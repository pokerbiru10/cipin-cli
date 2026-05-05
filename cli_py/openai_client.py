from __future__ import annotations

import json
import os
import urllib.error
import urllib.request
from dataclasses import dataclass
from typing import Callable, Iterable

from .sse import iter_sse_events


class CipinCliError(RuntimeError):
    pass


@dataclass(frozen=True)
class OpenAIClient:
    api_key: str
    base_url: str

    @classmethod
    def from_env(cls, base_url_override: str | None = None) -> "OpenAIClient":
        api_key = os.environ.get("OPENAI_API_KEY", "").strip()
        if not api_key:
            raise CipinCliError("Missing OPENAI_API_KEY env var")

        base_url = (
            (base_url_override or os.environ.get("OPENAI_BASE_URL") or "https://api.openai.com/v1")
            .strip()
            .rstrip("/")
        )
        return cls(api_key=api_key, base_url=base_url)

    def stream_text(
        self,
        *,
        model: str,
        messages: Iterable[dict[str, str]],
        on_delta: Callable[[str], None],
    ) -> None:
        url = f"{self.base_url}/responses"
        payload = {
            "model": model,
            "input": list(messages),
            "stream": True,
        }

        req = urllib.request.Request(
            url,
            data=json.dumps(payload).encode("utf-8"),
            method="POST",
            headers={
                "Content-Type": "application/json",
                "Accept": "text/event-stream",
                "Authorization": f"Bearer {self.api_key}",
            },
        )

        try:
            with urllib.request.urlopen(req, timeout=60) as resp:
                for event in iter_sse_events(resp):
                    if event == "[DONE]":
                        return
                    try:
                        obj = json.loads(event)
                    except Exception:
                        continue

                    if obj.get("type") == "response.output_text.delta" and isinstance(obj.get("delta"), str):
                        on_delta(obj["delta"])
        except urllib.error.HTTPError as e:
            body = ""
            try:
                body = e.read().decode("utf-8", errors="replace")
            except Exception:
                body = "(no body)"
            raise CipinCliError(f"OpenAI API error ({e.code}): {body}") from e
        except urllib.error.URLError as e:
            raise CipinCliError(f"OpenAI API connection error: {e}") from e

