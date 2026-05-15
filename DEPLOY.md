# Murailles Immobilier — Production Deployment Checklist

How to migrate the local site to the live server (`murailles-immobilier.com` or any production host) while keeping translation, biens, and admin settings working.

---

## Before you start

You need access to:
- **Local**: this XAMPP install (the files + the `wordpress_CodeSommet` MySQL database).
- **Production**: SFTP + database credentials of the live host. cPanel works too.
- The **Polylang plugin** (paste your licence key on prod after install — Polylang basic is free).

Estimated time: **45–60 minutes**.

---

## Step 1 — Back up local

```bash
# From C:\xampp\htdocs\wordpress
c:/xampp/mysql/bin/mysqldump.exe -u root wordpress_CodeSommet > backup-local.sql
```

Also zip these folders:
- `wp-content/themes/rentup-theme/`
- `wp-content/uploads/`
- `.htaccess` (root)
- `wp-config.php` (root) — copy for reference, **don't upload**: keys/SMTP differ in prod.

---

## Step 2 — Upload theme + uploads to prod

Use SFTP/FileZilla to upload, in this exact location on the live server:

| Local | Production |
|---|---|
| `wp-content/themes/rentup-theme/` | `wp-content/themes/rentup-theme/` |
| `wp-content/mu-plugins/` | `wp-content/mu-plugins/` |
| `wp-content/uploads/` | `wp-content/uploads/` |
| `.htaccess` | `.htaccess` (root) |

> The `mu-plugins/` folder contains a must-use plugin that forces Polylang into directory mode (`/fr/` and `/en/` URL prefixes) regardless of admin saves. It activates automatically — no clicks needed.

⚠️ **Do not upload `wp-config.php`** — production already has its own with prod DB credentials.

---

## Step 3 — Install + activate plugins on prod

On the live WP Admin → **Plugins → Add New**:

1. **Polylang** — install + activate.
2. Any caching/security plugin you already use (Wordfence, WP Super Cache, etc.).

---

## Step 4 — Import the database

Open phpMyAdmin or Adminer on the live server. Two paths:

### Option A — Full DB replacement (cleanest, if prod is fresh)

1. In phpMyAdmin, drop all tables of the prod database.
2. Click **Import** → upload `backup-local.sql` → run.

### Option B — Selective import (if prod has data you want to keep)

Import only the rentup-related tables: `wp_posts`, `wp_postmeta`, `wp_terms`, `wp_termmeta`, `wp_term_taxonomy`, `wp_term_relationships`, `wp_options` (carefully — see below).

---

## Step 5 — Fix URLs in the database

The local URL `http://localhost/wordpress` is hard-coded in dozens of places (serialized arrays, post content, Polylang settings). **Do not use SQL `REPLACE`** on serialized data — it corrupts string lengths.

Use one of these:

### Best: Better Search Replace plugin

1. Plugins → Add New → **Better Search Replace** → install + activate.
2. **Tools → Better Search Replace**.
3. Search: `http://localhost/wordpress`
4. Replace: `https://murailles-immobilier.com`
5. Select **all tables**, uncheck "Dry run", click **Run Search/Replace**.
6. Then repeat with:
   - Search: `localhost/wordpress`
   - Replace: `murailles-immobilier.com`

### Manual fallback (only for `siteurl` and `home`)

```sql
UPDATE wp_options
   SET option_value = 'https://murailles-immobilier.com'
 WHERE option_name IN ('siteurl', 'home');
```

This is enough to **log in** to admin; finish with Better Search Replace afterwards.

---

## Step 6 — Re-save permalinks

WP Admin → **Settings → Permalinks** → click **Save Changes** (no need to modify anything).

This regenerates `.htaccess` rewrite rules and Polylang's `/fr/` and `/en/` prefix rules. **Critical step** — without this, every page returns 404.

---

## Step 7 — Configure Polylang on prod

1. **Languages → Languages**: verify Français (fr_FR) and English (en_US) are both listed.
2. **Languages → Settings → URL modifications**:
   - ☑ The language is set from the directory name in pretty permalinks
   - ☐ Hide URL language information for default language (leave unchecked so `/fr/` shows)
   - ☑ The front page url contains the language code instead of the page name or page id
   - ☑ Remove /language/ in pretty permalinks
3. Click **Save changes**.
4. **Languages → Synchronization**: check at least:
   - Taxonomies
   - Custom fields
   - Comment status
   - Page parent
5. Save.

---

## Step 8 — Configure SMTP for prod

Open the prod `wp-config.php` (via cPanel File Manager or SFTP). Add **before** `/* That's all, stop editing! */`:

```php
define( 'MURAILLES_SMTP_HOST',      'smtp.gmail.com' );
define( 'MURAILLES_SMTP_PORT',      587 );
define( 'MURAILLES_SMTP_SECURE',    'tls' );
define( 'MURAILLES_SMTP_USER',      'contact@murailles-immobilier.com' );
define( 'MURAILLES_SMTP_PASS',      'xxxx xxxx xxxx xxxx' );
define( 'MURAILLES_SMTP_FROM',      'contact@murailles-immobilier.com' );
define( 'MURAILLES_SMTP_FROM_NAME', 'Agence Murailles' );
define( 'MURAILLES_LEAD_NOTIFY',    'contact@murailles-immobilier.com' );
define( 'MURAILLES_WHATSAPP_NUMBER','212661425150' );
```

Generate the SMTP password at https://myaccount.google.com/apppasswords (Gmail 2FA required).

---

## Step 9 — Security hardening

In prod `wp-config.php`:

```php
define( 'WP_DEBUG', false );
define( 'DISALLOW_FILE_EDIT', true );  // disables admin theme/plugin editor
define( 'FORCE_SSL_ADMIN', true );     // forces HTTPS for /wp-admin/
```

Regenerate fresh keys at https://api.wordpress.org/secret-key/1.1/salt/ and replace the `AUTH_KEY` block.

---

## Step 10 — Smoke test

Hit each of these URLs in the browser. All should return 200:

- `https://murailles-immobilier.com/` → French homepage
- `https://murailles-immobilier.com/fr/faq/` → FAQ in French
- `https://murailles-immobilier.com/en/faq/` → FAQ in English
- `https://murailles-immobilier.com/fr/bien/` → property listings FR
- `https://murailles-immobilier.com/en/bien/` → property listings EN
- Click the FR/EN switcher in the header — page must reload in the other language.
- Submit the contact form — you should receive an email at `MURAILLES_LEAD_NOTIFY` within seconds.

If any URL returns 404: **redo Step 6** (re-save permalinks).

---

## Common production gotchas

| Symptom | Cause | Fix |
|---|---|---|
| Every page is 404 except `/` | Apache `AllowOverride None` or missing `.htaccess` | Ask host to enable `AllowOverride All`, re-upload `.htaccess` |
| `/fr/` and `/en/` don't work | Polylang URL mode not saved on prod | Step 7 again, then Step 6 |
| Layout broken / images missing | Old `localhost/wordpress` URLs in DB | Run Better Search Replace (Step 5) again |
| Login page redirects in a loop | `siteurl` mismatch with `home` | Both must be `https://murailles-immobilier.com` |
| Contact form silent failure | SMTP credentials wrong | Step 8 — check Gmail App Password is enabled |
| EN translations missing | Plugin not activated | Step 3 — confirm Polylang is **Active** |
| Mixed content warning | Some image URLs still `http://` | Run Better Search Replace on `http://murailles-immobilier.com` → `https://murailles-immobilier.com` |

---

## Will my translation work on prod?

**Yes, identically — provided you follow this checklist.** The translation system has three layers:

1. **Static UI strings** (header, footer, buttons) — defined in `inc/i18n-strings.php`. They travel with the theme files. No DB dependency. **Works immediately on prod.**
2. **Polylang URL routing** (`/fr/`, `/en/`) — stored in the `polylang` row of `wp_options`. Travels with the DB. **Works after Step 6 + Step 7.**
3. **Per-page translations** (page content, property descriptions, blog posts) — stored as separate posts in `wp_posts` with a `pll_*` taxonomy linking them. Travels with the DB.

Nothing is hard-coded to `localhost`. After Steps 5–7, the whole system runs the same on prod as on local.

---

## After deployment: ongoing tasks

- **New blog post** → write in French, click `+` next to EN in the Languages box, translate. (FR title + content auto-copies as a starting point thanks to a theme hook in `inc/i18n.php`.)
- **New property (bien)** → same workflow.
- **New UI string in code** → add the FR text via `murailles_t( 'New string' )` and add a new entry in `inc/i18n-strings.php`. Push the file to prod; the EN translation auto-seeds into Polylang's String Translations panel.

---

*Last updated: 15 May 2026.*
