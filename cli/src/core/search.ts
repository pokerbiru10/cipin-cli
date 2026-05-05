import { spawn } from "node:child_process";
import path from "node:path";
import { anyGlobMatch, normalizePath } from "./glob.js";
import { toWorkspaceRelative } from "./paths.js";
import { isSensitivePath } from "./sensitive.js";

export type SearchHit = {
  path: string;
  line: number;
  text: string;
};

export async function searchText(
  workspaceRoot: string,
  query: string,
  opts: { glob?: string; limit: number; ignoreGlobs: string[] },
): Promise<SearchHit[]> {
  const glob = opts.glob ? normalizePath(opts.glob) : undefined;

  const rgArgs = ["-n", "--no-heading", "--color", "never", ...toRipgrepIgnores(opts.ignoreGlobs)];
  if (glob) {
    rgArgs.push("--glob", glob);
  }
  rgArgs.push(query, ".");
  const hits = await tryRipgrep(workspaceRoot, rgArgs, opts.limit);
  if (hits) {
    const filtered = hits
      .map((h) => ({
        ...h,
        path: normalizePath(h.path),
      }))
      .filter((h) => !anyGlobMatch(h.path, opts.ignoreGlobs))
      .filter((h) => !isSensitivePath(h.path))
      .filter((h) => (!glob ? true : anyGlobMatch(h.path, [glob])));

    return filtered.slice(0, opts.limit);
  }

  // Fallback: no rg available
  return [];
}

function toRipgrepIgnores(ignoreGlobs: string[]): string[] {
  const args: string[] = [];
  for (const g of ignoreGlobs) {
    const p = normalizePath(g);
    if (!p) continue;
    // ripgrep glob uses !pattern to exclude
    if (p.endsWith("/**")) {
      args.push("--glob", "!" + p);
      continue;
    }
    if (!p.includes("*") && !p.includes("?") && !p.includes("[")) {
      // treat as directory/file
      args.push("--glob", "!" + p);
      args.push("--glob", "!" + p + "/**");
      continue;
    }
    args.push("--glob", "!" + p);
  }
  return args;
}

async function tryRipgrep(
  cwd: string,
  args: string[],
  limit: number,
): Promise<SearchHit[] | null> {
  return new Promise((resolve) => {
    const child = spawn("rg", args, { cwd, stdio: ["ignore", "pipe", "ignore"] });
    const lines: string[] = [];
    let buffer = "";

    child.on("error", () => resolve(null));
    child.stdout.on("data", (chunk: Buffer) => {
      buffer += chunk.toString("utf8");
      let idx: number;
      while ((idx = buffer.indexOf("\n")) >= 0) {
        const line = buffer.slice(0, idx);
        buffer = buffer.slice(idx + 1);
        if (line.trim() === "") continue;
        lines.push(line);
        if (lines.length >= limit * 3) {
          child.kill();
          break;
        }
      }
    });
    child.on("close", () => {
      const hits: SearchHit[] = [];
      for (const line of lines) {
        // format: path:line:match
        const first = line.indexOf(":");
        const second = first >= 0 ? line.indexOf(":", first + 1) : -1;
        if (first < 0 || second < 0) continue;
        const file = line.slice(0, first);
        const lineNum = Number(line.slice(first + 1, second));
        const text = line.slice(second + 1);
        const rel = toWorkspaceRelative(cwd, path.resolve(cwd, file));
        hits.push({ path: rel, line: Number.isFinite(lineNum) ? lineNum : 0, text });
        if (hits.length >= limit) break;
      }
      resolve(hits);
    });
  });
}
