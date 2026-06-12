<?php
/**
 * Page editor bridge for template-driven pages.
 *
 * Hardcoded page templates remain in full control of the frontend markup, but
 * their key texts and images become editable from the page editor via
 * per-page post meta. This keeps Polylang translations isolated because each
 * translated page stores its own meta values.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return the meta-box configuration for supported page templates.
 */
function murailles_page_editor_config() {
	return array(
		'front-page' => array(
			'label'    => __( 'Homepage Sections', 'murailles' ),
			'sections' => array(
				array(
					'title'  => __( 'Hero', 'murailles' ),
					'fields' => array(
						array( 'key' => 'hero_bg_image_id', 'label' => __( 'Hero background image', 'murailles' ), 'type' => 'image' ),
						array( 'key' => 'hero_title', 'label' => __( 'Hero title', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'hero_subtitle', 'label' => __( 'Hero subtitle', 'murailles' ), 'type' => 'textarea' ),
					),
				),
			),
		),
		'page-templates/about-us.php' => array(
			'label'    => __( 'About Us Sections', 'murailles' ),
			'sections' => array(
				array(
					'title'  => __( 'Hero', 'murailles' ),
					'fields' => array(
						array( 'key' => 'hero_bg_image_id', 'label' => __( 'Hero background image', 'murailles' ), 'type' => 'image' ),
						array( 'key' => 'hero_title', 'label' => __( 'Hero title', 'murailles' ), 'type' => 'text' ),
					),
				),
				array(
					'title'  => __( 'Agency Story', 'murailles' ),
					'fields' => array(
						array( 'key' => 'story_title', 'label' => __( 'Story heading', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'story_subtitle', 'label' => __( 'Story subtitle', 'murailles' ), 'type' => 'textarea' ),
						array( 'key' => 'story_text_1', 'label' => __( 'Story paragraph 1', 'murailles' ), 'type' => 'textarea' ),
						array( 'key' => 'story_text_2', 'label' => __( 'Story paragraph 2', 'murailles' ), 'type' => 'textarea' ),
						array( 'key' => 'story_button_label', 'label' => __( 'Story button label', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'story_button_url', 'label' => __( 'Story button URL', 'murailles' ), 'type' => 'url' ),
						array( 'key' => 'story_image_id', 'label' => __( 'Story image', 'murailles' ), 'type' => 'image' ),
					),
				),
				array(
					'title'  => __( 'Team section', 'murailles' ),
					'fields' => array(
						array( 'key' => 'team_heading', 'label' => __( 'Team heading', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'team_subheading', 'label' => __( 'Team subheading', 'murailles' ), 'type' => 'textarea' ),
					),
				),
			),
		),
		'page-templates/contact.php' => array(
			'label'    => __( 'Contact Sections', 'murailles' ),
			'sections' => array(
				array(
					'title'  => __( 'Hero', 'murailles' ),
					'fields' => array(
						array( 'key' => 'hero_bg_image_id', 'label' => __( 'Hero background image', 'murailles' ), 'type' => 'image' ),
						array( 'key' => 'hero_eyebrow', 'label' => __( 'Hero eyebrow', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'hero_title', 'label' => __( 'Hero title', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'hero_subtitle', 'label' => __( 'Hero subtitle', 'murailles' ), 'type' => 'textarea' ),
					),
				),
				array(
					'title'  => __( 'Contact Cards', 'murailles' ),
					'fields' => array(
						array( 'key' => 'phone_label', 'label' => __( 'Phone label', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'phone_value', 'label' => __( 'Phone value', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'phone_note', 'label' => __( 'Phone note', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'email_label', 'label' => __( 'Email label', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'email_value', 'label' => __( 'Email value', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'email_note', 'label' => __( 'Email note', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'address_label', 'label' => __( 'Address label', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'address_line_1', 'label' => __( 'Address line 1', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'address_line_2', 'label' => __( 'Address line 2', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'map_embed_url', 'label' => __( 'Google Maps embed URL', 'murailles' ), 'type' => 'url' ),
					),
				),
			),
		),
		'page-templates/nos-services.php' => array(
			'label'    => __( 'Nos Services Sections', 'murailles' ),
			'sections' => array(
				array(
					'title'  => __( 'Hero', 'murailles' ),
					'fields' => array(
						array( 'key' => 'hero_bg_image_id', 'label' => __( 'Hero background image', 'murailles' ), 'type' => 'image' ),
						array( 'key' => 'hero_eyebrow', 'label' => __( 'Hero eyebrow', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'hero_title', 'label' => __( 'Hero title', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'hero_subtitle', 'label' => __( 'Hero subtitle', 'murailles' ), 'type' => 'textarea' ),
					),
				),
				array(
					'title'  => __( 'Intro', 'murailles' ),
					'fields' => array(
						array( 'key' => 'intro_eyebrow', 'label' => __( 'Intro eyebrow', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'intro_title', 'label' => __( 'Intro title', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'intro_text', 'label' => __( 'Intro text', 'murailles' ), 'type' => 'textarea' ),
					),
				),
			),
		),
		'page-templates/assistance-conseils.php' => array(
			'label'    => __( 'Assistance & Conseils Sections', 'murailles' ),
			'sections' => array(
				array(
					'title'  => __( 'Hero', 'murailles' ),
					'fields' => array(
						array( 'key' => 'hero_bg_image_id', 'label' => __( 'Hero background image', 'murailles' ), 'type' => 'image' ),
						array( 'key' => 'hero_eyebrow', 'label' => __( 'Hero eyebrow', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'hero_title', 'label' => __( 'Hero title', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'hero_subtitle', 'label' => __( 'Hero subtitle', 'murailles' ), 'type' => 'textarea' ),
					),
				),
			),
		),
		'page-templates/histoire-marrakech.php' => array(
			'label'    => __( 'Histoire de Marrakech Sections', 'murailles' ),
			'sections' => array(
				array(
					'title'  => __( 'Hero', 'murailles' ),
					'fields' => array(
						array( 'key' => 'hero_bg_image_id', 'label' => __( 'Hero background image', 'murailles' ), 'type' => 'image' ),
						array( 'key' => 'hero_eyebrow', 'label' => __( 'Hero eyebrow', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'hero_title', 'label' => __( 'Hero title', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'hero_subtitle', 'label' => __( 'Hero subtitle', 'murailles' ), 'type' => 'textarea' ),
					),
				),
			),
		),
		'page-templates/tourisme-marrakech.php' => array(
			'label'    => __( 'Tourisme à Marrakech Sections', 'murailles' ),
			'sections' => array(
				array(
					'title'  => __( 'Hero', 'murailles' ),
					'fields' => array(
						array( 'key' => 'hero_bg_image_id', 'label' => __( 'Hero background image', 'murailles' ), 'type' => 'image' ),
						array( 'key' => 'hero_eyebrow', 'label' => __( 'Hero eyebrow', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'hero_title', 'label' => __( 'Hero title', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'hero_subtitle', 'label' => __( 'Hero subtitle', 'murailles' ), 'type' => 'textarea' ),
					),
				),
			),
		),
	);
}

/**
 * Determine which supported template config applies to a page.
 */
function murailles_page_editor_template_key( $post_id ) {
	$post_id = absint( $post_id );
	if ( ! $post_id || 'page' !== get_post_type( $post_id ) ) {
		return '';
	}

	$front_id = (int) get_option( 'page_on_front' );
	if ( $front_id === $post_id ) {
		return 'front-page';
	}

	if ( $front_id && function_exists( 'pll_get_post_translations' ) ) {
		$translations = pll_get_post_translations( $front_id );
		if ( in_array( $post_id, array_map( 'intval', (array) $translations ), true ) ) {
			return 'front-page';
		}
	}

	$template = get_page_template_slug( $post_id );
	return is_string( $template ) ? $template : '';
}

/**
 * Return the stored template sections array for a page.
 */
function murailles_page_sections_data( $post_id = 0 ) {
	static $cache = array();

	$post_id = $post_id ? absint( $post_id ) : get_the_ID();
	if ( ! $post_id ) {
		return array();
	}

	if ( isset( $cache[ $post_id ] ) ) {
		return $cache[ $post_id ];
	}

	$data = get_post_meta( $post_id, '_murailles_page_sections', true );
	$cache[ $post_id ] = is_array( $data ) ? $data : array();
	return $cache[ $post_id ];
}

/**
 * Read one template-controlled field with a safe fallback.
 */
function murailles_page_section_meta( $field, $default = '', $post_id = 0 ) {
	$data = murailles_page_sections_data( $post_id );
	return isset( $data[ $field ] ) && '' !== $data[ $field ] ? $data[ $field ] : $default;
}

/**
 * Resolve an attachment ID field for a page section, with optional fallback to
 * the page featured image.
 */
function murailles_page_section_image_id( $field, $post_id = 0, $allow_featured_image = false ) {
	$image_id = absint( murailles_page_section_meta( $field, 0, $post_id ) );
	if ( $image_id ) {
		return $image_id;
	}

	$post_id = $post_id ? absint( $post_id ) : get_the_ID();
	if ( $allow_featured_image && $post_id && has_post_thumbnail( $post_id ) ) {
		return (int) get_post_thumbnail_id( $post_id );
	}

	return 0;
}

/**
 * Resolve the URL for a template-controlled image field.
 */
function murailles_page_section_image_url( $field, $fallback_url, $post_id = 0, $allow_featured_image = false, $size = 'full' ) {
	$image_id = murailles_page_section_image_id( $field, $post_id, $allow_featured_image );
	if ( ! $image_id ) {
		return $fallback_url;
	}

	$url = wp_get_attachment_image_url( $image_id, $size );
	return $url ? $url : $fallback_url;
}

/**
 * Render an inline <img> for a template-controlled attachment with fallback.
 */
function murailles_page_section_image( $field, $fallback_url, $attrs = array(), $post_id = 0, $allow_featured_image = false, $size = 'full' ) {
	$image_id = murailles_page_section_image_id( $field, $post_id, $allow_featured_image );
	if ( $image_id ) {
		return wp_get_attachment_image( $image_id, $size, false, $attrs );
	}

	$html_attrs = '';
	foreach ( (array) $attrs as $name => $value ) {
		if ( null === $value || '' === $value ) {
			continue;
		}
		$html_attrs .= sprintf( ' %s="%s"', esc_attr( $name ), esc_attr( $value ) );
	}

	return sprintf( '<img src="%s"%s />', esc_url( $fallback_url ), $html_attrs );
}

/**
 * Add a contextual explanation above the editor for template-driven pages.
 */
function murailles_page_editor_notice( $post ) {
	if ( ! $post instanceof WP_Post || 'page' !== $post->post_type ) {
		return;
	}

	$template_key = murailles_page_editor_template_key( $post->ID );
	$config       = murailles_page_editor_config();

	if ( ! $template_key || empty( $config[ $template_key ] ) ) {
		return;
	}
	?>
	<div class="notice notice-info inline murailles-template-editor-note">
		<p><strong><?php esc_html_e( 'Template-driven page', 'murailles' ); ?></strong></p>
		<p><?php esc_html_e( 'This page keeps its frontend layout in the theme template. Use the “Template Sections” box below to edit the built-in texts and images. Use the main block editor for optional extra content rendered after the static layout.', 'murailles' ); ?></p>
	</div>
	<?php
}
add_action( 'edit_form_after_title', 'murailles_page_editor_notice' );

/**
 * Register the template sections meta box for supported page templates.
 */
function murailles_page_editor_add_meta_box() {
	add_meta_box(
		'murailles-page-sections',
		__( 'Template Sections', 'murailles' ),
		'murailles_page_editor_render_meta_box',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes_page', 'murailles_page_editor_add_meta_box' );

/**
 * Enqueue the media bridge for the page editor.
 */
function murailles_page_editor_assets( $hook ) {
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}

	$screen = get_current_screen();
	if ( ! $screen || 'page' !== $screen->post_type ) {
		return;
	}

	wp_enqueue_media();
	wp_enqueue_style(
		'murailles-editor-admin',
		get_template_directory_uri() . '/assets/css/editor-admin.css',
		array(),
		wp_get_theme()->get( 'Version' )
	);
	wp_enqueue_script(
		'murailles-editor-bridge',
		get_template_directory_uri() . '/assets/js/editor-bridge.js',
		array( 'jquery' ),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'admin_enqueue_scripts', 'murailles_page_editor_assets' );

/**
 * Render the supported template fields.
 */
function murailles_page_editor_render_meta_box( $post ) {
	$template_key = murailles_page_editor_template_key( $post->ID );
	$config       = murailles_page_editor_config();

	if ( ! $template_key || empty( $config[ $template_key ] ) ) {
		echo '<p>' . esc_html__( 'This page currently uses the standard editor only. Template-specific section controls appear here when the page uses a supported custom template or is assigned as the site homepage.', 'murailles' ) . '</p>';
		return;
	}

	wp_nonce_field( 'murailles_page_sections_save', 'murailles_page_sections_nonce' );
	$data = murailles_page_sections_data( $post->ID );
	?>
	<div class="murailles-page-sections-wrap">
		<?php foreach ( $config[ $template_key ]['sections'] as $section ) : ?>
			<div class="murailles-page-sections-group">
				<h3><?php echo esc_html( $section['title'] ); ?></h3>
				<table class="form-table" role="presentation">
					<tbody>
					<?php foreach ( $section['fields'] as $field ) : ?>
						<?php
						$key   = $field['key'];
						$type  = $field['type'];
						$value = isset( $data[ $key ] ) ? $data[ $key ] : '';
						?>
						<tr>
							<th scope="row"><label for="<?php echo esc_attr( 'murailles_' . $key ); ?>"><?php echo esc_html( $field['label'] ); ?></label></th>
							<td>
								<?php if ( 'image' === $type ) : ?>
									<?php $preview = $value ? wp_get_attachment_image_url( absint( $value ), 'medium' ) : ''; ?>
									<div class="murailles-media-field">
										<input type="hidden" name="murailles_page_sections[<?php echo esc_attr( $key ); ?>]" id="<?php echo esc_attr( 'murailles_' . $key ); ?>" value="<?php echo esc_attr( $value ); ?>" />
										<div class="murailles-media-preview<?php echo $preview ? '' : ' is-empty'; ?>">
											<?php if ( $preview ) : ?>
												<img src="<?php echo esc_url( $preview ); ?>" alt="" />
											<?php else : ?>
												<span><?php esc_html_e( 'No image selected. The frontend fallback image will be used.', 'murailles' ); ?></span>
											<?php endif; ?>
										</div>
										<div class="murailles-media-actions">
											<button type="button" class="button murailles-media-select" data-target="<?php echo esc_attr( 'murailles_' . $key ); ?>"><?php esc_html_e( 'Choose image', 'murailles' ); ?></button>
											<button type="button" class="button-link-delete murailles-media-clear<?php echo $preview ? '' : ' is-hidden'; ?>" data-target="<?php echo esc_attr( 'murailles_' . $key ); ?>"><?php esc_html_e( 'Remove', 'murailles' ); ?></button>
										</div>
									</div>
								<?php elseif ( 'textarea' === $type ) : ?>
									<textarea class="large-text" rows="4" name="murailles_page_sections[<?php echo esc_attr( $key ); ?>]" id="<?php echo esc_attr( 'murailles_' . $key ); ?>"><?php echo esc_textarea( $value ); ?></textarea>
								<?php else : ?>
									<input class="regular-text<?php echo 'url' === $type ? ' code' : ''; ?>" type="<?php echo esc_attr( $type ); ?>" name="murailles_page_sections[<?php echo esc_attr( $key ); ?>]" id="<?php echo esc_attr( 'murailles_' . $key ); ?>" value="<?php echo esc_attr( $value ); ?>" />
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		<?php endforeach; ?>
	</div>
	<?php
}

/**
 * Sanitize the submitted template sections data for one page.
 */
function murailles_page_editor_sanitize_sections( $raw_sections, $template_key ) {
	$config = murailles_page_editor_config();
	if ( empty( $config[ $template_key ] ) || ! is_array( $raw_sections ) ) {
		return array();
	}

	$clean = array();
	foreach ( $config[ $template_key ]['sections'] as $section ) {
		foreach ( $section['fields'] as $field ) {
			$key = $field['key'];
			if ( ! array_key_exists( $key, $raw_sections ) ) {
				continue;
			}

			$value = $raw_sections[ $key ];
			switch ( $field['type'] ) {
				case 'image':
					$clean[ $key ] = absint( $value );
					break;
				case 'url':
					$clean[ $key ] = esc_url_raw( $value );
					break;
				case 'textarea':
					$clean[ $key ] = sanitize_textarea_field( $value );
					break;
				case 'text':
				default:
					$clean[ $key ] = sanitize_text_field( $value );
					break;
			}
		}
	}

	return $clean;
}

/**
 * Save the page-template sections on page save.
 */
function murailles_page_editor_save( $post_id, $post ) {
	if ( ! $post instanceof WP_Post || 'page' !== $post->post_type ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}
	if ( ! isset( $_POST['murailles_page_sections_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['murailles_page_sections_nonce'] ) ), 'murailles_page_sections_save' ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	$template_key = murailles_page_editor_template_key( $post_id );
	if ( ! $template_key ) {
		delete_post_meta( $post_id, '_murailles_page_sections' );
		return;
	}

	$raw   = isset( $_POST['murailles_page_sections'] ) ? wp_unslash( $_POST['murailles_page_sections'] ) : array();
	$clean = murailles_page_editor_sanitize_sections( $raw, $template_key );

	if ( empty( $clean ) ) {
		delete_post_meta( $post_id, '_murailles_page_sections' );
		return;
	}

	update_post_meta( $post_id, '_murailles_page_sections', $clean );
}
add_action( 'save_post_page', 'murailles_page_editor_save', 10, 2 );

/**
 * Seed translation pages with the source page's section meta when Polylang
 * creates a translated draft from an existing page.
 */
function murailles_page_editor_copy_translation_meta( $new_id, $new_post, $update ) {
	if ( $update || ! is_admin() || 'page' !== $new_post->post_type ) {
		return;
	}
	if ( empty( $_GET['from_post'] ) || empty( $_GET['new_lang'] ) ) {
		return;
	}

	$source_id = absint( $_GET['from_post'] );
	if ( ! $source_id || $source_id === $new_id ) {
		return;
	}

	if ( get_post_meta( $new_id, '_murailles_page_sections', true ) ) {
		return;
	}

	$source_meta = get_post_meta( $source_id, '_murailles_page_sections', true );
	if ( is_array( $source_meta ) && ! empty( $source_meta ) ) {
		update_post_meta( $new_id, '_murailles_page_sections', $source_meta );
	}
}
add_action( 'wp_insert_post', 'murailles_page_editor_copy_translation_meta', 25, 3 );
