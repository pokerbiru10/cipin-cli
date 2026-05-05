from __future__ import annotations

from pathlib import Path
from typing import Optional

from PyQt6.QtCore import Qt, pyqtSignal
from PyQt6.QtGui import QFileSystemModel
from PyQt6.QtWidgets import QTreeView, QWidget


class FileExplorer(QTreeView):
    """Sidebar file explorer menggunakan QFileSystemModel."""

    file_selected = pyqtSignal(str)

    def __init__(self, root_path: str, parent: Optional[QWidget] = None) -> None:
        super().__init__(parent)
        self._root_path = Path(root_path)

        self._model = QFileSystemModel()
        self._model.setRootPath(str(self._root_path))
        self._model.setFilter(
            Qt.Filter.AllDirs | Qt.Filter.Files | Qt.Filter.NoDotAndDotDot
        )

        self.setModel(self._model)
        self.setRootIndex(self._model.index(str(self._root_path)))

        # Hide unnecessary columns, show only name
        self.setColumnWidth(0, 250)
        self.setHeaderHidden(True)
        for col in range(1, self._model.columnCount()):
            self.hideColumn(col)

        self.setStyleSheet("""
            QTreeView {
                background-color: #21222c;
                color: #f8f8f2;
                border: none;
                outline: none;
            }
            QTreeView::item {
                padding: 4px;
            }
            QTreeView::item:selected {
                background-color: #44475a;
                color: #f8f8f2;
            }
            QTreeView::item:hover {
                background-color: #2a2c38;
            }
        """)

        self.clicked.connect(self._on_clicked)
        self.setAnimated(True)
        self.setIndentation(12)

    def _on_clicked(self, index) -> None:
        path = self._model.filePath(index)
        if Path(path).is_file():
            self.file_selected.emit(path)

    def set_root_path(self, path: str) -> None:
        self._root_path = Path(path)
        self._model.setRootPath(path)
        self.setRootIndex(self._model.index(path))

