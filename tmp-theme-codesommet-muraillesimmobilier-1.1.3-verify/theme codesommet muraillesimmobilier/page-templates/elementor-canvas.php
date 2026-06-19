<?php
/**
 * Template Name: Elementor Canvas (blank)
 *
 * A true blank canvas for landing pages built entirely in Elementor.
 * No theme header, no footer, no sidebar — only the bare HTML scaffolding,
 * the theme's CSS/JS (so brand styles stay available), and the Elementor
 * content. Use this for high-conversion landing pages where the standard
 * navigation would distract.
 *
 * @package Murailles Immobilier
 */

if (! defined('ABSPATH')) {
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class('elementor-canvas-page'); ?>>
<?php wp_body_open(); ?>
<?php
while (have_posts()) :
	the_post();
	the_content();
endwhile;
?>
<?php wp_footer(); ?>
</body>
</html>
