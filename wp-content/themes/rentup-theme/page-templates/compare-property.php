<?php
/**
 * Template Name: Compare Property
 *
 * Renders the side-by-side comparison from localStorage snapshots —
 * no DB lookup needed because each entry already carries title/thumb/price.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
?>

<div class="page-title" style="background:#f4f4f4 url(<?php echo esc_url( murailles_img( 'faq-immobilier-marrakech.webp' ) ); ?>);" data-overlay="5">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="breadcrumbs-wrap position-relative z-1">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php murailles_t( 'Accueil' ); ?></a></li>
						<li class="breadcrumb-item active" aria-current="page"><?php murailles_t( 'Comparer' ); ?></li>
					</ol>
					<h2 class="breadcrumb-title"><?php murailles_t( 'Comparer les biens' ); ?></h2>
				</div>
			</div>
		</div>
	</div>
</div>

<section class="pt-5 pb-5">
	<div class="container">

		<div id="murailles-compare-empty" class="text-center py-5" style="display:none;">
			<i class="fa-solid fa-scale-balanced" style="font-size:64px;color:#dc3545;opacity:0.4;"></i>
			<h3 class="mt-4"><?php murailles_t( 'Aucun bien à comparer' ); ?></h3>
			<p class="text-muted"><?php murailles_t( "Cliquez sur l'icône" ); ?> <i class="fa-solid fa-share"></i> <?php murailles_t( "d'un bien pour l'ajouter à la comparaison (max. 2 biens)." ); ?></p>
			<a href="<?php echo esc_url( murailles_bien_url() ); ?>" class="btn btn-danger mt-3"><?php murailles_t( 'Voir les biens disponibles' ); ?></a>
		</div>

		<div id="murailles-compare-content" style="display:none;">
			<div class="d-flex justify-content-end mb-3">
				<button type="button" id="murailles-compare-clear" class="btn btn-sm btn-outline-secondary">
					<i class="fa-solid fa-rotate-left"></i> <?php murailles_t( 'Réinitialiser' ); ?>
				</button>
			</div>
			<div class="table-responsive">
				<table class="table table-bordered" style="background:#fff;">
					<thead style="background:#1a2332;color:#fff;">
						<tr id="murailles-compare-headers"></tr>
					</thead>
					<tbody id="murailles-compare-rows"></tbody>
				</table>
			</div>
		</div>

	</div>
</section>

<?php // Compare logic enqueued via functions.php (murailles-compare.js + murailles-custom.css) ?>

<?php get_template_part( 'template-parts/call-to-action' ); ?>
<?php get_footer(); ?>
