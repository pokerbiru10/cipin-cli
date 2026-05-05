#!/usr/bin/env node
import { main } from "../dist/src/index.js";

main(process.argv.slice(2)).catch((err) => {
  const message = err instanceof Error ? err.message : String(err);
  console.error(message);
  process.exitCode = 1;
});

