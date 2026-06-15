<?php
/**
 * Template Name: Histoire de Marrakech
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$murailles_histoire_page_id = get_the_ID();

$murailles_histoire_hero_bg = murailles_page_section_image_url( 'hero_bg_image_id', murailles_img( 'histoire-marrakech.webp' ), $murailles_histoire_page_id, true );
$murailles_histoire_hero_eyebrow = murailles_page_section_meta( 'hero_eyebrow', murailles_t( 'Patrimoine', false ) );
$murailles_histoire_hero_title = murailles_page_section_meta( 'hero_title', murailles_t( 'Histoire de Marrakech', false ) );
$murailles_histoire_hero_subtitle = murailles_page_section_meta( 'hero_subtitle', murailles_t( "Mille ans de civilisation, de souks animés et d'architecture berbéro-andalouse au pied de l'Atlas.", false ) );
$murailles_histoire_intro_quote = murailles_page_section_meta( 'intro_quote', murailles_t( "Fondée en 1062 par Youssef Ibn Tachfine, Marrakech a tour à tour été capitale des Almoravides, des Almohades et des Saadiens. La ville rouge tient son nom des remparts d'argile qui l'enserrent encore aujourd'hui.", false ) );
$murailles_histoire_timeline_eyebrow = murailles_page_section_meta( 'timeline_eyebrow', murailles_t( 'Chronologie', false ) );
$murailles_histoire_timeline_heading = murailles_page_section_meta( 'timeline_heading', murailles_t( 'Une histoire millénaire', false ) );
$murailles_histoire_timeline_subtitle = murailles_page_section_meta( 'timeline_subtitle', murailles_t( 'Les grandes dates qui ont façonné la ville rouge.', false ) );
$murailles_histoire_monuments_eyebrow = murailles_page_section_meta( 'monuments_eyebrow', murailles_t( 'Patrimoine', false ) );
$murailles_histoire_monuments_heading = murailles_page_section_meta( 'monuments_heading', murailles_t( 'Monuments emblématiques', false ) );
$murailles_histoire_monuments_subtitle = murailles_page_section_meta( 'monuments_subtitle', murailles_t( "Les joyaux architecturaux qui racontent l'histoire de la ville.", false ) );
$murailles_histoire_repeaters = murailles_page_editor_repeatable_defaults( 'page-templates/histoire-marrakech.php' );
$murailles_histoire_timeline = murailles_get_repeatable_meta(
	'_murailles_histoire_timeline',
	isset( $murailles_histoire_repeaters['_murailles_histoire_timeline'] ) ? $murailles_histoire_repeaters['_murailles_histoire_timeline'] : array(),
	$murailles_histoire_page_id
);
$murailles_histoire_monuments = murailles_get_repeatable_meta(
	'_murailles_histoire_monuments',
	isset( $murailles_histoire_repeaters['_murailles_histoire_monuments'] ) ? $murailles_histoire_repeaters['_murailles_histoire_monuments'] : array(),
	$murailles_histoire_page_id
);
get_header();
?>

<!-- ============================ Page Title ================================== -->
<?php if ( murailles_page_section_is_visible( 'hero', $murailles_histoire_page_id ) ) : ?>
<div class="page-title histoire-hero" style="background:linear-gradient(135deg,rgba(220,53,69,0.85),rgba(26,35,50,0.85)),url(<?php echo esc_url( $murailles_histoire_hero_bg ); ?>) center/cover no-repeat;padding:100px 0;color:#fff;">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<span style="display:inline-block;padding:6px 16px;background:rgba(255,255,255,0.15);border-radius:20px;font-size:13px;font-weight:600;letter-spacing:0.5px;text-transform:uppercase;backdrop-filter:blur(4px);margin-bottom:14px;"><?php echo esc_html( $murailles_histoire_hero_eyebrow ); ?></span>
				<h1 style="color:#fff;font-size:42px;font-weight:800;margin:0 0 12px;text-shadow:0 2px 10px rgba(0,0,0,0.2);"><?php echo esc_html( $murailles_histoire_hero_title ); ?></h1>
				<p style="color:rgba(255,255,255,0.92);font-size:17px;max-width:680px;margin:0 auto;line-height:1.6;"><?php echo esc_html( $murailles_histoire_hero_subtitle ); ?></p>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

<!-- Intro -->
<?php if ( murailles_page_section_is_visible( 'intro', $murailles_histoire_page_id ) ) : ?>
<section class="pt-5 pb-4">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-10">
				<div style="display:flex;gap:20px;align-items:center;padding:24px 28px;background:#fff5f6;border-left:4px solid #dc3545;border-radius:10px;margin-bottom:40px;">
					<i class="fa-solid fa-quote-left" style="color:#dc3545;font-size:32px;flex-shrink:0;"></i>
					<p style="margin:0;font-size:17px;line-height:1.6;color:#1a2332;font-style:italic;font-weight:500;">
						<?php echo esc_html( $murailles_histoire_intro_quote ); ?>
					</p>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- Timeline -->
<?php if ( murailles_page_section_is_visible( 'timeline-intro', $murailles_histoire_page_id ) ) : ?>
<section class="pb-5">
	<div class="container">
		<div class="row justify-content-center mb-4">
			<div class="col-lg-7 text-center">
				<span style="display:inline-block;color:#dc3545;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;font-size:13px;margin-bottom:8px;"><?php echo esc_html( $murailles_histoire_timeline_eyebrow ); ?></span>
				<h2 style="margin:0 0 12px;"><?php echo esc_html( $murailles_histoire_timeline_heading ); ?></h2>
				<p class="text-muted"><?php echo esc_html( $murailles_histoire_timeline_subtitle ); ?></p>
			</div>
		</div>

		<div class="row justify-content-center">
			<div class="col-lg-10">
				<?php
				$timeline = array(
					array( '1062', murailles_t( 'Almoravides', false ),  'fa-flag',         murailles_t( 'Fondation par Youssef Ibn Tachfine, première capitale du Maroc.', false ), '#dc3545' ),
					array( '1147', murailles_t( 'Almohades', false ),    'fa-mosque',       murailles_t( "Construction de la Koutoubia, chef-d'œuvre de l'architecture islamique.", false ), '#0e8763' ),
					array( '1269', murailles_t( 'Mérinides', false ),    'fa-book-quran',   murailles_t( 'Période de transition, déplacement de la capitale à Fès.', false ), '#856404' ),
					array( '1554', murailles_t( 'Saadiens', false ),     'fa-crown',        murailles_t( "Âge d'or : palais El Badi, tombeaux saadiens, médersa Ben Youssef.", false ), '#dc3545' ),
					array( '1672', murailles_t( 'Alaouites', false ),    'fa-landmark',     murailles_t( 'Moulay Ismaïl démantèle El Badi pour construire Meknès.', false ), '#0e8763' ),
					array( '1912', murailles_t( 'Protectorat', false ),  'fa-building',     murailles_t( 'Création du quartier Guéliz, urbanisme à la française.', false ), '#856404' ),
					array( '1985', murailles_t( 'UNESCO', false ),       'fa-award',        murailles_t( "La médina inscrite au patrimoine mondial de l'UNESCO.", false ), '#dc3545' ),
					array( '2025', murailles_t( "Aujourd'hui", false ),  'fa-city',         murailles_t( "Capitale touristique du Maroc, 1,5 million d'habitants.", false ), '#0e8763' ),
				);
				foreach ( $murailles_histoire_timeline as $t ) :
					$year  = isset( $t['year'] ) ? $t['year'] : '';
					$era   = isset( $t['title'] ) ? $t['title'] : '';
					$icon  = isset( $t['icon_class'] ) ? $t['icon_class'] : '';
					$desc  = isset( $t['description'] ) ? $t['description'] : '';
					$color = isset( $t['color'] ) ? $t['color'] : '#dc3545';
				?>
				<div style="display:flex;gap:24px;margin-bottom:28px;align-items:flex-start;">
					<div style="flex-shrink:0;width:80px;text-align:center;">
						<div style="background:<?php echo $color; ?>;color:#fff;font-weight:800;font-size:18px;padding:14px 0;border-radius:12px;box-shadow:0 8px 20px rgba(0,0,0,0.08);">
							<?php echo esc_html( $year ); ?>
						</div>
					</div>
					<div style="flex:1;background:#fff;border:1px solid #f0f0f0;border-radius:12px;padding:20px 24px;box-shadow:0 4px 16px rgba(0,0,0,0.04);">
						<div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
							<i class="fa-solid <?php echo esc_attr( $icon ); ?>" style="color:<?php echo $color; ?>;font-size:18px;"></i>
							<h4 style="margin:0;font-size:18px;color:#1a2332;font-weight:700;"><?php echo esc_html( $era ); ?></h4>
						</div>
						<p style="margin:0;color:#4a5568;font-size:15px;line-height:1.6;"><?php echo esc_html( $desc ); ?></p>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- Monuments incontournables -->
<?php if ( murailles_page_section_is_visible( 'monuments-intro', $murailles_histoire_page_id ) ) : ?>
<section class="py-5" style="background:#fafbfc;">
	<div class="container">
		<div class="row justify-content-center mb-4">
			<div class="col-lg-7 text-center">
				<span style="display:inline-block;color:#dc3545;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;font-size:13px;margin-bottom:8px;"><?php echo esc_html( $murailles_histoire_monuments_eyebrow ); ?></span>
				<h2 style="margin:0 0 12px;"><?php echo esc_html( $murailles_histoire_monuments_heading ); ?></h2>
				<p class="text-muted"><?php echo esc_html( $murailles_histoire_monuments_subtitle ); ?></p>
			</div>
		</div>

		<div class="row g-4">
			<?php
			$monuments = array(
				array( 'Koutoubia',                                        '1147', murailles_t( 'Minaret almohade de 77 m, modèle de la Giralda de Séville.', false ),         'fa-mosque' ),
				array( murailles_t( 'Palais El Badi', false ),             '1578', murailles_t( "Vestiges du palais saadien, surnommé l'Incomparable.", false ),                'fa-landmark' ),
				array( murailles_t( 'Médersa Ben Youssef', false ),        '1565', murailles_t( 'Plus grande école coranique du Maghreb, zelliges et stucs raffinés.', false ), 'fa-book-quran' ),
				array( murailles_t( 'Tombeaux saadiens', false ),          '1557', murailles_t( 'Nécropole royale aux 66 sépultures, redécouverte en 1917.', false ),           'fa-monument' ),
				array( 'Bahia',                                            '1880', murailles_t( 'Palais alaouite, 8 ha de cours et jardins andalous.', false ),                  'fa-tree' ),
				array( murailles_t( 'Remparts', false ),                   '1126', murailles_t( '19 km de murailles en pisé rouge, percées de 9 portes.', false ),               'fa-archway' ),
			);
			foreach ( $murailles_histoire_monuments as $m ) :
				$name = isset( $m['title'] ) ? $m['title'] : '';
				$date = isset( $m['date'] ) ? $m['date'] : '';
				$desc = isset( $m['description'] ) ? $m['description'] : '';
				$icon = isset( $m['icon_class'] ) ? $m['icon_class'] : '';
			?>
			<div class="col-lg-4 col-md-6">
				<div style="background:#fff;border-radius:12px;padding:28px 24px;height:100%;box-shadow:0 4px 16px rgba(0,0,0,0.05);transition:transform .25s, box-shadow .25s;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 28px rgba(0,0,0,0.1)';" onmouseout="this.style.transform='';this.style.boxShadow='0 4px 16px rgba(0,0,0,0.05)';">
					<div style="width:56px;height:56px;background:linear-gradient(135deg,#dc3545,#a02834);border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
						<i class="fa-solid <?php echo esc_attr( $icon ); ?>" style="color:#fff;font-size:22px;"></i>
					</div>
					<h4 style="margin:0 0 4px;font-size:18px;color:#1a2332;font-weight:700;"><?php echo esc_html( $name ); ?></h4>
					<div style="color:#dc3545;font-size:12px;font-weight:700;letter-spacing:0.5px;margin-bottom:10px;"><?php echo esc_html( $date ); ?></div>
					<p style="margin:0;color:#6c757d;font-size:14px;line-height:1.6;"><?php echo esc_html( $desc ); ?></p>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- Free content from the page -->
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
