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
require_once get_template_directory() . '/inc/page-editor.php';
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

	// Block editor compatibility for pages that use Gutenberg for freeform
	// content in addition to template-controlled sections.
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_editor_style( 'assets/css/editor-admin.css' );

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
	add_post_type_support('agent', 'elementor');
}
add_action('after_setup_theme', 'murailles_theme_setup');

/**
 * Force the bare site root to the default Polylang language.
 *
 * Some installs keep serving the last `pll_language` cookie on `/`, which
 * opens the English homepage even though French is the default language. The
 * expected behavior for this theme is: `/` resolves to the default language,
 * while translated homes live under `/fr/` and `/en/`.
 */
function murailles_force_default_language_home() {
	if ( is_admin() || wp_doing_ajax() || ! function_exists( 'pll_default_language' ) ) {
		return;
	}

	$request_path = isset( $_SERVER['REQUEST_URI'] )
		? (string) wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH )
		: '';

	$home_path = (string) wp_parse_url( get_option( 'home' ), PHP_URL_PATH );
	$home_path = rtrim( $home_path, '/' );

	$normalized_request = rtrim( $request_path, '/' );
	if ( '' === $normalized_request ) {
		$normalized_request = '/';
	}
	if ( '' === $home_path ) {
		$home_path = '/';
	}

	if ( $normalized_request !== $home_path ) {
		return;
	}

	$default_lang = pll_default_language( 'slug' );
	if ( ! $default_lang ) {
		return;
	}

	$target = function_exists( 'pll_home_url' ) ? pll_home_url( $default_lang ) : '';
	if ( ! $target ) {
		$target = rtrim( get_option( 'home' ), '/' ) . '/' . $default_lang . '/';
	}
	if ( ! empty( $_SERVER['QUERY_STRING'] ) ) {
		$target .= '?' . ltrim( (string) wp_unslash( $_SERVER['QUERY_STRING'] ), '?' );
	}

	if ( ! headers_sent() ) {
		setcookie( 'pll_language', $default_lang, time() + YEAR_IN_SECONDS, COOKIEPATH ?: '/', COOKIE_DOMAIN );
		$_COOKIE['pll_language'] = $default_lang;
	}

	$target_path = (string) wp_parse_url( $target, PHP_URL_PATH );
	$target_path = rtrim( $target_path, '/' );
	if ( '' === $target_path ) {
		$target_path = '/';
	}

	if ( $target_path === $home_path ) {
		$current_lang = function_exists( 'pll_current_language' ) ? pll_current_language( 'slug' ) : '';
		if ( $current_lang && $current_lang !== $default_lang ) {
			wp_safe_redirect( $target, 302, 'murailles-default-language-home' );
			exit;
		}
		return;
	}

	wp_safe_redirect( $target, 302, 'murailles-default-language-home' );
	exit;
}
add_action( 'template_redirect', 'murailles_force_default_language_home', 0 );

function murailles_front_page_id_for_language( $lang = '' ) {
	$front_id = (int) get_option( 'page_on_front' );
	if ( ! $front_id ) {
		return 0;
	}

	if ( ! $lang || ! function_exists( 'pll_get_post_translations' ) ) {
		return $front_id;
	}

	$current_lang = function_exists( 'pll_get_post_language' ) ? pll_get_post_language( $front_id, 'slug' ) : '';
	if ( $current_lang === $lang ) {
		return $front_id;
	}

	$translations = pll_get_post_translations( $front_id );
	if ( ! empty( $translations[ $lang ] ) ) {
		return (int) $translations[ $lang ];
	}

	return $front_id;
}

function murailles_detect_language_root_request() {
	if ( is_admin() ) {
		return '';
	}

	$request_path = isset( $_SERVER['REQUEST_URI'] )
		? (string) wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH )
		: '';
	if ( '' === $request_path ) {
		return '';
	}

	$normalized = trim( $request_path, '/' );
	if ( '' === $normalized ) {
		return '';
	}

	$segments = explode( '/', $normalized );
	$home_path = trim( (string) wp_parse_url( get_option( 'home' ), PHP_URL_PATH ), '/' );
	if ( '' !== $home_path ) {
		$home_segments = explode( '/', $home_path );
		if ( $segments && $home_segments && $segments[0] === end( $home_segments ) ) {
			array_shift( $segments );
		}
	}

	if ( 1 !== count( $segments ) ) {
		return '';
	}

	$lang = sanitize_key( $segments[0] );
	if ( ! function_exists( 'pll_languages_list' ) ) {
		return in_array( $lang, array( 'fr', 'en' ), true ) ? $lang : '';
	}

	$languages = (array) pll_languages_list( array( 'fields' => 'slug' ) );
	return in_array( $lang, $languages, true ) ? $lang : '';
}

function murailles_bind_language_root_front_page( $wp ) {
	if ( ! $wp instanceof WP || empty( $wp->query_vars['lang'] ) ) {
		return;
	}

	$lang = murailles_detect_language_root_request();
	if ( ! $lang ) {
		return;
	}

	$front_id = murailles_front_page_id_for_language( $lang );
	if ( ! $front_id ) {
		return;
	}

	$wp->query_vars['page_id'] = $front_id;
	unset( $wp->query_vars['pagename'], $wp->query_vars['name'], $wp->query_vars['error'] );
	$wp->matched_query = 'lang=' . rawurlencode( $lang ) . '&page_id=' . $front_id;
}
add_action( 'parse_request', 'murailles_bind_language_root_front_page', 20 );

function murailles_request_language_root_front_page( $query_vars ) {
	$lang = murailles_detect_language_root_request();
	if ( ! $lang ) {
		return $query_vars;
	}

	$front_id = murailles_front_page_id_for_language( $lang );
	if ( ! $front_id ) {
		return $query_vars;
	}

	$query_vars['lang']    = $lang;
	$query_vars['page_id'] = $front_id;
	unset( $query_vars['pagename'], $query_vars['name'], $query_vars['error'] );

	return $query_vars;
}
add_filter( 'request', 'murailles_request_language_root_front_page', 20 );

function murailles_rescue_language_root_404( $preempt, $wp_query ) {
	if ( ! $wp_query instanceof WP_Query ) {
		return $preempt;
	}

	$lang = murailles_detect_language_root_request();
	if ( ! $lang ) {
		return $preempt;
	}

	if ( $wp_query->is_front_page() || $wp_query->is_page() ) {
		return $preempt;
	}

	$front_id   = murailles_front_page_id_for_language( $lang );
	$front_post = $front_id ? get_post( $front_id ) : null;
	if ( ! $front_post || 'page' !== $front_post->post_type ) {
		return $preempt;
	}

	$wp_query->posts             = array( $front_post );
	$wp_query->post              = $front_post;
	$wp_query->queried_object    = $front_post;
	$wp_query->queried_object_id = $front_post->ID;
	$wp_query->found_posts       = 1;
	$wp_query->post_count        = 1;
	$wp_query->max_num_pages     = 1;
	$wp_query->is_404            = false;
	$wp_query->is_page           = true;
	$wp_query->is_singular       = true;
	$wp_query->is_home           = false;
	$wp_query->is_front_page     = true;

	if ( ! headers_sent() ) {
		status_header( 200 );
	}

	global $post;
	$post = $front_post;

	return true;
}
add_filter( 'pre_handle_404', 'murailles_rescue_language_root_404', 10, 2 );

/**
 * Enqueue Styles
 */
function murailles_page_uses_advanced_filters() {
	return is_front_page()
		|| is_post_type_archive( 'property' )
		|| is_tax( array( 'property_category', 'property_location', 'property_area' ) )
		|| is_singular( 'property' );
}

/**
 * Determine whether the current request needs the property submission assets.
 *
 * @return bool
 */
function murailles_page_uses_submission_assets() {
	return is_page_template( 'page-templates/submit-property.php' );
}

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
	$uses_advanced_filters = murailles_page_uses_advanced_filters();
	$uses_submission_assets = murailles_page_uses_submission_assets();

	// Use WordPress's bundled jQuery so Elementor, Royal Elementor Addons, and
	// all admin scripts get the handle they expect in <head>. The theme's own
	// jQuery file (3.6.0) is kept in /assets/js/ but is no longer served to
	// avoid the in_footer conflict that breaks Elementor widget initialisation.

	// Popper.js (required by Bootstrap)
	wp_enqueue_script('murailles-popper', $theme_uri . '/assets/js/popper.min.js', array('jquery'), $ver, true);

	// Bootstrap JS
	wp_enqueue_script('murailles-bootstrap', $theme_uri . '/assets/js/bootstrap.min.js', array('jquery', 'murailles-popper'), $ver, true);

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

	if ( $uses_advanced_filters ) {
		wp_enqueue_script('murailles-rangeslider', $theme_uri . '/assets/js/ion.rangeSlider.min.js', array('jquery'), $ver, true);
	}

	if ( $uses_submission_assets ) {
		wp_enqueue_script('murailles-daterangepicker', $theme_uri . '/assets/js/daterangepicker.js', array('jquery'), $ver, true);
		wp_enqueue_script('murailles-dropzone', $theme_uri . '/assets/js/dropzone.js', array('jquery'), $ver, true);
	}

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
	if ( $uses_submission_assets ) {
		wp_enqueue_script('murailles-uploader', $theme_uri . '/assets/js/murailles-uploader.js', array(), $uploader_js_ver, true);
	}

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
if ( ! function_exists( 'murailles_bien_url' ) ) {
	function murailles_bien_url() {
		$url = get_post_type_archive_link( 'property' );
		return $url ? $url : home_url( '/bien/' );
	}
}

/**
 * Render the current page's saved editor content inside otherwise static
 * templates so WPBakery, shortcodes, and core blocks still output normally.
 */
function murailles_render_page_builder_content() {
	if ( ! is_singular( 'page' ) ) {
		return;
	}

	global $post;

	$page = get_queried_object();
	if ( ! ( $page instanceof WP_Post ) || 'page' !== $page->post_type ) {
		return;
	}

	$content = get_post_field( 'post_content', $page );
	if ( ! is_string( $content ) || '' === trim( $content ) ) {
		return;
	}

	$post = $page;
	setup_postdata( $post );
	?>
	<section class="murailles-page-builder-content">
		<div class="article-content">
			<?php echo apply_filters( 'the_content', $content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	</section>
	<?php
	wp_reset_postdata();
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

function murailles_find_seed_page( $slug, $lang = '', $title = '' ) {
	global $wpdb;

	$candidates = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT ID FROM {$wpdb->posts}
			WHERE post_type = 'page'
				AND post_status IN ('publish', 'draft', 'private')
				AND ( post_name = %s OR post_title = %s )
			ORDER BY ID ASC",
			$slug,
			$title
		)
	);

	if ( empty( $candidates ) ) {
		return null;
	}

	foreach ( $candidates as $candidate ) {
		$post = get_post( (int) $candidate->ID );
		if ( ! $post ) {
			continue;
		}

		if ( '' === $lang || ! function_exists( 'pll_get_post_language' ) ) {
			return $post;
		}

		if ( pll_get_post_language( $post->ID, 'slug' ) === $lang ) {
			return $post;
		}
	}

	return null;
}

function murailles_copy_seed_page_data( $target_id, $source_id ) {
	if ( ! $target_id || ! $source_id || $target_id === $source_id ) {
		return;
	}

	$source = get_post( $source_id );
	if ( ! $source ) {
		return;
	}

	wp_update_post(
		array(
			'ID'           => $target_id,
			'post_content' => $source->post_content,
			'post_excerpt' => $source->post_excerpt,
		)
	);

	$thumb_id = get_post_thumbnail_id( $source_id );
	if ( $thumb_id ) {
		set_post_thumbnail( $target_id, $thumb_id );
	}

	$meta_keys = array(
		'_wp_page_template',
		'murailles_page_sections',
		'_yoast_wpseo_title',
		'_yoast_wpseo_metadesc',
		'_yoast_wpseo_focuskw',
		'_yoast_wpseo_canonical',
	);

	foreach ( $meta_keys as $meta_key ) {
		$value = get_post_meta( $source_id, $meta_key, true );
		if ( '' !== $value && null !== $value ) {
			update_post_meta( $target_id, $meta_key, $value );
		}
	}
}

/**
 * Auto-create all WordPress pages with correct templates on theme activation.
 * This maps every page template to a WordPress page so all navigation links work.
 */
function murailles_create_pages_legacy( $force = false )
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

function murailles_create_pages( $force = false, $repair_existing = false )
{
	if ( ! $force && get_option( 'murailles_pages_created' ) ) {
		return;
	}

	$pages = array(
		'home'                      => array( 'title' => 'Home', 'template' => '', 'titles' => array( 'fr' => 'Accueil', 'en' => 'Home' ) ),
		'about-us'                  => array( 'title' => 'About Us', 'template' => 'page-templates/about-us.php', 'titles' => array( 'fr' => 'A propos', 'en' => 'About Us' ) ),
		'contact'                   => array( 'title' => 'Contact', 'template' => 'page-templates/contact.php', 'titles' => array( 'fr' => 'Contact', 'en' => 'Contact' ) ),
		'blog'                      => array( 'title' => 'Blog', 'template' => '', 'titles' => array( 'fr' => 'Blog', 'en' => 'Blog' ) ),
		'faq'                       => array( 'title' => 'FAQ', 'template' => 'page-templates/faq.php' ),
		'pricing'                   => array( 'title' => 'Pricing', 'template' => 'page-templates/pricing.php' ),
		'privacy'                   => array( 'title' => 'Politique de confidentialite', 'template' => 'page-templates/privacy.php', 'titles' => array( 'fr' => 'Politique de confidentialite', 'en' => 'Privacy Policy' ) ),
		'conditions-generales'      => array( 'title' => 'Conditions generales', 'template' => 'page-templates/terms.php', 'titles' => array( 'fr' => 'Conditions generales', 'en' => 'Terms and Conditions' ) ),
		'checkout'                  => array( 'title' => 'Checkout', 'template' => 'page-templates/checkout.php' ),
		'component'                 => array( 'title' => 'Components', 'template' => 'page-templates/component.php' ),
		'dashboard'                 => array( 'title' => 'Dashboard', 'template' => 'page-templates/dashboard.php' ),
		'my-profile'                => array( 'title' => 'My Profile', 'template' => 'page-templates/my-profile.php' ),
		'my-property'               => array( 'title' => 'My Property', 'template' => 'page-templates/my-property.php' ),
		'messages'                  => array( 'title' => 'Messages', 'template' => 'page-templates/messages.php' ),
		'bookmark-list'             => array( 'title' => 'Bookmark List', 'template' => 'page-templates/bookmark-list.php' ),
		'favoris'                   => array( 'title' => 'Mes favoris', 'template' => 'page-templates/favoris.php', 'titles' => array( 'fr' => 'Mes favoris', 'en' => 'My Favourites' ) ),
		'submit-property'           => array( 'title' => 'Submit Property', 'template' => 'page-templates/submit-property.php', 'titles' => array( 'fr' => 'Deposer une annonce', 'en' => 'Submit Property' ) ),
		'compare-property'          => array( 'title' => 'Compare Property', 'template' => 'page-templates/compare-property.php' ),
		'single-property-1'         => array( 'title' => 'Single Property 1', 'template' => 'page-templates/single-property-1.php' ),
		'single-property-2'         => array( 'title' => 'Single Property 2', 'template' => 'page-templates/single-property-2.php' ),
		'single-property-3'         => array( 'title' => 'Single Property 3', 'template' => 'page-templates/single-property-3.php' ),
		'single-property-4'         => array( 'title' => 'Single Property 4', 'template' => 'page-templates/single-property-4.php' ),
		'agents'                    => array( 'title' => 'Agents', 'template' => 'page-templates/agents.php' ),
		'agents-2'                  => array( 'title' => 'Agents Grid 2', 'template' => 'page-templates/agents-2.php' ),
		'agent-page'                => array( 'title' => 'Agent Detail', 'template' => 'page-templates/agent-page.php' ),
		'agencies'                  => array( 'title' => 'Agencies', 'template' => 'page-templates/agencies.php' ),
		'agency-page'               => array( 'title' => 'Agency Detail', 'template' => 'page-templates/agency-page.php' ),
		'grid-layout-with-sidebar'  => array( 'title' => 'Grid Layout With Sidebar', 'template' => 'page-templates/grid-layout-with-sidebar.php' ),
		'grid-layout-2'             => array( 'title' => 'Grid Layout 2', 'template' => 'page-templates/grid-layout-2.php' ),
		'grid-layout-3'             => array( 'title' => 'Grid Layout 3', 'template' => 'page-templates/grid-layout-3.php' ),
		'grid-layout-with-map'      => array( 'title' => 'Grid Layout With Map', 'template' => 'page-templates/grid-layout-with-map.php' ),
		'list-layout-with-sidebar'  => array( 'title' => 'List Layout With Sidebar', 'template' => 'page-templates/list-layout-with-sidebar.php' ),
		'list-layout-with-map'      => array( 'title' => 'List Layout With Map', 'template' => 'page-templates/list-layout-with-map.php' ),
		'list-layout-with-map-2'    => array( 'title' => 'List Layout With Map 2', 'template' => 'page-templates/list-layout-with-map-2.php' ),
		'classical-layout-with-map' => array( 'title' => 'Classical Layout With Map', 'template' => 'page-templates/classical-layout-with-map.php' ),
		'half-map'                  => array( 'title' => 'Half Map', 'template' => 'page-templates/half-map.php' ),
		'half-map-2'                => array( 'title' => 'Half Map 2', 'template' => 'page-templates/half-map-2.php' ),
		'map-home'                  => array( 'title' => 'Map Home', 'template' => 'page-templates/map.php' ),
		'home-2'                    => array( 'title' => 'Home 2', 'template' => 'page-templates/home-2.php' ),
		'home-3'                    => array( 'title' => 'Home 3', 'template' => 'page-templates/home-3.php' ),
		'home-4'                    => array( 'title' => 'Home 4', 'template' => 'page-templates/home-4.php' ),
		'home-5'                    => array( 'title' => 'Home 5', 'template' => 'page-templates/home-5.php' ),
		'home-6'                    => array( 'title' => 'Home 6', 'template' => 'page-templates/home-6.php' ),
		'home-7'                    => array( 'title' => 'Home 7', 'template' => 'page-templates/home-7.php' ),
		'nos-services'              => array( 'title' => 'Nos Services', 'template' => 'page-templates/nos-services.php', 'titles' => array( 'fr' => 'Nos Services', 'en' => 'Our Services' ) ),
		'assistance-conseils'       => array( 'title' => 'Assistance & Conseils', 'template' => 'page-templates/assistance-conseils.php', 'titles' => array( 'fr' => 'Assistance & Conseils', 'en' => 'Assistance & Advice' ) ),
		'histoire-marrakech'        => array( 'title' => 'Histoire de Marrakech', 'template' => 'page-templates/histoire-marrakech.php', 'titles' => array( 'fr' => 'Histoire de Marrakech', 'en' => 'History of Marrakech' ) ),
		'tourisme-marrakech'        => array( 'title' => 'Tourisme a Marrakech', 'template' => 'page-templates/tourisme-marrakech.php', 'titles' => array( 'fr' => 'Tourisme a Marrakech', 'en' => 'Tourism in Marrakech' ) ),
		'erreur'                    => array( 'title' => 'Erreur', 'template' => 'page-templates/error.php', 'titles' => array( 'fr' => 'Erreur', 'en' => 'Error' ) ),
	);

	$default_lang    = function_exists( 'pll_default_language' ) ? pll_default_language( 'slug' ) : '';
	$available_langs = function_exists( 'pll_languages_list' ) ? pll_languages_list( array( 'fields' => 'slug' ) ) : array();
	$source_lang     = in_array( 'fr', $available_langs, true ) ? 'fr' : $default_lang;
	$english_lang    = in_array( 'en', $available_langs, true ) && 'en' !== $source_lang ? 'en' : '';
	$home_page_id    = 0;
	$blog_page_id    = 0;

	foreach ( $pages as $slug => $data ) {
		$title       = $data['title'];
		$template    = $data['template'];
		$lang_titles = isset( $data['titles'] ) ? $data['titles'] : array();

		if ( ! $source_lang || ! function_exists( 'pll_set_post_language' ) || ! function_exists( 'pll_save_post_translations' ) ) {
			$existing = get_page_by_path( $slug );
			$created  = false;
			if ( ! $existing ) {
				$page_id = wp_insert_post(
					array(
						'post_title'   => $title,
						'post_name'    => $slug,
						'post_status'  => 'publish',
						'post_type'    => 'page',
						'post_content' => '',
					)
				);
				$existing = ( $page_id && ! is_wp_error( $page_id ) ) ? get_post( $page_id ) : null;
				$created  = (bool) $existing;
			}

			if ( $existing && $template && ( $created || $repair_existing ) ) {
				update_post_meta( $existing->ID, '_wp_page_template', $template );
			}

			if ( $existing && 'home' === $slug ) {
				$home_page_id = (int) $existing->ID;
			}

			if ( $existing && 'blog' === $slug ) {
				$blog_page_id = (int) $existing->ID;
			}

			continue;
		}

		$default_title = isset( $lang_titles[ $source_lang ] ) ? $lang_titles[ $source_lang ] : $title;
		$default_page  = murailles_find_seed_page( $slug, $source_lang, $default_title );
		$english_title = isset( $lang_titles['en'] ) ? $lang_titles['en'] : $title;
		$english_page  = $english_lang ? murailles_find_seed_page( $slug, $english_lang, $english_title ) : null;
		$default_created = false;
		$english_created = false;

		if ( ! $default_page && $english_page && function_exists( 'pll_get_post_translations' ) ) {
			$translations = pll_get_post_translations( $english_page->ID );
			if ( ! empty( $translations[ $source_lang ] ) ) {
				$default_page = get_post( (int) $translations[ $source_lang ] );
			}
		}

		if ( ! $english_page && $default_page && function_exists( 'pll_get_post_translations' ) && $english_lang ) {
			$translations = pll_get_post_translations( $default_page->ID );
			if ( ! empty( $translations[ $english_lang ] ) ) {
				$english_page = get_post( (int) $translations[ $english_lang ] );
			}
		}

		if ( ! $default_page ) {
			$default_id = wp_insert_post(
				array(
					'post_title'   => $default_title,
					'post_name'    => $slug,
					'post_status'  => 'publish',
					'post_type'    => 'page',
					'post_content' => $english_page ? $english_page->post_content : '',
					'post_excerpt' => $english_page ? $english_page->post_excerpt : '',
				)
			);

			if ( $default_id && ! is_wp_error( $default_id ) ) {
				pll_set_post_language( $default_id, $source_lang );
				$default_page = get_post( $default_id );
				$default_created = (bool) $default_page;
				if ( $english_page ) {
					murailles_copy_seed_page_data( $default_id, $english_page->ID );
				}
			}
		}

		if ( $default_page && $template && ( $default_created || $repair_existing ) ) {
			update_post_meta( $default_page->ID, '_wp_page_template', $template );
		}

		if ( $english_lang && ! $english_page ) {
			$english_id = wp_insert_post(
				array(
					'post_title'   => $english_title,
					'post_name'    => $slug,
					'post_status'  => 'publish',
					'post_type'    => 'page',
					'post_content' => $default_page ? $default_page->post_content : '',
					'post_excerpt' => $default_page ? $default_page->post_excerpt : '',
				)
			);

			if ( $english_id && ! is_wp_error( $english_id ) ) {
				pll_set_post_language( $english_id, $english_lang );
				$english_page = get_post( $english_id );
				$english_created = (bool) $english_page;
				if ( $default_page ) {
					murailles_copy_seed_page_data( $english_id, $default_page->ID );
				}
			}
		}

		if ( $english_page && $template && ( $english_created || $repair_existing ) ) {
			update_post_meta( $english_page->ID, '_wp_page_template', $template );
		}

		if ( $default_page && $english_page && $english_lang && ( $repair_existing || $default_created || $english_created ) ) {
			pll_save_post_translations(
				array(
					$source_lang  => (int) $default_page->ID,
					$english_lang => (int) $english_page->ID,
				)
			);
		}

		if ( 'home' === $slug && $default_page ) {
			$home_page_id = (int) $default_page->ID;
		}

		if ( 'blog' === $slug && $default_page ) {
			$blog_page_id = (int) $default_page->ID;
		}
	}

	if ( $home_page_id ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_page_id );
	}

	if ( $blog_page_id ) {
		update_option( 'page_for_posts', $blog_page_id );
	}

	global $wp_rewrite;
	$wp_rewrite->set_permalink_structure( '/%postname%/' );
	$wp_rewrite->flush_rules( false );

	update_option( 'murailles_pages_created', true );
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
 * Return all active plugin basenames, including network-active plugins.
 *
 * @return string[]
 */
function murailles_get_active_plugin_basenames() {
	$plugins = (array) get_option( 'active_plugins', array() );

	if ( is_multisite() ) {
		$network_plugins = array_keys( (array) get_site_option( 'active_sitewide_plugins', array() ) );
		$plugins         = array_merge( $plugins, $network_plugins );
	}

	return array_values( array_unique( array_filter( array_map( 'strval', $plugins ) ) ) );
}

/**
 * Determine whether the current site should be treated as production-like.
 *
 * Local/dev URLs containing localhost, .local or .test are treated as safe.
 * A defined WP_ENVIRONMENT_TYPE=production always forces production mode.
 *
 * @return bool
 */
function murailles_is_production_like_environment() {
	if ( defined( 'WP_ENVIRONMENT_TYPE' ) && 'production' === WP_ENVIRONMENT_TYPE ) {
		return true;
	}

	$url  = home_url( '/' );
	$host = (string) wp_parse_url( $url, PHP_URL_HOST );
	$host = strtolower( trim( $host ) );

	if ( '' === $host ) {
		return false;
	}

	$local_hosts = array(
		'localhost',
		'127.0.0.1',
		'::1',
	);

	if ( in_array( $host, $local_hosts, true ) ) {
		return false;
	}

	if ( str_ends_with( $host, '.local' ) || str_ends_with( $host, '.test' ) ) {
		return false;
	}

	return true;
}

/**
 * Show a strong admin warning if Novamira MCP is active on production.
 *
 * Novamira allows PHP execution and filesystem operations and must remain
 * limited to development/staging environments.
 *
 * @return void
 */
function murailles_novamira_production_notice() {
	if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( ! murailles_is_production_like_environment() ) {
		return;
	}

	$active_plugins = murailles_get_active_plugin_basenames();
	if ( ! in_array( 'novamira/novamira.php', $active_plugins, true ) ) {
		return;
	}

	echo '<div class="notice notice-error"><p><strong>Novamira MCP is active.</strong> This plugin allows PHP execution and filesystem operations and should only be used on development/staging environments.</p></div>';
}
add_action( 'admin_notices', 'murailles_novamira_production_notice' );

/**
 * admin-post.php handlers — each runs, sets a transient for the success notice,
 * then redirects back to wherever the admin was (no blank page, no double-submit).
 */
function murailles_handle_create_pages() {
	if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'murailles_create_pages' ) ) {
		wp_die( 'Accès refusé.' );
	}
	murailles_create_pages( false, false );
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
	murailles_create_pages( true, true );
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
		<<<'JS'
(function($){
			$(function(){
				var $carousel = $('[data-murailles-adm-carousel]');
				if (!$carousel.length) { return; }
				function tuneAdmCarousel() {
					if (!$carousel.hasClass('slick-initialized')) {
						setTimeout(tuneAdmCarousel, 80);
						return;
					}
					$carousel.slick('slickSetOption', {
						dots: true,
						arrows: true,
						slidesToShow: 3,
						slidesToScroll: 1,
						autoplay: true,
						autoplaySpeed: 3500,
						responsive: [
							{ breakpoint: 1024, settings: { slidesToShow: 2, slidesToScroll: 1 } },
							{ breakpoint: 640,  settings: { slidesToShow: 1, slidesToScroll: 1 } }
						]
					}, true);
				}
				tuneAdmCarousel();
			});
		}(jQuery));
JS
	);
}
add_action( 'wp_enqueue_scripts', 'murailles_adm_inline_carousel', 20 );
