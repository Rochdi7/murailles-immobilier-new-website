<?php
/**
 * Template Part: Navigation Fallback
 *
 * Menu statique avec structure exacte :
 * Accueil | Vente (catégories) | Location (catégories) | Informations | Déposer une annonce | Contact
 *
 * Each Vente/Location item links to /bien/ pre-filtered with the action
 * (A Vendre / A Louer) and the property_category slug (ptype) so the user
 * lands on the polished archive layout with the right scope already applied.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$base = murailles_bien_url();

/**
 * The _property_action meta is stored as the literal language-specific string
 * (FR posts hold "A Vendre" / "A Louer", EN posts hold "For Sale" / "For Rent").
 * So the filter query arg has to match the current language's stored value.
 */
$mu_lang = function_exists( 'pll_current_language' ) ? pll_current_language( 'slug' ) : 'fr';
$ACT_SALE = ( $mu_lang === 'en' ) ? 'For Sale' : 'A Vendre';
$ACT_RENT = ( $mu_lang === 'en' ) ? 'For Rent' : 'A Louer';

/**
 * Build a filtered archive URL from an action + category slug.
 * Either arg can be empty to omit that filter.
 */
$flt = function ( $action, $ptype = '' ) use ( $base ) {
	$args = array();
	if ( $action ) { $args['action_t'] = $action; }
	if ( $ptype )  { $args['ptype']    = $ptype; }
	return esc_url( $args ? add_query_arg( $args, $base ) : $base );
};
?>
<ul class="nav-menu">

	<!-- 1. Accueil -->
	<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php murailles_t( 'Accueil' ); ?></a></li>

	<!-- 2. Vente (avec sous-menu catégories) -->
	<li><a href="<?php echo $flt( $ACT_SALE ); ?>"><?php murailles_t( 'Vente' ); ?><span class="submenu-indicator"></span></a>
		<ul class="nav-dropdown nav-submenu">
			<li><a href="<?php echo $flt( $ACT_SALE ); ?>"><?php murailles_t( 'Riads' ); ?><span class="submenu-indicator"></span></a>
				<ul class="nav-dropdown nav-submenu">
					<li><a href="<?php echo $flt( $ACT_SALE, 'maison-dhote' ); ?>"><?php murailles_t( "Maison d'hôte" ); ?></a></li>
					<li><a href="<?php echo $flt( $ACT_SALE, 'riad-habitation' ); ?>"><?php murailles_t( "Riad d'habitation" ); ?></a></li>
					<li><a href="<?php echo $flt( $ACT_SALE, 'riad-renove' ); ?>"><?php murailles_t( 'Riad rénové' ); ?></a></li>
					<li><a href="<?php echo $flt( $ACT_SALE, 'riad-a-renover' ); ?>"><?php murailles_t( 'Riad à rénover' ); ?></a></li>
				</ul>
			</li>
			<li><a href="<?php echo $flt( $ACT_SALE, 'hotel' ); ?>"><?php murailles_t( 'Hotel' ); ?></a></li>
			<li><a href="<?php echo $flt( $ACT_SALE, 'terrain' ); ?>"><?php murailles_t( 'Terrain' ); ?></a></li>
			<li><a href="<?php echo $flt( $ACT_SALE, 'appartement' ); ?>"><?php murailles_t( 'Appartement' ); ?></a></li>
			<li><a href="<?php echo $flt( $ACT_SALE, 'villa' ); ?>"><?php murailles_t( 'Villa' ); ?></a></li>
			<li><a href="<?php echo $flt( $ACT_SALE, 'ferme' ); ?>"><?php murailles_t( 'Ferme' ); ?></a></li>
			<li><a href="<?php echo $flt( $ACT_SALE, 'bureaux' ); ?>"><?php murailles_t( 'Bureaux' ); ?></a></li>
		</ul>
	</li>

	<!-- 3. Location (avec sous-menu catégories) -->
	<li><a href="<?php echo $flt( $ACT_RENT ); ?>"><?php murailles_t( 'Location' ); ?><span class="submenu-indicator"></span></a>
		<ul class="nav-dropdown nav-submenu">
			<li><a href="<?php echo $flt( $ACT_RENT ); ?>"><?php murailles_t( 'Riads' ); ?><span class="submenu-indicator"></span></a>
				<ul class="nav-dropdown nav-submenu">
					<li><a href="<?php echo $flt( $ACT_RENT, 'maison-dhote' ); ?>"><?php murailles_t( "Maison d'hôte" ); ?></a></li>
					<li><a href="<?php echo $flt( $ACT_RENT, 'riad-habitation' ); ?>"><?php murailles_t( 'Riad habitation' ); ?></a></li>
					<li><a href="<?php echo $flt( $ACT_RENT, 'riad-renove' ); ?>"><?php murailles_t( 'Riad rénové' ); ?></a></li>
					<li><a href="<?php echo $flt( $ACT_RENT, 'riad-a-renover' ); ?>"><?php murailles_t( 'Riad à rénover' ); ?></a></li>
				</ul>
			</li>
			<li><a href="<?php echo $flt( $ACT_RENT, 'appartement' ); ?>"><?php murailles_t( 'Appartement' ); ?></a></li>
			<li><a href="<?php echo $flt( $ACT_RENT, 'villa' ); ?>"><?php murailles_t( 'Villa' ); ?></a></li>
			<li><a href="<?php echo $flt( $ACT_RENT, 'terrain' ); ?>"><?php murailles_t( 'Terrain' ); ?></a></li>
			<li><a href="<?php echo $flt( $ACT_RENT, 'ferme' ); ?>"><?php murailles_t( 'Ferme' ); ?></a></li>
			<li><a href="<?php echo $flt( $ACT_RENT, 'bureaux' ); ?>"><?php murailles_t( 'Bureaux' ); ?></a></li>
		</ul>
	</li>

	<!-- 4. Informations -->
	<li><a href="#"><?php murailles_t( 'Informations' ); ?><span class="submenu-indicator"></span></a>
		<ul class="nav-dropdown nav-submenu">
			<li><a href="<?php echo esc_url( home_url( '/assistance-conseils/' ) ); ?>"><?php murailles_t( 'Assistance & conseils' ); ?></a></li>
			<li><a href="<?php echo esc_url( home_url( '/histoire-marrakech/' ) ); ?>"><?php murailles_t( 'Histoire de Marrakech' ); ?></a></li>
			<li><a href="<?php echo esc_url( home_url( '/tourisme-marrakech/' ) ); ?>"><?php murailles_t( 'Tourisme à Marrakech' ); ?></a></li>
		</ul>
	</li>

	<!-- 5. Déposer une annonce -->
	<li><a href="<?php echo esc_url( home_url( '/submit-property/' ) ); ?>"><?php murailles_t( 'Déposer une annonce' ); ?></a></li>

	<!-- 6. Blog -->
	<li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php murailles_t( 'Blog' ); ?></a></li>

	<!-- 6. Contact -->
	<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php murailles_t( 'Contact' ); ?></a></li>

</ul>
