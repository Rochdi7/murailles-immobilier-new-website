<?php
/**
 * wp-config.php — PRODUCTION TEMPLATE
 * =====================================
 * Fill in the values marked with <<REPLACE>> before uploading.
 * This file goes in: public_html/wp-config.php
 *
 * DO NOT commit this file to git.
 */

// ── Database (from Hostinger cPanel → MySQL Databases) ────────────────────
define( 'DB_NAME',     '<<REPLACE: your_db_name>>' );
define( 'DB_USER',     '<<REPLACE: your_db_user>>' );
define( 'DB_PASSWORD', '<<REPLACE: your_db_password>>' );
define( 'DB_HOST',     'localhost' );
define( 'DB_CHARSET',  'utf8mb4' );
define( 'DB_COLLATE',  '' );

// ── Security Keys (generate fresh ones at: https://api.wordpress.org/secret-key/1.1/salt/) ──
define( 'AUTH_KEY',         '<<REPLACE>>' );
define( 'SECURE_AUTH_KEY',  '<<REPLACE>>' );
define( 'LOGGED_IN_KEY',    '<<REPLACE>>' );
define( 'NONCE_KEY',        '<<REPLACE>>' );
define( 'AUTH_SALT',        '<<REPLACE>>' );
define( 'SECURE_AUTH_SALT', '<<REPLACE>>' );
define( 'LOGGED_IN_SALT',   '<<REPLACE>>' );
define( 'NONCE_SALT',       '<<REPLACE>>' );

// ── Debug — ALL false on production ───────────────────────────────────────
define( 'WP_DEBUG',         false );
define( 'WP_DEBUG_LOG',     false );
define( 'WP_DEBUG_DISPLAY', false );

// ── SMTP — Gmail App Password ─────────────────────────────────────────────
// Generate App Password: Google Account → Security → 2-Step → App passwords
define( 'MURAILLES_SMTP_HOST',      'smtp.gmail.com' );
define( 'MURAILLES_SMTP_PORT',      587 );
define( 'MURAILLES_SMTP_SECURE',    'tls' );
define( 'MURAILLES_SMTP_USER',      '<<REPLACE: your@gmail.com>>' );
define( 'MURAILLES_SMTP_PASS',      '<<REPLACE: 16-char-app-password>>' );
define( 'MURAILLES_SMTP_FROM',      '<<REPLACE: your@gmail.com>>' );
define( 'MURAILLES_SMTP_FROM_NAME', 'Agence Murailles' );
define( 'MURAILLES_LEAD_NOTIFY',    '<<REPLACE: your@gmail.com>>' );

// ── Performance ───────────────────────────────────────────────────────────
define( 'WP_MEMORY_LIMIT',    '256M' );
define( 'WP_MAX_MEMORY_LIMIT','256M' );
define( 'FORCE_SSL_ADMIN',    true );
define( 'DISALLOW_FILE_EDIT', true );   // disables theme/plugin file editor in admin

// ── Table prefix ─────────────────────────────────────────────────────────
$table_prefix = 'wp_';

// ── Absolute path ─────────────────────────────────────────────────────────
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}
require_once ABSPATH . 'wp-settings.php';
