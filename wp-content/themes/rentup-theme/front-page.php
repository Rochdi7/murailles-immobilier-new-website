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

$murailles_header_style = 'transparent';
get_header();
?>

<!-- ============================ Hero Banner  Start================================== -->
			<div class="image-cover hero_banner" style="background:url(<?php echo esc_url( murailles_img( 'banner-home.jpg' ) ); ?>) no-repeat;" data-overlay="4">
				<div class="container">
					
					<h1 class="big-header-capt mb-0"><?php murailles_t( 'Trouvez votre prochain bien' ); ?></h1>
					<p class="text-center"><?php murailles_t( 'Découvrez les nouveaux biens immobiliers à la une dans votre ville.' ); ?></p>
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
													<select id="location" name="location" class="form-control">
														<option value="">&nbsp;</option>
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
													<select id="ptypes" name="ptype" class="form-control">
														<option value="">&nbsp;</option>
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
													<select id="price" name="price_range" class="form-control" data-murailles-price-range>
														<option value="">&nbsp;</option>
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
													<img src="<?php echo esc_url( murailles_img( 'trust.webp' ) ); ?>" class="img-fluid" width="70" alt="">
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
														<p class="m-0 text-muted">3 612 <?php murailles_t( 'avis au total' ); ?></p>
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
													<img src="<?php echo esc_url( murailles_img( 'cap.webp' ) ); ?>" class="img-fluid" width="70" alt="">
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
														<p class="m-0 text-muted">4 589 <?php murailles_t( 'avis au total' ); ?></p>
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
													<img src="<?php echo esc_url( murailles_img( 'clutch.webp' ) ); ?>" class="img-fluid" width="70" alt="">
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
														<p class="m-0 text-muted">3 625 <?php murailles_t( 'avis au total' ); ?></p>
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
			
			<!-- ============================ Property Category Start ================================== -->
			<section class="min">
				<div class="container">
					
					<div class="row justify-content-center">
						<div class="col-lg-7 col-md-8">
							<div class="sec-heading center">
								<h2><?php murailles_t( 'Choisissez votre catégorie' ); ?></h2>
								<p><?php murailles_t( "Explorez nos biens immobiliers par type : riads d'exception, appartements, villas, terrains et locaux professionnels au cœur du Maroc." ); ?></p>
							</div>
						</div>
					</div>
					
					<div class="row justify-content-center mt-4">
					<?php
					/**
					 * Dynamic property-category tiles.
					 * Pulls real terms from the `property_category` taxonomy, ordered by
					 * descending property count, capped at 8 tiles for the grid. Each tile
					 * links to the actual term archive (/categorie-bien/{slug}/).
					 *
					 * Icon + color mapping is keyed by term slug with a graceful fallback
					 * cycle for unmapped terms.
					 */
					$cat_terms = get_terms( array(
						'taxonomy'   => 'property_category',
						'hide_empty' => false,
						'orderby'    => 'count',
						'order'      => 'DESC',
						'number'     => 8,
					) );

					$icon_map = array(
						'appartement'      => array( 'icon' => 'fa-building',                'color' => 'text-info' ),
						'bureaux'          => array( 'icon' => 'fa-house-laptop',            'color' => 'text-primary' ),
						'commerce'         => array( 'icon' => 'fa-store',                   'color' => 'text-purple' ),
						'ferme'            => array( 'icon' => 'fa-tractor',                 'color' => 'text-success' ),
						'maison-dhote'     => array( 'icon' => 'fa-bed',                     'color' => 'text-warning' ),
						'hotel'            => array( 'icon' => 'fa-hotel',                   'color' => 'text-danger' ),
						'palais'           => array( 'icon' => 'fa-landmark',                'color' => 'text-warning' ),
						'riad-habitation'  => array( 'icon' => 'fa-house-circle-check',      'color' => 'text-warning' ),
						'riad-renove'      => array( 'icon' => 'fa-house-chimney',           'color' => 'text-orange' ),
						'riad-a-renover'   => array( 'icon' => 'fa-house-crack',             'color' => 'text-danger' ),
						'terrain'          => array( 'icon' => 'fa-mountain',                'color' => 'text-seegreen' ),
						'villa'            => array( 'icon' => 'fa-house',                   'color' => 'text-success' ),
					);
					$fallback_styles = array(
						array( 'icon' => 'fa-house',                  'color' => 'text-info' ),
						array( 'icon' => 'fa-house-circle-check',     'color' => 'text-warning' ),
						array( 'icon' => 'fa-building',               'color' => 'text-success' ),
						array( 'icon' => 'fa-house-crack',            'color' => 'text-purple' ),
						array( 'icon' => 'fa-house-fire',             'color' => 'text-seegreen' ),
						array( 'icon' => 'fa-igloo',                  'color' => 'text-danger' ),
						array( 'icon' => 'fa-house-laptop',           'color' => 'text-primary' ),
						array( 'icon' => 'fa-building-circle-check',  'color' => 'text-orange' ),
					);

					if ( ! is_wp_error( $cat_terms ) && ! empty( $cat_terms ) ) :
						$idx = 0;
						foreach ( $cat_terms as $term ) :
							$style = isset( $icon_map[ $term->slug ] )
								? $icon_map[ $term->slug ]
								: $fallback_styles[ $idx % count( $fallback_styles ) ];
							// Route to the property archive's `ptype` filter so the user
							// lands on the polished archive-property.php layout (filters
							// sidebar, sort dropdown, pagination) pre-filtered to this
							// category. Skips needing a taxonomy-property_category.php
							// template just to wrap the archive.
							$term_url = add_query_arg( 'ptype', $term->slug, murailles_bien_url() );
							$cat_name  = ucwords( strtolower( $term->name ) );
							$count_lbl = sprintf(
								murailles_t( $term->count > 1 ? '%s Biens' : '%s Bien', false ),
								number_format_i18n( $term->count )
							);
							$idx++;
					?>
						<!-- Single Category -->
						<div class="col-lg-3 col-md-4 col-sm-6">
							<div class="_category_box">
								<a href="<?php echo esc_url( $term_url ); ?>">
									<div class="_category_elio">
										<div class="_category_thumb">
											<i class="fa-solid <?php echo esc_attr( $style['icon'] ); ?> <?php echo esc_attr( $style['color'] ); ?>"></i>
										</div>
										<div class="_category_caption">
											<h5><?php echo esc_html( $cat_name ); ?></h5>
											<span><?php echo esc_html( $count_lbl ); ?></span>
										</div>
									</div>
								</a>
							</div>
						</div>
					<?php
						endforeach;
					endif;
					?>
					</div>
					
				</div>
			</section>
			<!-- ============================ Property Category End ================================== -->
			
			<!-- ============================ Biens Start ================================== -->
			<section class="pt-0">
				<div class="container">
					
					<div class="row justify-content-center">
						<div class="col-lg-7 col-md-8">
							<div class="sec-heading center">
								<h2><?php murailles_t( 'Biens immobiliers à la une' ); ?></h2>
								<p><?php murailles_t( 'Une sélection exclusive de riads, villas et appartements à Marrakech, Casablanca, Rabat et dans les plus belles villes du Maroc.' ); ?></p>
							</div>
						</div>
					</div>
					
					<div class="row g-4 justify-content-center">
						<?php
						$_featured = new WP_Query( array(
							'post_type'      => 'property',
							'posts_per_page' => 3,
							'post_status'    => 'publish',
							'orderby'        => 'date',
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
						<div class="col-lg-4 col-md-6 col-sm-12" data-murailles-id="<?php echo esc_attr( $pid ); ?>">
							<div class="property-listing property-2 h-100">

								<div class="listing-img-wrapper">
									<?php if ( $paction ) : ?><div class="_exlio_125"><?php echo esc_html( $paction ); ?></div><?php endif; ?>
									<div class="list-img-slide">
										<div class="click">
											<?php foreach ( $imgs as $img_url ) : ?>
											<div><a href="<?php echo esc_url( $plink ); ?>"><img src="<?php echo esc_url( $img_url ); ?>" class="img-fluid mx-auto" alt="<?php the_title_attribute(); ?>" /></a></div>
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
										<div class="listing-card-info-icon">
											<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bed.svg' ) ); ?>" width="15" alt="" /></div><?php echo esc_html( $pbeds ); ?> <?php murailles_t( 'Ch.' ); ?>
										</div>
										<?php endif; ?>
										<?php if ( $pbaths ) : ?>
										<div class="listing-card-info-icon">
											<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bathtub.svg' ) ); ?>" width="15" alt="" /></div><?php echo esc_html( $pbaths ); ?> <?php murailles_t( 'SdB' ); ?>
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
										<div class="foot-location"><img src="<?php echo esc_url( murailles_img( 'pin.svg' ) ); ?>" width="18" alt="" /><?php echo esc_html( $paddr ?: $ploc ); ?></div>
									</div>
									<div class="footer-flex">
										<ul class="selio_style">
											<li>
												<div class="prt_saveed_12lk">
													<label class="toggler toggler-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?php echo esc_attr( murailles_t( 'Enregistrer le bien', false ) ); ?>"><input type="checkbox"><i class="fa-solid fa-heart"></i></label>
												</div>
											</li>
											<li>
												<div class="prt_saveed_12lk">
													<a href="<?php echo esc_url( home_url( '/compare-property/' ) ); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?php echo esc_attr( murailles_t( 'Comparer le bien', false ) ); ?>"><i class="fa-solid fa-share"></i></a>
												</div>
											</li>
											<li>
												<div class="prt_saveed_12lk">
													<a href="<?php echo esc_url( $plink ); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?php echo esc_attr( murailles_t( 'Voir le bien', false ) ); ?>"><i class="fa-regular fa-circle-right"></i></a>
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
						<div class="col-lg-4 col-md-6 col-sm-12">
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
						<?php endforeach; endif; ?>
					</div>	
					
				</div>
			</section>
			<!-- ============================ Biens End ================================== -->
			
			<!-- ============================ How It Works Start ================================== -->
			<section class="gray-simple">
				<div class="container">

					<div class="row justify-content-center">
						<div class="col-lg-7 col-md-8">
							<div class="sec-heading center">
								<h2><?php murailles_t( 'Comment ça marche ?' ); ?></h2>
								<p><?php murailles_t( "Trois étapes simples pour trouver le bien immobilier qui vous correspond avec l'Agence Murailles : créez votre compte, parcourez nos annonces et réservez votre coup de cœur." ); ?></p>
							</div>
						</div>
					</div>

					<div class="row justify-content-center g-4">

						<div class="col-lg-4 col-md-4 col-sm-12">
							<div class="wpk_process">
								<div class="wpk_thumb">
									<div class="wpk_thumb_figure">
										<i class="fa-solid fa-user-plus text-danger" style="font-size:48px;"></i>
									</div>
								</div>
								<div class="wpk_caption">
									<h4><?php murailles_t( 'Créez votre compte' ); ?></h4>
									<p><?php murailles_t( 'Inscrivez-vous gratuitement en quelques clics pour accéder à toutes nos annonces et enregistrer vos favoris.' ); ?></p>
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
									<h4><?php murailles_t( 'Trouvez votre bien' ); ?></h4>
									<p><?php murailles_t( 'Filtrez par ville, type de bien et budget pour découvrir les riads, villas et appartements qui correspondent à vos critères.' ); ?></p>
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
									<h4><?php murailles_t( 'Réservez votre bien' ); ?></h4>
									<p><?php murailles_t( "Contactez notre équipe pour organiser une visite, négocier le prix et finaliser votre acquisition en toute sérénité." ); ?></p>
								</div>
							</div>
						</div>

					</div>

				</div>
			</section>
			<div class="clearfix"></div>
			<!-- ============================ How It Works End ================================== -->

			<!-- ============================ Qui sommes nous Start ================================== -->
			<section>
				<div class="container">

					<div class="row align-items-center">

						<div class="col-lg-6 col-md-12 col-sm-12 mb-4 mb-lg-0">
							<div class="position-relative">
								<img src="<?php echo esc_url( murailles_img( 'banner-home.jpg' ) ); ?>" class="img-fluid rounded" alt="Agence Murailles Immobilier" style="width:100%;border-radius:12px;box-shadow:0 20px 40px rgba(0,0,0,0.08);">
								<div style="position:absolute;bottom:-20px;right:-20px;background:#dc3545;color:#fff;padding:24px 32px;border-radius:12px;box-shadow:0 12px 24px rgba(220,53,69,0.3);">
									<div style="font-size:32px;font-weight:800;line-height:1;">15+</div>
									<div style="font-size:13px;letter-spacing:0.5px;text-transform:uppercase;"><?php murailles_t( "Années d'expérience" ); ?></div>
								</div>
							</div>
						</div>

						<div class="col-lg-6 col-md-12 col-sm-12 ps-lg-5">

							<div class="sec-heading" style="margin-bottom:24px;">
								<span style="display:inline-block;color:#dc3545;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;font-size:13px;margin-bottom:8px;"><?php murailles_t( 'À propos de nous' ); ?></span>
								<h2 style="margin:0;"><?php murailles_t( 'Qui sommes-nous ?' ); ?></h2>
							</div>

							<p><strong>MURAILLES IMMOBILIER</strong> <?php murailles_t( "est sans aucun doute l'agence immobilière la plus investie en termes de suivi et d'accompagnement dans vos projets immobiliers." ); ?></p>

							<p><?php murailles_t( 'Depuis la création de l\'agence, le fondateur' ); ?> <strong>Youssef MOUMEN</strong> <?php murailles_t( "a comme principal objectif de dénicher le produit tant espéré par ses clients. La présence et l'implication de notre équipe dans les différents secteurs de Marrakech garantissent une analyse experte de votre bien à vendre ou de votre acquisition au juste prix." ); ?></p>

							<p><?php murailles_t( "Chaque type de bien et chaque secteur de Marrakech répondent à une logique de marché distincte, c'est l'ensemble de ces savoir-faire que nous mettons à votre disposition." ); ?></p>

							<a href="<?php echo esc_url( home_url( '/nos-services/' ) ); ?>" class="btn btn-outline-danger mt-2" role="button">
								<i class="fa fa-plus-circle me-2"></i><?php murailles_t( 'Découvrir nos services' ); ?>
							</a>

						</div>

					</div>

					<div class="collapse mt-5" id="qui-sommes-nous-details">
						<div class="row g-4">

							<div class="col-lg-12">
								<h3 style="font-size:22px;margin-bottom:24px;color:#1a2332;"><?php murailles_t( "L'Agence Murailles Immobilier vous propose :" ); ?></h3>
							</div>

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
			<!-- ============================ Qui sommes nous End ================================== -->

			<!-- ============================ Property By Location ================================== -->
			<section>
				<div class="container">
				
					<div class="row justify-content-center">
						<div class="col-lg-7 col-md-8">
							<div class="sec-heading center">
								<h2><?php murailles_t( 'Villes phares au Maroc' ); ?></h2>
								<p><?php murailles_t( 'Explorez les biens immobiliers disponibles dans les destinations les plus recherchées du Royaume : Marrakech, Casablanca, Rabat, Tanger et Fès.' ); ?></p>
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
			<!-- ============================ Property By Location End ================================== -->
			
			<!-- ============================ Smart Testimonials ================================== -->
			<section class="gray-simple">
				<div class="container">
				
					<div class="row justify-content-center">
						<div class="col-lg-7 col-md-8">
							<div class="sec-heading center">
								<h2><?php murailles_t( 'Avis de nos clients' ); ?></h2>
								<p><?php murailles_t( 'Découvrez les témoignages de propriétaires et acheteurs qui nous ont fait confiance pour leur projet immobilier au Maroc.' ); ?></p>
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
													<img src="<?php echo esc_url( murailles_img( 'user-1.jpg' ) ); ?>" class="img-fluid" alt="">
												</div>
												<div class="_tsl_flex_capst">
													<h5>Susan D. Murphy</h5>
													<div class="_ovr_posts"><span><?php murailles_t( 'Propriétaire' ); ?></span></div>
													<div class="_ovr_rates"><span><i class="fa fa-star"></i></span>4.7</div>
												</div>
											</div>
											<div class="_testimonial_flex_first_last">
												<div class="_tsl_flex_thumb">
													<img src="<?php echo esc_url( murailles_img( 'c-1.png' ) ); ?>" class="img-fluid" alt="">
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
													<img src="<?php echo esc_url( murailles_img( 'user-2.jpg' ) ); ?>" class="img-fluid" alt="">
												</div>
												<div class="_tsl_flex_capst">
													<h5>Maxine E. Gagliardi</h5>
													<div class="_ovr_posts"><span><?php murailles_t( 'Acheteuse, Marrakech' ); ?></span></div>
													<div class="_ovr_rates"><span><i class="fa fa-star"></i></span>4.5</div>
												</div>
											</div>
											<div class="_testimonial_flex_first_last">
												<div class="_tsl_flex_thumb">
													<img src="<?php echo esc_url( murailles_img( 'c-2.png' ) ); ?>" class="img-fluid" alt="">
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
													<img src="<?php echo esc_url( murailles_img( 'user-3.jpg' ) ); ?>" class="img-fluid" alt="">
												</div>
												<div class="_tsl_flex_capst">
													<h5>Roy M. Cardona</h5>
													<div class="_ovr_posts"><span><?php murailles_t( 'Investisseur' ); ?></span></div>
													<div class="_ovr_rates"><span><i class="fa fa-star"></i></span>4.9</div>
												</div>
											</div>
											<div class="_testimonial_flex_first_last">
												<div class="_tsl_flex_thumb">
													<img src="<?php echo esc_url( murailles_img( 'c-3.png' ) ); ?>" class="img-fluid" alt="">
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
													<img src="<?php echo esc_url( murailles_img( 'user-4.jpg' ) ); ?>" class="img-fluid" alt="">
												</div>
												<div class="_tsl_flex_capst">
													<h5>Dorothy K. Shipton</h5>
													<div class="_ovr_posts"><span><?php murailles_t( 'Locataire, Casablanca' ); ?></span></div>
													<div class="_ovr_rates"><span><i class="fa fa-star"></i></span>4.7</div>
												</div>
											</div>
											<div class="_testimonial_flex_first_last">
												<div class="_tsl_flex_thumb">
													<img src="<?php echo esc_url( murailles_img( 'c-4.png' ) ); ?>" class="img-fluid" alt="">
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
													<img src="<?php echo esc_url( murailles_img( 'user-5.jpg' ) ); ?>" class="img-fluid" alt="">
												</div>
												<div class="_tsl_flex_capst">
													<h5>Robert P. McKissack</h5>
													<div class="_ovr_posts"><span><?php murailles_t( 'Propriétaire' ); ?></span></div>
													<div class="_ovr_rates"><span><i class="fa fa-star"></i></span>4.7</div>
												</div>
											</div>
											<div class="_testimonial_flex_first_last">
												<div class="_tsl_flex_thumb">
													<img src="<?php echo esc_url( murailles_img( 'c-5.png' ) ); ?>" class="img-fluid" alt="">
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
			<!-- ============================ Smart Testimonials End ================================== -->

			<!-- ============================ Property Tag Start ================================== -->
			<section class="image-cover" style="background:#122947 url(<?php echo esc_url( murailles_img( 'banner-home.jpg' ) ); ?>) no-repeat;" data-overlay="4">
				<div class="container">
					<div class="row">
						<div class="col-xl-6 col-lg-6 col-md-8 col-sm-12">

							<div class="tab_exclusive position-relative z-1">
								<h2><?php murailles_t( 'Vous cherchez le lieu idéal pour réaliser votre rêve ?' ); ?></h2>
								<p><?php murailles_t( "Riads d'exception dans la médina, villas avec piscine à la Palmeraie, appartements modernes à Casablanca ou Rabat — l'Agence Murailles vous accompagne pour trouver le bien qui correspond à votre projet de vie au Maroc." ); ?></p>
								<a href="<?php echo esc_url( murailles_bien_url() ); ?>" class="btn exliou btn-seegreen mt-2"><?php murailles_t( 'Voir les biens' ); ?></a>
							</div>

						</div>
					</div>
				</div>
			</section>
			<!-- ============================ Property Tag End ================================== -->

			<!-- ============================ article Start ================================== -->
			<section>
				<div class="container">
				
					<div class="row justify-content-center">
						<div class="col-lg-7 col-md-8">
							<div class="sec-heading center">
								<h2><?php murailles_t( 'Actualités & Articles' ); ?></h2>
								<p><?php murailles_t( 'Conseils, tendances du marché et guides pour acheter, vendre ou louer votre bien immobilier au Maroc.' ); ?></p>
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
			<!-- ============================ article End ================================== -->

<?php get_template_part( 'template-parts/call-to-action' ); ?>

<?php get_footer(); ?>
