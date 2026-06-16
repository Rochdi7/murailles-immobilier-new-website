<?php
/**
 * Social-share meta: Open Graph + Twitter Cards.
 *
 * Without these, links shared on Facebook, LinkedIn, WhatsApp, Slack or
 * iMessage show a bare URL with no thumbnail or description.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! function_exists( 'murailles_opt' ) ) {
	function murailles_opt( $key, $default = '' ) {
		$opts = (array) get_option( 'murailles_options', array() );
		return isset( $opts[ $key ] ) && $opts[ $key ] !== '' ? $opts[ $key ] : $default;
	}
}

/**
 * Pick the best image for the current URL:
 *   1. Custom _seo_og_image meta (set via WP admin or Royal MCP key: _seo_og_image).
 *   2. Featured image of the current post (full size).
 *   3. First image from the property gallery.
 *   4. Theme banner for the homepage / archive.
 */
function murailles_social_image() {
	if ( is_singular() ) {
		$id = get_queried_object_id();
		$og_override = (string) get_post_meta( $id, '_seo_og_image', true );
		if ( $og_override ) { return $og_override; }
		if ( has_post_thumbnail( $id ) ) {
			return get_the_post_thumbnail_url( $id, 'full' );
		}
		if ( get_post_type( $id ) === 'property' ) {
			$gallery = (string) get_post_meta( $id, '_property_gallery_ids', true );
			$ids     = array_filter( array_map( 'intval', explode( ',', $gallery ) ) );
			if ( ! empty( $ids ) ) {
				$url = wp_get_attachment_image_url( $ids[0], 'full' );
				if ( $url ) { return $url; }
			}
		}
	}
	// Fall back to the global default OG image set in Options du thème → SEO.
	$default_og = murailles_opt( 'seo_default_og_image' );
	if ( $default_og ) { return $default_og; }

	if ( function_exists( 'murailles_img' ) ) {
		return murailles_img( 'villa-luxe-marrakech-hero.webp' );
	}
	return '';
}

/**
 * Derive a human-readable alt text for the OG image.
 * Used for og:image:alt (accessibility + some validators require it).
 */
function murailles_social_image_alt() {
	if ( is_singular() ) {
		$id  = get_queried_object_id();
		$alt = (string) get_post_meta( $id, '_seo_og_image', true )
			? get_the_title( $id )
			: get_post_meta( get_post_thumbnail_id( $id ), '_wp_attachment_image_alt', true );
		if ( $alt ) { return $alt; }
		return get_the_title( $id );
	}
	return get_bloginfo( 'name' );
}

/**
 * Emit Open Graph + Twitter Card tags.
 * Hooked at priority 5 so they appear near the top of <head>, before scripts.
 */
add_action( 'wp_head', function () {
	// Defer OG/Twitter tags to SEO plugin when one is active — prevents duplicates.
	if ( function_exists( 'murailles_seo_plugin_active' ) && murailles_seo_plugin_active() ) {
		return;
	}

	$site   = get_bloginfo( 'name' );
	$locale = function_exists( 'pll_current_language' ) ? pll_current_language( 'locale' ) : get_locale();
	if ( ! $locale ) { $locale = 'fr_FR'; }

	$title = function_exists( 'wp_get_document_title' ) ? wp_get_document_title() : $site;
	$desc  = function_exists( 'murailles_seo_description' ) ? murailles_seo_description() : '';
	$image = murailles_social_image();
	$url   = is_singular() ? get_permalink() : ( is_front_page() ? home_url( '/' ) : home_url( wp_parse_url( add_query_arg( array() ), PHP_URL_PATH ) ?: '/' ) );

	$type = 'website';
	if ( is_singular( 'post' ) )      { $type = 'article'; }
	if ( is_singular( 'property' ) )  { $type = 'product'; } // closest OG type; Schema.org JSON-LD adds the RealEstateListing detail

	$image_alt  = murailles_social_image_alt();
	$fb_app_id  = murailles_opt( 'seo_facebook_app_id' );
	$tw_handle  = murailles_opt( 'seo_twitter_handle' );

	echo "\n<!-- Open Graph -->\n";
	printf( '<meta property="og:site_name" content="%s" />' . "\n", esc_attr( $site ) );
	printf( '<meta property="og:locale" content="%s" />' . "\n", esc_attr( $locale ) );
	printf( '<meta property="og:type" content="%s" />' . "\n", esc_attr( $type ) );
	printf( '<meta property="og:title" content="%s" />' . "\n", esc_attr( $title ) );
	if ( $desc ) {
		printf( '<meta property="og:description" content="%s" />' . "\n", esc_attr( wp_strip_all_tags( $desc ) ) );
	}
	printf( '<meta property="og:url" content="%s" />' . "\n", esc_url( $url ) );
	if ( $image ) {
		printf( '<meta property="og:image" content="%s" />' . "\n", esc_url( $image ) );
		printf( '<meta property="og:image:width" content="1200" />' . "\n" );
		printf( '<meta property="og:image:height" content="630" />' . "\n" );
		printf( '<meta property="og:image:alt" content="%s" />' . "\n", esc_attr( $image_alt ) );
	}
	if ( $fb_app_id ) {
		printf( '<meta property="fb:app_id" content="%s" />' . "\n", esc_attr( $fb_app_id ) );
	}

	// Alternate locale links from Polylang.
	if ( function_exists( 'pll_the_languages' ) ) {
		$langs = pll_the_languages( array( 'raw' => 1, 'hide_if_empty' => 0 ) );
		if ( is_array( $langs ) ) {
			foreach ( $langs as $lang ) {
				if ( empty( $lang['current_lang'] ) && ! empty( $lang['locale'] ) ) {
					printf( '<meta property="og:locale:alternate" content="%s" />' . "\n", esc_attr( $lang['locale'] ) );
				}
			}
		}
	}

	// Article-specific OG.
	if ( is_singular( 'post' ) ) {
		printf( '<meta property="article:published_time" content="%s" />' . "\n", esc_attr( get_the_date( 'c' ) ) );
		printf( '<meta property="article:modified_time" content="%s" />' . "\n", esc_attr( get_the_modified_date( 'c' ) ) );
		$author_id = (int) get_post_field( 'post_author', get_queried_object_id() );
		$author    = get_the_author_meta( 'display_name', $author_id );
		if ( $author ) {
			printf( '<meta property="article:author" content="%s" />' . "\n", esc_attr( $author ) );
		}
		foreach ( get_the_category() as $cat ) {
			printf( '<meta property="article:section" content="%s" />' . "\n", esc_attr( $cat->name ) );
		}
		foreach ( get_the_tags() ?: array() as $tag ) {
			printf( '<meta property="article:tag" content="%s" />' . "\n", esc_attr( $tag->name ) );
		}
	}

	// Twitter / X Cards.
	echo "<!-- Twitter Cards -->\n";
	printf( '<meta name="twitter:card" content="%s" />' . "\n", $image ? 'summary_large_image' : 'summary' );
	if ( $tw_handle ) {
		printf( '<meta name="twitter:site" content="%s" />' . "\n", esc_attr( $tw_handle ) );
	}
	printf( '<meta name="twitter:title" content="%s" />' . "\n", esc_attr( $title ) );
	if ( $desc )       { printf( '<meta name="twitter:description" content="%s" />' . "\n", esc_attr( wp_strip_all_tags( $desc ) ) ); }
	if ( $image ) {
		printf( '<meta name="twitter:image" content="%s" />' . "\n", esc_url( $image ) );
		printf( '<meta name="twitter:image:alt" content="%s" />' . "\n", esc_attr( $image_alt ) );
	}
}, 5 );

if ( ! function_exists( 'murailles_render_share_dock' ) ) {
	/**
	 * Compact social-share dock for singular pages and property listings.
	 * Adds crawlable share links so on-page SEO tools detect multiple
	 * distribution options beyond a single generic share button.
	 */
	function murailles_render_share_dock() {
		if ( is_admin() || is_feed() || post_password_required() ) {
			return;
		}

		if ( ! is_page() && ! is_singular( 'property' ) ) {
			return;
		}

		$url   = get_permalink();
		$title = get_the_title();

		if ( ! $url || ! $title ) {
			return;
		}

		$share_url    = rawurlencode( $url );
		$share_title  = rawurlencode( $title );
		$label        = function_exists( 'murailles_t' ) ? murailles_t( 'Partager :', false ) : 'Share:';
		$toggle_label = function_exists( 'murailles_t' ) ? murailles_t( 'Partager cette page', false ) : 'Share this page';
		$toggle_aria  = $toggle_label . ' - ' . ( function_exists( 'murailles_t' ) ? murailles_t( 'ouvrir les options de partage', false ) : 'open share options' );
		?>
		<div class="murailles-share-fab-wrap">
			<details class="murailles-share-fab">
				<summary class="murailles-share-fab__toggle" aria-label="<?php echo esc_attr( $toggle_aria ); ?>">
					<i class="fa-solid fa-share-nodes" aria-hidden="true"></i>
					<span class="murailles-share-fab__text"><?php echo esc_html( $toggle_label ); ?></span>
				</summary>
				<div class="murailles-share-fab__panel" role="group" aria-label="<?php echo esc_attr( $label ); ?>">
					<a class="murailles-share-fab__link is-facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_attr( $share_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( murailles_t( 'Partager sur Facebook', false ) ); ?>">
						<i class="fa-brands fa-facebook-f" aria-hidden="true"></i>
					</a>
					<a class="murailles-share-fab__link is-x" href="https://twitter.com/intent/tweet?url=<?php echo esc_attr( $share_url ); ?>&text=<?php echo esc_attr( $share_title ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( murailles_t( 'Partager sur X', false ) ); ?>">
						<i class="fa-brands fa-x-twitter" aria-hidden="true"></i>
					</a>
					<a class="murailles-share-fab__link is-whatsapp" href="https://wa.me/?text=<?php echo esc_attr( $share_title ); ?>%20<?php echo esc_attr( $share_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( murailles_t( 'Partager sur WhatsApp', false ) ); ?>">
						<i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
					</a>
					<a class="murailles-share-fab__link is-linkedin" href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo esc_attr( $share_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( murailles_t( 'Partager sur LinkedIn', false ) ); ?>">
						<i class="fa-brands fa-linkedin-in" aria-hidden="true"></i>
					</a>
				</div>
			</details>
		</div>
		<?php
	}
}

add_action( 'wp_footer', 'murailles_render_share_dock', 20 );
