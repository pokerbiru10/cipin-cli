import test from "node:test";
import assert from "node:assert/strict";
import { anyGlobMatch } from "../src/core/glob.js";

test("anyGlobMatch supports **", () => {
  assert.equal(anyGlobMatch("src/a/b/c.ts", ["src/**"]), true);
  assert.equal(anyGlobMatch("vendor/x.php", ["vendor/**"]), true);
  assert.equal(anyGlobMatch("app/x.php", ["vendor/**"]), false);
});

