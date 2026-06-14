<?php
/**
 * Blog Card (single grid item)
 *
 * Expects: global $post inside the loop.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$post_id      = get_the_ID();
$permalink    = get_permalink();
$title        = get_the_title();
$excerpt      = wp_trim_words( get_the_excerpt(), 18, '...' );
$day          = get_the_date( 'd' );
$month_year   = get_the_date( 'M Y' );
$comment_cnt  = (int) get_comments_number( $post_id );

// Featured image: use post thumbnail if set, else fall back to a rotating demo image.
if ( has_post_thumbnail( $post_id ) ) {
	$thumb = get_the_post_thumbnail_url( $post_id, 'large' );
} else {
	$fallbacks = array( 'b-1.jpg', 'b-5.jpg', 'b-6.jpg' );
	$thumb     = murailles_img( $fallbacks[ $post_id % count( $fallbacks ) ] );
}

// Badge: "Nouveau" if published in last 7 days, otherwise "Populaire" if comments > 5
$is_new = ( time() - get_post_time( 'U', false, $post_id ) ) < ( 7 * DAY_IN_SECONDS );
$badge  = $is_new ? '<span class="latest_new_post">' . esc_html( murailles_t( 'Nouveau', false ) ) . '</span>'
                  : ( $comment_cnt > 5 ? '<span class="latest_new_post hot">' . esc_html( murailles_t( 'Populaire', false ) ) . '</span>' : '' );

// Author
$author_id     = (int) get_post_field( 'post_author', $post_id );
$author_name   = get_the_author_meta( 'display_name', $author_id );
$author_url    = get_author_posts_url( $author_id );
$author_avatar = get_avatar_url( $author_id, array( 'size' => 80 ) );
if ( ! $author_avatar ) {
	$avatars       = array( 'user-1.jpg', 'user-2.jpg', 'user-3.jpg' );
	$author_avatar = murailles_img( $avatars[ $author_id % count( $avatars ) ] );
}
?>
<div class="col-lg-4 col-md-6">
	<div class="grid_blog_box shadow-0">

		<div class="gtid_blog_thumb">
			<a href="<?php echo esc_url( $permalink ); ?>"><img src="<?php echo esc_url( $thumb ); ?>" class="img-fluid" alt="<?php echo esc_attr( $title ); ?>" /></a>
			<div class="gtid_blog_info"><span><?php echo esc_html( $day ); ?></span><?php echo esc_html( $month_year ); ?></div>
		</div>

		<div class="blog-body">
			<h4 class="bl-title"><a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a><?php echo $badge; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h4>
			<p><?php echo esc_html( $excerpt ); ?></p>
		</div>

		<div class="modern_property_footer">
			<div class="property-author">
				<div class="path-img"><a href="<?php echo esc_url( $author_url ); ?>" aria-label="<?php echo esc_attr( $author_name ); ?>"><img src="<?php echo esc_url( $author_avatar ); ?>" class="img-fluid" alt="<?php echo esc_attr( $author_name ); ?>"></a></div>
				<h5><a href="<?php echo esc_url( $author_url ); ?>"><?php echo esc_html( $author_name ); ?></a></h5>
			</div>
			<span class="article-pulish-date"><i class="ti-comment-alt me-2"></i><?php echo esc_html( $comment_cnt ); ?></span>
		</div>

	</div>
</div>
