from __future__ import annotations

from typing import Callable

from PyQt6.QtCore import QObject, pyqtSignal, QThread


class StreamWorker(QObject):
    """Worker thread untuk streaming OpenAI API agar UI tidak freeze."""

    delta_received = pyqtSignal(str)
    finished = pyqtSignal()
    error = pyqtSignal(str)

    def __init__(
        self,
        client,
        model: str,
        messages: list[dict[str, str]],
        parent: QObject | None = None,
    ) -> None:
        super().__init__(parent)
        self.client = client
        self.model = model
        self.messages = messages
        self._is_running = True

    def run(self) -> None:
        try:
            def on_delta(delta: str) -> None:
                if self._is_running:
                    self.delta_received.emit(delta)

            self.client.stream_text(
                model=self.model,
                messages=self.messages,
                on_delta=on_delta,
            )
        except Exception as e:
            if self._is_running:
                self.error.emit(str(e))
        finally:
            if self._is_running:
                self.finished.emit()

    def stop(self) -> None:
        self._is_running = False

