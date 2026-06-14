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

function murailles_theme_testimonial_default_rows( $lang = 'fr' ) {
	$rows = array(
		'fr' => array(
			array( 'name' => 'Susan D. Murphy',     'role' => 'Proprietaire',            'photo_url' => 'https://i.pravatar.cc/96?img=47', 'rating' => 4.7, 'text' => "L'equipe d'Agence Murailles m'a accompagnee du premier rendez-vous a la signature. Service reactif, conseils avises et belle selection de biens a Marrakech." ),
			array( 'name' => 'Maxine E. Gagliardi', 'role' => 'Acheteuse, Marrakech',    'photo_url' => 'https://i.pravatar.cc/96?img=32', 'rating' => 4.5, 'text' => "L'equipe d'Agence Murailles m'a accompagnee du premier rendez-vous a la signature. Service reactif, conseils avises et belle selection de biens a Marrakech." ),
			array( 'name' => 'Roy M. Cardona',      'role' => 'Investisseur',            'photo_url' => 'https://i.pravatar.cc/96?img=12', 'rating' => 4.9, 'text' => "L'equipe d'Agence Murailles m'a accompagnee du premier rendez-vous a la signature. Service reactif, conseils avises et belle selection de biens a Marrakech." ),
			array( 'name' => 'Dorothy K. Shipton',  'role' => 'Locataire, Casablanca',   'photo_url' => 'https://i.pravatar.cc/96?img=45', 'rating' => 4.7, 'text' => "L'equipe d'Agence Murailles m'a accompagnee du premier rendez-vous a la signature. Service reactif, conseils avises et belle selection de biens a Marrakech." ),
			array( 'name' => 'Robert P. McKissack', 'role' => 'Proprietaire',            'photo_url' => 'https://i.pravatar.cc/96?img=68', 'rating' => 4.7, 'text' => "L'equipe d'Agence Murailles m'a accompagnee du premier rendez-vous a la signature. Service reactif, conseils avises et belle selection de biens a Marrakech." ),
		),
		'en' => array(
			array( 'name' => 'Susan D. Murphy',     'role' => 'Owner',                   'photo_url' => 'https://i.pravatar.cc/96?img=47', 'rating' => 4.7, 'text' => 'The Agence Murailles team supported me from the first meeting to the final signature. Responsive service, sound advice and a strong selection of properties in Marrakech.' ),
			array( 'name' => 'Maxine E. Gagliardi', 'role' => 'Buyer, Marrakech',       'photo_url' => 'https://i.pravatar.cc/96?img=32', 'rating' => 4.5, 'text' => 'The Agence Murailles team supported me from the first meeting to the final signature. Responsive service, sound advice and a strong selection of properties in Marrakech.' ),
			array( 'name' => 'Roy M. Cardona',      'role' => 'Investor',                'photo_url' => 'https://i.pravatar.cc/96?img=12', 'rating' => 4.9, 'text' => 'The Agence Murailles team supported me from the first meeting to the final signature. Responsive service, sound advice and a strong selection of properties in Marrakech.' ),
			array( 'name' => 'Dorothy K. Shipton',  'role' => 'Tenant, Casablanca',      'photo_url' => 'https://i.pravatar.cc/96?img=45', 'rating' => 4.7, 'text' => 'The Agence Murailles team supported me from the first meeting to the final signature. Responsive service, sound advice and a strong selection of properties in Marrakech.' ),
			array( 'name' => 'Robert P. McKissack', 'role' => 'Owner',                   'photo_url' => 'https://i.pravatar.cc/96?img=68', 'rating' => 4.7, 'text' => 'The Agence Murailles team supported me from the first meeting to the final signature. Responsive service, sound advice and a strong selection of properties in Marrakech.' ),
		),
	);

	return isset( $rows[ $lang ] ) ? $rows[ $lang ] : $rows['fr'];
}

function murailles_sanitize_rating_value( $value, $default = 5, $allow_empty = false ) {
	$value = trim( str_replace( ',', '.', (string) $value ) );
	if ( '' === $value ) {
		return $allow_empty ? '' : (float) $default;
	}

	if ( ! is_numeric( $value ) ) {
		$value = preg_replace( '/[^0-9.\\-]/', '', $value );
	}

	if ( ! is_numeric( $value ) ) {
		return $allow_empty ? '' : (float) $default;
	}

	$rating = (float) $value;
	$rating = max( 0, min( 5, $rating ) );

	return round( $rating, 1 );
}

function murailles_sanitize_testimonial_rows( $rows ) {
	$clean = array();

	if ( ! is_array( $rows ) ) {
		return $clean;
	}

	foreach ( $rows as $row ) {
		if ( empty( $row['name'] ) ) {
			continue;
		}

		$clean[] = array(
			'name'      => sanitize_text_field( $row['name'] ?? '' ),
			'role'      => sanitize_text_field( $row['role'] ?? '' ),
			'photo_id'  => absint( $row['photo_id'] ?? 0 ),
			'photo_url' => esc_url_raw( $row['photo_url'] ?? '' ),
			'rating'    => murailles_sanitize_rating_value( $row['rating'] ?? 5 ),
			'text'      => sanitize_textarea_field( $row['text'] ?? '' ),
		);
	}

	return $clean;
}

function murailles_theme_testimonial_rows_for_admin( $lang = 'fr', $opts = null ) {
	if ( ! in_array( $lang, array( 'fr', 'en' ), true ) ) {
		$lang = 'fr';
	}

	if ( null === $opts ) {
		$opts = (array) get_option( 'murailles_options', array() );
	}

	$key = 'testimonials_' . $lang;

	if ( array_key_exists( $key, $opts ) && is_array( $opts[ $key ] ) ) {
		return $opts[ $key ];
	}

	if ( 'fr' === $lang && array_key_exists( 'testimonials', $opts ) && is_array( $opts['testimonials'] ) ) {
		return $opts['testimonials'];
	}

	return murailles_theme_testimonial_default_rows( $lang );
}

function murailles_theme_testimonial_rows_to_page_meta( $rows ) {
	$mapped = array();

	foreach ( (array) $rows as $row ) {
		if ( empty( $row['name'] ) ) {
			continue;
		}

		$mapped[] = array(
			'person_name' => sanitize_text_field( $row['name'] ?? '' ),
			'person_role' => sanitize_text_field( $row['role'] ?? '' ),
			'rating'      => murailles_sanitize_rating_value( $row['rating'] ?? 5 ),
			'description' => sanitize_textarea_field( $row['text'] ?? '' ),
			'image_id'    => absint( $row['photo_id'] ?? 0 ),
			'image_url'   => esc_url_raw( $row['photo_url'] ?? '' ),
			'alt_text'    => sanitize_text_field( $row['name'] ?? '' ),
		);
	}

	return $mapped;
}

function murailles_theme_options_render_testimonial_photo_field( $input_prefix, $row ) {
	$photo_id  = absint( $row['photo_id'] ?? 0 );
	$photo_url = esc_url_raw( $row['photo_url'] ?? '' );
	$preview   = $photo_id ? wp_get_attachment_image_url( $photo_id, 'thumbnail' ) : $photo_url;
	?>
	<div class="murailles-testi-photo-control">
		<label><?php esc_html_e( 'Photo', 'murailles' ); ?></label><br>
		<input type="hidden" name="<?php echo esc_attr( $input_prefix . '[photo_id]' ); ?>" class="murailles-testi-photo-id" value="<?php echo esc_attr( $photo_id ); ?>">
		<div class="murailles-option-image-preview<?php echo $preview ? '' : ' is-empty'; ?>" style="min-height:74px;margin:6px 0;">
			<?php if ( $preview ) : ?>
				<img src="<?php echo esc_url( $preview ); ?>" style="width:72px;height:72px;object-fit:cover;border-radius:50%;display:block;">
			<?php else : ?>
				<span style="display:inline-block;color:#646970;font-size:12px;"><?php esc_html_e( 'No image selected', 'murailles' ); ?></span>
			<?php endif; ?>
		</div>
		<button type="button" class="button murailles-testi-media-btn"><?php esc_html_e( 'Choose image', 'murailles' ); ?></button>
		<button type="button" class="button-link-delete murailles-testi-media-clear<?php echo ( $photo_id || $photo_url ) ? '' : ' is-hidden'; ?>" style="<?php echo ( $photo_id || $photo_url ) ? '' : 'display:none;'; ?>"><?php esc_html_e( 'Remove', 'murailles' ); ?></button>
		<p style="margin:8px 0 0;">
			<label><?php esc_html_e( 'Fallback image URL', 'murailles' ); ?></label><br>
			<input type="url" name="<?php echo esc_attr( $input_prefix . '[photo_url]' ); ?>" value="<?php echo esc_attr( $photo_url ); ?>" class="regular-text murailles-testi-photo-url" placeholder="https://...">
		</p>
	</div>
	<?php
}

function murailles_get_theme_option_testimonials( $lang = '', $default = array() ) {
	if ( ! $lang ) {
		$lang = function_exists( 'murailles_current_lang' ) ? murailles_current_lang() : 'fr';
	}
	if ( ! in_array( $lang, array( 'fr', 'en' ), true ) ) {
		$lang = 'fr';
	}

	$opts = (array) get_option( 'murailles_options', array() );
	$key  = 'testimonials_' . $lang;

	if ( array_key_exists( $key, $opts ) && is_array( $opts[ $key ] ) ) {
		return murailles_theme_testimonial_rows_to_page_meta( $opts[ $key ] );
	}

	if ( 'fr' === $lang && array_key_exists( 'testimonials', $opts ) && is_array( $opts['testimonials'] ) ) {
		return murailles_theme_testimonial_rows_to_page_meta( $opts['testimonials'] );
	}

	return $default;
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
	wp_enqueue_media(); // registers wp.media (depends on jQuery, loaded by core)

	// Phase 1 redesign: dedicated premium stylesheet for the options page only.
	wp_enqueue_style(
		'murailles-theme-options-css',
		get_template_directory_uri() . '/inc/theme-options.css',
		array(),
		'2.0'
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
	foreach ( array( 'fr', 'en' ) as $lang ) {
		$field = 'testimonials_' . $lang;
		if ( isset( $post[ $field ] ) && is_array( $post[ $field ] ) ) {
			$clean[ $field ] = murailles_sanitize_testimonial_rows( $post[ $field ] );
		}
	}
	if ( isset( $clean['testimonials_fr'] ) ) {
		$clean['testimonials'] = $clean['testimonials_fr'];
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

	$o = function( $key, $default = '' ) use ( $opts ) {
		return isset( $opts[ $key ] ) && $opts[ $key ] !== '' ? esc_attr( $opts[ $key ] ) : esc_attr( $default );
	};
	$ou = function( $key, $default = '' ) use ( $opts ) {
		return isset( $opts[ $key ] ) && $opts[ $key ] !== '' ? esc_url( $opts[ $key ] ) : esc_url( $default );
	};

	// Sidebar navigation: icon + label + description. Slugs preserved for back-compat.
	$nav = array(
		'home'         => array( '🖼️', 'Accueil',      'Hero, étapes et présentation' ),
		'about'        => array( '📖', 'À propos',      'Histoire et distinctions' ),
		'contact'      => array( '📞', 'Contact',       'Coordonnées et carte' ),
		'agency'       => array( '🏢', 'Agence',        'Identité, logos, réseaux' ),
		'team'         => array( '👥', 'Équipe',        'Membres et fonctions' ),
		'testimonials' => array( '💬', 'Témoignages',   'Avis clients FR / EN' ),
		'seo'          => array( '🔍', 'SEO & Analytics', 'Référencement et suivi' ),
	);
	if ( ! isset( $nav[ $tab ] ) ) { $tab = 'home'; }

	/**
	 * Renders the modern "media field" card. Wraps the existing single-image
	 * hidden-input pattern (name + #id + .murailles-media-btn[data-target]) so
	 * the proven inline jQuery uploader keeps working unchanged.
	 */
	$media_field = function ( $name, $label, $reco = '', $current = '' ) {
		$id = $name;
		?>
		<div class="mi-field">
			<label><?php echo esc_html( $label ); ?></label>
			<div class="mi-media">
				<div class="mi-media-preview<?php echo $current ? '' : ''; ?>">
					<?php if ( $current ) : ?>
						<img src="<?php echo esc_url( $current ); ?>" alt="">
					<?php endif; ?>
					<span class="mi-media-empty" style="<?php echo $current ? 'display:none;' : ''; ?>">
						<span class="dashicons dashicons-format-image"></span>
						<?php esc_html_e( 'Aucune image', 'murailles' ); ?>
					</span>
				</div>
				<div class="mi-media-meta">
					<?php if ( $reco ) : ?><span class="mi-media-reco"><?php echo esc_html( $reco ); ?></span><br><?php endif; ?>
					<input type="hidden" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $id ); ?>" value="<?php echo esc_url( $current ); ?>">
					<div class="mi-media-buttons">
						<button type="button" class="mi-btn murailles-media-btn" data-target="<?php echo esc_attr( $id ); ?>">
							<span class="dashicons dashicons-upload"></span><?php echo $current ? esc_html__( 'Remplacer', 'murailles' ) : esc_html__( 'Choisir une image', 'murailles' ); ?>
						</button>
						<button type="button" class="mi-btn mi-btn-danger murailles-media-clear" data-target="<?php echo esc_attr( $id ); ?>" style="<?php echo $current ? '' : 'display:none;'; ?>">
							<span class="dashicons dashicons-trash"></span><?php esc_html_e( 'Retirer', 'murailles' ); ?>
						</button>
					</div>
					<span class="mi-hint"><?php esc_html_e( 'Glissez une image ici ou cliquez pour choisir dans la médiathèque.', 'murailles' ); ?></span>
				</div>
			</div>
		</div>
		<?php
	};
	?>
	<div class="wrap murailles-options-wrap murailles-app">

		<div class="mi-topbar">
			<span class="mi-logo">🏛️</span>
			<h1>Options du thème<small>Murailles Immobilier — gérez le contenu de votre site sans code</small></h1>
		</div>

		<div class="mi-shell">
			<!-- Sidebar -->
			<nav class="mi-sidebar" aria-label="<?php esc_attr_e( 'Sections des options', 'murailles' ); ?>">
				<div class="mi-nav">
					<?php foreach ( $nav as $slug => $meta ) : ?>
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=murailles-options&tab=' . $slug ) ); ?>"
					   class="mi-nav-item<?php echo ( $tab === $slug ) ? ' is-active' : ''; ?>"
					   <?php echo ( $tab === $slug ) ? 'aria-current="page"' : ''; ?>>
						<span class="mi-nav-ico" aria-hidden="true"><?php echo $meta[0]; // emoji ?></span>
						<span class="mi-nav-txt">
							<span class="mi-nav-label"><?php echo esc_html( $meta[1] ); ?></span>
							<span class="mi-nav-desc"><?php echo esc_html( $meta[2] ); ?></span>
						</span>
					</a>
					<?php endforeach; ?>
				</div>
			</nav>

			<!-- Content -->
			<div class="mi-content">

			<?php if ( $saved ) : ?>
			<div class="mi-toast" role="status"><span class="dashicons dashicons-yes-alt"></span> <?php esc_html_e( 'Options enregistrées avec succès.', 'murailles' ); ?></div>
			<?php endif; ?>

			<div class="mi-panel-head">
				<h2><?php echo $nav[ $tab ][0] . ' ' . esc_html( $nav[ $tab ][1] ); ?></h2>
				<p><?php echo esc_html( $nav[ $tab ][2] ); ?></p>
			</div>

			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" enctype="multipart/form-data">
			<?php wp_nonce_field( 'murailles_options_nonce', '_murailles_options_nonce' ); ?>
			<input type="hidden" name="action" value="murailles_save_options">
			<input type="hidden" name="_active_tab" value="<?php echo esc_attr( $tab ); ?>">

			<?php
			// ── Tab: Accueil ──────────────────────────────────────────────────
			if ( $tab === 'home' ) :
			?>
			<div class="mi-card">
				<div class="mi-card-head"><span class="mi-card-ico">🎯</span><h3>Section Hero</h3><span class="mi-card-sub">Haut de la page d'accueil</span></div>
				<div class="mi-card-body">
					<div class="mi-field">
						<label>Titre principal (H1)</label>
						<input type="text" name="hero_title" value="<?php echo $o('hero_title','Trouvez votre prochain bien'); ?>">
					</div>
					<div class="mi-field">
						<label>Sous-titre</label>
						<input type="text" name="hero_subtitle" value="<?php echo $o('hero_subtitle','Découvrez les nouveaux biens immobiliers à la une dans votre ville.'); ?>">
					</div>
					<?php $media_field( 'hero_bg_url', "Image de fond du hero", 'Recommandé : 1920 × 1080 px', $ou('hero_bg_url') ); ?>
				</div>
			</div>

			<div class="mi-card">
				<div class="mi-card-head"><span class="mi-card-ico">🧭</span><h3>Comment ça marche</h3><span class="mi-card-sub">Les 3 étapes</span></div>
				<div class="mi-card-body">
					<?php
					$step_defaults = array(
						'step1' => array( 'Explorez nos annonces', 'Parcourez notre sélection de riads, villas et appartements à Marrakech, en location ou à la vente.' ),
						'step2' => array( 'Trouvez votre bien', 'Filtrez par ville, type de bien et budget pour découvrir les biens qui correspondent à vos critères.' ),
						'step3' => array( 'Réservez votre bien', 'Contactez notre équipe pour organiser une visite, négocier le prix et finaliser votre acquisition.' ),
					);
					for ( $i = 1; $i <= 3; $i++ ) :
						$sk = 'step' . $i;
					?>
					<div class="mi-grid-2">
						<div class="mi-field">
							<label>Étape <?php echo $i; ?> — Titre</label>
							<input type="text" name="how_step<?php echo $i; ?>_title" value="<?php echo $o( 'how_step' . $i . '_title', $step_defaults[$sk][0] ); ?>">
						</div>
						<div class="mi-field">
							<label>Étape <?php echo $i; ?> — Texte</label>
							<input type="text" name="how_step<?php echo $i; ?>_text" value="<?php echo $o( 'how_step' . $i . '_text', $step_defaults[$sk][1] ); ?>">
						</div>
					</div>
					<?php if ( $i < 3 ) : ?><hr style="border:none;border-top:1px solid #eef0f2;margin:16px 0;"><?php endif; ?>
					<?php endfor; ?>
				</div>
			</div>

			<div class="mi-card">
				<div class="mi-card-head"><span class="mi-card-ico">🤝</span><h3>« Qui sommes-nous »</h3><span class="mi-card-sub">Bloc présentation accueil</span></div>
				<div class="mi-card-body">
					<?php $media_field( 'about_home_image_url', "Image de l'agence", 'Recommandé : 800 × 1000 px', $ou('about_home_image_url') ); ?>
					<div class="mi-field">
						<label>Badge années d'expérience</label>
						<input type="text" name="about_home_years" value="<?php echo $o('about_home_years','15+'); ?>" class="is-short">
					</div>
					<div class="mi-field">
						<label>Paragraphe 1</label>
						<textarea name="about_home_p1" rows="4"><?php echo isset($opts['about_home_p1']) ? esc_textarea($opts['about_home_p1']) : ''; ?></textarea>
					</div>
					<div class="mi-field">
						<label>Paragraphe 2 <span style="font-weight:400;color:#8c8f94;">(HTML autorisé)</span></label>
						<textarea name="about_home_p2" rows="6"><?php echo isset($opts['about_home_p2']) ? esc_textarea($opts['about_home_p2']) : ''; ?></textarea>
					</div>
				</div>
			</div>
			<?php endif; // home ?>

			<?php
			// ── Tab: À propos ─────────────────────────────────────────────────
			if ( $tab === 'about' ) :
			?>
			<div class="mi-card">
				<div class="mi-card-head"><span class="mi-card-ico">📖</span><h3>Notre histoire</h3><span class="mi-card-sub">Page « À propos »</span></div>
				<div class="mi-card-body">
					<?php $media_field( 'about_banner_url', 'Bannière hero', 'Recommandé : 1920 × 600 px', $ou('about_banner_url') ); ?>
					<?php $media_field( 'about_story_image_url', "Image section histoire", 'Recommandé : 800 × 1000 px', $ou('about_story_image_url') ); ?>
					<div class="mi-field">
						<label>Titre de la section histoire</label>
						<input type="text" name="about_story_title" value="<?php echo $o('about_story_title','Notre histoire'); ?>">
					</div>
					<div class="mi-field">
						<label>Paragraphe 1</label>
						<textarea name="about_story_p1" rows="5"><?php echo isset($opts['about_story_p1']) ? esc_textarea($opts['about_story_p1']) : ''; ?></textarea>
					</div>
					<div class="mi-field">
						<label>Paragraphe 2</label>
						<textarea name="about_story_p2" rows="5"><?php echo isset($opts['about_story_p2']) ? esc_textarea($opts['about_story_p2']) : ''; ?></textarea>
					</div>
				</div>
			</div>

			<div class="mi-card">
				<div class="mi-card-head"><span class="mi-card-ico">🏆</span><h3>Compteurs & distinctions</h3><span class="mi-card-sub">4 indicateurs</span></div>
				<div class="mi-card-body">
					<?php
					$counter_defaults = array(
						1 => array('32 M', 'Prix Excellence Immobilier'),
						2 => array('43 M', 'Trophée Service Client'),
						3 => array('51 M', 'Certification Qualité'),
						4 => array('42 M', 'Label Confiance Client'),
					);
					for ( $i = 1; $i <= 4; $i++ ) :
					?>
					<div class="mi-grid-2">
						<div class="mi-field">
							<label>Compteur <?php echo $i; ?> — Valeur</label>
							<input type="text" name="counter<?php echo $i; ?>_num" value="<?php echo $o('counter'.$i.'_num', $counter_defaults[$i][0]); ?>" class="is-short" placeholder="Valeur">
						</div>
						<div class="mi-field">
							<label>Compteur <?php echo $i; ?> — Libellé</label>
							<input type="text" name="counter<?php echo $i; ?>_label" value="<?php echo $o('counter'.$i.'_label', $counter_defaults[$i][1]); ?>" placeholder="Libellé">
						</div>
					</div>
					<?php if ( $i < 4 ) : ?><hr style="border:none;border-top:1px solid #eef0f2;margin:16px 0;"><?php endif; ?>
					<?php endfor; ?>
				</div>
			</div>
			<?php endif; // about ?>

			<?php
			// ── Tab: Contact ──────────────────────────────────────────────────
			if ( $tab === 'contact' ) :
			?>
			<div class="mi-card">
				<div class="mi-card-head"><span class="mi-card-ico">📞</span><h3>Coordonnées</h3><span class="mi-card-sub">Affichées sur la page contact</span></div>
				<div class="mi-card-body">
					<?php $media_field( 'contact_banner_url', 'Bannière hero', 'Recommandé : 1920 × 600 px', $ou('contact_banner_url') ); ?>
					<div class="mi-grid-2">
						<div class="mi-field"><label>Titre de la page</label><input type="text" name="contact_page_title" value="<?php echo $o('contact_page_title','Une équipe à votre écoute'); ?>"></div>
						<div class="mi-field"><label>Sous-titre</label><input type="text" name="contact_page_subtitle" value="<?php echo $o('contact_page_subtitle','Besoin d\'aide pour votre projet immobilier ? Nous sommes joignables 7 jours sur 7.'); ?>"></div>
						<div class="mi-field"><label>Téléphone (affichage)</label><input type="text" name="contact_phone" value="<?php echo $o('contact_phone'); ?>" placeholder="+212 6 XX XX XX XX"></div>
						<div class="mi-field"><label>Téléphone (lien tel:)</label><input type="text" name="contact_phone_href" value="<?php echo $o('contact_phone_href'); ?>" placeholder="+212600000000"></div>
						<div class="mi-field"><label>Email</label><input type="email" name="contact_email" value="<?php echo $o('contact_email'); ?>"></div>
						<div class="mi-field"><label>WhatsApp</label><input type="text" name="contact_whatsapp" value="<?php echo $o('contact_whatsapp'); ?>" placeholder="+212600000000"></div>
						<div class="mi-field"><label>Adresse — ligne 1</label><input type="text" name="contact_address1" value="<?php echo $o('contact_address1'); ?>"></div>
						<div class="mi-field"><label>Adresse — ligne 2</label><input type="text" name="contact_address2" value="<?php echo $o('contact_address2'); ?>"></div>
					</div>
					<div class="mi-field">
						<label>URL embed Google Maps</label>
						<textarea name="contact_map_url" rows="3"><?php echo isset($opts['contact_map_url']) ? esc_textarea($opts['contact_map_url']) : ''; ?></textarea>
						<span class="mi-hint">Copiez la valeur de l'attribut <code>src="..."</code> de l'iframe Google Maps.</span>
					</div>
				</div>
			</div>
			<?php endif; // contact ?>

			<?php
			// ── Tab: Agence ───────────────────────────────────────────────────
			if ( $tab === 'agency' ) :
			?>
			<div class="mi-card">
				<div class="mi-card-head"><span class="mi-card-ico">🏢</span><h3>Informations agence</h3></div>
				<div class="mi-card-body">
					<div class="mi-grid-2">
						<div class="mi-field"><label>Nom de l'agence</label><input type="text" name="agency_name" value="<?php echo $o('agency_name','Murailles Immobilier'); ?>"></div>
						<div class="mi-field"><label>Accroche / tagline</label><input type="text" name="agency_tagline" value="<?php echo $o('agency_tagline'); ?>"></div>
						<div class="mi-field"><label>Fondateur</label><input type="text" name="agency_founder" value="<?php echo $o('agency_founder','Youssef MOUMEN'); ?>"></div>
						<div class="mi-field"><label>Années d'expérience</label><input type="text" name="agency_years" value="<?php echo $o('agency_years','15+'); ?>" class="is-short"></div>
					</div>
					<?php $media_field( 'agency_logo_url', 'Logo (fond clair)', 'PNG transparent, hauteur ~60 px', $ou('agency_logo_url') ); ?>
					<?php $media_field( 'agency_logo_white_url', 'Logo (fond sombre)', 'Version blanche, PNG transparent', $ou('agency_logo_white_url') ); ?>
				</div>
			</div>

			<div class="mi-card">
				<div class="mi-card-head"><span class="mi-card-ico">🔗</span><h3>Réseaux sociaux</h3></div>
				<div class="mi-card-body">
					<div class="mi-grid-2">
						<div class="mi-field"><label>Facebook</label><input type="url" name="social_facebook" value="<?php echo $ou('social_facebook'); ?>" placeholder="https://facebook.com/..."></div>
						<div class="mi-field"><label>Instagram</label><input type="url" name="social_instagram" value="<?php echo $ou('social_instagram'); ?>" placeholder="https://instagram.com/..."></div>
						<div class="mi-field"><label>LinkedIn</label><input type="url" name="social_linkedin" value="<?php echo $ou('social_linkedin'); ?>"></div>
						<div class="mi-field"><label>Twitter / X</label><input type="url" name="social_twitter" value="<?php echo $ou('social_twitter'); ?>"></div>
					</div>
				</div>
			</div>
			<?php endif; // agency ?>

			<?php
			// ── Tab: Équipe ───────────────────────────────────────────────────
			if ( $tab === 'team' ) :
				$team_members = isset( $opts['team_members'] ) && is_array( $opts['team_members'] ) ? $opts['team_members'] : array(
					array( 'name' => 'Youssef Moumen', 'role' => 'PDG & Fondateur', 'photo_url' => '', 'facebook' => '#', 'instagram' => '#', 'linkedin' => '#', 'twitter' => '#' ),
					array( 'name' => 'Équipe Murailles', 'role' => 'Conseillers immobiliers', 'photo_url' => '', 'facebook' => '#', 'instagram' => '#', 'linkedin' => '#', 'twitter' => '#' ),
				);
			?>
			<?php
			/**
			 * Renders one team member row. Used for existing rows AND the JS
			 * <template> so the markup never drifts. $i is the array index.
			 * Field names preserved: team_members[i][...].
			 */
			$render_team_row = function ( $i, $member ) {
				$photo = $member['photo_url'] ?? '';
				?>
				<div class="mi-repeat-row" data-row>
					<div class="mi-repeat-bar">
						<span class="mi-repeat-handle" title="Glisser pour réordonner" aria-hidden="true">⠿</span>
						<span class="mi-repeat-title"><span class="mi-repeat-num"><?php echo (int) $i + 1; ?></span>Membre</span>
						<span class="mi-repeat-actions">
							<button type="button" class="mi-btn mi-btn-danger murailles-remove-team-row"><span class="dashicons dashicons-trash"></span>Supprimer</button>
						</span>
					</div>
					<div class="mi-repeat-body">
						<div class="mi-repeat-grid">
							<div class="mi-field mi-span-3">
								<label>Photo</label>
								<div class="mi-media">
									<div class="mi-media-preview" style="width:88px;height:88px;border-radius:50%;">
										<?php if ( $photo ) : ?><img src="<?php echo esc_url( $photo ); ?>" alt=""><?php endif; ?>
										<span class="mi-media-empty" style="<?php echo $photo ? 'display:none;' : ''; ?>"><span class="dashicons dashicons-admin-users"></span></span>
									</div>
									<div class="mi-media-meta">
										<input type="hidden" name="team_members[<?php echo $i; ?>][photo_url]" class="murailles-media-input" value="<?php echo esc_attr( $photo ); ?>">
										<button type="button" class="mi-btn murailles-media-btn-row"><span class="dashicons dashicons-upload"></span>Choisir une photo</button>
									</div>
								</div>
							</div>
							<div class="mi-field"><label>Nom</label><input type="text" name="team_members[<?php echo $i; ?>][name]" value="<?php echo esc_attr( $member['name'] ?? '' ); ?>"></div>
							<div class="mi-field"><label>Rôle / Fonction</label><input type="text" name="team_members[<?php echo $i; ?>][role]" value="<?php echo esc_attr( $member['role'] ?? '' ); ?>"></div>
							<div class="mi-field"><label>Facebook URL</label><input type="url" name="team_members[<?php echo $i; ?>][facebook]" value="<?php echo esc_attr( $member['facebook'] ?? '#' ); ?>"></div>
							<div class="mi-field"><label>Instagram URL</label><input type="url" name="team_members[<?php echo $i; ?>][instagram]" value="<?php echo esc_attr( $member['instagram'] ?? '#' ); ?>"></div>
							<div class="mi-field"><label>LinkedIn URL</label><input type="url" name="team_members[<?php echo $i; ?>][linkedin]" value="<?php echo esc_attr( $member['linkedin'] ?? '#' ); ?>"></div>
						</div>
					</div>
				</div>
				<?php
			};
			?>
			<div class="mi-card">
				<div class="mi-card-head"><span class="mi-card-ico">👥</span><h3>Membres de l'équipe</h3><span class="mi-card-sub">Glissez ⠿ pour réordonner</span></div>
				<div class="mi-card-body">
					<div class="mi-repeater" id="murailles-team-repeater" data-prefix="team_members">
						<?php foreach ( $team_members as $i => $member ) { $render_team_row( $i, $member ); } ?>
					</div>
					<template id="murailles-team-tpl"><?php $render_team_row( '__INDEX__', array( 'facebook' => '#', 'instagram' => '#', 'linkedin' => '#' ) ); ?></template>
					<p style="margin:14px 0 0;">
						<button type="button" class="mi-btn mi-btn-primary" id="murailles-add-team"><span class="dashicons dashicons-plus-alt2"></span>Ajouter un membre</button>
					</p>
				</div>
			</div>
			<?php endif; // team ?>

			<?php
			// ── Tab: Témoignages ──────────────────────────────────────────────
			if ( $tab === 'testimonials' ) :
				$testimonial_sets = array(
					'fr' => array(
						'label' => 'Francais',
						'rows'  => murailles_theme_testimonial_rows_for_admin( 'fr', $opts ),
					),
					'en' => array(
						'label' => 'English',
						'rows'  => murailles_theme_testimonial_rows_for_admin( 'en', $opts ),
					),
				);
			?>
			<div class="mi-card">
				<div class="mi-card-head"><span class="mi-card-ico">💬</span><h3>Témoignages clients</h3><span class="mi-card-sub">Jeu distinct FR / EN</span></div>
				<div class="mi-card-body">
					<p class="mi-hint" style="margin-top:0;">Gérez les avis affichés sur l'accueil et la page « À propos ». Chaque langue possède sa propre liste.</p>

					<div data-langgroup>
						<div class="mi-langtabs" role="tablist">
							<?php $first = true; foreach ( $testimonial_sets as $lang_code => $testimonial_set ) : ?>
							<button type="button" class="mi-langtab<?php echo $first ? ' is-active' : ''; ?>" data-lang="<?php echo esc_attr( $lang_code ); ?>" role="tab" aria-selected="<?php echo $first ? 'true' : 'false'; ?>">
								<?php echo 'fr' === $lang_code ? '🇫🇷' : '🇬🇧'; ?> <?php echo esc_html( $testimonial_set['label'] ); ?>
							</button>
							<?php $first = false; endforeach; ?>
						</div>

						<?php $first = true; foreach ( $testimonial_sets as $lang_code => $testimonial_set ) : ?>
						<div class="mi-langpane<?php echo $first ? ' is-active' : ''; ?>" data-lang="<?php echo esc_attr( $lang_code ); ?>" role="tabpanel">
							<div id="murailles-testi-repeater-<?php echo esc_attr( $lang_code ); ?>" class="murailles-testi-repeater mi-repeater" data-lang="<?php echo esc_attr( $lang_code ); ?>">
								<?php foreach ( $testimonial_set['rows'] as $i => $t ) : ?>
								<div class="murailles-repeater-row mi-repeat-row">
									<div class="mi-repeat-bar">
										<span class="mi-repeat-title"><span class="mi-repeat-num"><?php echo (int) $i + 1; ?></span>Avis</span>
										<span class="mi-repeat-actions">
											<button type="button" class="mi-btn mi-btn-danger murailles-remove-testi-row"><span class="dashicons dashicons-trash"></span>Supprimer</button>
										</span>
									</div>
									<div class="mi-repeat-body">
										<div class="mi-repeat-grid">
											<div class="mi-field"><?php murailles_theme_options_render_testimonial_photo_field( 'testimonials_' . $lang_code . '[' . $i . ']', $t ); ?></div>
											<div class="mi-field"><label>Nom</label><input type="text" name="testimonials_<?php echo esc_attr( $lang_code ); ?>[<?php echo $i; ?>][name]" value="<?php echo esc_attr( $t['name'] ?? '' ); ?>"></div>
											<div class="mi-field"><label>Rôle / Ville</label><input type="text" name="testimonials_<?php echo esc_attr( $lang_code ); ?>[<?php echo $i; ?>][role]" value="<?php echo esc_attr( $t['role'] ?? '' ); ?>"></div>
											<div class="mi-field"><label>Note (ex : 4.8)</label><input type="text" inputmode="decimal" name="testimonials_<?php echo esc_attr( $lang_code ); ?>[<?php echo $i; ?>][rating]" value="<?php echo esc_attr( $t['rating'] ?? 5 ); ?>" class="is-short"></div>
											<div class="mi-field mi-span-2"><label>Texte du témoignage</label><textarea name="testimonials_<?php echo esc_attr( $lang_code ); ?>[<?php echo $i; ?>][text]" rows="3"><?php echo esc_textarea( $t['text'] ?? '' ); ?></textarea></div>
										</div>
									</div>
								</div>
								<?php endforeach; ?>
							</div>
							<p style="margin:14px 0 0;">
								<button type="button" class="mi-btn mi-btn-primary murailles-add-testi" data-lang="<?php echo esc_attr( $lang_code ); ?>"><span class="dashicons dashicons-plus-alt2"></span>Ajouter un témoignage</button>
							</p>
						</div>
						<?php $first = false; endforeach; ?>
					</div>
				</div>
			</div>
			<?php endif; // testimonials ?>

			<?php
			// ── Tab: SEO & Analytics ──────────────────────────────────────────
			if ( $tab === 'seo' ) :
			?>
			<div class="mi-card">
				<div class="mi-card-head"><span class="mi-card-ico">📊</span><h3>Analytics & Tag Manager</h3></div>
				<div class="mi-card-body">
					<div class="mi-grid-2">
						<div class="mi-field"><label>Google Tag Manager ID</label><input type="text" name="seo_gtm_id" value="<?php echo $o('seo_gtm_id'); ?>" placeholder="GTM-XXXXXXX"><span class="mi-hint">Prioritaire sur GA4 si renseigné.</span></div>
						<div class="mi-field"><label>Google Analytics 4 ID</label><input type="text" name="seo_ga4_id" value="<?php echo $o('seo_ga4_id'); ?>" placeholder="G-XXXXXXXXXX"></div>
					</div>
				</div>
			</div>

			<div class="mi-card">
				<div class="mi-card-head"><span class="mi-card-ico">✅</span><h3>Vérification moteurs de recherche</h3></div>
				<div class="mi-card-body">
					<div class="mi-grid-2">
						<div class="mi-field"><label>Google Search Console</label><input type="text" name="seo_google_verif" value="<?php echo $o('seo_google_verif'); ?>" placeholder="Valeur content= uniquement"></div>
						<div class="mi-field"><label>Bing Webmaster Tools</label><input type="text" name="seo_bing_verif" value="<?php echo $o('seo_bing_verif'); ?>" placeholder="Valeur content= uniquement"></div>
					</div>
				</div>
			</div>

			<div class="mi-card">
				<div class="mi-card-head"><span class="mi-card-ico">🔗</span><h3>Open Graph & réseaux sociaux</h3></div>
				<div class="mi-card-body">
					<?php $media_field( 'seo_default_og_image', "Image de partage par défaut (OG)", 'Recommandé : 1200 × 630 px', $ou('seo_default_og_image') ); ?>
					<div class="mi-grid-2">
						<div class="mi-field"><label>Twitter / X Handle</label><input type="text" name="seo_twitter_handle" value="<?php echo $o('seo_twitter_handle'); ?>" placeholder="@MuraillesImmo"></div>
						<div class="mi-field"><label>Facebook App ID</label><input type="text" name="seo_facebook_app_id" value="<?php echo $o('seo_facebook_app_id'); ?>"></div>
					</div>
					<div class="mi-field">
						<label>Description du site
							<span class="mi-hint" style="display:inline;margin:0 0 0 6px;">Idéal 120–155 car. · <span id="seo_desc_counter" class="mi-counter">0 / 160</span></span>
						</label>
						<textarea name="seo_site_description" rows="3" data-counter="120,160" data-counter-for="seo_desc_counter"><?php echo isset($opts['seo_site_description']) ? esc_textarea($opts['seo_site_description']) : ''; ?></textarea>
					</div>
				</div>
			</div>
			<?php endif; // seo ?>

			<div class="mi-savebar">
				<button type="submit" class="mi-btn mi-btn-primary"><span class="dashicons dashicons-saved"></span> Enregistrer les options</button>
				<span class="mi-save-note">Vos données existantes sont conservées — seule cette section est mise à jour.</span>
			</div>
		</form>
		</div><!-- .mi-content -->
		</div><!-- .mi-shell -->
	</div>

	<script>
	(function($){
		function muraillesOptionPreview($row, url) {
			var $preview = $row.find('.murailles-option-image-preview').first();
			if (!$preview.length) {
				return;
			}
			if (url) {
				$preview.removeClass('is-empty').html('<img src="' + url + '" style="width:72px;height:72px;object-fit:cover;border-radius:50%;display:block;">');
			} else {
				$preview.addClass('is-empty').html('<span style="display:inline-block;color:#646970;font-size:12px;">No image selected</span>');
			}
		}

		// Media uploader for single image buttons (new .mi-media card layout)
		function muraillesSetSingleImage(target, url){
			$('#'+target).val(url || '');
			var $field = $('[data-target="'+target+'"]').closest('.mi-media');
			if ($field.length) {
				var $preview = $field.find('.mi-media-preview').first();
				var $img = $preview.find('img');
				var $empty = $preview.find('.mi-media-empty');
				var $clear = $field.find('.murailles-media-clear');
				var $pick  = $field.find('.murailles-media-btn');
				if (url) {
					if ($img.length) { $img.attr('src', url); }
					else { $preview.prepend('<img src="'+url+'" alt="">'); }
					$empty.hide();
					$clear.show();
					$pick.find('.dashicons').nextAll().remove();
				} else {
					$img.remove();
					$empty.show();
					$clear.hide();
				}
			} else {
				// Legacy fallback (any old-style button still present)
				var $btn = $('[data-target="'+target+'"]');
				var $legacy = $btn.prev('img');
				if (url) {
					if ($legacy.length) { $legacy.attr('src', url); }
					else { $btn.before('<img src="'+url+'" style="max-height:80px;display:block;margin-bottom:8px;">'); }
				} else if ($legacy.length) { $legacy.remove(); }
			}
		}

		$(document).on('click', '.murailles-media-btn', function(e){
			e.preventDefault();
			var target = $(this).data('target');
			var frame = wp.media({ title: 'Choisir une image', button: { text: 'Utiliser' }, multiple: false });
			frame.on('select', function(){
				var url = frame.state().get('selection').first().toJSON().url;
				muraillesSetSingleImage(target, url);
			});
			frame.open();
		});

		// Remove button for single images
		$(document).on('click', '.murailles-media-clear', function(e){
			e.preventDefault();
			muraillesSetSingleImage($(this).data('target'), '');
		});

		$(document).on('click', '.murailles-media-btn-row, .murailles-testi-media-btn', function(e){
			e.preventDefault();
			var $row = $(this).closest('.murailles-repeater-row');
			var frame = wp.media({ title: 'Choisir une image', button: { text: 'Utiliser' }, multiple: false });
			frame.on('select', function(){
				var attachment = frame.state().get('selection').first().toJSON();
				var url = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
				if ($row.find('.murailles-testi-photo-id').length) {
					$row.find('.murailles-testi-photo-id').val(attachment.id || '');
					$row.find('.murailles-testi-photo-url').val(attachment.url || url);
					$row.find('.murailles-testi-media-clear').show().removeClass('is-hidden');
					muraillesOptionPreview($row, url);
					return;
				}
				$row.find('.murailles-media-input').val(attachment.url || url);
				var $existing = $row.find('img').first();
				if ($existing.length) {
					$existing.attr('src', url);
				} else {
					$(e.currentTarget).before('<img src="' + url + '" style="max-height:60px;display:block;margin-bottom:6px;border-radius:50%;">');
				}
			});
			frame.open();
		});

		$(document).on('click', '.murailles-testi-media-clear', function(e){
			e.preventDefault();
			var $row = $(this).closest('.murailles-repeater-row');
			$row.find('.murailles-testi-photo-id').val('');
			$row.find('.murailles-testi-photo-url').val('');
			muraillesOptionPreview($row, '');
			$(this).hide().addClass('is-hidden');
		});

		// Remove team / testimonial rows
		$(document).on('click', '.murailles-remove-team-row, .murailles-remove-testi-row', function(){
			if (confirm('Supprimer cet élément ?')) {
				$(this).closest('.murailles-repeater-row').remove();
			}
		});
		$(document).on('click', '.murailles-add-testi', function(e){
			e.preventDefault();
			var lang = $(this).data('lang') || 'fr';
			var $wrap = $('#murailles-testi-repeater-' + lang);
			if (!$wrap.length) {
				return;
			}
			var idx = $wrap.children('.murailles-repeater-row').length;
			var prefix = 'testimonials_' + lang + '[' + idx + ']';
			var row = ''
				+ '<div class="murailles-repeater-row" style="background:#f9f9f9;border:1px solid #e0e0e0;padding:16px;margin-bottom:12px;border-radius:6px;">'
				+   '<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;">'
				+     '<div class="murailles-testi-photo-control"><label>Photo</label><br><input type="hidden" name="' + prefix + '[photo_id]" class="murailles-testi-photo-id" value=""><div class="murailles-option-image-preview is-empty" style="min-height:74px;margin:6px 0;"><span style="display:inline-block;color:#646970;font-size:12px;">No image selected</span></div><button type="button" class="button murailles-testi-media-btn">Choose image</button> <button type="button" class="button-link-delete murailles-testi-media-clear is-hidden" style="display:none;">Remove</button><p style="margin:8px 0 0;"><label>Fallback image URL</label><br><input type="url" name="' + prefix + '[photo_url]" class="regular-text murailles-testi-photo-url" placeholder="https://..."></p></div>'
				+     '<div><label>Nom</label><br><input type="text" name="' + prefix + '[name]" class="regular-text"></div>'
				+     '<div><label>Role / Ville</label><br><input type="text" name="' + prefix + '[role]" class="regular-text"></div>'
				+     '<div><label>Note (ex: 4.8)</label><br><input type="text" inputmode="decimal" name="' + prefix + '[rating]" value="5" class="small-text"></div>'
				+     '<div style="grid-column:span 2;"><label>Texte du temoignage</label><br><textarea name="' + prefix + '[text]" rows="3" class="large-text"></textarea></div>'
				+   '</div>'
				+   '<p><button type="button" class="button button-link-delete murailles-remove-testi-row">Supprimer ce temoignage</button></p>'
				+ '</div>';
			$wrap.append(row);
		});

		// ── Add team member (fixes previously dead button) ──
		$(document).on('click', '#murailles-add-team', function(e){
			e.preventDefault();
			var $wrap = $('#murailles-team-repeater');
			var tpl = document.getElementById('murailles-team-tpl');
			if (!$wrap.length || !tpl) { return; }
			var idx = $wrap.children('.murailles-repeater-row').length;
			var html = tpl.innerHTML.replace(/__INDEX__/g, idx);
			var $row = $($.parseHTML(html.trim())).filter('.mi-repeat-row');
			$row.find('.mi-repeat-num').text(idx + 1);
			$wrap.append($row);
			$row.find('input[name$="[name]"]').trigger('focus');
		});

		// ── Live character counters ──
		$('[data-counter]').each(function(){
			var $in = $(this);
			var $out = $('#' + $in.data('counter-for'));
			if (!$out.length) { return; }
			var parts = String($in.data('counter') || '0,160').split(',');
			var min = parseInt(parts[0], 10), max = parseInt(parts[1], 10);
			function upd(){
				var n = $in.val().length;
				$out.text(n + ' / ' + max).removeClass('is-good is-warn is-over');
				if (n > max) { $out.addClass('is-over'); }
				else if (n >= min) { $out.addClass('is-good'); }
				else { $out.addClass('is-warn'); }
			}
			$in.on('input', upd); upd();
		});
	})(jQuery);
	</script>
	<?php
}
