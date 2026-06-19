<?php
/**
 * Taxonomy Archive — property_area (Quartier)
 *
 * Thin wrapper. All markup/logic lives in the shared renderer so the three
 * property taxonomies (Ville / Quartier / Type) stay visually identical.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();
get_template_part( 'template-parts/property-taxonomy' );
get_template_part( 'template-parts/call-to-action' );
get_footer();
