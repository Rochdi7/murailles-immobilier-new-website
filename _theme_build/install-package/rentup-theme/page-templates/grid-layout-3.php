<?php
/**
 * Template Name: Grid Layout 3
 *
 * Auto-converted from grid-layout-3.html
 * Preserves exact original HTML markup, classes, and structure.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();
?>

<!-- ============================ All Property ================================== -->
			<section class="gray pt-4">
			
				<div class="container">
					
					<div class="row m-0">
						<div class="short_wraping">
							<div class="row align-items-center">
							
								<div class="col-lg-3 col-md-6 col-sm-12  col-sm-6">
									<ul class="shorting_grid">
										<li class="list-inline-item"><a href="<?php echo esc_url( home_url( '/grid-layout-with-sidebar/' ) ); ?>" class="active"><span class="ti-layout-grid2"></span>Grid</a></li>
										<li class="list-inline-item"><a href="<?php echo esc_url( home_url( '/list-layout-with-sidebar/' ) ); ?>"><span class="ti-view-list"></span>List</a></li>
										<li class="list-inline-item"><a href="#"><span class="ti-map-alt"></span>Map</a></li>
									</ul>
								</div>
						
								<div class="col-lg-6 col-md-12 col-sm-12 order-lg-2 order-md-3 elco_bor col-sm-12">
									<div class="shorting_pagination">
										<div class="shorting_pagination_laft">
											<h5>Showing 1-25 of 72 results</h5>
										</div>
										<div class="shorting_pagination_right">
											<ul>
												<li><a href="javascript:void(0);" class="active">1</a></li>
												<li><a href="javascript:void(0);">2</a></li>
												<li><a href="javascript:void(0);">3</a></li>
												<li><a href="javascript:void(0);">4</a></li>
												<li><a href="javascript:void(0);">5</a></li>
												<li><a href="javascript:void(0);">6</a></li>
											</ul>
										</div>
									</div>
								</div>
						
								<div class="col-lg-3 col-md-6 col-sm-12 order-lg-3 order-md-2 col-sm-6">
									<div class="shorting-right">
										<label>Short By:</label>
										<div class="dropdown show">
											<a class="btn btn-filter dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<span class="selection">Most Rated</span>
											</a>
											<div class="drp-select dropdown-menu">
												<a class="dropdown-item" href="JavaScript:Void(0);">Most Rated</a>
												<a class="dropdown-item" href="JavaScript:Void(0);">Most Viewd</a>
												<a class="dropdown-item" href="JavaScript:Void(0);">News Listings</a>
												<a class="dropdown-item" href="JavaScript:Void(0);">High Rated</a>
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
							<div class="page-sidebar p-0">
								<a class="filter_links" data-bs-toggle="collapse" href="#fltbox" role="button" aria-expanded="false" aria-controls="fltbox">Open Advance Filter<i class="fa fa-sliders-h ms-2"></i></a>							
								<div class="collapse" id="fltbox">
									<!-- Find New Property -->
									<div class="sidebar-widgets p-4">
										
										<div class="form-group">
											<div class="input-with-icon">
												<input type="text" class="form-control" placeholder="Neighborhood">
												<i class="ti-search"></i>
											</div>
										</div>
										
										<div class="form-group">
											<div class="input-with-icon">
												<input type="text" class="form-control" placeholder="Location">
												<i class="ti-location-pin"></i>
											</div>
										</div>
										
										<div class="form-group">
											<div class="simple-input">
												<select id="ptype" class="form-control">
													<option value="">&nbsp;</option>
													<option value="1">Apartment</option>
													<option value="2">Condo</option>
													<option value="3">Family</option>
													<option value="4">Houses</option>
													<option value="5">Villa</option>
												</select>
											</div>
										</div>
										
										<div class="form-group">
											<div class="simple-input">
												<select id="status" class="form-control">
													<option value="">&nbsp;</option>
													<option value="1">Apartment</option>
													<option value="2">Condo</option>
													<option value="3">Houses</option>
													<option value="4">Villa</option>
													<option value="5">Land</option>
												</select>
											</div>
										</div>
										
										<div class="form-group">
											<div class="simple-input">
												<select id="price" class="form-control">
													<option value="">&nbsp;</option>
													<option value="1">Less Then $1000</option>
													<option value="2">$1000 - $2000</option>
													<option value="3">$2000 - $3000</option>
													<option value="4">$3000 - $4000</option>
													<option value="5">Above $5000</option>
												</select>
											</div>
										</div>
										
										<div class="form-group">
											<div class="simple-input">
												<select id="bedrooms" class="form-control">
													<option value="">&nbsp;</option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
												</select>
											</div>
										</div>
										
										<div class="form-group">
											<div class="simple-input">
												<select id="bathrooms" class="form-control">
													<option value="">&nbsp;</option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
												</select>
											</div>
										</div>
										
										<div class="form-group">
											<div class="simple-input">
												<select id="garage" class="form-control">
													<option value="">&nbsp;</option>
													<option value="1">Any Type</option>
													<option value="2">Yes</option>
													<option value="3">No</option>
												</select>
											</div>
										</div>
										
										<div class="form-group">
											<div class="simple-input">
												<select id="built" class="form-control">
													<option value="">&nbsp;</option>
													<option value="1">2010</option>
													<option value="2">2011</option>
													<option value="3">2012</option>
													<option value="4">2013</option>
													<option value="5">2014</option>
													<option value="6">2015</option>
													<option value="7">2016</option>
												</select>
											</div>
										</div>
										
										<div class="row">
											<div class="col-lg-6 col-md-6 col-sm-6">
												<div class="form-group">
													<div class="simple-input">
														<input type="text" class="form-control" placeholder="Min Area">
													</div>
												</div>
											</div>
											<div class="col-lg-6 col-md-6 col-sm-6">
												<div class="form-group">
													<div class="simple-input">
														<input type="text" class="form-control" placeholder="Max Area">
													</div>
												</div>
											</div>
										</div>
										
										<div class="row">
											<div class="col-lg-12 col-md-12 col-sm-12 pt-4 pb-4">
												<h6>Choose Price</h6>
												<div class="rg-slider">
													 <input type="text" class="js-range-slider" name="my_range" value="" />
												</div>
											</div>
										</div>									
										
										<div class="row">
											<div class="col-lg-12 col-md-12 col-sm-12 pt-4">
												<h6>Advance Features</h6>
												<ul class="row p-0 m-0">
													<li class="col-lg-6 col-md-6 p-0">
														<input id="a-1" class="form-check-input" name="a-1" type="checkbox">
														<label for="a-1" class="form-check-label">Air Condition</label>
													</li>
													<li class="col-lg-6 col-md-6 p-0">
														<input id="a-2" class="form-check-input" name="a-2" type="checkbox">
														<label for="a-2" class="form-check-label">Bedding</label>
													</li>
													<li class="col-lg-6 col-md-6 p-0">
														<input id="a-3" class="form-check-input" name="a-3" type="checkbox">
														<label for="a-3" class="form-check-label">Heating</label>
													</li>
													<li class="col-lg-6 col-md-6 p-0">
														<input id="a-4" class="form-check-input" name="a-4" type="checkbox">
														<label for="a-4" class="form-check-label">Internet</label>
													</li>
													<li class="col-lg-6 col-md-6 p-0">
														<input id="a-5" class="form-check-input" name="a-5" type="checkbox">
														<label for="a-5" class="form-check-label">Microwave</label>
													</li>
													<li class="col-lg-6 col-md-6 p-0">
														<input id="a-6" class="form-check-input" name="a-6" type="checkbox">
														<label for="a-6" class="form-check-label">Smoking Allow</label>
													</li>
													<li class="col-lg-6 col-md-6 p-0">
														<input id="a-7" class="form-check-input" name="a-7" type="checkbox">
														<label for="a-7" class="form-check-label">Terrace</label>
													</li>
													<li class="col-lg-6 col-md-6 p-0">
														<input id="a-8" class="form-check-input" name="a-8" type="checkbox">
														<label for="a-8" class="form-check-label">Balcony</label>
													</li>
													<li class="col-lg-6 col-md-6 p-0">
														<input id="a-9" class="form-check-input" name="a-9" type="checkbox">
														<label for="a-9" class="form-check-label">Icon</label>
													</li>
												</ul>
											</div>
										</div>
										
										<div class="row">
											<div class="col-lg-12 col-md-12 col-sm-12 pt-4">
												<button class="btn btn-danger full-width">Find New Home</button>
											</div>
										</div>
									
									</div>
								</div>
							</div>
							<!-- Sidebar End -->						
						</div>
						
						<div class="col-lg-8 col-md-12 col-sm-12">
							<div class="row justify-content-center g-4">
						
								<!-- Single Property -->
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="property-listing property-2">
										
										<div class="listing-img-wrapper">
											<div class="list-img-slide">
												<a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>"><img src="<?php echo esc_url( murailles_img( 'p-1.png' ) ); ?>" class="img-fluid mx-auto" alt="" /></a>
											</div>
										</div>
										
										<div class="listing-detail-wrapper">
											<div class="listing-short-detail-wrap">
												<div class="_card_list_flex mb-2">
													<div class="_card_flex_01">
														<span class="property-type elt_rent">For Rent</span>
													</div>
													<div class="_card_flex_last">
														<div class="prt_saveed_12lk">
															<label class="toggler toggler-danger"><input type="checkbox"><i class="fas fa-heart"></i></label>
														</div>
													</div>
												</div>
												<div class="listing-short-detail">
													<h4 class="listing-name verified"><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-link-detail">Red Carpet Real Estate</a></h4>
													<div class="foot-location"><img src="<?php echo esc_url( murailles_img( 'pin.svg' ) ); ?>" width="18" alt="" />210 Zirak Road, Canada</div>
												</div>
											</div>
										</div>
										
										<div class="listing-detail-footer">
											<div class="footer-first">
												<div class="foot-location"><span class="pric_lio bg-danger">$3,700</span>/sqft</div>
											</div>
											<div class="footer-flex">
												<span>Apartment</span>
											</div>
										</div>
										
									</div>
								</div>
								
								<!-- Single Property -->
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="property-listing property-2">
										
										<div class="listing-img-wrapper">
											<div class="list-img-slide">
												<a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>"><img src="<?php echo esc_url( murailles_img( 'p-2.png' ) ); ?>" class="img-fluid mx-auto" alt="" /></a>
											</div>
										</div>
										
										<div class="listing-detail-wrapper">
											<div class="listing-short-detail-wrap">
												<div class="_card_list_flex mb-2">
													<div class="_card_flex_01">
														<span class="property-type elt_sale">For Sale</span>
													</div>
													<div class="_card_flex_last">
														<div class="prt_saveed_12lk">
															<label class="toggler toggler-danger"><input type="checkbox"><i class="fas fa-heart"></i></label>
														</div>
													</div>
												</div>
												<div class="listing-short-detail">
													<h4 class="listing-name verified"><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-link-detail">Fairmount Properties</a></h4>
													<div class="foot-location"><img src="<?php echo esc_url( murailles_img( 'pin.svg' ) ); ?>" width="18" alt="" />5698 Zirak Road, NewYork</div>
												</div>
											</div>
										</div>
										
										<div class="listing-detail-footer">
											<div class="footer-first">
												<div class="foot-location"><span class="pric_lio bg-danger">$9,750</span>/sqft</div>
											</div>
											<div class="footer-flex">
												<span>Condos</span>
											</div>
										</div>
										
									</div>
								</div>
								
								<!-- Single Property -->
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="property-listing property-2">
										
										<div class="listing-img-wrapper">
											<div class="list-img-slide">
												<a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>"><img src="<?php echo esc_url( murailles_img( 'p-4.png' ) ); ?>" class="img-fluid mx-auto" alt="" /></a>
											</div>
										</div>
										
										<div class="listing-detail-wrapper">
											<div class="listing-short-detail-wrap">
												<div class="_card_list_flex mb-2">
													<div class="_card_flex_01">
														<span class="property-type elt_rent">For Rent</span>
													</div>
													<div class="_card_flex_last">
														<div class="prt_saveed_12lk">
															<label class="toggler toggler-danger"><input type="checkbox"><i class="fas fa-heart"></i></label>
														</div>
													</div>
												</div>
												<div class="listing-short-detail">
													<h4 class="listing-name verified"><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-link-detail">The Real Estate Corner</a></h4>
													<div class="foot-location"><img src="<?php echo esc_url( murailles_img( 'pin.svg' ) ); ?>" width="18" alt="" />5624 Mooker Market, USA</div>
												</div>
											</div>
										</div>
										
										<div class="listing-detail-footer">
											<div class="footer-first">
												<div class="foot-location"><span class="pric_lio bg-danger">$5,860</span>/sqft</div>
											</div>
											<div class="footer-flex">
												<span>Offices</span>
											</div>
										</div>
										
									</div>
								</div>
								
								<!-- Single Property -->
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="property-listing property-2">
										
										<div class="listing-img-wrapper">
											<div class="list-img-slide">
												<a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>"><img src="<?php echo esc_url( murailles_img( 'p-5.png' ) ); ?>" class="img-fluid mx-auto" alt="" /></a>
											</div>
										</div>
										
										<div class="listing-detail-wrapper">
											<div class="listing-short-detail-wrap">
												<div class="_card_list_flex mb-2">
													<div class="_card_flex_01">
														<span class="property-type elt_sale">For Sale</span>
													</div>
													<div class="_card_flex_last">
														<div class="prt_saveed_12lk">
															<label class="toggler toggler-danger"><input type="checkbox"><i class="fas fa-heart"></i></label>
														</div>
													</div>
												</div>
												<div class="listing-short-detail">
													<h4 class="listing-name verified"><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-link-detail">Herringbone Realty</a></h4>
													<div class="foot-location"><img src="<?php echo esc_url( murailles_img( 'pin.svg' ) ); ?>" width="18" alt="" />5621 Liverpool, London</div>
												</div>
											</div>
										</div>
										
										<div class="listing-detail-footer">
											<div class="footer-first">
												<div class="foot-location"><span class="pric_lio bg-danger">$7,540</span>/sqft</div>
											</div>
											<div class="footer-flex">
												<span>Homes & Villas</span>
											</div>
										</div>
										
									</div>
								</div>
								
								<!-- Single Property -->
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="property-listing property-2">
										
										<div class="listing-img-wrapper">
											<div class="list-img-slide">
												<a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>"><img src="<?php echo esc_url( murailles_img( 'p-6.png' ) ); ?>" class="img-fluid mx-auto" alt="" /></a>
											</div>
										</div>
										
										<div class="listing-detail-wrapper">
											<div class="listing-short-detail-wrap">
												<div class="_card_list_flex mb-2">
													<div class="_card_flex_01">
														<span class="property-type elt_rent">For Rent</span>
													</div>
													<div class="_card_flex_last">
														<div class="prt_saveed_12lk">
															<label class="toggler toggler-danger"><input type="checkbox"><i class="fas fa-heart"></i></label>
														</div>
													</div>
												</div>
												<div class="listing-short-detail">
													<h4 class="listing-name verified"><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-link-detail">Brick Lane Realty</a></h4>
													<div class="foot-location"><img src="<?php echo esc_url( murailles_img( 'pin.svg' ) ); ?>" width="18" alt="" />210 Montreal Road, Canada</div>
												</div>
											</div>
										</div>
										
										<div class="listing-detail-footer">
											<div class="footer-first">
												<div class="foot-location"><span class="pric_lio bg-danger">$4,850</span>/sqft</div>
											</div>
											<div class="footer-flex">
												<span>Commercial</span>
											</div>
										</div>
										
									</div>
								</div>
								
								<!-- Single Property -->
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="property-listing property-2">
										
										<div class="listing-img-wrapper">
											<div class="list-img-slide">
												<a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>"><img src="<?php echo esc_url( murailles_img( 'p-7.png' ) ); ?>" class="img-fluid mx-auto" alt="" /></a>
											</div>
										</div>
										
										<div class="listing-detail-wrapper">
											<div class="listing-short-detail-wrap">
												<div class="_card_list_flex mb-2">
													<div class="_card_flex_01">
														<span class="property-type elt_sale">For Sale</span>
													</div>
													<div class="_card_flex_last">
														<div class="prt_saveed_12lk">
															<label class="toggler toggler-danger"><input type="checkbox"><i class="fas fa-heart"></i></label>
														</div>
													</div>
												</div>
												<div class="listing-short-detail">
													<h4 class="listing-name verified"><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-link-detail">Banyon Tree Realty</a></h4>
													<div class="foot-location"><img src="<?php echo esc_url( murailles_img( 'pin.svg' ) ); ?>" width="18" alt="" />210 Zirak Road, Canada</div>
												</div>
											</div>
										</div>
										
										<div class="listing-detail-footer">
											<div class="footer-first">
												<div class="foot-location"><span class="pric_lio bg-danger">$2,742</span>/sqft</div>
											</div>
											<div class="footer-flex">
												<span>Apartment</span>
											</div>
										</div>
										
									</div>
								</div>
								
							</div>
						</div>
						
						
					</div>
				</div>	
			</section>
			<!-- ============================ All Property ================================== -->

<?php murailles_render_page_builder_content(); ?>

<?php get_template_part( 'template-parts/call-to-action' ); ?>

<?php get_footer(); ?>
