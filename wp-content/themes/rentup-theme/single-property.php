<?php
/**
 * Single Property Template (CPT: property)
 *
 * Design exact de single-property-1.html avec données dynamiques.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

// All meta
$id       = get_the_ID();
$price    = get_post_meta( $id, '_property_price', true );
$suffix   = get_post_meta( $id, '_property_price_suffix', true );
$action   = get_post_meta( $id, '_property_action', true );
$address  = get_post_meta( $id, '_property_address', true );
$size     = get_post_meta( $id, '_property_size', true );
$land     = get_post_meta( $id, '_property_land_size', true );
$rooms    = get_post_meta( $id, '_property_rooms', true );
$beds     = get_post_meta( $id, '_property_bedrooms', true );
$baths    = get_post_meta( $id, '_property_bathrooms', true );
$garages  = get_post_meta( $id, '_property_garages', true );
$year     = get_post_meta( $id, '_property_year_built', true );
$map      = get_post_meta( $id, '_property_map_embed', true );
$video    = get_post_meta( $id, '_property_video_url', true );
$gallery  = get_post_meta( $id, '_property_gallery_ids', true );
$amenities = (array) json_decode( get_post_meta( $id, '_property_amenities', true ), true );
$agent_id = intval( get_post_meta( $id, '_property_agent_id', true ) );

// Taxonomies
$cats  = wp_get_post_terms( $id, 'property_category', array( 'fields' => 'names' ) );
$locs  = wp_get_post_terms( $id, 'property_location', array( 'fields' => 'names' ) );
$areas = wp_get_post_terms( $id, 'property_area', array( 'fields' => 'names' ) );
$cat_label  = ! empty( $cats ) ? $cats[0] : '';
$loc_label  = ! empty( $locs ) ? implode( ', ', $locs ) : '';
$area_label = ! empty( $areas ) ? $areas[0] : '';

// Gallery images
$img_ids = $gallery ? array_filter( array_map( 'intval', explode( ',', $gallery ) ) ) : array();
$main_img = ! empty( $img_ids[0] ) ? wp_get_attachment_image_url( $img_ids[0], 'large' ) : ( has_post_thumbnail() ? get_the_post_thumbnail_url( $id, 'large' ) : murailles_img( 'banner-home.jpg' ) );

// Amenity labels — each label runs through murailles_t() so Polylang translates them.
$amenity_labels = array(
	'piscine'=>murailles_t( 'Piscine', false ),'climatisation'=>murailles_t( 'Climatisation', false ),'parking'=>murailles_t( 'Parking', false ),'jardin'=>murailles_t( 'Jardin', false ),
	'terrasse'=>murailles_t( 'Terrasse', false ),'wifi'=>murailles_t( 'Wi-Fi', false ),'securite'=>murailles_t( 'Sécurité', false ),'balcon'=>murailles_t( 'Balcon', false ),
	'chauffage'=>murailles_t( 'Chauffage', false ),'meuble'=>murailles_t( 'Meublé', false ),'gardien'=>murailles_t( 'Gardien', false ),'toit_terrasse'=>murailles_t( 'Toit-terrasse', false ),
	'ascenseur'=>murailles_t( 'Ascenseur', false ),'cheminee'=>murailles_t( 'Cheminée', false ),'buanderie'=>murailles_t( 'Buanderie', false ),'conciergerie'=>murailles_t( 'Conciergerie', false ),
	'vue_mer'=>murailles_t( 'Vue sur mer', false ),'vue_lac'=>murailles_t( 'Vue sur lac', false ),'salle_sport'=>murailles_t( 'Salle de sport', false ),
	'grenier'=>murailles_t( 'Grenier', false ),'cave_a_vin'=>murailles_t( 'Cave à vin', false ),'espace_prive'=>murailles_t( 'Espace privé', false ),
	'rangement'=>murailles_t( 'Rangement', false ),'salle_loisirs'=>murailles_t( 'Salle de loisirs', false ),'lave_linge'=>murailles_t( 'Lave-linge', false ),
	'chauffage_gaz'=>murailles_t( 'Chauffage gaz', false ),'terrain_basket'=>murailles_t( 'Terrain de basket', false ),'bassin'=>murailles_t( 'Bassin', false ),
	'jardin_arriere'=>murailles_t( 'Jardin arrière', false ),'jardin_avant'=>murailles_t( 'Jardin avant', false ),'cour_cloturee'=>murailles_t( 'Cour clôturée', false ),
	'arroseurs'=>murailles_t( 'Arroseurs automatiques', false ),
);

// Similar properties
$similar = new WP_Query( array(
	'post_type' => 'property', 'posts_per_page' => 4,
	'post__not_in' => array( $id ), 'post_status' => 'publish',
) );
?>

			<!-- ============================ Hero Banner Start ================================== -->
			<!-- Gallery Part Start -->
			<section class="gallery_parts pt-2 pb-2 d-none d-sm-none d-md-none d-lg-none d-xl-block">
				<div class="container">
					<div class="row align-items-center">
						<div class="col-lg-8 col-md-7 col-sm-12 pr-1">
							<div class="gg_single_part left"><a href="<?php echo esc_url( $main_img ); ?>" class="mfp-gallery rounded"><img src="<?php echo esc_url( $main_img ); ?>" class="img-fluid mx-auto rounded" alt="" /></a></div>
						</div>
						<div class="col-lg-4 col-md-5 col-sm-12 pl-1">
							<?php for ( $i = 1; $i <= 3; $i++ ) :
								$gimg = isset( $img_ids[$i] ) ? wp_get_attachment_image_url( $img_ids[$i], 'medium_large' ) : murailles_img( 'p-' . ( $i + 2 ) . '.png' );
								$mt = $i > 1 ? ' mt-3' : '';
							?>
							<div class="gg_single_part-right min<?php echo $mt; ?>"><a href="<?php echo esc_url( $gimg ); ?>" class="mfp-gallery h-100"><img src="<?php echo esc_url( $gimg ); ?>" class="img-fluid full-width rounded object-fit h-100" alt="" /></a></div>
							<?php endfor; ?>
						</div>
					</div>
				</div>
			</section>

			<div class="featured_slick_gallery gray d-block d-md-block d-lg-block d-xl-none">
				<div class="featured_slick_gallery-slide">
					<div class="featured_slick_padd"><a href="<?php echo esc_url( $main_img ); ?>" class="mfp-gallery"><img src="<?php echo esc_url( $main_img ); ?>" class="img-fluid mx-auto" alt="" /></a></div>
					<?php foreach ( array_slice( $img_ids, 1, 3 ) as $gid ) :
						$gurl = wp_get_attachment_image_url( $gid, 'medium_large' ) ?: murailles_img( 'p-3.png' );
					?>
					<div class="featured_slick_padd"><a href="<?php echo esc_url( $gurl ); ?>" class="mfp-gallery"><img src="<?php echo esc_url( $gurl ); ?>" class="img-fluid mx-auto" alt="" /></a></div>
					<?php endforeach; ?>
				</div>
			</div>
			<!-- ============================ Hero Banner End ================================== -->

			<!-- ============================ Property Detail Start ================================== -->
			<section class="pt-4">
				<div class="container">
					<div class="row">

						<!-- property main detail -->
						<div class="col-lg-8 col-md-12 col-sm-12">

							<div class="property_info_detail_wrap mb-4">
								<div class="property_info_detail_wrap_first">
									<div class="pr-price-into">
										<ul class="prs_lists">
											<?php if ( $beds ) : ?><li><span class="bed fw-medium rounded"><?php echo esc_html( $beds ); ?> <?php murailles_t( 'Ch.' ); ?></span></li><?php endif; ?>
											<?php if ( $baths ) : ?><li><span class="bath fw-medium rounded"><?php echo esc_html( $baths ); ?> <?php murailles_t( 'SdB' ); ?></span></li><?php endif; ?>
											<?php if ( $garages ) : ?><li><span class="gar fw-medium rounded"><?php echo esc_html( $garages ); ?> <?php murailles_t( 'Garage' ); ?></span></li><?php endif; ?>
											<?php if ( $size ) : ?><li><span class="sqft fw-medium rounded"><?php echo esc_html( $size ); ?> m²</span></li><?php endif; ?>
										</ul>
										<h2><?php the_title(); ?></h2>
										<span><i class="lni-map-marker"></i> <?php echo esc_html( $address ); ?><?php if ( $area_label ) echo ', ' . esc_html( $area_label ); ?><?php if ( $loc_label ) echo ' — ' . esc_html( $loc_label ); ?></span>
									</div>
								</div>
								<div class="property_detail_section">
									<div class="prt-sect-pric">
										<ul class="_share_lists">
											<li><a href="#" class="murailles-prop-save" data-murailles-id="<?php echo esc_attr( get_the_ID() ); ?>" title="<?php echo esc_attr( murailles_t( 'Enregistrer dans mes favoris', false ) ); ?>"><i class="fa fa-bookmark"></i></a></li>
											<li><a href="#" class="murailles-prop-share" data-murailles-share-url="<?php echo esc_url( get_permalink() ); ?>" data-murailles-share-title="<?php echo esc_attr( get_the_title() ); ?>" title="<?php echo esc_attr( murailles_t( 'Partager ce bien', false ) ); ?>"><i class="fa fa-share"></i></a></li>
										</ul>
									</div>
								</div>
							</div>

							<!-- About Property -->
							<div class="property_block_wrap">
								<div class="property_block_wrap_header">
									<h4 class="property_block_title"><?php murailles_t( 'Description du bien' ); ?></h4>
								</div>
								<div class="block-body">
									<?php the_content(); ?>
								</div>
							</div>

							<!-- Advance Features -->
							<div class="property_block_wrap">
								<div class="property_block_wrap_header">
									<h4 class="property_block_title"><?php murailles_t( 'Caractéristiques' ); ?></h4>
								</div>
								<div class="block-body">
									<ul class="row p-0 m-0">
										<?php if ( $beds ) : ?><li class="col-lg-4 col-md-6 mb-3 p-0"><i class="fa fa-bed me-1"></i><?php echo esc_html( $beds ); ?> <?php murailles_t( 'Chambres' ); ?></li><?php endif; ?>
										<?php if ( $baths ) : ?><li class="col-lg-4 col-md-6 mb-3 p-0"><i class="fa fa-bath me-1"></i><?php echo esc_html( $baths ); ?> <?php murailles_t( 'Salles de bain' ); ?></li><?php endif; ?>
										<?php if ( $size ) : ?><li class="col-lg-4 col-md-6 mb-3 p-0"><i class="fa fa-expand-arrows-alt me-1"></i><?php echo esc_html( $size ); ?> m²</li><?php endif; ?>
										<?php if ( $rooms ) : ?><li class="col-lg-4 col-md-6 mb-3 p-0"><i class="fa fa-house-damage me-1"></i><?php echo esc_html( $rooms ); ?> <?php murailles_t( 'Pièces' ); ?></li><?php endif; ?>
										<?php if ( $year ) : ?><li class="col-lg-4 col-md-6 mb-3 p-0"><i class="fa fa-building me-1"></i><?php murailles_t( 'Construit' ); ?> <?php echo esc_html( $year ); ?></li><?php endif; ?>
										<?php if ( $garages ) : ?><li class="col-lg-4 col-md-6 mb-3 p-0"><i class="fa fa-car me-1"></i><?php echo esc_html( $garages ); ?> <?php murailles_t( 'Garage(s)' ); ?></li><?php endif; ?>
										<?php if ( $land ) : ?><li class="col-lg-4 col-md-6 mb-3 p-0"><i class="fa fa-layer-group me-1"></i><?php murailles_t( 'Terrain' ); ?> <?php echo esc_html( $land ); ?> m²</li><?php endif; ?>
										<?php if ( $cat_label ) : ?><li class="col-lg-4 col-md-6 mb-3 p-0"><i class="fa fa-tag me-1"></i><?php echo esc_html( $cat_label ); ?></li><?php endif; ?>
										<?php if ( $action ) : ?><li class="col-lg-4 col-md-6 mb-3 p-0"><i class="fa fa-briefcase me-1"></i><?php echo esc_html( $action ); ?></li><?php endif; ?>
									</ul>
								</div>
							</div>

							<!-- Amenities -->
							<?php if ( ! empty( $amenities ) ) : ?>
							<div class="property_block_wrap">
								<div class="property_block_wrap_header">
									<h4 class="property_block_title"><?php murailles_t( 'Équipements' ); ?></h4>
								</div>
								<div class="block-body">
									<ul class="avl-features third">
										<?php foreach ( $amenities as $a ) :
											$label = isset( $amenity_labels[$a] ) ? $amenity_labels[$a] : ucfirst( str_replace( '_', ' ', $a ) );
										?>
										<li class="active"><?php echo esc_html( $label ); ?></li>
										<?php endforeach; ?>
									</ul>
								</div>
							</div>
							<?php endif; ?>

							<!-- Video -->
							<?php if ( $video ) : ?>
							<div class="property_block_wrap">
								<div class="property_block_wrap_header">
									<h4 class="property_block_title"><?php murailles_t( 'Vidéo du bien' ); ?></h4>
								</div>
								<div class="block-body">
									<div class="property_video">
										<div class="thumb">
											<img class="pro_img img-fluid w100" src="<?php echo esc_url( $main_img ); ?>" alt="">
											<div class="overlay_icon">
												<div class="bb-video-box">
													<div class="bb-video-box-inner">
														<div class="bb-video-box-innerup">
															<a href="<?php echo esc_url( $video ); ?>" data-bs-toggle="modal" data-bs-target="#popup-video" class="theme-cl"><i class="ti-control-play"></i></a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php endif; ?>

							<!-- Location Map -->
							<?php if ( $map ) : ?>
							<div class="property_block_wrap">
								<div class="property_block_wrap_header">
									<h4 class="property_block_title"><?php murailles_t( 'Localisation' ); ?></h4>
								</div>
								<div class="block-body">
									<div class="map-container">
										<iframe src="<?php echo esc_url( $map ); ?>" class="full-width" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
									</div>
								</div>
							</div>
							<?php endif; ?>

						</div>

						<!-- Sidebar -->
						<div class="col-lg-4 col-md-12 col-sm-12">
							<div class="property-sidebar">

								<!-- Price Block -->
								<div class="sider_blocks_wrap">
									<div class="side-booking-header">
										<div class="sb-header-left"><h3 class="price"><?php echo esc_html( $price ); ?> MAD<?php if ( $suffix ) : ?><sub>/<?php echo esc_html( $suffix ); ?></sub><?php endif; ?></h3></div>
										<div class="price_offer bg-seegreen"><?php echo esc_html( $action ); ?></div>
									</div>
									<div class="side-booking-body">
										<div class="row">
											<div class="col-lg-12 col-md-12 col-sm-12">
												<h6><?php murailles_t( 'Détails rapides' ); ?></h6>
												<div class="_adv_features">
													<ul>
														<?php if ( $cat_label ) : ?><li><?php murailles_t( 'Type' ); ?><span><?php echo esc_html( $cat_label ); ?></span></li><?php endif; ?>
														<?php if ( $size ) : ?><li><?php murailles_t( 'Superficie' ); ?><span><?php echo esc_html( $size ); ?> m²</span></li><?php endif; ?>
														<?php if ( $land && $land > 0 ) : ?><li><?php murailles_t( 'Terrain' ); ?><span><?php echo esc_html( $land ); ?> m²</span></li><?php endif; ?>
														<?php if ( $beds ) : ?><li><?php murailles_t( 'Chambres' ); ?><span><?php echo esc_html( $beds ); ?></span></li><?php endif; ?>
														<?php if ( $baths ) : ?><li><?php murailles_t( 'Salles de bain' ); ?><span><?php echo esc_html( $baths ); ?></span></li><?php endif; ?>
														<?php if ( $rooms ) : ?><li><?php murailles_t( 'Pièces' ); ?><span><?php echo esc_html( $rooms ); ?></span></li><?php endif; ?>
														<?php if ( $area_label ) : ?><li><?php murailles_t( 'Quartier' ); ?><span><?php echo esc_html( $area_label ); ?></span></li><?php endif; ?>
														<li><?php murailles_t( 'Référence' ); ?><span>#<?php echo $id; ?></span></li>
													</ul>
												</div>
											</div>
											<div class="col-lg-12 col-md-12 col-sm-12">
												<div class="stbooking-footer mt-1">
													<div class="form-group mb-0 pb-0">
														<a href="https://wa.me/?text=<?php echo urlencode( murailles_t( 'Je suis intéressé(e) par :', false ) . ' ' . get_the_title() . ' — ' . get_permalink() ); ?>" target="_blank" class="btn btn-success full-width fw-medium"><i class="fab fa-whatsapp me-2"></i><?php murailles_t( 'Contacter via WhatsApp' ); ?></a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<!-- Agent Detail -->
								<?php if ( $agent_id > 0 ) :
									$ag_name  = get_the_title( $agent_id );
									$ag_pos   = get_post_meta( $agent_id, '_agent_position', true );
									$ag_phone = get_post_meta( $agent_id, '_agent_phone', true );
									$ag_wa    = get_post_meta( $agent_id, '_agent_whatsapp', true );
									$ag_email = get_post_meta( $agent_id, '_agent_email', true );
									$ag_thumb = get_the_post_thumbnail_url( $agent_id, 'thumbnail' ) ?: murailles_img( 'user-5.jpg' );
								?>
								<div class="sider_blocks_wrap">
									<div class="side-booking-body">
										<div class="agent-_blocks_title">
											<div class="agent-_blocks_thumb"><img src="<?php echo esc_url( $ag_thumb ); ?>" alt=""></div>
											<div class="agent-_blocks_caption">
												<h4><a href="#"><?php echo esc_html( $ag_name ); ?></a></h4>
												<?php if ( $ag_pos ) : ?><span class="approved-agent"><i class="ti-check"></i><?php echo esc_html( $ag_pos ); ?></span><?php endif; ?>
											</div>
											<div class="clearfix"></div>
										</div>
										<?php if ( $ag_email ) : ?><a href="mailto:<?php echo esc_attr( $ag_email ); ?>" class="agent-btn-contact"><i class="ti-comment-alt"></i><?php murailles_t( 'Envoyer un message' ); ?></a><?php endif; ?>
										<?php if ( $ag_phone ) : ?>
										<span id="number">
											<span><i class="ti-headphone-alt"></i><a href="tel:<?php echo esc_attr( $ag_phone ); ?>"><?php echo esc_html( $ag_phone ); ?></a></span>
										</span>
										<?php endif; ?>
									</div>
								</div>
								<?php endif; ?>

								<!-- Contact Form -->
								<div class="sider_blocks_wrap">
									<div class="side-booking-header">
										<h4 class="m-0"><?php murailles_t( "Demande d'information" ); ?></h4>
									</div>
									<div class="sider-block-body p-3">
										<div class="form-group">
											<div class="input-with-icon">
												<input type="text" class="form-control light" placeholder="<?php echo esc_attr( murailles_t( 'Votre nom', false ) ); ?>">
												<i class="ti-user"></i>
											</div>
										</div>
										<div class="form-group">
											<div class="input-with-icon">
												<input type="email" class="form-control light" placeholder="<?php echo esc_attr( murailles_t( 'Votre email', false ) ); ?>">
												<i class="ti-email"></i>
											</div>
										</div>
										<div class="form-group">
											<div class="input-with-icon">
												<input type="text" class="form-control light" placeholder="<?php echo esc_attr( murailles_t( 'Votre téléphone', false ) ); ?>">
												<i class="ti-mobile"></i>
											</div>
										</div>
										<div class="form-group">
											<textarea class="form-control light" rows="3" placeholder="<?php echo esc_attr( murailles_t( 'Je suis intéressé(e) par ce bien...', false ) ); ?>"></textarea>
										</div>
										<button class="btn btn-danger full-width fw-medium"><?php murailles_t( 'Envoyer' ); ?></button>
									</div>
								</div>

								<!-- Similar Property -->
								<?php if ( $similar->have_posts() ) : ?>
								<div class="sidebar-widgets">
									<h4><?php murailles_t( 'Biens similaires' ); ?></h4>
									<div class="sidebar_featured_property">
										<?php while ( $similar->have_posts() ) : $similar->the_post();
											$sp_id    = get_the_ID();
											$sp_price = get_post_meta( $sp_id, '_property_price', true );
											$sp_action= get_post_meta( $sp_id, '_property_action', true );
											$sp_locs  = wp_get_post_terms( $sp_id, 'property_location', array( 'fields' => 'names' ) );
											$sp_loc   = ! empty( $sp_locs ) ? $sp_locs[0] : '';
											$sp_thumb = has_post_thumbnail() ? get_the_post_thumbnail_url( $sp_id, 'thumbnail' ) : murailles_img( 'p-' . ( ( $sp_id % 9 ) + 1 ) . '.png' );
											$sp_type  = ( $sp_action === 'A Louer' ) ? '' : 'sale';
										?>
										<div class="sides_list_property">
											<div class="sides_list_property_thumb">
												<img src="<?php echo esc_url( $sp_thumb ); ?>" class="img-fluid" alt="" />
											</div>
											<div class="sides_list_property_detail">
												<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
												<?php if ( $sp_loc ) : ?><span><i class="ti-location-pin"></i><?php echo esc_html( $sp_loc ); ?></span><?php endif; ?>
												<div class="lists_property_price">
													<div class="lists_property_types">
														<div class="property_types_vlix <?php echo $sp_type; ?>"><?php echo esc_html( $sp_action ); ?></div>
													</div>
													<div class="lists_property_price_value">
														<h4><?php echo esc_html( $sp_price ); ?> MAD</h4>
													</div>
												</div>
											</div>
										</div>
										<?php endwhile; wp_reset_postdata(); ?>
									</div>
								</div>
								<?php endif; ?>

							</div>
						</div>

					</div>
				</div>
			</section>
			<!-- ============================ Property Detail End ================================== -->

<?php get_template_part( 'template-parts/call-to-action' ); ?>

<?php get_footer(); ?>
