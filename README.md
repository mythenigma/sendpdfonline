# sendpdfonline

Static website content for `sendpdfonline.com` (documentation + SEO pages) around **MaiPDF / MaiImg** workflows:

- **Share PDFs as links / QR codes**
- **Access control** (view limits, expiration, revoke)
- **Security/DRM messaging** (no print/download, anti-forwarding)
- **Replace PDF without changing the link**
- **Tracking & “Read Alerts via Telegram”** (notify the owner when a reading link is opened)
- **MaiImg image hosting & sharing guides**

This repo is mainly **HTML + images**. There is no single “app” to run; pages are served as static files.

## Repo structure (high level)

- **`index.html`**: main landing page
- **`article/`**: long-form articles / guides
- **`features/`**: feature pages (EN/ZH)
- **`usecase/`**: use-case landing pages
- **`maiimg-articles/`**: MaiImg guides (image hosting/sharing)
- **`images/`**: image assets used by pages
  - **`images/maipdf2026/`**: curated 2026 screenshot/asset set
  - **`images/maipdf2026/show_off/`**: decorative “hero/marketing” graphics (not UI screenshots)
- **`maipdf-flowcharts/`**: reusable SVG flowcharts for articles
- **`work.html`**: internal work panel / knowledge base (not for indexing)

## Local preview

Any static HTTP server works. Example with Python:

```bash
python -m http.server 8000
```

Then open:

- `http://localhost:8000/`
- or a specific page path, e.g. `http://localhost:8000/article/share-pdf-online.html`

## Content conventions

- **Avoid spaces in asset filenames**: spaces are easy to break on CDNs/URLs if not encoded.
- **Prefer `.webp` for hero images**: smaller payload, good quality.
- **Use consistent product terms** (EN):
  - Feature name: **Read Alerts** (avoid “ReadNotify / Read Notify” variations)
  - Telegram binding button text: **Add Bot** (keep consistent across pages)

## License

All rights reserved unless noted otherwise.

