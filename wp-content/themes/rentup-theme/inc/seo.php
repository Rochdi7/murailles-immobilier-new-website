<?php
/**
 * SEO core: title tags, meta description, robots directives, canonicals.
 *
 * Goals:
 *   • Generate descriptive, unique titles per page (without an SEO plugin).
 *   • Generate a meta description from the page content or an explicit
 *     `_seo_description` post-meta field.
 *   • Send sensible robots directives (noindex on thin/utility pages).
 *   • Leave canonical/hreflang to WP core + Polylang (already working).
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

// Defensive fallback: murailles_opt() is defined in inc/theme-options.php which is
// loaded first in functions.php. If for any reason that file was not included
// (e.g. a hosting file-permission issue), define a no-op stub so this file
// never causes a PHP fatal error.
if ( ! function_exists( 'murailles_opt' ) ) {
	function murailles_opt( $key, $default = '' ) {
		$opts = (array) get_option( 'murailles_options', array() );
		return isset( $opts[ $key ] ) && $opts[ $key ] !== '' ? $opts[ $key ] : $default;
	}
}

/**
 * REST auth callback for SEO meta fields.
 *
 * @param bool   $allowed Current allowed state.
 * @param string $meta_key Meta key being edited.
 * @param int    $post_id Post ID.
 * @return bool
 */
function murailles_seo_meta_auth_callback( $allowed, $meta_key, $post_id ) {
	unset( $allowed, $meta_key );
	return current_user_can( 'edit_post', (int) $post_id );
}

/**
 * Sanitize SEO meta values before storage.
 *
 * @param mixed  $meta_value Raw meta value.
 * @param string $meta_key Meta key.
 * @return string
 */
function murailles_sanitize_seo_meta_value( $meta_value, $meta_key ) {
	$value = (string) $meta_value;

	if ( in_array( $meta_key, array( '_seo_og_image', '_seo_canonical' ), true ) ) {
		return esc_url_raw( $value );
	}

	if ( '_seo_noindex' === $meta_key ) {
		return empty( $value ) ? '' : '1';
	}

	return sanitize_text_field( $value );
}

/**
 * Build the page title for the current request.
 *
 * Priority order for singular posts/pages/properties:
 *   1. Yoast SEO / Rank Math / AIOSEO / SEOPress (when installed — they hook
 *      wp_title / pre_get_document_title themselves at higher priority).
 *   2. Custom `_seo_title` post-meta set via Royal MCP or the WP admin meta box.
 *   3. Theme-generated title (price-enriched for properties, etc.).
 *
 * Hooked to `pre_get_document_title` so it overrides WP's default.
 */
add_filter( 'pre_get_document_title', function ( $title ) {
	// Defer entirely to Yoast / Rank Math / AIOSEO / SEOPress when active.
	if ( defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) ||
	     class_exists( 'AIOSEO\Plugin\AIOSEO' ) || defined( 'SEOPRESS_VERSION' ) ) {
		return $title;
	}

	$site = get_bloginfo( 'name' );

	// Custom _seo_title meta wins over all theme-generated titles.
	if ( is_singular() ) {
		$id         = get_queried_object_id();
		$seo_title  = get_post_meta( $id, '_seo_title', true );
		if ( $seo_title ) {
			return $seo_title;
		}
	}

	if ( is_front_page() ) {
		$tagline = murailles_t( 'Agence immobilière à Marrakech', false );
		return sprintf( '%s — %s', $site, $tagline );
	}

	if ( is_singular( 'property' ) ) {
		$id     = get_queried_object_id();
		$ptitle = get_the_title( $id );
		$price  = (int) get_post_meta( $id, '_property_price', true );
		if ( $price > 0 ) {
			return sprintf(
				'%s — %s €%s | %s',
				$ptitle,
				number_format_i18n( $price ),
				get_post_meta( $id, '_property_price_suffix', true ) ? ' ' . get_post_meta( $id, '_property_price_suffix', true ) : '',
				$site
			);
		}
		return sprintf( '%s | %s', $ptitle, $site );
	}

	if ( is_singular() ) {
		return sprintf( '%s | %s', get_the_title(), $site );
	}

	if ( is_post_type_archive( 'property' ) ) {
		return sprintf( '%s | %s', murailles_t( 'Biens immobiliers à vendre et à louer au Maroc', false ), $site );
	}

	if ( is_tax( array( 'property_category', 'property_location', 'property_area' ) ) ) {
		$term = get_queried_object();
		if ( $term ) {
			$prefix = is_tax( 'property_category' ) ? murailles_t( 'Biens', false )
				: ( is_tax( 'property_location' ) ? murailles_t( 'Biens à', false ) : murailles_t( 'Biens dans le quartier', false ) );
			return sprintf( '%s %s | %s', $prefix, $term->name, $site );
		}
	}

	if ( is_search() ) {
		return sprintf( '%s : %s | %s', murailles_t( 'Recherche', false ), esc_html( get_search_query() ), $site );
	}

	if ( is_404() ) {
		return sprintf( '%s | %s', murailles_t( 'Page introuvable', false ), $site );
	}

	if ( is_home() ) {
		return sprintf( '%s | %s', murailles_t( 'Actualités & Articles', false ), $site );
	}

	// Fallback: WP default.
	return $title;
}, 10, 1 );

/**
 * Get/derive a meta description for the current request.
 * Honors a `_seo_description` post-meta override set via Royal MCP or the
 * WP admin meta box; falls back to excerpt, then trimmed content.
 * Returns empty string when Yoast/RankMath/AIOSEO/SEOPress is active —
 * those plugins emit the description tag themselves.
 */
function murailles_seo_description() {
	$site_tagline = get_bloginfo( 'description' );

	if ( is_front_page() ) {
		// Theme options override → site tagline → hardcoded default.
		$opt_desc = murailles_opt( 'seo_site_description' );
		return $opt_desc ?: ( $site_tagline ?: murailles_t( "Agence immobilière à Marrakech. Riads d'exception, villas, appartements et terrains à vendre ou à louer au Maroc avec un accompagnement complet de A à Z.", false ) );
	}

	if ( is_singular() ) {
		$id = get_queried_object_id();
		$custom = get_post_meta( $id, '_seo_description', true );
		if ( $custom ) { return $custom; }

		if ( has_excerpt( $id ) ) {
			return wp_strip_all_tags( get_the_excerpt( $id ) );
		}

		// Build a description from the first ~30 words of the content.
		$content = wp_strip_all_tags( get_post_field( 'post_content', $id ) );
		$content = preg_replace( '/\s+/', ' ', $content );
		$desc    = wp_trim_words( $content, 30, '…' );

		// For properties, prepend the category + city + price so the snippet is dense with intent signals.
		if ( get_post_type( $id ) === 'property' ) {
			$cats  = wp_get_post_terms( $id, 'property_category', array( 'fields' => 'names' ) );
			$locs  = wp_get_post_terms( $id, 'property_location', array( 'fields' => 'names' ) );
			$price = (int) get_post_meta( $id, '_property_price', true );
			$bits  = array();
			if ( ! empty( $cats ) )  { $bits[] = $cats[0]; }
			if ( ! empty( $locs ) )  { $bits[] = $locs[0]; }
			if ( $price > 0 )        { $bits[] = number_format_i18n( $price ) . ' €'; }
			if ( $bits ) {
				$desc = implode( ' · ', $bits ) . ' — ' . $desc;
			}
		}
		return $desc;
	}

	if ( is_post_type_archive( 'property' ) ) {
		return murailles_t( "Découvrez tous les biens immobiliers proposés par l'Agence Murailles à Marrakech, Casablanca, Rabat et dans les plus belles villes du Maroc.", false );
	}

	if ( is_tax() ) {
		$term = get_queried_object();
		if ( $term && $term->description ) { return wp_strip_all_tags( $term->description ); }
		if ( $term ) {
			return sprintf(
				/* translators: %s is the taxonomy term name (e.g. "Villa", "Marrakech") */
				murailles_t( 'Biens immobiliers dans la catégorie « %s » par Agence Murailles Immobilier au Maroc.', false ),
				$term->name
			);
		}
	}

	if ( is_home() ) {
		return murailles_t( "Le blog de l'Agence Murailles Immobilier : conseils, tendances du marché et guides pour acheter, vendre ou louer un bien au Maroc.", false );
	}

	return $site_tagline;
}

/**
 * Emit <meta name="description"> in <head>.
 * Suppressed when Yoast SEO, Rank Math, AIOSEO, or SEOPress is active
 * to prevent duplicate meta description tags.
 */
add_action( 'wp_head', function () {
	if ( defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) ||
	     class_exists( 'AIOSEO\Plugin\AIOSEO' ) || defined( 'SEOPRESS_VERSION' ) ) {
		return;
	}
	$desc = apply_filters( 'murailles_seo_description_output', murailles_seo_description() );
	if ( ! $desc ) { return; }
	$desc = trim( wp_strip_all_tags( $desc ) );
	$desc = preg_replace( '/\s+/', ' ', $desc );
	// Soft 160-char cap — Google truncates at ~155-160.
	if ( mb_strlen( $desc ) > 160 ) {
		$desc = mb_substr( $desc, 0, 157 ) . '…';
	}
	printf( '<meta name="description" content="%s" />' . "\n", esc_attr( $desc ) );
}, 1 );

/**
 * Homepage fallback meta description by language when no explicit SEO text exists.
 */
add_filter( 'murailles_seo_description_output', function ( $desc ) {
	if ( ! is_front_page() ) {
		return $desc;
	}

	$desc = trim( (string) $desc );
	$custom_desc = trim( (string) murailles_opt( 'seo_site_description' ) );
	if ( '' !== $custom_desc ) {
		return $desc;
	}

	$lang = function_exists( 'murailles_current_lang' ) ? murailles_current_lang() : 'fr';
	$site_tagline = trim( (string) get_bloginfo( 'description' ) );

	if ( '' !== $desc && $desc !== $site_tagline ) {
		return $desc;
	}

	if ( 'en' === $lang ) {
		return 'Real estate agency in Marrakech specializing in sales, rentals and management of riads, villas and apartments in Morocco.';
	}

	return 'Agence immobilière à Marrakech spécialisée dans la vente, location et gestion de riads, villas et appartements au Maroc.';
}, 20 );

/**
 * If a third-party SEO plugin stays silent on the front page, inject the
 * theme fallback meta description without creating duplicates.
 */
function murailles_capture_front_page_head_for_meta_description() {
	if ( is_admin() || ! is_front_page() ) {
		return;
	}

	if ( ! defined( 'WPSEO_VERSION' ) && ! defined( 'RANK_MATH_VERSION' ) &&
		! class_exists( 'AIOSEO\\Plugin\\AIOSEO' ) && ! defined( 'SEOPRESS_VERSION' ) ) {
		return;
	}

	$GLOBALS['murailles_head_desc_capture'] = true;
	ob_start();
}
add_action( 'wp_head', 'murailles_capture_front_page_head_for_meta_description', 0 );

function murailles_output_front_page_head_with_meta_description_fallback() {
	if ( is_admin() || ! is_front_page() || empty( $GLOBALS['murailles_head_desc_capture'] ) || ! ob_get_level() ) {
		return;
	}

	unset( $GLOBALS['murailles_head_desc_capture'] );
	$head = (string) ob_get_clean();
	$has_description = false !== stripos( $head, '<meta name="description"' )
		|| false !== stripos( $head, "<meta name='description'" );

	if ( ! $has_description ) {
		$desc = apply_filters( 'murailles_seo_description_output', murailles_seo_description() );
		$desc = trim( preg_replace( '/\s+/', ' ', wp_strip_all_tags( (string) $desc ) ) );

		if ( '' !== $desc ) {
			if ( function_exists( 'mb_strlen' ) && mb_strlen( $desc ) > 160 ) {
				$desc = mb_substr( $desc, 0, 157 ) . '...';
			}

			$head = sprintf( '<meta name="description" content="%s" />' . "\n", esc_attr( $desc ) ) . $head;
		}
	}

	echo $head; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action( 'wp_head', 'murailles_output_front_page_head_with_meta_description_fallback', PHP_INT_MAX );

/* ============================================================
 * Register all SEO meta keys for pages, posts, and properties.
 * show_in_rest:true lets Royal MCP read/write them via wp_get_post_meta
 * and wp_update_post_meta. Property-specific registration is in
 * custom-post-types.php; here we cover post + page.
 *
 * Royal MCP keys reference:
 *   _seo_title         → overrides <title>
 *   _seo_description   → overrides <meta name="description">
 *   _seo_focus_keyword → target keyword (stored, used in future hints)
 *   _seo_og_image      → custom OG/Twitter share image URL
 *   _seo_canonical     → custom canonical URL (overrides WP default)
 *   _seo_noindex       → set to "1" to noindex this post/page
 * ============================================================ */
add_action( 'init', function () {
	$seo_keys = array(
		'_seo_title'         => 'string',
		'_seo_description'   => 'string',
		'_seo_focus_keyword' => 'string',
		'_seo_og_image'      => 'string',
		'_seo_canonical'     => 'string',
		'_seo_noindex'       => 'string',
	);
	foreach ( array( 'post', 'page' ) as $pt ) {
		foreach ( $seo_keys as $key => $type ) {
			register_meta( 'post', $key, array(
				'object_subtype' => $pt,
				'type'           => $type,
				'single'         => true,
				'show_in_rest'   => true,
				'sanitize_callback' => 'murailles_sanitize_seo_meta_value',
				'auth_callback'     => 'murailles_seo_meta_auth_callback',
			) );
		}
	}
} );

/* ============================================================
 * SEO Meta Box — shown on pages, posts, and property biens.
 * All fields are also writable via Royal MCP (wp_update_post_meta).
 * When Yoast/Rank Math is active the frontend tags are suppressed
 * (those plugins own them), but the fields are still stored and
 * readable via Royal MCP for reference.
 * ============================================================ */
function murailles_seo_metabox_register() {
	add_meta_box(
		'murailles_seo_fields',
		__( 'SEO — Titre, Description & Avancé', 'murailles' ),
		'murailles_seo_metabox_render',
		array( 'post', 'page', 'property' ),
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'murailles_seo_metabox_register' );

function murailles_seo_metabox_render( $post ) {
	wp_nonce_field( 'murailles_seo_save', 'murailles_seo_nonce' );

	$seo_title   = (string) get_post_meta( $post->ID, '_seo_title',         true );
	$seo_desc    = (string) get_post_meta( $post->ID, '_seo_description',   true );
	$seo_kw      = (string) get_post_meta( $post->ID, '_seo_focus_keyword', true );
	$seo_og_img  = (string) get_post_meta( $post->ID, '_seo_og_image',      true );
	$seo_canon   = (string) get_post_meta( $post->ID, '_seo_canonical',     true );
	$seo_noindex = (string) get_post_meta( $post->ID, '_seo_noindex',       true );

	$plugin_active = defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) ||
	                 class_exists( 'AIOSEO\Plugin\AIOSEO' ) || defined( 'SEOPRESS_VERSION' );

	$notice_color = $plugin_active ? '#856404' : '#0c5460';
	$notice_bg    = $plugin_active ? '#fff3cd' : '#d1ecf1';
	$notice_msg   = $plugin_active
		? __( 'Un plugin SEO est actif (Yoast / Rank Math). Le titre et la description ci-dessous sont ignorés sur le frontend — le plugin SEO les gère. Les champs Canonical, Noindex et Image OG restent actifs.', 'murailles' )
		: __( 'Ces champs sont utilisés directement par le thème. Laissez vides pour la génération automatique. Modifiables aussi via Royal MCP avec wp_update_post_meta.', 'murailles' );
	?>
	<div style="background:<?php echo esc_attr( $notice_bg ); ?>;border-left:4px solid <?php echo esc_attr( $notice_color ); ?>;padding:8px 12px;margin-bottom:12px;border-radius:2px;color:<?php echo esc_attr( $notice_color ); ?>;font-size:13px;">
		<?php echo esc_html( $notice_msg ); ?>
	</div>

	<table class="form-table" style="margin-top:0">
		<tr>
			<th style="width:160px;padding-top:10px"><label for="murailles_seo_title"><?php esc_html_e( 'Titre SEO', 'murailles' ); ?></label></th>
			<td>
				<input type="text" id="murailles_seo_title" name="murailles_seo_title"
					value="<?php echo esc_attr( $seo_title ); ?>"
					style="width:100%;max-width:680px"
					placeholder="<?php esc_attr_e( 'Laisser vide → titre auto', 'murailles' ); ?>" />
				<p class="description"><?php esc_html_e( 'Onglet navigateur + résultats Google. Idéalement 50–60 caractères. Clé Royal MCP : _seo_title', 'murailles' ); ?></p>
			</td>
		</tr>
		<tr>
			<th style="padding-top:10px"><label for="murailles_seo_description"><?php esc_html_e( 'Meta description', 'murailles' ); ?></label></th>
			<td>
				<textarea id="murailles_seo_description" name="murailles_seo_description"
					rows="3" style="width:100%;max-width:680px"
					placeholder="<?php esc_attr_e( 'Laisser vide → description auto', 'murailles' ); ?>"><?php echo esc_textarea( $seo_desc ); ?></textarea>
				<p class="description"><?php esc_html_e( 'Snippet Google. Idéalement 120–155 caractères. Clé Royal MCP : _seo_description', 'murailles' ); ?></p>
			</td>
		</tr>
		<tr>
			<th style="padding-top:10px"><label for="murailles_seo_focus_keyword"><?php esc_html_e( 'Mot-clé cible', 'murailles' ); ?></label></th>
			<td>
				<input type="text" id="murailles_seo_focus_keyword" name="murailles_seo_focus_keyword"
					value="<?php echo esc_attr( $seo_kw ); ?>"
					style="width:100%;max-width:400px"
					placeholder="ex: riad à vendre marrakech" />
				<p class="description"><?php esc_html_e( 'Mémorisé pour référence et compatibilité Yoast/Rank Math. Clé Royal MCP : _seo_focus_keyword', 'murailles' ); ?></p>
			</td>
		</tr>
		<tr>
			<th style="padding-top:10px"><label for="murailles_seo_og_image"><?php esc_html_e( 'Image OG / Réseaux sociaux', 'murailles' ); ?></label></th>
			<td>
				<input type="url" id="murailles_seo_og_image" name="murailles_seo_og_image"
					value="<?php echo esc_attr( $seo_og_img ); ?>"
					style="width:100%;max-width:680px"
					placeholder="https://…/image.jpg (1200×630 recommandé)" />
				<p class="description"><?php esc_html_e( 'Remplace l\'image partagée sur Facebook/WhatsApp/Twitter. Laissez vide → image mise en avant ou galerie. Clé Royal MCP : _seo_og_image', 'murailles' ); ?></p>
			</td>
		</tr>
		<tr>
			<th style="padding-top:10px"><label for="murailles_seo_canonical"><?php esc_html_e( 'URL Canonique', 'murailles' ); ?></label></th>
			<td>
				<input type="url" id="murailles_seo_canonical" name="murailles_seo_canonical"
					value="<?php echo esc_attr( $seo_canon ); ?>"
					style="width:100%;max-width:680px"
					placeholder="Laisser vide → URL WordPress par défaut" />
				<p class="description"><?php esc_html_e( 'Utilisez uniquement si cette page est un doublon d\'une autre URL. Clé Royal MCP : _seo_canonical', 'murailles' ); ?></p>
			</td>
		</tr>
		<tr>
			<th style="padding-top:10px"><?php esc_html_e( 'Robots', 'murailles' ); ?></th>
			<td>
				<label>
					<input type="checkbox" name="murailles_seo_noindex" value="1" <?php checked( $seo_noindex, '1' ); ?> />
					<?php esc_html_e( 'Exclure cette page de l\'index Google (noindex)', 'murailles' ); ?>
				</label>
				<p class="description"><?php esc_html_e( 'Cochez pour les pages de test, doublons, ou contenu mince. Clé Royal MCP : _seo_noindex (valeur "1" ou "").', 'murailles' ); ?></p>
			</td>
		</tr>
	</table>
	<?php
}

function murailles_seo_metabox_save( $post_id ) {
	if ( ! isset( $_POST['murailles_seo_nonce'] ) ) { return; }
	if ( ! wp_verify_nonce( $_POST['murailles_seo_nonce'], 'murailles_seo_save' ) ) { return; }
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
	if ( ! current_user_can( 'edit_post', $post_id ) ) { return; }

	$fields = array(
		'_seo_title'         => array( 'murailles_seo_title',         'sanitize_text_field' ),
		'_seo_description'   => array( 'murailles_seo_description',   'sanitize_textarea_field' ),
		'_seo_focus_keyword' => array( 'murailles_seo_focus_keyword', 'sanitize_text_field' ),
		'_seo_og_image'      => array( 'murailles_seo_og_image',      'esc_url_raw' ),
		'_seo_canonical'     => array( 'murailles_seo_canonical',     'esc_url_raw' ),
	);
	foreach ( $fields as $meta_key => $cfg ) {
		list( $field_name, $sanitize ) = $cfg;
		$value = isset( $_POST[ $field_name ] ) ? call_user_func( $sanitize, wp_unslash( $_POST[ $field_name ] ) ) : '';
		if ( $value ) {
			update_post_meta( $post_id, $meta_key, $value );
		} else {
			delete_post_meta( $post_id, $meta_key );
		}
	}

	// Checkbox — absent when unchecked.
	$noindex = isset( $_POST['murailles_seo_noindex'] ) ? '1' : '';
	if ( $noindex ) {
		update_post_meta( $post_id, '_seo_noindex', '1' );
	} else {
		delete_post_meta( $post_id, '_seo_noindex' );
	}
}
add_action( 'save_post', 'murailles_seo_metabox_save' );

/**
 * Emit <link rel="canonical"> when a per-post override is set via _seo_canonical.
 * WP core + Polylang already output the default canonical — we only override
 * when the field is non-empty, by removing WP's canonical and printing ours.
 */
add_action( 'wp_head', function () {
	if ( ! is_singular() ) { return; }
	$canon = (string) get_post_meta( get_queried_object_id(), '_seo_canonical', true );
	if ( ! $canon ) { return; }
	// Remove WP core's auto canonical so we don't duplicate it.
	remove_action( 'wp_head', 'rel_canonical' );
	printf( '<link rel="canonical" href="%s" />' . "\n", esc_url( $canon ) );
}, 1 );

/**
 * Robots directives: noindex utility pages so they don't dilute the index.
 * Also respects the per-post _seo_noindex meta set via admin or Royal MCP.
 */
add_filter( 'wp_robots', function ( $robots ) {
	$noindex_paths = array( '/favoris/', '/compare-property/', '/erreur/', '/checkout/' );
	$req = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '';

	$noindex = false;
	if ( is_search() )     { $noindex = true; }
	if ( is_attachment() ) { $noindex = true; }
	if ( is_404() )        { $noindex = true; }
	if ( is_paged() && get_query_var( 'paged' ) > 1 ) {
		$page = (int) get_query_var( 'paged' );
		if ( $page > 3 ) { $noindex = true; }
	}
	foreach ( $noindex_paths as $path ) {
		if ( strpos( $req, $path ) !== false ) { $noindex = true; break; }
	}
	// Per-post noindex override (set via WP admin meta box or Royal MCP _seo_noindex key).
	if ( is_singular() && get_post_meta( get_queried_object_id(), '_seo_noindex', true ) === '1' ) {
		$noindex = true;
	}

	$force_indexable_home = function_exists( 'murailles_is_production_like_environment' )
		&& murailles_is_production_like_environment()
		&& is_front_page()
		&& ! $noindex;

	if ( $force_indexable_home ) {
		unset( $robots['noindex'], $robots['nofollow'] );
		$robots['index']              = true;
		$robots['follow']             = true;
		$robots['max-image-preview']  = 'large';
		$robots['max-snippet']        = -1;
		$robots['max-video-preview']  = -1;
		return $robots;
	}

	if ( $noindex ) {
		$robots['noindex']  = true;
		$robots['nofollow'] = false;
	} else {
		$robots['index']  = true;
		$robots['follow'] = true;
	}
	$robots['max-image-preview'] = 'large';
	$robots['max-snippet']       = -1;
	$robots['max-video-preview'] = -1;
	return $robots;
}, 10, 1 );

add_filter( 'wpseo_robots', function ( $robots ) {
	if ( ! function_exists( 'murailles_is_production_like_environment' ) || ! murailles_is_production_like_environment() || ! is_front_page() ) {
		return $robots;
	}

	return 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1';
} );

add_filter( 'rank_math/frontend/robots', function ( $robots ) {
	if ( ! function_exists( 'murailles_is_production_like_environment' ) || ! murailles_is_production_like_environment() || ! is_front_page() ) {
		return $robots;
	}

	$robots['index'] = 'index';
	$robots['follow'] = 'follow';
	unset( $robots['noindex'], $robots['nofollow'] );

	return $robots;
} );

/**
 * Emit hreflang tags for FR/EN translations when Polylang is active.
 */
add_action( 'wp_head', function () {
	if ( ! function_exists( 'pll_get_post_translations' ) || ! is_singular() ) {
		return;
	}

	$post_id = get_queried_object_id();
	if ( ! $post_id ) {
		return;
	}

	$translations = pll_get_post_translations( $post_id );
	if ( empty( $translations ) || count( $translations ) < 2 ) {
		return;
	}

	echo "\n<!-- hreflang (Murailles) -->\n";
	foreach ( $translations as $lang => $translation_id ) {
		$url = get_permalink( $translation_id );
		if ( ! $url ) {
			continue;
		}

		printf(
			'<link rel="alternate" hreflang="%s" href="%s" />' . "\n",
			esc_attr( $lang ),
			esc_url( $url )
		);
	}

	if ( ! empty( $translations['fr'] ) ) {
		printf(
			'<link rel="alternate" hreflang="x-default" href="%s" />' . "\n",
			esc_url( get_permalink( $translations['fr'] ) )
		);
	}
}, 11 );
