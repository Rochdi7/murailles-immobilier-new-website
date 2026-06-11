<?php
/**
 * Email templates — branded HTML wrappers for outgoing mail.
 *
 * Two templates:
 *  - murailles_email_admin()   : internal notification to codesommet@gmail.com
 *  - murailles_email_user()    : confirmation to the form submitter
 *
 * Both share a common chrome (murailles_email_wrap) so brand styling is centralised.
 * Designed for max email-client compatibility: inline styles, table layout, no JS.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Wrap a body of HTML in the Agence Murailles brand chrome.
 */
function murailles_email_wrap( $title, $intro_html, $body_html, $cta_label = '', $cta_url = '' ) {
	$logo  = function_exists( 'murailles_img' ) ? murailles_img( 'logo.png' ) : home_url( '/wp-content/themes/rentup-theme/assets/images/logo.png' );
	$brand = 'Agence Murailles';
	$site  = home_url( '/' );
	$year  = date( 'Y' );

	$cta_html = '';
	if ( $cta_label && $cta_url ) {
		$cta_html = sprintf(
			'<tr><td align="center" style="padding:24px 0 8px;"><a href="%s" style="display:inline-block;background:#dc3545;color:#fff;text-decoration:none;font-weight:600;font-size:15px;padding:14px 32px;border-radius:6px;font-family:Arial,Helvetica,sans-serif;">%s</a></td></tr>',
			esc_url( $cta_url ),
			esc_html( $cta_label )
		);
	}

	return '<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>' . esc_html( $title ) . '</title>
</head>
<body style="margin:0;padding:0;background:#f4f5f7;font-family:Arial,Helvetica,sans-serif;color:#2c3e50;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f4f5f7;padding:32px 16px;">
	<tr>
		<td align="center">
			<table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;width:100%;background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.06);">

				<!-- Header -->
				<tr>
					<td align="center" style="padding:32px 32px 16px;background:#ffffff;border-bottom:3px solid #dc3545;">
						<img src="' . esc_url( $logo ) . '" alt="' . esc_attr( $brand ) . '" width="180" style="max-width:180px;height:auto;display:block;">
					</td>
				</tr>

				<!-- Title + intro -->
				<tr>
					<td style="padding:32px 40px 16px;">
						<h1 style="margin:0 0 12px;font-size:22px;font-weight:700;color:#1a2332;font-family:Arial,Helvetica,sans-serif;">' . esc_html( $title ) . '</h1>
						<div style="font-size:15px;line-height:1.6;color:#4a5568;">' . wp_kses_post( $intro_html ) . '</div>
					</td>
				</tr>

				<!-- Body card -->
				<tr>
					<td style="padding:0 40px 24px;">
						<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f8f9fa;border-radius:8px;border:1px solid #e9ecef;">
							<tr><td style="padding:20px 24px;font-size:14px;line-height:1.6;color:#2c3e50;">' . $body_html . '</td></tr>
						</table>
					</td>
				</tr>

				' . $cta_html . '

				<!-- Footer -->
				' . ( function () use ( $brand, $site, $year ) {
					$ci = function_exists( 'murailles_contact_info' ) ? murailles_contact_info() : array(
						'email'         => 'contact@murailles-immobilier.com',
						'phone_display' => '+212 6 61 42 51 50',
						'address_line1' => '13 Rue Mouslim, Résidence Boukar',
						'address_city'  => 'Marrakech 40000, Maroc',
					);
					return '
				<tr>
					<td align="center" style="padding:28px 40px 32px;border-top:1px solid #e9ecef;background:#fafbfc;">
						<p style="margin:0 0 8px;font-size:13px;color:#6c757d;">
							<strong style="color:#1a2332;">' . esc_html( $brand ) . '</strong> &middot; ' . esc_html( $ci['address_line1'] ) . ', ' . esc_html( $ci['address_city'] ) . '
						</p>
						<p style="margin:0 0 8px;font-size:13px;color:#6c757d;">
							<a href="mailto:' . esc_attr( $ci['email'] ) . '" style="color:#dc3545;text-decoration:none;">' . esc_html( $ci['email'] ) . '</a> &middot;
							<a href="tel:' . esc_attr( preg_replace( '/[^0-9+]/', '', $ci['phone_display'] ) ) . '" style="color:#dc3545;text-decoration:none;">' . esc_html( $ci['phone_display'] ) . '</a> &middot;
							<a href="' . esc_url( $site ) . '" style="color:#dc3545;text-decoration:none;">' . esc_html( wp_parse_url( $site, PHP_URL_HOST ) ) . '</a>
						</p>
						<p style="margin:12px 0 0;font-size:12px;color:#adb5bd;">&copy; ' . $year . ' ' . esc_html( $brand ) . '. Tous droits réservés.</p>
					</td>
				</tr>';
				} )() . '

			</table>
		</td>
	</tr>
</table>
</body>
</html>';
}

/**
 * Build a key/value table for admin notification emails.
 */
function murailles_email_kv_table( $rows ) {
	$html = '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="font-size:14px;">';
	foreach ( $rows as $label => $value ) {
		if ( $value === '' || $value === null ) {
			$value = '—';
		}
		$html .= '<tr>'
			. '<td valign="top" style="padding:8px 12px 8px 0;color:#6c757d;font-weight:600;width:38%;border-bottom:1px solid #e9ecef;">' . esc_html( $label ) . '</td>'
			. '<td valign="top" style="padding:8px 0;color:#1a2332;border-bottom:1px solid #e9ecef;">' . wp_kses_post( $value ) . '</td>'
			. '</tr>';
	}
	$html .= '</table>';
	return $html;
}

/**
 * Internal admin notification — concise, action-oriented.
 */
function murailles_email_admin( $title, $intro, $rows, $cta_label = '', $cta_url = '' ) {
	$intro_html = '<p style="margin:0;">' . esc_html( $intro ) . '</p>';
	$body_html  = murailles_email_kv_table( $rows );
	return murailles_email_wrap( $title, $intro_html, $body_html, $cta_label, $cta_url );
}

/**
 * Public user confirmation — friendly, branded, no internal details.
 */
function murailles_email_user( $first_name, $title, $message_html, $next_steps_html = '' ) {
	$greeting = $first_name ? 'Bonjour ' . esc_html( $first_name ) . ',' : 'Bonjour,';
	$intro    = '<p style="margin:0;">' . $greeting . '</p>';
	$body     = '<div style="font-size:15px;line-height:1.7;color:#2c3e50;">' . $message_html . '</div>';
	if ( $next_steps_html ) {
		$body .= '<div style="margin-top:20px;padding-top:20px;border-top:1px solid #e9ecef;font-size:14px;color:#4a5568;">' . $next_steps_html . '</div>';
	}
	$body .= '<p style="margin:24px 0 0;font-size:14px;color:#4a5568;">Cordialement,<br><strong style="color:#1a2332;">L\'équipe Agence Murailles</strong></p>';
	return murailles_email_wrap( $title, $intro, $body );
}
