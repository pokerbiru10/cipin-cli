import path from "node:path";

export type CipinCommand = "init" | "chat" | "plan" | "agent" | "code" | "cli";

export type ParsedArgs = {
  command: CipinCommand | null;
  positionals: string[];
  model?: string;
  workspaceRoot: string;
  yes: boolean;
  autoRun: boolean;
  dryRun: boolean;
  help: boolean;
};

export function parseCliArgs(argv: string[]): ParsedArgs {
  const positionals: string[] = [];

  let command: CipinCommand | null = null;
  let model: string | undefined;
  let workspaceRoot = process.cwd();
  let yes = false;
  let autoRun = false;
  let dryRun = false;
  let help = false;

  const args = [...argv];
  while (args.length > 0) {
    const token = args.shift();
    if (!token) break;

    if (!command && !token.startsWith("-")) {
      command = token as CipinCommand;
      continue;
    }

    if (token === "-h" || token === "--help") {
      help = true;
      continue;
    }

    if (token === "--model") {
      model = args.shift();
      continue;
    }

    if (token.startsWith("--model=")) {
      model = token.slice("--model=".length);
      continue;
    }

    if (token === "--workspace") {
      const next = args.shift();
      if (next) workspaceRoot = next;
      continue;
    }

    if (token.startsWith("--workspace=")) {
      workspaceRoot = token.slice("--workspace=".length);
      continue;
    }

    if (token === "--yes") {
      yes = true;
      continue;
    }

    if (token === "--auto-run") {
      autoRun = true;
      continue;
    }

    if (token === "--dry-run") {
      dryRun = true;
      continue;
    }

    positionals.push(token);
  }

  return {
    command,
    positionals,
    model,
    workspaceRoot: path.resolve(workspaceRoot),
    yes,
    autoRun,
    dryRun,
    help,
  };
}
