<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'murailles_security_normalize_text' ) ) {
	function murailles_security_normalize_text( $value ) {
		$value = is_string( $value ) ? $value : '';
		$value = wp_strip_all_tags( $value );
		$value = remove_accents( $value );

		return strtolower( $value );
	}
}

if ( ! function_exists( 'murailles_security_is_suspicious_post' ) ) {
	function murailles_security_is_suspicious_post( $title, $content = '' ) {
		$title   = murailles_security_normalize_text( $title );
		$content = murailles_security_normalize_text( $content );

		$bad_title_fragments = array(
			'anti-porn crack',
			'activator windows 10',
			'control resonant goty',
			'cyberpunk 2 goty',
			'virtualdj 2025 portable',
			'office 2016 small business arm',
			'pre-activated command',
		);

		$bad_content_fragments = array(
			'generating crack code',
			'rpc.mevblocker.io',
			'ethereum-rpc.publicnode.com',
			'1rpc.io/eth',
			'hash-code:',
			'offline license injector',
			'valid license keys',
			'portable + crack',
			'captchacanvas',
			'window.dov=async function',
			'avx2 instruction set required',
		);

		foreach ( $bad_title_fragments as $fragment ) {
			if ( false !== strpos( $title, $fragment ) ) {
				return true;
			}
		}

		foreach ( $bad_content_fragments as $fragment ) {
			if ( false !== strpos( $content, $fragment ) ) {
				return true;
			}
		}

		return false;
	}
}

if ( ! function_exists( 'murailles_security_log_blocked_post' ) ) {
	function murailles_security_log_blocked_post( $title, $context = '' ) {
		$user = wp_get_current_user();
		$who  = $user instanceof WP_User && $user->exists() ? $user->user_login : 'anonymous';

		error_log(
			sprintf(
				'[murailles-security] blocked suspicious post (%s) by %s: %s',
				$context ? $context : 'unknown',
				$who,
				is_string( $title ) ? $title : ''
			)
		);
	}
}

add_filter( 'xmlrpc_enabled', '__return_false' );

add_filter(
	'rest_pre_insert_post',
	function ( $prepared_post, $request ) {
		if ( is_wp_error( $prepared_post ) ) {
			return $prepared_post;
		}

		$title   = isset( $prepared_post->post_title ) ? $prepared_post->post_title : '';
		$content = isset( $prepared_post->post_content ) ? $prepared_post->post_content : '';

		if ( murailles_security_is_suspicious_post( $title, $content ) ) {
			murailles_security_log_blocked_post( $title, 'rest_pre_insert_post' );

			return new WP_Error(
				'murailles_blocked_post',
				'Blocked suspicious post content.',
				array( 'status' => 403 )
			);
		}

		return $prepared_post;
	},
	10,
	2
);

add_filter(
	'wp_insert_post_data',
	function ( $data, $postarr ) {
		$post_type = isset( $data['post_type'] ) ? $data['post_type'] : '';
		if ( ! in_array( $post_type, array( 'post', 'revision' ), true ) ) {
			return $data;
		}

		$title   = isset( $data['post_title'] ) ? $data['post_title'] : '';
		$content = isset( $data['post_content'] ) ? $data['post_content'] : '';

		if ( ! murailles_security_is_suspicious_post( $title, $content ) ) {
			return $data;
		}

		murailles_security_log_blocked_post( $title, 'wp_insert_post_data' );

		$data['post_status']    = 'draft';
		$data['post_title']     = '[Blocked suspicious content]';
		$data['post_content']   = '';
		$data['post_excerpt']   = '';
		$data['comment_status'] = 'closed';
		$data['ping_status']    = 'closed';

		if ( 'post' === $post_type ) {
			$data['post_name'] = 'blocked-suspicious-content';
		}

		return $data;
	},
	99,
	2
);

if ( ! function_exists( 'murailles_security_purge_suspicious_post' ) ) {
	function murailles_security_purge_suspicious_post( $post_id, $post ) {
		static $purging = false;

		if ( $purging || ! $post instanceof WP_Post ) {
			return;
		}

		if ( ! in_array( $post->post_type, array( 'post', 'revision' ), true ) ) {
			return;
		}

		if ( ! murailles_security_is_suspicious_post( $post->post_title, $post->post_content ) ) {
			return;
		}

		$purging = true;
		murailles_security_log_blocked_post( $post->post_title, 'save_post_delete' );
		wp_delete_post( $post_id, true );
		$purging = false;
	}
}

add_action( 'save_post', 'murailles_security_purge_suspicious_post', 5, 2 );
