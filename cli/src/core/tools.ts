import { confirmYesNo } from "./confirm.js";
import { summarizeUnifiedDiff } from "./diff.js";
import { CipinError } from "./errors.js";
import { listFiles, readFileText } from "./fs_tools.js";
import { gitApply } from "./git_apply.js";
import { searchText } from "./search.js";
import { runCommand } from "./runner.js";
import { isSensitivePath } from "./sensitive.js";
import { applyUnifiedDiff } from "./unified_apply.js";
import { optionalNumber, optionalString, requireObject, requiredString, requiredStringArray, ToolRouter } from "./tooling.js";

export type ToolContext = {
  workspaceRoot: string;
  ignoreGlobs: string[];
  yes: boolean;
  autoRun: boolean;
  dryRun: boolean;
  confirmEdits: boolean;
  confirmCommands: boolean;
  limits: {
    readFileMaxChars: number;
    maxToolOutputChars: number;
    defaultSearchLimit: number;
    defaultListFilesLimit: number;
    commandTimeoutSec: number;
  };
};

export function createToolRouter(ctx: ToolContext): ToolRouter {
  return {
    async list_files(args: any) {
      const a = requireObject(args, "list_files args");
      const glob = optionalString(a.glob);
      const limit = Math.min(optionalNumber(a.limit) ?? ctx.limits.defaultListFilesLimit, 2000);
      const files = await listFiles(ctx.workspaceRoot, { glob, limit, ignoreGlobs: ctx.ignoreGlobs });
      return cap({ files }, ctx.limits.maxToolOutputChars);
    },

    async read_file(args: any) {
      const a = requireObject(args, "read_file args");
      const p = requiredString(a.path, "path");
      const maxChars = Math.min(optionalNumber(a.maxChars) ?? ctx.limits.readFileMaxChars, ctx.limits.readFileMaxChars);
      const r = await readFileText(ctx.workspaceRoot, p, { maxChars, ignoreGlobs: ctx.ignoreGlobs });
      return cap(r, ctx.limits.maxToolOutputChars);
    },

    async search(args: any) {
      const a = requireObject(args, "search args");
      const query = requiredString(a.query, "query");
      const glob = optionalString(a.glob);
      const limit = Math.min(optionalNumber(a.limit) ?? ctx.limits.defaultSearchLimit, 500);
      const hits = await searchText(ctx.workspaceRoot, query, { glob, limit, ignoreGlobs: ctx.ignoreGlobs });
      return cap({ hits }, ctx.limits.maxToolOutputChars);
    },

    async propose_patch(args: any) {
      const a = requireObject(args, "propose_patch args");
      const patch = requiredString(a.patch, "patch");
      const summary = summarizeUnifiedDiff(ctx.workspaceRoot, patch);
      return cap({ ok: true, summary }, ctx.limits.maxToolOutputChars);
    },

    async apply_patch(args: any) {
      const a = requireObject(args, "apply_patch args");
      const patch = requiredString(a.patch, "patch");

      const summary = summarizeUnifiedDiff(ctx.workspaceRoot, patch);
      for (const f of summary.files) {
        if (isSensitivePath(f.path)) throw new CipinError(`Refusing to edit sensitive path: ${f.path}`);
      }

      if (ctx.dryRun) return { ok: true, dryRun: true, summary };

      if (ctx.confirmEdits && !ctx.yes) {
        const ok = await confirmYesNo(`Apply patch touching ${summary.files.length} file(s)?`, true);
        if (!ok) return { ok: false, skipped: true, reason: "user_declined" };
      }

      try {
        await gitApply(ctx.workspaceRoot, patch);
      } catch (err) {
        const message = err instanceof Error ? err.message : String(err);
        if (message.toLowerCase().includes("git not found")) {
          await applyUnifiedDiff(ctx.workspaceRoot, patch);
        } else {
          throw err;
        }
      }
      return { ok: true, applied: true, summary };
    },

    async run_command(args: any) {
      const a = requireObject(args, "run_command args");
      const argv = requiredStringArray(a.argv, "argv");
      const cwd = optionalString(a.cwd);
      const timeoutSec = Math.min(optionalNumber(a.timeoutSec) ?? ctx.limits.commandTimeoutSec, 3600);

      if (ctx.dryRun) return { ok: true, dryRun: true, argv, cwd };

      if (ctx.confirmCommands && !ctx.autoRun) {
        const ok = await confirmYesNo(`Run command: ${argv.join(" ")} ?`, true);
        if (!ok) return { ok: false, skipped: true, reason: "user_declined" };
      }

      const result = await runCommand(ctx.workspaceRoot, argv, {
        cwd,
        timeoutSec,
        maxOutputChars: ctx.limits.maxToolOutputChars,
      });
      return cap({ ok: true, result }, ctx.limits.maxToolOutputChars);
    },
  };
}

function cap(value: any, maxChars: number): any {
  const json = JSON.stringify(value);
  if (json.length <= maxChars) return value;
  return { truncated: true, note: `output exceeded ${maxChars} chars` };
}
