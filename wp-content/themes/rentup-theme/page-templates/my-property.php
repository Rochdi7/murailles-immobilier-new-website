<?php
/**
 * Template Name: My Property
 *
 * Auto-converted from my-property.html
 * Preserves exact original HTML markup, classes, and structure.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();
?>

<!-- ============================ Page Title Start================================== -->
			<div class="page-title" style="background:#f4f4f4 url(<?php echo esc_url( murailles_img( 'banner-home.jpg' ) ); ?>);" data-overlay="5">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12">
							
							<div class="breadcrumbs-wrap position-relative z-1">
								<ol class="breadcrumb">
									<li class="breadcrumb-item active" aria-current="page">My Properties</li>
								</ol>
								<h2 class="breadcrumb-title">My All Properties</h2>
							</div>
							
						</div>
					</div>
				</div>
			</div>
			<!-- ============================ Page Title End ================================== -->
			
			<!-- ============================ User Dashboard ================================== -->
			<section class="gray pt-5 pb-5">
				<div class="container-fluid">
								
					<div class="row">
						
						<div class="col-lg-3 col-md-4 col-sm-12">
							<div class="property_dashboard_navbar">
								
								<div class="dash_user_avater">
									<img src="<?php echo esc_url( murailles_img( 'user-3.jpg' ) ); ?>" class="img-fluid avater" alt="">
									<h4>Adam Harshvardhan</h4>
									<span>Canada USA</span>
								</div>
								
								<div class="dash_user_menues">
									<ul>
										<li><a href="<?php echo esc_url( home_url( '/dashboard/' ) ); ?>"><i class="fa fa-tachometer-alt"></i>Dashboard<span class="notti_coun style-1">4</span></a></li>
										<li><a href="<?php echo esc_url( home_url( '/my-profile/' ) ); ?>"><i class="fa fa-user-tie"></i>My Profile</a></li>
										<li><a href="<?php echo esc_url( home_url( '/bookmark-list/' ) ); ?>"><i class="fa fa-bookmark"></i>Saved Property<span class="notti_coun style-2">7</span></a></li>
										<li class="active"><a href="<?php echo esc_url( home_url( '/my-property/' ) ); ?>"><i class="fa fa-tasks"></i>My Properties</a></li>
										<li><a href="<?php echo esc_url( home_url( '/messages/' ) ); ?>"><i class="fa fa-envelope"></i>Messages<span class="notti_coun style-3">3</span></a></li>
										<li><a href="<?php echo esc_url( home_url( '/pricing/' ) ); ?>"><i class="fa fa-gift"></i>Choose Package<span class="expiration">10 days left</span></a></li>
										<li><a href="<?php echo esc_url( home_url( '/dashboard/' ) ); ?>"><i class="fa fa-pen-nib"></i>Submit New Property</a></li>
										<li><a href="<?php echo esc_url( home_url( '/my-profile/' ) ); ?>"><i class="fa fa-unlock-alt"></i>Change Password</a></li>
									</ul>
								</div>
								
								<div class="dash_user_footer">
									<ul>
										<li><a href="#"><i class="fa fa-power-off"></i></a></li>
										<li><a href="#"><i class="fa fa-comment"></i></a></li>
										<li><a href="#"><i class="fa fa-cog"></i></a></li>
									</ul>
								</div>
								
							</div>
						</div>
						
						<div class="col-lg-9 col-md-8 col-sm-12">
							<div class="dashboard-body">
							
								<div class="row">
									<div class="col-lg-12 col-md-12">
										<div class="_prt_filt_dash">
											<div class="_prt_filt_dash_flex">
												<div class="foot-news-last">
													<div class="input-group">
													  <input type="text" class="form-control" placeholder="Email Address">
														<div class="input-group-append">
															<span type="button" class="input-group-text bg-danger border-0 text-light"><i class="fas fa-search"></i></span>
														</div>
													</div>
												</div>
											</div>
											<div class="_prt_filt_dash_last m2_hide">
												<div class="_prt_filt_radius">
													
												</div>
												<div class="_prt_filt_add_new">
													<a href="<?php echo esc_url( home_url( '/dashboard/' ) ); ?>" class="prt_submit_link"><i class="fas fa-plus-circle"></i><span class="d-none d-lg-block d-md-block">List New Property</span></a>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-lg-12 col-md-12">
										<div class="dashboard_property">
											<div class="table-responsive">
												<table class="table">
													<thead class="thead-dark">
														<tr>
														  <th scope="col">Property</th>
														  <th scope="col" class="m2_hide">Leads</th>
														  <th scope="col" class="m2_hide">Stats</th>
														  <th scope="col" class="m2_hide">Posted On</th>
														  <th scope="col">Status</th>
														  <th scope="col">Action</th>
														</tr>
													</thead>
													<tbody>
														<!-- tr block -->
														<tr>
															<td>
																<div class="dash_prt_wrap">
																	<div class="dash_prt_thumb">
																		<img src="<?php echo esc_url( murailles_img( 'p-1.png' ) ); ?>" class="img-fluid" alt="" />
																	</div>
																	<div class="dash_prt_caption">
																		<h5>4 Bhk Luxury Villa</h5>
																		<div class="prt_dashb_lot">5682 Brown River Suit 18</div>
																		<div class="prt_dash_rate"><span>$ 2,200,000</span></div>
																	</div>
																</div>
															</td>
															<td class="m2_hide">
																<div class="prt_leads"><span>27 till now</span></div>
																<div class="prt_leads_list">
																	<ul>
																		<li><a href="#"><img src="<?php echo esc_url( murailles_img( 'team-1.jpg' ) ); ?>" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#"><img src="<?php echo esc_url( murailles_img( 'team-1.jpg' ) ); ?>" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="_leads_name style-1">K</a></li>
																		<li><a href="#"><img src="<?php echo esc_url( murailles_img( 'team-1.jpg' ) ); ?>" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="leades_more">10+</a></li>
																	</ul>
																</div>
															</td>
															<td class="m2_hide">
																<div class="_leads_view"><h5 class="up">816</h5></div>
																<div class="_leads_view_title"><span>Total Views</span></div>
															</td>
															<td class="m2_hide">
																<div class="_leads_posted"><h5>16 Aug - 12:40</h5></div>
																<div class="_leads_view_title"><span>16 Days ago</span></div>
															</td>
															<td>
																<div class="_leads_status"><span class="active">Active</span></div>
																<div class="_leads_view_title"><span>Till 12 Oct</span></div>
															</td>
															<td>
																<div class="_leads_action">
																	<a href="#"><i class="fas fa-edit"></i></a>
																	<a href="#"><i class="fas fa-trash"></i></a>
																</div>
															</td>
														</tr>
														
														<!-- tr block -->
														<tr>
															<td>
																<div class="dash_prt_wrap">
																	<div class="dash_prt_thumb">
																		<img src="<?php echo esc_url( murailles_img( 'p-2.png' ) ); ?>" class="img-fluid" alt="" />
																	</div>
																	<div class="dash_prt_caption">
																		<h5>4 Bhk Luxury Villa</h5>
																		<div class="prt_dashb_lot">5682 Brown River Suit 18</div>
																		<div class="prt_dash_rate"><span>$ 2,200,000</span></div>
																	</div>
																</div>
															</td>
															<td class="m2_hide">
																<div class="prt_leads"><span>27 till now</span></div>
																<div class="prt_leads_list">
																	<ul>
																		<li><a href="#"><img src="<?php echo esc_url( murailles_img( 'team-1.jpg' ) ); ?>" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#"><img src="<?php echo esc_url( murailles_img( 'team-1.jpg' ) ); ?>" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="_leads_name style-1">K</a></li>
																		<li><a href="#"><img src="<?php echo esc_url( murailles_img( 'team-1.jpg' ) ); ?>" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="leades_more">10+</a></li>
																	</ul>
																</div>
															</td>
															<td class="m2_hide">
																<div class="_leads_view"><h5 class="up">816</h5></div>
																<div class="_leads_view_title"><span>Total Views</span></div>
															</td>
															<td class="m2_hide">
																<div class="_leads_posted"><h5>16 Aug - 12:40</h5></div>
																<div class="_leads_view_title"><span>16 Days ago</span></div>
															</td>
															<td>
																<div class="_leads_status"><span class="expire">Expired</span></div>
																<div class="_leads_view_title"><span>Till 12 Oct</span></div>
															</td>
															<td>
																<div class="_leads_action">
																	<a href="#"><i class="fas fa-edit"></i></a>
																	<a href="#"><i class="fas fa-trash"></i></a>
																</div>
															</td>
														</tr>
														
														<!-- tr block -->
														<tr>
															<td>
																<div class="dash_prt_wrap">
																	<div class="dash_prt_thumb">
																		<img src="<?php echo esc_url( murailles_img( 'p-3.png' ) ); ?>" class="img-fluid" alt="" />
																	</div>
																	<div class="dash_prt_caption">
																		<h5>4 Bhk Luxury Villa</h5>
																		<div class="prt_dashb_lot">5682 Brown River Suit 18</div>
																		<div class="prt_dash_rate"><span>$ 2,200,000</span></div>
																	</div>
																</div>
															</td>
															<td class="m2_hide">
																<div class="prt_leads"><span>27 till now</span></div>
																<div class="prt_leads_list">
																	<ul>
																		<li><a href="#"><img src="<?php echo esc_url( murailles_img( 'team-1.jpg' ) ); ?>" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#"><img src="<?php echo esc_url( murailles_img( 'team-1.jpg' ) ); ?>" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="_leads_name style-1">K</a></li>
																		<li><a href="#"><img src="<?php echo esc_url( murailles_img( 'team-1.jpg' ) ); ?>" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="leades_more">10+</a></li>
																	</ul>
																</div>
															</td>
															<td class="m2_hide">
																<div class="_leads_view"><h5 class="up">816</h5></div>
																<div class="_leads_view_title"><span>Total Views</span></div>
															</td>
															<td class="m2_hide">
																<div class="_leads_posted"><h5>16 Aug - 12:40</h5></div>
																<div class="_leads_view_title"><span>16 Days ago</span></div>
															</td>
															<td>
																<div class="_leads_status"><span class="active">Active</span></div>
																<div class="_leads_view_title"><span>Till 12 Oct</span></div>
															</td>
															<td>
																<div class="_leads_action">
																	<a href="#"><i class="fas fa-edit"></i></a>
																	<a href="#"><i class="fas fa-trash"></i></a>
																</div>
															</td>
														</tr>
														
														<!-- tr block -->
														<tr>
															<td>
																<div class="dash_prt_wrap">
																	<div class="dash_prt_thumb">
																		<img src="<?php echo esc_url( murailles_img( 'p-4.png' ) ); ?>" class="img-fluid" alt="" />
																	</div>
																	<div class="dash_prt_caption">
																		<h5>4 Bhk Luxury Villa</h5>
																		<div class="prt_dashb_lot">5682 Brown River Suit 18</div>
																		<div class="prt_dash_rate"><span>$ 2,200,000</span></div>
																	</div>
																</div>
															</td>
															<td class="m2_hide">
																<div class="prt_leads"><span>27 till now</span></div>
																<div class="prt_leads_list">
																	<ul>
																		<li><a href="#"><img src="<?php echo esc_url( murailles_img( 'team-1.jpg' ) ); ?>" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#"><img src="<?php echo esc_url( murailles_img( 'team-1.jpg' ) ); ?>" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="_leads_name style-1">K</a></li>
																		<li><a href="#"><img src="<?php echo esc_url( murailles_img( 'team-1.jpg' ) ); ?>" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="leades_more">10+</a></li>
																	</ul>
																</div>
															</td>
															<td class="m2_hide">
																<div class="_leads_view"><h5 class="up">816</h5></div>
																<div class="_leads_view_title"><span>Total Views</span></div>
															</td>
															<td class="m2_hide">
																<div class="_leads_posted"><h5>16 Aug - 12:40</h5></div>
																<div class="_leads_view_title"><span>16 Days ago</span></div>
															</td>
															<td>
																<div class="_leads_status"><span class="expire">Expired</span></div>
																<div class="_leads_view_title"><span>Till 12 Oct</span></div>
															</td>
															<td>
																<div class="_leads_action">
																	<a href="#"><i class="fas fa-edit"></i></a>
																	<a href="#"><i class="fas fa-trash"></i></a>
																</div>
															</td>
														</tr>
														
														<!-- tr block -->
														<tr>
															<td>
																<div class="dash_prt_wrap">
																	<div class="dash_prt_thumb">
																		<img src="<?php echo esc_url( murailles_img( 'p-5.png' ) ); ?>" class="img-fluid" alt="" />
																	</div>
																	<div class="dash_prt_caption">
																		<h5>4 Bhk Luxury Villa</h5>
																		<div class="prt_dashb_lot">5682 Brown River Suit 18</div>
																		<div class="prt_dash_rate"><span>$ 2,200,000</span></div>
																	</div>
																</div>
															</td>
															<td class="m2_hide">
																<div class="prt_leads"><span>27 till now</span></div>
																<div class="prt_leads_list">
																	<ul>
																		<li><a href="#"><img src="<?php echo esc_url( murailles_img( 'team-1.jpg' ) ); ?>" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#"><img src="<?php echo esc_url( murailles_img( 'team-1.jpg' ) ); ?>" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="_leads_name style-1">K</a></li>
																		<li><a href="#"><img src="<?php echo esc_url( murailles_img( 'team-1.jpg' ) ); ?>" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="leades_more">10+</a></li>
																	</ul>
																</div>
															</td>
															<td class="m2_hide">
																<div class="_leads_view"><h5 class="up">816</h5></div>
																<div class="_leads_view_title"><span>Total Views</span></div>
															</td>
															<td class="m2_hide">
																<div class="_leads_posted"><h5>16 Aug - 12:40</h5></div>
																<div class="_leads_view_title"><span>16 Days ago</span></div>
															</td>
															<td>
																<div class="_leads_status"><span class="active">Active</span></div>
																<div class="_leads_view_title"><span>Till 12 Oct</span></div>
															</td>
															<td>
																<div class="_leads_action">
																	<a href="#"><i class="fas fa-edit"></i></a>
																	<a href="#"><i class="fas fa-trash"></i></a>
																</div>
															</td>
														</tr>
														
														<!-- tr block -->
														<tr>
															<td>
																<div class="dash_prt_wrap">
																	<div class="dash_prt_thumb">
																		<img src="<?php echo esc_url( murailles_img( 'p-6.png' ) ); ?>" class="img-fluid" alt="" />
																	</div>
																	<div class="dash_prt_caption">
																		<h5>4 Bhk Luxury Villa</h5>
																		<div class="prt_dashb_lot">5682 Brown River Suit 18</div>
																		<div class="prt_dash_rate"><span>$ 2,200,000</span></div>
																	</div>
																</div>
															</td>
															<td class="m2_hide">
																<div class="prt_leads"><span>27 till now</span></div>
																<div class="prt_leads_list">
																	<ul>
																		<li><a href="#"><img src="<?php echo esc_url( murailles_img( 'team-1.jpg' ) ); ?>" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#"><img src="<?php echo esc_url( murailles_img( 'team-1.jpg' ) ); ?>" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="_leads_name style-1">K</a></li>
																		<li><a href="#"><img src="<?php echo esc_url( murailles_img( 'team-1.jpg' ) ); ?>" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="leades_more">10+</a></li>
																	</ul>
																</div>
															</td>
															<td class="m2_hide">
																<div class="_leads_view"><h5 class="up">816</h5></div>
																<div class="_leads_view_title"><span>Total Views</span></div>
															</td>
															<td class="m2_hide">
																<div class="_leads_posted"><h5>16 Aug - 12:40</h5></div>
																<div class="_leads_view_title"><span>16 Days ago</span></div>
															</td>
															<td>
																<div class="_leads_status"><span class="active">Active</span></div>
																<div class="_leads_view_title"><span>Till 12 Oct</span></div>
															</td>
															<td>
																<div class="_leads_action">
																	<a href="#"><i class="fas fa-edit"></i></a>
																	<a href="#"><i class="fas fa-trash"></i></a>
																</div>
															</td>
														</tr>
														
														<!-- tr block -->
														<tr>
															<td>
																<div class="dash_prt_wrap">
																	<div class="dash_prt_thumb">
																		<img src="<?php echo esc_url( murailles_img( 'p-7.png' ) ); ?>" class="img-fluid" alt="" />
																	</div>
																	<div class="dash_prt_caption">
																		<h5>4 Bhk Luxury Villa</h5>
																		<div class="prt_dashb_lot">5682 Brown River Suit 18</div>
																		<div class="prt_dash_rate"><span>$ 2,200,000</span></div>
																	</div>
																</div>
															</td>
															<td class="m2_hide">
																<div class="prt_leads"><span>27 till now</span></div>
																<div class="prt_leads_list">
																	<ul>
																		<li><a href="#"><img src="<?php echo esc_url( murailles_img( 'team-1.jpg' ) ); ?>" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#"><img src="<?php echo esc_url( murailles_img( 'team-1.jpg' ) ); ?>" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="_leads_name style-1">K</a></li>
																		<li><a href="#"><img src="<?php echo esc_url( murailles_img( 'team-1.jpg' ) ); ?>" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="leades_more">10+</a></li>
																	</ul>
																</div>
															</td>
															<td class="m2_hide">
																<div class="_leads_view"><h5 class="up">816</h5></div>
																<div class="_leads_view_title"><span>Total Views</span></div>
															</td>
															<td class="m2_hide">
																<div class="_leads_posted"><h5>16 Aug - 12:40</h5></div>
																<div class="_leads_view_title"><span>16 Days ago</span></div>
															</td>
															<td>
																<div class="_leads_status"><span class="expire">Expired</span></div>
																<div class="_leads_view_title"><span>Till 12 Oct</span></div>
															</td>
															<td>
																<div class="_leads_action">
																	<a href="#"><i class="fas fa-edit"></i></a>
																	<a href="#"><i class="fas fa-trash"></i></a>
																</div>
															</td>
														</tr>
														
														<!-- tr block -->
														<tr>
															<td>
																<div class="dash_prt_wrap">
																	<div class="dash_prt_thumb">
																		<img src="<?php echo esc_url( murailles_img( 'p-8.png' ) ); ?>" class="img-fluid" alt="" />
																	</div>
																	<div class="dash_prt_caption">
																		<h5>4 Bhk Luxury Villa</h5>
																		<div class="prt_dashb_lot">5682 Brown River Suit 18</div>
																		<div class="prt_dash_rate"><span>$ 2,200,000</span></div>
																	</div>
																</div>
															</td>
															<td class="m2_hide">
																<div class="prt_leads"><span>27 till now</span></div>
																<div class="prt_leads_list">
																	<ul>
																		<li><a href="#"><img src="<?php echo esc_url( murailles_img( 'team-1.jpg' ) ); ?>" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#"><img src="<?php echo esc_url( murailles_img( 'team-1.jpg' ) ); ?>" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="_leads_name style-1">K</a></li>
																		<li><a href="#"><img src="<?php echo esc_url( murailles_img( 'team-1.jpg' ) ); ?>" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="leades_more">10+</a></li>
																	</ul>
																</div>
															</td>
															<td class="m2_hide">
																<div class="_leads_view"><h5 class="up">816</h5></div>
																<div class="_leads_view_title"><span>Total Views</span></div>
															</td>
															<td class="m2_hide">
																<div class="_leads_posted"><h5>16 Aug - 12:40</h5></div>
																<div class="_leads_view_title"><span>16 Days ago</span></div>
															</td>
															<td>
																<div class="_leads_status"><span class="active">Active</span></div>
																<div class="_leads_view_title"><span>Till 12 Oct</span></div>
															</td>
															<td>
																<div class="_leads_action">
																	<a href="#"><i class="fas fa-edit"></i></a>
																	<a href="#"><i class="fas fa-trash"></i></a>
																</div>
															</td>
														</tr>
														
														<!-- tr block -->
														<tr>
															<td>
																<div class="dash_prt_wrap">
																	<div class="dash_prt_thumb">
																		<img src="<?php echo esc_url( murailles_img( 'p-9.png' ) ); ?>" class="img-fluid" alt="" />
																	</div>
																	<div class="dash_prt_caption">
																		<h5>4 Bhk Luxury Villa</h5>
																		<div class="prt_dashb_lot">5682 Brown River Suit 18</div>
																		<div class="prt_dash_rate"><span>$ 2,200,000</span></div>
																	</div>
																</div>
															</td>
															<td class="m2_hide">
																<div class="prt_leads"><span>27 till now</span></div>
																<div class="prt_leads_list">
																	<ul>
																		<li><a href="#"><img src="<?php echo esc_url( murailles_img( 'team-1.jpg' ) ); ?>" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#"><img src="<?php echo esc_url( murailles_img( 'team-1.jpg' ) ); ?>" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="_leads_name style-1">K</a></li>
																		<li><a href="#"><img src="<?php echo esc_url( murailles_img( 'team-1.jpg' ) ); ?>" class="img-fluid circle" alt="" /></a></li>
																		<li><a href="#" class="leades_more">10+</a></li>
																	</ul>
																</div>
															</td>
															<td class="m2_hide">
																<div class="_leads_view"><h5 class="up">816</h5></div>
																<div class="_leads_view_title"><span>Total Views</span></div>
															</td>
															<td class="m2_hide">
																<div class="_leads_posted"><h5>16 Aug - 12:40</h5></div>
																<div class="_leads_view_title"><span>16 Days ago</span></div>
															</td>
															<td>
																<div class="_leads_status"><span class="expire">Expired</span></div>
																<div class="_leads_view_title"><span>Till 12 Oct</span></div>
															</td>
															<td>
																<div class="_leads_action">
																	<a href="#"><i class="fas fa-edit"></i></a>
																	<a href="#"><i class="fas fa-trash"></i></a>
																</div>
															</td>
														</tr>
														
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								<!-- row -->
							
								
							</div>
								
						</div>
						
					</div>
				</div>
			</section>
			<!-- ============================ User Dashboard End ================================== -->

<?php get_template_part( 'template-parts/call-to-action' ); ?>

<?php get_footer(); ?>
