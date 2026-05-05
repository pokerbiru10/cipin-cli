from __future__ import annotations

from typing import Optional

from PyQt6.QtCore import Qt, QRect, QSize
from PyQt6.QtGui import QColor, QFont, QFontMetrics, QPainter, QTextFormat
from PyQt6.QtWidgets import QPlainTextEdit, QTextEdit, QWidget

from .highlighter import PythonHighlighter


class LineNumberArea(QWidget):
    """Widget area untuk line numbers di sebelah editor."""

    def __init__(self, editor: "CodeEditor") -> None:
        super().__init__(editor)
        self._editor = editor

    def sizeHint(self) -> QSize:
        return QSize(self._editor.line_number_area_width(), 0)

    def paintEvent(self, event) -> None:
        self._editor.line_number_area_paint_event(event)


class CodeEditor(QPlainTextEdit):
    """Code editor dengan line numbers dan syntax highlighting."""

    def __init__(self, parent: Optional[QWidget] = None) -> None:
        super().__init__(parent)
        self._font = QFont("JetBrains Mono", 12)
        self._font.setStyleHint(QFont.StyleHint.Monospace)
        self.setFont(self._font)

        self.setTabStopDistance(4 * QFontMetrics(self._font).horizontalAdvance(" "))
        self.setLineWrapMode(QPlainTextEdit.LineWrapMode.NoWrap)

        # Dark background
        self.setStyleSheet("""
            QPlainTextEdit {
                background-color: #282a36;
                color: #f8f8f2;
                border: none;
                selection-background-color: #44475a;
                padding: 8px;
            }
        """)

        self._line_number_area = LineNumberArea(self)
        self._line_number_area.setStyleSheet("background-color: #21222c; color: #6272a4;")

        self.blockCountChanged.connect(self.update_line_number_area_width)
        self.updateRequest.connect(self.update_line_number_area)
        self.cursorPositionChanged.connect(self.highlight_current_line)

        self.update_line_number_area_width(0)
        self.highlight_current_line()

        # Syntax highlighter
        self._highlighter = PythonHighlighter(self.document())

    def line_number_area_width(self) -> int:
        digits = len(str(max(1, self.blockCount())))
        return 10 + QFontMetrics(self._font).horizontalAdvance("9") * digits

    def update_line_number_area_width(self, _) -> None:
        self.setViewportMargins(self.line_number_area_width(), 0, 0, 0)

    def update_line_number_area(self, rect, dy: int) -> None:
        if dy:
            self._line_number_area.scroll(0, dy)
        else:
            self._line_number_area.update(0, rect.y(), self._line_number_area.width(), rect.height())

        if rect.contains(self.viewport().rect()):
            self.update_line_number_area_width(0)

    def resizeEvent(self, event) -> None:
        super().resizeEvent(event)
        cr = self.contentsRect()
        self._line_number_area.setGeometry(QRect(cr.left(), cr.top(), self.line_number_area_width(), cr.height()))

    def line_number_area_paint_event(self, event) -> None:
        painter = QPainter(self._line_number_area)
        painter.fillRect(event.rect(), QColor("#21222c"))

        block = self.firstVisibleBlock()
        block_number = block.blockNumber()
        top = self.blockBoundingGeometry(block).translated(self.contentOffset()).top()
        bottom = top + self.blockBoundingRect(block).height()

        font_metrics = QFontMetrics(self._font)
        while block.isValid() and top <= event.rect().bottom():
            if block.isVisible() and bottom >= event.rect().top():
                number = str(block_number + 1)
                painter.setPen(QColor("#6272a4"))
                painter.drawText(
                    0,
                    int(top),
                    self._line_number_area.width() - 4,
                    font_metrics.height(),
                    Qt.AlignmentFlag.AlignRight,
                    number,
                )
            block = block.next()
            top = bottom
            bottom = top + self.blockBoundingRect(block).height()
            block_number += 1

    def highlight_current_line(self) -> None:
        extra_selections = []
        if not self.isReadOnly():
            selection = QTextEdit.ExtraSelection()
            line_color = QColor("#44475a")
            selection.format.setBackground(line_color)
            selection.format.setProperty(QTextFormat.Property.FullWidthSelection, True)
            selection.cursor = self.textCursor()
            selection.cursor.clearSelection()
            extra_selections.append(selection)
        self.setExtraSelections(extra_selections)

    def set_text(self, text: str) -> None:
        self.setPlainText(text)

    def get_text(self) -> str:
        return self.toPlainText()

    def get_selected_text(self) -> str:
        return self.textCursor().selectedText()

