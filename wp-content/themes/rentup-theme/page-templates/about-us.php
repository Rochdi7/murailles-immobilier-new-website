<?php
/**
 * Template Name: About Us
 *
 * Auto-converted from about-us.html
 * Preserves exact original HTML markup, classes, and structure.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$murailles_about_page_id = get_the_ID();

$murailles_about_hero_bg = murailles_page_section_image_url(
	'hero_bg_image_id',
	murailles_img( 'about-agence-murailles-immobilier.webp' ),
	$murailles_about_page_id,
	true
);
$murailles_about_hero_title = murailles_page_section_meta( 'hero_title', murailles_t( 'À propos — Qui sommes-nous ?', false ) );
$murailles_about_story_title = murailles_page_section_meta( 'story_title', murailles_t( "L'histoire de notre agence", false ) );
$murailles_about_story_subtitle = murailles_page_section_meta( 'story_subtitle', murailles_t( 'Découvrez notre parcours et notre méthode de travail', false ) );
$murailles_about_story_text_1 = murailles_page_section_meta( 'story_text_1', murailles_t( "Depuis sa création, l'Agence Murailles Immobilier s'investit pleinement dans le suivi et l'accompagnement de ses clients. Nous mettons notre connaissance fine du marché marocain au service de chaque projet : achat, vente, location longue durée ou saisonnière.", false ) );
$murailles_about_story_text_2 = murailles_page_section_meta( 'story_text_2', murailles_t( "Notre équipe sillonne quotidiennement Marrakech et les autres villes du Royaume pour vous proposer une sélection rigoureuse de biens : riads d'exception, villas, appartements modernes, terrains à bâtir et locaux commerciaux.", false ) );
$murailles_about_story_button_label = murailles_page_section_meta( 'story_button_label', murailles_t( 'En savoir plus', false ) );
$murailles_about_story_button_url = murailles_page_section_meta( 'story_button_url', home_url( '/contact/' ) );
$murailles_about_team_heading = murailles_page_section_meta( 'team_heading', murailles_t( 'Notre équipe', false ) );
$murailles_about_team_subheading = murailles_page_section_meta( 'team_subheading', murailles_t( 'Une équipe professionnelle et dévouée à vos côtés', false ) );
$murailles_about_awards_eyebrow = murailles_page_section_meta( 'awards_eyebrow', murailles_t( 'Nos distinctions', false ) );
$murailles_about_awards_heading = murailles_page_section_meta( 'awards_heading', murailles_t( 'Des centaines de clients satisfaits qui continuent à nous faire confiance pour leurs projets immobiliers.', false ) );
$murailles_about_testimonials_heading = murailles_page_section_meta( 'testimonials_heading', murailles_t( 'Avis de nos clients', false ) );
$murailles_about_testimonials_subtitle = murailles_page_section_meta( 'testimonials_subtitle', murailles_t( 'Découvrez les témoignages de propriétaires et acheteurs qui nous ont fait confiance pour leur projet immobilier au Maroc.', false ) );
$murailles_about_blog_heading = murailles_page_section_meta( 'blog_heading', murailles_t( 'Actualités & Articles', false ) );
$murailles_about_blog_subtitle = murailles_page_section_meta( 'blog_subtitle', murailles_t( 'Conseils, tendances du marché et guides pour acheter, vendre ou louer votre bien immobilier au Maroc.', false ) );

$murailles_about_repeaters = murailles_page_editor_repeatable_defaults( 'page-templates/about-us.php' );
$murailles_about_testimonials_default = murailles_get_repeatable_meta(
	'_murailles_about_testimonials',
	isset( $murailles_about_repeaters['_murailles_about_testimonials'] ) ? $murailles_about_repeaters['_murailles_about_testimonials'] : array(),
	$murailles_about_page_id
);
$murailles_about_testimonials = function_exists( 'murailles_get_theme_option_testimonials' )
	? murailles_get_theme_option_testimonials( '', $murailles_about_testimonials_default )
	: $murailles_about_testimonials_default;

get_header();
?>

<!-- ============================ Page Title Start================================== -->
			<?php if ( murailles_page_section_is_visible( 'hero', $murailles_about_page_id ) ) : ?>
			<div class="page-title" style="background:#f4f4f4 url(<?php echo esc_url( $murailles_about_hero_bg ); ?>);" data-overlay="5">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12">
							
							<div class="breadcrumbs-wrap position-relative z-1">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php murailles_t( 'Accueil' ); ?></a></li>
									<li class="breadcrumb-item active" aria-current="page"><?php murailles_t( 'À propos' ); ?></li>
								</ol>
								<h2 class="breadcrumb-title"><?php echo esc_html( $murailles_about_hero_title ); ?></h2>
							</div>
							
						</div>
					</div>
				</div>
			</div>
			<?php endif; ?>
			<!-- ============================ Page Title End ================================== -->
			
			<!-- ============================ Our Story Start ================================== -->
			<?php if ( murailles_page_section_is_visible( 'agency-story', $murailles_about_page_id ) ) : ?>
			<section>
			
				<div class="container">
				
					<!-- row Start -->
					<div class="row align-items-center">
						
						<div class="col-lg-6 col-md-6">
							<div class="story-wrap explore-content">

								<h2 class="mb-3 fw-bold"><?php echo esc_html( $murailles_about_story_title ); ?></h2>
								<span class="text-muted fs-5"><?php echo esc_html( $murailles_about_story_subtitle ); ?></span>
								<p class="mt-4"><?php echo esc_html( $murailles_about_story_text_1 ); ?></p>
								<p class="mb-3"><?php echo esc_html( $murailles_about_story_text_2 ); ?></p>
								<a href="<?php echo esc_url( $murailles_about_story_button_url ); ?>" class="btn btn-danger"><?php echo esc_html( $murailles_about_story_button_label ); ?></a>
							</div>
						</div>
						
						<div class="col-lg-6 col-md-6">
							<?php echo murailles_page_section_image( 'story_image_id', murailles_img( 'b-1.jpg' ), array( 'class' => 'img-fluid rounded', 'alt' => $murailles_about_story_title ), $murailles_about_page_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						
					</div>
					<!-- /row -->					
					
				</div>
						
			</section>
			<?php endif; ?>
			<!-- ============================ Our Story End ================================== -->
			
			<!-- ============================ Our Counter Start ================================== -->
			<?php if ( murailles_page_section_is_visible( 'distinctions', $murailles_about_page_id ) ) : ?>
			<section class="image-cover" style="background:#a70a29 url(<?php echo esc_url( murailles_img( 'pattern.png' ) ); ?>) no-repeat;">
				<div class="container">
					
					<div class="row justify-content-center">
						<div class="col-xl-7 col-lg-10 col-md-12 col-sm-12">
							<div class="text-center mb-5">
								<span class="text-light"><?php echo esc_html( $murailles_about_awards_eyebrow ); ?></span>
								<h2 class="font-weight-normal text-light"><?php echo esc_html( $murailles_about_awards_heading ); ?></h2>
							</div>
						</div>
					</div>
					
					<div class="row justify-content-center">
						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="_morder_counter">
								<div class="_morder_counter_thumb"><i class="ti-cup"></i></div>
								<div class="_morder_counter_caption">
									<h5 class="text-light"><span>32</span> M</h5>
									<span class="text-light"><?php murailles_t( 'Prix Excellence Immobilier' ); ?></span>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="_morder_counter">
								<div class="_morder_counter_thumb"><i class="ti-briefcase"></i></div>
								<div class="_morder_counter_caption">
									<h5 class="text-light"><span>43</span> M</h5>
									<span class="text-light"><?php murailles_t( 'Trophée Service Client' ); ?></span>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="_morder_counter">
								<div class="_morder_counter_thumb"><i class="ti-light-bulb"></i></div>
								<div class="_morder_counter_caption">
									<h5 class="text-light"><span>51</span> M</h5>
									<span class="text-light"><?php murailles_t( 'Certification Qualité' ); ?></span>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="_morder_counter">
								<div class="_morder_counter_thumb"><i class="ti-heart"></i></div>
								<div class="_morder_counter_caption">
									<h5 class="text-light"><span>42</span> M</h5>
									<span class="text-light"><?php murailles_t( 'Label Confiance Client' ); ?></span>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</section>
			<?php endif; ?>
			<!-- ============================ Our Counter End ================================== -->
			
			<!-- ================= Our Team================= -->
			<?php if ( murailles_page_section_is_visible( 'team-section', $murailles_about_page_id ) ) : ?>
			<section>
				<div class="container">
				
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="sec-heading center">
								<h2><?php echo esc_html( $murailles_about_team_heading ); ?></h2>
								<p><?php echo esc_html( $murailles_about_team_subheading ); ?></p>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12">
						
							<div class="team-slide item-slide">
								
								<!-- Single Teamm -->
								<div class="single-team">
									<div class="team-grid">
								
										<div class="teamgrid-user">
											<img src="https://i.pravatar.cc/96?img=47" alt="" class="img-fluid" />
										</div>
										
										<div class="teamgrid-content">
											<h4>Shaurya Preet</h4>
											<span><?php murailles_t( 'Co-fondateur' ); ?></span>
										</div>
										
										<div class="teamgrid-social">
											<ul>
												<li><a href="#" class="f-cl"><i class="ti-facebook"></i></a></li>
												<li><a href="#" class="t-cl"><i class="ti-twitter"></i></a></li>
												<li><a href="#" class="i-cl"><i class="ti-instagram"></i></a></li>
												<li><a href="#" class="l-cl"><i class="ti-linkedin"></i></a></li>
											</ul>
										</div>
							
									</div>
								</div>
								
								<!-- Single Teamm -->
								<div class="single-team">
									<div class="team-grid">
								
										<div class="teamgrid-user">
											<img src="https://i.pravatar.cc/96?img=32" alt="" class="img-fluid" />
										</div>
										
										<div class="teamgrid-content">
											<h4>Shivangi Preet</h4>
											<span><?php murailles_t( 'Rédacteur' ); ?></span>
										</div>
										
										<div class="teamgrid-social">
											<ul>
												<li><a href="#" class="f-cl"><i class="ti-facebook"></i></a></li>
												<li><a href="#" class="t-cl"><i class="ti-twitter"></i></a></li>
												<li><a href="#" class="i-cl"><i class="ti-instagram"></i></a></li>
												<li><a href="#" class="l-cl"><i class="ti-linkedin"></i></a></li>
											</ul>
										</div>
							
									</div>
								</div>
								
								<!-- Single Teamm -->
								<div class="single-team">
									<div class="team-grid">
								
										<div class="teamgrid-user">
											<img src="https://i.pravatar.cc/96?img=12" alt="" class="img-fluid" />
										</div>
										
										<div class="teamgrid-content">
											<h4>Yash Preet</h4>
											<span><?php murailles_t( 'Rédacteur' ); ?></span>
										</div>
										
										<div class="teamgrid-social">
											<ul>
												<li><a href="#" class="f-cl"><i class="ti-facebook"></i></a></li>
												<li><a href="#" class="t-cl"><i class="ti-twitter"></i></a></li>
												<li><a href="#" class="i-cl"><i class="ti-instagram"></i></a></li>
												<li><a href="#" class="l-cl"><i class="ti-linkedin"></i></a></li>
											</ul>
										</div>
							
									</div>
								</div>
								
								<!-- Single Teamm -->
								<div class="single-team">
									<div class="team-grid">
								
										<div class="teamgrid-user">
											<img src="https://i.pravatar.cc/96?img=45" alt="" class="img-fluid" />
										</div>
										
										<div class="teamgrid-content">
											<h4>Dhananjay Preet</h4>
											<span><?php murailles_t( 'PDG & Directeur' ); ?></span>
										</div>
										
										<div class="teamgrid-social">
											<ul>
												<li><a href="#" class="f-cl"><i class="ti-facebook"></i></a></li>
												<li><a href="#" class="t-cl"><i class="ti-twitter"></i></a></li>
												<li><a href="#" class="i-cl"><i class="ti-instagram"></i></a></li>
												<li><a href="#" class="l-cl"><i class="ti-linkedin"></i></a></li>
											</ul>
										</div>
							
									</div>
								</div>
								
								<!-- Single Teamm -->
								<div class="single-team">
									<div class="team-grid">
								
										<div class="teamgrid-user">
											<img src="https://i.pravatar.cc/96?img=68" alt="" class="img-fluid" />
										</div>
										
										<div class="teamgrid-content">
											<h4>Rahul Gilkrist</h4>
											<span><?php murailles_t( 'Designer' ); ?></span>
										</div>
										
										<div class="teamgrid-social">
											<ul>
												<li><a href="#" class="f-cl"><i class="ti-facebook"></i></a></li>
												<li><a href="#" class="t-cl"><i class="ti-twitter"></i></a></li>
												<li><a href="#" class="i-cl"><i class="ti-instagram"></i></a></li>
												<li><a href="#" class="l-cl"><i class="ti-linkedin"></i></a></li>
											</ul>
										</div>
							
									</div>
								</div>
								
								<!-- Single Teamm -->
								<div class="single-team">
									<div class="team-grid">
								
										<div class="teamgrid-user">
											<img src="https://i.pravatar.cc/96?img=53" alt="" class="img-fluid" />
										</div>
										
										<div class="teamgrid-content">
											<h4>Adam Wilcard</h4>
											<span><?php murailles_t( 'Développeur Web' ); ?></span>
										</div>
										
										<div class="teamgrid-social">
											<ul>
												<li><a href="#" class="f-cl"><i class="ti-facebook"></i></a></li>
												<li><a href="#" class="t-cl"><i class="ti-twitter"></i></a></li>
												<li><a href="#" class="i-cl"><i class="ti-instagram"></i></a></li>
												<li><a href="#" class="l-cl"><i class="ti-linkedin"></i></a></li>
											</ul>
										</div>
							
									</div>
								</div>
								
							</div>
						
						</div>
					</div>
				
				</div>
			</section>
			<?php endif; ?>
			<!-- =============================== Our Team ================================== -->
			
			<!-- ============================ Smart Testimonials ================================== -->
			<?php if ( murailles_page_section_is_visible( 'testimonials', $murailles_about_page_id ) ) : ?>
			<section class="gray-simple">
				<div class="container">
				
					<div class="row justify-content-center">
						<div class="col-lg-7 col-md-8">
							<div class="sec-heading center">
								<h2><?php echo esc_html( $murailles_about_testimonials_heading ); ?></h2>
								<p><?php echo esc_html( $murailles_about_testimonials_subtitle ); ?></p>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="item-slide space">
								<?php foreach ( $murailles_about_testimonials as $murailles_testimonial ) : ?>
									<?php
									$murailles_testimonial_image = murailles_get_repeatable_image_url( $murailles_testimonial, 'https://i.pravatar.cc/96?img=47' );
									$murailles_testimonial_alt   = murailles_get_repeatable_image_alt( $murailles_testimonial );
									$murailles_testimonial_name  = isset( $murailles_testimonial['person_name'] ) ? $murailles_testimonial['person_name'] : '';
									$murailles_testimonial_role  = isset( $murailles_testimonial['person_role'] ) ? $murailles_testimonial['person_role'] : '';
									$murailles_testimonial_text  = isset( $murailles_testimonial['description'] ) ? $murailles_testimonial['description'] : '';
									$murailles_testimonial_rate  = isset( $murailles_testimonial['rating'] ) && '' !== (string) $murailles_testimonial['rating'] ? (string) $murailles_testimonial['rating'] : '4.7';
									?>
									<div class="single_items">
										<div class="_testimonial_wrios">
											<div class="_testimonial_flex">
												<div class="_testimonial_flex_first">
													<div class="_tsl_flex_thumb">
														<img src="<?php echo esc_url( $murailles_testimonial_image ); ?>" class="img-fluid" alt="<?php echo esc_attr( $murailles_testimonial_alt ); ?>">
													</div>
													<div class="_tsl_flex_capst">
														<h5><?php echo esc_html( $murailles_testimonial_name ); ?></h5>
														<div class="_ovr_posts"><span><?php echo esc_html( $murailles_testimonial_role ); ?></span></div>
														<div class="_ovr_rates"><span><i class="fa fa-star"></i></span><?php echo esc_html( $murailles_testimonial_rate ); ?></div>
													</div>
												</div>
											</div>
											<div class="facts-detail">
												<p><?php echo esc_html( $murailles_testimonial_text ); ?></p>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
								<?php if ( false ) : ?>
								<!-- Single Item -->
								<div class="single_items">
									<div class="_testimonial_wrios">
										<div class="_testimonial_flex">
											<div class="_testimonial_flex_first">
												<div class="_tsl_flex_thumb">
													<img src="https://i.pravatar.cc/96?img=47" class="img-fluid" alt="">
												</div>
												<div class="_tsl_flex_capst">
													<h5>Susan D. Murphy</h5>
													<div class="_ovr_posts"><span><?php murailles_t( 'Propriétaire' ); ?></span></div>
													<div class="_ovr_rates"><span><i class="fa fa-star"></i></span>4.7</div>
												</div>
											</div>
										</div>
										
										<div class="facts-detail">
											<p><?php murailles_t( "L'équipe d'Agence Murailles m'a accompagnée du premier rendez-vous à la signature. Service réactif, conseils avisés et belle sélection de biens à Marrakech." ); ?></p>
										</div>
									</div>
								</div>
								
								<!-- Single Item -->
								<div class="single_items">
									<div class="_testimonial_wrios">
										<div class="_testimonial_flex">
											<div class="_testimonial_flex_first">
												<div class="_tsl_flex_thumb">
													<img src="https://i.pravatar.cc/96?img=32" class="img-fluid" alt="">
												</div>
												<div class="_tsl_flex_capst">
													<h5>Maxine E. Gagliardi</h5>
													<div class="_ovr_posts"><span><?php murailles_t( 'Acheteuse, Marrakech' ); ?></span></div>
													<div class="_ovr_rates"><span><i class="fa fa-star"></i></span>4.5</div>
												</div>
											</div>
										</div>
										
										<div class="facts-detail">
											<p><?php murailles_t( "L'équipe d'Agence Murailles m'a accompagnée du premier rendez-vous à la signature. Service réactif, conseils avisés et belle sélection de biens à Marrakech." ); ?></p>
										</div>
									</div>
								</div>
								
								<!-- Single Item -->
								<div class="single_items">
									<div class="_testimonial_wrios">
										<div class="_testimonial_flex">
											<div class="_testimonial_flex_first">
												<div class="_tsl_flex_thumb">
													<img src="https://i.pravatar.cc/96?img=12" class="img-fluid" alt="">
												</div>
												<div class="_tsl_flex_capst">
													<h5>Roy M. Cardona</h5>
													<div class="_ovr_posts"><span><?php murailles_t( 'Investisseur' ); ?></span></div>
													<div class="_ovr_rates"><span><i class="fa fa-star"></i></span>4.9</div>
												</div>
											</div>
										</div>
										
										<div class="facts-detail">
											<p><?php murailles_t( "L'équipe d'Agence Murailles m'a accompagnée du premier rendez-vous à la signature. Service réactif, conseils avisés et belle sélection de biens à Marrakech." ); ?></p>
										</div>
									</div>
								</div>
								
								<!-- Single Item -->
								<div class="single_items">
									<div class="_testimonial_wrios">
										<div class="_testimonial_flex">
											<div class="_testimonial_flex_first">
												<div class="_tsl_flex_thumb">
													<img src="https://i.pravatar.cc/96?img=45" class="img-fluid" alt="">
												</div>
												<div class="_tsl_flex_capst">
													<h5>Dorothy K. Shipton</h5>
													<div class="_ovr_posts"><span><?php murailles_t( 'Locataire, Casablanca' ); ?></span></div>
													<div class="_ovr_rates"><span><i class="fa fa-star"></i></span>4.7</div>
												</div>
											</div>
										</div>
										
										<div class="facts-detail">
											<p><?php murailles_t( "L'équipe d'Agence Murailles m'a accompagnée du premier rendez-vous à la signature. Service réactif, conseils avisés et belle sélection de biens à Marrakech." ); ?></p>
										</div>
									</div>
								</div>
								
								<!-- Single Item -->
								<div class="single_items">
									<div class="_testimonial_wrios">
										<div class="_testimonial_flex">
											<div class="_testimonial_flex_first">
												<div class="_tsl_flex_thumb">
													<img src="https://i.pravatar.cc/96?img=68" class="img-fluid" alt="">
												</div>
												<div class="_tsl_flex_capst">
													<h5>Robert P. McKissack</h5>
													<div class="_ovr_posts"><span><?php murailles_t( 'Propriétaire' ); ?></span></div>
													<div class="_ovr_rates"><span><i class="fa fa-star"></i></span>4.7</div>
												</div>
											</div>
										</div>
										
										<div class="facts-detail">
											<p><?php murailles_t( "L'équipe d'Agence Murailles m'a accompagnée du premier rendez-vous à la signature. Service réactif, conseils avisés et belle sélection de biens à Marrakech." ); ?></p>
										</div>
									</div>
								</div>
								<?php endif; ?>
							
							</div>
						</div>
					</div>
					
				</div>
			</section>
			<?php endif; ?>
			<!-- ============================ Smart Testimonials End ================================== -->
			
			<!-- ============================ article Start ================================== -->
			<?php if ( murailles_page_section_is_visible( 'articles', $murailles_about_page_id ) ) : ?>
			<section>
				<div class="container">
				
					<div class="row justify-content-center">
						<div class="col-lg-7 col-md-8">
							<div class="sec-heading center">
								<h2><?php echo esc_html( $murailles_about_blog_heading ); ?></h2>
								<p><?php echo esc_html( $murailles_about_blog_subtitle ); ?></p>
							</div>
						</div>
					</div>
					
					<div class="row g-4">
						<?php
						// Pull the 3 most recent published posts for the about page.
						// Polylang filters this query to the current language automatically.
						$mu_about_blog = new WP_Query( array(
							'post_type'      => 'post',
							'posts_per_page' => 3,
							'post_status'    => 'publish',
							'orderby'        => 'date',
							'order'          => 'DESC',
						) );
						$mu_about_fallbacks = array( 'b-1.jpg', 'b-5.jpg', 'b-6.jpg' );
						$mu_about_idx = 0;
						if ( $mu_about_blog->have_posts() ) :
							while ( $mu_about_blog->have_posts() ) : $mu_about_blog->the_post();
								$mu_p_id    = get_the_ID();
								$mu_p_url   = get_permalink();
								$mu_p_title = get_the_title();
								$mu_p_thumb = has_post_thumbnail( $mu_p_id )
									? get_the_post_thumbnail_url( $mu_p_id, 'medium_large' )
									: murailles_img( $mu_about_fallbacks[ $mu_about_idx % count( $mu_about_fallbacks ) ] );
								$mu_p_excerpt = has_excerpt( $mu_p_id ) ? get_the_excerpt() : wp_trim_words( wp_strip_all_tags( get_the_content() ), 18, '…' );
								$mu_p_auth_id = (int) get_post_field( 'post_author', $mu_p_id );
								$mu_p_auth    = get_the_author_meta( 'display_name', $mu_p_auth_id );
								$mu_p_auth_av = get_avatar_url( $mu_p_auth_id, array( 'size' => 60 ) );
								$mu_p_auth_ur = get_author_posts_url( $mu_p_auth_id );
								$mu_p_comm    = (int) get_comments_number( $mu_p_id );
								$mu_p_day     = date_i18n( 'd',   get_post_time( 'U', false, $mu_p_id ) );
								$mu_p_mon     = date_i18n( 'M Y', get_post_time( 'U', false, $mu_p_id ) );
								$mu_p_is_new  = ( time() - get_post_time( 'U', false, $mu_p_id ) ) < ( 21 * DAY_IN_SECONDS );
								$mu_p_is_hot  = $mu_p_comm >= 5;
								$mu_about_idx++;
						?>
						<div class="col-lg-4 col-md-6">
							<div class="grid_blog_box">
								<div class="gtid_blog_thumb">
									<a href="<?php echo esc_url( $mu_p_url ); ?>"><img src="<?php echo esc_url( $mu_p_thumb ); ?>" class="img-fluid" alt="<?php echo esc_attr( $mu_p_title ); ?>" /></a>
									<div class="gtid_blog_info"><span><?php echo esc_html( $mu_p_day ); ?></span><?php echo esc_html( $mu_p_mon ); ?></div>
								</div>
								<div class="blog-body">
									<h4 class="bl-title">
										<a href="<?php echo esc_url( $mu_p_url ); ?>"><?php echo esc_html( $mu_p_title ); ?></a>
										<?php if ( $mu_p_is_hot ) : ?>
											<span class="latest_new_post hot"><?php murailles_t( 'Populaire' ); ?></span>
										<?php elseif ( $mu_p_is_new ) : ?>
											<span class="latest_new_post"><?php murailles_t( 'Nouveau' ); ?></span>
										<?php endif; ?>
									</h4>
									<p><?php echo esc_html( $mu_p_excerpt ); ?></p>
								</div>
								<div class="modern_property_footer">
									<div class="property-author">
										<div class="path-img"><a href="<?php echo esc_url( $mu_p_auth_ur ); ?>" tabindex="-1"><img src="<?php echo esc_url( $mu_p_auth_av ); ?>" class="img-fluid" alt=""></a></div>
										<h5><a href="<?php echo esc_url( $mu_p_auth_ur ); ?>" tabindex="-1"><?php echo esc_html( $mu_p_auth ); ?></a></h5>
									</div>
									<span class="article-pulish-date"><i class="ti-comment-alt me-2"></i><?php echo (int) $mu_p_comm; ?></span>
								</div>
							</div>
						</div>
						<?php
							endwhile;
							wp_reset_postdata();
						else :
						?>
						<div class="col-12 text-center">
							<p><?php murailles_t( 'Aucun article publié pour le moment.' ); ?></p>
						</div>
						<?php endif; ?>
					</div>
					
				</div>
			</section>
			<div class="clearfix"></div>
			<?php endif; ?>
			<!-- ============================ article End ================================== -->

<?php murailles_render_page_builder_content(); ?>

<?php get_template_part( 'template-parts/call-to-action' ); ?>

<?php get_footer(); ?>
