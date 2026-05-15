<?php
/**
 * Template Name: Conditions générales d'utilisation
 *
 * Conditions générales d'utilisation — Agence Murailles Immobilier.
 *
 * ⚠️ Ce contenu est un modèle de départ : faites-le valider par un
 *    avocat avant la mise en ligne définitive.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();
?>

<!-- ============================ Page Title ================================== -->
<div class="page-title" style="background:#f4f4f4 url(<?php echo esc_url( murailles_img( 'banner-home.jpg' ) ); ?>);" data-overlay="5">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="breadcrumbs-wrap position-relative z-1">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php murailles_t( 'Accueil' ); ?></a></li>
						<li class="breadcrumb-item active" aria-current="page"><?php murailles_t( 'Conditions générales' ); ?></li>
					</ol>
					<h2 class="breadcrumb-title"><?php murailles_t( "Conditions générales d'utilisation" ); ?></h2>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ============================ Page Title End ================================== -->

<section class="gray">
	<div class="container">
		<div class="row">
			<div class="col-lg-9 col-md-12 mx-auto">
				<div class="property_block_wrap">

					<div class="block-body">
						<p class="text-muted"><em><?php murailles_t( 'Dernière mise à jour : 13 mai 2026' ); ?></em></p>
						<p><?php murailles_t( "Les présentes Conditions Générales d'Utilisation (« CGU ») régissent l'accès et l'utilisation du site murailles-immobilier.com édité par l'Agence Murailles Immobilier, ainsi que les services proposés aux visiteurs, acheteurs, vendeurs et locataires. L'utilisation du site implique l'acceptation pleine et entière des présentes CGU." ); ?></p>
					</div>

					<div class="property_block_wrap_header mt-5">
						<h4 class="property_block_title"><?php murailles_t( '1. Mentions légales' ); ?></h4>
					</div>
					<div class="block-body">
						<?php $murailles_ci = murailles_contact_info(); ?>
						<ul>
							<li><strong><?php murailles_t( 'Éditeur :' ); ?></strong> Agence Murailles Immobilier</li>
							<li><strong><?php murailles_t( 'Forme juridique :' ); ?></strong> <?php murailles_t( 'SARL de droit marocain' ); ?></li>
							<li><strong><?php murailles_t( 'Siège social :' ); ?></strong> <?php echo esc_html( $murailles_ci['address_line1'] ); ?>, <?php echo esc_html( $murailles_ci['address_line2'] ); ?>, <?php echo esc_html( $murailles_ci['address_city'] ); ?></li>
							<li><strong><?php murailles_t( 'Registre du commerce :' ); ?></strong> <?php murailles_t( 'RC à compléter' ); ?></li>
							<li><strong><?php murailles_t( 'Identifiant fiscal :' ); ?></strong> <?php murailles_t( 'IF à compléter' ); ?></li>
							<li><strong><?php murailles_t( "Carte professionnelle d'agent immobilier :" ); ?></strong> <?php murailles_t( 'numéro à compléter' ); ?></li>
							<li><strong><?php murailles_t( 'E-mail :' ); ?></strong> <a href="mailto:<?php echo esc_attr( $murailles_ci['email'] ); ?>"><?php echo esc_html( $murailles_ci['email'] ); ?></a></li>
							<li><strong><?php murailles_t( 'Téléphone :' ); ?></strong> <a href="tel:<?php echo esc_attr( $murailles_ci['phone_tel'] ); ?>"><?php echo esc_html( $murailles_ci['phone_display'] ); ?></a></li>
							<li><strong><?php murailles_t( 'Hébergement :' ); ?></strong> <?php murailles_t( 'hébergeur à compléter' ); ?></li>
						</ul>
					</div>

					<div class="property_block_wrap_header mt-5">
						<h4 class="property_block_title"><?php murailles_t( '2. Objet du site' ); ?></h4>
					</div>
					<div class="block-body">
						<p><?php murailles_t( "Le site présente l'activité de l'Agence et permet aux internautes de :" ); ?></p>
						<ul>
							<li><?php murailles_t( 'Consulter les biens immobiliers proposés à la vente ou à la location au Maroc ;' ); ?></li>
							<li><?php murailles_t( 'Affiner leur recherche par ville, quartier, type de bien et budget ;' ); ?></li>
							<li><?php murailles_t( 'Sauvegarder leurs biens favoris et comparer plusieurs biens ;' ); ?></li>
							<li><?php murailles_t( 'Demander une visite ou des renseignements complémentaires ;' ); ?></li>
							<li><?php murailles_t( "Confier un bien à l'Agence en déposant une annonce." ); ?></li>
						</ul>
					</div>

					<div class="property_block_wrap_header mt-5">
						<h4 class="property_block_title"><?php murailles_t( "3. Rôle de l'Agence" ); ?></h4>
					</div>
					<div class="block-body">
						<p><?php murailles_t( "L'Agence Murailles intervient en qualité d'intermédiaire immobilier. Elle met en relation des acheteurs / locataires avec des vendeurs / bailleurs et accompagne ses clients dans la sécurisation juridique et fiscale de la transaction. L'Agence n'est pas partie aux contrats de vente ou de location qui sont conclus directement entre les parties, en présence du notaire le cas échéant." ); ?></p>
					</div>

					<div class="property_block_wrap_header mt-5">
						<h4 class="property_block_title"><?php murailles_t( '4. Annonces et informations publiées' ); ?></h4>
					</div>
					<div class="block-body">
						<p><?php murailles_t( "L'Agence apporte tous ses soins à la sélection et à la mise à jour des annonces publiées. Les informations (description, surface, prix, photos) sont fournies à titre indicatif et ne constituent pas un engagement contractuel. Les caractéristiques exactes du bien, son état et ses limites font l'objet d'un constat lors de la visite et sont précisés dans le compromis ou le bail." ); ?></p>
						<p><?php murailles_t( "L'Agence se réserve le droit de modifier, suspendre ou retirer toute annonce à tout moment, notamment en cas de vente du bien, de retrait du mandat ou d'information erronée." ); ?></p>
					</div>

					<div class="property_block_wrap_header mt-5">
						<h4 class="property_block_title"><?php murailles_t( "5. Dépôt d'annonce par un propriétaire" ); ?></h4>
					</div>
					<div class="block-body">
						<p><?php murailles_t( 'Tout propriétaire qui dépose une annonce sur le site déclare et garantit :' ); ?></p>
						<ul>
							<li><?php murailles_t( "Être le propriétaire légitime du bien ou disposer d'un mandat l'autorisant à le commercialiser ;" ); ?></li>
							<li><?php murailles_t( "Que les informations et photos fournies sont exactes et lui appartiennent ou qu'il dispose des droits nécessaires pour les diffuser ;" ); ?></li>
							<li><?php murailles_t( 'Que le bien est conforme à la réglementation en vigueur (titre de propriété, urbanisme, fiscalité).' ); ?></li>
						</ul>
						<p><?php murailles_t( "La publication effective de l'annonce reste soumise à la validation de l'Agence et à la signature d'un mandat de vente ou de location." ); ?></p>
					</div>

					<div class="property_block_wrap_header mt-5">
						<h4 class="property_block_title"><?php murailles_t( "6. Honoraires d'agence" ); ?></h4>
					</div>
					<div class="block-body">
						<p><?php murailles_t( "Les honoraires de l'Agence sont communiqués au client avant la signature du mandat. Ils ne sont dus qu'en cas de réalisation effective de la transaction (signature de l'acte authentique de vente ou du contrat de bail). Le détail des honoraires est précisé dans le mandat correspondant." ); ?></p>
					</div>

					<div class="property_block_wrap_header mt-5">
						<h4 class="property_block_title"><?php murailles_t( '7. Propriété intellectuelle' ); ?></h4>
					</div>
					<div class="block-body">
						<p><?php murailles_t( "L'ensemble des éléments du site (textes, photographies, logo, charte graphique, code source) est protégé par le droit de la propriété intellectuelle. Toute reproduction, représentation, modification ou diffusion, totale ou partielle, sans autorisation écrite préalable de l'Agence est interdite et constitue une contrefaçon sanctionnée par la loi." ); ?></p>
					</div>

					<div class="property_block_wrap_header mt-5">
						<h4 class="property_block_title"><?php murailles_t( '8. Responsabilité' ); ?></h4>
					</div>
					<div class="block-body">
						<p><?php murailles_t( "L'Agence s'efforce d'assurer la disponibilité du site et l'exactitude des informations publiées. Elle ne saurait toutefois être tenue responsable :" ); ?></p>
						<ul>
							<li><?php murailles_t( "D'une indisponibilité temporaire du site liée à une maintenance ou à un cas de force majeure ;" ); ?></li>
							<li><?php murailles_t( "D'erreurs ou d'omissions dans les annonces qui sont fournies par les propriétaires ;" ); ?></li>
							<li><?php murailles_t( "De l'usage que l'utilisateur fait des informations consultées ;" ); ?></li>
							<li><?php murailles_t( "De dommages indirects résultant de l'utilisation du site." ); ?></li>
						</ul>
					</div>

					<div class="property_block_wrap_header mt-5">
						<h4 class="property_block_title"><?php murailles_t( '9. Liens externes' ); ?></h4>
					</div>
					<div class="block-body">
						<p><?php murailles_t( "Le site peut contenir des liens vers des sites tiers (réseaux sociaux, notaires, partenaires). L'Agence n'exerce aucun contrôle sur ces sites et décline toute responsabilité quant à leur contenu ou aux conséquences de leur utilisation." ); ?></p>
					</div>

					<div class="property_block_wrap_header mt-5">
						<h4 class="property_block_title"><?php murailles_t( '10. Données personnelles' ); ?></h4>
					</div>
					<div class="block-body">
						<p><?php
							printf(
								/* translators: %s is the Privacy Policy page link */
								murailles_t( 'Le traitement de vos données est régi par notre %s, à laquelle vous êtes invité à vous référer.', false ),
								'<a href="' . esc_url( home_url( '/privacy/' ) ) . '">' . esc_html( murailles_t( 'Politique de confidentialité', false ) ) . '</a>'
							);
						?></p>
					</div>

					<div class="property_block_wrap_header mt-5">
						<h4 class="property_block_title"><?php murailles_t( '11. Loi applicable et juridiction' ); ?></h4>
					</div>
					<div class="block-body">
						<p><?php murailles_t( "Les présentes CGU sont régies par le droit marocain. En cas de litige et à défaut d'accord amiable, les tribunaux compétents de Marrakech seront seuls compétents." ); ?></p>
					</div>

					<div class="property_block_wrap_header mt-5">
						<h4 class="property_block_title"><?php murailles_t( '12. Modifications' ); ?></h4>
					</div>
					<div class="block-body">
						<p><?php murailles_t( "L'Agence se réserve le droit de modifier les présentes CGU à tout moment. La version applicable est celle publiée sur le site à la date de consultation. Il est recommandé aux utilisateurs de relire régulièrement cette page." ); ?></p>
					</div>

				</div>
			</div>
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/call-to-action' ); ?>

<?php get_footer(); ?>
