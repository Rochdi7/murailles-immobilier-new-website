<?php
/**
 * Template Name: My Profile
 *
 * Auto-converted from my-profile.html
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
									<li class="breadcrumb-item active" aria-current="page">My Profile</li>
								</ol>
								<h2 class="breadcrumb-title">My Account & Profile</h2>
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
										<li class="active"><a href="<?php echo esc_url( home_url( '/my-profile/' ) ); ?>"><i class="fa fa-user-tie"></i>My Profile</a></li>
										<li><a href="<?php echo esc_url( home_url( '/bookmark-list/' ) ); ?>"><i class="fa fa-bookmark"></i>Saved Property<span class="notti_coun style-2">7</span></a></li>
										<li><a href="<?php echo esc_url( home_url( '/my-property/' ) ); ?>"><i class="fa fa-tasks"></i>My Properties</a></li>
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
							
								<div class="dashboard-wraper">
								
									<!-- Basic Information -->
									<div class="frm_submit_block">	
										<h4>My Account</h4>
										<div class="frm_submit_wrap">
											<div class="form-row row">
											
												<div class="form-group col-md-6">
													<label>Your Name</label>
													<input type="text" class="form-control" value="Shaurya Preet">
												</div>
												
												<div class="form-group col-md-6">
													<label>Email</label>
													<input type="email" class="form-control" value="preet77@gmail.com">
												</div>
												
												<div class="form-group col-md-6">
													<label>Your Title</label>
													<input type="text" class="form-control" value="Web Designer">
												</div>
												
												<div class="form-group col-md-6">
													<label>Phone</label>
													<input type="text" class="form-control" value="123 456 5847">
												</div>
												
												<div class="form-group col-md-6">
													<label>Address</label>
													<input type="text" class="form-control" value="522, Arizona, Canada">
												</div>
												
												<div class="form-group col-md-6">
													<label>City</label>
													<input type="text" class="form-control" value="Montquebe">
												</div>
												
												<div class="form-group col-md-6">
													<label>State</label>
													<input type="text" class="form-control" value="Canada">
												</div>
												
												<div class="form-group col-md-6">
													<label>Zip</label>
													<input type="text" class="form-control" value="160052">
												</div>
												
												<div class="form-group col-md-12">
													<label>About</label>
													<textarea class="form-control">Maecenas quis consequat libero, a feugiat eros. Nunc ut lacinia tortor morbi ultricies laoreet ullamcorper phasellus semper</textarea>
												</div>
												
											</div>
										</div>
									</div>
									
									<div class="frm_submit_block">	
										<h4>Social Accounts</h4>
										<div class="frm_submit_wrap">
											<div class="form-row row">
											
												<div class="form-group col-md-6">
													<label>Facebook</label>
													<input type="text" class="form-control" value="https://facebook.com/">
												</div>
												
												<div class="form-group col-md-6">
													<label>Twitter</label>
													<input type="email" class="form-control" value="https://twitter.com/">
												</div>
												
												<div class="form-group col-md-6">
													<label>Google Plus</label>
													<input type="text" class="form-control" value="https://googleplus.com/">
												</div>
												
												<div class="form-group col-md-6">
													<label>LinkedIn</label>
													<input type="text" class="form-control" value="https://linkedin.com/">
												</div>
												
												<div class="form-group col-lg-12 col-md-12 mt-4">
													<button class="btn btn-danger btn-lg" type="submit">Save Changes</button>
												</div>
												
											</div>
										</div>
									</div>
									
								</div>
							
							</div>
						</div>
						
					</div>
				</div>
			</section>
			<!-- ============================ User Dashboard End ================================== -->

<?php murailles_render_page_builder_content(); ?>

<?php get_template_part( 'template-parts/call-to-action' ); ?>

<?php get_footer(); ?>
