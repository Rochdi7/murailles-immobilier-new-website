# PRE-DEPLOYMENT CHECKLIST — Murailles Immobilier
## Target: One.com Managed WordPress | PHP 8.3 | WordPress 6.8+
## Generated: 2026-06-12

---

## ⛔ CRITICAL — Fix before deploying (will cause white screen / fatal errors)

### [ ] WP-01 — Fix `wp_deregister_script('jquery')` breaking all plugins
**File:** `functions.php` line 143
**Problem:** De-registering `jquery` handle then re-registering at `in_footer:true` breaks any
plugin that depends on jQuery being in `<head>`. Confirmed cause of "critical error" on Hostinger.
**Fix:**
```php
// Remove lines 143-144. Replace with:
add_action('wp_enqueue_scripts', function() {
    wp_deregister_script('jquery');
    wp_register_script('jquery',
        get_template_directory_uri() . '/assets/js/jquery.min.js',
        array(), '3.6.0', false  // false = load in <head>, not footer
    );
    wp_enqueue_script('jquery');
}, 0);
```

---

### [ ] QUAL-02 — Define missing `murailles_lang_switcher_fallback()` function
**File:** `inc/i18n.php` — function is called on line 91 and 101 but NEVER defined
**Problem:** `PHP Fatal error: Call to undefined function murailles_lang_switcher_fallback()`
on any site without Polylang or with only one language. This is LIKELY THE MAIN CAUSE of
the "critical error" screen after theme activation.
**Fix:** Add this function to `inc/i18n.php` before `murailles_lang_switcher()`:
```php
function murailles_lang_switcher_fallback() {
    $current = murailles_current_lang();
    $other   = $current === 'fr' ? 'en' : 'fr';
    $url     = add_query_arg( 'lang', $other, home_url( add_query_arg( array() ) ) );
    ?>
    <li class="murailles-lang-switcher">
        <a href="<?php echo esc_url( $url ); ?>" class="btn btn-order-by-filt"
           title="<?php esc_attr_e( 'Choisir la langue', 'murailles' ); ?>">
            <?php echo esc_html( strtoupper( $other ) ); ?>
        </a>
    </li>
    <?php
}
```

---

### [ ] WP-03 — Remove `murailles_create_pages()` call from `admin_notices` hook
**File:** `functions.php` line 609
**Problem:** `murailles_create_pages()` runs 50+ SQL queries. Calling it inside `admin_notices`
means those 50+ queries execute on EVERY admin page load until the option is set.
On shared hosting this triggers the 30-second execution timeout → "critical error" screen.
**Fix:**
```php
// Replace murailles_admin_setup_notice() entirely:
function murailles_admin_setup_notice() {
    if ( get_option( 'murailles_pages_created' ) ) { return; }
    $url = wp_nonce_url( add_query_arg( 'murailles_run_setup', '1', admin_url() ), 'murailles_setup' );
    echo '<div class="notice notice-warning is-dismissible"><p>';
    echo '<strong>Agence Murailles:</strong> Les pages du thème n\'ont pas encore été créées. ';
    echo '<a href="' . esc_url( $url ) . '" class="button button-primary">Créer les pages maintenant</a>';
    echo '</p></div>';
}
add_action( 'admin_notices', 'murailles_admin_setup_notice' );

// Handle the button click:
add_action( 'admin_init', function () {
    if ( ! isset( $_GET['murailles_run_setup'] ) ) { return; }
    check_admin_referer( 'murailles_setup' );
    if ( ! current_user_can( 'manage_options' ) ) { return; }
    murailles_create_pages();
    wp_redirect( add_query_arg( 'murailles_setup_done', '1', admin_url() ) );
    exit;
} );
```

---

### [ ] ONE-01 — Create correct One.com `.htaccess` (not Hostinger config)
**File:** `DEPLOY/htaccess-production.txt`
**Problem:** Current file is labeled for Hostinger. One.com uses LiteSpeed Web Server.
Verify with One.com support whether `.htaccess` customization is permitted on their
Managed WordPress plan (they often manage it centrally).

**One.com-compatible minimal .htaccess:**
```apache
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress

# Protect wp-config.php
<Files wp-config.php>
Require all denied
</Files>
```
Note: HTTPS on One.com is enforced via their dashboard, not .htaccess.
Note: `<FilesMatch>` blocks on theme PHP files are NOT needed — WordPress's
`ABSPATH` guards already prevent direct PHP access.

---

### [ ] ONE-02 — Add MIME validation to unauthenticated file upload
**File:** `inc/forms.php` line 648
**Problem:** No explicit MIME check before `media_handle_upload()`. WP core does validate
internally but only if `finfo` extension is available. Defense-in-depth required.
**Fix:** Add inside the `foreach ($_FILES['gallery']['name'] as $i => $name)` loop:
```php
// After the error check at line 649, add:
$allowed_types = array( 'image/jpeg', 'image/png', 'image/webp', 'image/gif' );
if ( ! in_array( $_FILES['gallery']['type'][ $i ], $allowed_types, true ) ) {
    continue;
}
$max_size = 5 * 1024 * 1024; // 5MB per file
if ( $_FILES['gallery']['size'][ $i ] > $max_size ) {
    continue;
}
```

---

## 🔴 HIGH — Fix before going live (bugs, security, compatibility)

### [ ] PHP-02 — Fix `$_FILES` superglobal overwritten in upload loop
**File:** `inc/forms.php` line 659
**Problem:** `$_FILES = array('gallery_single' => ...)` destroys the original $_FILES after
iteration 1, meaning only the first uploaded image is ever processed.
**Fix:**
```php
// Replace the $_FILES assignment pattern:
$tmp_files_backup = $_FILES;
$_FILES = array( 'gallery_single' => $single_file );
$attach_id = media_handle_upload( 'gallery_single', $post_id );
$_FILES = $tmp_files_backup;
```

---

### [ ] PHP-07 — Wrap `json_decode()` in try/catch for PHP 8.0+
**Files:** `inc/seo-advanced.php` lines 497, 552
**Problem:** PHP 8.0+ can throw `\ValueError` / `\JsonException` from `json_decode()`.
**Fix:**
```php
// Replace both json_decode() + json_last_error() patterns:
try {
    $decoded = json_decode( $val, false, 512, JSON_THROW_ON_ERROR );
} catch ( \JsonException $e ) {
    $decoded = null;
    $val = '';
}
if ( ! $decoded ) { /* skip */ }
```

---

### [ ] PLUG-01 — Add SEO plugin guard to Phase 3b OG override output
**File:** `inc/seo-advanced.php` line 515
**Problem:** Phase 3b `wp_head` filter at priority 6 outputs OG meta even when
Yoast/RankMath is active, creating duplicate OG tags.
**Fix:** Add one line at the start of the closure:
```php
add_filter( 'wp_head', function () {
    if ( murailles_seo_plugin_active() ) { return; }  // ADD THIS LINE
    if ( ! is_singular() ) { return; }
    // ... rest unchanged
}, 6 );
```

---

### [ ] QUAL-01 — Escape `bloginfo('name')` in `alt` attributes
**File:** `header.php` lines 43, 44, 54, 80 and all similar occurrences
**Fix:**
```php
// Replace:
alt="<?php bloginfo('name'); ?>"
// With:
alt="<?php echo esc_attr( get_bloginfo('name') ); ?>"
```

---

### [ ] QUAL-03 — Add rate limiting to form submissions
**File:** `inc/forms.php` — add to `murailles_form_is_legit()` function
**Fix:**
```php
function murailles_form_is_legit( $nonce_action ) {
    // Honeypot
    if ( ! empty( $_POST['_mw_hp_url'] ) ) { return false; }
    // Nonce
    if ( empty( $_POST['_murailles_nonce'] ) || ! wp_verify_nonce( $_POST['_murailles_nonce'], $nonce_action ) ) {
        return false;
    }
    // Timing
    if ( ! empty( $_POST['_murailles_ts'] ) ) {
        if ( time() - intval( $_POST['_murailles_ts'] ) < 2 ) { return false; }
    }
    // Rate limit — max 3 submissions per IP per hour  ← ADD THIS
    $ip_key = 'murailles_rate_' . md5( $_SERVER['REMOTE_ADDR'] ?? '' ) . '_' . $nonce_action;
    $count  = (int) get_transient( $ip_key );
    if ( $count >= 5 ) { return false; }
    set_transient( $ip_key, $count + 1, HOUR_IN_SECONDS );

    return true;
}
```

---

### [ ] QUAL-05 — Add `load_theme_textdomain()` call
**File:** `functions.php` — inside `murailles_theme_setup()` function
**Fix:**
```php
function murailles_theme_setup() {
    load_theme_textdomain( 'murailles', get_template_directory() . '/languages' );
    // ... rest of existing setup code unchanged
```

---

### [ ] ONE-04 — Configure WP-Cron for One.com
**File:** `DEPLOY/wp-config-production-template.php`
**Fix:** Add after the `DISALLOW_FILE_EDIT` line:
```php
// One.com uses server-side cron — disable WP pseudo-cron
define( 'DISABLE_WP_CRON', true );
define( 'ALTERNATE_WP_CRON', false );
```
Then in One.com cPanel → Cron Jobs, add:
```
*/15 * * * * wget -q -O - "https://yourdomain.com/wp-cron.php?doing_wp_cron=1" > /dev/null 2>&1
```

---

### [ ] ONE-05 — Add LiteSpeed Cache guard to `ob_start()` post-processor
**File:** `inc/seo-perf.php` line 301
**Fix:** Modify the `template_redirect` hook:
```php
add_action( 'template_redirect', function () {
    if ( is_admin() || is_feed() || wp_doing_ajax() || wp_doing_cron() ) { return; }
    // Skip when LiteSpeed Cache is active — it handles caching at a lower level
    // and our output buffer may not fire on cache hits.
    if ( defined( 'LSCWP_V' ) ) { return; }
    ob_start( function ( $html ) {
        // ... existing code unchanged
    } );
}, 0 );
```

---

### [ ] ONE-06 — Fill in all SMTP constants before deployment
**File:** `DEPLOY/wp-config-production-template.php`
Replace ALL `<<REPLACE>>` placeholders:
- `DB_NAME`, `DB_USER`, `DB_PASSWORD` — from One.com hPanel → MySQL
- All 8 `AUTH_KEY` / `SALT` values — generate at https://api.wordpress.org/secret-key/1.1/salt/
- `MURAILLES_SMTP_USER`, `MURAILLES_SMTP_PASS` — Gmail App Password
- `MURAILLES_LEAD_NOTIFY` — admin email for lead notifications

---

### [ ] WP-02 — Fix `get_page_by_path()` misuse for blog posts
**File:** `functions.php` line 662
**Fix:**
```php
// Replace:
if (get_page_by_path($p['slug'], OBJECT, 'post')) {
    continue;
}
// With:
$existing = get_posts(array(
    'name'           => $p['slug'],
    'post_type'      => 'post',
    'post_status'    => 'any',
    'posts_per_page' => 1,
    'fields'         => 'ids',
));
if ( $existing ) { continue; }
```

---

### [ ] SEC-05 — Use `X-Forwarded-For` header for real IP behind One.com proxy
**Files:** `inc/forms.php` lines 194, 327, 447
**Fix:**
```php
// Replace all: sanitize_text_field( $_SERVER['REMOTE_ADDR'] )
// With:
function murailles_get_client_ip() {
    if ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
        $ips = explode( ',', $_SERVER['HTTP_X_FORWARDED_FOR'] );
        return sanitize_text_field( trim( $ips[0] ) );
    }
    return sanitize_text_field( $_SERVER['REMOTE_ADDR'] ?? '' );
}
```

---

## 🟡 MEDIUM — Fix within first week after deployment

### [ ] PHP-01 / WP-05 — Fix `$term->last_updated` dynamic property
**File:** `inc/seo-perf.php` line 235
```php
// Replace:
$entry['lastmod'] = date('c', strtotime($term->last_updated ?? 'now'));
// With:
$entry['lastmod'] = date('c'); // WP_Term has no last_updated property
```

---

### [ ] PHP-03 — Replace closures with named functions in `register_meta()` auth_callback
**Files:** `inc/seo-advanced.php` line 44, `inc/seo-multilingual.php` line 120
**Fix:** Declare a named function, not a closure, so object cache drivers can serialize the schema:
```php
// Add to functions.php or a new inc/meta-helpers.php:
function murailles_meta_auth_edit( $allowed, $meta_key, $post_id ) {
    return current_user_can( 'edit_post', (int) $post_id );
}
function murailles_meta_auth_media( $allowed, $meta_key, $post_id ) {
    return current_user_can( 'edit_post', (int) $post_id );
}
// Replace all closure-based auth_callbacks with 'auth_callback' => 'murailles_meta_auth_edit'
```

---

### [ ] PLUG-02 — Move `pll_register_string()` to `init` hook, not per-render
**File:** `inc/i18n.php` line 29
**Fix:** In `inc/i18n-strings.php`, add a dedicated registration hook:
```php
add_action( 'init', function () {
    if ( ! function_exists( 'pll_register_string' ) ) { return; }
    global $murailles_i18n_dict;
    foreach ( array_keys( $murailles_i18n_dict ) as $string ) {
        pll_register_string( $string, $string, 'Murailles Immobilier', false );
    }
}, 5 );
```
Then remove the `pll_register_string()` call from `murailles_t()`.

---

### [ ] PLUG-06 — Add Slim SEO to SEO plugin detection
**Files:** `inc/seo.php` lines 30-32, `inc/seo-social.php` lines 69-71,
`inc/seo-schema.php` lines 80-82, `inc/seo-advanced.php` line 229
**Fix:** Add `|| defined('SLIM_SEO_VER')` to every plugin detection block.

---

### [ ] PERF-01 — Conditionally load heavy JS libraries
**File:** `functions.php` — inside `murailles_enqueue_scripts()`
**Fix:** Move these enqueues inside conditional blocks:
```php
// Only on property submission page:
if ( is_page_template( 'page-templates/submit-property.php' ) ) {
    wp_enqueue_script( 'murailles-dropzone', ... );
    wp_enqueue_script( 'murailles-daterangepicker', ... );
}
// Only on property archive + single property:
if ( is_post_type_archive( 'property' ) || is_singular( 'property' ) || is_page_template('page-templates/archive*') ) {
    wp_enqueue_script( 'murailles-rangeslider', ... );
    wp_enqueue_script( 'murailles-select2', ... );
}
```

---

### [ ] ONE-07 — Upload local logo files to eliminate remote URL dependency
**Action:** Copy `logo.webp` and `logo.png` to:
`wp-content/themes/rentup-theme/assets/images/logo.webp`
`wp-content/themes/rentup-theme/assets/images/logo.png`
The `murailles_img()` function already checks for local files first — once uploaded,
the remote `usercontent.one` fallback becomes unreachable.

---

### [ ] SEC-02 — Audit `_property_map_embed` output in templates
**Action:** Search all template files for `_property_map_embed` output and ensure it
is wrapped in `wp_kses()` with only `<iframe>` allowed:
```php
$allowed_map = array(
    'iframe' => array(
        'src' => true, 'width' => true, 'height' => true,
        'style' => true, 'allowfullscreen' => true, 'loading' => true,
        'title' => true, 'class' => true, 'frameborder' => true,
    ),
);
echo wp_kses( get_post_meta( $id, '_property_map_embed', true ), $allowed_map );
```

---

### [ ] SEO-02 — Use real OG image dimensions
**File:** `inc/seo-social.php` lines 102-103
**Fix:**
```php
if ( $image ) {
    printf( '<meta property="og:image" content="%s" />' . "\n", esc_url( $image ) );
    // Get real dimensions if it's an attachment URL
    $img_id = attachment_url_to_postid( $image );
    if ( $img_id ) {
        $meta = wp_get_attachment_image_src( $img_id, 'full' );
        if ( $meta ) {
            printf( '<meta property="og:image:width" content="%d" />' . "\n", (int) $meta[1] );
            printf( '<meta property="og:image:height" content="%d" />' . "\n", (int) $meta[2] );
        }
    } else {
        // Fallback for non-attachment images (remote URLs)
        printf( '<meta property="og:image:width" content="1200" />' . "\n" );
        printf( '<meta property="og:image:height" content="630" />' . "\n" );
    }
```

---

## 🟢 LOW — Polish after launch

### [ ] PHP-05 — Add `wp_unslash()` before nonce verification
**Files:** `inc/custom-post-types.php:724`, `inc/agent-post-type.php:221`, `inc/seo.php:333`
```php
// Replace e.g.:
if ( ! wp_verify_nonce( $_POST['murailles_property_nonce'], 'murailles_property_save' ) ) { return; }
// With:
if ( ! wp_verify_nonce( wp_unslash( $_POST['murailles_property_nonce'] ?? '' ), 'murailles_property_save' ) ) { return; }
```

### [ ] PHP-06 — Use `wp_date()` instead of `date()`
**File:** `inc/email-templates.php` line 27
```php
// Replace:
$year = date( 'Y' );
// With:
$year = wp_date( 'Y' );
```

### [ ] PERF-04 — Remove duplicate FontAwesome preload
**File:** `inc/seo-advanced.php` line 991
The `<link rel="preload">` for FA6 at priority 0 in `seo-advanced.php` duplicates the
`<link rel="preconnect">` in `seo-perf.php` and the stylesheet enqueue in `functions.php`.
Remove the preload from `seo-advanced.php` — the preconnect in `seo-perf.php` is sufficient.

### [ ] SEC-03 — Convert subscriber export to POST form
**File:** `inc/forms.php` lines 231-270
Change the export link to a `<form method="post">` so the nonce does not appear in URLs
and cannot leak via Referer headers.

### [ ] SEC-04 — Add custom capability types to internal CPTs
**File:** `inc/forms.php` lines 103, 122
```php
'capability_type' => array( 'murailles_lead', 'murailles_leads' ),
'map_meta_cap'    => true,
```
Then assign capabilities to the Administrator role in theme activation.

### [ ] WP-08 — Move `show_in_rest:true` into `agent-post-type.php` CPT registration
**File:** `inc/agent-post-type.php` line 49
Change `'show_in_rest' => false` to `true` directly in the CPT args,
then remove the `registered_post_type` mutation in `seo-advanced.php:189-194`.

---

## DEPLOYMENT ORDER

Execute fixes in this exact sequence:

1. Fix QUAL-02 (define `murailles_lang_switcher_fallback`) — prevents fatal on activation
2. Fix WP-01 (jQuery deregister) — prevents plugin conflicts
3. Fix WP-03 (admin_notices flood) — prevents timeout on activation
4. Fill ONE-06 (SMTP + DB credentials in wp-config)
5. Fix PHP-02 (`$_FILES` overwrite) — prevents image upload corruption
6. Fix PLUG-01 (SEO plugin OG guard) — before installing Rank Math/Yoast
7. Fix ONE-05 (LiteSpeed ob_start guard) — before enabling caching
8. Upload logo files (ONE-07) — eliminates remote dependency
9. Fix PHP-07 (JsonException) — before PHP 8.3 strict mode
10. All other HIGH items
11. Re-zip and deploy
12. After deployment: activate theme → run page setup → configure permalinks → install plugins
13. Apply MEDIUM fixes in first week
14. Apply LOW fixes before next plugin update cycle

---

## POST-DEPLOYMENT VERIFICATION CHECKLIST

- [ ] Home page loads without PHP warnings/notices (`WP_DEBUG=false` on production)
- [ ] Contact form submits and sends email
- [ ] Newsletter form submits and saves subscriber
- [ ] Property submission form uploads images correctly (test with 3 photos)
- [ ] Language switcher works (FR ↔ EN)
- [ ] All 50+ pages created by `murailles_create_pages()` exist
- [ ] XML sitemap accessible at `/wp-sitemap.xml`
- [ ] robots.txt accessible and contains `Sitemap:` directive
- [ ] Schema.org validated at https://validator.schema.org
- [ ] OG tags correct in https://developers.facebook.com/tools/debug/
- [ ] No duplicate meta description when Rank Math/Yoast active
- [ ] `debug.log` empty after 30 minutes of normal use
- [ ] Page speed score >70 on PageSpeed Insights
