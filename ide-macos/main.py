#!/usr/bin/env python3
"""
CIPIN IDE - Desktop AI IDE untuk macOS / Windows / Linux
Aplikasi GUI Python (PyQt6) dengan integrasi AI Chat seperti Blackbox.
"""
from __future__ import annotations

import sys
from pathlib import Path

# Pastikan cli_py tersedia untuk import
PROJECT_ROOT = Path(__file__).resolve().parent.parent
sys.path.insert(0, str(PROJECT_ROOT))

from PyQt6.QtWidgets import QApplication
from src.app import CipinIDE


def main() -> int:
    app = QApplication(sys.argv)
    app.setApplicationName("CIPIN IDE")
    app.setApplicationVersion("0.1.0")
    app.setOrganizationName("cipin")

    # Dark theme default
    app.setStyle("Fusion")

    window = CipinIDE()
    window.show()

    return app.exec()


if __name__ == "__main__":
    raise SystemExit(main())

