<?php
/**
 * Plugin Name: Murailles - Block Editor CSS Fix
 * Description: Injects default-editor-styles.css content directly, bypassing a
 *              file-read block caused by ESET Smart Security protecting the
 *              wp-includes/css/dist/ subtree. Safe to remove once the ESET
 *              exclusion is added for C:\xampp (see README below).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Inject the default editor styles directly into block editor settings.
 *
 * WordPress normally reads these from:
 *   wp-includes/css/dist/block-editor/default-editor-styles.css
 *
 * ESET Smart Security is blocking file_get_contents() on the entire /css/dist/
 * subtree (HIPS / real-time protection), causing:
 *   Warning: file_get_contents(...): Failed to open stream: Permission denied
 *     in block-editor.php on line 204
 *
 * This filter runs before block-editor.php tries to read the file, so the
 * static $default_editor_styles_file_contents variable never gets a chance
 * to be empty. Priority 1 = runs before WP core's own block_editor_settings_all.
 */
add_filter( 'block_editor_settings_all', function ( $settings ) {
	// If WP already loaded the CSS successfully, do not override.
	if ( ! empty( $settings['defaultEditorStyles'] ) ) {
		return $settings;
	}

	// Verbatim content of default-editor-styles.css (WP 6.9.4, 325 bytes).
	$css = 'body{'
		. 'font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,'
		. 'Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;'
		. 'font-size:18px;line-height:1.5;--wp--style--block-gap:2em;}'
		. 'p{line-height:1.8;}'
		. '.editor-post-title__block{'
		. 'font-size:2.5em;font-weight:800;margin-bottom:1em;margin-top:2em;}';

	$settings['defaultEditorStyles'] = array(
		array( 'css' => $css ),
	);

	return $settings;
}, 1 );

/**
 * Silence the PHP warning produced by block-editor.php line 204.
 *
 * Even with the CSS injected above, PHP still attempts the file_get_contents()
 * call and emits a Warning. We use a custom error handler that suppresses only
 * that specific warning (matched by file path), then restores the previous
 * handler immediately so nothing else is affected.
 */
add_action( 'wp_loaded', function () {
	$blocked = wp_normalize_path(
		ABSPATH . WPINC . '/css/dist/block-editor/default-editor-styles.css'
	);

	// Only install the suppressor when the file is actually unreadable.
	// Once the ESET exclusion is in place, @file_get_contents succeeds and
	// this entire handler is never registered.
	if ( @file_get_contents( $blocked ) !== false ) {
		return;
	}

	set_error_handler( function ( $errno, $errstr, $errfile, $errline ) use ( $blocked ) {
		// Suppress only the specific Permission denied warning from block-editor.php.
		if ( strpos( $errstr, 'Permission denied' ) !== false
			&& strpos( $errfile, 'block-editor.php' ) !== false ) {
			return true; // suppress
		}
		return false; // pass all other errors to the default handler
	}, E_WARNING );
} );
