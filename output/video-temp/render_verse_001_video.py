from __future__ import annotations

import math
import subprocess
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


VERSE = {
    "id": 1,
    "chapter_number": 1,
    "chapter_title": "The Pairs",
    "title": "Mind leads everything",
    "pages": [
        {
            "kind": "sentence",
            "name": "s1",
            "label": "Sentence 1",
            "english": "Mind precedes all mental states.",
            "chinese": "心是一切心理状态的前导。",
            "audio": ["verse-001-s1-en-david.wav", 0.30, "verse-001-s1-zh-huihui.wav", 0.60],
        },
        {
            "kind": "sentence",
            "name": "s2",
            "label": "Sentence 2",
            "english": "Mind is their chief; they are all mind-wrought.",
            "chinese": "心是主，它们都是由心所造。",
            "audio": ["verse-001-s2-en-david.wav", 0.30, "verse-001-s2-zh-huihui.wav", 0.60],
        },
        {
            "kind": "sentence",
            "name": "s3",
            "label": "Sentence 3",
            "english": (
                "If with an impure mind a person speaks or acts, "
                "suffering follows him like the wheel that follows the foot of the ox."
            ),
            "chinese": "若一个人以染污的心说话或行动，苦就跟随他，如同车轮跟着牛足。",
            "audio": ["verse-001-s3-en-david.wav", 0.30, "verse-001-s3-zh-huihui.wav", 0.70],
        },
        {
            "kind": "vocab",
            "name": "v1",
            "word": "precede",
            "pos": "verb",
            "zh": "在前面，先于某事发生",
            "en": "to come or happen before something else",
            "example": "A feeling of doubt often precedes a hard decision.",
            "audio": ["verse-001-vocab1-en-david.wav", 0.80],
        },
        {
            "kind": "vocab",
            "name": "v2",
            "word": "impure",
            "pos": "adj",
            "zh": "不纯净的；这里也可指不诚实、动机不正、道德上不清明",
            "en": "not clean, honest, or morally clear",
            "example": "An impure motive can quietly spoil a good action.",
            "audio": ["verse-001-vocab2-en-david.wav", 0.80],
        },
        {
            "kind": "vocab",
            "name": "v3",
            "word": "mind-wrought",
            "pos": "adj",
            "zh": "由心形成的，由心造出来的",
            "en": "formed, shaped, or produced by the mind",
            "example": "Much of his fear was mind-wrought rather than real.",
            "audio": ["verse-001-vocab3-en-david.wav", 0.90],
        },
    ],
}


FONTS = {
    "sans": str(Path("C:/Windows/Fonts/arial.ttf")),
    "serif": str(Path("C:/Windows/Fonts/georgia.ttf")),
    "zh": str(Path("C:/Windows/Fonts/msyh.ttc")),
    "zh_bold": str(Path("C:/Windows/Fonts/msyhbd.ttc")),
}


def font(kind: str, size: int) -> ImageFont.FreeTypeFont:
    return ImageFont.truetype(FONTS[kind], size=size)


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
    draw.rounded_rectangle((92, 90, WIDTH - 92, HEIGHT - 90), radius=0, fill=CARD, outline=None)
    draw.line((94, 126, 734, 126), fill=LINE, width=2)
    draw.line((94, HEIGHT - 144, WIDTH - 94, HEIGHT - 144), fill=LINE, width=2)

    illustration = OUT / "verse-001-illustration.png"
    if illustration.exists():
        art = Image.open(illustration).convert("RGBA")
        art.thumbnail((600, 660))
        alpha = art.getchannel("A").point(lambda v: int(v * 0.55))
        art.putalpha(alpha)
        image.alpha_composite(art, dest=(880, 110))

    return image, draw


def draw_title_page(path: Path) -> None:
    image, draw = make_canvas()
    draw.text((96, 86), "DHAMMAPADA", font=font("sans", 28), fill=MUTED)
    draw.text((96, 170), "Verse 1", font=font("serif", 56), fill=SOFT)
    draw.text((96, 248), VERSE["title"], font=font("serif", 88), fill=TEXT)
    draw.text((96, 388), "一句一句读：先英文，再中文直译", font=font("zh_bold", 34), fill=SOFT)
    draw.text((96, 448), "最后接本页生词，方便直接拿去做短视频。", font=font("zh", 28), fill=MUTED)
    draw.text((96, 520), "English voice: Microsoft David", font=font("sans", 34), fill=TEXT)
    draw.text((96, 572), "Chinese voice: Microsoft Huihui", font=font("sans", 34), fill=TEXT)
    draw.text((96, 664), "Format: English sentence + Chinese line on one page", font=font("sans", 28), fill=MUTED)
    draw.text((96, 712), "Ending: vocabulary cards from the webpage notes", font=font("sans", 28), fill=MUTED)
    image.convert("RGB").save(path, quality=95)


def draw_sentence_page(page: dict, path: Path) -> None:
    image, draw = make_canvas()
    header = f"Chapter {VERSE['chapter_number']} · {VERSE['chapter_title']} · Verse {VERSE['id']} · {page['label']}"
    draw.text((96, 86), header, font=font("sans", 28), fill=MUTED)
    draw.text((96, 158), "English", font=font("sans", 32), fill=MUTED)

    y = 242
    for line in wrap_text(draw, page["english"], font("sans", 58), 860):
        draw.text((96, y), line, font=font("sans", 58), fill=TEXT)
        y += 74

    draw.text((96, max(430, y + 28)), "中文直译", font=font("zh", 32), fill=MUTED)

    y = max(520, y + 118)
    for line in wrap_cjk(draw, page["chinese"], font("zh_bold", 44), 820):
        draw.text((96, y), line, font=font("zh_bold", 44), fill=TEXT)
        y += 66

    image.convert("RGB").save(path, quality=95)


def draw_vocab_page(page: dict, path: Path) -> None:
    image, draw = make_canvas()
    draw.text((96, 86), "Vocabulary", font=font("sans", 30), fill=MUTED)
    draw.text((96, 170), page["word"], font=font("sans", 68), fill=TEXT)
    draw.text((96, 246), f"{page['zh']}   {page['pos']}", font=font("zh", 28), fill=SOFT)

    draw.text((96, 344), "English", font=font("sans", 30), fill=MUTED)
    y = 408
    for line in wrap_text(draw, page["en"], font("sans", 48), 860):
        draw.text((96, y), line, font=font("sans", 48), fill=TEXT)
        y += 60

    draw.text((96, 536), "中文提醒", font=font("zh", 30), fill=MUTED)
    y = 596
    for line in wrap_cjk(draw, page["zh"], font("zh", 38), 840):
        draw.text((96, y), line, font=font("zh", 38), fill=TEXT)
        y += 54

    draw.text((96, 724), "Example", font=font("sans", 30), fill=MUTED)
    example_lines = wrap_text(draw, page["example"], font("sans", 34), 1080)
    y = 778
    for line in example_lines:
        draw.text((96, y), line, font=font("sans", 34), fill=SOFT)
        y += 42

    image.convert("RGB").save(path, quality=95)


def seconds_for_wav(path: Path) -> float:
    with wave.open(str(path), "rb") as wav_file:
        return wav_file.getnframes() / float(wav_file.getframerate())


def make_silence(params: wave._wave_params, duration: float) -> bytes:
    frames = int(params.framerate * duration)
    return b"\x00" * frames * params.nchannels * params.sampwidth


def build_audio(output_path: Path) -> list[float]:
    clips: list[Path | float] = [1.60]
    page_durations: list[float] = [1.60]
    for page in VERSE["pages"]:
        total = 0.0
        for item in page["audio"]:
            if isinstance(item, str):
                wav_path = OUT / item
                clips.append(wav_path)
                total += seconds_for_wav(wav_path)
            else:
                clips.append(item)
                total += float(item)
        page_durations.append(total)

    first_wav = next(item for item in clips if isinstance(item, Path))
    with wave.open(str(first_wav), "rb") as base:
        params = base.getparams()

    with wave.open(str(output_path), "wb") as out_wav:
        out_wav.setparams(params)
        for item in clips:
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

    return page_durations


def build_pages() -> list[Path]:
    pages: list[Path] = []
    title_path = OUT / "verse-001-v7-page-01-title.png"
    draw_title_page(title_path)
    pages.append(title_path)

    for index, page in enumerate(VERSE["pages"], start=2):
        path = OUT / f"verse-001-v7-page-{index:02d}-{page['name']}.png"
        if page["kind"] == "sentence":
            draw_sentence_page(page, path)
        else:
            draw_vocab_page(page, path)
        pages.append(path)

    return pages


def build_manifest(page_paths: list[Path], page_durations: list[float], manifest_path: Path) -> None:
    lines: list[str] = []
    for page_path, duration in zip(page_paths, page_durations):
        lines.append(f"file '{page_path.as_posix()}'")
        lines.append(f"duration {duration:.3f}")
    lines.append(f"file '{page_paths[-1].as_posix()}'")
    manifest_path.write_text("\n".join(lines) + "\n", encoding="utf-8")


def render_video(manifest_path: Path, audio_path: Path, video_path: Path) -> None:
    command = [
        "ffmpeg",
        "-y",
        "-f",
        "concat",
        "-safe",
        "0",
        "-i",
        str(manifest_path),
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


def main() -> None:
    page_paths = build_pages()
    audio_path = OUT / "verse-001-v7-audio.wav"
    manifest_path = OUT / "verse-001-v7-pages.txt"
    video_path = OUT / "verse-001-mind-leads-everything-v7.mp4"

    page_durations = build_audio(audio_path)
    build_manifest(page_paths, page_durations, manifest_path)
    render_video(manifest_path, audio_path, video_path)

    total = sum(page_durations)
    print(f"Rendered: {video_path}")
    print(f"Duration: {total:.2f}s")


if __name__ == "__main__":
    main()
