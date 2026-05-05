import path from "node:path";
import { CipinError } from "./errors.js";
import { resolveInsideWorkspace, toWorkspaceRelative } from "./paths.js";
import { isSensitivePath } from "./sensitive.js";

export type DiffSummary = {
  files: Array<{ path: string; additions: number; deletions: number }>;
  totalAdditions: number;
  totalDeletions: number;
};

export function summarizeUnifiedDiff(workspaceRoot: string, patch: string): DiffSummary {
  const files = new Map<string, { additions: number; deletions: number }>();
  const touchedPaths = extractPaths(patch);
  for (const p of touchedPaths) {
    const abs = resolveInsideWorkspace(workspaceRoot, p);
    const rel = toWorkspaceRelative(workspaceRoot, abs);
    if (isSensitivePath(rel)) throw new CipinError(`Patch touches sensitive path: ${rel}`);
    if (!files.has(rel)) files.set(rel, { additions: 0, deletions: 0 });
  }

  let current: string | null = null;
  for (const line of patch.split("\n")) {
    if (line.startsWith("+++ ")) {
      const raw = line.slice(4).trim();
      const p = stripDiffPrefix(raw);
      if (p === "/dev/null") {
        current = null;
      } else {
        current = toWorkspaceRelative(workspaceRoot, resolveInsideWorkspace(workspaceRoot, p));
        if (!files.has(current)) files.set(current, { additions: 0, deletions: 0 });
      }
      continue;
    }

    if (!current) continue;
    if (line.startsWith("+") && !line.startsWith("+++")) files.get(current)!.additions += 1;
    if (line.startsWith("-") && !line.startsWith("---")) files.get(current)!.deletions += 1;
  }

  let totalAdditions = 0;
  let totalDeletions = 0;
  const list = [...files.entries()].map(([p, v]) => {
    totalAdditions += v.additions;
    totalDeletions += v.deletions;
    return { path: p, additions: v.additions, deletions: v.deletions };
  });

  return { files: list, totalAdditions, totalDeletions };
}

export function extractPaths(patch: string): string[] {
  const paths = new Set<string>();
  for (const line of patch.split("\n")) {
    if (line.startsWith("diff --git ")) {
      const parts = line.split(" ");
      if (parts.length >= 4) {
        const a = stripDiffPrefix(parts[2]);
        const b = stripDiffPrefix(parts[3]);
        if (a !== "/dev/null") paths.add(a);
        if (b !== "/dev/null") paths.add(b);
      }
      continue;
    }

    if (line.startsWith("--- ") || line.startsWith("+++ ")) {
      const p = stripDiffPrefix(line.slice(4).trim());
      if (p !== "/dev/null") paths.add(p);
    }
  }

  const out = [...paths].map((p) => p.replaceAll("\\", "/"));
  for (const p of out) {
    if (path.posix.isAbsolute(p)) throw new CipinError(`Absolute paths not allowed in patch: ${p}`);
    if (p.includes("..")) throw new CipinError(`Parent traversal not allowed in patch path: ${p}`);
  }
  return out;
}

function stripDiffPrefix(p: string): string {
  return p.replace(/^a\//, "").replace(/^b\//, "");
}

