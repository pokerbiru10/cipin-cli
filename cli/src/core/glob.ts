// Minimal glob matcher: supports **, *, ?
// Paths are matched using forward slashes.

export function globToRegExp(glob: string): RegExp {
  const g = normalizeGlob(glob);
  const escaped = g
    .split("")
    .map((ch) => {
      if ("\\^$+.|(){}[]".includes(ch)) return "\\" + ch;
      return ch;
    })
    .join("");

  const regex = escaped
    .replaceAll("\\*\\*\\/", "(?:.*\\/)?")
    .replaceAll("\\*\\*", ".*")
    .replaceAll("\\*", "[^/]*")
    .replaceAll("\\?", "[^/]");

  return new RegExp("^" + regex + "$");
}

export function anyGlobMatch(pathLike: string, globs: string[]): boolean {
  const p = normalizePath(pathLike);
  for (const glob of globs) {
    const re = globToRegExp(glob);
    if (re.test(p)) return true;
  }
  return false;
}

export function normalizePath(p: string): string {
  return p.replaceAll("\\", "/").replaceAll(/\/+/g, "/").replaceAll(/^\.\//, "");
}

function normalizeGlob(glob: string): string {
  return normalizePath(glob.trim());
}

