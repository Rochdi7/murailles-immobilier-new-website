<?php
/**
 * Template Name: Blog Grid
 *
 * Dynamic blog grid pulling posts from the database.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

$paged   = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
$blog_q  = new WP_Query( array(
	'post_type'      => 'post',
	'post_status'    => 'publish',
	'posts_per_page' => 9,
	'paged'          => $paged,
) );
?>

<!-- ============================ Page Title Start================================== -->
			<div class="page-title" style="background:#f4f4f4 url(<?php echo esc_url( murailles_img( 'slider-3.jpg' ) ); ?>);" data-overlay="5">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12">

							<div class="breadcrumbs-wrap position-relative z-1">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php murailles_t( 'Accueil' ); ?></a></li>
									<li class="breadcrumb-item active" aria-current="page"><?php murailles_t( 'Blog' ); ?></li>
								</ol>
								<h2 class="breadcrumb-title"><?php murailles_t( 'Notre Blog' ); ?></h2>
							</div>

						</div>
					</div>
				</div>
			</div>
			<!-- ============================ Page Title End ================================== -->

			<!-- ============================ Blog List Start ================================== -->
			<section class="gray">

				<div class="container">

					<div class="row">
						<div class="col text-center">
							<div class="sec-heading center">
								<h2><?php murailles_t( 'Dernières actualités' ); ?></h2>
								<p><?php murailles_t( "Nous publions régulièrement des articles utiles pour vous accompagner dans votre projet immobilier." ); ?></p>
							</div>
						</div>
					</div>

					<!-- row Start -->
					<div class="row g-4">

						<?php if ( $blog_q->have_posts() ) : ?>
							<?php while ( $blog_q->have_posts() ) : $blog_q->the_post(); ?>
								<?php get_template_part( 'template-parts/blog-card' ); ?>
							<?php endwhile; ?>
							<?php wp_reset_postdata(); ?>
						<?php else : ?>
							<div class="col-12 text-center py-5">
								<h4><?php murailles_t( 'Aucun article pour le moment' ); ?></h4>
								<p><?php murailles_t( 'Revenez bientôt pour découvrir de nouveaux articles.' ); ?></p>
							</div>
						<?php endif; ?>

					</div>
					<!-- /row -->

					<!-- Pagination -->
					<?php
					$pagination = paginate_links( array(
						'type'      => 'array',
						'total'     => $blog_q->max_num_pages,
						'current'   => $paged,
						'prev_text' => '<span class="ti-arrow-left"></span>',
						'next_text' => '<span class="ti-arrow-right"></span>',
					) );
					if ( $pagination ) : ?>
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12">
								<ul class="pagination p-center">
									<?php foreach ( $pagination as $link ) : ?>
										<li class="page-item<?php echo ( strpos( $link, 'current' ) !== false ) ? ' active' : ''; ?>"><?php echo $link; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></li>
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
					<?php endif; ?>

				</div>

			</section>
			<!-- ============================ Blog List End ================================== -->

<?php murailles_render_page_builder_content(); ?>

<?php get_template_part( 'template-parts/call-to-action' ); ?>

<?php get_footer(); ?>
