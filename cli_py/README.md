# cli_py - CIPIN Python AI Terminal

CLI sederhana untuk chat AI via OpenAI Responses API (streaming) + mode terminal (REPL).

## Prasyarat

- Python 3.11+
- Environment variable `OPENAI_API_KEY`
- (opsional) `OPENAI_BASE_URL` untuk OpenAI-compatible server

## Cara pakai

Jalankan single prompt:

```bash
python -m cli_py chat "Hello"
```

Masuk mode terminal (default):

```bash
python -m cli_py
```

Di mode terminal:

- `:help` lihat command
- `:model gpt-5` ganti model
- `:reset` hapus history

## Set API key

Windows (PowerShell):

```powershell
$env:OPENAI_API_KEY="YOUR_KEY"
```

macOS/Linux:

```bash
export OPENAI_API_KEY="YOUR_KEY"
```
