$ErrorActionPreference = "Stop"

function Require-Command([string]$Name) {
  $cmd = Get-Command $Name -ErrorAction SilentlyContinue
  if (-not $cmd) {
    throw "$Name not found. Install Node.js >= 20 first."
  }
}

Require-Command "node"
Require-Command "npm"

Write-Host ("Node: " + (node -v))

Write-Host "Installing cipin-cli-agent globally..."
npm i -g cipin-cli-agent

Write-Host ""
Write-Host "Done."
Write-Host ""
Write-Host "Next:"
Write-Host '  $env:OPENAI_API_KEY="..."'
Write-Host "  cipin init --model gpt-5"
Write-Host "  cipin code"
