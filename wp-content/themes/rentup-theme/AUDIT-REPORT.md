# Murailles Immobilier — Production Compatibility & Plugin Audit

**Theme:** `rentup-theme` (Murailles Immobilier v1.0.0)
**Audit date:** 2026-06-11
**Target stack:** WordPress 6.8+, PHP 8.3, Hostinger (LiteSpeed), MariaDB 10.11 / MySQL 8, Cloudflare

---

## Final Verdict: ⚠ READY WITH MINOR FIXES

The theme is architecturally sound: complete `ABSPATH` guards, ~2,200 escaping calls
across 75 files, proper hooks/enqueues, nonce + honeypot on every form, zero direct
SQL, zero dangerous PHP functions. The blockers are mostly operational and every
high-severity code issue is a 1–4 line fix.

### Scores

| Category                       | Score   |
|--------------------------------|---------|
| Compatibility (overall)        | 78/100  |
| Production Readiness           | 74/100  |
| SEO Plugin Compatibility       | 84/100  |
| Elementor Compatibility        | 72/100  |
| Royal Elementor Compatibility  | 65/100  |
| Security                       | 79/100  |
| Performance                    | 71/100  |

### Do NOT deploy until these 5 items are done

1. Configure SMTP credentials in `wp-config.php` (forms silently fail without it)
2. Delete or block the `DEPLOY/` directory inside the theme
3. Remove the jQuery deregister lines (`functions.php:141-142`)
4. Sanitize or disable SVG uploads (`functions.php:375-380`)
5. Guard `pre_get_document_title` against active SEO plugins (`inc/seo.php:31`)

---

## 🔴 Blockers

### BLOCKER-1 — SMTP not configured
**File:** `wp-config.php` (production)
All form handlers (`inc/forms.php`) send mail via `wp_mail()` over Gmail SMTP using
`MURAILLES_SMTP_*` constants. Until those constants are defined, **every contact /
review / newsletter / submit-property email silently fails** — leads are saved as
`murailles_lead` posts but nobody is notified.
**Fix:** Fill in all `<<REPLACE>>` values from `DEPLOY/wp-config-production-template.php`
(Gmail App Password required).

### BLOCKER-2 — Production wp-config not deployed
**File:** `DEPLOY/wp-config-production-template.php`
The template exists but must be copied to `public_html/wp-config.php` with fresh
salts (https://api.wordpress.org/secret-key/1.1/salt/), real DB credentials, and
`WP_DEBUG` set to `false`.

### BLOCKER-3 — DEPLOY/ directory publicly accessible
**File:** `DEPLOY/` (inside the theme)
`yoursite.com/wp-content/themes/rentup-theme/DEPLOY/wp-config-production-template.php`
is readable by anyone and exposes your infrastructure layout.
**Fix:** Delete the directory from the deployed theme, or block it:
```apache
RewriteRule ^wp-content/themes/rentup-theme/DEPLOY/ - [F,L]
```

---

## 🔴 High Severity

### H-1 — jQuery deregister breaks Elementor & plugin compatibility
**File:** `functions.php:141-142`
```php
wp_deregister_script('jquery');
wp_enqueue_script('jquery', $theme_uri . '/assets/js/jquery.min.js', array(), '3.6.0', true);
```
Replacing WordPress core jQuery is a known anti-pattern. It breaks Elementor's
editor (white screen / `jQuery is not defined`), WooCommerce, Jetpack, and WP
Rocket's deferred-jQuery logic. WordPress 6.7+ already ships jQuery 3.7.1.
**Fix:** Delete both lines and depend on core jQuery (`array('jquery')` in the
other enqueues already works).

### H-2 — SVG upload without sanitization (XSS vector)
**File:** `functions.php:375-380`
```php
$mimes['svg'] = 'image/svg+xml';
```
SVG files can carry `<script>` tags and `on*=` handlers. Any user with upload
capability (Author/Editor) could upload a malicious SVG that executes JS in the
admin and steals credentials.
**Fix:** Remove SVG support entirely (not needed for property photos) or add a
prefilter:
```php
add_filter('wp_handle_upload_prefilter', function ($file) {
    if ($file['type'] === 'image/svg+xml') {
        $content = file_get_contents($file['tmp_name']);
        if (preg_match('/<script|javascript:|on\w+\s*=/i', $content)) {
            $file['error'] = 'SVG contient du JavaScript — refusé.';
        }
    }
    return $file;
});
```

### H-3 — Bootstrap double-loading with Elementor / Royal Addons
**Files:** `functions.php:148` + bundled `styles.css`
The theme loads its own Bootstrap CSS + JS; Elementor Pro and Royal Elementor
Addons ship their own subsets. Symptoms: modal z-index conflicts, tooltips
initializing twice, popups that won't close.
**Fix:** Skip the theme Bootstrap JS when Elementor is active:
```php
if (! defined('ELEMENTOR_VERSION')) {
    wp_enqueue_script('murailles-bootstrap', ...);
}
```

### H-4 — Output buffer (`ob_start`) conflicts with LiteSpeed Cache & Elementor
**File:** `inc/seo-perf.php:226-300`
The theme registers an `ob_start()` callback on `template_redirect` (priority 0)
to regex-modify `<img>` tags. LiteSpeed Cache and Elementor both run their own
output buffers — nested buffers can double, strip, or reorder HTML.
**Fix:** Bail out when either is handling the response:
```php
add_action('template_redirect', function () {
    if (defined('LSCWP_V') || defined('LITESPEED_ON')) { return; }
    if (defined('ELEMENTOR_VERSION')
        && \Elementor\Plugin::$instance->preview->is_preview_mode()) { return; }
    ob_start(function ($html) { /* ... */ });
}, 0);
```

### H-5 — Cache "Delay JS" breaks scroll animations
**File:** `assets/js/scroll-animations.js`
WP Rocket / FlyingPress "Delay JS execution" postpones the script until first
interaction; elements already in viewport never get `data-anim-state="in"` and
sections stay un-animated.
**Fix:** Add `scroll-animations.js` to the cache plugin's "never delay" exclusion
list, and document this in deployment notes.

---

## 🟠 Medium Severity

### M-1 — `pre_get_document_title` not guarded against SEO plugins
**File:** `inc/seo.php:31`
The title filter fires at priority 10 even when Yoast/Rank Math is active —
whichever registers last wins, risking duplicate or wrong titles.
**Fix:** Add the same plugin guard used elsewhere, and lower priority to 1:
```php
add_filter('pre_get_document_title', function ($title) {
    if (defined('WPSEO_VERSION') || defined('RANK_MATH_VERSION') ||
        class_exists('AIOSEO\Plugin\AIOSEO') || defined('SEOPRESS_VERSION')) {
        return $title;
    }
    /* ... existing logic ... */
}, 1);
```

### M-2 — BreadcrumbList schema duplicates Yoast's
**File:** `inc/seo-schema.php:413-483`
The BreadcrumbList `wp_head` hook has **no** SEO-plugin suppression guard (the
Organization/WebSite hook does). With Yoast active, two BreadcrumbList blocks
are emitted.
**Fix:** Copy the guard from `seo-schema.php:80-82` into the breadcrumb hook.

### M-3 — Slim SEO & The SEO Framework not detected
**Files:** `inc/seo.php:159`, `inc/seo-social.php:47`, `inc/seo-schema.php:80`
The guard covers Yoast, Rank Math, AIOSEO, SEOPress only.
**Fix:** Extend in all three files:
```php
|| class_exists('SlimSEO\Plugin')
|| class_exists('The_SEO_Framework\Load')
```

### M-4 — File upload: no MIME pre-validation, no count cap
**File:** `inc/forms.php:643-668` (`murailles_handle_submit_property`)
`media_handle_upload()` validates internally, but there is no early MIME filter
and no limit on file count/total size — a public form can be abused for upload
flooding.
**Fix:**
```php
$allowed = array('image/jpeg', 'image/png', 'image/webp');
if (! in_array($_FILES['gallery']['type'][$i], $allowed, true)) { continue; }
if (count($uploaded_ids) >= 10) { break; }
```

### M-5 — Public AJAX endpoint without rate limiting
**File:** `inc/interactive.php:68-74` (`murailles_get_properties`)
Unauthenticated endpoint runs a `WP_Query` per call with unbounded ID lists.
**Fix:** Cap the input: `$ids = array_slice($ids, 0, 50);` — optionally add a
transient-based rate limiter per IP.

### M-6 — `$_SERVER['REQUEST_URI']` used unsanitized
**Files:** `inc/seo.php:181`, `inc/seo-perf.php:108`
Only used in `strpos()` comparisons (not output), but still bad practice.
**Fix:** `$req = esc_url_raw(wp_unslash($_SERVER['REQUEST_URI'] ?? ''));`

### M-7 — Hero LCP element is a CSS background-image
**File:** `front-page.php:18`
```php
<div class="image-cover hero_banner" style="background:url(...)">
```
Background images can't get `fetchpriority="high"`; the preload hint in
`seo-perf.php` only partially compensates. Estimated LCP penalty: 0.5–1 s.
**Fix:** Render the hero as an absolutely-positioned
`<img fetchpriority="high" loading="eager">` inside the container.

### M-8 — 18 JS files loaded globally on every page
**File:** `functions.php:135-210`
`daterangepicker`, `dropzone`, `magnific-popup`, `ion.rangeSlider`, `lightbox`
etc. are enqueued site-wide but used on a handful of templates.
**Fix:** Wrap each page-specific script in `is_singular('property')` /
`is_page_template(...)` conditions (the pattern already exists at lines 201-209).

### M-9 — Royal Elementor Addons: Select2 + modal conflicts
**Files:** `functions.php:154`, Bootstrap JS
Royal's Form widget loads its own Select2; the theme's copy can clobber it.
Royal popups + theme Bootstrap modals can both bind to the same triggers.
**Fix:**
```php
if (defined('RAEL_VERSION') || defined('RAEL_PRO_VERSION')) {
    wp_dequeue_script('murailles-select2');
}
```
Also note the `ob_start` img-rewriter (H-4) may mark Royal icon-widget images as
`aria-hidden` because they share `fa-` / `ti-` class prefixes.

### M-10 — Theme scroll animations vs Elementor Motion Effects
**File:** `assets/js/scroll-animations.js`
Both attach IntersectionObservers to the same sections → double-animation stutter.
**Fix:** `if (document.body.classList.contains('elementor-page')) return;`

### M-11 — TranslatePress / WPML compatibility gaps
**File:** `inc/i18n.php`
- `murailles_t()` only integrates Polylang; with WPML the switcher renders empty
  and `pll_register_string()` is a no-op.
- `esc_html()` inside `murailles_t()` runs before TranslatePress can capture the
  string, making some UI strings untranslatable with TP.
**Fix (optional, only if the client may switch plugins):** add WPML detection via
`ICL_SITEPRESS_VERSION` and a string-translation bridge.

---

## 🟡 Low Severity

### L-1 — Duplicate `Sitemap:` line in robots.txt
**File:** `inc/seo-perf.php:145` — WP core already appends one since 5.5.
**Fix:** `if (strpos($output, 'Sitemap:') === false) { ... }`

### L-2 — `og:type="product"` for properties
**File:** `inc/seo-social.php:63` — Facebook maps `product` to e-commerce cards.
**Fix:** Use `og:type="website"` for property pages.

### L-3 — Year-long language cookie without consent check
**File:** `inc/i18n.php:77` — `murailles_lang` cookie set unconditionally; a
GDPR/ePrivacy consideration for EU visitors.
**Fix:** Make it a session cookie or gate it behind the consent banner.

### L-4 — Default `wp_` table prefix in production template
**File:** `DEPLOY/wp-config-production-template.php:52`
**Fix:** Use a random prefix (e.g. `m8k2x_`) on the fresh production install.

### L-5 — `filemtime()` cache-busting on every request
**File:** `functions.php:111-128` — adds filesystem stat calls per page load;
fine on Hostinger, but switch to a constant version string if moving to a
read-only / containerized filesystem.

### L-6 — Page creation inside `admin_notices`
**File:** `functions.php:601-610` — `murailles_create_pages()` running from a
notice hook is non-standard (guarded by an option, so safe, but move it to
`after_switch_theme` only).

### L-7 — 14 duplicate vendor CSS files
**Files:** `assets/css/*.css` vs `assets/css/plugins/*.css` — identical copies
(bootstrap, slick, animation, etc.). Only `styles.css` is enqueued.
**Fix:** Delete one set to halve the theme's CSS footprint and avoid confusion.

### L-8 — Global lazy-loading filter can lazy-load the LCP image
**File:** `inc/seo-perf.php:93-101` — forces `loading="lazy"` on **all**
attachment images, overriding WP core's smarter skip-first-images logic.
**Fix:** Remove the filter or exempt the first image in each loop.

### L-9 — Font Awesome 6 from CDN
**File:** `functions.php:107` — external dependency (~80 KB, mostly unused
icons), extra DNS/TLS round-trip, breaks if cdnjs is down.
**Fix:** Self-host a subset of the icons actually used.

### L-10 — No Critical CSS
Three render-blocking stylesheets, no above-the-fold inlining. Acceptable at
launch; revisit with LiteSpeed Cache's CCSS feature enabled.

---

## 🔎 GEO / AI Search Recommendations

| # | Recommendation | Detail |
|---|----------------|--------|
| G-1 | Add `LocalBusiness` to the schema `@type` array | `['LocalBusiness','RealEstateAgent']` + `hasMap` (Google Business Profile CID), `currenciesAccepted`, `paymentAccepted` — enables local pack / Maps eligibility. `inc/seo-schema.php:98` |
| G-2 | Add `AggregateRating` to property schema | Review data already exists in WP comments (type `review` + `murailles_rating` meta) — surface it. |
| G-3 | Sync FAQ schema with template content | Q&A pairs are hardcoded in `inc/seo-schema.php:325-354`; if `faq.php` changes, they diverge. |
| G-4 | Lengthen schema descriptions | 60-word truncation (`seo-schema.php:221`) is under the passage-indexing sweet spot; aim 150+ words. |
| G-5 | Add `llms.txt` at site root | Declares AI-crawler access policy (Perplexity, Gemini, Claude). |
| G-6 | Add entity `sameAs` links | Wikidata / Google Business Profile URLs on the Organization node improve entity confidence. |

---

## ✅ What's Already Good

- **Escaping:** ~2,200 `esc_html/esc_attr/esc_url/sanitize_*` calls; no raw output found.
- **No SQL:** zero `$wpdb` usage; all data via WP APIs.
- **No dangerous PHP:** no `eval`, `exec`, `system`, `base64_decode`.
- **Forms:** nonce + honeypot + min-fill-time on every handler; leads persisted as CPT.
- **SEO plugin guards:** meta description, OG/Twitter, and Organization/WebSite
  schema all correctly suppress when Yoast/Rank Math/AIOSEO/SEOPress is active.
- **Schema coverage:** Organization, RealEstateAgent, WebSite+SearchAction,
  RealEstateListing (with Offer/Accommodation), BlogPosting, FAQPage,
  BreadcrumbList, CollectionPage/ItemList — comprehensive for the niche.
- **Polylang:** full integration with graceful degradation, per-language schema
  `inLanguage`, translation seeding, string registration.
- **PHP 8.3 / WP 6.8:** no deprecated constructs found.
- **Server compatibility:** Apache, Nginx, Cloudflare, MariaDB/MySQL all fine.

---

## Deployment Checklist

- [ ] Fill in `wp-config.php` from the DEPLOY template (DB, salts, SMTP)
- [ ] Delete `DEPLOY/` from the deployed theme
- [ ] Remove jQuery deregister (`functions.php:141-142`)
- [ ] Disable or sanitize SVG uploads
- [ ] Guard `pre_get_document_title` + BreadcrumbList against SEO plugins
- [ ] Add Slim SEO / SEO Framework to all plugin guards
- [ ] Add LiteSpeed/Elementor bail-outs around the `ob_start` buffer
- [ ] Add MIME whitelist + 10-file cap to the submit-property upload loop
- [ ] Cap `murailles_get_properties` AJAX at 50 IDs
- [ ] Fix duplicate `Sitemap:` line in robots.txt
- [ ] Exclude `scroll-animations.js` from cache-plugin Delay JS
- [ ] Random table prefix on the production database
- [ ] `WP_DEBUG = false`, `DISALLOW_FILE_EDIT = true`, `FORCE_SSL_ADMIN = true`
- [ ] Post-launch: hero `<img>` conversion, conditional JS enqueues, FA6 self-host,
      `LocalBusiness` schema, `llms.txt`
