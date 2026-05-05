#!/usr/bin/env bash
set -euo pipefail

if ! command -v node >/dev/null 2>&1; then
  echo "node not found. Install Node.js >= 20 first." >&2
  exit 1
fi

if ! command -v npm >/dev/null 2>&1; then
  echo "npm not found. Install Node.js (includes npm) first." >&2
  exit 1
fi

node_version="$(node -v || true)"
echo "Node: ${node_version}"

echo "Installing cipin-cli-agent globally..."
npm i -g cipin-cli-agent

cat <<'EOF'

Done.

Next:
  export OPENAI_API_KEY="..."
  cipin init --model gpt-5
  cipin code

EOF
