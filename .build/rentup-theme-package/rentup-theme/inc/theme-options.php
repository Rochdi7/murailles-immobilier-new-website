<?php
/**
 * Theme Options — Murailles Immobilier
 *
 * Registers a "Options du thème" admin page with tabbed sections so the client
 * can edit all page content (text, images, contact info, team, testimonials)
 * without touching PHP files.
 *
 * Storage: everything goes into wp_options under the key 'murailles_options'.
 * Helper: murailles_opt( $key, $default = '' ) — reads from that array.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ─────────────────────────────────────────────────────────────────────────────
   HELPER
───────────────────────────────────────────────────────────────────────────── */
function murailles_opt( $key, $default = '' ) {
	static $cache = null;
	if ( $cache === null ) {
		$cache = (array) get_option( 'murailles_options', array() );
	}
	return isset( $cache[ $key ] ) && $cache[ $key ] !== '' ? $cache[ $key ] : $default;
}

/* ─────────────────────────────────────────────────────────────────────────────
   ADMIN MENU
───────────────────────────────────────────────────────────────────────────── */
add_action( 'admin_menu', function () {
	add_menu_page(
		'Options du thème',
		'Options du thème',
		'manage_options',
		'murailles-options',
		'murailles_options_page',
		'dashicons-admin-customizer',
		59
	);
} );

/* ─────────────────────────────────────────────────────────────────────────────
   ENQUEUE MEDIA UPLOADER on our options page
───────────────────────────────────────────────────────────────────────────── */
add_action( 'admin_enqueue_scripts', function ( $hook ) {
	if ( $hook !== 'toplevel_page_murailles-options' ) { return; }
	wp_enqueue_media();
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_script(
		'murailles-options-js',
		get_template_directory_uri() . '/inc/admin-assets.js',
		array( 'jquery', 'wp-color-picker' ),
		'1.1',
		true
	);
	wp_enqueue_style(
		'murailles-options-css',
		get_template_directory_uri() . '/inc/admin-assets.css',
		array(),
		'1.1'
	);
} );

/* ─────────────────────────────────────────────────────────────────────────────
   SAVE HANDLER
───────────────────────────────────────────────────────────────────────────── */
add_action( 'admin_post_murailles_save_options', function () {
	check_admin_referer( 'murailles_options_nonce', '_murailles_options_nonce' );
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Unauthorized' );
	}

	$old  = (array) get_option( 'murailles_options', array() );
	$post = $_POST;
	$clean = array();

	// ── Scalar fields ────────────────────────────────────────────────────────
	$text_fields = array(
		'hero_title', 'hero_subtitle',
		'about_home_years', 'agency_name', 'agency_tagline', 'agency_founder', 'agency_years',
		'about_story_title', 'about_story_subtitle',
		'contact_page_title', 'contact_page_subtitle',
		'contact_phone', 'contact_phone_href', 'contact_address1', 'contact_address2',
		'contact_whatsapp',
		'counter1_num', 'counter1_label',
		'counter2_num', 'counter2_label',
		'counter3_num', 'counter3_label',
		'counter4_num', 'counter4_label',
		'how_step1_title', 'how_step1_text',
		'how_step2_title', 'how_step2_text',
		'how_step3_title', 'how_step3_text',
		'seo_ga4_id', 'seo_gtm_id',
		'seo_google_verif', 'seo_bing_verif',
		'seo_twitter_handle', 'seo_facebook_app_id',
	);
	foreach ( $text_fields as $f ) {
		if ( isset( $post[ $f ] ) ) {
			$clean[ $f ] = sanitize_text_field( $post[ $f ] );
		}
	}

	// ── HTML/textarea fields ─────────────────────────────────────────────────
	$html_fields = array(
		'about_home_p1', 'about_home_p2',
		'about_story_p1', 'about_story_p2',
		'seo_site_description',
	);
	foreach ( $html_fields as $f ) {
		if ( isset( $post[ $f ] ) ) {
			$clean[ $f ] = wp_kses_post( $post[ $f ] );
		}
	}

	// ── Email fields ─────────────────────────────────────────────────────────
	if ( isset( $post['contact_email'] ) ) {
		$clean['contact_email'] = sanitize_email( $post['contact_email'] );
	}

	// ── URL / image fields ───────────────────────────────────────────────────
	$url_fields = array(
		'hero_bg_url', 'about_home_image_url',
		'about_banner_url', 'about_story_image_url',
		'contact_banner_url', 'contact_map_url',
		'agency_logo_url', 'agency_logo_white_url',
		'social_facebook', 'social_instagram', 'social_linkedin', 'social_twitter',
		'seo_default_og_image',
	);
	foreach ( $url_fields as $f ) {
		if ( isset( $post[ $f ] ) ) {
			$clean[ $f ] = esc_url_raw( $post[ $f ] );
		}
	}

	// ── Team repeater ────────────────────────────────────────────────────────
	if ( isset( $post['team_members'] ) && is_array( $post['team_members'] ) ) {
		$team = array();
		foreach ( $post['team_members'] as $m ) {
			if ( empty( $m['name'] ) ) { continue; }
			$team[] = array(
				'name'      => sanitize_text_field( $m['name'] ?? '' ),
				'role'      => sanitize_text_field( $m['role'] ?? '' ),
				'photo_url' => esc_url_raw( $m['photo_url'] ?? '' ),
				'facebook'  => esc_url_raw( $m['facebook'] ?? '' ),
				'instagram' => esc_url_raw( $m['instagram'] ?? '' ),
				'linkedin'  => esc_url_raw( $m['linkedin'] ?? '' ),
				'twitter'   => esc_url_raw( $m['twitter'] ?? '' ),
			);
		}
		$clean['team_members'] = $team;
	}

	// ── Testimonials repeater ────────────────────────────────────────────────
	if ( isset( $post['testimonials'] ) && is_array( $post['testimonials'] ) ) {
		$testis = array();
		foreach ( $post['testimonials'] as $t ) {
			if ( empty( $t['name'] ) ) { continue; }
			$testis[] = array(
				'name'      => sanitize_text_field( $t['name'] ?? '' ),
				'role'      => sanitize_text_field( $t['role'] ?? '' ),
				'photo_url' => esc_url_raw( $t['photo_url'] ?? '' ),
				'rating'    => floatval( $t['rating'] ?? 5 ),
				'text'      => sanitize_textarea_field( $t['text'] ?? '' ),
			);
		}
		$clean['testimonials'] = $testis;
	}

	// ── Affaires du mois (managed separately) — preserve ────────────────────
	if ( isset( $old['affaires_du_mois'] ) ) {
		$clean['affaires_du_mois'] = $old['affaires_du_mois'];
	}

	// Merge: new values override, existing keys preserved.
	$merged = array_merge( $old, $clean );
	update_option( 'murailles_options', $merged );

	$tab = isset( $post['_active_tab'] ) ? sanitize_key( $post['_active_tab'] ) : 'home';
	wp_redirect( admin_url( 'admin.php?page=murailles-options&tab=' . $tab . '&saved=1' ) );
	exit;
} );

/* ─────────────────────────────────────────────────────────────────────────────
   OPTIONS PAGE RENDER
───────────────────────────────────────────────────────────────────────────── */
function murailles_options_page() {
	if ( ! current_user_can( 'manage_options' ) ) { return; }

	$opts    = (array) get_option( 'murailles_options', array() );
	$tab     = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'home';
	$saved   = isset( $_GET['saved'] );

	$tabs = array(
		'home'         => 'Accueil',
		'about'        => 'À propos',
		'contact'      => 'Contact',
		'agency'       => 'Agence',
		'team'         => 'Équipe',
		'testimonials' => 'Témoignages',
		'seo'          => '🔍 SEO & Analytics',
	);

	$o = function( $key, $default = '' ) use ( $opts ) {
		return isset( $opts[ $key ] ) && $opts[ $key ] !== '' ? esc_attr( $opts[ $key ] ) : esc_attr( $default );
	};
	$oh = function( $key, $default = '' ) use ( $opts ) {
		return isset( $opts[ $key ] ) && $opts[ $key ] !== '' ? esc_html( $opts[ $key ] ) : esc_html( $default );
	};
	$ou = function( $key, $default = '' ) use ( $opts ) {
		return isset( $opts[ $key ] ) && $opts[ $key ] !== '' ? esc_url( $opts[ $key ] ) : esc_url( $default );
	};
	?>
	<div class="wrap murailles-options-wrap">
		<h1 style="display:flex;align-items:center;gap:10px;">
			<span class="dashicons dashicons-admin-customizer" style="font-size:28px;color:#dc3545;"></span>
			Options du thème — Murailles Immobilier
		</h1>

		<?php if ( $saved ) : ?>
		<div class="notice notice-success is-dismissible"><p><strong>✅ Options enregistrées avec succès.</strong></p></div>
		<?php endif; ?>

		<!-- Tabs -->
		<nav class="nav-tab-wrapper" style="margin-bottom:0;">
			<?php foreach ( $tabs as $slug => $label ) : ?>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=murailles-options&tab=' . $slug ) ); ?>"
			   class="nav-tab<?php echo ( $tab === $slug ) ? ' nav-tab-active' : ''; ?>">
				<?php echo esc_html( $label ); ?>
			</a>
			<?php endforeach; ?>
		</nav>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" enctype="multipart/form-data" style="background:#fff;padding:24px;border:1px solid #c3c4c7;border-top:none;">
			<?php wp_nonce_field( 'murailles_options_nonce', '_murailles_options_nonce' ); ?>
			<input type="hidden" name="action" value="murailles_save_options">
			<input type="hidden" name="_active_tab" value="<?php echo esc_attr( $tab ); ?>">

			<?php
			// ── Tab: Accueil ──────────────────────────────────────────────────
			if ( $tab === 'home' ) :
			?>
			<h2>Section Hero</h2>
			<table class="form-table">
				<tr><th>Titre H1</th><td><input type="text" name="hero_title" value="<?php echo $o('hero_title','Trouvez votre prochain bien'); ?>" class="regular-text"></td></tr>
				<tr><th>Sous-titre</th><td><input type="text" name="hero_subtitle" value="<?php echo $o('hero_subtitle','Découvrez les nouveaux biens immobiliers à la une dans votre ville.'); ?>" class="large-text"></td></tr>
				<tr>
					<th>Image de fond hero</th>
					<td>
						<input type="hidden" name="hero_bg_url" id="hero_bg_url" value="<?php echo $ou('hero_bg_url'); ?>">
						<?php if ( ! empty( $opts['hero_bg_url'] ) ) : ?>
						<img src="<?php echo esc_url( $opts['hero_bg_url'] ); ?>" style="max-height:80px;display:block;margin-bottom:8px;">
						<?php endif; ?>
						<button type="button" class="button murailles-media-btn" data-target="hero_bg_url">Choisir une image</button>
					</td>
				</tr>
			</table>

			<h2>Comment ça marche</h2>
			<table class="form-table">
				<?php
				$step_defaults = array(
					'step1' => array( 'Explorez nos annonces', 'Parcourez notre sélection de riads, villas et appartements à Marrakech, en location ou à la vente.' ),
					'step2' => array( 'Trouvez votre bien', 'Filtrez par ville, type de bien et budget pour découvrir les biens qui correspondent à vos critères.' ),
					'step3' => array( 'Réservez votre bien', 'Contactez notre équipe pour organiser une visite, négocier le prix et finaliser votre acquisition.' ),
				);
				for ( $i = 1; $i <= 3; $i++ ) :
					$sk = 'step' . $i;
				?>
				<tr><th>Étape <?php echo $i; ?> — Titre</th><td><input type="text" name="how_step<?php echo $i; ?>_title" value="<?php echo $o( 'how_step' . $i . '_title', $step_defaults[$sk][0] ); ?>" class="regular-text"></td></tr>
				<tr><th>Étape <?php echo $i; ?> — Texte</th><td><input type="text" name="how_step<?php echo $i; ?>_text" value="<?php echo $o( 'how_step' . $i . '_text', $step_defaults[$sk][1] ); ?>" class="large-text"></td></tr>
				<?php endfor; ?>
			</table>

			<h2>Section « Qui sommes-nous » (accueil)</h2>
			<table class="form-table">
				<tr>
					<th>Image agence</th>
					<td>
						<input type="hidden" name="about_home_image_url" id="about_home_image_url" value="<?php echo $ou('about_home_image_url'); ?>">
						<?php if ( ! empty( $opts['about_home_image_url'] ) ) : ?>
						<img src="<?php echo esc_url( $opts['about_home_image_url'] ); ?>" style="max-height:80px;display:block;margin-bottom:8px;">
						<?php endif; ?>
						<button type="button" class="button murailles-media-btn" data-target="about_home_image_url">Choisir une image</button>
					</td>
				</tr>
				<tr><th>Badge années d'expérience</th><td><input type="text" name="about_home_years" value="<?php echo $o('about_home_years','15+'); ?>" class="small-text"></td></tr>
				<tr><th>Paragraphe 1</th><td><textarea name="about_home_p1" rows="4" class="large-text"><?php echo isset($opts['about_home_p1']) ? esc_textarea($opts['about_home_p1']) : ''; ?></textarea></td></tr>
				<tr><th>Paragraphe 2 (HTML autorisé)</th><td><textarea name="about_home_p2" rows="6" class="large-text"><?php echo isset($opts['about_home_p2']) ? esc_textarea($opts['about_home_p2']) : ''; ?></textarea></td></tr>
			</table>
			<?php endif; // home ?>

			<?php
			// ── Tab: À propos ─────────────────────────────────────────────────
			if ( $tab === 'about' ) :
			?>
			<h2>Page à propos</h2>
			<table class="form-table">
				<tr>
					<th>Bannière hero</th>
					<td>
						<input type="hidden" name="about_banner_url" id="about_banner_url" value="<?php echo $ou('about_banner_url'); ?>">
						<?php if ( ! empty( $opts['about_banner_url'] ) ) : ?>
						<img src="<?php echo esc_url( $opts['about_banner_url'] ); ?>" style="max-height:80px;display:block;margin-bottom:8px;">
						<?php endif; ?>
						<button type="button" class="button murailles-media-btn" data-target="about_banner_url">Choisir une image</button>
					</td>
				</tr>
				<tr>
					<th>Image section histoire</th>
					<td>
						<input type="hidden" name="about_story_image_url" id="about_story_image_url" value="<?php echo $ou('about_story_image_url'); ?>">
						<?php if ( ! empty( $opts['about_story_image_url'] ) ) : ?>
						<img src="<?php echo esc_url( $opts['about_story_image_url'] ); ?>" style="max-height:80px;display:block;margin-bottom:8px;">
						<?php endif; ?>
						<button type="button" class="button murailles-media-btn" data-target="about_story_image_url">Choisir une image</button>
					</td>
				</tr>
				<tr><th>Titre section histoire</th><td><input type="text" name="about_story_title" value="<?php echo $o('about_story_title','Notre histoire'); ?>" class="regular-text"></td></tr>
				<tr><th>Paragraphe 1</th><td><textarea name="about_story_p1" rows="5" class="large-text"><?php echo isset($opts['about_story_p1']) ? esc_textarea($opts['about_story_p1']) : ''; ?></textarea></td></tr>
				<tr><th>Paragraphe 2</th><td><textarea name="about_story_p2" rows="5" class="large-text"><?php echo isset($opts['about_story_p2']) ? esc_textarea($opts['about_story_p2']) : ''; ?></textarea></td></tr>
			</table>

			<h2>Compteurs & distinctions</h2>
			<table class="form-table">
				<?php
				$counter_defaults = array(
					1 => array('32 M', 'Prix Excellence Immobilier'),
					2 => array('43 M', 'Trophée Service Client'),
					3 => array('51 M', 'Certification Qualité'),
					4 => array('42 M', 'Label Confiance Client'),
				);
				for ( $i = 1; $i <= 4; $i++ ) :
				?>
				<tr>
					<th>Compteur <?php echo $i; ?></th>
					<td>
						<input type="text" name="counter<?php echo $i; ?>_num" value="<?php echo $o('counter'.$i.'_num', $counter_defaults[$i][0]); ?>" class="small-text" placeholder="Valeur">
						<input type="text" name="counter<?php echo $i; ?>_label" value="<?php echo $o('counter'.$i.'_label', $counter_defaults[$i][1]); ?>" class="regular-text" placeholder="Libellé">
					</td>
				</tr>
				<?php endfor; ?>
			</table>
			<?php endif; // about ?>

			<?php
			// ── Tab: Contact ──────────────────────────────────────────────────
			if ( $tab === 'contact' ) :
			?>
			<h2>Contact</h2>
			<table class="form-table">
				<tr>
					<th>Bannière hero</th>
					<td>
						<input type="hidden" name="contact_banner_url" id="contact_banner_url" value="<?php echo $ou('contact_banner_url'); ?>">
						<?php if ( ! empty( $opts['contact_banner_url'] ) ) : ?>
						<img src="<?php echo esc_url( $opts['contact_banner_url'] ); ?>" style="max-height:80px;display:block;margin-bottom:8px;">
						<?php endif; ?>
						<button type="button" class="button murailles-media-btn" data-target="contact_banner_url">Choisir une image</button>
					</td>
				</tr>
				<tr><th>Titre de la page</th><td><input type="text" name="contact_page_title" value="<?php echo $o('contact_page_title','Une équipe à votre écoute'); ?>" class="regular-text"></td></tr>
				<tr><th>Sous-titre</th><td><input type="text" name="contact_page_subtitle" value="<?php echo $o('contact_page_subtitle','Besoin d\'aide pour votre projet immobilier ? Nous sommes joignables 7 jours sur 7.'); ?>" class="large-text"></td></tr>
				<tr><th>Téléphone (affichage)</th><td><input type="text" name="contact_phone" value="<?php echo $o('contact_phone'); ?>" class="regular-text" placeholder="+212 6 XX XX XX XX"></td></tr>
				<tr><th>Téléphone (href tel:)</th><td><input type="text" name="contact_phone_href" value="<?php echo $o('contact_phone_href'); ?>" class="regular-text" placeholder="+212600000000"></td></tr>
				<tr><th>Email</th><td><input type="email" name="contact_email" value="<?php echo $o('contact_email'); ?>" class="regular-text"></td></tr>
				<tr><th>Adresse ligne 1</th><td><input type="text" name="contact_address1" value="<?php echo $o('contact_address1'); ?>" class="regular-text"></td></tr>
				<tr><th>Adresse ligne 2</th><td><input type="text" name="contact_address2" value="<?php echo $o('contact_address2'); ?>" class="regular-text"></td></tr>
				<tr><th>WhatsApp</th><td><input type="text" name="contact_whatsapp" value="<?php echo $o('contact_whatsapp'); ?>" class="regular-text" placeholder="+212600000000"></td></tr>
				<tr><th>URL embed Google Maps</th><td><textarea name="contact_map_url" rows="3" class="large-text"><?php echo isset($opts['contact_map_url']) ? esc_textarea($opts['contact_map_url']) : ''; ?></textarea><p class="description">Copier la valeur de l'attribut src="..." de l'iframe Google Maps.</p></td></tr>
			</table>
			<?php endif; // contact ?>

			<?php
			// ── Tab: Agence ───────────────────────────────────────────────────
			if ( $tab === 'agency' ) :
			?>
			<h2>Informations agence</h2>
			<table class="form-table">
				<tr><th>Nom de l'agence</th><td><input type="text" name="agency_name" value="<?php echo $o('agency_name','Murailles Immobilier'); ?>" class="regular-text"></td></tr>
				<tr><th>Accroche / tagline</th><td><input type="text" name="agency_tagline" value="<?php echo $o('agency_tagline'); ?>" class="regular-text"></td></tr>
				<tr>
					<th>Logo (fond clair)</th>
					<td>
						<input type="hidden" name="agency_logo_url" id="agency_logo_url" value="<?php echo $ou('agency_logo_url'); ?>">
						<?php if ( ! empty( $opts['agency_logo_url'] ) ) : ?>
						<img src="<?php echo esc_url( $opts['agency_logo_url'] ); ?>" style="max-height:60px;display:block;margin-bottom:8px;">
						<?php endif; ?>
						<button type="button" class="button murailles-media-btn" data-target="agency_logo_url">Choisir une image</button>
					</td>
				</tr>
				<tr>
					<th>Logo (fond transparent/sombre)</th>
					<td>
						<input type="hidden" name="agency_logo_white_url" id="agency_logo_white_url" value="<?php echo $ou('agency_logo_white_url'); ?>">
						<?php if ( ! empty( $opts['agency_logo_white_url'] ) ) : ?>
						<img src="<?php echo esc_url( $opts['agency_logo_white_url'] ); ?>" style="max-height:60px;display:block;margin-bottom:8px;background:#1a2332;padding:8px;">
						<?php endif; ?>
						<button type="button" class="button murailles-media-btn" data-target="agency_logo_white_url">Choisir une image</button>
					</td>
				</tr>
				<tr><th>Fondateur</th><td><input type="text" name="agency_founder" value="<?php echo $o('agency_founder','Youssef MOUMEN'); ?>" class="regular-text"></td></tr>
				<tr><th>Années d'expérience</th><td><input type="text" name="agency_years" value="<?php echo $o('agency_years','15+'); ?>" class="small-text"></td></tr>
			</table>
			<h2>Réseaux sociaux</h2>
			<table class="form-table">
				<tr><th>Facebook</th><td><input type="url" name="social_facebook" value="<?php echo $ou('social_facebook'); ?>" class="regular-text" placeholder="https://facebook.com/..."></td></tr>
				<tr><th>Instagram</th><td><input type="url" name="social_instagram" value="<?php echo $ou('social_instagram'); ?>" class="regular-text" placeholder="https://instagram.com/..."></td></tr>
				<tr><th>LinkedIn</th><td><input type="url" name="social_linkedin" value="<?php echo $ou('social_linkedin'); ?>" class="regular-text"></td></tr>
				<tr><th>Twitter / X</th><td><input type="url" name="social_twitter" value="<?php echo $ou('social_twitter'); ?>" class="regular-text"></td></tr>
			</table>
			<?php endif; // agency ?>

			<?php
			// ── Tab: Équipe ───────────────────────────────────────────────────
			if ( $tab === 'team' ) :
				$team_members = isset( $opts['team_members'] ) && is_array( $opts['team_members'] ) ? $opts['team_members'] : array(
					array( 'name' => 'Youssef Moumen', 'role' => 'PDG & Fondateur', 'photo_url' => '', 'facebook' => '#', 'instagram' => '#', 'linkedin' => '#', 'twitter' => '#' ),
					array( 'name' => 'Équipe Murailles', 'role' => 'Conseillers immobiliers', 'photo_url' => '', 'facebook' => '#', 'instagram' => '#', 'linkedin' => '#', 'twitter' => '#' ),
				);
			?>
			<h2>Membres de l'équipe</h2>
			<p class="description">Ajoutez, modifiez ou supprimez les membres de l'équipe.</p>
			<div id="murailles-team-repeater">
				<?php foreach ( $team_members as $i => $member ) : ?>
				<div class="murailles-repeater-row" style="background:#f9f9f9;border:1px solid #e0e0e0;padding:16px;margin-bottom:12px;border-radius:6px;">
					<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;">
						<div>
							<label>Photo</label><br>
							<input type="hidden" name="team_members[<?php echo $i; ?>][photo_url]" class="murailles-media-input" value="<?php echo esc_attr( $member['photo_url'] ?? '' ); ?>">
							<?php if ( ! empty( $member['photo_url'] ) ) : ?>
							<img src="<?php echo esc_url( $member['photo_url'] ); ?>" style="max-height:60px;display:block;margin-bottom:6px;border-radius:50%;">
							<?php endif; ?>
							<button type="button" class="button murailles-media-btn-row">Photo</button>
						</div>
						<div>
							<label>Nom</label><br>
							<input type="text" name="team_members[<?php echo $i; ?>][name]" value="<?php echo esc_attr( $member['name'] ?? '' ); ?>" class="regular-text">
						</div>
						<div>
							<label>Rôle / Fonction</label><br>
							<input type="text" name="team_members[<?php echo $i; ?>][role]" value="<?php echo esc_attr( $member['role'] ?? '' ); ?>" class="regular-text">
						</div>
						<div>
							<label>Facebook URL</label><br>
							<input type="url" name="team_members[<?php echo $i; ?>][facebook]" value="<?php echo esc_attr( $member['facebook'] ?? '#' ); ?>" class="regular-text">
						</div>
						<div>
							<label>Instagram URL</label><br>
							<input type="url" name="team_members[<?php echo $i; ?>][instagram]" value="<?php echo esc_attr( $member['instagram'] ?? '#' ); ?>" class="regular-text">
						</div>
						<div>
							<label>LinkedIn URL</label><br>
							<input type="url" name="team_members[<?php echo $i; ?>][linkedin]" value="<?php echo esc_attr( $member['linkedin'] ?? '#' ); ?>" class="regular-text">
						</div>
					</div>
					<p><button type="button" class="button button-link-delete murailles-remove-team-row">Supprimer ce membre</button></p>
				</div>
				<?php endforeach; ?>
			</div>
			<button type="button" class="button button-primary" id="murailles-add-team">+ Ajouter un membre</button>
			<?php endif; // team ?>

			<?php
			// ── Tab: Témoignages ──────────────────────────────────────────────
			if ( $tab === 'testimonials' ) :
				$testimonials = isset( $opts['testimonials'] ) && is_array( $opts['testimonials'] ) ? $opts['testimonials'] : array(
					array( 'name' => 'Susan D. Murphy',       'role' => 'Acheteuse — Paris',    'photo_url' => 'https://i.pravatar.cc/96?img=1', 'rating' => 4.9, 'text' => 'Service exceptionnel, équipe très professionnelle.' ),
					array( 'name' => 'Maxine E. Gagliardi',   'role' => 'Investisseur — Lyon',  'photo_url' => 'https://i.pravatar.cc/96?img=2', 'rating' => 4.8, 'text' => 'Excellent accompagnement pour mon riad à Marrakech.' ),
					array( 'name' => 'Roy M. Cardona',        'role' => 'Locataire — Madrid',   'photo_url' => 'https://i.pravatar.cc/96?img=3', 'rating' => 4.7, 'text' => 'Très bonne expérience, je recommande vivement.' ),
					array( 'name' => 'Dorothy K. Shipton',    'role' => 'Vendeuse — Casablanca','photo_url' => 'https://i.pravatar.cc/96?img=4', 'rating' => 4.8, 'text' => 'Vente conclue rapidement et aux meilleures conditions.' ),
					array( 'name' => 'Robert P. McKissack',   'role' => 'Acheteur — Genève',    'photo_url' => 'https://i.pravatar.cc/96?img=5', 'rating' => 4.9, 'text' => 'Murailles Immobilier : la référence pour investir au Maroc.' ),
				);
			?>
			<h2>Témoignages clients</h2>
			<p class="description">Ajoutez, modifiez ou supprimez les avis clients affichés sur le site.</p>
			<div id="murailles-testi-repeater">
				<?php foreach ( $testimonials as $i => $t ) : ?>
				<div class="murailles-repeater-row" style="background:#f9f9f9;border:1px solid #e0e0e0;padding:16px;margin-bottom:12px;border-radius:6px;">
					<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;">
						<div>
							<label>Photo URL</label><br>
							<input type="text" name="testimonials[<?php echo $i; ?>][photo_url]" value="<?php echo esc_attr( $t['photo_url'] ?? '' ); ?>" class="regular-text" placeholder="URL ou lien Gravatar">
						</div>
						<div>
							<label>Nom</label><br>
							<input type="text" name="testimonials[<?php echo $i; ?>][name]" value="<?php echo esc_attr( $t['name'] ?? '' ); ?>" class="regular-text">
						</div>
						<div>
							<label>Rôle / Ville</label><br>
							<input type="text" name="testimonials[<?php echo $i; ?>][role]" value="<?php echo esc_attr( $t['role'] ?? '' ); ?>" class="regular-text">
						</div>
						<div>
							<label>Note (ex: 4.8)</label><br>
							<input type="number" name="testimonials[<?php echo $i; ?>][rating]" value="<?php echo esc_attr( $t['rating'] ?? 5 ); ?>" min="1" max="5" step="0.1" class="small-text">
						</div>
						<div style="grid-column:span 2;">
							<label>Texte du témoignage</label><br>
							<textarea name="testimonials[<?php echo $i; ?>][text]" rows="3" class="large-text"><?php echo esc_textarea( $t['text'] ?? '' ); ?></textarea>
						</div>
					</div>
					<p><button type="button" class="button button-link-delete murailles-remove-testi-row">Supprimer ce témoignage</button></p>
				</div>
				<?php endforeach; ?>
			</div>
			<button type="button" class="button button-primary" id="murailles-add-testi">+ Ajouter un témoignage</button>
			<?php endif; // testimonials ?>

			<?php
			// ── Tab: SEO & Analytics ──────────────────────────────────────────
			if ( $tab === 'seo' ) :
			?>
			<h2>Google Analytics & Tag Manager</h2>
			<table class="form-table">
				<tr><th>Google Tag Manager ID</th><td><input type="text" name="seo_gtm_id" value="<?php echo $o('seo_gtm_id'); ?>" class="regular-text" placeholder="GTM-XXXXXXX"><p class="description">Prioritaire sur GA4 si renseigné.</p></td></tr>
				<tr><th>Google Analytics 4 ID</th><td><input type="text" name="seo_ga4_id" value="<?php echo $o('seo_ga4_id'); ?>" class="regular-text" placeholder="G-XXXXXXXXXX"></td></tr>
			</table>
			<h2>Vérification des moteurs de recherche</h2>
			<table class="form-table">
				<tr><th>Google Search Console</th><td><input type="text" name="seo_google_verif" value="<?php echo $o('seo_google_verif'); ?>" class="regular-text" placeholder="Valeur content= uniquement"></td></tr>
				<tr><th>Bing Webmaster Tools</th><td><input type="text" name="seo_bing_verif" value="<?php echo $o('seo_bing_verif'); ?>" class="regular-text" placeholder="Valeur content= uniquement"></td></tr>
			</table>
			<h2>Réseaux sociaux & Open Graph</h2>
			<table class="form-table">
				<tr>
					<th>Image OG par défaut (1200×630)</th>
					<td>
						<input type="hidden" name="seo_default_og_image" id="seo_default_og_image" value="<?php echo $ou('seo_default_og_image'); ?>">
						<?php if ( ! empty( $opts['seo_default_og_image'] ) ) : ?>
						<img src="<?php echo esc_url( $opts['seo_default_og_image'] ); ?>" style="max-height:80px;display:block;margin-bottom:8px;">
						<?php endif; ?>
						<button type="button" class="button murailles-media-btn" data-target="seo_default_og_image">Choisir une image</button>
					</td>
				</tr>
				<tr><th>Twitter/X Handle</th><td><input type="text" name="seo_twitter_handle" value="<?php echo $o('seo_twitter_handle'); ?>" class="regular-text" placeholder="@MuraillesImmo"></td></tr>
				<tr><th>Facebook App ID</th><td><input type="text" name="seo_facebook_app_id" value="<?php echo $o('seo_facebook_app_id'); ?>" class="regular-text"></td></tr>
				<tr><th>Description du site (120-155 car.)</th><td><textarea name="seo_site_description" rows="3" class="large-text"><?php echo isset($opts['seo_site_description']) ? esc_textarea($opts['seo_site_description']) : ''; ?></textarea></td></tr>
			</table>
			<?php endif; // seo ?>

			<p class="submit">
				<button type="submit" class="button button-primary button-large">💾 Enregistrer les options</button>
			</p>
		</form>
	</div>

	<script>
	(function($){
		// Media uploader for single image buttons
		$(document).on('click', '.murailles-media-btn', function(e){
			e.preventDefault();
			var target = $(this).data('target');
			var frame = wp.media({ title: 'Choisir une image', button: { text: 'Utiliser' }, multiple: false });
			frame.on('select', function(){
				var url = frame.state().get('selection').first().toJSON().url;
				$('#'+target).val(url);
				var $btn = $('[data-target="'+target+'"]');
				var $img = $btn.prev('img');
				if ($img.length) { $img.attr('src', url); }
				else { $btn.before('<img src="'+url+'" style="max-height:80px;display:block;margin-bottom:8px;">'); }
			});
			frame.open();
		});

		// Remove team / testimonial rows
		$(document).on('click', '.murailles-remove-team-row, .murailles-remove-testi-row', function(){
			if (confirm('Supprimer cet élément ?')) {
				$(this).closest('.murailles-repeater-row').remove();
			}
		});
	})(jQuery);
	</script>
	<?php
}
