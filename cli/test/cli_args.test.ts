import test from "node:test";
import assert from "node:assert/strict";
import { parseCliArgs } from "../src/core/cli_args.js";

test("parseCliArgs parses code command", () => {
  const args = parseCliArgs(["code"]);
  assert.equal(args.command, "code");
});

test("parseCliArgs preserves flags with code command", () => {
  const args = parseCliArgs(["code", "--model", "gpt-5", "--yes", "--auto-run", "--dry-run"]);
  assert.equal(args.command, "code");
  assert.equal(args.model, "gpt-5");
  assert.equal(args.yes, true);
  assert.equal(args.autoRun, true);
  assert.equal(args.dryRun, true);
});

