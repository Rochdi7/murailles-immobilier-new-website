<?php
/**
 * Single Post (Blog Detail) Template
 *
 * Polished blog detail layout matching the Murailles design language:
 *   - hero header with featured image + breadcrumb + post title
 *   - white content card with typography, meta bar, tags, share row
 *   - author bio block
 *   - related-posts grid
 *   - styled comments + sidebar widgets
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();
?>

<?php while ( have_posts() ) : the_post();
	$mu_post_id     = get_the_ID();
	$mu_author_id   = (int) get_post_field( 'post_author', $mu_post_id );
	$mu_author_name = get_the_author_meta( 'display_name', $mu_author_id );
	$mu_author_bio  = get_the_author_meta( 'description',  $mu_author_id );
	$mu_author_url  = get_author_posts_url( $mu_author_id );
	$mu_author_av   = get_avatar_url( $mu_author_id, array( 'size' => 120 ) );
	$mu_comment_cnt = (int) get_comments_number( $mu_post_id );
	$mu_categories  = get_the_category();
	$mu_tags        = get_the_tags();
	$mu_reading     = max( 1, (int) ceil( str_word_count( wp_strip_all_tags( get_the_content() ) ) / 200 ) );
	$mu_share_url   = rawurlencode( get_permalink() );
	$mu_share_title = rawurlencode( get_the_title() );
	$mu_header_bg   = has_post_thumbnail( $mu_post_id ) ? get_the_post_thumbnail_url( $mu_post_id, 'full' ) : '';
?>

	<!-- ============================ Blog Detail Hero ============================ -->
	<header class="murailles-blog-hero<?php echo $mu_header_bg ? ' has-image' : ''; ?>"
		<?php if ( $mu_header_bg ) : ?>style="background-image:url('<?php echo esc_url( $mu_header_bg ); ?>');"<?php endif; ?>>
		<div class="murailles-blog-hero__overlay"></div>
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-9 col-md-11">
					<nav class="murailles-blog-hero__breadcrumb" aria-label="breadcrumb">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php murailles_t( 'Accueil' ); ?></a>
						<span class="sep">/</span>
						<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php murailles_t( 'Blog' ); ?></a>
						<span class="sep">/</span>
						<span class="current"><?php echo esc_html( wp_trim_words( get_the_title(), 6, '…' ) ); ?></span>
					</nav>

					<?php if ( ! empty( $mu_categories ) ) : ?>
						<div class="murailles-blog-hero__cats">
							<?php foreach ( $mu_categories as $mu_cat ) : ?>
								<a href="<?php echo esc_url( get_category_link( $mu_cat ) ); ?>"><?php echo esc_html( $mu_cat->name ); ?></a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<h1 class="murailles-blog-hero__title"><?php the_title(); ?></h1>

					<div class="murailles-blog-hero__meta">
						<span class="meta-item">
							<img src="<?php echo esc_url( get_avatar_url( $mu_author_id, array( 'size' => 48 ) ) ); ?>" alt="" class="meta-avatar">
							<a href="<?php echo esc_url( $mu_author_url ); ?>"><?php echo esc_html( $mu_author_name ); ?></a>
						</span>
						<span class="meta-dot"></span>
						<span class="meta-item"><i class="fa-regular fa-calendar"></i><?php echo esc_html( get_the_date() ); ?></span>
						<span class="meta-dot"></span>
						<span class="meta-item"><i class="fa-regular fa-clock"></i><?php echo (int) $mu_reading; ?> <?php murailles_t( 'min de lecture' ); ?></span>
						<span class="meta-dot"></span>
						<span class="meta-item"><i class="fa-regular fa-comment"></i><?php echo (int) $mu_comment_cnt; ?> <?php murailles_t( 'commentaires' ); ?></span>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- ============================ Hero End ============================ -->

	<section class="murailles-blog-detail gray">
		<div class="container">
			<div class="row">

				<!-- ===== Article column ===== -->
				<div class="col-lg-8 col-md-12">
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'murailles-blog-card' ); ?>>

						<div class="murailles-blog-card__content">
							<?php the_content(); ?>
						</div>

						<div class="murailles-blog-card__footer">
							<?php if ( $mu_tags ) : ?>
								<div class="murailles-blog-card__tags">
									<i class="fa-solid fa-tags"></i>
									<?php foreach ( $mu_tags as $mu_tag ) : ?>
										<a href="<?php echo esc_url( get_tag_link( $mu_tag ) ); ?>" class="murailles-tag"><?php echo esc_html( $mu_tag->name ); ?></a>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>

							<div class="murailles-blog-card__share">
								<span class="share-label"><?php murailles_t( 'Partager :' ); ?></span>
								<a class="share-btn share-fb" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $mu_share_url; ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( murailles_t( 'Partager sur Facebook', false ) ); ?>"><i class="fa-brands fa-facebook-f"></i></a>
								<a class="share-btn share-tw" href="https://twitter.com/intent/tweet?url=<?php echo $mu_share_url; ?>&text=<?php echo $mu_share_title; ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( murailles_t( 'Partager sur X', false ) ); ?>"><i class="fa-brands fa-x-twitter"></i></a>
								<a class="share-btn share-wa" href="https://wa.me/?text=<?php echo $mu_share_title; ?>%20<?php echo $mu_share_url; ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( murailles_t( 'Partager sur WhatsApp', false ) ); ?>"><i class="fa-brands fa-whatsapp"></i></a>
								<a class="share-btn share-li" href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $mu_share_url; ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( murailles_t( 'Partager sur LinkedIn', false ) ); ?>"><i class="fa-brands fa-linkedin-in"></i></a>
								<a class="share-btn share-copy" href="<?php echo esc_url( get_permalink() ); ?>" data-copy="<?php echo esc_url( get_permalink() ); ?>" aria-label="<?php echo esc_attr( murailles_t( 'Copier le lien', false ) ); ?>"><i class="fa-solid fa-link"></i></a>
							</div>
						</div>

					</article>

					<!-- ===== Author box ===== -->
					<aside class="murailles-author-box">
						<img class="murailles-author-box__avatar" src="<?php echo esc_url( $mu_author_av ); ?>" alt="<?php echo esc_attr( $mu_author_name ); ?>">
						<div class="murailles-author-box__body">
							<span class="murailles-author-box__role"><?php murailles_t( 'Auteur' ); ?></span>
							<h4 class="murailles-author-box__name"><a href="<?php echo esc_url( $mu_author_url ); ?>"><?php echo esc_html( $mu_author_name ); ?></a></h4>
							<p class="murailles-author-box__bio">
								<?php echo $mu_author_bio ? esc_html( $mu_author_bio ) : esc_html( murailles_t( 'Contributeur chez Murailles Immobilier.', false ) ); ?>
							</p>
							<a class="murailles-author-box__all" href="<?php echo esc_url( $mu_author_url ); ?>"><?php
								printf(
									/* translators: %s is the author's display name */
									murailles_t( 'Tous les articles de %s', false ),
									esc_html( $mu_author_name )
								);
							?> <i class="fa-solid fa-arrow-right"></i></a>
						</div>
					</aside>

					<!-- ===== Related posts ===== -->
					<?php
					$mu_related_args = array(
						'post_type'      => 'post',
						'posts_per_page' => 3,
						'post__not_in'   => array( $mu_post_id ),
						'orderby'        => 'rand',
					);
					if ( ! empty( $mu_categories ) ) {
						$mu_related_args['category__in'] = wp_list_pluck( $mu_categories, 'term_id' );
					}
					$mu_related = new WP_Query( $mu_related_args );
					if ( $mu_related->have_posts() ) : ?>
						<section class="murailles-related">
							<header class="murailles-related__header">
								<h3><?php murailles_t( 'À lire également' ); ?></h3>
								<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php murailles_t( 'Voir tous les articles' ); ?> <i class="fa-solid fa-arrow-right"></i></a>
							</header>
							<div class="murailles-related__grid">
								<?php while ( $mu_related->have_posts() ) : $mu_related->the_post();
									$mu_r_pid   = get_the_ID();
									$mu_r_thumb = has_post_thumbnail( $mu_r_pid )
										? get_the_post_thumbnail_url( $mu_r_pid, 'medium_large' )
										: murailles_img( 'b-' . ( ( $mu_r_pid % 6 ) + 1 ) . '.jpg' );
								?>
								<a class="murailles-related__card" href="<?php the_permalink(); ?>">
									<div class="murailles-related__thumb" style="background-image:url('<?php echo esc_url( $mu_r_thumb ); ?>');"></div>
									<div class="murailles-related__body">
										<span class="murailles-related__date"><?php echo esc_html( get_the_date() ); ?></span>
										<h4 class="murailles-related__title"><?php the_title(); ?></h4>
									</div>
								</a>
								<?php endwhile; wp_reset_postdata(); ?>
							</div>
						</section>
					<?php endif; ?>

					<!-- ===== Comments ===== -->
					<div class="murailles-comments-wrap">
						<?php
						if ( comments_open() || get_comments_number() ) {
							comments_template();
						}
						?>
					</div>

				</div>

				<!-- ===== Sidebar column ===== -->
				<aside class="col-lg-4 col-md-12 murailles-blog-sidebar">
					<?php get_sidebar(); ?>
				</aside>

			</div>
		</div>
	</section>

	<script>
	/* Copy-link share button */
	( function () {
		document.querySelectorAll( '.share-copy[data-copy]' ).forEach( function ( btn ) {
			btn.addEventListener( 'click', function ( e ) {
				e.preventDefault();
				var url = btn.getAttribute( 'data-copy' );
				if ( navigator.clipboard && navigator.clipboard.writeText ) {
					navigator.clipboard.writeText( url ).then( function () {
						btn.classList.add( 'is-copied' );
						setTimeout( function () { btn.classList.remove( 'is-copied' ); }, 1500 );
					} );
				}
			} );
		} );
	} )();
	</script>

<?php endwhile; ?>

<?php get_template_part( 'template-parts/call-to-action' ); ?>

<?php get_footer(); ?>
