from __future__ import annotations

import argparse
import os
import sys
from pathlib import Path

from .config import load_default_model
from .openai_client import CipinCliError, OpenAIClient


def main(argv: list[str] | None = None) -> int:
    args = _parse_args(argv or sys.argv[1:])

    workspace = Path(os.getcwd())
    default_model = load_default_model(workspace) or "gpt-5"
    model = args.model or default_model

    try:
        client = OpenAIClient.from_env(base_url_override=args.base_url)
    except CipinCliError as e:
        # Allow showing help without API key.
        if args.command in ("help", None) or args.command == "code":
            # In REPL, we still want to show the header even if key is missing.
            client = None  # type: ignore[assignment]
            missing_key_error = str(e)
        else:
            _print_error(str(e))
            return 2
    else:
        missing_key_error = ""

    if args.command == "chat":
        prompt = _read_prompt(args.prompt)
        if not prompt:
            _print_error('Missing prompt. Usage: python -m cli_py chat "..."')
            return 2
        if client is None:
            _print_error(missing_key_error)
            return 2
        _run_chat(client, model=model, prompt=prompt)
        return 0

    # Default: interactive code mode
    _render_header()
    if missing_key_error:
        _print_error(missing_key_error)
        sys.stdout.write("\n")
        sys.stdout.write("Set env then retry:\n")
        sys.stdout.write('  Windows (PowerShell): $env:OPENAI_API_KEY="..."\n')
        sys.stdout.write("  macOS/Linux: export OPENAI_API_KEY=...\n\n")

    _run_repl(client, model=model, stateless=args.stateless)
    return 0


def _parse_args(argv: list[str]) -> argparse.Namespace:
    p = argparse.ArgumentParser(prog="python -m cli_py", add_help=True)
    p.add_argument("--model", help="Override model (default: .cipin/config.json or gpt-5)")
    p.add_argument("--base-url", dest="base_url", help="Override OPENAI_BASE_URL (OpenAI-compatible)")
    p.add_argument("--stateless", action="store_true", help="Do not keep chat history in REPL")

    sub = p.add_subparsers(dest="command")
    chat = sub.add_parser("chat", help="Single prompt (streams output)")
    chat.add_argument("prompt", nargs="*", help="Prompt (or read from stdin)")

    sub.add_parser("code", help="Interactive terminal (default)")

    return p.parse_args(argv)


def _render_header() -> None:
    sys.stdout.write("\n")
    sys.stdout.write("CIPIN CLI - Python AI Terminal\n")
    sys.stdout.write("--------------------------------\n")
    sys.stdout.write("Type :help for commands. Ctrl+C to exit.\n\n")


def _run_chat(client: OpenAIClient, *, model: str, prompt: str) -> None:
    sys.stdout.write("\n")
    sys.stdout.write("Assistant: ")
    sys.stdout.flush()

    def on_delta(delta: str) -> None:
        sys.stdout.write(delta)
        sys.stdout.flush()

    client.stream_text(model=model, messages=[{"role": "user", "content": prompt}], on_delta=on_delta)
    sys.stdout.write("\n")


def _run_repl(client: OpenAIClient | None, *, model: str, stateless: bool) -> None:
    current_model = model
    history: list[dict[str, str]] = []

    while True:
        try:
            line = input("CIPIN CLI> ")
        except (EOFError, KeyboardInterrupt):
            sys.stdout.write("\n")
            return

        trimmed = line.strip()
        if not trimmed:
            continue

        if trimmed.startswith(":"):
            cmd, *rest = trimmed[1:].split()
            cmd = cmd.lower()
            if cmd in ("exit", "quit"):
                return
            if cmd in ("help", "?"):
                _print_help()
                continue
            if cmd == "clear":
                _clear_screen()
                continue
            if cmd == "reset":
                history.clear()
                sys.stdout.write("(history cleared)\n")
                continue
            if cmd == "model":
                if not rest:
                    sys.stdout.write(f"(model: {current_model})\n")
                else:
                    current_model = " ".join(rest).strip()
                    sys.stdout.write(f"(model set to: {current_model})\n")
                continue
            sys.stdout.write(f"Unknown command: :{cmd}. Type :help\n")
            continue

        if client is None:
            _print_error("Missing OPENAI_API_KEY env var")
            continue

        prompt = trimmed
        messages = [{"role": "user", "content": prompt}] if stateless else [*history, {"role": "user", "content": prompt}]

        sys.stdout.write("Assistant: ")
        sys.stdout.flush()
        out_parts: list[str] = []

        def on_delta(delta: str) -> None:
            out_parts.append(delta)
            sys.stdout.write(delta)
            sys.stdout.flush()

        try:
            client.stream_text(model=current_model, messages=messages, on_delta=on_delta)
        except CipinCliError as e:
            sys.stdout.write("\n")
            _print_error(str(e))
            continue

        sys.stdout.write("\n")

        if not stateless:
            history.append({"role": "user", "content": prompt})
            history.append({"role": "assistant", "content": "".join(out_parts)})


def _read_prompt(positionals: list[str]) -> str:
    if positionals:
        return " ".join(positionals).strip()
    if sys.stdin.isatty():
        return ""
    return sys.stdin.read().strip()


def _print_help() -> None:
    sys.stdout.write(
        "\nCommands:\n"
        "  :help            Show this help\n"
        "  :exit            Exit\n"
        "  :clear           Clear screen\n"
        "  :reset           Clear chat history\n"
        "  :model <name>    Set model (or show current)\n"
        "\n"
    )


def _clear_screen() -> None:
    os.system("cls" if os.name == "nt" else "clear")


def _print_error(msg: str) -> None:
    sys.stdout.write(f"Error: {msg}\n")
