<?php

/**
 * En-tête du thème
 *
 * Navigation : Accueil | Vente | Location | Informations | Déposer une annonce | Contact
 * Pas de connexion/inscription — dépôt d'annonce sans login.
 *
 * @package Murailles Immobilier
 */

if (! defined('ABSPATH')) {
	exit;
}

$header_style = isset($murailles_header_style) ? $murailles_header_style : 'light';
if (is_front_page() && ! isset($murailles_header_style)) {
	$header_style = 'transparent';
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
	<?php /* Preloader safety net — pure CSS + inline JS, no jQuery dependency.
	         Hides the spinner after 2 s if window.load / custom.js never fires.
	         Runs before any external script so it works even when every JS 404s. */ ?>
	<style>
		@keyframes murailles-preloader-timeout {
			0%   { opacity: 1; pointer-events: auto;  }
			99%  { opacity: 1; pointer-events: auto;  }
			100% { opacity: 0; pointer-events: none;  }
		}
		.preloader-timeout-armed {
			animation: murailles-preloader-timeout 2s forwards;
			animation-delay: 2s;
		}
	</style>
	<script>
		/* Immediately make body visible so a blank white screen never persists. */
		document.documentElement.style.visibility = 'visible';
		/* Arm the CSS 2 s fallback as soon as the element exists in the DOM. */
		document.addEventListener('DOMContentLoaded', function() {
			var el = document.querySelector('.preloader');
			if (el) { el.classList.add('preloader-timeout-armed'); }
		});
		/* Belt-and-braces: window.onload plain JS fallback (no jQuery needed). */
		window.addEventListener('load', function() {
			var el = document.querySelector('.preloader');
			if (el) {
				el.style.transition = 'opacity 0.3s ease';
				el.style.opacity    = '0';
				el.style.pointerEvents = 'none';
				setTimeout(function() { if (el && el.parentNode) { el.parentNode.removeChild(el); } }, 350);
			}
		});
	</script>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<div class="preloader"></div>

	<div id="main-wrapper">

		<!-- Start Navigation -->
		<?php if ($header_style === 'transparent') : ?>
			<div class="header header-transparent change-logo">
				<div class="container">
					<nav id="navigation" class="navigation navigation-landscape">
						<div class="nav-header">
							<a class="nav-brand static-logo" href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo esc_url(murailles_img('logo.webp')); ?>" class="logo" alt="<?php bloginfo('name'); ?>" /></a>
							<a class="nav-brand fixed-logo" href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo esc_url(murailles_img('logo.webp')); ?>" class="logo" alt="<?php bloginfo('name'); ?>" /></a>
							<div class="nav-toggle"></div>
							<div class="mobile_nav">
								<ul class="nav-menu nav-menu-social mobile-lang-switcher">
									<?php murailles_lang_switcher(); ?>
								</ul>
							</div>
						</div>
						<div class="nav-menus-wrapper" style="transition-property: none;">
							<a class="nav-brand mobile-menu-logo" href="<?php echo esc_url(home_url('/')); ?>">
								<img src="<?php echo esc_url(murailles_img('logo.webp')); ?>" alt="<?php bloginfo('name'); ?>" />
							</a>
							<?php if (has_nav_menu('primary')) :
								wp_nav_menu(array(
									'theme_location' => 'primary',
									'container'      => false,
									'menu_class'     => 'nav-menu',
									'walker'         => new Murailles_Nav_Walker(),
								));
							else :
								get_template_part('template-parts/nav-fallback');
							endif; ?>

							<ul class="nav-menu nav-menu-social align-to-right">
								<?php murailles_lang_switcher(); ?>
							</ul>
						</div>
					</nav>
				</div>
			</div>
		<?php else : ?>
			<div class="header header-light">
				<div class="container">
					<nav id="navigation" class="navigation navigation-landscape">
						<div class="nav-header">
							<a class="nav-brand" href="<?php echo esc_url(home_url('/')); ?>">
								<img src="<?php echo esc_url(murailles_img('logo.webp')); ?>" class="logo" alt="<?php bloginfo('name'); ?>" />
							</a>
							<div class="nav-toggle"></div>
							<div class="mobile_nav">
								<ul class="nav-menu nav-menu-social mobile-lang-switcher">
									<?php murailles_lang_switcher(); ?>
								</ul>
							</div>
						</div>
						<div class="nav-menus-wrapper" style="transition-property: none;">
							<a class="nav-brand mobile-menu-logo" href="<?php echo esc_url(home_url('/')); ?>">
								<img src="<?php echo esc_url(murailles_img('logo.webp')); ?>" alt="<?php bloginfo('name'); ?>" />
							</a>
							<?php if (has_nav_menu('primary')) :
								wp_nav_menu(array(
									'theme_location' => 'primary',
									'container'      => false,
									'menu_class'     => 'nav-menu',
									'walker'         => new Murailles_Nav_Walker(),
								));
							else :
								get_template_part('template-parts/nav-fallback');
							endif; ?>

							<ul class="nav-menu nav-menu-social align-to-right">
								<?php murailles_lang_switcher(); ?>
							</ul>
						</div>
					</nav>
				</div>
			</div>
		<?php endif; ?>
		<!-- End Navigation -->
		<div class="clearfix"></div>