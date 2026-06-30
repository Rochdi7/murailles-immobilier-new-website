<?php
/**
 * Plugin Name: Murailles — .htaccess Guard
 * Description: Guarantees the root .htaccess always keeps (1) the admin-asset
 *              allow rule for load-styles.php / load-scripts.php and (2) the
 *              One.com CORS response headers — every time WordPress, the theme,
 *              Polylang, or any plugin regenerates the rewrite rules. Without
 *              this, a flush_rewrite_rules() call rewrites the root .htaccess and
 *              can drop those rules, which 403s the wp-admin CSS/JS and breaks
 *              the dashboard (the "GGGG" / jQuery-not-defined symptom).
 *
 *              Loaded as a must-use plugin so the filter is always registered,
 *              independently of the active theme. Safe to remove only once the
 *              hosting stack is guaranteed never to rewrite root .htaccess.
 *
 * Author:      Agence Murailles
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The required directives that must always survive an .htaccess regeneration.
 *
 * These are injected INSIDE the `# BEGIN WordPress` / `# END WordPress` managed
 * block (via the mod_rewrite_rules filter) so that WordPress's own
 * insert_with_markers() writes them back every single time it rewrites the file.
 * That makes them impossible to lose to a core update, a theme flush, Polylang,
 * or any plugin's flush_rewrite_rules() call.
 *
 * Production .htaccess uses RewriteBase / (the live one.com site).
 */
if ( ! function_exists( 'murailles_htaccess_required_block' ) ) {
	/**
	 * @return string Directives to prepend inside the WP-managed rewrite block.
	 */
	function murailles_htaccess_required_block() {
		return <<<HTACCESS
# Murailles guard BEGIN — do not remove (keeps wp-admin assets reachable)
<FilesMatch "^(load-styles|load-scripts)\.php\$">
    Require all granted
</FilesMatch>

# One.com response headers BEGIN
<IfModule mod_headers.c>
    <FilesMatch "\.(ttf|ttc|otf|eot|woff|woff2|css|js|png|jpg|jpeg|svg|pdf|json)\$">
        Header set Access-Control-Allow-Origin "https://murailles-immobilier.com"
    </FilesMatch>
</IfModule>
# One.com response headers END
# Murailles guard END
HTACCESS;
	}
}

/**
 * Re-inject the required directives whenever WordPress regenerates the rewrite
 * rules. The `mod_rewrite_rules` filter receives the full text WordPress is
 * about to write between the `# BEGIN WordPress` markers; we prepend our block.
 *
 * Idempotent: if the guard markers are already present (e.g. WordPress passes
 * back rules that already include them), we don't add a second copy.
 *
 * @param string $rules The rewrite rules WordPress is about to write.
 * @return string Rules with the guard block guaranteed at the top.
 */
add_filter(
	'mod_rewrite_rules',
	function ( $rules ) {
		if ( ! is_string( $rules ) ) {
			return $rules;
		}

		// Already injected on this pass — leave as-is.
		if ( false !== strpos( $rules, '# Murailles guard BEGIN' ) ) {
			return $rules;
		}

		return murailles_htaccess_required_block() . "\n\n" . $rules;
	},
	10,
	1
);
