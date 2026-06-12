<?php
/**
 * Template Part: Error Page
 *
 * Renders a polished branded error block. Used by 404.php and any other
 * error context (e.g. a /erreur/ page, custom 403/500 routing).
 *
 * Args via set_query_var() before include OR via get_template_part( 'template-parts/error-page', null, $args ):
 *   - code    : string|int   HTTP code (404, 403, 500, etc.) — defaults to 404
 *   - title   : string       headline — defaults derived from code
 *   - message : string       body copy — defaults derived from code
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$mu_error_args = isset( $args ) && is_array( $args ) ? $args : array();
$mu_code  = isset( $mu_error_args['code'] )    ? (string) $mu_error_args['code']   : ( get_query_var( 'murailles_error_code' )    ?: '404' );
$mu_title = isset( $mu_error_args['title'] )   ? (string) $mu_error_args['title']  : (string) get_query_var( 'murailles_error_title' );
$mu_msg   = isset( $mu_error_args['message'] ) ? (string) $mu_error_args['message']: (string) get_query_var( 'murailles_error_message' );

// Per-code defaults (French copy, on-brand). Each string is run through
// murailles_t( …, false ) so Polylang can translate it.
$mu_defaults = array(
	'404' => array(
		'title'   => murailles_t( 'Page introuvable', false ),
		'message' => murailles_t( "La page que vous cherchez n'existe pas, a été déplacée, ou son lien est obsolète. Pas d'inquiétude — utilisez la recherche ou explorez nos catégories pour trouver le bien qu'il vous faut.", false ),
	),
	'403' => array(
		'title'   => murailles_t( 'Accès refusé', false ),
		'message' => murailles_t( "Vous n'avez pas l'autorisation d'accéder à cette page. Si vous pensez qu'il s'agit d'une erreur, contactez-nous.", false ),
	),
	'500' => array(
		'title'   => murailles_t( 'Erreur serveur', false ),
		'message' => murailles_t( "Une erreur inattendue est survenue de notre côté. Nous travaillons à la résoudre — merci de réessayer dans quelques instants.", false ),
	),
	'503' => array(
		'title'   => murailles_t( 'Service indisponible', false ),
		'message' => murailles_t( "Le site est temporairement indisponible pour maintenance. Nous serons de retour très bientôt.", false ),
	),
	'maintenance' => array(
		'title'   => murailles_t( 'Maintenance en cours', false ),
		'message' => murailles_t( 'Le site fait peau neuve. Merci de revenir dans quelques minutes.', false ),
	),
);

if ( ! isset( $mu_defaults[ $mu_code ] ) ) {
	$mu_defaults[ $mu_code ] = array(
		'title'   => murailles_t( 'Une erreur est survenue', false ),
		'message' => murailles_t( "Quelque chose s'est mal passé. Veuillez réessayer ou revenir à l'accueil.", false ),
	);
}
if ( $mu_title === '' ) { $mu_title = $mu_defaults[ $mu_code ]['title']; }
if ( $mu_msg === '' )   { $mu_msg   = $mu_defaults[ $mu_code ]['message']; }
?>
<section class="murailles-error">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8 col-md-10">
				<div class="murailles-error__card text-center">

					<div class="murailles-error__code"><?php echo esc_html( $mu_code ); ?></div>
					<h1 class="murailles-error__title"><?php echo esc_html( $mu_title ); ?></h1>
					<p class="murailles-error__message"><?php echo esc_html( $mu_msg ); ?></p>

					<form role="search" method="get" action="<?php echo esc_url( murailles_bien_url() ); ?>" class="murailles-error__search">
						<label for="murailles-error-q" class="visually-hidden"><?php murailles_t( 'Rechercher un bien' ); ?></label>
						<input id="murailles-error-q" type="search" name="q" placeholder="<?php echo esc_attr( murailles_t( 'Rechercher un bien, une ville, un quartier…', false ) ); ?>" autocomplete="off">
						<button type="submit" aria-label="<?php echo esc_attr( murailles_t( 'Rechercher', false ) ); ?>"><i class="fa-solid fa-magnifying-glass"></i></button>
					</form>

					<div class="murailles-error__actions">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-danger">
							<i class="fa-solid fa-house me-2"></i> <?php murailles_t( "Retour à l'accueil" ); ?>
						</a>
						<a href="<?php echo esc_url( murailles_bien_url() ); ?>" class="btn btn-outline-dark">
							<i class="fa-solid fa-magnifying-glass-location me-2"></i> <?php murailles_t( 'Parcourir les biens' ); ?>
						</a>
						<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-outline-secondary">
							<i class="fa-solid fa-envelope me-2"></i> <?php murailles_t( 'Nous contacter' ); ?>
						</a>
					</div>

					<?php
					// Popular categories shortcut — pulled live from the taxonomy.
					$mu_pop_cats = get_terms( array(
						'taxonomy'   => 'property_category',
						'hide_empty' => true,
						'orderby'    => 'count',
						'order'      => 'DESC',
						'number'     => 6,
					) );
					if ( ! is_wp_error( $mu_pop_cats ) && ! empty( $mu_pop_cats ) ) :
					?>
					<div class="murailles-error__popular">
						<span class="murailles-error__popular-label"><?php murailles_t( 'Recherches populaires :' ); ?></span>
						<?php foreach ( $mu_pop_cats as $mu_cat ) : ?>
							<a class="murailles-error__chip" href="<?php echo esc_url( add_query_arg( 'ptype', $mu_cat->slug, murailles_bien_url() ) ); ?>">
								<?php echo esc_html( ucwords( strtolower( $mu_cat->name ) ) ); ?>
							</a>
						<?php endforeach; ?>
					</div>
					<?php endif; ?>

				</div>
			</div>
		</div>
	</div>
</section>
