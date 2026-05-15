<?php
/**
 * Schema.org structured data (JSON-LD).
 *
 * Emits the right `@type` for each page:
 *
 *   • Site-wide (every page):  Organization + RealEstateAgent + WebSite (+ SearchAction)
 *   • Front page:              ItemList of featured properties
 *   • Property archive:        CollectionPage + ItemList
 *   • Single property:         RealEstateListing (with Offer, geo, photos)
 *   • Blog single:             BlogPosting
 *   • Blog index:              Blog
 *   • FAQ page:                FAQPage extracted from the FAQ template's <h3>/<p> pairs
 *   • Any page with breadcrumb: BreadcrumbList
 *
 * One JSON-LD <script> block per scope, no duplication.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Helper: get the agency's canonical NAP + social profile data.
 * Uses murailles_contact_info() when available, falls back to hard-coded values.
 */
function murailles_schema_agency_data() {
	$ci = function_exists( 'murailles_contact_info' ) ? murailles_contact_info() : array();
	return wp_parse_args( $ci, array(
		'address_line1' => '13 Rue Mouslim, Résidence Boukar',
		'address_line2' => '2ème étage Bureau N°10',
		'address_city'  => 'Marrakech 40000',
		'contact_name'  => 'Youssef',
		'phone_display' => '+212 6 61 42 51 50',
		'phone_tel'     => '+212661425150',
		'email'         => 'contact@murailles-immobilier.com',
		'facebook'      => '',
		'instagram'     => '',
		'twitter'       => '',
	) );
}

/**
 * Helper: encode a JSON-LD blob into a properly-formatted <script>.
 * Recursively decodes HTML entities in string values so the JSON-LD has raw
 * UTF-8 text (Google parses entities but rich-results validators flag them).
 */
function murailles_schema_print( $data ) {
	if ( empty( $data ) ) { return; }
	$data = murailles_schema_decode_entities( $data );
	echo "<script type=\"application/ld+json\">\n";
	echo wp_json_encode(
		$data,
		JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
	);
	echo "\n</script>\n";
}

/**
 * Recursively run html_entity_decode on every string in a nested array
 * (used by murailles_schema_print).
 */
function murailles_schema_decode_entities( $value ) {
	if ( is_array( $value ) ) {
		return array_map( 'murailles_schema_decode_entities', $value );
	}
	if ( is_string( $value ) ) {
		return html_entity_decode( $value, ENT_QUOTES | ENT_HTML5, 'UTF-8' );
	}
	return $value;
}

/**
 * Site-wide Organization + WebSite schema. Emitted on every page so search
 * engines can resolve the brand entity from any entry point.
 */
add_action( 'wp_head', function () {
	$ci   = murailles_schema_agency_data();
	$home = home_url( '/' );
	$logo = function_exists( 'murailles_img' ) ? murailles_img( 'logo.png' ) : ( $home . 'wp-content/themes/rentup-theme/assets/images/logo.png' );

	$social = array_filter( array(
		! empty( $ci['facebook'] )  && $ci['facebook']  !== '#' ? $ci['facebook']  : null,
		! empty( $ci['instagram'] ) && $ci['instagram'] !== '#' ? $ci['instagram'] : null,
		! empty( $ci['twitter'] )   && $ci['twitter']   !== '#' ? $ci['twitter']   : null,
	) );

	// Organization (also acting as RealEstateAgent — multi-type is allowed in JSON-LD).
	$org = array(
		'@context'    => 'https://schema.org',
		'@type'       => array( 'Organization', 'RealEstateAgent' ),
		'@id'         => $home . '#organization',
		'name'        => get_bloginfo( 'name' ),
		'url'         => $home,
		'logo'        => array(
			'@type' => 'ImageObject',
			'url'   => $logo,
		),
		'image'       => $logo,
		'description' => get_bloginfo( 'description' ),
		'address'     => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => trim( $ci['address_line1'] . ', ' . $ci['address_line2'], ' ,' ),
			'addressLocality' => 'Marrakech',
			'postalCode'      => '40000',
			'addressCountry'  => 'MA',
		),
		'contactPoint' => array(
			'@type'             => 'ContactPoint',
			'telephone'         => $ci['phone_tel'],
			'contactType'       => 'sales',
			'areaServed'        => 'MA',
			'availableLanguage' => array( 'French', 'English', 'Arabic' ),
			'email'             => $ci['email'],
		),
		'areaServed' => array(
			array( '@type' => 'City', 'name' => 'Marrakech' ),
			array( '@type' => 'City', 'name' => 'Casablanca' ),
			array( '@type' => 'City', 'name' => 'Rabat' ),
			array( '@type' => 'City', 'name' => 'Tangier' ),
			array( '@type' => 'City', 'name' => 'Fes' ),
			array( '@type' => 'Country', 'name' => 'Morocco' ),
		),
		'priceRange' => '€€€',
	);
	if ( $social ) {
		$org['sameAs'] = array_values( $social );
	}
	murailles_schema_print( $org );

	// WebSite with internal SearchAction.
	$website = array(
		'@context'       => 'https://schema.org',
		'@type'          => 'WebSite',
		'@id'            => $home . '#website',
		'url'            => $home,
		'name'           => get_bloginfo( 'name' ),
		'description'    => get_bloginfo( 'description' ),
		'inLanguage'     => function_exists( 'pll_current_language' ) ? pll_current_language( 'locale' ) : 'fr-FR',
		'publisher'      => array( '@id' => $home . '#organization' ),
		'potentialAction' => array(
			'@type'       => 'SearchAction',
			'target'      => array(
				'@type'       => 'EntryPoint',
				'urlTemplate' => $home . 'bien/?q={search_term_string}',
			),
			'query-input' => 'required name=search_term_string',
		),
	);
	murailles_schema_print( $website );
}, 7 );

/**
 * Per-page schema. Hooked late so it appears after Organization/WebSite.
 */
add_action( 'wp_head', function () {
	$home = home_url( '/' );

	// ─────────────────────────────────────────────────────────────────
	// Single property → RealEstateListing
	// ─────────────────────────────────────────────────────────────────
	if ( is_singular( 'property' ) ) {
		$id        = get_queried_object_id();
		$price_raw = (string) get_post_meta( $id, '_property_price', true );
		// _property_price may be stored as "4 200 000" or "4,200,000" — strip thousands separators before casting.
		$price     = (float) preg_replace( '/[^\d.]/', '', str_replace( ',', '.', $price_raw ) );
		$action    = (string) get_post_meta( $id, '_property_action', true );
		$size    = (float) get_post_meta( $id, '_property_size', true );
		$beds    = (int) get_post_meta( $id, '_property_bedrooms', true );
		$baths   = (int) get_post_meta( $id, '_property_bathrooms', true );
		$rooms   = (int) get_post_meta( $id, '_property_rooms', true );
		$year    = (int) get_post_meta( $id, '_property_year_built', true );
		$address = (string) get_post_meta( $id, '_property_address', true );

		$cats  = wp_get_post_terms( $id, 'property_category', array( 'fields' => 'names' ) );
		$locs  = wp_get_post_terms( $id, 'property_location', array( 'fields' => 'names' ) );
		$areas = wp_get_post_terms( $id, 'property_area', array( 'fields' => 'names' ) );

		$gallery_ids = array_filter( array_map( 'intval', explode( ',', (string) get_post_meta( $id, '_property_gallery_ids', true ) ) ) );
		$images = array();
		if ( has_post_thumbnail( $id ) ) {
			$images[] = get_the_post_thumbnail_url( $id, 'full' );
		}
		foreach ( $gallery_ids as $gid ) {
			$u = wp_get_attachment_image_url( $gid, 'full' );
			if ( $u && ! in_array( $u, $images, true ) ) { $images[] = $u; }
		}
		$images = array_slice( $images, 0, 8 );

		$listing = array(
			'@context'      => 'https://schema.org',
			'@type'         => 'RealEstateListing',
			'@id'           => get_permalink( $id ) . '#listing',
			'name'          => get_the_title( $id ),
			'description'   => wp_strip_all_tags( get_the_excerpt( $id ) ?: wp_trim_words( get_post_field( 'post_content', $id ), 60, '…' ) ),
			'url'           => get_permalink( $id ),
			'datePosted'    => get_the_date( 'c', $id ),
			'dateModified'  => get_the_modified_date( 'c', $id ),
			'inLanguage'    => function_exists( 'pll_get_post_language' ) ? pll_get_post_language( $id, 'locale' ) : 'fr-FR',
			'image'         => $images ?: null,
			'provider'      => array( '@id' => $home . '#organization' ),
		);

		// Offer (price + currency + availability).
		if ( $price > 0 ) {
			$listing['offers'] = array(
				'@type'         => 'Offer',
				'price'         => $price,
				'priceCurrency' => 'EUR',
				'availability'  => 'https://schema.org/InStock',
				'businessFunction' => ( stripos( $action, 'louer' ) !== false || stripos( $action, 'rent' ) !== false )
					? 'https://schema.org/LeaseOut'
					: 'https://schema.org/Sell',
				'seller'        => array( '@id' => $home . '#organization' ),
			);
		}

		// Spatial / address.
		$address_locality = ! empty( $locs ) ? $locs[0] : 'Marrakech';
		$listing['address'] = array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => $address ?: '',
			'addressLocality' => $address_locality,
			'addressRegion'   => ! empty( $areas ) ? $areas[0] : '',
			'addressCountry'  => 'MA',
		);

		// Accommodation (nested type — bedrooms/bathrooms/area belong on it, not on Listing).
		$accommodation = array(
			'@type' => 'Accommodation',
			'name'  => get_the_title( $id ),
		);
		if ( $size > 0 ) {
			$accommodation['floorSize'] = array(
				'@type'    => 'QuantitativeValue',
				'value'    => $size,
				'unitCode' => 'MTK', // square metre, UN/CEFACT code
			);
		}
		if ( $beds > 0 )  { $accommodation['numberOfBedrooms']  = $beds; }
		if ( $baths > 0 ) { $accommodation['numberOfBathroomsTotal'] = $baths; }
		if ( $rooms > 0 ) { $accommodation['numberOfRooms']      = $rooms; }
		if ( $year > 0 )  { $accommodation['yearBuilt']          = $year; }
		if ( ! empty( $cats ) ) {
			$accommodation['accommodationCategory'] = $cats[0];
		}
		$listing['itemOffered'] = $accommodation;

		murailles_schema_print( array_filter( $listing ) );
	}

	// ─────────────────────────────────────────────────────────────────
	// Single blog post → BlogPosting
	// ─────────────────────────────────────────────────────────────────
	if ( is_singular( 'post' ) ) {
		$id        = get_queried_object_id();
		$author_id = (int) get_post_field( 'post_author', $id );
		$image     = has_post_thumbnail( $id ) ? get_the_post_thumbnail_url( $id, 'full' ) : '';

		$article = array(
			'@context'         => 'https://schema.org',
			'@type'            => 'BlogPosting',
			'@id'              => get_permalink( $id ) . '#article',
			'mainEntityOfPage' => array(
				'@type' => 'WebPage',
				'@id'   => get_permalink( $id ),
			),
			'headline'         => get_the_title( $id ),
			'description'      => wp_strip_all_tags( get_the_excerpt( $id ) ?: wp_trim_words( get_post_field( 'post_content', $id ), 30, '…' ) ),
			'image'            => $image ?: null,
			'datePublished'    => get_the_date( 'c', $id ),
			'dateModified'     => get_the_modified_date( 'c', $id ),
			'inLanguage'       => function_exists( 'pll_get_post_language' ) ? pll_get_post_language( $id, 'locale' ) : 'fr-FR',
			'author'           => array(
				'@type' => 'Person',
				'name'  => get_the_author_meta( 'display_name', $author_id ),
				'url'   => get_author_posts_url( $author_id ),
			),
			'publisher'        => array( '@id' => $home . '#organization' ),
		);
		// Article section + keywords from categories/tags.
		$cats = wp_get_post_terms( $id, 'category', array( 'fields' => 'names' ) );
		$tags = wp_get_post_terms( $id, 'post_tag', array( 'fields' => 'names' ) );
		if ( ! empty( $cats ) ) { $article['articleSection'] = $cats[0]; }
		$kw = array_filter( array_merge( $cats, $tags ) );
		if ( $kw ) { $article['keywords'] = implode( ', ', $kw ); }

		murailles_schema_print( array_filter( $article ) );
	}

	// ─────────────────────────────────────────────────────────────────
	// FAQ page → FAQPage (parses the rendered DOM of the FAQ template)
	// ─────────────────────────────────────────────────────────────────
	if ( is_page() && is_page_template( 'page-templates/faq.php' ) ) {
		// Hardcoded list of Q&A — same content as in the FAQ template, expressed
		// here so search engines see structured data even if the template HTML
		// changes. Each entry is run through murailles_t() so the EN translation
		// is emitted on /en/faq/.
		$qa = array(
			array(
				murailles_t( 'Un étranger peut-il acheter un bien au Maroc ?', false ),
				murailles_t( "Oui. Le Maroc autorise les ressortissants étrangers à acquérir des biens immobiliers urbains (riads, villas, appartements) sans autorisation préalable. Seuls les terrains à vocation agricole sont soumis à des restrictions spécifiques. L'acte authentique se signe chez un notaire marocain, qui sécurise la transaction et l'inscription au registre foncier (titre foncier « melkia » ou titre conservé).", false ),
			),
			array(
				murailles_t( 'Quels documents faut-il fournir pour acheter ?', false ),
				murailles_t( "Une pièce d'identité en cours de validité (carte d'identité nationale ou passeport), un justificatif de domicile et un compte bancaire — au Maroc ou à l'étranger pour les non-résidents. Pour un investissement par un non-résident, l'ouverture d'un compte en dirhams convertibles est recommandée afin de pouvoir, à la revente, transférer le produit de la vente hors du Maroc.", false ),
			),
			array(
				murailles_t( "Quels frais s'ajoutent au prix du bien ?", false ),
				murailles_t( "Comptez environ 5 à 7 % du prix d'achat de frais annexes : droits d'enregistrement (4 % pour un bien d'habitation), conservation foncière (1,5 %), honoraires de notaire (environ 0,5 à 1 %), timbres et taxe notariale, plus les honoraires d'agence. Notre équipe vous remet un chiffrage complet avant la signature du compromis.", false ),
			),
			array(
				murailles_t( 'Combien de temps prend une transaction ?', false ),
				murailles_t( "En moyenne 6 à 10 semaines entre la signature du compromis et l'acte authentique. Ce délai permet au notaire de réaliser les vérifications d'usage : titre de propriété, urbanisme, absence d'hypothèque, situation fiscale du vendeur. Pour les biens en cours d'immatriculation foncière, le délai peut être plus long : nous vous l'indiquons dès la visite.", false ),
			),
			array(
				murailles_t( "Peut-on obtenir un crédit immobilier au Maroc en tant qu'étranger ?", false ),
				murailles_t( 'Oui, plusieurs banques marocaines proposent des crédits aux non-résidents, généralement à hauteur de 60 à 70 % du prix du bien, sur une durée de 15 à 20 ans. Les dossiers sont étudiés au cas par cas selon les revenus et le profil. Nous pouvons vous mettre en relation avec un courtier partenaire.', false ),
			),
			array(
				murailles_t( "Quels sont les honoraires de l'Agence ?", false ),
				murailles_t( "Pour une vente, les honoraires sont en général de 2,5 % TTC du prix de cession à la charge du vendeur et 2,5 % TTC à la charge de l'acquéreur, selon le mandat signé. Pour une location longue durée, ils correspondent à un mois de loyer, partagé entre bailleur et locataire. Les chiffres définitifs figurent toujours dans le mandat et sont communiqués avant toute visite.", false ),
			),
			array(
				murailles_t( 'Faut-il payer pour visiter un bien ?', false ),
				murailles_t( "Non. Les visites, les estimations et les conseils sont gratuits et sans engagement. Nous nous engageons à ne facturer qu'en cas de transaction conclue grâce à notre intermédiation.", false ),
			),
		);
		$entities = array();
		foreach ( $qa as $pair ) {
			$entities[] = array(
				'@type'          => 'Question',
				'name'           => $pair[0],
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => $pair[1],
				),
			);
		}
		murailles_schema_print( array(
			'@context'   => 'https://schema.org',
			'@type'      => 'FAQPage',
			'@id'        => get_permalink() . '#faq',
			'mainEntity' => $entities,
		) );
	}

	// ─────────────────────────────────────────────────────────────────
	// Property archive → CollectionPage + ItemList
	// ─────────────────────────────────────────────────────────────────
	if ( is_post_type_archive( 'property' ) || is_tax( array( 'property_category', 'property_location', 'property_area' ) ) ) {
		global $wp_query;
		$items = array();
		$idx   = 1;
		if ( $wp_query->have_posts() ) {
			foreach ( $wp_query->posts as $p ) {
				$items[] = array(
					'@type'    => 'ListItem',
					'position' => $idx++,
					'url'      => get_permalink( $p ),
					'name'     => get_the_title( $p ),
				);
				if ( $idx > 20 ) { break; }
			}
		}
		if ( ! empty( $items ) ) {
			murailles_schema_print( array(
				'@context'      => 'https://schema.org',
				'@type'         => 'CollectionPage',
				'@id'           => ( isset( $_SERVER['REQUEST_URI'] ) ? home_url( $_SERVER['REQUEST_URI'] ) : home_url( '/bien/' ) ) . '#collection',
				'mainEntity'    => array(
					'@type'           => 'ItemList',
					'numberOfItems'   => count( $items ),
					'itemListElement' => $items,
				),
				'isPartOf'      => array( '@id' => $home . '#website' ),
			) );
		}
	}
}, 8 );

/**
 * BreadcrumbList — emitted alongside the visible breadcrumb in template-parts/page-title.php.
 * The visible breadcrumb is rendered in templates; this hook builds the JSON-LD twin so
 * Google can show breadcrumb-style results in SERPs.
 */
add_action( 'wp_head', function () {
	if ( is_front_page() ) { return; }
	$home = home_url( '/' );
	$items = array();
	$pos   = 1;

	$items[] = array(
		'@type'    => 'ListItem',
		'position' => $pos++,
		'name'     => murailles_t( 'Accueil', false ),
		'item'     => $home,
	);

	if ( is_singular( 'property' ) ) {
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => $pos++,
			'name'     => murailles_t( 'Biens immobiliers', false ),
			'item'     => function_exists( 'murailles_bien_url' ) ? murailles_bien_url() : ( $home . 'bien/' ),
		);
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => $pos++,
			'name'     => get_the_title(),
			'item'     => get_permalink(),
		);
	} elseif ( is_singular( 'post' ) ) {
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => $pos++,
			'name'     => murailles_t( 'Blog', false ),
			'item'     => home_url( '/blog/' ),
		);
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => $pos++,
			'name'     => get_the_title(),
			'item'     => get_permalink(),
		);
	} elseif ( is_page() ) {
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => $pos++,
			'name'     => get_the_title(),
			'item'     => get_permalink(),
		);
	} elseif ( is_post_type_archive( 'property' ) ) {
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => $pos++,
			'name'     => murailles_t( 'Biens immobiliers', false ),
			'item'     => function_exists( 'murailles_bien_url' ) ? murailles_bien_url() : ( $home . 'bien/' ),
		);
	} elseif ( is_tax() ) {
		$term = get_queried_object();
		$items[] = array(
			'@type'    => 'ListItem',
			'position' => $pos++,
			'name'     => $term->name,
			'item'     => get_term_link( $term ),
		);
	}

	if ( count( $items ) < 2 ) { return; }

	murailles_schema_print( array(
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => $items,
	) );
}, 9 );
