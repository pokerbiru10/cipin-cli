import { CipinError } from "./errors.js";

export type ToolCallHandler = (args: any) => Promise<any>;

export type ToolRouter = Record<string, ToolCallHandler>;

export function requireObject(value: any, name: string): Record<string, any> {
  if (!value || typeof value !== "object") throw new CipinError(`${name} must be an object`);
  return value;
}

export function optionalString(value: any): string | undefined {
  return typeof value === "string" ? value : undefined;
}

export function optionalNumber(value: any): number | undefined {
  return typeof value === "number" && Number.isFinite(value) ? value : undefined;
}

export function requiredString(value: any, name: string): string {
  if (typeof value !== "string" || value.trim() === "") throw new CipinError(`${name} must be a string`);
  return value;
}

export function requiredStringArray(value: any, name: string): string[] {
  if (!Array.isArray(value) || value.some((v) => typeof v !== "string")) {
    throw new CipinError(`${name} must be string[]`);
  }
  return value as string[];
}

