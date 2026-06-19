<?php
/**
 * Template Name: Home 3
 *
 * Auto-converted from home-3.html
 * Preserves exact original HTML markup, classes, and structure.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$murailles_header_style = 'transparent';
get_header();
?>

<!-- ============================ Hero Banner  Start================================== -->
			<div class="image-cover hero_banner" style="background:url(<?php echo esc_url( murailles_img( 'banner-home.jpg' ) ); ?>) no-repeat;" data-overlay="5">
				<div class="container">
					
					<h1 class="big-header-capt mb-0">Search Your Next Home</h1>
					<p class="text-center mb-4">Find new & featured property located in your local city.</p>
					<!-- Type -->
					<div class="row justify-content-center">
						<div class="col-xl-10 col-lg-12 col-md-12">
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
										
										<div class="col-lg-3 col-md-4 col-sm-12">
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
										
										<div class="col-lg-1 col-md-2 col-sm-12 small-padd">
											<div class="form-group none">
												<a href="#" class="btn btn-danger full-width"><i class="fa fa-search"></i></a>
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
			
			<!-- ============================ Recent Property Start ================================== -->
			<section>
				<div class="container">
					
					<div class="row justify-content-center">
						<div class="col-lg-7 col-md-8">
							<div class="sec-heading center">
								<h2>Recent Property Listed</h2>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
							</div>
						</div>
					</div>
					
					<div class="row justify-content-center g-4">
						
						<!-- Single Property -->
						<div class="col-lg-4 col-md-6 col-sm-12">
							<div class="property-listing property-2 h-100">
								
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
						<div class="col-lg-4 col-md-6 col-sm-12">
							<div class="property-listing property-2 h-100">
								
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
						<div class="col-lg-4 col-md-6 col-sm-12">
							<div class="property-listing property-2 h-100">
								
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
						<div class="col-lg-4 col-md-6 col-sm-12">
							<div class="property-listing property-2 h-100">
								
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
						<div class="col-lg-4 col-md-6 col-sm-12">
							<div class="property-listing property-2 h-100">
								
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
						<div class="col-lg-4 col-md-6 col-sm-12">
							<div class="property-listing property-2 h-100">
								
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
			</section>
			<!-- ============================ Property End ================================== -->
			
			<!-- ============================ Our Counter Start ================================== -->
			<section class="image-cover" style="background:#0f161a url(<?php echo esc_url( murailles_img( 'pattern.png' ) ); ?>) no-repeat;">
				<div class="container">
					
					<div class="row justify-content-center">
						<div class="col-xl-7 col-lg-10 col-md-12 col-sm-12">
							<div class="text-center mb-5">
								<span class="label bg-danger d-inline-flex mb-3">Our Awards</span>
								<h2 class="font-weight-normal text-light">Over 1,24,000+ Happy User Bieng with us Still they Love Our Services</h2>
							</div>
						</div>
					</div>
					
					<div class="row justify-content-center">
						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="_morder_counter">
								<div class="_morder_counter_thumb"><i class="ti-cup"></i></div>
								<div class="_morder_counter_caption">
									<h5 class="text-light"><span>32</span> M</h5>
									<span>Blue Burmin Award</span>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="_morder_counter">
								<div class="_morder_counter_thumb"><i class="ti-briefcase"></i></div>
								<div class="_morder_counter_caption">
									<h5 class="text-light"><span>43</span> M</h5>
									<span>Mimo X11 Award</span>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="_morder_counter">
								<div class="_morder_counter_thumb"><i class="ti-light-bulb"></i></div>
								<div class="_morder_counter_caption">
									<h5 class="text-light"><span>51</span> M</h5>
									<span>Australian UGC Award</span>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="_morder_counter">
								<div class="_morder_counter_thumb"><i class="ti-heart"></i></div>
								<div class="_morder_counter_caption">
									<h5 class="text-light"><span>42</span> M</h5>
									<span>IITCA Green Award</span>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</section>
			<!-- ============================ Our Counter End ================================== -->
			
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
			
			<!-- ============================ Top Agents ================================== -->
			<section class="gray-simple">
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
												<ul class="inline_social mt-3">
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
												<ul class="inline_social mt-3">
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
												<ul class="inline_social mt-3">
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
												<ul class="inline_social mt-3">
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
												<ul class="inline_social mt-3">
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

<?php murailles_render_page_builder_content(); ?>

<?php get_template_part( 'template-parts/call-to-action' ); ?>

<?php get_footer(); ?>
