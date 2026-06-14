<?php
/**
 * Template Name: Tourisme à Marrakech
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$murailles_tourisme_page_id = get_the_ID();

$murailles_tourisme_hero_bg = murailles_page_section_image_url( 'hero_bg_image_id', murailles_img( 'tourisme-marrakech.webp' ), $murailles_tourisme_page_id, true );
$murailles_tourisme_hero_eyebrow = murailles_page_section_meta( 'hero_eyebrow', murailles_t( 'Découvrir', false ) );
$murailles_tourisme_hero_title = murailles_page_section_meta( 'hero_title', murailles_t( 'Tourisme à Marrakech', false ) );
$murailles_tourisme_hero_subtitle = murailles_page_section_meta( 'hero_subtitle', murailles_t( 'La ville ocre vous ouvre ses portes : palais millénaires, jardins enchantés, gastronomie raffinée et désert mystique.', false ) );
$murailles_tourisme_places_eyebrow = murailles_page_section_meta( 'places_eyebrow', murailles_t( 'À ne pas manquer', false ) );
$murailles_tourisme_places_heading = murailles_page_section_meta( 'places_heading', murailles_t( 'Lieux incontournables', false ) );
$murailles_tourisme_places_subtitle = murailles_page_section_meta( 'places_subtitle', murailles_t( 'Les sites emblématiques qui font le charme unique de Marrakech.', false ) );
$murailles_tourisme_seasons_eyebrow = murailles_page_section_meta( 'seasons_eyebrow', murailles_t( 'Pratique', false ) );
$murailles_tourisme_seasons_heading = murailles_page_section_meta( 'seasons_heading', murailles_t( 'Quand visiter Marrakech ?', false ) );
$murailles_tourisme_seasons_subtitle = murailles_page_section_meta( 'seasons_subtitle', murailles_t( 'Le climat de la ville ocre suit le rythme des saisons marocaines.', false ) );
$murailles_tourisme_food_eyebrow = murailles_page_section_meta( 'food_eyebrow', murailles_t( 'Gastronomie', false ) );
$murailles_tourisme_food_heading = murailles_page_section_meta( 'food_heading', murailles_t( 'Une cuisine de tradition', false ) );
$murailles_tourisme_food_text = murailles_page_section_meta( 'food_text', murailles_t( "La cuisine marocaine, classée par l'UNESCO, est un voyage à elle seule. Tajines mijotés, couscous du vendredi, pâtisseries au miel et thé à la menthe : chaque plat raconte l'art de vivre marocain.", false ) );
$murailles_tourisme_repeaters = murailles_page_editor_repeatable_defaults( 'page-templates/tourisme-marrakech.php' );
$murailles_tourisme_infos = murailles_get_repeatable_meta(
	'_murailles_tourisme_infos',
	isset( $murailles_tourisme_repeaters['_murailles_tourisme_infos'] ) ? $murailles_tourisme_repeaters['_murailles_tourisme_infos'] : array(),
	$murailles_tourisme_page_id
);
$murailles_tourisme_places = murailles_get_repeatable_meta(
	'_murailles_tourisme_places',
	isset( $murailles_tourisme_repeaters['_murailles_tourisme_places'] ) ? $murailles_tourisme_repeaters['_murailles_tourisme_places'] : array(),
	$murailles_tourisme_page_id
);
$murailles_tourisme_seasons = murailles_get_repeatable_meta(
	'_murailles_tourisme_seasons',
	isset( $murailles_tourisme_repeaters['_murailles_tourisme_seasons'] ) ? $murailles_tourisme_repeaters['_murailles_tourisme_seasons'] : array(),
	$murailles_tourisme_page_id
);
$murailles_tourisme_dishes = murailles_get_repeatable_meta(
	'_murailles_tourisme_dishes',
	isset( $murailles_tourisme_repeaters['_murailles_tourisme_dishes'] ) ? $murailles_tourisme_repeaters['_murailles_tourisme_dishes'] : array(),
	$murailles_tourisme_page_id
);
get_header();
?>

<!-- ============================ Page Title ================================== -->
<?php if ( murailles_page_section_is_visible( 'hero', $murailles_tourisme_page_id ) ) : ?>
<div class="page-title tourisme-hero" style="background:linear-gradient(135deg,rgba(220,53,69,0.85),rgba(26,35,50,0.85)),url(<?php echo esc_url( $murailles_tourisme_hero_bg ); ?>) center/cover no-repeat;padding:100px 0;color:#fff;">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<span style="display:inline-block;padding:6px 16px;background:rgba(255,255,255,0.15);border-radius:20px;font-size:13px;font-weight:600;letter-spacing:0.5px;text-transform:uppercase;backdrop-filter:blur(4px);margin-bottom:14px;"><?php echo esc_html( $murailles_tourisme_hero_eyebrow ); ?></span>
				<h1 style="color:#fff;font-size:42px;font-weight:800;margin:0 0 12px;text-shadow:0 2px 10px rgba(0,0,0,0.2);"><?php echo esc_html( $murailles_tourisme_hero_title ); ?></h1>
				<p style="color:rgba(255,255,255,0.92);font-size:17px;max-width:680px;margin:0 auto;line-height:1.6;"><?php echo esc_html( $murailles_tourisme_hero_subtitle ); ?></p>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

<!-- Quick info -->
<section class="py-5">
	<div class="container">
		<div class="row g-3 justify-content-center">
			<?php
			$infos = array(
				array( 'fa-temperature-half',  '22°C',      murailles_t( "Climat doux toute l'année", false ) ),
				array( 'fa-plane-arrival',     '3h',        murailles_t( 'depuis Paris en vol direct', false ) ),
				array( 'fa-language',          'FR/AR/EN',  murailles_t( 'Langues parlées', false ) ),
				array( 'fa-clock',             'GMT+1',     murailles_t( 'Fuseau horaire (Maroc)', false ) ),
			);
			foreach ( $murailles_tourisme_infos as $info ) :
				$icon  = isset( $info['icon_class'] ) ? $info['icon_class'] : '';
				$val   = isset( $info['value'] ) ? $info['value'] : '';
				$label = isset( $info['label'] ) ? $info['label'] : '';
			?>
			<div class="col-lg-3 col-md-6 col-6">
				<div style="display:flex;gap:14px;align-items:center;padding:18px 20px;background:#fff;border-radius:12px;box-shadow:0 4px 16px rgba(0,0,0,0.05);">
					<div style="width:46px;height:46px;background:#fff5f6;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
						<i class="fa-solid <?php echo esc_attr( $icon ); ?>" style="color:#dc3545;font-size:18px;"></i>
					</div>
					<div>
						<div style="font-size:18px;font-weight:800;color:#1a2332;line-height:1.1;"><?php echo esc_html( $val ); ?></div>
						<div style="font-size:12px;color:#6c757d;margin-top:2px;"><?php echo esc_html( $label ); ?></div>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- Lieux incontournables -->
<?php if ( murailles_page_section_is_visible( 'places-intro', $murailles_tourisme_page_id ) ) : ?>
<section class="py-5" style="background:#fafbfc;">
	<div class="container">
		<div class="row justify-content-center mb-4">
			<div class="col-lg-7 text-center">
				<span style="display:inline-block;color:#dc3545;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;font-size:13px;margin-bottom:8px;"><?php echo esc_html( $murailles_tourisme_places_eyebrow ); ?></span>
				<h2 style="margin:0 0 12px;"><?php echo esc_html( $murailles_tourisme_places_heading ); ?></h2>
				<p class="text-muted"><?php echo esc_html( $murailles_tourisme_places_subtitle ); ?></p>
			</div>
		</div>

		<div class="row g-4">
			<?php
			$places = array(
				array( 'Jemaa el-Fna',                                    murailles_t( "Place mythique inscrite à l'UNESCO. Conteurs, charmeurs de serpents, gastronomie de rue à la nuit tombée.", false ), murailles_t( 'Patrimoine UNESCO', false ),  'fa-mug-hot' ),
				array( murailles_t( 'Souks de la Médina', false ),        murailles_t( "Labyrinthe d'artisans : zelliges, cuirs, épices, tapis berbères et lanternes ciselées.", false ),                  murailles_t( 'Artisanat', false ),         'fa-shop' ),
				array( murailles_t( 'Jardin Majorelle', false ),          murailles_t( "Oasis de bambous et fleurs exotiques aux murs bleu Klein, ancienne demeure d'Yves Saint Laurent.", false ),        murailles_t( 'Jardin & Musée', false ),    'fa-leaf' ),
				array( 'Ménara',                                          murailles_t( "Bassin centenaire et oliveraie au pied de l'Atlas, cadre romantique au coucher du soleil.", false ),               murailles_t( 'Jardin historique', false ), 'fa-water' ),
				array( murailles_t( 'Palais Bahia', false ),              murailles_t( "Joyau de l'architecture marocaine du XIXe siècle : 8 ha de patios, riads et plafonds peints.", false ),            murailles_t( 'Palais', false ),            'fa-landmark' ),
				array( murailles_t( 'Médersa Ben Youssef', false ),       murailles_t( 'Ancienne école coranique aux décors de zelliges, stucs et bois de cèdre sculpté.', false ),                        murailles_t( 'Monument', false ),          'fa-book-quran' ),
				array( murailles_t( "Vallée de l'Ourika", false ),        murailles_t( 'Excursion à 1h : cascades, villages berbères, marché du lundi à Tnine, randonnées en montagne.', false ),          murailles_t( 'Excursion', false ),         'fa-mountain' ),
				array( murailles_t( "Désert d'Agafay", false ),           murailles_t( 'Désert de pierres à 30 min de la ville. Bivouacs sous les étoiles, balades en chameau et 4x4.', false ),           murailles_t( 'Aventure', false ),          'fa-sun' ),
				array( 'Essaouira',                                       murailles_t( 'Cité atlantique à 2h30 de route : ramparts portugais, port de pêche, surf et alizés.', false ),                    murailles_t( 'Côte atlantique', false ),   'fa-water' ),
			);
			foreach ( $murailles_tourisme_places as $p ) :
				$name = isset( $p['title'] ) ? $p['title'] : '';
				$desc = isset( $p['description'] ) ? $p['description'] : '';
				$tag  = isset( $p['tag'] ) ? $p['tag'] : '';
				$icon = isset( $p['icon_class'] ) ? $p['icon_class'] : '';
			?>
			<div class="col-lg-4 col-md-6">
				<div style="background:#fff;border-radius:14px;overflow:hidden;height:100%;box-shadow:0 4px 16px rgba(0,0,0,0.05);transition:transform .25s, box-shadow .25s;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 14px 32px rgba(0,0,0,0.1)';" onmouseout="this.style.transform='';this.style.boxShadow='0 4px 16px rgba(0,0,0,0.05)';">
					<div style="height:140px;background:linear-gradient(135deg,#dc3545,#a02834);display:flex;align-items:center;justify-content:center;position:relative;">
						<i class="fa-solid <?php echo esc_attr( $icon ); ?>" style="color:rgba(255,255,255,0.95);font-size:54px;"></i>
						<span style="position:absolute;top:14px;left:14px;background:rgba(255,255,255,0.92);color:#1a2332;padding:4px 12px;border-radius:20px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.4px;"><?php echo esc_html( $tag ); ?></span>
					</div>
					<div style="padding:22px 24px;">
						<h4 style="margin:0 0 10px;font-size:18px;color:#1a2332;font-weight:700;"><?php echo esc_html( $name ); ?></h4>
						<p style="margin:0;color:#6c757d;font-size:14px;line-height:1.6;"><?php echo esc_html( $desc ); ?></p>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- Quand venir -->
<?php if ( murailles_page_section_is_visible( 'seasons-intro', $murailles_tourisme_page_id ) ) : ?>
<section class="py-5">
	<div class="container">
		<div class="row justify-content-center mb-4">
			<div class="col-lg-7 text-center">
				<span style="display:inline-block;color:#dc3545;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;font-size:13px;margin-bottom:8px;"><?php echo esc_html( $murailles_tourisme_seasons_eyebrow ); ?></span>
				<h2 style="margin:0 0 12px;"><?php echo esc_html( $murailles_tourisme_seasons_heading ); ?></h2>
				<p class="text-muted"><?php echo esc_html( $murailles_tourisme_seasons_subtitle ); ?></p>
			</div>
		</div>

		<div class="row g-3 justify-content-center">
			<?php
			$seasons = array(
				array( murailles_t( 'Printemps', false ), murailles_t( 'Mars-Mai', false ),    '18-26°C', 'fa-seedling',  '#0e8763', murailles_t( 'Saison idéale : journées chaudes, soirées fraîches, jardins en fleurs.', false ) ),
				array( murailles_t( 'Été', false ),       murailles_t( 'Juin-Août', false ),   '28-40°C', 'fa-sun',       '#f9b704', murailles_t( 'Très chaud en journée. Préférer les riads avec piscine et siestes en patio.', false ) ),
				array( murailles_t( 'Automne', false ),   murailles_t( 'Sept-Nov', false ),    '20-30°C', 'fa-cloud-sun', '#dc3545', murailles_t( 'Lumière dorée magnifique, températures douces. Excellent pour les randonnées.', false ) ),
				array( murailles_t( 'Hiver', false ),     murailles_t( 'Déc-Février', false ), '8-18°C',  'fa-snowflake', '#3b82f6', murailles_t( "Doux en journée, frais le soir. L'Atlas sous la neige se visite à 1h30.", false ) ),
			);
			foreach ( $murailles_tourisme_seasons as $s ) :
				$name   = isset( $s['title'] ) ? $s['title'] : '';
				$months = isset( $s['months'] ) ? $s['months'] : '';
				$temp   = isset( $s['temperature'] ) ? $s['temperature'] : '';
				$icon   = isset( $s['icon_class'] ) ? $s['icon_class'] : '';
				$color  = isset( $s['color'] ) ? $s['color'] : '#dc3545';
				$desc   = isset( $s['description'] ) ? $s['description'] : '';
			?>
			<div class="col-lg-3 col-md-6">
				<div style="background:#fff;border-radius:14px;padding:24px 22px;height:100%;box-shadow:0 4px 16px rgba(0,0,0,0.04);border-top:4px solid <?php echo $color; ?>;">
					<i class="fa-solid <?php echo esc_attr( $icon ); ?>" style="color:<?php echo $color; ?>;font-size:28px;margin-bottom:12px;"></i>
					<h4 style="margin:0 0 4px;font-size:18px;color:#1a2332;font-weight:700;"><?php echo esc_html( $name ); ?></h4>
					<div style="font-size:13px;color:#6c757d;font-weight:600;margin-bottom:6px;"><?php echo esc_html( $months ); ?> &middot; <span style="color:<?php echo $color; ?>;"><?php echo esc_html( $temp ); ?></span></div>
					<p style="margin:0;color:#6c757d;font-size:13px;line-height:1.6;"><?php echo esc_html( $desc ); ?></p>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- Gastronomie -->
<?php if ( murailles_page_section_is_visible( 'food-intro', $murailles_tourisme_page_id ) ) : ?>
<section class="py-5" style="background:linear-gradient(135deg,#1a2332,#0f161f);color:#fff;">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-6">
				<span style="display:inline-block;color:#dc3545;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;font-size:13px;margin-bottom:8px;"><?php echo esc_html( $murailles_tourisme_food_eyebrow ); ?></span>
				<h2 style="color:#fff;margin:0 0 16px;"><?php echo esc_html( $murailles_tourisme_food_heading ); ?></h2>
				<p style="color:rgba(255,255,255,0.85);font-size:16px;line-height:1.7;"><?php echo esc_html( $murailles_tourisme_food_text ); ?></p>
			</div>
			<div class="col-lg-6">
				<div class="row g-3 mt-3 mt-lg-0">
					<?php
					$dishes = array(
						array( murailles_t( 'Tajine', false ),     'fa-bowl-food',    murailles_t( 'Agneau aux pruneaux, poulet citron-olives, kefta aux œufs.', false ) ),
						array( murailles_t( 'Couscous', false ),   'fa-utensils',     murailles_t( 'Le grain roi du vendredi, accompagné de 7 légumes et viande.', false ) ),
						array( murailles_t( 'Pastilla', false ),   'fa-cookie-bite',  murailles_t( 'Feuilletée sucrée-salée au pigeon ou au poisson.', false ) ),
						array( murailles_t( 'Thé menthe', false ), 'fa-mug-hot',      murailles_t( "Versé de haut, symbole de l'hospitalité marocaine.", false ) ),
					);
					foreach ( $murailles_tourisme_dishes as $d ) :
						$name = isset( $d['title'] ) ? $d['title'] : '';
						$icon = isset( $d['icon_class'] ) ? $d['icon_class'] : '';
						$desc = isset( $d['description'] ) ? $d['description'] : '';
					?>
					<div class="col-6">
						<div style="padding:18px;background:rgba(255,255,255,0.06);border-radius:12px;backdrop-filter:blur(4px);height:100%;">
							<i class="fa-solid <?php echo esc_attr( $icon ); ?>" style="color:#dc3545;font-size:22px;margin-bottom:10px;"></i>
							<h5 style="margin:0 0 4px;color:#fff;font-size:15px;font-weight:700;"><?php echo esc_html( $name ); ?></h5>
							<p style="margin:0;color:rgba(255,255,255,0.7);font-size:13px;line-height:1.5;"><?php echo esc_html( $desc ); ?></p>
						</div>
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
