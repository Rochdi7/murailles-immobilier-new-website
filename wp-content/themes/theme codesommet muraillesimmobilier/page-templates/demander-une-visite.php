<?php
/**
 * Template Name: Demander une visite
 *
 * Standalone "Request a viewing" page. Reuses the murailles_visit_request
 * AJAX handler (inc/forms.php) — the visitor picks a property from the
 * dropdown, a date and a time slot; a lead is created and the agency is
 * notified by e-mail.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$murailles_visit_page_id = get_the_ID();

$murailles_visit_hero_bg = murailles_page_section_image_url(
	'hero_bg_image_id',
	murailles_img( 'contact-agence-immobiliere-marrakech.webp' ),
	$murailles_visit_page_id,
	true
);
$murailles_visit_eyebrow  = murailles_page_section_meta( 'hero_eyebrow', murailles_t( 'Planifiez votre rendez-vous', false ) );
$murailles_visit_title    = murailles_page_section_meta( 'hero_title', murailles_t( 'Demander une visite', false ) );
$murailles_visit_subtitle = murailles_page_section_meta( 'hero_subtitle', murailles_t( "Choisissez le bien qui vous intéresse, une date et un créneau : notre équipe vous recontacte pour confirmer votre visite.", false ) );

// Optional ?property_id=… pre-selects a bien when arriving from a listing.
$murailles_visit_preselect = isset( $_GET['property_id'] ) ? absint( $_GET['property_id'] ) : 0;

// Published properties for the selector.
$murailles_visit_properties = get_posts( array(
	'post_type'      => 'property',
	'post_status'    => 'publish',
	'posts_per_page' => -1,
	'orderby'        => 'title',
	'order'          => 'ASC',
	'no_found_rows'  => true,
) );

get_header();
?>

<!-- ============================ Page Title Start ================================== -->
			<div class="page-title" style="background:#f4f4f4 url(<?php echo esc_url( $murailles_visit_hero_bg ); ?>);" data-overlay="6">
				<div class="ht-80"></div>
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12 position-relative z-1">
							<div class="_page_tetio">
								<div class="pledtio_wrap"><span><?php echo esc_html( $murailles_visit_eyebrow ); ?></span></div>
								<h1 class="text-light mb-0"><?php echo esc_html( $murailles_visit_title ); ?></h1>
								<p><?php echo esc_html( $murailles_visit_subtitle ); ?></p>
							</div>
						</div>
					</div>
				</div>
				<div class="ht-120"></div>
			</div>
			<!-- ============================ Page Title End ================================== -->

			<!-- ============================ Visit Request Start ================================== -->
			<section class="pt-0 mt-5">
				<div class="container">
					<div class="row g-4 justify-content-center">

						<!-- Form -->
						<div class="col-lg-7 col-md-12">
							<div class="property_block_wrap">
								<div class="property_block_wrap_header">
									<h4 class="property_block_title"><i class="fa-regular fa-calendar-check text-danger me-2"></i><?php murailles_t( 'Réservez votre visite' ); ?></h4>
								</div>
								<div class="block-body">
									<form class="murailles-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
										<input type="hidden" name="action" value="murailles_visit_request">
										<?php wp_nonce_field( 'murailles_visit_request', '_murailles_nonce' ); ?>
										<input type="hidden" name="page_url" value="<?php echo esc_url( get_permalink( $murailles_visit_page_id ) ); ?>">
										<input type="hidden" name="language" value="<?php echo esc_attr( function_exists( 'pll_current_language' ) ? pll_current_language( 'slug' ) : 'fr' ); ?>">
										<input type="text" name="_mw_hp_url" value="" tabindex="-1" autocomplete="new-password" aria-hidden="true" style="position:absolute;left:-9999px;top:-9999px;opacity:0;width:1px;height:1px;pointer-events:none;">

										<div class="form-group">
											<label><?php murailles_t( 'Bien à visiter' ); ?></label>
											<select name="property_id" class="form-control simple" required>
												<option value=""><?php echo esc_html( murailles_t( 'Sélectionnez un bien…', false ) ); ?></option>
												<?php foreach ( $murailles_visit_properties as $murailles_visit_prop ) : ?>
												<option value="<?php echo esc_attr( $murailles_visit_prop->ID ); ?>" <?php selected( $murailles_visit_preselect, $murailles_visit_prop->ID ); ?>><?php echo esc_html( $murailles_visit_prop->post_title ); ?></option>
												<?php endforeach; ?>
											</select>
										</div>

										<div class="row">
											<div class="col-lg-6 col-md-12">
												<div class="form-group">
													<label><?php murailles_t( 'Nom complet' ); ?></label>
													<input type="text" name="name" class="form-control simple" required>
												</div>
											</div>
											<div class="col-lg-6 col-md-12">
												<div class="form-group">
													<label><?php murailles_t( 'E-mail' ); ?></label>
													<input type="email" name="email" class="form-control simple" required>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-lg-6 col-md-12">
												<div class="form-group">
													<label><?php murailles_t( 'Téléphone' ); ?></label>
													<input type="tel" name="phone" class="form-control simple" required>
												</div>
											</div>
											<div class="col-lg-3 col-md-6">
												<div class="form-group">
													<label><?php murailles_t( 'Date souhaitée' ); ?></label>
													<input type="date" name="visit_date" class="form-control simple" min="<?php echo esc_attr( current_time( 'Y-m-d' ) ); ?>" required>
												</div>
											</div>
											<div class="col-lg-3 col-md-6">
												<div class="form-group">
													<label><?php murailles_t( 'Heure' ); ?></label>
													<select name="visit_time" class="form-control simple" required>
														<option value=""><?php echo esc_html( murailles_t( '--:--', false ) ); ?></option>
														<?php
														// 09:00 → 18:30 in 30-minute slots.
														for ( $h = 9; $h <= 18; $h++ ) {
															foreach ( array( '00', '30' ) as $m ) {
																$slot = sprintf( '%02d:%s', $h, $m );
																echo '<option value="' . esc_attr( $slot ) . '">' . esc_html( $slot ) . '</option>';
															}
														}
														?>
													</select>
												</div>
											</div>
										</div>

										<div class="form-group">
											<label><?php murailles_t( 'Message (optionnel)' ); ?></label>
											<textarea name="message" class="form-control simple" rows="3" placeholder="<?php echo esc_attr( murailles_t( 'Précisions sur votre projet, vos disponibilités…', false ) ); ?>"></textarea>
										</div>

										<div class="form-group mb-0">
											<button class="btn btn-danger fw-medium" type="submit"><i class="fa-regular fa-calendar-check me-2"></i><?php murailles_t( 'Demander une visite' ); ?></button>
										</div>
									</form>
								</div>
							</div>
						</div>

						<!-- Reassurance / steps -->
						<div class="col-lg-5 col-md-12">
							<div class="property_block_wrap" style="height:100%;">
								<div class="property_block_wrap_header">
									<h4 class="property_block_title"><?php murailles_t( 'Comment se passe une visite ?' ); ?></h4>
								</div>
								<div class="block-body">
									<div class="d-flex mb-4">
										<div style="flex-shrink:0;width:44px;height:44px;background:#dc3545;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;margin-right:16px;">1</div>
										<div>
											<h5 class="mb-1"><?php murailles_t( 'Vous choisissez un créneau' ); ?></h5>
											<p class="text-muted mb-0" style="font-size:14px;"><?php murailles_t( 'Sélectionnez le bien, une date et une heure qui vous conviennent.' ); ?></p>
										</div>
									</div>
									<div class="d-flex mb-4">
										<div style="flex-shrink:0;width:44px;height:44px;background:#dc3545;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;margin-right:16px;">2</div>
										<div>
											<h5 class="mb-1"><?php murailles_t( 'Nous confirmons' ); ?></h5>
											<p class="text-muted mb-0" style="font-size:14px;"><?php murailles_t( "Notre équipe vous rappelle sous 24 à 48h pour confirmer la disponibilité." ); ?></p>
										</div>
									</div>
									<div class="d-flex">
										<div style="flex-shrink:0;width:44px;height:44px;background:#dc3545;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;margin-right:16px;">3</div>
										<div>
											<h5 class="mb-1"><?php murailles_t( 'Vous visitez le bien' ); ?></h5>
											<p class="text-muted mb-0" style="font-size:14px;"><?php murailles_t( 'Un conseiller vous accompagne sur place et répond à toutes vos questions.' ); ?></p>
										</div>
									</div>

									<hr style="border:none;border-top:1px solid #eef0f2;margin:24px 0;">

									<div class="d-flex align-items-center">
										<i class="ti-headphone-alt text-danger" style="font-size:30px;margin-right:14px;"></i>
										<div>
											<p class="text-muted mb-0" style="font-size:13px;"><?php murailles_t( 'Une question avant de réserver ?' ); ?></p>
											<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="fw-medium text-danger"><?php murailles_t( 'Contactez-nous' ); ?> <i class="fa fa-arrow-right ms-1" style="font-size:12px;"></i></a>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</section>
			<!-- ============================ Visit Request End ================================== -->

<?php murailles_render_page_builder_content(); ?>

<?php get_footer(); ?>
