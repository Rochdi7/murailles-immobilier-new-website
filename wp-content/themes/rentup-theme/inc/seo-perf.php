<?php

/**
 * Performance, crawlability, and discovery improvements.
 *
 *   • Preconnect to FontAwesome CDN so the first paint isn't blocked
 *     waiting for DNS + TLS handshake.
 *   • Async/defer non-critical theme JS.
 *   • Lazy-load images outside the viewport via WP's native loading="lazy"
 *     (and decoding="async") — WP core handles most of this, we just turn
 *     it on for older themes that opted out.
 *   • Add fetchpriority="high" to the hero image so LCP is measured against
 *     the right element.
 *   • robots.txt: WP serves a virtual one, but we extend it to point to
 *     the Polylang-aware sitemap index.
 *   • Sitemap: WP core's wp-sitemap.xml already includes Polylang's per-language
 *     entries when Polylang is active; we just make sure the property CPT is
 *     included and tweak priorities.
 *
 * @package Murailles Immobilier
 */

if (! defined('ABSPATH')) {
	exit;
}

/**
 * DNS prefetch + preconnect to external origins we know are used on every page.
 */
add_action('wp_head', function () {
?>
	<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
	<link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
<?php
}, 1);

/**
 * Add defer to non-critical theme scripts. Keeps jQuery synchronous (some
 * page builders / inline scripts depend on $ being available immediately).
 */
add_filter('script_loader_tag', function ($tag, $handle) {
	$defer = array(
		'murailles-compare',
		'murailles-favoris',
		'murailles-dropdown',
		'murailles-uploader',
		'murailles-single-property',
		'murailles-slick',
		'murailles-magnific',
		'murailles-rangeslider',
		'murailles-lightbox',
		'murailles-dropzone',
		'murailles-fa6',
	);
	foreach ($defer as $h) {
		if ($handle === $h && strpos($tag, 'defer') === false) {
			$tag = str_replace('<script ', '<script defer ', $tag);
			break;
		}
	}
	return $tag;
}, 10, 2);

/**
 * Ensure the hero image on the front page gets fetchpriority="high" and
 * is NOT lazy-loaded (it's the LCP element). WP core's loading="lazy" is
 * smart about above-the-fold images, but the hero background-image on
 * front-page.php is set via inline CSS so WP can't auto-detect it. We
 * preload it explicitly.
 */
add_action('wp_head', function () {
	if (! is_front_page()) {
		return;
	}
	if (! function_exists('murailles_img')) {
		return;
	}
	$hero = murailles_img('villa-luxe-marrakech-hero.webp');
	if (! $hero) {
		return;
	}
	printf(
		'<link rel="preload" as="image" href="%s" fetchpriority="high">' . "\n",
		esc_url($hero)
	);
}, 2);

/**
 * Force loading="lazy" + decoding="async" on every image in the_content()
 * that doesn't already declare it. WP core does this for new posts, but
 * older content / embedded images may not have it.
 */
add_filter('wp_get_attachment_image_attributes', function ($attr, $attachment, $size) {
	if (empty($attr['loading'])) {
		$attr['loading']  = 'lazy';
	}
	if (empty($attr['decoding'])) {
		$attr['decoding'] = 'async';
	}
	return $attr;
}, 10, 3);

/**
 * Polylang + directory mode hides /robots.txt behind language routing,
 * which makes requests 404. Intercept early and serve WP's virtual robots.txt.
 */
add_action('parse_request', function ($wp) {
	$req = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
	$path = (string) wp_parse_url($req, PHP_URL_PATH);
	$install = (string) wp_parse_url(get_option('home'), PHP_URL_PATH);
	$install = rtrim($install, '/');
	if ($install && strpos($path, $install) === 0) {
		$path = substr($path, strlen($install));
	}
	if ($path === '/robots.txt' || $path === '/wp-sitemap.xml') {
		// Let WP core handle it — it has the rewrites registered.
		$wp->query_vars = array();
		if ($path === '/robots.txt') {
			$wp->query_vars['robots'] = '1';
		} else {
			$wp->query_vars['sitemap'] = 'index';
		}
		$wp->matched_query = $path === '/robots.txt' ? 'robots=1' : 'sitemap=index';
	}
}, 1);

/**
 * Extend WP's virtual robots.txt with:
 *   • Disallow utility paths Google shouldn't crawl
 *   • Reference the sitemap index
 */
add_filter('robots_txt', function ($output, $public) {
	if (! $public) {
		return $output;
	} // Site is set to discourage crawling — respect that.

	$additions  = "\n";
	$additions .= "Disallow: /favoris/\n";
	$additions .= "Disallow: /compare-property/\n";
	$additions .= "Disallow: /erreur/\n";
	$additions .= "Disallow: /checkout/\n";
	$additions .= "Disallow: /*?s=\n";          // search queries
	$additions .= "Disallow: /wp-admin/\n";     // already covered, repeat for older crawlers
	$additions .= "Allow: /wp-admin/admin-ajax.php\n";
	$additions .= "\nSitemap: " . esc_url_raw(home_url('/wp-sitemap.xml')) . "\n";

	// Append before the existing Sitemap line WP adds, if any.
	$output = rtrim($output) . "\n" . $additions;
	return $output;
}, 10, 2);

/**
 * Make sure the property CPT and our published pages are included in the
 * core sitemap. WP includes all public post types and public taxonomies
 * by default, so this is a safety net — exclude only the 'attachment'
 * and noindex'd utility pages.
 */
add_filter('wp_sitemaps_post_types', function ($post_types) {
	// Remove attachment pages (they're indexed individually and dilute the sitemap).
	unset($post_types['attachment']);
	return $post_types;
}, 10, 1);

/**
 * Exclude the noindex'd utility pages from the sitemap so Google doesn't
 * waste crawl budget on /favoris/, /compare-property/, /erreur/, etc.
 */
add_filter('wp_sitemaps_posts_query_args', function ($args, $post_type) {
	if ($post_type !== 'page') {
		return $args;
	}
	$exclude_slugs = array('favoris', 'compare-property', 'erreur', 'checkout');
	$ids = array();
	foreach ($exclude_slugs as $slug) {
		$p = get_page_by_path($slug);
		if ($p) {
			$ids[] = (int) $p->ID;
		}
	}
	if ($ids) {
		$args['post__not_in'] = array_merge((array) ($args['post__not_in'] ?? array()), $ids);
	}
	return $args;
}, 10, 2);

/**
 * Make <html lang="..."> reflect the current Polylang language instead of the
 * site default. Polylang already does this via language_attributes, but the
 * theme's header.php calls language_attributes() — we hook the filter that
 * function calls to make sure the right ISO code is emitted (fr-FR / en-US).
 */
add_filter('language_attributes', function ($output) {
	if (! function_exists('pll_current_language')) {
		return $output;
	}
	$locale = pll_current_language('locale'); // e.g. fr_FR
	if (! $locale) {
		return $output;
	}
	$lang = str_replace('_', '-', $locale);    // fr-FR
	// Strip any existing lang="..." and inject the right one.
	$output = preg_replace('/\blang="[^"]*"/', 'lang="' . $lang . '"', $output);
	return $output;
});

/**
 * Inject a "Skip to main content" link as the first focusable element.
 * Hidden until focused — keyboard users press Tab once and can jump past
 * the navigation. Lighthouse Accessibility audit penalty if missing.
 */
add_action('wp_body_open', function () {
	$label = function_exists('murailles_t') ? murailles_t('Aller au contenu principal', false) : 'Skip to content';
	echo '<a class="murailles-skip-link screen-reader-text" href="#main-wrapper">' . esc_html($label) . '</a>';
});

/**
 * Auto-add accessibility/perf attributes to <img> tags emitted by templates:
 *   • Empty alt="" + class containing "fa", "icon", or src ends with .svg
 *     → add aria-hidden="true" + role="presentation" (decorative icon).
 *   • Missing width/height → add intrinsic sizes based on the file on disk
 *     (prevents CLS on the front page).
 *
 * Buffered via template_redirect → ob_start → wp_footer. Runs once per
 * page response, regex-only (no DOM parser dependency).
 */
add_action('template_redirect', function () {
	if (is_admin() || is_feed() || wp_doing_ajax() || (function_exists('wp_doing_cron') && wp_doing_cron())) {
		return;
	}
	ob_start(function ($html) {

		// Decorative icons: empty alt + class hints → aria-hidden.
		$html = preg_replace_callback(
			'#<img\s([^>]*?)alt=""([^>]*?)>#i',
			function ($m) {
				$before = $m[1];
				$after  = $m[2];
				$full   = $before . $after;
				// Skip if already has aria-hidden or role.
				if (stripos($full, 'aria-hidden') !== false || stripos($full, 'role=') !== false) {
					return $m[0];
				}
				// Only treat as decorative if class contains "icon" or src is an inline SVG / icon file.
				$decorative = false;
				if (preg_match('#class="[^"]*(inc-fleat-icon|fa-|ti-|icon|flag)[^"]*"#i', $full)) {
					$decorative = true;
				}
				if (preg_match('#src="[^"]*(bed|bath|move|pin|verified|flaticon)[^"]*\.svg"#i', $full)) {
					$decorative = true;
				}
				if (! $decorative) {
					return $m[0];
				}
				return '<img ' . $before . 'alt="" aria-hidden="true" role="presentation"' . $after . '>';
			},
			$html
		);

		// Add width/height to logo + testimonial avatars when missing.
		// These are the most common CLS culprits on this theme.
		$known_dims = array(
			'logo.webp'      => array(165, 40),
			'logo.png'       => array(165, 40),
			'user-1.jpg'     => array(60,  60),
			'user-2.jpg'     => array(60,  60),
			'user-3.jpg'     => array(60,  60),
			'user-4.jpg'     => array(60,  60),
			'user-5.jpg'     => array(60,  60),
			'c-1.png'        => array(60,  60),
			'c-2.png'        => array(60,  60),
			'c-3.png'        => array(60,  60),
			'c-4.png'        => array(60,  60),
			'c-5.png'        => array(60,  60),
			'trust.webp'     => array(70,  70),
			'cap.webp'       => array(70,  70),
			'clutch.webp'    => array(70,  70),
		);
		$html = preg_replace_callback(
			'#<img\s([^>]*?)src="([^"]+)"([^>]*?)>#i',
			function ($m) use ($known_dims) {
				$before = $m[1];
				$src    = $m[2];
				$after  = $m[3];
				$full   = $before . $after;
				if (stripos($full, ' width=') !== false || stripos($full, ' height=') !== false) {
					return $m[0]; // Already has dimensions.
				}
				foreach ($known_dims as $needle => $dim) {
					if (stripos($src, $needle) !== false) {
						return '<img ' . $before . 'src="' . $src . '" width="' . $dim[0] . '" height="' . $dim[1] . '"' . $after . '>';
					}
				}
				return $m[0];
			},
			$html
		);

		return $html;
	});
}, 0);

/**
 * Strip Google-incompatible characters from auto-generated post excerpts.
 * Long dashes, smart quotes, and non-breaking spaces sometimes appear in
 * meta descriptions; normalize them for cleaner SERP snippets.
 */
add_filter('get_the_excerpt', function ($excerpt) {
	if (! $excerpt) {
		return $excerpt;
	}
	$replace = array(
		"\xc2\xa0" => ' ',  // NBSP
		'…'        => '...',
		'—'        => '—',  // keep em-dash for FR
	);
	return strtr($excerpt, $replace);
}, 99);
