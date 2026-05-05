import path from "node:path";

const SENSITIVE_NAMES = new Set([
  ".env",
  ".env.local",
  ".env.production",
  ".env.backup",
  "id_rsa",
  "id_ed25519",
]);

export function isSensitivePath(workspaceRelativePath: string): boolean {
  const p = workspaceRelativePath.replaceAll("\\", "/");
  const base = path.posix.basename(p);
  if (SENSITIVE_NAMES.has(base)) return true;
  if (base.endsWith(".key") || base.endsWith(".pem") || base.endsWith(".p12")) return true;
  if (p.startsWith(".git/")) return true;
  return false;
}

