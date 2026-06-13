<?php
/**
 * Template Name: Half Map
 *
 * Auto-converted from half-map.html
 * Preserves exact original HTML markup, classes, and structure.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();
?>

<!-- ============================ Hero Banner  Start================================== -->
			<div class="home-map-banner half-map">
				
				<div class="fs-left-map-box">
					<div class="home-map fl-wrap">
						<div class="hm-map-container fw-map">
							<div id="map"></div>
						</div>
					</div>
				</div>
				
				<div class="fs-inner-container">
					<div class="fs-content">
					
						<div class="row">
							<div class="col-lg-12 col-md-12">
								<div class="_mp_filter mb-3">
									<div class="_mp_filter_first">
										<h4>Where to Say?</h4>
										<div class="input-group">
										  <input type="text" class="form-control" placeholder="Neighborhood, City etc.">
											<div class="input-group-append">
												<button type="submit" class="input-group-text"><i class="fas fa-search"></i></submit>
											</div>
										</div>
									</div>
									<div class="_mp_filter_last">
										<a class="map_filter" data-bs-toggle="collapse" href="#filtermap" role="button" aria-expanded="false" aria-controls="filtermap"><i class="fa fa-sliders-h me-2"></i>Filter</a>
									</div>
								</div>
							</div>
							<div class="col-lg-12 col-md-12 mt-4">
								<div class="collapse" id="filtermap">
									<div class="row">
							
										<div class="col-lg-6 col-md-6 col-sm-12">
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
										</div>
											
										<div class="col-lg-6 col-md-6 col-sm-12">
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
										</div>
										
										<div class="col-lg-6 col-md-6 col-sm-12">
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
										</div>
										
										<div class="col-lg-6 col-md-6 col-sm-12">
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
										
										<div class="col-lg-12 col-md-12 col-sm-12 pt-4 pb-4">
											<h6>Choose Price</h6>
											<div class="rg-slider">
												 <input type="text" class="js-range-slider" name="my_range" value="" />
											</div>
										</div>
										
										<div class="col-lg-12 col-md-12 col-sm-12">
											<h6>Advance Features</h6>
											<ul class="row p-0 m-0">
												<li class="col-xl-4 col-lg-6 col-md-6 p-0">
													<input id="a-1" class="form-check-input" name="a-1" type="checkbox">
													<label for="a-1" class="form-check-label">Air Condition</label>
												</li>
												<li class="col-xl-4 col-lg-6 col-md-6 p-0">
													<input id="a-2" class="form-check-input" name="a-2" type="checkbox">
													<label for="a-2" class="form-check-label">Bedding</label>
												</li>
												<li class="col-xl-4 col-lg-6 col-md-6 p-0">
													<input id="a-3" class="form-check-input" name="a-3" type="checkbox">
													<label for="a-3" class="form-check-label">Heating</label>
												</li>
												<li class="col-xl-4 col-lg-6 col-md-6 p-0">
													<input id="a-4" class="form-check-input" name="a-4" type="checkbox">
													<label for="a-4" class="form-check-label">Internet</label>
												</li>
												<li class="col-xl-4 col-lg-6 col-md-6 p-0">
													<input id="a-5" class="form-check-input" name="a-5" type="checkbox">
													<label for="a-5" class="form-check-label">Microwave</label>
												</li>
												<li class="col-xl-4 col-lg-6 col-md-6 p-0">
													<input id="a-6" class="form-check-input" name="a-6" type="checkbox">
													<label for="a-6" class="form-check-label">Smoking Allow</label>
												</li>
												<li class="col-xl-4 col-lg-6 col-md-6 p-0">
													<input id="a-7" class="form-check-input" name="a-7" type="checkbox">
													<label for="a-7" class="form-check-label">Terrace</label>
												</li>
												<li class="col-xl-4 col-lg-6 col-md-6 p-0">
													<input id="a-8" class="form-check-input" name="a-8" type="checkbox">
													<label for="a-8" class="form-check-label">Balcony</label>
												</li>
												<li class="col-xl-4 col-lg-6 col-md-6 p-0">
													<input id="a-9" class="form-check-input" name="a-9" type="checkbox">
													<label for="a-9" class="form-check-label">Icon</label>
												</li>
											</ul>
										</div>
										
										<div class="col-lg-12 col-md-12 col-sm-12 mb-4 mt-4">
											<div class="elgio_filter">
												<div class="elgio_ft_first">
													<button class="btn elgio_reset">
														Reset<span class="reset_counter">0</span>
													</button>
												</div>
												<div class="elgio_ft_last">
													<button class="btn btn-dark me-2">Cancel</button>
													<button class="btn btn-danger me-2">See 76 Properties</button>
												</div>
											</div>
										</div>
									
									</div>
								</div>
							</div>
						</div>
						
						<!--- All List -->
						<div class="row g-4">
							
							<!-- Single Property -->
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
								<div class="property-listing list_view">
									
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
														<h6 class="listing-card-info-price text-seegreen mb-0">$7,000</h6>
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
													<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bed.svg' ) ); ?>" width="15" alt="" /></div>3 Beds
												</div>
												<div class="listing-card-info-icon">
													<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bathtub.svg' ) ); ?>" width="15" alt="" /></div>1 Bath
												</div>
												<div class="listing-card-info-icon">
													<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'move.svg' ) ); ?>" width="15" alt="" /></div>800 sqft
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
												<a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-view bg-danger">View Detail</a>
											</div>
										</div>
									</div>
									
								</div>
							</div>
							<!-- End Single Property -->
							
							<!-- Single Property -->
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
								<div class="property-listing list_view">
									
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
														<h6 class="listing-card-info-price text-seegreen mb-0">$10,500</h6>
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
													<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bed.svg' ) ); ?>" width="15" alt="" /></div>4 Beds
												</div>
												<div class="listing-card-info-icon">
													<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bathtub.svg' ) ); ?>" width="15" alt="" /></div>2 Bath
												</div>
												<div class="listing-card-info-icon">
													<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'move.svg' ) ); ?>" width="15" alt="" /></div>1000 sqft
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
												<a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-view bg-danger">View Detail</a>
											</div>
										</div>
									</div>
									
								</div>
							</div>
							<!-- End Single Property -->
							
							<!-- Single Property -->
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
								<div class="property-listing list_view">
									
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
														<span class="_list_blickes types">Apartment</span>
													</div>
													<div class="_card_flex_last">
														<h6 class="listing-card-info-price text-seegreen mb-0">$8,700</h6>
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
													<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bed.svg' ) ); ?>" width="15" alt="" /></div>5 Beds
												</div>
												<div class="listing-card-info-icon">
													<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bathtub.svg' ) ); ?>" width="15" alt="" /></div>2 Bath
												</div>
												<div class="listing-card-info-icon">
													<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'move.svg' ) ); ?>" width="15" alt="" /></div>900 sqft
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
												<a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-view bg-danger">View Detail</a>
											</div>
										</div>
									</div>
									
								</div>
							</div>
							<!-- End Single Property -->
							
							<!-- Single Property -->
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
								<div class="property-listing list_view">
									
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
														<h6 class="listing-card-info-price text-seegreen mb-0">$9,100</h6>
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
													<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bed.svg' ) ); ?>" width="15" alt="" /></div>5 Beds
												</div>
												<div class="listing-card-info-icon">
													<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bathtub.svg' ) ); ?>" width="15" alt="" /></div>2 Bath
												</div>
												<div class="listing-card-info-icon">
													<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'move.svg' ) ); ?>" width="15" alt="" /></div>900 sqft
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
												<a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-view bg-danger">View Detail</a>
											</div>
										</div>
									</div>
									
								</div>
							</div>
							<!-- End Single Property -->
							
							<!-- Single Property -->
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
								<div class="property-listing list_view">
									
									<div class="listing-img-wrapper">
										<div class="_exlio_125">For Sale</div>
										<div class="list-img-slide">
											<div class="click">
												<div><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>"><img src="<?php echo esc_url( murailles_img( 'p-13.png' ) ); ?>" class="img-fluid mx-auto" alt="" /></a></div>
												<div><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>"><img src="<?php echo esc_url( murailles_img( 'p-5.png' ) ); ?>" class="img-fluid mx-auto" alt="" /></a></div>
												<div><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>"><img src="<?php echo esc_url( murailles_img( 'p-15.png' ) ); ?>" class="img-fluid mx-auto" alt="" /></a></div>
											</div>
										</div>
									</div>
									
									<div class="list_view_flex">
									
										<div class="listing-detail-wrapper mt-1">
											<div class="listing-short-detail-wrap">
												<div class="_card_list_flex mb-2">
													<div class="_card_flex_01">
														<span class="_list_blickes _netork">4 Network</span>
														<span class="_list_blickes types">Offices</span>
													</div>
													<div class="_card_flex_last">
														<h6 class="listing-card-info-price text-seegreen mb-0">$7,400</h6>
													</div>
												</div>
												<div class="_card_list_flex">
													<div class="_card_flex_01">
														<h4 class="listing-name verified"><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-link-detail">5629 Rani Market Near Saaket, Henever Canada, QWUI98</a></h4>
													</div>
												</div>
											</div>
										</div>
										
										<div class="price-features-wrapper">
											<div class="list-fx-features">
												<div class="listing-card-info-icon">
													<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bed.svg' ) ); ?>" width="15" alt="" /></div>4 Beds
												</div>
												<div class="listing-card-info-icon">
													<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bathtub.svg' ) ); ?>" width="15" alt="" /></div>2 Bath
												</div>
												<div class="listing-card-info-icon">
													<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'move.svg' ) ); ?>" width="15" alt="" /></div>810 sqft
												</div>
											</div>
										</div>
										
										<div class="listing-detail-footer">
											<div class="footer-first">
												<div class="foot-rates">
													<span class="elio_rate good">4.5</span>
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
												<a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-view bg-danger">View Detail</a>
											</div>
										</div>
									</div>
									
								</div>
							</div>
							<!-- End Single Property -->
							
							<!-- Single Property -->
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
								<div class="property-listing list_view">
									
									<div class="listing-img-wrapper">
										<div class="_exlio_125">For Rent</div>
										<div class="list-img-slide">
											<div class="click">
												<div><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>"><img src="<?php echo esc_url( murailles_img( 'p-16.png' ) ); ?>" class="img-fluid mx-auto" alt="" /></a></div>
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
														<span class="_list_blickes _netork">4 Network</span>
														<span class="_list_blickes types">Apartment</span>
													</div>
													<div class="_card_flex_last">
														<h6 class="listing-card-info-price text-seegreen mb-0">$9,700</h6>
													</div>
												</div>
												<div class="_card_list_flex">
													<div class="_card_flex_01">
														<h4 class="listing-name verified"><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-link-detail">3297 Rani Market Near Saaket, Henever Canada, QWUI98</a></h4>
													</div>
												</div>
											</div>
										</div>
										
										<div class="price-features-wrapper">
											<div class="list-fx-features">
												<div class="listing-card-info-icon">
													<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bed.svg' ) ); ?>" width="15" alt="" /></div>6 Beds
												</div>
												<div class="listing-card-info-icon">
													<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bathtub.svg' ) ); ?>" width="15" alt="" /></div>3 Bath
												</div>
												<div class="listing-card-info-icon">
													<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'move.svg' ) ); ?>" width="15" alt="" /></div>1200 sqft
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
												<a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-view bg-danger">View Detail</a>
											</div>
										</div>
									</div>
									
								</div>
							</div>
							<!-- End Single Property -->
							
							<!-- Load More button -->
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 my-4 text-center">
								<button type="button" class="btn btn-light-danger fw-medium px-5">Load More...</button>
							</div>
							
						</div>
						
					</div>
				</div>
				
			</div>
			<div class="clearfix"></div>
			<!-- ============================ Hero Banner End ================================== -->
			
			<!-- ============================ Footer Start ================================== -->

<?php murailles_render_page_builder_content(); ?>

<?php get_footer(); ?>
