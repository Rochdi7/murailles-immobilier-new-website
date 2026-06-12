<?php

/**
 * Murailles Immobilier Theme Functions
 *
 * Handles theme setup, asset loading, menu registration, widget areas,
 * and custom post type support for the Murailles Immobilier real estate theme.
 *
 * @package Murailles Immobilier
 */

if (! defined('ABSPATH')) {
	exit;
}

// Theme options panel + murailles_opt() helper
require_once get_template_directory() . '/inc/theme-options.php';
// Load Custom Post Types, Taxonomies, and Meta Boxes
require_once get_template_directory() . '/inc/custom-post-types.php';
require_once get_template_directory() . '/inc/agent-post-type.php';
require_once get_template_directory() . '/inc/forms.php';
require_once get_template_directory() . '/inc/interactive.php';
// i18n helpers — Polylang integration (no-op when Polylang isn't installed).
require_once get_template_directory() . '/inc/i18n.php';
// FR → EN dictionary that seeds Polylang's string-translation panel.
require_once get_template_directory() . '/inc/i18n-strings.php';
// SEO core: title tags, meta description, robots directives.
require_once get_template_directory() . '/inc/seo.php';
// Open Graph + Twitter Cards for rich social-share previews.
require_once get_template_directory() . '/inc/seo-social.php';
// Schema.org JSON-LD: Organization, RealEstateAgent, WebSite, RealEstateListing,
// BlogPosting, FAQPage, BreadcrumbList, ItemList.
require_once get_template_directory() . '/inc/seo-schema.php';
// Performance + crawlability: preconnect, defer JS, lazy images, robots.txt
// extensions, sitemap tuning.
require_once get_template_directory() . '/inc/seo-perf.php';

/**
 * Theme Setup - Register theme features
 */
function murailles_theme_setup()
{
	// Let WordPress manage the document title
	add_theme_support('title-tag');

	// Enable post thumbnails (featured images)
	add_theme_support('post-thumbnails');

	// Custom logo support
	add_theme_support('custom-logo', array(
		'height'      => 50,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
	));

	// HTML5 markup support
	add_theme_support('html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	));

	// Register navigation menus
	register_nav_menus(array(
		'primary'       => __('Primary Menu', 'murailles'),
		'footer-menu'   => __('Footer Menu', 'murailles'),
	));

	// Set content width
	if (! isset($content_width)) {
		$content_width = 1140;
	}

	// Elementor compatibility — opt-in only. Adding theme support tells Elementor
	// that the theme cooperates with the page builder; per-post-type support lets
	// editors click "Edit with Elementor" on pages, posts, and property listings.
	// Existing PHP templates remain in control — Elementor only activates on a
	// post when an editor explicitly opens it in the Elementor editor.
	add_theme_support('elementor');
	add_post_type_support('page', 'elementor');
	add_post_type_support('post', 'elementor');
	add_post_type_support('property', 'elementor');
}
add_action('after_setup_theme', 'murailles_theme_setup');

/**
 * Enqueue Styles
 */
function murailles_enqueue_styles()
{
	$theme_uri = get_template_directory_uri();
	$ver       = wp_get_theme()->get('Version');

	// Main combined stylesheet (contains Bootstrap, FontAwesome 5 classes, all vendor CSS)
	wp_enqueue_style('murailles-styles', $theme_uri . '/assets/css/styles.css', array(), $ver);

	// Slick Carousel core CSS — required for the slider to render. Without these
	// rules (.slick-list overflow, .slick-track display, .slick-initialized
	// .slick-slide display:block) every slide stays display:none after JS init,
	// which is why the single-property mobile gallery was blank. styles.css has
	// only a few helper overrides but lacks the core layout rules.
	wp_enqueue_style('murailles-slick', $theme_uri . '/assets/css/slick.css', array('murailles-styles'), $ver);

	// Font Awesome 6 from CDN — bundled CSS lacks FA6 class names (fa-magnifying-glass,
	// fa-scale-balanced, etc.). Loaded AFTER the theme CSS so its rules win.
	wp_enqueue_style('murailles-fa6', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css', array('murailles-styles'), '6.5.2');

	// Theme overrides — consolidated into murailles-custom.css for caching + SEO.
	// filemtime() so cache busts automatically on every edit.
	$custom_css_ver = file_exists(get_template_directory() . '/assets/css/murailles-custom.css')
		? filemtime(get_template_directory() . '/assets/css/murailles-custom.css')
		: $ver;
	wp_enqueue_style('murailles-custom-css', $theme_uri . '/assets/css/murailles-custom.css', array('murailles-fa6'), $custom_css_ver);

	// WordPress default stylesheet (theme metadata only)
	wp_enqueue_style('murailles-theme-style', get_stylesheet_uri(), array('murailles-styles'), $ver);

	// Unified dropdown / select / datepicker styling. Must load AFTER murailles-styles
	// to override the legacy rules in styles.css.
	// filemtime() so cache busts automatically on every edit.
	$dropdown_css_ver = file_exists(get_template_directory() . '/assets/css/murailles-dropdown.css')
		? filemtime(get_template_directory() . '/assets/css/murailles-dropdown.css')
		: $ver;
	wp_enqueue_style('murailles-dropdown', $theme_uri . '/assets/css/murailles-dropdown.css', array('murailles-styles', 'murailles-theme-style'), $dropdown_css_ver);

	$scroll_css = get_stylesheet_directory() . '/assets/css/scroll-animations.css';
	wp_enqueue_style('murailles-scroll-anim', get_stylesheet_directory_uri() . '/assets/css/scroll-animations.css', array(), file_exists($scroll_css) ? filemtime($scroll_css) : $ver);
}
add_action('wp_enqueue_scripts', 'murailles_enqueue_styles');

/**
 * Enqueue Scripts
 */
function murailles_enqueue_scripts()
{
	$theme_uri = get_template_directory_uri();
	$ver       = wp_get_theme()->get('Version');

	// Use WordPress's bundled jQuery so Elementor, Royal Elementor Addons, and
	// all admin scripts get the handle they expect in <head>. The theme's own
	// jQuery file (3.6.0) is kept in /assets/js/ but is no longer served to
	// avoid the in_footer conflict that breaks Elementor widget initialisation.

	// Popper.js (required by Bootstrap)
	wp_enqueue_script('murailles-popper', $theme_uri . '/assets/js/popper.min.js', array('jquery'), $ver, true);

	// Bootstrap JS
	wp_enqueue_script('murailles-bootstrap', $theme_uri . '/assets/js/bootstrap.min.js', array('jquery', 'murailles-popper'), $ver, true);

	// Ion Range Slider
	wp_enqueue_script('murailles-rangeslider', $theme_uri . '/assets/js/ion.rangeSlider.min.js', array('jquery'), $ver, true);

	// Select2
	wp_enqueue_script('murailles-select2', $theme_uri . '/assets/js/select2.min.js', array('jquery'), $ver, true);

	// Magnific Popup
	wp_enqueue_script('murailles-magnific', $theme_uri . '/assets/js/jquery.magnific-popup.min.js', array('jquery'), $ver, true);

	// Slick Slider
	wp_enqueue_script('murailles-slick', $theme_uri . '/assets/js/slick.js', array('jquery'), $ver, true);

	// Slider Background
	wp_enqueue_script('murailles-slider-bg', $theme_uri . '/assets/js/slider-bg.js', array('jquery'), $ver, true);

	// Lightbox
	wp_enqueue_script('murailles-lightbox', $theme_uri . '/assets/js/lightbox.js', array('jquery'), $ver, true);

	// Images Loaded
	wp_enqueue_script('murailles-imagesloaded', $theme_uri . '/assets/js/imagesloaded.js', array('jquery'), $ver, true);

	// Daterange Picker
	wp_enqueue_script('murailles-daterangepicker', $theme_uri . '/assets/js/daterangepicker.js', array('jquery'), $ver, true);

	// Dropzone
	wp_enqueue_script('murailles-dropzone', $theme_uri . '/assets/js/dropzone.js', array('jquery'), $ver, true);

	// Custom JS (main theme script)
	$custom_js_ver = file_exists(get_template_directory() . '/assets/js/custom.js')
		? filemtime(get_template_directory() . '/assets/js/custom.js')
		: $ver;
	wp_enqueue_script('murailles-custom', $theme_uri . '/assets/js/custom.js', array('jquery', 'murailles-bootstrap', 'murailles-slick'), $custom_js_ver, true);

	// Unified dropdown enhancer — converts every <select.form-control> into the
	// Murailles dropdown component. No dependencies, vanilla JS.
	$dropdown_js_ver = file_exists(get_template_directory() . '/assets/js/murailles-dropdown.js')
		? filemtime(get_template_directory() . '/assets/js/murailles-dropdown.js')
		: $ver;
	wp_enqueue_script('murailles-dropdown', $theme_uri . '/assets/js/murailles-dropdown.js', array(), $dropdown_js_ver, true);

	// File uploader with previews — used on submit-property.php and any other
	// form that opts in with [data-murailles-uploader]. Vanilla JS, no deps.
	$uploader_js_ver = file_exists(get_template_directory() . '/assets/js/murailles-uploader.js')
		? filemtime(get_template_directory() . '/assets/js/murailles-uploader.js')
		: $ver;
	wp_enqueue_script('murailles-uploader', $theme_uri . '/assets/js/murailles-uploader.js', array(), $uploader_js_ver, true);

	$scroll_js = get_stylesheet_directory() . '/assets/js/scroll-animations.js';
	wp_enqueue_script('murailles-scroll-anim', get_stylesheet_directory_uri() . '/assets/js/scroll-animations.js', array(), file_exists($scroll_js) ? filemtime($scroll_js) : $ver, true);

	// Page-specific scripts — loaded only on their pages via is_page_template().
	if (is_singular('property') || is_page_template('page-templates/single-property-1.php')) {
		wp_enqueue_script('murailles-single-property', $theme_uri . '/assets/js/murailles-single-property.js', array('murailles-wishlist-compare'), $ver, true);
	}
	if (is_page_template('page-templates/favoris.php')) {
		wp_enqueue_script('murailles-favoris', $theme_uri . '/assets/js/murailles-favoris.js', array('murailles-wishlist-compare'), $ver, true);
	}
	if (is_page_template('page-templates/compare-property.php')) {
		wp_enqueue_script('murailles-compare', $theme_uri . '/assets/js/murailles-compare.js', array('murailles-wishlist-compare'), $ver, true);
	}
}
add_action('wp_enqueue_scripts', 'murailles_enqueue_scripts');

/**
 * Register Widget Areas (Sidebars)
 */
function murailles_widgets_init()
{
	register_sidebar(array(
		'name'          => __('Blog Sidebar', 'murailles'),
		'id'            => 'blog-sidebar',
		'description'   => __('Widgets shown on blog and archive pages.', 'murailles'),
		'before_widget' => '<div id="%1$s" class="sidebar_widgets %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="sidebar_title">',
		'after_title'   => '</h4>',
	));

	register_sidebar(array(
		'name'          => __('Property Sidebar', 'murailles'),
		'id'            => 'property-sidebar',
		'description'   => __('Widgets shown on property listing pages.', 'murailles'),
		'before_widget' => '<div id="%1$s" class="sidebar_widgets %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="sidebar_title">',
		'after_title'   => '</h4>',
	));

	register_sidebar(array(
		'name'          => __('Footer Column 1', 'murailles'),
		'id'            => 'footer-1',
		'description'   => __('First footer widget column.', 'murailles'),
		'before_widget' => '<div id="%1$s" class="footer_widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget_title">',
		'after_title'   => '</h4>',
	));

	register_sidebar(array(
		'name'          => __('Footer Column 2', 'murailles'),
		'id'            => 'footer-2',
		'description'   => __('Second footer widget column.', 'murailles'),
		'before_widget' => '<div id="%1$s" class="footer_widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget_title">',
		'after_title'   => '</h4>',
	));

	register_sidebar(array(
		'name'          => __('Footer Column 3', 'murailles'),
		'id'            => 'footer-3',
		'description'   => __('Third footer widget column.', 'murailles'),
		'before_widget' => '<div id="%1$s" class="footer_widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget_title">',
		'after_title'   => '</h4>',
	));
}
add_action('widgets_init', 'murailles_widgets_init');

/**
 * Custom Walker for the primary navigation menu
 * Outputs the exact same HTML structure as the original template
 */
class Murailles_Nav_Walker extends Walker_Nav_Menu
{

	public function start_lvl(&$output, $depth = 0, $args = null)
	{
		$indent = str_repeat("\t", $depth);
		$output .= "\n{$indent}<ul class=\"nav-dropdown nav-submenu\">\n";
	}

	public function end_lvl(&$output, $depth = 0, $args = null)
	{
		$indent = str_repeat("\t", $depth);
		$output .= "{$indent}</ul>\n";
	}

	public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
	{
		$indent    = str_repeat("\t", $depth);
		$classes   = empty($item->classes) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
		$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

		$output .= $indent . '<li' . $class_names . '>';

		$atts           = array();
		$atts['title']  = ! empty($item->attr_title) ? $item->attr_title : '';
		$atts['target'] = ! empty($item->target) ? $item->target : '';
		$atts['rel']    = ! empty($item->xfn) ? $item->xfn : '';
		$atts['href']   = ! empty($item->url) ? $item->url : '';

		$atts       = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
		$attributes = '';
		foreach ($atts as $attr => $value) {
			if (! empty($value)) {
				$value       = esc_attr($value);
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$title = apply_filters('the_title', $item->title, $item->ID);

		// Add submenu indicator if item has children
		$has_children = in_array('menu-item-has-children', $classes);
		$indicator    = $has_children ? '<span class="submenu-indicator"></span>' : '';

		$item_output  = isset($args->before) ? $args->before : '';
		$item_output .= '<a' . $attributes . '>';
		$item_output .= (isset($args->link_before) ? $args->link_before : '') . $title . $indicator . (isset($args->link_after) ? $args->link_after : '');
		$item_output .= '</a>';
		$item_output .= isset($args->after) ? $args->after : '';

		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}
}

/**
 * Fallback menu when no menu is assigned
 * Outputs the original static navigation links
 */
function murailles_fallback_menu()
{
?>
	<ul class="nav-menu">
		<li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
		<li><a href="<?php echo esc_url(home_url('/blog/')); ?>">Blog</a></li>
		<li><a href="<?php echo esc_url(home_url('/about-us/')); ?>">About Us</a></li>
		<li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact</a></li>
	</ul>
<?php
}

/**
 * Add body classes for skin support
 */
function murailles_body_classes($classes)
{
	$classes[] = 'yellow-skin';
	return $classes;
}
add_filter('body_class', 'murailles_body_classes');

/**
 * Disable WordPress emoji scripts and block editor CSS (keeps frontend clean)
 */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

function murailles_remove_wp_block_css()
{
	wp_dequeue_style('wp-block-library');
	wp_dequeue_style('wp-block-library-theme');
	wp_dequeue_style('global-styles');
	wp_dequeue_style('classic-theme-styles');
}
add_action('wp_enqueue_scripts', 'murailles_remove_wp_block_css', 100);

/**
 * Allow SVG uploads
 */
function murailles_mime_types($mimes)
{
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'murailles_mime_types');

/**
 * Wrap the post count in WP's default Categories widget so we can style it
 * as a circular badge (matches the CodeSommet blog-detail sidebar design).
 *
 * WP renders each item as: <li><a>Name</a> (3)</li>
 * After this filter it becomes: <li><a>Name</a><span class="murailles-cat-count">03</span></li>
 *
 * Applied to both `wp_list_categories` (generic) and `widget_categories`
 * (sidebar widget) outputs so the styling stays consistent everywhere.
 */
function murailles_format_category_count($html)
{
	return preg_replace(
		'/<\/a>\s*\((\d+)\)/',
		'</a><span class="murailles-cat-count">$1</span>',
		$html
	);
}
add_filter('wp_list_categories', 'murailles_format_category_count');
add_filter('widget_categories_args', function ($args) {
	$args['show_count'] = 1;
	return $args;
});

/**
 * Custom excerpt length
 */
function murailles_excerpt_length($length)
{
	return 25;
}
add_filter('excerpt_length', 'murailles_excerpt_length');

/**
 * Custom excerpt "read more" text
 */
function murailles_excerpt_more($more)
{
	return '...';
}
add_filter('excerpt_more', 'murailles_excerpt_more');

/**
 * Helper: Return the canonical URL for the property archive (/bien/).
 * Used everywhere a link to "all properties" is needed.
 * Falls back to home_url('/bien/') when no post-type archive URL is resolvable
 * (e.g. during a fresh install before CPTs are fully flushed).
 */
function murailles_bien_url() {
	$url = get_post_type_archive_link( 'property' );
	return $url ? $url : home_url( '/bien/' );
}

/**
 * Helper: Get theme image URL
 * Simplifies referencing images in the assets/images folder.
 *
 * Demo override: routes brand logo and property/riad photos to remote demo URLs
 * (Agence Murailles assets) so the local theme reflects the live brand without
 * needing to re-upload media. UI icons, avatars and testimonial logos fall
 * through to the local /assets/images/ folder.
 */
function murailles_img($filename)
{
	$logo_remote = 'https://usercontent.one/wp/www.agence-immobilier-marrakech.com/wp-content/uploads/2019/05/LOGOM-e1611537046750.png?media=1768339104';
	$riad_remote = 'https://usercontent.one/wp/www.agence-immobilier-marrakech.com/wp-content/uploads/2022/10/WhatsApp-Image-2025-12-02-at-15.37.02-1-525x328.jpeg?media=1768339104';

	$theme_dir = get_template_directory();
	$theme_uri = get_template_directory_uri();

	// Local theme image takes priority: if you drop a real image into
	// assets/images/ matching the filename, it's served instead of any
	// remote fallback. This is how new branded assets ship without
	// editing this function each time.
	if ( file_exists( $theme_dir . '/assets/images/' . $filename ) ) {
		return $theme_uri . '/assets/images/' . $filename;
	}

	// Brand logos (header + footer, light + dark variants) — remote fallback
	// when the local logo file is missing.
	if (preg_match('/^logo(-light)?\.png$/i', $filename)) {
		return $logo_remote;
	}

	// Demo placeholders from the original rentup HTML kit (p-N.png, city-N.png,
	// b-N.jpg, slider-N.jpg, banner-home.jpg). When no real image is in the
	// theme folder we fall back to the agency's stock riad photo so cards
	// don't render broken. Drop a real image with the same filename into
	// assets/images/ to override per-tile (e.g. p-1.png → real riad photo).
	// To diversify card placeholders for properties without their own photos,
	// we rotate over a small set of branded webp files when they exist.
	if (preg_match('/^(p-\d+\.(png|jpe?g)|city-\d+\.(png|jpe?g)|b-\d+\.(png|jpe?g)|slider-\d+\.(png|jpe?g)|banner-home\.(png|jpe?g))$/i', $filename)) {
		$rotation = array(
			'propriete-marrakech-default.webp',
			'villa-luxe-marrakech-hero.webp',
			'about-agence-murailles-immobilier.webp',
			'nos-services-immobilier-marrakech.webp',
			'histoire-marrakech.webp',
			'tourisme-marrakech.webp',
		);
		// Stable per-filename index so a given placeholder always resolves
		// to the same branded image (no flicker between page loads).
		$idx = abs( crc32( $filename ) ) % count( $rotation );
		for ( $i = 0; $i < count( $rotation ); $i++ ) {
			$candidate = $rotation[ ( $idx + $i ) % count( $rotation ) ];
			if ( file_exists( $theme_dir . '/assets/images/' . $candidate ) ) {
				return $theme_uri . '/assets/images/' . $candidate;
			}
		}
		return $riad_remote;
	}

	return $theme_uri . '/assets/images/' . $filename;
}

/**
 * Auto-create all WordPress pages with correct templates on theme activation.
 * This maps every page template to a WordPress page so all navigation links work.
 */
function murailles_create_pages( $force = false )
{
	// Only run once unless forced
	if ( ! $force && get_option('murailles_pages_created') ) {
		return;
	}

	// slug => [ title, template file relative to theme root ]
	$pages = array(
		'home'                       => array('Home',                        ''),
		'about-us'                   => array('About Us',                    'page-templates/about-us.php'),
		'contact'                    => array('Contact',                     'page-templates/contact.php'),
		'blog'                       => array('Blog',                        ''),
		'faq'                        => array('FAQ',                         'page-templates/faq.php'),
		'pricing'                    => array('Pricing',                     'page-templates/pricing.php'),
		'privacy'                    => array('Politique de confidentialité', 'page-templates/privacy.php'),
		'conditions-generales'       => array('Conditions générales',        'page-templates/terms.php'),
		'checkout'                   => array('Checkout',                    'page-templates/checkout.php'),
		'component'                  => array('Components',                  'page-templates/component.php'),
		'dashboard'                  => array('Dashboard',                   'page-templates/dashboard.php'),
		'my-profile'                 => array('My Profile',                  'page-templates/my-profile.php'),
		'my-property'                => array('My Property',                 'page-templates/my-property.php'),
		'messages'                   => array('Messages',                    'page-templates/messages.php'),
		'bookmark-list'              => array('Bookmark List',               'page-templates/bookmark-list.php'),
		'favoris'                    => array('Mes favoris',                  'page-templates/favoris.php'),
		'submit-property'            => array('Submit Property',             'page-templates/submit-property.php'),
		'compare-property'           => array('Compare Property',            'page-templates/compare-property.php'),
		'single-property-1'          => array('Single Property 1',           'page-templates/single-property-1.php'),
		'single-property-2'          => array('Single Property 2',           'page-templates/single-property-2.php'),
		'single-property-3'          => array('Single Property 3',           'page-templates/single-property-3.php'),
		'single-property-4'          => array('Single Property 4',           'page-templates/single-property-4.php'),
		'agents'                     => array('Agents',                      'page-templates/agents.php'),
		'agents-2'                   => array('Agents Grid 2',              'page-templates/agents-2.php'),
		'agent-page'                 => array('Agent Detail',                'page-templates/agent-page.php'),
		'agencies'                   => array('Agencies',                    'page-templates/agencies.php'),
		'agency-page'                => array('Agency Detail',               'page-templates/agency-page.php'),
		'grid-layout-with-sidebar'   => array('Grid Layout With Sidebar',    'page-templates/grid-layout-with-sidebar.php'),
		'grid-layout-2'              => array('Grid Layout 2',               'page-templates/grid-layout-2.php'),
		'grid-layout-3'              => array('Grid Layout 3',               'page-templates/grid-layout-3.php'),
		'grid-layout-with-map'       => array('Grid Layout With Map',        'page-templates/grid-layout-with-map.php'),
		'list-layout-with-sidebar'   => array('List Layout With Sidebar',    'page-templates/list-layout-with-sidebar.php'),
		'list-layout-with-map'       => array('List Layout With Map',        'page-templates/list-layout-with-map.php'),
		'list-layout-with-map-2'     => array('List Layout With Map 2',      'page-templates/list-layout-with-map-2.php'),
		'classical-layout-with-map'  => array('Classical Layout With Map',   'page-templates/classical-layout-with-map.php'),
		'half-map'                   => array('Half Map',                    'page-templates/half-map.php'),
		'half-map-2'                 => array('Half Map 2',                  'page-templates/half-map-2.php'),
		'map-home'                   => array('Map Home',                    'page-templates/map.php'),
		'home-2'                     => array('Home 2',                      'page-templates/home-2.php'),
		'home-3'                     => array('Home 3',                      'page-templates/home-3.php'),
		'home-4'                     => array('Home 4',                      'page-templates/home-4.php'),
		'home-5'                     => array('Home 5',                      'page-templates/home-5.php'),
		'home-6'                     => array('Home 6',                      'page-templates/home-6.php'),
		'home-7'                     => array('Home 7',                      'page-templates/home-7.php'),
		// Inner service/editorial pages — linked from nav and footer.
		'nos-services'               => array('Nos Services',                'page-templates/nos-services.php'),
		'assistance-conseils'        => array('Assistance & Conseils',       'page-templates/assistance-conseils.php'),
		'histoire-marrakech'         => array('Histoire de Marrakech',       'page-templates/histoire-marrakech.php'),
		'tourisme-marrakech'         => array('Tourisme à Marrakech',        'page-templates/tourisme-marrakech.php'),
	);

	foreach ($pages as $slug => $data) {
		$title    = $data[0];
		$template = $data[1];

		// Skip if page already exists
		$existing = get_page_by_path($slug);
		if ($existing) {
			// Still assign the template if missing
			if ($template && ! get_post_meta($existing->ID, '_wp_page_template', true)) {
				update_post_meta($existing->ID, '_wp_page_template', $template);
			}
			continue;
		}

		$page_id = wp_insert_post(array(
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '',
		));

		if ($page_id && ! is_wp_error($page_id) && $template) {
			update_post_meta($page_id, '_wp_page_template', $template);
		}
	}

	// Set "Home" as static front page and "Blog" as posts page
	$home_page = get_page_by_path('home');
	$blog_page = get_page_by_path('blog');

	if ($home_page) {
		update_option('show_on_front', 'page');
		update_option('page_on_front', $home_page->ID);
	}
	if ($blog_page) {
		update_option('page_for_posts', $blog_page->ID);
	}

	// Set permalink structure to /%postname%/ so slugs work
	global $wp_rewrite;
	$wp_rewrite->set_permalink_structure('/%postname%/');
	$wp_rewrite->flush_rules( false );

	update_option('murailles_pages_created', true);
}
// Page creation is intentionally NOT wired to after_switch_theme.
// An admin notice with a manual button triggers it instead (see murailles_admin_setup_notice).

/**
 * Admin notice shown after theme activation for one-time manual setup.
 * Three independent nonce-protected buttons — none runs automatically:
 *   1. "Créer le contenu du thème"  — 44 pages      (murailles_create_pages)
 *   2. "Créer les termes de taxonomie" — ~90 terms  (murailles_populate_taxonomies)
 *   3. "Publier les articles de démo" — 3 posts     (murailles_seed_demo_blog_posts)
 *
 * This pattern prevents bulk SQL during activation on One.com Managed WordPress.
 */
function murailles_admin_setup_notice()
{
	$pages_done = (bool) get_option( 'murailles_pages_created' );
	$terms_done = (bool) get_option( 'murailles_taxonomies_populated_v3' );
	$posts_done = (bool) get_option( 'murailles_demo_blog_seeded' );

	// Build the redirect-back URL (current admin page, so notice reappears after action).
	$back_url = esc_url( remove_query_arg( array( 'murailles_done', 'murailles_action' ) ) );

	// Show transient success messages set by admin-post handlers.
	$done_msg = get_transient( 'murailles_setup_done_' . get_current_user_id() );
	if ( $done_msg ) {
		delete_transient( 'murailles_setup_done_' . get_current_user_id() );
		echo '<div class="notice notice-success is-dismissible"><p>' . wp_kses_post( $done_msg ) . '</p></div>';
		// Refresh local state after action.
		$pages_done = (bool) get_option( 'murailles_pages_created' );
		$terms_done = (bool) get_option( 'murailles_taxonomies_populated_v3' );
		$posts_done = (bool) get_option( 'murailles_demo_blog_seeded' );
	}

	// All done — hide the notice.
	if ( $pages_done && $terms_done && $posts_done ) {
		return;
	}

	// Each form posts to admin-post.php with action= and a _wpnonce field.
	// admin-post.php is always a valid endpoint on every WP install (no blank page).
	echo '<div class="notice notice-warning">';
	echo '<p><strong>Agence Murailles Theme — Configuration initiale</strong></p>';
	echo '<p style="display:flex;gap:12px;flex-wrap:wrap;align-items:center;">';

	if ( ! $pages_done ) {
		echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
		echo '<input type="hidden" name="action" value="murailles_create_pages">';
		echo '<input type="hidden" name="_wpnonce" value="' . esc_attr( wp_create_nonce( 'murailles_create_pages' ) ) . '">';
		echo '<input type="hidden" name="_wp_http_referer" value="' . esc_attr( wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ) ) . '">';
		echo '<button type="submit" class="button button-primary">Créer le contenu du thème (44 pages)</button>';
		echo '</form>';
	}

	if ( ! $terms_done ) {
		echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
		echo '<input type="hidden" name="action" value="murailles_populate_terms">';
		echo '<input type="hidden" name="_wpnonce" value="' . esc_attr( wp_create_nonce( 'murailles_populate_terms' ) ) . '">';
		echo '<input type="hidden" name="_wp_http_referer" value="' . esc_attr( wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ) ) . '">';
		echo '<button type="submit" class="button">Créer les termes de taxonomie (~90 termes)</button>';
		echo '</form>';
	}

	if ( ! $posts_done ) {
		echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
		echo '<input type="hidden" name="action" value="murailles_seed_posts">';
		echo '<input type="hidden" name="_wpnonce" value="' . esc_attr( wp_create_nonce( 'murailles_seed_posts' ) ) . '">';
		echo '<input type="hidden" name="_wp_http_referer" value="' . esc_attr( wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ) ) . '">';
		echo '<button type="submit" class="button">Publier les articles de démo (3 posts)</button>';
		echo '</form>';
	}

	// Re-import — always visible so missing pages can be restored any time.
	echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" style="margin-left:auto;" onsubmit="return confirm(\'Ré-importer toutes les 44 pages ? Les pages existantes ne seront pas supprimées.\')">';
	echo '<input type="hidden" name="action" value="murailles_reimport_pages">';
	echo '<input type="hidden" name="_wpnonce" value="' . esc_attr( wp_create_nonce( 'murailles_reimport_pages' ) ) . '">';
	echo '<input type="hidden" name="_wp_http_referer" value="' . esc_attr( wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ) ) . '">';
	echo '<button type="submit" class="button" style="color:#856404;border-color:#ffc107;">↺ Ré-importer toutes les pages</button>';
	echo '</form>';

	echo '</p>';
	if ( $pages_done ) {
		echo '<p style="margin:4px 0 8px;color:#666;font-size:12px;">✓ Pages déjà créées — utilisez ↺ pour récupérer des pages manquantes.</p>';
	}
	echo '</div>';
}
add_action( 'admin_notices', 'murailles_admin_setup_notice' );

/**
 * admin-post.php handlers — each runs, sets a transient for the success notice,
 * then redirects back to wherever the admin was (no blank page, no double-submit).
 */
function murailles_handle_create_pages() {
	if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'murailles_create_pages' ) ) {
		wp_die( 'Accès refusé.' );
	}
	murailles_create_pages();
	set_transient( 'murailles_setup_done_' . get_current_user_id(),
		'<strong>Agence Murailles:</strong> Pages créées. <a href="' . esc_url( admin_url( 'edit.php?post_type=page' ) ) . '">Voir les pages &rarr;</a>',
		60 );
	wp_safe_redirect( wp_get_referer() ?: admin_url() );
	exit;
}
add_action( 'admin_post_murailles_create_pages', 'murailles_handle_create_pages' );

function murailles_handle_populate_terms() {
	if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'murailles_populate_terms' ) ) {
		wp_die( 'Accès refusé.' );
	}
	murailles_populate_taxonomies();
	set_transient( 'murailles_setup_done_' . get_current_user_id(),
		'<strong>Agence Murailles:</strong> Termes de taxonomie créés (catégories, localisations, quartiers).',
		60 );
	wp_safe_redirect( wp_get_referer() ?: admin_url() );
	exit;
}
add_action( 'admin_post_murailles_populate_terms', 'murailles_handle_populate_terms' );

function murailles_handle_seed_posts() {
	if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'murailles_seed_posts' ) ) {
		wp_die( 'Accès refusé.' );
	}
	murailles_seed_demo_blog_posts();
	set_transient( 'murailles_setup_done_' . get_current_user_id(),
		'<strong>Agence Murailles:</strong> Articles de démo publiés.',
		60 );
	wp_safe_redirect( wp_get_referer() ?: admin_url() );
	exit;
}
add_action( 'admin_post_murailles_seed_posts', 'murailles_handle_seed_posts' );

function murailles_handle_reimport_pages() {
	if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'murailles_reimport_pages' ) ) {
		wp_die( 'Accès refusé.' );
	}
	delete_option( 'murailles_pages_created' );
	murailles_create_pages( true );
	set_transient( 'murailles_setup_done_' . get_current_user_id(),
		'<strong>Agence Murailles:</strong> Toutes les pages ont été ré-importées. <a href="' . esc_url( admin_url( 'edit.php?post_type=page' ) ) . '">Voir les pages &rarr;</a>',
		60 );
	wp_safe_redirect( wp_get_referer() ?: admin_url() );
	exit;
}
add_action( 'admin_post_murailles_reimport_pages', 'murailles_handle_reimport_pages' );

/**
 * Seed 3 demo blog posts so the dynamic blog grid + detail pages have content.
 * Runs once: guarded by the `murailles_demo_blog_seeded` option.
 */
function murailles_seed_demo_blog_posts()
{
	if (get_option('murailles_demo_blog_seeded')) {
		return;
	}

	// Ensure a couple of categories exist
	$cat_ids = array();
	foreach (array('Real Estate', 'Interior Design', 'Property Tips') as $cat_name) {
		$term = term_exists($cat_name, 'category');
		if (! $term) {
			$term = wp_insert_term($cat_name, 'category');
		}
		if (! is_wp_error($term)) {
			$cat_ids[$cat_name] = is_array($term) ? (int) $term['term_id'] : (int) $term;
		}
	}

	$posts = array(
		array(
			'title'   => 'Investir à Marrakech : guide complet pour 2026',
			'slug'    => 'investir-a-marrakech-guide-2026',
			'excerpt' => 'Tout ce qu\'il faut savoir pour réussir votre investissement immobilier dans la ville ocre cette année.',
			'content' => "<p>Marrakech reste l'une des destinations les plus attractives pour l'investissement immobilier au Maroc. Avec une demande locative en hausse constante, des prix encore accessibles et une fiscalité avantageuse, la ville ocre offre des opportunités uniques aux investisseurs avertis.</p>\n\n<h3>Pourquoi investir à Marrakech ?</h3>\n<p>La ville bénéficie d'un afflux touristique stable, d'infrastructures modernes et d'un cadre de vie incomparable. Les quartiers comme l'Hivernage, Guéliz et la Palmeraie continuent d'attirer une clientèle internationale exigeante.</p>\n\n<h3>Les meilleurs quartiers en 2026</h3>\n<ul><li><strong>L'Hivernage</strong> — luxe et hôtellerie haut de gamme</li><li><strong>Guéliz</strong> — moderne et bien situé</li><li><strong>La Palmeraie</strong> — villas avec piscine</li><li><strong>Médina</strong> — riads de caractère</li></ul>\n\n<h3>Notre conseil</h3>\n<p>Faites-vous accompagner par une agence locale qui connaît le marché. Murailles Immobilier vous propose un suivi complet de votre projet, de la recherche à la signature.</p>",
			'category' => 'Real Estate',
		),
		array(
			'title'   => 'Décorer un riad traditionnel : 7 idées intemporelles',
			'slug'    => 'decorer-riad-traditionnel-idees',
			'excerpt' => 'Découvrez comment marier authenticité marocaine et confort moderne dans votre riad.',
			'content' => "<p>Le riad marocain est un joyau architectural qui mérite une décoration à sa hauteur. Voici nos sept conseils pour mettre en valeur ce patrimoine unique tout en y apportant le confort moderne.</p>\n\n<h3>1. Le zellige, valeur sûre</h3><p>Misez sur des zelliges traditionnels pour les sols et les murs du patio. Les motifs géométriques apportent une signature visuelle forte.</p>\n\n<h3>2. Le tadelakt sur les murs</h3><p>Cet enduit à la chaux donne une finition douce et chaleureuse, parfaite pour les pièces de vie et les salles de bain.</p>\n\n<h3>3. Du mobilier sur mesure</h3><p>Faites travailler les artisans locaux : menuisiers, ferronniers et tapissiers réalisent des pièces uniques qui valoriseront votre intérieur.</p>\n\n<h3>4. Des textiles berbères</h3><p>Tapis Beni Ouarain, coussins kilim, tentures en lin… les textiles apportent chaleur et caractère.</p>\n\n<h3>5. Une lumière douce</h3><p>Multipliez les sources lumineuses : lanternes en laiton ajouré, bougies, appliques discrètes.</p>\n\n<h3>6. Un patio végétalisé</h3><p>Orangers, bougainvilliers, jasmins : la végétation transforme votre patio en oasis de fraîcheur.</p>\n\n<h3>7. Une touche contemporaine</h3><p>N'hésitez pas à mêler quelques pièces design pour rompre la monotonie et signaler votre style personnel.</p>",
			'category' => 'Interior Design',
		),
		array(
			'title'   => '5 erreurs à éviter lors de l\'achat d\'un bien immobilier',
			'slug'    => 'erreurs-eviter-achat-immobilier',
			'excerpt' => 'Ne tombez pas dans les pièges classiques : voici les 5 erreurs les plus fréquentes lors d\'un achat immobilier au Maroc.',
			'content' => "<p>Acheter un bien immobilier est l'une des décisions financières les plus importantes d'une vie. Pour éviter les déconvenues, voici les cinq erreurs les plus fréquentes que nous voyons chez Murailles Immobilier.</p>\n\n<h3>1. Négliger l'étude du titre foncier</h3><p>Vérifiez toujours que le bien est titré, qu'il n'y a pas de servitude cachée ni d'hypothèque en cours. Un avocat immobilier peut vous épargner bien des soucis.</p>\n\n<h3>2. Sous-estimer les frais annexes</h3><p>Droits d'enregistrement, honoraires notariaux, taxes : prévoyez environ 8 à 10 % du prix d'achat en frais annexes.</p>\n\n<h3>3. Acheter sans visite approfondie</h3><p>Visitez le bien à différents moments de la journée. Vérifiez la luminosité, le bruit, le voisinage.</p>\n\n<h3>4. Ignorer les diagnostics techniques</h3><p>Plomberie, électricité, toiture, humidité : faites venir un expert avant de signer le compromis.</p>\n\n<h3>5. Se précipiter sur une offre</h3><p>Prenez le temps de comparer, de négocier et de réfléchir. Le marché marocain offre de nombreuses opportunités, ne vous laissez pas presser.</p>\n\n<p><strong>Conclusion :</strong> un achat immobilier réussi se prépare. N'hésitez pas à vous entourer de professionnels — c'est tout l'intérêt de travailler avec Murailles Immobilier.</p>",
			'category' => 'Property Tips',
		),
	);

	foreach ($posts as $p) {
		// Skip if a post with this slug already exists
		if (get_page_by_path($p['slug'], OBJECT, 'post')) {
			continue;
		}

		$post_id = wp_insert_post(array(
			'post_title'   => $p['title'],
			'post_name'    => $p['slug'],
			'post_content' => $p['content'],
			'post_excerpt' => $p['excerpt'],
			'post_status'  => 'publish',
			'post_type'    => 'post',
			'post_author'  => 1,
		));

		if ($post_id && ! is_wp_error($post_id) && isset($cat_ids[$p['category']])) {
			wp_set_post_categories($post_id, array($cat_ids[$p['category']]));
		}
	}

	update_option('murailles_demo_blog_seeded', true);
}
// Demo blog seeder is NOT wired to after_switch_theme or admin_init.
// Triggered manually via the admin notice button (see murailles_admin_setup_notice).

/**
 * Central contact info — single source of truth for the agency's coordinates.
 *
 * Override any field via wp-config.php constants (MURAILLES_PHONE,
 * MURAILLES_EMAIL, etc.) if you ever need an environment-specific value
 * without editing the theme code.
 *
 * Used by: footer.php, contact.php, privacy.php, terms.php,
 * single-property-1.php, inc/email-templates.php.
 */
function murailles_contact_info()
{
	return array(
		'phone'         => defined('MURAILLES_PHONE')         ? MURAILLES_PHONE         : '+212 (0) 6 61 42 51 50',
		'phone_tel'     => defined('MURAILLES_PHONE_TEL')     ? MURAILLES_PHONE_TEL     : '+212661425150',
		'phone_display' => defined('MURAILLES_PHONE_DISPLAY') ? MURAILLES_PHONE_DISPLAY : '+212 6 61 42 51 50',
		'email'         => defined('MURAILLES_EMAIL')         ? MURAILLES_EMAIL         : 'contact@murailles-immobilier.com',
		'address_line1' => defined('MURAILLES_ADDR1')         ? MURAILLES_ADDR1         : '13 Rue Mouslim, Résidence Boukar',
		'address_line2' => defined('MURAILLES_ADDR2')         ? MURAILLES_ADDR2         : '2ème étage Bureau N°10',
		'address_city'  => defined('MURAILLES_CITY')          ? MURAILLES_CITY          : 'Marrakech 40000, Maroc',
		'contact_name'  => defined('MURAILLES_CONTACT_NAME')  ? MURAILLES_CONTACT_NAME  : 'Youssef',
		'facebook'      => defined('MURAILLES_FACEBOOK')      ? MURAILLES_FACEBOOK      : 'https://www.facebook.com/profile.php?id=100063563441285',
		'instagram'     => defined('MURAILLES_INSTAGRAM')     ? MURAILLES_INSTAGRAM     : '#',
		'twitter'       => defined('MURAILLES_TWITTER')       ? MURAILLES_TWITTER       : '#',
	);
}

// ============================================================
// AFFAIRES DU MOIS — back-office settings page
// Lets the admin pick which published properties appear in the
// "Affaires du Mois" carousel on the homepage.
// ============================================================

function murailles_adm_register_settings() {
	register_setting(
		'murailles_adm_group',
		'murailles_affaires_du_mois',
		array(
			'type'              => 'array',
			'sanitize_callback' => 'murailles_adm_sanitize',
			'default'           => array(),
		)
	);
}
add_action( 'admin_init', 'murailles_adm_register_settings' );

function murailles_adm_sanitize( $value ) {
	if ( ! is_array( $value ) ) {
		return array();
	}
	return array_values( array_filter( array_map( 'absint', $value ) ) );
}

function murailles_adm_add_menu() {
	add_submenu_page(
		'themes.php',
		__( 'Affaires du Mois', 'murailles' ),
		__( 'Affaires du Mois', 'murailles' ),
		'manage_options',
		'murailles-affaires-du-mois',
		'murailles_adm_settings_page'
	);
}
add_action( 'admin_menu', 'murailles_adm_add_menu' );

function murailles_adm_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$saved_ids = array_filter( array_map( 'intval', (array) get_option( 'murailles_affaires_du_mois', array() ) ) );

	// All published properties for the picker
	$all_props = get_posts( array(
		'post_type'      => 'property',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'title',
		'order'          => 'ASC',
	) );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Affaires du Mois', 'murailles' ); ?></h1>
		<p><?php esc_html_e( 'Sélectionnez les biens à afficher dans le carrousel "Affaires du Mois" sur la page d\'accueil. L\'ordre de sélection est conservé.', 'murailles' ); ?></p>

		<?php settings_errors( 'murailles_adm_group' ); ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'murailles_adm_group' ); ?>

			<?php if ( empty( $all_props ) ) : ?>
				<p><em><?php esc_html_e( 'Aucun bien publié trouvé. Publiez d\'abord des biens immobiliers.', 'murailles' ); ?></em></p>
			<?php else : ?>
			<table class="widefat striped" style="max-width:800px;margin-top:16px;">
				<thead>
					<tr>
						<th style="width:40px;"><?php esc_html_e( 'Inclure', 'murailles' ); ?></th>
						<th><?php esc_html_e( 'Bien', 'murailles' ); ?></th>
						<th><?php esc_html_e( 'Catégorie', 'murailles' ); ?></th>
						<th><?php esc_html_e( 'Prix', 'murailles' ); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ( $all_props as $prop ) :
					$pid      = $prop->ID;
					$checked  = in_array( $pid, $saved_ids, true ) ? 'checked' : '';
					$price    = get_post_meta( $pid, '_property_price', true );
					$cats     = wp_get_post_terms( $pid, 'property_category', array( 'fields' => 'names' ) );
					$cat_name = $cats ? implode( ', ', $cats ) : '—';
				?>
					<tr>
						<td style="text-align:center;">
							<input type="checkbox"
								name="murailles_affaires_du_mois[]"
								value="<?php echo esc_attr( $pid ); ?>"
								<?php echo $checked; ?>
							/>
						</td>
						<td>
							<strong><?php echo esc_html( get_the_title( $pid ) ); ?></strong><br>
							<small><a href="<?php echo esc_url( get_permalink( $pid ) ); ?>" target="_blank"><?php esc_html_e( 'Voir le bien', 'murailles' ); ?></a>
							&nbsp;|&nbsp;
							<a href="<?php echo esc_url( get_edit_post_link( $pid ) ); ?>"><?php esc_html_e( 'Modifier', 'murailles' ); ?></a></small>
						</td>
						<td><?php echo esc_html( $cat_name ); ?></td>
						<td><?php echo $price ? esc_html( $price ) . ' €' : '—'; ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<?php endif; ?>

			<?php submit_button( __( 'Enregistrer la sélection', 'murailles' ) ); ?>
		</form>

		<?php if ( ! empty( $saved_ids ) ) : ?>
		<hr>
		<h2><?php esc_html_e( 'Biens actuellement sélectionnés', 'murailles' ); ?> (<?php echo count( $saved_ids ); ?>)</h2>
		<ul>
			<?php foreach ( $saved_ids as $sid ) : ?>
			<li><?php echo esc_html( get_the_title( $sid ) ); ?> — ID <?php echo esc_html( $sid ); ?></li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Enqueue the Slick carousel init script for the ADM section on the frontend.
 * Reuses the already-loaded slick.js — just inlines the init call.
 */
function murailles_adm_inline_carousel() {
	if ( ! is_front_page() ) {
		return;
	}
	$adm_ids = array_filter( array_map( 'intval', (array) get_option( 'murailles_affaires_du_mois', array() ) ) );
	if ( empty( $adm_ids ) ) {
		return;
	}
	wp_add_inline_script(
		'murailles-custom',
		"(function($){
			$(function(){
				$('[data-murailles-adm-carousel]').slick({
					dots: true,
					infinite: true,
					speed: 400,
					slidesToShow: 3,
					slidesToScroll: 1,
					autoplay: true,
					autoplaySpeed: 3500,
					responsive: [
						{ breakpoint: 1024, settings: { slidesToShow: 2 } },
						{ breakpoint: 640,  settings: { slidesToShow: 1 } }
					]
				});
			});
		}(jQuery));"
	);
}
add_action( 'wp_enqueue_scripts', 'murailles_adm_inline_carousel', 20 );
