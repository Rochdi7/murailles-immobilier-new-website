<?php

/**
 * Murailles Immobilier – Type de publication : Agent immobilier
 *
 * CRUD complet pour la gestion des agents avec :
 * - Photo de profil (image mise en avant)
 * - Informations de contact (téléphone, email, WhatsApp)
 * - Réseaux sociaux
 * - Biographie
 * - Spécialisation & langues
 * - Compteur de biens assignés dans les colonnes admin
 *
 * Tout en français.
 *
 * @package Murailles Immobilier
 */

if (! defined('ABSPATH')) {
	exit;
}

/* ╔═══════════════════════════════════════════════════╗
   ║  1. TYPE DE PUBLICATION : Agent                   ║
   ╚═══════════════════════════════════════════════════╝ */
function murailles_register_agent_cpt()
{
	register_post_type('agent', array(
		'labels' => array(
			'name'               => 'Agents',
			'singular_name'      => 'Agent',
			'menu_name'          => 'Agents',
			'add_new'            => 'Ajouter',
			'add_new_item'       => 'Ajouter un agent',
			'edit_item'          => 'Modifier l\'agent',
			'new_item'           => 'Nouvel agent',
			'view_item'          => 'Voir l\'agent',
			'all_items'          => 'Tous les agents',
			'search_items'       => 'Rechercher un agent',
			'not_found'          => 'Aucun agent trouvé.',
			'not_found_in_trash' => 'Aucun agent dans la corbeille.',
		),
		'public'             => true,
		'has_archive'        => true,
		'rewrite'            => array('slug' => 'agent', 'with_front' => false),
		'menu_position'      => 6,
		'menu_icon'          => 'dashicons-businessperson',
		'supports'           => array('title', 'editor', 'thumbnail'),
		'show_in_rest'       => false,
	));
}
add_action('init', 'murailles_register_agent_cpt');

// Désactiver Gutenberg pour les agents
function murailles_disable_gutenberg_for_agent($use, $post_type)
{
	return $post_type === 'agent' ? false : $use;
}
add_filter('use_block_editor_for_post_type', 'murailles_disable_gutenberg_for_agent', 10, 2);

/* ╔═══════════════════════════════════════════════════╗
   ║  2. ASSETS ADMIN POUR AGENT                      ║
   ╚═══════════════════════════════════════════════════╝ */
function murailles_agent_admin_enqueue($hook)
{
	global $post_type;
	if ($post_type !== 'agent') return;
	wp_enqueue_style('murailles-admin-css', get_template_directory_uri() . '/inc/admin-assets.css', array(), '1.1');
	wp_enqueue_script('murailles-admin-js', get_template_directory_uri() . '/inc/admin-assets.js', array('jquery'), '1.1', true);
}
add_action('admin_enqueue_scripts', 'murailles_agent_admin_enqueue');

/* ╔═══════════════════════════════════════════════════╗
   ║  3. META BOX AGENT                                ║
   ╚═══════════════════════════════════════════════════╝ */
function murailles_add_agent_meta_boxes()
{
	add_meta_box('murailles_agent_info', 'Informations de l\'agent', 'murailles_render_agent_metabox', 'agent', 'normal', 'high');
}
add_action('add_meta_boxes', 'murailles_add_agent_meta_boxes');

function murailles_render_agent_metabox($post)
{
	wp_nonce_field('murailles_agent_save', 'murailles_agent_nonce');
	$m = function ($key) use ($post) {
		return get_post_meta($post->ID, $key, true);
	};
?>
	<div class="murailles-tabs-wrap">

		<ul class="murailles-tabs-nav">
			<li><a href="#tab-agent-contact" class="active"><span class="dashicons dashicons-phone"></span> Contact</a></li>
			<li><a href="#tab-agent-social"><span class="dashicons dashicons-share"></span> Réseaux sociaux</a></li>
			<li><a href="#tab-agent-details"><span class="dashicons dashicons-id-alt"></span> Détails</a></li>
		</ul>

		<!-- ONGLET 1 : CONTACT -->
		<div id="tab-agent-contact" class="murailles-tab-panel active">

			<div class="murailles-section-title">Coordonnées</div>

			<div class="murailles-field-row">
				<div class="murailles-field-label">Poste / Fonction<small>ex : Directeur commercial</small></div>
				<div class="murailles-field-input">
					<input type="text" name="_agent_position" value="<?php echo esc_attr($m('_agent_position')); ?>" placeholder="Agent immobilier" />
				</div>
			</div>
			<div class="murailles-field-row">
				<div class="murailles-field-label">Téléphone</div>
				<div class="murailles-field-input">
					<input type="text" name="_agent_phone" value="<?php echo esc_attr($m('_agent_phone')); ?>" placeholder="+212 6 00 00 00 00" />
				</div>
			</div>
			<div class="murailles-field-row">
				<div class="murailles-field-label">Téléphone fixe</div>
				<div class="murailles-field-input">
					<input type="text" name="_agent_phone_office" value="<?php echo esc_attr($m('_agent_phone_office')); ?>" placeholder="+212 5 24 00 00 00" />
				</div>
			</div>
			<div class="murailles-field-row">
				<div class="murailles-field-label">WhatsApp<small>Numéro avec indicatif pays</small></div>
				<div class="murailles-field-input">
					<input type="text" name="_agent_whatsapp" value="<?php echo esc_attr($m('_agent_whatsapp')); ?>" placeholder="+212661425150" />
				</div>
			</div>
			<div class="murailles-field-row">
				<div class="murailles-field-label">Email</div>
				<div class="murailles-field-input">
					<input type="email" name="_agent_email" value="<?php echo esc_attr($m('_agent_email')); ?>" placeholder="agent@exemple.com" />
				</div>
			</div>
			<div class="murailles-field-row">
				<div class="murailles-field-label">Adresse du bureau</div>
				<div class="murailles-field-input">
					<input type="text" name="_agent_address" value="<?php echo esc_attr($m('_agent_address')); ?>" placeholder="123 Rue Gueliz, Marrakech" />
				</div>
			</div>
			<div class="murailles-field-row">
				<div class="murailles-field-label">Site web</div>
				<div class="murailles-field-input">
					<input type="url" name="_agent_website" value="<?php echo esc_url($m('_agent_website')); ?>" placeholder="https://www.exemple.com" />
				</div>
			</div>

		</div>

		<!-- ONGLET 2 : RÉSEAUX SOCIAUX -->
		<div id="tab-agent-social" class="murailles-tab-panel">

			<div class="murailles-section-title">Liens réseaux sociaux</div>

			<?php
			$socials = array(
				'_agent_facebook'  => array('Facebook',  'https://facebook.com/...'),
				'_agent_instagram' => array('Instagram', 'https://instagram.com/...'),
				'_agent_linkedin'  => array('LinkedIn',  'https://linkedin.com/in/...'),
				'_agent_twitter'   => array('Twitter / X', 'https://x.com/...'),
				'_agent_youtube'   => array('YouTube',   'https://youtube.com/...'),
				'_agent_tiktok'    => array('TikTok',    'https://tiktok.com/@...'),
			);
			foreach ($socials as $key => $info) :
			?>
				<div class="murailles-field-row">
					<div class="murailles-field-label"><?php echo esc_html($info[0]); ?></div>
					<div class="murailles-field-input">
						<input type="url" name="<?php echo esc_attr($key); ?>" value="<?php echo esc_url($m($key)); ?>" placeholder="<?php echo esc_attr($info[1]); ?>" />
					</div>
				</div>
			<?php endforeach; ?>

		</div>

		<!-- ONGLET 3 : DÉTAILS -->
		<div id="tab-agent-details" class="murailles-tab-panel">

			<div class="murailles-section-title">Profil professionnel</div>

			<div class="murailles-field-row">
				<div class="murailles-field-label">Spécialisation<small>ex : Riads, Villas de luxe</small></div>
				<div class="murailles-field-input">
					<input type="text" name="_agent_specialization" value="<?php echo esc_attr($m('_agent_specialization')); ?>" placeholder="Riads, Villas, Appartements" />
				</div>
			</div>
			<div class="murailles-field-row">
				<div class="murailles-field-label">Langues parlées</div>
				<div class="murailles-field-input">
					<input type="text" name="_agent_languages" value="<?php echo esc_attr($m('_agent_languages')); ?>" placeholder="Français, Arabe, Anglais" />
				</div>
			</div>
			<div class="murailles-field-row">
				<div class="murailles-field-label">Expérience<small>Années d'expérience</small></div>
				<div class="murailles-field-input">
					<input type="text" name="_agent_experience" value="<?php echo esc_attr($m('_agent_experience')); ?>" placeholder="10 ans" />
				</div>
			</div>
			<div class="murailles-field-row">
				<div class="murailles-field-label">Licence / N° agrément</div>
				<div class="murailles-field-input">
					<input type="text" name="_agent_license" value="<?php echo esc_attr($m('_agent_license')); ?>" placeholder="AG-12345" />
				</div>
			</div>
			<div class="murailles-field-row">
				<div class="murailles-field-label">Zones couvertes</div>
				<div class="murailles-field-input">
					<input type="text" name="_agent_service_areas" value="<?php echo esc_attr($m('_agent_service_areas')); ?>" placeholder="Marrakech, Essaouira, Ouarzazate" />
				</div>
			</div>

		</div>

	</div>
<?php
}

/* ╔═══════════════════════════════════════════════════╗
   ║  4. SAUVEGARDE DES DONNÉES AGENT                 ║
   ╚═══════════════════════════════════════════════════╝ */
function murailles_save_agent_meta($post_id)
{
	if (! isset($_POST['murailles_agent_nonce'])) return;
	if (! wp_verify_nonce($_POST['murailles_agent_nonce'], 'murailles_agent_save')) return;
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
	if (! current_user_can('edit_post', $post_id)) return;

	$keys = array(
		'_agent_position',
		'_agent_phone',
		'_agent_phone_office',
		'_agent_whatsapp',
		'_agent_email',
		'_agent_address',
		'_agent_website',
		'_agent_facebook',
		'_agent_instagram',
		'_agent_linkedin',
		'_agent_twitter',
		'_agent_youtube',
		'_agent_tiktok',
		'_agent_specialization',
		'_agent_languages',
		'_agent_experience',
		'_agent_license',
		'_agent_service_areas',
	);

	foreach ($keys as $key) {
		if (isset($_POST[$key])) {
			update_post_meta($post_id, $key, sanitize_text_field($_POST[$key]));
		}
	}
}
add_action('save_post_agent', 'murailles_save_agent_meta');

/* ╔═══════════════════════════════════════════════════╗
   ║  5. COLONNES ADMIN AGENT                          ║
   ╚═══════════════════════════════════════════════════╝ */
function murailles_agent_admin_columns($columns)
{
	$new = array();
	foreach ($columns as $k => $v) {
		$new[$k] = $v;
		if ($k === 'title') {
			$new['agent_phone']    = 'Téléphone';
			$new['agent_email']    = 'Email';
			$new['agent_whatsapp'] = 'WhatsApp';
			$new['agent_properties'] = 'Biens';
		}
	}
	// Remove date, add it at end
	unset($new['date']);
	$new['date'] = 'Date';
	return $new;
}
add_filter('manage_agent_posts_columns', 'murailles_agent_admin_columns');

function murailles_agent_admin_column_data($column, $post_id)
{
	switch ($column) {
		case 'agent_phone':
			echo esc_html(get_post_meta($post_id, '_agent_phone', true) ?: '—');
			break;
		case 'agent_email':
			$email = get_post_meta($post_id, '_agent_email', true);
			echo $email ? '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>' : '—';
			break;
		case 'agent_whatsapp':
			$wa = get_post_meta($post_id, '_agent_whatsapp', true);
			echo $wa ? esc_html($wa) : '—';
			break;
		case 'agent_properties':
			// Count properties assigned to this agent
			$count = new WP_Query(array(
				'post_type'  => 'property',
				'meta_key'   => '_property_agent_id',
				'meta_value' => $post_id,
				'posts_per_page' => -1,
				'fields' => 'ids',
			));
			echo intval($count->found_posts);
			break;
	}
}
add_action('manage_agent_posts_custom_column', 'murailles_agent_admin_column_data', 10, 2);

/* ╔═══════════════════════════════════════════════════╗
   ║  6. HELPER : Récupérer tous les agents            ║
   ╚═══════════════════════════════════════════════════╝ */
function murailles_get_all_agents()
{
	return get_posts(array(
		'post_type'      => 'agent',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
		'orderby'        => 'title',
		'order'          => 'ASC',
	));
}

/* ╔═══════════════════════════════════════════════════╗
   ║  7. FLUSH REWRITES                                ║
   ╚═══════════════════════════════════════════════════╝ */
function murailles_agent_flush_rewrites()
{
	murailles_register_agent_cpt();
	flush_rewrite_rules();
}
add_action('after_switch_theme', 'murailles_agent_flush_rewrites');
