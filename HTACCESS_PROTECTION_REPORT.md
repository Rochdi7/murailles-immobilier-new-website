# .htaccess Protection Report — Murailles Immobilier

**Date:** 2026-06-28
**Engineer role:** Senior WordPress engineer
**Target environment:** Production (one.com, `RewriteBase /`)
**Goal:** Stop the theme from regenerating root `.htaccess` on normal traffic and **permanently preserve** the admin-asset allow rule + One.com headers so `wp-admin` CSS/JS never 403s again.

---

## 1. Root cause — what was editing `.htaccess`

No theme/plugin code wrote `.htaccess` directly (no `insert_with_markers`, `file_put_contents`, or `WP_Filesystem` writes were found). The damage came **indirectly** through `flush_rewrite_rules()`.

On Apache, `flush_rewrite_rules()` → `save_mod_rewrite_rules()` → `insert_with_markers()` on the **root `.htaccess`**, rewriting the `# BEGIN WordPress … # END WordPress` block. Any directives the site added **outside** those markers (the One.com `Access-Control-Allow-Origin` headers and the `load-styles`/`load-scripts` `Require all granted` rule) are vulnerable to being dropped on a regeneration — which 403s the admin assets ("GGGG" Dashicons + `jQuery is not defined`).

### Scan results

| File | Line | Trigger | Verdict |
|---|---|---|---|
| `inc/custom-post-types.php` | 918 (was) | **`add_action('init', …, 99)`** | 🔴 Fired on **every front-end + admin request** until the version option matched. Worst offender. **FIXED** |
| `inc/i18n.php` | 184 (was) | **`add_action('wp_loaded', …)`** | 🟠 Fired on **every request** until marker matched. **FIXED** |
| `inc/custom-post-types.php` | 900, 917 | `after_switch_theme` | ✅ Safe (theme activation only) — unchanged |
| `inc/agent-post-type.php` | 328 | `after_switch_theme` | ✅ Safe (theme activation only) — unchanged |
| `inc/forms.php` | 501 | `fopen('php://output')` | ✅ Not a file write — CSV to HTTP stream. Unchanged |
| `inc/seo-perf.php` | 39, 57, 60 | comments only | ✅ No code. Unchanged |

**No `Deny from all` / `Require all denied` / `<FilesMatch "\.php$">` rules** were found in any tracked `.htaccess`, and **none exist in `wp-admin/`, `wp-content/`, or `uploads/`** that block PHP globally. The dangerous admin-loader-blocking rule was never in the repo — it was added on the production server, and your manual `Require all granted` fix is correct.

---

## 2. Fixes applied

### Fix A — Move version-gated flushes off public hooks (no more front-end regeneration)

Both one-shot flushes now run on **`admin_init`** (logged-in admin context) instead of `init` / `wp_loaded`. They remain version/marker-gated, so they still fire **once** after a deploy — but never on public traffic, and never in a context that would rewrite `.htaccess` for an anonymous visitor.

- `inc/custom-post-types.php` — `murailles_maybe_flush_rewrites` moved `init → admin_init`.
- `inc/i18n.php` — Polylang force-flush moved `wp_loaded → admin_init`.

`after_switch_theme` flushes (theme activation) were **left intact** — that's the correct, WP-recommended place to flush, and it only happens when an admin switches themes.

### Fix B — Permanent guard via `mod_rewrite_rules` (the durable protection)

New must-use plugin: **`wp-content/mu-plugins/murailles-htaccess-guard.php`**

It hooks the `mod_rewrite_rules` filter, which WordPress runs **every time** it regenerates root `.htaccess`. The guard **prepends the required directives inside the WP-managed block**, so WordPress's own `insert_with_markers()` writes them back on every regeneration. This means the rules survive:

- the theme's own flushes,
- **core/WordPress updates**,
- Polylang, Yoast, Elementor, WPBakery, or any plugin calling `flush_rewrite_rules()`,
- a Settings → Permalinks save.

Preserved block (exactly as required):
```apache
<FilesMatch "^(load-styles|load-scripts)\.php$">
    Require all granted
</FilesMatch>

# One.com response headers BEGIN
<IfModule mod_headers.c>
    <FilesMatch "\.(ttf|ttc|otf|eot|woff|woff2|css|js|png|jpg|jpeg|svg|pdf|json)$">
        Header set Access-Control-Allow-Origin "https://murailles-immobilier.com"
    </FilesMatch>
</IfModule>
# One.com response headers END
```

The filter is **idempotent** (won't duplicate if already present) and is a must-use plugin so it loads regardless of the active theme.

---

## 3. Files changed

| File | Change |
|---|---|
| `wp-content/themes/rentup-theme/inc/custom-post-types.php` | Moved `murailles_maybe_flush_rewrites` from `init` hook to `admin_init`; added explanatory comment. |
| `wp-content/themes/rentup-theme/inc/i18n.php` | Moved Polylang force-flush from `wp_loaded` to `admin_init`; added comment. |
| `wp-content/mu-plugins/murailles-htaccess-guard.php` | **New** — guards root `.htaccess` via `mod_rewrite_rules` filter. |
| `HTACCESS_PROTECTION_REPORT.md` | **New** — this report. |

All three PHP files pass `php -l` (no syntax errors). **No content, design, or DB changes.**

---

## 4. Not broken (verified by design)

- ✅ Frontend design / theme features — untouched (only hook timing changed).
- ✅ Polylang — `/fr/` `/en/` rewrites still flush once on next admin visit; force-filter unchanged.
- ✅ Yoast, Elementor, WPBakery — unaffected (guard only adds, never removes, rules).
- ✅ Media library, admin dashboard, REST API, `admin-ajax.php` — the guard's whole purpose is to keep admin assets reachable.
- ✅ Permalinks — still flush correctly on theme switch and on the one-shot admin_init pass.

---

## 5. How to test

After deploying the 3 changed files to production:

1. **Force a regeneration:** WP Admin → **Settings → Permalinks → Save Changes** (no changes needed — saving triggers a flush).
2. **Open the root `.htaccess`** on the server. Confirm the `# Murailles guard BEGIN … END` block (with both the `load-styles/load-scripts` rule and the One.com headers) is present **inside** the WordPress block.
3. **Hard-reload `/wp-admin/`** (`Ctrl+Shift+R`). Confirm:
   - styled menu, no "GGGG" Dashicons,
   - DevTools Console: **no** `jQuery is not defined`,
   - `https://murailles-immobilier.com/wp-admin/load-styles.php` → **200**,
   - `…/wp-admin/load-scripts.php` → **200**,
   - `…/wp-admin/admin-ajax.php` → **200** (`0` for empty action),
   - `…/wp-json/` → JSON.
4. **Front-end:** load homepage FR + EN, a property page, a blog page — confirm design intact and **no `.htaccess` rewrite happens on anonymous hits** (the file's mtime should not change when logged-out visitors browse).
5. **Media upload** + **plugins.php** load without 403.

---

## 6. Rollback instructions

Each change is independently reversible. No `.bak` overwrite was needed (edits are small and tracked in git).

- **Disable the guard only:** delete or rename `wp-content/mu-plugins/murailles-htaccess-guard.php` → `…_OFF`. (The required block stays in `.htaccess` until the next regeneration.)
- **Revert the hook changes:** `git checkout -- wp-content/themes/rentup-theme/inc/custom-post-types.php wp-content/themes/rentup-theme/inc/i18n.php` (or change `admin_init` back to `init` / `wp_loaded`).
- **Full rollback:** `git checkout -- .` then delete the two new files (`murailles-htaccess-guard.php`, `HTACCESS_PROTECTION_REPORT.md`).
- If the root `.htaccess` was already damaged, **Settings → Permalinks → Save** will rebuild it with the guard block in place (once the mu-plugin is active).

---

## 7. Remaining notes

- The guard hard-codes `https://murailles-immobilier.com` and `RewriteBase /` (production). If you later test locally (`/wordpress/`), the guard's rewrite rules don't override WP's `RewriteBase` (WP still writes the correct base) — only the FilesMatch + headers are injected, which are path-agnostic and safe in both environments.
- This does **not** stop a host-level (one.com ModSecurity/WAF) 403. If `plugins.php` still 403s after this, that's the host firewall, not `.htaccess` — handle via one.com support (covered in `SECURITY_COMPATIBILITY_AUDIT.md`).
