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

/**
 * Pick the best image for the current URL:
 *   1. Featured image of the current post (full size).
 *   2. First image from the property gallery.
 *   3. Theme banner (banner-home.jpg) for the homepage / archive.
 */
function murailles_social_image() {
	if ( is_singular() ) {
		$id = get_queried_object_id();
		if ( has_post_thumbnail( $id ) ) {
			return get_the_post_thumbnail_url( $id, 'full' );
		}
		// For properties, fall back to the first gallery image.
		if ( get_post_type( $id ) === 'property' ) {
			$gallery = (string) get_post_meta( $id, '_property_gallery_ids', true );
			$ids     = array_filter( array_map( 'intval', explode( ',', $gallery ) ) );
			if ( ! empty( $ids ) ) {
				$url = wp_get_attachment_image_url( $ids[0], 'full' );
				if ( $url ) { return $url; }
			}
		}
	}
	if ( function_exists( 'murailles_img' ) ) {
		return murailles_img( 'villa-luxe-marrakech-hero.webp' );
	}
	return '';
}

/**
 * Emit Open Graph + Twitter Card tags.
 * Hooked at priority 5 so they appear near the top of <head>, before scripts.
 */
add_action( 'wp_head', function () {
	$site   = get_bloginfo( 'name' );
	$locale = function_exists( 'pll_current_language' ) ? pll_current_language( 'locale' ) : get_locale();
	if ( ! $locale ) { $locale = 'fr_FR'; }

	$title = function_exists( 'wp_get_document_title' ) ? wp_get_document_title() : $site;
	$desc  = function_exists( 'murailles_seo_description' ) ? murailles_seo_description() : '';
	$image = murailles_social_image();
	$url   = is_singular() ? get_permalink() : ( is_front_page() ? home_url( '/' ) : ( isset( $_SERVER['REQUEST_URI'] ) ? home_url( $_SERVER['REQUEST_URI'] ) : home_url( '/' ) ) );

	$type = 'website';
	if ( is_singular( 'post' ) )      { $type = 'article'; }
	if ( is_singular( 'property' ) )  { $type = 'product'; } // closest OG type; Schema.org JSON-LD adds the RealEstateListing detail

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

	// Twitter Cards (large image variant works best for real-estate photos).
	echo "<!-- Twitter Cards -->\n";
	printf( '<meta name="twitter:card" content="%s" />' . "\n", $image ? 'summary_large_image' : 'summary' );
	printf( '<meta name="twitter:title" content="%s" />' . "\n", esc_attr( $title ) );
	if ( $desc )  { printf( '<meta name="twitter:description" content="%s" />' . "\n", esc_attr( wp_strip_all_tags( $desc ) ) ); }
	if ( $image ) { printf( '<meta name="twitter:image" content="%s" />' . "\n", esc_url( $image ) ); }
}, 5 );
