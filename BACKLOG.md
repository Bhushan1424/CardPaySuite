# CardPay Suite — Feature Backlog

A prioritized list of features that would make CardPay Suite a more complete **fintech learning** platform.
Work through it one item at a time. Each item has a scope, the *why it matters* for learners, an effort
estimate, and a priority score so we can sequence the work.

**Scoring**
- **Impact** (1–5): how much it improves the learning experience.
- **Effort** (S / M / L): S = a few hours, M = 1–2 days, L = multi-day.
- **Priority** = derived from high impact ÷ low effort. P0 = do first, P3 = nice-to-have.

Status legend: ⬜ Not started · 🚧 In progress · ✅ Done

---

## P0 — High impact, low/medium effort (do first)

| # | Feature | Why it matters | Impact | Effort | Status |
|---|---------|----------------|:------:|:------:|:------:|
| 1 | **Quizzes / knowledge checks** per Learn topic (ISO 8583, EMV, lifecycle, ISO 20022). Multiple-choice, instant feedback, score at end. Store progress in `localStorage`. | A learning site with no way to *test* retention is just a reference. Highest-leverage gap. | 5 | M | ⬜ |
| 2 | **Site-wide search** across docs + tools (client-side index, no backend needed). | Users can't find content as the site grows past ~15 pages. | 4 | M | ⬜ |
| 3 | **Missing core Learn topics** — one page each: 3-D Secure / SCA, Tokenization (network + PCI), Authorization vs Clearing vs Settlement, Chargebacks & Disputes, Interchange & fees. | These are the concepts learners actually get asked about; currently absent. | 5 | M | ⬜ |
| 4 | **Copy-to-clipboard + shareable deep links** on every tool output. | Removes friction; tools become sharable teaching artifacts. | 3 | S | ⬜ |
| 5 | **SEO + social meta** (per-page `<title>`, `<meta description>`, Open Graph, `sitemap.xml`, `robots.txt`). All pages currently share `<title>Card Pay Suite</title>`. | Discoverability — a learning site nobody finds teaches nobody. | 4 | S | ⬜ |

---

## P1 — High impact, more effort (do next)

| # | Feature | Why it matters | Impact | Effort | Status |
|---|---------|----------------|:------:|:------:|:------:|
| 6 | **Guided learning paths** — ordered curriculum ("Payments 101 → Card Data → Messaging → Security") with a progress bar. | Turns a pile of pages into a course; drives completion. | 4 | M | ⬜ |
| 7 | **Interactive ISO 8583 message builder** — build a message field-by-field and watch the bitmap + hex assemble live (inverse of the existing parser). | Best way to *understand* the format is to construct one. | 4 | L | ⬜ |
| 8 | **Cryptography tool pack** — PIN block (ISO 9564 formats 0–4), ARQC/cryptogram concept explainer, CVV/CVC generator+validator, MAC calc. Clearly labeled *educational / test-key only*. | Core payments-security skills with no free interactive tools elsewhere. | 4 | L | ⬜ |
| 9 | **Reference lookups** — MCC codes, ISO 4217 currency codes, ISO 3166 country codes, ISO 8583 response codes. | Everyday lookups engineers keep in browser tabs. | 3 | M | ⬜ |
| 10 | **Payment rails overview** — ACH, SEPA, UPI, RTP/FedNow, Wires, card networks compared. | Broadens scope beyond cards → "fintech" not just "card processing". | 4 | M | ⬜ |

---

## P2 — Solid improvements

| # | Feature | Why it matters | Impact | Effort | Status |
|---|---------|----------------|:------:|:------:|:------:|
| 11 | **Encoding tool pack** — HEX ↔ ASCII ↔ EBCDIC, JWT/JWS/JWE decoder, URL/HTML encode. | Complements Base64; common in message debugging. | 3 | M | ⬜ |
| 12 | **Glossary linking** — auto-link glossary terms across all docs; hover tooltips. | Reinforces vocabulary in context. | 3 | M | ⬜ |
| 13 | **Downloadable cheat sheets** (PDF) — ISO 8583 bitmap, EMV tags, response codes. | High-value takeaway; shareable. | 3 | S | ⬜ |
| 14 | **Simulator: failure/decline scenarios** — insufficient funds, fraud decline, timeout, partial auth. Currently only the happy path. | Learners see *why* transactions fail, not just success. | 4 | M | ⬜ |
| 15 | **Accessibility pass** — keyboard nav, ARIA labels, contrast audit, reduced-motion. | Inclusive + good practice; likely gaps in glassmorphism UI. | 3 | M | ⬜ |
| 16 | **Feedback / "was this helpful?"** widget per page. | Cheap signal on which content to invest in. | 2 | S | ⬜ |

---

## P3 — Nice-to-have / later

| # | Feature | Why it matters | Impact | Effort | Status |
|---|---------|----------------|:------:|:------:|:------:|
| 17 | **User accounts + saved progress** (would need a backend/DB — currently stateless). | Cross-device progress, but a big architectural change. | 3 | L | ⬜ |
| 18 | **Certificates of completion** after finishing a learning path. | Motivation / shareable credential. | 2 | M | ⬜ |
| 19 | **Community / discussion** per topic. | Engagement, but heavy to moderate. | 2 | L | ⬜ |
| 20 | **Light theme toggle** (site is dark-only today). | Preference/accessibility. | 2 | S | ⬜ |
| 21 | **Multi-language / i18n**. | Wider reach; large ongoing cost. | 2 | L | ⬜ |

---

## Cross-cutting / tech debt (from CLAUDE.md — worth folding in)

- Hardcoded GNews API key in `news.php` → move to env/`config.php`.
- No `.gitignore` → `error_log`, `cache/*.json` are committed.
- Per-page `<title>`/meta (overlaps with #5).

---

### How to use this backlog
1. Pick the top unstarted P0 item.
2. Mark it 🚧, implement, verify in the browser preview, mark ✅.
3. Re-check priorities — impact/effort estimates are a starting point, adjust as we learn.
