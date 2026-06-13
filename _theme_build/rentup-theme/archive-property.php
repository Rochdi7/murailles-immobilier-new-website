<?php
/**
 * Archive Property Template
 *
 * Liste dynamique des biens avec le design exact
 * de grid-layout-with-sidebar.html.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

$all_cats  = get_terms( array( 'taxonomy' => 'property_category', 'hide_empty' => false ) );
/* Only show child (city-level) terms in the Ville filter — skip country parents
   so users don't see "Maroc" alongside Marrakech/Casablanca. */
$all_locs  = get_terms( array(
	'taxonomy'   => 'property_location',
	'hide_empty' => false,
	'orderby'    => 'name',
	'exclude'    => wp_list_pluck( get_terms( array(
		'taxonomy'   => 'property_location',
		'hide_empty' => false,
		'parent'     => 0,
	) ), 'term_id' ),
) );
$all_areas = get_terms( array( 'taxonomy' => 'property_area',     'hide_empty' => false ) );
$paged     = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
$per_page  = 6;

/* ─── Read GET filters ────────────────────────────────────────────────── */
$f = array(
	'q'         => isset( $_GET['q'] )         ? sanitize_text_field( wp_unslash( $_GET['q'] ) )      : '',
	'ptype'     => isset( $_GET['ptype'] )     ? sanitize_text_field( wp_unslash( $_GET['ptype'] ) )  : '',
	'action'    => isset( $_GET['action_t'] )  ? sanitize_text_field( wp_unslash( $_GET['action_t'] ) ): '',
	'location'  => isset( $_GET['location'] )  ? sanitize_text_field( wp_unslash( $_GET['location'] ) ): '',
	'area'      => isset( $_GET['area'] )      ? sanitize_text_field( wp_unslash( $_GET['area'] ) )   : '',
	'beds'      => isset( $_GET['beds'] )      ? intval( $_GET['beds'] )                              : 0,
	'baths'     => isset( $_GET['baths'] )     ? intval( $_GET['baths'] )                             : 0,
	'price_max' => isset( $_GET['price_max'] ) ? intval( $_GET['price_max'] )                         : 0,
	'price_min' => isset( $_GET['price_min'] ) ? intval( $_GET['price_min'] )                         : 0,
	'size_min'  => isset( $_GET['size_min'] )  ? intval( $_GET['size_min'] )                          : 0,
	'size_max'  => isset( $_GET['size_max'] )  ? intval( $_GET['size_max'] )                          : 0,
	'year'      => isset( $_GET['built_year'] ) ? intval( $_GET['built_year'] )                        : 0,
	'orderby'   => isset( $_GET['orderby'] )   ? sanitize_text_field( wp_unslash( $_GET['orderby'] ) ): 'recent',
);

/* ─── Build WP_Query args ─────────────────────────────────────────────── */
$args = array(
	'post_type'      => 'property',
	'posts_per_page' => $per_page,
	'paged'          => $paged,
	'post_status'    => 'publish',
);

if ( $f['q'] !== '' ) {
	$args['s'] = $f['q'];
}

$tax_query = array();
if ( $f['ptype'] !== '' ) {
	$tax_query[] = array( 'taxonomy' => 'property_category', 'field' => 'slug', 'terms' => $f['ptype'] );
}
if ( $f['location'] !== '' ) {
	$tax_query[] = array( 'taxonomy' => 'property_location', 'field' => 'slug', 'terms' => $f['location'] );
}
if ( $f['area'] !== '' ) {
	$tax_query[] = array( 'taxonomy' => 'property_area', 'field' => 'slug', 'terms' => $f['area'] );
}
if ( count( $tax_query ) > 1 ) {
	$tax_query['relation'] = 'AND';
}
if ( $tax_query ) {
	$args['tax_query'] = $tax_query;
}

$meta_query = array();
if ( $f['action'] !== '' ) {
	$meta_query[] = array( 'key' => '_property_action', 'value' => $f['action'], 'compare' => '=' );
}
if ( $f['beds'] > 0 ) {
	$meta_query[] = array( 'key' => '_property_bedrooms', 'value' => $f['beds'], 'type' => 'NUMERIC', 'compare' => '>=' );
}
if ( $f['baths'] > 0 ) {
	$meta_query[] = array( 'key' => '_property_bathrooms', 'value' => $f['baths'], 'type' => 'NUMERIC', 'compare' => '>=' );
}
if ( $f['price_min'] > 0 ) {
	$meta_query[] = array( 'key' => '_property_price', 'value' => $f['price_min'], 'type' => 'NUMERIC', 'compare' => '>=' );
}
if ( $f['price_max'] > 0 ) {
	$meta_query[] = array( 'key' => '_property_price', 'value' => $f['price_max'], 'type' => 'NUMERIC', 'compare' => '<=' );
}
if ( $f['size_min'] > 0 ) {
	$meta_query[] = array( 'key' => '_property_size', 'value' => $f['size_min'], 'type' => 'NUMERIC', 'compare' => '>=' );
}
if ( $f['size_max'] > 0 ) {
	$meta_query[] = array( 'key' => '_property_size', 'value' => $f['size_max'], 'type' => 'NUMERIC', 'compare' => '<=' );
}
if ( $f['year'] > 0 ) {
	$meta_query[] = array( 'key' => '_property_year_built', 'value' => $f['year'], 'type' => 'NUMERIC', 'compare' => '=' );
}
if ( count( $meta_query ) > 1 ) {
	$meta_query['relation'] = 'AND';
}
if ( $meta_query ) {
	$args['meta_query'] = $meta_query;
}

switch ( $f['orderby'] ) {
	case 'price_asc':
		$args['meta_key'] = '_property_price';
		$args['orderby']  = 'meta_value_num';
		$args['order']    = 'ASC';
		break;
	case 'price_desc':
		$args['meta_key'] = '_property_price';
		$args['orderby']  = 'meta_value_num';
		$args['order']    = 'DESC';
		break;
	default:
		$args['orderby'] = 'date';
		$args['order']   = 'DESC';
}

$props = new WP_Query( $args );

$total = $props->found_posts;
$start = $total ? ( ( $paged - 1 ) * $per_page ) + 1 : 0;
$end   = min( $paged * $per_page, $total );
$pages = $props->max_num_pages;

/* Count active filters for badge */
$active_count = 0;
foreach ( array( 'q','ptype','action','location','area','beds','baths','price_min','price_max','size_min','size_max','year' ) as $k ) {
	if ( ! empty( $f[ $k ] ) ) $active_count++;
}
?>

			<!-- ============================ All Property ================================== -->
			<section class="gray pt-4">

				<div class="container">

					<div class="row m-0">
						<div class="short_wraping">
							<div class="row align-items-center">

								<div class="col-lg-3 col-md-6 col-sm-12 col-sm-6">
									<ul class="shorting_grid">
										<li class="list-inline-item"><a href="<?php echo esc_url( murailles_bien_url() ); ?>" class="active"><span class="ti-layout-grid2"></span><?php murailles_t( 'Grille' ); ?></a></li>
									</ul>
								</div>

								<div class="col-lg-6 col-md-12 col-sm-12 order-lg-2 order-md-3 elco_bor col-sm-12">
									<div class="shorting_pagination">
										<div class="shorting_pagination_laft">
											<h5><?php murailles_t( 'Affichage' ); ?> <?php echo $start; ?>-<?php echo $end; ?> <?php murailles_t( 'sur' ); ?> <?php echo $total; ?> <?php murailles_t( 'résultats' ); ?></h5>
										</div>
										<div class="shorting_pagination_right">
											<ul>
												<?php
												$keep_q = array_filter( $f, function ( $v ) { return $v !== '' && $v !== 0; } );
												for ( $i = 1; $i <= min( $pages, 6 ); $i++ ) :
													$url = add_query_arg( $keep_q, get_pagenum_link( $i ) );
												?>
												<li><a href="<?php echo esc_url( $url ); ?>"<?php echo $i === $paged ? ' class="active"' : ''; ?>><?php echo $i; ?></a></li>
												<?php endfor; ?>
											</ul>
										</div>
									</div>
								</div>

								<div class="col-lg-3 col-md-6 col-sm-12 order-lg-3 order-md-2 col-sm-6">
									<div class="shorting-right">
										<label><?php murailles_t( 'Trier par :' ); ?></label>
										<?php
										$current_label = murailles_t( 'Plus récents', false );
										if ( $f['orderby'] === 'price_asc' )  $current_label = murailles_t( 'Prix croissant', false );
										if ( $f['orderby'] === 'price_desc' ) $current_label = murailles_t( 'Prix décroissant', false );
										$keep = array_filter( $f, function ( $v ) { return $v !== '' && $v !== 0; } );
										unset( $keep['orderby'] );
										$sort_url = function ( $key ) use ( $keep ) {
											return esc_url( add_query_arg( array_merge( $keep, array( 'orderby' => $key ) ), murailles_bien_url() ) );
										};
										?>
										<div class="dropdown show">
											<a class="btn btn-filter dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<span class="selection"><?php echo esc_html( $current_label ); ?></span>
											</a>
											<div class="drp-select dropdown-menu">
												<a class="dropdown-item" href="<?php echo $sort_url( 'recent' ); ?>"><?php murailles_t( 'Plus récents' ); ?></a>
												<a class="dropdown-item" href="<?php echo $sort_url( 'price_asc' ); ?>"><?php murailles_t( 'Prix croissant' ); ?></a>
												<a class="dropdown-item" href="<?php echo $sort_url( 'price_desc' ); ?>"><?php murailles_t( 'Prix décroissant' ); ?></a>
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>

					<div class="row">

						<!-- property Sidebar -->
						<div class="col-lg-4 col-md-12 col-sm-12">
							<form method="get" action="<?php echo esc_url( murailles_bien_url() ); ?>" class="page-sidebar p-0">

								<a class="filter_links" data-bs-toggle="collapse" href="#fltbox" role="button" aria-expanded="true" aria-controls="fltbox">
									<?php murailles_t( 'Filtre avancé' ); ?><i class="fa fa-sliders-h ms-2"></i>
									<?php if ( $active_count ) : ?>
										<span class="badge bg-danger ms-2"><?php echo (int) $active_count; ?> <?php murailles_t( $active_count > 1 ? 'actifs' : 'actif' ); ?></span>
									<?php endif; ?>
								</a>

								<div class="collapse show" id="fltbox">
									<div class="sidebar-widgets p-4">

										<div class="form-group">
											<div class="input-with-icon">
												<input type="text" name="q" value="<?php echo esc_attr( $f['q'] ); ?>" class="form-control" placeholder="<?php echo esc_attr( murailles_t( 'Mot-clé, référence...', false ) ); ?>">
												<i class="ti-search"></i>
											</div>
										</div>

										<div class="form-group">
											<div class="simple-input">
												<select name="ptype" class="form-control">
													<option value=""><?php murailles_t( 'Type de bien' ); ?></option>
													<?php foreach ( $all_cats as $cat ) : ?>
													<option value="<?php echo esc_attr( $cat->slug ); ?>" <?php selected( $f['ptype'], $cat->slug ); ?>><?php echo esc_html( $cat->name ); ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>

										<?php
										// _property_action is stored in the language of the post (FR posts hold
										// "A Vendre" / "A Louer", EN posts hold "For Sale" / "For Rent").
										$mu_lang   = function_exists( 'pll_current_language' ) ? pll_current_language( 'slug' ) : 'fr';
										$mu_sale   = ( $mu_lang === 'en' ) ? 'For Sale' : 'A Vendre';
										$mu_rent   = ( $mu_lang === 'en' ) ? 'For Rent' : 'A Louer';
										?>
										<div class="form-group">
											<div class="simple-input">
												<select name="action_t" class="form-control">
													<option value=""><?php murailles_t( 'Action' ); ?></option>
													<option value="<?php echo esc_attr( $mu_sale ); ?>" <?php selected( $f['action'], $mu_sale ); ?>><?php murailles_t( 'À vendre' ); ?></option>
													<option value="<?php echo esc_attr( $mu_rent ); ?>" <?php selected( $f['action'], $mu_rent ); ?>><?php murailles_t( 'À louer' ); ?></option>
												</select>
											</div>
										</div>

										<?php if ( ! empty( $all_locs ) ) : ?>
										<div class="form-group">
											<div class="simple-input">
												<select name="location" class="form-control">
													<option value=""><?php murailles_t( 'Ville' ); ?></option>
													<?php foreach ( $all_locs as $loc ) : ?>
													<option value="<?php echo esc_attr( $loc->slug ); ?>" <?php selected( $f['location'], $loc->slug ); ?>><?php echo esc_html( $loc->name ); ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
										<?php endif; ?>

										<?php if ( ! empty( $all_areas ) ) : ?>
										<div class="form-group">
											<div class="simple-input">
												<select name="area" class="form-control">
													<option value=""><?php murailles_t( 'Quartier' ); ?></option>
													<?php foreach ( $all_areas as $area ) : ?>
													<option value="<?php echo esc_attr( $area->slug ); ?>" <?php selected( $f['area'], $area->slug ); ?>><?php echo esc_html( $area->name ); ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>
										<?php endif; ?>

										<div class="form-group">
											<div class="simple-input">
												<select name="beds" class="form-control">
													<option value="0"><?php murailles_t( 'Chambres (min.)' ); ?></option>
													<?php for ( $b = 1; $b <= 6; $b++ ) : ?>
													<option value="<?php echo $b; ?>" <?php selected( $f['beds'], $b ); ?>><?php echo $b; ?>+</option>
													<?php endfor; ?>
												</select>
											</div>
										</div>

										<div class="form-group">
											<div class="simple-input">
												<select name="baths" class="form-control">
													<option value="0"><?php murailles_t( 'Salles de bain (min.)' ); ?></option>
													<?php for ( $b = 1; $b <= 5; $b++ ) : ?>
													<option value="<?php echo $b; ?>" <?php selected( $f['baths'], $b ); ?>><?php echo $b; ?>+</option>
													<?php endfor; ?>
												</select>
											</div>
										</div>

										<div class="row">
											<div class="col-6">
												<div class="form-group">
													<input type="number" name="price_min" value="<?php echo $f['price_min'] ? esc_attr( $f['price_min'] ) : ''; ?>" class="form-control" placeholder="<?php echo esc_attr( murailles_t( 'Prix min. (€)', false ) ); ?>">
												</div>
											</div>
											<div class="col-6">
												<div class="form-group">
													<input type="number" name="price_max" value="<?php echo $f['price_max'] ? esc_attr( $f['price_max'] ) : ''; ?>" class="form-control" placeholder="<?php echo esc_attr( murailles_t( 'Prix max. (€)', false ) ); ?>">
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-6">
												<div class="form-group">
													<input type="number" name="size_min" value="<?php echo $f['size_min'] ? esc_attr( $f['size_min'] ) : ''; ?>" class="form-control" placeholder="<?php echo esc_attr( murailles_t( 'Surface min. (m²)', false ) ); ?>">
												</div>
											</div>
											<div class="col-6">
												<div class="form-group">
													<input type="number" name="size_max" value="<?php echo $f['size_max'] ? esc_attr( $f['size_max'] ) : ''; ?>" class="form-control" placeholder="<?php echo esc_attr( murailles_t( 'Surface max. (m²)', false ) ); ?>">
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="simple-input">
												<select name="built_year" class="form-control">
													<option value="0"><?php murailles_t( 'Année de construction' ); ?></option>
													<?php for ( $y = (int) date('Y'); $y >= 1990; $y-- ) : ?>
													<option value="<?php echo $y; ?>" <?php selected( $f['year'], $y ); ?>><?php echo $y; ?></option>
													<?php endfor; ?>
												</select>
											</div>
										</div>

										<?php if ( $f['orderby'] ) : ?>
											<input type="hidden" name="orderby" value="<?php echo esc_attr( $f['orderby'] ); ?>">
										<?php endif; ?>

										<div class="d-grid gap-2 mt-3">
											<button type="submit" class="btn btn-danger">
												<i class="fa fa-search me-1"></i> <?php murailles_t( 'Rechercher' ); ?>
											</button>
											<a href="<?php echo esc_url( murailles_bien_url() ); ?>" class="btn btn-outline-secondary btn-sm">
												<i class="fa fa-rotate-left me-1"></i> <?php murailles_t( 'Réinitialiser' ); ?>
											</a>
										</div>

									</div>
								</div>
							</form>
						</div>
						<!-- Sidebar End -->

						<!-- Property Grid -->
						<div class="col-lg-8 col-md-12 col-sm-12">
							<div class="row justify-content-start g-4">

								<?php if ( $props->have_posts() ) : ?>
									<?php while ( $props->have_posts() ) : $props->the_post();
										$pid     = get_the_ID();
										$pprice  = get_post_meta( $pid, '_property_price', true );
										$psuffix = get_post_meta( $pid, '_property_price_suffix', true );
										$paction = get_post_meta( $pid, '_property_action', true );
										$paddr   = get_post_meta( $pid, '_property_address', true );
										$psize   = get_post_meta( $pid, '_property_size', true );
										$pbeds   = get_post_meta( $pid, '_property_bedrooms', true );
										$pbaths  = get_post_meta( $pid, '_property_bathrooms', true );
										$pcats   = wp_get_post_terms( $pid, 'property_category', array( 'fields' => 'names' ) );
										$pareas  = wp_get_post_terms( $pid, 'property_area', array( 'fields' => 'names' ) );
										$plocs   = wp_get_post_terms( $pid, 'property_location', array( 'fields' => 'names' ) );
										$pcat    = ! empty( $pcats ) ? $pcats[0] : '';
										$ploc    = ! empty( $plocs ) ? $plocs[0] : '';
										$parea   = ! empty( $pareas ) ? $pareas[0] : '';
										$link    = get_permalink();
										$thumb   = has_post_thumbnail() ? get_the_post_thumbnail_url( $pid, 'medium_large' ) : murailles_img( 'p-' . ( ( $pid % 9 ) + 1 ) . '.png' );
										$gallery = get_post_meta( $pid, '_property_gallery_ids', true );
										$imgs    = array();
										if ( $gallery ) {
											foreach ( array_slice( array_filter( explode( ',', $gallery ) ), 0, 3 ) as $gid ) {
												$url = wp_get_attachment_image_url( intval( $gid ), 'medium_large' );
												if ( $url ) $imgs[] = $url;
											}
										}
										if ( empty( $imgs ) ) {
											$imgs[] = $thumb;
										}
										
									?>
								<!-- Single Property -->
								<div class="col-lg-6 col-md-6 col-sm-12" data-murailles-id="<?php echo esc_attr( $pid ); ?>">
									<div class="property-listing property-2">

										<div class="listing-img-wrapper">
											<div class="_exlio_125"><?php echo esc_html( $paction ?: $mu_sale ); ?></div>
											<div class="list-img-slide">
												<div class="click">
													<?php foreach ( $imgs as $img_url ) : ?>
													<div><a href="<?php echo esc_url( $link ); ?>"><img src="<?php echo esc_url( $img_url ); ?>" class="img-fluid mx-auto" alt="<?php the_title_attribute(); ?>" width="1200" height="800" loading="lazy" decoding="async" /></a></div>
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
														<h6 class="listing-card-info-price text-seegreen mb-0"><?php echo esc_html( $pprice ); ?> €</h6>
														<?php if ( $psuffix ) : ?><small><?php echo esc_html( $psuffix ); ?></small><?php endif; ?>
													</div>
													<?php endif; ?>
												</div>
												<div class="_card_list_flex">
													<div class="_card_flex_01">
														<h4 class="listing-name verified"><a href="<?php echo esc_url( $link ); ?>" class="prt-link-detail"><?php the_title(); ?></a></h4>
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
												<div class="foot-location"><img src="<?php echo esc_url( murailles_img( 'pin.svg' ) ); ?>" width="18" alt="" /><?php echo esc_html( $parea ? $parea . ', ' : '' ); ?><?php echo esc_html( $ploc ); ?></div>
											</div>
											<div class="footer-flex">
												<ul class="selio_style">
													<li>
														<div class="prt_saveed_12lk">
															<label class="toggler toggler-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?php echo esc_attr( murailles_t( 'Sauvegarder', false ) ); ?>" aria-label="<?php echo esc_attr( murailles_t( 'Sauvegarder', false ) ); ?>"><input type="checkbox"><i class="fa-solid fa-heart"></i></label>
														</div>
													</li>
													<li>
														<div class="prt_saveed_12lk">
															<a href="<?php echo esc_url( home_url( '/compare-property/' ) ); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?php echo esc_attr( murailles_t( 'Comparer', false ) ); ?>" aria-label="<?php echo esc_attr( murailles_t( 'Comparer', false ) ); ?>"><i class="fa-solid fa-share"></i></a>
														</div>
													</li>
													<li>
														<div class="prt_saveed_12lk">
															<a href="<?php echo esc_url( $link ); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="<?php echo esc_attr( murailles_t( 'Voir le bien', false ) ); ?>" aria-label="<?php echo esc_attr( murailles_t( 'Voir le bien', false ) ); ?>"><i class="fa-regular fa-circle-right"></i></a>
														</div>
													</li>
												</ul>
											</div>
										</div>

									</div>
								</div>
								<!-- End Single Property -->
									<?php endwhile; ?>
								<?php else : ?>
								<div class="col-lg-12 text-center py-5">
									<h4><?php murailles_t( 'Aucun bien trouvé' ); ?></h4>
									<p><?php murailles_t( 'Revenez bientôt, de nouveaux biens sont ajoutés régulièrement.' ); ?></p>
								</div>
								<?php endif; ?>

							</div>
						</div>
						<?php wp_reset_postdata(); ?>

					</div>
				</div>
			</section>
			<!-- ============================ All Property End ================================== -->

<?php get_template_part( 'template-parts/call-to-action' ); ?>

<?php get_footer(); ?>
