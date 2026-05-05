import path from "node:path";
import { ParsedArgs } from "../core/cli_args.js";
import { defaultConfig, writeConfig } from "../core/config.js";

export async function runInit(args: ParsedArgs): Promise<void> {
  const workspaceRoot = args.workspaceRoot;
  const model = args.model ?? args.positionals[0] ?? "REPLACE_ME";
  const config = defaultConfig(workspaceRoot, model);
  const configPath = await writeConfig(workspaceRoot, config);
  // eslint-disable-next-line no-console
  console.log(`Wrote ${path.relative(process.cwd(), configPath)}`);
}
