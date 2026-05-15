<?php
/**
 * Plugin Name: Murailles — Force Polylang URL strategy
 * Description: Forces Polylang into directory mode with visible /fr/ + /en/
 *              prefixes and redirect from bare /. Loaded as a must-use plugin
 *              so the filter is registered BEFORE Polylang reads its options
 *              (Polylang caches them at plugin-load time, so a theme-level
 *              filter would be too late and would have no effect on its
 *              internal model — only this MU-plugin position works).
 * Author:      Agence Murailles
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_filter( 'option_polylang', function ( $opts ) {
	if ( ! is_array( $opts ) ) { return $opts; }
	$opts['force_lang']    = 1;     // Language from directory prefix
	$opts['hide_default']  = false; // French gets /fr/ prefix
	$opts['redirect_lang'] = true;  // Bare / -> /fr/
	$opts['rewrite']       = true;  // No /language/ ugly segment
	return $opts;
}, PHP_INT_MAX );

/**
 * Helpers: return a language-prefixed URL.
 *
 * Use `murailles_url('/contact/')` instead of `home_url('/contact/')` for any
 * raw path. `murailles_bien_url()` is the same thing pre-bound to the CPT
 * archive. Both always return /wordpress/fr/contact/ or /wordpress/en/contact/
 * depending on the current language, falling back to /wordpress/contact/ when
 * Polylang isn't active.
 */
if ( ! function_exists( 'murailles_url' ) ) {
	function murailles_url( $path = '/' ) {
		$path = '/' . ltrim( (string) $path, '/' );
		if ( function_exists( 'pll_current_language' ) ) {
			$lang = pll_current_language( 'slug' );
			if ( $lang ) {
				return home_url( '/' . $lang . $path );
			}
		}
		return home_url( $path );
	}
}

if ( ! function_exists( 'murailles_bien_url' ) ) {
	function murailles_bien_url() {
		return murailles_url( '/bien/' );
	}
}

/**
 * Disable Polylang's canonical-redirect for pages so /en/blog/, /en/contact/,
 * etc. don't bounce to /fr/. Polylang normally redirects to what it thinks the
 * canonical URL is — but with aligned FR/EN slugs (intentional, so /en/blog/
 * and /fr/blog/ both work), Polylang's notion of "canonical" wrongly points
 * each EN URL back to the FR equivalent. We trust the request URL instead.
 */
remove_filter( 'template_redirect', 'redirect_canonical' );
add_filter( 'redirect_canonical', '__return_false', 999 );

/**
 * When WordPress's page-lookup finds the wrong post because two languages
 * share the same slug, force it to the post matching the current language.
 * Hooks into `posts_results` early, before the main query gets the wrong post.
 */
add_filter( 'parse_request', function ( $wp ) {
	if ( is_admin() || ! function_exists( 'pll_current_language' ) ) { return; }
	// Only act when WP is resolving a page by name (pagename query var set).
	$pagename = isset( $wp->query_vars['pagename'] ) ? $wp->query_vars['pagename'] : '';
	$name     = isset( $wp->query_vars['name'] )     ? $wp->query_vars['name']     : '';
	$slug     = $pagename ?: $name;
	if ( $slug === '' ) { return; }

	$lang = pll_current_language( 'slug' );
	if ( ! $lang ) { return; }

	// Find ALL published posts/pages with this slug (across languages).
	global $wpdb;
	$rows = $wpdb->get_results( $wpdb->prepare(
		"SELECT ID, post_type FROM {$wpdb->posts}
		 WHERE post_name = %s AND post_status = 'publish'
		   AND post_type IN ('page','post','property')",
		$slug
	) );
	if ( ! $rows || count( $rows ) < 2 ) { return; } // No conflict.

	// Pick the one matching the current language.
	foreach ( $rows as $row ) {
		$row_lang = pll_get_post_language( (int) $row->ID, 'slug' );
		if ( $row_lang === $lang ) {
			// Rewrite the query vars to target the matching post by ID.
			$wp->query_vars['page_id'] = (int) $row->ID;
			unset( $wp->query_vars['pagename'], $wp->query_vars['name'] );
			$wp->matched_query = 'page_id=' . $row->ID;
			return;
		}
	}
}, 5 );

/**
 * Catch-all: when any code in the theme or third-party plugin calls
 * `home_url('/some-path/')` on the front-end, prepend the current language
 * slug if the URL doesn't already contain one.
 *
 * Polylang already filters home_url() for actual WP page permalinks. The
 * problem is that path-style calls like `home_url('/submit-property/')`,
 * `home_url('/blog/')`, `home_url('/contact/')` bypass Polylang's filter
 * because the path doesn't map to a known translated page object — those
 * are the ones we need to fix.
 *
 * Guard logic:
 *   • Only on front-end requests (admin URLs stay raw — they go to /wp-admin/).
 *   • Only if $path is non-empty (bare home_url() is handled by Polylang).
 *   • Skip URLs that already start with /xx/ for a known language slug.
 *   • Skip wp-json, wp-admin, wp-login, xmlrpc paths.
 */
add_filter( 'home_url', function ( $url, $path, $orig_scheme, $blog_id ) {
	// Front-end only.
	if ( is_admin() && ! wp_doing_ajax() )             { return $url; }
	if ( ! function_exists( 'pll_current_language' ) ) { return $url; }

	// Bare home_url() — Polylang handles it correctly.
	if ( $path === '' || $path === null || $path === '/' ) { return $url; }

	// Normalize $path: caller wrote '/contact/', strip leading '/'.
	$norm_path = ltrim( (string) $path, '/' );

	// Skip system paths.
	if ( preg_match( '#^(wp-json|wp-admin|wp-login|xmlrpc|wp-content|wp-includes)#', $norm_path ) ) {
		return $url;
	}

	// Critical: when Polylang or WordPress is computing the canonical URL of
	// an actual post (for redirect_canonical, post permalinks, sitemap, etc.),
	// the URL already has a slash-segment that maps to a real post slug. Trust
	// those — only intervene for paths that DON'T correspond to a real post,
	// which means the caller is doing a manual home_url('/something/') and we
	// need to add the language prefix to make it work.
	//
	// Detect "real post path" by stripping query / fragment / trailing slash
	// and seeing if any published post has that slug in the current language.
	$probe = $norm_path;
	if ( false !== ( $q = strpos( $probe, '?' ) ) ) { $probe = substr( $probe, 0, $q ); }
	if ( false !== ( $q = strpos( $probe, '#' ) ) ) { $probe = substr( $probe, 0, $q ); }
	$probe = trim( $probe, '/' );
	// If $url already includes any known language prefix, Polylang has handled
	// it; bail out so we don't double-prefix.
	$lang = pll_current_language( 'slug' );
	if ( ! $lang ) { return $url; }

	static $known_langs = null;
	if ( $known_langs === null ) {
		$known_langs = function_exists( 'pll_languages_list' )
			? (array) pll_languages_list( array( 'fields' => 'slug' ) )
			: array( 'fr', 'en' );
	}

	// Skip if requested $path itself already has a known lang prefix.
	foreach ( $known_langs as $slug ) {
		if ( preg_match( '#^' . preg_quote( $slug, '#' ) . '(/|$)#', $norm_path ) ) {
			return $url;
		}
	}

	// Skip if $url already contains /lang/ in the URL string (Polylang
	// already filtered it). Check just after the install path.
	static $install_path = null;
	if ( $install_path === null ) {
		$install_path = rtrim( (string) wp_parse_url( get_option( 'home' ), PHP_URL_PATH ), '/' );
	}
	foreach ( $known_langs as $slug ) {
		if ( strpos( $url, $install_path . '/' . $slug . '/' ) !== false
		     || strpos( $url, $install_path . '/' . $slug . '?' ) !== false
		     || preg_match( '#' . preg_quote( $install_path . '/' . $slug, '#' ) . '$#', $url ) ) {
			return $url;
		}
	}

	// Get the raw site root from the option (avoid recursive home_url() call).
	static $site_root = null;
	if ( $site_root === null ) {
		$site_root = rtrim( get_option( 'home' ), '/' );
	}

	// Split query / fragment off before prefixing.
	$query = '';
	$fragment = '';
	if ( false !== ( $q = strpos( $norm_path, '#' ) ) ) {
		$fragment = substr( $norm_path, $q );
		$norm_path = substr( $norm_path, 0, $q );
	}
	if ( false !== ( $q = strpos( $norm_path, '?' ) ) ) {
		$query = substr( $norm_path, $q );
		$norm_path = substr( $norm_path, 0, $q );
	}

	// With FR/EN sharing the same slug (e.g. both /fr/contact/ and /en/contact/
	// point to their respective language's "contact" page), we don't need to
	// look up per-language slugs. Just prefix with the current language.

	$rebuilt = $site_root . '/' . $lang . '/' . $norm_path;
	if ( $norm_path !== '' && substr( $norm_path, -1 ) !== '/' && strpos( basename( $norm_path ), '.' ) === false ) {
		$rebuilt .= '/';
	}
	return $rebuilt . $query . $fragment;
}, 20, 4 );

/**
 * Language switcher: when the current page has no translation in the target
 * language, Polylang gives the switcher an empty URL and the browser ends up
 * back on the language home. With aligned slugs (see DB migration), every
 * published FR page now has an EN translation at the same slug — so the
 * switcher resolves correctly without us needing a fallback filter.
 *
 * We only step in as a safety net: if a translation URL exists, keep it; if
 * it's empty (shouldn't happen anymore, but for orphan posts/properties),
 * stay on the same path under the target language so the user doesn't jump
 * back to the home page mid-browsing.
 */
add_filter( 'pll_translation_url', function ( $url, $lang ) {
	if ( $url ) { return $url; }

	// Build a same-path-different-prefix fallback: swap /fr/ for /en/ (or vice versa)
	// in the current request URI. Better than dumping the user on /en/.
	if ( ! empty( $_SERVER['REQUEST_URI'] ) ) {
		$req = wp_parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
		$req = (string) $req;
		// Strip the WP install path (e.g. /wordpress).
		$install = wp_parse_url( get_option( 'home' ), PHP_URL_PATH );
		$install = is_string( $install ) ? rtrim( $install, '/' ) : '';
		if ( $install && strpos( $req, $install ) === 0 ) {
			$req = substr( $req, strlen( $install ) );
		}
		// Replace any known lang prefix with the target lang.
		$known = function_exists( 'pll_languages_list' )
			? (array) pll_languages_list( array( 'fields' => 'slug' ) )
			: array( 'fr', 'en' );
		$pattern = '#^/(' . implode( '|', array_map( 'preg_quote', $known ) ) . ')(/|$)#';
		if ( preg_match( $pattern, $req ) ) {
			$swapped = preg_replace( $pattern, '/' . $lang . '$2', $req, 1 );
		} else {
			$swapped = '/' . $lang . $req;
		}
		return rtrim( get_option( 'home' ), '/' ) . $swapped;
	}

	return home_url( '/' . $lang . '/' );
}, 10, 2 );

/**
 * Persist the current language across navigation:
 * Polylang's default cookie is `pll_language`, but it can get stuck when
 * users navigate via raw home_url() links (the cookie says "en" but the URL
 * has no /en/ prefix). When Polylang detects a mismatch between the cookie
 * and the URL, it should trust the URL — set the cookie to match what the
 * URL says, not what was previously cached.
 */
add_action( 'wp', function () {
	if ( ! function_exists( 'pll_current_language' ) ) { return; }
	if ( is_admin() || headers_sent() ) { return; }
	$current = pll_current_language( 'slug' );
	if ( ! $current ) { return; }
	$cookie = isset( $_COOKIE['pll_language'] ) ? sanitize_key( $_COOKIE['pll_language'] ) : '';
	if ( $cookie !== $current ) {
		setcookie( 'pll_language', $current, time() + YEAR_IN_SECONDS, COOKIEPATH ?: '/', COOKIE_DOMAIN );
		$_COOKIE['pll_language'] = $current;
	}
}, 5 );
