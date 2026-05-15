<?php
/**
 * Template Name: Home 6
 *
 * Auto-converted from home-6.html
 * Preserves exact original HTML markup, classes, and structure.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$murailles_header_style = 'transparent';
get_header();
?>

<!-- ============================ Hero Banner  Start================================== -->
			<div class="image-cover hero_banner" style="background:#042238 url(<?php echo esc_url( murailles_img( 'banner-home.jpg' ) ); ?>) no-repeat;">
				<div class="container">
					
					<div class="row">
						<div class="col-xl-7 col-lg-8 col-md-10">
							<h2 class="big-header-capt mb-5">Find Your Next Perfect <span class="text-danger">Place</span> To Live & Stay.</h2>
						</div>
					</div>
					
					<div class="row">
						<div class="col-xl-12 col-lg-12 col-md-12">
							<div class="full_search_box nexio_search lightanic_search hero_search-radius modern">
								<div class="search_hero_wrapping">
							
									<div class="row">
										<div class="col-lg-3 col-md-3 col-sm-12">
											<div class="form-group">
												<label>City/Street</label>
												<div class="input-with-icon">
													<select id="location" class="form-control">
														<option value="">&nbsp;</option>
														<option value="1">New York City</option>
														<option value="2">Honolulu, Hawaii</option>
														<option value="3">California</option>
														<option value="4">New Orleans</option>
														<option value="5">Washington</option>
														<option value="6">Charleston</option>
													</select>
												</div>
											</div>
										</div>
										
										<div class="col-lg-2 col-md-3 col-sm-12">
											<div class="form-group">
												<label>Property Type</label>
												<div class="input-with-icon">
													<select id="ptypes" class="form-control">
														<option value="">&nbsp;</option>
														<option value="1">All categories</option>
														<option value="2">Apartment</option>
														<option value="3">Villas</option>
														<option value="4">Commercial</option>
														<option value="5">Offices</option>
														<option value="6">Garage</option>
													</select>
												</div>
											</div>
										</div>
										
										<div class="col-lg-3 col-sm-12 d-md-none d-lg-block">
											<div class="form-group">
												<label>Price Range</label>
												<div class="input-with-icon">
													<select id="price" class="form-control">
														<option value="">&nbsp;</option>
														<option value="1">From 40,000 To 10m</option>
														<option value="2">From 60,000 To 20m</option>
														<option value="3">From 70,000 To 30m</option>
														<option value="3">From 80,000 To 40m</option>
														<option value="3">From 90,000 To 50m</option>
													</select>
												</div>
											</div>
										</div>
										
										<div class="col-lg-2 col-md-3 col-sm-12">
											<div class="form-group none">
												<a class="collapsed ad-search" data-bs-toggle="collapse" data-parent="#search" data-bs-target="#advance-search" href="javascript:void(0);" aria-expanded="false" aria-controls="advance-search"><i class="fa fa-sliders-h me-2"></i>Advance Filter</a>
											</div>
										</div>
										
										<div class="col-lg-2 col-md-3 col-sm-12 small-padd">
											<div class="form-group none">
												<a href="#" class="btn search-btn btn-danger full-width">Search Property</a>
											</div>
										</div>
									</div>
									
									<!-- Collapse Advance Search Form -->
									<div class="collapse" id="advance-search" aria-expanded="false" role="banner">
										
										<!-- row -->
										<div class="row">
										
											<div class="col-lg-3 col-md-6 col-sm-6">
												<div class="form-group none style-auto">
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
											
											<div class="col-lg-3 col-md-6 col-sm-6">
												<div class="form-group none style-auto">
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
											
											<div class="col-lg-3 col-md-6 col-sm-6">
												<div class="form-group none">
													<input type="text" class="form-control" placeholder="min sqft" />
												</div>
											</div>
											
											<div class="col-lg-3 col-md-6 col-sm-6">
												<div class="form-group none">
													<input type="text" class="form-control" placeholder="max sqft" />
												</div>
											</div>
											
										</div>
										<!-- /row -->
										
										<!-- row -->
										<div class="row">
											<div class="col-lg-12 col-md-12 col-sm-12 mt-2">
												<h6>Advance Price</h6>
												<div class="rg-slider">
													 <input type="text" class="js-range-slider" name="my_range" value="" />
												</div>
											</div>
										</div>
										<!-- /row -->
										
										<!-- row -->
										<div class="row">
										
											<div class="col-lg-12 col-md-12 col-sm-12 mt-3">
												<h4 class="text-dark">Amenities & Features</h4>
												<ul class="no-ul-list third-row">
													<li>
														<input id="a-1" class="form-check-input" name="a-1" type="checkbox">
														<label for="a-1" class="form-check-label">Air Condition</label>
													</li>
													<li>
														<input id="a-2" class="form-check-input" name="a-2" type="checkbox">
														<label for="a-2" class="form-check-label">Bedding</label>
													</li>
													<li>
														<input id="a-3" class="form-check-input" name="a-3" type="checkbox">
														<label for="a-3" class="form-check-label">Heating</label>
													</li>
													<li>
														<input id="a-4" class="form-check-input" name="a-4" type="checkbox">
														<label for="a-4" class="form-check-label">Internet</label>
													</li>
													<li>
														<input id="a-5" class="form-check-input" name="a-5" type="checkbox">
														<label for="a-5" class="form-check-label">Microwave</label>
													</li>
													<li>
														<input id="a-6" class="form-check-input" name="a-6" type="checkbox">
														<label for="a-6" class="form-check-label">Smoking Allow</label>
													</li>
													<li>
														<input id="a-7" class="form-check-input" name="a-7" type="checkbox">
														<label for="a-7" class="form-check-label">Terrace</label>
													</li>
													<li>
														<input id="a-8" class="form-check-input" name="a-8" type="checkbox">
														<label for="a-8" class="form-check-label">Balcony</label>
													</li>
													<li>
														<input id="a-9" class="form-check-input" name="a-9" type="checkbox">
														<label for="a-9" class="form-check-label">Icon</label>
													</li>
													<li>
														<input id="a-10" class="form-check-input" name="a-10" type="checkbox">
														<label for="a-10" class="form-check-label">Wi-Fi</label>
													</li>
													<li>
														<input id="a-11" class="form-check-input" name="a-11" type="checkbox">
														<label for="a-11" class="form-check-label">Beach</label>
													</li>
													<li>
														<input id="a-12" class="form-check-input" name="a-12" type="checkbox">
														<label for="a-12" class="form-check-label">Parking</label>
													</li>
												</ul>
											</div>
											
										</div>
										<!-- /row -->
										
									</div>
									
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
			<!-- ============================ Hero Banner End ================================== -->
			
			<!-- ============================ Property Type Start ================================== -->
			<section class="gray-simple">
				<div class="container">
				
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="sec-heading center">
								<h2>Featured Property Types</h2>
								<p>Find All Type of Property.</p>
							</div>
						</div>
					</div>
					
					<div class="row justify-content-center g-4">
						
						<div class="col-lg col-md-4">
							<!-- Single Category -->
							<div class="property_cats_boxs">
								<a href="<?php echo esc_url( home_url( '/grid-layout-with-sidebar/' ) ); ?>" class="category-box">
									<div class="property_category_short">
										<div class="category-icon clip-1">
											<i class="flaticon-beach-house-2"></i>
										</div>

										<div class="property_category_expand property_category_short-text">
											<h4>Family House</h4>
											<p>122 Property</p>
										</div>
									</div>
								</a>	
							</div>
						</div>
						
						<div class="col-lg col-md-4">
							<!-- Single Category -->
							<div class="property_cats_boxs">
								<a href="<?php echo esc_url( home_url( '/grid-layout-with-sidebar/' ) ); ?>" class="category-box">
									<div class="property_category_short">
										<div class="category-icon clip-2">
											<i class="flaticon-cabin"></i>
										</div>

										<div class="property_category_expand property_category_short-text">
											<h4>House & Villa</h4>
											<p>155 Property</p>
										</div>
									</div>
								</a>
							</div>
						</div>
						
						<div class="col-lg col-md-4">
							<!-- Single Category -->
							<div class="property_cats_boxs">
								<a href="<?php echo esc_url( home_url( '/grid-layout-with-sidebar/' ) ); ?>" class="category-box">
									<div class="property_category_short">
										<div class="category-icon clip-3">
											<i class="flaticon-apartments"></i>
										</div>

										<div class="property_category_expand property_category_short-text">
											<h4>Apartment</h4>
											<p>300 Property</p>
										</div>
									</div>
								</a>
							</div>
						</div>
						
						<div class="col-lg col-md-4">
							<!-- Single Category -->
							<div class="property_cats_boxs">
								<a href="<?php echo esc_url( home_url( '/grid-layout-with-sidebar/' ) ); ?>" class="category-box">
									<div class="property_category_short">
										<div class="category-icon clip-4">
											<i class="flaticon-student-housing"></i>
										</div>

										<div class="property_category_expand property_category_short-text">
											<h4>Office & Studio</h4>
											<p>80 Property</p>
										</div>
									</div>
								</a>
							</div>
						</div>
						
						<div class="col-lg col-md-4">
							<!-- Single Category -->
							<div class="property_cats_boxs">
								<a href="<?php echo esc_url( home_url( '/grid-layout-with-sidebar/' ) ); ?>" class="category-box">
									<div class="property_category_short">
										<div class="category-icon clip-5">
											<i class="flaticon-modern-house-4"></i>
										</div>

										<div class="property_category_expand property_category_short-text">
											<h4>Villa & Condo</h4>
											<p>80 Property</p>
										</div>
									</div>
								</a>
							</div>
						</div>
						
					</div>
				</div>
			</section>
			<!-- ============================ Property Type End ================================== -->
			
			<!-- ============================ Latest Property For Sale Start ================================== -->
			<section class="min">
				<div class="container">
				
					<div class="row justify-content-center">
						<div class="col-lg-7 col-md-10 text-center">
							<div class="sec-heading center mb-4">
								<h2>Recent Property For Sale</h2>
								<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores</p>
							</div>
						</div>
					</div>
					
					<div class="row justify-content-center g-4">
						
						<!-- Single Property -->
						<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
							<div class="property-listing list_view h-100 shadow-0 border">
								
								<div class="listing-img-wrapper">
									<div class="_exlio_125">For Sale</div>
									<div class="list-img-slide">
										<div class="click">
											<div><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>"><img src="<?php echo esc_url( murailles_img( 'p-1.png' ) ); ?>" class="img-fluid mx-auto" alt="" /></a></div>
											<div><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>"><img src="<?php echo esc_url( murailles_img( 'p-2.png' ) ); ?>" class="img-fluid mx-auto" alt="" /></a></div>
											<div><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>"><img src="<?php echo esc_url( murailles_img( 'p-3.png' ) ); ?>" class="img-fluid mx-auto" alt="" /></a></div>
										</div>
									</div>
								</div>
								
								<div class="list_view_flex">
								
									<div class="listing-detail-wrapper mt-1">
										<div class="listing-short-detail-wrap">
											<div class="_card_list_flex mb-2">
												<div class="_card_flex_01">
													<span class="_list_blickes _netork">6 Network</span>
													<span class="_list_blickes types">Family</span>
												</div>
												<div class="_card_flex_last">
													<h6 class="listing-card-info-price mb-0">$7,000</h6>
												</div>
											</div>
											<div class="_card_list_flex">
												<div class="_card_flex_01">
													<h4 class="listing-name verified"><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-link-detail">5689 Resot Relly Market, Montreal Canada, HAQC445</a></h4>
												</div>
											</div>
										</div>
									</div>
									
									<div class="price-features-wrapper">
										<div class="list-fx-features">
											<div class="listing-card-info-icon">
												<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bed.svg' ) ); ?>" width="13" alt="" /></div>3 Beds
											</div>
											<div class="listing-card-info-icon">
												<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bathtub.svg' ) ); ?>" width="13" alt="" /></div>1 Bath
											</div>
											<div class="listing-card-info-icon">
												<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'move.svg' ) ); ?>" width="13" alt="" /></div>800 sqft
											</div>
										</div>
									</div>
									
									<div class="listing-detail-footer">
										<div class="footer-first">
											<div class="foot-rates">
												<span class="elio_rate good">4.2</span>
												<div class="_rate_stio">
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
												</div>
											</div>
										</div>
										<div class="footer-flex">
											<a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-view">View Detail</a>
										</div>
									</div>
								</div>
								
							</div>
						</div>
						<!-- End Single Property -->
						
						<!-- Single Property -->
						<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
							<div class="property-listing list_view h-100 shadow-0 border">
								
								<div class="listing-img-wrapper">
									<div class="_exlio_125">For Rent</div>
									<div class="list-img-slide">
										<div class="click">
											<div><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>"><img src="<?php echo esc_url( murailles_img( 'p-4.png' ) ); ?>" class="img-fluid mx-auto" alt="" /></a></div>
											<div><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>"><img src="<?php echo esc_url( murailles_img( 'p-5.png' ) ); ?>" class="img-fluid mx-auto" alt="" /></a></div>
											<div><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>"><img src="<?php echo esc_url( murailles_img( 'p-6.png' ) ); ?>" class="img-fluid mx-auto" alt="" /></a></div>
										</div>
									</div>
								</div>
								
								<div class="list_view_flex">
								
									<div class="listing-detail-wrapper mt-1">
										<div class="listing-short-detail-wrap">
											<div class="_card_list_flex mb-2">
												<div class="_card_flex_01">
													<span class="_list_blickes _netork">7 Network</span>
													<span class="_list_blickes types">Condos</span>
												</div>
												<div class="_card_flex_last">
													<h6 class="listing-card-info-price mb-0">$10,500</h6>
												</div>
											</div>
											<div class="_card_list_flex">
												<div class="_card_flex_01">
													<h4 class="listing-name verified"><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-link-detail">9632 New Green Garden, Huwai Denever USA, AWE789O</a></h4>
												</div>
											</div>
										</div>
									</div>
									
									<div class="price-features-wrapper">
										<div class="list-fx-features">
											<div class="listing-card-info-icon">
												<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bed.svg' ) ); ?>" width="13" alt="" /></div>4 Beds
											</div>
											<div class="listing-card-info-icon">
												<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bathtub.svg' ) ); ?>" width="13" alt="" /></div>2 Bath
											</div>
											<div class="listing-card-info-icon">
												<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'move.svg' ) ); ?>" width="13" alt="" /></div>1000 sqft
											</div>
										</div>
									</div>
									
									<div class="listing-detail-footer">
										<div class="footer-first">
											<div class="foot-rates">
												<span class="elio_rate perfect">4.7</span>
												<div class="_rate_stio">
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
												</div>
											</div>
										</div>
										<div class="footer-flex">
											<a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-view">View Detail</a>
										</div>
									</div>
								</div>
								
							</div>
						</div>
						<!-- End Single Property -->
						
						<!-- Single Property -->
						<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
							<div class="property-listing list_view h-100 shadow-0 border">
								
								<div class="listing-img-wrapper">
									<div class="_exlio_125">For Sale</div>
									<div class="list-img-slide">
										<div class="click">
											<div><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>"><img src="<?php echo esc_url( murailles_img( 'p-7.png' ) ); ?>" class="img-fluid mx-auto" alt="" /></a></div>
											<div><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>"><img src="<?php echo esc_url( murailles_img( 'p-8.png' ) ); ?>" class="img-fluid mx-auto" alt="" /></a></div>
											<div><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>"><img src="<?php echo esc_url( murailles_img( 'p-9.png' ) ); ?>" class="img-fluid mx-auto" alt="" /></a></div>
										</div>
									</div>
								</div>
								
								<div class="list_view_flex">
								
									<div class="listing-detail-wrapper mt-1">
										<div class="listing-short-detail-wrap">
											<div class="_card_list_flex mb-2">
												<div class="_card_flex_01">
													<span class="_list_blickes _netork">8 Network</span>
													<span class="_list_blickes types">Studio</span>
												</div>
												<div class="_card_flex_last">
													<h6 class="listing-card-info-price mb-0">$8,700</h6>
												</div>
											</div>
											<div class="_card_list_flex">
												<div class="_card_flex_01">
													<h4 class="listing-name verified"><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-link-detail">8512 Red Reveals Market, Montreal Canada, SHQT45O</a></h4>
												</div>
											</div>
										</div>
									</div>
									
									<div class="price-features-wrapper">
										<div class="list-fx-features">
											<div class="listing-card-info-icon">
												<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bed.svg' ) ); ?>" width="13" alt="" /></div>5 Beds
											</div>
											<div class="listing-card-info-icon">
												<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bathtub.svg' ) ); ?>" width="13" alt="" /></div>2 Bath
											</div>
											<div class="listing-card-info-icon">
												<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'move.svg' ) ); ?>" width="13" alt="" /></div>900 sqft
											</div>
										</div>
									</div>
									
									<div class="listing-detail-footer">
										<div class="footer-first">
											<div class="foot-rates">
												<span class="elio_rate good">4.3</span>
												<div class="_rate_stio">
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
												</div>
											</div>
										</div>
										<div class="footer-flex">
											<a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-view">View Detail</a>
										</div>
									</div>
								</div>
								
							</div>
						</div>
						<!-- End Single Property -->
						
						<!-- Single Property -->
						<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
							<div class="property-listing list_view h-100 shadow-0 border">
								
								<div class="listing-img-wrapper">
									<div class="_exlio_125">For Rent</div>
									<div class="list-img-slide">
										<div class="click">
											<div><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>"><img src="<?php echo esc_url( murailles_img( 'p-1.png' ) ); ?>" class="img-fluid mx-auto" alt="" /></a></div>
											<div><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>"><img src="<?php echo esc_url( murailles_img( 'p-2.png' ) ); ?>" class="img-fluid mx-auto" alt="" /></a></div>
											<div><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>"><img src="<?php echo esc_url( murailles_img( 'p-3.png' ) ); ?>" class="img-fluid mx-auto" alt="" /></a></div>
										</div>
									</div>
								</div>
								
								<div class="list_view_flex">
								
									<div class="listing-detail-wrapper mt-1">
										<div class="listing-short-detail-wrap">
											<div class="_card_list_flex mb-2">
												<div class="_card_flex_01">
													<span class="_list_blickes _netork">10 Network</span>
													<span class="_list_blickes types">Villas</span>
												</div>
												<div class="_card_flex_last">
													<h6 class="listing-card-info-price mb-0">$9,100</h6>
												</div>
											</div>
											<div class="_card_list_flex">
												<div class="_card_flex_01">
													<h4 class="listing-name verified"><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-link-detail">7298 Rani Market Near Saaket, Henever Canada, QWUI98</a></h4>
												</div>
											</div>
										</div>
									</div>
									
									<div class="price-features-wrapper">
										<div class="list-fx-features">
											<div class="listing-card-info-icon">
												<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bed.svg' ) ); ?>" width="13" alt="" /></div>5 Beds
											</div>
											<div class="listing-card-info-icon">
												<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bathtub.svg' ) ); ?>" width="13" alt="" /></div>2 Bath
											</div>
											<div class="listing-card-info-icon">
												<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'move.svg' ) ); ?>" width="13" alt="" /></div>900 sqft
											</div>
										</div>
									</div>
									
									<div class="listing-detail-footer">
										<div class="footer-first">
											<div class="foot-rates">
												<span class="elio_rate perfect">4.8</span>
												<div class="_rate_stio">
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
												</div>
											</div>
										</div>
										<div class="footer-flex">
											<a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-view">View Detail</a>
										</div>
									</div>
								</div>
								
							</div>
						</div>
						<!-- End Single Property -->
						
					</div>
					
				</div>
			</section>
			<!-- ============================ Latest Property For Sale End ================================== -->
			
			<!-- ============================ Smart Testimonials ================================== -->
			<section class="image-cover" style="background:#122947 url(<?php echo esc_url( murailles_img( 'pattern.png' ) ); ?>) no-repeat;">
				<div class="container">
				
					<div class="row justify-content-center">
						<div class="col-lg-7 col-md-8">
							<div class="sec-heading center light">
								<h2>Good Reviews By Clients</h2>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
							</div>
						</div>
					</div>
					
					<div class="row justify-content-center">
						<div class="col-lg-8 col-md-8">
							<div class="modern-testimonial">
								
								<!-- Single Items -->
								<div class="single_items">
									<div class="_smart_testimons">
										<div class="_smart_testimons_thumb">
											<img src="<?php echo esc_url( murailles_img( 'user-1.jpg' ) ); ?>" class="img-fluid" alt="">
											<span class="tes_quote"><i class="fa fa-quote-left"></i></span>
										</div>
										<div class="facts-detail">
											<p>Faucibus tristique felis potenti ultrices ornare rhoncus semper hac facilisi Rutrum tellus lorem sem velit nisi non pharetra in dui.</p>
										</div>
										<div class="_smart_testimons_info">
											<h5>Lily Warliags</h5>
											<div class="_ovr_posts"><span>CEO, Leader</span></div>
										</div>
									</div>
								</div>
								
								<!-- Single Items -->
								<div class="single_items">
									<div class="_smart_testimons">
										<div class="_smart_testimons_thumb">
											<img src="<?php echo esc_url( murailles_img( 'user-2.jpg' ) ); ?>" class="img-fluid" alt="">
											<span class="tes_quote"><i class="fa fa-quote-left"></i></span>
										</div>
										<div class="facts-detail">
											<p>Faucibus tristique felis potenti ultrices ornare rhoncus semper hac facilisi Rutrum tellus lorem sem velit nisi non pharetra in dui.</p>
										</div>
										<div class="_smart_testimons_info">
											<h5>Carol B. Halton</h5>
											<div class="_ovr_posts"><span>CEO, Leader</span></div>
										</div>
									</div>
								</div>
								
								<!-- Single Items -->
								<div class="single_items">
									<div class="_smart_testimons">
										<div class="_smart_testimons_thumb">
											<img src="<?php echo esc_url( murailles_img( 'user-3.jpg' ) ); ?>" class="img-fluid" alt="">
											<span class="tes_quote"><i class="fa fa-quote-left"></i></span>
										</div>
										<div class="facts-detail">
											<p>Faucibus tristique felis potenti ultrices ornare rhoncus semper hac facilisi Rutrum tellus lorem sem velit nisi non pharetra in dui.</p>
										</div>
										<div class="_smart_testimons_info">
											<h5>Jesse L. Westberg</h5>
											<div class="_ovr_posts"><span>CEO, Leader</span></div>
										</div>
									</div>
								</div>
								
								<!-- Single Items -->
								<div class="single_items">
									<div class="_smart_testimons">
										<div class="_smart_testimons_thumb">
											<img src="<?php echo esc_url( murailles_img( 'user-4.jpg' ) ); ?>" class="img-fluid" alt="">
											<span class="tes_quote"><i class="fa fa-quote-left"></i></span>
										</div>
										<div class="facts-detail">
											<p>Faucibus tristique felis potenti ultrices ornare rhoncus semper hac facilisi Rutrum tellus lorem sem velit nisi non pharetra in dui.</p>
										</div>
										<div class="_smart_testimons_info">
											<h5>Elmer N. Rodriguez</h5>
											<div class="_ovr_posts"><span>CEO, Leader</span></div>
										</div>
									</div>
								</div>
								
								<!-- Single Items -->
								<div class="single_items">
									<div class="_smart_testimons">
										<div class="_smart_testimons_thumb">
											<img src="<?php echo esc_url( murailles_img( 'user-5.jpg' ) ); ?>" class="img-fluid" alt="">
											<span class="tes_quote"><i class="fa fa-quote-left"></i></span>
										</div>
										<div class="facts-detail">
											<p>Faucibus tristique felis potenti ultrices ornare rhoncus semper hac facilisi Rutrum tellus lorem sem velit nisi non pharetra in dui.</p>
										</div>
										<div class="_smart_testimons_info">
											<h5>Heather R. Sirianni</h5>
											<div class="_ovr_posts"><span>CEO, Leader</span></div>
										</div>
									</div>
								</div>
								
							</div>
						</div>
					</div>
					
				</div>
			</section>
			<!-- ============================ Smart Testimonials End ================================== -->
			
			<!-- ============================ List Tag Start ================================== -->
			<section>
				<div class="container">
					<div class="row align-items-center justify-content-between">
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
							<div class="eplios_tags">
								<div class="tags-1">01</div>
								<h2 class="mb-4">Search & Find Perfect Place</h2>
								<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.</p>
								<ul class="eplios_list mt-5">
									<li>100% Money Gaurantee</li>
									<li>Super & Perfect Place</li>
									<li>Effective & Best Price</li>
									<li>Friendly & Lovely Area</li>
								</ul>
							</div>
						</div>
						
						<div class="col-xl-5 col-lg-5 col-md-6 col-sm-12">
							<div class="text-center">
								<img src="<?php echo esc_url( murailles_img( 'verified.svg' ) ); ?>" class="img-fluid" alt="" />
							</div>
						</div>
						
					</div>
				</div>
			</section>
			<!-- ============================ Property Tag End ================================== -->
			
			<!-- ============================ List Tag Start ================================== -->
			<section class="pt-0">
				<div class="container">
					<div class="row align-items-center justify-content-between">
					
						<div class="col-xl-5 col-lg-5 col-md-6 col-sm-12">
							<div class="text-center">
								<img src="<?php echo esc_url( murailles_img( 'b-1.jpg' ) ); ?>" class="img-fluid" alt="" />
							</div>
						</div>
						
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
							<div class="eplios_tags right">
								<div class="tags-2">02</div>
								<h2 class="mb-4">Meet Agents & Fixed Your Deal</h2>
								<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.</p>
								<a href="#" class="btn exliou btn-danger mt-5">Find Properties</a>
							</div>
						</div>
						
					</div>
				</div>
			</section>
			<!-- ============================ Property Tag End ================================== -->
			
			<!-- ============================ Top Agents ================================== -->
			<section class="gray">
				<div class="container">
				
					<div class="row justify-content-center">
						<div class="col-lg-7 col-md-8">
							<div class="sec-heading center">
								<h2>Our Featured Agents</h2>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="item-slide space">
								
								<!-- Single Item -->
								<div class="single_items">
									<div class="grid_agents style-2 border-0">
										<div class="elio_mx_list bg-danger">20 Listings</div>
										<div class="grid_agents-wrap">
											
											<div class="fr-grid-thumb">
												<a href="<?php echo esc_url( home_url( '/agent-page/' ) ); ?>">
													<img src="<?php echo esc_url( murailles_img( 'team-1.jpg' ) ); ?>" class="img-fluid mx-auto" alt="">
												</a>
												<ul class="inline_social">
													<li><a href="#"><i class="ti-facebook"></i></a></li>
													<li><a href="#"><i class="ti-linkedin"></i></a></li>
													<li><a href="#"><i class="ti-instagram"></i></a></li>
													<li><a href="#"><i class="ti-twitter"></i></a></li>
												</ul>
											</div>
											
											<div class="fr-grid-deatil">
												<span><i class="ti-location-pin me-1"></i>3298 Sardis Station</span>
												<h5 class="fr-can-name fs-6"><a href="<?php echo esc_url( home_url( '/agent-page/' ) ); ?>">Fannie T. Dean</a></h5>
											</div>
											
											<div class="fr-infos-deatil">	
												<a href="#"  data-bs-toggle="modal" data-bs-target="#autho-message" class="btn btn-danger"><i class="fa fa-envelope me-2"></i>Message</a>
												<a href="#" class="btn btn-dark"><i class="fa fa-phone"></i></a>
											</div>
											
										</div>
										
									</div>
								</div>
								
								<!-- Single Item -->
								<div class="single_items">
									<div class="grid_agents style-2 border-0">
										<div class="elio_mx_list bg-danger">18 Listings</div>
										<div class="grid_agents-wrap">
											
											<div class="fr-grid-thumb">
												<a href="<?php echo esc_url( home_url( '/agent-page/' ) ); ?>">
													<img src="<?php echo esc_url( murailles_img( 'team-2.jpg' ) ); ?>" class="img-fluid mx-auto" alt="">
												</a>
												<ul class="inline_social">
													<li><a href="#"><i class="ti-facebook"></i></a></li>
													<li><a href="#"><i class="ti-linkedin"></i></a></li>
													<li><a href="#"><i class="ti-instagram"></i></a></li>
													<li><a href="#"><i class="ti-twitter"></i></a></li>
												</ul>
											</div>
											
											<div class="fr-grid-deatil">
												<span><i class="ti-location-pin me-1"></i>1700 Pursglove, USA</span>
												<h5 class="fr-can-name fs-6"><a href="<?php echo esc_url( home_url( '/agent-page/' ) ); ?>">Sylvia J. Church</a></h5>
											</div>
											
											<div class="fr-infos-deatil">	
												<a href="#"  data-bs-toggle="modal" data-bs-target="#autho-message" class="btn btn-danger"><i class="fa fa-envelope me-2"></i>Message</a>
												<a href="#" class="btn btn-dark"><i class="fa fa-phone"></i></a>
											</div>
											
										</div>
										
									</div>
								</div>
								
								<!-- Single Item -->
								<div class="single_items">
									<div class="grid_agents style-2 border-0">
										<div class="elio_mx_list bg-danger">30 Listings</div>
										<div class="grid_agents-wrap">
											
											<div class="fr-grid-thumb">
												<a href="<?php echo esc_url( home_url( '/agent-page/' ) ); ?>">
													<img src="<?php echo esc_url( murailles_img( 'team-3.jpg' ) ); ?>" class="img-fluid mx-auto" alt="">
												</a>
												<ul class="inline_social">
													<li><a href="#"><i class="ti-facebook"></i></a></li>
													<li><a href="#"><i class="ti-linkedin"></i></a></li>
													<li><a href="#"><i class="ti-instagram"></i></a></li>
													<li><a href="#"><i class="ti-twitter"></i></a></li>
												</ul>
											</div>
											
											<div class="fr-grid-deatil">
												<span><i class="ti-location-pin me-1"></i>188 Barrington Court</span>
												<h5 class="fr-can-name fs-6"><a href="<?php echo esc_url( home_url( '/agent-page/' ) ); ?>">Regina J. Stanhope</a></h5>
											</div>
											
											<div class="fr-infos-deatil">	
												<a href="#"  data-bs-toggle="modal" data-bs-target="#autho-message" class="btn btn-danger"><i class="fa fa-envelope me-2"></i>Message</a>
												<a href="#" class="btn btn-dark"><i class="fa fa-phone"></i></a>
											</div>
											
										</div>
										
									</div>
								</div>
								
								<!-- Single Item -->
								<div class="single_items">
									<div class="grid_agents style-2 border-0">
										<div class="elio_mx_list bg-danger">42 Listings</div>
										<div class="grid_agents-wrap">
											
											<div class="fr-grid-thumb">
												<a href="<?php echo esc_url( home_url( '/agent-page/' ) ); ?>">
													<img src="<?php echo esc_url( murailles_img( 'team-4.jpg' ) ); ?>" class="img-fluid mx-auto" alt="">
												</a>
												<ul class="inline_social">
													<li><a href="#"><i class="ti-facebook"></i></a></li>
													<li><a href="#"><i class="ti-linkedin"></i></a></li>
													<li><a href="#"><i class="ti-instagram"></i></a></li>
													<li><a href="#"><i class="ti-twitter"></i></a></li>
												</ul>
											</div>
											
											<div class="fr-grid-deatil">
												<span><i class="ti-location-pin me-1"></i>1548 Cimmaron Road</span>
												<h5 class="fr-can-name fs-6"><a href="<?php echo esc_url( home_url( '/agent-page/' ) ); ?>">Rose M. Bischof</a></h5>
											</div>
											
											<div class="fr-infos-deatil">	
												<a href="#"  data-bs-toggle="modal" data-bs-target="#autho-message" class="btn btn-danger"><i class="fa fa-envelope me-2"></i>Message</a>
												<a href="#" class="btn btn-dark"><i class="fa fa-phone"></i></a>
											</div>
											
										</div>
										
									</div>
								</div>
								
								<!-- Single Item -->
								<div class="single_items">
									<div class="grid_agents style-2 border-0">
										<div class="elio_mx_list bg-danger">17 Listings</div>
										<div class="grid_agents-wrap">
											
											<div class="fr-grid-thumb">
												<a href="<?php echo esc_url( home_url( '/agent-page/' ) ); ?>">
													<img src="<?php echo esc_url( murailles_img( 'team-5.jpg' ) ); ?>" class="img-fluid mx-auto" alt="">
												</a>
												<ul class="inline_social">
													<li><a href="#"><i class="ti-facebook"></i></a></li>
													<li><a href="#"><i class="ti-linkedin"></i></a></li>
													<li><a href="#"><i class="ti-instagram"></i></a></li>
													<li><a href="#"><i class="ti-twitter"></i></a></li>
												</ul>
											</div>
											
											<div class="fr-grid-deatil">
												<span><i class="ti-location-pin me-1"></i>Montreal, USA</span>
												<h5 class="fr-can-name fs-6"><a href="<?php echo esc_url( home_url( '/agent-page/' ) ); ?>">Lawanna K. Ruel</a></h5>
											</div>
											
											<div class="fr-infos-deatil">	
												<a href="#"  data-bs-toggle="modal" data-bs-target="#autho-message" class="btn btn-danger"><i class="fa fa-envelope me-2"></i>Message</a>
												<a href="#" class="btn btn-dark"><i class="fa fa-phone"></i></a>
											</div>
											
										</div>
										
									</div>
								</div>
							
							</div>
						</div>
					</div>
					
				</div>
			</section>
			<!-- ============================ Top Agents End ================================== -->
			
			<!-- ============================ Property Tag Start ================================== -->
			<section class="image-cover" style="background:#122947 url(<?php echo esc_url( murailles_img( 'banner-home.jpg' ) ); ?>) no-repeat;" data-overlay="2">
				<div class="container">
					<div class="row">
						<div class="col-xl-6 col-lg-6 col-md-8 col-sm-12">
							
							<div class="tab_exclusive position-relative z-1">
								<h2>Are You Searching Perfect Place For your Dream?</h2>
								<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi</p>
								<a href="#" class="btn exliou btn-danger">Find Properties</a>
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
								<h2>Latest News & Articles</h2>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
							</div>
						</div>
					</div>
					
					<div class="row justify-content-center g-4">
						
						<!-- Single blog Grid -->
						<div class="col-lg-4 col-md-6">
							<div class="grid_blog_box">
								
								<div class="gtid_blog_thumb">
									<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><img src="<?php echo esc_url( murailles_img( 'b-1.jpg' ) ); ?>" class="img-fluid" alt="" /></a>
									<div class="gtid_blog_info"><span>30</span>july 2021</div>
								</div>								
								
								<div class="blog-body">
									<h4 class="bl-title"><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">Creative Designs</a><span class="latest_new_post">New</span></h4>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod. </p>
								</div>
								
								<div class="modern_property_footer">
									<div class="property-author">
										<div class="path-img"><a href="<?php echo esc_url( home_url( '/agent-page/' ) ); ?>" tabindex="-1"><img src="<?php echo esc_url( murailles_img( 'user-1.jpg' ) ); ?>" class="img-fluid" alt=""></a></div>
										<h5><a href="<?php echo esc_url( home_url( '/agent-page/' ) ); ?>" tabindex="-1">Shaurya Preet</a></h5>
									</div>
									<span class="article-pulish-date"><i class="ti-comment-alt me-2"></i>202</span>
								</div>
								
							</div>
						</div>
						
						<!-- Single blog Grid -->
						<div class="col-lg-4 col-md-6">
							<div class="grid_blog_box">
								
								<div class="gtid_blog_thumb">
									<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><img src="<?php echo esc_url( murailles_img( 'b-5.jpg' ) ); ?>" class="img-fluid" alt="" /></a>
									<div class="gtid_blog_info"><span>12</span>Oct 2021</div>
								</div>								
								
								<div class="blog-body">
									<h4 class="bl-title"><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">UX/UI Developer</a><span class="latest_new_post hot">Hot</span></h4>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod. </p>
								</div>
								
								<div class="modern_property_footer">
									<div class="property-author">
										<div class="path-img"><a href="<?php echo esc_url( home_url( '/agent-page/' ) ); ?>" tabindex="-1"><img src="<?php echo esc_url( murailles_img( 'user-2.jpg' ) ); ?>" class="img-fluid" alt=""></a></div>
										<h5><a href="<?php echo esc_url( home_url( '/agent-page/' ) ); ?>" tabindex="-1">Nirgam Singh</a></h5>
									</div>
									<span class="article-pulish-date"><i class="ti-comment-alt me-2"></i>407</span>
								</div>
								
							</div>
						</div>
						
						<!-- Single blog Grid -->
						<div class="col-lg-4 col-md-6">
							<div class="grid_blog_box">
								
								<div class="gtid_blog_thumb">
									<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><img src="<?php echo esc_url( murailles_img( 'b-6.jpg' ) ); ?>" class="img-fluid" alt="" /></a>
									<div class="gtid_blog_info"><span>17</span>Nov 2021</div>
								</div>								
								
								<div class="blog-body">
									<h4 class="bl-title"><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">WordPress Developer & UI</a><span class="latest_new_post">New</span></h4>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod. </p>
								</div>
								
								<div class="modern_property_footer">
									<div class="property-author">
										<div class="path-img"><a href="<?php echo esc_url( home_url( '/agent-page/' ) ); ?>" tabindex="-1"><img src="<?php echo esc_url( murailles_img( 'user-3.jpg' ) ); ?>" class="img-fluid" alt=""></a></div>
										<h5><a href="<?php echo esc_url( home_url( '/agent-page/' ) ); ?>" tabindex="-1">Dhananjay Singh</a></h5>
									</div>
									<span class="article-pulish-date"><i class="ti-comment-alt me-2"></i>410</span>
								</div>
								
							</div>
						</div>
						
					</div>
					
				</div>
			</section>
			<div class="clearfix"></div>
			<!-- ============================ article End ================================== -->

<?php get_template_part( 'template-parts/call-to-action' ); ?>

<?php get_footer(); ?>
