<?php
/**
 * 404 Error Page Template
 *
 * Renders the shared error template part with code 404. Sends a proper
 * 404 status header so search engines correctly de-index missing URLs.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

status_header( 404 );
nocache_headers();

get_header();
get_template_part( 'template-parts/error-page', null, array( 'code' => '404' ) );
get_footer();
