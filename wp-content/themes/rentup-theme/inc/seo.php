<?php
/**
 * SEO core: title tags, meta description, robots directives, canonicals.
 *
 * Goals:
 *   • Generate descriptive, unique titles per page (without an SEO plugin).
 *   • Generate a meta description from the page content or an explicit
 *     `_seo_description` post-meta field.
 *   • Send sensible robots directives (noindex on thin/utility pages).
 *   • Leave canonical/hreflang to WP core + Polylang (already working).
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Build the page title for the current request.
 *
 * Format:
 *   • Single property:  "{property title} — {price} {currency} | Murailles Immobilier"
 *   • Single blog post: "{post title} | Murailles Immobilier"
 *   • Page:             "{page title} | Murailles Immobilier"
 *   • Archive:          "Biens à vendre/louer | Murailles Immobilier"
 *   • Home:             "Murailles Immobilier — Agence immobilière à Marrakech"
 *   • Search:           "Recherche : {query} | Murailles Immobilier"
 *   • 404:              "Page introuvable | Murailles Immobilier"
 *
 * Hooked to `pre_get_document_title` so it overrides WP's default.
 */
add_filter( 'pre_get_document_title', function ( $title ) {
	$site = get_bloginfo( 'name' );

	if ( is_front_page() ) {
		$tagline = murailles_t( 'Agence immobilière à Marrakech — riads, villas, appartements', false );
		return sprintf( '%s — %s', $site, $tagline );
	}

	if ( is_singular( 'property' ) ) {
		$id     = get_queried_object_id();
		$ptitle = get_the_title( $id );
		$price  = (int) get_post_meta( $id, '_property_price', true );
		if ( $price > 0 ) {
			return sprintf(
				'%s — %s €%s | %s',
				$ptitle,
				number_format_i18n( $price ),
				get_post_meta( $id, '_property_price_suffix', true ) ? ' ' . get_post_meta( $id, '_property_price_suffix', true ) : '',
				$site
			);
		}
		return sprintf( '%s | %s', $ptitle, $site );
	}

	if ( is_singular() ) {
		return sprintf( '%s | %s', get_the_title(), $site );
	}

	if ( is_post_type_archive( 'property' ) ) {
		return sprintf( '%s | %s', murailles_t( 'Biens immobiliers à vendre et à louer au Maroc', false ), $site );
	}

	if ( is_tax( array( 'property_category', 'property_location', 'property_area' ) ) ) {
		$term = get_queried_object();
		if ( $term ) {
			$prefix = is_tax( 'property_category' ) ? murailles_t( 'Biens', false )
				: ( is_tax( 'property_location' ) ? murailles_t( 'Biens à', false ) : murailles_t( 'Biens dans le quartier', false ) );
			return sprintf( '%s %s | %s', $prefix, $term->name, $site );
		}
	}

	if ( is_search() ) {
		return sprintf( '%s : %s | %s', murailles_t( 'Recherche', false ), esc_html( get_search_query() ), $site );
	}

	if ( is_404() ) {
		return sprintf( '%s | %s', murailles_t( 'Page introuvable', false ), $site );
	}

	if ( is_home() ) {
		return sprintf( '%s | %s', murailles_t( 'Actualités & Articles', false ), $site );
	}

	// Fallback: WP default.
	return $title;
}, 10, 1 );

/**
 * Get/derive a meta description for the current request.
 * Honors a `_seo_description` post-meta override; falls back to excerpt,
 * then trimmed content.
 */
function murailles_seo_description() {
	$site_tagline = get_bloginfo( 'description' );

	if ( is_front_page() ) {
		return $site_tagline ?: murailles_t( "Agence immobilière à Marrakech. Riads d'exception, villas, appartements et terrains à vendre ou à louer au Maroc avec un accompagnement complet de A à Z.", false );
	}

	if ( is_singular() ) {
		$id = get_queried_object_id();
		$custom = get_post_meta( $id, '_seo_description', true );
		if ( $custom ) { return $custom; }

		if ( has_excerpt( $id ) ) {
			return wp_strip_all_tags( get_the_excerpt( $id ) );
		}

		// Build a description from the first ~30 words of the content.
		$content = wp_strip_all_tags( get_post_field( 'post_content', $id ) );
		$content = preg_replace( '/\s+/', ' ', $content );
		$desc    = wp_trim_words( $content, 30, '…' );

		// For properties, prepend the category + city + price so the snippet is dense with intent signals.
		if ( get_post_type( $id ) === 'property' ) {
			$cats  = wp_get_post_terms( $id, 'property_category', array( 'fields' => 'names' ) );
			$locs  = wp_get_post_terms( $id, 'property_location', array( 'fields' => 'names' ) );
			$price = (int) get_post_meta( $id, '_property_price', true );
			$bits  = array();
			if ( ! empty( $cats ) )  { $bits[] = $cats[0]; }
			if ( ! empty( $locs ) )  { $bits[] = $locs[0]; }
			if ( $price > 0 )        { $bits[] = number_format_i18n( $price ) . ' €'; }
			if ( $bits ) {
				$desc = implode( ' · ', $bits ) . ' — ' . $desc;
			}
		}
		return $desc;
	}

	if ( is_post_type_archive( 'property' ) ) {
		return murailles_t( "Découvrez tous les biens immobiliers proposés par l'Agence Murailles à Marrakech, Casablanca, Rabat et dans les plus belles villes du Maroc.", false );
	}

	if ( is_tax() ) {
		$term = get_queried_object();
		if ( $term && $term->description ) { return wp_strip_all_tags( $term->description ); }
		if ( $term ) {
			return sprintf(
				/* translators: %s is the taxonomy term name (e.g. "Villa", "Marrakech") */
				murailles_t( 'Biens immobiliers dans la catégorie « %s » par Agence Murailles Immobilier au Maroc.', false ),
				$term->name
			);
		}
	}

	if ( is_home() ) {
		return murailles_t( "Le blog de l'Agence Murailles Immobilier : conseils, tendances du marché et guides pour acheter, vendre ou louer un bien au Maroc.", false );
	}

	return $site_tagline;
}

/**
 * Emit <meta name="description"> in <head>.
 */
add_action( 'wp_head', function () {
	$desc = murailles_seo_description();
	if ( ! $desc ) { return; }
	$desc = trim( wp_strip_all_tags( $desc ) );
	$desc = preg_replace( '/\s+/', ' ', $desc );
	// Soft 160-char cap — Google truncates at ~155-160.
	if ( mb_strlen( $desc ) > 160 ) {
		$desc = mb_substr( $desc, 0, 157 ) . '…';
	}
	printf( '<meta name="description" content="%s" />' . "\n", esc_attr( $desc ) );
}, 1 );

/**
 * Robots directives: noindex utility pages so they don't dilute the index.
 * Search, paginated archives beyond page 1, attachment pages, /favoris/,
 * /compare-property/, /erreur/ should not be indexed.
 */
add_filter( 'wp_robots', function ( $robots ) {
	$noindex_paths = array( '/favoris/', '/compare-property/', '/erreur/', '/checkout/' );
	$req = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '';

	$noindex = false;
	if ( is_search() )                    { $noindex = true; }
	if ( is_attachment() )                { $noindex = true; }
	if ( is_404() )                       { $noindex = true; }
	if ( is_paged() && get_query_var( 'paged' ) > 1 ) {
		// Allow page 2-3 of property archive to be indexed (deep inventory matters),
		// but noindex deeper paginations.
		$page = (int) get_query_var( 'paged' );
		if ( $page > 3 ) { $noindex = true; }
	}
	foreach ( $noindex_paths as $path ) {
		if ( strpos( $req, $path ) !== false ) { $noindex = true; break; }
	}

	if ( $noindex ) {
		$robots['noindex']  = true;
		$robots['nofollow'] = false; // allow link discovery
	} else {
		$robots['index']  = true;
		$robots['follow'] = true;
	}
	$robots['max-image-preview'] = 'large';
	$robots['max-snippet']       = -1;
	$robots['max-video-preview'] = -1;
	return $robots;
}, 10, 1 );
