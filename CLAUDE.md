# CLAUDE.md — CardPay Suite

## Project Overview

**CardPay Suite** is an educational web app that teaches payment-processing concepts (ISO 8583, EMV TLV, transaction lifecycle) through interactive simulators, developer tools, and a built-in AI guide. It is **not** a real payment processor — all "transactions" are simulated client-side or proxied to read-only lookup APIs.

- **Audience:** developers, students, and fintech enthusiasts learning card-payment standards.
- **Current version:** `v1.0.0-beta` (see `includes/footer.php`).
- **License:** none specified.

## Technology Stack

- **Backend:** Plain procedural PHP (no framework, no Composer, no autoloader).
- **Frontend:** Vanilla HTML + CSS (custom properties, glassmorphism) + vanilla JS (no jQuery/React/Vue).
- **External APIs:**
  - **Groq** (`api.groq.com`) — chat completions, used by the in-app AI guide. Models tried in order: `llama-3.1-8b-instant` → `llama3-8b-8192` → `mixtral-8x7b-32768`.
  - **GNews** (`gnews.io`) — fintech news feed with 20-minute file cache.
  - **HandyAPI** (`data.handyapi.com`) — BIN → issuer/network lookup.
- **CDN assets:** Font Awesome 6, Google Fonts (Inter).
- **Deployment:** GitHub Actions (`.github/workflows/auto-update.yml`) — wipes everything except `.github/` and `updates/`, then moves `updates/*` into repo root.

## Folder Structure

```
CardPaySuite/
├── index.php            # Home: hero + interactive transaction simulator
├── news.php             # GNews-backed fintech news radar
├── ai-proxy.php         # Server-side proxy → Groq chat
├── bin-proxy.php        # Server-side proxy → HandyAPI BIN lookup
├── config.php           # Loads groq_api_key from env
│
├── includes/
│   ├── header.php       # Shared <head> + sticky nav
│   └── footer.php       # Shared footer + global AI guide widget markup/CSS
│
├── docs/                # Learning Center (static PHP pages)
│   ├── index.php
│   ├── transaction-lifecycle.php
│   ├── iso8583.php
│   ├── emv-tlv.php
│   └── glossary.php
│
├── tools/               # Developer utilities (6 tools + hub)
│   ├── index.php
│   ├── iso8583-parser.php
│   ├── bin-lookup.php
│   ├── tlv.php
│   ├── card-generator.php
│   ├── base64.php
│   └── luhn.php
│
├── assets/
│   ├── css/{style,simulator,ai-guide}.css
│   ├── js/{simulator,ai-guide}.js
│   └── img/cards/       # Visa, MC, Amex, Discover, JCB, Diners SVGs
│
├── data/
│   └── emv-tags.json    # EMV TLV tag reference (used by tools/tlv.php)
│
├── cache/
│   └── news.json        # Generated at runtime; 20-min GNews cache
│
└── .github/workflows/
    └── auto-update.yml  # Deployment: replaces files from `updates/` dir
```

## Entry Points

| URL path | File | Role |
|---|---|---|
| `/` | `index.php` | Hero + transaction simulator (flagship feature) |
| `/news.php` | `news.php` | Cached GNews feed |
| `/tools/index.php` | `tools/index.php` | Hub for 6 developer tools |
| `/docs/index.php` | `docs/index.php` | Learning Center |
| `POST /ai-proxy.php` | `ai-proxy.php` | Chat proxy to Groq |
| `GET /bin-proxy.php?bin=…` | `bin-proxy.php` | BIN lookup proxy |

## Database Usage

**There is no database.** The app is fully stateless. Persistence is only:

- `cache/news.json` — file-based 20-min cache for the GNews API.
- `data/emv-tags.json` — static lookup data for the TLV tool.
- `config.php` — env-backed runtime config.

## Configuration

`config.php` reads one env var:

```php
$ai_config = array(
    'groq_api_key' => getenv('groq_api_key')
);
```

Set the `groq_api_key` environment variable in the hosting environment. Without it, `ai-proxy.php` short-circuits with a "Configuration Error" JSON response.

## Conventions & Code Style

- **PHP style:** procedural, uses `array(...)` literal syntax (not `[]`), uses `isset()` + null-coalescing via ternary rather than `??`. Match this style when adding PHP.
- **Includes:** every page does `<?php include 'includes/header.php'; ?>` at top and `<?php include 'includes/footer.php'; ?>` at bottom. The footer injects the AI guide widget HTML on every page; do not duplicate it.
- **CSS architecture:** theme tokens live in `assets/css/style.css` under `:root` (e.g. `--accent-primary`, `--glass-bg`, `--text-bright`). Reuse these tokens — do not hardcode colors elsewhere.
- **Class patterns:** `glass-panel` for frosted cards, `text-gradient` for hero headings, `btn-primary` / `btn-console` for buttons, `.container` for max-width 1200px layout.
- **JavaScript:** DOMContentLoaded wrappers, null-checked updaters (see the `updateUI` / `updateClass` helpers in `simulator.js`). No bundler — `<script src="...">` tags inline at the bottom of pages.
- **No build step.** Edit files directly; refresh the browser.
- **No tests, no linter, no CI lint** beyond the deploy workflow.

## Important / Frequently-Edited Files

1. `index.php` — flagship simulator markup.
2. `assets/js/simulator.js` — simulator state machine + safe DOM updater pattern.
3. `ai-proxy.php` — Groq bridge with model fallback loop.
4. `news.php` — cache-or-fetch pattern for GNews.
5. `bin-proxy.php` — HandyAPI proxy.
6. `tools/index.php` — tools hub grid.
7. `data/emv-tags.json` — TLV reference data.
8. `includes/header.php`, `includes/footer.php` — global chrome; footer also injects the AI guide widget.
9. `assets/css/style.css` — design tokens (`:root`).

## Things to Watch Out For

- **Hardcoded secret in source:** `news.php` line 23 contains a GNews API key as a string literal. Move it to `config.php` alongside `groq_api_key` and read from env like the other secret.
- **No `.gitignore` exists.** `error_log` (root and `tools/`) and `cache/news.json` are committed. Add `.gitignore` covering `error_log`, `cache/*.json`, and any local dev artifacts.
- **AI guide is global:** the widget is in `includes/footer.php`, so any change to its markup/CSS affects every page on the site.
- **API key required at runtime:** the AI guide widget will respond with error JSON if `groq_api_key` env var is not set on the host.
- **CORS:** `ai-proxy.php` and `bin-proxy.php` both return `Access-Control-Allow-Origin: *` — they are intentionally callable cross-origin (e.g. from a static frontend or a different domain). Keep that header unless you intentionally want to lock them down.
- **`updates/` directory** is referenced by the deploy workflow but doesn't exist in the repo — the workflow expects to copy its contents into root on deploy. Don't commit it unless you're explicitly staging a release.
- **Magic numbers in `simulator.js`** (timeouts, MTI codes, response codes) are hardcoded; treat them as the source of truth for the simulated transaction flow.

## Quick Tasks Cheat Sheet

- **Add a new developer tool:** create `tools/<name>.php` mirroring the structure of `tools/luhn.php` or `tools/tlv.php` (header include at top, footer at bottom, inline CSS/JS, self-contained logic), then add a `<div class="tool-card">` entry to `tools/index.php`.
- **Add a Learning Center page:** drop a new `docs/<slug>.php` with header/footer includes, then add it to the sidebar nav in `docs/index.php` (and any sibling `docs/*.php` files that have their own copy of the sidebar).
- **Tweak the simulator flow:** edit `index.php` for markup and `assets/js/simulator.js` for the timing/flow messages. The `updateUI` and `updateClass` helpers are the safe way to mutate DOM.
- **Change AI behavior:** edit the `$systemPrompt` in `ai-proxy.php` (line 46) and/or the `model_attempts` array (lines 29–33).
- **Change theme colors:** edit `:root` in `assets/css/style.css` only. All other CSS reads from those variables.
