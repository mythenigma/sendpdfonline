# MaiImg article assets — `static-images/` guide

**Purpose:** Describe every file under `maiimg-articles/static-images/` so writers and developers pick the right screenshot or diagram. **MaiImg** (English product name) is **麦瓜图床** in Chinese.

**Language note:** Folders `common/` and `diagram/` are preferred for **English** articles. Files under `cn/` often contain **Chinese UI or marketing copy** — still usable in EN pages with a short caption (e.g. “Chinese-language interface shown”).

---

## `common/` — product UI & outcomes

| File | What it shows (use in articles) |
|------|----------------------------------|
| `maiimg-head.png` | Header / branding strip for MaiImg; good **OG / social preview** hero. |
| `maiimg-setting.png` | Settings panel (limits, security-related options). Use for **access control**, **best practices**, **expiration** topics. |
| `image_result.png` | Post-upload screen: **share link + QR** style result. Step 2 in “how it works”. |
| `result_tracking.png` | **Analytics / view tracking** or management view after sharing. Step 3 or “know who opened”. |

## `common/show/` — marketing & workflow stills

| File | What it shows |
|------|----------------|
| `upload.jpg` | **Upload / drag-and-drop** flow visual; Step 1. |
| `sharegallery.png` | **Gallery-style sharing**; social / portfolio context. |
| `sharemaiimg.png` | **Sharing MaiImg** (link copy / distribution); email & social sections. |
| `sharesmarter.jpg` | “Share smarter” style creative; **email without attachments**, efficiency narrative. |
| `sharewithacharacter.png` | Character/mascot + share messaging; **light tone**, social posts. |
| `limtandexpirtion.png` | **Limits & expiration** UI emphasis; security / best practices. |

## `cn/` — Chinese UI strings (caption when used in EN)

| File | What it shows |
|------|----------------|
| `麦瓜二维码首页.png` | Chinese homepage / QR entry — **QR landing** context. |
| `生成结果.png` | **Generation result** screen (Chinese labels); alternative to `common/image_result.png`. |
| `一键删除图片.png` | **One-click delete** confirmation flow. |
| `设置打开次数.png` | **Set open count / view limit** (Chinese UI). |
| `删除时候确认.png` | **Delete confirmation** dialog. |

### `cn/宣传/` — Chinese promo art (JPEG)

| File | Typical use |
|------|-------------|
| `麦瓜.png` | Brand / mascot artwork. |
| `带人物.png` | People + product messaging. |
| `扫码分享.jpg` | **Scan QR to share** scene. |
| `微信发.jpg` | **WeChat-style** “send in chat” visual (Chinese copy). |
| `谁看了清楚.jpg` | **Who viewed** / analytics messaging. |
| `图片你自己定规则.jpg` | **You set the rules** (permissions) messaging. |

## `diagram/` — SVG diagrams (English-friendly)

| File | Topic |
|------|--------|
| `image-sharing-workflow-diagram.svg` | End-to-end **upload → link/QR → share → track** (general hosting guide). |
| `best-free-image-hosting-sites-2025.svg` | **Hosting landscape / comparison** narrative. |
| `best-free-online-photo-storage-solutions-2025.svg` | **Storage vs sharing** / cloud angles. |
| `channel-distribution-matrix.svg` | **Channels** (email, social, QR, etc.). |
| `security-control-flow.svg` | **Security and control** flow (limits, revoke, tracking). |
| `event-photo-runbook.svg` | **Events** (booth, run-of-show photo sharing). |
| `artist-portfolio-sharing-guide.svg` | **Creatives / portfolio** delivery. |
| `client-gallery-delivery.svg` | **Client proofing / gallery** handoff. |
| `automotive-photo-sharing-guide.svg` | **Automotive** (dealer, vehicle photos) scenario. |
| `airdrop-alternative-reliable-photo-sharing.svg` | **Airdrop / local transfer** alternative — reliable link sharing. |

---

## Absolute URLs (production)

Use on `sendpdfonline.com`:

`https://sendpdfonline.com/maiimg-articles/static-images/<path>`

Example:

`https://sendpdfonline.com/maiimg-articles/static-images/common/show/upload.jpg`

---

## Maintenance

- When replacing screenshots, keep **filenames stable** or update this file and all HTML references.
- Prefer **WebP/PNG** for UI; existing **JPG** promos are fine for hero/inline.
- Last reviewed: **2026-03-02**.
