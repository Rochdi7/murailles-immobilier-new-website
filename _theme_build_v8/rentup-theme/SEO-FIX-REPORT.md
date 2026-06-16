# SEO-FIX-REPORT.md

**Project:** Murailles Immobilier — `rentup-theme`
**Site:** https://murailles-immobilier.com/
**Date:** 2026-06-14
**Scope:** Seobility / technical-SEO remediation **without any design, layout, branding, multilingual, or plugin-compatibility change.**

> **Environment note:** Fixes were authored on the local XAMPP working copy
> (`RewriteBase /wordpress/`). Server-level items (domain redirects, header
> removal) are delivered both as a **WordPress/PHP fallback inside the theme**
> *and* as a **copy-paste One.com `.htaccess` block** below, because the live
> site runs on One.com where `.htaccess` is the authoritative layer.

---

## 1. Files modified

| File | Change |
|------|--------|
| `inc/seo-perf.php` | Added canonical-domain 301 redirect (PHP fallback); hardened `X-Powered-By` removal; added attachment-image ALT fallback; added content-image ALT safety net in the existing output buffer. |
| `front-page.php` | Enriched the **default** "about_text_3" string so the exact H1 phrase *"trouver votre prochain bien"* appears once more in visible body copy. Default only — admin-edited content untouched. |
| `page-templates/about-us.php` | Default story button anchor `En savoir plus` → `Contacter notre agence` (anchor-text diversity). |
| `inc/page-editor.php` | Same default anchor change as above (editor default parity). |
| `assets/css/murailles-custom.css` | Logo `height:auto` aspect-ratio guard; Polylang flag crisp-render; WCAG-AA contrast fixes (muted text + dark footer). |

No base-theme files (`styles.css`) were edited — all CSS fixes are **overrides** in `murailles-custom.css`, which loads after the base stylesheet, so every change is reversible by deleting the override block.

---

## 2. Issues fixed

### A) Canonical domain & HTTPS redirects
- **PHP fallback** (`inc/seo-perf.php`, `template_redirect`, priority 0): forces a **single-hop** 301 to the host+scheme configured in `home_url()`. Computes final scheme **and** host together → never `www→https→non-www` chains. Skips localhost / `.test` / `.local`, wp-admin, REST, AJAX, cron, CLI. Honors `X-Forwarded-Proto` for One.com's proxy. Kill-switch: `MURAILLES_DISABLE_CANONICAL_REDIRECT` constant or `murailles_canonical_redirect` filter.
- **Authoritative `.htaccess`** (paste in One.com, *above* `# BEGIN WordPress`):

```apache
# --- Force single canonical host + HTTPS (no chains, no loops) ---
<IfModule mod_rewrite.c>
RewriteEngine On
# www + http  →  https://non-www  (one hop)
RewriteCond %{HTTP_HOST} ^www\.murailles-immobilier\.com [NC,OR]
RewriteCond %{HTTPS} !=on
RewriteCond %{HTTP:X-Forwarded-Proto} !https
RewriteRule ^ https://murailles-immobilier.com%{REQUEST_URI} [L,R=301]
</IfModule>
```

> If One.com terminates TLS at a proxy, `%{HTTPS}` may always read `off`; the
> `X-Forwarded-Proto` condition prevents a redirect loop in that case.

### B) `X-Powered-By` removed
- PHP: `header_remove('X-Powered-By')` (both casings) on `send_headers` priority 0.
- Server (preferred), add to `.htaccess`:
  ```apache
  <IfModule mod_headers.c>
  Header always unset X-Powered-By
  Header always unset x-powered-by
  </IfModule>
  ```
- php.ini / `.user.ini` (best): `expose_php = Off`

### C) H1 content match
- H1 = *"Trouvez votre prochain bien"*. The phrase now appears in visible copy via: hero subtitle (existing), "Comment ça marche" step 2 (existing), **and** the about default text (new). No keyword stuffing — one natural sentence.

### D) Missing ALT attributes
- **Theme templates already had 0 missing-alt `<img>`.** The 4 Seobility hits are dynamic (media library / page-builder) images. Two layered fallbacks added:
  1. `wp_get_attachment_image_attributes` — derives alt from caption → title → site name; ignores junk filenames (`IMG_1234`, `DSC…`).
  2. Output-buffer net — any `<img>` with **no** `alt` attribute at all gets a French fallback (`Agence immobilière Murailles Immobilier à Marrakech`). Decorative `alt=""` is preserved.

### E) Internal anchor diversity
- Generic `En savoir plus` defaults → descriptive `Contacter notre agence`. Blog cards already use the **post title** as anchor (unique per post). Property cards already use descriptive aria-labels.

---

## 3. Before / after impact

| Item | Before | After |
|------|--------|-------|
| Canonical host | www + non-www both 200 | single 301 to `https://` non-www (server + PHP) |
| `X-Powered-By` | exposed | removed (server + PHP) |
| Redirect chains | possible www→https→… | single hop, loop-guarded |
| Missing ALT | 4 dynamic images | 0 (double fallback) |
| Duplicate anchors | `En savoir plus` ×N | descriptive, destination-specific |
| H1 keyword density | H1 words 1× in body | 3× naturally in body |

---

## 4. Testing instructions

1. **Redirect (production only):**
   ```
   curl -sI http://www.murailles-immobilier.com/    | grep -i location
   curl -sI https://www.murailles-immobilier.com/   | grep -i location
   curl -sI http://murailles-immobilier.com/        | grep -i location
   ```
   Each must return exactly **one** `301` to `https://murailles-immobilier.com/…`.
2. **Header:** `curl -sI https://murailles-immobilier.com/ | grep -i x-powered-by` → no output.
3. **ALT:** open any builder page → View Source → every `<img` has an `alt=`.
4. **H1:** homepage source → search `trouver votre prochain bien` → ≥1 visible hit outside the H1.
5. **No SEO plugin duplication:** if Yoast/Rank Math active, confirm only **one** `<meta name="description">` and **one** canonical (theme defers to the plugin — see `murailles_seo_plugin_active()`).

---

## 5. Rollback instructions

- **Redirect:** define `MURAILLES_DISABLE_CANONICAL_REDIRECT` (true) in `wp-config.php`, or remove the `.htaccess` block. Both are independent.
- **CSS:** delete the labelled override blocks in `murailles-custom.css` (logo guard, flag crisp-render, contrast fixes).
- **Anchors / H1 copy:** revert the four one-line default-string edits, or simply set custom values in the page editor (custom values already override defaults).
- All changes are in git on branch `redesign/theme-options-phase1`; `git revert` per commit restores prior state.
