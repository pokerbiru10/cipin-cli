import path from "node:path";
import readline from "node:readline/promises";
import { runAgent } from "./agent.js";
import { runChat } from "./chat.js";
import { runInit } from "./init.js";
import { runPlan } from "./plan.js";
import { ParsedArgs } from "../core/cli_args.js";
import { loadConfig } from "../core/config.js";

const PRIMARY = { r: 236, g: 11, b: 98 };

export async function runCode(args: ParsedArgs): Promise<void> {
  renderHeroLikeUi();

  try {
    await loadConfig(args.workspaceRoot);
  } catch {
    const rel = path.join(args.workspaceRoot, ".cipin", "config.json");
    process.stdout.write("\n");
    process.stdout.write(dim("Config not found.\n"));
    process.stdout.write(dim(`Run: cipin init --model gpt-5 --workspace "${args.workspaceRoot}"\n`));
    process.stdout.write(dim(`Expected: ${rel}\n`));
    process.stdout.write("\n");
  }

  process.stdout.write(dim("Type: help  |  / for shortcuts  |  Tab to complete  |  Ctrl+C to exit\n\n"));

  const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout,
    // Keep it simple: offer completion for slash shortcuts + common repl commands.
    completer: (line: string): [string[], string] => {
      const candidates = [
        "/usage",
        "/plan",
        "/reasoning",
        "/models",
        "/access",
        "chat",
        "plan",
        "agent",
        "init",
        "help",
        "exit",
        "quit",
      ];

      const trimmed = line.trimStart();
      const last = trimmed.split(/\s+/).pop() ?? "";
      const prefix = last;

      if (!prefix) return [[], line];
      const matches = candidates.filter((c) => c.startsWith(prefix));
      return [matches, line];
    },
  });

  let closed = false;
  rl.on("SIGINT", () => {
    closed = true;
    rl.close();
  });

  while (!closed) {
    let line: string;
    try {
      line = await rl.question(pink("CIPIN") + " " + bold("CLI") + dim("> ") + reset());
    } catch {
      return;
    }

    const trimmed = line.trim();
    if (!trimmed) continue;

    // Slash shortcuts (Codex-like). Type "/" to see a list.
    if (trimmed === "/") {
      printSlashMenu();
      continue;
    }

    const tokens = tokenize(trimmed);
    const cmdRaw = (tokens.shift() ?? "").toLowerCase();

    if (cmdRaw === "exit" || cmdRaw === "quit") return;
    if (cmdRaw === "help" || cmdRaw === "?") {
      printReplHelp();
      continue;
    }

    if (cmdRaw.startsWith("/")) {
      const slash = cmdRaw;
      if (slash === "/usage") {
        printReplHelp();
        printSlashMenu();
        continue;
      }
      if (slash === "/plan") {
        if (tokens.length === 0) {
          process.stdout.write(dim('Usage: /plan "<goal>"\n'));
          continue;
        }
        const childArgs = parseInlineArgs(args, tokens);
        await runPlan({ ...childArgs, command: "plan" });
        continue;
      }
      if (slash === "/models") {
        printModelsHelp(args);
        continue;
      }
      if (slash === "/access") {
        printAccessHelp(args);
        continue;
      }
      if (slash === "/reasoning") {
        printReasoningHelp();
        continue;
      }

      process.stdout.write(dim(`Unknown shortcut: ${slash}. Type: / then Enter\n`));
      continue;
    }

    const childArgs = parseInlineArgs(args, tokens);

    try {
      if (cmdRaw === "chat") {
        await runChat({ ...childArgs, command: "chat" });
      } else if (cmdRaw === "plan") {
        await runPlan({ ...childArgs, command: "plan" });
      } else if (cmdRaw === "agent") {
        await runAgent({ ...childArgs, command: "agent" });
      } else if (cmdRaw === "init") {
        await runInit({ ...childArgs, command: "init" });
      } else {
        process.stdout.write(dim(`Unknown: ${cmdRaw}. Type: help\n`));
      }
    } catch (err) {
      const message = err instanceof Error ? err.message : String(err);
      process.stdout.write(red(`Error: ${message}\n`));
    }
  }
}

function renderHeroLikeUi(): void {
  const cols = typeof process.stdout.columns === "number" ? process.stdout.columns : 100;
  const width = clamp(cols - 4, 64, 100);

  const top = "┌" + "─".repeat(width - 2) + "┐";
  const mid = "├" + "─".repeat(width - 2) + "┤";
  const bot = "└" + "─".repeat(width - 2) + "┘";

  const header = padLine(`${pink("●")} ${dim("●")} ${dim("●")}  ${dim("CIPIN CLI Terminal")}`, width);

  const ascii = [
    // Big logo (was accidentally "CIPIH" before; this spells "CIPIN CLI").
    " ██████╗██╗██████╗ ██╗███╗   ██╗     ██████╗██╗     ██╗",
    "██╔════╝██║██╔══██╗██║████╗  ██║    ██╔════╝██║     ██║",
    "██║     ██║██████╔╝██║██╔██╗ ██║    ██║     ██║     ██║",
    "██║     ██║██╔═══╝ ██║██║╚██╗██║    ██║     ██║     ██║",
    "╚██████╗██║██║     ██║██║ ╚████║    ╚██████╗███████╗██║",
    " ╚═════╝╚═╝╚═╝     ╚═╝╚═╝  ╚═══╝     ╚═════╝╚══════╝╚═╝",
  ].map((l) => pink(l));

  const dailyPct = 34;
  const weeklyPct = 62;
  const metrics = [
    `${bold("Daily usage")}  ${renderPercentBar(dailyPct)} ${dim(`${dailyPct}%`)}`,
    `${bold("Weekly usage")} ${renderPercentBar(weeklyPct)} ${dim(`${weeklyPct}%`)}`,
  ];

  process.stdout.write("\n");
  process.stdout.write(top + "\n");
  process.stdout.write("│" + header + "│\n");
  process.stdout.write(mid + "\n");

  for (const line of ascii) {
    process.stdout.write("│" + padLine(line, width) + "│\n");
  }
  process.stdout.write("│" + padLine(dim(""), width) + "│\n");
  process.stdout.write("│" + padLine(`${bold("CIPIN CLI")} ${dim("v0.1.0")} ${dim("— terminal AI workflows")}`, width) + "│\n");
  process.stdout.write("│" + padLine(dim(""), width) + "│\n");
  process.stdout.write("│" + padLine(dim("Usage"), width) + "│\n");
  for (const m of metrics) {
    process.stdout.write("│" + padLine("  " + m, width) + "│\n");
  }
  process.stdout.write("│" + padLine(dim(""), width) + "│\n");
  process.stdout.write(bot + "\n");
  process.stdout.write("\n");
}

function renderPercentBar(pct: number, blocks = 14): string {
  const clamped = clamp(pct, 0, 100);
  const filled = Math.round((clamped / 100) * blocks);
  const full = "█".repeat(Math.max(0, Math.min(blocks, filled)));
  const empty = "░".repeat(Math.max(0, blocks - full.length));
  return "[" + pink(full) + dim(empty) + "]";
}

function printReplHelp(): void {
  const text = `
Commands:
  chat <prompt>         Streaming chat
  plan <goal>           Generate a plan (no edits)
  agent <goal>          Agent loop with tools
  init [--model <m>]    Create .cipin/config.json
  help                  Show this help
  exit                  Quit

Shortcuts (type "/" then Enter):
  /usage                Show help + shortcuts
  /plan <goal>          Generate a plan (same as "plan")
  /reasoning            Reasoning settings info
  /models               Model selection info
  /access               API key / base url info

Flags (optional, same as CLI):
  --model <name>    Override model
  --workspace <dir> Workspace root
  --yes             Auto-accept patches
  --auto-run        Auto-run allowed commands
  --dry-run         Do not apply patches or run commands
`.trim();
  process.stdout.write(text + "\n\n");
}

function printSlashMenu(): void {
  const text = `
Shortcuts:
  /usage
  /plan <goal>
  /reasoning
  /models
  /access
`.trim();
  process.stdout.write(text + "\n\n");
}

function printModelsHelp(args: ParsedArgs): void {
  process.stdout.write("\n");
  process.stdout.write(bold("Models") + "\n");
  process.stdout.write(dim(`Workspace: ${args.workspaceRoot}\n`));
  process.stdout.write(dim("Configure default model via: cipin init --model <name>\n"));
  process.stdout.write(dim("Or override per command: chat --model <name>\n"));
  process.stdout.write(dim("Example: chat --model gpt-5 \"Hello\"\n\n"));
}

function printAccessHelp(args: ParsedArgs): void {
  const hasKey = Boolean(process.env.OPENAI_API_KEY);
  const baseUrl = process.env.OPENAI_BASE_URL || "https://api.openai.com/v1";
  process.stdout.write("\n");
  process.stdout.write(bold("Access") + "\n");
  process.stdout.write(dim(`Workspace: ${args.workspaceRoot}\n`));
  process.stdout.write(dim(`OPENAI_API_KEY: ${hasKey ? "set" : "missing"}\n`));
  process.stdout.write(dim(`OPENAI_BASE_URL: ${baseUrl}\n\n`));
}

function printReasoningHelp(): void {
  process.stdout.write("\n");
  process.stdout.write(bold("Reasoning") + "\n");
  process.stdout.write(dim("This CLI currently follows the model defaults.\n"));
  process.stdout.write(dim("Tip: pick a model that fits your use case via --model or cipin init.\n\n"));
}

function parseInlineArgs(base: ParsedArgs, tokens: string[]): ParsedArgs {
  const positionals: string[] = [];
  let model = base.model;
  let workspaceRoot = base.workspaceRoot;
  let yes = base.yes;
  let autoRun = base.autoRun;
  let dryRun = base.dryRun;
  let help = false;

  const args = [...tokens];
  while (args.length > 0) {
    const t = args.shift();
    if (!t) break;

    if (t === "-h" || t === "--help") {
      help = true;
      continue;
    }
    if (t === "--model") {
      const next = args.shift();
      if (next) model = next;
      continue;
    }
    if (t.startsWith("--model=")) {
      model = t.slice("--model=".length);
      continue;
    }
    if (t === "--workspace") {
      const next = args.shift();
      if (next) workspaceRoot = next;
      continue;
    }
    if (t.startsWith("--workspace=")) {
      workspaceRoot = t.slice("--workspace=".length);
      continue;
    }
    if (t === "--yes") {
      yes = true;
      continue;
    }
    if (t === "--auto-run") {
      autoRun = true;
      continue;
    }
    if (t === "--dry-run") {
      dryRun = true;
      continue;
    }
    positionals.push(t);
  }

  return {
    command: null,
    positionals,
    model,
    workspaceRoot: path.resolve(workspaceRoot),
    yes,
    autoRun,
    dryRun,
    help,
  };
}

function tokenize(input: string): string[] {
  const out: string[] = [];
  let cur = "";
  let quote: "'" | '"' | null = null;

  for (let i = 0; i < input.length; i++) {
    const ch = input[i]!;

    if (quote) {
      if (ch === quote) {
        quote = null;
      } else if (ch === "\\" && quote === '"' && i + 1 < input.length) {
        cur += input[i + 1]!;
        i++;
      } else {
        cur += ch;
      }
      continue;
    }

    if (ch === "'" || ch === '"') {
      quote = ch;
      continue;
    }

    if (/\s/.test(ch)) {
      if (cur) {
        out.push(cur);
        cur = "";
      }
      continue;
    }

    cur += ch;
  }

  if (cur) out.push(cur);
  return out;
}

function padLine(s: string, width: number): string {
  const printable = stripAnsi(s);
  const innerWidth = width - 2;
  const rightPad = Math.max(0, innerWidth - 1 - printable.length);
  return " " + s + " ".repeat(rightPad);
}

function stripAnsi(s: string): string {
  // eslint-disable-next-line no-control-regex
  return s.replace(/\u001b\[[0-9;]*m/g, "");
}

function clamp(n: number, min: number, max: number): number {
  return Math.max(min, Math.min(max, n));
}

function rgb(r: number, g: number, b: number): string {
  return `\u001b[38;2;${r};${g};${b}m`;
}

function reset(): string {
  return "\u001b[0m";
}

function dim(s: string): string {
  return `\u001b[90m${s}${reset()}`;
}

function bold(s: string): string {
  return `\u001b[1m${s}${reset()}`;
}

function pink(s: string): string {
  return `${rgb(PRIMARY.r, PRIMARY.g, PRIMARY.b)}${s}${reset()}`;
}

function red(s: string): string {
  return `\u001b[31m${s}${reset()}`;
}
