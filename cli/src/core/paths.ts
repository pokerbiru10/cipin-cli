import path from "node:path";
import { CipinError } from "./errors.js";

export function resolveInsideWorkspace(workspaceRoot: string, candidatePath: string): string {
  const resolved = path.resolve(workspaceRoot, candidatePath);
  const relative = path.relative(workspaceRoot, resolved);

  if (relative === "") return resolved;
  if (relative.startsWith("..") || path.isAbsolute(relative)) {
    throw new CipinError(`Path escapes workspace: ${candidatePath}`);
  }
  return resolved;
}

export function toWorkspaceRelative(workspaceRoot: string, absolutePath: string): string {
  const relative = path.relative(workspaceRoot, absolutePath);
  return relative.replaceAll("\\", "/");
}

