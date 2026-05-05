import { spawn } from "node:child_process";
import { CipinError } from "./errors.js";

export async function gitApply(workspaceRoot: string, patch: string): Promise<void> {
  await new Promise<void>((resolve, reject) => {
    const child = spawn("git", ["apply", "--whitespace=nowarn", "-"], {
      cwd: workspaceRoot,
      stdio: ["pipe", "ignore", "pipe"],
    });

    let stderr = "";
    child.stderr.on("data", (c: Buffer) => (stderr += c.toString("utf8")));

    child.on("error", (err: any) => {
      if (err?.code === "ENOENT") {
        reject(new CipinError("git not found. Install git to enable apply_patch."));
        return;
      }
      reject(err);
    });
    child.on("close", (code) => {
      if (code === 0) return resolve();
      reject(new CipinError(`git apply failed (${code}): ${stderr.trim()}`));
    });

    child.stdin.write(patch, "utf8");
    child.stdin.end();
  });
}
