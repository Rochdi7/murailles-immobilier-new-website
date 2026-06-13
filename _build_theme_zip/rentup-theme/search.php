<?php
/**
 * Search Results Template (static layout)
 *
 * Static search results page.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();
?>

			<!-- ============================ Page Title Start================================== -->
			<div class="page-title" style="background:#f4f4f4;" data-overlay="5">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="breadcrumbs-wrap position-relative z-1">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php murailles_t( 'Accueil' ); ?></a></li>
									<li class="breadcrumb-item active" aria-current="page"><?php murailles_t( 'Résultats de recherche' ); ?></li>
								</ol>
								<h2 class="breadcrumb-title"><?php murailles_t( 'Résultats de recherche' ); ?></h2>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- ============================ Page Title End ================================== -->

			<section class="gray">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-lg-6 col-md-10">
							<div class="text-center py-5">
								<h3><?php murailles_t( 'Résultats de recherche' ); ?></h3>
								<p><?php murailles_t( 'Utilisez le menu de navigation pour trouver ce que vous cherchez.' ); ?></p>
								<a class="btn btn-danger" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php murailles_t( "Retour à l'accueil" ); ?></a>
							</div>
						</div>
					</div>
				</div>
			</section>

<?php get_template_part( 'template-parts/call-to-action' ); ?>

<?php get_footer(); ?>
