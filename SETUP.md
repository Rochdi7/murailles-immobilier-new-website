# Murailles Immobilier — Guide de mise en route WordPress

Procédure complète pour configurer un site WordPress prêt à l'emploi avec le thème **rentup-theme** (Murailles Immobilier).

Suivez les étapes **dans l'ordre**. Chaque étape est rapide (1 à 3 minutes) sauf l'installation de Polylang qui est optionnelle.

---

## 1. Prérequis

- WordPress **6.0+** installé et accessible (XAMPP en local ou hébergement de prod).
- PHP **8.0+** avec extensions `gd`, `mbstring`, `curl`, `mysqli` actives.
- MySQL/MariaDB.
- Accès **Administrateur** au back-office WordPress.

---

## 2. Activer le thème

1. WP Admin → **Apparence → Thèmes**.
2. Survolez la vignette **Murailles Immobilier** → cliquez **Activer**.
3. Au premier chargement d'une page admin, le thème exécute automatiquement les créateurs de pages (`/favoris/`, `/conditions-generales/`, `/privacy/`, `/erreur/`, etc.) et la population des taxonomies.

---

## 3. Configurer les permalinks (CRITIQUE)

1. WP Admin → **Réglages → Permaliens**.
2. Sélectionnez **« Nom de l'article »** (Post name).
3. Cliquez **Enregistrer les modifications**.

> ⚠️ Ne PAS choisir « Simple » (Plain) — toutes les URL propres du thème (`/bien/`, `/categorie-bien/villa/`, `/localisation/marrakech/`, paginations, `/conditions-generales/`, etc.) cessent de fonctionner.

Si une URL `/bien/page/2/` renvoie un 404, revenez ici et ré-enregistrez les permaliens pour forcer un flush des règles de réécriture.

---

## 4. Réglages généraux

WP Admin → **Réglages → Général** :

| Champ | Valeur |
|-------|--------|
| Titre du site | `Murailles Immobilier` |
| Slogan | `De loin, l'agence la plus proche de vous` |
| Adresse e-mail d'administration | `contact@murailles-immobilier.com` |
| Langue du site | `Français` |
| Fuseau horaire | `Casablanca` (UTC+1) |
| Format de date | `j F Y` |
| Format d'heure | `H:i` |

Cliquez **Enregistrer**.

---

## 5. Configurer le SMTP (envoi d'e-mails)

Le thème lit des constantes définies dans `wp-config.php`. Ouvrez le fichier et ajoutez/modifiez **avant** la ligne `/* That's all, stop editing! */` :

```php
define( 'MURAILLES_SMTP_HOST',      'smtp.gmail.com' );
define( 'MURAILLES_SMTP_PORT',      587 );
define( 'MURAILLES_SMTP_SECURE',    'tls' );
define( 'MURAILLES_SMTP_USER',      'votre-adresse@gmail.com' );
define( 'MURAILLES_SMTP_PASS',      'xxxx xxxx xxxx xxxx' ); // Mot de passe d'application Gmail
define( 'MURAILLES_SMTP_FROM',      'votre-adresse@gmail.com' );
define( 'MURAILLES_SMTP_FROM_NAME', 'Agence Murailles' );
define( 'MURAILLES_LEAD_NOTIFY',    'contact@murailles-immobilier.com' );
define( 'MURAILLES_WHATSAPP_NUMBER','212661425150' );
```

### Comment obtenir un mot de passe d'application Gmail

1. Activez la **double authentification** sur votre compte Google.
2. Allez sur https://myaccount.google.com/apppasswords
3. Créez une nouvelle application « WordPress », copiez les 16 caractères.
4. Collez-les dans `MURAILLES_SMTP_PASS` (avec ou sans espaces).

### Tester

Envoyez un message via la page **/contact/**. Vous devez recevoir l'e-mail de notification sur `MURAILLES_LEAD_NOTIFY` sous quelques secondes.

---

## 6. Vérifier les pages auto-créées

Le thème crée automatiquement ces pages au premier chargement admin :

| Slug | Template | Présence |
|------|----------|----------|
| `/` | front-page.php | Page d'accueil |
| `/bien/` | archive-property.php | Archive des biens (auto via CPT) |
| `/about-us/` | page-templates/about-us.php | À propos |
| `/contact/` | page-templates/contact.php | Contact |
| `/blog/` | (pas de template) | Page Blog |
| `/faq/` | page-templates/faq.php | Foire aux questions |
| `/submit-property/` | page-templates/submit-property.php | Déposer une annonce |
| `/favoris/` | page-templates/favoris.php | Mes favoris |
| `/compare-property/` | page-templates/compare-property.php | Comparateur |
| `/privacy/` | page-templates/privacy.php | Politique de confidentialité |
| `/conditions-generales/` | page-templates/terms.php | CGU |
| `/assistance-conseils/` | page-templates/assistance-conseils.php | Assistance |
| `/histoire-marrakech/` | page-templates/histoire-marrakech.php | Histoire |
| `/tourisme-marrakech/` | page-templates/tourisme-marrakech.php | Tourisme |
| `/erreur/` | page-templates/error.php | Page d'erreur générique |

WP Admin → **Pages → Toutes les pages** : vérifiez qu'elles existent toutes. Si une manque, créez-la manuellement et assignez le template via la sidebar droite.

---

## 7. Définir la page d'accueil

1. WP Admin → **Réglages → Lecture**.
2. **Votre page d'accueil affiche** : sélectionnez **« Une page statique »**.
3. **Page d'accueil** : `Home` (ou la page de slug `/`).
4. **Page des articles** : `Blog`.
5. Enregistrez.

---

## 8. Configurer le menu principal

1. WP Admin → **Apparence → Menus**.
2. Créez un nouveau menu nommé `Primary`.
3. Cochez **Primary Menu** comme emplacement.
4. Sinon, laissez vide — le thème utilisera le menu de secours `template-parts/nav-fallback.php` qui contient déjà la structure correcte (Accueil, Vente, Location, Informations, Blog, Contact).

---

## 9. Coordonnées de l'agence

Ouvrez `wp-content/themes/rentup-theme/inc/contact-helpers.php` et vérifiez que `murailles_contact_info()` renvoie les bonnes valeurs :

```php
return array(
    'address_line1' => '13 Rue Mouslim, Résidence Boukar',
    'address_line2' => '2ème étage Bureau N°10',
    'address_city'  => 'Marrakech 40000, Maroc',
    'contact_name'  => 'Youssef',
    'phone_display' => '+212 6 61 42 51 50',
    'phone_tel'     => '+212661425150',
    'email'         => 'contact@murailles-immobilier.com',
    'facebook'      => 'https://www.facebook.com/profile.php?id=100063563441285',
    'instagram'     => '#',
    'twitter'       => '#',
);
```

Pour remplacer les `#` Instagram / Twitter, modifiez les URL ici. Cette fonction alimente le footer + la page Contact + les e-mails transactionnels.

---

## 10. Peupler les taxonomies (auto)

Au premier chargement, le thème insère automatiquement :

- **Catégories de biens** : RIAD A RENOVER, APPARTEMENT, BUREAUX, COMMERCE, FERME, MAISON D'HOTE, HOTEL, PALAIS, RIAD HABITATION, RIAD RENOVE, TERRAIN, VILLA.
- **Localisations** : Maroc (Marrakech, Casablanca, Rabat, Fès, Tanger, Agadir, Essaouira, Meknès, Ouarzazate, Tétouan, Oujda, Kénitra, El Jadida, Safi, Nador) + France, Espagne, Émirats Arabes Unis.
- **Quartiers de Marrakech** : AGDAL, AMELKIS, GUELIZ, HIVERNAGE, KASBAH, MAJORELLE, MEDINA, PALMERAIE, etc.

Vérifiez via **Biens → Catégories / Pays-Ville / Quartiers**.

---

## 11. Ajouter le premier bien

1. WP Admin → **Biens → Ajouter**.
2. Titre, description longue, image à la une.
3. Dans la meta-box **Paramètres du bien** (onglets) :
   - **Détails** : prix, action (Vente/Location), surface, chambres, SDB.
   - **Médias** : galerie photo.
   - **Carte** : code embed Google Maps.
   - **Équipements** : cochez les options.
4. Catégorie + Pays-Ville + Quartier dans la sidebar.
5. **Publier**.

Le bien apparaît immédiatement sur `/bien/` et la fiche détaillée sur `/bien/votre-slug/`.

---

## 12. Workflow des soumissions visiteurs

Quand un visiteur remplit **/submit-property/** :

1. Un post `property` est créé en **brouillon** (jamais publié automatiquement).
2. Vous recevez un e-mail sur `MURAILLES_LEAD_NOTIFY` avec un lien direct vers l'éditeur.
3. Dans **WP Admin → Biens**, un **badge rouge** indique le nombre de brouillons en attente.
4. La colonne **« Soumis par »** affiche le nom + e-mail + téléphone cliquables.
5. Vérifiez les infos, ajustez les photos/description, puis **Publier** quand vous validez.

---

## 13. Multilangue (optionnel — FR/EN)

Le thème supporte deux modes :

### Option A — Sans plugin (déjà actif)

Le sélecteur drapeau FR/EN dans l'en-tête bascule la langue via `?lang=en` et un cookie d'un an. Les chaînes UI traduites sont définies dans `inc/i18n-strings.php`. **Aucune configuration requise.**

### Option B — Avec Polylang (recommandé pour le SEO)

1. **Extensions → Ajouter** → recherchez **Polylang** → installez + activez.
2. **Languages → Languages** :
   - Ajoutez **Français** (fr-FR) — coché par défaut.
   - Ajoutez **English** (en-US).
3. **Languages → Settings → URL modifications** :
   - Cochez **« The language is set from the directory name in pretty permalinks »**.
   - Cochez **« Hide URL language information for default language »** (optionnel).
4. Les URL deviennent `/bien/...` (FR) et `/en/bien/...` (EN).
5. Pour traduire un bien : éditez-le → colonne droite → cliquez **+** à côté du drapeau EN.

Le thème gère automatiquement :
- Filtrage des biens par langue dans `archive-property.php`.
- Enregistrement des chaînes statiques via `pll_register_string()` (visibles dans **Languages → Strings translations**).
- Switcher FR/EN dans l'en-tête avec drapeaux corrects.

---

## 14. Optimisations recommandées

### Extensions à installer

| Extension | Utilité |
|-----------|---------|
| **Polylang** | Multilangue (cf. §13) |
| **Wordfence Security** | Pare-feu + scan malware |
| **WP Super Cache** ou **LiteSpeed Cache** | Cache HTML statique |
| **Smush** ou **ShortPixel** | Compression images automatique |
| **Yoast SEO** ou **Rank Math** | Méta-tags, sitemap, schema |
| **WP Mail Logging** | Tracer les e-mails envoyés (utile en cas de souci SMTP) |

### Réglages WordPress

WP Admin → **Réglages → Commentaires** :
- Décochez **Permettre les pings** (inutile en immobilier).
- Cochez **L'auteur du commentaire doit renseigner son nom et son e-mail**.

WP Admin → **Réglages → Médias** :
- Taille des miniatures : `300x200`
- Taille moyenne : `768x512`
- Grande taille : `1200x800`

---

## 15. Mise en production

### Avant le déploiement

- [ ] Désactivez `WP_DEBUG` dans `wp-config.php` (mettre à `false`).
- [ ] Vérifiez que `MURAILLES_SMTP_*` pointent vers l'adresse pro et non Gmail dev.
- [ ] Changez les **clés de sécurité** dans `wp-config.php` via https://api.wordpress.org/secret-key/1.1/salt/
- [ ] Vérifiez `MURAILLES_WHATSAPP_NUMBER` (sans `+`, sans espaces : `212661425150`).
- [ ] Régénérez les permaliens (§3) après la migration.

### Sauvegarde

Avant tout : sauvegardez la base de données + le dossier `wp-content/`.

```bash
# Export DB
mysqldump -u root wordpress_rentup > backup-$(date +%Y-%m-%d).sql

# Export uploads
zip -r uploads-$(date +%Y-%m-%d).zip wp-content/uploads
```

### Migration vers la prod

1. Uploadez `wp-content/themes/rentup-theme/` sur l'hébergement.
2. Importez la base via phpMyAdmin / Adminer.
3. Remplacez `localhost/wordpress` par `https://murailles-immobilier.com` :
   ```sql
   UPDATE wp_options SET option_value='https://murailles-immobilier.com' WHERE option_name IN ('siteurl','home');
   ```
   Ou utilisez **Better Search Replace** (plugin) pour éviter de casser les données sérialisées.
4. Vider le cache navigateur + ré-enregistrer les permaliens.

---

## 16. Dépannage rapide

| Symptôme | Cause probable | Fix |
|----------|----------------|-----|
| `/bien/page/2/` → 404 | Règles de réécriture pas flushées | §3 (ré-enregistrer les permaliens) |
| « Requête invalide » au formulaire | Autofill remplit le honeypot | Déjà patché en v1.0 (champ `_mw_hp_url`) |
| Aucun e-mail reçu | SMTP mal configuré | §5 — vérifier mot de passe d'application Gmail |
| Page blanche | `WP_DEBUG = false` masque l'erreur | Activez temporairement, vérifiez `wp-content/debug.log` |
| Catégories vides sur `/bien/?ptype=...` | Slugs mal mappés | Vérifiez **Biens → Catégories** — le slug doit correspondre |
| Footer affiche « rentup » | Site Title pas changé | §4 |
| Soumissions perdues | Brouillons masqués dans WP Admin | Filtrez par **Brouillon** dans Biens |

---

## 17. Maintenance courante

### Hebdomadaire

- Vérifier les nouvelles soumissions de biens (Biens → badge rouge).
- Répondre aux messages de contact (boîte `contact@murailles-immobilier.com`).
- Vérifier que le site répond (page d'accueil + une fiche bien).

### Mensuelle

- Mettre à jour WordPress core + extensions.
- Sauvegarder la base + uploads (cf. §15).
- Vérifier les commentaires en attente de modération.

### Trimestrielle

- Auditer les performances avec PageSpeed Insights.
- Renouveler le mot de passe d'application Gmail si besoin.
- Vérifier les certificats SSL.

---

## 18. Support

- **Théme développé par :** [CodeSommet](https://codesommet.com/)
- **Contact :** elyounani.business@gmail.com
- **Documentation technique :** voir `inc/` (forms.php, custom-post-types.php, i18n.php) — chaque fichier est commenté.

---

*Document généré le 15 mai 2026 — version 1.0*
