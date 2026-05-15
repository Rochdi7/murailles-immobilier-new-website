<?php
/**
 * Template Name: Politique de confidentialité
 *
 * Politique de confidentialité — Agence Murailles Immobilier.
 * Conforme à la Loi n°09-08 (Maroc) relative à la protection des
 * données à caractère personnel et aux recommandations de la CNDP.
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
						<li class="breadcrumb-item active" aria-current="page"><?php murailles_t( 'Politique de confidentialité' ); ?></li>
					</ol>
					<h2 class="breadcrumb-title"><?php murailles_t( 'Politique de confidentialité' ); ?></h2>
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

						<p><?php murailles_t( "L'Agence Murailles Immobilier (« nous », « notre », « l'Agence ») accorde une grande importance à la protection des données personnelles de ses visiteurs et clients. La présente politique explique comment vos informations sont collectées, utilisées, conservées et protégées lorsque vous utilisez notre site murailles-immobilier.com ou nos services." ); ?></p>

						<p><?php murailles_t( "Le traitement de vos données est effectué dans le respect de la Loi n°09-08 relative à la protection des personnes physiques à l'égard du traitement des données à caractère personnel, ainsi que des recommandations de la Commission Nationale de Contrôle de la Protection des Données à Caractère Personnel (CNDP)." ); ?></p>
					</div>

					<div class="property_block_wrap_header mt-5">
						<h4 class="property_block_title"><?php murailles_t( '1. Données collectées' ); ?></h4>
					</div>
					<div class="block-body">
						<p><?php murailles_t( 'Nous collectons les données personnelles que vous nous communiquez directement, notamment :' ); ?></p>
						<ul>
							<li><?php murailles_t( "Vos nom, prénom, adresse e-mail et numéro de téléphone lorsque vous remplissez un formulaire de contact ou de demande d'information ;" ); ?></li>
							<li><?php murailles_t( 'Les informations relatives à votre projet immobilier (type de bien recherché, budget, ville, surface, etc.) ;' ); ?></li>
							<li><?php murailles_t( "Les informations relatives aux biens que vous souhaitez confier à l'Agence (adresse, photos, prix demandé, documents de propriété) ;" ); ?></li>
							<li><?php murailles_t( 'Vos préférences de navigation et données techniques (adresse IP, navigateur, pages consultées) collectées via les cookies.' ); ?></li>
						</ul>
					</div>

					<div class="property_block_wrap_header mt-5">
						<h4 class="property_block_title"><?php murailles_t( '2. Finalités du traitement' ); ?></h4>
					</div>
					<div class="block-body">
						<p><?php murailles_t( 'Vos données sont utilisées uniquement pour :' ); ?></p>
						<ul>
							<li><?php murailles_t( 'Répondre à vos demandes de renseignement et organiser les visites de biens ;' ); ?></li>
							<li><?php murailles_t( 'Vous proposer des biens correspondant à votre recherche ;' ); ?></li>
							<li><?php murailles_t( 'Publier votre annonce immobilière si vous nous confiez un mandat ;' ); ?></li>
							<li><?php murailles_t( 'Gérer la relation commerciale et établir les documents contractuels (mandat, compromis, bail) ;' ); ?></li>
							<li><?php murailles_t( 'Respecter nos obligations légales et réglementaires (lutte contre le blanchiment, fiscalité) ;' ); ?></li>
							<li><?php murailles_t( 'Améliorer la qualité de notre site et de nos services.' ); ?></li>
						</ul>
					</div>

					<div class="property_block_wrap_header mt-5">
						<h4 class="property_block_title"><?php murailles_t( '3. Destinataires et partage' ); ?></h4>
					</div>
					<div class="block-body">
						<p><?php murailles_t( 'Vos données ne sont jamais vendues à des tiers. Elles peuvent être communiquées, dans la stricte limite de ce qui est nécessaire, à :' ); ?></p>
						<ul>
							<li><?php murailles_t( 'Nos collaborateurs et agents commerciaux habilités ;' ); ?></li>
							<li><?php murailles_t( 'Les professionnels intervenant dans la transaction (notaire, avocat, banque, expert) ;' ); ?></li>
							<li><?php murailles_t( "Nos prestataires techniques (hébergeur, service d'envoi d'e-mails) sous accord de confidentialité ;" ); ?></li>
							<li><?php murailles_t( "Les autorités compétentes lorsque la loi nous l'impose." ); ?></li>
						</ul>
					</div>

					<div class="property_block_wrap_header mt-5">
						<h4 class="property_block_title"><?php murailles_t( '4. Durée de conservation' ); ?></h4>
					</div>
					<div class="block-body">
						<p><?php murailles_t( 'Nous conservons vos données uniquement le temps nécessaire aux finalités décrites ci-dessus :' ); ?></p>
						<ul>
							<li><strong><?php murailles_t( 'Prospects :' ); ?></strong> <?php murailles_t( '3 ans à compter du dernier contact ;' ); ?></li>
							<li><strong><?php murailles_t( 'Clients (mandat, vente, location) :' ); ?></strong> <?php murailles_t( '10 ans à compter de la fin de la relation contractuelle, pour respecter nos obligations comptables et fiscales ;' ); ?></li>
							<li><strong><?php murailles_t( 'Cookies :' ); ?></strong> <?php murailles_t( '13 mois maximum.' ); ?></li>
						</ul>
					</div>

					<div class="property_block_wrap_header mt-5">
						<h4 class="property_block_title"><?php murailles_t( '5. Cookies' ); ?></h4>
					</div>
					<div class="block-body">
						<p><?php murailles_t( 'Notre site utilise des cookies pour :' ); ?></p>
						<ul>
							<li><?php murailles_t( 'Assurer le bon fonctionnement du site (session, panier de favoris, comparateur) ;' ); ?></li>
							<li><?php murailles_t( "Mesurer l'audience de manière anonyme (statistiques de visite) ;" ); ?></li>
							<li><?php murailles_t( 'Améliorer votre expérience de navigation (préférences linguistiques, recherche récente).' ); ?></li>
						</ul>
						<p><?php murailles_t( "Vous pouvez à tout moment configurer votre navigateur pour bloquer ou supprimer les cookies. Le refus de certains cookies peut limiter l'accès à certaines fonctionnalités du site." ); ?></p>
					</div>

					<div class="property_block_wrap_header mt-5">
						<h4 class="property_block_title"><?php murailles_t( '6. Vos droits' ); ?></h4>
					</div>
					<div class="block-body">
						<p><?php murailles_t( 'Conformément à la Loi n°09-08, vous disposez à tout moment des droits suivants sur vos données :' ); ?></p>
						<ul>
							<li><strong><?php murailles_t( "Droit d'accès" ); ?></strong> — <?php murailles_t( 'obtenir une copie des données que nous détenons sur vous ;' ); ?></li>
							<li><strong><?php murailles_t( 'Droit de rectification' ); ?></strong> — <?php murailles_t( 'corriger une information inexacte ou incomplète ;' ); ?></li>
							<li><strong><?php murailles_t( "Droit d'opposition" ); ?></strong> — <?php murailles_t( 'vous opposer au traitement de vos données pour des motifs légitimes ;' ); ?></li>
							<li><strong><?php murailles_t( 'Droit de suppression' ); ?></strong> — <?php murailles_t( "demander l'effacement de vos données lorsque la loi le permet." ); ?></li>
						</ul>
						<p><?php
							printf(
								/* translators: 1: contact email link, 2: CNDP link */
								murailles_t( "Pour exercer ces droits, contactez-nous à l'adresse %1\$s en joignant une copie d'une pièce d'identité. Vous pouvez également déposer une réclamation auprès de la CNDP (%2\$s).", false ),
								'<a href="mailto:contact@murailles-immobilier.com">contact@murailles-immobilier.com</a>',
								'<a href="https://www.cndp.ma" target="_blank" rel="noopener">www.cndp.ma</a>'
							);
						?></p>
					</div>

					<div class="property_block_wrap_header mt-5">
						<h4 class="property_block_title"><?php murailles_t( '7. Sécurité' ); ?></h4>
					</div>
					<div class="block-body">
						<p><?php murailles_t( "Nous mettons en œuvre les mesures techniques et organisationnelles appropriées pour protéger vos données contre toute perte, accès non autorisé, divulgation ou destruction : connexion HTTPS, contrôle d'accès, sauvegardes régulières et sensibilisation de nos équipes." ); ?></p>
					</div>

					<div class="property_block_wrap_header mt-5">
						<h4 class="property_block_title"><?php murailles_t( '8. Contact' ); ?></h4>
					</div>
					<div class="block-body">
						<p><?php murailles_t( 'Pour toute question relative à la présente politique ou au traitement de vos données :' ); ?></p>
						<ul>
							<li><strong>Agence Murailles Immobilier</strong></li>
							<li><?php murailles_t( 'E-mail :' ); ?> <a href="mailto:contact@murailles-immobilier.com">contact@murailles-immobilier.com</a></li>
							<?php $murailles_ci = murailles_contact_info(); ?>
							<li><?php murailles_t( 'Téléphone :' ); ?> <a href="tel:<?php echo esc_attr( $murailles_ci['phone_tel'] ); ?>"><?php echo esc_html( $murailles_ci['phone_display'] ); ?></a></li>
							<li><?php murailles_t( 'Adresse :' ); ?> <?php echo esc_html( $murailles_ci['address_line1'] ); ?>, <?php echo esc_html( $murailles_ci['address_line2'] ); ?>, <?php echo esc_html( $murailles_ci['address_city'] ); ?></li>
						</ul>
						<p><?php murailles_t( "L'Agence se réserve le droit de modifier la présente politique. Toute mise à jour sera publiée sur cette page avec la date de dernière révision." ); ?></p>
					</div>

				</div>
			</div>
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/call-to-action' ); ?>

<?php get_footer(); ?>
