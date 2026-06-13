<?php
/**
 * Template Name: Assistance & Conseils
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$murailles_assistance_page_id = get_the_ID();

$murailles_assistance_hero_bg = murailles_page_section_image_url( 'hero_bg_image_id', murailles_img( 'assistance-conseils-immobilier-marrakech.webp' ), $murailles_assistance_page_id, true );
$murailles_assistance_hero_eyebrow = murailles_page_section_meta( 'hero_eyebrow', murailles_t( 'Notre expertise', false ) );
$murailles_assistance_hero_title = murailles_page_section_meta( 'hero_title', murailles_t( 'Assistance & Conseils', false ) );
$murailles_assistance_hero_subtitle = murailles_page_section_meta( 'hero_subtitle', murailles_t( 'Un accompagnement personnalisé à chaque étape de votre projet immobilier au Maroc.', false ) );
$murailles_assistance_services_eyebrow = murailles_page_section_meta( 'services_eyebrow', murailles_t( 'Services', false ) );
$murailles_assistance_services_heading = murailles_page_section_meta( 'services_heading', murailles_t( 'Notre accompagnement', false ) );
$murailles_assistance_services_subtitle = murailles_page_section_meta( 'services_subtitle', murailles_t( "Murailles Immobilier vous accompagne de A à Z dans votre projet, depuis la première visite jusqu'à la remise des clés.", false ) );
$murailles_assistance_process_eyebrow = murailles_page_section_meta( 'process_eyebrow', murailles_t( 'Processus', false ) );
$murailles_assistance_process_heading = murailles_page_section_meta( 'process_heading', murailles_t( 'Comment nous procédons', false ) );
$murailles_assistance_process_subtitle = murailles_page_section_meta( 'process_subtitle', murailles_t( 'Une méthode éprouvée en 4 étapes pour sécuriser votre acquisition.', false ) );
$murailles_assistance_partners_eyebrow = murailles_page_section_meta( 'partners_eyebrow', murailles_t( 'Notre réseau', false ) );
$murailles_assistance_partners_heading = murailles_page_section_meta( 'partners_heading', murailles_t( 'Des partenaires de confiance', false ) );
$murailles_assistance_partners_text = murailles_page_section_meta( 'partners_text', murailles_t( "Banques, notaires, architectes, bureaux d'études, experts-comptables, entrepreneurs, artisans : notre réseau de partenaires marocains met son savoir-faire à votre service pour chaque étape de votre projet immobilier.", false ) );
$murailles_assistance_partners_button_label = murailles_page_section_meta( 'partners_button_label', murailles_t( 'Parlons de votre projet', false ) );
$murailles_assistance_partners_button_url = murailles_page_section_meta( 'partners_button_url', home_url( '/contact/' ) );
get_header();
?>

<!-- ============================ Page Title ================================== -->
<?php if ( murailles_page_section_is_visible( 'hero', $murailles_assistance_page_id ) ) : ?>
<div class="page-title assistance-hero" style="background:linear-gradient(135deg,rgba(220,53,69,0.85),rgba(26,35,50,0.85)),url(<?php echo esc_url( $murailles_assistance_hero_bg ); ?>) center/cover no-repeat;padding:100px 0;color:#fff;">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<span style="display:inline-block;padding:6px 16px;background:rgba(255,255,255,0.15);border-radius:20px;font-size:13px;font-weight:600;letter-spacing:0.5px;text-transform:uppercase;backdrop-filter:blur(4px);margin-bottom:14px;"><?php echo esc_html( $murailles_assistance_hero_eyebrow ); ?></span>
				<h1 style="color:#fff;font-size:42px;font-weight:800;margin:0 0 12px;text-shadow:0 2px 10px rgba(0,0,0,0.2);"><?php echo esc_html( $murailles_assistance_hero_title ); ?></h1>
				<p style="color:rgba(255,255,255,0.92);font-size:17px;max-width:680px;margin:0 auto;line-height:1.6;"><?php echo esc_html( $murailles_assistance_hero_subtitle ); ?></p>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

<!-- Stats bar -->
<section class="py-5">
	<div class="container">
		<div class="row g-4 justify-content-center">
			<?php
			$stats = array(
				array( '15+',  murailles_t( "Années d'expérience", false ), 'fa-award' ),
				array( '850+', murailles_t( 'Biens vendus', false ),        'fa-handshake' ),
				array( '1200+',murailles_t( 'Clients satisfaits', false ),  'fa-users' ),
				array( '24/7', murailles_t( 'Disponibilité', false ),       'fa-headset' ),
			);
			foreach ( $stats as $s ) :
				list( $val, $label, $icon ) = $s;
			?>
			<div class="col-lg-3 col-md-6 col-6">
				<div style="text-align:center;padding:24px 20px;background:#fff;border-radius:14px;box-shadow:0 6px 20px rgba(0,0,0,0.05);">
					<div style="width:60px;height:60px;margin:0 auto 14px;background:linear-gradient(135deg,#dc3545,#a02834);border-radius:50%;display:flex;align-items:center;justify-content:center;">
						<i class="fa-solid <?php echo esc_attr( $icon ); ?>" style="color:#fff;font-size:22px;"></i>
					</div>
					<div style="font-size:30px;font-weight:800;color:#1a2332;line-height:1;margin-bottom:6px;"><?php echo esc_html( $val ); ?></div>
					<div style="font-size:13px;color:#6c757d;font-weight:600;text-transform:uppercase;letter-spacing:0.4px;"><?php echo esc_html( $label ); ?></div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- Services -->
<?php if ( murailles_page_section_is_visible( 'services-intro', $murailles_assistance_page_id ) ) : ?>
<section class="py-5" style="background:#fafbfc;">
	<div class="container">
		<div class="row justify-content-center mb-4">
			<div class="col-lg-7 text-center">
				<span style="display:inline-block;color:#dc3545;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;font-size:13px;margin-bottom:8px;"><?php echo esc_html( $murailles_assistance_services_eyebrow ); ?></span>
				<h2 style="margin:0 0 12px;"><?php echo esc_html( $murailles_assistance_services_heading ); ?></h2>
				<p class="text-muted"><?php echo esc_html( $murailles_assistance_services_subtitle ); ?></p>
			</div>
		</div>

		<div class="row g-4">
			<?php
			$services = array(
				array( 'fa-magnifying-glass',     murailles_t( 'Recherche personnalisée', false ),   murailles_t( 'Nous identifions les biens correspondant exactement à vos critères : ville, quartier, surface, budget et style architectural.', false ) ),
				array( 'fa-handshake',            murailles_t( 'Négociation au juste prix', false ), murailles_t( "Forte de 15 ans d'expérience locale, notre équipe négocie chaque transaction pour obtenir les meilleures conditions.", false ) ),
				array( 'fa-file-signature',       murailles_t( 'Démarches juridiques', false ),      murailles_t( 'Compromis de vente, clauses suspensives, acte authentique : nous coordonnons notaire, avocat et expert pour une transaction sécurisée.', false ) ),
				array( 'fa-building-columns',     murailles_t( 'Financement bancaire', false ),      murailles_t( 'Réseau de partenaires bancaires marocains pour obtenir un crédit immobilier adapté à votre profil (résident et non-résident).', false ) ),
				array( 'fa-key',                  murailles_t( 'Remise des clés', false ),           murailles_t( 'Coordination avec syndic, copropriété, services publics. Vous récupérez un bien prêt à vivre ou à louer.', false ) ),
				array( 'fa-trowel-bricks',        murailles_t( 'Travaux & rénovation', false ),      murailles_t( "Architectes, maîtres d'œuvre, artisans : nous orchestrons les chantiers de rénovation, traditionnels et contemporains.", false ) ),
				array( 'fa-chart-line',           murailles_t( 'Gestion locative', false ),          murailles_t( 'Mise en location, sélection des locataires, encaissement des loyers, état des lieux : votre patrimoine rentabilisé sans tracas.', false ) ),
				array( 'fa-shield-halved',        murailles_t( 'Conseil patrimonial', false ),       murailles_t( 'Optimisation fiscale, succession, démembrement : nos partenaires experts-comptables vous guident sur la durée.', false ) ),
			);
			foreach ( $services as $s ) :
				list( $icon, $title, $desc ) = $s;
			?>
			<div class="col-lg-6 col-md-6">
				<div style="display:flex;gap:18px;padding:24px;background:#fff;border-radius:14px;height:100%;box-shadow:0 4px 16px rgba(0,0,0,0.04);border:1px solid #f0f0f0;transition:transform .2s, box-shadow .2s;" onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 12px 28px rgba(0,0,0,0.08)';" onmouseout="this.style.transform='';this.style.boxShadow='0 4px 16px rgba(0,0,0,0.04)';">
					<div style="flex-shrink:0;width:56px;height:56px;background:rgba(220,53,69,0.1);border-radius:14px;display:flex;align-items:center;justify-content:center;">
						<i class="fa-solid <?php echo esc_attr( $icon ); ?>" style="color:#dc3545;font-size:22px;"></i>
					</div>
					<div>
						<h4 style="margin:0 0 8px;font-size:17px;color:#1a2332;font-weight:700;"><?php echo esc_html( $title ); ?></h4>
						<p style="margin:0;color:#6c757d;font-size:14px;line-height:1.6;"><?php echo esc_html( $desc ); ?></p>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- Process steps -->
<?php if ( murailles_page_section_is_visible( 'process-intro', $murailles_assistance_page_id ) ) : ?>
<section class="py-5">
	<div class="container">
		<div class="row justify-content-center mb-4">
			<div class="col-lg-7 text-center">
				<span style="display:inline-block;color:#dc3545;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;font-size:13px;margin-bottom:8px;"><?php echo esc_html( $murailles_assistance_process_eyebrow ); ?></span>
				<h2 style="margin:0 0 12px;"><?php echo esc_html( $murailles_assistance_process_heading ); ?></h2>
				<p class="text-muted"><?php echo esc_html( $murailles_assistance_process_subtitle ); ?></p>
			</div>
		</div>

		<div class="row g-4">
			<?php
			$steps = array(
				array( '01', murailles_t( 'Premier contact', false ),     murailles_t( 'Échange téléphonique ou en agence pour cerner votre projet, votre budget et vos critères.', false ) ),
				array( '02', murailles_t( 'Visites ciblées', false ),     murailles_t( 'Sélection de 3 à 5 biens correspondant à vos attentes, accompagnement sur chaque visite.', false ) ),
				array( '03', murailles_t( 'Offre & négociation', false ), murailles_t( "Rédaction de l'offre d'achat, négociation du prix et des conditions avec le vendeur.", false ) ),
				array( '04', murailles_t( 'Signature & remise', false ),  murailles_t( "Coordination avec le notaire, signature de l'acte définitif, remise des clés.", false ) ),
			);
			foreach ( $steps as $i => $st ) :
				list( $num, $title, $desc ) = $st;
			?>
			<div class="col-lg-3 col-md-6">
				<div style="text-align:center;padding:32px 20px;position:relative;">
					<div style="font-size:60px;font-weight:900;color:rgba(220,53,69,0.08);line-height:1;position:absolute;top:0;left:50%;transform:translateX(-50%);"><?php echo esc_html( $num ); ?></div>
					<div style="position:relative;z-index:1;padding-top:30px;">
						<h4 style="margin:0 0 10px;font-size:17px;color:#1a2332;font-weight:700;"><?php echo esc_html( $title ); ?></h4>
						<p style="margin:0;color:#6c757d;font-size:14px;line-height:1.6;"><?php echo esc_html( $desc ); ?></p>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- Partners callout -->
<?php if ( murailles_page_section_is_visible( 'partners-callout', $murailles_assistance_page_id ) ) : ?>
<section class="py-5" style="background:linear-gradient(135deg,#1a2332,#0f161f);color:#fff;">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-7">
				<span style="display:inline-block;color:#dc3545;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;font-size:13px;margin-bottom:8px;"><?php echo esc_html( $murailles_assistance_partners_eyebrow ); ?></span>
				<h2 style="color:#fff;margin:0 0 14px;"><?php echo esc_html( $murailles_assistance_partners_heading ); ?></h2>
				<p style="color:rgba(255,255,255,0.85);font-size:16px;line-height:1.6;margin-bottom:24px;"><?php echo esc_html( $murailles_assistance_partners_text ); ?></p>
				<a href="<?php echo esc_url( $murailles_assistance_partners_button_url ); ?>" class="btn btn-danger" style="padding:12px 28px;border-radius:8px;font-weight:600;">
					<i class="fa-solid fa-envelope"></i><?php echo esc_html( $murailles_assistance_partners_button_label ); ?>
				</a>
			</div>
			<div class="col-lg-5 text-center">
				<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-top:20px;">
					<?php
					$partners = array( 'fa-building-columns','fa-balance-scale','fa-pen-ruler','fa-calculator','fa-screwdriver-wrench','fa-truck-fast' );
					foreach ( $partners as $p ) : ?>
					<div style="aspect-ratio:1;background:rgba(255,255,255,0.06);border-radius:14px;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px);">
						<i class="fa-solid <?php echo esc_attr( $p ); ?>" style="color:#dc3545;font-size:28px;"></i>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- Free content from page editor -->
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

<?php get_template_part( 'template-parts/call-to-action' ); ?>
<?php get_footer(); ?>
