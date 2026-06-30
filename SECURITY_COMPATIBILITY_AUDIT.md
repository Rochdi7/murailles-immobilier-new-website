# Security & Compatibility Audit — Murailles Immobilier

**Date:** 2026-06-28
**Scope:** Local repository (`c:\xampp\htdocs\wordpress`) — theme `rentup-theme`, mu-plugins, all `.htaccess`, `wp-config.php`, root PHP.
**Mode:** Phase 1 — **AUDIT ONLY. No files were modified.**
**Auditor role:** Senior WordPress security + compatibility engineer.

---

## 0. Critical scope note (read first)

This audit covers the **local checkout only**. The local repo is **not** the production server.

- The malware you found in production — root `index.php` injection, the random-named plugin `wiuwegq/`, files like `1.php` and `ahrefs_44...php`, the `403 on plugins.php` — **live on the one.com production server and are NOT present in this repo.**
- Therefore the "Clean malware" actions below are **instructions to run against production** (via FTP / one.com File Manager). I cannot reach the live server from here, and per project policy MCP access to the live site is not used.
- Everything else (theme code, mu-plugins, tracked `.htaccess`) **was** scanned directly and is reported as fact.

---

## 1. Executive summary

| Area | Result |
|---|---|
| Malware in local repo | ✅ **None found** |
| Theme PHP security (nonces, caps, sanitize, escape) | ✅ **Strong — follows WP standards** |
| Raw/unsafe SQL | ✅ None (all `$wpdb` uses `prepare()` or static literals) |
| Unsafe AJAX / admin-post endpoints | ✅ All write endpoints nonce + capability checked |
| Unescaped output of `$_GET/$_POST` | ✅ None found |
| `.htaccess` blocking admin assets | ✅ Not present in repo (was a **production-only** problem) |
| Direct file access (ABSPATH guards) | ✅ Present in audited `inc/` files |
| Enqueue discipline | ✅ Uses `wp_enqueue_*`, no injected tags |
| **Production server** | ⚠️ **Compromised — manual cleanup required (Section 4)** |

**Bottom line:** Your custom theme and mu-plugins are clean and well-engineered. The risk is entirely on the **production server** (injected files + a rogue plugin) and in **server-config/plugin conflicts** (the cache/security plugins that broke jQuery and caused 403s).

---

## 2. Detected problems

### 2.1 Local repo — findings

| # | Severity | File | Finding |
|---|---|---|---|
| L1 | ℹ️ Info | `wp-content/plugins/royal-mcp/`, references to `novamira` | MCP plugin that **allows PHP execution + filesystem ops**. The theme already warns about this (`functions.php:1664` shows an admin notice on production). **Must not be active on production.** |
| L2 | ℹ️ Info | `wp-config.php` | `WP_CACHE` define present (line for cache drop-in). Fine, but see production note 3.3. |
| L3 | ✅ Good | `inc/security-post-guard.php` | Custom anti-spam guard already blocks the exact crack/spam content that hit the site, and disables XML-RPC. Keep it. |

No vulnerabilities found in theme code.

### 2.2 Production server — findings (from your screenshots/errors, not local)

| # | Severity | Item | Finding |
|---|---|---|---|
| P1 | 🔴 Critical | `wp-content/plugins/wiuwegq/` | Random 7-char plugin folder = classic malware/backdoor pattern. **Inspect, then remove.** |
| P2 | 🔴 Critical | root `1.php`, `ahrefs_44...php` | Random root PHP files = injected backdoors/SEO-spam shells. **Remove after inspection.** |
| P3 | 🔴 Critical | root `index.php` (prod) | Was injected previously. **Verify it matches the clean version** (local copy is clean — 405 bytes, standard WP loader). |
| P4 | 🟠 High | jQuery `is not defined` storm in wp-admin | Caused by **JS combine/defer** from a cache plugin (LiteSpeed → then SiteGround `sg-cachepress`). Not a theme bug. |
| P5 | 🟠 High | `403 Forbidden on plugins.php` + `Dashicons "GGGG"` | Server WAF / security-plugin rule (Really Simple Security + one.com hardening) blocking admin assets, including the rule that blocked `load-styles.php`/`load-scripts.php`. |
| P6 | 🟡 Medium | `wp-reset` plugin present on prod | Can wipe the entire site. Keep deactivated; never run. |

---

## 3. .htaccess review

All `.htaccess` files tracked in the repo were read.

| File | Verdict | Notes |
|---|---|---|
| `/.htaccess` (root) | ✅ Safe | `Options -Indexes`, denies `.env/.sql/.zip/.bak/.log`, sane security headers (X-Frame-Options, nosniff, Referrer-Policy, HSTS gated on HTTPS), **standard WordPress rewrite block intact** (`RewriteBase /wordpress/`). Does **not** block any admin asset. |
| `wp-content/uploads/.htaccess` | ✅ Safe | Present (no admin-loader rules). **Recommend** adding explicit PHP-execution block (see 5.3). |
| `wp-content/aiowps_backups/.htaccess` | ✅ Safe | `deny from all` — correct. |
| `wp-content/updraft/.htaccess` | ✅ Safe | `deny from all` — correct. |
| `wp-content/cache/wpo-cache/.htaccess` | ✅ Safe | Denies all — correct. |
| `wp-content/plugins/akismet/.htaccess` | ✅ Safe | Denies all except Akismet's own CSS/JS/images — correct WP pattern. |

**The dangerous rule that blocked `load-styles.php`/`load-scripts.php` is NOT in this repo** — it was added on the production server's root `.htaccess`. Your fix (`Require all granted` for those two files) is correct and should stay on production. See Section 5 for the recommended hardened-but-safe production `.htaccess`.

---

## 4. Malware cleanup — PRODUCTION instructions (do NOT delete blindly)

Run these on the one.com server (File Manager / FTP). **Inspect before deleting.**

### Step 1 — Inspect the rogue plugin
- Open `wp-content/plugins/wiuwegq/` and list its files. A single obfuscated `.php` (base64/eval/gzinflate) = backdoor → remove the whole folder.
- Do the same for any other unfamiliar plugin folder not in this list of expected plugins:
  `burst-statistics, classic-editor, classic-widgets, google-site-kit, gtm-kit, internal-links, polylang, updraftplus, wordpress-seo, wp-reset` (+ Akismet, Elementor/WPBakery if used).

### Step 2 — Inspect & remove injected root files
- `1.php`, `ahrefs_4d4f0ee0...php`, `aios-bootstrap.php` (verify the last is really AIOS), any other random root `.php`.
- **Compare production root `index.php` to the clean local one** (this repo's `index.php` is the canonical clean WP loader). If prod differs, replace with the clean version.

### Step 3 — Replace core if in doubt
- If anything else looks off, re-upload **fresh WordPress core** (`wp-admin/` + `wp-includes/` + root files) from wordpress.org for your exact version — this overwrites any infected core file without touching `wp-content/` or the DB.

### Step 4 — Rotate secrets after cleanup
- Regenerate salts in `wp-config.php` (forces re-login of any attacker session).
- Change the DB password and all admin passwords.
- ⚠️ Your DB password is currently visible in `wp-config.php` in plaintext (normal for WP) — **rotate it** since it was on a compromised server.

**Do NOT** delete: `*-old` backup folders, `wp-content/uploads`, theme files, or run WP Reset.

---

## 5. Recommended production hardening (safe, non-breaking) — for Phase 2

These are **proposals**, not yet applied. Each is written to NOT break wp-admin, REST, AJAX, uploads, or updates.

### 5.1 Root `.htaccess` — keep admin loaders allowed
Your existing fix is correct and must remain on production:
```apache
<FilesMatch "^(load-styles|load-scripts)\.php$">
    Require all granted
</FilesMatch>
```
**Never** block: `load-styles.php`, `load-scripts.php`, `admin-ajax.php`, `/wp-json/`, `async-upload.php`, `update.php`, `plugins.php`, `themes.php`, `wp-cron.php`.

### 5.2 Block PHP execution in uploads (does NOT touch admin)
Add to `wp-content/uploads/.htaccess` (scoped to uploads only):
```apache
<FilesMatch "\.(php|php\d|phtml|phar)$">
    Require all denied
</FilesMatch>
```

### 5.3 Protect sensitive root files (scoped, safe)
```apache
<FilesMatch "^(wp-config\.php|wp-config-sample\.php|readme\.html|license\.txt|\.user\.ini)$">
    Require all denied
</FilesMatch>
```

### 5.4 Cache/optimization plugin settings (the jQuery fix)
In whatever cache plugin remains (SiteGround Optimizer / LiteSpeed / WP-Optimize), **turn OFF**:
- Combine JS
- Defer / Delay JavaScript
And **exclude jQuery** from any JS optimization. This is what caused the `jQuery is not defined` cascade.

### 5.5 `DISALLOW_FILE_EDIT`
Already set (`wp-config.php` defines it true) → theme/plugin editor is disabled in admin. Good. Keep it.

---

## 6. Security-plugin compatibility notes

| Plugin | Compatibility | Action |
|---|---|---|
| **Really Simple Security** | ⚠️ Was over-blocking (403 on admin). | Re-enable carefully; ensure it does **not** firewall `load-styles/scripts.php` or `plugins.php`. Keep HTTPS redirect. |
| **Wordfence** | ✅ Theme compatible | Safe to use. Run a malware scan on production with it. |
| **All-In-One Security (AIOS)** | ✅ Compatible | Avoid "Prevent access to PHP in uploads" conflicting with media; the scoped rule in 5.2 is enough. Don't enable "block long URLs"/aggressive firewall that breaks REST. |
| **Yoast SEO** | ✅ Compatible | Theme's `inc/seo*.php` defers to Yoast where present; no metadata/sitemap conflict. |
| **Polylang** | ✅ Compatible | `murailles-polylang-force.php` (mu-plugin) intentionally forces directory URL strategy; verified clean. Keep. |
| **UpdraftPlus** | ✅ Compatible | `wp-content/updraft/.htaccess` denies direct access — correct. |
| **one.com cache/CDN/security** | ⚠️ Host-level WAF | This (not WordPress) caused the `403 Forbidden`. Whitelist admin paths or disable ModSecurity for the domain if it blocks legit admin requests. |
| **royal-mcp / novamira (MCP)** | 🔴 Dev-only | Allows PHP execution. **Deactivate on production.** Theme already shows a warning notice. |

---

## 7. Theme compatibility — standards checklist

| Standard | Status | Evidence |
|---|---|---|
| Enqueue via `wp_enqueue_style/script` | ✅ | 23 enqueue calls in `functions.php`; versioned assets |
| No hardcoded admin URLs | ✅ | All use `admin_url()` / `home_url()` |
| ABSPATH guard / no direct access | ✅ | `if ( ! defined('ABSPATH') ) exit;` in audited `inc/` files |
| Output escaping | ✅ | `esc_html/esc_attr/esc_url/wp_kses_post` used consistently |
| Input sanitization | ✅ | `sanitize_text_field/email/key`, `wp_unslash`, `absint/intval` |
| AJAX nonce checks | ✅ | `murailles_form_is_legit()` (nonce + honeypot) on all write forms |
| Capability checks | ✅ | `current_user_can('manage_options')` + `check_admin_referer()` on all admin-post handlers |
| Raw SQL safety | ✅ | `$wpdb->prepare()` in `functions.php`; static literal counts in `seo-advanced.php` (no user input) |
| File uploads | ✅ | MIME allowlist (jpg/png/webp), size limit, count limit, `media_handle_upload` |
| CPT/taxonomy registration | ✅ | `register_post_type/register_taxonomy` standard |
| Polylang | ✅ | Preserved via mu-plugin |
| Yoast metadata/sitemap | ✅ | No conflict |
| Gutenberg/Elementor/WPBakery | ✅ | `elementor-canvas.php`/`elementor-header-footer.php` templates present; block-editor CSS mu-plugin fix in place |

---

## 8. Files changed

**None.** This is an audit-only pass. No file in the repo was modified.

---

## 9. Remaining risks

1. 🔴 **Production is still presumed compromised** until Section 4 is completed and a full Wordfence/AIOS scan runs clean.
2. 🟠 **Reinfection vector unknown** — likely an outdated plugin or stolen FTP/admin credential. After cleanup, update everything and rotate all credentials (Section 4, Step 4).
3. 🟠 **Host-level WAF (one.com)** can re-block admin assets after any change — coordinate with one.com if 403s recur.
4. 🟡 **DB password exposure** — was readable on a compromised server; rotate it.
5. 🟡 **Cache plugin** can re-break jQuery if JS-combine/defer is re-enabled.

---

## 10. Rollback instructions

- This pass made **no changes**, so nothing to roll back here.
- For Phase 2 (when fixes are applied): every change will be to `.htaccess` or a new mu-plugin. Before each edit, a `.bak` copy will be saved alongside (e.g. `.htaccess.bak-YYYYMMDD`). To roll back, restore the `.bak` and clear the cache.
- Production files removed during malware cleanup should first be **downloaded to a quarantine folder** (not deleted), so they can be restored if a false positive.

---

## 11. Suggested next steps (Phase 2 — only on your approval)

1. Clean production per Section 4 (you/me with FTP).
2. Apply safe hardening 5.2 + 5.3 to production `.htaccess`.
3. Add an optional mu-plugin to force-exclude jQuery from cache-plugin JS optimization (prevents recurrence).
4. Re-enable Really Simple Security + run Wordfence scan.
5. Run the Section-9 test checklist.

---

## 12. Final test checklist (run after Phase 2 on production)

- [ ] Homepage (FR + EN)
- [ ] Property single + archive pages
- [ ] Blog list + single
- [ ] `/wp-admin/` dashboard renders styled (no "GGGG", no jQuery errors)
- [ ] `/wp-admin/load-styles.php` → 200
- [ ] `/wp-admin/load-scripts.php` → 200
- [ ] `/wp-admin/admin-ajax.php` → 200 (`0` for empty action)
- [ ] `/wp-json/` → JSON
- [ ] Media upload works
- [ ] `plugins.php` loads (no 403)
- [ ] Permalinks resolve
- [ ] Yoast sitemap (`/sitemap_index.xml`)
- [ ] `robots.txt`
- [ ] Contact / newsletter / submit-property forms send mail
