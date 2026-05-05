import { ParsedArgs } from "../core/cli_args.js";
import { loadConfig } from "../core/config.js";
import { CipinError } from "../core/errors.js";
import { OpenAIClient } from "../core/openai.js";

export async function runChat(args: ParsedArgs): Promise<void> {
  const prompt = await readPrompt(args.positionals);
  if (!prompt) throw new CipinError("Missing prompt. Usage: cipin chat \"...\"");

  const config = await loadConfig(args.workspaceRoot);
  const model = args.model ?? config.model;
  if (!model || model === "REPLACE_ME") throw new CipinError("Model not configured. Set in .cipin/config.json or use --model");

  const client = new OpenAIClient();
  await client.streamText(
    {
      model,
      input: [{ role: "user", content: prompt }],
      stream: true,
    },
    (delta) => process.stdout.write(delta),
  );
  process.stdout.write("\n");
}

async function readPrompt(positionals: string[]): Promise<string> {
  if (positionals.length > 0) return positionals.join(" ");
  if (process.stdin.isTTY) return "";
  const chunks: Buffer[] = [];
  for await (const c of process.stdin) chunks.push(Buffer.from(c));
  return Buffer.concat(chunks).toString("utf8").trim();
}

