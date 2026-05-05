import fs from "node:fs/promises";
import path from "node:path";
import { anyGlobMatch, normalizePath } from "./glob.js";
import { resolveInsideWorkspace, toWorkspaceRelative } from "./paths.js";
import { isSensitivePath } from "./sensitive.js";

export async function listFiles(
  workspaceRoot: string,
  opts: { glob?: string; limit: number; ignoreGlobs: string[] },
): Promise<string[]> {
  const results: string[] = [];
  const glob = opts.glob ? normalizePath(opts.glob) : undefined;

  async function walk(dirAbs: string): Promise<void> {
    if (results.length >= opts.limit) return;
    const entries = await fs.readdir(dirAbs, { withFileTypes: true });
    for (const entry of entries) {
      if (results.length >= opts.limit) return;
      const abs = path.join(dirAbs, entry.name);
      const rel = toWorkspaceRelative(workspaceRoot, abs);

      if (anyGlobMatch(rel, opts.ignoreGlobs)) continue;
      if (isSensitivePath(rel)) continue;

      if (entry.isDirectory()) {
        await walk(abs);
      } else if (entry.isFile()) {
        if (!glob || anyGlobMatch(rel, [glob])) results.push(rel);
      }
    }
  }

  const root = resolveInsideWorkspace(workspaceRoot, ".");
  await walk(root);
  return results;
}

export async function readFileText(
  workspaceRoot: string,
  filePath: string,
  opts: { maxChars: number; ignoreGlobs: string[] },
): Promise<{ path: string; content: string; truncated: boolean }> {
  const abs = resolveInsideWorkspace(workspaceRoot, filePath);
  const rel = toWorkspaceRelative(workspaceRoot, abs);
  if (anyGlobMatch(rel, opts.ignoreGlobs)) {
    return { path: rel, content: "[blocked by ignoreGlobs]", truncated: true };
  }
  if (isSensitivePath(rel)) {
    return { path: rel, content: "[blocked: sensitive file]", truncated: true };
  }

  const raw = await fs.readFile(abs, "utf8");
  if (raw.length <= opts.maxChars) return { path: rel, content: raw, truncated: false };
  return { path: rel, content: raw.slice(0, opts.maxChars) + "\n[...truncated...]\n", truncated: true };
}

