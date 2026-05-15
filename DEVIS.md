# DEVIS — Développement Site Web Immobilier

**Projet :** Murailles Immobilier — Plateforme immobilière sur WordPress
**Thème personnalisé :** `CodeSommet-theme` (développement sur mesure)
**Date du devis :** 14 mai 2026
**Validité :** 30 jours à compter de la date d'émission
**Régime :** Auto-entrepreneur — _TVA non applicable, art. 293 B équivalent (régime CPU Maroc)_

---

## 1. Prestataire

- **Nom :** [À compléter]
- **Email :** elyounani.business@gmail.com
- **ICE / RC / IF :** [À compléter]

## 2. Client

- **Raison sociale :** [À compléter]
- **Adresse :** [À compléter]
- **Contact :** [À compléter]

---

## 3. Contexte et objet de la prestation

Conception, développement et mise en production d'un site web immobilier complet sous WordPress, comprenant un **thème entièrement développé sur mesure** (`CodeSommet-theme`), un système de gestion d'annonces immobilières, un espace agent/agence, ainsi qu'un module de soumission d'annonces côté front-office.

Le design est inspiré de la maquette HTML statique _CodeSommet_ et adapté à l'identité **Murailles Immobilier**.

---

## 4. Détail des prestations réalisées

### 4.1 — Conception & architecture technique

| Réf.  | Désignation                                                                                | Jours | PU (MAD) | Total (MAD) |
| ----- | ------------------------------------------------------------------------------------------ | ----: | -------: | ----------: |
| 4.1.1 | Analyse fonctionnelle, arborescence du site, conception base de données (CPT + taxonomies) |     2 |    4 500 |       9 000 |
| 4.1.2 | Configuration WordPress, environnement local XAMPP, structure du thème                     |     1 |    4 500 |       4 500 |

### 4.2 — Développement du thème sur mesure `CodeSommet-theme`

Thème entièrement codé en PHP/HTML/CSS/JS, sans page builder.

| Réf.  | Désignation                                                                                                         | Jours | PU (MAD) | Total (MAD) |
| ----- | ------------------------------------------------------------------------------------------------------------------- | ----: | -------: | ----------: |
| 4.2.1 | Intégration HTML → PHP du gabarit CodeSommet (header, footer, sidebar, 404, search)                                 |     3 |    4 500 |      13 500 |
| 4.2.2 | Système de templates : `front-page.php`, `archive.php`, `single.php`, `page.php`                                    |     2 |    4 500 |       9 000 |
| 4.2.3 | Assets : intégration CSS/JS/fonts/images, optimisation des `enqueue`                                                |     1 |    4 500 |       4 500 |
| 4.2.4 | Internationalisation (i18n) et préparation Polylang (FR/EN/AR)                                                      |     1 |    4 500 |       4 500 |
| 4.2.5 | Composants réutilisables (`template-parts/`) : blog-card, login-modal, message-modal, CTA, page-title, nav-fallback |   1,5 |    4 500 |       6 750 |

### 4.3 — Module Annonces immobilières (Custom Post Types)

| Réf.  | Désignation                                                                               | Jours | PU (MAD) | Total (MAD) |
| ----- | ----------------------------------------------------------------------------------------- | ----: | -------: | ----------: |
| 4.3.1 | CPT `property` avec champs personnalisés (prix, surface, chambres, SDB, géoloc, galerie…) |     2 |    4 500 |       9 000 |
| 4.3.2 | Taxonomies : `property_category`, `property_location`, `property_area`                    |     1 |    4 500 |       4 500 |
| 4.3.3 | CPT `agent` (fiches agents/agences)                                                       |     1 |    4 500 |       4 500 |
| 4.3.4 | Gabarits dédiés : `archive-property.php`, `single-property.php` (4 variantes de single)   |     2 |    4 500 |       9 000 |

### 4.4 — Pages & gabarits fonctionnels (page-templates)

Plus de **45 gabarits de pages** développés.

| Réf.  | Désignation                                                                                                                                                                  | Jours | PU (MAD) | Total (MAD) |
| ----- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ----: | -------: | ----------: |
| 4.4.1 | 7 variantes Home (home-2 à home-7 + front-page)                                                                                                                              |     3 |    4 500 |      13 500 |
| 4.4.2 | Listings : grid-layout (×3), list-layout (×3), half-map (×2), classical-layout-with-map, layouts with sidebar                                                                |     3 |    4 500 |      13 500 |
| 4.4.3 | Pages utilisateurs : `dashboard`, `my-profile`, `my-property`, `messages`, `favoris`, `bookmark-list`                                                                        |   2,5 |    4 500 |      11 250 |
| 4.4.4 | Pages annonces : `submit-property` (formulaire "Déposer une annonce"), `compare-property`, `checkout`, `pricing`                                                             |   2,5 |    4 500 |      11 250 |
| 4.4.5 | Pages agents/agences : `agents`, `agents-2`, `agencies`, `agent-page`, `agency-page`                                                                                         |   1,5 |    4 500 |       6 750 |
| 4.4.6 | Pages éditoriales : `about-us`, `contact`, `faq`, `blog`, `assistance-conseils`, `histoire-marrakech`, `tourisme-marrakech`, `privacy`, `terms`, `error`, `component`, `map` |     2 |    4 500 |       9 000 |

### 4.5 — Formulaires AJAX & emails transactionnels

| Réf.  | Désignation                                                                                        | Jours | PU (MAD) | Total (MAD) |
| ----- | -------------------------------------------------------------------------------------------------- | ----: | -------: | ----------: |
| 4.5.1 | Endpoints AJAX sécurisés (nonce + capability check) : contact, avis, newsletter, dépôt d'annonce   |     2 |    4 500 |       9 000 |
| 4.5.2 | Configuration SMTP Gmail via `wp_mail` + logs `wp_mail_failed` / `wp_mail_succeeded`               |   0,5 |    4 500 |       2 250 |
| 4.5.3 | Templates emails HTML transactionnels (confirmation contact, accusé d'annonce, notification admin) |     1 |    4 500 |       4 500 |

### 4.6 — Interactivité front-end

| Réf.  | Désignation                                                         | Jours | PU (MAD) | Total (MAD) |
| ----- | ------------------------------------------------------------------- | ----: | -------: | ----------: |
| 4.6.1 | Modales de connexion/inscription, modale de messagerie              |     1 |    4 500 |       4 500 |
| 4.6.2 | Filtres de recherche annonces, tri, comparateur, favoris (bookmark) |     2 |    4 500 |       9 000 |
| 4.6.3 | Intégration carte (vues half-map / with-map)                        |     1 |    4 500 |       4 500 |

### 4.7 — Administration & back-office

| Réf.  | Désignation                                                        | Jours | PU (MAD) | Total (MAD) |
| ----- | ------------------------------------------------------------------ | ----: | -------: | ----------: |
| 4.7.1 | Assets admin personnalisés (`admin-assets.css`, `admin-assets.js`) |   0,5 |    4 500 |       2 250 |
| 4.7.2 | Meta-boxes propriétés et agents                                    |     1 |    4 500 |       4 500 |

### 4.8 — Tests, recette & mise en production

| Réf.  | Désignation                                                          | Jours | PU (MAD) | Total (MAD) |
| ----- | -------------------------------------------------------------------- | ----: | -------: | ----------: |
| 4.8.1 | Tests cross-browser, responsive mobile/tablette                      |     1 |    4 500 |       4 500 |
| 4.8.2 | Migration vers hébergement de production, configuration domaine, SSL |     1 |    4 500 |       4 500 |
| 4.8.3 | Documentation utilisateur (rédaction d'annonces, gestion agents)     |   0,5 |    4 500 |       2 250 |

---

## 5. Récapitulatif financier

| Poste                            |      Jours |   Montant (MAD) |
| -------------------------------- | ---------: | --------------: |
| 4.1 — Conception & architecture  |          3 |          13 500 |
| 4.2 — Thème sur mesure           |        8,5 |          38 250 |
| 4.3 — Module Annonces (CPT)      |          6 |          27 000 |
| 4.4 — Pages & gabarits (45+)     |       14,5 |          65 250 |
| 4.5 — Formulaires AJAX & emails  |        3,5 |          15 750 |
| 4.6 — Interactivité front        |          4 |          18 000 |
| 4.7 — Back-office                |        1,5 |           6 750 |
| 4.8 — Tests & mise en production |        2,5 |          11 250 |
| **TOTAL NET À PAYER**            | **43,5 j** | **195 750 MAD** |

> **TVA non applicable** — auto-entrepreneur, art. 323 du CGI Maroc (régime CPU).

---

## 6. Modalités de paiement

- **Acompte à la commande :** 30 % — 58 725 MAD
- **Acompte à mi-projet :** 40 % — 78 300 MAD
- **Solde à la livraison :** 30 % — 58 725 MAD
- **Moyens acceptés :** virement bancaire, chèque
- **Délai de paiement :** 15 jours à compter de la date de facture

## 7. Délais

- Démarrage : à réception de l'acompte
- Durée estimée : **9 à 11 semaines** ouvrées
- Livraison finale : selon planning convenu en kick-off

## 8. Garanties & maintenance

- **Garantie de bon fonctionnement :** 30 jours après livraison (correction des bugs constatés sans surcoût).
- **Maintenance évolutive :** non incluse — proposée sur devis séparé (forfait mensuel ou à la demande).
- **Hébergement, nom de domaine, licences plugins tiers :** à la charge du client.

## 9. Propriété intellectuelle

Le code source du thème `CodeSommet-theme` est cédé au client à l'issue du paiement intégral. Les bibliothèques open-source utilisées restent sous leurs licences respectives (WordPress GPL, etc.).

---

**Bon pour accord — Le client**

Nom : **********\_\_\_\_********** Date : \_**\_ / \_\_** / **\_\_**

Signature et cachet :

---

_Devis établi le 14 mai 2026 — Murailles Immobilier_
