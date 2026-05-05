from __future__ import annotations

from collections.abc import Iterator
from typing import BinaryIO


def iter_sse_events(stream: BinaryIO) -> Iterator[str]:
    """
    Minimal SSE parser.

    Yields the concatenated "data:" payload for each event block.
    """
    data_lines: list[str] = []

    while True:
        raw = stream.readline()
        if not raw:
            break

        line = raw.decode("utf-8", errors="replace").rstrip("\r\n")

        # Blank line terminates one event.
        if line == "":
            if data_lines:
                yield "\n".join(data_lines)
                data_lines.clear()
            continue

        # Comment lines.
        if line.startswith(":"):
            continue

        if line.startswith("data:"):
            data_lines.append(line[5:].lstrip())

    if data_lines:
        yield "\n".join(data_lines)

