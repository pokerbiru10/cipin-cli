import { spawn } from "node:child_process";
import path from "node:path";
import { CipinError } from "./errors.js";
import { resolveInsideWorkspace } from "./paths.js";

export type RunResult = {
  exitCode: number;
  stdout: string;
  stderr: string;
  timedOut: boolean;
};

const DEFAULT_ALLOWLIST = new Set(["php", "composer", "npm", "npx", "git", "node"]);

export async function runCommand(
  workspaceRoot: string,
  argv: string[],
  opts: { cwd?: string; timeoutSec: number; maxOutputChars: number; allowlist?: string[] },
): Promise<RunResult> {
  if (!Array.isArray(argv) || argv.length === 0) throw new CipinError("run_command argv must be non-empty string[]");

  const allowlist = new Set((opts.allowlist ?? []).length ? opts.allowlist : [...DEFAULT_ALLOWLIST]);
  const exe = normalizeExe(argv[0]);
  if (!allowlist.has(exe)) throw new CipinError(`Command not allowed: ${argv[0]}`);

  const cwd = opts.cwd ? resolveInsideWorkspace(workspaceRoot, opts.cwd) : workspaceRoot;

  return new Promise((resolve, reject) => {
    const child = spawn(argv[0], argv.slice(1), {
      cwd,
      stdio: ["ignore", "pipe", "pipe"],
      shell: false,
      windowsHide: true,
    });

    let stdout = "";
    let stderr = "";
    let timedOut = false;

    const timeout = setTimeout(() => {
      timedOut = true;
      child.kill();
    }, Math.max(1, opts.timeoutSec) * 1000);

    child.stdout.on("data", (c: Buffer) => {
      stdout += c.toString("utf8");
      if (stdout.length > opts.maxOutputChars) stdout = stdout.slice(-opts.maxOutputChars);
    });
    child.stderr.on("data", (c: Buffer) => {
      stderr += c.toString("utf8");
      if (stderr.length > opts.maxOutputChars) stderr = stderr.slice(-opts.maxOutputChars);
    });

    child.on("error", (err) => {
      clearTimeout(timeout);
      reject(err);
    });
    child.on("close", (code) => {
      clearTimeout(timeout);
      resolve({
        exitCode: typeof code === "number" ? code : 1,
        stdout,
        stderr,
        timedOut,
      });
    });
  });
}

function normalizeExe(exe: string): string {
  const base = path.basename(exe).toLowerCase();
  return base.replace(/\.exe$|\.cmd$|\.bat$/i, "");
}

