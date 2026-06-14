# Cache and SEO Plugin Compatibility

This theme is designed to let dedicated SEO plugins own frontend SEO output.
When Yoast SEO, Rank Math, AIOSEO, or SEOPress is active, the theme suppresses
its fallback title, meta description, canonical, robots, Open Graph, Twitter,
and schema output.

## Cache Plugin Settings

These settings are safe starting points for WP Rocket, LiteSpeed Cache, W3 Total
Cache, WP Super Cache, Autoptimize, Perfmatters, One.com Performance Cache Pro,
and Cloudflare APO/CDN.

- Enable page cache for public GET requests.
- Enable browser cache for static assets.
- Enable CSS minification.
- Enable JS minification only after testing the mobile menu, carousels, search forms, and submission forms.
- Enable defer JS cautiously; the theme scripts are footer-safe and dependency-aware.
- Do not cache POST requests, `admin-ajax.php`, REST API writes, login, or WordPress admin.
- Keep separate cache buckets for each Polylang language path and do not normalize `/fr/` and `/en/` into the same cache key.

## Recommended Page Exclusions

Exclude these pages from full-page cache if they exist on the production site:

- `/submit-property/`
- `/dashboard/`
- `/my-profile/`
- `/my-property/`
- `/messages/`
- `/checkout/`
- `/wp-login.php`
- `/wp-admin/`

Wishlist and compare pages are client-rendered from localStorage and can usually
stay cached. Exclude `/favoris/` and `/compare-property/` only if a cache plugin
snapshots user-specific rendered HTML after JavaScript execution.

## Recommended AJAX and Endpoint Exclusions

Never cache these endpoints:

- `/wp-admin/admin-ajax.php`
- `/wp-json/` for non-GET or authenticated requests
- Contact form submissions
- Newsletter form submissions
- Property inquiry submissions
- Property submission uploads
- Wishlist/compare AJAX property lookups

## Recommended Delay/Defer Exclusions

Minification is acceptable, but avoid delaying these handles because they affect
above-the-fold navigation, carousels, forms, or localStorage UI:

- `jquery-core`
- `jquery-migrate`
- `murailles-bootstrap`
- `murailles-custom`
- `murailles-dropdown`
- `murailles-slick`
- `murailles-wishlist-compare`
- `murailles-forms`
- `murailles-uploader`
- `murailles-single-property`

Optional libraries are conditionally loaded by the theme:

- `murailles-dropzone` only on the property submission page.
- `murailles-rangeslider` only where advanced property filters exist.
- `murailles-daterangepicker` only on legacy single-property templates with text date fields.
- `murailles-magnific`, `murailles-lightbox`, and `murailles-imagesloaded` only on property gallery pages.

## Server-Level Recommendations

Apply these at hosting/server level, not inside the theme:

- Force HTTPS with a 301 redirect on production.
- Remove `X-Powered-By` in PHP or web-server config. The theme also attempts to remove it with `header_remove()`.
- Enable gzip or Brotli compression for text assets.
- Cache static assets for 30 days to 1 year, with versioned URLs.
- Serve WebP images where supported.
- Add HSTS only after HTTPS is confirmed stable across the full domain and subdomains.

Example Apache rules for production only:

```apache
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteCond %{HTTPS} !=on
RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</IfModule>

<IfModule mod_headers.c>
Header unset X-Powered-By
<FilesMatch "\.(css|js|jpg|jpeg|png|gif|webp|svg|woff|woff2)$">
Header set Cache-Control "public, max-age=31536000, immutable"
</FilesMatch>
</IfModule>

<IfModule mod_deflate.c>
AddOutputFilterByType DEFLATE text/html text/plain text/css application/javascript application/json image/svg+xml
</IfModule>
```

Do not apply HTTPS/HSTS rules to local XAMPP unless local SSL is configured.
