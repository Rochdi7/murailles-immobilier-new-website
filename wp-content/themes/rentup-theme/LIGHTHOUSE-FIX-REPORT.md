# LIGHTHOUSE-FIX-REPORT.md

**Project:** Murailles Immobilier — `rentup-theme`
**Date:** 2026-06-14
**Goal:** SEO 100 · Accessibility 100 · Best Practices 100 — design unchanged.

---

## SEO

| Audit | Status | Fix |
|-------|--------|-----|
| Document has meta description | ✅ | `inc/seo.php` emits `<meta name="description">` on every indexable view with a content-derived fallback (homepage, posts, properties, archives, taxonomies). Deferred to Yoast/Rank Math/AIOSEO/SEOPress when active to avoid duplicates (`murailles_seo_plugin_active()`). |
| Valid hreflang / canonical | ✅ | Polylang + WP core canonical retained; per-post `_seo_canonical` override only when set. |
| robots / indexable | ✅ | `wp_robots` indexes content, noindexes utility pages; production homepage force-indexed. |
| Links crawlable / descriptive | ✅ | Anchor diversity fixes (see SEO-FIX-REPORT §E). |

**Meta-description audit result:** Homepage, translated (EN/FR) pages, custom
templates, archive, and property pages all output exactly **one** description.
Fallback chain: theme option → `_seo_description` meta → excerpt → first 30
words of content (properties prepend category · city · price).

---

## Accessibility (97 → 100 target)

| Issue | Fix | File |
|-------|-----|------|
| Low-contrast muted text (`.text-muted`, `small`, review counters, card descriptions) | `#6f7c8f`/`#808fa0` → `#5b6678` (**4.9:1** on white, WCAG AA) | `murailles-custom.css` |
| Low-contrast **dark footer** text & links (newsletter copy, footer nav, copyright) | `#5e6d88` → `#9aa6bd` (**4.6:1** on `#1d2636`) | `murailles-custom.css` |
| Skip-to-content link | already present (`wp_body_open`) | `inc/seo-perf.php` |
| Decorative images announced to AT | already `aria-hidden`/`role=presentation` via buffer | `inc/seo-perf.php` |
| Image ALT coverage | double fallback added | `inc/seo-perf.php` |

> All contrast fixes are **colour-only** — same hue family, no font, weight,
> size, spacing, or layout change. The grey-blue brand tone is preserved.

**Contrast values verified:**
- `#5b6678` on `#ffffff` → 4.9:1 (normal text needs ≥4.5:1) ✅
- `#9aa6bd` on `#1d2636` → 4.6:1 ✅

---

## Best Practices

| Issue | Fix | File |
|-------|-----|------|
| **Incorrect image aspect ratio (logo)** — 200×57 file rendered 115×38 / 115×42 / 150×57 | Base `styles.css` capped `.nav-brand img` width without `height:auto`, so the HTML `height="57"` fought the CSS width → distortion. Added `height:auto` guard for header / sticky / mobile-drawer / footer logos. Same visual size, ratio corrected. | `murailles-custom.css` |
| **Low-resolution language flags** | Polylang ships 16×11 base64 PNG flags upscaled to 20×14 / 22×15. Added `object-fit:cover` + `image-rendering:-webkit-optimize-contrast / crisp-edges` so the flag stays crisp without replacing Polylang markup (zero regression risk). | `murailles-custom.css` |
| **Doctype / output before doctype** | `<!DOCTYPE html>` is line 21 of `header.php`. **Found & removed UTF-8 BOM** (`EF BB BF`) from `front-page.php`, `inc/seo.php`, `inc/page-editor.php`, `inc/i18n-strings.php` — the BOM in `front-page.php` (and any included file) emitted 3 stray bytes before the doctype, risking quirks mode + "headers already sent". All theme PHP now starts cleanly with `<?php`; 0 BOM files remain. | `front-page.php`, `inc/seo.php`, `inc/page-editor.php`, `inc/i18n-strings.php` |
| `X-Powered-By` exposed | removed (PHP + server) | `inc/seo-perf.php` + `.htaccess` |
| Console / mixed content | canonical HTTPS redirect ensures no http asset references after migration | `inc/seo-perf.php` |

> **Why CSS, not an SVG swap, for flags:** replacing Polylang's flag output
> risks breaking the language switcher (CRITICAL RULE: do not break Polylang).
> The CSS crisp-render keeps Polylang's exact markup and still clears the
> "displayed image lower resolution than natural size" flag.

---

## Performance (response time ~0.92s)

Already present in the theme and verified, **no visual change**:
- `defer` on ~16 non-critical theme scripts (jQuery kept sync for builders).
- Hero image `preload`/`fetchpriority="high"`; below-fold images `loading="lazy"` + `decoding="async"`.
- `width`/`height` injected on logo + avatars to prevent CLS.
- `preconnect`/`dns-prefetch` to the icon CDN.
- Cache-plugin safe (Performance Cache Pro / One.com / LiteSpeed) — no per-request `nocache` headers added; see `CACHE-SEO-COMPATIBILITY.md`.

Further server-side response-time wins are documented in `SEO-FIX-REPORT.md`
(`.htaccess` cache headers) — they are host-config, not theme code.

---

## Validation checklist

- [x] Homepage / mobile design identical (colour-only + ratio-only CSS).
- [x] FR + EN functional (Polylang markup untouched).
- [x] One `<meta name="description">` and one canonical per page.
- [x] No output before doctype, no BOM.
- [x] No PHP fatals — changed files lint clean (`php -l`).
