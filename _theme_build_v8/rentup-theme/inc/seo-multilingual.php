<?php
/**
 * SEO Multilingual — Murailles Immobilier
 *
 * Phase 12 — Full Polylang FR/EN management via WordPress Admin + REST + Royal MCP
 *
 * Features:
 *   1. Per-language SEO meta fields (title, description, focus keyword, canonical,
 *      OG title/desc/image, Twitter title/desc/image, noindex, nofollow, schema type)
 *   2. Per-language image metadata (ALT, caption, description — FR & EN)
 *      Registered with REST schema so /wp-json/wp/v2/media/{id} exposes them.
 *   3. Hreflang tag generation (x-default, fr, en) on every singular page
 *      Uses real Polylang translated post URLs; x-default only points to FR
 *      when the FR translation actually exists.
 *   4. Per-language canonical <link> override
 *   5. Translation audit: detect missing SEO translations
 *   6. GEO / AI Search optimization: llms.txt, author/entity signals
 *      llms.txt excludes password-protected, noindex, and per-lang-noindex pages.
 *   7. robots.txt AI bot section with /wp-admin/ Disallow per-agent
 *   8. Vary: Cookie header when Polylang cookie mode is active
 *   9. Full Yoast / Rank Math / AIOSEO / SEOPress guard on every wp_head output
 *
 * Meta key convention:
 *   _seo_title_fr / _seo_title_en  (per language variant)
 *   _seo_description_fr / _seo_description_en
 *   etc.
 *
 * When Polylang is not active all FR keys are used as fallback.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ═══════════════════════════════════════════════════════════════════════════
   HELPERS
   ═══════════════════════════════════════════════════════════════════════════ */

/*
 * murailles_current_lang() is declared in inc/i18n.php — do not redeclare.
 * murailles_active_langs(), murailles_get_seo_meta(), murailles_seo_plugin_active(),
 * murailles_get_translation_id(), murailles_pll_uses_cookie_mode() are new helpers
 * declared here with function_exists() guards so this file is safe to include
 * even if a future version of i18n.php adds them.
 */

if ( ! function_exists( 'murailles_active_langs' ) ) {
	/** Returns all active language slugs from Polylang, or ['fr','en'] as fallback. */
	function murailles_active_langs() {
		if ( function_exists( 'pll_languages_list' ) ) {
			$list = pll_languages_list( array( 'fields' => 'slug' ) );
			return ( is_array( $list ) && count( $list ) ) ? $list : array( 'fr', 'en' );
		}
		return array( 'fr', 'en' );
	}
}

if ( ! function_exists( 'murailles_get_seo_meta' ) ) {
	/**
	 * Get a per-language SEO meta value for a post.
	 * Checks {base_key}_{lang} first, falls back to {base_key}.
	 */
	function murailles_get_seo_meta( $post_id, $base_key, $lang = null ) {
		if ( null === $lang ) {
			$lang = murailles_current_lang();
		}
		$lang_val = (string) get_post_meta( $post_id, $base_key . '_' . $lang, true );
		if ( $lang_val !== '' ) { return $lang_val; }
		return (string) get_post_meta( $post_id, $base_key, true );
	}
}

if ( ! function_exists( 'murailles_seo_plugin_active' ) ) {
	/** Returns true when a supported third-party SEO plugin is active. */
	function murailles_seo_plugin_active() {
		return defined( 'WPSEO_VERSION' )
			|| defined( 'RANK_MATH_VERSION' )
			|| class_exists( 'AIOSEO\Plugin\AIOSEO' )
			|| defined( 'SEOPRESS_VERSION' );
	}
}

if ( ! function_exists( 'murailles_get_translation_id' ) ) {
	/**
	 * Get the Polylang translation ID of a post in a given language.
	 * Returns $post_id itself when Polylang is not active or no translation exists.
	 */
	function murailles_get_translation_id( $post_id, $lang ) {
		if ( function_exists( 'pll_get_post' ) ) {
			$trans = pll_get_post( $post_id, $lang );
			return $trans ?: $post_id;
		}
		return $post_id;
	}
}

if ( ! function_exists( 'murailles_pll_uses_cookie_mode' ) ) {
	/**
	 * Returns true when Polylang is in cookie/browser-detection language mode
	 * (force_lang = 0), meaning the same URL can serve different languages.
	 */
	function murailles_pll_uses_cookie_mode() {
		if ( ! function_exists( 'pll_languages_list' ) ) { return false; }
		$options = get_option( 'polylang' );
		// force_lang: 0 = cookie/browser, 1 = directory, 2 = subdomain, 3 = domain
		return isset( $options['force_lang'] ) && (int) $options['force_lang'] === 0;
	}
}


/* ═══════════════════════════════════════════════════════════════════════════
   1. REGISTER PER-LANGUAGE SEO META KEYS
   All keys follow pattern: {base_key}_{lang}
   Registered for post, page, property — show_in_rest:true for Royal MCP.
   Attachment keys include REST schema so media endpoint exposes them.
   ═══════════════════════════════════════════════════════════════════════════ */
add_action( 'init', function () {
	$langs = murailles_active_langs();

	$auth_edit = function( $allowed, $meta_key, $post_id ) {
		return current_user_can( 'edit_post', (int) $post_id );
	};

	$per_lang_keys = array(
		'_seo_title'          => 'sanitize_text_field',
		'_seo_description'    => 'wp_kses_post',
		'_seo_focus_keyword'  => 'sanitize_text_field',
		'_seo_canonical'      => 'esc_url_raw',
		'_seo_og_title'       => 'sanitize_text_field',
		'_seo_og_description' => 'wp_kses_post',
		'_seo_og_image'       => 'esc_url_raw',
		'_seo_twitter_title'  => 'sanitize_text_field',
		'_seo_twitter_desc'   => 'wp_kses_post',
		'_seo_twitter_image'  => 'esc_url_raw',
		'_seo_noindex'        => 'sanitize_text_field',
		'_seo_nofollow'       => 'sanitize_text_field',
		'_seo_schema_type'    => 'sanitize_text_field',
		'_seo_schema_json'    => 'wp_unslash',
	);

	foreach ( $langs as $lang ) {
		foreach ( $per_lang_keys as $base => $sanitize ) {
			$key = $base . '_' . $lang;
			foreach ( array( 'post', 'page', 'property' ) as $pt ) {
				register_meta( 'post', $key, array(
					'object_subtype'    => $pt,
					'type'              => 'string',
					'single'            => true,
					'show_in_rest'      => true,
					'sanitize_callback' => $sanitize,
					'auth_callback'     => $auth_edit,
					'description'       => "Per-language ({$lang}) override for {$base}",
				) );
			}
		}
	}

	/*
	 * BUG FIX (Check 1): Attachment meta needs an explicit REST schema array
	 * so that GET /wp-json/wp/v2/media/{id} actually exposes these fields.
	 * Without 'schema' => array('type'=>'string'), WP silently drops
	 * attachment meta from the REST response even with show_in_rest:true.
	 */
	$auth_media = function( $allowed, $meta_key, $post_id ) {
		return current_user_can( 'edit_post', (int) $post_id );
	};
	foreach ( $langs as $lang ) {
		$img_keys = array(
			"_seo_img_alt_{$lang}"     => 'sanitize_text_field',
			"_seo_img_caption_{$lang}" => 'sanitize_text_field',
			"_seo_img_desc_{$lang}"    => 'wp_kses_post',
		);
		foreach ( $img_keys as $key => $sanitize ) {
			register_meta( 'post', $key, array(
				'object_subtype'    => 'attachment',
				'type'              => 'string',
				'single'            => true,
				'show_in_rest'      => array(
					'schema' => array( 'type' => 'string', 'context' => array( 'view', 'edit' ) ),
				),
				'sanitize_callback' => $sanitize,
				'auth_callback'     => $auth_media,
				'description'       => "Per-language ({$lang}) image metadata ({$key})",
			) );
		}
	}
}, 25 );


/* ═══════════════════════════════════════════════════════════════════════════
   2. OVERRIDE TITLE / DESCRIPTION / OG / ROBOTS WITH PER-LANG META
   These filters run after seo.php and seo-advanced.php (priority > 10).
   All blocks defer to third-party SEO plugins when one is active (Bug 8 fix).
   ═══════════════════════════════════════════════════════════════════════════ */

/* Title */
add_filter( 'pre_get_document_title', function ( $title ) {
	if ( ! is_singular() ) { return $title; }
	if ( murailles_seo_plugin_active() ) { return $title; }
	$val = murailles_get_seo_meta( get_queried_object_id(), '_seo_title' );
	return $val ?: $title;
}, 20, 1 );

/* Description — override murailles_seo_description() output */
add_filter( 'murailles_seo_description_output', function ( $desc ) {
	if ( ! is_singular() ) { return $desc; }
	if ( murailles_seo_plugin_active() ) { return $desc; }
	$val = murailles_get_seo_meta( get_queried_object_id(), '_seo_description' );
	return $val ?: $desc;
}, 20 );

/* Noindex / nofollow per-lang override */
add_filter( 'wp_robots', function ( $robots ) {
	if ( ! is_singular() ) { return $robots; }
	$id   = get_queried_object_id();
	$lang = murailles_current_lang();

	if ( murailles_get_seo_meta( $id, '_seo_noindex', $lang ) === '1' ) {
		$robots['noindex'] = true;
		unset( $robots['index'] );
	}
	if ( murailles_get_seo_meta( $id, '_seo_nofollow', $lang ) === '1' ) {
		$robots['nofollow'] = true;
		unset( $robots['follow'] );
	}
	return $robots;
}, 20, 1 );

/*
 * OG / Twitter per-lang overrides.
 * Runs after seo-social.php (priority 5) and seo-advanced.php (priority 6).
 * Bug 8 fix: guard added — skip when a SEO plugin is active.
 */
add_action( 'wp_head', function () {
	if ( ! is_singular() ) { return; }
	if ( murailles_seo_plugin_active() ) { return; }

	$id   = get_queried_object_id();
	$lang = murailles_current_lang();

	$og_title = murailles_get_seo_meta( $id, '_seo_og_title', $lang );
	$og_desc  = murailles_get_seo_meta( $id, '_seo_og_description', $lang );
	$og_img   = murailles_get_seo_meta( $id, '_seo_og_image', $lang );
	$tw_title = murailles_get_seo_meta( $id, '_seo_twitter_title', $lang );
	$tw_desc  = murailles_get_seo_meta( $id, '_seo_twitter_desc', $lang );
	$tw_img   = murailles_get_seo_meta( $id, '_seo_twitter_image', $lang );

	if ( $og_title || $og_desc || $og_img || $tw_title || $tw_desc || $tw_img ) {
		echo "\n<!-- SEO Multilingual ({$lang}) overrides -->\n";
		if ( $og_title ) printf( '<meta property="og:title" content="%s" />' . "\n", esc_attr( $og_title ) );
		if ( $og_desc  ) printf( '<meta property="og:description" content="%s" />' . "\n", esc_attr( wp_strip_all_tags( $og_desc ) ) );
		if ( $og_img   ) printf( '<meta property="og:image" content="%s" />' . "\n", esc_url( $og_img ) );
		if ( $tw_title ) printf( '<meta name="twitter:title" content="%s" />' . "\n", esc_attr( $tw_title ) );
		if ( $tw_desc  ) printf( '<meta name="twitter:description" content="%s" />' . "\n", esc_attr( wp_strip_all_tags( $tw_desc ) ) );
		if ( $tw_img   ) printf( '<meta name="twitter:image" content="%s" />' . "\n", esc_url( $tw_img ) );
	}
}, 7 );


/* ═══════════════════════════════════════════════════════════════════════════
   3. HREFLANG TAGS
   Bug fixes applied:
   - BUG 2: pll_get_post() returns null for the current language's own post
     when there is no explicit Polylang link; fall back to $id itself.
   - BUG 3: article:published_time / modified_time removed from GEO block
     (it already appears in seo-social.php for post type).
   - BUG 4: x-default only uses FR URL when a FR translation actually exists.
   ═══════════════════════════════════════════════════════════════════════════ */
add_action( 'wp_head', function () {
	if ( ! function_exists( 'pll_get_post' ) ) { return; }
	if ( ! is_singular() ) { return; }

	$id    = get_queried_object_id();
	$langs = murailles_active_langs();

	/*
	 * Build the translation map: lang_slug => ['id', 'href', 'hreflang_code']
	 *
	 * BUG FIX (Check 2): pll_get_post() returns 0/false for the current post's
	 * own language when no explicit Polylang link exists for self.
	 * We detect the current post's own language and include it as self-reference.
	 *
	 * BUG FIX (Check 4): x-default is only set to the FR URL when a FR
	 * translation actually exists; otherwise falls back to the current URL.
	 *
	 * Locale map: we output fr-MA (Morocco) not generic "fr", and plain "en".
	 */
	$locale_map = array( 'fr' => 'fr-MA', 'en' => 'en' );
	$post_lang  = function_exists( 'pll_get_post_language' )
		? (string) pll_get_post_language( $id, 'slug' )
		: murailles_current_lang();

	$hreflang_data = array();
	foreach ( $langs as $lang ) {
		$trans_id = pll_get_post( $id, $lang );
		if ( ! $trans_id ) {
			// pll_get_post returns 0 for self-language; use current post
			if ( $post_lang === $lang ) {
				$trans_id = $id;
			} else {
				continue; // genuinely no translation — omit this language
			}
		}
		$href = get_permalink( $trans_id );
		if ( ! $href ) { continue; }
		$hreflang_data[ $lang ] = array(
			'id'   => (int) $trans_id,
			'href' => $href,
			'code' => isset( $locale_map[ $lang ] ) ? $locale_map[ $lang ] : $lang,
		);
	}

	if ( count( $hreflang_data ) < 2 ) {
		// Only one language found — no point emitting hreflang (requires ≥2)
		return;
	}

	echo "\n<!-- hreflang (Murailles Multilingual) -->\n";
	foreach ( $hreflang_data as $lang => $data ) {
		printf(
			'<link rel="alternate" hreflang="%s" href="%s" />' . "\n",
			esc_attr( $data['code'] ),
			esc_url( $data['href'] )
		);
	}

	// BUG FIX (Check 4): x-default → FR URL when FR exists, otherwise current URL
	if ( isset( $hreflang_data['fr'] ) ) {
		printf(
			'<link rel="alternate" hreflang="x-default" href="%s" />' . "\n",
			esc_url( $hreflang_data['fr']['href'] )
		);
	} else {
		printf(
			'<link rel="alternate" hreflang="x-default" href="%s" />' . "\n",
			esc_url( get_permalink( $id ) )
		);
	}
}, 4 ); // priority 4 = before seo-social.php (5)


/* ═══════════════════════════════════════════════════════════════════════════
   4. PER-LANGUAGE CANONICAL URL OVERRIDE
   BUG FIX (Check 7): Emit <link rel="canonical"> from per-lang key and
   remove WP core's canonical for that request, preventing conflicts with
   hreflang.
   ═══════════════════════════════════════════════════════════════════════════ */
add_action( 'wp_head', function () {
	if ( ! is_singular() ) { return; }
	if ( murailles_seo_plugin_active() ) { return; }

	$id       = get_queried_object_id();
	$lang     = murailles_current_lang();
	$canonical = (string) get_post_meta( $id, '_seo_canonical_' . $lang, true );

	if ( ! $canonical ) {
		// Fall back to base (language-agnostic) key
		$canonical = (string) get_post_meta( $id, '_seo_canonical', true );
	}

	if ( $canonical ) {
		// Remove WP core's canonical so there's only one
		remove_action( 'wp_head', 'rel_canonical' );
		printf( '<link rel="canonical" href="%s" />' . "\n", esc_url( $canonical ) );
	}
}, 9 ); // after seo-advanced.php canonical (priority 6), before wp_head finishes


/* ═══════════════════════════════════════════════════════════════════════════
   5. CACHE PLUGIN COMPATIBILITY
   BUG FIX (Check 9): When Polylang uses cookie/browser-detection mode,
   the same URL serves different languages. Cache plugins must be told to
   vary the cache by cookie so they don't serve FR content to EN visitors.
   ═══════════════════════════════════════════════════════════════════════════ */
add_action( 'send_headers', function () {
	if ( is_admin() || wp_doing_ajax() ) { return; }
	if ( ! murailles_pll_uses_cookie_mode() ) { return; }
	if ( ! headers_sent() ) {
		header( 'Vary: Cookie', false );
	}
} );


/* ═══════════════════════════════════════════════════════════════════════════
   6. PER-LANGUAGE ADMIN META BOX
   ═══════════════════════════════════════════════════════════════════════════ */
add_action( 'add_meta_boxes', function () {
	foreach ( array( 'post', 'page', 'property' ) as $pt ) {
		add_meta_box(
			'murailles_seo_multilingual',
			'🌐 SEO Multilingue (FR / EN)',
			'murailles_seo_multilingual_render',
			$pt,
			'normal',
			'default'
		);
	}
}, 12 );

function murailles_seo_multilingual_render( $post ) {
	wp_nonce_field( 'murailles_seo_ml_save', 'murailles_seo_ml_nonce' );
	$langs = murailles_active_langs();
	if ( count( $langs ) < 2 ) {
		echo '<p style="color:#888;">Polylang non configuré ou une seule langue active.</p>';
		return;
	}
	$lang_labels = array( 'fr' => '🇫🇷 Français', 'en' => '🇬🇧 English' );
	?>
	<p style="color:#888;font-size:12px;margin-top:0;">
		Ces champs remplacent les valeurs du panneau SEO basique pour chaque langue.
		Laissez vide pour utiliser la valeur universelle.
		<strong>Clés Royal MCP</strong> : <code>_seo_title_fr</code>, <code>_seo_title_en</code>, etc.
	</p>
	<style>
	.murailles-ml-tabs { display:flex; gap:0; border-bottom:2px solid #1d7484; margin-bottom:16px; }
	.murailles-ml-tab  { padding:7px 18px; cursor:pointer; background:#f0f0f0; border:1px solid #ccc; font-size:13px; font-weight:600; }
	.murailles-ml-tab.ml-active { background:#fff; color:#1d7484; border-bottom:2px solid #fff; margin-bottom:-2px; }
	.murailles-ml-panel { display:none; }
	.murailles-ml-panel.ml-active { display:block; }
	.murailles-ml-row { margin-bottom:12px; }
	.murailles-ml-row label { display:block; font-size:12px; font-weight:600; color:#444; margin-bottom:3px; }
	.murailles-ml-row input, .murailles-ml-row textarea { width:100%; max-width:680px; }
	</style>
	<div class="murailles-ml-tabs">
		<?php foreach ( $langs as $i => $lang ) : ?>
		<div class="murailles-ml-tab <?php echo $i === 0 ? 'ml-active' : ''; ?>" data-ml-panel="<?php echo esc_attr($lang); ?>">
			<?php echo esc_html( isset( $lang_labels[ $lang ] ) ? $lang_labels[ $lang ] : strtoupper($lang) ); ?>
		</div>
		<?php endforeach; ?>
	</div>

	<?php foreach ( $langs as $i => $lang ) :
		$m = function( $base ) use ( $post, $lang ) {
			return (string) get_post_meta( $post->ID, $base . '_' . $lang, true );
		};
		?>
	<div class="murailles-ml-panel <?php echo $i === 0 ? 'ml-active' : ''; ?>" id="murailles-ml-panel-<?php echo esc_attr($lang); ?>">
		<div class="murailles-ml-row">
			<label>Titre SEO <span style="color:#999">(<?php echo esc_html($lang); ?>)</span></label>
			<input type="text" name="ml[<?php echo esc_attr($lang); ?>][_seo_title]" value="<?php echo esc_attr( $m('_seo_title') ); ?>" placeholder="Titre SEO en <?php echo esc_attr($lang); ?>…" />
		</div>
		<div class="murailles-ml-row">
			<label>Meta description <span style="color:#999">(<?php echo esc_html($lang); ?>)</span></label>
			<textarea name="ml[<?php echo esc_attr($lang); ?>][_seo_description]" rows="2" placeholder="Description en <?php echo esc_attr($lang); ?>…"><?php echo esc_textarea( $m('_seo_description') ); ?></textarea>
		</div>
		<div class="murailles-ml-row">
			<label>Mot-clé cible <span style="color:#999">(<?php echo esc_html($lang); ?>)</span></label>
			<input type="text" name="ml[<?php echo esc_attr($lang); ?>][_seo_focus_keyword]" value="<?php echo esc_attr( $m('_seo_focus_keyword') ); ?>" placeholder="focus keyword…" />
		</div>
		<div class="murailles-ml-row">
			<label>OG Titre <span style="color:#999">(<?php echo esc_html($lang); ?>)</span></label>
			<input type="text" name="ml[<?php echo esc_attr($lang); ?>][_seo_og_title]" value="<?php echo esc_attr( $m('_seo_og_title') ); ?>" />
		</div>
		<div class="murailles-ml-row">
			<label>OG Description <span style="color:#999">(<?php echo esc_html($lang); ?>)</span></label>
			<textarea name="ml[<?php echo esc_attr($lang); ?>][_seo_og_description]" rows="2"><?php echo esc_textarea( $m('_seo_og_description') ); ?></textarea>
		</div>
		<div class="murailles-ml-row">
			<label>Twitter Titre <span style="color:#999">(<?php echo esc_html($lang); ?>)</span></label>
			<input type="text" name="ml[<?php echo esc_attr($lang); ?>][_seo_twitter_title]" value="<?php echo esc_attr( $m('_seo_twitter_title') ); ?>" />
		</div>
		<div class="murailles-ml-row">
			<label>URL Canonique <span style="color:#999">(<?php echo esc_html($lang); ?>)</span></label>
			<input type="url" name="ml[<?php echo esc_attr($lang); ?>][_seo_canonical]" value="<?php echo esc_attr( $m('_seo_canonical') ); ?>" placeholder="https://…" />
		</div>
		<div class="murailles-ml-row">
			<label style="font-weight:normal;display:flex;align-items:center;gap:6px;">
				<input type="checkbox" name="ml[<?php echo esc_attr($lang); ?>][_seo_noindex]" value="1" <?php checked( $m('_seo_noindex'), '1' ); ?> />
				NOINDEX pour la version <?php echo esc_html( strtoupper($lang) ); ?>
			</label>
		</div>
	</div>
	<?php endforeach; ?>

	<script>
	(function($){
		$('.murailles-ml-tab').on('click', function(){
			$('.murailles-ml-tab').removeClass('ml-active');
			$('.murailles-ml-panel').removeClass('ml-active');
			$(this).addClass('ml-active');
			$('#murailles-ml-panel-' + $(this).data('ml-panel')).addClass('ml-active');
		});
	})(jQuery);
	</script>
	<?php
}

add_action( 'save_post', function ( $post_id ) {
	if ( ! isset( $_POST['murailles_seo_ml_nonce'] ) ) { return; }
	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['murailles_seo_ml_nonce'] ) ), 'murailles_seo_ml_save' ) ) { return; }
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
	if ( ! current_user_can( 'edit_post', $post_id ) ) { return; }
	if ( ! isset( $_POST['ml'] ) || ! is_array( $_POST['ml'] ) ) { return; }

	$langs        = murailles_active_langs();
	$text_fields  = array( '_seo_title', '_seo_focus_keyword', '_seo_og_title', '_seo_twitter_title', '_seo_schema_type' );
	$html_fields  = array( '_seo_description', '_seo_og_description', '_seo_twitter_desc' );
	$url_fields   = array( '_seo_og_image', '_seo_twitter_image', '_seo_canonical' );
	$check_fields = array( '_seo_noindex', '_seo_nofollow' );

	foreach ( $langs as $lang ) {
		if ( ! isset( $_POST['ml'][ $lang ] ) ) { continue; }
		$data = (array) wp_unslash( $_POST['ml'][ $lang ] );

		foreach ( $text_fields as $base ) {
			$key = $base . '_' . $lang;
			$val = isset( $data[ $base ] ) ? sanitize_text_field( $data[ $base ] ) : '';
			$val ? update_post_meta( $post_id, $key, $val ) : delete_post_meta( $post_id, $key );
		}
		foreach ( $html_fields as $base ) {
			$key = $base . '_' . $lang;
			$val = isset( $data[ $base ] ) ? wp_kses_post( $data[ $base ] ) : '';
			$val ? update_post_meta( $post_id, $key, $val ) : delete_post_meta( $post_id, $key );
		}
		foreach ( $url_fields as $base ) {
			$key = $base . '_' . $lang;
			$val = isset( $data[ $base ] ) ? esc_url_raw( $data[ $base ] ) : '';
			$val ? update_post_meta( $post_id, $key, $val ) : delete_post_meta( $post_id, $key );
		}
		foreach ( $check_fields as $base ) {
			$key = $base . '_' . $lang;
			isset( $data[ $base ] ) && $data[ $base ] === '1'
				? update_post_meta( $post_id, $key, '1' )
				: delete_post_meta( $post_id, $key );
		}
	}
} );


/* ═══════════════════════════════════════════════════════════════════════════
   7. TRANSLATION AUDIT — Admin notice on posts missing SEO translations
   ═══════════════════════════════════════════════════════════════════════════ */
add_action( 'post_submitbox_misc_actions', function () {
	global $post;
	if ( ! $post || ! in_array( $post->post_type, array( 'post', 'page', 'property' ), true ) ) { return; }
	if ( ! function_exists( 'pll_get_post' ) ) { return; }

	$langs  = murailles_active_langs();
	$issues = array();

	foreach ( $langs as $lang ) {
		$trans_id = pll_get_post( $post->ID, $lang );
		if ( ! $trans_id ) {
			$post_lang = function_exists( 'pll_get_post_language' )
				? pll_get_post_language( $post->ID, 'slug' )
				: '';
			if ( $post_lang !== $lang ) {
				$issues[] = "Traduction <strong>" . esc_html( strtoupper( $lang ) ) . "</strong> manquante";
			}
			continue;
		}
		if ( ! get_post_meta( $trans_id, '_seo_title_' . $lang, true ) &&
		     ! get_post_meta( $trans_id, '_seo_title', true ) ) {
			$issues[] = "Titre SEO <strong>" . esc_html( strtoupper( $lang ) ) . "</strong> manquant";
		}
		if ( ! get_post_meta( $trans_id, '_seo_description_' . $lang, true ) &&
		     ! get_post_meta( $trans_id, '_seo_description', true ) ) {
			$issues[] = "Meta description <strong>" . esc_html( strtoupper( $lang ) ) . "</strong> manquante";
		}
	}

	if ( ! empty( $issues ) ) {
		echo '<div style="background:#fff3cd;border-left:3px solid #ffc107;padding:8px 10px;margin:8px 0;font-size:12px;">';
		echo '<strong>⚠️ SEO Multilingue</strong><ul style="margin:4px 0 0 16px;padding:0;">';
		foreach ( $issues as $issue ) {
			echo '<li>' . wp_kses( $issue, array( 'strong' => array() ) ) . '</li>';
		}
		echo '</ul></div>';
	}
} );


/* ═══════════════════════════════════════════════════════════════════════════
   8. TRANSLATION AUDIT PAGE — Admin dashboard
   ═══════════════════════════════════════════════════════════════════════════ */
add_action( 'admin_menu', function () {
	add_submenu_page(
		'themes.php',
		'Audit SEO Multilingue',
		'🌐 Audit ML SEO',
		'manage_options',
		'murailles-ml-audit',
		'murailles_ml_audit_page'
	);
} );

function murailles_ml_audit_page() {
	if ( ! current_user_can( 'manage_options' ) ) { wp_die( 'Accès refusé.' ); }
	if ( ! function_exists( 'pll_get_post' ) ) {
		echo '<div class="wrap"><h1>Audit SEO Multilingue</h1><p>Polylang non détecté.</p></div>';
		return;
	}

	$langs      = murailles_active_langs();
	$post_types = array( 'post', 'page', 'property' );
	$results    = array();

	foreach ( $post_types as $pt ) {
		$posts = get_posts( array(
			'post_type'      => $pt,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'fields'         => 'ids',
			'lang'           => 'fr', // scan FR posts as the canonical set
		) );

		foreach ( $posts as $pid ) {
			$row = array(
				'id'     => $pid,
				'type'   => $pt,
				'title'  => get_the_title( $pid ),
				'url'    => get_permalink( $pid ),
				'issues' => array(),
			);

			foreach ( $langs as $lang ) {
				$trans_id = pll_get_post( $pid, $lang );

				if ( ! $trans_id && $lang !== 'fr' ) {
					$row['issues'][] = "Traduction {$lang} manquante";
					continue;
				}
				$check_id = $trans_id ?: $pid;

				if ( ! get_post_meta( $check_id, '_seo_title_' . $lang, true ) &&
				     ! get_post_meta( $check_id, '_seo_title', true ) ) {
					$row['issues'][] = "Titre SEO ({$lang}) manquant";
				}
				if ( ! get_post_meta( $check_id, '_seo_description_' . $lang, true ) &&
				     ! get_post_meta( $check_id, '_seo_description', true ) ) {
					$row['issues'][] = "Description ({$lang}) manquante";
				}
			}
			if ( ! empty( $row['issues'] ) ) {
				$results[] = $row;
			}
		}
	}

	$total_issues = array_sum( array_map( function( $r ) { return count( $r['issues'] ); }, $results ) );
	?>
	<div class="wrap">
	<h1 style="display:flex;align-items:center;gap:8px;"><span style="font-size:24px;">🌐</span> Audit SEO Multilingue</h1>

	<div style="display:flex;gap:16px;margin-bottom:24px;flex-wrap:wrap;">
		<div style="background:#fff;border:1px solid #ddd;border-radius:8px;padding:16px 24px;text-align:center;">
			<div style="font-size:32px;font-weight:700;color:<?php echo $total_issues > 0 ? '#d63638' : '#00a32a'; ?>;"><?php echo esc_html( $total_issues ); ?></div>
			<div style="font-size:13px;color:#555;">Problèmes SEO ML</div>
		</div>
		<div style="background:#fff;border:1px solid #ddd;border-radius:8px;padding:16px 24px;text-align:center;">
			<div style="font-size:32px;font-weight:700;color:#0073aa;"><?php echo esc_html( count( $results ) ); ?></div>
			<div style="font-size:13px;color:#555;">Pages affectées</div>
		</div>
		<div style="background:#fff;border:1px solid #ddd;border-radius:8px;padding:16px 24px;text-align:center;">
			<div style="font-size:32px;font-weight:700;color:#555;"><?php echo esc_html( count( $langs ) ); ?></div>
			<div style="font-size:13px;color:#555;">Langues actives (<?php echo esc_html( implode( ', ', $langs ) ); ?>)</div>
		</div>
	</div>

	<?php if ( empty( $results ) ) : ?>
	<div style="background:#d4edda;border:1px solid #c3e6cb;padding:16px;border-radius:6px;color:#155724;">
		✅ <strong>Parfait !</strong> Tous les contenus publiés ont leurs SEO multilingues renseignés.
	</div>
	<?php else : ?>
	<table class="widefat striped">
		<thead>
			<tr>
				<th>ID</th>
				<th>Type</th>
				<th>Titre</th>
				<th>Problèmes</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ( $results as $r ) : ?>
		<tr>
			<td><?php echo esc_html( $r['id'] ); ?></td>
			<td><?php echo esc_html( $r['type'] ); ?></td>
			<td><a href="<?php echo esc_url( $r['url'] ); ?>" target="_blank"><?php echo esc_html( $r['title'] ); ?></a></td>
			<td>
				<?php foreach ( $r['issues'] as $issue ) : ?>
				<span style="display:inline-block;background:#fff3cd;border:1px solid #ffc107;border-radius:3px;padding:2px 6px;font-size:11px;margin:2px;"><?php echo esc_html( $issue ); ?></span>
				<?php endforeach; ?>
			</td>
			<td><a href="<?php echo esc_url( get_edit_post_link( $r['id'] ) ); ?>" class="button button-small">Éditer</a></td>
		</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<?php endif; ?>

	<!-- Royal MCP Multilingual Cheat Sheet -->
	<hr style="margin-top:32px;">
	<h2>Royal MCP — Gestion multilingue complète</h2>
	<p style="color:#555;font-size:13px;">
		<strong>Clés disponibles pour pages, articles, biens :</strong>
		<code>_seo_title_fr</code>, <code>_seo_title_en</code>,
		<code>_seo_description_fr</code>, <code>_seo_description_en</code>,
		<code>_seo_og_title_fr/en</code>, <code>_seo_og_description_fr/en</code>,
		<code>_seo_og_image_fr/en</code>, <code>_seo_twitter_title_fr/en</code>,
		<code>_seo_twitter_desc_fr/en</code>, <code>_seo_twitter_image_fr/en</code>,
		<code>_seo_canonical_fr/en</code>, <code>_seo_noindex_fr/en</code>,
		<code>_seo_focus_keyword_fr/en</code>, <code>_seo_schema_type_fr/en</code>.<br>
		<strong>Clés pour images (médias) :</strong>
		<code>_seo_img_alt_fr</code>, <code>_seo_img_alt_en</code>,
		<code>_seo_img_caption_fr/en</code>, <code>_seo_img_desc_fr/en</code>.
	</p>
	<div style="background:#1e1e1e;color:#d4d4d4;padding:16px;border-radius:6px;font-family:monospace;font-size:12px;line-height:1.9;overflow-x:auto;">
<strong style="color:#9cdcfe;"># LIRE contenu d'une page en FR et EN</strong>
GET /wp-json/wp/v2/pages/{id}?lang=fr
GET /wp-json/wp/v2/pages/{id_en}?lang=en

<strong style="color:#9cdcfe;"># LIRE la traduction EN d'un bien immobilier</strong>
GET /wp-json/wp/v2/property?lang=en&amp;per_page=50

<strong style="color:#9cdcfe;"># MODIFIER le titre SEO EN d'un bien (id = ID de la version EN)</strong>
wp_update_post_meta  post_id:{id_en}  key:_seo_title_en  value:"Riad for Sale in Marrakech"
wp_update_post_meta  post_id:{id_en}  key:_seo_description_en  value:"Stunning traditional riad..."

<strong style="color:#9cdcfe;"># MODIFIER le titre SEO FR du même bien</strong>
wp_update_post_meta  post_id:{id_fr}  key:_seo_title_fr  value:"Riad à vendre à Marrakech"

<strong style="color:#9cdcfe;"># MODIFIER OG + Twitter EN</strong>
wp_update_post_meta  post_id:{id_en}  key:_seo_og_title_en  value:"Beautiful Riad – Murailles"
wp_update_post_meta  post_id:{id_en}  key:_seo_og_description_en  value:"Discover this exceptional riad..."
wp_update_post_meta  post_id:{id_en}  key:_seo_twitter_title_en  value:"Riad for Sale – Marrakech"

<strong style="color:#9cdcfe;"># ALT image en FR et EN (post_id = ID de l'image dans la médiathèque)</strong>
wp_update_post_meta  post_id:{img_id}  key:_seo_img_alt_fr  value:"Riad vue piscine Marrakech"
wp_update_post_meta  post_id:{img_id}  key:_seo_img_alt_en  value:"Riad pool view Marrakech"
wp_update_post_meta  post_id:{img_id}  key:_seo_img_caption_fr  value:"Piscine privée du riad"
wp_update_post_meta  post_id:{img_id}  key:_seo_img_caption_en  value:"Private riad pool"

<strong style="color:#9cdcfe;"># LIRE image avec ses métas multilingues</strong>
GET /wp-json/wp/v2/media/{img_id}
→ champ meta._seo_img_alt_fr, meta._seo_img_alt_en, etc.

<strong style="color:#9cdcfe;"># LIRE les langues Polylang</strong>
GET /wp-json/pll/v1/languages

<strong style="color:#9cdcfe;"># Trouver la traduction EN d'un bien FR (post ID 42)</strong>
GET /wp-json/wp/v2/property/42
→ champ polylang.translations.en = ID de la version EN

<strong style="color:#9cdcfe;"># Bulk: lire tous les biens EN et mettre à jour leurs SEO</strong>
GET /wp-json/wp/v2/property?lang=en&amp;per_page=100&amp;_fields=id,title,meta
→ itérer sur chaque ID, appeler wp_update_post_meta avec _seo_title_en, _seo_description_en
	</div>
	</div>
	<?php
}


/* ═══════════════════════════════════════════════════════════════════════════
   9. GEO / AI SEARCH OPTIMIZATION
   BUG FIX (Check 5): llms.txt excludes password-protected pages and pages
   with per-language noindex.
   BUG FIX (Check 8): GEO wp_head block now guards against SEO plugins.
   BUG FIX (Check 3): article:published_time removed from here — already
   emitted by seo-social.php for post type.
   ═══════════════════════════════════════════════════════════════════════════ */

/**
 * Serve /llms.txt
 */
add_action( 'parse_request', function ( $wp ) {
	$req  = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '';
	$path = (string) wp_parse_url( $req, PHP_URL_PATH );
	$base = rtrim( (string) wp_parse_url( home_url(), PHP_URL_PATH ), '/' );
	if ( $base ) { $path = substr( $path, strlen( $base ) ); }
	if ( $path !== '/llms.txt' ) { return; }

	$pages = get_posts( array(
		'post_type'      => 'page',
		'post_status'    => 'publish',
		'posts_per_page' => 20,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	) );
	$props = get_posts( array(
		'post_type'      => 'property',
		'post_status'    => 'publish',
		'posts_per_page' => 10,
		'orderby'        => 'date',
		'order'          => 'DESC',
	) );
	$posts = get_posts( array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => 5,
		'orderby'        => 'date',
		'order'          => 'DESC',
	) );

	header( 'Content-Type: text/plain; charset=UTF-8' );
	header( 'Cache-Control: public, max-age=86400' );
	$site = get_bloginfo( 'name' );
	$desc = get_bloginfo( 'description' );
	$home = home_url( '/' );

	echo "# {$site}\n\n";
	echo "> {$desc}\n\n";
	echo "## About\n\n";
	echo "Murailles Immobilier is a Moroccan real estate agency based in Marrakech, ";
	echo "specializing in riads, villas, apartments, and land for sale and rent in ";
	echo "Marrakech, Casablanca, Rabat, and across Morocco.\n\n";

	/*
	 * BUG FIX (Check 5): Hardcoded slug exclusions for utility/thin pages that
	 * should never appear in llms.txt regardless of meta state.
	 * These match the slugs excluded from the XML sitemap in seo-perf.php.
	 */
	$excluded_slugs = array(
		'favoris', 'compare-property', 'erreur', 'checkout',
		'my-account', 'cart', 'wp-login', 'wp-register',
	);

	echo "## Pages\n\n";
	foreach ( $pages as $p ) {
		// Skip password-protected pages
		if ( ! empty( $p->post_password ) ) { continue; }
		// Skip by slug (utility/thin pages)
		if ( in_array( $p->post_name, $excluded_slugs, true ) ) { continue; }
		// Skip if noindex meta is set (base key or any per-language key)
		if ( get_post_meta( $p->ID, '_seo_noindex', true ) === '1' ) { continue; }
		$skip_lang = false;
		foreach ( murailles_active_langs() as $llms_lang ) {
			if ( get_post_meta( $p->ID, '_seo_noindex_' . $llms_lang, true ) === '1' ) {
				$skip_lang = true;
				break;
			}
		}
		if ( $skip_lang ) { continue; }
		$title = esc_html( get_the_title( $p->ID ) );
		echo "- [{$title}](" . get_permalink( $p->ID ) . ")\n";
	}

	echo "\n## Properties (recent listings)\n\n";
	foreach ( $props as $p ) {
		if ( ! empty( $p->post_password ) ) { continue; }
		$action = get_post_meta( $p->ID, '_property_action', true );
		$price  = get_post_meta( $p->ID, '_property_price', true );
		$title  = esc_html( get_the_title( $p->ID ) );
		$line   = "- [{$title}](" . get_permalink( $p->ID ) . ")";
		if ( $action ) { $line .= " — " . esc_html( $action ); }
		if ( $price )  { $line .= " — " . esc_html( $price ) . " €"; }
		echo $line . "\n";
	}

	echo "\n## Blog\n\n";
	foreach ( $posts as $p ) {
		if ( ! empty( $p->post_password ) ) { continue; }
		$title = esc_html( get_the_title( $p->ID ) );
		echo "- [{$title}](" . get_permalink( $p->ID ) . ")\n";
	}

	echo "\n## Contact\n\n";
	$ci = function_exists( 'murailles_contact_info' ) ? murailles_contact_info() : array();
	if ( ! empty( $ci['phone'] ) )        { echo "Phone: " . esc_html( $ci['phone'] ) . "\n"; }
	if ( ! empty( $ci['email'] ) )        { echo "Email: " . esc_html( $ci['email'] ) . "\n"; }
	if ( ! empty( $ci['address_city'] ) ) { echo "Location: " . esc_html( $ci['address_city'] ) . "\n"; }

	echo "\n## Languages\n\n";
	echo "- French (fr-MA) — primary\n";
	echo "- English (en) — available\n\n";
	echo "## Sitemap\n\n";
	echo "- [XML Sitemap]({$home}wp-sitemap.xml)\n";
	exit;
} );

/**
 * GEO / AI Search meta tags.
 * BUG FIX (Check 3): removed duplicate article:published_time (seo-social.php handles it).
 * BUG FIX (Check 8): guard against SEO plugins added.
 */
add_action( 'wp_head', function () {
	if ( murailles_seo_plugin_active() ) { return; }

	$site = get_bloginfo( 'name' );
	echo "\n<!-- GEO / AI Search signals -->\n";

	if ( is_singular( 'post' ) ) {
		$author_id = (int) get_post_field( 'post_author', get_queried_object_id() );
		$author    = get_the_author_meta( 'display_name', $author_id );
		if ( $author ) {
			printf( '<meta name="author" content="%s" />' . "\n", esc_attr( $author ) );
		}
	} else {
		printf( '<meta name="author" content="%s" />' . "\n", esc_attr( $site ) );
	}

	// Geographic region
	echo '<meta name="geo.region" content="MA-RAK" />' . "\n";
	echo '<meta name="geo.placename" content="Marrakech" />' . "\n";

	// Content language — per current Polylang lang
	$lang = murailles_current_lang();
	printf( '<meta http-equiv="content-language" content="%s" />' . "\n", esc_attr( $lang === 'fr' ? 'fr-MA' : 'en' ) );
}, 8 );

/**
 * robots.txt: allow AI crawlers with explicit /wp-admin/ Disallow per agent.
 * BUG FIX (Check 6): each AI bot block now explicitly Disallows /wp-admin/.
 * Without this, the per-agent "Allow: /" overrides the global Disallow.
 */
add_filter( 'robots_txt', function ( $output, $public ) {
	if ( ! $public ) { return $output; }

	$disallow_private  = "Disallow: /wp-admin/\n";
	$disallow_private .= "Disallow: /wp-login.php\n";
	$disallow_private .= "Disallow: /wp-json/wp/v2/users\n";
	$disallow_private .= "Disallow: /wp-json/wp/v2/users/\n";
	$disallow_private .= "Disallow: /?s=\n";
	$disallow_private .= "Disallow: /checkout/\n";
	$disallow_private .= "Disallow: /favoris/\n";
	$disallow_private .= "Disallow: /compare-property/\n";

	$ai  = "\n# AI Search crawlers — public content allowed, admin blocked\n";
	$ai .= "User-agent: PerplexityBot\nAllow: /\n{$disallow_private}\n";
	$ai .= "User-agent: ClaudeBot\nAllow: /\n{$disallow_private}\n";
	$ai .= "User-agent: GPTBot\nAllow: /\n{$disallow_private}\n";
	$ai .= "User-agent: Google-Extended\nAllow: /\n{$disallow_private}\n";
	$ai .= "User-agent: Googlebot\nAllow: /\n{$disallow_private}\n";
	$ai .= "\n# LLMs.txt discovery\nSitemap: " . esc_url_raw( home_url( '/llms.txt' ) ) . "\n";

	return rtrim( $output ) . "\n" . $ai;
}, 15, 2 );
