<?php
/**
 * Archive Template
 *
 * Dynamic blog archive for category/tag/date archives.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

$archive_title = wp_get_document_title();
if ( is_category() ) {
	$archive_title = single_cat_title( '', false );
} elseif ( is_tag() ) {
	$archive_title = single_tag_title( '', false );
} elseif ( is_author() ) {
	$archive_title = get_the_author();
} elseif ( is_date() ) {
	$archive_title = get_the_archive_title();
} else {
	$archive_title = murailles_t( 'Archive', false );
}
?>

			<!-- ============================ Page Title Start================================== -->
			<div class="page-title" style="background:#f4f4f4;" data-overlay="5">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="breadcrumbs-wrap position-relative z-1">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php murailles_t( 'Accueil' ); ?></a></li>
									<li class="breadcrumb-item active" aria-current="page"><?php echo esc_html( wp_strip_all_tags( $archive_title ) ); ?></li>
								</ol>
								<h2 class="breadcrumb-title"><?php echo esc_html( wp_strip_all_tags( $archive_title ) ); ?></h2>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- ============================ Page Title End ================================== -->

			<section class="gray">
				<div class="container">
					<div class="row">
						<div class="col text-center">
							<div class="sec-heading center">
								<h2><?php murailles_t( 'Dernières actualités' ); ?></h2>
								<p><?php murailles_t( 'Nous publions régulièrement des articles utiles pour vous accompagner dans votre projet immobilier.' ); ?></p>
							</div>
						</div>
					</div>

					<div class="row g-4">
						<?php if ( have_posts() ) : ?>
							<?php while ( have_posts() ) : the_post(); ?>
								<?php get_template_part( 'template-parts/blog-card' ); ?>
							<?php endwhile; ?>
						<?php else : ?>
							<div class="col-12 text-center py-5">
								<h4><?php murailles_t( 'Aucun article trouvé' ); ?></h4>
								<p><?php murailles_t( 'Essayez une autre catégorie ou revenez plus tard.' ); ?></p>
							</div>
						<?php endif; ?>
					</div>

					<?php
					$pagination = paginate_links( array(
						'type'      => 'array',
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

<?php get_template_part( 'template-parts/call-to-action' ); ?>

<?php get_footer(); ?>
