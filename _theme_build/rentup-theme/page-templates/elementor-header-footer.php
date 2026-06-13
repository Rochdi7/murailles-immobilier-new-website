<?php
/**
 * Template Name: Elementor (with header & footer)
 *
 * Use this template for pages built in Elementor that should keep the
 * Murailles header and footer. The Elementor canvas occupies the area
 * between them, full width, with no theme-injected sidebars or wrappers.
 *
 * @package Murailles Immobilier
 */

get_header();

while (have_posts()) :
	the_post();
	the_content();
endwhile;

get_footer();
