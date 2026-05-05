import { runAgent } from "./commands/agent.js";
import { runChat } from "./commands/chat.js";
import { runCode } from "./commands/code.js";
import { runInit } from "./commands/init.js";
import { runPlan } from "./commands/plan.js";
import { parseCliArgs } from "./core/cli_args.js";
import { CipinError } from "./core/errors.js";

export async function main(argv: string[]): Promise<void> {
  const parsed = parseCliArgs(argv);

  if (parsed.help) {
    printHelp();
    return;
  }

  if (!parsed.command) {
    throw new CipinError("Missing command. Run: cipin --help");
  }

  switch (parsed.command) {
    case "init":
      await runInit(parsed);
      return;
    case "chat":
      await runChat(parsed);
      return;
    case "plan":
      await runPlan(parsed);
      return;
    case "agent":
      await runAgent(parsed);
      return;
    case "code":
      await runCode(parsed);
      return;
    case "cli":
      // Alias for `code` (people expect `cipin cli` to open the interactive prompt).
      await runCode(parsed);
      return;
    default:
      throw new CipinError(`Unknown command: ${parsed.command}. Run: cipin --help`);
  }
}

function printHelp(): void {
  const help = `
cipin - Terminal AI agent

Usage:
  cipin <command> [args] [--flags]

Commands:
  init              Create .cipin/config.json
  chat [prompt]     Chat with AI (streams output)
  plan <goal>       Output a plan (no edits)
  agent <goal>      Agent loop: read/search/propose/apply/run
  code              Terminal UI + interactive mode
  cli               Alias for \`code\`

Global flags:
  --model <name>    Override model
  --workspace <dir> Override workspace root (default: cwd)
  --yes             Auto-accept patches
  --auto-run        Auto-run allowed commands
  --dry-run         Do not apply patches or run commands
  -h, --help        Show help

Env:
  OPENAI_API_KEY    Required for OpenAI API calls
  OPENAI_BASE_URL   Optional (default: https://api.openai.com/v1)
`.trim();

  // eslint-disable-next-line no-console
  console.log(help);
}
