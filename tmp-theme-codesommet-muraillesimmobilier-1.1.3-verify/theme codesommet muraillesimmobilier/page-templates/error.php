<?php
/**
 * Template Name: Page d'erreur
 *
 * Assignable to any page (e.g. /erreur/) to render an on-brand error
 * screen. The error code can be overridden via ?code= query arg, so
 * the same page can render 403 / 500 / 503 / maintenance variants:
 *   /erreur/?code=403
 *   /erreur/?code=500
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$mu_allowed = array( '400', '401', '403', '404', '500', '503', 'maintenance' );
$mu_code    = isset( $_GET['code'] ) ? sanitize_text_field( wp_unslash( $_GET['code'] ) ) : '404';
if ( ! in_array( $mu_code, $mu_allowed, true ) ) { $mu_code = '404'; }

// Send the matching HTTP status so the response is honest.
if ( ctype_digit( $mu_code ) ) {
	status_header( (int) $mu_code );
} else {
	status_header( 503 );
}
nocache_headers();

get_header();
get_template_part( 'template-parts/error-page', null, array( 'code' => $mu_code ) );
murailles_render_page_builder_content();
get_footer();
