from __future__ import annotations

from PyQt6.QtCore import QRegularExpression
from PyQt6.QtGui import (
    QColor,
    QFont,
    QSyntaxHighlighter,
    QTextCharFormat,
)


class PythonHighlighter(QSyntaxHighlighter):
    """Syntax highlighter sederhana untuk Python."""

    def __init__(self, parent=None) -> None:
        super().__init__(parent)
        self._formats: dict[str, QTextCharFormat] = {}
        self._rules: list[tuple[QRegularExpression, QTextCharFormat]] = []
        self._setup_formats()
        self._setup_rules()

    def _setup_formats(self) -> None:
        keyword_fmt = QTextCharFormat()
        keyword_fmt.setForeground(QColor("#ff79c6"))
        keyword_fmt.setFontWeight(QFont.Weight.Bold)
        self._formats["keyword"] = keyword_fmt

        builtin_fmt = QTextCharFormat()
        builtin_fmt.setForeground(QColor("#8be9fd"))
        self._formats["builtin"] = builtin_fmt

        string_fmt = QTextCharFormat()
        string_fmt.setForeground(QColor("#f1fa8c"))
        self._formats["string"] = string_fmt

        comment_fmt = QTextCharFormat()
        comment_fmt.setForeground(QColor("#6272a4"))
        comment_fmt.setFontItalic(True)
        self._formats["comment"] = comment_fmt

        number_fmt = QTextCharFormat()
        number_fmt.setForeground(QColor("#bd93f9"))
        self._formats["number"] = number_fmt

        function_fmt = QTextCharFormat()
        function_fmt.setForeground(QColor("#50fa7b"))
        self._formats["function"] = function_fmt

        decorator_fmt = QTextCharFormat()
        decorator_fmt.setForeground(QColor("#ffb86c"))
        self._formats["decorator"] = decorator_fmt

    def _setup_rules(self) -> None:
        keywords = [
            "and", "as", "assert", "async", "await", "break", "class", "continue",
            "def", "del", "elif", "else", "except", "False", "finally", "for",
            "from", "global", "if", "import", "in", "is", "lambda", "None",
            "nonlocal", "not", "or", "pass", "raise", "return", "True", "try",
            "while", "with", "yield",
        ]
        keyword_pattern = r"\b(" + "|".join(keywords) + r")\b"
        self._rules.append((QRegularExpression(keyword_pattern), self._formats["keyword"]))

        builtins = [
            "abs", "all", "any", "bin", "bool", "bytearray", "bytes", "callable",
            "chr", "classmethod", "compile", "complex", "delattr", "dict", "dir",
            "divmod", "enumerate", "eval", "exec", "filter", "float", "format",
            "frozenset", "getattr", "globals", "hasattr", "hash", "help", "hex",
            "id", "input", "int", "isinstance", "issubclass", "iter", "len",
            "list", "locals", "map", "max", "memoryview", "min", "next", "object",
            "oct", "open", "ord", "pow", "print", "property", "range", "repr",
            "reversed", "round", "set", "setattr", "slice", "sorted", "staticmethod",
            "str", "sum", "super", "tuple", "type", "vars", "zip", "__import__",
        ]
        builtin_pattern = r"\b(" + "|".join(builtins) + r")\b(?=\s*\()"
        self._rules.append((QRegularExpression(builtin_pattern), self._formats["builtin"]))

        self._rules.append((QRegularExpression(r"\b[0-9]+\b"), self._formats["number"]))
        self._rules.append((QRegularExpression(r"@[\w\.]+"), self._formats["decorator"]))
        self._rules.append((QRegularExpression(r"\b[A-Za-z_]\w*(?=\s*\()"), self._formats["function"]))

        self._string_regex = QRegularExpression(r"""("[^"]*")|('[^']*')""")
        self._multiline_string_regex = QRegularExpression(r"\"\"\"|'''")
        self._comment_regex = QRegularExpression(r"#[^\n]*")

    def highlightBlock(self, text: str) -> None:
        for regex, fmt in self._rules:
            match_iterator = regex.globalMatch(text)
            while match_iterator.hasNext():
                match = match_iterator.next()
                self.setFormat(match.capturedStart(), match.capturedLength(), fmt)

        # Strings
        match_iterator = self._string_regex.globalMatch(text)
        while match_iterator.hasNext():
            match = match_iterator.next()
            self.setFormat(match.capturedStart(), match.capturedLength(), self._formats["string"])

        # Comments
        match_iterator = self._comment_regex.globalMatch(text)
        while match_iterator.hasNext():
            match = match_iterator.next()
            self.setFormat(match.capturedStart(), match.capturedLength(), self._formats["comment"])

