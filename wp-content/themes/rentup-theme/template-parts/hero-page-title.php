<?php
/**
 * Shared page hero ("page-title") — standardized across inner pages.
 *
 * Matches the "Demander une visite" / Contact hero: full-height banner with
 * ht-80 / ht-120 spacers, an eyebrow pill, a large centered white H1 and a
 * subtitle. Use the same look and height on every inner page that has a hero.
 *
 * Pass data through set_query_var() / get_template_part() args:
 *   $args['bg']       (string) Background image URL. Required.
 *   $args['eyebrow']  (string) Small uppercase pill text. Optional.
 *   $args['title']    (string) Main H1 text. Required.
 *   $args['subtitle'] (string) Lead paragraph. Optional.
 *   $args['overlay']  (int)    data-overlay strength 1–9. Default 6.
 *   $args['allow_html_subtitle'] (bool) wp_kses_post the subtitle. Default false.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$murailles_hero_bg       = isset( $args['bg'] ) ? $args['bg'] : '';
$murailles_hero_eyebrow  = isset( $args['eyebrow'] ) ? $args['eyebrow'] : '';
$murailles_hero_title    = isset( $args['title'] ) ? $args['title'] : '';
$murailles_hero_subtitle = isset( $args['subtitle'] ) ? $args['subtitle'] : '';
$murailles_hero_overlay  = isset( $args['overlay'] ) ? (int) $args['overlay'] : 6;
$murailles_hero_html_sub = ! empty( $args['allow_html_subtitle'] );
?>
<div class="page-title" style="background:#f4f4f4 url(<?php echo esc_url( $murailles_hero_bg ); ?>);" data-overlay="<?php echo esc_attr( $murailles_hero_overlay ); ?>">
	<div class="ht-80"></div>
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 position-relative z-1">
				<div class="_page_tetio">
					<?php if ( $murailles_hero_eyebrow ) : ?>
					<div class="pledtio_wrap"><span><?php echo esc_html( $murailles_hero_eyebrow ); ?></span></div>
					<?php endif; ?>
					<h1 class="text-light mb-0"><?php echo esc_html( $murailles_hero_title ); ?></h1>
					<?php if ( $murailles_hero_subtitle ) : ?>
					<p><?php echo $murailles_hero_html_sub ? wp_kses_post( $murailles_hero_subtitle ) : esc_html( $murailles_hero_subtitle ); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="ht-120"></div>
</div>
