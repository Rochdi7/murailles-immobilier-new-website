<?php
/**
 * Murailles Immobilier – Type de publication personnalisé, Taxonomies & Meta Boxes à onglets
 *
 * Interface d'édition moderne avec onglets :
 *   Onglet 1 : Détails du bien
 *   Onglet 2 : Médias
 *   Onglet 3 : Caractéristiques
 *   Onglet 4 : Carte
 *   Onglet 5 : Équipements
 *   Onglet 6 : Agent
 *   Onglet 7 : Paramètres
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ╔═══════════════════════════════════════════════════╗
   ║  1. TYPE DE PUBLICATION : Bien immobilier         ║
   ╚═══════════════════════════════════════════════════╝ */
function murailles_register_property_cpt() {
	register_post_type( 'property', array(
		'labels' => array(
			'name'               => 'Biens immobiliers',
			'singular_name'      => 'Bien',
			'menu_name'          => 'Biens',
			'add_new'            => 'Ajouter',
			'add_new_item'       => 'Ajouter un bien',
			'edit_item'          => 'Modifier le bien',
			'new_item'           => 'Nouveau bien',
			'view_item'          => 'Voir le bien',
			'all_items'          => 'Tous les biens',
			'search_items'       => 'Rechercher un bien',
			'not_found'          => 'Aucun bien trouvé.',
			'not_found_in_trash' => 'Aucun bien dans la corbeille.',
		),
		'public'             => true,
		'has_archive'        => true,
		'rewrite'            => array( 'slug' => 'bien', 'with_front' => false ),
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-building',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		// REST enabled so Royal MCP can list, search, read and update properties
		// via wp/v2/property. Gutenberg is still disabled below — REST ≠ block editor.
		'show_in_rest'       => true,
		'rest_base'          => 'property',
	) );

	// Expose all property meta fields + SEO fields to the REST API so Royal MCP
	// can read and update them with wp_get_post_meta / wp_update_post_meta.
	$property_meta_keys = array(
		'_property_price'                 => 'string',
		'_property_price_suffix'          => 'string',
		'_property_price_label'           => 'string',
		'_property_address'               => 'string',
		'_property_postal_code'           => 'string',
		'_property_country'               => 'string',
		'_property_size'                  => 'string',
		'_property_land_size'             => 'string',
		'_property_rooms'                 => 'string',
		'_property_bedrooms'              => 'string',
		'_property_bathrooms'             => 'string',
		'_property_owner_note'            => 'string',
		'_property_status'                => 'string',
		'_property_action'                => 'string',
		'_property_premium'               => 'string',
		'_property_gallery_ids'           => 'string',
		'_property_video_url'             => 'string',
		'_property_year_built'            => 'string',
		'_property_garages'               => 'string',
		'_property_garage_size'           => 'string',
		'_property_available_from'        => 'string',
		'_property_basement'              => 'string',
		'_property_external_construction' => 'string',
		'_property_roofing'               => 'string',
		'_property_map_embed'             => 'string',
		'_property_amenities'             => 'string',
		'_property_agent_id'              => 'string',
		// SEO fields (shared with pages/posts, registered in seo.php)
		'_seo_title'                      => 'string',
		'_seo_description'                => 'string',
		'_seo_focus_keyword'              => 'string',
		'_seo_og_image'                   => 'string',
		'_seo_canonical'                  => 'string',
		'_seo_noindex'                    => 'string',
	);
	foreach ( $property_meta_keys as $key => $type ) {
		register_meta( 'post', $key, array(
			'object_subtype' => 'property',
			'type'           => $type,
			'single'         => true,
			'show_in_rest'   => true,
		) );
	}
}
add_action( 'init', 'murailles_register_property_cpt' );

// Désactiver Gutenberg pour les biens
function murailles_disable_gutenberg_for_property( $use, $post_type ) {
	return $post_type === 'property' ? false : $use;
}
add_filter( 'use_block_editor_for_post_type', 'murailles_disable_gutenberg_for_property', 10, 2 );

/* ╔═══════════════════════════════════════════════════╗
   ║  2. TAXONOMIES                                    ║
   ╚═══════════════════════════════════════════════════╝ */
function murailles_register_taxonomies() {

	// Catégorie du bien
	register_taxonomy( 'property_category', 'property', array(
		'labels' => array(
			'name' => 'Catégories', 'singular_name' => 'Catégorie',
			'search_items' => 'Rechercher', 'all_items' => 'Toutes les catégories',
			'edit_item' => 'Modifier la catégorie', 'add_new_item' => 'Ajouter une catégorie',
			'menu_name' => 'Catégories',
		),
		'hierarchical' => true, 'show_ui' => true,
		'show_admin_column' => true, 'show_in_rest' => true,
		'rewrite' => array( 'slug' => 'categorie-bien' ),
	) );

	// Localisation (Pays > Ville)
	register_taxonomy( 'property_location', 'property', array(
		'labels' => array(
			'name' => 'Pays / Ville', 'singular_name' => 'Localisation',
			'parent_item' => 'Pays (parent)', 'search_items' => 'Rechercher',
			'all_items' => 'Toutes les localisations',
			'edit_item' => 'Modifier', 'add_new_item' => 'Ajouter une localisation',
			'menu_name' => 'Pays / Ville',
		),
		'hierarchical' => true, 'show_ui' => true,
		'show_admin_column' => true, 'show_in_rest' => true,
		'rewrite' => array( 'slug' => 'localisation' ),
	) );

	// Quartier
	register_taxonomy( 'property_area', 'property', array(
		'labels' => array(
			'name' => 'Quartiers', 'singular_name' => 'Quartier',
			'search_items' => 'Rechercher', 'all_items' => 'Tous les quartiers',
			'edit_item' => 'Modifier', 'add_new_item' => 'Ajouter un quartier',
			'menu_name' => 'Quartiers',
		),
		'hierarchical' => true, 'show_ui' => true,
		'show_admin_column' => true, 'show_in_rest' => true,
		'rewrite' => array( 'slug' => 'quartier' ),
	) );
}
add_action( 'init', 'murailles_register_taxonomies' );

/* ╔═══════════════════════════════════════════════════╗
   ║  3. ASSETS ADMIN (CSS + JS)                       ║
   ╚═══════════════════════════════════════════════════╝ */
function murailles_admin_enqueue( $hook ) {
	global $post_type;
	if ( $post_type !== 'property' ) return;
	wp_enqueue_media();
	wp_enqueue_style( 'murailles-admin-css', get_template_directory_uri() . '/inc/admin-assets.css', array(), '1.1' );
	wp_enqueue_script( 'murailles-admin-js', get_template_directory_uri() . '/inc/admin-assets.js', array( 'jquery' ), '1.1', true );
}
add_action( 'admin_enqueue_scripts', 'murailles_admin_enqueue' );

/* ╔═══════════════════════════════════════════════════╗
   ║  4. CLÉS META                                     ║
   ╚═══════════════════════════════════════════════════╝ */
function murailles_get_all_meta_keys() {
	return array(
		'_property_price','_property_price_suffix','_property_price_label',
		'_property_address','_property_postal_code','_property_country',
		'_property_size','_property_land_size','_property_rooms',
		'_property_bedrooms','_property_bathrooms','_property_owner_note',
		'_property_status','_property_action','_property_premium',
		'_property_gallery_ids','_property_video_url',
		'_property_year_built','_property_garages','_property_garage_size',
		'_property_available_from','_property_basement',
		'_property_external_construction','_property_roofing',
		'_property_map_embed',
		'_property_amenities',
		'_property_agent_id',
		'_property_show_title','_property_page_template','_property_header_type',
		'_property_transparent_header','_property_sidebar_position',
		'_property_sidebar_selection','_property_slider_type',
	);
}

// Champs obligatoires
function murailles_get_required_fields() {
	return array(
		'_property_address' => 'Adresse',
		'_property_size'    => 'Superficie',
		'_property_bedrooms'=> 'Chambres',
		'_property_action'  => 'Action (Vente / Location)',
	);
}

// Validation à la sauvegarde
function murailles_validate_property( $post_id ) {
	if ( get_post_type( $post_id ) !== 'property' ) return;
	if ( ! isset( $_POST['murailles_property_nonce'] ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

	$errors = array();
	foreach ( murailles_get_required_fields() as $key => $label ) {
		if ( empty( trim( $_POST[ $key ] ?? '' ) ) ) {
			$errors[] = $label;
		}
	}

	// Taxonomy: at least one Catégorie de bien is required. WordPress posts
	// the taxonomy input under `tax_input[property_category]` (array of term IDs)
	// from the standard category metabox.
	$cat_terms = $_POST['tax_input']['property_category'] ?? array();
	if ( is_array( $cat_terms ) ) {
		$cat_terms = array_filter( array_map( 'intval', $cat_terms ) );
	} else {
		$cat_terms = array_filter( array_map( 'intval', explode( ',', (string) $cat_terms ) ) );
	}
	if ( empty( $cat_terms ) ) {
		$errors[] = 'Catégorie de bien';
	}

	if ( $errors ) {
		set_transient( 'murailles_property_errors_' . $post_id, $errors, 60 );
	} else {
		delete_transient( 'murailles_property_errors_' . $post_id );
	}
}
add_action( 'save_post_property', 'murailles_validate_property', 5 );

// Afficher les erreurs dans l'admin
function murailles_show_property_errors() {
	global $post;
	if ( ! $post || get_post_type( $post ) !== 'property' ) return;
	$errors = get_transient( 'murailles_property_errors_' . $post->ID );
	if ( $errors ) {
		echo '<div class="notice notice-error is-dismissible"><p><strong>Champs obligatoires manquants :</strong> ' . esc_html( implode( ', ', $errors ) ) . '</p></div>';
		delete_transient( 'murailles_property_errors_' . $post->ID );
	}
}
add_action( 'admin_notices', 'murailles_show_property_errors' );

/* ╔═══════════════════════════════════════════════════╗
   ║  5. META BOX                                      ║
   ╚═══════════════════════════════════════════════════╝ */
function murailles_add_property_meta_boxes() {
	add_meta_box( 'murailles_property_tabs', 'Paramètres du bien', 'murailles_render_tabbed_metabox', 'property', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'murailles_add_property_meta_boxes' );

/* ╔═══════════════════════════════════════════════════╗
   ║  6. RENDU DES ONGLETS                             ║
   ╚═══════════════════════════════════════════════════╝ */
function murailles_render_tabbed_metabox( $post ) {
	wp_nonce_field( 'murailles_property_save', 'murailles_property_nonce' );
	$m = function( $key ) use ( $post ) {
		return get_post_meta( $post->ID, $key, true );
	};
	?>
	<div class="murailles-tabs-wrap">

		<!-- Navigation des onglets -->
		<ul class="murailles-tabs-nav">
			<li><a href="#tab-details" class="active"><span class="dashicons dashicons-admin-home"></span> Détails</a></li>
			<li><a href="#tab-media"><span class="dashicons dashicons-format-gallery"></span> Médias</a></li>
			<li><a href="#tab-custom"><span class="dashicons dashicons-admin-generic"></span> Caractéristiques</a></li>
			<li><a href="#tab-map"><span class="dashicons dashicons-location"></span> Carte</a></li>
			<li><a href="#tab-amenities"><span class="dashicons dashicons-yes-alt"></span> Équipements</a></li>
			<li><a href="#tab-agent"><span class="dashicons dashicons-businessman"></span> Agent</a></li>
			<li><a href="#tab-settings"><span class="dashicons dashicons-admin-settings"></span> Paramètres</a></li>
		</ul>

		<!-- ═══════════════════════════════════ -->
		<!-- ONGLET 1 : DÉTAILS DU BIEN         -->
		<!-- ═══════════════════════════════════ -->
		<div id="tab-details" class="murailles-tab-panel active">

			<div class="murailles-section-title">Tarification</div>

			<div class="murailles-field-row">
				<div class="murailles-field-label">Prix<small>Prix en MAD (facultatif)</small></div>
				<div class="murailles-field-input">
					<input type="text" name="_property_price" value="<?php echo esc_attr( $m('_property_price') ); ?>" placeholder="1 500 000" />
				</div>
			</div>
			<div class="murailles-field-row">
				<div class="murailles-field-label">Après le prix<small>ex : "par mois"</small></div>
				<div class="murailles-field-input">
					<input type="text" name="_property_price_suffix" value="<?php echo esc_attr( $m('_property_price_suffix') ); ?>" placeholder="par mois" />
				</div>
			</div>
			<div class="murailles-field-row">
				<div class="murailles-field-label">Libellé du prix<small>ex : "À partir de"</small></div>
				<div class="murailles-field-input">
					<input type="text" name="_property_price_label" value="<?php echo esc_attr( $m('_property_price_label') ); ?>" placeholder="À partir de" />
				</div>
			</div>
			<div class="murailles-field-row">
				<div class="murailles-field-label">Action <span class="murailles-required">*</span></div>
				<div class="murailles-field-input">
					<select name="_property_action" required>
						<option value="">— Sélectionner —</option>
						<?php foreach ( array( 'A Vendre', 'A Louer' ) as $opt ) : ?>
						<option value="<?php echo esc_attr( $opt ); ?>" <?php selected( $m('_property_action'), $opt ); ?>><?php echo esc_html( $opt ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="murailles-field-row">
				<div class="murailles-field-label">Statut du bien</div>
				<div class="murailles-field-input">
					<select name="_property_status">
						<?php foreach ( array( 'Normal', 'Vendu', 'Loué', 'En attente' ) as $opt ) : ?>
						<option value="<?php echo esc_attr( $opt ); ?>" <?php selected( $m('_property_status'), $opt ); ?>><?php echo esc_html( $opt ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="murailles-field-row">
				<div class="murailles-field-label">Bien premium</div>
				<div class="murailles-field-input">
					<label><input type="checkbox" name="_property_premium" value="1" <?php checked( $m('_property_premium'), '1' ); ?> /> Marquer comme bien en vedette</label>
				</div>
			</div>

			<div class="murailles-section-title">Localisation</div>

			<div class="murailles-field-row">
				<div class="murailles-field-label">Adresse <span class="murailles-required">*</span><small>Nom de rue uniquement</small></div>
				<div class="murailles-field-input">
					<input type="text" name="_property_address" value="<?php echo esc_attr( $m('_property_address') ); ?>" placeholder="Rue de la Kasbah" required />
				</div>
			</div>
			<div class="murailles-field-row">
				<div class="murailles-field-label">Code postal</div>
				<div class="murailles-field-input">
					<input type="text" name="_property_postal_code" value="<?php echo esc_attr( $m('_property_postal_code') ); ?>" placeholder="40000" />
				</div>
			</div>
			<div class="murailles-field-row">
				<div class="murailles-field-label">Pays</div>
				<div class="murailles-field-input">
					<select name="_property_country">
						<option value="">— Sélectionner —</option>
						<?php foreach ( array( 'Maroc', 'France', 'Espagne', 'Émirats Arabes Unis' ) as $c ) : ?>
						<option value="<?php echo esc_attr( $c ); ?>" <?php selected( $m('_property_country'), $c ); ?>><?php echo esc_html( $c ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="murailles-section-title">Caractéristiques du bien</div>

			<div class="murailles-field-row">
				<div class="murailles-field-label">Superficie (m²) <span class="murailles-required">*</span><small>Nombre uniquement</small></div>
				<div class="murailles-field-input">
					<input type="number" name="_property_size" value="<?php echo esc_attr( $m('_property_size') ); ?>" placeholder="120" required />
				</div>
			</div>
			<div class="murailles-field-row">
				<div class="murailles-field-label">Superficie terrain (m²)<small>Nombre uniquement</small></div>
				<div class="murailles-field-input">
					<input type="number" name="_property_land_size" value="<?php echo esc_attr( $m('_property_land_size') ); ?>" placeholder="500" />
				</div>
			</div>
			<div class="murailles-field-row">
				<div class="murailles-field-label">Pièces<small>Nombre uniquement</small></div>
				<div class="murailles-field-input">
					<input type="number" name="_property_rooms" value="<?php echo esc_attr( $m('_property_rooms') ); ?>" placeholder="5" />
				</div>
			</div>
			<div class="murailles-field-row">
				<div class="murailles-field-label">Chambres <span class="murailles-required">*</span><small>Nombre uniquement</small></div>
				<div class="murailles-field-input">
					<input type="number" name="_property_bedrooms" value="<?php echo esc_attr( $m('_property_bedrooms') ); ?>" placeholder="3" required />
				</div>
			</div>
			<div class="murailles-field-row">
				<div class="murailles-field-label">Salles de bain<small>Nombre uniquement</small></div>
				<div class="murailles-field-input">
					<input type="number" name="_property_bathrooms" value="<?php echo esc_attr( $m('_property_bathrooms') ); ?>" placeholder="2" />
				</div>
			</div>
			<div class="murailles-field-row">
				<div class="murailles-field-label">Note du propriétaire<small>Non visible sur l'annonce</small></div>
				<div class="murailles-field-input">
					<textarea name="_property_owner_note" placeholder="Notes privées..."><?php echo esc_textarea( $m('_property_owner_note') ); ?></textarea>
				</div>
			</div>

		</div>

		<!-- ═══════════════════════════════════ -->
		<!-- ONGLET 2 : MÉDIAS                  -->
		<!-- ═══════════════════════════════════ -->
		<div id="tab-media" class="murailles-tab-panel">

			<div class="murailles-section-title">Galerie photos</div>

			<div class="murailles-gallery-container">
				<?php
				$gallery_ids = $m('_property_gallery_ids');
				if ( $gallery_ids ) {
					foreach ( explode( ',', $gallery_ids ) as $img_id ) {
						$thumb = wp_get_attachment_image_url( intval( $img_id ), 'thumbnail' );
						if ( $thumb ) {
							echo '<div class="murailles-gallery-item" data-id="' . intval( $img_id ) . '">';
							echo '<img src="' . esc_url( $thumb ) . '" />';
							echo '<button type="button" class="remove-image">&times;</button>';
							echo '</div>';
						}
					}
				}
				?>
			</div>
			<input type="hidden" name="_property_gallery_ids" id="_property_gallery_ids" value="<?php echo esc_attr( $gallery_ids ); ?>" />
			<button type="button" id="murailles-add-gallery" class="button button-primary">
				<span class="dashicons dashicons-plus-alt" style="vertical-align:middle;margin-top:-2px"></span> Ajouter des images
			</button>

			<div class="murailles-section-title" style="margin-top:30px">Vidéo</div>
			<div class="murailles-field-row">
				<div class="murailles-field-label">URL de la vidéo<small>YouTube ou Vimeo</small></div>
				<div class="murailles-field-input">
					<input type="url" name="_property_video_url" value="<?php echo esc_url( $m('_property_video_url') ); ?>" placeholder="https://www.youtube.com/watch?v=..." />
				</div>
			</div>

		</div>

		<!-- ═══════════════════════════════════ -->
		<!-- ONGLET 3 : CARACTÉRISTIQUES        -->
		<!-- ═══════════════════════════════════ -->
		<div id="tab-custom" class="murailles-tab-panel">

			<div class="murailles-section-title">Détails de construction</div>

			<?php
			$custom_fields = array(
				'_property_year_built'            => array( 'Année de construction', 'date',  '2020-01-01' ),
				'_property_garages'               => array( 'Garages',               'text',  '1' ),
				'_property_garage_size'           => array( 'Taille du garage',      'text',  '200 m²' ),
				'_property_available_from'        => array( 'Disponible à partir de','text',  'Immédiatement' ),
				'_property_basement'              => array( 'Sous-sol',              'text',  'Complet' ),
				'_property_external_construction' => array( 'Construction externe',  'text',  'Brique' ),
				'_property_roofing'               => array( 'Toiture',              'text',  'Béton' ),
			);
			foreach ( $custom_fields as $key => $cf ) :
			?>
			<div class="murailles-field-row">
				<div class="murailles-field-label"><?php echo esc_html( $cf[0] ); ?></div>
				<div class="murailles-field-input">
					<input type="<?php echo esc_attr( $cf[1] ); ?>" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $m($key) ); ?>" placeholder="<?php echo esc_attr( $cf[2] ); ?>" />
				</div>
			</div>
			<?php endforeach; ?>

		</div>

		<!-- ═══════════════════════════════════ -->
		<!-- ONGLET 4 : CARTE                   -->
		<!-- ═══════════════════════════════════ -->
		<div id="tab-map" class="murailles-tab-panel">

			<div class="murailles-section-title">Carte Google Maps</div>

			<div class="murailles-field-row">
				<div class="murailles-field-label">
					Lien d'intégration
					<small>Collez le lien <code>src=""</code> de l'iframe Google Maps</small>
				</div>
				<div class="murailles-field-input">
					<input type="url" name="_property_map_embed" id="_property_map_embed" value="<?php echo esc_attr( $m('_property_map_embed') ); ?>" placeholder="https://www.google.com/maps/embed?pb=..." style="max-width:100%" />
					<p class="description" style="margin-top:8px">
						<strong>Comment obtenir le lien :</strong><br>
						1. Ouvrir <a href="https://www.google.com/maps" target="_blank">Google Maps</a><br>
						2. Rechercher l'emplacement du bien<br>
						3. Cliquer sur <strong>Partager</strong> &rarr; <strong>Intégrer une carte</strong><br>
						4. Copier l'URL dans <code>src="..."</code> du code iframe<br>
						5. Coller ici
					</p>
				</div>
			</div>

			<div class="murailles-field-row">
				<div class="murailles-field-label">Aperçu</div>
				<div class="murailles-field-input">
					<?php $embed_url = $m('_property_map_embed'); ?>
					<iframe id="murailles-map-preview" src="<?php echo esc_url( $embed_url ); ?>" width="100%" height="350" style="border:0;border-radius:6px;<?php echo empty($embed_url) ? 'display:none;' : ''; ?>" allowfullscreen="" loading="lazy"></iframe>
					<?php if ( empty( $embed_url ) ) : ?>
					<p id="murailles-map-empty" style="color:#999;padding:40px 0;text-align:center;background:#f6f7f7;border-radius:6px;">
						Collez un lien d'intégration ci-dessus et enregistrez pour voir l'aperçu.
					</p>
					<?php endif; ?>
				</div>
			</div>

		</div>

		<!-- ═══════════════════════════════════ -->
		<!-- ONGLET 5 : ÉQUIPEMENTS             -->
		<!-- ═══════════════════════════════════ -->
		<div id="tab-amenities" class="murailles-tab-panel">

			<div class="murailles-section-title">Équipements et caractéristiques</div>

			<?php
			$all_amenities = array(
				'grenier'          => 'Grenier',
				'chauffage_gaz'    => 'Chauffage gaz',
				'vue_mer'          => 'Vue sur mer',
				'cave_a_vin'       => 'Cave à vin',
				'terrain_basket'   => 'Terrain de basket',
				'salle_sport'      => 'Salle de sport',
				'bassin'           => 'Bassin',
				'cheminee'         => 'Cheminée',
				'vue_lac'          => 'Vue sur lac',
				'piscine'          => 'Piscine',
				'jardin_arriere'   => 'Jardin arrière',
				'jardin_avant'     => 'Jardin avant',
				'cour_cloturee'    => 'Cour clôturée',
				'arroseurs'        => 'Arroseurs automatiques',
				'lave_linge'       => 'Lave-linge / Sèche-linge',
				'terrasse'         => 'Terrasse',
				'balcon'           => 'Balcon',
				'buanderie'        => 'Buanderie',
				'conciergerie'     => 'Conciergerie',
				'gardien'          => 'Gardien',
				'espace_prive'     => 'Espace privé',
				'rangement'        => 'Rangement',
				'salle_loisirs'    => 'Salle de loisirs',
				'toit_terrasse'    => 'Toit-terrasse',
				'climatisation'    => 'Climatisation',
				'chauffage'        => 'Chauffage central',
				'ascenseur'        => 'Ascenseur',
				'parking'          => 'Parking',
				'securite'         => 'Sécurité',
				'jardin'           => 'Jardin',
				'wifi'             => 'Wi-Fi',
				'meuble'           => 'Meublé',
			);
			$saved = (array) json_decode( $m('_property_amenities'), true );
			?>
			<div class="murailles-amenities-grid">
				<?php foreach ( $all_amenities as $key => $label ) :
					$checked = in_array( $key, $saved ) ? 'checked' : '';
				?>
				<div class="murailles-amenity-item">
					<input type="checkbox" name="_property_amenities_list[]" value="<?php echo esc_attr( $key ); ?>" <?php echo $checked; ?> id="am_<?php echo esc_attr( $key ); ?>" />
					<label for="am_<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label>
				</div>
				<?php endforeach; ?>
			</div>

		</div>

		<!-- ═══════════════════════════════════ -->
		<!-- ONGLET 6 : AGENT                   -->
		<!-- ═══════════════════════════════════ -->
		<div id="tab-agent" class="murailles-tab-panel">

			<div class="murailles-section-title">Agent assigné <small style="font-weight:normal;color:#787c82;">(optionnel)</small></div>

			<?php
			$agents = murailles_get_all_agents();
			$selected_agent_id = intval( $m('_property_agent_id') );
			?>

			<div class="murailles-field-row">
				<div class="murailles-field-label">Sélectionner un agent<small>Laisser vide si aucun agent</small></div>
				<div class="murailles-field-input">
					<select name="_property_agent_id" id="_property_agent_id" style="max-width:400px">
						<option value="0">— Aucun agent —</option>
						<?php foreach ( $agents as $ag ) : ?>
						<option value="<?php echo intval( $ag->ID ); ?>" <?php selected( $selected_agent_id, $ag->ID ); ?>>
							<?php echo esc_html( $ag->post_title ); ?>
							<?php
							$pos = get_post_meta( $ag->ID, '_agent_position', true );
							if ( $pos ) echo ' — ' . esc_html( $pos );
							?>
						</option>
						<?php endforeach; ?>
					</select>
					<?php if ( empty( $agents ) ) : ?>
					<p class="description" style="margin-top:8px;color:#d63638;">
						Aucun agent créé. <a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=agent' ) ); ?>">Ajouter un agent</a> d'abord.
					</p>
					<?php else : ?>
					<p class="description" style="margin-top:8px;">
						<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=agent' ) ); ?>">Gérer les agents</a> |
						<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=agent' ) ); ?>">Ajouter un nouvel agent</a>
					</p>
					<?php endif; ?>
				</div>
			</div>

			<!-- Aperçu de l'agent sélectionné -->
			<?php if ( $selected_agent_id > 0 ) :
				$ag_thumb  = get_the_post_thumbnail_url( $selected_agent_id, 'thumbnail' );
				$ag_name   = get_the_title( $selected_agent_id );
				$ag_pos    = get_post_meta( $selected_agent_id, '_agent_position', true );
				$ag_phone  = get_post_meta( $selected_agent_id, '_agent_phone', true );
				$ag_wa     = get_post_meta( $selected_agent_id, '_agent_whatsapp', true );
				$ag_email  = get_post_meta( $selected_agent_id, '_agent_email', true );
				$ag_langs  = get_post_meta( $selected_agent_id, '_agent_languages', true );
			?>
			<div class="murailles-section-title">Aperçu de l'agent</div>
			<div style="display:flex;gap:16px;align-items:flex-start;padding:16px;background:#f6f7f7;border-radius:8px;max-width:600px;">
				<?php if ( $ag_thumb ) : ?>
				<img src="<?php echo esc_url( $ag_thumb ); ?>" style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,.1);" />
				<?php else : ?>
				<div style="width:80px;height:80px;border-radius:50%;background:#ddd;display:flex;align-items:center;justify-content:center;">
					<span class="dashicons dashicons-businessperson" style="font-size:32px;color:#999;"></span>
				</div>
				<?php endif; ?>
				<div style="flex:1;">
					<strong style="font-size:15px;"><?php echo esc_html( $ag_name ); ?></strong>
					<?php if ( $ag_pos ) : ?><br><span style="color:#666;"><?php echo esc_html( $ag_pos ); ?></span><?php endif; ?>
					<div style="margin-top:8px;font-size:12.5px;color:#50575e;">
						<?php if ( $ag_phone ) : ?><span class="dashicons dashicons-phone" style="font-size:14px;vertical-align:middle;"></span> <?php echo esc_html( $ag_phone ); ?><br><?php endif; ?>
						<?php if ( $ag_wa ) : ?><span class="dashicons dashicons-whatsapp" style="font-size:14px;vertical-align:middle;color:#25D366;"></span> <?php echo esc_html( $ag_wa ); ?><br><?php endif; ?>
						<?php if ( $ag_email ) : ?><span class="dashicons dashicons-email" style="font-size:14px;vertical-align:middle;"></span> <?php echo esc_html( $ag_email ); ?><br><?php endif; ?>
						<?php if ( $ag_langs ) : ?><span class="dashicons dashicons-translation" style="font-size:14px;vertical-align:middle;"></span> <?php echo esc_html( $ag_langs ); ?><?php endif; ?>
					</div>
					<a href="<?php echo esc_url( get_edit_post_link( $selected_agent_id ) ); ?>" class="button button-small" style="margin-top:10px;">Modifier cet agent</a>
				</div>
			</div>
			<?php endif; ?>

		</div>

		<!-- ═══════════════════════════════════ -->
		<!-- ONGLET 7 : PARAMÈTRES              -->
		<!-- ═══════════════════════════════════ -->
		<div id="tab-settings" class="murailles-tab-panel">

			<div class="murailles-section-title">Paramètres d'affichage</div>

			<div class="murailles-field-row">
				<div class="murailles-field-label">Afficher le titre</div>
				<div class="murailles-field-input">
					<select name="_property_show_title">
						<option value="yes" <?php selected( $m('_property_show_title'), 'yes' ); ?>>Oui</option>
						<option value="no" <?php selected( $m('_property_show_title'), 'no' ); ?>>Non</option>
					</select>
				</div>
			</div>
			<div class="murailles-field-row">
				<div class="murailles-field-label">Modèle de page</div>
				<div class="murailles-field-input">
					<select name="_property_page_template">
						<?php foreach ( array( 'Par défaut' => 'default', 'Pleine largeur' => 'full-width', 'Avec barre latérale' => 'with-sidebar', 'En-tête carte' => 'map-header' ) as $label => $val ) : ?>
						<option value="<?php echo esc_attr( $val ); ?>" <?php selected( $m('_property_page_template'), $val ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="murailles-field-row">
				<div class="murailles-field-label">Type d'en-tête</div>
				<div class="murailles-field-input">
					<select name="_property_header_type">
						<?php foreach ( array( 'Par défaut' => 'default', 'Transparent' => 'transparent', 'Coloré' => 'colored' ) as $label => $val ) : ?>
						<option value="<?php echo esc_attr( $val ); ?>" <?php selected( $m('_property_header_type'), $val ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="murailles-field-row">
				<div class="murailles-field-label">En-tête transparent</div>
				<div class="murailles-field-input">
					<label><input type="checkbox" name="_property_transparent_header" value="1" <?php checked( $m('_property_transparent_header'), '1' ); ?> /> Activer l'en-tête transparent</label>
				</div>
			</div>
			<div class="murailles-field-row">
				<div class="murailles-field-label">Type de slider</div>
				<div class="murailles-field-input">
					<select name="_property_slider_type">
						<?php foreach ( array( 'Aucun' => 'none', 'Slider galerie' => 'gallery-slider', 'Revolution Slider' => 'revolution-slider' ) as $label => $val ) : ?>
						<option value="<?php echo esc_attr( $val ); ?>" <?php selected( $m('_property_slider_type'), $val ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="murailles-field-row">
				<div class="murailles-field-label">Position barre latérale</div>
				<div class="murailles-field-input">
					<select name="_property_sidebar_position">
						<?php foreach ( array( 'Aucune' => 'none', 'Gauche' => 'left', 'Droite' => 'right' ) as $label => $val ) : ?>
						<option value="<?php echo esc_attr( $val ); ?>" <?php selected( $m('_property_sidebar_position'), $val ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="murailles-field-row">
				<div class="murailles-field-label">Sélection barre latérale</div>
				<div class="murailles-field-input">
					<select name="_property_sidebar_selection">
						<?php
						global $wp_registered_sidebars;
						echo '<option value="">— Par défaut —</option>';
						if ( ! empty( $wp_registered_sidebars ) ) {
							foreach ( $wp_registered_sidebars as $sb ) {
								echo '<option value="' . esc_attr( $sb['id'] ) . '"' . selected( $m('_property_sidebar_selection'), $sb['id'], false ) . '>' . esc_html( $sb['name'] ) . '</option>';
							}
						}
						?>
					</select>
				</div>
			</div>

		</div>

	</div>
	<?php
}

/* ╔═══════════════════════════════════════════════════╗
   ║  7. SAUVEGARDE DES DONNÉES                       ║
   ╚═══════════════════════════════════════════════════╝ */
function murailles_save_property_meta( $post_id ) {
	if ( ! isset( $_POST['murailles_property_nonce'] ) ) return;
	if ( ! wp_verify_nonce( $_POST['murailles_property_nonce'], 'murailles_property_save' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	$keys = murailles_get_all_meta_keys();
	foreach ( $keys as $key ) {
		if ( $key === '_property_amenities' ) continue;
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, sanitize_text_field( $_POST[ $key ] ) );
		}
	}

	$checkboxes = array( '_property_premium', '_property_transparent_header' );
	foreach ( $checkboxes as $cb ) {
		update_post_meta( $post_id, $cb, isset( $_POST[ $cb ] ) ? '1' : '0' );
	}

	$amenities = isset( $_POST['_property_amenities_list'] ) ? array_map( 'sanitize_text_field', $_POST['_property_amenities_list'] ) : array();
	update_post_meta( $post_id, '_property_amenities', wp_json_encode( $amenities ) );
}
add_action( 'save_post_property', 'murailles_save_property_meta' );

/* ╔═══════════════════════════════════════════════════╗
   ║  8. COLONNES ADMIN                                ║
   ╚═══════════════════════════════════════════════════╝ */
function murailles_property_admin_columns( $columns ) {
	$new = array();
	foreach ( $columns as $k => $v ) {
		$new[ $k ] = $v;
		if ( $k === 'title' ) {
			$new['prop_price']  = 'Prix';
			$new['prop_action'] = 'Action';
			$new['prop_status'] = 'Statut';
		}
	}
	return $new;
}
add_filter( 'manage_property_posts_columns', 'murailles_property_admin_columns' );

function murailles_property_admin_column_data( $column, $post_id ) {
	switch ( $column ) {
		case 'prop_price':
			$p = get_post_meta( $post_id, '_property_price', true );
			echo $p ? esc_html( $p ) . ' MAD' : '—';
			break;
		case 'prop_action':
			echo esc_html( get_post_meta( $post_id, '_property_action', true ) ?: '—' );
			break;
		case 'prop_status':
			echo esc_html( get_post_meta( $post_id, '_property_status', true ) ?: '—' );
			break;
	}
}
add_action( 'manage_property_posts_custom_column', 'murailles_property_admin_column_data', 10, 2 );

/* ╔═══════════════════════════════════════════════════╗
   ║  9. REMPLISSAGE AUTOMATIQUE DES TERMES           ║
   ╚═══════════════════════════════════════════════════╝ */
function murailles_populate_taxonomies() {
	if ( get_option( 'murailles_taxonomies_populated_v3' ) ) return;

	$categories = array(
		'RIAD A RENOVER','APPARTEMENT','BUREAUX','COMMERCE','FERME',
		"MAISON D'HOTE",'HOTEL','PALAIS','RIAD HABITATION',
		'RIAD RENOVE','TERRAIN','VILLA',
	);
	foreach ( $categories as $cat ) {
		if ( ! term_exists( $cat, 'property_category' ) ) wp_insert_term( $cat, 'property_category' );
	}

	$locations = array(
		'Maroc' => array('Marrakech','Casablanca','Rabat','Fès','Tanger','Agadir','Essaouira','Meknès','Ouarzazate','Tétouan','Oujda','Kénitra','El Jadida','Safi','Nador'),
		'France' => array('Paris','Lyon','Marseille','Nice','Toulouse','Bordeaux'),
		'Espagne' => array('Madrid','Barcelone','Séville','Malaga'),
		'Émirats Arabes Unis' => array('Dubaï','Abu Dhabi'),
	);
	foreach ( $locations as $pays => $villes ) {
		$pt = term_exists( $pays, 'property_location' );
		if ( ! $pt ) $pt = wp_insert_term( $pays, 'property_location' );
		$pid = is_array( $pt ) ? $pt['term_id'] : $pt;
		foreach ( $villes as $v ) {
			if ( ! term_exists( $v, 'property_location' ) ) {
				wp_insert_term( $v, 'property_location', array( 'parent' => intval( $pid ) ) );
			}
		}
	}

	$areas = array(
		'AGDAL','AMELKIS','BAB ATLAS','BAB DOUKALLA','DAR EL BACHA',
		'GUELIZ','HIVERNAGE','KASBAH','MAJORELLE','MEDINA','MOUASSINE',
		'PALMERAIE','ROUTE DE FES','ROUTE DE OUARZAZATE','ROUTE DE CASABLANCA',
		"ROUTE D'AMIZMIZ",'SIDI GHANEM','TARGA','VICTOR HUGO',
		'CAMP EL GHOUL','SEMLALIA',"M'HAMID",'OURIKA','TAMANSOURT',
		'TASSOULTANTE','AIT OURIR','SIDI YOUSSEF BEN ALI','MASSIRA','DAOUDIATE','IZIKI',
	);
	foreach ( $areas as $a ) {
		if ( ! term_exists( $a, 'property_area' ) ) wp_insert_term( $a, 'property_area' );
	}

	update_option( 'murailles_taxonomies_populated_v3', true );
}
add_action( 'init', 'murailles_populate_taxonomies', 20 );

/* ╔═══════════════════════════════════════════════════╗
   ║  10. FLUSH DES RÈGLES DE RÉÉCRITURE              ║
   ╚═══════════════════════════════════════════════════╝ */
function murailles_flush_rewrites() {
	murailles_register_property_cpt();
	murailles_register_taxonomies();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'murailles_flush_rewrites' );

/**
 * One-time auto-flush of rewrite rules.
 * Bump MURAILLES_REWRITE_VERSION whenever CPT/taxonomy rewrite slugs change.
 * Runs once on the next request after deploy, then never again.
 */
if ( ! defined( 'MURAILLES_REWRITE_VERSION' ) ) {
	define( 'MURAILLES_REWRITE_VERSION', '2026-05-13-1' );
}
function murailles_maybe_flush_rewrites() {
	if ( get_option( 'murailles_rewrite_version' ) === MURAILLES_REWRITE_VERSION ) {
		return;
	}
	flush_rewrite_rules();
	update_option( 'murailles_rewrite_version', MURAILLES_REWRITE_VERSION );
}
add_action( 'init', 'murailles_maybe_flush_rewrites', 99 );

/* ╔═══════════════════════════════════════════════════╗
   ║  11. ADMIN UX — soumissions externes              ║
   ╚═══════════════════════════════════════════════════╝
   Quand un visiteur dépose une annonce via /submit-property/, le post est
   créé en brouillon avec les coordonnées du déposant dans les meta
   _property_contact_*. Les fonctions ci-dessous rendent ces soumissions
   visibles immédiatement dans la liste « Biens » du back-office. */

/**
 * Ajoute une colonne « Soumis par » dans la liste des biens.
 */
add_filter( 'manage_property_posts_columns', function ( $cols ) {
	$new = array();
	foreach ( $cols as $key => $label ) {
		$new[ $key ] = $label;
		// Insère la nouvelle colonne juste après le titre.
		if ( $key === 'title' ) {
			$new['murailles_submitter'] = 'Soumis par';
		}
	}
	return $new;
} );

add_action( 'manage_property_posts_custom_column', function ( $col, $post_id ) {
	if ( $col !== 'murailles_submitter' ) {
		return;
	}
	$name  = get_post_meta( $post_id, '_property_contact_name',  true );
	$email = get_post_meta( $post_id, '_property_contact_email', true );
	$phone = get_post_meta( $post_id, '_property_contact_phone', true );

	if ( ! $name && ! $email && ! $phone ) {
		echo '<span style="color:#999;">— ajouté manuellement —</span>';
		return;
	}

	$bits = array();
	if ( $name ) {
		$bits[] = '<strong>' . esc_html( $name ) . '</strong>';
	}
	if ( $email ) {
		$bits[] = '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>';
	}
	if ( $phone ) {
		$tel = preg_replace( '/[^0-9+]/', '', $phone );
		$bits[] = '<a href="tel:' . esc_attr( $tel ) . '">' . esc_html( $phone ) . '</a>';
	}
	echo implode( '<br>', $bits );
}, 10, 2 );

/**
 * Compte les biens en brouillon (soumissions en attente) et affiche un
 * badge rouge à côté de l'entrée « Biens » dans le menu admin.
 */
add_action( 'admin_menu', function () {
	global $menu;
	if ( ! is_array( $menu ) ) {
		return;
	}
	$count = (int) wp_count_posts( 'property' )->draft;
	if ( $count < 1 ) {
		return;
	}
	foreach ( $menu as $key => $item ) {
		if ( isset( $item[2] ) && $item[2] === 'edit.php?post_type=property' ) {
			$menu[ $key ][0] = sprintf(
				'%s <span class="awaiting-mod count-%d"><span class="pending-count">%d</span></span>',
				$item[0],
				$count,
				$count
			);
			break;
		}
	}
}, 999 );

/**
 * Filtre la liste « Biens » sur les brouillons par défaut quand l'admin
 * arrive depuis le badge (sans pré-filtre actif). Petit détail UX : si on
 * laisse WordPress sur « Tous », on doit cliquer « Brouillons » manuellement
 * pour voir les nouvelles soumissions. Désactivé par défaut — décommentez
 * la ligne si vous voulez ce comportement automatique.
 */
// add_action( 'pre_get_posts', function ( $query ) {
//     if ( ! is_admin() || ! $query->is_main_query() ) return;
//     if ( $query->get( 'post_type' ) !== 'property' ) return;
//     if ( isset( $_GET['post_status'] ) ) return;
//     $query->set( 'post_status', 'draft' );
// } );

/**
 * Align the main query's posts_per_page with the archive template's value (6).
 * Why: archive-property.php runs its own WP_Query at 6 per page, but WordPress
 * still validates the URL against the *main* query. With the default 10/page,
 * /bien/page/2/ 404s whenever total properties ≤ 10, even though the template
 * shows a "page 2" link as soon as total > 6. Without this, the 7th–10th
 * property is reachable only on page 1, and the linked page 2 always 404s.
 */
add_action( 'pre_get_posts', function ( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) return;
	if ( $query->is_post_type_archive( 'property' ) ) {
		$query->set( 'posts_per_page', 6 );
	}
} );
