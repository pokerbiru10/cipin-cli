import test from "node:test";
import assert from "node:assert/strict";
import { runCommand } from "../src/core/runner.js";

test("runCommand denies non-allowlisted exe", async () => {
  await assert.rejects(
    () => runCommand(process.cwd(), ["rm", "-rf", "."], { timeoutSec: 1, maxOutputChars: 1000 }),
    /not allowed/i,
  );
});

