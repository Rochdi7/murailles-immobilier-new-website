<?php
/**
 * Multi-currency support for properties (biens).
 *
 * - Each property stores its own base currency in the `_property_currency` meta
 *   (MAD | EUR | USD). The raw amount in `_property_price` is expressed in that
 *   currency.
 * - On the front office, a small switcher (single-property + property archive)
 *   lets the visitor convert any price to MAD / EUR / USD using exchange rates
 *   configured in the theme options. The choice is remembered in localStorage.
 * - Large numbers are always grouped with the correct thousands separator per
 *   currency convention (space for MAD/EUR-fr, comma for USD).
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Supported currencies and their display rules.
 *
 * symbol      : displayed currency symbol / code.
 * position    : 'after' (1 500 000 MAD) or 'before' ($1,500,000).
 * thousands   : thousands separator used for grouping big numbers.
 * decimals    : default number of decimals shown (prices are whole amounts).
 * dec_point   : decimal separator.
 *
 * @return array<string,array>
 */
function murailles_get_currencies() {
	return array(
		'MAD' => array(
			'code'      => 'MAD',
			'label'     => 'Dirham (MAD)',
			'symbol'    => 'MAD',
			'position'  => 'after',
			'thousands' => ' ',
			'decimals'  => 0,
			'dec_point' => ',',
		),
		'EUR' => array(
			'code'      => 'EUR',
			'label'     => 'Euro (€)',
			'symbol'    => '€',
			'position'  => 'after',
			'thousands' => ' ',
			'decimals'  => 0,
			'dec_point' => ',',
		),
		'USD' => array(
			'code'      => 'USD',
			'label'     => 'Dollar ($)',
			'symbol'    => '$',
			'position'  => 'before',
			'thousands' => ',',
			'decimals'  => 0,
			'dec_point' => '.',
		),
	);
}

/**
 * Default currency used when a property has none stored.
 *
 * @return string
 */
function murailles_default_currency() {
	$default = murailles_opt( 'currency_default', 'MAD' );
	return array_key_exists( $default, murailles_get_currencies() ) ? $default : 'MAD';
}

/**
 * Exchange rates expressed as: 1 unit of <currency> = X MAD.
 *
 * MAD is the pivot currency (rate 1). The EUR/USD rates are editable in the
 * theme options ("Devises / Currency"). Defaults are reasonable round numbers
 * and should be reviewed by the admin.
 *
 * @return array<string,float>
 */
function murailles_currency_rates() {
	$rates = array(
		'MAD' => 1.0,
		'EUR' => (float) murailles_opt( 'rate_eur', 10.8 ), // 1 EUR = 10.8 MAD
		'USD' => (float) murailles_opt( 'rate_usd', 10.0 ), // 1 USD = 10.0 MAD
	);

	foreach ( $rates as $code => $rate ) {
		if ( $rate <= 0 ) {
			$rates[ $code ] = 1.0;
		}
	}

	return $rates;
}

/**
 * Normalise a free-text price (e.g. "1 500 000", "1,500,000", "1500000.00")
 * into a float. Returns null when nothing numeric is present.
 *
 * @param mixed $raw Stored price meta.
 * @return float|null
 */
function murailles_parse_price_number( $raw ) {
	if ( is_int( $raw ) || is_float( $raw ) ) {
		return (float) $raw;
	}

	$raw = trim( (string) $raw );
	if ( '' === $raw ) {
		return null;
	}

	// Strip everything except digits, separators and sign.
	$clean = preg_replace( '/[^0-9.,\-]/', '', $raw );
	if ( '' === $clean ) {
		return null;
	}

	// If both separators exist, the last one is the decimal separator.
	$last_dot   = strrpos( $clean, '.' );
	$last_comma = strrpos( $clean, ',' );

	if ( false !== $last_dot && false !== $last_comma ) {
		if ( $last_comma > $last_dot ) {
			// 1.500.000,50 → comma is decimal.
			$clean = str_replace( '.', '', $clean );
			$clean = str_replace( ',', '.', $clean );
		} else {
			// 1,500,000.50 → dot is decimal.
			$clean = str_replace( ',', '', $clean );
		}
	} elseif ( false !== $last_comma ) {
		// Only commas. Treat as thousands unless it looks like 1234,56.
		$decimals = strlen( $clean ) - $last_comma - 1;
		if ( 1 === substr_count( $clean, ',' ) && $decimals > 0 && $decimals <= 2 ) {
			$clean = str_replace( ',', '.', $clean );
		} else {
			$clean = str_replace( ',', '', $clean );
		}
	} elseif ( false !== $last_dot ) {
		// Only dots. Treat as thousands unless it looks like a single decimal group.
		$decimals = strlen( $clean ) - $last_dot - 1;
		if ( substr_count( $clean, '.' ) > 1 || $decimals === 3 ) {
			$clean = str_replace( '.', '', $clean );
		}
	}

	if ( ! is_numeric( $clean ) ) {
		return null;
	}

	return (float) $clean;
}

/**
 * Convert an amount from one currency to another using the configured rates.
 *
 * @param float  $amount Amount in $from currency.
 * @param string $from   Source currency code.
 * @param string $to     Target currency code.
 * @return float
 */
function murailles_convert_currency( $amount, $from, $to ) {
	$rates = murailles_currency_rates();
	$from  = isset( $rates[ $from ] ) ? $from : murailles_default_currency();
	$to    = isset( $rates[ $to ] ) ? $to : murailles_default_currency();

	if ( $from === $to ) {
		return (float) $amount;
	}

	// Convert to MAD pivot, then to the target currency.
	$in_mad = (float) $amount * $rates[ $from ];
	return $in_mad / $rates[ $to ];
}

/**
 * Format a numeric amount with the grouping/symbol rules of a given currency.
 * Big numbers are always grouped (e.g. 1 500 000 MAD, $1,500,000).
 *
 * @param float|null $amount   Numeric amount (already in $currency).
 * @param string     $currency Currency code.
 * @return string
 */
function murailles_format_currency_amount( $amount, $currency ) {
	$currencies = murailles_get_currencies();
	if ( ! isset( $currencies[ $currency ] ) ) {
		$currency = murailles_default_currency();
	}
	$c = $currencies[ $currency ];

	if ( null === $amount ) {
		return '';
	}

	// Prices are whole amounts; converted values are rounded to the currency's
	// decimal count (0 for MAD/EUR/USD here) so big numbers stay clean.
	$decimals = max( (int) $c['decimals'], 0 );

	$number = number_format( (float) $amount, $decimals, $c['dec_point'], $c['thousands'] );

	if ( 'before' === $c['position'] ) {
		return $c['symbol'] . $number;
	}
	return $number . ' ' . $c['symbol'];
}

/**
 * Render a property's price for the front office, wrapped in markup the
 * front-office switcher can convert live without a page reload.
 *
 * Returns an empty string when the property has no numeric price.
 *
 * @param int    $post_id    Property ID.
 * @param string $extra_class Extra class for the wrapper (optional).
 * @return string HTML
 */
function murailles_price_html( $post_id, $extra_class = '' ) {
	$raw      = get_post_meta( $post_id, '_property_price', true );
	$amount   = murailles_parse_price_number( $raw );
	$currency = get_post_meta( $post_id, '_property_currency', true );

	$currencies = murailles_get_currencies();
	if ( ! isset( $currencies[ $currency ] ) ) {
		$currency = murailles_default_currency();
	}

	// No numeric price → fall back to the raw label (e.g. "Sur demande").
	if ( null === $amount ) {
		$raw = trim( (string) $raw );
		if ( '' === $raw ) {
			return '';
		}
		return '<span class="murailles-price">' . esc_html( $raw ) . '</span>';
	}

	$formatted = murailles_format_currency_amount( $amount, $currency );

	$class = 'murailles-price js-price';
	if ( $extra_class ) {
		$class .= ' ' . sanitize_html_class( $extra_class );
	}

	// data-amount + data-currency let the JS recompute from the base currency.
	return sprintf(
		'<span class="%1$s" data-amount="%2$s" data-currency="%3$s">%4$s</span>',
		esc_attr( $class ),
		esc_attr( (string) $amount ),
		esc_attr( $currency ),
		esc_html( $formatted )
	);
}

/* ╔═══════════════════════════════════════════════════╗
   ║  Front-office assets (switcher) — property pages   ║
   ╚═══════════════════════════════════════════════════╝ */

/**
 * Should the currency switcher load on the current view?
 * Only on single property pages and the property archive/listing.
 *
 * @return bool
 */
function murailles_currency_pages() {
	return is_singular( 'property' )
		|| is_post_type_archive( 'property' )
		|| is_tax( array( 'property_category', 'property_location', 'property_area' ) )
		|| is_page_template( 'page-templates/single-property-1.php' );
}

function murailles_currency_enqueue() {
	if ( ! murailles_currency_pages() ) {
		return;
	}

	$theme_uri = get_template_directory_uri();

	wp_enqueue_style(
		'murailles-currency',
		$theme_uri . '/assets/css/murailles-currency.css',
		array(),
		murailles_asset_version( 'assets/css/murailles-currency.css' )
	);

	wp_enqueue_script(
		'murailles-currency',
		$theme_uri . '/assets/js/murailles-currency.js',
		array(),
		murailles_asset_version( 'assets/js/murailles-currency.js' ),
		true
	);

	$currencies = murailles_get_currencies();
	$config     = array();
	foreach ( $currencies as $code => $c ) {
		$config[ $code ] = array(
			'symbol'    => $c['symbol'],
			'position'  => $c['position'],
			'thousands' => $c['thousands'],
			'dec_point' => $c['dec_point'],
			'decimals'  => $c['decimals'],
			'label'     => $c['label'],
		);
	}

	wp_localize_script(
		'murailles-currency',
		'MURAILLES_CURRENCY',
		array(
			'currencies' => $config,
			'rates'      => murailles_currency_rates(),
			'default'    => murailles_default_currency(),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'murailles_currency_enqueue' );

/**
 * Render the front-office switcher control (MAD / EUR / USD buttons).
 *
 * @param array $args { 'class' => string }
 * @return void
 */
function murailles_currency_switcher( $args = array() ) {
	$currencies = murailles_get_currencies();
	$default    = murailles_default_currency();
	$class      = isset( $args['class'] ) ? $args['class'] : '';

	echo '<div class="murailles-currency-switcher ' . esc_attr( $class ) . '" data-default="' . esc_attr( $default ) . '" role="group" aria-label="' . esc_attr( murailles_t( 'Devise', false ) ) . '">';
	echo '<span class="mcs-label">' . esc_html( murailles_t( 'Devise', false ) ) . ' :</span>';
	foreach ( $currencies as $code => $c ) {
		printf(
			'<button type="button" class="mcs-btn%1$s" data-currency="%2$s">%3$s</button>',
			$code === $default ? ' is-active' : '',
			esc_attr( $code ),
			esc_html( $c['code'] )
		);
	}
	echo '</div>';
}
