import { ParsedArgs } from "../core/cli_args.js";
import { loadConfig } from "../core/config.js";
import { CipinError } from "../core/errors.js";
import { FunctionTool, OpenAIClient } from "../core/openai.js";
import { createToolRouter } from "../core/tools.js";

export async function runAgent(args: ParsedArgs): Promise<void> {
  const goal = args.positionals.join(" ").trim();
  if (!goal) throw new CipinError("Missing goal. Usage: cipin agent <goal>");

  const config = await loadConfig(args.workspaceRoot);
  const model = args.model ?? config.model;
  if (!model || model === "REPLACE_ME") throw new CipinError("Model not configured. Set in .cipin/config.json or use --model");

  const toolRouter = createToolRouter({
    workspaceRoot: config.workspaceRoot,
    ignoreGlobs: config.ignoreGlobs,
    yes: args.yes,
    autoRun: args.autoRun,
    dryRun: args.dryRun,
    confirmEdits: config.safety.confirmEdits,
    confirmCommands: config.safety.confirmCommands,
    limits: {
      readFileMaxChars: config.agent.readFileMaxChars,
      maxToolOutputChars: config.agent.maxToolOutputChars,
      defaultSearchLimit: config.agent.defaultSearchLimit,
      defaultListFilesLimit: config.agent.defaultListFilesLimit,
      commandTimeoutSec: config.agent.commandTimeoutSec,
    },
  });

  const tools = buildTools();

  const client = new OpenAIClient();
  const input: any[] = [{ role: "user", content: goal }];

  const instructions = `
You are Cipin, a careful terminal coding agent.
You can call tools to inspect and modify the workspace.
Rules:
- Prefer reading/searching before editing.
- Use propose_patch before apply_patch.
- Never request secrets. Do not read .env or private keys.
- Only run safe commands when needed; prefer tests/lints.
- When done, respond with a short summary of what you changed or found.
`.trim();

  for (let step = 1; step <= config.agent.maxSteps; step++) {
    const response = await client.createResponse({
      model,
      instructions,
      tools,
      input,
      stream: false,
    });

    input.push(...response.output);

    const calls = response.output.filter((o) => o.type === "function_call") as any[];
    if (calls.length === 0) {
      if (response.output_text) process.stdout.write(response.output_text.trim() + "\n");
      else process.stdout.write("(no output_text)\n");
      return;
    }

    for (const call of calls) {
      const name = call.name as string;
      const handler = toolRouter[name];
      if (!handler) {
        input.push({
          type: "function_call_output",
          call_id: call.call_id,
          output: JSON.stringify({ ok: false, error: `unknown_tool:${name}` }),
        });
        continue;
      }

      let argsObj: any = {};
      try {
        argsObj = JSON.parse(call.arguments ?? "{}");
      } catch {
        argsObj = {};
      }

      try {
        const result = await handler(argsObj);
        input.push({
          type: "function_call_output",
          call_id: call.call_id,
          output: JSON.stringify(result),
        });
      } catch (err) {
        const message = err instanceof Error ? err.message : String(err);
        input.push({
          type: "function_call_output",
          call_id: call.call_id,
          output: JSON.stringify({ ok: false, error: message }),
        });
      }
    }
  }

  throw new CipinError(`Agent stopped after maxSteps=${config.agent.maxSteps}`);
}

function buildTools(): FunctionTool[] {
  return [
    {
      type: "function",
      name: "list_files",
      description: "List files under the workspace root. Returns relative paths.",
      strict: true,
      parameters: {
        type: "object",
        additionalProperties: false,
        properties: {
          glob: { type: "string", description: "Optional glob filter like src/**/*.ts" },
          limit: { type: "number", description: "Max number of files" },
        },
      },
    },
    {
      type: "function",
      name: "read_file",
      description: "Read a UTF-8 text file from the workspace. Sensitive files are blocked.",
      strict: true,
      parameters: {
        type: "object",
        additionalProperties: false,
        properties: {
          path: { type: "string" },
          maxChars: { type: "number" },
        },
        required: ["path"],
      },
    },
    {
      type: "function",
      name: "search",
      description: "Search for text in the workspace (ripgrep-like). Returns hits with path/line/text.",
      strict: true,
      parameters: {
        type: "object",
        additionalProperties: false,
        properties: {
          query: { type: "string" },
          glob: { type: "string" },
          limit: { type: "number" },
        },
        required: ["query"],
      },
    },
    {
      type: "function",
      name: "propose_patch",
      description: "Validate and summarize a unified diff patch. Does not apply it.",
      strict: true,
      parameters: {
        type: "object",
        additionalProperties: false,
        properties: {
          patch: { type: "string" },
        },
        required: ["patch"],
      },
    },
    {
      type: "function",
      name: "apply_patch",
      description: "Apply a unified diff patch to the workspace using git apply. May prompt for confirmation.",
      strict: true,
      parameters: {
        type: "object",
        additionalProperties: false,
        properties: {
          patch: { type: "string" },
        },
        required: ["patch"],
      },
    },
    {
      type: "function",
      name: "run_command",
      description: "Run an allowed command in the workspace. argv must be an array of strings.",
      strict: true,
      parameters: {
        type: "object",
        additionalProperties: false,
        properties: {
          argv: { type: "array", items: { type: "string" } },
          cwd: { type: "string" },
          timeoutSec: { type: "number" },
        },
        required: ["argv"],
      },
    },
  ];
}

