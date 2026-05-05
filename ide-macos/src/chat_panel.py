from __future__ import annotations

import os
from pathlib import Path
from typing import Optional

from PyQt6.QtCore import Qt, QThread, pyqtSignal
from PyQt6.QtGui import QColor, QFont, QTextCursor
from PyQt6.QtWidgets import (
    QFrame,
    QHBoxLayout,
    QLabel,
    QLineEdit,
    QPushButton,
    QScrollArea,
    QSplitter,
    QTextEdit,
    QVBoxLayout,
    QWidget,
)

from .worker import StreamWorker


class MessageBubble(QFrame):
    """Bubble chat untuk user / assistant."""

    def __init__(self, text: str, is_user: bool = False, parent: Optional[QWidget] = None) -> None:
        super().__init__(parent)
        self._is_user = is_user

        layout = QHBoxLayout(self)
        layout.setContentsMargins(12, 8, 12, 8)
        layout.setSpacing(0)

        self._label = QLabel(text)
        self._label.setWordWrap(True)
        self._label.setTextInteractionFlags(Qt.TextInteractionFlag.TextSelectableByMouse)
        self._label.setFont(QFont("SF Pro Text", 12))
        self._label.setStyleSheet("""
            QLabel {
                color: #f8f8f2;
                line-height: 140%;
            }
        """)

        if is_user:
            self.setStyleSheet("""
                MessageBubble {
                    background-color: #bd93f9;
                    border-radius: 12px;
                    border-top-right-radius: 2px;
                }
                QLabel { color: #282a36; }
            """)
            layout.addStretch()
            layout.addWidget(self._label)
        else:
            self.setStyleSheet("""
                MessageBubble {
                    background-color: #44475a;
                    border-radius: 12px;
                    border-top-left-radius: 2px;
                }
            """)
            layout.addWidget(self._label)
            layout.addStretch()

        self.setMaximumWidth(700)

    def append_text(self, text: str) -> None:
        current = self._label.text()
        self._label.setText(current + text)

    def set_text(self, text: str) -> None:
        self._label.setText(text)


class ChatPanel(QWidget):
    """Panel chat AI seperti Blackbox - di sisi kanan IDE."""

    send_message = pyqtSignal(str)

    def __init__(self, parent: Optional[QWidget] = None) -> None:
        super().__init__(parent)
        self._client = None
        self._model = "gpt-5"
        self._history: list[dict[str, str]] = []
        self._current_worker: Optional[StreamWorker] = None
        self._current_thread: Optional[QThread] = None
        self._current_bubble: Optional[MessageBubble] = None

        self._setup_ui()
        self._try_load_client()

    def _setup_ui(self) -> None:
        layout = QVBoxLayout(self)
        layout.setContentsMargins(0, 0, 0, 0)
        layout.setSpacing(0)

        # Header
        header = QWidget()
        header.setStyleSheet("background-color: #21222c; border-bottom: 1px solid #44475a;")
        header_layout = QHBoxLayout(header)
        header_layout.setContentsMargins(16, 12, 16, 12)

        title = QLabel("🤖 CIPIN AI Chat")
        title.setFont(QFont("SF Pro Display", 14, QFont.Weight.Bold))
        title.setStyleSheet("color: #f8f8f2;")
        header_layout.addWidget(title)

        self._model_label = QLabel(f"model: {self._model}")
        self._model_label.setStyleSheet("color: #6272a4; font-size: 11px;")
        header_layout.addStretch()
        header_layout.addWidget(self._model_label)

        layout.addWidget(header)

        # Chat area
        scroll = QScrollArea()
        scroll.setWidgetResizable(True)
        scroll.setHorizontalScrollBarPolicy(Qt.ScrollBarPolicy.ScrollBarAlwaysOff)
        scroll.setStyleSheet("""
            QScrollArea {
                background-color: #282a36;
                border: none;
            }
            QScrollBar:vertical {
                background: #282a36;
                width: 8px;
            }
            QScrollBar::handle:vertical {
                background: #44475a;
                border-radius: 4px;
            }
        """)

        self._chat_container = QWidget()
        self._chat_layout = QVBoxLayout(self._chat_container)
        self._chat_layout.setContentsMargins(16, 16, 16, 16)
        self._chat_layout.setSpacing(12)
        self._chat_layout.addStretch()

        scroll.setWidget(self._chat_container)
        layout.addWidget(scroll, 1)

        # Input area
        input_container = QWidget()
        input_container.setStyleSheet("""
            QWidget {
                background-color: #21222c;
                border-top: 1px solid #44475a;
