import test from "node:test";
import assert from "node:assert/strict";
import { resolveInsideWorkspace } from "../src/core/paths.js";

test("resolveInsideWorkspace blocks escaping paths", () => {
  assert.throws(() => resolveInsideWorkspace("C:\\work", "..\\secrets.txt"));
});

