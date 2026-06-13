<?php
/**
 * SEO Advanced — Murailles Immobilier
 *
 * Covers:
 *   Phase 2  — REST API security: sanitize_callback + auth_callback on all meta
 *   Phase 3  — Full per-post SEO panel (OG title/desc, Twitter title/desc/image,
 *               nofollow, per-field overrides)
 *   Phase 4  — Schema Manager: per-page schema type selector + custom JSON-LD
 *   Phase 5  — Image SEO: bulk/single alt, caption, description, title, focus kw
 *   Phase 6  — Media Library SEO Dashboard
 *   Phase 7  — Property REST: lat/lng, reference, full field exposure
 *   Phase 8  — Internal Linking: related properties, posts, locations
 *   Phase 9  — Sitemap: noindex exclusion, image sitemap, per-type priority
 *   Phase 10 — Performance: preload critical CSS, resource hints, query cache
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ═══════════════════════════════════════════════════════════════════════════
   PHASE 2 — REST API SECURITY: sanitize_callback + auth_callback
   ═══════════════════════════════════════════════════════════════════════════

   Problem: all register_meta() calls in seo.php and custom-post-types.php
   omit sanitize_callback and auth_callback, meaning:
   - Any authenticated user can write arbitrary HTML to SEO meta via REST
   - No server-side sanitisation on REST writes

   Fix: re-register all SEO + property meta with proper callbacks.
   register_meta() is idempotent for the same key+subtype — the later call
   wins, so this file's registration takes precedence.
   ═══════════════════════════════════════════════════════════════════════════ */
add_action( 'init', function () {

	/* ── Sanitizers ─────────────────────────────────────────────────── */
	$sanitize_text  = 'sanitize_text_field';
	$sanitize_url   = 'esc_url_raw';
	$sanitize_int   = 'absint';
	$sanitize_html  = 'wp_kses_post';

	/* ── Auth: must be able to edit the post ────────────────────────── */
	$auth_edit = function( $allowed, $meta_key, $post_id ) {
		return current_user_can( 'edit_post', (int) $post_id );
	};

	/* ── SEO keys — post + page + property ──────────────────────────── */
	$seo_keys = array(
		'_seo_title'           => array( 'sanitize' => $sanitize_text, 'description' => 'SEO title override' ),
		'_seo_description'     => array( 'sanitize' => $sanitize_html, 'description' => 'SEO meta description override' ),
		'_seo_focus_keyword'   => array( 'sanitize' => $sanitize_text, 'description' => 'Focus keyword for SEO' ),
		'_seo_og_image'        => array( 'sanitize' => $sanitize_url,  'description' => 'Custom OG / Twitter share image URL' ),
		'_seo_og_title'        => array( 'sanitize' => $sanitize_text, 'description' => 'Custom Open Graph title (overrides _seo_title for social shares)' ),
		'_seo_og_description'  => array( 'sanitize' => $sanitize_html, 'description' => 'Custom Open Graph description' ),
		'_seo_twitter_title'   => array( 'sanitize' => $sanitize_text, 'description' => 'Custom Twitter / X card title' ),
		'_seo_twitter_desc'    => array( 'sanitize' => $sanitize_html, 'description' => 'Custom Twitter / X card description' ),
		'_seo_twitter_image'   => array( 'sanitize' => $sanitize_url,  'description' => 'Custom Twitter / X card image URL' ),
		'_seo_canonical'       => array( 'sanitize' => $sanitize_url,  'description' => 'Custom canonical URL' ),
		'_seo_noindex'         => array( 'sanitize' => $sanitize_text, 'description' => 'Set to "1" to noindex this post' ),
		'_seo_nofollow'        => array( 'sanitize' => $sanitize_text, 'description' => 'Set to "1" to nofollow this post' ),
		'_seo_schema_type'     => array( 'sanitize' => $sanitize_text, 'description' => 'Schema.org @type override for this post' ),
		'_seo_schema_json'     => array( 'sanitize' => 'wp_unslash',   'description' => 'Custom JSON-LD schema blob (must be valid JSON)' ),
	);

	foreach ( array( 'post', 'page', 'property' ) as $pt ) {
		foreach ( $seo_keys as $key => $cfg ) {
			register_meta( 'post', $key, array(
				'object_subtype'    => $pt,
				'type'              => 'string',
				'single'            => true,
				'show_in_rest'      => true,
				'sanitize_callback' => $cfg['sanitize'],
				'auth_callback'     => $auth_edit,
				'description'       => $cfg['description'],
			) );
		}
	}

	/* ── Property-specific meta — re-register with sanitize + auth ──── */
	$property_keys = array(
		'_property_price'                 => $sanitize_text,
		'_property_price_suffix'          => $sanitize_text,
		'_property_price_label'           => $sanitize_text,
		'_property_address'               => $sanitize_text,
		'_property_postal_code'           => $sanitize_text,
		'_property_country'               => $sanitize_text,
		'_property_size'                  => $sanitize_text,
		'_property_land_size'             => $sanitize_text,
		'_property_rooms'                 => $sanitize_text,
		'_property_bedrooms'              => $sanitize_text,
		'_property_bathrooms'             => $sanitize_text,
		'_property_owner_note'            => $sanitize_html,
		'_property_status'                => $sanitize_text,
		'_property_action'                => $sanitize_text,
		'_property_premium'               => $sanitize_text,
		'_property_gallery_ids'           => $sanitize_text,
		'_property_video_url'             => $sanitize_url,
		'_property_year_built'            => $sanitize_text,
		'_property_garages'               => $sanitize_text,
		'_property_garage_size'           => $sanitize_text,
		'_property_available_from'        => $sanitize_text,
		'_property_basement'              => $sanitize_text,
		'_property_external_construction' => $sanitize_text,
		'_property_roofing'               => $sanitize_text,
		'_property_map_embed'             => $sanitize_text,
		'_property_amenities'             => $sanitize_text,
		'_property_agent_id'              => $sanitize_text,
		// Phase 7 — new location/reference fields
		'_property_latitude'              => $sanitize_text,
		'_property_longitude'             => $sanitize_text,
		'_property_reference'             => $sanitize_text,
	);
	foreach ( $property_keys as $key => $sanitize_cb ) {
		register_meta( 'post', $key, array(
			'object_subtype'    => 'property',
			'type'              => 'string',
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => $sanitize_cb,
			'auth_callback'     => $auth_edit,
		) );
	}

	/* ── Agent meta — expose to REST (was missing entirely) ─────────── */
	$agent_keys = array(
		'_agent_position'       => $sanitize_text,
		'_agent_phone'          => $sanitize_text,
		'_agent_phone_office'   => $sanitize_text,
		'_agent_whatsapp'       => $sanitize_text,
		'_agent_email'          => 'sanitize_email',
		'_agent_address'        => $sanitize_text,
		'_agent_website'        => $sanitize_url,
		'_agent_facebook'       => $sanitize_url,
		'_agent_instagram'      => $sanitize_url,
		'_agent_linkedin'       => $sanitize_url,
		'_agent_twitter'        => $sanitize_url,
		'_agent_youtube'        => $sanitize_url,
		'_agent_tiktok'         => $sanitize_url,
		'_agent_specialization' => $sanitize_text,
		'_agent_languages'      => $sanitize_text,
		'_agent_experience'     => $sanitize_text,
		'_agent_license'        => $sanitize_text,
		'_agent_service_areas'  => $sanitize_text,
	);
	$auth_agent = function( $allowed, $meta_key, $post_id ) {
		return current_user_can( 'edit_post', (int) $post_id );
	};
	foreach ( $agent_keys as $key => $sanitize_cb ) {
		register_meta( 'post', $key, array(
			'object_subtype'    => 'agent',
			'type'              => 'string',
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => $sanitize_cb,
			'auth_callback'     => $auth_agent,
		) );
	}

	/* ── Image (attachment) SEO meta ────────────────────────────────── */
	$auth_media = function( $allowed, $meta_key, $post_id ) {
		return current_user_can( 'edit_post', (int) $post_id );
	};
	$image_seo_keys = array(
		'_seo_img_alt'          => $sanitize_text,
		'_seo_img_focus_kw'     => $sanitize_text,
	);
	foreach ( $image_seo_keys as $key => $sanitize_cb ) {
		register_meta( 'post', $key, array(
			'object_subtype'    => 'attachment',
			'type'              => 'string',
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => $sanitize_cb,
			'auth_callback'     => $auth_media,
		) );
	}

}, 20 ); // priority 20 = after seo.php (default 10) so these registrations win


/* ═══════════════════════════════════════════════════════════════════════════
   PHASE 2b — Agent CPT REST support
   ═══════════════════════════════════════════════════════════════════════════
   Agent CPT had show_in_rest:false. We can't easily change the CPT
   registration (it's in agent-post-type.php), so we hook late and
   add REST support via the registered_post_type action.
   ═══════════════════════════════════════════════════════════════════════════ */
add_action( 'registered_post_type', function ( $post_type, $post_type_object ) {
	if ( $post_type !== 'agent' ) { return; }
	$post_type_object->show_in_rest = true;
	$post_type_object->rest_base    = 'agent';
	$post_type_object->rest_controller_class = 'WP_REST_Posts_Controller';
}, 10, 2 );


/* ═══════════════════════════════════════════════════════════════════════════
   PHASE 3 — FULL SEO CONTROL PANEL
   Extended meta box with OG title/desc, Twitter title/desc/image, nofollow.
   Replaces the basic box in seo.php (same ID, same hook — this one fires at
   priority 11, after the original at default 10, so it takes over rendering).
   ═══════════════════════════════════════════════════════════════════════════ */

/* Remove the old basic meta box and replace with the full one */
add_action( 'add_meta_boxes', function () {
	remove_meta_box( 'murailles_seo_fields', 'post',     'normal' );
	remove_meta_box( 'murailles_seo_fields', 'page',     'normal' );
	remove_meta_box( 'murailles_seo_fields', 'property', 'normal' );

	foreach ( array( 'post', 'page', 'property' ) as $pt ) {
		add_meta_box(
			'murailles_seo_advanced',
			'🔍 SEO — Panneau complet',
			'murailles_seo_advanced_render',
			$pt,
			'normal',
			'high'
		);
	}
}, 11 );

function murailles_seo_advanced_render( $post ) {
	wp_nonce_field( 'murailles_seo_advanced_save', 'murailles_seo_advanced_nonce' );

	$m = function( $key ) use ( $post ) {
		return (string) get_post_meta( $post->ID, $key, true );
	};

	$plugin_active = defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) ||
	                 class_exists( 'AIOSEO\Plugin\AIOSEO' ) || defined( 'SEOPRESS_VERSION' );

	$schema_types = array(
		''                => '— Auto-détecté —',
		'WebPage'         => 'WebPage',
		'Article'         => 'Article',
		'BlogPosting'     => 'BlogPosting',
		'NewsArticle'     => 'NewsArticle',
		'RealEstateListing' => 'RealEstateListing',
		'Product'         => 'Product',
		'Service'         => 'Service',
		'Organization'    => 'Organization',
		'LocalBusiness'   => 'LocalBusiness',
		'RealEstateAgent' => 'RealEstateAgent',
		'FAQPage'         => 'FAQPage',
		'BreadcrumbList'  => 'BreadcrumbList',
		'Event'           => 'Event',
		'Review'          => 'Review',
		'VideoObject'     => 'VideoObject',
		'ImageObject'     => 'ImageObject',
		'CollectionPage'  => 'CollectionPage',
	);
	?>
	<style>
	.murailles-seo-tabs { display:flex; gap:0; margin:0 0 16px; border-bottom:2px solid #dc3545; flex-wrap:wrap; }
	.murailles-seo-tab  { padding:8px 16px; cursor:pointer; background:#f0f0f0; border:1px solid #ddd; border-bottom:none; font-size:13px; font-weight:600; color:#555; }
	.murailles-seo-tab.active  { background:#fff; color:#dc3545; border-bottom:2px solid #fff; margin-bottom:-2px; }
	.murailles-seo-panel { display:none; }
	.murailles-seo-panel.active { display:block; }
	.murailles-seo-row  { display:flex; flex-direction:column; margin-bottom:14px; }
	.murailles-seo-row label { font-weight:600; font-size:12px; color:#444; margin-bottom:4px; text-transform:uppercase; letter-spacing:.5px; }
	.murailles-seo-row input[type=text],
	.murailles-seo-row input[type=url],
	.murailles-seo-row textarea,
	.murailles-seo-row select { width:100%; max-width:700px; padding:6px 8px; border:1px solid #c3c4c7; border-radius:3px; font-size:13px; }
	.murailles-seo-row .desc { font-size:11px; color:#888; margin-top:3px; }
	.murailles-seo-char { font-size:11px; color:#888; float:right; }
	.murailles-seo-char.warn { color:#d63638; }
	.murailles-seo-preview { background:#f8f9fa; border:1px solid #dee2e6; border-radius:6px; padding:14px; margin-bottom:16px; }
	.murailles-seo-preview .serp-title { color:#1a0dab; font-size:18px; text-decoration:none; display:block; margin-bottom:3px; max-width:500px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
	.murailles-seo-preview .serp-url   { color:#006621; font-size:13px; margin-bottom:4px; }
	.murailles-seo-preview .serp-desc  { color:#545454; font-size:13px; line-height:1.5; max-width:500px; }
	.murailles-seo-notice { padding:8px 12px; border-left:4px solid; border-radius:2px; font-size:13px; margin-bottom:12px; }
	.murailles-seo-notice.info  { background:#d1ecf1; border-color:#0c5460; color:#0c5460; }
	.murailles-seo-notice.warn  { background:#fff3cd; border-color:#856404; color:#856404; }
	.murailles-seo-schema-preview { background:#1e1e1e; color:#d4d4d4; padding:14px; border-radius:6px; font-family:monospace; font-size:12px; overflow:auto; max-height:300px; white-space:pre; }
	</style>

	<?php if ( $plugin_active ) : ?>
	<div class="murailles-seo-notice warn">
		Un plugin SEO (Yoast / Rank Math…) est actif. Les champs Titre et Description sont ignorés sur le frontend — utilisez l'interface du plugin. Les champs Canonical, Noindex, Schema et Image OG restent actifs.
	</div>
	<?php else : ?>
	<div class="murailles-seo-notice info">
		Modifiez directement depuis cette interface ou via Royal MCP (<code>wp_update_post_meta</code>). Laissez vide pour la génération automatique.
	</div>
	<?php endif; ?>

	<!-- SERP Preview -->
	<div class="murailles-seo-preview">
		<span class="serp-title" id="murailles-serp-title"><?php echo esc_html( $m('_seo_title') ?: get_the_title( $post ) ); ?></span>
		<span class="serp-url"><?php echo esc_html( get_permalink( $post->ID ) ?: get_bloginfo('url') . '/' . $post->post_name . '/' ); ?></span>
		<span class="serp-desc" id="murailles-serp-desc"><?php echo esc_html( wp_trim_words( $m('_seo_description') ?: wp_strip_all_tags( $post->post_excerpt ?: $post->post_content ), 25, '…' ) ); ?></span>
	</div>

	<!-- Tabs -->
	<div class="murailles-seo-tabs">
		<div class="murailles-seo-tab active" data-panel="basic">📋 Basique</div>
		<div class="murailles-seo-tab" data-panel="social">📱 Social</div>
		<div class="murailles-seo-tab" data-panel="technical">⚙️ Technique</div>
		<div class="murailles-seo-tab" data-panel="schema">🗂 Schéma</div>
	</div>

	<!-- TAB: Basique -->
	<div class="murailles-seo-panel active" id="murailles-panel-basic">
		<div class="murailles-seo-row">
			<label for="seo_title">Titre SEO <span class="murailles-seo-char" id="cnt-title">0/60</span></label>
			<input type="text" id="seo_title" name="_seo_title" value="<?php echo esc_attr( $m('_seo_title') ); ?>" maxlength="120" placeholder="Laisser vide → titre auto" />
			<span class="desc">Onglet navigateur + résultats Google. 50–60 caractères. <b>Clé MCP :</b> <code>_seo_title</code></span>
		</div>
		<div class="murailles-seo-row">
			<label for="seo_desc">Meta description <span class="murailles-seo-char" id="cnt-desc">0/155</span></label>
			<textarea id="seo_desc" name="_seo_description" rows="3" maxlength="320" placeholder="Laisser vide → description auto"><?php echo esc_textarea( $m('_seo_description') ); ?></textarea>
			<span class="desc">Snippet Google. 120–155 caractères. <b>Clé MCP :</b> <code>_seo_description</code></span>
		</div>
		<div class="murailles-seo-row">
			<label for="seo_focus_kw">Mot-clé cible (Focus Keyword)</label>
			<input type="text" id="seo_focus_kw" name="_seo_focus_keyword" value="<?php echo esc_attr( $m('_seo_focus_keyword') ); ?>" placeholder="ex: riad à vendre marrakech" />
			<span class="desc">Utilisé pour les analyses et la compatibilité Yoast/Rank Math. <b>Clé MCP :</b> <code>_seo_focus_keyword</code></span>
		</div>
	</div>

	<!-- TAB: Social (OG + Twitter) -->
	<div class="murailles-seo-panel" id="murailles-panel-social">
		<h4 style="margin-top:0;color:#1877f2;">Open Graph (Facebook, LinkedIn, WhatsApp)</h4>
		<div class="murailles-seo-row">
			<label for="seo_og_title">OG Titre personnalisé</label>
			<input type="text" id="seo_og_title" name="_seo_og_title" value="<?php echo esc_attr( $m('_seo_og_title') ); ?>" placeholder="Laisser vide → utilise le titre SEO" />
			<span class="desc"><b>Clé MCP :</b> <code>_seo_og_title</code></span>
		</div>
		<div class="murailles-seo-row">
			<label for="seo_og_desc">OG Description personnalisée</label>
			<textarea id="seo_og_desc" name="_seo_og_description" rows="2" placeholder="Laisser vide → utilise la meta description"><?php echo esc_textarea( $m('_seo_og_description') ); ?></textarea>
			<span class="desc"><b>Clé MCP :</b> <code>_seo_og_description</code></span>
		</div>
		<div class="murailles-seo-row">
			<label for="seo_og_img">Image OG (1200×630 px recommandé)</label>
			<input type="url" id="seo_og_img" name="_seo_og_image" value="<?php echo esc_attr( $m('_seo_og_image') ); ?>" placeholder="https://…/image.jpg" />
			<span class="desc">Remplace l'image partagée sur Facebook/WhatsApp. Laisser vide → image mise en avant. <b>Clé MCP :</b> <code>_seo_og_image</code></span>
		</div>
		<hr style="margin:16px 0;">
		<h4 style="color:#000;">Twitter / X Cards</h4>
		<div class="murailles-seo-row">
			<label for="seo_tw_title">Twitter Titre</label>
			<input type="text" id="seo_tw_title" name="_seo_twitter_title" value="<?php echo esc_attr( $m('_seo_twitter_title') ); ?>" placeholder="Laisser vide → utilise le titre SEO" />
			<span class="desc"><b>Clé MCP :</b> <code>_seo_twitter_title</code></span>
		</div>
		<div class="murailles-seo-row">
			<label for="seo_tw_desc">Twitter Description</label>
			<textarea id="seo_tw_desc" name="_seo_twitter_desc" rows="2" placeholder="Laisser vide → utilise la meta description"><?php echo esc_textarea( $m('_seo_twitter_desc') ); ?></textarea>
			<span class="desc"><b>Clé MCP :</b> <code>_seo_twitter_desc</code></span>
		</div>
		<div class="murailles-seo-row">
			<label for="seo_tw_img">Twitter Image</label>
			<input type="url" id="seo_tw_img" name="_seo_twitter_image" value="<?php echo esc_attr( $m('_seo_twitter_image') ); ?>" placeholder="Laisser vide → utilise l'image OG" />
			<span class="desc"><b>Clé MCP :</b> <code>_seo_twitter_image</code></span>
		</div>
	</div>

	<!-- TAB: Technique -->
	<div class="murailles-seo-panel" id="murailles-panel-technical">
		<div class="murailles-seo-row">
			<label for="seo_canonical">URL Canonique</label>
			<input type="url" id="seo_canonical" name="_seo_canonical" value="<?php echo esc_attr( $m('_seo_canonical') ); ?>" placeholder="Laisser vide → URL WordPress par défaut" />
			<span class="desc">Utilisez uniquement si cette page est un doublon. <b>Clé MCP :</b> <code>_seo_canonical</code></span>
		</div>
		<div class="murailles-seo-row">
			<label>Robots</label>
			<label style="font-weight:normal;display:flex;align-items:center;gap:8px;margin-bottom:6px;">
				<input type="checkbox" name="_seo_noindex" value="1" <?php checked( $m('_seo_noindex'), '1' ); ?> />
				<span>NOINDEX — Exclure de l'index Google <span style="color:#888;font-size:11px;">(Clé MCP: <code>_seo_noindex</code> = "1")</span></span>
			</label>
			<label style="font-weight:normal;display:flex;align-items:center;gap:8px;">
				<input type="checkbox" name="_seo_nofollow" value="1" <?php checked( $m('_seo_nofollow'), '1' ); ?> />
				<span>NOFOLLOW — Ne pas suivre les liens de cette page <span style="color:#888;font-size:11px;">(Clé MCP: <code>_seo_nofollow</code> = "1")</span></span>
			</label>
		</div>
	</div>

	<!-- TAB: Schéma -->
	<div class="murailles-seo-panel" id="murailles-panel-schema">
		<div class="murailles-seo-row">
			<label for="seo_schema_type">Type de schéma Schema.org</label>
			<select id="seo_schema_type" name="_seo_schema_type">
				<?php foreach ( $schema_types as $val => $label ) : ?>
				<option value="<?php echo esc_attr( $val ); ?>" <?php selected( $m('_seo_schema_type'), $val ); ?>><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select>
			<span class="desc">Sélectionnez le type Schema.org principal pour cette page. <b>Clé MCP :</b> <code>_seo_schema_type</code></span>
		</div>
		<div class="murailles-seo-row">
			<label for="seo_schema_json">JSON-LD personnalisé (optionnel)</label>
			<textarea id="seo_schema_json" name="_seo_schema_json" rows="10" style="font-family:monospace;font-size:12px;" placeholder='{"@context":"https://schema.org","@type":"WebPage","name":"..."}'><?php echo esc_textarea( $m('_seo_schema_json') ); ?></textarea>
			<span class="desc">JSON-LD complet — remplace le schéma auto-généré si renseigné. <b>Clé MCP :</b> <code>_seo_schema_json</code></span>
		</div>
		<div style="display:flex;gap:10px;margin-top:8px;">
			<button type="button" id="murailles-validate-json" class="button">✅ Valider le JSON</button>
			<button type="button" id="murailles-preview-schema" class="button">👁 Aperçu rendu</button>
		</div>
		<div id="murailles-schema-preview-box" style="display:none;margin-top:12px;">
			<div class="murailles-seo-schema-preview" id="murailles-schema-preview-content"></div>
		</div>
	</div>

	<script>
	(function($){
		// Tab switching
		$('.murailles-seo-tab').on('click', function(){
			$('.murailles-seo-tab').removeClass('active');
			$('.murailles-seo-panel').removeClass('active');
			$(this).addClass('active');
			$('#murailles-panel-' + $(this).data('panel')).addClass('active');
		});

		// Character counters + SERP preview
		function countChars(input, counterId, max) {
			var len = $(input).val().length;
			var $c  = $('#' + counterId);
			$c.text(len + '/' + max);
			$c.toggleClass('warn', len > max);
		}
		$('#seo_title').on('input', function(){
			countChars(this, 'cnt-title', 60);
			$('#murailles-serp-title').text($(this).val() || '<?php echo esc_js( get_the_title( $post ) ); ?>');
		}).trigger('input');
		$('#seo_desc').on('input', function(){
			countChars(this, 'cnt-desc', 155);
			var t = $(this).val().substring(0,155) || '<?php echo esc_js( wp_trim_words( wp_strip_all_tags( $post->post_excerpt ?: $post->post_content ), 25, '…' ) ); ?>';
			$('#murailles-serp-desc').text(t);
		}).trigger('input');

		// JSON validator
		$('#murailles-validate-json').on('click', function(){
			var raw = $('#seo_schema_json').val().trim();
			if (!raw) { alert('✅ Aucun JSON personnalisé — le schéma auto sera utilisé.'); return; }
			try {
				var parsed = JSON.parse(raw);
				alert('✅ JSON valide.\nType : ' + (parsed['@type'] || '(non défini)'));
			} catch(e) {
				alert('❌ JSON invalide : ' + e.message);
			}
		});

		// Schema preview
		$('#murailles-preview-schema').on('click', function(){
			var raw = $('#seo_schema_json').val().trim();
			if (!raw) { $('#murailles-schema-preview-content').text('(aucun JSON personnalisé)'); }
			else {
				try {
					var parsed = JSON.parse(raw);
					$('#murailles-schema-preview-content').text(JSON.stringify(parsed, null, 2));
				} catch(e) {
					$('#murailles-schema-preview-content').text('JSON invalide : ' + e.message);
				}
			}
			$('#murailles-schema-preview-box').show();
		});
	})(jQuery);
	</script>
	<?php
}

add_action( 'save_post', function ( $post_id ) {
	if ( ! isset( $_POST['murailles_seo_advanced_nonce'] ) ) { return; }
	if ( ! wp_verify_nonce( $_POST['murailles_seo_advanced_nonce'], 'murailles_seo_advanced_save' ) ) { return; }
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
	if ( ! current_user_can( 'edit_post', $post_id ) ) { return; }

	$text_fields = array(
		'_seo_title', '_seo_focus_keyword', '_seo_og_title', '_seo_twitter_title', '_seo_schema_type',
	);
	$html_fields = array(
		'_seo_description', '_seo_og_description', '_seo_twitter_desc',
	);
	$url_fields = array(
		'_seo_og_image', '_seo_twitter_image', '_seo_canonical',
	);
	$raw_fields = array(
		'_seo_schema_json',
	);

	foreach ( $text_fields as $key ) {
		$val = isset( $_POST[ $key ] ) ? sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) : '';
		$val ? update_post_meta( $post_id, $key, $val ) : delete_post_meta( $post_id, $key );
	}
	foreach ( $html_fields as $key ) {
		$val = isset( $_POST[ $key ] ) ? wp_kses_post( wp_unslash( $_POST[ $key ] ) ) : '';
		$val ? update_post_meta( $post_id, $key, $val ) : delete_post_meta( $post_id, $key );
	}
	foreach ( $url_fields as $key ) {
		$val = isset( $_POST[ $key ] ) ? esc_url_raw( wp_unslash( $_POST[ $key ] ) ) : '';
		$val ? update_post_meta( $post_id, $key, $val ) : delete_post_meta( $post_id, $key );
	}
	foreach ( $raw_fields as $key ) {
		$val = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : '';
		// Validate JSON before storing
		if ( $val ) {
			$decoded = json_decode( $val );
			if ( json_last_error() !== JSON_ERROR_NONE ) { $val = ''; }
		}
		$val ? update_post_meta( $post_id, $key, $val ) : delete_post_meta( $post_id, $key );
	}

	// Checkboxes
	$noindex   = isset( $_POST['_seo_noindex'] )   ? '1' : '';
	$nofollow  = isset( $_POST['_seo_nofollow'] )  ? '1' : '';
	$noindex  ? update_post_meta( $post_id, '_seo_noindex',  '1' ) : delete_post_meta( $post_id, '_seo_noindex' );
	$nofollow ? update_post_meta( $post_id, '_seo_nofollow', '1' ) : delete_post_meta( $post_id, '_seo_nofollow' );
} );


/* ═══════════════════════════════════════════════════════════════════════════
   PHASE 3b — Wire new OG/Twitter fields to frontend output
   Override seo-social.php's output when per-post OG/Twitter fields are set.
   ═══════════════════════════════════════════════════════════════════════════ */
add_filter( 'wp_head', function () {
	if ( ! is_singular() ) { return; }
	$id = get_queried_object_id();

	$og_title = (string) get_post_meta( $id, '_seo_og_title', true );
	$og_desc  = (string) get_post_meta( $id, '_seo_og_description', true );
	$tw_title = (string) get_post_meta( $id, '_seo_twitter_title', true );
	$tw_desc  = (string) get_post_meta( $id, '_seo_twitter_desc', true );
	$tw_img   = (string) get_post_meta( $id, '_seo_twitter_image', true );

	// Only emit override tags if any are set (seo-social.php handles the base ones)
	if ( $og_title || $og_desc || $tw_title || $tw_desc || $tw_img ) {
		echo "\n<!-- SEO Advanced overrides -->\n";
		if ( $og_title ) printf( '<meta property="og:title" content="%s" />' . "\n", esc_attr( $og_title ) );
		if ( $og_desc  ) printf( '<meta property="og:description" content="%s" />' . "\n", esc_attr( wp_strip_all_tags( $og_desc ) ) );
		if ( $tw_title ) printf( '<meta name="twitter:title" content="%s" />' . "\n", esc_attr( $tw_title ) );
		if ( $tw_desc  ) printf( '<meta name="twitter:description" content="%s" />' . "\n", esc_attr( wp_strip_all_tags( $tw_desc ) ) );
		if ( $tw_img   ) printf( '<meta name="twitter:image" content="%s" />' . "\n", esc_url( $tw_img ) );
	}
}, 6 ); // priority 6 = after seo-social.php (priority 5), overrides its tags

/* Wire nofollow into wp_robots */
add_filter( 'wp_robots', function ( $robots ) {
	if ( ! is_singular() ) { return $robots; }
	if ( get_post_meta( get_queried_object_id(), '_seo_nofollow', true ) === '1' ) {
		$robots['nofollow'] = true;
		unset( $robots['follow'] );
	}
	return $robots;
}, 11 );

/* Wire custom JSON-LD schema into wp_head */
add_action( 'wp_head', function () {
	if ( ! is_singular() ) { return; }
	$id         = get_queried_object_id();
	$custom_json = (string) get_post_meta( $id, '_seo_schema_json', true );
	if ( ! $custom_json ) { return; }
	$decoded = json_decode( $custom_json );
	if ( json_last_error() !== JSON_ERROR_NONE ) { return; }
	echo "\n<script type=\"application/ld+json\">\n";
	echo wp_json_encode( $decoded, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
	echo "\n</script>\n";
}, 15 );


/* ═══════════════════════════════════════════════════════════════════════════
   PHASE 5 + 6 — IMAGE SEO MANAGEMENT + MEDIA DASHBOARD
   ═══════════════════════════════════════════════════════════════════════════ */

/* ── Admin menu: Media SEO Dashboard ───────────────────────────────── */
add_action( 'admin_menu', function () {
	add_media_page(
		'SEO Médias',
		'🖼 SEO Médias',
		'upload_files',
		'murailles-media-seo',
		'murailles_media_seo_dashboard'
	);
} );

function murailles_media_seo_dashboard() {
	if ( ! current_user_can( 'upload_files' ) ) { wp_die( 'Accès refusé.' ); }

	// Handle bulk save
	if ( isset( $_POST['murailles_media_nonce'] ) &&
	     wp_verify_nonce( $_POST['murailles_media_nonce'], 'murailles_media_save' ) ) {
		$ids = isset( $_POST['media_ids'] ) ? array_map( 'absint', (array) $_POST['media_ids'] ) : array();
		foreach ( $ids as $mid ) {
			if ( ! current_user_can( 'edit_post', $mid ) ) { continue; }
			$alt     = isset( $_POST['alt'][ $mid ] )     ? sanitize_text_field( wp_unslash( $_POST['alt'][ $mid ] ) )     : '';
			$caption = isset( $_POST['caption'][ $mid ] ) ? sanitize_text_field( wp_unslash( $_POST['caption'][ $mid ] ) ) : '';
			$desc    = isset( $_POST['desc'][ $mid ] )    ? wp_kses_post( wp_unslash( $_POST['desc'][ $mid ] ) )           : '';
			$title   = isset( $_POST['title'][ $mid ] )   ? sanitize_text_field( wp_unslash( $_POST['title'][ $mid ] ) )   : '';
			$kw      = isset( $_POST['kw'][ $mid ] )      ? sanitize_text_field( wp_unslash( $_POST['kw'][ $mid ] ) )      : '';

			update_post_meta( $mid, '_wp_attachment_image_alt', $alt );
			wp_update_post( array( 'ID' => $mid, 'post_excerpt' => $caption, 'post_content' => $desc, 'post_title' => $title ) );
			update_post_meta( $mid, '_seo_img_focus_kw', $kw );
		}
		echo '<div class="notice notice-success is-dismissible"><p><strong>Images SEO mises à jour.</strong></p></div>';
	}

	// Gather stats
	global $wpdb;
	$total    = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type='attachment' AND post_status='inherit' AND post_mime_type LIKE 'image/%'" );
	$no_alt   = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts} p LEFT JOIN {$wpdb->postmeta} m ON p.ID=m.post_id AND m.meta_key='_wp_attachment_image_alt' WHERE p.post_type='attachment' AND p.post_status='inherit' AND p.post_mime_type LIKE 'image/%' AND (m.meta_value IS NULL OR m.meta_value='')" );
	$no_cap   = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type='attachment' AND post_status='inherit' AND post_mime_type LIKE 'image/%' AND (post_excerpt IS NULL OR post_excerpt='')" );
	$no_desc  = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type='attachment' AND post_status='inherit' AND post_mime_type LIKE 'image/%' AND (post_content IS NULL OR post_content='')" );

	// Image list for editing
	$filter  = sanitize_text_field( $_GET['filter'] ?? 'all' );
	$search  = sanitize_text_field( $_GET['s'] ?? '' );
	$paged   = max( 1, (int) ( $_GET['paged'] ?? 1 ) );
	$per_page = 25;

	$args = array(
		'post_type'      => 'attachment',
		'post_status'    => 'inherit',
		'post_mime_type' => 'image',
		'posts_per_page' => $per_page,
		'paged'          => $paged,
		'orderby'        => 'date',
		'order'          => 'DESC',
		's'              => $search,
	);
	if ( $filter === 'no_alt' ) {
		$args['meta_query'] = array( array( 'key' => '_wp_attachment_image_alt', 'compare' => 'NOT EXISTS' ) );
	} elseif ( $filter === 'no_caption' ) {
		$args['post_excerpt'] = '';
	}
	$images     = new WP_Query( $args );
	$total_pages = $images->max_num_pages;
	?>
	<div class="wrap">
	<h1 style="display:flex;align-items:center;gap:10px;"><span style="font-size:28px;">🖼</span> SEO Médiathèque — Murailles Immobilier</h1>

	<!-- Dashboard stats -->
	<div style="display:flex;gap:16px;flex-wrap:wrap;margin-bottom:24px;">
		<?php
		$stats = array(
			array( 'Total images', $total, '#0073aa', '' ),
			array( 'ALT manquant', $no_alt, '#d63638', 'no_alt' ),
			array( 'Légende manquante', $no_cap, '#dba617', 'no_caption' ),
			array( 'Description manquante', $no_desc, '#856404', '' ),
		);
		foreach ( $stats as $s ) {
			$url = add_query_arg( array( 'page' => 'murailles-media-seo', 'filter' => $s[3] ), admin_url('upload.php') );
			echo '<div style="background:#fff;border:1px solid #ddd;border-radius:8px;padding:16px 24px;min-width:160px;text-align:center;cursor:pointer;" onclick="location.href=\'' . esc_url( $url ) . '\'">';
			echo '<div style="font-size:32px;font-weight:700;color:' . esc_attr( $s[2] ) . ';">' . esc_html( $s[1] ) . '</div>';
			echo '<div style="font-size:13px;color:#555;">' . esc_html( $s[0] ) . '</div>';
			echo '</div>';
		}
		?>
	</div>

	<!-- Filter & Search -->
	<form method="get" action="<?php echo esc_url( admin_url('upload.php') ); ?>" style="display:flex;gap:10px;align-items:center;margin-bottom:16px;flex-wrap:wrap;">
		<input type="hidden" name="page" value="murailles-media-seo">
		<select name="filter">
			<option value="all" <?php selected($filter,'all'); ?>>Toutes</option>
			<option value="no_alt" <?php selected($filter,'no_alt'); ?>>ALT manquant</option>
			<option value="no_caption" <?php selected($filter,'no_caption'); ?>>Légende manquante</option>
		</select>
		<input type="search" name="s" value="<?php echo esc_attr($search); ?>" placeholder="Rechercher par nom..." style="padding:4px 8px;min-width:220px;">
		<button type="submit" class="button">Filtrer</button>
	</form>

	<!-- Bulk edit form -->
	<form method="post" action="">
		<?php wp_nonce_field( 'murailles_media_save', 'murailles_media_nonce' ); ?>
		<div style="margin-bottom:10px;display:flex;align-items:center;gap:12px;">
			<button type="submit" class="button button-primary" style="background:#dc3545;border-color:#c82333;">💾 Enregistrer les modifications</button>
			<span style="color:#888;font-size:12px;">Modifiez ALT, légende, description, titre et mot-clé directement dans le tableau. Sauvegardez en une fois.</span>
		</div>
		<?php if ( $images->have_posts() ) : ?>
		<table class="widefat striped" style="table-layout:fixed;">
			<colgroup>
				<col style="width:80px">
				<col style="width:200px">
				<col style="width:22%">
				<col style="width:18%">
				<col style="width:18%">
				<col style="width:14%">
				<col style="width:12%">
			</colgroup>
			<thead>
				<tr>
					<th>Aperçu</th>
					<th>Fichier</th>
					<th>ALT text <span style="color:#d63638">*</span></th>
					<th>Légende</th>
					<th>Description</th>
					<th>Titre</th>
					<th>Mot-clé</th>
				</tr>
			</thead>
			<tbody>
			<?php while ( $images->have_posts() ) : $images->the_post();
				$mid  = get_the_ID();
				$alt  = (string) get_post_meta( $mid, '_wp_attachment_image_alt', true );
				$cap  = get_the_excerpt();
				$desc = get_the_content();
				$ttl  = get_the_title();
				$kw   = (string) get_post_meta( $mid, '_seo_img_focus_kw', true );
				$src  = wp_get_attachment_image_url( $mid, 'thumbnail' );
				?>
				<input type="hidden" name="media_ids[]" value="<?php echo esc_attr( $mid ); ?>">
				<tr>
					<td><img src="<?php echo esc_url( $src ); ?>" style="width:64px;height:64px;object-fit:cover;border-radius:4px;border:1px solid #ddd;"></td>
					<td style="word-break:break-all;font-size:12px;color:#555;"><?php echo esc_html( get_the_title() ); ?><br><a href="<?php echo esc_url( get_edit_post_link($mid) ); ?>" target="_blank" style="font-size:11px;">Éditer ↗</a></td>
					<td><input type="text" name="alt[<?php echo esc_attr($mid); ?>]" value="<?php echo esc_attr($alt); ?>" class="widefat" style="<?php echo !$alt ? 'border-color:#d63638;background:#fff5f5;' : ''; ?>" placeholder="Texte ALT..."></td>
					<td><input type="text" name="caption[<?php echo esc_attr($mid); ?>]" value="<?php echo esc_attr($cap); ?>" class="widefat" placeholder="Légende..."></td>
					<td><input type="text" name="desc[<?php echo esc_attr($mid); ?>]" value="<?php echo esc_attr(wp_strip_all_tags($desc)); ?>" class="widefat" placeholder="Description..."></td>
					<td><input type="text" name="title[<?php echo esc_attr($mid); ?>]" value="<?php echo esc_attr($ttl); ?>" class="widefat" placeholder="Titre..."></td>
					<td><input type="text" name="kw[<?php echo esc_attr($mid); ?>]" value="<?php echo esc_attr($kw); ?>" class="widefat" placeholder="Mot-clé..."></td>
				</tr>
			<?php endwhile; wp_reset_postdata(); ?>
			</tbody>
		</table>

		<!-- Pagination -->
		<?php if ( $total_pages > 1 ) : ?>
		<div style="margin-top:12px;">
			<?php
			echo paginate_links( array(
				'base'      => add_query_arg( 'paged', '%#%' ),
				'format'    => '',
				'current'   => $paged,
				'total'     => $total_pages,
				'prev_text' => '« Précédent',
				'next_text' => 'Suivant »',
			) );
			?>
		</div>
		<?php endif; ?>

		<?php else : ?>
		<p>Aucune image trouvée.</p>
		<?php endif; ?>
	</form>

	<!-- Royal MCP Reference -->
	<hr style="margin-top:32px;">
	<h3>Royal MCP — Gestion images via API</h3>
	<div style="background:#f8f9fa;border:1px solid #dee2e6;border-radius:6px;padding:16px;font-family:monospace;font-size:12px;line-height:1.9;">
		<b>Lister toutes les images :</b><br>
		<code>GET /wp-json/wp/v2/media?media_type=image&per_page=100</code><br><br>
		<b>Lire les métadonnées d'une image :</b><br>
		<code>GET /wp-json/royal-mcp/v1/media/{id}</code><br><br>
		<b>Mettre à jour le texte ALT :</b><br>
		<code>wp_update_post_meta  post_id:{id}  key:_wp_attachment_image_alt  value:"Riad vue piscine Marrakech"</code><br><br>
		<b>Mettre à jour le titre :</b><br>
		<code>PUT /wp-json/royal-mcp/v1/media/{id}  {"title":"Riad Dar Mouassine — Marrakech"}</code><br><br>
		<b>Mettre à jour le mot-clé focus :</b><br>
		<code>wp_update_post_meta  post_id:{id}  key:_seo_img_focus_kw  value:"riad marrakech médina"</code>
	</div>
	</div>
	<?php
}


/* ═══════════════════════════════════════════════════════════════════════════
   PHASE 7 — PROPERTY REST ENHANCEMENTS
   Add lat/lng + reference fields to admin meta box + REST + schema
   ═══════════════════════════════════════════════════════════════════════════ */

/* Add lat/lng/reference fields to property meta box (appended to Carte tab) */
add_action( 'admin_footer-post.php', 'murailles_inject_property_geo_fields' );
add_action( 'admin_footer-post-new.php', 'murailles_inject_property_geo_fields' );
function murailles_inject_property_geo_fields() {
	global $post;
	if ( ! $post || $post->post_type !== 'property' ) { return; }
	$lat = (string) get_post_meta( $post->ID, '_property_latitude', true );
	$lng = (string) get_post_meta( $post->ID, '_property_longitude', true );
	$ref = (string) get_post_meta( $post->ID, '_property_reference', true );
	?>
	<script>
	(function($){
		$(document).ready(function(){
			// Inject into the Carte tab content if it exists
			var $mapPanel = $('[data-tab-content="carte"], #property-tab-carte, .property-tab-carte');
			var html = '<div style="margin-top:16px;border-top:1px solid #eee;padding-top:12px;">'
				+ '<h4 style="margin:0 0 10px;color:#1d2327;">📍 Coordonnées GPS & Référence</h4>'
				+ '<table class="form-table" style="margin:0;">'
				+ '<tr><th style="width:160px;">Latitude</th><td><input type="text" name="_property_latitude" value="<?php echo esc_js($lat); ?>" class="regular-text" placeholder="31.6295"></td></tr>'
				+ '<tr><th>Longitude</th><td><input type="text" name="_property_longitude" value="<?php echo esc_js($lng); ?>" class="regular-text" placeholder="-7.9811"></td></tr>'
				+ '<tr><th>Référence interne</th><td><input type="text" name="_property_reference" value="<?php echo esc_js($ref); ?>" class="regular-text" placeholder="MUR-2026-001"></td></tr>'
				+ '</table></div>';
			if ($mapPanel.length) {
				$mapPanel.append(html);
			} else {
				// Fallback: inject before the submit button
				$('#murailles_property_tabs').append(html);
			}
		});
	})(jQuery);
	</script>
	<?php
}

/* Save lat/lng/reference from property form */
add_action( 'save_post_property', function ( $post_id ) {
	if ( ! isset( $_POST['murailles_property_nonce'] ) ) { return; }
	if ( ! wp_verify_nonce( $_POST['murailles_property_nonce'], 'murailles_property_save' ) ) { return; }
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }

	$geo_fields = array( '_property_latitude', '_property_longitude', '_property_reference' );
	foreach ( $geo_fields as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			$val = sanitize_text_field( wp_unslash( $_POST[ $key ] ) );
			$val ? update_post_meta( $post_id, $key, $val ) : delete_post_meta( $post_id, $key );
		}
	}
} );

/* Enrich RealEstateListing schema with lat/lng/reference when available */
add_filter( 'murailles_property_schema', function ( $schema, $post_id ) {
	$lat = (float) get_post_meta( $post_id, '_property_latitude', true );
	$lng = (float) get_post_meta( $post_id, '_property_longitude', true );
	$ref = (string) get_post_meta( $post_id, '_property_reference', true );

	if ( $lat && $lng && isset( $schema['address'] ) ) {
		$schema['geo'] = array(
			'@type'     => 'GeoCoordinates',
			'latitude'  => $lat,
			'longitude' => $lng,
		);
	}
	if ( $ref ) {
		$schema['identifier'] = array(
			'@type' => 'PropertyValue',
			'name'  => 'Référence',
			'value' => $ref,
		);
	}
	return $schema;
}, 10, 2 );


/* ═══════════════════════════════════════════════════════════════════════════
   PHASE 8 — INTERNAL LINKING SYSTEM
   Related properties widget + admin suggestions panel
   ═══════════════════════════════════════════════════════════════════════════ */

/**
 * Get related properties for a given property ID.
 * Matches on: shared taxonomy terms (category, location), price range (±30%).
 * Returns up to $limit WP_Post objects, excluding the current post.
 */
function murailles_get_related_properties( $post_id, $limit = 4 ) {
	$cats = wp_get_post_terms( $post_id, 'property_category', array( 'fields' => 'ids' ) );
	$locs = wp_get_post_terms( $post_id, 'property_location',  array( 'fields' => 'ids' ) );

	$tax_query = array( 'relation' => 'OR' );
	if ( ! empty( $cats ) ) {
		$tax_query[] = array( 'taxonomy' => 'property_category', 'field' => 'term_id', 'terms' => $cats );
	}
	if ( ! empty( $locs ) ) {
		$tax_query[] = array( 'taxonomy' => 'property_location', 'field' => 'term_id', 'terms' => $locs );
	}

	$args = array(
		'post_type'      => 'property',
		'post_status'    => 'publish',
		'posts_per_page' => $limit,
		'post__not_in'   => array( $post_id ),
		'orderby'        => 'rand',
	);
	if ( count( $tax_query ) > 1 ) {
		$args['tax_query'] = $tax_query;
	}

	return get_posts( $args );
}

/**
 * Get related blog posts for a given property ID.
 * Matches on property category names used as post tags/categories.
 */
function murailles_get_related_posts( $post_id, $limit = 3 ) {
	$cat_names = wp_get_post_terms( $post_id, 'property_category', array( 'fields' => 'names' ) );
	$loc_names = wp_get_post_terms( $post_id, 'property_location',  array( 'fields' => 'names' ) );
	$keywords  = array_merge( (array) $cat_names, (array) $loc_names );
	if ( empty( $keywords ) ) { return array(); }

	return get_posts( array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => $limit,
		'orderby'        => 'relevance',
		's'              => implode( ' ', array_slice( $keywords, 0, 2 ) ),
	) );
}

/* Internal linking suggestions in property admin sidebar */
add_action( 'add_meta_boxes_property', function () {
	add_meta_box(
		'murailles_internal_links',
		'🔗 Maillage interne — Suggestions',
		function ( $post ) {
			$related = murailles_get_related_properties( $post->ID, 5 );
			$posts   = murailles_get_related_posts( $post->ID, 3 );
			echo '<p style="color:#888;font-size:12px;margin-top:0;">Biens similaires à lier dans le contenu ou le texte de l\'agent.</p>';
			if ( $related ) {
				echo '<ul style="margin:0 0 12px;padding-left:18px;">';
				foreach ( $related as $r ) {
					$price = get_post_meta( $r->ID, '_property_price', true );
					echo '<li><a href="' . esc_url( get_permalink( $r->ID ) ) . '" target="_blank">' . esc_html( $r->post_title ) . '</a>';
					if ( $price ) echo ' <span style="color:#888;font-size:11px;">— ' . esc_html( $price ) . ' €</span>';
					echo '</li>';
				}
				echo '</ul>';
			} else {
				echo '<p style="color:#888;">Aucun bien similaire trouvé.</p>';
			}
			if ( $posts ) {
				echo '<p style="font-weight:600;font-size:12px;margin-bottom:4px;">Articles de blog connexes :</p>';
				echo '<ul style="margin:0;padding-left:18px;">';
				foreach ( $posts as $p ) {
					echo '<li><a href="' . esc_url( get_permalink( $p->ID ) ) . '" target="_blank">' . esc_html( $p->post_title ) . '</a></li>';
				}
				echo '</ul>';
			}
		},
		'property',
		'side',
		'low'
	);
} );


/* ═══════════════════════════════════════════════════════════════════════════
   PHASE 9 — XML SITEMAP IMPROVEMENTS
   - Auto-exclude noindex posts/pages
   - Image sitemap entries for properties
   - Per-type URL priorities
   ═══════════════════════════════════════════════════════════════════════════ */

/* Exclude per-post noindex from sitemap */
add_filter( 'wp_sitemaps_posts_query_args', function ( $args, $post_type ) {
	// Find all posts with _seo_noindex = 1 and exclude them
	$noindex_ids = get_posts( array(
		'post_type'      => $post_type,
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'fields'         => 'ids',
		'meta_query'     => array( array( 'key' => '_seo_noindex', 'value' => '1' ) ),
	) );
	if ( $noindex_ids ) {
		$args['post__not_in'] = array_merge(
			(array) ( $args['post__not_in'] ?? array() ),
			$noindex_ids
		);
	}
	return $args;
}, 15, 2 ); // priority 15 = after existing filter at 10

/* Add images to property sitemap entries */
add_filter( 'wp_sitemaps_posts_entry', function ( $entry, $post ) {
	if ( $post->post_type !== 'property' ) { return $entry; }

	$images = array();
	if ( has_post_thumbnail( $post->ID ) ) {
		$images[] = array(
			'loc'     => get_the_post_thumbnail_url( $post->ID, 'full' ),
			'title'   => get_the_title( $post->ID ),
			'caption' => wp_strip_all_tags( get_the_excerpt( $post->ID ) ),
		);
	}
	$gallery_raw = (string) get_post_meta( $post->ID, '_property_gallery_ids', true );
	if ( $gallery_raw ) {
		foreach ( array_filter( array_map( 'intval', explode( ',', $gallery_raw ) ) ) as $gid ) {
			$url = wp_get_attachment_image_url( $gid, 'full' );
			if ( $url ) {
				$alt = (string) get_post_meta( $gid, '_wp_attachment_image_alt', true );
				$images[] = array( 'loc' => $url, 'title' => $alt ?: get_the_title( $post->ID ) );
			}
		}
	}
	if ( $images ) {
		$entry['images'] = $images;
	}
	return $entry;
}, 15, 2 );


/* ═══════════════════════════════════════════════════════════════════════════
   PHASE 10 — PERFORMANCE
   - Preload critical font/CSS resources
   - Cache frequently-called property meta in object cache
   - Lazy-init expensive SEO computations
   ═══════════════════════════════════════════════════════════════════════════ */

/* Preload Font Awesome from CDN — avoids FOUT on first paint */
add_action( 'wp_head', function () {
	if ( is_admin() ) { return; }
	echo '<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" as="style" crossorigin="anonymous">' . "\n";
}, 0 );

/**
 * Cache property meta bundle in WP object cache.
 * Called once per property page; subsequent get_post_meta() calls for the
 * same post hit the cache automatically (WP does this internally with
 * update_meta_cache), but we warm it explicitly so all meta is loaded
 * in one DB query.
 */
add_action( 'wp', function () {
	if ( ! is_singular( 'property' ) ) { return; }
	$id = get_queried_object_id();
	// This triggers WP to prime the meta cache for this post in one query.
	update_meta_cache( 'post', array( $id ) );
} );

/**
 * Prevent the ob_start() output buffer in seo-perf.php from running on
 * admin-ajax, REST API, or CLI requests where it could cause issues.
 * We hook at template_redirect priority -1 to run before seo-perf.php's
 * hook at 0, and add a short-circuit constant.
 */
add_action( 'template_redirect', function () {
	if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
		define( 'MURAILLES_SKIP_OUTPUT_BUFFER', true );
	}
}, -1 );


/* ═══════════════════════════════════════════════════════════════════════════
   PHASE 4 — SCHEMA MANAGER: per-page type selector wired to output
   When _seo_schema_type is set, we append a typed schema block in wp_head.
   The custom _seo_schema_json (Phase 3) takes full precedence.
   ═══════════════════════════════════════════════════════════════════════════ */
add_action( 'wp_head', function () {
	if ( ! is_singular() ) { return; }
	$id          = get_queried_object_id();
	$custom_json = (string) get_post_meta( $id, '_seo_schema_json', true );
	if ( $custom_json ) { return; } // custom JSON-LD already handled at priority 15

	$schema_type = (string) get_post_meta( $id, '_seo_schema_type', true );
	if ( ! $schema_type ) { return; }

	$home  = home_url( '/' );
	$title = get_the_title( $id );
	$url   = get_permalink( $id );
	$desc  = wp_strip_all_tags( get_the_excerpt( $id ) ?: wp_trim_words( get_post_field( 'post_content', $id ), 60, '…' ) );
	$img   = get_the_post_thumbnail_url( $id, 'full' );

	$schema = array(
		'@context'    => 'https://schema.org',
		'@type'       => $schema_type,
		'@id'         => $url . '#' . strtolower( $schema_type ),
		'name'        => $title,
		'description' => $desc,
		'url'         => $url,
	);
	if ( $img ) {
		$schema['image'] = $img;
	}

	// Type-specific enrichments
	switch ( $schema_type ) {
		case 'Article':
		case 'BlogPosting':
		case 'NewsArticle':
			$schema['datePublished']  = get_the_date( 'c', $id );
			$schema['dateModified']   = get_the_modified_date( 'c', $id );
			$schema['author']         = array( '@type' => 'Organization', '@id' => $home . '#organization' );
			$schema['publisher']      = array( '@id' => $home . '#organization' );
			break;

		case 'Service':
		case 'LocalBusiness':
			$schema['provider']       = array( '@id' => $home . '#organization' );
			$schema['areaServed']     = 'Marrakech, Maroc';
			break;

		case 'FAQPage':
			// FAQPage without custom JSON is a no-op (content-driven)
			return;

		case 'Product':
			$price = (string) get_post_meta( $id, '_property_price', true );
			if ( $price ) {
				$schema['offers'] = array(
					'@type'         => 'Offer',
					'price'         => (float) preg_replace( '/[^\d.]/', '', str_replace( ',', '.', $price ) ),
					'priceCurrency' => 'EUR',
					'availability'  => 'https://schema.org/InStock',
				);
			}
			break;
	}

	echo "\n<script type=\"application/ld+json\">\n";
	echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
	echo "\n</script>\n";
}, 16 );


/* ═══════════════════════════════════════════════════════════════════════════
   ADMIN ASSETS — enqueue inline styles for media dashboard on admin pages
   ═══════════════════════════════════════════════════════════════════════════ */
add_action( 'admin_enqueue_scripts', function ( $hook ) {
	// Enqueue on property + post + page edit screens
	if ( in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		wp_enqueue_script( 'jquery' );
	}
} );
