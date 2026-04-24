from __future__ import annotations

import argparse
import json
import re
import subprocess
import sys
import wave
from pathlib import Path

from PIL import Image, ImageDraw, ImageFont


ROOT = Path(__file__).resolve().parents[2]
OUT = ROOT / "output" / "video-temp"

WIDTH = 1600
HEIGHT = 900

BG = "#f4ecd9"
CARD = "#fbf6ec"
BORDER = "#d9c7a3"
TEXT = "#2e2419"
MUTED = "#8d6d43"
SOFT = "#a48c66"
LINE = "#dccaa8"

FONTS = {
    "sans": str(Path("C:/Windows/Fonts/arial.ttf")),
    "serif": str(Path("C:/Windows/Fonts/georgia.ttf")),
    "zh": str(Path("C:/Windows/Fonts/msyh.ttc")),
    "zh_bold": str(Path("C:/Windows/Fonts/msyhbd.ttc")),
}

EN_VOICE = "David"
ZH_VOICE = "Huihui"
TITLE_HOLD = 1.6
EN_GAP = 0.30
ZH_GAP = 0.60
VOCAB_GAP = 0.90


def font(kind: str, size: int) -> ImageFont.FreeTypeFont:
    return ImageFont.truetype(FONTS[kind], size=size)


def slugify(value: str) -> str:
    value = value.lower()
    value = re.sub(r"[^a-z0-9]+", "-", value)
    return value.strip("-")


def wrap_text(draw: ImageDraw.ImageDraw, text: str, text_font: ImageFont.FreeTypeFont, max_width: int) -> list[str]:
    words = text.split(" ")
    lines: list[str] = []
    current = ""
    for word in words:
        candidate = word if not current else current + " " + word
        if draw.textbbox((0, 0), candidate, font=text_font)[2] <= max_width:
            current = candidate
        else:
            if current:
                lines.append(current)
            current = word
    if current:
        lines.append(current)
    return lines


def wrap_cjk(draw: ImageDraw.ImageDraw, text: str, text_font: ImageFont.FreeTypeFont, max_width: int) -> list[str]:
    lines: list[str] = []
    current = ""
    for ch in text:
        candidate = current + ch
        if draw.textbbox((0, 0), candidate, font=text_font)[2] <= max_width:
            current = candidate
        else:
            if current:
                lines.append(current)
            current = ch
    if current:
        lines.append(current)
    return lines


def make_canvas() -> tuple[Image.Image, ImageDraw.ImageDraw]:
    image = Image.new("RGBA", (WIDTH, HEIGHT), BG)
    draw = ImageDraw.Draw(image)
    draw.rounded_rectangle((54, 52, WIDTH - 54, HEIGHT - 52), radius=34, fill="#f1e7d1", outline=BORDER, width=2)
    draw.rectangle((92, 90, WIDTH - 92, HEIGHT - 90), fill=CARD)
    draw.line((94, 126, 734, 126), fill=LINE, width=2)
    draw.line((94, HEIGHT - 144, WIDTH - 94, HEIGHT - 144), fill=LINE, width=2)

    illustration = OUT / "verse-001-illustration.png"
    if illustration.exists():
        art = Image.open(illustration).convert("RGBA")
        art.thumbnail((560, 620))
        alpha = art.getchannel("A").point(lambda value: int(value * 0.46))
        art.putalpha(alpha)
        image.alpha_composite(art, dest=(930, 120))

    return image, draw


def split_english(text: str) -> list[str]:
    pieces: list[str] = []
    current = []
    for index, char in enumerate(text):
        current.append(char)
        next_char = text[index + 1] if index + 1 < len(text) else ""
        if char in ".?!" and (not next_char or next_char in {'"', "”", " "}):
            part = "".join(current).strip()
            if part:
                pieces.append(part)
            current = []
    tail = "".join(current).strip()
    if tail:
        pieces.append(tail)
    return pieces


def split_literal_chinese(text: str) -> list[str]:
    pieces: list[str] = []
    current = []
    for char in text:
        current.append(char)
        if char in "；。！？":
            part = "".join(current).strip()
            if part:
                pieces.append(part)
            current = []
    tail = "".join(current).strip()
    if tail:
        pieces.append(tail)
    return pieces


def load_verse_data(chapter_number: int, verse_ids: list[int]) -> dict:
    cmd = [
        "node",
        str(OUT / "extract_dhammapada_data.js"),
        f"--chapter={chapter_number}",
        f"--ids={','.join(str(verse_id) for verse_id in verse_ids)}",
    ]
    completed = subprocess.run(cmd, check=True, capture_output=True, text=True, encoding="utf-8")
    return json.loads(completed.stdout)


def draw_title_page(chapter_number: int, chapter_title: str, verse: dict, output_path: Path) -> None:
    image, draw = make_canvas()
    draw.text((96, 86), "DHAMMAPADA", font=font("sans", 28), fill=MUTED)
    draw.text((96, 170), f"Chapter {chapter_number} · {chapter_title}", font=font("serif", 44), fill=SOFT)
    draw.text((96, 242), f"Verse {verse['id']}", font=font("serif", 56), fill=SOFT)

    y = 328
    for line in wrap_text(draw, verse["title"], font("serif", 76), 920):
        draw.text((96, y), line, font=font("serif", 76), fill=TEXT)
        y += 84

    draw.text((96, y + 32), verse["titleZh"], font=font("zh_bold", 34), fill=SOFT)
    draw.text((96, y + 112), "一句英文，一句中文直译，后面接本页生词。", font=font("zh", 28), fill=MUTED)
    draw.text((96, y + 164), f"English voice: Microsoft {EN_VOICE}", font=font("sans", 32), fill=TEXT)
    draw.text((96, y + 212), f"Chinese voice: Microsoft {ZH_VOICE}", font=font("sans", 32), fill=TEXT)
    image.convert("RGB").save(output_path, quality=95)


def draw_sentence_page(chapter_number: int, chapter_title: str, verse: dict, sentence_index: int, english: str, chinese: str, output_path: Path) -> None:
    image, draw = make_canvas()
    header = f"Chapter {chapter_number} · {chapter_title} · Verse {verse['id']} · Sentence {sentence_index}"
    draw.text((96, 86), header, font=font("sans", 28), fill=MUTED)
    draw.text((96, 158), "English", font=font("sans", 32), fill=MUTED)

    block_top = 242
    block_bottom = 708
    chinese_label_gap = 36
    chinese_block_gap = 72
    layout = None
    for english_size in range(58, 37, -2):
        english_font = font("sans", english_size)
        english_lines = wrap_text(draw, english, english_font, 860)
        english_line_height = int(english_size * 1.28)
        english_height = len(english_lines) * english_line_height

        for chinese_size in range(44, 27, -2):
            chinese_font = font("zh_bold", chinese_size)
            chinese_lines = wrap_cjk(draw, chinese, chinese_font, 820)
            chinese_line_height = int(chinese_size * 1.52)
            chinese_height = len(chinese_lines) * chinese_line_height
            total_height = english_height + chinese_label_gap + chinese_block_gap + chinese_height
            if total_height <= (block_bottom - block_top):
                extra_space = (block_bottom - block_top) - total_height
                english_start_y = block_top + int(extra_space * 0.28)
                english_end = english_start_y + english_height
                chinese_label_y = english_end + chinese_label_gap
                chinese_start_y = chinese_label_y + chinese_block_gap
                layout = {
                    "english_font": english_font,
                    "english_lines": english_lines,
                    "english_line_height": english_line_height,
                    "english_start_y": english_start_y,
                    "chinese_font": chinese_font,
                    "chinese_lines": chinese_lines,
                    "chinese_line_height": chinese_line_height,
                    "chinese_label_y": chinese_label_y,
                    "chinese_start_y": chinese_start_y,
                }
                break
        if layout:
            break

    if not layout:
        english_font = font("sans", 38)
        chinese_font = font("zh_bold", 28)
        english_lines = wrap_text(draw, english, english_font, 860)
        chinese_lines = wrap_cjk(draw, chinese, chinese_font, 820)
        english_line_height = int(38 * 1.22)
        chinese_line_height = int(28 * 1.42)
        english_height = len(english_lines) * english_line_height
        layout = {
            "english_font": english_font,
            "english_lines": english_lines,
            "english_line_height": english_line_height,
            "english_start_y": 232,
            "chinese_font": chinese_font,
            "chinese_lines": chinese_lines,
            "chinese_line_height": chinese_line_height,
            "chinese_label_y": 232 + english_height + 24,
            "chinese_start_y": 232 + english_height + 86,
        }

    y = layout["english_start_y"]
    for line in layout["english_lines"]:
        draw.text((96, y), line, font=layout["english_font"], fill=TEXT)
        y += layout["english_line_height"]

    draw.text((96, layout["chinese_label_y"]), "中文直译", font=font("zh", 32), fill=MUTED)
    y = layout["chinese_start_y"]
    for line in layout["chinese_lines"]:
        draw.text((96, y), line, font=layout["chinese_font"], fill=TEXT)
        y += layout["chinese_line_height"]

    image.convert("RGB").save(output_path, quality=95)


def draw_vocab_page(chapter_number: int, chapter_title: str, verse: dict, vocab_index: int, vocab: dict, output_path: Path) -> None:
    image, draw = make_canvas()
    header = f"Chapter {chapter_number} · {chapter_title} · Verse {verse['id']} · Vocabulary {vocab_index}"
    draw.text((96, 86), header, font=font("sans", 28), fill=MUTED)
    draw.text((96, 170), vocab["word"], font=font("sans", 68), fill=TEXT)
    draw.text((96, 246), f"{vocab['meaning']}   {vocab['pos'].lower()}", font=font("zh", 28), fill=SOFT)

    draw.text((96, 344), "English", font=font("sans", 30), fill=MUTED)
    y = 408
    for line in wrap_text(draw, vocab.get("en", ""), font("sans", 48), 860):
        draw.text((96, y), line, font=font("sans", 48), fill=TEXT)
        y += 60

    draw.text((96, 536), "中文提醒", font=font("zh", 30), fill=MUTED)
    y = 596
    for line in wrap_cjk(draw, vocab["meaning"], font("zh", 38), 840):
        draw.text((96, y), line, font=font("zh", 38), fill=TEXT)
        y += 54

    draw.text((96, 724), "Example", font=font("sans", 30), fill=MUTED)
    y = 778
    for line in wrap_text(draw, vocab.get("example", ""), font("sans", 34), 1080):
        draw.text((96, y), line, font=font("sans", 34), fill=SOFT)
        y += 42

    image.convert("RGB").save(output_path, quality=95)


def write_text(path: Path, text: str) -> None:
    path.write_text(text, encoding="utf-8")


def build_prepare_outputs(chapter_number: int, verse_ids: list[int]) -> Path:
    data = load_verse_data(chapter_number, verse_ids)
    jobs: list[dict] = []

    for verse in data["verses"]:
        verse_slug = slugify(verse["title"])
        english_parts = split_english(verse["english"])
        chinese_parts = split_literal_chinese(verse["literalZh"])

        if len(english_parts) != len(chinese_parts):
            english_parts = [verse["english"]]
            chinese_parts = [verse["literalZh"]]

        title_path = OUT / f"verse-{verse['id']:03d}-page-01-title.png"
        draw_title_page(data["chapterNumber"], data["chapterTitle"], verse, title_path)

        for index, (english, chinese) in enumerate(zip(english_parts, chinese_parts), start=1):
            page_path = OUT / f"verse-{verse['id']:03d}-page-{index + 1:02d}-s{index}.png"
            draw_sentence_page(data["chapterNumber"], data["chapterTitle"], verse, index, english, chinese, page_path)

            en_text_path = OUT / f"verse-{verse['id']:03d}-s{index}-en.txt"
            zh_text_path = OUT / f"verse-{verse['id']:03d}-s{index}-zh.txt"
            en_wav_path = OUT / f"verse-{verse['id']:03d}-s{index}-en-david.wav"
            zh_wav_path = OUT / f"verse-{verse['id']:03d}-s{index}-zh-huihui.wav"
            write_text(en_text_path, english)
            write_text(zh_text_path, chinese)
            jobs.append({"voice": EN_VOICE, "rate": 0, "textFile": str(en_text_path), "outputFile": str(en_wav_path)})
            jobs.append({"voice": ZH_VOICE, "rate": 0, "textFile": str(zh_text_path), "outputFile": str(zh_wav_path)})

        for vocab_index, vocab in enumerate(verse["vocab"], start=1):
            page_path = OUT / f"verse-{verse['id']:03d}-page-{len(english_parts) + vocab_index + 1:02d}-v{vocab_index}.png"
            draw_vocab_page(data["chapterNumber"], data["chapterTitle"], verse, vocab_index, vocab, page_path)

            vocab_text = f"{vocab['word']}. {vocab.get('en', '')}. Example: {vocab.get('example', '')}"
            vocab_text_path = OUT / f"verse-{verse['id']:03d}-vocab{vocab_index}-en.txt"
            vocab_wav_path = OUT / f"verse-{verse['id']:03d}-vocab{vocab_index}-en-david.wav"
            write_text(vocab_text_path, vocab_text)
            jobs.append({"voice": EN_VOICE, "rate": 0, "textFile": str(vocab_text_path), "outputFile": str(vocab_wav_path)})

    manifest_path = OUT / "tts-manifest-verses.json"
    manifest_path.write_text(json.dumps(jobs, ensure_ascii=False, indent=2), encoding="utf-8")
    return manifest_path


def seconds_for_wav(path: Path) -> float:
    with wave.open(str(path), "rb") as wav_file:
        return wav_file.getnframes() / float(wav_file.getframerate())


def make_silence(params: wave._wave_params, duration: float) -> bytes:
    frames = int(params.framerate * duration)
    return b"\x00" * frames * params.nchannels * params.sampwidth


def build_audio_file(parts: list[Path | float], output_path: Path) -> None:
    first_wav = next(item for item in parts if isinstance(item, Path))
    with wave.open(str(first_wav), "rb") as base:
        params = base.getparams()

    with wave.open(str(output_path), "wb") as out_wav:
        out_wav.setparams(params)
        for item in parts:
            if isinstance(item, Path):
                with wave.open(str(item), "rb") as source:
                    source_params = source.getparams()
                    if (
                        source_params.nchannels != params.nchannels
                        or source_params.sampwidth != params.sampwidth
                        or source_params.framerate != params.framerate
                        or source_params.comptype != params.comptype
                    ):
                        raise ValueError(f"Audio format mismatch: {item.name}")
                    out_wav.writeframes(source.readframes(source.getnframes()))
            else:
                out_wav.writeframes(make_silence(params, float(item)))


def build_manifest(page_paths: list[Path], durations: list[float], output_path: Path) -> None:
    lines: list[str] = []
    for page_path, duration in zip(page_paths, durations):
        lines.append(f"file '{page_path.as_posix()}'")
        lines.append(f"duration {duration:.3f}")
    lines.append(f"file '{page_paths[-1].as_posix()}'")
    output_path.write_text("\n".join(lines) + "\n", encoding="utf-8")


def render_video(page_manifest: Path, audio_path: Path, video_path: Path) -> None:
    command = [
        "ffmpeg",
        "-y",
        "-f",
        "concat",
        "-safe",
        "0",
        "-i",
        str(page_manifest),
        "-i",
        str(audio_path),
        "-r",
        "30",
        "-c:v",
        "libx264",
        "-pix_fmt",
        "yuv420p",
        "-c:a",
        "aac",
        "-b:a",
        "192k",
        "-shortest",
        str(video_path),
    ]
    subprocess.run(command, check=True)


def build_render_outputs(chapter_number: int, verse_ids: list[int]) -> list[Path]:
    data = load_verse_data(chapter_number, verse_ids)
    rendered: list[Path] = []

    for verse in data["verses"]:
        verse_slug = slugify(verse["title"])
        english_parts = split_english(verse["english"])
        chinese_parts = split_literal_chinese(verse["literalZh"])
        if len(english_parts) != len(chinese_parts):
            english_parts = [verse["english"]]
            chinese_parts = [verse["literalZh"]]

        page_paths: list[Path] = [OUT / f"verse-{verse['id']:03d}-page-01-title.png"]
        durations: list[float] = [TITLE_HOLD]
        audio_parts: list[Path | float] = [TITLE_HOLD]

        for index, _ in enumerate(english_parts, start=1):
            page_paths.append(OUT / f"verse-{verse['id']:03d}-page-{index + 1:02d}-s{index}.png")
            en_wav = OUT / f"verse-{verse['id']:03d}-s{index}-en-david.wav"
            zh_wav = OUT / f"verse-{verse['id']:03d}-s{index}-zh-huihui.wav"
            duration = seconds_for_wav(en_wav) + EN_GAP + seconds_for_wav(zh_wav) + ZH_GAP
            durations.append(duration)
            audio_parts.extend([en_wav, EN_GAP, zh_wav, ZH_GAP])

        for vocab_index, _ in enumerate(verse["vocab"], start=1):
            page_paths.append(OUT / f"verse-{verse['id']:03d}-page-{len(english_parts) + vocab_index + 1:02d}-v{vocab_index}.png")
            vocab_wav = OUT / f"verse-{verse['id']:03d}-vocab{vocab_index}-en-david.wav"
            duration = seconds_for_wav(vocab_wav) + VOCAB_GAP
            durations.append(duration)
            audio_parts.extend([vocab_wav, VOCAB_GAP])

        audio_path = OUT / f"verse-{verse['id']:03d}-audio.wav"
        manifest_path = OUT / f"verse-{verse['id']:03d}-pages.txt"
        video_path = OUT / f"verse-{verse['id']:03d}-{verse_slug}.mp4"

        build_audio_file(audio_parts, audio_path)
        build_manifest(page_paths, durations, manifest_path)
        render_video(manifest_path, audio_path, video_path)
        rendered.append(video_path)

    return rendered


def main() -> None:
    parser = argparse.ArgumentParser()
    parser.add_argument("mode", choices=["prepare", "render"])
    parser.add_argument("--chapter", type=int, default=1)
    parser.add_argument("verse_ids", nargs="+", type=int)
    args = parser.parse_args()

    if args.mode == "prepare":
        manifest = build_prepare_outputs(args.chapter, args.verse_ids)
        print(f"Prepared TTS manifest: {manifest}")
        return

    rendered = build_render_outputs(args.chapter, args.verse_ids)
    for item in rendered:
        print(f"Rendered: {item}")


if __name__ == "__main__":
    main()
