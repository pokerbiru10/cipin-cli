from __future__ import annotations

import json
from pathlib import Path
from typing import Any


def load_default_model(workspace: Path) -> str | None:
    """
    Try to load default model from .cipin/config.json.
    Returns None if config is missing/invalid.
    """
    cfg_path = workspace / ".cipin" / "config.json"
    if not cfg_path.exists():
        return None

    try:
        data: Any = json.loads(cfg_path.read_text(encoding="utf-8"))
    except Exception:
        return None

    if isinstance(data, dict) and isinstance(data.get("model"), str) and data["model"].strip():
        model = data["model"].strip()
        if model != "REPLACE_ME":
            return model
    return None

