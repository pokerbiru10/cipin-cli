import readline from "node:readline/promises";

export async function confirmYesNo(question: string, defaultNo = true): Promise<boolean> {
  const rl = readline.createInterface({ input: process.stdin, output: process.stdout });
  try {
    const suffix = defaultNo ? " [y/N] " : " [Y/n] ";
    const answer = (await rl.question(question + suffix)).trim().toLowerCase();
    if (!answer) return !defaultNo;
    return answer === "y" || answer === "yes";
  } finally {
    rl.close();
  }
}

