export async function* parseSseEvents(body: ReadableStream<Uint8Array>): AsyncGenerator<string> {
  const reader = body.getReader();
  const decoder = new TextDecoder("utf-8");
  let buffer = "";

  while (true) {
    const { value, done } = await reader.read();
    if (done) break;
    buffer += decoder.decode(value, { stream: true });

    let idx: number;
    while ((idx = buffer.indexOf("\n\n")) >= 0) {
      const chunk = buffer.slice(0, idx);
      buffer = buffer.slice(idx + 2);

      const dataLines = chunk
        .split("\n")
        .map((l) => l.trimEnd())
        .filter((l) => l.startsWith("data:"))
        .map((l) => l.slice("data:".length).trim());

      for (const data of dataLines) {
        if (!data) continue;
        yield data;
      }
    }
  }

  const tail = buffer.trim();
  if (tail.startsWith("data:")) yield tail.slice("data:".length).trim();
}

