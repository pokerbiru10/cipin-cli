import { ParsedArgs } from "../core/cli_args.js";
import { loadConfig } from "../core/config.js";
import { CipinError } from "../core/errors.js";
import { OpenAIClient } from "../core/openai.js";

export async function runPlan(args: ParsedArgs): Promise<void> {
  const goal = args.positionals.join(" ").trim();
  if (!goal) throw new CipinError("Missing goal. Usage: cipin plan <goal>");

  const config = await loadConfig(args.workspaceRoot);
  const model = args.model ?? config.model;
  if (!model || model === "REPLACE_ME") throw new CipinError("Model not configured. Set in .cipin/config.json or use --model");

  const client = new OpenAIClient();
  await client.streamText(
    {
      model,
      instructions:
        "You are Cipin. Write a concise step-by-step plan in Markdown. Do not apply changes. Do not include code unless requested.",
      input: [{ role: "user", content: goal }],
      stream: true,
    },
    (delta) => process.stdout.write(delta),
  );
  process.stdout.write("\n");
}

