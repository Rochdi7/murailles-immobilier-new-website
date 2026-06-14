<?php
/**
 * Template Name: Contact
 *
 * Auto-converted from contact.html
 * Preserves exact original HTML markup, classes, and structure.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$murailles_contact_page_id = get_the_ID();

$murailles_contact_hero_bg = murailles_page_section_image_url(
	'hero_bg_image_id',
	murailles_img( 'contact-agence-immobiliere-marrakech.webp' ),
	$murailles_contact_page_id,
	true
);
$murailles_contact_hero_eyebrow = murailles_page_section_meta( 'hero_eyebrow', murailles_t( 'Contactez-nous', false ) );
$murailles_contact_hero_title = murailles_page_section_meta( 'hero_title', murailles_t( 'Une équipe à votre écoute', false ) );
$murailles_contact_hero_subtitle = murailles_page_section_meta( 'hero_subtitle', murailles_t( "Besoin d'aide pour votre projet immobilier ? Nous sommes joignables 7 jours sur 7.", false ) );
$murailles_contact_phone_label = murailles_page_section_meta( 'phone_label', murailles_t( 'Téléphone', false ) );
$murailles_contact_phone_value = murailles_page_section_meta( 'phone_value', '+212 (0) 6 61 42 51 50' );
$murailles_contact_phone_note = murailles_page_section_meta( 'phone_note', murailles_t( 'Joignable 7j/7', false ) );
$murailles_contact_email_label = murailles_page_section_meta( 'email_label', murailles_t( 'E-mail', false ) );
$murailles_contact_email_value = murailles_page_section_meta( 'email_value', 'contact@murailles-immobilier.com' );
$murailles_contact_email_note = murailles_page_section_meta( 'email_note', murailles_t( 'Réponse sous 24h', false ) );
$murailles_contact_address_label = murailles_page_section_meta( 'address_label', murailles_t( 'Adresse', false ) );
$murailles_contact_address_line_1 = murailles_page_section_meta( 'address_line_1', murailles_t( '13 Rue Mouslim, Résidence Boukar', false ) );
$murailles_contact_address_line_2 = murailles_page_section_meta( 'address_line_2', murailles_t( '2ème étage Bureau N°10, Marrakesh 40000', false ) );
$murailles_contact_map_url = murailles_page_section_meta( 'map_embed_url', 'https://maps.google.com/maps?q=31.633176,-8.004951&z=16&hl=fr&output=embed' );
$murailles_contact_form_heading = murailles_page_section_meta( 'form_heading', murailles_t( 'Écrivez-nous', false ) );
$murailles_contact_latest_heading = murailles_page_section_meta( 'latest_heading', murailles_t( 'Nos derniers biens', false ) );
$murailles_contact_latest_subtitle = murailles_page_section_meta( 'latest_subtitle', murailles_t( "Découvrez les biens immobiliers les plus récemment ajoutés par l'Agence Murailles à travers le Maroc.", false ) );
$murailles_contact_blog_heading = murailles_page_section_meta( 'blog_heading', murailles_t( 'Actualités & Articles', false ) );
$murailles_contact_blog_subtitle = murailles_page_section_meta( 'blog_subtitle', murailles_t( 'Conseils, tendances du marché et guides pour acheter, vendre ou louer votre bien immobilier au Maroc.', false ) );
$murailles_contact_phone_href = 'tel:' . preg_replace( '/[^0-9+]/', '', $murailles_contact_phone_value );
$murailles_contact_email_href = 'mailto:' . sanitize_email( $murailles_contact_email_value );

get_header();
?>

<!-- ============================ Page Title Start================================== -->
			<?php if ( murailles_page_section_is_visible( 'hero', $murailles_contact_page_id ) ) : ?>
			<div class="page-title" style="background:#f4f4f4 url(<?php echo esc_url( $murailles_contact_hero_bg ); ?>);" data-overlay="5">
				<div class="ht-80"></div>
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12 position-relative z-1">
							<div class="_page_tetio">
								<div class="pledtio_wrap"><span><?php echo esc_html( $murailles_contact_hero_eyebrow ); ?></span></div>
								<h2 class="text-light mb-0"><?php echo esc_html( $murailles_contact_hero_title ); ?></h2>
								<p><?php echo esc_html( $murailles_contact_hero_subtitle ); ?></p>
							</div>
						</div>
					</div>
				</div>
				<div class="ht-120"></div>
			</div>
			<?php endif; ?>
			<!-- ============================ Page Title End ================================== -->
			
			<!-- ============================ Agency List Start ================================== -->
			<?php if ( murailles_page_section_is_visible( 'contact-cards', $murailles_contact_page_id ) || murailles_page_section_is_visible( 'form', $murailles_contact_page_id ) ) : ?>
			<section class="pt-0">
				<div class="container">
					<?php if ( murailles_page_section_is_visible( 'contact-cards', $murailles_contact_page_id ) ) : ?>
					<div class="row align-items-center pretio_top">
						
						<div class="col-lg-4 col-md-4 col-sm-12">
							<div class="contact-box">
								<i class="ti-mobile text-danger"></i>
								<h4><?php echo esc_html( $murailles_contact_phone_label ); ?></h4>
								<p><a href="<?php echo esc_url( $murailles_contact_phone_href ); ?>"><?php echo esc_html( $murailles_contact_phone_value ); ?></a></p>
								<span><?php echo esc_html( $murailles_contact_phone_note ); ?></span>
							</div>
						</div>

						<div class="col-lg-4 col-md-4 col-sm-12">
							<div class="contact-box">
								<i class="ti-email text-danger"></i>
								<h4><?php echo esc_html( $murailles_contact_email_label ); ?></h4>
								<p><a href="<?php echo esc_url( $murailles_contact_email_href ); ?>"><?php echo esc_html( $murailles_contact_email_value ); ?></a></p>
								<span><?php echo esc_html( $murailles_contact_email_note ); ?></span>
							</div>
						</div>

						<div class="col-lg-4 col-md-4 col-sm-12">
							<div class="contact-box">
								<i class="ti-location-pin text-danger"></i>
								<h4><?php echo esc_html( $murailles_contact_address_label ); ?></h4>
								<p><?php echo esc_html( $murailles_contact_address_line_1 ); ?></p>
								<span><?php echo esc_html( $murailles_contact_address_line_2 ); ?></span>
							</div>
						</div>
						
					</div>
					<?php endif; ?>
					
					<!-- row Start -->
					<?php if ( murailles_page_section_is_visible( 'form', $murailles_contact_page_id ) ) : ?>
					<div class="row">
						<div class="col-lg-8 col-md-7">
							<div class="property_block_wrap">
								
								<div class="property_block_wrap_header">
									<h4 class="property_block_title"><?php echo esc_html( $murailles_contact_form_heading ); ?></h4>
								</div>
								
								<div class="block-body">
									<form class="murailles-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
										<input type="hidden" name="action" value="murailles_contact">
										<?php wp_nonce_field( 'murailles_contact', '_murailles_nonce' ); ?>
										<input type="hidden" name="page_url" value="<?php echo esc_url( get_permalink( $murailles_contact_page_id ) ); ?>">
										<input type="hidden" name="language" value="<?php echo esc_attr( function_exists( 'pll_current_language' ) ? pll_current_language( 'slug' ) : 'fr' ); ?>">
										<input type="text" name="_mw_hp_url" value="" tabindex="-1" autocomplete="new-password" aria-hidden="true" style="position:absolute;left:-9999px;top:-9999px;opacity:0;width:1px;height:1px;pointer-events:none;">

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

										<div class="form-group">
											<label><?php murailles_t( 'Sujet' ); ?></label>
											<input type="text" name="subject" class="form-control simple">
										</div>

										<div class="form-group">
											<label><?php murailles_t( 'Message' ); ?></label>
											<textarea name="message" class="form-control simple" required></textarea>
										</div>

										<div class="form-group">
											<button class="btn btn-danger" type="submit"><?php murailles_t( 'Envoyer ma demande' ); ?></button>
										</div>
									</form>
								</div>
								
							</div>
											
						</div>
						
						<div class="col-lg-4 col-md-5">
							<iframe src="<?php echo esc_url( $murailles_contact_map_url ); ?>" width="100%" height="470" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
						</div>
						
					</div>
					<!-- /row -->		
					<?php endif; ?>
				</div>	
			</section>
			<?php endif; ?>
			<!-- ============================ Agency List End ================================== -->
			
			<!-- ============================ Latest Properties Start ================================== -->
			<?php if ( murailles_page_section_is_visible( 'latest-properties', $murailles_contact_page_id ) ) : ?>
			<section class="gray-simple">
				<div class="container">

					<div class="row justify-content-center">
						<div class="col-lg-7 col-md-8">
							<div class="sec-heading center">
								<h2><?php echo esc_html( $murailles_contact_latest_heading ); ?></h2>
								<p><?php echo esc_html( $murailles_contact_latest_subtitle ); ?></p>
							</div>
						</div>
					</div>

					<div class="row g-4 justify-content-center">
						<?php
						$_latest = new WP_Query( array(
							'post_type'      => 'property',
							'posts_per_page' => 3,
							'post_status'    => 'publish',
							'orderby'        => 'date',
							'order'          => 'DESC',
						) );
						if ( $_latest->have_posts() ) :
							while ( $_latest->have_posts() ) : $_latest->the_post();
								$pid    = get_the_ID();
								$plink  = get_permalink();
								$pprice = get_post_meta( $pid, '_property_price', true );
								$psuffix= get_post_meta( $pid, '_property_price_suffix', true );
								$paction= get_post_meta( $pid, '_property_action', true );
								$paddr  = get_post_meta( $pid, '_property_address', true );
								$psize  = get_post_meta( $pid, '_property_size', true );
								$pbeds  = get_post_meta( $pid, '_property_bedrooms', true );
								$pbaths = get_post_meta( $pid, '_property_bathrooms', true );
								$pcats  = wp_get_post_terms( $pid, 'property_category', array( 'fields' => 'names' ) );
								$plocs  = wp_get_post_terms( $pid, 'property_location', array( 'fields' => 'names' ) );
								$pcat   = $pcats ? $pcats[0] : '';
								$ploc   = $plocs ? $plocs[0] : '';
								$thumb  = has_post_thumbnail() ? get_the_post_thumbnail_url( $pid, 'medium_large' ) : murailles_img( 'p-' . ( ( $pid % 9 ) + 1 ) . '.png' );
						?>
						<div class="col-lg-4 col-md-6 col-sm-12">
							<div class="property-listing property-2 h-100">
								<div class="listing-img-wrapper">
									<?php if ( $paction ) : ?><div class="_exlio_125"><?php echo esc_html( $paction ); ?></div><?php endif; ?>
									<a href="<?php echo esc_url( $plink ); ?>"><img src="<?php echo esc_url( $thumb ); ?>" class="img-fluid mx-auto" alt="<?php the_title_attribute(); ?>" /></a>
								</div>
								<div class="listing-detail-wrapper">
									<div class="listing-short-detail-wrap">
										<div class="_card_list_flex mb-2">
											<div class="_card_flex_01">
												<?php if ( $pbeds ) : ?><span class="_list_blickes _netork"><?php echo esc_html( $pbeds ); ?> <?php murailles_t( 'Ch.' ); ?></span><?php endif; ?>
												<?php if ( $pcat ) : ?><span class="_list_blickes types"><?php echo esc_html( $pcat ); ?></span><?php endif; ?>
											</div>
											<div class="_card_flex_last">
												<h6 class="listing-card-info-price mb-0"><?php echo esc_html( $pprice ); ?> €<?php if ( $psuffix ) echo ' ' . esc_html( $psuffix ); ?></h6>
											</div>
										</div>
										<div class="_card_list_flex">
											<div class="_card_flex_01">
												<h4 class="listing-name verified"><a href="<?php echo esc_url( $plink ); ?>" class="prt-link-detail"><?php the_title(); ?></a></h4>
											</div>
										</div>
									</div>
								</div>
								<div class="price-features-wrapper">
									<div class="list-fx-features">
										<?php if ( $pbeds ) : ?>
										<div class="listing-card-info-icon"><div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bed.svg' ) ); ?>" width="15" alt="" /></div><?php echo esc_html( $pbeds ); ?> <?php murailles_t( 'Ch.' ); ?></div>
										<?php endif; ?>
										<?php if ( $pbaths ) : ?>
										<div class="listing-card-info-icon"><div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bathtub.svg' ) ); ?>" width="15" alt="" /></div><?php echo esc_html( $pbaths ); ?> <?php murailles_t( 'SdB' ); ?></div>
										<?php endif; ?>
										<?php if ( $psize ) : ?>
										<div class="listing-card-info-icon"><div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'move.svg' ) ); ?>" width="15" alt="" /></div><?php echo esc_html( $psize ); ?> m²</div>
										<?php endif; ?>
									</div>
								</div>
								<div class="listing-detail-footer">
									<div class="footer-first">
										<div class="foot-location"><img src="<?php echo esc_url( murailles_img( 'pin.svg' ) ); ?>" width="18" alt="" /><?php echo esc_html( $paddr ?: $ploc ); ?></div>
									</div>
									<div class="footer-flex">
										<a href="<?php echo esc_url( $plink ); ?>" class="prt_saveed_12lk"><i class="fa-regular fa-circle-right"></i></a>
									</div>
								</div>
							</div>
						</div>
						<?php
							endwhile;
							wp_reset_postdata();
						else :
						?>
						<div class="col-12 text-center">
							<p><?php murailles_t( 'Aucun bien disponible pour le moment.' ); ?></p>
							<a href="<?php echo esc_url( murailles_bien_url() ); ?>" class="btn btn-danger"><?php murailles_t( 'Voir tous les biens' ); ?></a>
						</div>
						<?php endif; ?>
					</div>

				</div>
			</section>
			<?php endif; ?>
			<!-- ============================ Latest Properties End ================================== -->
			
			<!-- ============================ article Start ================================== -->
			<?php if ( murailles_page_section_is_visible( 'articles', $murailles_contact_page_id ) ) : ?>
			<section>
				<div class="container">

					<div class="row justify-content-center">
						<div class="col-lg-7 col-md-8">
							<div class="sec-heading center">
								<h2><?php echo esc_html( $murailles_contact_blog_heading ); ?></h2>
								<p><?php echo esc_html( $murailles_contact_blog_subtitle ); ?></p>
							</div>
						</div>
					</div>

					<div class="row g-4">
						<?php
						$_posts = new WP_Query( array(
							'post_type'      => 'post',
							'posts_per_page' => 3,
							'post_status'    => 'publish',
							'orderby'        => 'date',
							'order'          => 'DESC',
						) );
						if ( $_posts->have_posts() ) :
							while ( $_posts->have_posts() ) : $_posts->the_post();
								$blink = get_permalink();
								$bthumb = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'medium_large' ) : murailles_img( 'b-1.jpg' );
								$author_id = get_the_author_meta( 'ID' );
								$author_url = get_author_posts_url( $author_id );
								$author_av = get_avatar_url( $author_id, array( 'size' => 60 ) );
						?>
						<div class="col-lg-4 col-md-6">
							<div class="grid_blog_box">

								<div class="gtid_blog_thumb">
									<a href="<?php echo esc_url( $blink ); ?>"><img src="<?php echo esc_url( $bthumb ); ?>" class="img-fluid" alt="<?php the_title_attribute(); ?>" /></a>
									<div class="gtid_blog_info"><span><?php echo esc_html( get_the_date( 'd' ) ); ?></span><?php echo esc_html( get_the_date( 'M Y' ) ); ?></div>
								</div>

								<div class="blog-body">
									<h4 class="bl-title"><a href="<?php echo esc_url( $blink ); ?>"><?php the_title(); ?></a></h4>
									<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
								</div>

								<div class="modern_property_footer">
									<div class="property-author">
										<div class="path-img"><a href="<?php echo esc_url( $author_url ); ?>" tabindex="-1"><img src="<?php echo esc_url( $author_av ); ?>" class="img-fluid" alt=""></a></div>
										<h5><a href="<?php echo esc_url( $author_url ); ?>" tabindex="-1"><?php the_author(); ?></a></h5>
									</div>
									<span class="article-pulish-date"><i class="ti-comment-alt me-2"></i><?php echo esc_html( get_comments_number() ); ?></span>
								</div>

							</div>
						</div>
						<?php
							endwhile;
							wp_reset_postdata();
						else :
						?>
						<div class="col-12 text-center">
							<p><?php murailles_t( 'Aucun article publié pour le moment.' ); ?></p>
						</div>
						<?php endif; ?>
					</div>

				</div>
			</section>
			<?php endif; ?>
			<!-- ============================ article End ================================== -->

<?php murailles_render_page_builder_content(); ?>

<?php get_template_part( 'template-parts/call-to-action' ); ?>

<?php get_footer(); ?>
