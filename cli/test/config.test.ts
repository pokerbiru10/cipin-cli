import test from "node:test";
import assert from "node:assert/strict";
import { validateConfig } from "../src/core/schema.js";

test("validateConfig accepts valid config", () => {
  const cfg = validateConfig({
    model: "gpt-5",
    workspaceRoot: "/tmp/work",
    ignoreGlobs: ["node_modules/**"],
    safety: { confirmEdits: true, confirmCommands: true },
    agent: {
      maxSteps: 5,
      maxToolOutputChars: 1000,
      readFileMaxChars: 1000,
      defaultSearchLimit: 10,
      defaultListFilesLimit: 10,
      commandTimeoutSec: 10,
    },
  });

  assert.equal(cfg.model, "gpt-5");
});

