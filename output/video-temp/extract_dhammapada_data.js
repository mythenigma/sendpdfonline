const fs = require("fs");
const path = require("path");
const vm = require("vm");

const root = path.resolve(__dirname, "..", "..");
const htmlPath = path.join(root, "dhammapada.html");
const html = fs.readFileSync(htmlPath, "utf8");

function extractLiteralAfterConst(constName) {
  const marker = `const ${constName} = `;
  const start = html.indexOf(marker);
  if (start === -1) {
    throw new Error(`Missing const marker: ${constName}`);
  }

  const from = start + marker.length;
  const opener = html[from];
  const closer = opener === "[" ? "]" : "}";
  if (!["[", "{"].includes(opener)) {
    throw new Error(`Unsupported opener for ${constName}: ${opener}`);
  }

  let depth = 0;
  let inString = false;
  let quote = "";
  let escaped = false;

  for (let i = from; i < html.length; i += 1) {
    const ch = html[i];

    if (inString) {
      if (escaped) {
        escaped = false;
        continue;
      }
      if (ch === "\\") {
        escaped = true;
        continue;
      }
      if (ch === quote) {
        inString = false;
        quote = "";
      }
      continue;
    }

    if (ch === '"' || ch === "'" || ch === "`") {
      inString = true;
      quote = ch;
      continue;
    }

    if (ch === opener) depth += 1;
    if (ch === closer) depth -= 1;

    if (depth === 0) {
      return html.slice(from, i + 1);
    }
  }

  throw new Error(`Could not find closing token for ${constName}`);
}

function evaluateSnippet(snippet) {
  return vm.runInNewContext(`(${snippet})`, {}, { timeout: 1000 });
}

const chaptersSnippet = extractLiteralAfterConst("chapters");
const vocabGuideSnippet = extractLiteralAfterConst("vocabGuide");
const chapters = evaluateSnippet(chaptersSnippet);
const vocabGuide = evaluateSnippet(vocabGuideSnippet);

const idsArg = process.argv.find((arg) => arg.startsWith("--ids="));
const chapterArg = process.argv.find((arg) => arg.startsWith("--chapter="));
const ids = idsArg
  ? idsArg.replace("--ids=", "").split(",").map((value) => Number(value.trim())).filter(Boolean)
  : [];
const chapterNumber = chapterArg ? Number(chapterArg.replace("--chapter=", "").trim()) : 1;

const chapterMeta = chapters.find((chapter) => chapter.id === chapterNumber);
if (!chapterMeta) {
  throw new Error(`Missing chapter metadata for chapter ${chapterNumber}`);
}

const versesSnippet = extractLiteralAfterConst(`chapter${chapterNumber}Verses`);
const verses = evaluateSnippet(versesSnippet);

const filtered = ids.length ? verses.filter((verse) => ids.includes(verse.id)) : verses;

const enriched = filtered.map((verse) => ({
  id: verse.id,
  title: verse.title,
  titleZh: verse.titleZh,
  literalZh: verse.literalZh,
  english: verse.english,
  chinese: verse.chinese,
  takeaway: verse.takeaway,
  example: verse.example,
  vocab: (verse.vocab || []).map((item) => ({
    ...item,
    en: vocabGuide[item.word]?.en || "",
    example: vocabGuide[item.word]?.example || "",
  })),
}));

process.stdout.write(
  JSON.stringify(
    {
      chapterNumber,
      chapterTitle: chapterMeta.title,
      verses: enriched,
    },
    null,
    2
  )
);
