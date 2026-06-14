<?php
/**
 * Comments Template
 *
 * Displays comments and comment form using the original theme styling.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area mt-4">

	<?php if ( have_comments() ) : ?>
	<div class="property_block_wrap">
		<div class="property_block_wrap_header">
			<h4 class="property_block_title">
				<?php
				$mu_cnt = (int) get_comments_number();
				printf(
					/* translators: %s is the comment count */
					murailles_t( $mu_cnt > 1 ? '%s Commentaires' : '%s Commentaire', false ),
					number_format_i18n( $mu_cnt )
				);
				?>
			</h4>
		</div>

		<div class="block-body">
			<ul class="comment-list list-unstyled">
				<?php
				wp_list_comments( array(
					'style'      => 'ul',
					'short_ping' => true,
					'avatar_size' => 50,
				) );
				?>
			</ul>

			<?php the_comments_navigation(); ?>
		</div>
	</div>
	<?php endif; ?>

	<?php if ( comments_open() ) : ?>
	<div class="property_block_wrap mt-4">
		<div class="property_block_wrap_header">
			<h4 class="property_block_title"><?php murailles_t( 'Laisser un commentaire' ); ?></h4>
		</div>
		<div class="block-body">
			<?php
			comment_form( array(
				'class_form'    => 'comment-form',
				'class_submit'  => 'btn btn-danger',
				'title_reply'   => '',
				'label_submit'  => murailles_t( 'Envoyer le commentaire', false ),
			) );
			?>
		</div>
	</div>
	<?php endif; ?>

</div>
