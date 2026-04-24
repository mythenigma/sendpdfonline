from __future__ import annotations

import argparse
import json
import re
from pathlib import Path

import pythoncom
import win32com.storagecon as sc


ROOT_OPEN_FLAG = sc.STGM_READ | sc.STGM_SHARE_DENY_WRITE
CHILD_OPEN_FLAG = sc.STGM_READ | sc.STGM_SHARE_EXCLUSIVE


PROP_MAP = {
    "message_class": "__substg1.0_001A001F",
    "subject": "__substg1.0_0037001F",
    "transport_headers": "__substg1.0_007D001F",
    "sender_name": "__substg1.0_0C1A001F",
    "sender_exchange_type": "__substg1.0_0C1E001F",
    "sender_email": "__substg1.0_5D02001F",
    "reply_to_name": "__substg1.0_0042001F",
    "reply_to_email": "__substg1.0_5D07001F",
    "reply_to_email_2": "__substg1.0_5D08001F",
    "to_display": "__substg1.0_0E04001F",
    "cc_display": "__substg1.0_0E03001F",
    "bcc_display": "__substg1.0_0E02001F",
    "body": "__substg1.0_1000001F",
}


def read_all(stream) -> bytes:
    chunks: list[bytes] = []
    while True:
        chunk = stream.Read(65536)
        if not chunk:
            break
        chunks.append(chunk)
        if len(chunk) < 65536:
            break
    return b"".join(chunks)


def read_unicode_stream(storage, name: str) -> str | None:
    try:
        stream = storage.OpenStream(name, None, CHILD_OPEN_FLAG)
    except Exception:
        return None
    data = read_all(stream)
    return data.decode("utf-16le", errors="ignore").rstrip("\x00")


def read_stream_names(storage) -> list[tuple[str, int]]:
    return [(stat[0], stat[1]) for stat in storage.EnumElements()]


def open_storage(parent, name: str):
    return parent.OpenStorage(name, None, CHILD_OPEN_FLAG, None, 0)


def extract_recipients(root_storage) -> list[dict]:
    recipients: list[dict] = []
    for name, stype in read_stream_names(root_storage):
        if stype != 1 or not name.startswith("__recip_version1.0_"):
            continue
        recip_storage = open_storage(root_storage, name)
        recipients.append(
            {
                "storage": name,
                "display_name": read_unicode_stream(recip_storage, "__substg1.0_3001001F"),
                "address_type": read_unicode_stream(recip_storage, "__substg1.0_3002001F"),
                "email_address": read_unicode_stream(recip_storage, "__substg1.0_3003001F"),
                "smtp_address": read_unicode_stream(recip_storage, "__substg1.0_39FE001F"),
                "display_type_name": read_unicode_stream(recip_storage, "__substg1.0_39FF001F"),
            }
        )
    return recipients


def extract_attachments(root_storage) -> list[dict]:
    attachments: list[dict] = []
    for name, stype in read_stream_names(root_storage):
        if stype != 1 or not name.startswith("__attach_version1.0_"):
            continue
        att_storage = open_storage(root_storage, name)
        attachments.append(
            {
                "storage": name,
                "filename": read_unicode_stream(att_storage, "__substg1.0_3704001F"),
                "long_filename": read_unicode_stream(att_storage, "__substg1.0_3707001F"),
                "mime_tag": read_unicode_stream(att_storage, "__substg1.0_370E001F"),
                "content_id": read_unicode_stream(att_storage, "__substg1.0_3712001F"),
            }
        )
    return attachments


def normalize_body(text: str) -> str:
    text = text.replace("\r\n", "\n").replace("\r", "\n")
    text = text.replace("\u00a0", " ")
    text = re.sub(r"[ \t]+\n", "\n", text)
    text = re.sub(r"\n{3,}", "\n\n", text)
    return text.strip()


def parse_thread_sections(body: str) -> list[dict]:
    body = normalize_body(body)
    matches = list(re.finditer(r"(?m)^From:\s", body))
    sections: list[dict] = []

    if not matches:
        return [{"kind": "top_message", "body": body}]

    top_body = body[: matches[0].start()].strip()
    if top_body:
        sections.append({"kind": "top_message", "body": top_body})

    for index, match in enumerate(matches):
        start = match.start()
        end = matches[index + 1].start() if index + 1 < len(matches) else len(body)
        chunk = body[start:end].strip()
        lines = chunk.splitlines()
        parsed = {"kind": "quoted_message", "raw": chunk}

        header_limit = 0
        for i, line in enumerate(lines):
            if not line.strip():
                header_limit = i
                break
        else:
            header_limit = min(len(lines), 6)

        header_lines = lines[:header_limit]
        body_lines = lines[header_limit + 1 :] if header_limit < len(lines) else []
        for line in header_lines:
            if ":" not in line:
                continue
            key, value = line.split(":", 1)
            key = key.strip().lower().replace(" ", "_")
            parsed[key] = value.strip()

        parsed["body"] = "\n".join(body_lines).strip() if body_lines else ""
        sections.append(parsed)

    return sections


def extract_msg(path: Path) -> dict:
    storage = pythoncom.StgOpenStorage(str(path), None, ROOT_OPEN_FLAG, None, 0)
    result = {
        "path": str(path),
        "file_name": path.name,
        "properties": {},
    }

    for key, stream_name in PROP_MAP.items():
        result["properties"][key] = read_unicode_stream(storage, stream_name)

    body = result["properties"].get("body") or ""
    result["body_clean"] = normalize_body(body)
    result["thread_sections"] = parse_thread_sections(body)
    result["recipients"] = extract_recipients(storage)
    result["attachments"] = extract_attachments(storage)
    return result


def render_text(data: dict) -> str:
    props = data["properties"]
    lines = [
        f"File: {data['file_name']}",
        f"Path: {data['path']}",
        "",
        "Basic Info",
        f"Subject: {props.get('subject') or ''}",
        f"Message Class: {props.get('message_class') or ''}",
        f"Sender: {props.get('sender_name') or ''} <{props.get('sender_email') or ''}>",
        f"Reply-To: {props.get('reply_to_name') or ''} <{props.get('reply_to_email') or props.get('reply_to_email_2') or ''}>",
        f"To: {props.get('to_display') or ''}",
        f"Cc: {props.get('cc_display') or ''}",
        f"Bcc: {props.get('bcc_display') or ''}",
        "",
        "Recipients",
    ]

    for recip in data["recipients"]:
        lines.append(
            f"- {recip.get('display_name') or ''} | {recip.get('email_address') or ''} | smtp={recip.get('smtp_address') or ''}"
        )

    lines.extend(["", "Attachments"])
    if data["attachments"]:
        for attachment in data["attachments"]:
            lines.append(
                f"- {attachment.get('long_filename') or attachment.get('filename') or attachment.get('storage')}"
            )
    else:
        lines.append("- None found")

    lines.extend(["", "Latest + Full Thread Body", "", data["body_clean"], "", "Thread Sections"])

    for index, section in enumerate(data["thread_sections"], start=1):
        lines.append("")
        lines.append(f"[Section {index}] {section.get('kind', '')}")
        for key in ["from", "sent", "to", "cc", "subject"]:
            if section.get(key):
                lines.append(f"{key.title()}: {section[key]}")
        lines.append("")
        lines.append(section.get("body") or "")

    headers = props.get("transport_headers")
    if headers:
        lines.extend(["", "Transport Headers", "", normalize_body(headers)])

    return "\n".join(lines).strip() + "\n"


def main() -> None:
    parser = argparse.ArgumentParser()
    parser.add_argument("msg_path")
    parser.add_argument("--out-dir", default="")
    args = parser.parse_args()

    msg_path = Path(args.msg_path)
    out_dir = Path(args.out_dir) if args.out_dir else msg_path.parent
    out_dir.mkdir(parents=True, exist_ok=True)

    data = extract_msg(msg_path)
    stem = msg_path.stem
    json_path = out_dir / f"{stem}.structured.json"
    txt_path = out_dir / f"{stem}.structured.txt"

    json_path.write_text(json.dumps(data, ensure_ascii=False, indent=2), encoding="utf-8")
    txt_path.write_text(render_text(data), encoding="utf-8")

    print(json.dumps({"json": str(json_path), "txt": str(txt_path)}, ensure_ascii=False))


if __name__ == "__main__":
    main()
