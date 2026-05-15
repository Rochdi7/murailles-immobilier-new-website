<?php
/**
 * Template Name: Components
 *
 * Auto-converted from component.html
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
									<li class="breadcrumb-item active" aria-current="page">Components</li>
								</ol>
								<h2 class="breadcrumb-title">Components - All Elements</h2>
							</div>
							
						</div>
					</div>
				</div>
			</div>
			<!-- ============================ Page Title End ================================== -->
			
			<!-- ============================ Agency List Start ================================== -->
			<section>
			
				<div class="container">
				
					<!-- row Start -->
					<div class="row">
					
						<div class="col-lg-12 col-md-12 col-sm-12">
							<h4>Tabs Examples</h4>
							<div class="custom-tab style-1">
								<ul class="nav nav-tabs pb-2 b-0" id="myTab" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
									</li>
								</ul>
								<div class="tab-content" id="myTabContent">
									<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
									</div>
									<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
									</div>
									<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
									</div>
								</div>
							</div>
						</div>
						
					</div>
					<!-- /row -->

					<!-- row Start -->
					<div class="row mt-4">
					
						<div class="col-lg-6 col-md-12 col-sm-12">
							<h4>Typography</h4>
							 <h1>Heading One</h1>
                            <h2>Heading Two</h2>
                            <h3>Heading Three</h3>
                            <h4>Heading Four</h4>
                            <h5>Heading Five</h5>
                            <h6>Heading Six</h6>
						</div>
						
						<div class="col-lg-6 col-md-12 col-sm-12">
							<h4>Buttons</h4>
							<button type="submit" class="btn btn-danger">Simple button</button></br>
							<button type="submit" class="btn btn-danger btn-rounded">Simple button</button>
							<button type="submit" class="btn btn-danger btn-md">Midium Button</button></br>
							<button type="submit" class="btn btn-danger btn-lg">Large Button</button>
							<button type="submit" class="btn btn-outline-danger">Outline Button</button></br></br>
							<a href="#" class="btn btn-danger">Simple button</a></br>
							<a href="#" class="btn btn-danger">Simple button</a>
						</div>
						
					</div>
					<!-- /row -->	

					<!-- row Start -->
					<div class="row mt-4">
					
						<div class="col-lg-6 col-md-12 col-sm-12">
							<h4>Shadow & Simple Inputbox</h4>
							
							<div class="form-group">
								<div class="input-with-icon">
									<input type="text" class="form-control" placeholder="Neighborhood">
									<i class="ti-search"></i>
								</div>
							</div>
							<div class="form-group">
								<label>Name</label>
								<input type="text" class="form-control simple">
							</div>
						</div>
						
						<div class="col-lg-6 col-md-12 col-sm-12">
							<h4>Checkbox & Radio buttons</h4>
							<ul class="no-ul-list">
								<li>
									<input id="a-1" class="form-check-input" name="a-1" type="checkbox">
									<label for="a-1" class="form-check-label">Air Condition</label>
								</li>
								<li>
									<input id="a-2" class="form-check-input" name="a-2" type="checkbox">
									<label for="a-2" class="form-check-label">Bedding</label>
								</li>
								
							</ul>
							
							<ul class="no-ul-list">
								<li>
									<input id="a-p" class="form-check-input" name="a-p" type="radio">
									<label for="a-p" class="form-check-label">Air Condition</label>
								</li>
								<li>
									<input id="a-c" class="form-check-input" name="a-c" type="radio">
									<label for="a-c" class="form-check-label">Bedding</label>
								</li>
								
							</ul>
						</div>
						
					</div>
					<!-- /row -->

					<div class="row mt-3">
						<div class="col-lg-12 col-md-12">
							<h4>Lists Style</h4>
						</div>
						
						<!-- Buttons Styles -->			
						<div class="col-lg-4 col-md-4">
							<ul class="simple-list">
								<li>A simple light alert</li>
								<li>A simple light alert</li>
								<li>A simple light alert</li>
								<li>A simple light alert</li>
							</ul>	
						</div>
						
						<!-- Buttons Styles -->			
						<div class="col-lg-4 col-md-4">
							<ul class="colored-list">
								<li>A simple light alert</li>
								<li>A simple light alert</li>
								<li>A simple light alert</li>
								<li>A simple light alert</li>
							</ul>
						</div>
						
						<!-- Buttons Styles -->			
						<div class="col-lg-4 col-md-4">
							<ul class="simple-list">
								<li>A simple light alert</li>
								<li>A simple light alert</li>
								<li>A simple light alert</li>
								<li>A simple light alert</li>
							</ul>
						</div>
						
					</div>					
					
				</div>
						
			</section>
			<!-- ============================ Agency List End ================================== -->

<?php get_template_part( 'template-parts/call-to-action' ); ?>

<?php get_footer(); ?>
