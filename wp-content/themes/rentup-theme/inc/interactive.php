<?php

/**
 * Interactive features: AJAX endpoints for wishlist + compare hydration.
 *
 * Frontend stores property IDs in localStorage. When the user lands on
 * /favoris/ or /compare-property/, JS reads the IDs and asks the server
 * to render the corresponding property cards.
 *
 * @package Murailles Immobilier
 */

if (! defined('ABSPATH')) {
	exit;
}

function murailles_ensure_localized_page( $slug, $titles, $template ) {
	$default_title = is_array( $titles ) ? ( $titles['fr'] ?? reset( $titles ) ) : (string) $titles;
	$english_title = is_array( $titles ) ? ( $titles['en'] ?? $default_title ) : (string) $titles;

	if ( ! function_exists( 'pll_languages_list' ) || ! function_exists( 'pll_set_post_language' ) || ! function_exists( 'pll_save_post_translations' ) ) {
		$existing = get_page_by_path( $slug );
		if ( ! $existing ) {
			$page_id = wp_insert_post( array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => $default_title,
				'post_name'    => $slug,
				'post_content' => '',
			) );
			$existing = ( $page_id && ! is_wp_error( $page_id ) ) ? get_post( $page_id ) : null;
		}
		if ( $existing ) {
			update_post_meta( $existing->ID, '_wp_page_template', $template );
		}
		return $existing;
	}

	$available_langs = pll_languages_list( array( 'fields' => 'slug' ) );
	$source_lang     = in_array( 'fr', $available_langs, true ) ? 'fr' : pll_default_language( 'slug' );
	$english_lang    = in_array( 'en', $available_langs, true ) && 'en' !== $source_lang ? 'en' : '';

	$source_page = function_exists( 'murailles_find_seed_page' )
		? murailles_find_seed_page( $slug, $source_lang, $default_title )
		: get_page_by_path( $slug );
	$english_page = $english_lang && function_exists( 'murailles_find_seed_page' )
		? murailles_find_seed_page( $slug, $english_lang, $english_title )
		: null;

	if ( ! $source_page && $english_page && function_exists( 'pll_get_post_translations' ) ) {
		$translations = pll_get_post_translations( $english_page->ID );
		if ( ! empty( $translations[ $source_lang ] ) ) {
			$source_page = get_post( (int) $translations[ $source_lang ] );
		}
	}

	if ( ! $source_page ) {
		$source_id = wp_insert_post( array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => $default_title,
			'post_name'    => $slug,
			'post_content' => $english_page ? $english_page->post_content : '',
			'post_excerpt' => $english_page ? $english_page->post_excerpt : '',
		) );
		if ( $source_id && ! is_wp_error( $source_id ) ) {
			pll_set_post_language( $source_id, $source_lang );
			$source_page = get_post( $source_id );
			if ( $english_page && function_exists( 'murailles_copy_seed_page_data' ) ) {
				murailles_copy_seed_page_data( $source_id, $english_page->ID );
			}
		}
	}

	if ( $source_page ) {
		update_post_meta( $source_page->ID, '_wp_page_template', $template );
	}

	if ( $english_lang ) {
		if ( ! $english_page && $source_page && function_exists( 'pll_get_post_translations' ) ) {
			$translations = pll_get_post_translations( $source_page->ID );
			if ( ! empty( $translations[ $english_lang ] ) ) {
				$english_page = get_post( (int) $translations[ $english_lang ] );
			}
		}

		if ( ! $english_page ) {
			$english_id = wp_insert_post( array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => $english_title,
				'post_name'    => $slug,
				'post_content' => $source_page ? $source_page->post_content : '',
				'post_excerpt' => $source_page ? $source_page->post_excerpt : '',
			) );
			if ( $english_id && ! is_wp_error( $english_id ) ) {
				pll_set_post_language( $english_id, $english_lang );
				$english_page = get_post( $english_id );
				if ( $source_page && function_exists( 'murailles_copy_seed_page_data' ) ) {
					murailles_copy_seed_page_data( $english_id, $source_page->ID );
				}
			}
		}

		if ( $english_page ) {
			update_post_meta( $english_page->ID, '_wp_page_template', $template );
		}

		if ( $source_page && $english_page ) {
			pll_save_post_translations( array(
				$source_lang  => (int) $source_page->ID,
				$english_lang => (int) $english_page->ID,
			) );
		}
	}

	return $source_page;
}

/**
 * Return a stripped-down array of property data for a set of IDs.
 * Used by both wishlist and compare-property to render cards client-side.
 */
function murailles_get_properties_payload($ids)
{
	$ids = array_filter(array_map('intval', (array) $ids));
	if (empty($ids)) {
		return array();
	}
	$query = new WP_Query(array(
		'post_type'      => post_type_exists('property') ? 'property' : 'post',
		'post__in'       => $ids,
		'orderby'        => 'post__in',
		'posts_per_page' => count($ids),
		'post_status'    => array('publish', 'draft'),
	));
	$out = array();
	foreach ($query->posts as $p) {
		$pid     = $p->ID;
		$thumb   = has_post_thumbnail($pid)
			? get_the_post_thumbnail_url($pid, 'medium_large')
			: murailles_img('p-' . (($pid % 9) + 1) . '.png');
		$pcats   = wp_get_post_terms($pid, 'property_category', array('fields' => 'names'));
		$plocs   = wp_get_post_terms($pid, 'property_location', array('fields' => 'names'));
		$out[]   = array(
			'id'        => $pid,
			'title'     => get_the_title($pid),
			'url'       => get_permalink($pid),
			'thumb'     => $thumb,
			'price'     => get_post_meta($pid, '_property_price', true),
			'action'    => get_post_meta($pid, '_property_action', true),
			'address'   => get_post_meta($pid, '_property_address', true),
			'beds'      => get_post_meta($pid, '_property_bedrooms', true),
			'baths'     => get_post_meta($pid, '_property_bathrooms', true),
			'size'      => get_post_meta($pid, '_property_size', true),
			'rooms'     => get_post_meta($pid, '_property_rooms', true),
			'garage'    => get_post_meta($pid, '_property_garage', true),
			'building_age' => get_post_meta($pid, '_property_building_age', true),
			'features'  => get_post_meta($pid, '_property_features', true),
			'category'  => $pcats ? $pcats[0] : '',
			'location'  => $plocs ? $plocs[0] : '',
		);
	}
	wp_reset_postdata();
	return $out;
}

/**
 * AJAX: GET /wp-admin/admin-ajax.php?action=murailles_get_properties&ids=1,2,3
 */
function murailles_ajax_get_properties()
{
	$ids = isset($_REQUEST['ids']) ? array_map('intval', explode(',', sanitize_text_field($_REQUEST['ids']))) : array();
	wp_send_json_success(murailles_get_properties_payload($ids));
}
add_action('wp_ajax_nopriv_murailles_get_properties', 'murailles_ajax_get_properties');
add_action('wp_ajax_murailles_get_properties',        'murailles_ajax_get_properties');

/**
 * Enqueue wishlist + compare JS on the frontend.
 */
add_action('wp_enqueue_scripts', function () {
	$theme_uri = get_template_directory_uri();
	$ver       = wp_get_theme()->get('Version');
	wp_enqueue_script('murailles-wishlist-compare', $theme_uri . '/assets/js/wishlist-compare.js', array(), $ver, true);
	wp_localize_script('murailles-wishlist-compare', 'MuraillesWC', array(
		'ajax_url'       => admin_url('admin-ajax.php'),
		'compare_url'    => home_url('/compare-property/'),
		'favoris_url'    => home_url('/favoris/'),
		'max_compare'    => 2,
		'i18n'           => array(
			'added_favoris'    => 'Ajouté à vos favoris',
			'removed_favoris'  => 'Retiré des favoris',
			'added_compare'    => 'Ajouté à la comparaison',
			'removed_compare'  => 'Retiré de la comparaison',
			'compare_full'     => 'Vous comparez déjà 2 biens. Choisissez celui à remplacer.',
			'compare_ready'    => 'Vous comparez 2 biens. Voir la comparaison ?',
			'replace'          => 'Remplacer',
			'cancel'           => 'Annuler',
			'view_compare'     => 'Voir la comparaison',
			'add_one_more'     => 'Ajoutez un autre bien pour comparer',
		),
	));
}, 20);

/**
 * One-time creator: ensure a /favoris/ page exists with the right template.
 * Runs at most once per request when an admin visits any wp-admin page.
 */
add_action('admin_init', function () {
	if (get_option('murailles_favoris_page_created')) {
		return;
	}
	murailles_ensure_localized_page(
		'favoris',
		array(
			'fr' => 'Mes favoris',
			'en' => 'My Favourites',
		),
		'page-templates/favoris.php'
	);
	update_option('murailles_favoris_page_created', 1);
});

/**
 * One-time creator: ensure the three "Informations" pages exist with their
 * dedicated templates assigned. Re-runs whenever the version flag bumps so
 * future template changes can be force-rebound by incrementing the option name.
 */
add_action('admin_init', function () {
	if (get_option('murailles_info_pages_v2_created')) {
		return;
	}
	$localized_pages = array(
		'histoire-marrakech'  => array(
			'titles'   => array( 'fr' => 'Histoire de Marrakech', 'en' => 'History of Marrakech' ),
			'template' => 'page-templates/histoire-marrakech.php',
		),
		'assistance-conseils' => array(
			'titles'   => array( 'fr' => 'Assistance & Conseils', 'en' => 'Assistance & Advice' ),
			'template' => 'page-templates/assistance-conseils.php',
		),
		'tourisme-marrakech'  => array(
			'titles'   => array( 'fr' => 'Tourisme a Marrakech', 'en' => 'Tourism in Marrakech' ),
			'template' => 'page-templates/tourisme-marrakech.php',
		),
		'nos-services'        => array(
			'titles'   => array( 'fr' => 'Nos Services', 'en' => 'Our Services' ),
			'template' => 'page-templates/nos-services.php',
		),
	);
	foreach ( $localized_pages as $slug => $info ) {
		murailles_ensure_localized_page( $slug, $info['titles'], $info['template'] );
	}
	update_option('murailles_info_pages_v2_created', 1);
	return;
	$pages = array(
		'histoire-marrakech'  => array('title' => 'Histoire de Marrakech',  'template' => 'page-templates/histoire-marrakech.php'),
		'assistance-conseils' => array('title' => 'Assistance & Conseils',  'template' => 'page-templates/assistance-conseils.php'),
		'tourisme-marrakech'  => array('title' => 'Tourisme à Marrakech',   'template' => 'page-templates/tourisme-marrakech.php'),
		'nos-services'        => array('title' => 'Nos Services',           'template' => 'page-templates/nos-services.php'),
	);
	foreach ($pages as $slug => $info) {
		$existing = get_page_by_path($slug);
		if (! $existing) {
			$pid = wp_insert_post(array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => $info['title'],
				'post_name'    => $slug,
				'post_content' => '',
			));
			if ($pid && ! is_wp_error($pid)) {
				update_post_meta($pid, '_wp_page_template', $info['template']);
			}
		} else {
			update_post_meta($existing->ID, '_wp_page_template', $info['template']);
		}
	}
	update_option('murailles_info_pages_v2_created', 1);
});

/**
 * One-time creator: ensure /privacy/ and /conditions-generales/ pages exist
 * with their templates assigned, even on sites where murailles_create_pages()
 * already ran (which short-circuits on murailles_pages_created flag).
 */
add_action('admin_init', function () {
	if (get_option('murailles_legal_pages_v1_created')) {
		return;
	}
	$localized_pages = array(
		'privacy' => array(
			'titles'   => array( 'fr' => 'Politique de confidentialite', 'en' => 'Privacy Policy' ),
			'template' => 'page-templates/privacy.php',
		),
		'conditions-generales' => array(
			'titles'   => array( 'fr' => 'Conditions generales', 'en' => 'Terms and Conditions' ),
			'template' => 'page-templates/terms.php',
		),
	);
	foreach ( $localized_pages as $slug => $info ) {
		murailles_ensure_localized_page( $slug, $info['titles'], $info['template'] );
	}
	update_option('murailles_legal_pages_v1_created', 1);
	return;
	$pages = array(
		'privacy'              => array('title' => 'Politique de confidentialité', 'template' => 'page-templates/privacy.php'),
		'conditions-generales' => array('title' => 'Conditions générales',          'template' => 'page-templates/terms.php'),
	);
	foreach ($pages as $slug => $info) {
		$existing = get_page_by_path($slug);
		if (! $existing) {
			$pid = wp_insert_post(array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => $info['title'],
				'post_name'    => $slug,
				'post_content' => '',
			));
			if ($pid && ! is_wp_error($pid)) {
				update_post_meta($pid, '_wp_page_template', $info['template']);
			}
		} else {
			update_post_meta($existing->ID, '_wp_page_template', $info['template']);
		}
	}
	update_option('murailles_legal_pages_v1_created', 1);
});

/**
 * One-time creator: ensure a /erreur/ page exists, bound to the generic
 * error page template. Used by the wp_die handler below and reachable
 * directly with /erreur/?code=500 etc.
 */
add_action('admin_init', function () {
	if (get_option('murailles_error_page_created')) {
		return;
	}
	murailles_ensure_localized_page(
		'erreur',
		array(
			'fr' => 'Erreur',
			'en' => 'Error',
		),
		'page-templates/error.php'
	);
	update_option('murailles_error_page_created', 1);
	return;
	$existing = get_page_by_path('erreur');
	if (! $existing) {
		$pid = wp_insert_post(array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => 'Erreur',
			'post_name'    => 'erreur',
			'post_content' => '',
		));
		if ($pid && ! is_wp_error($pid)) {
			update_post_meta($pid, '_wp_page_template', 'page-templates/error.php');
		}
	} else {
		update_post_meta($existing->ID, '_wp_page_template', 'page-templates/error.php');
	}
	update_option('murailles_error_page_created', 1);
});

/**
 * Floating WhatsApp button — left side, above any back-to-top.
 * Uses wa.me/<number> with a pre-filled French greeting.
 * Override the number via wp-config.php constant MURAILLES_WHATSAPP_NUMBER if needed.
 */
add_action('wp_footer', function () {
	$number = defined('MURAILLES_WHATSAPP_NUMBER') ? MURAILLES_WHATSAPP_NUMBER : '212661425150';
	$msg    = 'Bonjour, je vous contacte depuis le site Agence Murailles. J\'aimerais avoir plus d\'informations sur vos biens immobiliers.';
	$wa_url = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $number) . '?text=' . rawurlencode($msg);
	// CSS lives in /assets/css/murailles-custom.css under "Floating WhatsApp button".
?>
	<a href="<?php echo esc_url($wa_url); ?>" target="_blank" rel="noopener noreferrer" id="murailles-whatsapp-btn" title="Discuter sur WhatsApp">
		<i class="fa-brands fa-whatsapp"></i>
		<span class="murailles-wa-pulse"></span>
		<span class="murailles-wa-tip">Discuter sur WhatsApp</span>
	</a>
<?php
});

// Header favoris badge: injection moved into assets/js/wishlist-compare.js (injectHeaderFavBadge).
