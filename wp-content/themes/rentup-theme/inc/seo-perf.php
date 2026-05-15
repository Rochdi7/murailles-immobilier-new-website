<?php
/**
 * Performance, crawlability, and discovery improvements.
 *
 *   • Preconnect to FontAwesome CDN so the first paint isn't blocked
 *     waiting for DNS + TLS handshake.
 *   • Async/defer non-critical theme JS.
 *   • Lazy-load images outside the viewport via WP's native loading="lazy"
 *     (and decoding="async") — WP core handles most of this, we just turn
 *     it on for older themes that opted out.
 *   • Add fetchpriority="high" to the hero image so LCP is measured against
 *     the right element.
 *   • robots.txt: WP serves a virtual one, but we extend it to point to
 *     the Polylang-aware sitemap index.
 *   • Sitemap: WP core's wp-sitemap.xml already includes Polylang's per-language
 *     entries when Polylang is active; we just make sure the property CPT is
 *     included and tweak priorities.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * DNS prefetch + preconnect to external origins we know are used on every page.
 */
add_action( 'wp_head', function () {
	?>
	<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
	<link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
	<?php
}, 1 );

/**
 * Add defer to non-critical theme scripts. Keeps jQuery synchronous (some
 * page builders / inline scripts depend on $ being available immediately).
 */
add_filter( 'script_loader_tag', function ( $tag, $handle ) {
	$defer = array(
		'murailles-compare', 'murailles-favoris', 'murailles-dropdown',
		'murailles-uploader', 'murailles-single-property',
		'slick', 'magnific-popup', 'ion-rangeslider', 'lightbox', 'dropzone',
		'fontawesome', 'murailles-fa6',
	);
	foreach ( $defer as $h ) {
		if ( $handle === $h && strpos( $tag, 'defer' ) === false ) {
			$tag = str_replace( '<script ', '<script defer ', $tag );
			break;
		}
	}
	return $tag;
}, 10, 2 );

/**
 * Ensure the hero image on the front page gets fetchpriority="high" and
 * is NOT lazy-loaded (it's the LCP element). WP core's loading="lazy" is
 * smart about above-the-fold images, but the hero background-image on
 * front-page.php is set via inline CSS so WP can't auto-detect it. We
 * preload it explicitly.
 */
add_action( 'wp_head', function () {
	if ( ! is_front_page() ) { return; }
	if ( ! function_exists( 'murailles_img' ) ) { return; }
	$hero = murailles_img( 'banner-home.jpg' );
	if ( ! $hero ) { return; }
	printf(
		'<link rel="preload" as="image" href="%s" fetchpriority="high">' . "\n",
		esc_url( $hero )
	);
}, 2 );

/**
 * Force loading="lazy" + decoding="async" on every image in the_content()
 * that doesn't already declare it. WP core does this for new posts, but
 * older content / embedded images may not have it.
 */
add_filter( 'wp_get_attachment_image_attributes', function ( $attr, $attachment, $size ) {
	if ( empty( $attr['loading'] ) )  { $attr['loading']  = 'lazy'; }
	if ( empty( $attr['decoding'] ) ) { $attr['decoding'] = 'async'; }
	return $attr;
}, 10, 3 );

/**
 * Polylang + directory mode hides /robots.txt behind language routing,
 * which makes requests 404. Intercept early and serve WP's virtual robots.txt.
 */
add_action( 'parse_request', function ( $wp ) {
	$req = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '';
	$path = (string) wp_parse_url( $req, PHP_URL_PATH );
	$install = (string) wp_parse_url( get_option( 'home' ), PHP_URL_PATH );
	$install = rtrim( $install, '/' );
	if ( $install && strpos( $path, $install ) === 0 ) {
		$path = substr( $path, strlen( $install ) );
	}
	if ( $path === '/robots.txt' || $path === '/wp-sitemap.xml' ) {
		// Let WP core handle it — it has the rewrites registered.
		$wp->query_vars = array();
		if ( $path === '/robots.txt' ) {
			$wp->query_vars['robots'] = '1';
		} else {
			$wp->query_vars['sitemap'] = 'index';
		}
		$wp->matched_query = $path === '/robots.txt' ? 'robots=1' : 'sitemap=index';
	}
}, 1 );

/**
 * Extend WP's virtual robots.txt with:
 *   • Disallow utility paths Google shouldn't crawl
 *   • Reference the sitemap index
 */
add_filter( 'robots_txt', function ( $output, $public ) {
	if ( ! $public ) { return $output; } // Site is set to discourage crawling — respect that.

	$additions  = "\n";
	$additions .= "Disallow: /favoris/\n";
	$additions .= "Disallow: /compare-property/\n";
	$additions .= "Disallow: /erreur/\n";
	$additions .= "Disallow: /checkout/\n";
	$additions .= "Disallow: /*?s=\n";          // search queries
	$additions .= "Disallow: /wp-admin/\n";     // already covered, repeat for older crawlers
	$additions .= "Allow: /wp-admin/admin-ajax.php\n";
	$additions .= "\nSitemap: " . esc_url_raw( home_url( '/wp-sitemap.xml' ) ) . "\n";

	// Append before the existing Sitemap line WP adds, if any.
	$output = rtrim( $output ) . "\n" . $additions;
	return $output;
}, 10, 2 );

/**
 * Make sure the property CPT and our published pages are included in the
 * core sitemap. WP includes all public post types and public taxonomies
 * by default, so this is a safety net — exclude only the 'attachment'
 * and noindex'd utility pages.
 */
add_filter( 'wp_sitemaps_post_types', function ( $post_types ) {
	// Remove attachment pages (they're indexed individually and dilute the sitemap).
	unset( $post_types['attachment'] );
	return $post_types;
}, 10, 1 );

/**
 * Exclude the noindex'd utility pages from the sitemap so Google doesn't
 * waste crawl budget on /favoris/, /compare-property/, /erreur/, etc.
 */
add_filter( 'wp_sitemaps_posts_query_args', function ( $args, $post_type ) {
	if ( $post_type !== 'page' ) { return $args; }
	$exclude_slugs = array( 'favoris', 'compare-property', 'erreur', 'checkout' );
	$ids = array();
	foreach ( $exclude_slugs as $slug ) {
		$p = get_page_by_path( $slug );
		if ( $p ) { $ids[] = (int) $p->ID; }
	}
	if ( $ids ) {
		$args['post__not_in'] = array_merge( (array) ( $args['post__not_in'] ?? array() ), $ids );
	}
	return $args;
}, 10, 2 );

/**
 * Strip Google-incompatible characters from auto-generated post excerpts.
 * Long dashes, smart quotes, and non-breaking spaces sometimes appear in
 * meta descriptions; normalize them for cleaner SERP snippets.
 */
add_filter( 'get_the_excerpt', function ( $excerpt ) {
	if ( ! $excerpt ) { return $excerpt; }
	$replace = array(
		"\xc2\xa0" => ' ',  // NBSP
		'…'        => '...',
		'—'        => '—',  // keep em-dash for FR
	);
	return strtr( $excerpt, $replace );
}, 99 );
