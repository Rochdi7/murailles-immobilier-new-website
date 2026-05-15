# Murailles Immobilier — Production Deployment Guide (Beginner Edition)

This is a step-by-step guide to put your local WordPress site (currently running on XAMPP at `http://localhost/wordpress/`) onto a real web host so the world can see it.

**Time needed:** about 1 hour the first time. Don't rush — read each step before doing it.

**You will need:**
- A hosting account (any host that supports WordPress: O2switch, OVH, LWS, Hostinger, SiteGround, etc.)
- A domain name (e.g. `murailles-immobilier.com`)
- Your local files (already on this computer)
- An FTP client like **FileZilla** (free: https://filezilla-project.org/)
- A web browser

If you get stuck on any step, stop and ask before continuing.

---

## Part 1 — Prepare your local site (15 minutes)

### Step 1.1 — Make a backup of your database

Open the **Windows command line** (press `Win + R`, type `cmd`, press Enter) and paste this:

```cmd
"C:\xampp\mysql\bin\mysqldump.exe" -u root wordpress_CodeSommet > C:\Users\ASUS\Desktop\backup-database.sql
```

You should now have a file `backup-database.sql` on your Desktop. **This file is your whole site's database** — keep it safe.

### Step 1.2 — Make a zip of the theme + uploads

Open File Explorer, go to `C:\xampp\htdocs\wordpress\wp-content\`.

Zip these two folders (right-click → "Send to" → "Compressed folder"):
- `themes\rentup-theme` → save as `rentup-theme.zip` on your Desktop
- `uploads` → save as `uploads.zip` on your Desktop
- `mu-plugins` → save as `mu-plugins.zip` on your Desktop

You should now have **4 files on your Desktop**:
- `backup-database.sql`
- `rentup-theme.zip`
- `uploads.zip`
- `mu-plugins.zip`

---

## Part 2 — Set up the hosting (20 minutes)

### Step 2.1 — Buy a domain + hosting

Pick any hosting provider that says "**WordPress hosting**" or "**Shared hosting with PHP 8+**".

Good options for Morocco / Europe:
- **O2switch** (France) — €5/month, unlimited, very beginner-friendly
- **LWS** (France) — cheap, French support
- **Hostinger** (international) — very cheap, fast
- **OVH** (France) — well-known
- **Genious Communication** (Morocco)

Buy:
- 1 domain name → e.g. `murailles-immobilier.com`
- 1 shared hosting plan (any basic plan is enough)

After buying, the host emails you **cPanel** (or "Hosting control panel") access. Save:
- cPanel URL (something like `https://my-host.com:2083`)
- cPanel username
- cPanel password

### Step 2.2 — Create the database on the host

1. Log into cPanel.
2. Find **MySQL Databases** (or "Bases de données MySQL").
3. Create:
   - **Database name**: `wordpress_murailles` → write down the FULL name the host gives you (often with a prefix like `myuser_wordpress_murailles`).
   - **Database user**: `murailles_user` → write down the FULL name with prefix.
   - **Password**: generate a long random one, copy it to a notepad.
4. **Add the user to the database** with **ALL PRIVILEGES** (very important — there's usually a button "Add User to Database").

Write these 3 things on a notepad — you'll need them in Step 3.2:
- Full DB name (with prefix)
- Full DB user (with prefix)
- DB password

### Step 2.3 — Install WordPress on the host

Most hosts have a **"WordPress Installer"** (one-click install) in cPanel. Use it:
1. Click "Install WordPress" or "Softaculous → WordPress".
2. Choose your domain in the dropdown.
3. Site title: `Murailles Immobilier`
4. Admin username: pick something NOT "admin" (e.g. `agence`).
5. Admin password: generate a strong one, save it in your notepad.
6. Admin email: `contact@murailles-immobilier.com`
7. Click **Install**.

After ~1 minute, your host shows you:
- Site URL: `https://murailles-immobilier.com`
- Admin URL: `https://murailles-immobilier.com/wp-admin/`
- Username + password (the ones you just chose)

**Test it**: visit your site → should show the WordPress default theme. Visit `/wp-admin/` → log in. Good.

---

## Part 3 — Upload your local content to the host (15 minutes)

### Step 3.1 — Connect with FileZilla

1. Open FileZilla.
2. **File → Site Manager → New site**.
3. Fill in (your host's email has these):
   - Protocol: **SFTP** (or FTP if SFTP not available)
   - Host: `ftp.murailles-immobilier.com` (or whatever the host says)
   - User: your FTP user (often the same as cPanel)
   - Password: your FTP password
4. Click **Connect**.

You should see two panels: your computer on the left, your host on the right.

### Step 3.2 — Upload the theme

On the right panel (the host), navigate to the WordPress folder. It's usually:
- `public_html/` (if domain points to the root)
- or `public_html/murailles-immobilier.com/` (if you have multiple domains)

You should see folders like `wp-admin`, `wp-content`, `wp-includes`, and a file `wp-config.php`. **You're in the right place.**

Now:
1. Open `wp-content/themes/` on the host (right panel).
2. From your Desktop, open `rentup-theme.zip` — extract it first if needed (you'd get a `rentup-theme` folder).
3. **Drag the `rentup-theme` folder** from your computer (left) to the host's `wp-content/themes/` (right).
4. Wait. This uploads ~500 files. Could take 5-10 minutes.

### Step 3.3 — Upload the uploads (media library)

1. On the host, open `wp-content/uploads/`.
2. From your Desktop, open `uploads.zip` and extract it.
3. **Drag everything inside the extracted `uploads` folder** to the host's `wp-content/uploads/`.
4. Wait — this is the biggest folder (all property photos). 10-20 minutes.

### Step 3.4 — Upload the must-use plugins

1. On the host, look for `wp-content/mu-plugins/` — it probably **doesn't exist yet**.
2. Right-click in `wp-content/` → **Create directory** → name it `mu-plugins`.
3. Extract `mu-plugins.zip` on your Desktop.
4. Drag the file `murailles-polylang-force.php` from inside the extracted folder to the host's `wp-content/mu-plugins/`.

That's it for files.

---

## Part 4 — Import the database (10 minutes)

### Step 4.1 — Open phpMyAdmin on the host

1. cPanel → **phpMyAdmin**.
2. On the left, click your database name (the one you wrote down in Step 2.2).
3. You'll see all the WordPress tables (`wp_posts`, `wp_options`, etc.).

### Step 4.2 — Wipe the host's empty WordPress data

The fresh WordPress install made some empty tables. We want to replace them with your local data.

1. At the top, click the **"Structure"** tab.
2. Scroll to the bottom → click **"Check all"**.
3. In the dropdown that says "With selected", choose **"Drop"** (delete).
4. Confirm → all tables gone.

### Step 4.3 — Import your local database

1. Click the **"Import"** tab at the top.
2. Click **"Choose file"** → select `backup-database.sql` from your Desktop.
3. Scroll to the bottom → click **"Go"** (or "Importer").
4. Wait 30 seconds. You should see a green "Import successful" message.

Now your host's database has all your French + English pages, properties, and blog posts.

---

## Part 5 — Fix the URLs in the database (5 minutes — CRITICAL)

Your local database has `http://localhost/wordpress` written in hundreds of places. You need to replace it with your real URL `https://murailles-immobilier.com` everywhere.

**Do NOT use SQL "Find and Replace"** — it corrupts WordPress settings (WordPress stores some data in a special format that breaks if you do a naive replace).

### Step 5.1 — Use phpMyAdmin SQL for the bare minimum

In phpMyAdmin, click your database → **"SQL"** tab → paste this:

```sql
UPDATE wp_options SET option_value = 'https://murailles-immobilier.com' WHERE option_name IN ('siteurl', 'home');
```

Click **Go**. This makes WordPress reachable.

### Step 5.2 — Connect the host's wp-config.php to the host's database

1. Back to FileZilla. On the host, open `wp-config.php` (right-click → **View/Edit**).
2. Find these lines near the top:

   ```php
   define( 'DB_NAME', 'something_else' );
   define( 'DB_USER', 'something_else' );
   define( 'DB_PASSWORD', 'something_else' );
   define( 'DB_HOST', 'localhost' );
   ```

3. Replace with the database details you wrote down in Step 2.2:

   ```php
   define( 'DB_NAME', 'myuser_wordpress_murailles' );
   define( 'DB_USER', 'myuser_murailles_user' );
   define( 'DB_PASSWORD', 'the-password-you-generated' );
   define( 'DB_HOST', 'localhost' );  // 99% of hosts use localhost. If yours doesn't, the host tells you.
   ```

4. **Save the file** (FileZilla asks "upload back to server?" → Yes).

### Step 5.3 — Log into your new admin

Go to `https://murailles-immobilier.com/wp-admin/`.

Log in with the **username + password from your LOCAL site** (not the WordPress install you did in Step 2.3 — that's gone now because we wiped the database).

If you don't remember your local credentials, log into your local site to check, then come back.

### Step 5.4 — Install "Better Search Replace" plugin

1. Once logged in, go to **Plugins → Add New**.
2. Search for **"Better Search Replace"**.
3. Click **Install Now**, then **Activate**.

### Step 5.5 — Run the URL replacement

1. **Tools → Better Search Replace**.
2. **Search for**: `http://localhost/wordpress`
3. **Replace with**: `https://murailles-immobilier.com`
4. **Select tables**: click "Select all".
5. **UNCHECK** "Run as dry run".
6. Click **Run Search/Replace**.
7. Wait ~30 seconds. You'll see "X cells changed". Good.

8. **Run a second pass** for any remaining `localhost/wordpress` (without protocol):
   - Search for: `localhost/wordpress`
   - Replace with: `murailles-immobilier.com`
   - Run again.

---

## Part 6 — Install Polylang (5 minutes)

The translation system needs the Polylang plugin.

1. WP Admin → **Plugins → Add New**.
2. Search for **"Polylang"**.
3. Click **Install Now**, then **Activate**.
4. You'll see a "Welcome to Polylang" message — close it without touching anything (the languages are already in your imported database).

To verify:
- **Languages** menu appears in the admin sidebar.
- Click **Languages → Languages**: you should see French (28 posts) and English (28 posts).

---

## Part 7 — Configure permalinks (1 minute — CRITICAL)

Without this step, every page on your site returns "404 Not Found".

1. WP Admin → **Settings → Permalinks**.
2. The structure should already be set to **"Post name"**. If not, select it.
3. Click **Save Changes** (even if nothing changed — this regenerates the URL routing).

Test in the browser:
- `https://murailles-immobilier.com/` → should redirect to `/fr/`
- `https://murailles-immobilier.com/fr/faq/` → French FAQ
- `https://murailles-immobilier.com/en/faq/` → English FAQ

If any of these 404, **redo Step 7** (re-save permalinks).

---

## Part 8 — Configure the contact email (5 minutes)

Your site sends emails when visitors:
- Submit a property listing
- Send a contact-form message
- Subscribe to the newsletter

For this to work, you need SMTP credentials.

### Step 8.1 — Get a Gmail App Password

1. Make sure 2-Factor Authentication is enabled on the Google account that owns `contact@murailles-immobilier.com` (or any Gmail address you'll use for sending).
2. Go to https://myaccount.google.com/apppasswords
3. Click "Create new app password". Name it `WordPress`.
4. Google shows you a 16-character password like `abcd efgh ijkl mnop`. Copy it.

### Step 8.2 — Edit wp-config.php on the host

In FileZilla, open `wp-config.php` again (View/Edit).

Find the line `/* That's all, stop editing! */` near the bottom.

**ABOVE** that line, paste:

```php
define( 'MURAILLES_SMTP_HOST',      'smtp.gmail.com' );
define( 'MURAILLES_SMTP_PORT',      587 );
define( 'MURAILLES_SMTP_SECURE',    'tls' );
define( 'MURAILLES_SMTP_USER',      'votre-adresse@gmail.com' );
define( 'MURAILLES_SMTP_PASS',      'abcd efgh ijkl mnop' );
define( 'MURAILLES_SMTP_FROM',      'votre-adresse@gmail.com' );
define( 'MURAILLES_SMTP_FROM_NAME', 'Agence Murailles' );
define( 'MURAILLES_LEAD_NOTIFY',    'contact@murailles-immobilier.com' );
define( 'MURAILLES_WHATSAPP_NUMBER','212661425150' );
```

Replace:
- `votre-adresse@gmail.com` with your actual Gmail address (in 2 places)
- `abcd efgh ijkl mnop` with the App Password from Step 8.1
- `contact@murailles-immobilier.com` with where you want to receive the notifications
- `212661425150` with your WhatsApp number (without `+` and spaces)

Save the file → upload back to server.

### Step 8.3 — Test it

Visit your live site → `/contact/` page → fill the form → submit.

You should receive the email within 30 seconds at `MURAILLES_LEAD_NOTIFY`.

If no email comes:
- Check the Gmail "Sent" folder of the SMTP account
- Try sending to a different address
- Make sure the App Password has no spaces (or has spaces, depending on what Google gave you — try both)

---

## Part 9 — Security hardening (5 minutes)

These are small changes that make your site much safer.

### Step 9.1 — Disable WP_DEBUG in production

In `wp-config.php`, find `define( 'WP_DEBUG', true );` and change to:

```php
define( 'WP_DEBUG', false );
```

If the line doesn't exist, add it.

### Step 9.2 — Add security flags

Also in `wp-config.php`, **ABOVE** `/* That's all, stop editing! */`, add:

```php
define( 'DISALLOW_FILE_EDIT', true );  // Hides the dangerous "edit theme/plugin" admin panels
define( 'FORCE_SSL_ADMIN', true );     // Always use HTTPS for /wp-admin/
```

### Step 9.3 — Regenerate authentication keys

1. Visit https://api.wordpress.org/secret-key/1.1/salt/
2. Copy the 8 lines that look like `define( 'AUTH_KEY', '...' );`
3. In `wp-config.php`, find your existing `AUTH_KEY`, `SECURE_AUTH_KEY`, `LOGGED_IN_KEY`, etc. block.
4. **Replace** the entire block with the fresh values you copied.
5. Save the file.

This logs you out — that's normal. Log back in.

---

## Part 10 — Final checks (10 minutes)

Visit each of these URLs. **All should work**:

| URL | What you should see |
|---|---|
| `https://murailles-immobilier.com/` | Redirects to `/fr/` |
| `https://murailles-immobilier.com/fr/` | French homepage with properties |
| `https://murailles-immobilier.com/en/` | English homepage with properties |
| `https://murailles-immobilier.com/fr/faq/` | French FAQ |
| `https://murailles-immobilier.com/en/faq/` | English FAQ |
| `https://murailles-immobilier.com/fr/bien/` | French property listings (should show 8 properties) |
| `https://murailles-immobilier.com/en/bien/` | English property listings (8 properties) |
| `https://murailles-immobilier.com/fr/blog/` | French blog (3 articles) |
| `https://murailles-immobilier.com/en/blog/` | English blog (3 articles) |

Also test:
- Click a property → property detail page opens
- Click 🇫🇷/🇺🇸 language switcher → page reloads in the other language
- Click "Sale" / "Vente" in the menu → properties filter to for-sale
- Submit the contact form → email arrives at `MURAILLES_LEAD_NOTIFY`

If anything fails, see **Troubleshooting** below.

---

## Part 11 — Recommended extras

These are optional but very useful.

### Install a security plugin

WP Admin → Plugins → Add New → search "**Wordfence Security**" → install + activate.

Run a scan once a month.

### Install a cache plugin

Cache = makes pages load 5-10× faster.

WP Admin → Plugins → Add New → search "**LiteSpeed Cache**" (if your host runs LiteSpeed) or "**WP Super Cache**" (works everywhere) → install + activate.

Default settings are fine.

### Install an image-compression plugin

Photos eat bandwidth. Install "**Smush**" → it auto-compresses every uploaded image.

### Set up daily backups

Either:
- Use your host's automatic backup feature (most have it, check cPanel)
- Or install "**UpdraftPlus**" plugin → Settings → set schedule to "Daily" → connect to Google Drive / Dropbox

---

## Troubleshooting

### "Error establishing a database connection"

→ Your `wp-config.php` DB credentials don't match. Re-check Step 5.2.

### Every URL 404s except the homepage

→ Permalinks not flushed. Re-do **Part 7**. If still broken, check that `.htaccess` exists at the root of your WordPress folder (FileZilla shows hidden files via menu).

### `/fr/` and `/en/` don't appear in URLs

→ The MU-plugin didn't upload correctly. Check FileZilla: `wp-content/mu-plugins/murailles-polylang-force.php` should exist on the host. If not, re-upload it.

### Pages show in English on the bare URL

→ Your browser has a sticky `pll_language=en` cookie from testing. Open an **incognito window** to confirm the site shows French by default.

### "No properties found" on `/en/bien/`

→ All EN properties might be in draft status. WP Admin → Properties → filter by "Draft" → bulk-edit to "Publish".

### Layout looks broken / images missing

→ Old `localhost` URLs still in the database. Re-run Better Search Replace (Step 5.5) with these:
- Search `http://localhost/wordpress` → Replace `https://murailles-immobilier.com`
- Search `localhost/wordpress` → Replace `murailles-immobilier.com`

### Contact form silently fails (no email)

→ SMTP credentials wrong. Re-check Step 8. Common cause: Gmail App Password has been deleted by Google (they expire after some months of unuse). Generate a new one.

### Mixed-content warning (yellow lock in browser)

→ Some images still load over `http://`. Run Better Search Replace one more time:
- Search `http://murailles-immobilier.com` → Replace `https://murailles-immobilier.com`

### I broke something and want to start over

→ Restore from the backup you took in **Step 1.1**.
1. cPanel → phpMyAdmin → your DB → Drop all tables.
2. Import → upload `backup-database.sql` from your Desktop again.
3. Re-do **Part 5**.

---

## Ongoing maintenance

### Weekly

- Check WP Admin → **Properties** → look for the red badge (new property submissions from visitors awaiting your review).
- Check your email inbox for contact-form messages.

### Monthly

- WP Admin → Dashboard → **Updates** → update WordPress + plugins.
- Run a Wordfence scan.
- Download a fresh backup (cPanel or UpdraftPlus).

### When adding a new property

1. WP Admin → **Properties → Add New**.
2. Fill in title, description, price, photos, etc.
3. **Categories / Locations / Areas** in the right sidebar — pick from the FR list.
4. Click **Publish**.
5. To add the English version: in the same edit screen, the **Languages** box on the right has a `+` icon next to the English flag. Click it. A new screen opens with the FR content already filled in. Translate the title + description, click **Publish**.

### When adding a new blog post

Same workflow as a property:
1. **Posts → Add New** → write in French → Publish.
2. Click `+` next to English in the Languages box → translate → Publish.

### When changing static text (theme strings)

The header, footer, button labels, and form labels are all translated via a dictionary file on the server: `wp-content/themes/rentup-theme/inc/i18n-strings.php`.

To change a translation:
1. WP Admin → **Languages → String Translations** (or "Translations").
2. Find the French string → edit the English column → Save.

No code editing needed.

---

## Cost summary

| Item | Approximate yearly cost |
|---|---|
| Domain name | €10–15 |
| Shared hosting | €60–100 |
| Polylang (free version) | €0 |
| Wordfence (free version) | €0 |
| Gmail (for SMTP) | €0 |
| **Total** | **€70–115 / year** |

Polylang has a paid "Pro" version (~€100/year) that adds features like translating WooCommerce or sharing slugs across languages — **you don't need it** for this site.

---

## Need help?

- **Theme developer**: CodeSommet — elyounani.business@gmail.com
- **WordPress official docs**: https://wordpress.org/documentation/
- **Polylang docs**: https://polylang.pro/doc/
- **Your hosting support**: most hosts answer FTP / DB questions for free in their chat

---

*Last updated: 15 May 2026.*
