<?php
/**
 * Template Name: Favoris
 *
 * Renders the visitor's wishlist directly from localStorage snapshots —
 * no DB lookup needed because each entry already carries title/thumb/price.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
?>

<div class="page-title" style="background:#f4f4f4 url(<?php echo esc_url( murailles_img( 'banner-home.jpg' ) ); ?>);" data-overlay="5">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="breadcrumbs-wrap position-relative z-1">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php murailles_t( 'Accueil' ); ?></a></li>
						<li class="breadcrumb-item active" aria-current="page"><?php murailles_t( 'Mes favoris' ); ?></li>
					</ol>
					<h2 class="breadcrumb-title"><?php murailles_t( 'Mes biens favoris' ); ?></h2>
				</div>
			</div>
		</div>
	</div>
</div>

<section class="gray pt-5 pb-5">
	<div class="container">

		<div id="murailles-favoris-empty" class="text-center py-5" style="display:none;">
			<i class="fa-regular fa-heart" style="font-size:64px;color:#dc3545;opacity:0.4;"></i>
			<h3 class="mt-4"><?php murailles_t( "Aucun favori pour l'instant" ); ?></h3>
			<p class="text-muted"><?php murailles_t( 'Parcourez nos biens et cliquez sur le cœur pour les enregistrer ici.' ); ?></p>
			<a href="<?php echo esc_url( murailles_bien_url() ); ?>" class="btn btn-danger mt-3"><?php murailles_t( 'Voir tous les biens' ); ?></a>
		</div>

		<div id="murailles-favoris-list" class="row g-4"></div>

		<div id="murailles-favoris-actions" class="text-center mt-4" style="display:none;">
			<button type="button" id="murailles-favoris-clear" class="btn btn-outline-secondary btn-sm">
				<i class="fa-solid fa-broom"></i> <?php murailles_t( 'Vider mes favoris' ); ?>
			</button>
		</div>

	</div>
</section>

<?php // Favoris styles + render JS are enqueued via functions.php (murailles-custom.css + murailles-favoris.js) ?>


<?php get_template_part( 'template-parts/call-to-action' ); ?>
<?php get_footer(); ?>
