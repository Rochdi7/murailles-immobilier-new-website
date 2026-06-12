<?php
/**
 * Template Name: Nos Services
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$murailles_services_hero_bg = murailles_page_section_image_url( 'hero_bg_image_id', murailles_img( 'nos-services-immobilier-marrakech.webp' ), get_the_ID(), true );
$murailles_services_hero_eyebrow = murailles_page_section_meta( 'hero_eyebrow', 'Murailles Immobilier' );
$murailles_services_hero_title = murailles_page_section_meta( 'hero_title', 'Nos Services' );
$murailles_services_hero_subtitle = murailles_page_section_meta( 'hero_subtitle', 'Un savoir-faire complet sur tous les types de biens et tous les secteurs de Marrakech.' );
$murailles_services_intro_eyebrow = murailles_page_section_meta( 'intro_eyebrow', 'Ce que nous proposons' );
$murailles_services_intro_title = murailles_page_section_meta( 'intro_title', "L'Agence Murailles Immobilier vous propose" );
$murailles_services_intro_text = murailles_page_section_meta( 'intro_text', "Chaque type de bien et chaque secteur de Marrakech répondent à une logique de marché distincte&nbsp;: c'est l'ensemble de ces savoir-faire que nous mettons à votre disposition." );
get_header();
?>

<!-- ============================ Page Title ================================== -->
<div class="page-title nos-services-hero" style="background:linear-gradient(135deg,rgba(220,53,69,0.85),rgba(26,35,50,0.85)),url(<?php echo esc_url( $murailles_services_hero_bg ); ?>) center/cover no-repeat;padding:100px 0;color:#fff;">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<span style="display:inline-block;padding:6px 16px;background:rgba(255,255,255,0.15);border-radius:20px;font-size:13px;font-weight:600;letter-spacing:0.5px;text-transform:uppercase;backdrop-filter:blur(4px);margin-bottom:14px;"><?php echo esc_html( $murailles_services_hero_eyebrow ); ?></span>
				<h1 style="color:#fff;font-size:42px;font-weight:800;margin:0 0 12px;text-shadow:0 2px 10px rgba(0,0,0,0.2);"><?php echo esc_html( $murailles_services_hero_title ); ?></h1>
				<p style="color:rgba(255,255,255,0.92);font-size:17px;max-width:680px;margin:0 auto;line-height:1.6;"><?php echo wp_kses_post( $murailles_services_hero_subtitle ); ?></p>
			</div>
		</div>
	</div>
</div>

<!-- ============================ Intro ================================== -->
<section class="py-5">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-9 text-center">
				<span style="display:inline-block;color:#dc3545;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;font-size:13px;margin-bottom:8px;"><?php echo esc_html( $murailles_services_intro_eyebrow ); ?></span>
				<h2 style="margin:0 0 16px;"><?php echo esc_html( $murailles_services_intro_title ); ?></h2>
				<p class="text-muted" style="font-size:16px;line-height:1.7;"><?php echo wp_kses_post( $murailles_services_intro_text ); ?></p>
			</div>
		</div>
	</div>
</section>

<!-- ============================ Services grid ================================== -->
<section class="pb-5">
	<div class="container">
		<div class="row g-4">
			<?php
			$services = array(
				array( 'fa-archway',           'Riads & maisons d\'hôtes', 'Un large choix dans la médina, la Kasbah ou dans les alentours de Marrakech.' ),
				array( 'fa-building',          'Appartements & villas',    'À vendre ou à louer dans les quartiers de Guéliz et Hivernage.' ),
				array( 'fa-utensils',          'Commerces & restaurants',  'À vendre ou à louer, courte ou longue durée.' ),
				array( 'fa-map-location-dot',  'Terrains à bâtir',         'Route de l\'Ourika, Amezmiz, Tahennaoute, Sidi Abdellah Ghiat, Fès, Ouarzazate, Bab Atlas, Palmeraie, Amelkis…' ),
				array( 'fa-chart-line',        'Gestion & promotion',      'Ne laissez plus vos biens vacants — rentabilisez-les avec notre service de gestion locative.' ),
				array( 'fa-handshake',         'Accompagnement A à Z',     'Négociation, ouverture de compte, compromis, crédit, acte de vente, clauses suspensives, bail…' ),
			);
			foreach ( $services as $s ) :
				list( $icon, $title, $desc ) = $s;
			?>
			<div class="col-lg-6 col-md-6">
				<div class="d-flex" style="padding:24px;background:#f8f9fa;border-radius:12px;border-left:4px solid #dc3545;height:100%;transition:transform .2s, box-shadow .2s;" onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 12px 28px rgba(0,0,0,0.08)';" onmouseout="this.style.transform='';this.style.boxShadow='';">
					<div style="flex-shrink:0;width:52px;height:52px;background:#dc3545;color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:22px;margin-right:18px;">
						<i class="fa-solid <?php echo esc_attr( $icon ); ?>"></i>
					</div>
					<div>
						<h5 style="margin:0 0 8px;font-size:17px;color:#1a2332;font-weight:700;"><?php echo esc_html( $title ); ?></h5>
						<p style="margin:0;font-size:14px;color:#6c757d;line-height:1.6;"><?php echo esc_html( $desc ); ?></p>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>

		<div class="row mt-5">
			<div class="col-lg-12">
				<div style="padding:28px 36px;background:#1a2332;color:#fff;border-radius:12px;text-align:center;">
					<p style="margin:0 0 8px;font-size:13px;letter-spacing:1.5px;text-transform:uppercase;color:#dc3545;font-weight:700;">Notre engagement</p>
					<p style="margin:0;font-size:20px;font-weight:600;line-height:1.5;">Une approche globale et sécurisante pour votre projet de vie ou d'investissement.</p>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- ============================ Free content from page editor ================================== -->
<?php if ( get_the_content() ) : ?>
<section class="py-5">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-10">
				<div class="article-content" style="font-size:16px;line-height:1.8;color:#2c3e50;">
					<?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>

<?php get_footer(); ?>
