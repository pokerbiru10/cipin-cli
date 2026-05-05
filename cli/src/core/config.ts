import fs from "node:fs/promises";
import path from "node:path";
import { CipinError } from "./errors.js";
import { CipinConfig, validateConfig } from "./schema.js";

export const CONFIG_DIR = ".cipin";
export const CONFIG_FILE = "config.json";

export type ResolvedConfig = CipinConfig & {
  configPath: string;
};

export function defaultConfig(workspaceRoot: string, modelPlaceholder = "REPLACE_ME"): CipinConfig {
  return {
    model: modelPlaceholder,
    workspaceRoot,
    ignoreGlobs: [
      ".git",
      ".git/**",
      ".cipin",
      ".cipin/**",
      "node_modules",
      "node_modules/**",
      "vendor",
      "vendor/**",
      "storage",
      "storage/**",
      "bootstrap/cache",
      "bootstrap/cache/**",
      "public/build",
      "public/build/**",
      "public/storage",
      "public/storage/**",
    ],
    safety: {
      confirmEdits: true,
      confirmCommands: true,
    },
    agent: {
      maxSteps: 20,
      maxToolOutputChars: 24_000,
      readFileMaxChars: 24_000,
      defaultSearchLimit: 50,
      defaultListFilesLimit: 200,
      commandTimeoutSec: 300,
    },
  };
}

export async function loadConfig(workspaceRoot: string): Promise<ResolvedConfig> {
  const configPath = path.join(workspaceRoot, CONFIG_DIR, CONFIG_FILE);
  let raw: string;
  try {
    raw = await fs.readFile(configPath, "utf8");
  } catch {
    throw new CipinError(`Missing config. Run: cipin init --workspace ${workspaceRoot} --model <name>`);
  }

  let parsed: unknown;
  try {
    parsed = JSON.parse(raw);
  } catch {
    throw new CipinError(`Invalid JSON: ${configPath}`);
  }

  const config = validateConfig(parsed);
  return { ...config, configPath };
}

export async function writeConfig(workspaceRoot: string, config: CipinConfig): Promise<string> {
  const dir = path.join(workspaceRoot, CONFIG_DIR);
  const configPath = path.join(dir, CONFIG_FILE);
  await fs.mkdir(dir, { recursive: true });
  await fs.writeFile(configPath, JSON.stringify(config, null, 2) + "\n", "utf8");
  return configPath;
}
