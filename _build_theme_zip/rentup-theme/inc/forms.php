<?php
/**
 * Forms handler — contact, review, newsletter, submit-property.
 *
 * - Configures wp_mail() to send via Gmail SMTP using constants in wp-config.php
 * - Registers a 'lead' CPT to persist every submission (admin-only)
 * - Registers admin-post + admin-ajax handlers for each form
 * - Anti-spam: WP nonce + honeypot field (`_mw_hp_url`) + minimum fill time
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/email-templates.php';

/**
 * Extract a likely first name from a full name string.
 */
function murailles_first_name( $full ) {
	$parts = preg_split( '/\s+/', trim( (string) $full ) );
	return $parts ? $parts[0] : '';
}

/* -------------------------------------------------------------------------
 * SMTP wiring (Gmail App Password)
 * ---------------------------------------------------------------------- */

add_action( 'phpmailer_init', function ( $phpmailer ) {
	if ( ! defined( 'MURAILLES_SMTP_HOST' ) || ! defined( 'MURAILLES_SMTP_USER' ) || ! defined( 'MURAILLES_SMTP_PASS' ) ) {
		return;
	}
	$phpmailer->isSMTP();
	$phpmailer->Host       = MURAILLES_SMTP_HOST;
	$phpmailer->Port       = defined( 'MURAILLES_SMTP_PORT' )     ? MURAILLES_SMTP_PORT     : 587;
	$phpmailer->SMTPSecure = defined( 'MURAILLES_SMTP_SECURE' )   ? MURAILLES_SMTP_SECURE   : 'tls';
	$phpmailer->SMTPAuth   = true;
	$phpmailer->Username   = MURAILLES_SMTP_USER;
	$phpmailer->Password   = MURAILLES_SMTP_PASS;
	$phpmailer->From       = defined( 'MURAILLES_SMTP_FROM' )      ? MURAILLES_SMTP_FROM      : MURAILLES_SMTP_USER;
	$phpmailer->FromName   = defined( 'MURAILLES_SMTP_FROM_NAME' ) ? MURAILLES_SMTP_FROM_NAME : get_bloginfo( 'name' );
	$phpmailer->CharSet    = 'UTF-8';

	// Local XAMPP has no CA bundle by default — TLS handshake fails silently.
	// Disable peer verification ONLY on localhost (dev convenience).
	$host_is_local = in_array( $_SERVER['HTTP_HOST'] ?? '', array( 'localhost', '127.0.0.1' ), true )
		|| ( isset( $_SERVER['HTTP_HOST'] ) && strpos( $_SERVER['HTTP_HOST'], 'localhost' ) === 0 );
	if ( $host_is_local ) {
		$phpmailer->SMTPOptions = array(
			'ssl' => array(
				'verify_peer'       => false,
				'verify_peer_name'  => false,
				'allow_self_signed' => true,
			),
		);
	}

	// Capture verbose debug output to debug.log so we can see what's failing.
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		$phpmailer->SMTPDebug   = 2; // 0=off, 1=client, 2=client+server
		$phpmailer->Debugoutput = function ( $str, $level ) {
			error_log( '[murailles-smtp] ' . trim( $str ) );
		};
	}
} );

/**
 * Log every wp_mail() failure with the underlying error.
 * Lets us see in debug.log whether sending succeeded or which step failed.
 */
add_action( 'wp_mail_failed', function ( $wp_error ) {
	error_log( '[murailles-mail] wp_mail FAILED: ' . $wp_error->get_error_message() );
	$data = $wp_error->get_error_data();
	if ( ! empty( $data ) ) {
		error_log( '[murailles-mail] error data: ' . wp_json_encode( $data ) );
	}
} );

/**
 * Log every successful send so we can confirm SMTP is working.
 */
add_action( 'wp_mail_succeeded', function ( $mail_data ) {
	$to = is_array( $mail_data['to'] ?? null ) ? implode( ',', $mail_data['to'] ) : (string) ( $mail_data['to'] ?? '' );
	error_log( '[murailles-mail] wp_mail OK → ' . $to . ' | subject: ' . ( $mail_data['subject'] ?? '' ) );
} );

add_filter( 'wp_mail_from', function ( $email ) {
	return defined( 'MURAILLES_SMTP_FROM' ) ? MURAILLES_SMTP_FROM : $email;
} );

add_filter( 'wp_mail_from_name', function ( $name ) {
	return defined( 'MURAILLES_SMTP_FROM_NAME' ) ? MURAILLES_SMTP_FROM_NAME : $name;
} );

/* -------------------------------------------------------------------------
 * Lead CPT — stores every form submission for admin review
 * Subscriber CPT — stores newsletter signups (queryable, exportable)
 * ---------------------------------------------------------------------- */

add_action( 'init', function () {
	register_post_type( 'murailles_lead', array(
		'labels'              => array(
			'name'          => 'Demandes',
			'singular_name' => 'Demande',
			'menu_name'     => 'Demandes',
			'all_items'     => 'Toutes les demandes',
		),
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_icon'           => 'dashicons-email-alt',
		'menu_position'       => 26,
		'supports'            => array( 'title', 'editor', 'custom-fields' ),
		'capability_type'     => 'post',
		'exclude_from_search' => true,
		'has_archive'         => false,
		'rewrite'             => false,
	) );

	register_post_type( 'murailles_property_submission', array(
		'labels'              => array(
			'name'          => 'Soumissions biens',
			'singular_name' => 'Soumission bien',
			'menu_name'     => 'Soumissions biens',
			'all_items'     => 'Toutes les soumissions',
			'add_new_item'  => 'Ajouter une soumission',
			'edit_item'     => 'Modifier la soumission',
		),
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_icon'           => 'dashicons-clipboard',
		'menu_position'       => 25,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
		'capability_type'     => 'post',
		'exclude_from_search' => true,
		'has_archive'         => false,
		'rewrite'             => false,
		'show_in_rest'        => true,
		'rest_base'           => 'property-submission',
	) );

	register_post_type( 'murailles_subscriber', array(
		'labels'              => array(
			'name'          => 'Abonnés newsletter',
			'singular_name' => 'Abonné',
			'menu_name'     => 'Newsletter',
			'all_items'     => 'Tous les abonnés',
			'add_new_item'  => 'Ajouter un abonné',
		),
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_icon'           => 'dashicons-megaphone',
		'menu_position'       => 27,
		'supports'            => array( 'title' ),
		'capability_type'     => 'post',
		'exclude_from_search' => true,
		'has_archive'         => false,
		'rewrite'             => false,
	) );
} );

/**
 * Internal status definitions for leads/messages.
 */
function murailles_lead_statuses() {
	return array(
		'new'      => 'New',
		'read'     => 'Read',
		'replied'  => 'Replied',
		'archived' => 'Archived',
	);
}

/**
 * Internal status definitions for visitor property submissions.
 */
function murailles_property_submission_statuses() {
	return array(
		'pending'             => 'Pending',
		'under_review'        => 'Under Review',
		'approved_internally' => 'Approved Internally',
		'rejected'            => 'Rejected',
		'archived'            => 'Archived',
	);
}

/**
 * Resolve the current/requested language slug.
 */
function murailles_form_language() {
	if ( ! empty( $_POST['language'] ) ) {
		$lang = sanitize_key( wp_unslash( $_POST['language'] ) );
		if ( in_array( $lang, array( 'fr', 'en' ), true ) ) {
			return $lang;
		}
	}

	if ( function_exists( 'pll_current_language' ) ) {
		$lang = pll_current_language( 'slug' );
		if ( in_array( $lang, array( 'fr', 'en' ), true ) ) {
			return $lang;
		}
	}

	return 'fr';
}

/**
 * Lightweight translation helper for form workflow messages.
 */
function murailles_form_i18n( $fr, $en = '' ) {
	$lang = murailles_form_language();
	return ( 'en' === $lang && '' !== $en ) ? $en : $fr;
}

/**
 * Basic phone normalization/validation.
 */
function murailles_normalize_phone( $phone ) {
	$phone = preg_replace( '/[^\d+]/', '', (string) $phone );
	return is_string( $phone ) ? trim( $phone ) : '';
}

/**
 * Collect common request context for backoffice storage and emails.
 */
function murailles_form_context() {
	$page_url = '';
	if ( ! empty( $_POST['page_url'] ) ) {
		$page_url = esc_url_raw( wp_unslash( $_POST['page_url'] ) );
	}
	if ( ! $page_url ) {
		$referrer = wp_get_referer();
		$page_url = $referrer ? esc_url_raw( $referrer ) : home_url( '/' );
	}

	return array(
		'language' => murailles_form_language(),
		'page_url' => $page_url,
		'ip'       => isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '',
		'ua'       => isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '',
	);
}

/**
 * Resolve the backoffice notification inbox for form events.
 */
function murailles_form_notification_recipient() {
	return defined( 'MURAILLES_LEAD_NOTIFY' ) ? MURAILLES_LEAD_NOTIFY : get_option( 'admin_email' );
}

/**
 * Normalize values before storing them as post meta.
 *
 * @param mixed $value Raw field value.
 * @return mixed
 */
function murailles_form_meta_value( $value ) {
	if ( is_array( $value ) ) {
		$sanitized = array_map(
			static function ( $item ) {
				return sanitize_text_field( (string) $item );
			},
			$value
		);
		return wp_json_encode( array_values( array_filter( $sanitized, 'strlen' ) ) );
	}

	return sanitize_text_field( (string) $value );
}

/**
 * Register internal lead/submission meta for REST-safe admin tooling.
 */
add_action(
	'init',
	function () {
		$lead_meta_keys = array(
			'_lead_type',
			'_lead_status',
			'_lead_ip',
			'_lead_ua',
			'_lead_language',
			'_lead_page_url',
			'_lead_name',
			'_lead_email',
			'_lead_phone',
			'_lead_subject',
			'_lead_message',
			'_lead_property',
			'_lead_property_id',
			'_lead_rating',
		);

		foreach ( $lead_meta_keys as $meta_key ) {
			register_post_meta(
				'murailles_lead',
				$meta_key,
				array(
					'single'            => true,
					'type'              => 'string',
					'show_in_rest'      => true,
					'sanitize_callback' => 'sanitize_text_field',
					'auth_callback'     => static function () {
						return current_user_can( 'edit_posts' );
					},
				)
			);
		}

		$submission_string_meta = array(
			'_submission_status',
			'_submission_language',
			'_submission_page_url',
			'_submission_ip',
			'_submission_ua',
			'_submission_property_title',
			'_submission_property_status',
			'_submission_property_type',
			'_submission_price',
			'_submission_area',
			'_submission_bedrooms',
			'_submission_bathrooms',
			'_submission_address',
			'_submission_city',
			'_submission_state',
			'_submission_zip_code',
			'_submission_building_age',
			'_submission_garage',
			'_submission_rooms',
			'_submission_owner_name',
			'_submission_owner_email',
			'_submission_owner_phone',
			'_submission_gallery_ids',
			'_submission_features',
		);

		foreach ( $submission_string_meta as $meta_key ) {
			register_post_meta(
				'murailles_property_submission',
				$meta_key,
				array(
					'single'            => true,
					'type'              => 'string',
					'show_in_rest'      => true,
					'sanitize_callback' => 'sanitize_text_field',
					'auth_callback'     => static function () {
						return current_user_can( 'edit_posts' );
					},
				)
			);
		}
	}
);

/**
 * Admin columns for the subscriber CPT — show email + date inscription.
 */
add_filter( 'manage_murailles_subscriber_posts_columns', function ( $cols ) {
	return array(
		'cb'        => $cols['cb'],
		'title'     => 'E-mail',
		'sub_date'  => 'Date d\'inscription',
		'sub_ip'    => 'IP',
		'sub_src'   => 'Source',
	);
} );
add_action( 'manage_murailles_subscriber_posts_custom_column', function ( $col, $post_id ) {
	switch ( $col ) {
		case 'sub_date':
			echo esc_html( get_the_date( 'd/m/Y H:i', $post_id ) );
			break;
		case 'sub_ip':
			echo esc_html( get_post_meta( $post_id, '_sub_ip', true ) ?: '—' );
			break;
		case 'sub_src':
			echo esc_html( get_post_meta( $post_id, '_sub_source', true ) ?: 'newsletter' );
			break;
	}
}, 10, 2 );

/**
 * Save a subscriber as a CPT post; returns post ID, or 0 if duplicate.
 */
function murailles_save_subscriber( $email, $source = 'newsletter' ) {
	$email = sanitize_email( $email );
	if ( ! is_email( $email ) ) {
		return 0;
	}
	// Dedup: query existing
	$existing = get_posts( array(
		'post_type'      => 'murailles_subscriber',
		'title'          => $email,
		'posts_per_page' => 1,
		'post_status'    => 'any',
		'fields'         => 'ids',
	) );
	if ( $existing ) {
		return 0;
	}
	$post_id = wp_insert_post( array(
		'post_type'   => 'murailles_subscriber',
		'post_status' => 'publish',
		'post_title'  => $email,
	) );
	if ( $post_id && ! is_wp_error( $post_id ) ) {
		update_post_meta( $post_id, '_sub_ip',     isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( $_SERVER['REMOTE_ADDR'] ) : '' );
		update_post_meta( $post_id, '_sub_ua',     isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( $_SERVER['HTTP_USER_AGENT'] ) : '' );
		update_post_meta( $post_id, '_sub_source', sanitize_text_field( $source ) );
		return $post_id;
	}
	return 0;
}

/**
 * One-time migration: copy old wp_options['murailles_newsletter_list'] entries into the CPT.
 */
add_action( 'admin_init', function () {
	if ( get_option( 'murailles_subscribers_migrated' ) ) {
		return;
	}
	$old = get_option( 'murailles_newsletter_list', array() );
	if ( is_array( $old ) ) {
		foreach ( $old as $email ) {
			murailles_save_subscriber( $email, 'migration' );
		}
	}
	update_option( 'murailles_subscribers_migrated', 1 );
} );

/**
 * Export action — admin can download CSV of all subscribers.
 */
add_action( 'admin_menu', function () {
	add_submenu_page(
		'edit.php?post_type=murailles_subscriber',
		'Exporter les abonnés',
		'Exporter CSV',
		'manage_options',
		'murailles-export-subscribers',
		'murailles_export_subscribers_page'
	);
} );
function murailles_export_subscribers_page() {
	?>
	<div class="wrap">
		<h1>Exporter les abonnés newsletter</h1>
		<p>Téléchargez la liste complète des abonnés au format CSV (compatible Excel, Google Sheets, Mailchimp).</p>
		<p>
			<a href="<?php echo esc_url( admin_url( 'admin-post.php?action=murailles_export_subscribers&_wpnonce=' . wp_create_nonce( 'murailles_export' ) ) ); ?>" class="button button-primary">
				<span class="dashicons dashicons-download" style="vertical-align:middle;"></span> Télécharger le CSV
			</a>
		</p>
	</div>
	<?php
}
add_action( 'admin_post_murailles_export_subscribers', function () {
	if ( ! current_user_can( 'manage_options' ) || ! wp_verify_nonce( $_GET['_wpnonce'] ?? '', 'murailles_export' ) ) {
		wp_die( 'Accès refusé.' );
	}
	$subs = get_posts( array(
		'post_type'      => 'murailles_subscriber',
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'post_status'    => 'publish',
	) );
	nocache_headers();
	header( 'Content-Type: text/csv; charset=UTF-8' );
	header( 'Content-Disposition: attachment; filename="abonnes-' . date( 'Y-m-d' ) . '.csv"' );
	$out = fopen( 'php://output', 'w' );
	fwrite( $out, "\xEF\xBB\xBF" ); // BOM for Excel UTF-8
	fputcsv( $out, array( 'E-mail', 'Date inscription', 'IP', 'Source' ) );
	foreach ( $subs as $s ) {
		fputcsv( $out, array(
			$s->post_title,
			get_the_date( 'd/m/Y H:i', $s ),
			get_post_meta( $s->ID, '_sub_ip',     true ),
			get_post_meta( $s->ID, '_sub_source', true ),
		) );
	}
	fclose( $out );
	exit;
} );

/* -------------------------------------------------------------------------
 * Helpers
 * ---------------------------------------------------------------------- */

/**
 * Validate honeypot + nonce + minimum render-to-submit duration.
 * Returns true if the request looks human, false otherwise.
 */
function murailles_form_is_legit( $nonce_action ) {
	// Honeypot — bots fill every input
	if ( ! empty( $_POST['_mw_hp_url'] ) ) {
		return false;
	}
	// Nonce
	if ( empty( $_POST['_murailles_nonce'] ) || ! wp_verify_nonce( $_POST['_murailles_nonce'], $nonce_action ) ) {
		return false;
	}
	// Render-to-submit duration — humans take >2s to fill a form
	if ( ! empty( $_POST['_murailles_ts'] ) ) {
		$elapsed = time() - intval( $_POST['_murailles_ts'] );
		if ( $elapsed < 2 ) {
			return false;
		}
	}
	return true;
}

/**
 * Send an HTML email via wp_mail() (which now uses SMTP).
 */
function murailles_send_mail( $to, $subject, $body_html, $reply_to = '' ) {
	$headers = array( 'Content-Type: text/html; charset=UTF-8' );
	if ( $reply_to && is_email( $reply_to ) ) {
		$headers[] = 'Reply-To: ' . sanitize_email( $reply_to );
	}
	$ok = wp_mail( $to, $subject, $body_html, $headers );
	if ( ! $ok ) {
		error_log( '[murailles-mail] wp_mail() returned false for: ' . $to . ' (subject: ' . $subject . ')' );
	}
	return $ok;
}

/**
 * Persist a submission as a murailles_lead post.
 */
function murailles_save_lead( $type, $title, $fields, $body = '' ) {
	$context = murailles_form_context();
	$post_id = wp_insert_post( array(
		'post_type'    => 'murailles_lead',
		'post_status'  => 'publish',
		'post_title'   => wp_strip_all_tags( $title ),
		'post_content' => wp_kses_post( $body ),
	) );
	if ( $post_id && ! is_wp_error( $post_id ) ) {
		update_post_meta( $post_id, '_lead_type', sanitize_key( $type ) );
		update_post_meta( $post_id, '_lead_status', 'new' );
		update_post_meta( $post_id, '_lead_ip', $context['ip'] );
		update_post_meta( $post_id, '_lead_ua', $context['ua'] );
		update_post_meta( $post_id, '_lead_language', $context['language'] );
		update_post_meta( $post_id, '_lead_page_url', $context['page_url'] );
		foreach ( $fields as $key => $value ) {
			update_post_meta( $post_id, '_lead_' . sanitize_key( $key ), murailles_form_meta_value( $value ) );
		}
	}
	return $post_id;
}

/**
 * Store a visitor property submission in an internal-only queue.
 *
 * @param array $submission Submission data.
 * @return int
 */
function murailles_save_property_submission( $submission ) {
	$post_id = wp_insert_post(
		array(
			'post_type'    => 'murailles_property_submission',
			'post_status'  => 'publish',
			'post_title'   => wp_strip_all_tags( $submission['post_title'] ?? '' ),
			'post_content' => wp_kses_post( $submission['post_content'] ?? '' ),
		)
	);

	if ( ! $post_id || is_wp_error( $post_id ) ) {
		return 0;
	}

	$meta = isset( $submission['meta'] ) && is_array( $submission['meta'] ) ? $submission['meta'] : array();
	foreach ( $meta as $key => $value ) {
		update_post_meta( $post_id, $key, murailles_form_meta_value( $value ) );
	}

	$image_ids = isset( $submission['image_ids'] ) && is_array( $submission['image_ids'] ) ? array_values( array_filter( array_map( 'absint', $submission['image_ids'] ) ) ) : array();
	if ( $image_ids ) {
		set_post_thumbnail( $post_id, $image_ids[0] );
		update_post_meta( $post_id, '_submission_gallery_ids', implode( ',', $image_ids ) );
	}

	return (int) $post_id;
}

/**
 * Validate and upload multiple gallery images.
 *
 * @param string $field_name Field name in $_FILES.
 * @param int    $post_id Parent post.
 * @return array{ids: array<int>, errors: array<int, string>}
 */
function murailles_handle_gallery_uploads( $field_name, $post_id ) {
	$result = array(
		'ids'    => array(),
		'errors' => array(),
	);

	if ( empty( $_FILES[ $field_name ] ) || ! is_array( $_FILES[ $field_name ]['name'] ) ) {
		return $result;
	}

	$allowed_mimes = array(
		'image/jpeg',
		'image/png',
		'image/webp',
	);
	$max_files     = 12;
	$max_bytes     = wp_max_upload_size();
	$total_files   = count( $_FILES[ $field_name ]['name'] );

	if ( $total_files > $max_files ) {
		$result['errors'][] = murailles_form_i18n(
			'Vous pouvez envoyer au maximum 12 photos par annonce.',
			'You can upload up to 12 photos per submission.'
		);
		return $result;
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$original_files = $_FILES;

	foreach ( $_FILES[ $field_name ]['name'] as $index => $name ) {
		if ( empty( $name ) ) {
			continue;
		}

		$error_code = (int) ( $_FILES[ $field_name ]['error'][ $index ] ?? UPLOAD_ERR_NO_FILE );
		if ( UPLOAD_ERR_OK !== $error_code ) {
			$result['errors'][] = sprintf(
				/* translators: %s: uploaded filename. */
				murailles_form_i18n( 'Le fichier %s n\'a pas pu être importé.', 'The file %s could not be uploaded.' ),
				sanitize_file_name( $name )
			);
			continue;
		}

		$type = (string) ( $_FILES[ $field_name ]['type'][ $index ] ?? '' );
		$size = (int) ( $_FILES[ $field_name ]['size'][ $index ] ?? 0 );

		if ( $size < 1 || $size > $max_bytes ) {
			$result['errors'][] = sprintf(
				murailles_form_i18n( 'Le fichier %s dépasse la taille autorisée.', 'The file %s exceeds the allowed size.' ),
				sanitize_file_name( $name )
			);
			continue;
		}

		if ( ! in_array( $type, $allowed_mimes, true ) ) {
			$result['errors'][] = sprintf(
				murailles_form_i18n( 'Le fichier %s doit être au format JPG, PNG ou WEBP.', 'The file %s must be JPG, PNG, or WEBP.' ),
				sanitize_file_name( $name )
			);
			continue;
		}

		$_FILES = array(
			'murailles_gallery_single' => array(
				'name'     => $_FILES[ $field_name ]['name'][ $index ],
				'type'     => $_FILES[ $field_name ]['type'][ $index ],
				'tmp_name' => $_FILES[ $field_name ]['tmp_name'][ $index ],
				'error'    => $_FILES[ $field_name ]['error'][ $index ],
				'size'     => $_FILES[ $field_name ]['size'][ $index ],
			),
		);

		$attachment_id = media_handle_upload( 'murailles_gallery_single', $post_id );
		if ( is_wp_error( $attachment_id ) ) {
			$result['errors'][] = sprintf(
				murailles_form_i18n( 'Le fichier %s a échoué : %s', 'The file %s failed: %s' ),
				sanitize_file_name( $name ),
				$attachment_id->get_error_message()
			);
			continue;
		}

		$result['ids'][] = (int) $attachment_id;
	}

	$_FILES = $original_files;

	return $result;
}

/**
 * Return JSON for AJAX requests, redirect otherwise.
 */
function murailles_form_response( $success, $message, $redirect = '' ) {
	if ( wp_doing_ajax() || ( ! empty( $_POST['_ajax'] ) && $_POST['_ajax'] === '1' ) ) {
		wp_send_json( array(
			'success' => $success,
			'message' => $message,
		) );
	}
	$redirect = $redirect ?: wp_get_referer() ?: home_url( '/' );
	$redirect = add_query_arg( array(
		'form_status' => $success ? 'ok' : 'err',
		'form_msg'    => rawurlencode( $message ),
	), $redirect );
	wp_safe_redirect( $redirect );
	exit;
}

/**
 * Human-readable status label.
 *
 * @param array  $statuses Allowed statuses.
 * @param string $status Current status.
 * @return string
 */
function murailles_form_status_label( $statuses, $status ) {
	return isset( $statuses[ $status ] ) ? $statuses[ $status ] : $status;
}

/**
 * Add backoffice columns for saved leads.
 */
add_filter(
	'manage_murailles_lead_posts_columns',
	function ( $columns ) {
		return array(
			'cb'          => $columns['cb'],
			'title'       => 'Sujet',
			'lead_type'   => 'Type',
			'lead_status' => 'Statut',
			'lead_email'  => 'E-mail',
			'lead_lang'   => 'Langue',
			'date'        => $columns['date'],
		);
	}
);

add_action(
	'manage_murailles_lead_posts_custom_column',
	function ( $column, $post_id ) {
		switch ( $column ) {
			case 'lead_type':
				echo esc_html( get_post_meta( $post_id, '_lead_type', true ) ?: '—' );
				break;
			case 'lead_status':
				$status = get_post_meta( $post_id, '_lead_status', true ) ?: 'new';
				echo esc_html( murailles_form_status_label( murailles_lead_statuses(), $status ) );
				break;
			case 'lead_email':
				$email = get_post_meta( $post_id, '_lead_email', true );
				if ( $email && is_email( $email ) ) {
					echo '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>';
				} else {
					echo '—';
				}
				break;
			case 'lead_lang':
				echo esc_html( strtoupper( get_post_meta( $post_id, '_lead_language', true ) ?: 'fr' ) );
				break;
		}
	},
	10,
	2
);

/**
 * Add backoffice columns for property submissions.
 */
add_filter(
	'manage_murailles_property_submission_posts_columns',
	function ( $columns ) {
		return array(
			'cb'                => $columns['cb'],
			'title'             => 'Annonce',
			'submission_owner'  => 'Déposant',
			'submission_status' => 'Statut',
			'submission_lang'   => 'Langue',
			'submission_media'  => 'Photos',
			'date'              => $columns['date'],
		);
	}
);

add_action(
	'manage_murailles_property_submission_posts_custom_column',
	function ( $column, $post_id ) {
		switch ( $column ) {
			case 'submission_owner':
				$name  = get_post_meta( $post_id, '_submission_owner_name', true );
				$email = get_post_meta( $post_id, '_submission_owner_email', true );
				$phone = get_post_meta( $post_id, '_submission_owner_phone', true );
				$bits  = array();
				if ( $name ) {
					$bits[] = '<strong>' . esc_html( $name ) . '</strong>';
				}
				if ( $email && is_email( $email ) ) {
					$bits[] = '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>';
				}
				if ( $phone ) {
					$bits[] = esc_html( $phone );
				}
				echo $bits ? implode( '<br>', $bits ) : '—';
				break;
			case 'submission_status':
				$status = get_post_meta( $post_id, '_submission_status', true ) ?: 'pending';
				echo esc_html( murailles_form_status_label( murailles_property_submission_statuses(), $status ) );
				break;
			case 'submission_lang':
				echo esc_html( strtoupper( get_post_meta( $post_id, '_submission_language', true ) ?: 'fr' ) );
				break;
			case 'submission_media':
				$gallery = (string) get_post_meta( $post_id, '_submission_gallery_ids', true );
				$count   = $gallery ? count( array_filter( array_map( 'absint', explode( ',', $gallery ) ) ) ) : 0;
				echo esc_html( (string) $count );
				break;
		}
	},
	10,
	2
);

/**
 * Add workflow metaboxes for internal records.
 */
add_action(
	'add_meta_boxes',
	function () {
		add_meta_box( 'murailles-lead-workflow', 'Workflow', 'murailles_render_lead_workflow_metabox', 'murailles_lead', 'side', 'high' );
		add_meta_box( 'murailles-submission-workflow', 'Workflow', 'murailles_render_submission_workflow_metabox', 'murailles_property_submission', 'side', 'high' );
	}
);

function murailles_render_lead_workflow_metabox( $post ) {
	wp_nonce_field( 'murailles_save_internal_workflow', 'murailles_internal_workflow_nonce' );
	$status   = get_post_meta( $post->ID, '_lead_status', true ) ?: 'new';
	$email    = get_post_meta( $post->ID, '_lead_email', true );
	$page_url = get_post_meta( $post->ID, '_lead_page_url', true );
	$lang     = get_post_meta( $post->ID, '_lead_language', true ) ?: 'fr';
	?>
	<p>
		<label for="murailles-lead-status"><strong>Statut</strong></label><br>
		<select id="murailles-lead-status" name="murailles_lead_status" class="widefat">
			<?php foreach ( murailles_lead_statuses() as $value => $label ) : ?>
				<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $status, $value ); ?>><?php echo esc_html( $label ); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<p><strong>Langue :</strong> <?php echo esc_html( strtoupper( $lang ) ); ?></p>
	<?php if ( $email && is_email( $email ) ) : ?>
	<p><strong>E-mail :</strong><br><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></p>
	<?php endif; ?>
	<?php if ( $page_url ) : ?>
	<p><strong>Page source :</strong><br><a href="<?php echo esc_url( $page_url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $page_url ); ?></a></p>
	<?php endif; ?>
	<?php
}

function murailles_render_submission_workflow_metabox( $post ) {
	wp_nonce_field( 'murailles_save_internal_workflow', 'murailles_internal_workflow_nonce' );
	$status   = get_post_meta( $post->ID, '_submission_status', true ) ?: 'pending';
	$email    = get_post_meta( $post->ID, '_submission_owner_email', true );
	$page_url = get_post_meta( $post->ID, '_submission_page_url', true );
	$lang     = get_post_meta( $post->ID, '_submission_language', true ) ?: 'fr';
	?>
	<p>
		<label for="murailles-submission-status"><strong>Statut</strong></label><br>
		<select id="murailles-submission-status" name="murailles_submission_status" class="widefat">
			<?php foreach ( murailles_property_submission_statuses() as $value => $label ) : ?>
				<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $status, $value ); ?>><?php echo esc_html( $label ); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<p><strong>Langue :</strong> <?php echo esc_html( strtoupper( $lang ) ); ?></p>
	<?php if ( $email && is_email( $email ) ) : ?>
	<p><strong>E-mail :</strong><br><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></p>
	<?php endif; ?>
	<?php if ( $page_url ) : ?>
	<p><strong>Page source :</strong><br><a href="<?php echo esc_url( $page_url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $page_url ); ?></a></p>
	<?php endif; ?>
	<?php
}

/**
 * Persist workflow statuses.
 */
add_action(
	'save_post',
	function ( $post_id, $post ) {
		if ( empty( $_POST['murailles_internal_workflow_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['murailles_internal_workflow_nonce'] ) ), 'murailles_save_internal_workflow' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( 'murailles_lead' === $post->post_type && ! empty( $_POST['murailles_lead_status'] ) ) {
			$status = sanitize_key( wp_unslash( $_POST['murailles_lead_status'] ) );
			if ( isset( murailles_lead_statuses()[ $status ] ) ) {
				update_post_meta( $post_id, '_lead_status', $status );
			}
		}

		if ( 'murailles_property_submission' === $post->post_type && ! empty( $_POST['murailles_submission_status'] ) ) {
			$status = sanitize_key( wp_unslash( $_POST['murailles_submission_status'] ) );
			if ( isset( murailles_property_submission_statuses()[ $status ] ) ) {
				update_post_meta( $post_id, '_submission_status', $status );
			}
		}
	},
	10,
	2
);

/* -------------------------------------------------------------------------
 * Form: Contact (contact.php)
 * ---------------------------------------------------------------------- */

function murailles_handle_contact() {
	if ( ! murailles_form_is_legit( 'murailles_contact' ) ) {
		murailles_form_response( false, 'Requête invalide. Merci de réessayer.' );
	}

	$name    = isset( $_POST['name'] )    ? sanitize_text_field( wp_unslash( $_POST['name'] ) )    : '';
	$email   = isset( $_POST['email'] )   ? sanitize_email( wp_unslash( $_POST['email'] ) )        : '';
	$subject = isset( $_POST['subject'] ) ? sanitize_text_field( wp_unslash( $_POST['subject'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';
	$context = murailles_form_context();

	if ( ! $name || ! is_email( $email ) || ! $message ) {
		murailles_form_response( false, 'Merci de remplir votre nom, votre e-mail et votre message.' );
	}

	$fields = compact( 'name', 'email', 'subject', 'message' );

	// Admin notification
	$admin_html = murailles_email_admin(
		'Nouvelle demande de contact',
		'Un visiteur vient de remplir le formulaire de contact.',
		array(
			'Langue'  => esc_html( strtoupper( $context['language'] ) ),
			'Page'    => '<a href="' . esc_url( $context['page_url'] ) . '" style="color:#dc3545;">' . esc_html( $context['page_url'] ) . '</a>',
			'Nom'     => esc_html( $name ),
			'E-mail'  => '<a href="mailto:' . esc_attr( $email ) . '" style="color:#dc3545;">' . esc_html( $email ) . '</a>',
			'Sujet'   => esc_html( $subject ?: '(non précisé)' ),
			'Message' => nl2br( esc_html( $message ) ),
		),
		'Répondre par e-mail',
		'mailto:' . $email . '?subject=' . rawurlencode( 'Re: ' . ( $subject ?: 'Votre demande' ) )
	);

	murailles_save_lead( 'contact', 'Contact — ' . $name, $fields, $admin_html );
	murailles_send_mail(
		murailles_form_notification_recipient(),
		'[Agence Murailles] Contact — ' . $name,
		$admin_html,
		$email
	);

	// User confirmation
	$user_html = murailles_email_user(
		murailles_first_name( $name ),
		'Votre message a bien été reçu',
		'<p>Merci d\'avoir contacté <strong>Agence Murailles</strong>. Nous avons bien reçu votre demande concernant <em>' . esc_html( $subject ?: 'votre projet immobilier' ) . '</em>.</p>'
		. '<p>Notre équipe vous recontactera sous <strong>24 heures ouvrées</strong> pour vous accompagner dans votre projet à Marrakech ou ailleurs au Maroc.</p>',
		'<p style="margin:0;"><strong>Récapitulatif de votre message :</strong></p>'
		. '<p style="margin:8px 0 0;padding:12px 16px;background:#fff;border-left:3px solid #dc3545;border-radius:4px;font-style:italic;">' . nl2br( esc_html( $message ) ) . '</p>'
	);
	murailles_send_mail( $email, 'Votre demande — Agence Murailles', $user_html );

	murailles_form_response( true, 'Merci ! Votre message a bien été envoyé. Vous recevez un e-mail de confirmation et nous vous recontactons sous 24 h.' );
}
add_action( 'admin_post_nopriv_murailles_contact', 'murailles_handle_contact' );
add_action( 'admin_post_murailles_contact',        'murailles_handle_contact' );
add_action( 'wp_ajax_nopriv_murailles_contact',    'murailles_handle_contact' );
add_action( 'wp_ajax_murailles_contact',           'murailles_handle_contact' );

/* -------------------------------------------------------------------------
 * Form: Property review (single-property-*.php)
 * ---------------------------------------------------------------------- */

function murailles_handle_review() {
	if ( ! murailles_form_is_legit( 'murailles_review' ) ) {
		murailles_form_response( false, 'Requête invalide. Merci de réessayer.' );
	}

	$name       = isset( $_POST['name'] )       ? sanitize_text_field( wp_unslash( $_POST['name'] ) )    : '';
	$email      = isset( $_POST['email'] )      ? sanitize_email( wp_unslash( $_POST['email'] ) )        : '';
	$message    = isset( $_POST['message'] )    ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';
	$property   = isset( $_POST['property_id'] ) ? intval( $_POST['property_id'] ) : 0;
	$rating     = isset( $_POST['rating'] )     ? intval( $_POST['rating'] )       : 0;
	$context    = murailles_form_context();

	if ( ! $name || ! is_email( $email ) || ! $message ) {
		murailles_form_response( false, 'Merci de remplir votre nom, e-mail et avis.' );
	}

	$property_title = $property ? get_the_title( $property ) : '(non précisé)';
	$fields = compact( 'name', 'email', 'message', 'property', 'rating' );

	// Route into WP comments system (unapproved → admin moderates)
	$comment_id = 0;
	if ( $property ) {
		$comment_id = wp_insert_comment( array(
			'comment_post_ID'      => $property,
			'comment_author'       => $name,
			'comment_author_email' => $email,
			'comment_content'      => $message,
			'comment_type'         => 'review',
			'comment_approved'     => 0, // pending moderation
			'comment_author_IP'    => isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( $_SERVER['REMOTE_ADDR'] ) : '',
			'comment_agent'        => isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( $_SERVER['HTTP_USER_AGENT'] ) : '',
		) );
		if ( $comment_id && $rating > 0 ) {
			add_comment_meta( $comment_id, 'murailles_rating', $rating );
		}
	}

	$moderation_link = $comment_id
		? admin_url( 'comment.php?action=editcomment&c=' . $comment_id )
		: admin_url( 'edit-comments.php?comment_status=moderated' );

	// Admin notification
	$admin_html = murailles_email_admin(
		'Nouvel avis à modérer',
		sprintf( 'Un visiteur a laissé un avis sur « %s ».', $property_title ),
		array(
			'Langue'  => esc_html( strtoupper( $context['language'] ) ),
			'Page'    => '<a href="' . esc_url( $context['page_url'] ) . '" style="color:#dc3545;">' . esc_html( $context['page_url'] ) . '</a>',
			'Bien'    => esc_html( $property_title ),
			'Auteur'  => esc_html( $name ),
			'E-mail'  => '<a href="mailto:' . esc_attr( $email ) . '" style="color:#dc3545;">' . esc_html( $email ) . '</a>',
			'Note'    => $rating ? str_repeat( '★', $rating ) . str_repeat( '☆', 5 - $rating ) . ' (' . $rating . '/5)' : '—',
			'Avis'    => nl2br( esc_html( $message ) ),
			'Statut'  => '<em style="color:#856404;">En attente de modération</em>',
		),
		'Modérer l\'avis',
		$moderation_link
	);

	murailles_save_lead( 'review', 'Avis — ' . $property_title, $fields, $admin_html );
	murailles_send_mail(
		murailles_form_notification_recipient(),
		'[Agence Murailles] Avis à modérer — ' . $property_title,
		$admin_html,
		$email
	);

	// User confirmation
	$user_html = murailles_email_user(
		murailles_first_name( $name ),
		'Merci pour votre avis',
		'<p>Nous avons bien reçu votre avis sur <strong>' . esc_html( $property_title ) . '</strong>. Merci d\'avoir pris le temps de partager votre expérience.</p>'
		. '<p>Votre avis sera publié sur le site après vérification par notre équipe, généralement sous 48 heures.</p>',
		'<p style="margin:0;"><strong>Votre avis :</strong></p>'
		. ( $rating ? '<p style="margin:8px 0;color:#dc3545;font-size:18px;">' . str_repeat( '★', $rating ) . str_repeat( '☆', 5 - $rating ) . '</p>' : '' )
		. '<p style="margin:8px 0 0;padding:12px 16px;background:#fff;border-left:3px solid #dc3545;border-radius:4px;font-style:italic;">' . nl2br( esc_html( $message ) ) . '</p>'
	);
	murailles_send_mail( $email, 'Votre avis — Agence Murailles', $user_html );

	murailles_form_response( true, 'Merci ! Votre avis a été enregistré et sera publié après modération.' );
}
add_action( 'admin_post_nopriv_murailles_review', 'murailles_handle_review' );
add_action( 'admin_post_murailles_review',        'murailles_handle_review' );
add_action( 'wp_ajax_nopriv_murailles_review',    'murailles_handle_review' );
add_action( 'wp_ajax_murailles_review',           'murailles_handle_review' );

/* -------------------------------------------------------------------------
 * Form: Newsletter (footer.php)
 * ---------------------------------------------------------------------- */

function murailles_handle_newsletter() {
	if ( ! murailles_form_is_legit( 'murailles_newsletter' ) ) {
		murailles_form_response( false, 'Requête invalide.' );
	}

	$email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	if ( ! is_email( $email ) ) {
		murailles_form_response( false, 'Adresse e-mail invalide.' );
	}

	// Persist to the murailles_subscriber CPT (returns 0 if duplicate)
	$sub_id = murailles_save_subscriber( $email, 'newsletter' );
	if ( ! $sub_id ) {
		murailles_form_response( true, 'Vous êtes déjà inscrit(e) à notre newsletter.' );
	}

	// Also append to the legacy options list for back-compat (anything that still reads it)
	$list = get_option( 'murailles_newsletter_list', array() );
	if ( ! is_array( $list ) ) $list = array();
	if ( ! in_array( $email, $list, true ) ) {
		$list[] = $email;
		update_option( 'murailles_newsletter_list', $list );
	}

	$total = wp_count_posts( 'murailles_subscriber' );
	$total_published = isset( $total->publish ) ? (int) $total->publish : count( $list );

	murailles_save_lead( 'newsletter', 'Newsletter — ' . $email, array( 'email' => $email ) );

	$admin_html = murailles_email_admin(
		'Nouvelle inscription newsletter',
		'Un nouveau visiteur s\'est inscrit à la newsletter.',
		array(
			'E-mail'        => '<a href="mailto:' . esc_attr( $email ) . '" style="color:#dc3545;">' . esc_html( $email ) . '</a>',
			'Date'          => date_i18n( 'd/m/Y H:i' ),
			'Total abonnés' => $total_published,
		),
		'Voir tous les abonnés',
		admin_url( 'edit.php?post_type=murailles_subscriber' )
	);
	murailles_send_mail(
		murailles_form_notification_recipient(),
		'[Agence Murailles] Nouvelle inscription newsletter',
		$admin_html
	);

	$user_html = murailles_email_user(
		'',
		'Bienvenue dans notre newsletter',
		'<p>Merci de vous être inscrit(e) à la newsletter d\'<strong>Agence Murailles</strong>.</p>'
		. '<p>Vous recevrez chaque mois :</p>'
		. '<ul style="margin:8px 0 0;padding-left:20px;color:#4a5568;">'
		. '<li>Les nouvelles annonces exclusives à Marrakech et au Maroc</li>'
		. '<li>Nos conseils pour acheter, vendre ou louer</li>'
		. '<li>Les tendances du marché immobilier marocain</li>'
		. '</ul>'
	);
	murailles_send_mail( $email, 'Bienvenue — Agence Murailles', $user_html );

	murailles_form_response( true, 'Merci ! Vous recevrez nos prochaines actualités.' );
}
add_action( 'admin_post_nopriv_murailles_newsletter', 'murailles_handle_newsletter' );
add_action( 'admin_post_murailles_newsletter',        'murailles_handle_newsletter' );
add_action( 'wp_ajax_nopriv_murailles_newsletter',    'murailles_handle_newsletter' );
add_action( 'wp_ajax_murailles_newsletter',           'murailles_handle_newsletter' );

/* -------------------------------------------------------------------------
 * Form: Property inquiry (single-property.php)
 * ---------------------------------------------------------------------- */

function murailles_handle_property_inquiry() {
	if ( ! murailles_form_is_legit( 'murailles_property_inquiry' ) ) {
		murailles_form_response( false, murailles_form_i18n( 'Requête invalide. Merci de réessayer.', 'Invalid request. Please try again.' ) );
	}

	$name        = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email       = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone       = isset( $_POST['phone'] ) ? murailles_normalize_phone( wp_unslash( $_POST['phone'] ) ) : '';
	$message     = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';
	$property_id = isset( $_POST['property_id'] ) ? absint( $_POST['property_id'] ) : 0;
	$context     = murailles_form_context();

	if ( ! $name || ! is_email( $email ) || ! $message || ! $property_id ) {
		murailles_form_response( false, murailles_form_i18n( 'Merci de renseigner votre nom, votre e-mail et votre message.', 'Please provide your name, email, and message.' ) );
	}

	$property_title = get_the_title( $property_id );
	$property_url   = get_permalink( $property_id );
	$fields         = array(
		'name'        => $name,
		'email'       => $email,
		'phone'       => $phone,
		'message'     => $message,
		'property_id' => $property_id,
		'property'    => $property_title,
	);

	$admin_html = murailles_email_admin(
		'Nouvelle demande sur un bien',
		'Un visiteur demande plus d\'informations sur un bien publié.',
		array(
			'Langue'     => esc_html( strtoupper( $context['language'] ) ),
			'Page'       => '<a href="' . esc_url( $context['page_url'] ) . '" style="color:#dc3545;">' . esc_html( $context['page_url'] ) . '</a>',
			'Bien'       => '<a href="' . esc_url( $property_url ) . '" style="color:#dc3545;">' . esc_html( $property_title ) . '</a>',
			'Nom'        => esc_html( $name ),
			'E-mail'     => '<a href="mailto:' . esc_attr( $email ) . '" style="color:#dc3545;">' . esc_html( $email ) . '</a>',
			'Téléphone'  => esc_html( $phone ?: '—' ),
			'Message'    => nl2br( esc_html( $message ) ),
		),
		'Voir le bien',
		$property_url
	);

	murailles_save_lead( 'property_inquiry', 'Demande bien — ' . $property_title, $fields, $admin_html );
	murailles_send_mail(
		murailles_form_notification_recipient(),
		'[Agence Murailles] Demande bien — ' . $property_title,
		$admin_html,
		$email
	);

	$user_html = murailles_email_user(
		murailles_first_name( $name ),
		murailles_form_i18n( 'Votre demande a bien été reçue', 'Your request has been received' ),
		murailles_form_i18n(
			'<p>Merci pour votre intérêt pour <strong>' . esc_html( $property_title ) . '</strong>.</p><p>Notre équipe vous recontactera rapidement avec les informations complémentaires sur ce bien.</p>',
			'<p>Thank you for your interest in <strong>' . esc_html( $property_title ) . '</strong>.</p><p>Our team will contact you shortly with more information about this property.</p>'
		),
		murailles_form_i18n( '<p style="margin:0;"><strong>Votre message :</strong></p>', '<p style="margin:0;"><strong>Your message:</strong></p>' )
		. '<p style="margin:8px 0 0;padding:12px 16px;background:#fff;border-left:3px solid #dc3545;border-radius:4px;font-style:italic;">' . nl2br( esc_html( $message ) ) . '</p>'
	);
	murailles_send_mail( $email, murailles_form_i18n( 'Votre demande — Agence Murailles', 'Your request — Agence Murailles' ), $user_html );

	murailles_form_response( true, murailles_form_i18n( 'Merci ! Votre demande a bien été envoyée. Notre équipe vous répondra rapidement.', 'Thank you. Your request has been sent. Our team will get back to you shortly.' ) );
}
add_action( 'admin_post_nopriv_murailles_property_inquiry', 'murailles_handle_property_inquiry' );
add_action( 'admin_post_murailles_property_inquiry',        'murailles_handle_property_inquiry' );
add_action( 'wp_ajax_nopriv_murailles_property_inquiry',    'murailles_handle_property_inquiry' );
add_action( 'wp_ajax_murailles_property_inquiry',           'murailles_handle_property_inquiry' );

/* -------------------------------------------------------------------------
 * Form: Submit property (submit-property.php)
 * Creates a DRAFT property post + uploads photos + emails admin.
 * ---------------------------------------------------------------------- */

function murailles_handle_submit_property() {
	if ( ! murailles_form_is_legit( 'murailles_submit_property' ) ) {
		murailles_form_response( false, 'Requête invalide. Merci de réessayer.' );
	}

	$title       = isset( $_POST['property_title'] ) ? sanitize_text_field( wp_unslash( $_POST['property_title'] ) ) : '';
	$status      = isset( $_POST['status'] )         ? sanitize_text_field( wp_unslash( $_POST['status'] ) )         : '';
	$ptype       = isset( $_POST['ptypes'] )         ? sanitize_text_field( wp_unslash( $_POST['ptypes'] ) )         : '';
	$price       = isset( $_POST['price'] )          ? sanitize_text_field( wp_unslash( $_POST['price'] ) )          : '';
	$area        = isset( $_POST['area'] )           ? sanitize_text_field( wp_unslash( $_POST['area'] ) )           : '';
	$bedrooms    = isset( $_POST['bedrooms'] )       ? sanitize_text_field( wp_unslash( $_POST['bedrooms'] ) )       : '';
	$bathrooms   = isset( $_POST['bathrooms'] )      ? sanitize_text_field( wp_unslash( $_POST['bathrooms'] ) )      : '';
	$address     = isset( $_POST['address'] )        ? sanitize_text_field( wp_unslash( $_POST['address'] ) )        : '';
	$city        = isset( $_POST['city'] )           ? sanitize_text_field( wp_unslash( $_POST['city'] ) )           : '';
	$state       = isset( $_POST['state'] )          ? sanitize_text_field( wp_unslash( $_POST['state'] ) )          : '';
	$zip         = isset( $_POST['zip_code'] )       ? sanitize_text_field( wp_unslash( $_POST['zip_code'] ) )       : '';
	$description = isset( $_POST['description'] )   ? sanitize_textarea_field( wp_unslash( $_POST['description'] ) ) : '';
	$building_age = isset( $_POST['building_age'] ) ? sanitize_text_field( wp_unslash( $_POST['building_age'] ) )    : '';
	$garage      = isset( $_POST['garage'] )         ? sanitize_text_field( wp_unslash( $_POST['garage'] ) )         : '';
	$rooms       = isset( $_POST['rooms'] )          ? sanitize_text_field( wp_unslash( $_POST['rooms'] ) )          : '';
	$contact_name  = isset( $_POST['contact_name'] )  ? sanitize_text_field( wp_unslash( $_POST['contact_name'] ) )  : '';
	$contact_email = isset( $_POST['contact_email'] ) ? sanitize_email( wp_unslash( $_POST['contact_email'] ) )      : '';
	$contact_phone = isset( $_POST['contact_phone'] ) ? murailles_normalize_phone( wp_unslash( $_POST['contact_phone'] ) ) : '';
	$features    = isset( $_POST['features'] ) && is_array( $_POST['features'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['features'] ) ) : array();

	if ( ! $title || ! $contact_name || ! is_email( $contact_email ) ) {
		murailles_form_response( false, 'Merci de renseigner au minimum le titre du bien, votre nom et votre e-mail.' );
	}

	$context = murailles_form_context();
	$post_id = murailles_save_property_submission( array(
		'post_title'   => $title,
		'post_content' => $description,
		'meta'         => array(
			'_submission_status'          => 'pending',
			'_submission_language'        => $context['language'],
			'_submission_page_url'        => $context['page_url'],
			'_submission_ip'              => $context['ip'],
			'_submission_ua'              => $context['ua'],
			'_submission_property_title'  => $title,
			'_submission_property_status' => $status,
			'_submission_property_type'   => $ptype,
			'_submission_price'           => $price,
			'_submission_area'            => $area,
			'_submission_bedrooms'        => $bedrooms,
			'_submission_bathrooms'       => $bathrooms,
			'_submission_address'         => $address,
			'_submission_city'            => $city,
			'_submission_state'           => $state,
			'_submission_zip_code'        => $zip,
			'_submission_building_age'    => $building_age,
			'_submission_garage'          => $garage,
			'_submission_rooms'           => $rooms,
			'_submission_owner_name'      => $contact_name,
			'_submission_owner_email'     => $contact_email,
			'_submission_owner_phone'     => $contact_phone,
			'_submission_features'        => $features,
		),
	) );

	if ( ! $post_id ) {
		murailles_form_response( false, 'Une erreur est survenue lors de l\'enregistrement. Merci de réessayer.' );
	}

	$upload_result = murailles_handle_gallery_uploads( 'gallery', $post_id );
	$uploaded_ids  = $upload_result['ids'];
	if ( ! empty( $uploaded_ids ) ) {
		set_post_thumbnail( $post_id, $uploaded_ids[0] );
		update_post_meta( $post_id, '_submission_gallery_ids', implode( ',', $uploaded_ids ) );
	}
	$edit_link     = admin_url( 'post.php?action=edit&post=' . $post_id );
	$full_addr     = trim( $address . ', ' . $city . ' ' . $zip, ', ' );

	$admin_html = murailles_email_admin(
		'Nouvelle soumission de bien',
		'Une nouvelle annonce a été reçue via le formulaire « Déposer une annonce ». Elle a été enregistrée dans la file interne de modération et n\'est pas publique.',
		array(
			'Langue'         => esc_html( strtoupper( $context['language'] ) ),
			'Page'           => '<a href="' . esc_url( $context['page_url'] ) . '" style="color:#dc3545;">' . esc_html( $context['page_url'] ) . '</a>',
			'Titre'          => esc_html( $title ),
			'Statut'         => esc_html( $status ),
			'Type'           => esc_html( $ptype ),
			'Prix'           => $price ? esc_html( $price ) . ' MAD' : '—',
			'Surface'        => $area ? esc_html( $area ) . ' m²' : '—',
			'Chambres / SdB' => esc_html( ( $bedrooms ?: '—' ) . ' / ' . ( $bathrooms ?: '—' ) ),
			'Adresse'        => esc_html( $full_addr ),
			'Description'    => nl2br( esc_html( $description ) ),
			'Équipements'    => esc_html( implode( ', ', $features ) ?: '—' ),
			'Déposé par'     => esc_html( $contact_name ) . ' &lt;<a href="mailto:' . esc_attr( $contact_email ) . '" style="color:#dc3545;">' . esc_html( $contact_email ) . '</a>&gt; ' . esc_html( $contact_phone ),
			'Photos'         => count( $uploaded_ids ) . ' photo(s) reçue(s)',
			'Statut interne' => 'Pending',
		),
		'Examiner la soumission',
		$edit_link
	);

	murailles_save_lead( 'submit_property', 'Soumission bien — ' . $title, array(
		'submission_id'  => $post_id,
		'title'          => $title,
		'price'          => $price,
		'city'           => $city,
		'contact_name'   => $contact_name,
		'contact_email'  => $contact_email,
		'contact_phone'  => $contact_phone,
	), $admin_html );

	murailles_send_mail(
		murailles_form_notification_recipient(),
		'[Agence Murailles] Nouvelle soumission — ' . $title,
		$admin_html,
		$contact_email
	);

	$user_html = murailles_email_user(
		murailles_first_name( $contact_name ),
		murailles_form_i18n( 'Votre annonce a bien été reçue', 'Your property submission has been received' ),
		murailles_form_i18n(
			'<p>Merci d\'avoir choisi <strong>Agence Murailles</strong> pour votre projet immobilier.</p><p>Votre annonce <strong>« ' . esc_html( $title ) . ' »</strong> a bien été transmise à notre équipe. Elle reste en <strong>révision interne</strong> jusqu\'à validation manuelle.</p><p>Un conseiller pourra vous contacter pour compléter le dossier ou planifier la mise en ligne.</p>',
			'<p>Thank you for choosing <strong>Agence Murailles</strong> for your real estate project.</p><p>Your property submission <strong>“' . esc_html( $title ) . '”</strong> has been received by our team. It stays in <strong>internal review</strong> until manually approved.</p><p>An advisor may contact you to complete the file or prepare publication.</p>'
		),
		murailles_form_i18n( '<p style="margin:0 0 12px;"><strong>Récapitulatif de votre annonce :</strong></p>', '<p style="margin:0 0 12px;"><strong>Your submission summary:</strong></p>' )
		. murailles_email_kv_table( array(
			'Type'           => esc_html( $ptype ) . ' — ' . esc_html( $status ),
			'Prix'           => $price ? esc_html( $price ) . ' MAD' : 'à définir',
			'Surface'        => $area ? esc_html( $area ) . ' m²' : '—',
			'Chambres / SdB' => esc_html( ( $bedrooms ?: '—' ) . ' / ' . ( $bathrooms ?: '—' ) ),
			'Adresse'        => esc_html( $full_addr ),
			'Photos'         => count( $uploaded_ids ) . ' photo(s) reçue(s)',
		) )
	);
	if ( ! empty( $upload_result['errors'] ) ) {
		$user_html .= '<p style="margin-top:16px;color:#856404;">' . esc_html( implode( ' ', $upload_result['errors'] ) ) . '</p>';
	}
	murailles_send_mail( $contact_email, murailles_form_i18n( 'Votre annonce — Agence Murailles', 'Your submission — Agence Murailles' ), $user_html );

	$success_message = murailles_form_i18n(
		'Merci ! Votre annonce a bien été enregistrée dans notre file interne de validation. Elle ne sera jamais publiée automatiquement.',
		'Thank you. Your property has been saved in our internal review queue. It will never be published automatically.'
	);
	if ( ! empty( $upload_result['errors'] ) ) {
		$success_message .= ' ' . implode( ' ', $upload_result['errors'] );
	}

	murailles_form_response( true, $success_message );

	// Create the property as draft for admin review
	$post_id = wp_insert_post( array(
		'post_type'    => post_type_exists( 'property' ) ? 'property' : 'post',
		'post_status'  => 'draft',
		'post_title'   => $title,
		'post_content' => $description,
	) );

	if ( is_wp_error( $post_id ) || ! $post_id ) {
		murailles_form_response( false, 'Une erreur est survenue lors de l\'enregistrement. Merci de réessayer.' );
	}

	// Save meta with the same keys archive-property.php reads
	update_post_meta( $post_id, '_property_price',      $price );
	update_post_meta( $post_id, '_property_action',     $status === 'vente' ? 'À vendre' : ( $status === 'location' ? 'À louer' : '' ) );
	update_post_meta( $post_id, '_property_address',    trim( $address . ', ' . $city . ' ' . $zip, ', ' ) );
	update_post_meta( $post_id, '_property_size',       $area );
	update_post_meta( $post_id, '_property_bedrooms',   $bedrooms );
	update_post_meta( $post_id, '_property_bathrooms',  $bathrooms );
	update_post_meta( $post_id, '_property_rooms',      $rooms );
	update_post_meta( $post_id, '_property_garage',     $garage );
	update_post_meta( $post_id, '_property_building_age', $building_age );
	update_post_meta( $post_id, '_property_features',   $features );
	update_post_meta( $post_id, '_property_contact_name',  $contact_name );
	update_post_meta( $post_id, '_property_contact_email', $contact_email );
	update_post_meta( $post_id, '_property_contact_phone', $contact_phone );

	// Taxonomies if they exist
	if ( $ptype && taxonomy_exists( 'property_category' ) ) {
		wp_set_object_terms( $post_id, $ptype, 'property_category' );
	}
	if ( $city && taxonomy_exists( 'property_location' ) ) {
		wp_set_object_terms( $post_id, $city, 'property_location' );
	}

	// Handle uploaded images (multiple under name="gallery[]")
	$uploaded_ids = array();
	if ( ! empty( $_FILES['gallery'] ) && is_array( $_FILES['gallery']['name'] ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';

		foreach ( $_FILES['gallery']['name'] as $i => $name ) {
			if ( empty( $name ) || ! empty( $_FILES['gallery']['error'][ $i ] ) ) {
				continue;
			}
			$single_file = array(
				'name'     => $_FILES['gallery']['name'][ $i ],
				'type'     => $_FILES['gallery']['type'][ $i ],
				'tmp_name' => $_FILES['gallery']['tmp_name'][ $i ],
				'error'    => $_FILES['gallery']['error'][ $i ],
				'size'     => $_FILES['gallery']['size'][ $i ],
			);
			$_FILES = array( 'gallery_single' => $single_file );
			$attach_id = media_handle_upload( 'gallery_single', $post_id );
			if ( ! is_wp_error( $attach_id ) ) {
				$uploaded_ids[] = $attach_id;
			}
		}
		if ( ! empty( $uploaded_ids ) ) {
			set_post_thumbnail( $post_id, $uploaded_ids[0] );
			update_post_meta( $post_id, '_property_gallery_ids', implode( ',', $uploaded_ids ) );
		}
	}

	$edit_link  = admin_url( 'post.php?action=edit&post=' . $post_id );
	$full_addr  = trim( $address . ', ' . $city . ' ' . $zip, ', ' );

	$admin_html = murailles_email_admin(
		'Nouvelle annonce déposée',
		'Une nouvelle annonce a été soumise via le formulaire « Déposer une annonce ». Elle est en brouillon en attente de votre validation.',
		array(
			'Titre'           => esc_html( $title ),
			'Statut'          => esc_html( $status ),
			'Type'            => esc_html( $ptype ),
			'Prix'            => $price ? esc_html( $price ) . ' €' : '—',
			'Surface'         => $area ? esc_html( $area ) . ' m²' : '—',
			'Chambres / SdB'  => esc_html( ( $bedrooms ?: '—' ) . ' / ' . ( $bathrooms ?: '—' ) ),
			'Adresse'         => esc_html( $full_addr ),
			'Description'     => nl2br( esc_html( $description ) ),
			'Équipements'     => esc_html( implode( ', ', $features ) ?: '—' ),
			'Déposé par'      => esc_html( $contact_name ) . ' &lt;<a href="mailto:' . esc_attr( $contact_email ) . '" style="color:#dc3545;">' . esc_html( $contact_email ) . '</a>&gt; ' . esc_html( $contact_phone ),
			'Photos'          => count( $uploaded_ids ) . ' photo(s) ajoutée(s)',
		),
		'Vérifier et publier l\'annonce',
		$edit_link
	);

	murailles_save_lead( 'submit_property', 'Annonce — ' . $title, array(
		'property_post_id' => $post_id,
		'title'            => $title,
		'price'            => $price,
		'city'             => $city,
		'contact_name'     => $contact_name,
		'contact_email'    => $contact_email,
		'contact_phone'    => $contact_phone,
	), $admin_html );

	murailles_send_mail(
		murailles_form_notification_recipient(),
		'[Agence Murailles] Nouvelle annonce — ' . $title,
		$admin_html,
		$contact_email
	);

	// User confirmation — recap of their listing
	$user_html = murailles_email_user(
		murailles_first_name( $contact_name ),
		'Votre annonce a bien été enregistrée',
		'<p>Merci d\'avoir choisi <strong>Agence Murailles</strong> pour la mise en ligne de votre bien.</p>'
		. '<p>Votre annonce <strong>« ' . esc_html( $title ) . ' »</strong> a été enregistrée avec succès. Notre équipe va l\'examiner et la publier sous <strong>48 heures ouvrées</strong> après vérification des informations.</p>'
		. '<p>Un conseiller pourrait vous contacter pour préciser certains détails ou vous proposer des photos professionnelles.</p>',
		'<p style="margin:0 0 12px;"><strong>Récapitulatif de votre annonce :</strong></p>'
		. murailles_email_kv_table( array(
			'Type'           => esc_html( $ptype ) . ' — ' . esc_html( $status ),
			'Prix'           => $price ? esc_html( $price ) . ' €' : 'à définir',
			'Surface'        => $area ? esc_html( $area ) . ' m²' : '—',
			'Chambres / SdB' => esc_html( ( $bedrooms ?: '—' ) . ' / ' . ( $bathrooms ?: '—' ) ),
			'Adresse'        => esc_html( $full_addr ),
			'Photos'         => count( $uploaded_ids ) . ' photo(s) reçue(s)',
		) )
	);
	murailles_send_mail( $contact_email, 'Votre annonce — Agence Murailles', $user_html );

	murailles_form_response( true, 'Merci ! Votre annonce a été enregistrée et sera publiée après vérification par notre équipe. Vous recevez un e-mail de confirmation.' );
}
add_action( 'admin_post_nopriv_murailles_submit_property', 'murailles_handle_submit_property' );
add_action( 'admin_post_murailles_submit_property',        'murailles_handle_submit_property' );
add_action( 'wp_ajax_nopriv_murailles_submit_property',    'murailles_handle_submit_property' );
add_action( 'wp_ajax_murailles_submit_property',           'murailles_handle_submit_property' );

/* -------------------------------------------------------------------------
 * Frontend assets + localised AJAX endpoint
 * ---------------------------------------------------------------------- */

add_action( 'wp_enqueue_scripts', function () {
	$theme_uri = get_template_directory_uri();
	$script    = get_template_directory() . '/assets/js/forms.js';
	$ver       = file_exists( $script ) ? filemtime( $script ) : wp_get_theme()->get( 'Version' );
	wp_enqueue_script( 'murailles-forms', $theme_uri . '/assets/js/forms.js', array( 'jquery' ), $ver, true );
	wp_localize_script( 'murailles-forms', 'MuraillesForms', array(
		'ajax_url'           => admin_url( 'admin-ajax.php' ),
		'msg_sending'        => 'Envoi en cours…',
		'msg_default_error'  => 'Une erreur est survenue. Merci de réessayer.',
	) );
} );
