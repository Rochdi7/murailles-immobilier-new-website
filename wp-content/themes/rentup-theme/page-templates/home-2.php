<?php
/**
 * Template Name: Home 2
 *
 * Auto-converted from home-2.html
 * Preserves exact original HTML markup, classes, and structure.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$murailles_header_style = 'transparent';
get_header();
?>

<!-- ============================ Hero Banner  Start================================== -->
			<div class="hero-banner vedio-banner">
				<div class="overlay"></div>	

				<video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
					<source src="<?php echo esc_url( murailles_img( 'banner-home.jpg' ) ); ?>" type="video/mp4">
				</video>
				
				<div class="container">
					
					<div class="row justify-content-center">
						<div class="col-xl-12 col-lg-12 col-md-12">
							<h1 class="big-header-capt mb-0 text-light">Search Your Next Home</h1>
							<p class="text-center mb-4 text-light">Find new & featured property located in your local city.</p>
						</div>
					</div>
					
					<div class="row">
						<div class="col-xl-12 col-lg-12 col-md-12">
							<div class="simple_tab_search center">
								<ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" id="buy-tab" data-bs-toggle="tab" href="#buy" role="tab" aria-controls="buy" aria-selected="true">Buy</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="sell-tab" data-bs-toggle="tab" href="#sell" role="tab" aria-controls="sell" aria-selected="false">Sell</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="rent-tab" data-bs-toggle="tab" href="#rent" role="tab" aria-controls="rent" aria-selected="false">Rent</a>
									</li>
								</ul>
								
								<div class="tab-content" id="myTabContent">
									
									<!-- Tab for Buy -->
									<div class="tab-pane fade show active" id="buy" role="tabpanel" aria-labelledby="buy-tab">
										<div class="full_search_box nexio_search lightanic_search hero_search-radius modern">
											<div class="search_hero_wrapping">
										
												<div class="row">
												
													<div class="col-lg-3 col-sm-12 d-md-none d-lg-block">
														<div class="form-group">
															<label>Price Range</label>
															<input type="text" class="form-control search_input border-0" placeholder="ex. Neighborhood" />
														</div>
													</div>
													
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
													
													<div class="col-lg-2 col-md-3 col-sm-12">
														<div class="form-group none">
															<a class="collapsed ad-search" data-bs-toggle="collapse" data-parent="#search" data-bs-target="#advance-search" href="javascript:void(0);" aria-expanded="false" aria-controls="advance-search"><i class="fa fa-sliders-h me-2"></i>Advance Filter</a>
														</div>
													</div>
													
													<div class="col-lg-2 col-md-3 col-sm-12 small-padd">
														<div class="form-group none">
															<a href="#" class="btn btn-danger full-width">Search Property</a>
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
									
									<!-- Tab for Sell -->
									<div class="tab-pane fade" id="sell" role="tabpanel" aria-labelledby="sell-tab">
										<div class="full_search_box nexio_search lightanic_search hero_search-radius modern">
											<div class="search_hero_wrapping">
										
												<div class="row">
												
													<div class="col-lg-3 col-sm-12 d-md-none d-lg-block">
														<div class="form-group">
															<label>Price Range</label>
															<input type="text" class="form-control search_input border-0" placeholder="ex. Neighborhood" />
														</div>
													</div>
													
													<div class="col-lg-3 col-md-3 col-sm-12">
														<div class="form-group">
															<label>City/Street</label>
															<div class="input-with-icon">
																<select id="lot-1" class="form-control">
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
																<select id="ptype-1" class="form-control">
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
													
													<div class="col-lg-2 col-md-3 col-sm-12">
														<div class="form-group none">
															<a class="collapsed ad-search" data-bs-toggle="collapse" data-parent="#search1" data-bs-target="#advance-search-1" href="javascript:void(0);" aria-expanded="false" aria-controls="advance-search"><i class="fa fa-sliders-h me-2"></i>Advance Filter</a>
														</div>
													</div>
													
													<div class="col-lg-2 col-md-3 col-sm-12 small-padd">
														<div class="form-group none">
															<a href="#" class="btn btn-danger full-width">Search Property</a>
														</div>
													</div>
												</div>
												
												<!-- Collapse Advance Search Form -->
												<div class="collapse" id="advance-search-1" aria-expanded="false" role="banner">
													
													<!-- row -->
													<div class="row">
													
														<div class="col-lg-3 col-md-6 col-sm-6">
															<div class="form-group none style-auto">
																<select id="bedrooms1" class="form-control">
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
																<select id="bathrooms1" class="form-control">
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
																	<input id="a-1a" class="form-check-input" name="a-1a" type="checkbox">
																	<label for="a-1a" class="form-check-label">Air Condition</label>
																</li>
																<li>
																	<input id="a-2b" class="form-check-input" name="a-2b" type="checkbox">
																	<label for="a-2b" class="form-check-label">Bedding</label>
																</li>
																<li>
																	<input id="a-3c" class="form-check-input" name="a-3c" type="checkbox">
																	<label for="a-3c" class="form-check-label">Heating</label>
																</li>
																<li>
																	<input id="a-4d" class="form-check-input" name="a-4d" type="checkbox">
																	<label for="a-4d" class="form-check-label">Internet</label>
																</li>
																<li>
																	<input id="a-5e" class="form-check-input" name="a-5e" type="checkbox">
																	<label for="a-5e" class="form-check-label">Microwave</label>
																</li>
																<li>
																	<input id="a-6f" class="form-check-input" name="a-6f" type="checkbox">
																	<label for="a-6f" class="form-check-label">Smoking Allow</label>
																</li>
																<li>
																	<input id="a-7g" class="form-check-input" name="a-7g" type="checkbox">
																	<label for="a-7g" class="form-check-label">Terrace</label>
																</li>
																<li>
																	<input id="a-8h" class="form-check-input" name="a-8h" type="checkbox">
																	<label for="a-8h" class="form-check-label">Balcony</label>
																</li>
																<li>
																	<input id="a-9i" class="form-check-input" name="a-9i" type="checkbox">
																	<label for="a-9i" class="form-check-label">Icon</label>
																</li>
																<li>
																	<input id="a-10j" class="form-check-input" name="a-10j" type="checkbox">
																	<label for="a-10j" class="form-check-label">Wi-Fi</label>
																</li>
																<li>
																	<input id="a-11k" class="form-check-input" name="a-11k" type="checkbox">
																	<label for="a-11k" class="form-check-label">Beach</label>
																</li>
																<li>
																	<input id="a-12l" class="form-check-input" name="a-12l" type="checkbox">
																	<label for="a-12l" class="form-check-label">Parking</label>
																</li>
															</ul>
														</div>
														
													</div>
													<!-- /row -->
													
												</div>
												
											</div>
										</div>

									</div>
									
									<!-- Tab for Rent -->
									<div class="tab-pane fade" id="rent" role="tabpanel" aria-labelledby="rent-tab">
										<div class="full_search_box nexio_search lightanic_search hero_search-radius modern">
											<div class="search_hero_wrapping">
										
												<div class="row">
												
													<div class="col-lg-3 col-sm-12 d-md-none d-lg-block">
														<div class="form-group">
															<label>Price Range</label>
															<input type="text" class="form-control search_input border-0" placeholder="ex. Neighborhood" />
														</div>
													</div>
													
													<div class="col-lg-3 col-md-3 col-sm-12">
														<div class="form-group">
															<label>City/Street</label>
															<div class="input-with-icon">
																<select id="lot-2" class="form-control">
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
																<select id="ptype-2" class="form-control">
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
													
													<div class="col-lg-2 col-md-3 col-sm-12">
														<div class="form-group none">
															<a class="collapsed ad-search" data-bs-toggle="collapse" data-parent="#search" data-bs-target="#advance-search-2" href="javascript:void(0);" aria-expanded="false" aria-controls="advance-search"><i class="fa fa-sliders-h me-2"></i>Advance Filter</a>
														</div>
													</div>
													
													<div class="col-lg-2 col-md-3 col-sm-12 small-padd">
														<div class="form-group none">
															<a href="#" class="btn btn-danger full-width">Search Property</a>
														</div>
													</div>
												</div>
												
												<!-- Collapse Advance Search Form -->
												<div class="collapse" id="advance-search-2" aria-expanded="false" role="banner">
													
													<!-- row -->
													<div class="row">
													
														<div class="col-lg-3 col-md-6 col-sm-6">
															<div class="form-group none style-auto">
																<select id="bedrooms2" class="form-control">
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
																<select id="bathrooms2" class="form-control">
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
																	<input id="a-a1" class="form-check-input" name="a-a1" type="checkbox">
																	<label for="a-a1" class="form-check-label">Air Condition</label>
																</li>
																<li>
																	<input id="a-b2" class="form-check-input" name="a-b2" type="checkbox">
																	<label for="a-b2" class="form-check-label">Bedding</label>
																</li>
																<li>
																	<input id="a-c3" class="form-check-input" name="a-c3" type="checkbox">
																	<label for="a-c3" class="form-check-label">Heating</label>
																</li>
																<li>
																	<input id="a-d4" class="form-check-input" name="a-d4" type="checkbox">
																	<label for="a-d4" class="form-check-label">Internet</label>
																</li>
																<li>
																	<input id="a-e5" class="form-check-input" name="a-e5" type="checkbox">
																	<label for="a-e5" class="form-check-label">Microwave</label>
																</li>
																<li>
																	<input id="a-f6" class="form-check-input" name="a-f6" type="checkbox">
																	<label for="a-f6" class="form-check-label">Smoking Allow</label>
																</li>
																<li>
																	<input id="a-g7" class="form-check-input" name="a-g7" type="checkbox">
																	<label for="a-g7" class="form-check-label">Terrace</label>
																</li>
																<li>
																	<input id="a-h8" class="form-check-input" name="a-h8" type="checkbox">
																	<label for="a-h8" class="form-check-label">Balcony</label>
																</li>
																<li>
																	<input id="a-i9" class="form-check-input" name="a-i9" type="checkbox">
																	<label for="a-i9" class="form-check-label">Icon</label>
																</li>
																<li>
																	<input id="a-j10" class="form-check-input" name="a-j10" type="checkbox">
																	<label for="a-j10" class="form-check-label">Wi-Fi</label>
																</li>
																<li>
																	<input id="a-k11" class="form-check-input" name="a-k11" type="checkbox">
																	<label for="a-k11" class="form-check-label">Beach</label>
																</li>
																<li>
																	<input id="a-l12" class="form-check-input" name="a-l12" type="checkbox">
																	<label for="a-l12" class="form-check-label">Parking</label>
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
					</div>
				</div>
			</div>
			<!-- ============================ Hero Banner End ================================== -->
			
			<!-- ============================ Latest Property For Sale Start ================================== -->
			<section>
				<div class="container">
				
					<div class="row justify-content-center">
						<div class="col-lg-7 col-md-10 text-center">
							<div class="sec-heading center mb-4">
								<h2>Recent Listed Property</h2>
								<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores</p>
							</div>
						</div>
					</div>
					
					<div class="row justify-content-center g-4">
						
						<!-- Single Property -->
						<div class="col-lg-4 col-md-6 col-sm-12">
							<div class="property-listing property-2 h-100">
								
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
								
								<div class="listing-detail-wrapper">
									<div class="listing-short-detail-wrap">
										<div class="_card_list_flex mb-2">
											<div class="_card_flex_01">
												<span class="_list_blickes _netork">6 Network</span>
												<span class="_list_blickes types">Family</span>
											</div>
											<div class="_card_flex_last">
												<div class="prt_saveed_12lk">
													<label class="toggler toggler-danger"><input type="checkbox"><i class="ti-heart"></i></label>
												</div>
											</div>
										</div>
										<div class="_card_list_flex">
											<div class="_card_flex_01">
												<h4 class="listing-name verified"><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-link-detail">7012 Shine Sehu Street, Liverpool London, LC345AC</a></h4>
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
										<h6 class="listing-card-info-price mb-0 p-0">$7,000</h6>
									</div>
									<div class="footer-flex">
										<a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-view">View Detail</a>
									</div>
								</div>
								
							</div>
						</div>
						<!-- End Single Property -->
						
						<!-- Single Property -->
						<div class="col-lg-4 col-md-6 col-sm-12">
							<div class="property-listing property-2 h-100">
								
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
								
								<div class="listing-detail-wrapper">
									<div class="listing-short-detail-wrap">
										<div class="_card_list_flex mb-2">
											<div class="_card_flex_01">
												<span class="_list_blickes _netork">4 Network</span>
												<span class="_list_blickes types">Condos</span>
											</div>
											<div class="_card_flex_last">
												<div class="prt_saveed_12lk">
													<label class="toggler toggler-danger"><input type="checkbox"><i class="ti-heart"></i></label>
												</div>
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
											<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bed.svg' ) ); ?>" width="15" alt="" /></div>4 Beds
										</div>
										<div class="listing-card-info-icon">
											<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bathtub.svg' ) ); ?>" width="15" alt="" /></div>2 Bath
										</div>
										<div class="listing-card-info-icon">
											<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'move.svg' ) ); ?>" width="15" alt="" /></div>740 sqft
										</div>
									</div>
								</div>
								
								<div class="listing-detail-footer">
									<div class="footer-first">
										<h6 class="listing-card-info-price mb-0 p-0">$8,200</h6>
									</div>
									<div class="footer-flex">
										<a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-view">View Detail</a>
									</div>
								</div>
								
							</div>
						</div>
						<!-- End Single Property -->
						
						<!-- Single Property -->
						<div class="col-lg-4 col-md-6 col-sm-12">
							<div class="property-listing property-2 h-100">
								
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
								
								<div class="listing-detail-wrapper">
									<div class="listing-short-detail-wrap">
										<div class="_card_list_flex mb-2">
											<div class="_card_flex_01">
												<span class="_list_blickes _netork">5 Network</span>
												<span class="_list_blickes types">Offices</span>
											</div>
											<div class="_card_flex_last">
												<div class="prt_saveed_12lk">
													<label class="toggler toggler-danger"><input type="checkbox"><i class="ti-heart"></i></label>
												</div>
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
										<h6 class="listing-card-info-price mb-0 p-0">$9,500</h6>
									</div>
									<div class="footer-flex">
										<a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-view">View Detail</a>
									</div>
								</div>
								
							</div>
						</div>
						<!-- End Single Property -->
						
						<!-- Single Property -->
						<div class="col-lg-4 col-md-6 col-sm-12">
							<div class="property-listing property-2 h-100">
								
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
								
								<div class="listing-detail-wrapper">
									<div class="listing-short-detail-wrap">
										<div class="_card_list_flex mb-2">
											<div class="_card_flex_01">
												<span class="_list_blickes _netork">7 Network</span>
												<span class="_list_blickes types">Apartment</span>
											</div>
											<div class="_card_flex_last">
												<div class="prt_saveed_12lk">
													<label class="toggler toggler-danger"><input type="checkbox"><i class="ti-heart"></i></label>
												</div>
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
											<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bed.svg' ) ); ?>" width="15" alt="" /></div>4 Beds
										</div>
										<div class="listing-card-info-icon">
											<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bathtub.svg' ) ); ?>" width="15" alt="" /></div>2 Bath
										</div>
										<div class="listing-card-info-icon">
											<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'move.svg' ) ); ?>" width="15" alt="" /></div>920 sqft
										</div>
									</div>
								</div>
								
								<div class="listing-detail-footer">
									<div class="footer-first">
										<h6 class="listing-card-info-price mb-0 p-0">$10,400</h6>
									</div>
									<div class="footer-flex">
										<a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-view">View Detail</a>
									</div>
								</div>
								
							</div>
						</div>
						<!-- End Single Property -->
						
						<!-- Single Property -->
						<div class="col-lg-4 col-md-6 col-sm-12">
							<div class="property-listing property-2 h-100">
								
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
								
								<div class="listing-detail-wrapper">
									<div class="listing-short-detail-wrap">
										<div class="_card_list_flex mb-2">
											<div class="_card_flex_01">
												<span class="_list_blickes _netork">7 Network</span>
												<span class="_list_blickes types">Villas</span>
											</div>
											<div class="_card_flex_last">
												<div class="prt_saveed_12lk">
													<label class="toggler toggler-danger"><input type="checkbox"><i class="ti-heart"></i></label>
												</div>
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
											<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bed.svg' ) ); ?>" width="15" alt="" /></div>4 Beds
										</div>
										<div class="listing-card-info-icon">
											<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'bathtub.svg' ) ); ?>" width="15" alt="" /></div>3 Bath
										</div>
										<div class="listing-card-info-icon">
											<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'move.svg' ) ); ?>" width="15" alt="" /></div>850 sqft
										</div>
									</div>
								</div>
								
								<div class="listing-detail-footer">
									<div class="footer-first">
										<h6 class="listing-card-info-price mb-0 p-0">$9,200</h6>
									</div>
									<div class="footer-flex">
										<a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-view">View Detail</a>
									</div>
								</div>
								
							</div>
						</div>
						<!-- End Single Property -->
						
						<!-- Single Property -->
						<div class="col-lg-4 col-md-6 col-sm-12">
							<div class="property-listing property-2 h-100">
								
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
								
								<div class="listing-detail-wrapper">
									<div class="listing-short-detail-wrap">
										<div class="_card_list_flex mb-2">
											<div class="_card_flex_01">
												<span class="_list_blickes _netork">10 Network</span>
												<span class="_list_blickes types">Family</span>
											</div>
											<div class="_card_flex_last">
												<div class="prt_saveed_12lk">
													<label class="toggler toggler-danger"><input type="checkbox"><i class="ti-heart"></i></label>
												</div>
											</div>
										</div>
										<div class="_card_list_flex">
											<div class="_card_flex_01">
												<h4 class="listing-name verified"><a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-link-detail">7264 Green Glelcer Street, Barghimbar USA, ERIO098</a></h4>
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
											<div class="inc-fleat-icon"><img src="<?php echo esc_url( murailles_img( 'move.svg' ) ); ?>" width="15" alt="" /></div>750 sqft
										</div>
									</div>
								</div>
								
								<div class="listing-detail-footer">
									<div class="footer-first">
										<h6 class="listing-card-info-price mb-0 p-0">$9,100</h6>
									</div>
									<div class="footer-flex">
										<a href="<?php echo esc_url( home_url( '/single-property-1/' ) ); ?>" class="prt-view">View Detail</a>
									</div>
								</div>
								
							</div>
						</div>
						<!-- End Single Property -->
						
					</div>
					
					<!-- Pagination -->
					<div class="row mt-5">
						<div class="col-lg-12 col-md-12 col-sm-12 text-center">
							<a href="<?php echo esc_url( home_url( '/list-layout-with-map/' ) ); ?>" class="btn btn-light-danger">Explore More Properties</a>
						</div>
					</div>
					
				</div>
			</section>
			<!-- ============================ Latest Property For Sale End ================================== -->
			
			<!-- ============================ Top Agents ================================== -->
			<section class="gray-simple min">
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
									<div class="grid_agents">
										<div class="elio_mx_list theme-bg-2">102 Listings</div>
										<div class="grid_agents-wrap">
											
											<div class="fr-grid-thumb">
												<a href="<?php echo esc_url( home_url( '/agent-page/' ) ); ?>">
													<span class="verified"><img src="<?php echo esc_url( murailles_img( 'verified.svg' ) ); ?>" class="verify mx-auto" alt=""></span>
													<img src="<?php echo esc_url( murailles_img( 'team-1.jpg' ) ); ?>" class="img-fluid mx-auto" alt="">
												</a>
											</div>
											
											<div class="fr-grid-deatil">
												<span><i class="ti-location-pin me-1"></i>Montreal, USA</span>
												<h5 class="fr-can-name"><a href="<?php echo esc_url( home_url( '/agent-page/' ) ); ?>">Adam K. Jollio</a></h5>
												<ul class="inline_social mt-4">
													<li><a href="#" class="fb"><i class="ti-facebook"></i></a></li>
													<li><a href="#" class="ln"><i class="ti-linkedin"></i></a></li>
													<li><a href="#" class="ins"><i class="ti-instagram"></i></a></li>
													<li><a href="#" class="tw"><i class="ti-twitter"></i></a></li>
												</ul>
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
									<div class="grid_agents">
										<div class="elio_mx_list theme-bg-2">72 Listings</div>
										<div class="grid_agents-wrap">
											
											<div class="fr-grid-thumb">
												<a href="<?php echo esc_url( home_url( '/agent-page/' ) ); ?>">
													<span class="verified"><img src="<?php echo esc_url( murailles_img( 'verified.svg' ) ); ?>" class="verify mx-auto" alt=""></span>
													<img src="<?php echo esc_url( murailles_img( 'team-2.jpg' ) ); ?>" class="img-fluid mx-auto" alt="">
												</a>
											</div>
											
											<div class="fr-grid-deatil">
												<span><i class="ti-location-pin me-1"></i>Liverpool, Canada</span>
												<h5 class="fr-can-name"><a href="<?php echo esc_url( home_url( '/agent-page/' ) ); ?>">Sargam S. Singh</a></h5>
												<ul class="inline_social mt-4">
													<li><a href="#" class="fb"><i class="ti-facebook"></i></a></li>
													<li><a href="#" class="ln"><i class="ti-linkedin"></i></a></li>
													<li><a href="#" class="ins"><i class="ti-instagram"></i></a></li>
													<li><a href="#" class="tw"><i class="ti-twitter"></i></a></li>
												</ul>
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
									<div class="grid_agents">
										<div class="elio_mx_list theme-bg-2">22 Listings</div>
										<div class="grid_agents-wrap">
											
											<div class="fr-grid-thumb">
												<a href="<?php echo esc_url( home_url( '/agent-page/' ) ); ?>">
													<span class="verified"><img src="<?php echo esc_url( murailles_img( 'verified.svg' ) ); ?>" class="verify mx-auto" alt=""></span>
													<img src="<?php echo esc_url( murailles_img( 'team-3.jpg' ) ); ?>" class="img-fluid mx-auto" alt="">
												</a>
											</div>
											
											<div class="fr-grid-deatil">
												<span><i class="ti-location-pin me-1"></i>Montreal, Canada</span>
												<h5 class="fr-can-name"><a href="<?php echo esc_url( home_url( '/agent-page/' ) ); ?>">Harijeet M. Siller</a></h5>
												<ul class="inline_social mt-4">
													<li><a href="#" class="fb"><i class="ti-facebook"></i></a></li>
													<li><a href="#" class="ln"><i class="ti-linkedin"></i></a></li>
													<li><a href="#" class="ins"><i class="ti-instagram"></i></a></li>
													<li><a href="#" class="tw"><i class="ti-twitter"></i></a></li>
												</ul>
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
									<div class="grid_agents">
										<div class="elio_mx_list theme-bg-2">50 Listings</div>
										<div class="grid_agents-wrap">
											
											<div class="fr-grid-thumb">
												<a href="<?php echo esc_url( home_url( '/agent-page/' ) ); ?>">
													<span class="verified"><img src="<?php echo esc_url( murailles_img( 'verified.svg' ) ); ?>" class="verify mx-auto" alt=""></span>
													<img src="<?php echo esc_url( murailles_img( 'team-4.jpg' ) ); ?>" class="img-fluid mx-auto" alt="">
												</a>
											</div>
											
											<div class="fr-grid-deatil">
												<span><i class="ti-location-pin me-1"></i>Denever, USA</span>
												<h5 class="fr-can-name"><a href="<?php echo esc_url( home_url( '/agent-page/' ) ); ?>">Anna K. Young</a></h5>
												<ul class="inline_social mt-4">
													<li><a href="#" class="fb"><i class="ti-facebook"></i></a></li>
													<li><a href="#" class="ln"><i class="ti-linkedin"></i></a></li>
													<li><a href="#" class="ins"><i class="ti-instagram"></i></a></li>
													<li><a href="#" class="tw"><i class="ti-twitter"></i></a></li>
												</ul>
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
									<div class="grid_agents">
										<div class="elio_mx_list theme-bg-2">42 Listings</div>
										<div class="grid_agents-wrap">
											
											<div class="fr-grid-thumb">
												<a href="<?php echo esc_url( home_url( '/agent-page/' ) ); ?>">
													<span class="verified"><img src="<?php echo esc_url( murailles_img( 'verified.svg' ) ); ?>" class="verify mx-auto" alt=""></span>
													<img src="<?php echo esc_url( murailles_img( 'team-5.jpg' ) ); ?>" class="img-fluid mx-auto" alt="">
												</a>
											</div>
											
											<div class="fr-grid-deatil">
												<span><i class="ti-location-pin me-1"></i>2272 Briarwood Drive</span>
												<h5 class="fr-can-name"><a href="<?php echo esc_url( home_url( '/agent-page/' ) ); ?>">Michael P. Grimaldo</a></h5>
												<ul class="inline_social mt-4">
													<li><a href="#" class="fb"><i class="ti-facebook"></i></a></li>
													<li><a href="#" class="ln"><i class="ti-linkedin"></i></a></li>
													<li><a href="#" class="ins"><i class="ti-instagram"></i></a></li>
													<li><a href="#" class="tw"><i class="ti-twitter"></i></a></li>
												</ul>
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
			
			<!-- ============================ Property Location ================================== -->
			<section>
				<div class="container">
				
					<div class="row justify-content-center">
						<div class="col-lg-7 col-md-8">
							<div class="sec-heading center">
								<h2>Explore By Location</h2>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
							</div>
						</div>
					</div>
					
					<div class="row justify-content-center g-4">
						
						<!-- Single Location -->
						<div class="col-lg-4 col-md-4 col-sm-6">
							<a href="<?php echo esc_url( home_url( '/grid-layout-with-sidebar/' ) ); ?>" class="img-wrap style-2">
									<div class="location_wrap_content visible">
										<div class="location_wrap_content_first">
											<h4>New Orleans, Louisiana</h4>
											<ul>
												<li><span>12 Villas</span></li>
												<li><span>10 Apartments</span></li>
												<li><span>07 Offices</span></li>
											</ul>
										</div>
									</div>
								<div class="img-wrap-background" style="background-image: url(<?php echo esc_url( murailles_img( 'city-3.png' ) ); ?>);"></div>
							</a>
						</div>
						
						<!-- Single Location -->
						<div class="col-lg-4 col-md-4 col-sm-6">
							<a href="<?php echo esc_url( home_url( '/grid-layout-with-sidebar/' ) ); ?>" class="img-wrap style-2">
									<div class="location_wrap_content visible">
										<div class="location_wrap_content_first">
											<h4>Jerrsy, United State</h4>
											<ul>
												<li><span>12 Villas</span></li>
												<li><span>10 Apartments</span></li>
												<li><span>07 Offices</span></li>
											</ul>
										</div>
									</div>
								<div class="img-wrap-background" style="background-image: url(<?php echo esc_url( murailles_img( 'city-3.png' ) ); ?>);"></div>
							</a>
						</div>
						
						<!-- Single Location -->
						<div class="col-lg-4 col-md-4 col-sm-6">
							<a href="<?php echo esc_url( home_url( '/grid-layout-with-sidebar/' ) ); ?>" class="img-wrap style-2">
									<div class="location_wrap_content visible">
										<div class="location_wrap_content_first">
											<h4>Liverpool, London</h4>
											<ul>
												<li><span>12 Villas</span></li>
												<li><span>10 Apartments</span></li>
												<li><span>07 Offices</span></li>
											</ul>
										</div>
									</div>
								<div class="img-wrap-background" style="background-image: url(<?php echo esc_url( murailles_img( 'city-3.png' ) ); ?>);"></div>
							</a>
						</div>
						
						<!-- Single Location -->
						<div class="col-lg-4 col-md-4 col-sm-6">
							<a href="<?php echo esc_url( home_url( '/grid-layout-with-sidebar/' ) ); ?>" class="img-wrap style-2">
									<div class="location_wrap_content visible">
										<div class="location_wrap_content_first">
											<h4>NewYork, United States</h4>
											<ul>
												<li><span>12 Villas</span></li>
												<li><span>10 Apartments</span></li>
												<li><span>07 Offices</span></li>
											</ul>
										</div>
									</div>
								<div class="img-wrap-background" style="background-image: url(<?php echo esc_url( murailles_img( 'city-4.png' ) ); ?>);"></div>
							</a>
						</div>
						
						<!-- Single Location -->
						<div class="col-lg-4 col-md-4 col-sm-6">
							<a href="<?php echo esc_url( home_url( '/grid-layout-with-sidebar/' ) ); ?>" class="img-wrap style-2">
									<div class="location_wrap_content visible">
										<div class="location_wrap_content_first">
											<h4>Montreal, Canada</h4>
											<ul>
												<li><span>12 Villas</span></li>
												<li><span>10 Apartments</span></li>
												<li><span>07 Offices</span></li>
											</ul>
										</div>
									</div>
								<div class="img-wrap-background" style="background-image: url(<?php echo esc_url( murailles_img( 'city-5.png' ) ); ?>);"></div>
							</a>
						</div>
						
						<!-- Single Location -->
						<div class="col-lg-4 col-md-4 col-sm-6">
							<a href="<?php echo esc_url( home_url( '/grid-layout-with-sidebar/' ) ); ?>" class="img-wrap style-2">
									<div class="location_wrap_content visible">
										<div class="location_wrap_content_first">
											<h4>California, USA</h4>
											<ul>
												<li><span>12 Villas</span></li>
												<li><span>10 Apartments</span></li>
												<li><span>07 Offices</span></li>
											</ul>
										</div>
									</div>
								<div class="img-wrap-background" style="background-image: url(<?php echo esc_url( murailles_img( 'city-7.png' ) ); ?>);"></div>
							</a>
						</div>
						
					</div>
					
				</div>
			</section>
			<!-- ============================ Property Location End ================================== -->
			
			<!-- ============================ Smart Testimonials ================================== -->
			<section class="image-cover" style="background:#0f161a url(<?php echo esc_url( murailles_img( 'pattern.png' ) ); ?>) no-repeat;">
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
			
			<!-- ============================ Our Partner Start ================================== -->
			<section class="bg-cover p-0" style="background:url(<?php echo esc_url( murailles_img( 'b-1.jpg' ) ); ?>)no-repeat;" data-overlay="3">
				<div class="ht-100"></div>
			</section>
			<section class="bg-cover" style="background:#a70a29 url(<?php echo esc_url( murailles_img( 'banner-home.jpg' ) ); ?>)no-repeat">
				<div class="container">
					
					<div class="row justify-content-center">
						<div class="col-lg-8 col-md-10 col-sm-12">
							<div class="reio_o9i text-center mb-5">
								<h2 class="text-light">Less work, meet our partner.</h2>
								<p class="text-light">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias</p>
							</div>
						</div>
					</div>
					
					<div class="row justify-content-center">
						<div class="col-lg-9 col-md-10 col-sm-12 flex-wrap justify-content-center text-center">
							<div class="pertner_flexio">
								<img src="<?php echo esc_url( murailles_img( 'c-1.png' ) ); ?>" class="img-fluid" alt="" />
								<h5>Google Inc</h5>
							</div>
							<div class="pertner_flexio">
								<img src="<?php echo esc_url( murailles_img( 'c-2.png' ) ); ?>" class="img-fluid" alt="" />
								<h5>Dribbbdio</h5>
							</div>
							<div class="pertner_flexio">
								<img src="<?php echo esc_url( murailles_img( 'c-3.png' ) ); ?>" class="img-fluid" alt="" />
								<h5>Lio Vission</h5>
							</div>
							<div class="pertner_flexio">
								<img src="<?php echo esc_url( murailles_img( 'c-4.png' ) ); ?>" class="img-fluid" alt="" />
								<h5>Alzerra</h5>
							</div>
							<div class="pertner_flexio">
								<img src="<?php echo esc_url( murailles_img( 'c-5.png' ) ); ?>" class="img-fluid" alt="" />
								<h5>Skyepio</h5>
							</div>
							<div class="pertner_flexio">
								<img src="<?php echo esc_url( murailles_img( 'c-5.png' ) ); ?>" class="img-fluid" alt="" />
								<h5>Twikller</h5>
							</div>
							<div class="pertner_flexio">
								<img src="<?php echo esc_url( murailles_img( 'c-5.png' ) ); ?>" class="img-fluid" alt="" />
								<h5>Sincherio</h5>
							</div>
						</div>
					</div>
					
				</div>
				<div class="ht-110"></div>
			</section>
			<!-- ============================ Our Partner End ================================== -->
			
			<!-- ============================ Price Table Start ================================== -->
			<section class="min">
				<div class="container">
				
					<div class="row justify-content-center">
						<div class="col-lg-7 col-md-10 text-center">
							<div class="sec-heading center">
								<h2>Select your Package</h2>
								<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores</p>
							</div>
						</div>
					</div>
					
					<div class="row align-items-center">
					
						<!-- Single Package -->
						<div class="col-lg-4 col-md-4">
							<div class="pricing_wrap">
								<div class="prt_head">
									<h4>Basic</h4>
								</div>
								<div class="prt_price">
									<h2><span>$</span>29</h2>
									<span>per user, per month</span>
								</div>
								<div class="prt_body">
									<ul>
										<li>99.5% Uptime Guarantee</li>
										<li>120GB CDN Bandwidth</li>
										<li>5GB Cloud Storage</li>
										<li class="none">Personal Help Support</li>
										<li class="none">Enterprise SLA</li>
									</ul>
								</div>
								<div class="prt_footer">
									<a href="#" class="btn choose_package">Start Basic</a>
								</div>
							</div>
						</div>
						
						<!-- Single Package -->
						<div class="col-lg-4 col-md-4">
							<div class="pricing_wrap">
								<div class="prt_head">
									<div class="recommended">Best Value</div>
									<h4>Standard</h4>
								</div>
								<div class="prt_price">
									<h2><span>$</span>49</h2>
									<span>per user, per month</span>
								</div>
								<div class="prt_body">
									<ul>
										<li>99.5% Uptime Guarantee</li>
										<li>150GB CDN Bandwidth</li>
										<li>10GB Cloud Storage</li>
										<li>Personal Help Support</li>
										<li class="none">Enterprise SLA</li>
									</ul>
								</div>
								<div class="prt_footer">
									<a href="#" class="btn choose_package active">Start Standard</a>
								</div>
							</div>
						</div>
						
						<!-- Single Package -->
						<div class="col-lg-4 col-md-4">
							<div class="pricing_wrap">
								<div class="prt_head">
									<h4>Platinum</h4>
								</div>
								<div class="prt_price">
									<h2><span>$</span>79</h2>
									<span>2 user, per month</span>
								</div>
								<div class="prt_body">
									<ul>
										<li>100% Uptime Guarantee</li>
										<li>200GB CDN Bandwidth</li>
										<li>20GB Cloud Storage</li>
										<li>Personal Help Support</li>
										<li>Enterprise SLA</li>
									</ul>
								</div>
								<div class="prt_footer">
									<a href="#" class="btn choose_package">Start Platinum</a>
								</div>
							</div>
						</div>
						
					</div>
					
				</div>	
			</section>
			<!-- ============================ Price Table End ================================== -->

<?php get_template_part( 'template-parts/call-to-action' ); ?>

<?php get_footer(); ?>
