<?php
/**
 * Template Part: Page Title / Breadcrumb Banner
 *
 * Displays the page title banner with breadcrumbs used on inner pages.
 * Preserves the original HTML structure from the static template.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Allow custom title override via template variable
$page_title    = isset( $murailles_page_title ) ? $murailles_page_title : get_the_title();
$page_subtitle = isset( $murailles_page_subtitle ) ? $murailles_page_subtitle : '';
?>
<!-- ============================ Page Title Start================================== -->
<div class="page-title" style="background:#f4f4f4;" data-overlay="5">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12">

				<div class="breadcrumbs-wrap position-relative z-1">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php murailles_t( 'Accueil' ); ?></a></li>
						<li class="breadcrumb-item active" aria-current="page"><?php echo esc_html( $page_title ); ?></li>
					</ol>
					<h2 class="breadcrumb-title"><?php echo esc_html( $page_subtitle ? $page_subtitle : $page_title ); ?></h2>
				</div>

			</div>
		</div>
	</div>
</div>
<!-- ============================ Page Title End ================================== -->
