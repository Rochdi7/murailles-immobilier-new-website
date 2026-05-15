<?php
/**
 * Internationalisation helpers — Polylang integration.
 *
 * The theme is built around Polylang (https://wordpress.org/plugins/polylang/).
 * All helpers below degrade gracefully when Polylang isn't installed:
 *
 *   - murailles_lang_switcher() renders nothing if no languages exist
 *   - murailles_t() falls back to its raw default string
 *   - murailles_current_lang() returns 'fr' by default
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Polylang-compatible translate-or-echo. Use anywhere a hard-coded UI
 * string would be: <?php murailles_t( 'Déposer une annonce' ); ?>
 *
 * The string is also registered for Polylang's string-translation panel so
 * the admin can translate it from Languages → Strings translations.
 */
function murailles_t( $default, $echo = true ) {
	// Register with Polylang's string-translation registry on every page load
	// (cheap: it's a static array lookup once registered).
	if ( function_exists( 'pll_register_string' ) ) {
		pll_register_string( $default, $default, 'Murailles Immobilier', false );
	}
	$out = function_exists( 'pll__' ) ? pll__( $default ) : $default;
	if ( $echo ) {
		echo esc_html( $out );
	}
	return $out;
}

/**
 * Current site language code (e.g. 'fr', 'en'). Defaults to 'fr'.
 *
 * Order of preference: Polylang → ?lang= query param → murailles_lang cookie
 * → default 'fr'. Keeps the URL stable on most pages while letting the user
 * pick a language from the header switcher; once picked, the cookie persists
 * the choice across visits.
 */
function murailles_current_lang() {
	if ( function_exists( 'pll_current_language' ) ) {
		$lang = pll_current_language( 'slug' );
		if ( $lang ) { return $lang; }
	}
	if ( isset( $_GET['lang'] ) ) {
		$q = sanitize_key( wp_unslash( $_GET['lang'] ) );
		if ( in_array( $q, array( 'fr', 'en' ), true ) ) {
			return $q;
		}
	}
	if ( ! empty( $_COOKIE['murailles_lang'] ) ) {
		$c = sanitize_key( wp_unslash( $_COOKIE['murailles_lang'] ) );
		if ( in_array( $c, array( 'fr', 'en' ), true ) ) {
			return $c;
		}
	}
	return 'fr';
}

/**
 * When ?lang=xx arrives on any request, drop a year-long cookie so subsequent
 * pageloads remember the choice without needing the query string. Plays nicely
 * with Polylang too — if Polylang is active it just ignores us.
 */
add_action( 'init', function () {
	if ( ! isset( $_GET['lang'] ) ) { return; }
	$q = sanitize_key( wp_unslash( $_GET['lang'] ) );
	if ( ! in_array( $q, array( 'fr', 'en' ), true ) ) { return; }
	if ( headers_sent() ) { return; }
	setcookie( 'murailles_lang', $q, time() + YEAR_IN_SECONDS, COOKIEPATH ?: '/', COOKIE_DOMAIN );
	$_COOKIE['murailles_lang'] = $q;
} );

/**
 * Render the header language switcher.
 * Markup: a styled <li> with a flag + code that opens a dropdown of the
 * other available languages. No-op when Polylang isn't installed or only
 * one language is registered.
 */
function murailles_lang_switcher() {
	if ( ! function_exists( 'pll_the_languages' ) ) {
		// Polylang not installed — fall back to a basic FR/EN switcher backed
		// by the ?lang= query param and the murailles_lang cookie.
		murailles_lang_switcher_fallback();
		return;
	}
	$langs = pll_the_languages( array(
		'raw'           => 1,
		'hide_if_empty' => 0,
		'show_flags'    => 1,
		'show_names'    => 1,
	) );
	if ( empty( $langs ) || count( $langs ) < 2 ) {
		murailles_lang_switcher_fallback();
		return;
	}
	$current = null;
	$others  = array();
	foreach ( $langs as $lang ) {
		if ( ! empty( $lang['current_lang'] ) ) {
			$current = $lang;
		} else {
			$others[] = $lang;
		}
	}
	if ( ! $current ) { $current = reset( $langs ); }
	?>
	<li class="murailles-lang-switcher">
		<div class="btn-group account-drop p-0">
			<button type="button" class="btn btn-order-by-filt murailles-lang-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?php esc_attr_e( 'Choisir la langue', 'murailles' ); ?>">
				<?php if ( ! empty( $current['flag'] ) ) : ?>
					<span class="murailles-lang-flag"><?php echo $current['flag']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — Polylang returns trusted <img> HTML ?></span>
				<?php endif; ?>
				<span class="murailles-lang-code"><?php echo esc_html( strtoupper( $current['slug'] ) ); ?></span>
				<i class="fas fa-chevron-down"></i>
			</button>
			<div class="dropdown-menu pull-right animated flipInX murailles-lang-menu">
				<ul>
					<?php foreach ( $others as $lang ) : ?>
						<li>
							<a href="<?php echo esc_url( $lang['url'] ); ?>" hreflang="<?php echo esc_attr( $lang['locale'] ); ?>">
								<?php if ( ! empty( $lang['flag'] ) ) : ?>
									<span class="murailles-lang-flag"><?php echo $lang['flag']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
								<?php endif; ?>
								<?php echo esc_html( $lang['name'] ); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</li>
	<?php
}

/**
 * Filter the property archive WP_Query to the current language so each
 * language only sees its own posts. Polylang already filters most queries
 * automatically, but archive-property.php runs a custom WP_Query, so we
 * make sure its post__not_in includes posts that aren't in the current lang.
 *
 * Hooked low priority so it runs after Polylang's own filters.
 */
add_filter( 'pll_get_taxonomies', function ( $taxonomies ) {
	// Tell Polylang to manage these custom taxonomies (translatable per language).
	$taxonomies['property_category'] = 'property_category';
	$taxonomies['property_location'] = 'property_location';
	$taxonomies['property_area']     = 'property_area';
	return $taxonomies;
}, 10, 1 );

add_filter( 'pll_get_post_types', function ( $post_types ) {
	$post_types['property'] = 'property';
	return $post_types;
}, 10, 1 );

/**
 * Force Polylang into directory-mode with visible /fr/ and /en/ prefixes.
 * The filter is registered in wp-content/mu-plugins/murailles-polylang-force.php
 * because it MUST run before Polylang's plugin code reads option_polylang at
 * plugins_loaded time — a theme-level filter would be loaded too late and would
 * never fire for Polylang's internal model.
 *
 * Below is the post-filter bootstrap: clear caches and flush rewrite rules
 * the first time the marker is missing so the new URL strategy takes effect.
 */
/**
 * One-shot bootstrap to make Polylang adopt our forced URL strategy:
 *   1. Clear Polylang's transient cache of the languages list so it re-reads
 *      `option_polylang` (which is now filtered above).
 *   2. Flush the WP rewrite rules so /fr/ and /en/ prefixes get baked in.
 *
 * Stored marker prevents re-running on every request. Bumping the marker
 * string forces a fresh flush after future code changes.
 */
add_action( 'wp_loaded', function () {
	$marker = get_option( '_murailles_polylang_forced', '' );
	$want   = 'v2:force_lang=1;hide_default=0;redirect_lang=1';
	if ( $marker === $want ) { return; }

	// Wipe Polylang's cached languages list so it re-builds from filtered opts.
	delete_transient( 'pll_languages_list' );

	// Ask WP to regenerate the rewrite-rules option from scratch.
	flush_rewrite_rules( false );

	update_option( '_murailles_polylang_forced', $want, false );
}, 99 );

/**
 * When Polylang creates a new translation (click "+" next to a language flag),
 * seed the new post with the source's title + content + featured image so the
 * editor doesn't open blank. The admin then translates the text inline.
 *
 * Polylang fires this on the new-post-creation screen identified by ?from_post=ID.
 * We only touch posts that haven't been edited yet (post_content is empty).
 */
add_action( 'wp_insert_post', function ( $new_id, $new_post, $update ) {
	// Only fire on initial creation; never overwrite real edits.
	if ( $update ) { return; }
	if ( ! is_admin() ) { return; }
	if ( empty( $_GET['from_post'] ) || empty( $_GET['new_lang'] ) ) { return; }
	$source_id = absint( $_GET['from_post'] );
	if ( ! $source_id || $source_id === $new_id ) { return; }
	$source = get_post( $source_id );
	if ( ! $source || $source->post_type !== $new_post->post_type ) { return; }
	// Only seed if the new post is still empty — never trample real content.
	if ( trim( (string) $new_post->post_content ) !== '' ) { return; }

	wp_update_post( array(
		'ID'           => $new_id,
		'post_title'   => $source->post_title,
		'post_content' => $source->post_content,
		'post_excerpt' => $source->post_excerpt,
	) );

	// Copy the featured image so the EN page shows the same hero.
	$thumb_id = get_post_thumbnail_id( $source_id );
	if ( $thumb_id ) {
		set_post_thumbnail( $new_id, $thumb_id );
	}
}, 20, 3 );

/**
 * Standalone FR/EN switcher used when Polylang is not active.
 * Renders as a single dropdown item showing the current language code
 * and offering the other language. Picking a language drops a year-long
 * cookie (set by the init hook above) so subsequent pageloads remember
 * the choice even without ?lang= in the URL.
 */
function murailles_lang_switcher_fallback() {
	$current = murailles_current_lang();
	$alt     = ( $current === 'fr' ) ? 'en' : 'fr';
	$labels  = array( 'fr' => 'Français', 'en' => 'English' );
	$flags   = array(
		// Inline SVG flags so the switcher works without any external image.
		'fr' => '<svg width="18" height="12" viewBox="0 0 3 2" aria-hidden="true" style="vertical-align:middle;border-radius:2px;"><rect width="1" height="2" x="0" fill="#0055A4"/><rect width="1" height="2" x="1" fill="#fff"/><rect width="1" height="2" x="2" fill="#EF4135"/></svg>',
		'en' => '<svg width="18" height="12" viewBox="0 0 60 30" aria-hidden="true" style="vertical-align:middle;border-radius:2px;"><clipPath id="t"><path d="M0,0v30h60V0z"/></clipPath><clipPath id="s"><path d="M30,15h30v15zv15H0zH0V0zV0h30z"/></clipPath><g clip-path="url(#t)"><path d="M0,0v30h60V0z" fill="#012169"/><path d="M0,0 60,30M60,0 0,30" stroke="#fff" stroke-width="6"/><path d="M0,0 60,30M60,0 0,30" clip-path="url(#s)" stroke="#C8102E" stroke-width="4"/><path d="M30,0v30M0,15h60" stroke="#fff" stroke-width="10"/><path d="M30,0v30M0,15h60" stroke="#C8102E" stroke-width="6"/></g></svg>',
	);

	// Build the URL toggling to the alternate language. Strips any existing
	// ?lang= and appends the new one to the current request URI.
	$current_uri = ( is_ssl() ? 'https' : 'http' ) . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$toggle_url  = esc_url( add_query_arg( 'lang', $alt, remove_query_arg( 'lang', $current_uri ) ) );
	?>
	<li class="murailles-lang-switcher">
		<div class="btn-group account-drop p-0">
			<button type="button" class="btn btn-order-by-filt murailles-lang-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?php esc_attr_e( 'Choisir la langue', 'murailles' ); ?>">
				<span class="murailles-lang-flag"><?php echo $flags[ $current ]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — inline SVG ?></span>
				<span class="murailles-lang-code"><?php echo esc_html( strtoupper( $current ) ); ?></span>
				<i class="fas fa-chevron-down"></i>
			</button>
			<div class="dropdown-menu pull-right animated flipInX murailles-lang-menu">
				<ul>
					<li>
						<a href="<?php echo $toggle_url; ?>" hreflang="<?php echo esc_attr( $alt ); ?>">
							<span class="murailles-lang-flag"><?php echo $flags[ $alt ]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — inline SVG ?></span>
							<?php echo esc_html( $labels[ $alt ] ); ?>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</li>
	<?php
}
