<?php
/**
 * Blog Sidebar
 *
 * Dynamic sidebar with search, post categories, recent posts and tag cloud.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$categories = get_categories( array(
	'orderby'    => 'count',
	'order'      => 'DESC',
	'hide_empty' => 1,
	'number'     => 8,
) );

$recent = new WP_Query( array(
	'post_type'      => 'post',
	'post_status'    => 'publish',
	'posts_per_page' => 4,
	'ignore_sticky_posts' => 1,
) );
?>

<div class="sidebar_wrap">

	<!-- Search Widget -->
	<div class="sidebar_widgets">
		<h4 class="sidebar_title"><?php murailles_t( 'Recherche' ); ?></h4>
		<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<div class="input-group">
				<input type="text" class="form-control" name="s" placeholder="<?php echo esc_attr( murailles_t( 'Rechercher...', false ) ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>">
				<div class="input-group-append">
					<button class="btn btn-danger" type="submit"><i class="ti-search"></i></button>
				</div>
			</div>
		</form>
	</div>

	<?php if ( ! empty( $categories ) ) : ?>
	<!-- Categories Widget — design mirrors the WP default widget_categories so
	     both code paths render identically (see murailles-custom.css). -->
	<div class="sidebar_widgets widget widget_categories">
		<h4 class="widget-title"><?php murailles_t( 'Catégories' ); ?></h4>
		<ul>
			<?php foreach ( $categories as $cat ) : ?>
				<li>
					<a href="<?php echo esc_url( get_category_link( $cat ) ); ?>">
						<?php echo esc_html( $cat->name ); ?>
					</a>
					<span class="murailles-cat-count"><?php echo esc_html( (int) $cat->count ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if ( $recent->have_posts() ) : ?>
	<!-- Recent Posts Widget -->
	<div class="sidebar_widgets">
		<h4 class="sidebar_title"><?php murailles_t( 'Articles récents' ); ?></h4>
		<?php while ( $recent->have_posts() ) : $recent->the_post(); ?>
			<div class="sidebar_recent_post mb-3">
				<h6 class="mb-1"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
				<span class="text-muted small"><?php echo esc_html( get_the_date() ); ?></span>
			</div>
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
	</div>
	<?php endif; ?>

	<?php
	$tags = get_tags( array( 'number' => 15 ) );
	if ( ! empty( $tags ) ) : ?>
	<!-- Tags Widget -->
	<div class="sidebar_widgets">
		<h4 class="sidebar_title"><?php murailles_t( 'Étiquettes' ); ?></h4>
		<div class="sidebar_tags">
			<?php foreach ( $tags as $tag ) : ?>
				<a href="<?php echo esc_url( get_tag_link( $tag ) ); ?>" class="badge bg-light text-dark me-1 mb-1"><?php echo esc_html( $tag->name ); ?></a>
			<?php endforeach; ?>
		</div>
	</div>
	<?php endif; ?>

</div>
