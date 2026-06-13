<?php
/**
 * Front Page Template
 *
 * Displays the homepage layout from the original index.html.
 * Uses the transparent header with dual logos.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$murailles_front_page_id           = get_the_ID();
$murailles_front_hero_bg           = murailles_page_section_image_url( 'hero_bg_image_id', murailles_img( 'villa-luxe-marrakech-hero.webp' ), $murailles_front_page_id, true );
$murailles_front_title             = murailles_page_section_meta( 'hero_title', murailles_t( 'Trouvez votre prochain bien', false ), $murailles_front_page_id );
$murailles_front_subtitle          = murailles_page_section_meta( 'hero_subtitle', murailles_t( 'Découvrez les nouveaux biens immobiliers à la une dans votre ville.', false ), $murailles_front_page_id );
$murailles_front_adm_heading       = murailles_page_section_meta( 'adm_heading', murailles_t( 'Affaires du Mois', false ), $murailles_front_page_id );
$murailles_front_adm_subtitle      = murailles_page_section_meta( 'adm_subtitle', murailles_t( 'Notre sélection du moment : les meilleures opportunités immobilières à ne pas manquer ce mois-ci.', false ), $murailles_front_page_id );
$murailles_front_featured_heading  = murailles_page_section_meta( 'featured_heading', murailles_t( 'Biens immobiliers à la une', false ), $murailles_front_page_id );
$murailles_front_featured_subtitle = murailles_page_section_meta( 'featured_subtitle', murailles_t( 'Une sélection exclusive de riads, villas et appartements à Marrakech, Casablanca, Rabat et dans les plus belles villes du Maroc.', false ), $murailles_front_page_id );
$murailles_front_featured_button   = murailles_page_section_meta( 'featured_button_label', murailles_t( 'Voir tous les biens', false ), $murailles_front_page_id );
$murailles_front_how_heading       = murailles_page_section_meta( 'how_heading', murailles_t( 'Comment ça marche ?', false ), $murailles_front_page_id );
$murailles_front_how_subtitle      = murailles_page_section_meta( 'how_subtitle', murailles_t( "Trois étapes simples pour trouver le bien immobilier qui vous correspond avec l'Agence Murailles : explorez nos annonces, affinez votre recherche et réservez votre coup de cœur.", false ), $murailles_front_page_id );
$murailles_front_how_step_1_title  = murailles_page_section_meta( 'how_step_1_title', murailles_t( 'Explorez nos annonces', false ), $murailles_front_page_id );
$murailles_front_how_step_1_text   = murailles_page_section_meta( 'how_step_1_text', murailles_t( 'Parcourez notre sélection de riads, villas et appartements à Marrakech, en location ou à la vente.', false ), $murailles_front_page_id );
$murailles_front_how_step_2_title  = murailles_page_section_meta( 'how_step_2_title', murailles_t( 'Trouvez votre bien', false ), $murailles_front_page_id );
$murailles_front_how_step_2_text   = murailles_page_section_meta( 'how_step_2_text', murailles_t( 'Filtrez par ville, type de bien et budget pour découvrir les riads, villas et appartements qui correspondent à vos critères.', false ), $murailles_front_page_id );
$murailles_front_how_step_3_title  = murailles_page_section_meta( 'how_step_3_title', murailles_t( 'Réservez votre bien', false ), $murailles_front_page_id );
$murailles_front_how_step_3_text   = murailles_page_section_meta( 'how_step_3_text', murailles_t( "Contactez notre équipe pour organiser une visite, négocier le prix et finaliser votre acquisition en toute sérénité.", false ), $murailles_front_page_id );
$murailles_front_about_image       = murailles_page_section_image_url( 'about_image_id', murailles_img( 'about-agence-murailles-immobilier.webp' ), $murailles_front_page_id );
$murailles_front_about_badge_num   = murailles_page_section_meta( 'about_badge_number', '15+', $murailles_front_page_id );
$murailles_front_about_badge_text  = murailles_page_section_meta( 'about_badge_text', murailles_t( "Années d'expérience", false ), $murailles_front_page_id );
$murailles_front_about_eyebrow     = murailles_page_section_meta( 'about_eyebrow', murailles_t( 'À propos de nous', false ), $murailles_front_page_id );
$murailles_front_about_heading     = murailles_page_section_meta( 'about_heading', murailles_t( 'Qui sommes-nous ?', false ), $murailles_front_page_id );
$murailles_front_about_text_1      = murailles_page_section_meta( 'about_text_1', murailles_t( "est sans aucun doute l'agence immobilière la plus investie en termes de suivi et d'accompagnement dans vos projets immobiliers.", false ), $murailles_front_page_id );
$murailles_front_about_text_2      = murailles_page_section_meta( 'about_text_2', murailles_t( "Depuis la création de l'agence, le fondateur Youssef MOUMEN a comme principal objectif de dénicher le produit tant espéré par ses clients. La présence et l'implication de notre équipe dans les différents secteurs de Marrakech garantissent une analyse experte de votre bien à vendre ou de votre acquisition au juste prix.", false ), $murailles_front_page_id );
$murailles_front_about_text_3      = murailles_page_section_meta( 'about_text_3', murailles_t( "Chaque type de bien et chaque secteur de Marrakech répondent à une logique de marché distincte, c'est l'ensemble de ces savoir-faire que nous mettons à votre disposition.", false ), $murailles_front_page_id );
$murailles_front_about_button      = murailles_page_section_meta( 'about_button_label', murailles_t( 'Découvrir nos services', false ), $murailles_front_page_id );
$murailles_front_about_button_url  = murailles_page_section_meta( 'about_button_url', home_url( '/nos-services/' ), $murailles_front_page_id );
$murailles_front_cities_heading    = murailles_page_section_meta( 'cities_heading', murailles_t( 'Villes phares au Maroc', false ), $murailles_front_page_id );
$murailles_front_cities_subtitle   = murailles_page_section_meta( 'cities_subtitle', murailles_t( 'Explorez les biens immobiliers disponibles dans les destinations les plus recherchées du Royaume : Marrakech, Casablanca, Rabat, Tanger et Fès.', false ), $murailles_front_page_id );
$murailles_front_testi_heading     = murailles_page_section_meta( 'testimonials_heading', murailles_t( 'Avis de nos clients', false ), $murailles_front_page_id );
$murailles_front_testi_subtitle    = murailles_page_section_meta( 'testimonials_subtitle', murailles_t( 'Découvrez les témoignages de propriétaires et acheteurs qui nous ont fait confiance pour leur projet immobilier au Maroc.', false ), $murailles_front_page_id );
$murailles_front_cta_bg            = murailles_page_section_image_url( 'cta_bg_image_id', murailles_img( 'villa-luxe-marrakech-hero.webp' ), $murailles_front_page_id );
$murailles_front_cta_eyebrow       = murailles_page_section_meta( 'cta_eyebrow', murailles_t( 'Votre projet immobilier', false ), $murailles_front_page_id );
$murailles_front_cta_title         = murailles_page_section_meta( 'cta_title', murailles_t( 'Vous cherchez le lieu idéal pour réaliser votre rêve ?', false ), $murailles_front_page_id );
$murailles_front_cta_text          = murailles_page_section_meta( 'cta_text', murailles_t( "Riads d'exception dans la médina, villas avec piscine à la Palmeraie, appartements modernes à Casablanca ou Rabat — l'Agence Murailles vous accompagne pour trouver le bien qui correspond à votre projet de vie au Maroc.", false ), $murailles_front_page_id );
$murailles_front_cta_primary_label = murailles_page_section_meta( 'cta_primary_label', murailles_t( 'Voir les biens', false ), $murailles_front_page_id );
$murailles_front_cta_primary_url   = murailles_page_section_meta( 'cta_primary_url', murailles_bien_url(), $murailles_front_page_id );
$murailles_front_cta_secondary     = murailles_page_section_meta( 'cta_secondary_label', murailles_t( 'Nous contacter', false ), $murailles_front_page_id );
$murailles_front_cta_secondary_url = murailles_page_section_meta( 'cta_secondary_url', home_url( '/contact/' ), $murailles_front_page_id );
$murailles_front_blog_heading      = murailles_page_section_meta( 'blog_heading', murailles_t( 'Actualités & Articles', false ), $murailles_front_page_id );
$murailles_front_blog_subtitle     = murailles_page_section_meta( 'blog_subtitle', murailles_t( 'Conseils, tendances du marché et guides pour acheter, vendre ou louer votre bien immobilier au Maroc.', false ), $murailles_front_page_id );

$murailles_front_repeat_defaults   = murailles_page_editor_repeatable_defaults( 'front-page' );
$murailles_front_service_cards     = murailles_get_repeatable_meta( '_murailles_service_cards', isset( $murailles_front_repeat_defaults['_murailles_service_cards'] ) ? $murailles_front_repeat_defaults['_murailles_service_cards'] : array(), $murailles_front_page_id );
$murailles_front_commitment_cards  = murailles_get_repeatable_meta( '_murailles_commitment_cards', isset( $murailles_front_repeat_defaults['_murailles_commitment_cards'] ) ? $murailles_front_repeat_defaults['_murailles_commitment_cards'] : array(), $murailles_front_page_id );
$murailles_front_city_tiles        = murailles_get_repeatable_meta( '_murailles_city_tiles', isset( $murailles_front_repeat_defaults['_murailles_city_tiles'] ) ? $murailles_front_repeat_defaults['_murailles_city_tiles'] : array(), $murailles_front_page_id );
$murailles_front_home_testimonials = murailles_get_repeatable_meta( '_murailles_home_testimonials', isset( $murailles_front_repeat_defaults['_murailles_home_testimonials'] ) ? $murailles_front_repeat_defaults['_murailles_home_testimonials'] : array(), $murailles_front_page_id );
$murailles_front_commitment        = ! empty( $murailles_front_commitment_cards[0] ) ? $murailles_front_commitment_cards[0] : array();

$murailles_header_style = 'transparent';
get_header();
?>

<!-- ============================ Hero Banner  Start================================== -->
			<?php if ( murailles_page_section_is_visible( 'hero', $murailles_front_page_id ) ) : ?>
			<div class="image-cover hero_banner" style="background:url(<?php echo esc_url( $murailles_front_hero_bg ); ?>) no-repeat;" data-overlay="4">
				<div class="container">
					
					<h1 class="big-header-capt mb-0"><?php echo esc_html( $murailles_front_title ); ?></h1>
					<p class="text-center"><?php echo esc_html( $murailles_front_subtitle ); ?></p>
					<!-- Type -->
					<div class="row justify-content-center mt-5">
						<div class="col-xl-10 col-lg-11 col-md-12">
							<?php
							/**
							 * Hero search form. GET submits to /bien/ which renders
							 * archive-property.php and reads `location`, `ptype`,
							 * `price_min`, `price_max`. Price ranges are stored as
							 * a single "min-max" value on the <select> and split
							 * into two query args by a tiny submit handler below.
							 */
							$hero_locations = get_terms( array(
								'taxonomy'   => 'property_location',
								'hide_empty' => false,
								'parent'     => 0,
								'orderby'    => 'name',
							) );
							$hero_loc_options = array();
							if ( ! is_wp_error( $hero_locations ) ) {
								foreach ( $hero_locations as $country ) {
									$children = get_terms( array(
										'taxonomy'   => 'property_location',
										'hide_empty' => false,
										'parent'     => $country->term_id,
										'orderby'    => 'name',
									) );
									if ( ! is_wp_error( $children ) ) {
										foreach ( $children as $city ) {
											$hero_loc_options[] = $city;
										}
									}
								}
								if ( empty( $hero_loc_options ) ) {
									$hero_loc_options = $hero_locations;
								}
							}

							$hero_ptypes = get_terms( array(
								'taxonomy'   => 'property_category',
								'hide_empty' => false,
								'orderby'    => 'name',
							) );
							if ( is_wp_error( $hero_ptypes ) ) { $hero_ptypes = array(); }
							?>
							<form id="murailles-hero-search" method="get" action="<?php echo esc_url( murailles_bien_url() ); ?>" class="full_search_box nexio_search lightanic_search hero_search-radius modern">
								<div class="search_hero_wrapping">

									<div class="row">
										<div class="col-lg-4 col-md-3 col-sm-12">
											<div class="form-group">
												<label><?php murailles_t( 'Ville / Quartier' ); ?></label>
												<div class="input-with-icon">
													<select id="location" name="location" class="form-control" aria-label="<?php echo esc_attr( murailles_t( 'Ville / Quartier', false ) ); ?>">
														<option value=""><?php echo esc_html( murailles_t( 'Toutes les villes', false ) ); ?></option>
														<?php foreach ( $hero_loc_options as $loc ) : ?>
														<option value="<?php echo esc_attr( $loc->slug ); ?>"><?php echo esc_html( $loc->name ); ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
										</div>

										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label><?php murailles_t( 'Type de bien' ); ?></label>
												<div class="input-with-icon">
													<select id="ptypes" name="ptype" class="form-control" aria-label="<?php echo esc_attr( murailles_t( 'Type de bien', false ) ); ?>">
														<option value=""><?php echo esc_html( murailles_t( 'Tous les types', false ) ); ?></option>
														<?php foreach ( $hero_ptypes as $cat ) : ?>
														<option value="<?php echo esc_attr( $cat->slug ); ?>"><?php echo esc_html( ucwords( strtolower( $cat->name ) ) ); ?></option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
										</div>

										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group none">
												<label><?php murailles_t( 'Fourchette de prix' ); ?></label>
												<div class="input-with-icon">
													<select id="price" name="price_range" class="form-control" data-murailles-price-range aria-label="<?php echo esc_attr( murailles_t( 'Fourchette de prix', false ) ); ?>">
														<option value=""><?php echo esc_html( murailles_t( 'Tous les budgets', false ) ); ?></option>
														<option value="40000-100000"><?php murailles_t( 'De 40 000 € à 100 000 €' ); ?></option>
														<option value="100000-250000"><?php murailles_t( 'De 100 000 € à 250 000 €' ); ?></option>
														<option value="250000-500000"><?php murailles_t( 'De 250 000 € à 500 000 €' ); ?></option>
														<option value="500000-1000000"><?php murailles_t( 'De 500 000 € à 1 000 000 €' ); ?></option>
														<option value="1000000-0"><?php murailles_t( 'Plus de 1 000 000 €' ); ?></option>
													</select>
												</div>
											</div>
										</div>

										<div class="col-lg-1 col-md-2 col-sm-12 small-padd">
											<div class="form-group none">
												<button type="submit" class="btn btn-danger full-width" aria-label="<?php echo esc_attr( murailles_t( 'Rechercher', false ) ); ?>"><i class="fa fa-search"></i></button>
											</div>
										</div>
									</div>

								</div>
							</form>
							<script>
							/* Split the price range option (value="min-max") into separate
							   price_min/price_max query args, and disable empty fields so
							   the resulting URL stays tidy. */
							( function () {
								var form = document.getElementById( 'murailles-hero-search' );
								if ( ! form ) { return; }
								form.addEventListener( 'submit', function () {
									var rangeSel = form.querySelector( '[data-murailles-price-range]' );
									if ( rangeSel && rangeSel.value ) {
										var parts = rangeSel.value.split( '-' );
										var min = parseInt( parts[0], 10 ) || 0;
										var max = parseInt( parts[1], 10 ) || 0;
										function ensureHidden( name ) {
											var inp = form.querySelector( 'input[name="' + name + '"]' );
											if ( ! inp ) {
												inp = document.createElement( 'input' );
												inp.type = 'hidden';
												inp.name = name;
												form.appendChild( inp );
											}
											return inp;
										}
										ensureHidden( 'price_min' ).value = min > 0 ? min : '';
										ensureHidden( 'price_max' ).value = max > 0 ? max : '';
										rangeSel.disabled = true;
									}
									Array.prototype.forEach.call( form.elements, function ( el ) {
										if ( el.name && el.value === '' && el.tagName !== 'BUTTON' ) {
											el.disabled = true;
										}
									} );
								} );
							} )();
							</script>
						</div>
					</div>
				</div>
			</div>
			<?php endif; ?>
			<!-- ============================ Hero Banner End ================================== -->

			<!-- ============================ Our Awards Start ================================== -->
			<section class="p-0">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-xl-11 col-lg-11 col-md-12">
						
							<div class="_awards_group">	
								<ul class="_awards_lists">
									<!-- single list -->
									<li>
										<div class="_awards_list_wrap">
											<div class="d-flex align-items-center">
												<div class="rats-thumb">
													<img src="<?php echo esc_url( murailles_img( 'trust.webp' ) ); ?>" class="img-fluid" width="70" alt="Trustpilot">
												</div>
												<div class="ploi ps-3">
													<div class="d-flex align-items-center">
														<i class="fas fa-star text-warning me-1"></i>
														<i class="fas fa-star text-warning me-1"></i>
														<i class="fas fa-star text-warning me-1"></i>
														<i class="fas fa-star text-warning me-1"></i>
														<i class="fas fa-star text-warning"></i>
													</div>
													<div class="explio mt-1">
														<p class="m-0 text-muted">412 <?php murailles_t( 'avis au total' ); ?></p>
													</div>
												</div>
											</div>
										</div>
									</li>
									<!-- single list -->
									<li>
										<div class="_awards_list_wrap">
											<div class="d-flex align-items-center">
												<div class="rats-thumb">
													<i class="fab fa-google" style="font-size:42px;color:#4285F4;"></i>
												</div>
												<div class="ploi ps-3">
													<div class="d-flex align-items-center">
														<i class="fas fa-star text-warning me-1"></i>
														<i class="fas fa-star text-warning me-1"></i>
														<i class="fas fa-star text-warning me-1"></i>
														<i class="fas fa-star text-warning me-1"></i>
														<i class="fas fa-star text-warning"></i>
													</div>
													<div class="explio mt-1">
														<p class="m-0 text-muted">587 <?php murailles_t( 'avis au total' ); ?></p>
													</div>
												</div>
											</div>
										</div>
									</li>
									<!-- single list -->
									<li>
										<div class="_awards_list_wrap">
											<div class="d-flex align-items-center">
												<div class="rats-thumb">
													<i class="fas fa-house-chimney" style="font-size:38px;color:#e74c3c;"></i>
												</div>
												<div class="ploi ps-3">
													<div class="d-flex align-items-center">
														<i class="fas fa-star text-warning me-1"></i>
														<i class="fas fa-star text-warning me-1"></i>
														<i class="fas fa-star text-warning me-1"></i>
														<i class="fas fa-star text-warning me-1"></i>
														<i class="fas fa-star text-warning"></i>
													</div>
													<div class="explio mt-1">
														<p class="m-0 text-muted">324 <?php murailles_t( 'avis au total' ); ?></p>
													</div>
												</div>
											</div>
										</div>
									</li>
								</ul>
							</div>
							
						</div>
					</div>
				</div>
			</section>
			<!-- ============================ Our Awards End ================================== -->
			
			<!-- ============================ Property Category End ================================== -->

			<!-- ============================ Affaires du Mois Start ================================== -->
			<?php if ( murailles_page_section_is_visible( 'affaires-du-mois', $murailles_front_page_id ) ) : ?>
			<?php
			$_adm_ids = array_filter( array_map( 'intval', (array) get_option( 'murailles_affaires_du_mois', array() ) ) );
			if ( ! empty( $_adm_ids ) ) :
			?>
			<section class="pt-5">
				<div class="container">

					<div class="row justify-content-center">
						<div class="col-lg-7 col-md-8">
							<div class="sec-heading center">
								<h2><?php echo esc_html( $murailles_front_adm_heading ); ?></h2>
								<p><?php echo esc_html( $murailles_front_adm_subtitle ); ?></p>
							</div>
						</div>
					</div>

					<div class="item-slide murailles-adm-slide space" data-murailles-adm-carousel>
						<?php
						$_adm_query = new WP_Query( array(
							'post_type'      => 'property',
							'post__in'       => $_adm_ids,
							'orderby'        => 'post__in',
							'posts_per_page' => count( $_adm_ids ),
							'post_status'    => 'publish',
						) );
						if ( $_adm_query->have_posts() ) :
							while ( $_adm_query->have_posts() ) : $_adm_query->the_post();
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
								$gallery= get_post_meta( $pid, '_property_gallery_ids', true );
								$imgs   = array();
								if ( $gallery ) {
									foreach ( array_slice( array_filter( explode( ',', $gallery ) ), 0, 3 ) as $gid ) {
										$u = wp_get_attachment_image_url( intval( $gid ), 'medium_large' );
										if ( $u ) $imgs[] = $u;
									}
								}
								if ( empty( $imgs ) ) $imgs[] = $thumb;
								
						?>
						<!-- Affaire du Mois Card -->
						<div class="single_items" data-murailles-id="<?php echo esc_attr( $pid ); ?>">
							<div class="property-listing property-2 h-100">

								<div class="listing-img-wrapper">
									<?php if ( $paction ) : ?><div class="_exlio_125"><?php echo esc_html( $paction ); ?></div><?php endif; ?>
		<div class="list-img-slide">
										<div class="click">
											<?php foreach ( $imgs as $img_url ) : ?>
											<div><a href="<?php echo esc_url( $plink ); ?>"><img src="<?php echo esc_url( $img_url ); ?>" class="img-fluid mx-auto" alt="<?php the_title_attribute(); ?>" width="1200" height="800" loading="lazy" decoding="async" /></a></div>
											<?php endforeach; ?>
										</div>
									</div>
								</div>

								<div class="listing-detail-wrapper">
									<div class="listing-short-detail-wrap">
										<div class="_card_list_flex mb-2">
											<div class="_card_flex_01">
												<?php if ( $pbeds ) : ?><span class="_list_blickes _netork"><?php echo esc_html( $pbeds ); ?> <?php murailles_t( 'Ch.' ); ?></span><?php endif; ?>
												<?php if ( $pcat ) : ?><span class="_list_blickes types"><?php echo esc_html( $pcat ); ?></span><?php endif; ?>
											</div>
											<?php if ( $pprice !== '' ) : ?>
											<div class="_card_flex_last">
												<h6 class="listing-card-info-price mb-0"><?php echo esc_html( $pprice ); ?> €<?php if ( $psuffix ) echo ' ' . esc_html( $psuffix ); ?></h6>
											</div>
											<?php endif; ?>
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
										<div class="listing-card-info-icon">
											<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bed.svg' ) ); ?>" width="15" height="15" alt="" loading="lazy" decoding="async" /></div><?php echo esc_html( $pbeds ); ?> <?php murailles_t( 'Ch.' ); ?>
										</div>
										<?php endif; ?>
										<?php if ( $pbaths ) : ?>
										<div class="listing-card-info-icon">
											<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bathtub.svg' ) ); ?>" width="15" height="15" alt="" loading="lazy" decoding="async" /></div><?php echo esc_html( $pbaths ); ?> <?php murailles_t( 'SdB' ); ?>
										</div>
										<?php endif; ?>
										<?php if ( $psize ) : ?>
										<div class="listing-card-info-icon">
											<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'move.svg' ) ); ?>" width="15" height="15" alt="" loading="lazy" decoding="async" /></div><?php echo esc_html( $psize ); ?> m²
										</div>
										<?php endif; ?>
									</div>
								</div>

								<div class="listing-detail-footer">
									<div class="footer-first">
										<div class="foot-location"><img src="<?php echo esc_url( murailles_img( 'pin.svg' ) ); ?>" width="18" height="18" alt="" loading="lazy" decoding="async" /><?php echo esc_html( $paddr ?: $ploc ); ?></div>
									</div>
									<div class="footer-flex">
										<ul class="selio_style">
											<li>
												<div class="prt_saveed_12lk">
													<label class="toggler toggler-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?php echo esc_attr( murailles_t( 'Enregistrer le bien', false ) ); ?>" aria-label="<?php echo esc_attr( murailles_t( 'Enregistrer le bien', false ) ); ?>"><input type="checkbox"><i class="fa-solid fa-heart"></i></label>
												</div>
											</li>
											<li>
												<div class="prt_saveed_12lk">
													<a href="<?php echo esc_url( home_url( '/compare-property/' ) ); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?php echo esc_attr( murailles_t( 'Comparer le bien', false ) ); ?>" aria-label="<?php echo esc_attr( murailles_t( 'Comparer le bien', false ) ); ?>"><i class="fa-solid fa-share"></i></a>
												</div>
											</li>
											<li>
												<div class="prt_saveed_12lk">
													<a href="<?php echo esc_url( $plink ); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?php echo esc_attr( murailles_t( 'Voir le bien', false ) ); ?>" aria-label="<?php echo esc_attr( murailles_t( 'Voir le bien', false ) ); ?>"><i class="fa-regular fa-circle-right"></i></a>
												</div>
											</li>
										</ul>
									</div>
								</div>

							</div>
						</div>
						<?php
							endwhile;
							wp_reset_postdata();
						endif;
						?>
					</div>

				</div>
			</section>
			<?php endif; ?>
			<?php endif; ?>
			<!-- ============================ Affaires du Mois End ================================== -->

			<!-- ============================ Biens Start ================================== -->
			<?php if ( murailles_page_section_is_visible( 'biens-en-vedette', $murailles_front_page_id ) ) : ?>
			<section class="pt-0">
				<div class="container">
					
					<div class="row justify-content-center">
						<div class="col-lg-7 col-md-8">
							<div class="sec-heading center">
								<h2><?php echo esc_html( $murailles_front_featured_heading ); ?></h2>
								<p><?php echo esc_html( $murailles_front_featured_subtitle ); ?></p>
							</div>
						</div>
					</div>
					
					<div class="item-slide murailles-featured-slide space" data-murailles-featured-carousel>
						<?php
						$_featured = new WP_Query( array(
							'post_type'      => 'property',
							'posts_per_page' => 9,
							'post_status'    => 'publish',
							'orderby'        => 'modified',
							'order'          => 'DESC',
						) );
						if ( $_featured->have_posts() ) :
							while ( $_featured->have_posts() ) : $_featured->the_post();
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
								$gallery= get_post_meta( $pid, '_property_gallery_ids', true );
								$imgs   = array();
								if ( $gallery ) {
									foreach ( array_slice( array_filter( explode( ',', $gallery ) ), 0, 3 ) as $gid ) {
										$u = wp_get_attachment_image_url( intval( $gid ), 'medium_large' );
										if ( $u ) $imgs[] = $u;
									}
								}
								if ( empty( $imgs ) ) $imgs[] = $thumb;
								
						?>
						<!-- Single Property (dynamic) -->
						<div class="single_items" data-murailles-id="<?php echo esc_attr( $pid ); ?>">
							<div class="property-listing property-2 h-100">

								<div class="listing-img-wrapper">
									<?php if ( $paction ) : ?><div class="_exlio_125"><?php echo esc_html( $paction ); ?></div><?php endif; ?>
									<div class="list-img-slide">
										<div class="click">
											<?php foreach ( $imgs as $img_url ) : ?>
											<div><a href="<?php echo esc_url( $plink ); ?>"><img src="<?php echo esc_url( $img_url ); ?>" class="img-fluid mx-auto" alt="<?php the_title_attribute(); ?>" width="1200" height="800" loading="lazy" decoding="async" /></a></div>
											<?php endforeach; ?>
										</div>
									</div>
								</div>

								<div class="listing-detail-wrapper">
									<div class="listing-short-detail-wrap">
										<div class="_card_list_flex mb-2">
											<div class="_card_flex_01">
												<?php if ( $pbeds ) : ?><span class="_list_blickes _netork"><?php echo esc_html( $pbeds ); ?> <?php murailles_t( 'Ch.' ); ?></span><?php endif; ?>
												<?php if ( $pcat ) : ?><span class="_list_blickes types"><?php echo esc_html( $pcat ); ?></span><?php endif; ?>
											</div>
											<?php if ( $pprice !== '' ) : ?>
											<div class="_card_flex_last">
												<h6 class="listing-card-info-price mb-0"><?php echo esc_html( $pprice ); ?> €<?php if ( $psuffix ) echo ' ' . esc_html( $psuffix ); ?></h6>
											</div>
											<?php endif; ?>
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
										<div class="listing-card-info-icon">
											<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bed.svg' ) ); ?>" width="15" height="15" alt="" loading="lazy" decoding="async" /></div><?php echo esc_html( $pbeds ); ?> <?php murailles_t( 'Ch.' ); ?>
										</div>
										<?php endif; ?>
										<?php if ( $pbaths ) : ?>
										<div class="listing-card-info-icon">
											<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bathtub.svg' ) ); ?>" width="15" height="15" alt="" loading="lazy" decoding="async" /></div><?php echo esc_html( $pbaths ); ?> <?php murailles_t( 'SdB' ); ?>
										</div>
										<?php endif; ?>
										<?php if ( $psize ) : ?>
										<div class="listing-card-info-icon">
											<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'move.svg' ) ); ?>" width="15" alt="" /></div><?php echo esc_html( $psize ); ?> m²
										</div>
										<?php endif; ?>
									</div>
								</div>

								<div class="listing-detail-footer">
									<div class="footer-first">
										<div class="foot-location"><img src="<?php echo esc_url( murailles_img( 'pin.svg' ) ); ?>" width="18" height="18" alt="" loading="lazy" decoding="async" /><?php echo esc_html( $paddr ?: $ploc ); ?></div>
									</div>
									<div class="footer-flex">
										<ul class="selio_style">
											<li>
												<div class="prt_saveed_12lk">
													<label class="toggler toggler-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?php echo esc_attr( murailles_t( 'Enregistrer le bien', false ) ); ?>" aria-label="<?php echo esc_attr( murailles_t( 'Enregistrer le bien', false ) ); ?>"><input type="checkbox"><i class="fa-solid fa-heart"></i></label>
												</div>
											</li>
											<li>
												<div class="prt_saveed_12lk">
													<a href="<?php echo esc_url( home_url( '/compare-property/' ) ); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?php echo esc_attr( murailles_t( 'Comparer le bien', false ) ); ?>" aria-label="<?php echo esc_attr( murailles_t( 'Comparer le bien', false ) ); ?>"><i class="fa-solid fa-share"></i></a>
												</div>
											</li>
											<li>
												<div class="prt_saveed_12lk">
													<a href="<?php echo esc_url( $plink ); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?php echo esc_attr( murailles_t( 'Voir le bien', false ) ); ?>" aria-label="<?php echo esc_attr( murailles_t( 'Voir le bien', false ) ); ?>"><i class="fa-regular fa-circle-right"></i></a>
												</div>
											</li>
										</ul>
									</div>
								</div>

							</div>
						</div>
						<?php
							endwhile;
							wp_reset_postdata();
						else :
						?>
						<div class="col-12 text-center py-5">
							<p class="mb-0"><?php echo esc_html( murailles_current_lang() === 'en' ? 'No properties available at the moment.' : 'Aucun bien disponible actuellement.' ); ?></p>
						</div>
						<?php if ( false ) :
							/* Demo fallback — shown only when no real properties exist yet.
							   Cards link to /bien/ so visitors land on a useful page. */
							$_demo = array(
								array(
									'action' => murailles_t( 'À louer', false ),  'category' => murailles_t( 'Riad', false ),         'price' => '6 700 €/' . murailles_t( 'mois', false ),
									'title'  => '12 Derb El Bahia, Médina, Marrakech 40000',
									'beds'   => '4', 'baths' => '2', 'size' => '820',
								),
								array(
									'action' => murailles_t( 'À vendre', false ), 'category' => murailles_t( 'Appartement', false ),  'price' => '186 900 €',
									'title'  => '85 Bd de la Corniche, Aïn Diab, Casablanca 20180',
									'beds'   => '4', 'baths' => '2', 'size' => '700',
								),
								array(
									'action' => murailles_t( 'À louer', false ),  'category' => murailles_t( 'Villa', false ),        'price' => '8 500 €/' . murailles_t( 'mois', false ),
									'title'  => '47 Avenue Hassan II, Hivernage, Marrakech 40020',
									'beds'   => '3', 'baths' => '2', 'size' => '800',
								),
							);
							$_browse = esc_url( murailles_bien_url() );
							foreach ( $_demo as $d ) :
						?>
						<div class="single_items">
							<div class="property-listing property-2 h-100">
								<div class="listing-img-wrapper">
									<div class="_exlio_125"><?php echo esc_html( $d['action'] ); ?></div>
									<div class="list-img-slide">
										<div class="click">
											<div><a href="<?php echo $_browse; ?>"><img src="<?php echo esc_url( murailles_img( 'p-1.png' ) ); ?>" class="img-fluid mx-auto" alt="" /></a></div>
										</div>
									</div>
								</div>
								<div class="listing-detail-wrapper">
									<div class="listing-short-detail-wrap">
										<div class="_card_list_flex mb-2">
											<div class="_card_flex_01">
												<span class="_list_blickes _netork"><?php echo esc_html( $d['beds'] ); ?> <?php murailles_t( 'Ch.' ); ?></span>
												<span class="_list_blickes types"><?php echo esc_html( $d['category'] ); ?></span>
											</div>
											<div class="_card_flex_last">
												<h6 class="listing-card-info-price mb-0"><?php echo esc_html( $d['price'] ); ?></h6>
											</div>
										</div>
										<div class="_card_list_flex">
											<div class="_card_flex_01">
												<h4 class="listing-name verified"><a href="<?php echo $_browse; ?>" class="prt-link-detail"><?php echo esc_html( $d['title'] ); ?></a></h4>
											</div>
										</div>
									</div>
								</div>
								<div class="price-features-wrapper">
									<div class="list-fx-features">
										<div class="listing-card-info-icon"><div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bed.svg' ) ); ?>" width="15" alt="" /></div><?php echo esc_html( $d['beds'] ); ?> <?php murailles_t( 'Ch.' ); ?></div>
										<div class="listing-card-info-icon"><div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bathtub.svg' ) ); ?>" width="15" alt="" /></div><?php echo esc_html( $d['baths'] ); ?> <?php murailles_t( 'SdB' ); ?></div>
										<div class="listing-card-info-icon"><div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'move.svg' ) ); ?>" width="15" alt="" /></div><?php echo esc_html( $d['size'] ); ?> m²</div>
									</div>
								</div>
								<div class="listing-detail-footer">
									<div class="footer-first">
										<div class="foot-location"><img src="<?php echo esc_url( murailles_img( 'pin.svg' ) ); ?>" width="18" alt="" /><?php murailles_t( 'Marrakech, Maroc' ); ?></div>
									</div>
									<div class="footer-flex">
										<ul class="selio_style">
											<li><div class="prt_saveed_12lk"><label class="toggler toggler-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?php echo esc_attr( murailles_t( 'Enregistrer le bien', false ) ); ?>"><input type="checkbox"><i class="fa-solid fa-heart"></i></label></div></li>
											<li><div class="prt_saveed_12lk"><a href="<?php echo esc_url( home_url( '/compare-property/' ) ); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?php echo esc_attr( murailles_t( 'Comparer le bien', false ) ); ?>"><i class="fa-solid fa-share"></i></a></div></li>
											<li><div class="prt_saveed_12lk"><a href="<?php echo $_browse; ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?php echo esc_attr( murailles_t( 'Voir tous les biens', false ) ); ?>"><i class="fa-regular fa-circle-right"></i></a></div></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<?php endforeach; endif; endif; ?>
					</div>

					<script>
					/* Featured biens carousel — auto-scroll every 5s. The wrapper carries
					   the .item-slide class so custom.js initializes slick on it; we wait
					   for slick to attach then bump autoplaySpeed up from 2500ms to 5000ms. */
					( function () {
						function tuneFeaturedCarousel() {
							if ( typeof jQuery === 'undefined' ) { return; }
							var $car = jQuery( '[data-murailles-featured-carousel]' );
							if ( ! $car.length ) { return; }
							if ( ! $car.hasClass( 'slick-initialized' ) ) {
								setTimeout( tuneFeaturedCarousel, 80 );
								return;
							}
							$car.slick( 'slickSetOption', 'autoplaySpeed', 5000, true );
							$car.slick( 'slickPlay' );
						}
						if ( document.readyState === 'loading' ) {
							document.addEventListener( 'DOMContentLoaded', tuneFeaturedCarousel );
						} else {
							tuneFeaturedCarousel();
						}
					} )();
					</script>

					<div class="row mt-5">
						<div class="col-lg-12 text-center">
							<a href="<?php echo esc_url( murailles_bien_url() ); ?>" class="btn btn-danger px-4">
								<?php echo esc_html( $murailles_front_featured_button ); ?><i class="fa fa-arrow-right ms-2"></i>
							</a>
						</div>
					</div>

				</div>
			</section>
			<?php endif; ?>
			<!-- ============================ Biens End ================================== -->
			
			<!-- ============================ How It Works Start ================================== -->
			<?php if ( murailles_page_section_is_visible( 'comment-ca-marche', $murailles_front_page_id ) ) : ?>
			<section class="gray-simple">
				<div class="container">

					<div class="row justify-content-center">
						<div class="col-lg-7 col-md-8">
							<div class="sec-heading center">
								<h2><?php echo esc_html( $murailles_front_how_heading ); ?></h2>
								<p><?php echo esc_html( $murailles_front_how_subtitle ); ?></p>
							</div>
						</div>
					</div>

					<div class="row justify-content-center g-4">

						<div class="col-lg-4 col-md-4 col-sm-12">
							<div class="wpk_process">
								<div class="wpk_thumb">
									<div class="wpk_thumb_figure">
										<i class="fa-solid fa-list-ul text-danger" style="font-size:48px;"></i>
									</div>
								</div>
								<div class="wpk_caption">
									<h4><?php echo esc_html( $murailles_front_how_step_1_title ); ?></h4>
									<p><?php echo esc_html( $murailles_front_how_step_1_text ); ?></p>
								</div>
							</div>
						</div>

						<div class="col-lg-4 col-md-4 col-sm-12">
							<div class="wpk_process active">
								<div class="wpk_thumb">
									<div class="wpk_thumb_figure">
										<i class="fa-solid fa-magnifying-glass text-danger" style="font-size:48px;"></i>
									</div>
								</div>
								<div class="wpk_caption">
									<h4><?php echo esc_html( $murailles_front_how_step_2_title ); ?></h4>
									<p><?php echo esc_html( $murailles_front_how_step_2_text ); ?></p>
								</div>
							</div>
						</div>

						<div class="col-lg-4 col-md-4 col-sm-12">
							<div class="wpk_process">
								<div class="wpk_thumb">
									<div class="wpk_thumb_figure">
										<i class="fa-solid fa-key text-danger" style="font-size:48px;"></i>
									</div>
								</div>
								<div class="wpk_caption">
									<h4><?php echo esc_html( $murailles_front_how_step_3_title ); ?></h4>
									<p><?php echo esc_html( $murailles_front_how_step_3_text ); ?></p>
								</div>
							</div>
						</div>

					</div>

				</div>
			</section>
			<div class="clearfix"></div>
			<?php endif; ?>
			<!-- ============================ How It Works End ================================== -->

			<!-- ============================ Qui sommes nous Start ================================== -->
			<?php if ( murailles_page_section_is_visible( 'qui-sommes-nous', $murailles_front_page_id ) ) : ?>
			<section>
				<div class="container">

					<div class="row align-items-center">

						<div class="col-lg-6 col-md-12 col-sm-12 mb-4 mb-lg-0">
							<div class="position-relative">
								<img src="<?php echo esc_url( $murailles_front_about_image ); ?>" class="img-fluid rounded" alt="Agence Murailles Immobilier" style="width:100%;border-radius:12px;box-shadow:0 20px 40px rgba(0,0,0,0.08);">
								<div style="position:absolute;bottom:-20px;right:-20px;background:#dc3545;color:#fff;padding:24px 32px;border-radius:12px;box-shadow:0 12px 24px rgba(220,53,69,0.3);">
									<div style="font-size:32px;font-weight:800;line-height:1;"><?php echo esc_html( $murailles_front_about_badge_num ); ?></div>
									<div style="font-size:13px;letter-spacing:0.5px;text-transform:uppercase;"><?php echo esc_html( $murailles_front_about_badge_text ); ?></div>
								</div>
							</div>
						</div>

						<div class="col-lg-6 col-md-12 col-sm-12 ps-lg-5">

							<div class="sec-heading" style="margin-bottom:24px;">
								<span style="display:inline-block;color:#dc3545;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;font-size:13px;margin-bottom:8px;"><?php echo esc_html( $murailles_front_about_eyebrow ); ?></span>
								<h2 style="margin:0;"><?php echo esc_html( $murailles_front_about_heading ); ?></h2>
							</div>

							<p><strong>MURAILLES IMMOBILIER</strong> <?php echo esc_html( $murailles_front_about_text_1 ); ?></p>

							<p><?php echo esc_html( $murailles_front_about_text_2 ); ?></p>

							<p><?php echo esc_html( $murailles_front_about_text_3 ); ?></p>

							<a href="<?php echo esc_url( $murailles_front_about_button_url ); ?>" class="btn btn-outline-danger mt-2" role="button">
								<i class="fa fa-plus-circle me-2"></i><?php echo esc_html( $murailles_front_about_button ); ?>
							</a>

						</div>

					</div>

					<div class="collapse mt-5" id="qui-sommes-nous-details">
						<div class="row g-4">

							<div class="col-lg-12">
								<h3 style="font-size:22px;margin-bottom:24px;color:#1a2332;"><?php murailles_t( "L'Agence Murailles Immobilier vous propose :" ); ?></h3>
							</div>

							<?php if ( false ) : foreach ( $murailles_front_service_cards as $murailles_service_card ) : ?>
								<div class="col-lg-6 col-md-6">
									<div class="d-flex" style="padding:20px;background:#f8f9fa;border-radius:10px;border-left:4px solid #dc3545;height:100%;">
										<div style="flex-shrink:0;width:48px;height:48px;background:#dc3545;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;margin-right:16px;">
											<i class="<?php echo esc_attr( isset( $murailles_service_card['icon_class'] ) ? $murailles_service_card['icon_class'] : 'fa-solid fa-circle' ); ?>"></i>
										</div>
										<div>
											<h5 style="margin:0 0 6px;font-size:16px;color:#1a2332;"><?php echo esc_html( isset( $murailles_service_card['title'] ) ? $murailles_service_card['title'] : '' ); ?></h5>
											<p style="margin:0;font-size:14px;color:#6c757d;"><?php echo esc_html( isset( $murailles_service_card['description'] ) ? $murailles_service_card['description'] : '' ); ?></p>
										</div>
									</div>
								</div>
							<?php endforeach; endif; ?>

							<?php if ( true ) : ?>
							<div class="col-lg-6 col-md-6">
								<div class="d-flex" style="padding:20px;background:#f8f9fa;border-radius:10px;border-left:4px solid #dc3545;height:100%;">
									<div style="flex-shrink:0;width:48px;height:48px;background:#dc3545;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;margin-right:16px;">
										<i class="fa-solid fa-archway"></i>
									</div>
									<div>
										<h5 style="margin:0 0 6px;font-size:16px;color:#1a2332;"><?php murailles_t( "Riads & maisons d'hôtes" ); ?></h5>
										<p style="margin:0;font-size:14px;color:#6c757d;"><?php murailles_t( 'Un large choix dans la médina, la Kasbah ou dans les alentours de Marrakech.' ); ?></p>
									</div>
								</div>
							</div>

							<div class="col-lg-6 col-md-6">
								<div class="d-flex" style="padding:20px;background:#f8f9fa;border-radius:10px;border-left:4px solid #dc3545;height:100%;">
									<div style="flex-shrink:0;width:48px;height:48px;background:#dc3545;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;margin-right:16px;">
										<i class="fa-solid fa-building"></i>
									</div>
									<div>
										<h5 style="margin:0 0 6px;font-size:16px;color:#1a2332;"><?php murailles_t( 'Appartements & villas' ); ?></h5>
										<p style="margin:0;font-size:14px;color:#6c757d;"><?php murailles_t( 'À vendre ou à louer dans les quartiers de Guéliz et Hivernage.' ); ?></p>
									</div>
								</div>
							</div>

							<div class="col-lg-6 col-md-6">
								<div class="d-flex" style="padding:20px;background:#f8f9fa;border-radius:10px;border-left:4px solid #dc3545;height:100%;">
									<div style="flex-shrink:0;width:48px;height:48px;background:#dc3545;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;margin-right:16px;">
										<i class="fa-solid fa-utensils"></i>
									</div>
									<div>
										<h5 style="margin:0 0 6px;font-size:16px;color:#1a2332;"><?php murailles_t( 'Commerces & restaurants' ); ?></h5>
										<p style="margin:0;font-size:14px;color:#6c757d;"><?php murailles_t( 'À vendre ou à louer, courte ou longue durée.' ); ?></p>
									</div>
								</div>
							</div>

							<div class="col-lg-6 col-md-6">
								<div class="d-flex" style="padding:20px;background:#f8f9fa;border-radius:10px;border-left:4px solid #dc3545;height:100%;">
									<div style="flex-shrink:0;width:48px;height:48px;background:#dc3545;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;margin-right:16px;">
										<i class="fa-solid fa-map-location-dot"></i>
									</div>
									<div>
										<h5 style="margin:0 0 6px;font-size:16px;color:#1a2332;"><?php murailles_t( 'Terrains à bâtir' ); ?></h5>
										<p style="margin:0;font-size:14px;color:#6c757d;"><?php murailles_t( "Route de l'Ourika, Amezmiz, Tahennaoute, Sidi Abdellah Ghiat, Fès, Ouarzazate, Bab Atlas, Palmeraie, Amelkis…" ); ?></p>
									</div>
								</div>
							</div>

							<div class="col-lg-6 col-md-6">
								<div class="d-flex" style="padding:20px;background:#f8f9fa;border-radius:10px;border-left:4px solid #dc3545;height:100%;">
									<div style="flex-shrink:0;width:48px;height:48px;background:#dc3545;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;margin-right:16px;">
										<i class="fa-solid fa-chart-line"></i>
									</div>
									<div>
										<h5 style="margin:0 0 6px;font-size:16px;color:#1a2332;"><?php murailles_t( 'Gestion & promotion' ); ?></h5>
										<p style="margin:0;font-size:14px;color:#6c757d;"><?php murailles_t( 'Ne laissez plus vos biens vacants — rentabilisez-les avec notre service de gestion locative.' ); ?></p>
									</div>
								</div>
							</div>

							<div class="col-lg-6 col-md-6">
								<div class="d-flex" style="padding:20px;background:#f8f9fa;border-radius:10px;border-left:4px solid #dc3545;height:100%;">
									<div style="flex-shrink:0;width:48px;height:48px;background:#dc3545;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;margin-right:16px;">
										<i class="fa-solid fa-handshake"></i>
									</div>
									<div>
										<h5 style="margin:0 0 6px;font-size:16px;color:#1a2332;"><?php murailles_t( 'Accompagnement A à Z' ); ?></h5>
										<p style="margin:0;font-size:14px;color:#6c757d;"><?php murailles_t( 'Négociation, ouverture de compte, compromis, crédit, acte de vente, clauses suspensives, bail…' ); ?></p>
									</div>
								</div>
							</div>

							<?php endif; ?>

							<div class="col-lg-12 mt-4">
								<div style="padding:24px 32px;background:#1a2332;color:#fff;border-radius:10px;text-align:center;">
									<p style="margin:0 0 6px;font-size:14px;letter-spacing:1px;text-transform:uppercase;color:#dc3545;font-weight:700;"><?php murailles_t( 'Notre engagement' ); ?></p>
									<p style="margin:0;font-size:18px;font-weight:600;line-height:1.5;"><?php murailles_t( "Une approche globale et sécurisante pour votre projet de vie ou d'investissement." ); ?></p>
								</div>
							</div>

							<div class="col-lg-12">
								<p class="text-muted mt-3" style="font-size:14px;line-height:1.7;">
									<?php murailles_t( "Notre réseau de partenaires sérieux — banques, architectes, notaires, bureaux d'étude, experts-comptables, entrepreneurs et artisans — vous accompagne dans chaque étape. Chaque client est unique avec son projet personnel : nous vous conseillons depuis la recherche du bien jusqu'aux travaux de construction ou de rénovation." ); ?>
								</p>
							</div>

						</div>
					</div>

				</div>
			</section>
			<?php endif; ?>
			<!-- ============================ Qui sommes nous End ================================== -->

			<!-- ============================ Property By Location ================================== -->
			<?php if ( murailles_page_section_is_visible( 'villes-phares', $murailles_front_page_id ) ) : ?>
			<section>
				<div class="container">
				
					<div class="row justify-content-center">
						<div class="col-lg-7 col-md-8">
							<div class="sec-heading center">
								<h2><?php echo esc_html( $murailles_front_cities_heading ); ?></h2>
								<p><?php echo esc_html( $murailles_front_cities_subtitle ); ?></p>
							</div>
						</div>
					</div>
					
					<div class="row justify-content-center g-4">
						<div class="col-lg-4 col-md-4 col-sm-6">
							<a href="<?php echo esc_url( add_query_arg( 'location', 'casablanca', murailles_bien_url() ) ); ?>" class="img-wrap">
									<div class="location_wrap_content visible">
										<div class="location_wrap_content_first">
											<h4><?php murailles_t( 'Casablanca, Maroc' ); ?></h4>
											<span><?php murailles_t( 'Voir les biens' ); ?></span>
										</div>
										<div class="location_btn"><i class="fa fa-arrow-right"></i></div>
									</div>
								<div class="img-wrap-background" style="background-image: url(<?php echo esc_url( murailles_img( 'city-3.png' ) ); ?>);"></div>
							</a>
						</div>

						<div class="col-lg-4 col-md-4 col-sm-6">
							<a href="<?php echo esc_url( add_query_arg( 'location', 'marrakech', murailles_bien_url() ) ); ?>" class="img-wrap">
									<div class="location_wrap_content visible">
										<div class="location_wrap_content_first">
											<h4><?php murailles_t( 'Marrakech, Maroc' ); ?></h4>
											<span><?php murailles_t( 'Voir les biens' ); ?></span>
										</div>
										<div class="location_btn"><i class="fa fa-arrow-right"></i></div>
									</div>
								<div class="img-wrap-background" style="background-image: url(<?php echo esc_url( murailles_img( 'city-7.png' ) ); ?>);"></div>
							</a>
						</div>

						<div class="col-lg-4 col-md-4 col-sm-6">
							<a href="<?php echo esc_url( add_query_arg( 'location', 'rabat', murailles_bien_url() ) ); ?>" class="img-wrap">
									<div class="location_wrap_content visible">
										<div class="location_wrap_content_first">
											<h4><?php murailles_t( 'Rabat, Maroc' ); ?></h4>
											<span><?php murailles_t( 'Voir les biens' ); ?></span>
										</div>
										<div class="location_btn"><i class="fa fa-arrow-right"></i></div>
									</div>
								<div class="img-wrap-background" style="background-image: url(<?php echo esc_url( murailles_img( 'city-3.png' ) ); ?>);"></div>
							</a>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-6">
							<a href="<?php echo esc_url( add_query_arg( 'location', 'tanger', murailles_bien_url() ) ); ?>" class="img-wrap">
									<div class="location_wrap_content visible">
										<div class="location_wrap_content_first">
											<h4><?php murailles_t( 'Tanger, Maroc' ); ?></h4>
											<span><?php murailles_t( 'Voir les biens' ); ?></span>
										</div>
										<div class="location_btn"><i class="fa fa-arrow-right"></i></div>
									</div>
								<div class="img-wrap-background" style="background-image: url(<?php echo esc_url( murailles_img( 'city-4.png' ) ); ?>);"></div>
							</a>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-6">
							<a href="<?php echo esc_url( add_query_arg( 'location', 'fes', murailles_bien_url() ) ); ?>" class="img-wrap">
									<div class="location_wrap_content visible">
										<div class="location_wrap_content_first">
											<h4><?php murailles_t( 'Fès, Maroc' ); ?></h4>
											<span><?php murailles_t( 'Voir les biens' ); ?></span>
										</div>
										<div class="location_btn"><i class="fa fa-arrow-right"></i></div>
									</div>
								<div class="img-wrap-background" style="background-image: url(<?php echo esc_url( murailles_img( 'city-5.png' ) ); ?>);"></div>
							</a>
						</div>
						
					</div>
					
				</div>
			</section>
			<?php endif; ?>
			<!-- ============================ Property By Location End ================================== -->
			
			<!-- ============================ Smart Testimonials ================================== -->
			<?php if ( murailles_page_section_is_visible( 'temoignages', $murailles_front_page_id ) ) : ?>
			<section class="gray-simple">
				<div class="container">
				
					<div class="row justify-content-center">
						<div class="col-lg-7 col-md-8">
							<div class="sec-heading center">
								<h2><?php echo esc_html( $murailles_front_testi_heading ); ?></h2>
								<p><?php echo esc_html( $murailles_front_testi_subtitle ); ?></p>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="item-slide space">
								
								<!-- Single Item -->
								<div class="single_items">
									<div class="_testimonial_wrios">
										<div class="_testimonial_flex">
											<div class="_testimonial_flex_first">
												<div class="_tsl_flex_thumb">
													<img src="https://i.pravatar.cc/96?img=47" class="img-fluid" alt="">
												</div>
												<div class="_tsl_flex_capst">
													<h5>Susan D. Murphy</h5>
													<div class="_ovr_posts"><span><?php murailles_t( 'Propriétaire' ); ?></span></div>
													<div class="_ovr_rates"><span><i class="fa fa-star"></i></span>4.7</div>
												</div>
											</div>
										</div>
										
										<div class="facts-detail">
											<p><?php murailles_t( "L'équipe d'Agence Murailles m'a accompagnée du premier rendez-vous à la signature. Service réactif, conseils avisés et belle sélection de biens à Marrakech." ); ?></p>
										</div>
									</div>
								</div>
								
								<!-- Single Item -->
								<div class="single_items">
									<div class="_testimonial_wrios">
										<div class="_testimonial_flex">
											<div class="_testimonial_flex_first">
												<div class="_tsl_flex_thumb">
													<img src="https://i.pravatar.cc/96?img=32" class="img-fluid" alt="">
												</div>
												<div class="_tsl_flex_capst">
													<h5>Maxine E. Gagliardi</h5>
													<div class="_ovr_posts"><span><?php murailles_t( 'Acheteuse, Marrakech' ); ?></span></div>
													<div class="_ovr_rates"><span><i class="fa fa-star"></i></span>4.5</div>
												</div>
											</div>
										</div>
										
										<div class="facts-detail">
											<p><?php murailles_t( "L'équipe d'Agence Murailles m'a accompagnée du premier rendez-vous à la signature. Service réactif, conseils avisés et belle sélection de biens à Marrakech." ); ?></p>
										</div>
									</div>
								</div>
								
								<!-- Single Item -->
								<div class="single_items">
									<div class="_testimonial_wrios">
										<div class="_testimonial_flex">
											<div class="_testimonial_flex_first">
												<div class="_tsl_flex_thumb">
													<img src="https://i.pravatar.cc/96?img=12" class="img-fluid" alt="">
												</div>
												<div class="_tsl_flex_capst">
													<h5>Roy M. Cardona</h5>
													<div class="_ovr_posts"><span><?php murailles_t( 'Investisseur' ); ?></span></div>
													<div class="_ovr_rates"><span><i class="fa fa-star"></i></span>4.9</div>
												</div>
											</div>
										</div>
										
										<div class="facts-detail">
											<p><?php murailles_t( "L'équipe d'Agence Murailles m'a accompagnée du premier rendez-vous à la signature. Service réactif, conseils avisés et belle sélection de biens à Marrakech." ); ?></p>
										</div>
									</div>
								</div>
								
								<!-- Single Item -->
								<div class="single_items">
									<div class="_testimonial_wrios">
										<div class="_testimonial_flex">
											<div class="_testimonial_flex_first">
												<div class="_tsl_flex_thumb">
													<img src="https://i.pravatar.cc/96?img=45" class="img-fluid" alt="">
												</div>
												<div class="_tsl_flex_capst">
													<h5>Dorothy K. Shipton</h5>
													<div class="_ovr_posts"><span><?php murailles_t( 'Locataire, Casablanca' ); ?></span></div>
													<div class="_ovr_rates"><span><i class="fa fa-star"></i></span>4.7</div>
												</div>
											</div>
										</div>
										
										<div class="facts-detail">
											<p><?php murailles_t( "L'équipe d'Agence Murailles m'a accompagnée du premier rendez-vous à la signature. Service réactif, conseils avisés et belle sélection de biens à Marrakech." ); ?></p>
										</div>
									</div>
								</div>
								
								<!-- Single Item -->
								<div class="single_items">
									<div class="_testimonial_wrios">
										<div class="_testimonial_flex">
											<div class="_testimonial_flex_first">
												<div class="_tsl_flex_thumb">
													<img src="https://i.pravatar.cc/96?img=68" class="img-fluid" alt="">
												</div>
												<div class="_tsl_flex_capst">
													<h5>Robert P. McKissack</h5>
													<div class="_ovr_posts"><span><?php murailles_t( 'Propriétaire' ); ?></span></div>
													<div class="_ovr_rates"><span><i class="fa fa-star"></i></span>4.7</div>
												</div>
											</div>
										</div>
										
										<div class="facts-detail">
											<p><?php murailles_t( "L'équipe d'Agence Murailles m'a accompagnée du premier rendez-vous à la signature. Service réactif, conseils avisés et belle sélection de biens à Marrakech." ); ?></p>
										</div>
									</div>
								</div>
							
							</div>
						</div>
					</div>
					
				</div>
			</section>
			<?php endif; ?>
			<!-- ============================ Smart Testimonials End ================================== -->

			<!-- ============================ Property Tag Start ================================== -->
			<?php if ( murailles_page_section_is_visible( 'banniere-cta', $murailles_front_page_id ) ) : ?>
			<?php /* Cover banner CTA. Background uses `villa-luxe-marrakech-hero.webp`
			         (strong riad image) on the desktop, with a darker overlay
			         (data-overlay="5") so the white card pops and the underlying
			         photo doesn't fight the headline for attention. Card itself
			         gets a soft shadow, larger heading, and a red accent bar
			         on the left to anchor the brand color. */ ?>
			<section class="image-cover murailles-cta-banner" style="background:url(<?php echo esc_url( $murailles_front_cta_bg ); ?>) center/cover no-repeat;">
				<div class="container">
					<div class="row">
						<div class="col-xl-6 col-lg-7 col-md-9 col-sm-12">
							<div class="murailles-cta-banner__card">
								<span class="murailles-cta-banner__eyebrow"><?php echo esc_html( $murailles_front_cta_eyebrow ); ?></span>
								<h2><?php echo esc_html( $murailles_front_cta_title ); ?></h2>
								<p><?php echo esc_html( $murailles_front_cta_text ); ?></p>
								<div class="murailles-cta-banner__actions">
									<a href="<?php echo esc_url( $murailles_front_cta_primary_url ); ?>" class="btn btn-danger px-4"><?php echo esc_html( $murailles_front_cta_primary_label ); ?><i class="fa fa-arrow-right ms-2"></i></a>
									<a href="<?php echo esc_url( $murailles_front_cta_secondary_url ); ?>" class="btn btn-outline-dark px-4"><i class="fa fa-comments me-2"></i><?php echo esc_html( $murailles_front_cta_secondary ); ?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<?php endif; ?>
			<!-- ============================ Property Tag End ================================== -->

			<!-- ============================ article Start ================================== -->
			<?php if ( murailles_page_section_is_visible( 'articles', $murailles_front_page_id ) ) : ?>
			<section>
				<div class="container">
				
					<div class="row justify-content-center">
						<div class="col-lg-7 col-md-8">
							<div class="sec-heading center">
								<h2><?php echo esc_html( $murailles_front_blog_heading ); ?></h2>
								<p><?php echo esc_html( $murailles_front_blog_subtitle ); ?></p>
							</div>
						</div>
					</div>
					
					<div class="row justify-content-center g-4">
					<?php
					/**
					 * Dynamic blog tiles — pulls the 3 most recent published posts.
					 * Each tile links to the post's real permalink. Falls back to a
					 * curated thumbnail when the post has no featured image.
					 */
					$mu_blog_q = new WP_Query( array(
						'post_type'      => 'post',
						'posts_per_page' => 3,
						'post_status'    => 'publish',
					) );
					$mu_blog_fallback = array( 'b-1.jpg', 'b-5.jpg', 'b-6.jpg' );
					$mu_blog_idx = 0;
					$mu_recent_threshold = strtotime( '-21 days' );
					if ( $mu_blog_q->have_posts() ) :
						while ( $mu_blog_q->have_posts() ) : $mu_blog_q->the_post();
							$mu_pid     = get_the_ID();
							$mu_url     = get_permalink( $mu_pid );
							$mu_title   = get_the_title();
							$mu_excerpt = has_excerpt( $mu_pid ) ? get_the_excerpt() : wp_trim_words( wp_strip_all_tags( get_the_content() ), 22, '…' );
							$mu_thumb   = has_post_thumbnail( $mu_pid )
								? get_the_post_thumbnail_url( $mu_pid, 'medium_large' )
								: murailles_img( $mu_blog_fallback[ $mu_blog_idx % count( $mu_blog_fallback ) ] );
							$mu_aid     = (int) get_post_field( 'post_author', $mu_pid );
							$mu_aname   = get_the_author_meta( 'display_name', $mu_aid );
							$mu_aav     = get_avatar_url( $mu_aid, array( 'size' => 80 ) );
							$mu_aurl    = get_author_posts_url( $mu_aid );
							$mu_comm    = (int) get_comments_number( $mu_pid );
							$mu_day_fr  = date_i18n( 'd',   get_post_time( 'U', false, $mu_pid ) );
							$mu_mon_fr  = date_i18n( 'M Y', get_post_time( 'U', false, $mu_pid ) );
							$mu_is_new  = get_post_time( 'U', false, $mu_pid ) >= $mu_recent_threshold;
							$mu_is_hot  = $mu_comm >= 5;
							$mu_blog_idx++;
					?>
						<!-- Single blog Grid -->
						<div class="col-lg-4 col-md-4">
							<div class="grid_blog_box h-100">

								<div class="gtid_blog_thumb">
									<a href="<?php echo esc_url( $mu_url ); ?>"><img src="<?php echo esc_url( $mu_thumb ); ?>" class="img-fluid" alt="<?php echo esc_attr( $mu_title ); ?>" /></a>
									<div class="gtid_blog_info"><span><?php echo esc_html( $mu_day_fr ); ?></span><?php echo esc_html( $mu_mon_fr ); ?></div>
								</div>

								<div class="blog-body">
									<h4 class="bl-title">
										<a href="<?php echo esc_url( $mu_url ); ?>"><?php echo esc_html( $mu_title ); ?></a>
										<?php if ( $mu_is_hot ) : ?>
											<span class="latest_new_post hot"><?php murailles_t( 'Tendance' ); ?></span>
										<?php elseif ( $mu_is_new ) : ?>
											<span class="latest_new_post"><?php murailles_t( 'Nouveau' ); ?></span>
										<?php endif; ?>
									</h4>
									<p><?php echo esc_html( $mu_excerpt ); ?></p>
								</div>

								<div class="modern_property_footer">
									<div class="property-author">
										<div class="path-img"><a href="<?php echo esc_url( $mu_aurl ); ?>" tabindex="-1"><img src="<?php echo esc_url( $mu_aav ); ?>" class="img-fluid" alt=""></a></div>
										<h5><a href="<?php echo esc_url( $mu_aurl ); ?>" tabindex="-1"><?php echo esc_html( $mu_aname ); ?></a></h5>
									</div>
									<span class="article-pulish-date"><i class="ti-comment-alt me-2"></i><?php echo (int) $mu_comm; ?></span>
								</div>

							</div>
						</div>
					<?php
						endwhile;
						wp_reset_postdata();
					endif;
					?>
					</div>
					
				</div>
			</section>
			<div class="clearfix"></div>
			<?php endif; ?>
			<!-- ============================ article End ================================== -->

<?php murailles_render_page_builder_content(); ?>

<?php get_template_part( 'template-parts/call-to-action' ); ?>

<?php get_footer(); ?>
