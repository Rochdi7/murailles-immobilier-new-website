<?php
/**
 * Shared property taxonomy archive renderer.
 *
 * Drives ALL property taxonomy archives (Ville / Quartier / Type) with one
 * consistent design: full hero banner + advanced filter sidebar + equal-height
 * property cards. Each taxonomy-*.php wrapper just calls:
 *
 *     get_template_part( 'template-parts/property-taxonomy' );
 *
 * The queried term is read from get_queried_object(), so the markup adapts to
 * whichever taxonomy the visitor landed on. The current taxonomy is excluded
 * from the sidebar filters (you don't filter by Quartier on a Quartier page).
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$term = get_queried_object();
if ( ! is_a( $term, 'WP_Term' ) ) {
	return;
}

$current_tax = $term->taxonomy; // property_location | property_area | property_category
$term_name   = $term->name;
$term_desc   = $term->description;
$term_link   = get_term_link( $term );

/* Per-taxonomy labels for hero copy + eyebrow. */
$mu_lang = function_exists( 'pll_current_language' ) ? pll_current_language( 'slug' ) : 'fr';
switch ( $current_tax ) {
	case 'property_area':
		$hero_eyebrow = murailles_t( 'Annonces par quartier', false );
		/* translators: %s: neighbourhood name */
		$hero_title   = sprintf( murailles_t( 'Biens dans le quartier %s', false ), $term_name );
		break;
	case 'property_category':
		$hero_eyebrow = murailles_t( 'Annonces par type de bien', false );
		/* translators: %s: property type */
		$hero_title   = sprintf( murailles_t( 'Biens de type %s', false ), $term_name );
		break;
	case 'property_location':
	default:
		$hero_eyebrow = murailles_t( 'Annonces immobilières', false );
		/* translators: %s: city name */
		$hero_title   = sprintf( murailles_t( 'Biens à %s', false ), $term_name );
		break;
}

/* Hero background — term meta image if set, else the shared inner-page slider. */
$hero_bg = get_term_meta( $term->term_id, '_location_hero_image', true );
if ( ! $hero_bg ) {
	$hero_bg = murailles_img( 'slider-3.jpg' );
}

/* ── Filters (GET params) ──────────────────────────────────────────────── */
$all_cats  = get_terms( array( 'taxonomy' => 'property_category', 'hide_empty' => false ) );
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
$all_areas = get_terms( array( 'taxonomy' => 'property_area', 'hide_empty' => false ) );

$f = array(
	'q'         => isset( $_GET['q'] )          ? sanitize_text_field( wp_unslash( $_GET['q'] ) )       : '',
	'ptype'     => isset( $_GET['ptype'] )      ? sanitize_text_field( wp_unslash( $_GET['ptype'] ) )   : '',
	'action'    => isset( $_GET['action_t'] )   ? sanitize_text_field( wp_unslash( $_GET['action_t'] ) ): '',
	'location'  => isset( $_GET['location'] )   ? sanitize_text_field( wp_unslash( $_GET['location'] ) ): '',
	'area'      => isset( $_GET['area'] )       ? sanitize_text_field( wp_unslash( $_GET['area'] ) )    : '',
	'beds'      => isset( $_GET['beds'] )       ? intval( $_GET['beds'] )                               : 0,
	'baths'     => isset( $_GET['baths'] )      ? intval( $_GET['baths'] )                              : 0,
	'price_min' => isset( $_GET['price_min'] )  ? intval( $_GET['price_min'] )                          : 0,
	'price_max' => isset( $_GET['price_max'] )  ? intval( $_GET['price_max'] )                          : 0,
	'orderby'   => isset( $_GET['orderby'] )    ? sanitize_text_field( wp_unslash( $_GET['orderby'] ) ) : 'recent',
);

$mu_sale = ( $mu_lang === 'en' ) ? 'For Sale' : 'A Vendre';
$mu_rent = ( $mu_lang === 'en' ) ? 'For Rent' : 'A Louer';

if ( $f['action'] !== '' ) {
	$f['action'] = murailles_property_action_value( $f['action'] );
}

$paged    = max( 1, get_query_var( 'paged' ) );
$per_page = 6;

/* ── WP_Query — always scoped to the current term ──────────────────────── */
$args = array(
	'post_type'      => 'property',
	'posts_per_page' => $per_page,
	'paged'          => $paged,
	'post_status'    => 'publish',
	'tax_query'      => array(
		array(
			'taxonomy' => $current_tax,
			'field'    => 'term_id',
			'terms'    => $term->term_id,
		),
	),
);

if ( $f['q'] !== '' ) { $args['s'] = $f['q']; }

/* Extra taxonomy filters — skip whichever taxonomy is the current archive. */
$extra_tax = array();
if ( $f['ptype'] !== '' && $current_tax !== 'property_category' ) {
	$extra_tax[] = array( 'taxonomy' => 'property_category', 'field' => 'slug', 'terms' => $f['ptype'] );
}
if ( $f['location'] !== '' && $current_tax !== 'property_location' ) {
	$extra_tax[] = array( 'taxonomy' => 'property_location', 'field' => 'slug', 'terms' => $f['location'] );
}
if ( $f['area'] !== '' && $current_tax !== 'property_area' ) {
	$extra_tax[] = array( 'taxonomy' => 'property_area', 'field' => 'slug', 'terms' => $f['area'] );
}
if ( $extra_tax ) {
	$args['tax_query']['relation'] = 'AND';
	$args['tax_query']             = array_merge( $args['tax_query'], $extra_tax );
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
if ( count( $meta_query ) > 1 ) { $meta_query['relation'] = 'AND'; }
if ( $meta_query ) { $args['meta_query'] = $meta_query; }

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
$pages = $props->max_num_pages;
$start = $total ? ( ( $paged - 1 ) * $per_page ) + 1 : 0;
$end   = min( $paged * $per_page, $total );

$active_count = 0;
foreach ( array( 'q', 'ptype', 'action', 'location', 'area', 'beds', 'baths', 'price_min', 'price_max' ) as $k ) {
	if ( ! empty( $f[ $k ] ) ) $active_count++;
}
?>

<!-- ═══════════════════ HERO SECTION ═══════════════════════════════════════
     Reuses the shared inner-page hero (same markup/height/colors as
     about-us, histoire-marrakech, contact…) so every page stays consistent.
     A stats chip row is appended below the standard title block. -->
<?php
$hero_subtitle = $term_desc
	? $term_desc
	: sprintf(
		/* translators: %1$d: count  %2$s: term name */
		murailles_t( '%1$d bien(s) disponible(s) — %2$s', false ),
		(int) $total,
		$term_name
	);

get_template_part( 'template-parts/hero-page-title', null, array(
	'bg'       => $hero_bg,
	'eyebrow'  => $hero_eyebrow,
	'title'    => $hero_title,
	'subtitle' => $hero_subtitle,
	'overlay'  => 6,
	'stats'    => array(
		array( 'icon' => 'fa-building', 'text' => sprintf( '%d %s', (int) $total, murailles_t( 'annonces', false ) ) ),
		array( 'icon' => 'fa-tag',      'text' => murailles_t( 'Vente & Location', false ) ),
		array( 'icon' => 'fa-star',     'text' => murailles_t( 'Biens vérifiés', false ) ),
	),
) );
?>
<!-- ═══════════════════ END HERO ══════════════════════════════════════════ -->

<!-- ═══════════════════ LISTINGS ══════════════════════════════════════════ -->
<section class="gray pt-4 pb-5">
	<div class="container">

		<!-- Toolbar -->
		<div class="row m-0 mb-2">
			<div class="short_wraping">
				<div class="row align-items-center">

					<div class="col-lg-3 col-md-6 col-sm-12">
						<ul class="shorting_grid">
							<li class="list-inline-item">
								<a href="<?php echo esc_url( $term_link ); ?>" class="active">
									<span class="ti-layout-grid2"></span><?php murailles_t( 'Grille' ); ?>
								</a>
							</li>
						</ul>
					</div>

					<div class="col-lg-6 col-md-12 col-sm-12 order-lg-2 order-md-3 elco_bor">
						<div class="shorting_pagination">
							<div class="shorting_pagination_laft">
								<h5>
									<?php murailles_t( 'Affichage' ); ?> <?php echo $start; ?>–<?php echo $end; ?>
									<?php murailles_t( 'sur' ); ?> <?php echo $total; ?>
									<?php murailles_t( 'résultats' ); ?>
								</h5>
							</div>
							<?php if ( $pages > 1 ) : ?>
							<div class="shorting_pagination_right">
								<ul>
									<?php for ( $i = 1; $i <= min( $pages, 6 ); $i++ ) : ?>
										<li>
											<a href="<?php echo esc_url( get_pagenum_link( $i ) ); ?>"
											   <?php echo $i === $paged ? 'class="active"' : ''; ?>>
												<?php echo $i; ?>
											</a>
										</li>
									<?php endfor; ?>
								</ul>
							</div>
							<?php endif; ?>
						</div>
					</div>

					<div class="col-lg-3 col-md-6 col-sm-12 order-lg-3 order-md-2">
						<div class="shorting-right">
							<label><?php murailles_t( 'Trier par :' ); ?></label>
							<?php
							$cur_label = murailles_t( 'Plus récents', false );
							if ( $f['orderby'] === 'price_asc' )  $cur_label = murailles_t( 'Prix croissant', false );
							if ( $f['orderby'] === 'price_desc' ) $cur_label = murailles_t( 'Prix décroissant', false );
							?>
							<div class="dropdown">
								<a class="btn btn-filter dropdown-toggle" href="#"
								   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<span class="selection"><?php echo esc_html( $cur_label ); ?></span>
								</a>
								<div class="drp-select dropdown-menu">
									<a class="dropdown-item" href="<?php echo esc_url( $term_link ); ?>" data-murailles-orderby="recent"><?php murailles_t( 'Plus récents' ); ?></a>
									<a class="dropdown-item" href="<?php echo esc_url( $term_link ); ?>" data-murailles-orderby="price_asc"><?php murailles_t( 'Prix croissant' ); ?></a>
									<a class="dropdown-item" href="<?php echo esc_url( $term_link ); ?>" data-murailles-orderby="price_desc"><?php murailles_t( 'Prix décroissant' ); ?></a>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
		<!-- / Toolbar -->

		<div class="row">

			<!-- ── Sidebar filter ───────────────────────────────────────── -->
			<div class="col-lg-4 col-md-12 col-sm-12">
				<form method="get" action="<?php echo esc_url( $term_link ); ?>" class="page-sidebar p-0">

					<a class="filter_links" data-bs-toggle="collapse" href="#fltbox-tax" role="button"
					   aria-expanded="true" aria-controls="fltbox-tax">
						<?php murailles_t( 'Filtrer les annonces' ); ?><i class="fa fa-sliders-h ms-2"></i>
						<?php if ( $active_count ) : ?>
							<span class="badge bg-danger ms-2">
								<?php echo (int) $active_count; ?> <?php murailles_t( $active_count > 1 ? 'actifs' : 'actif' ); ?>
							</span>
						<?php endif; ?>
					</a>

					<div class="collapse show" id="fltbox-tax">
						<div class="sidebar-widgets p-4">

							<div class="form-group">
								<div class="input-with-icon">
									<input type="text" name="q" value="<?php echo esc_attr( $f['q'] ); ?>"
									       class="form-control"
									       placeholder="<?php echo esc_attr( murailles_t( 'Mot-clé, référence...', false ) ); ?>">
									<i class="ti-search"></i>
								</div>
							</div>

							<?php if ( $current_tax !== 'property_category' ) : ?>
							<div class="form-group">
								<div class="simple-input">
									<select name="ptype" class="form-control">
										<option value=""><?php murailles_t( 'Type de bien' ); ?></option>
										<?php foreach ( $all_cats as $cat ) : ?>
										<option value="<?php echo esc_attr( $cat->slug ); ?>" <?php selected( $f['ptype'], $cat->slug ); ?>>
											<?php echo esc_html( $cat->name ); ?>
										</option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<?php endif; ?>

							<div class="form-group">
								<div class="simple-input">
									<select name="action_t" class="form-control">
										<option value=""><?php murailles_t( 'Action' ); ?></option>
										<option value="<?php echo esc_attr( $mu_sale ); ?>" <?php selected( $f['action'], $mu_sale ); ?>><?php murailles_t( 'À vendre' ); ?></option>
										<option value="<?php echo esc_attr( $mu_rent ); ?>" <?php selected( $f['action'], $mu_rent ); ?>><?php murailles_t( 'À louer' ); ?></option>
									</select>
								</div>
							</div>

							<?php if ( $current_tax !== 'property_location' && ! empty( $all_locs ) ) : ?>
							<div class="form-group">
								<div class="simple-input">
									<select name="location" class="form-control">
										<option value=""><?php murailles_t( 'Ville' ); ?></option>
										<?php foreach ( $all_locs as $loc ) : ?>
										<option value="<?php echo esc_attr( $loc->slug ); ?>" <?php selected( $f['location'], $loc->slug ); ?>>
											<?php echo esc_html( $loc->name ); ?>
										</option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<?php endif; ?>

							<?php if ( $current_tax !== 'property_area' && ! empty( $all_areas ) ) : ?>
							<div class="form-group">
								<div class="simple-input">
									<select name="area" class="form-control">
										<option value=""><?php murailles_t( 'Quartier' ); ?></option>
										<?php foreach ( $all_areas as $area ) : ?>
										<option value="<?php echo esc_attr( $area->slug ); ?>" <?php selected( $f['area'], $area->slug ); ?>>
											<?php echo esc_html( $area->name ); ?>
										</option>
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
										<input type="number" name="price_min"
										       value="<?php echo $f['price_min'] ? esc_attr( $f['price_min'] ) : ''; ?>"
										       class="form-control"
										       placeholder="<?php echo esc_attr( murailles_t( 'Prix min.', false ) ); ?>">
									</div>
								</div>
								<div class="col-6">
									<div class="form-group">
										<input type="number" name="price_max"
										       value="<?php echo $f['price_max'] ? esc_attr( $f['price_max'] ) : ''; ?>"
										       class="form-control"
										       placeholder="<?php echo esc_attr( murailles_t( 'Prix max.', false ) ); ?>">
									</div>
								</div>
							</div>

							<?php if ( $f['orderby'] ) : ?>
								<input type="hidden" name="orderby" value="<?php echo esc_attr( $f['orderby'] ); ?>">
							<?php endif; ?>

							<div class="d-grid gap-2 mt-3">
								<button type="submit" class="btn btn-danger">
									<i class="fa fa-search me-1"></i> <?php murailles_t( 'Rechercher' ); ?>
								</button>
								<a href="<?php echo esc_url( $term_link ); ?>" class="btn btn-outline-secondary btn-sm">
									<i class="fa fa-rotate-left me-1"></i> <?php murailles_t( 'Réinitialiser' ); ?>
								</a>
							</div>

						</div>
					</div>
				</form>
			</div>
			<!-- / Sidebar -->

			<!-- ── Property grid ────────────────────────────────────────── -->
			<div class="col-lg-8 col-md-12 col-sm-12">

				<?php murailles_currency_switcher( array( 'class' => 'is-listing' ) ); ?>

				<div class="row justify-content-start g-4 murailles-prop-grid">

					<?php if ( $props->have_posts() ) : ?>
						<?php while ( $props->have_posts() ) : $props->the_post();
							$pid     = get_the_ID();
							$pprice  = get_post_meta( $pid, '_property_price', true );
							$psuffix = get_post_meta( $pid, '_property_price_suffix', true );
							$paction = get_post_meta( $pid, '_property_action', true );
							$psize   = get_post_meta( $pid, '_property_size', true );
							$pbeds   = get_post_meta( $pid, '_property_bedrooms', true );
							$pbaths  = get_post_meta( $pid, '_property_bathrooms', true );
							$pcats   = wp_get_post_terms( $pid, 'property_category', array( 'fields' => 'names' ) );
							$pareas  = wp_get_post_terms( $pid, 'property_area',     array( 'fields' => 'names' ) );
							$plocs   = wp_get_post_terms( $pid, 'property_location', array( 'fields' => 'names' ) );
							$pcat    = ! empty( $pcats )  ? $pcats[0]  : '';
							$ploc    = ! empty( $plocs )  ? $plocs[0]  : '';
							$parea   = ! empty( $pareas ) ? $pareas[0] : '';
							$link    = get_permalink();
							$thumb   = has_post_thumbnail()
								? get_the_post_thumbnail_url( $pid, 'medium_large' )
								: murailles_img( 'p-' . ( ( $pid % 9 ) + 1 ) . '.png' );
							$gallery = get_post_meta( $pid, '_property_gallery_ids', true );
							$imgs    = array();
							if ( $gallery ) {
								foreach ( array_slice( array_filter( explode( ',', $gallery ) ), 0, 3 ) as $gid ) {
									$url = wp_get_attachment_image_url( intval( $gid ), 'medium_large' );
									if ( $url ) $imgs[] = $url;
								}
							}
							if ( empty( $imgs ) ) { $imgs[] = $thumb; }
						?>

						<!-- Single Property Card -->
						<div class="col-lg-6 col-md-6 col-sm-12 d-flex" data-murailles-id="<?php echo esc_attr( $pid ); ?>">
							<div class="property-listing property-2 murailles-prop-card">

								<div class="listing-img-wrapper">
									<div class="_exlio_125"><?php echo esc_html( $paction ?: $mu_sale ); ?></div>
									<div class="list-img-slide">
										<div class="click">
											<?php foreach ( $imgs as $img_url ) : ?>
											<div>
												<a href="<?php echo esc_url( $link ); ?>">
													<img src="<?php echo esc_url( $img_url ); ?>" class="img-fluid mx-auto"
													     alt="<?php the_title_attribute(); ?>" width="1200" height="800"
													     loading="lazy" decoding="async" />
												</a>
											</div>
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
												<div class="listing-card-info-price text-seegreen mb-0"><?php echo murailles_price_html( $pid ); ?></div>
												<?php if ( $psuffix ) : ?><small><?php echo esc_html( $psuffix ); ?></small><?php endif; ?>
											</div>
											<?php endif; ?>
										</div>
										<div class="_card_list_flex">
											<div class="_card_flex_01">
												<h3 class="listing-name verified"><a href="<?php echo esc_url( $link ); ?>" class="prt-link-detail"><?php the_title(); ?></a></h3>
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
										<div class="foot-location">
											<img src="<?php echo esc_url( murailles_img( 'pin.svg' ) ); ?>" width="18" alt="" />
											<?php echo esc_html( $parea ? $parea . ', ' : '' ); ?><?php echo esc_html( $ploc ); ?>
										</div>
									</div>
									<div class="footer-flex">
										<ul class="selio_style">
											<li>
												<div class="prt_saveed_12lk">
													<label class="toggler toggler-danger" data-bs-toggle="tooltip" data-bs-placement="top"
													       data-bs-title="<?php echo esc_attr( murailles_t( 'Sauvegarder', false ) ); ?>"
													       aria-label="<?php echo esc_attr( sprintf( murailles_t( 'Sauvegarder %s', false ), get_the_title( $pid ) ) ); ?>">
														<input type="checkbox"><i class="fa-solid fa-heart" aria-hidden="true"></i>
													</label>
												</div>
											</li>
											<li>
												<div class="prt_saveed_12lk">
													<a href="<?php echo esc_url( home_url( '/compare-property/' ) ); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
													   data-bs-title="<?php echo esc_attr( murailles_t( 'Comparer', false ) ); ?>"
													   aria-label="<?php echo esc_attr( sprintf( murailles_t( 'Comparer %s', false ), get_the_title( $pid ) ) ); ?>">
														<i class="fa-solid fa-share" aria-hidden="true"></i>
													</a>
												</div>
											</li>
											<li>
												<div class="prt_saveed_12lk">
													<a href="<?php echo esc_url( $link ); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
													   data-bs-title="<?php echo esc_attr( murailles_t( 'Voir le bien', false ) ); ?>"
													   aria-label="<?php echo esc_attr( sprintf( murailles_t( 'Voir le bien %s', false ), get_the_title( $pid ) ) ); ?>">
														<i class="fa-regular fa-circle-right" aria-hidden="true"></i>
													</a>
												</div>
											</li>
										</ul>
									</div>
								</div>

							</div>
						</div>
						<!-- / Single Property Card -->

						<?php endwhile; wp_reset_postdata(); ?>

					<?php else : ?>
						<div class="col-lg-12 text-center py-5">
							<div class="murailles-empty-state">
								<i class="fa-solid fa-house-circle-xmark"></i>
								<h4><?php murailles_t( 'Aucun bien trouvé' ); ?></h4>
								<p>
									<?php
									printf(
										/* translators: %s: term name */
										esc_html( murailles_t( 'Aucune annonce ne correspond à vos critères — %s.', false ) ),
										esc_html( $term_name )
									);
									?>
								</p>
								<a href="<?php echo esc_url( $term_link ); ?>" class="btn btn-danger mt-2">
									<i class="fa fa-rotate-left me-1"></i> <?php murailles_t( 'Réinitialiser les filtres' ); ?>
								</a>
							</div>
						</div>
					<?php endif; ?>

				</div>
				<!-- / grid -->

				<?php if ( $pages > 1 ) : ?>
				<div class="row mt-4">
					<div class="col-lg-12 col-md-12">
						<ul class="pagination p-center">
							<?php
							$pagination = paginate_links( array(
								'total'     => $pages,
								'current'   => $paged,
								'type'      => 'array',
								'prev_text' => '<span class="ti-arrow-left"></span>',
								'next_text' => '<span class="ti-arrow-right"></span>',
							) );
							if ( $pagination ) {
								foreach ( $pagination as $link ) {
									echo '<li class="page-item' . ( strpos( $link, 'current' ) !== false ? ' active' : '' ) . '">' . $link . '</li>'; // phpcs:ignore
								}
							}
							?>
						</ul>
					</div>
				</div>
				<?php endif; ?>

			</div>
			<!-- / Property grid column -->

		</div>
	</div>
</section>
<!-- ═══════════════════ END LISTINGS ══════════════════════════════════════ -->
