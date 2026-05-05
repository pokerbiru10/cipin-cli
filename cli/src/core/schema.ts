import { CipinError } from "./errors.js";

export type CipinConfig = {
  model: string;
  workspaceRoot: string;
  ignoreGlobs: string[];
  safety: {
    confirmEdits: boolean;
    confirmCommands: boolean;
  };
  agent: {
    maxSteps: number;
    maxToolOutputChars: number;
    readFileMaxChars: number;
    defaultSearchLimit: number;
    defaultListFilesLimit: number;
    commandTimeoutSec: number;
  };
};

export function validateConfig(value: unknown): CipinConfig {
  if (!value || typeof value !== "object") throw new CipinError("Invalid config: expected object");
  const v = value as Record<string, unknown>;

  const model = requiredString(v.model, "model");
  const workspaceRoot = requiredString(v.workspaceRoot, "workspaceRoot");
  const ignoreGlobs = requiredStringArray(v.ignoreGlobs, "ignoreGlobs");

  const safety = requiredObject(v.safety, "safety");
  const confirmEdits = requiredBoolean(safety.confirmEdits, "safety.confirmEdits");
  const confirmCommands = requiredBoolean(safety.confirmCommands, "safety.confirmCommands");

  const agent = requiredObject(v.agent, "agent");
  const maxSteps = requiredNumber(agent.maxSteps, "agent.maxSteps");
  const maxToolOutputChars = requiredNumber(agent.maxToolOutputChars, "agent.maxToolOutputChars");
  const readFileMaxChars = requiredNumber(agent.readFileMaxChars, "agent.readFileMaxChars");
  const defaultSearchLimit = requiredNumber(agent.defaultSearchLimit, "agent.defaultSearchLimit");
  const defaultListFilesLimit = requiredNumber(agent.defaultListFilesLimit, "agent.defaultListFilesLimit");
  const commandTimeoutSec = requiredNumber(agent.commandTimeoutSec, "agent.commandTimeoutSec");

  return {
    model,
    workspaceRoot,
    ignoreGlobs,
    safety: { confirmEdits, confirmCommands },
    agent: {
      maxSteps,
      maxToolOutputChars,
      readFileMaxChars,
      defaultSearchLimit,
      defaultListFilesLimit,
      commandTimeoutSec,
    },
  };
}

function requiredObject(v: unknown, name: string): Record<string, unknown> {
  if (!v || typeof v !== "object") throw new CipinError(`Invalid config: ${name} must be object`);
  return v as Record<string, unknown>;
}

function requiredString(v: unknown, name: string): string {
  if (typeof v !== "string" || v.trim() === "") throw new CipinError(`Invalid config: ${name} must be string`);
  return v;
}

function requiredStringArray(v: unknown, name: string): string[] {
  if (!Array.isArray(v) || v.some((x) => typeof x !== "string")) {
    throw new CipinError(`Invalid config: ${name} must be string[]`);
  }
  return v as string[];
}

function requiredBoolean(v: unknown, name: string): boolean {
  if (typeof v !== "boolean") throw new CipinError(`Invalid config: ${name} must be boolean`);
  return v;
}

function requiredNumber(v: unknown, name: string): number {
  if (typeof v !== "number" || !Number.isFinite(v)) throw new CipinError(`Invalid config: ${name} must be number`);
  return v;
}

