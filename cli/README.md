# Cipin CLI

Terminal AI agent untuk chat, bikin plan, dan (opsional) edit/debug code langsung di workspace.

## Prasyarat

- Node.js >= 20
- Environment variable `OPENAI_API_KEY`

## Install (global)

```bash
npm i -g cipin-cli-agent
```

## Install (dev / dari repo)

```bash
cd cli
npm install
npm run build
```

Jalankan:

```bash
node ./bin/cipin.js --help
```

Jika mau jadi command global `cipin`:

```bash
cd cli
npm link
cipin --help
```

## Quickstart

```bash
export OPENAI_API_KEY="..."

cipin init --model gpt-5
cipin cli
cipin code
cipin chat "Halo cipin"
cipin plan "Bikin rencana refactor modul auth"
cipin agent "Perbaiki test yang gagal" --dry-run
```

## Safety

- Default: konfirmasi sebelum apply patch dan sebelum menjalankan command.
- `--yes`: auto-accept patch (tetap validasi sandbox path).
- `--auto-run`: auto-run command yang ada di allowlist.
- `--dry-run`: tidak apply patch dan tidak menjalankan command.

Catatan: `apply_patch` akan memakai `git apply` jika `git` tersedia, dan fallback ke applier built-in jika tidak.
