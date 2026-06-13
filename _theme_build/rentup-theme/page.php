<?php
/**
 * Default Page Template (static fallback)
 *
 * For pages that have a custom page template assigned, WordPress
 * loads that template directly. This fallback only triggers for
 * pages without a specific template - shows the page title banner
 * and a simple content area.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();
?>

			<!-- ============================ Page Title Start================================== -->
			<div class="page-title" style="background:#f4f4f4;" data-overlay="5">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="breadcrumbs-wrap position-relative z-1">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php murailles_t( 'Accueil' ); ?></a></li>
									<li class="breadcrumb-item active" aria-current="page"><?php echo esc_html( get_the_title() ); ?></li>
								</ol>
								<h2 class="breadcrumb-title"><?php echo esc_html( get_the_title() ); ?></h2>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- ============================ Page Title End ================================== -->

			<section>
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="article-content">
								<?php
								while ( have_posts() ) : the_post();
									the_content();
								endwhile;
								?>
							</div>
						</div>
					</div>
				</div>
			</section>

<?php get_template_part( 'template-parts/call-to-action' ); ?>

<?php get_footer(); ?>
