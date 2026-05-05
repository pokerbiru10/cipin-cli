import fs from "node:fs/promises";
import path from "node:path";
import { CipinError } from "./errors.js";
import { resolveInsideWorkspace } from "./paths.js";

type FilePatch = {
  oldPath: string | null;
  newPath: string | null;
  hunks: Hunk[];
};

type Hunk = {
  oldStart: number;
  oldCount: number;
  newStart: number;
  newCount: number;
  lines: string[];
};

export async function applyUnifiedDiff(workspaceRoot: string, patch: string): Promise<void> {
  const filePatches = parseUnifiedDiff(patch);
  for (const fp of filePatches) {
    await applyFilePatch(workspaceRoot, fp);
  }
}

function parseUnifiedDiff(patch: string): FilePatch[] {
  const lines = patch.replace(/\r\n/g, "\n").split("\n");
  const out: FilePatch[] = [];

  let idx = 0;
  while (idx < lines.length) {
    const line = lines[idx] ?? "";

    if (line.startsWith("diff --git ")) {
      idx++;
      continue;
    }

    if (!line.startsWith("--- ")) {
      idx++;
      continue;
    }

    const oldRaw = (lines[idx] ?? "").slice(4).trim();
    idx++;
    const newLine = lines[idx] ?? "";
    if (!newLine.startsWith("+++ ")) throw new CipinError("Invalid patch: missing +++ line");
    const newRaw = newLine.slice(4).trim();
    idx++;

    const oldPath = stripPrefix(oldRaw);
    const newPath = stripPrefix(newRaw);

    const filePatch: FilePatch = {
      oldPath: oldPath === "/dev/null" ? null : oldPath,
      newPath: newPath === "/dev/null" ? null : newPath,
      hunks: [],
    };

    while (idx < lines.length) {
      const l = lines[idx] ?? "";
      if (l.startsWith("diff --git ") || l.startsWith("--- ")) break;
      if (l.startsWith("@@")) {
        const { hunk, nextIdx } = parseHunk(lines, idx);
        filePatch.hunks.push(hunk);
        idx = nextIdx;
        continue;
      }
      idx++;
    }

    out.push(filePatch);
  }

  return out;
}

function parseHunk(lines: string[], startIdx: number): { hunk: Hunk; nextIdx: number } {
  const header = lines[startIdx] ?? "";
  const m = header.match(/^@@\s+-(\d+)(?:,(\d+))?\s+\+(\d+)(?:,(\d+))?\s+@@/);
  if (!m) throw new CipinError(`Invalid hunk header: ${header}`);
  const oldStart = Number(m[1]);
  const oldCount = m[2] ? Number(m[2]) : 1;
  const newStart = Number(m[3]);
  const newCount = m[4] ? Number(m[4]) : 1;

  const hunkLines: string[] = [];
  let idx = startIdx + 1;
  while (idx < lines.length) {
    const l = lines[idx] ?? "";
    if (l.startsWith("diff --git ") || l.startsWith("--- ") || l.startsWith("@@")) break;
    if (l.startsWith("\\ No newline at end of file")) {
      idx++;
      continue;
    }
    hunkLines.push(l);
    idx++;
  }

  return {
    hunk: { oldStart, oldCount, newStart, newCount, lines: hunkLines },
    nextIdx: idx,
  };
}

async function applyFilePatch(workspaceRoot: string, fp: FilePatch): Promise<void> {
  const targetPath = fp.newPath ?? fp.oldPath;
  if (!targetPath) throw new CipinError("Invalid patch: missing target path");

  const absTarget = resolveInsideWorkspace(workspaceRoot, targetPath);
  const absOld = fp.oldPath ? resolveInsideWorkspace(workspaceRoot, fp.oldPath) : null;

  const existing = fp.oldPath ? await readIfExists(absOld!) : null;
  const newline = detectNewline(existing?.raw ?? "");
  const originalLines = existing ? splitLines(existing.raw) : [];

  const patchedLines = applyHunks(originalLines, fp.hunks);
  const output = patchedLines.join(newline) + newline;

  if (fp.newPath === null) {
    // deletion
    await fs.rm(absOld!, { force: true });
    return;
  }

  await fs.mkdir(path.dirname(absTarget), { recursive: true });
  await fs.writeFile(absTarget, output, "utf8");
}

function applyHunks(original: string[], hunks: Hunk[]): string[] {
  let cursor = 0;
  const out: string[] = [];

  for (const h of hunks) {
    const targetIndex = Math.max(0, h.oldStart - 1);
    while (cursor < targetIndex && cursor < original.length) {
      out.push(original[cursor]!);
      cursor++;
    }

    for (const l of h.lines) {
      const tag = l[0] ?? "";
      const text = l.slice(1);

      if (tag === " ") {
        const cur = original[cursor];
        if (cur !== text) throw new CipinError("Patch context mismatch");
        out.push(cur);
        cursor++;
      } else if (tag === "-") {
        const cur = original[cursor];
        if (cur !== text) throw new CipinError("Patch deletion mismatch");
        cursor++;
      } else if (tag === "+") {
        out.push(text);
      } else {
        throw new CipinError(`Invalid patch line: ${l}`);
      }
    }
  }

  while (cursor < original.length) {
    out.push(original[cursor]!);
    cursor++;
  }

  return out;
}

async function readIfExists(abs: string): Promise<{ raw: string } | null> {
  try {
    const raw = await fs.readFile(abs, "utf8");
    return { raw };
  } catch {
    return null;
  }
}

function stripPrefix(p: string): string {
  return p.replace(/^a\//, "").replace(/^b\//, "");
}

function splitLines(raw: string): string[] {
  const normalized = raw.replace(/\r\n/g, "\n");
  const parts = normalized.split("\n");
  if (parts.length > 0 && parts[parts.length - 1] === "") parts.pop();
  return parts;
}

function detectNewline(raw: string): "\r\n" | "\n" {
  return raw.includes("\r\n") ? "\r\n" : "\n";
}

