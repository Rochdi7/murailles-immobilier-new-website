<?php
/**
 * Pre-registered English translations for static UI strings.
 *
 * Every French source string used in the theme via murailles_t( '...' ) is
 * listed here with its English counterpart. On every page load we:
 *   1. Register the string with Polylang's String Translation panel
 *      (so admins can override it later), and
 *   2. Seed the EN translation so Polylang returns it for free without anyone
 *      having to copy/paste each string in the admin.
 *
 * If Polylang isn't installed, this file is a no-op — murailles_t() will
 * fall back to the raw French default.
 *
 * To add a new string:
 *   - call murailles_t( 'Source FR' ) somewhere in a template
 *   - add an entry below: 'Source FR' => 'English target'
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Master dictionary of FR -> EN translations for the static UI.
 * Order is alphabetical-ish but doesn't matter — we walk the array.
 *
 * @return array<string,string>
 */
function murailles_i18n_dictionary() {
	return array(

		// === Header & navigation ============================================
		'Accueil'                  => 'Home',
		'Biens immobiliers'        => 'Properties',
		'Nos Services'             => 'Our Services',
		'Comparer'                 => 'Compare',
		'Blog'                     => 'Blog',
		'Navigation'               => 'Navigation',
		'Informations'             => 'Information',
		'A propos'                 => 'About',
		'À propos'                 => 'About',
		'Contact'                  => 'Contact',
		'FAQ'                      => 'FAQ',
		'Confidentialité'          => 'Privacy',
		'Conditions générales'     => 'Terms of Use',
		'Choisir la langue'        => 'Choose language',
		// nav-fallback.php sub-menus
		'Vente'                    => 'Sale',
		'Location'                 => 'Rent',
		'Déposer une annonce'      => 'Submit a Listing',
		'Riads'                    => 'Riads',
		"Maison d'hôte"            => 'Guest house',
		"Riad d'habitation"        => 'Living riad',
		'Riad habitation'          => 'Living riad',
		'Riad rénové'              => 'Renovated riad',
		'Riad à rénover'           => 'Riad to renovate',
		'Hotel'                    => 'Hotel',
		'Terrain'                  => 'Land',
		'Ferme'                    => 'Farm',
		'Bureaux'                  => 'Offices',
		'Assistance & conseils'    => 'Assistance & advice',
		'Histoire de Marrakech'    => 'History of Marrakech',
		'Tourisme à Marrakech'     => 'Tourism in Marrakech',

		// === Footer / newsletter ===========================================
		"Besoin d'aide pour"       => 'Need help with',
		'votre projet ?'           => 'your project?',
		'Recevez chaque mois nos nouvelles annonces, conseils et actualités du marché immobilier marocain directement dans votre boîte mail.'
			=> 'Receive our latest listings, advice and Moroccan real-estate market news in your inbox every month.',
		'Adresse e-mail'           => 'Email address',
		"S'abonner"                => 'Subscribe',
		'Tous droits réservés.'    => 'All rights reserved.',
		'Retour en haut'           => 'Back to top',

		// === Call to action ================================================
		'Vous avez des questions ?' => 'Have questions?',
		'Nous sommes disponibles pour vous accompagner dans votre projet immobilier.'
			=> 'We are available to support you with your real-estate project.',
		'Contactez-nous'           => 'Contact us',

		// === Blog card badges ==============================================
		'Nouveau'                  => 'New',
		'Populaire'                => 'Hot',

		// === Error page (404/403/500/503/maintenance) ======================
		'Page introuvable'         => 'Page not found',
		"La page que vous cherchez n'existe pas, a été déplacée, ou son lien est obsolète. Pas d'inquiétude — utilisez la recherche ou explorez nos catégories pour trouver le bien qu'il vous faut."
			=> "The page you are looking for does not exist, has moved, or its link is out of date. Don't worry — use the search or explore our categories to find the property you need.",
		'Accès refusé'             => 'Access denied',
		"Vous n'avez pas l'autorisation d'accéder à cette page. Si vous pensez qu'il s'agit d'une erreur, contactez-nous."
			=> "You don't have permission to access this page. If you think this is a mistake, contact us.",
		'Erreur serveur'           => 'Server error',
		"Une erreur inattendue est survenue de notre côté. Nous travaillons à la résoudre — merci de réessayer dans quelques instants."
			=> 'An unexpected error occurred on our side. We are working to fix it — please try again in a few moments.',
		'Service indisponible'     => 'Service unavailable',
		"Le site est temporairement indisponible pour maintenance. Nous serons de retour très bientôt."
			=> 'The site is temporarily down for maintenance. We will be back very soon.',
		'Maintenance en cours'     => 'Maintenance in progress',
		'Le site fait peau neuve. Merci de revenir dans quelques minutes.'
			=> 'The site is getting a refresh. Please come back in a few minutes.',
		'Une erreur est survenue'  => 'An error occurred',
		"Quelque chose s'est mal passé. Veuillez réessayer ou revenir à l'accueil."
			=> 'Something went wrong. Please try again or go back to the home page.',
		'Rechercher un bien'       => 'Search for a property',
		'Rechercher un bien, une ville, un quartier…'
			=> 'Search for a property, city, neighbourhood…',
		'Rechercher'               => 'Search',
		"Retour à l'accueil"       => 'Back to home',
		'Parcourir les biens'      => 'Browse properties',
		'Nous contacter'           => 'Contact us',
		'Recherches populaires :'  => 'Popular searches:',

		// === Search results page ===========================================
		'Résultats de recherche'   => 'Search results',
		'Utilisez le menu de navigation pour trouver ce que vous cherchez.'
			=> 'Use the navigation menu to find what you are looking for.',

		// === Front page: hero ==============================================
		'Trouvez votre prochain bien'  => 'Find your next property',
		'Découvrez les nouveaux biens immobiliers à la une dans votre ville.'
			=> 'Discover the new featured properties in your city.',
		'Ville / Quartier'             => 'City / Neighbourhood',
		'Type de bien'                 => 'Property type',
		'Fourchette de prix'           => 'Price range',
		'De 40 000 € à 100 000 €'      => '€40,000 – €100,000',
		'De 100 000 € à 250 000 €'     => '€100,000 – €250,000',
		'De 250 000 € à 500 000 €'     => '€250,000 – €500,000',
		'De 500 000 € à 1 000 000 €'   => '€500,000 – €1,000,000',
		'Plus de 1 000 000 €'          => 'Over €1,000,000',

		// === Front page: awards block ======================================
		'avis au total'                => 'total reviews',

		// === Front page: category section ==================================
		'Choisissez votre catégorie'   => 'Choose your category',
		"Explorez nos biens immobiliers par type : riads d'exception, appartements, villas, terrains et locaux professionnels au cœur du Maroc."
			=> 'Explore our properties by type: exceptional riads, apartments, villas, land and commercial spaces at the heart of Morocco.',
		'%s Bien'                      => '%s Property',
		'%s Biens'                     => '%s Properties',

		// === Front page: featured properties ==============================
		'Biens immobiliers à la une'   => 'Featured properties',
		'Une sélection exclusive de riads, villas et appartements à Marrakech, Casablanca, Rabat et dans les plus belles villes du Maroc.'
			=> 'An exclusive selection of riads, villas and apartments in Marrakech, Casablanca, Rabat and the most beautiful cities of Morocco.',
		'Ch.'                          => 'Br.',  // chambres → bedrooms
		'SdB'                          => 'Bath', // salles de bain → bathrooms
		'Enregistrer le bien'          => 'Save property',
		'Comparer le bien'             => 'Compare property',
		'Voir le bien'                 => 'View property',
		'Voir tous les biens'          => 'View all properties',
		'À louer'                      => 'For Rent',
		'À vendre'                     => 'For Sale',
		'Riad'                         => 'Riad',
		'Appartement'                  => 'Apartment',
		'Villa'                        => 'Villa',
		'mois'                         => 'month',
		'Marrakech, Maroc'             => 'Marrakech, Morocco',

		// === Front page: how it works ======================================
		'Comment ça marche ?'          => 'How it works?',
		"Trois étapes simples pour trouver le bien immobilier qui vous correspond avec l'Agence Murailles : créez votre compte, parcourez nos annonces et réservez votre coup de cœur."
			=> "Three simple steps to find the property that suits you with Agence Murailles: create your account, browse our listings and book your favourite.",
		'Créez votre compte'           => 'Create your account',
		'Inscrivez-vous gratuitement en quelques clics pour accéder à toutes nos annonces et enregistrer vos favoris.'
			=> 'Sign up for free in a few clicks to access all our listings and save your favourites.',
		'Trouvez votre bien'           => 'Find your property',
		'Filtrez par ville, type de bien et budget pour découvrir les riads, villas et appartements qui correspondent à vos critères.'
			=> 'Filter by city, property type and budget to discover the riads, villas and apartments that match your criteria.',
		'Réservez votre bien'          => 'Book your property',
		"Contactez notre équipe pour organiser une visite, négocier le prix et finaliser votre acquisition en toute sérénité."
			=> 'Contact our team to arrange a visit, negotiate the price and finalize your purchase with peace of mind.',

		// === Front page: about us ==========================================
		"Années d'expérience"          => 'Years of experience',
		'À propos de nous'             => 'About us',
		'Qui sommes-nous ?'            => 'Who are we?',
		"est sans aucun doute l'agence immobilière la plus investie en termes de suivi et d'accompagnement dans vos projets immobiliers."
			=> 'is without doubt the most committed real-estate agency in terms of follow-up and support for your property projects.',
		"Depuis la création de l'agence, le fondateur"
			=> 'Since the agency was founded, founder',
		"a comme principal objectif de dénicher le produit tant espéré par ses clients. La présence et l'implication de notre équipe dans les différents secteurs de Marrakech garantissent une analyse experte de votre bien à vendre ou de votre acquisition au juste prix."
			=> "has had one main goal: to find the property his clients have been hoping for. Our team's presence and involvement across the different districts of Marrakech ensures expert analysis of your property for sale or your purchase at the right price.",
		"Chaque type de bien et chaque secteur de Marrakech répondent à une logique de marché distincte, c'est l'ensemble de ces savoir-faire que nous mettons à votre disposition."
			=> 'Each property type and each district of Marrakech follows a distinct market logic — and it is all of this know-how that we put at your disposal.',
		'Découvrir nos services'       => 'Discover our services',
		"L'Agence Murailles Immobilier vous propose :"
			=> 'Agence Murailles Immobilier offers you:',
		"Riads & maisons d'hôtes"      => 'Riads & guest houses',
		'Un large choix dans la médina, la Kasbah ou dans les alentours de Marrakech.'
			=> 'A wide selection in the medina, the Kasbah or around Marrakech.',
		'Appartements & villas'        => 'Apartments & villas',
		'À vendre ou à louer dans les quartiers de Guéliz et Hivernage.'
			=> 'For sale or rent in the Guéliz and Hivernage districts.',
		'Commerces & restaurants'      => 'Shops & restaurants',
		'À vendre ou à louer, courte ou longue durée.'
			=> 'For sale or rent, short or long term.',
		'Terrains à bâtir'             => 'Building land',
		"Route de l'Ourika, Amezmiz, Tahennaoute, Sidi Abdellah Ghiat, Fès, Ouarzazate, Bab Atlas, Palmeraie, Amelkis…"
			=> 'Ourika Road, Amezmiz, Tahennaoute, Sidi Abdellah Ghiat, Fès, Ouarzazate, Bab Atlas, Palmeraie, Amelkis…',
		'Gestion & promotion'          => 'Management & promotion',
		'Ne laissez plus vos biens vacants — rentabilisez-les avec notre service de gestion locative.'
			=> "Don't leave your properties vacant — make them profitable with our rental management service.",
		'Accompagnement A à Z'         => 'Full A-to-Z support',
		'Négociation, ouverture de compte, compromis, crédit, acte de vente, clauses suspensives, bail…'
			=> 'Negotiation, account opening, preliminary contract, financing, deed of sale, conditional clauses, lease…',
		'Notre engagement'             => 'Our commitment',
		"Une approche globale et sécurisante pour votre projet de vie ou d'investissement."
			=> 'A holistic and reassuring approach for your life or investment project.',
		"Notre réseau de partenaires sérieux — banques, architectes, notaires, bureaux d'étude, experts-comptables, entrepreneurs et artisans — vous accompagne dans chaque étape. Chaque client est unique avec son projet personnel : nous vous conseillons depuis la recherche du bien jusqu'aux travaux de construction ou de rénovation."
			=> 'Our network of trusted partners — banks, architects, notaries, design firms, chartered accountants, contractors and craftsmen — supports you at every step. Each client is unique with a personal project: we advise you from the property search through to construction or renovation work.',

		// === Front page: cities ============================================
		'Villes phares au Maroc'       => 'Top cities in Morocco',
		'Explorez les biens immobiliers disponibles dans les destinations les plus recherchées du Royaume : Marrakech, Casablanca, Rabat, Tanger et Fès.'
			=> 'Explore the properties available in the most sought-after destinations of the Kingdom: Marrakech, Casablanca, Rabat, Tangier and Fes.',
		'Casablanca, Maroc'            => 'Casablanca, Morocco',
		'Rabat, Maroc'                 => 'Rabat, Morocco',
		'Tanger, Maroc'                => 'Tangier, Morocco',
		'Fès, Maroc'                   => 'Fes, Morocco',
		'Voir les biens'               => 'View properties',

		// === Front page: testimonials ======================================
		'Avis de nos clients'          => 'Our client reviews',
		'Découvrez les témoignages de propriétaires et acheteurs qui nous ont fait confiance pour leur projet immobilier au Maroc.'
			=> 'Discover the testimonials of owners and buyers who trusted us with their real-estate project in Morocco.',
		'Propriétaire'                 => 'Owner',
		'Acheteuse, Marrakech'         => 'Buyer, Marrakech',
		'Investisseur'                 => 'Investor',
		'Locataire, Casablanca'        => 'Tenant, Casablanca',
		"L'équipe d'Agence Murailles m'a accompagnée du premier rendez-vous à la signature. Service réactif, conseils avisés et belle sélection de biens à Marrakech."
			=> "The Agence Murailles team supported me from the first meeting to the signing. Responsive service, sound advice and a beautiful selection of properties in Marrakech.",

		// === Front page: bottom CTA + articles =============================
		'Vous cherchez le lieu idéal pour réaliser votre rêve ?'
			=> 'Looking for the perfect place to make your dream come true?',
		"Riads d'exception dans la médina, villas avec piscine à la Palmeraie, appartements modernes à Casablanca ou Rabat — l'Agence Murailles vous accompagne pour trouver le bien qui correspond à votre projet de vie au Maroc."
			=> 'Exceptional riads in the medina, villas with pools in the Palmeraie, modern apartments in Casablanca or Rabat — Agence Murailles helps you find the property that matches your life project in Morocco.',
		'Actualités & Articles'        => 'News & Articles',
		'Conseils, tendances du marché et guides pour acheter, vendre ou louer votre bien immobilier au Maroc.'
			=> 'Tips, market trends and guides to buy, sell or rent your property in Morocco.',
		'Tendance'                     => 'Trending',

		// === Single property ==============================================
		'Garage'                       => 'Garage',
		'Garage(s)'                    => 'Garage(s)',
		'Description du bien'          => 'Property description',
		'Caractéristiques'             => 'Features',
		'Chambres'                     => 'Bedrooms',
		'Salles de bain'               => 'Bathrooms',
		'Pièces'                       => 'Rooms',
		'Construit'                    => 'Built',
		// 'Terrain' — defined above in header/nav section
		'Équipements'                  => 'Amenities',
		'Vidéo du bien'                => 'Property video',
		'Localisation'                 => 'Location',
		'Détails rapides'              => 'Quick details',
		'Type'                         => 'Type',
		'Superficie'                   => 'Area',
		'Quartier'                     => 'Neighbourhood',
		'Référence'                    => 'Reference',
		'Je suis intéressé(e) par :'   => 'I am interested in:',
		'Contacter via WhatsApp'       => 'Contact via WhatsApp',
		'Envoyer un message'           => 'Send a message',
		"Demande d'information"        => 'Information request',
		'Votre nom'                    => 'Your name',
		'Votre email'                  => 'Your email',
		'Votre téléphone'              => 'Your phone',
		'Je suis intéressé(e) par ce bien...'
			=> 'I am interested in this property...',
		'Envoyer'                      => 'Send',
		'Biens similaires'             => 'Similar properties',
		'Enregistrer dans mes favoris' => 'Save to favourites',
		'Partager ce bien'             => 'Share this property',

		// Amenity labels
		'Piscine'                      => 'Pool',
		'Climatisation'                => 'Air conditioning',
		'Parking'                      => 'Parking',
		'Jardin'                       => 'Garden',
		'Terrasse'                     => 'Terrace',
		'Wi-Fi'                        => 'Wi-Fi',
		'Sécurité'                     => 'Security',
		'Balcon'                       => 'Balcony',
		'Chauffage'                    => 'Heating',
		'Meublé'                       => 'Furnished',
		'Gardien'                      => 'Caretaker',
		'Toit-terrasse'                => 'Roof terrace',
		'Ascenseur'                    => 'Elevator',
		'Cheminée'                     => 'Fireplace',
		'Buanderie'                    => 'Laundry room',
		'Conciergerie'                 => 'Concierge',
		'Vue sur mer'                  => 'Sea view',
		'Vue sur lac'                  => 'Lake view',
		'Salle de sport'               => 'Gym',
		'Grenier'                      => 'Attic',
		'Cave à vin'                   => 'Wine cellar',
		'Espace privé'                 => 'Private area',
		'Rangement'                    => 'Storage',
		'Salle de loisirs'             => 'Recreation room',
		'Lave-linge'                   => 'Washing machine',
		'Chauffage gaz'                => 'Gas heating',
		'Terrain de basket'            => 'Basketball court',
		'Bassin'                       => 'Pond',
		'Jardin arrière'               => 'Back garden',
		'Jardin avant'                 => 'Front garden',
		'Cour clôturée'                => 'Fenced yard',
		'Arroseurs automatiques'       => 'Automatic sprinklers',

		// === Archive property =============================================
		'Grille'                       => 'Grid',
		'Affichage'                    => 'Showing',
		'sur'                          => 'of',
		'résultats'                    => 'results',
		'Trier par :'                  => 'Sort by:',
		'Plus récents'                 => 'Most recent',
		'Prix croissant'               => 'Price ascending',
		'Prix décroissant'             => 'Price descending',
		'Filtre avancé'                => 'Advanced filter',
		'actif'                        => 'active',
		'actifs'                       => 'active',
		'Mot-clé, référence...'        => 'Keyword, reference...',
		'Action'                       => 'Action',
		'Ville'                        => 'City',
		'Chambres (min.)'              => 'Bedrooms (min.)',
		'Salles de bain (min.)'        => 'Bathrooms (min.)',
		'Prix min. (€)'                => 'Min. price (€)',
		'Prix max. (€)'                => 'Max. price (€)',
		'Surface min. (m²)'            => 'Min. area (m²)',
		'Surface max. (m²)'            => 'Max. area (m²)',
		'Année de construction'        => 'Year built',
		'Réinitialiser'                => 'Reset',
		'A Vendre'                     => 'For Sale',
		'Sauvegarder'                  => 'Save',
		'Aucun bien trouvé'            => 'No properties found',
		'Revenez bientôt, de nouveaux biens sont ajoutés régulièrement.'
			=> 'Check back soon, new properties are added regularly.',

		// === Compare property =============================================
		'Comparer les biens'           => 'Compare properties',
		'Aucun bien à comparer'        => 'No property to compare',
		"Cliquez sur l'icône"          => 'Click the icon',
		"d'un bien pour l'ajouter à la comparaison (max. 2 biens)."
			=> 'on a property to add it to the comparison (max. 2 properties).',
		'Voir les biens disponibles'   => 'View available properties',

		// === Favoris ======================================================
		'Mes favoris'                  => 'My favourites',
		'Mes biens favoris'            => 'My favourite properties',
		"Aucun favori pour l'instant"  => 'No favourites yet',
		'Parcourez nos biens et cliquez sur le cœur pour les enregistrer ici.'
			=> 'Browse our properties and click the heart icon to save them here.',
		'Vider mes favoris'            => 'Clear my favourites',

		// === Contact page =================================================
		'Une équipe à votre écoute'    => 'A team at your service',
		"Besoin d'aide pour votre projet immobilier ? Nous sommes joignables 7 jours sur 7."
			=> 'Need help with your real-estate project? We are reachable 7 days a week.',
		'Téléphone'                    => 'Phone',
		'Joignable 7j/7'               => 'Reachable 7 days a week',
		'E-mail'                       => 'Email',
		'Réponse sous 24h'             => 'Reply within 24 hours',
		'Adresse'                      => 'Address',
		'13 Rue Mouslim, Résidence Boukar' => '13 Mouslim Street, Résidence Boukar',
		'2ème étage Bureau N°10, Marrakesh 40000'
			=> '2nd floor, Office N°10, Marrakech 40000',
		'Écrivez-nous'                 => 'Write to us',
		'Nom complet'                  => 'Full name',
		'Sujet'                        => 'Subject',
		'Message'                      => 'Message',
		'Envoyer ma demande'           => 'Send my request',
		'Nos derniers biens'           => 'Our latest properties',
		"Découvrez les biens immobiliers les plus récemment ajoutés par l'Agence Murailles à travers le Maroc."
			=> 'Discover the most recently added properties by Agence Murailles across Morocco.',
		'Aucun bien disponible pour le moment.' => 'No property available at the moment.',
		'Aucun article publié pour le moment.'  => 'No article published yet.',

		// === FAQ page =====================================================
		'Questions fréquentes'         => 'Frequently asked questions',
		'Acheter, louer, vendre ou louer son bien au Maroc — toutes les réponses ici.'
			=> 'Buy, rent, sell or lease your property in Morocco — all the answers here.',
		'Recherchez un bien (riad, villa, ville…)'
			=> 'Search for a property (riad, villa, city…)',
		'Acheter un bien au Maroc'     => 'Buying a property in Morocco',
		'Un étranger peut-il acheter un bien au Maroc ?'
			=> 'Can a foreigner buy a property in Morocco?',
		"Oui. Le Maroc autorise les ressortissants étrangers à acquérir des biens immobiliers urbains (riads, villas, appartements) sans autorisation préalable. Seuls les terrains à vocation agricole sont soumis à des restrictions spécifiques. L'acte authentique se signe chez un notaire marocain, qui sécurise la transaction et l'inscription au registre foncier (titre foncier « melkia » ou titre conservé)."
			=> 'Yes. Morocco allows foreign nationals to acquire urban real estate (riads, villas, apartments) without prior authorisation. Only agricultural land is subject to specific restrictions. The deed is signed at a Moroccan notary, who secures the transaction and the land-registry entry ("melkia" title or conserved title).',
		'Quels documents faut-il fournir pour acheter ?'
			=> 'What documents are required to buy?',
		"Une pièce d'identité en cours de validité (carte d'identité nationale ou passeport), un justificatif de domicile et un compte bancaire — au Maroc ou à l'étranger pour les non-résidents. Pour un investissement par un non-résident, l'ouverture d'un compte en dirhams convertibles est recommandée afin de pouvoir, à la revente, transférer le produit de la vente hors du Maroc."
			=> 'A valid ID (national ID card or passport), proof of address, and a bank account — in Morocco or abroad for non-residents. For an investment by a non-resident, opening a convertible-dirham account is recommended so that, on resale, the sale proceeds can be transferred outside Morocco.',
		"Quels frais s'ajoutent au prix du bien ?"
			=> 'What fees are added to the property price?',
		"Comptez environ 5 à 7 % du prix d'achat de frais annexes : droits d'enregistrement (4 % pour un bien d'habitation), conservation foncière (1,5 %), honoraires de notaire (environ 0,5 à 1 %), timbres et taxe notariale, plus les honoraires d'agence. Notre équipe vous remet un chiffrage complet avant la signature du compromis."
			=> "Plan for around 5-7 % of the purchase price in additional fees: registration duty (4 % for a residential property), land registry (1.5 %), notary fees (around 0.5 to 1 %), stamps and notary tax, plus agency fees. Our team provides a full breakdown before the preliminary contract.",
		'Combien de temps prend une transaction ?'
			=> 'How long does a transaction take?',
		"En moyenne 6 à 10 semaines entre la signature du compromis et l'acte authentique. Ce délai permet au notaire de réaliser les vérifications d'usage : titre de propriété, urbanisme, absence d'hypothèque, situation fiscale du vendeur. Pour les biens en cours d'immatriculation foncière, le délai peut être plus long : nous vous l'indiquons dès la visite."
			=> "On average 6-10 weeks between the preliminary contract and the deed. This allows the notary to perform standard checks: title, planning, absence of mortgage, seller's tax situation. For properties undergoing land registration, the delay can be longer — we tell you at the first visit.",
		"Peut-on obtenir un crédit immobilier au Maroc en tant qu'étranger ?"
			=> 'Can a foreigner get a mortgage in Morocco?',
		'Oui, plusieurs banques marocaines proposent des crédits aux non-résidents, généralement à hauteur de 60 à 70 % du prix du bien, sur une durée de 15 à 20 ans. Les dossiers sont étudiés au cas par cas selon les revenus et le profil. Nous pouvons vous mettre en relation avec un courtier partenaire.'
			=> 'Yes, several Moroccan banks offer loans to non-residents, generally up to 60-70 % of the property price, over 15-20 years. Each application is reviewed case by case based on income and profile. We can connect you with a partner broker.',
		'Louer un bien'                => 'Renting a property',
		'Comment réserver une visite ?' => 'How to book a viewing?',
		"Depuis la fiche d'un bien, cliquez sur « Demander une visite » ou contactez-nous via le formulaire, par e-mail ou par WhatsApp. Notre équipe vous propose un créneau sous 24 à 48 heures et confirme la disponibilité du bien."
			=> 'From a property page, click "Request a viewing" or contact us via the form, by email, or by WhatsApp. Our team proposes a slot within 24-48 hours and confirms the property availability.',
		'Quels documents pour signer un bail ?'
			=> 'What documents to sign a lease?',
		"Une pièce d'identité, un justificatif de domicile précédent, un justificatif de revenus (bulletins de salaire ou attestation d'activité), et un RIB. Pour les étudiants ou les non-résidents, un garant solvable peut être demandé. Le dépôt de garantie est en général équivalent à 1 ou 2 mois de loyer hors charges."
			=> "ID, proof of previous address, proof of income (payslips or activity certificate), and a bank-account details slip (RIB). For students or non-residents, a solvent guarantor may be required. The security deposit is usually equivalent to 1-2 months' rent excluding charges.",
		'Location longue durée ou saisonnière : quelle différence ?'
			=> 'Long-term or seasonal rental: what is the difference?',
		"La location longue durée (généralement 1 an renouvelable) s'adresse aux résidents et expatriés. La location saisonnière, à la nuit ou à la semaine, concerne plutôt les riads et villas de vacances. Le cadre juridique, les obligations fiscales et le mode de calcul du loyer diffèrent — notre équipe vous oriente selon votre projet."
			=> 'Long-term rental (usually 1 year renewable) is for residents and expats. Seasonal rental, by the night or week, applies more to riads and holiday villas. The legal framework, tax obligations and the way rent is calculated differ — our team will advise based on your project.',
		'Le mobilier et les charges sont-ils inclus ?'
			=> 'Are furniture and charges included?',
		"Cela dépend du bien. Chaque annonce précise s'il s'agit d'une location meublée ou vide, et la liste des charges incluses (syndic, eau, internet) ou exclues. En cas de doute, nous fournissons un état détaillé sur demande avant la signature."
			=> 'It depends on the property. Each listing specifies whether the rental is furnished or unfurnished, plus the list of included charges (building management, water, internet) and excluded charges. If in doubt, we provide a detailed breakdown on request before signing.',
		'Vendre ou louer mon bien (déposer une annonce)'
			=> 'Selling or renting my property (submit a listing)',
		'Comment déposer une annonce ?' => 'How to submit a listing?',
		'Rendez-vous sur la page %s, renseignez les informations principales (type de bien, ville, surface, prix) et ajoutez vos photos. Un conseiller vous rappelle ensuite pour valider le mandat et planifier, si vous le souhaitez, une séance photo professionnelle.'
			=> 'Go to the %s page, fill in the main details (property type, city, area, price) and upload your photos. An advisor will then call you back to validate the mandate and schedule a professional photo session if you wish.',
		// 'Déposer une annonce' — defined above in header/nav section
		'Mandat simple ou mandat exclusif ?'
			=> 'Open or exclusive mandate?',
		"Le mandat simple vous laisse libre de confier le bien à plusieurs agences. Le mandat exclusif nous confie la commercialisation pour une durée définie : en contrepartie, vous bénéficiez d'un investissement marketing plus important (photos pro, mise en avant sur le site, campagnes sponsorisées) et d'un interlocuteur unique. La plupart des biens haut de gamme se vendent plus vite en exclusivité."
			=> 'An open mandate lets you give the property to several agencies. An exclusive mandate gives us the listing for a defined period: in return, you get bigger marketing investment (pro photos, featured placement, sponsored campaigns) and a single point of contact. Most high-end properties sell faster on exclusive mandate.',
		'Comment estimer mon bien ?'   => 'How is my property valued?',
		"Nous réalisons une estimation gratuite et confidentielle sur place. Elle s'appuie sur les transactions récentes du quartier, l'état du bien, ses prestations et la tendance du marché. Cette estimation vous est remise par écrit, sans engagement de mandat."
			=> 'We carry out a free, confidential on-site valuation. It is based on recent neighbourhood transactions, the property condition, its features and market trends. The valuation is given to you in writing, with no obligation to sign a mandate.',
		'Quels documents préparer pour vendre ?'
			=> 'What documents to prepare to sell?',
		"Le titre de propriété (ou la moulkia), le plan cadastral, les dernières quittances de taxe d'habitation et de taxe de services communaux, l'état des charges de syndic le cas échéant, et toute autorisation d'urbanisme (permis de construire, permis d'habiter). Nous vous accompagnons pour réunir ces pièces."
			=> 'The title deed (or "moulkia"), the cadastral plan, the latest housing-tax and municipal-services-tax receipts, the building-management charges statement if applicable, and any planning permission (building permit, habitation permit). We assist you in gathering these documents.',
		'Honoraires et paiement'       => 'Fees and payment',
		"Quels sont les honoraires de l'Agence ?"
			=> "What are the Agency's fees?",
		"Pour une vente, les honoraires sont en général de 2,5 % TTC du prix de cession à la charge du vendeur et 2,5 % TTC à la charge de l'acquéreur, selon le mandat signé. Pour une location longue durée, ils correspondent à un mois de loyer, partagé entre bailleur et locataire. Les chiffres définitifs figurent toujours dans le mandat et sont communiqués avant toute visite."
			=> 'For a sale, fees are usually 2.5 % incl. tax of the sale price for the seller and 2.5 % incl. tax for the buyer, depending on the signed mandate. For long-term rental, they equal one month\'s rent, shared between landlord and tenant. The final figures are always in the mandate and communicated before any viewing.',
		'À quel moment sont-ils payés ?'
			=> 'When are they paid?',
		"Les honoraires ne sont dus qu'en cas de transaction effectivement réalisée — c'est-à-dire à la signature de l'acte authentique chez le notaire pour une vente, ou à la signature du bail pour une location. Aucun acompte n'est demandé en amont."
			=> 'Fees are only due once the transaction actually completes — i.e. on signing of the deed at the notary for a sale, or on signing of the lease for a rental. No advance payment is requested.',
		'Faut-il payer pour visiter un bien ?'
			=> 'Is there a fee to view a property?',
		"Non. Les visites, les estimations et les conseils sont gratuits et sans engagement. Nous nous engageons à ne facturer qu'en cas de transaction conclue grâce à notre intermédiation."
			=> 'No. Viewings, valuations and advice are free and without obligation. We only charge when a transaction is concluded through our intermediation.',
		'Site, favoris et notifications'
			=> 'Site, favourites and notifications',
		'Comment enregistrer un bien dans mes favoris ?'
			=> 'How to save a property to my favourites?',
		"Sur chaque fiche, cliquez sur l'icône cœur. Le bien est immédiatement ajouté à vos favoris, consultables depuis la page %s. Aucune inscription n'est nécessaire : vos favoris sont conservés localement dans votre navigateur."
			=> 'On each property page, click the heart icon. The property is immediately added to your favourites, viewable from the %s page. No sign-up is required: your favourites are stored locally in your browser.',
		'Puis-je comparer plusieurs biens ?'
			=> 'Can I compare multiple properties?',
		"Oui. Vous pouvez ajouter jusqu'à deux biens au comparateur via l'icône balance présente sur chaque fiche, puis consulter le tableau comparatif depuis le bouton flottant en bas de page ou via %s."
			=> 'Yes. You can add up to two properties to the comparator via the scales icon on each property page, then view the comparison table from the floating button at the bottom of the page or via %s.',
		'Comment être alerté des nouveaux biens ?'
			=> 'How to be alerted about new properties?',
		'Indiquez votre projet via le formulaire de %s en précisant ville, type de bien et budget. Nous vous enverrons les nouvelles annonces correspondantes par e-mail ou WhatsApp dès leur mise en ligne.'
			=> 'Describe your project via the %s form, specifying city, property type and budget. We will send you matching new listings by email or WhatsApp as soon as they go live.',
		'contact'                      => 'contact',
		"Une question qui n'apparaît pas ici ?"
			=> 'A question not listed here?',
		'Écrivez-nous via la page %s ou par WhatsApp : nous répondons en général sous quelques heures, du lundi au samedi.'
			=> 'Write to us via the %s page or by WhatsApp: we usually reply within a few hours, Monday to Saturday.',

		// === About-us page ================================================
		'À propos — Qui sommes-nous ?' => 'About — Who are we?',
		"L'histoire de notre agence"   => 'Our agency story',
		'Découvrez notre parcours et notre méthode de travail'
			=> 'Discover our background and working method',
		"Depuis sa création, l'Agence Murailles Immobilier s'investit pleinement dans le suivi et l'accompagnement de ses clients. Nous mettons notre connaissance fine du marché marocain au service de chaque projet : achat, vente, location longue durée ou saisonnière."
			=> 'Since its founding, Agence Murailles Immobilier has fully committed to supporting its clients. We put our deep knowledge of the Moroccan market at the service of every project: buying, selling, long-term or seasonal rental.',
		"Notre équipe sillonne quotidiennement Marrakech et les autres villes du Royaume pour vous proposer une sélection rigoureuse de biens : riads d'exception, villas, appartements modernes, terrains à bâtir et locaux commerciaux."
			=> 'Our team travels daily across Marrakech and other cities of the Kingdom to offer you a carefully curated selection of properties: exceptional riads, villas, modern apartments, building land and commercial premises.',
		'En savoir plus'               => 'Learn more',
		'Nos distinctions'             => 'Our awards',
		'Des centaines de clients satisfaits qui continuent à nous faire confiance pour leurs projets immobiliers.'
			=> 'Hundreds of satisfied clients who continue to trust us for their real-estate projects.',
		'Prix Excellence Immobilier'   => 'Real Estate Excellence Award',
		'Trophée Service Client'       => 'Customer Service Trophy',
		'Certification Qualité'        => 'Quality Certification',
		'Label Confiance Client'       => 'Client Trust Label',
		'Notre équipe'                 => 'Our team',
		'Une équipe professionnelle et dévouée à vos côtés'
			=> 'A professional and dedicated team at your side',
		'Co-fondateur'                 => 'Co-founder',
		'Rédacteur'                    => 'Writer',
		'PDG & Directeur'              => 'CEO & Manager',
		'Designer'                     => 'Designer',
		'Développeur Web'              => 'Web Developer',

		// === Blog index / archive =========================================
		'Notre Blog'                   => 'Our Blog',
		'Dernières actualités'         => 'Latest news',
		'Nous publions régulièrement des articles utiles pour vous accompagner dans votre projet immobilier.'
			=> 'We regularly publish useful articles to support you in your real-estate project.',
		'Aucun article pour le moment' => 'No articles yet',
		'Revenez bientôt pour découvrir de nouveaux articles.'
			=> 'Check back soon to discover new articles.',
		'Aucun article trouvé'         => 'No articles found',
		'Essayez une autre catégorie ou revenez plus tard.'
			=> 'Try another category or check back later.',
		'Archive'                      => 'Archive',

		// === Single post ==================================================
		'min de lecture'               => 'min read',
		'commentaires'                 => 'comments',
		'Partager :'                   => 'Share:',
		'Partager sur Facebook'        => 'Share on Facebook',
		'Partager sur X'               => 'Share on X',
		'Partager sur WhatsApp'        => 'Share on WhatsApp',
		'Partager sur LinkedIn'        => 'Share on LinkedIn',
		'Copier le lien'               => 'Copy link',
		'Auteur'                       => 'Author',
		'Contributeur chez Murailles Immobilier.'
			=> 'Contributor at Murailles Immobilier.',
		'Tous les articles de %s'      => 'All articles by %s',
		'À lire également'             => 'Also read',
		'Voir tous les articles'       => 'View all articles',

		// === Privacy + Terms ==============================================
		'Politique de confidentialité' => 'Privacy Policy',
		// 'Conditions générales' — defined above in header/nav section
		"Conditions générales d'utilisation" => 'Terms of Use',
		'Dernière mise à jour : 13 mai 2026'
			=> 'Last updated: 13 May 2026',
		"L'Agence Murailles Immobilier (« nous », « notre », « l'Agence ») accorde une grande importance à la protection des données personnelles de ses visiteurs et clients. La présente politique explique comment vos informations sont collectées, utilisées, conservées et protégées lorsque vous utilisez notre site murailles-immobilier.com ou nos services."
			=> 'Agence Murailles Immobilier ("we", "our", "the Agency") attaches great importance to protecting the personal data of its visitors and clients. This policy explains how your information is collected, used, stored and protected when you use our murailles-immobilier.com website or our services.',
		"Le traitement de vos données est effectué dans le respect de la Loi n°09-08 relative à la protection des personnes physiques à l'égard du traitement des données à caractère personnel, ainsi que des recommandations de la Commission Nationale de Contrôle de la Protection des Données à Caractère Personnel (CNDP)."
			=> 'The processing of your data is carried out in compliance with Law n°09-08 on the protection of individuals with regard to the processing of personal data, and with the recommendations of the National Commission for the Protection of Personal Data (CNDP).',
		'1. Données collectées'        => '1. Data collected',
		'Nous collectons les données personnelles que vous nous communiquez directement, notamment :'
			=> 'We collect the personal data you directly provide to us, in particular:',
		"Vos nom, prénom, adresse e-mail et numéro de téléphone lorsque vous remplissez un formulaire de contact ou de demande d'information ;"
			=> 'Your name, surname, email address and phone number when you fill in a contact or enquiry form;',
		'Les informations relatives à votre projet immobilier (type de bien recherché, budget, ville, surface, etc.) ;'
			=> 'Information about your real-estate project (property type sought, budget, city, area, etc.);',
		"Les informations relatives aux biens que vous souhaitez confier à l'Agence (adresse, photos, prix demandé, documents de propriété) ;"
			=> 'Information about the properties you wish to entrust to the Agency (address, photos, asking price, ownership documents);',
		'Vos préférences de navigation et données techniques (adresse IP, navigateur, pages consultées) collectées via les cookies.'
			=> 'Your browsing preferences and technical data (IP address, browser, pages viewed) collected via cookies.',
		'2. Finalités du traitement'   => '2. Purposes of processing',
		'Vos données sont utilisées uniquement pour :'
			=> 'Your data is used only to:',
		'Répondre à vos demandes de renseignement et organiser les visites de biens ;'
			=> 'Respond to your enquiries and organise property viewings;',
		'Vous proposer des biens correspondant à votre recherche ;'
			=> 'Offer you properties matching your search;',
		'Publier votre annonce immobilière si vous nous confiez un mandat ;'
			=> 'Publish your property listing if you entrust us with a mandate;',
		'Gérer la relation commerciale et établir les documents contractuels (mandat, compromis, bail) ;'
			=> 'Manage the commercial relationship and produce contractual documents (mandate, preliminary contract, lease);',
		'Respecter nos obligations légales et réglementaires (lutte contre le blanchiment, fiscalité) ;'
			=> 'Comply with our legal and regulatory obligations (anti-money laundering, tax);',
		'Améliorer la qualité de notre site et de nos services.'
			=> 'Improve the quality of our site and our services.',
		'3. Destinataires et partage'  => '3. Recipients and sharing',
		'Vos données ne sont jamais vendues à des tiers. Elles peuvent être communiquées, dans la stricte limite de ce qui est nécessaire, à :'
			=> 'Your data is never sold to third parties. It may be shared, strictly within what is necessary, with:',
		'Nos collaborateurs et agents commerciaux habilités ;'
			=> 'Our authorised employees and sales agents;',
		'Les professionnels intervenant dans la transaction (notaire, avocat, banque, expert) ;'
			=> 'Professionals involved in the transaction (notary, lawyer, bank, expert);',
		"Nos prestataires techniques (hébergeur, service d'envoi d'e-mails) sous accord de confidentialité ;"
			=> 'Our technical providers (host, email-sending service) under confidentiality agreement;',
		"Les autorités compétentes lorsque la loi nous l'impose."
			=> 'The competent authorities when required by law.',
		'4. Durée de conservation'     => '4. Retention period',
		'Nous conservons vos données uniquement le temps nécessaire aux finalités décrites ci-dessus :'
			=> 'We retain your data only for the time necessary for the purposes described above:',
		'Prospects :'                  => 'Prospects:',
		'3 ans à compter du dernier contact ;'
			=> '3 years from the last contact;',
		'Clients (mandat, vente, location) :' => 'Clients (mandate, sale, rental):',
		'10 ans à compter de la fin de la relation contractuelle, pour respecter nos obligations comptables et fiscales ;'
			=> '10 years from the end of the contractual relationship, to comply with our accounting and tax obligations;',
		'Cookies :'                    => 'Cookies:',
		'13 mois maximum.'             => '13 months maximum.',
		'5. Cookies'                   => '5. Cookies',
		'Notre site utilise des cookies pour :' => 'Our site uses cookies to:',
		'Assurer le bon fonctionnement du site (session, panier de favoris, comparateur) ;'
			=> 'Ensure the proper operation of the site (session, favourites basket, comparator);',
		"Mesurer l'audience de manière anonyme (statistiques de visite) ;"
			=> 'Measure audience anonymously (visit statistics);',
		'Améliorer votre expérience de navigation (préférences linguistiques, recherche récente).'
			=> 'Improve your browsing experience (language preferences, recent search).',
		"Vous pouvez à tout moment configurer votre navigateur pour bloquer ou supprimer les cookies. Le refus de certains cookies peut limiter l'accès à certaines fonctionnalités du site."
			=> 'You can configure your browser at any time to block or delete cookies. Refusing certain cookies may limit access to some features of the site.',
		'6. Vos droits'                => '6. Your rights',
		'Conformément à la Loi n°09-08, vous disposez à tout moment des droits suivants sur vos données :'
			=> 'Under Law n°09-08, you have the following rights on your data at any time:',
		"Droit d'accès"                => 'Right of access',
		'obtenir une copie des données que nous détenons sur vous ;'
			=> 'obtain a copy of the data we hold about you;',
		'Droit de rectification'       => 'Right of rectification',
		'corriger une information inexacte ou incomplète ;'
			=> 'correct inaccurate or incomplete information;',
		"Droit d'opposition"           => 'Right to object',
		'vous opposer au traitement de vos données pour des motifs légitimes ;'
			=> 'object to the processing of your data on legitimate grounds;',
		'Droit de suppression'         => 'Right to deletion',
		"demander l'effacement de vos données lorsque la loi le permet."
			=> 'request the erasure of your data when the law permits.',
		"Pour exercer ces droits, contactez-nous à l'adresse %1\$s en joignant une copie d'une pièce d'identité. Vous pouvez également déposer une réclamation auprès de la CNDP (%2\$s)."
			=> 'To exercise these rights, contact us at %1$s with a copy of an ID. You may also lodge a complaint with the CNDP (%2$s).',
		'7. Sécurité'                  => '7. Security',
		"Nous mettons en œuvre les mesures techniques et organisationnelles appropriées pour protéger vos données contre toute perte, accès non autorisé, divulgation ou destruction : connexion HTTPS, contrôle d'accès, sauvegardes régulières et sensibilisation de nos équipes."
			=> 'We implement appropriate technical and organisational measures to protect your data against any loss, unauthorised access, disclosure or destruction: HTTPS, access control, regular backups and awareness of our teams.',
		'8. Contact'                   => '8. Contact',
		'Pour toute question relative à la présente politique ou au traitement de vos données :'
			=> 'For any question about this policy or the processing of your data:',
		'E-mail :'                     => 'Email:',
		'Téléphone :'                  => 'Phone:',
		'Adresse :'                    => 'Address:',
		"L'Agence se réserve le droit de modifier la présente politique. Toute mise à jour sera publiée sur cette page avec la date de dernière révision."
			=> 'The Agency reserves the right to modify this policy. Any update will be published on this page with the date of the last revision.',

		// Terms
		"Les présentes Conditions Générales d'Utilisation (« CGU ») régissent l'accès et l'utilisation du site murailles-immobilier.com édité par l'Agence Murailles Immobilier, ainsi que les services proposés aux visiteurs, acheteurs, vendeurs et locataires. L'utilisation du site implique l'acceptation pleine et entière des présentes CGU."
			=> 'These Terms of Use ("Terms") govern access to and use of the murailles-immobilier.com website published by Agence Murailles Immobilier, as well as the services offered to visitors, buyers, sellers and tenants. Use of the site implies full and unreserved acceptance of these Terms.',
		'1. Mentions légales'          => '1. Legal information',
		'Éditeur :'                    => 'Publisher:',
		'Forme juridique :'            => 'Legal form:',
		'SARL de droit marocain'       => 'LLC under Moroccan law',
		'Siège social :'               => 'Registered office:',
		'Registre du commerce :'       => 'Commercial Register:',
		'RC à compléter'               => 'RC to be completed',
		'Identifiant fiscal :'         => 'Tax ID:',
		'IF à compléter'               => 'Tax ID to be completed',
		"Carte professionnelle d'agent immobilier :"
			=> 'Real-estate agent professional licence:',
		'numéro à compléter'           => 'number to be completed',
		'Hébergement :'                => 'Hosting:',
		'hébergeur à compléter'        => 'host to be completed',
		'2. Objet du site'             => '2. Purpose of the site',
		"Le site présente l'activité de l'Agence et permet aux internautes de :"
			=> "The site introduces the Agency's activity and allows users to:",
		'Consulter les biens immobiliers proposés à la vente ou à la location au Maroc ;'
			=> 'Browse properties offered for sale or rent in Morocco;',
		'Affiner leur recherche par ville, quartier, type de bien et budget ;'
			=> 'Refine their search by city, neighbourhood, property type and budget;',
		'Sauvegarder leurs biens favoris et comparer plusieurs biens ;'
			=> 'Save their favourite properties and compare several properties;',
		'Demander une visite ou des renseignements complémentaires ;'
			=> 'Request a viewing or further information;',
		"Confier un bien à l'Agence en déposant une annonce."
			=> 'Entrust a property to the Agency by submitting a listing.',
		"3. Rôle de l'Agence"          => "3. The Agency's role",
		"L'Agence Murailles intervient en qualité d'intermédiaire immobilier. Elle met en relation des acheteurs / locataires avec des vendeurs / bailleurs et accompagne ses clients dans la sécurisation juridique et fiscale de la transaction. L'Agence n'est pas partie aux contrats de vente ou de location qui sont conclus directement entre les parties, en présence du notaire le cas échéant."
			=> 'Agence Murailles acts as a real-estate intermediary. It connects buyers/tenants with sellers/landlords and supports clients with the legal and tax securing of the transaction. The Agency is not party to the sale or rental contracts, which are concluded directly between the parties, in the presence of a notary where applicable.',
		'4. Annonces et informations publiées'
			=> '4. Listings and published information',
		"L'Agence apporte tous ses soins à la sélection et à la mise à jour des annonces publiées. Les informations (description, surface, prix, photos) sont fournies à titre indicatif et ne constituent pas un engagement contractuel. Les caractéristiques exactes du bien, son état et ses limites font l'objet d'un constat lors de la visite et sont précisés dans le compromis ou le bail."
			=> 'The Agency takes great care selecting and updating published listings. Information (description, area, price, photos) is provided for guidance only and does not constitute a contractual commitment. The exact characteristics of the property, its condition and limits are verified during the viewing and specified in the preliminary contract or lease.',
		"L'Agence se réserve le droit de modifier, suspendre ou retirer toute annonce à tout moment, notamment en cas de vente du bien, de retrait du mandat ou d'information erronée."
			=> 'The Agency reserves the right to modify, suspend or remove any listing at any time, in particular if the property is sold, the mandate is withdrawn, or information is incorrect.',
		"5. Dépôt d'annonce par un propriétaire"
			=> '5. Listing submission by an owner',
		'Tout propriétaire qui dépose une annonce sur le site déclare et garantit :'
			=> 'Any owner who submits a listing on the site declares and warrants that:',
		"Être le propriétaire légitime du bien ou disposer d'un mandat l'autorisant à le commercialiser ;"
			=> 'They are the legitimate owner of the property or hold a mandate authorising them to market it;',
		"Que les informations et photos fournies sont exactes et lui appartiennent ou qu'il dispose des droits nécessaires pour les diffuser ;"
			=> 'The information and photos provided are accurate and belong to them, or they have the necessary rights to publish them;',
		'Que le bien est conforme à la réglementation en vigueur (titre de propriété, urbanisme, fiscalité).'
			=> 'The property complies with current regulations (title deed, planning, tax).',
		"La publication effective de l'annonce reste soumise à la validation de l'Agence et à la signature d'un mandat de vente ou de location."
			=> 'Effective publication of the listing remains subject to the Agency\'s validation and the signing of a sale or rental mandate.',
		"6. Honoraires d'agence"       => '6. Agency fees',
		"Les honoraires de l'Agence sont communiqués au client avant la signature du mandat. Ils ne sont dus qu'en cas de réalisation effective de la transaction (signature de l'acte authentique de vente ou du contrat de bail). Le détail des honoraires est précisé dans le mandat correspondant."
			=> "The Agency's fees are communicated to the client before the mandate is signed. They are only due if the transaction effectively takes place (signing of the deed of sale or the lease agreement). The fee details are specified in the corresponding mandate.",
		'7. Propriété intellectuelle'  => '7. Intellectual property',
		"L'ensemble des éléments du site (textes, photographies, logo, charte graphique, code source) est protégé par le droit de la propriété intellectuelle. Toute reproduction, représentation, modification ou diffusion, totale ou partielle, sans autorisation écrite préalable de l'Agence est interdite et constitue une contrefaçon sanctionnée par la loi."
			=> 'All elements of the site (texts, photographs, logo, graphics, source code) are protected by intellectual property law. Any reproduction, representation, modification or distribution, in whole or in part, without prior written authorisation from the Agency is forbidden and constitutes counterfeiting punishable by law.',
		'8. Responsabilité'            => '8. Liability',
		"L'Agence s'efforce d'assurer la disponibilité du site et l'exactitude des informations publiées. Elle ne saurait toutefois être tenue responsable :"
			=> 'The Agency strives to ensure the availability of the site and the accuracy of published information. It cannot however be held liable for:',
		"D'une indisponibilité temporaire du site liée à une maintenance ou à un cas de force majeure ;"
			=> 'Temporary unavailability of the site due to maintenance or force majeure;',
		"D'erreurs ou d'omissions dans les annonces qui sont fournies par les propriétaires ;"
			=> 'Errors or omissions in the listings provided by the owners;',
		"De l'usage que l'utilisateur fait des informations consultées ;"
			=> 'The use the user makes of the information consulted;',
		"De dommages indirects résultant de l'utilisation du site."
			=> 'Indirect damages resulting from the use of the site.',
		'9. Liens externes'            => '9. External links',
		"Le site peut contenir des liens vers des sites tiers (réseaux sociaux, notaires, partenaires). L'Agence n'exerce aucun contrôle sur ces sites et décline toute responsabilité quant à leur contenu ou aux conséquences de leur utilisation."
			=> "The site may contain links to third-party sites (social networks, notaries, partners). The Agency exercises no control over these sites and disclaims any responsibility for their content or the consequences of their use.",
		'10. Données personnelles'     => '10. Personal data',
		'Le traitement de vos données est régi par notre %s, à laquelle vous êtes invité à vous référer.'
			=> 'The processing of your data is governed by our %s, to which you are invited to refer.',
		'11. Loi applicable et juridiction' => '11. Applicable law and jurisdiction',
		"Les présentes CGU sont régies par le droit marocain. En cas de litige et à défaut d'accord amiable, les tribunaux compétents de Marrakech seront seuls compétents."
			=> 'These Terms are governed by Moroccan law. In the event of a dispute and failing an amicable agreement, the competent courts of Marrakech will have sole jurisdiction.',
		'12. Modifications'            => '12. Amendments',
		"L'Agence se réserve le droit de modifier les présentes CGU à tout moment. La version applicable est celle publiée sur le site à la date de consultation. Il est recommandé aux utilisateurs de relire régulièrement cette page."
			=> 'The Agency reserves the right to modify these Terms at any time. The applicable version is the one published on the site on the date of consultation. Users are advised to re-read this page regularly.',

		// === Histoire de Marrakech ========================================
		'Patrimoine'                   => 'Heritage',
		// 'Histoire de Marrakech' — defined above in header/nav section
		"Mille ans de civilisation, de souks animés et d'architecture berbéro-andalouse au pied de l'Atlas."
			=> 'A thousand years of civilisation, lively souks and Berber-Andalusian architecture at the foot of the Atlas mountains.',
		"Fondée en 1062 par Youssef Ibn Tachfine, Marrakech a tour à tour été capitale des Almoravides, des Almohades et des Saadiens. La ville rouge tient son nom des remparts d'argile qui l'enserrent encore aujourd'hui."
			=> 'Founded in 1062 by Youssef Ibn Tachfine, Marrakech was successively capital of the Almoravids, the Almohads and the Saadians. The red city takes its name from the clay walls that still surround it today.',
		'Chronologie'                  => 'Timeline',
		'Une histoire millénaire'      => 'A thousand-year history',
		'Les grandes dates qui ont façonné la ville rouge.'
			=> 'The key dates that shaped the red city.',
		'Almoravides'                  => 'Almoravids',
		'Fondation par Youssef Ibn Tachfine, première capitale du Maroc.'
			=> 'Founded by Youssef Ibn Tachfine, first capital of Morocco.',
		'Almohades'                    => 'Almohads',
		"Construction de la Koutoubia, chef-d'œuvre de l'architecture islamique."
			=> 'Construction of the Koutoubia, masterpiece of Islamic architecture.',
		'Mérinides'                    => 'Marinids',
		'Période de transition, déplacement de la capitale à Fès.'
			=> 'Transitional period, the capital is moved to Fes.',
		'Saadiens'                     => 'Saadians',
		"Âge d'or : palais El Badi, tombeaux saadiens, médersa Ben Youssef."
			=> 'Golden age: El Badi palace, Saadian tombs, Ben Youssef madrasa.',
		'Alaouites'                    => 'Alaouites',
		'Moulay Ismaïl démantèle El Badi pour construire Meknès.'
			=> 'Moulay Ismaïl dismantles El Badi to build Meknes.',
		'Protectorat'                  => 'Protectorate',
		'Création du quartier Guéliz, urbanisme à la française.'
			=> 'Creation of the Guéliz district, French-style urban planning.',
		'UNESCO'                       => 'UNESCO',
		"La médina inscrite au patrimoine mondial de l'UNESCO."
			=> 'The medina inscribed on the UNESCO World Heritage list.',
		"Aujourd'hui"                  => 'Today',
		"Capitale touristique du Maroc, 1,5 million d'habitants."
			=> 'Tourist capital of Morocco, 1.5 million inhabitants.',
		'Monuments emblématiques'      => 'Emblematic monuments',
		"Les joyaux architecturaux qui racontent l'histoire de la ville."
			=> "The architectural jewels that tell the city's story.",
		'Minaret almohade de 77 m, modèle de la Giralda de Séville.'
			=> 'Almohad minaret of 77 m, model for the Giralda in Seville.',
		'Palais El Badi'               => 'El Badi Palace',
		"Vestiges du palais saadien, surnommé l'Incomparable."
			=> 'Remains of the Saadian palace, nicknamed "the Incomparable".',
		'Médersa Ben Youssef'          => 'Ben Youssef Madrasa',
		'Plus grande école coranique du Maghreb, zelliges et stucs raffinés.'
			=> 'The largest Quranic school in the Maghreb, with refined zellige and stucco.',
		'Tombeaux saadiens'            => 'Saadian Tombs',
		'Nécropole royale aux 66 sépultures, redécouverte en 1917.'
			=> 'Royal necropolis with 66 graves, rediscovered in 1917.',
		'Palais alaouite, 8 ha de cours et jardins andalous.'
			=> 'Alaouite palace, 8 hectares of courtyards and Andalusian gardens.',
		'Remparts'                     => 'Ramparts',
		'19 km de murailles en pisé rouge, percées de 9 portes.'
			=> '19 km of red rammed-earth walls, pierced by 9 gates.',

		// === Tourisme à Marrakech =========================================
		'Découvrir'                    => 'Discover',
		// 'Tourisme à Marrakech' — defined above in header/nav section
		'La ville ocre vous ouvre ses portes : palais millénaires, jardins enchantés, gastronomie raffinée et désert mystique.'
			=> 'The ochre city opens its doors: ancient palaces, enchanted gardens, refined gastronomy and mystical desert.',
		"Climat doux toute l'année"    => 'Mild climate year-round',
		'depuis Paris en vol direct'   => 'from Paris by direct flight',
		'Langues parlées'              => 'Languages spoken',
		'Fuseau horaire (Maroc)'       => 'Time zone (Morocco)',
		'À ne pas manquer'             => 'Not to be missed',
		'Lieux incontournables'        => 'Must-see places',
		'Les sites emblématiques qui font le charme unique de Marrakech.'
			=> 'The emblematic sites that make the unique charm of Marrakech.',
		"Place mythique inscrite à l'UNESCO. Conteurs, charmeurs de serpents, gastronomie de rue à la nuit tombée."
			=> 'Mythical UNESCO-listed square. Storytellers, snake charmers, street food after nightfall.',
		'Patrimoine UNESCO'            => 'UNESCO Heritage',
		'Souks de la Médina'           => 'Medina Souks',
		"Labyrinthe d'artisans : zelliges, cuirs, épices, tapis berbères et lanternes ciselées."
			=> 'Labyrinth of craftsmen: zellige, leather, spices, Berber rugs and chiselled lanterns.',
		'Artisanat'                    => 'Craftsmanship',
		'Jardin Majorelle'             => 'Majorelle Garden',
		"Oasis de bambous et fleurs exotiques aux murs bleu Klein, ancienne demeure d'Yves Saint Laurent."
			=> "Oasis of bamboo and exotic flowers with Klein-blue walls, former home of Yves Saint Laurent.",
		'Jardin & Musée'               => 'Garden & Museum',
		"Bassin centenaire et oliveraie au pied de l'Atlas, cadre romantique au coucher du soleil."
			=> 'Centuries-old pool and olive grove at the foot of the Atlas, romantic setting at sunset.',
		'Jardin historique'            => 'Historic garden',
		"Joyau de l'architecture marocaine du XIXe siècle : 8 ha de patios, riads et plafonds peints."
			=> "Jewel of 19th-century Moroccan architecture: 8 hectares of patios, riads and painted ceilings.",
		'Palais'                       => 'Palace',
		'Ancienne école coranique aux décors de zelliges, stucs et bois de cèdre sculpté.'
			=> 'Former Quranic school with zellige, stucco and carved cedar-wood decor.',
		'Monument'                     => 'Monument',
		"Vallée de l'Ourika"           => 'Ourika Valley',
		'Excursion à 1h : cascades, villages berbères, marché du lundi à Tnine, randonnées en montagne.'
			=> '1-hour excursion: waterfalls, Berber villages, Monday market in Tnine, mountain hikes.',
		'Excursion'                    => 'Excursion',
		"Désert d'Agafay"              => 'Agafay Desert',
		'Désert de pierres à 30 min de la ville. Bivouacs sous les étoiles, balades en chameau et 4x4.'
			=> '30-minute stone desert from the city. Bivouacs under the stars, camel rides and 4x4 trips.',
		'Aventure'                     => 'Adventure',
		'Cité atlantique à 2h30 de route : ramparts portugais, port de pêche, surf et alizés.'
			=> 'Atlantic city 2.5 hours away: Portuguese ramparts, fishing port, surf and trade winds.',
		'Côte atlantique'              => 'Atlantic coast',
		'Pratique'                     => 'Practical',
		'Quand visiter Marrakech ?'    => 'When to visit Marrakech?',
		'Le climat de la ville ocre suit le rythme des saisons marocaines.'
			=> 'The ochre city\'s climate follows the rhythm of the Moroccan seasons.',
		'Printemps'                    => 'Spring',
		'Mars-Mai'                     => 'March-May',
		'Saison idéale : journées chaudes, soirées fraîches, jardins en fleurs.'
			=> 'Ideal season: warm days, cool evenings, gardens in bloom.',
		'Été'                          => 'Summer',
		'Juin-Août'                    => 'June-August',
		'Très chaud en journée. Préférer les riads avec piscine et siestes en patio.'
			=> 'Very hot during the day. Prefer riads with a pool and patio naps.',
		'Automne'                      => 'Autumn',
		'Sept-Nov'                     => 'Sept-Nov',
		'Lumière dorée magnifique, températures douces. Excellent pour les randonnées.'
			=> 'Beautiful golden light, mild temperatures. Excellent for hiking.',
		'Hiver'                        => 'Winter',
		'Déc-Février'                  => 'Dec-February',
		"Doux en journée, frais le soir. L'Atlas sous la neige se visite à 1h30."
			=> 'Mild during the day, cool in the evening. The snow-covered Atlas is 1h30 away.',
		'Gastronomie'                  => 'Gastronomy',
		'Une cuisine de tradition'     => 'A traditional cuisine',
		"La cuisine marocaine, classée par l'UNESCO, est un voyage à elle seule. Tajines mijotés, couscous du vendredi, pâtisseries au miel et thé à la menthe : chaque plat raconte l'art de vivre marocain."
			=> "Moroccan cuisine, UNESCO-listed, is a journey in itself. Slow-cooked tajines, Friday couscous, honey pastries and mint tea: each dish tells the Moroccan art of living.",
		'Tajine'                       => 'Tagine',
		'Agneau aux pruneaux, poulet citron-olives, kefta aux œufs.'
			=> 'Lamb with prunes, chicken with preserved lemon and olives, kefta with eggs.',
		'Couscous'                     => 'Couscous',
		'Le grain roi du vendredi, accompagné de 7 légumes et viande.'
			=> 'The king grain of Friday, served with 7 vegetables and meat.',
		'Pastilla'                     => 'Pastilla',
		'Feuilletée sucrée-salée au pigeon ou au poisson.'
			=> 'Sweet-savoury puff pastry with pigeon or fish.',
		'Thé menthe'                   => 'Mint tea',
		"Versé de haut, symbole de l'hospitalité marocaine."
			=> 'Poured from above, symbol of Moroccan hospitality.',

		// === Assistance & Conseils ========================================
		'Notre expertise'              => 'Our expertise',
		'Assistance & Conseils'        => 'Assistance & Advice',
		'Un accompagnement personnalisé à chaque étape de votre projet immobilier au Maroc.'
			=> 'Personalised support at every step of your real-estate project in Morocco.',
		'Biens vendus'                 => 'Properties sold',
		'Clients satisfaits'           => 'Satisfied clients',
		'Disponibilité'                => 'Availability',
		'Services'                     => 'Services',
		'Notre accompagnement'         => 'Our support',
		"Murailles Immobilier vous accompagne de A à Z dans votre projet, depuis la première visite jusqu'à la remise des clés."
			=> 'Murailles Immobilier supports you from A to Z in your project, from the first viewing to handing over the keys.',
		'Recherche personnalisée'      => 'Personalised search',
		'Nous identifions les biens correspondant exactement à vos critères : ville, quartier, surface, budget et style architectural.'
			=> 'We identify properties matching exactly your criteria: city, neighbourhood, area, budget and architectural style.',
		'Négociation au juste prix'    => 'Negotiation at a fair price',
		"Forte de 15 ans d'expérience locale, notre équipe négocie chaque transaction pour obtenir les meilleures conditions."
			=> 'With 15 years of local experience, our team negotiates every transaction to obtain the best conditions.',
		'Démarches juridiques'         => 'Legal procedures',
		'Compromis de vente, clauses suspensives, acte authentique : nous coordonnons notaire, avocat et expert pour une transaction sécurisée.'
			=> 'Preliminary contract, conditional clauses, deed: we coordinate notary, lawyer and expert for a secure transaction.',
		'Financement bancaire'         => 'Bank financing',
		'Réseau de partenaires bancaires marocains pour obtenir un crédit immobilier adapté à votre profil (résident et non-résident).'
			=> 'Network of Moroccan bank partners to obtain a mortgage tailored to your profile (resident and non-resident).',
		'Remise des clés'              => 'Key handover',
		'Coordination avec syndic, copropriété, services publics. Vous récupérez un bien prêt à vivre ou à louer.'
			=> 'Coordination with the building manager, co-ownership and public services. You receive a property ready to live in or to rent out.',
		'Travaux & rénovation'         => 'Works & renovation',
		"Architectes, maîtres d'œuvre, artisans : nous orchestrons les chantiers de rénovation, traditionnels et contemporains."
			=> 'Architects, project managers, craftsmen: we orchestrate renovation work, both traditional and contemporary.',
		'Gestion locative'             => 'Rental management',
		'Mise en location, sélection des locataires, encaissement des loyers, état des lieux : votre patrimoine rentabilisé sans tracas.'
			=> 'Letting, tenant selection, rent collection, inventory: your assets made profitable hassle-free.',
		'Conseil patrimonial'          => 'Wealth advice',
		'Optimisation fiscale, succession, démembrement : nos partenaires experts-comptables vous guident sur la durée.'
			=> 'Tax optimisation, inheritance, dismemberment: our chartered-accountant partners guide you over the long term.',
		'Processus'                    => 'Process',
		'Comment nous procédons'       => 'How we work',
		'Une méthode éprouvée en 4 étapes pour sécuriser votre acquisition.'
			=> 'A proven 4-step method to secure your acquisition.',
		'Premier contact'              => 'First contact',
		'Échange téléphonique ou en agence pour cerner votre projet, votre budget et vos critères.'
			=> 'Phone or in-agency exchange to understand your project, budget and criteria.',
		'Visites ciblées'              => 'Targeted viewings',
		'Sélection de 3 à 5 biens correspondant à vos attentes, accompagnement sur chaque visite.'
			=> 'Selection of 3 to 5 properties matching your expectations, support for each viewing.',
		'Offre & négociation'          => 'Offer & negotiation',
		"Rédaction de l'offre d'achat, négociation du prix et des conditions avec le vendeur."
			=> 'Drafting the purchase offer, negotiating price and conditions with the seller.',
		'Signature & remise'           => 'Signing & handover',
		"Coordination avec le notaire, signature de l'acte définitif, remise des clés."
			=> 'Coordination with the notary, signing the final deed, handing over the keys.',
		'Notre réseau'                 => 'Our network',
		'Des partenaires de confiance' => 'Trusted partners',
		"Banques, notaires, architectes, bureaux d'études, experts-comptables, entrepreneurs, artisans : notre réseau de partenaires marocains met son savoir-faire à votre service pour chaque étape de votre projet immobilier."
			=> 'Banks, notaries, architects, design offices, chartered accountants, contractors, craftsmen: our network of Moroccan partners puts its expertise at your service for every step of your real-estate project.',
		'Parlons de votre projet'      => "Let's talk about your project",

		// === Comments + Sidebar ===========================================
		'%s Commentaire'               => '%s Comment',
		'%s Commentaires'              => '%s Comments',
		'Laisser un commentaire'       => 'Leave a comment',
		'Envoyer le commentaire'       => 'Submit comment',
		'Recherche'                    => 'Search',
		'Rechercher...'                => 'Search...',
		'Catégories'                   => 'Categories',
		'Articles récents'             => 'Recent posts',
		'Étiquettes'                   => 'Tags',

	);
}

/**
 * Register every string with Polylang and seed its EN translation.
 *
 * Runs once on init — Polylang's string-translation API stores everything
 * in options, so the second call is a no-op.
 */
add_action( 'init', function () {
	if ( ! function_exists( 'pll_register_string' ) ) {
		return; // Polylang not active — murailles_t() falls back to raw FR.
	}

	$dict = murailles_i18n_dictionary();
	foreach ( $dict as $source => $target ) {
		pll_register_string( $source, $source, 'Murailles Immobilier', true );
	}

	// Seed EN translations directly into Polylang's PLL_MO store, but only
	// if the admin hasn't already provided their own value (we never overwrite).
	if ( ! class_exists( 'PLL_MO' ) || ! function_exists( 'PLL' ) ) {
		return;
	}

	$en_obj = null;
	foreach ( PLL()->model->get_languages_list() as $lang_obj ) {
		if ( isset( $lang_obj->slug ) && $lang_obj->slug === 'en' ) {
			$en_obj = $lang_obj;
			break;
		}
	}
	if ( ! $en_obj ) {
		return; // English not configured yet in Languages → Languages.
	}

	$mo = new PLL_MO();
	$mo->import_from_db( $en_obj );

	$changed = false;
	foreach ( $dict as $source => $target ) {
		// Skip if an admin has already translated this string (never overwrite).
		$existing = $mo->translate( $source );
		if ( $existing && $existing !== $source ) {
			continue;
		}
		$mo->add_entry( $mo->make_entry( $source, $target ) );
		$changed = true;
	}

	if ( $changed ) {
		$mo->export_to_db( $en_obj );
	}
}, 20 );
