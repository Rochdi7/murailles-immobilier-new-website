<?php
/**
 * Template Name: Single Property
 *
 * Page template for individual property detail pages.
 * Mirrors the layout from single-property-1.html.
 * Create WordPress pages with this template and use the page editor
 * to fill in property details, or extend with custom fields.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

			<!-- ============================ Property Detail Start ================================== -->
			<section class="pt-4 pb-0">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12">

							<?php while ( have_posts() ) : the_post(); ?>

							<!-- Property Header -->
							<div class="prt_detail_header mb-4">
								<div class="row">
									<div class="col-lg-8 col-md-8">
										<h2 class="prt_title"><?php the_title(); ?></h2>
										<div class="prt_location">
											<i class="ti-location-pin"></i>
											<span><?php echo get_post_meta( get_the_ID(), 'property_location', true ) ?: 'Location not specified'; ?></span>
										</div>
									</div>
									<div class="col-lg-4 col-md-4 text-end">
										<div class="prt_price_fix">
											<h4 class="text-danger"><?php echo get_post_meta( get_the_ID(), 'property_price', true ) ?: '$0'; ?></h4>
										</div>
									</div>
								</div>
							</div>

							<!-- Property Content from Editor -->
							<div class="property-detail-content">
								<?php the_content(); ?>
							</div>

							<?php endwhile; ?>

						</div>
					</div>
				</div>
			</section>
			<!-- ============================ Property Detail End ================================== -->

			<?php get_template_part( 'template-parts/call-to-action' ); ?>

<?php get_footer(); ?>
