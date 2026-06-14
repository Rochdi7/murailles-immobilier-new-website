# Murailles Immobilier — WordPress Theme

**Custom WordPress real-estate theme** for Agence Murailles Immobilier (Marrakech, Morocco).

Built by CodeSommet. Includes a fully custom scroll animation system, SEO infrastructure, Elementor compatibility, and multi-language support via Polylang.

---

## Project Overview

### What It Does

This is a fully custom WordPress theme for a real-estate agency. It provides:

- Property listings with custom post types and meta fields
- Dynamic search and filtering
- Wishlist and property comparison via `localStorage`
- Contact, lead capture, and newsletter forms with Gmail SMTP
- Multi-language support (French / English) via Polylang
- Full SEO stack: titles, meta descriptions, Open Graph, JSON-LD schema
- A custom scroll animation system (see below)

### Why the Scroll Animation System Was Built

The theme uses inline-styled content blocks and Bootstrap grid columns on dozens of page templates. A standard "add `data-aos` to every element" approach would require editing every template individually. The animation system was instead built to **automatically detect** animatable elements using two passes:

1. **Pass 1 — Named-class targets**: theme-specific CSS classes (`.sec-heading`, `._category_box`, etc.)
2. **Pass 2 — Structural sweep**: every Bootstrap `.col-*` child of a `.row` that wasn't already caught by Pass 1

This means every current and future page template gets entrance animations with zero template changes.

### Performance Goals

- Zero layout shift (CLS = 0)
- No jQuery dependency
- No external animation libraries
- IntersectionObserver for async, off-main-thread triggering
- `WeakSet`-based deduplication to prevent memory leaks
- Full `prefers-reduced-motion` support

---

## Features

### Animation Types

| Class | Effect |
|---|---|
| `fade-up` | Element fades in while rising 36px |
| `fade-in` | Opacity only — no transform, zero layout impact |
| `slide-left` | Slides in from the left (44px) |
| `slide-right` | Slides in from the right (44px) |
| `zoom-in` | Scales from 90% to 100% |
| `stagger` | Cards in a row animate with a 90ms cascade delay |

### Automatic Detection

You do not need to add any class to your HTML. The JS scans the DOM on `DOMContentLoaded` and applies the correct animation class based on element type. To opt out a specific element, add the `is-visible` class directly in HTML — the script skips already-visible elements.

### Manual Override

To force a specific animation on any element, add the classes manually:

```html
<div class="animate-on-scroll fade-up anim-delay-2">...</div>
```

Delay modifiers: `anim-delay-1` through `anim-delay-5` (0.10s – 0.50s steps).

### Accessibility

- CSS `prefers-reduced-motion: reduce` gate fires before JS — no flash of invisible content on reduced-motion devices
- JS early-return when `prefers-reduced-motion` matches
- Elements already above the viewport get `.is-visible` immediately (no disappearing above-fold content)
- No-JS fallback: without the `html.js-scroll-ready` class (added by JS), all `.animate-on-scroll` elements default to `opacity: 1`

---

## Project Structure

```
rentup-theme/
├── assets/
│   ├── css/
│   │   ├── styles.css              — Combined vendor CSS (Bootstrap, FontAwesome 5, etc.)
│   │   ├── slick.css               — Slick Carousel core styles
│   │   ├── murailles-custom.css    — Theme design overrides
│   │   ├── murailles-dropdown.css  — Unified select/dropdown component
│   │   └── scroll-animations.css  — Scroll animation keyframes and states
│   ├── js/
│   │   ├── jquery.min.js           — jQuery 3.6.0 (update to 3.7.1 before production)
│   │   ├── bootstrap.min.js        — Bootstrap 5 JS
│   │   ├── slick.js                — Slick Carousel
│   │   ├── custom.js               — Main theme JS (sliders, filters, UI)
│   │   ├── murailles-dropdown.js   — Custom select dropdown component
│   │   ├── murailles-uploader.js   — File upload with previews
│   │   └── scroll-animations.js   — Scroll animation engine (vanilla JS)
│   └── images/
│       ├── logo.png                — Agency logo (REQUIRED — see Migration section)
│       ├── logo-light.png          — Light variant for dark backgrounds
│       └── villa-luxe-marrakech-hero.webp  — Hero background image
│
├── inc/
│   ├── custom-post-types.php       — Property CPT, taxonomies, meta boxes
│   ├── agent-post-type.php         — Agent CPT
│   ├── forms.php                   — Contact/lead/newsletter/submit-property forms + SMTP
│   ├── interactive.php             — AJAX endpoints for wishlist + compare
│   ├── i18n.php                    — Polylang helpers, language switcher
│   ├── i18n-strings.php            — FR→EN translation dictionary
│   ├── seo.php                     — Title tags, meta description, robots directives
│   ├── seo-social.php              — Open Graph + Twitter Cards
│   ├── seo-schema.php              — JSON-LD structured data
│   └── seo-perf.php                — Preconnect, defer JS, lazy images, output buffer
│
├── page-templates/                 — Full-page PHP templates (home, about, contact, etc.)
├── template-parts/                 — Reusable partials (header, footer, property cards)
│
├── functions.php                   — Theme setup, enqueue, walkers, helpers
├── style.css                       — WordPress theme metadata header (no actual CSS)
└── README.md                       — This file
```

---

## Requirements

### WordPress

- WordPress 6.0 or later (tested up to 6.6)
- Permalink structure set to `/%postname%/` (auto-configured on theme activation)

### PHP

- PHP 7.4 minimum
- PHP 8.0, 8.1, 8.2, 8.3 — fully compatible
- Required extensions: `mbstring`, `json`, `curl` (standard on all shared hosts)

### Browser Support

The scroll animation system requires:

- `IntersectionObserver` (Chrome 58+, Firefox 55+, Safari 12.1+, Edge 16+)
- `WeakSet` (Chrome 36+, Firefox 34+, Safari 9+)
- Graceful fallback: if either is unavailable, all content displays immediately with no animations

### Hosting

- Apache 2.4+ or Nginx 1.14+
- LiteSpeed (Hostinger, Namecheap) — fully compatible
- MySQL 5.7+ or MariaDB 10.3+
- HTTPS strongly recommended (SMTP uses TLS)

---

## Installation Guide

### Local Installation (XAMPP)

1. Install XAMPP and start Apache + MySQL
2. Place the WordPress files in `C:\xampp\htdocs\wordpress\`
3. Create a database: open `http://localhost/phpmyadmin` → New → name it `wordpress`
4. Run the WordPress installer at `http://localhost/wordpress/`
5. Go to **Appearance → Themes → Add New → Upload** and upload the theme zip, or place the `rentup-theme` folder directly in `wp-content/themes/`
6. Activate the theme — pages are created automatically

**Test animations locally:**

1. Open browser DevTools → Network → throttle to "Slow 3G"
2. Scroll the homepage — cards should animate in as they enter the viewport
3. Open DevTools → Rendering → check "Emulate CSS media feature prefers-reduced-motion: reduce" — all content should be visible immediately with no animations

### Local Installation (LocalWP / Laragon / WAMP)

Same process — place the theme folder in the `wp-content/themes/` directory of your local WordPress installation and activate it.

---

### Production Installation (Hostinger cPanel)

1. **Upload files** via File Manager or FTP to `public_html/` (or a subdirectory)
2. **Create a MySQL database** in cPanel → MySQL Databases
3. **Edit `wp-config.php`** with the production database credentials
4. **Add SMTP constants** to `wp-config.php` (see SMTP Configuration below)
5. **Upload local logo files** to `wp-content/themes/rentup-theme/assets/images/`:
   - `logo.png`
   - `logo-light.png`
   - `villa-luxe-marrakech-hero.webp`
6. Activate the theme in **Appearance → Themes**

#### SMTP Configuration (wp-config.php)

Add these constants above `/* That's all, stop editing! */`:

```php
define( 'MURAILLES_SMTP_HOST',      'smtp.gmail.com' );
define( 'MURAILLES_SMTP_PORT',      587 );
define( 'MURAILLES_SMTP_SECURE',    'tls' );
define( 'MURAILLES_SMTP_USER',      'your@gmail.com' );
define( 'MURAILLES_SMTP_PASS',      'your-app-password' );
define( 'MURAILLES_SMTP_FROM',      'your@gmail.com' );
define( 'MURAILLES_SMTP_FROM_NAME', 'Murailles Immobilier' );
```

> Use a Gmail App Password (not your account password). Generate one at: Google Account → Security → 2-Step Verification → App passwords.

---

## Migration From Localhost to Production

### Step 1 — Export the database

In phpMyAdmin (localhost): select the `wordpress` database → Export → Quick → Go.

Save the `.sql` file.

### Step 2 — Import the database

In cPanel → phpMyAdmin: select the production database → Import → choose the `.sql` file → Go.

### Step 3 — Search & Replace URLs

The database contains absolute URLs pointing to `http://localhost/wordpress`. These must be updated to your production URL.

**Option A — WP CLI (recommended):**

```bash
wp search-replace 'http://localhost/wordpress' 'https://yourdomain.com' --all-tables
```

**Option B — Plugin:**

Install "Better Search Replace" → run a search/replace from `http://localhost/wordpress` to `https://yourdomain.com`.

**Option C — SQL (manual):**

```sql
UPDATE wp_options SET option_value = replace(option_value, 'http://localhost/wordpress', 'https://yourdomain.com') WHERE option_name = 'siteurl' OR option_name = 'home';
UPDATE wp_posts SET post_content = replace(post_content, 'http://localhost/wordpress', 'https://yourdomain.com');
UPDATE wp_postmeta SET meta_value = replace(meta_value, 'http://localhost/wordpress', 'https://yourdomain.com');
```

### Step 4 — Update wp-config.php

Replace the database credentials:

```php
define( 'DB_NAME',     'production_db_name' );
define( 'DB_USER',     'production_db_user' );
define( 'DB_PASSWORD', 'production_db_password' );
define( 'DB_HOST',     'localhost' );
```

Set production mode:

```php
define( 'WP_DEBUG',         false );
define( 'WP_DEBUG_LOG',     false );
define( 'WP_DEBUG_DISPLAY', false );
```

### Step 5 — Flush Permalinks

Go to **Settings → Permalinks** → click Save Changes (no changes needed — just clicking Save flushes the rewrite rules).

### Common Mistakes

| Mistake | Symptom | Fix |
|---|---|---|
| Forgot to search-replace URLs | Images broken, internal links go to localhost | Run search-replace (Step 3) |
| Wrong DB credentials in wp-config.php | "Error establishing database connection" | Double-check DB name/user/password/host |
| Uploaded files via FTP in ASCII mode | PHP files corrupt | Use Binary mode for all transfers |
| Forgot to flush permalinks | All pages return 404 | Settings → Permalinks → Save |
| Logo images missing from `assets/images/` | Logo shows external fallback image | Upload logo.png and logo-light.png |
| WP_DEBUG still true on production | PHP notices visible to visitors | Set `WP_DEBUG` to `false` |

---

## Elementor Compatibility

### How It Works

The theme declares `add_theme_support('elementor')` and `add_post_type_support()` for pages, posts, and properties. Elementor only activates on a post when an editor explicitly opens it — existing PHP templates are unaffected.

### Scroll Animations with Elementor

The scroll animation JS guards against the Elementor editor environment:

```js
if (body.classList.contains('wp-admin') || body.id === 'login') { return; }
```

- **Elementor editor (iframe)**: `body.wp-admin` is present → animations do not run → no editor lag
- **Elementor frontend**: animations run normally on the published page
- **Elementor widgets**: Bootstrap columns inside Elementor sections are caught by Pass 2 and animated automatically

### No Manual Class Assignment

You do not need to add `animate-on-scroll` classes to Elementor widgets. The structural sweep (Pass 2) catches `.col-*` children of `.row` containers, which Elementor outputs for multi-column sections.

### Elementor Pro Compatibility

Fully compatible. The theme does not override Elementor Pro's JS or CSS. The only shared concern is jQuery — the theme uses WordPress's bundled jQuery, which Elementor also uses.

---

## SEO Plugin Compatibility

The theme includes its own SEO stack (titles, meta descriptions, OG tags, JSON-LD schema). When a dedicated SEO plugin is installed, the theme's SEO outputs are **automatically suppressed** to prevent duplicates.

### Detection Logic

The following plugins are detected and cause theme SEO outputs to defer:

| Plugin | Detection Constant |
|---|---|
| Yoast SEO | `WPSEO_VERSION` |
| Rank Math | `RANK_MATH_VERSION` |
| All in One SEO | `AIOSEO\Plugin\AIOSEO` class |
| SEOPress | `SEOPRESS_VERSION` |

### What the Theme Still Handles (plugin-independent)

- `wp_robots` filter — noindex rules for utility pages (favoris, compare, checkout)
- Sitemap exclusions via `wp_sitemaps_posts_query_args`
- robots.txt extensions via `robots_txt` filter

These do not conflict with any SEO plugin.

---

## Cache Plugin Compatibility

### LiteSpeed Cache (Hostinger default)

- All theme CSS and JS uses WordPress handles — LiteSpeed can combine/minify them safely
- Recommended: exclude `murailles-slick` from JS combine (carousels are timing-sensitive)
- The scroll animation CSS uses `filemtime()` versioning — cache-bust happens automatically on file edit

### WP Rocket

- JS loads in footer — compatible with "Load JS Deferred"
- Compatible with "Delay JS execution" — `scroll-animations.js` has no globals needed by other scripts
- **Recommended exclusion:** Add `/assets/js/slick.js` to the Delay JS exclusion list (carousels must initialize before the observer fires)

### W3 Total Cache

- Compatible with Page Cache, Browser Cache, and Minify modes
- No `document.write` in any theme JS — safe for async/defer minification

### Autoptimize

- Compatible with JS and CSS combine/minify
- `scroll-animations.js` uses only `document`, `window`, and `IntersectionObserver` — no globals that would break after minification

---

## Troubleshooting

### Animations Not Working

**Check 1: Is the JS loading?**

Open browser DevTools → Network → filter by JS → look for `scroll-animations.js`. It should return HTTP 200.

If it's 404: the file path is wrong. Verify the file exists at `assets/js/scroll-animations.js` inside the active theme folder.

**Check 2: Is the CSS loading?**

In DevTools → Network → filter by CSS → look for `scroll-animations.css`. If 404, same path issue.

**Check 3: Is there a JS error?**

Open DevTools → Console. Any error before `scroll-animations.js` runs will prevent the `DOMContentLoaded` listener from firing. Fix upstream errors first.

**Check 4: Is a cache plugin serving a stale version?**

Clear all caches (LiteSpeed, WP Rocket, browser cache) and hard-reload (Ctrl+Shift+R).

**Check 5: Is `prefers-reduced-motion` active?**

On macOS: System Preferences → Accessibility → Display → Reduce Motion. On Windows: Settings → Ease of Access → Display → Show animations. If active, no animations run — this is correct behavior.

---

### Animations Work Locally But Not on Production

**Cause 1: CSS/JS file permissions**

Files must be readable by the web server. Set file permissions to `644` and directory permissions to `755` via cPanel File Manager or FTP.

**Cause 2: URL mismatch after migration**

If `get_stylesheet_directory_uri()` returns the wrong URL on production, the CSS/JS will 404. Verify the `siteurl` and `home` options in the database match the production domain (see Migration Step 3).

**Cause 3: Cache plugin minification breaks the IIFE**

The script is wrapped in an IIFE `(function(){...}())`. Some aggressive minifiers break this. Test by temporarily disabling JS minification in your cache plugin.

**Cause 4: LiteSpeed combining scroll-animations.js with jQuery-dependent scripts**

The animation script is vanilla (no jQuery), but if combined into a bundle that loads after a broken script, it may not execute. Exclude `murailles-scroll-animations` from JS combine.

---

### Elementor Conflict

**Symptom:** Elementor editor is slow or elements are invisible when editing.

**Diagnosis:** The animation JS should never run inside the editor iframe. Open the editor, open the browser console inside the editor frame — if you see the `js-scroll-ready` class on `<html>`, the guard failed.

**Fix:** Verify `body.wp-admin` is present on the editor body element. In recent Elementor versions it always is. If using a custom Elementor template that removes this class, add a manual exclusion:

```js
// In scroll-animations.js, add to the guards section:
if (body.classList.contains('elementor-editor-active')) { return; }
```

---

### Cache Conflict

**Symptom:** Animations worked before enabling the cache plugin, broken after.

**Step 1:** Disable all JS optimization in the cache plugin and test.
**Step 2:** Re-enable options one by one: Page Cache → CSS Minify → JS Minify → JS Combine → Delay JS.
**Step 3:** The option that breaks animations is the one causing the issue. Either exclude `scroll-animations.js` from that option or leave it disabled for that file.

---

## Performance Notes

### Why IntersectionObserver

`IntersectionObserver` fires asynchronously off the main thread, unlike scroll event listeners which fire synchronously on every scroll pixel. This means animations have zero impact on scroll performance (INP score).

### Why jQuery Was Avoided

The animation system requires no DOM manipulation beyond adding CSS classes. Using jQuery for this would add ~87KB of dependency for three method calls. Vanilla `classList.add` is faster, smaller, and has no version conflict risk.

### Why Layout Shifts Are Prevented

`.animate-on-scroll.fade-in` uses `opacity` only — no transform. `.fade-up` and `.slide-*` use `transform: translate*()` which is handled entirely by the compositor thread and never causes reflow. The element's box dimensions do not change during the animation.

### Why the Solution Is Lightweight

- `scroll-animations.js`: ~4KB unminified, ~1.8KB gzipped
- `scroll-animations.css`: ~2KB unminified, ~0.8KB gzipped
- Zero external dependencies
- Zero npm packages
- Zero build step required

---

## Security Notes

### Safe Enqueue Methods

CSS and JS are loaded exclusively via `wp_enqueue_style()` and `wp_enqueue_script()`. These functions:

- Prevent double-loading
- Automatically output proper `<link>` and `<script>` tags
- Respect WordPress's script dependency graph

### No Direct File Access

All PHP files begin with:

```php
if ( ! defined( 'ABSPATH' ) ) { exit; }
```

This prevents direct HTTP requests to PHP files from executing any code.

### No External JS Dependencies

The animation system loads no third-party JavaScript. There is no CDN dependency, no third-party domain in the JS execution path, and no `eval()` or `Function()` calls.

---

## Maintenance Guide

### Updating scroll-animations.css

1. Edit the file directly — `filemtime()` versioning in `functions.php` automatically busts the browser cache on next page load
2. Test with DevTools → Rendering → "Show paint flashing" — if green boxes appear during animation, a layout shift is occurring

### Updating scroll-animations.js

1. Edit the file directly — same `filemtime()` versioning applies
2. Test in: Chrome, Firefox, Safari, and mobile Chrome (Android)
3. Test with DevTools → Performance → record a scroll — verify no long tasks on the main thread

### Adding New Animated Components

**Option A — Add to NAMED_TARGETS (recommended for theme-specific classes):**

Open `scroll-animations.js`, find the `NAMED_TARGETS` array, and add an entry:

```js
{ sel: '.my-new-component', anim: 'fade-up' },
```

Available `anim` values: `fade-up`, `fade-in`, `slide-left`, `slide-right`, `zoom-in`, `stagger`

**Option B — HTML class (for one-off elements):**

Add classes directly in the template:

```html
<div class="animate-on-scroll fade-up anim-delay-2">...</div>
```

The JS will not re-process elements that already have `animate-on-scroll`.

### Testing Future WordPress Updates

Before each major WordPress update:

1. Create a staging clone of the site
2. Apply the update on staging
3. Verify: scroll down the homepage — do cards animate?
4. Verify: open Elementor editor — does it load without console errors?
5. Verify: check the browser console for JS errors on the frontend

The animation system has no dependency on WordPress core APIs (it only uses `wp_enqueue_script` and `wp_enqueue_style` for loading). It is safe from WordPress core updates.

---

## Deployment Checklist

Run this checklist before going live:

### Files

- [ ] `logo.png` uploaded to `assets/images/`
- [ ] `logo-light.png` uploaded to `assets/images/`
- [ ] `villa-luxe-marrakech-hero.webp` uploaded to `assets/images/`
- [ ] `wp-config.php` updated with production DB credentials
- [ ] SMTP constants added to `wp-config.php`
- [ ] `WP_DEBUG` set to `false`

### Database

- [ ] Database exported from localhost
- [ ] Database imported to production
- [ ] Search-replace run: `http://localhost/wordpress` → `https://yourdomain.com`
- [ ] Permalinks flushed (Settings → Permalinks → Save)

### Verification

- [ ] Homepage loads without 404 errors
- [ ] CSS loads: inspect DevTools → no 404 for `scroll-animations.css`
- [ ] JS loads: inspect DevTools → no 404 for `scroll-animations.js`
- [ ] No console errors on homepage
- [ ] Scroll down homepage — cards animate in
- [ ] Test on mobile (Chrome Android)
- [ ] Test on Safari (iOS)
- [ ] Open Elementor editor on a page — editor loads without lag
- [ ] Contact form submits and email is received
- [ ] SEO plugin active and outputting correct meta tags
- [ ] Cache plugin enabled — animations still work after clearing cache
- [ ] HTTPS enabled and SSL certificate valid
- [ ] Google Search Console: submit sitemap at `https://yourdomain.com/wp-sitemap.xml`

---

## Contact & Support

**Agency:** Agence Murailles Immobilier  
**Developer:** CodeSommet  
**Theme Version:** 1.0.0  
**Last Audited:** 2026-06-09
