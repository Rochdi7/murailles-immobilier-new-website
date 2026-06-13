<?php
/**
 * Template Name: FAQ
 *
 * Questions fréquentes — Agence Murailles Immobilier (Marrakech, Maroc).
 * Sections : Acheter au Maroc · Louer un bien · Déposer une annonce ·
 * Honoraires & paiement · Mon compte & favoris.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();
?>

<!-- ============================ Page Title ================================== -->
<section class="image-cover faq-sec text-center" style="background:url(<?php echo esc_url( murailles_img( 'faq-immobilier-marrakech.webp' ) ); ?>) no-repeat;" data-overlay="6">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 position-relative z-1">
				<h1 class="text-light"><?php murailles_t( 'Questions fréquentes' ); ?></h1>
				<p class="text-light mb-4"><?php murailles_t( 'Acheter, louer, vendre ou louer son bien au Maroc — toutes les réponses ici.' ); ?></p>
				<div class="faq-search">
					<form method="get" action="<?php echo esc_url( murailles_bien_url() ); ?>">
						<input name="q" class="form-control" placeholder="<?php echo esc_attr( murailles_t( 'Recherchez un bien (riad, villa, ville…)', false ) ); ?>">
						<button type="submit" class="theme-cl" aria-label="<?php echo esc_attr( murailles_t( 'Rechercher', false ) ); ?>"><i class="ti-search"></i></button>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- ============================ Page Title End ================================== -->

<!-- ================= FAQ Sections ================= -->
<section>
	<div class="container">
		<div class="row">
			<div class="col-lg-10 col-md-12 col-sm-12 mx-auto">

				<!-- ── 1. Acheter au Maroc ───────────────────────────────────────── -->
				<div class="faq_wrap">
					<div class="faq_wrap_title">
						<h4><?php murailles_t( 'Acheter un bien au Maroc' ); ?></h4>
					</div>
					<div class="faq_wrap_body mb-5">
						<div class="accordion" id="faqAcheter">

							<div class="card">
								<div class="card-header" id="hAch1">
									<h2 class="mb-0">
										<button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#cAch1" aria-expanded="true" aria-controls="cAch1">
											<?php murailles_t( 'Un étranger peut-il acheter un bien au Maroc ?' ); ?>
										</button>
									</h2>
								</div>
								<div id="cAch1" class="collapse show" aria-labelledby="hAch1" data-parent="#faqAcheter">
									<div class="card-body">
										<p class="ac-para"><?php murailles_t( "Oui. Le Maroc autorise les ressortissants étrangers à acquérir des biens immobiliers urbains (riads, villas, appartements) sans autorisation préalable. Seuls les terrains à vocation agricole sont soumis à des restrictions spécifiques. L'acte authentique se signe chez un notaire marocain, qui sécurise la transaction et l'inscription au registre foncier (titre foncier « melkia » ou titre conservé)." ); ?></p>
									</div>
								</div>
							</div>

							<div class="card">
								<div class="card-header" id="hAch2">
									<h2 class="mb-0">
										<button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cAch2" aria-expanded="false" aria-controls="cAch2">
											<?php murailles_t( 'Quels documents faut-il fournir pour acheter ?' ); ?>
										</button>
									</h2>
								</div>
								<div id="cAch2" class="collapse" aria-labelledby="hAch2" data-parent="#faqAcheter">
									<div class="card-body">
										<p class="ac-para"><?php murailles_t( "Une pièce d'identité en cours de validité (carte d'identité nationale ou passeport), un justificatif de domicile et un compte bancaire — au Maroc ou à l'étranger pour les non-résidents. Pour un investissement par un non-résident, l'ouverture d'un compte en dirhams convertibles est recommandée afin de pouvoir, à la revente, transférer le produit de la vente hors du Maroc." ); ?></p>
									</div>
								</div>
							</div>

							<div class="card">
								<div class="card-header" id="hAch3">
									<h2 class="mb-0">
										<button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cAch3" aria-expanded="false" aria-controls="cAch3">
											<?php murailles_t( "Quels frais s'ajoutent au prix du bien ?" ); ?>
										</button>
									</h2>
								</div>
								<div id="cAch3" class="collapse" aria-labelledby="hAch3" data-parent="#faqAcheter">
									<div class="card-body">
										<p class="ac-para"><?php murailles_t( "Comptez environ 5 à 7 % du prix d'achat de frais annexes : droits d'enregistrement (4 % pour un bien d'habitation), conservation foncière (1,5 %), honoraires de notaire (environ 0,5 à 1 %), timbres et taxe notariale, plus les honoraires d'agence. Notre équipe vous remet un chiffrage complet avant la signature du compromis." ); ?></p>
									</div>
								</div>
							</div>

							<div class="card">
								<div class="card-header" id="hAch4">
									<h2 class="mb-0">
										<button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cAch4" aria-expanded="false" aria-controls="cAch4">
											<?php murailles_t( 'Combien de temps prend une transaction ?' ); ?>
										</button>
									</h2>
								</div>
								<div id="cAch4" class="collapse" aria-labelledby="hAch4" data-parent="#faqAcheter">
									<div class="card-body">
										<p class="ac-para"><?php murailles_t( "En moyenne 6 à 10 semaines entre la signature du compromis et l'acte authentique. Ce délai permet au notaire de réaliser les vérifications d'usage : titre de propriété, urbanisme, absence d'hypothèque, situation fiscale du vendeur. Pour les biens en cours d'immatriculation foncière, le délai peut être plus long : nous vous l'indiquons dès la visite." ); ?></p>
									</div>
								</div>
							</div>

							<div class="card">
								<div class="card-header" id="hAch5">
									<h2 class="mb-0">
										<button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cAch5" aria-expanded="false" aria-controls="cAch5">
											<?php murailles_t( "Peut-on obtenir un crédit immobilier au Maroc en tant qu'étranger ?" ); ?>
										</button>
									</h2>
								</div>
								<div id="cAch5" class="collapse" aria-labelledby="hAch5" data-parent="#faqAcheter">
									<div class="card-body">
										<p class="ac-para"><?php murailles_t( 'Oui, plusieurs banques marocaines proposent des crédits aux non-résidents, généralement à hauteur de 60 à 70 % du prix du bien, sur une durée de 15 à 20 ans. Les dossiers sont étudiés au cas par cas selon les revenus et le profil. Nous pouvons vous mettre en relation avec un courtier partenaire.' ); ?></p>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>

				<!-- ── 2. Louer un bien ──────────────────────────────────────────── -->
				<div class="faq_wrap">
					<div class="faq_wrap_title">
						<h4><?php murailles_t( 'Louer un bien' ); ?></h4>
					</div>
					<div class="faq_wrap_body mb-5">
						<div class="accordion" id="faqLouer">

							<div class="card">
								<div class="card-header" id="hLou1">
									<h2 class="mb-0">
										<button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#cLou1" aria-expanded="true" aria-controls="cLou1">
											<?php murailles_t( 'Comment réserver une visite ?' ); ?>
										</button>
									</h2>
								</div>
								<div id="cLou1" class="collapse show" aria-labelledby="hLou1" data-parent="#faqLouer">
									<div class="card-body">
										<p class="ac-para"><?php murailles_t( "Depuis la fiche d'un bien, cliquez sur « Demander une visite » ou contactez-nous via le formulaire, par e-mail ou par WhatsApp. Notre équipe vous propose un créneau sous 24 à 48 heures et confirme la disponibilité du bien." ); ?></p>
									</div>
								</div>
							</div>

							<div class="card">
								<div class="card-header" id="hLou2">
									<h2 class="mb-0">
										<button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cLou2" aria-expanded="false" aria-controls="cLou2">
											<?php murailles_t( 'Quels documents pour signer un bail ?' ); ?>
										</button>
									</h2>
								</div>
								<div id="cLou2" class="collapse" aria-labelledby="hLou2" data-parent="#faqLouer">
									<div class="card-body">
										<p class="ac-para"><?php murailles_t( "Une pièce d'identité, un justificatif de domicile précédent, un justificatif de revenus (bulletins de salaire ou attestation d'activité), et un RIB. Pour les étudiants ou les non-résidents, un garant solvable peut être demandé. Le dépôt de garantie est en général équivalent à 1 ou 2 mois de loyer hors charges." ); ?></p>
									</div>
								</div>
							</div>

							<div class="card">
								<div class="card-header" id="hLou3">
									<h2 class="mb-0">
										<button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cLou3" aria-expanded="false" aria-controls="cLou3">
											<?php murailles_t( 'Location longue durée ou saisonnière : quelle différence ?' ); ?>
										</button>
									</h2>
								</div>
								<div id="cLou3" class="collapse" aria-labelledby="hLou3" data-parent="#faqLouer">
									<div class="card-body">
										<p class="ac-para"><?php murailles_t( "La location longue durée (généralement 1 an renouvelable) s'adresse aux résidents et expatriés. La location saisonnière, à la nuit ou à la semaine, concerne plutôt les riads et villas de vacances. Le cadre juridique, les obligations fiscales et le mode de calcul du loyer diffèrent — notre équipe vous oriente selon votre projet." ); ?></p>
									</div>
								</div>
							</div>

							<div class="card">
								<div class="card-header" id="hLou4">
									<h2 class="mb-0">
										<button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cLou4" aria-expanded="false" aria-controls="cLou4">
											<?php murailles_t( 'Le mobilier et les charges sont-ils inclus ?' ); ?>
										</button>
									</h2>
								</div>
								<div id="cLou4" class="collapse" aria-labelledby="hLou4" data-parent="#faqLouer">
									<div class="card-body">
										<p class="ac-para"><?php murailles_t( "Cela dépend du bien. Chaque annonce précise s'il s'agit d'une location meublée ou vide, et la liste des charges incluses (syndic, eau, internet) ou exclues. En cas de doute, nous fournissons un état détaillé sur demande avant la signature." ); ?></p>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>

				<!-- ── 3. Déposer une annonce ───────────────────────────────────── -->
				<div class="faq_wrap">
					<div class="faq_wrap_title">
						<h4><?php murailles_t( 'Vendre ou louer mon bien (déposer une annonce)' ); ?></h4>
					</div>
					<div class="faq_wrap_body mb-5">
						<div class="accordion" id="faqDeposer">

							<div class="card">
								<div class="card-header" id="hDep1">
									<h2 class="mb-0">
										<button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#cDep1" aria-expanded="true" aria-controls="cDep1">
											<?php murailles_t( 'Comment déposer une annonce ?' ); ?>
										</button>
									</h2>
								</div>
								<div id="cDep1" class="collapse show" aria-labelledby="hDep1" data-parent="#faqDeposer">
									<div class="card-body">
										<p class="ac-para"><?php
											printf(
												/* translators: %s is the «Submit Property» page link */
												murailles_t( 'Rendez-vous sur la page %s, renseignez les informations principales (type de bien, ville, surface, prix) et ajoutez vos photos. Un conseiller vous rappelle ensuite pour valider le mandat et planifier, si vous le souhaitez, une séance photo professionnelle.', false ),
												'<a href="' . esc_url( home_url( '/submit-property/' ) ) . '">' . esc_html( murailles_t( 'Déposer une annonce', false ) ) . '</a>'
											);
										?></p>
									</div>
								</div>
							</div>

							<div class="card">
								<div class="card-header" id="hDep2">
									<h2 class="mb-0">
										<button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cDep2" aria-expanded="false" aria-controls="cDep2">
											<?php murailles_t( 'Mandat simple ou mandat exclusif ?' ); ?>
										</button>
									</h2>
								</div>
								<div id="cDep2" class="collapse" aria-labelledby="hDep2" data-parent="#faqDeposer">
									<div class="card-body">
										<p class="ac-para"><?php murailles_t( "Le mandat simple vous laisse libre de confier le bien à plusieurs agences. Le mandat exclusif nous confie la commercialisation pour une durée définie : en contrepartie, vous bénéficiez d'un investissement marketing plus important (photos pro, mise en avant sur le site, campagnes sponsorisées) et d'un interlocuteur unique. La plupart des biens haut de gamme se vendent plus vite en exclusivité." ); ?></p>
									</div>
								</div>
							</div>

							<div class="card">
								<div class="card-header" id="hDep3">
									<h2 class="mb-0">
										<button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cDep3" aria-expanded="false" aria-controls="cDep3">
											<?php murailles_t( 'Comment estimer mon bien ?' ); ?>
										</button>
									</h2>
								</div>
								<div id="cDep3" class="collapse" aria-labelledby="hDep3" data-parent="#faqDeposer">
									<div class="card-body">
										<p class="ac-para"><?php murailles_t( "Nous réalisons une estimation gratuite et confidentielle sur place. Elle s'appuie sur les transactions récentes du quartier, l'état du bien, ses prestations et la tendance du marché. Cette estimation vous est remise par écrit, sans engagement de mandat." ); ?></p>
									</div>
								</div>
							</div>

							<div class="card">
								<div class="card-header" id="hDep4">
									<h2 class="mb-0">
										<button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cDep4" aria-expanded="false" aria-controls="cDep4">
											<?php murailles_t( 'Quels documents préparer pour vendre ?' ); ?>
										</button>
									</h2>
								</div>
								<div id="cDep4" class="collapse" aria-labelledby="hDep4" data-parent="#faqDeposer">
									<div class="card-body">
										<p class="ac-para"><?php murailles_t( "Le titre de propriété (ou la moulkia), le plan cadastral, les dernières quittances de taxe d'habitation et de taxe de services communaux, l'état des charges de syndic le cas échéant, et toute autorisation d'urbanisme (permis de construire, permis d'habiter). Nous vous accompagnons pour réunir ces pièces." ); ?></p>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>

				<!-- ── 4. Honoraires & paiement ─────────────────────────────────── -->
				<div class="faq_wrap">
					<div class="faq_wrap_title">
						<h4><?php murailles_t( 'Honoraires et paiement' ); ?></h4>
					</div>
					<div class="faq_wrap_body mb-5">
						<div class="accordion" id="faqHono">

							<div class="card">
								<div class="card-header" id="hHon1">
									<h2 class="mb-0">
										<button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#cHon1" aria-expanded="true" aria-controls="cHon1">
											<?php murailles_t( "Quels sont les honoraires de l'Agence ?" ); ?>
										</button>
									</h2>
								</div>
								<div id="cHon1" class="collapse show" aria-labelledby="hHon1" data-parent="#faqHono">
									<div class="card-body">
										<p class="ac-para"><?php murailles_t( "Pour une vente, les honoraires sont en général de 2,5 % TTC du prix de cession à la charge du vendeur et 2,5 % TTC à la charge de l'acquéreur, selon le mandat signé. Pour une location longue durée, ils correspondent à un mois de loyer, partagé entre bailleur et locataire. Les chiffres définitifs figurent toujours dans le mandat et sont communiqués avant toute visite." ); ?></p>
									</div>
								</div>
							</div>

							<div class="card">
								<div class="card-header" id="hHon2">
									<h2 class="mb-0">
										<button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cHon2" aria-expanded="false" aria-controls="cHon2">
											<?php murailles_t( 'À quel moment sont-ils payés ?' ); ?>
										</button>
									</h2>
								</div>
								<div id="cHon2" class="collapse" aria-labelledby="hHon2" data-parent="#faqHono">
									<div class="card-body">
										<p class="ac-para"><?php murailles_t( "Les honoraires ne sont dus qu'en cas de transaction effectivement réalisée — c'est-à-dire à la signature de l'acte authentique chez le notaire pour une vente, ou à la signature du bail pour une location. Aucun acompte n'est demandé en amont." ); ?></p>
									</div>
								</div>
							</div>

							<div class="card">
								<div class="card-header" id="hHon3">
									<h2 class="mb-0">
										<button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cHon3" aria-expanded="false" aria-controls="cHon3">
											<?php murailles_t( 'Faut-il payer pour visiter un bien ?' ); ?>
										</button>
									</h2>
								</div>
								<div id="cHon3" class="collapse" aria-labelledby="hHon3" data-parent="#faqHono">
									<div class="card-body">
										<p class="ac-para"><?php murailles_t( "Non. Les visites, les estimations et les conseils sont gratuits et sans engagement. Nous nous engageons à ne facturer qu'en cas de transaction conclue grâce à notre intermédiation." ); ?></p>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>

				<!-- ── 5. Mon compte & favoris ──────────────────────────────────── -->
				<div class="faq_wrap">
					<div class="faq_wrap_title">
						<h4><?php murailles_t( 'Site, favoris et notifications' ); ?></h4>
					</div>
					<div class="faq_wrap_body">
						<div class="accordion" id="faqCompte">

							<div class="card">
								<div class="card-header" id="hCpt1">
									<h2 class="mb-0">
										<button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#cCpt1" aria-expanded="true" aria-controls="cCpt1">
											<?php murailles_t( 'Comment enregistrer un bien dans mes favoris ?' ); ?>
										</button>
									</h2>
								</div>
								<div id="cCpt1" class="collapse show" aria-labelledby="hCpt1" data-parent="#faqCompte">
									<div class="card-body">
										<p class="ac-para"><?php
											printf(
												/* translators: %s is the «Favourites» page link */
												murailles_t( "Sur chaque fiche, cliquez sur l'icône cœur. Le bien est immédiatement ajouté à vos favoris, consultables depuis la page %s. Aucune inscription n'est nécessaire : vos favoris sont conservés localement dans votre navigateur.", false ),
												'<a href="' . esc_url( home_url( '/favoris/' ) ) . '">' . esc_html( murailles_t( 'Mes favoris', false ) ) . '</a>'
											);
										?></p>
									</div>
								</div>
							</div>

							<div class="card">
								<div class="card-header" id="hCpt2">
									<h2 class="mb-0">
										<button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cCpt2" aria-expanded="false" aria-controls="cCpt2">
											<?php murailles_t( 'Puis-je comparer plusieurs biens ?' ); ?>
										</button>
									</h2>
								</div>
								<div id="cCpt2" class="collapse" aria-labelledby="hCpt2" data-parent="#faqCompte">
									<div class="card-body">
										<p class="ac-para"><?php
											printf(
												/* translators: %s is the «Compare» page link */
												murailles_t( "Oui. Vous pouvez ajouter jusqu'à deux biens au comparateur via l'icône balance présente sur chaque fiche, puis consulter le tableau comparatif depuis le bouton flottant en bas de page ou via %s.", false ),
												'<a href="' . esc_url( home_url( '/compare-property/' ) ) . '">' . esc_html( murailles_t( 'Comparer', false ) ) . '</a>'
											);
										?></p>
									</div>
								</div>
							</div>

							<div class="card">
								<div class="card-header" id="hCpt3">
									<h2 class="mb-0">
										<button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cCpt3" aria-expanded="false" aria-controls="cCpt3">
											<?php murailles_t( 'Comment être alerté des nouveaux biens ?' ); ?>
										</button>
									</h2>
								</div>
								<div id="cCpt3" class="collapse" aria-labelledby="hCpt3" data-parent="#faqCompte">
									<div class="card-body">
										<p class="ac-para"><?php
											printf(
												/* translators: %s is the contact page link */
												murailles_t( 'Indiquez votre projet via le formulaire de %s en précisant ville, type de bien et budget. Nous vous enverrons les nouvelles annonces correspondantes par e-mail ou WhatsApp dès leur mise en ligne.', false ),
												'<a href="' . esc_url( home_url( '/contact/' ) ) . '">' . esc_html( murailles_t( 'contact', false ) ) . '</a>'
											);
										?></p>
									</div>
								</div>
							</div>

							<div class="card">
								<div class="card-header" id="hCpt4">
									<h2 class="mb-0">
										<button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cCpt4" aria-expanded="false" aria-controls="cCpt4">
											<?php murailles_t( "Une question qui n'apparaît pas ici ?" ); ?>
										</button>
									</h2>
								</div>
								<div id="cCpt4" class="collapse" aria-labelledby="hCpt4" data-parent="#faqCompte">
									<div class="card-body">
										<p class="ac-para"><?php
											printf(
												/* translators: %s is the Contact page link */
												murailles_t( 'Écrivez-nous via la page %s ou par WhatsApp : nous répondons en général sous quelques heures, du lundi au samedi.', false ),
												'<a href="' . esc_url( home_url( '/contact/' ) ) . '">' . esc_html( murailles_t( 'Contact', false ) ) . '</a>'
											);
										?></p>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>
<!-- ================= /FAQ Sections ================= -->

<?php murailles_render_page_builder_content(); ?>

<?php get_template_part( 'template-parts/call-to-action' ); ?>

<?php get_footer(); ?>
