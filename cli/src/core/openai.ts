import { CipinError } from "./errors.js";
import { parseSseEvents } from "./sse.js";

export type FunctionTool = {
  type: "function";
  name: string;
  description: string;
  parameters: unknown;
  strict?: boolean;
};

export type CreateResponseParams = {
  model: string;
  input: Array<{ role: string; content: string }> | string;
  instructions?: string;
  tools?: FunctionTool[];
  stream?: boolean;
};

export type FunctionCallItem = {
  type: "function_call";
  call_id: string;
  name: string;
  arguments: string;
};

export type ResponseOutputItem = FunctionCallItem | { type: string; [k: string]: unknown };

export type CreateResponseResult = {
  id: string;
  output: ResponseOutputItem[];
  output_text?: string;
};

export class OpenAIClient {
  private readonly apiKey: string;
  private readonly baseUrl: string;

  constructor(opts?: { apiKey?: string; baseUrl?: string }) {
    const apiKey = opts?.apiKey ?? process.env.OPENAI_API_KEY;
    if (!apiKey) throw new CipinError("Missing OPENAI_API_KEY env var");
    this.apiKey = apiKey;
    this.baseUrl = (opts?.baseUrl ?? process.env.OPENAI_BASE_URL ?? "https://api.openai.com/v1").replace(/\/+$/, "");
  }

  async createResponse(params: CreateResponseParams): Promise<CreateResponseResult> {
    const url = this.baseUrl + "/responses";
    const res = await fetch(url, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${this.apiKey}`,
      },
      body: JSON.stringify({
        model: params.model,
        input: params.input,
        instructions: params.instructions,
        tools: params.tools,
        stream: params.stream ?? false,
      }),
    });

    if (!res.ok) {
      const text = await safeReadText(res);
      throw new CipinError(`OpenAI API error (${res.status}): ${text}`);
    }

    const json = (await res.json()) as any;
    return {
      id: String(json.id ?? ""),
      output: Array.isArray(json.output) ? (json.output as ResponseOutputItem[]) : [],
      output_text: extractOutputText(json),
    };
  }

  async streamText(params: CreateResponseParams, onDelta: (delta: string) => void): Promise<void> {
    const url = this.baseUrl + "/responses";
    const res = await fetch(url, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${this.apiKey}`,
      },
      body: JSON.stringify({
        model: params.model,
        input: params.input,
        instructions: params.instructions,
        tools: params.tools,
        stream: true,
      }),
    });

    if (!res.ok) {
      const text = await safeReadText(res);
      throw new CipinError(`OpenAI API error (${res.status}): ${text}`);
    }

    if (!res.body) throw new CipinError("Missing response body for streaming");
    for await (const event of parseSseEvents(res.body)) {
      if (event === "[DONE]") return;
      let obj: any;
      try {
        obj = JSON.parse(event);
      } catch {
        continue;
      }
      if (obj?.type === "response.output_text.delta" && typeof obj?.delta === "string") {
        onDelta(obj.delta);
      }
    }
  }
}

async function safeReadText(res: Response): Promise<string> {
  try {
    return await res.text();
  } catch {
    return "(no body)";
  }
}

function extractOutputText(responseJson: any): string | undefined {
  if (!responseJson || typeof responseJson !== "object") return undefined;
  if (typeof responseJson.output_text === "string") return responseJson.output_text;
  const output = Array.isArray(responseJson.output) ? responseJson.output : [];
  let text = "";
  for (const item of output) {
    if (!item || typeof item !== "object") continue;
    if (item.type !== "message") continue;
    const content = Array.isArray(item.content) ? item.content : [];
    for (const part of content) {
      if (!part || typeof part !== "object") continue;
      if (part.type === "output_text" && typeof part.text === "string") text += part.text;
    }
  }
  return text || undefined;
}
