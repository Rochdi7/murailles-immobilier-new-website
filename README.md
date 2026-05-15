<div align="center">

# 🏛️ Murailles Immobilier

### *De loin, l'agence la plus proche de vous*

A bespoke WordPress real-estate platform crafted for **Agence Murailles Immobilier** — Marrakech, Maroc.

[![WordPress](https://img.shields.io/badge/WordPress-6.0+-21759B?style=for-the-badge&logo=wordpress&logoColor=white)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-MariaDB-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/License-GPL%20v2-blue?style=for-the-badge)](LICENSE)

[**Demo**](#) · [**Setup Guide**](SETUP.md) · [**Report a bug**](mailto:elyounani.business@gmail.com)

</div>

---

## ✨ Overview

**Murailles Immobilier** is a fully custom WordPress theme — built from a static HTML design into a production real-estate platform tailored for the Moroccan market. Property listings, advanced search, favorites, side-by-side comparison, visitor submissions, transactional email — all glued together with a clean French-first UX and optional EN translation.

> 🏠 Sales & rental listings · 🌍 Bilingual FR/EN · 💌 SMTP-powered leads · 🔍 Multi-criteria search · ⭐ Favorites & comparator

---

## 🎯 Features

### Front-end

- 🏘️ **Custom Property CPT** — typology, location, neighborhood, price, surface, rooms, amenities, photo gallery, map embed
- 🔎 **Advanced search** — filter by category, city, neighborhood, price range, action (sale / rent)
- ⭐ **Favorites** — guest-friendly favorites system (cookies + user meta)
- ⚖️ **Side-by-side comparator** — up to 4 properties, full spec sheet diff
- 📝 **Visitor submissions** — `/submit-property/` form creates drafts pending admin review
- 📞 **Click-to-call & WhatsApp** — single source of truth via `murailles_contact_info()`
- 🌐 **Bilingual FR/EN** — works out-of-the-box (cookie + querystring) or with **Polylang** for SEO-friendly URLs

### Back-end

- 🚨 **Submission badge** — red counter in WP Admin showing drafts awaiting review
- 📧 **SMTP transactional emails** — credentials defined as constants in `wp-config.php`
- 🛡️ **Honeypot anti-bot** — `_mw_hp_url` field, autofill-resistant
- 🗺️ **Auto-populated taxonomies** — categories, cities, Marrakech neighborhoods
- 📑 **Auto-created pages** — Home, About, Contact, FAQ, Privacy, Terms, Compare, Favorites…
- 🎨 **Tabbed property meta-box** — Details · Media · Map · Amenities

---

## 🏗️ Tech Stack

| Layer | Tech |
|---|---|
| **CMS** | WordPress 6.0+ |
| **Language** | PHP 8.0+ |
| **Database** | MySQL / MariaDB |
| **Theme** | `rentup-theme` — fully custom, no page builder |
| **i18n** | Native `?lang=` + cookie · optional Polylang |
| **Email** | `wp_mail` over SMTP (Gmail App Password ready) |
| **Front** | Vanilla JS · CSS3 · zero framework lock-in |

---

## 🚀 Quick Start

```bash
# 1. Clone into your WordPress install
git clone https://github.com/your-org/murailles-immobilier.git wordpress/

# 2. Point Apache / Nginx / XAMPP to the directory

# 3. Create the database
mysql -u root -e "CREATE DATABASE wordpress_rentup;"

# 4. Configure wp-config.php (DB credentials + MURAILLES_* SMTP constants)

# 5. Activate the theme: WP Admin → Appearance → Themes → Murailles Immobilier

# 6. Set permalinks: WP Admin → Settings → Permalinks → "Post name"
```

> 📖 **Full setup walkthrough:** see [`SETUP.md`](SETUP.md) — 18 chapters covering install, SMTP, multilang, production deployment, and troubleshooting.

---

## ⚙️ Required Constants

Add these to `wp-config.php` **before** the `/* That's all, stop editing! */` line:

```php
define( 'MURAILLES_SMTP_HOST',       'smtp.gmail.com' );
define( 'MURAILLES_SMTP_PORT',       587 );
define( 'MURAILLES_SMTP_SECURE',     'tls' );
define( 'MURAILLES_SMTP_USER',       'your-address@gmail.com' );
define( 'MURAILLES_SMTP_PASS',       'xxxx xxxx xxxx xxxx' ); // Gmail App Password
define( 'MURAILLES_SMTP_FROM',       'your-address@gmail.com' );
define( 'MURAILLES_SMTP_FROM_NAME',  'Agence Murailles' );
define( 'MURAILLES_LEAD_NOTIFY',     'contact@murailles-immobilier.com' );
define( 'MURAILLES_WHATSAPP_NUMBER', '212661425150' );
```

---

## 📂 Project Structure

```
wordpress/
├── wp-content/
│   └── themes/
│       └── rentup-theme/              ← The custom theme
│           ├── assets/
│           │   ├── css/styles.css     ← Main stylesheet
│           │   └── js/                ← Vanilla JS bundles
│           ├── inc/
│           │   ├── custom-post-types.php   ← Property CPT + taxonomies
│           │   ├── forms.php               ← Contact + submit-property handlers
│           │   ├── i18n.php                ← FR/EN switcher logic
│           │   ├── i18n-strings.php        ← UI string translations
│           │   ├── contact-helpers.php     ← Single source of truth for agency info
│           │   └── smtp.php                ← PHPMailer SMTP bootstrap
│           ├── page-templates/        ← About, Contact, FAQ, Submit, Compare…
│           ├── template-parts/        ← Headers, footers, nav, components
│           ├── archive-property.php   ← /bien/ listing
│           ├── single-property.php    ← /bien/{slug}/ detail
│           ├── front-page.php        ← Homepage
│           └── functions.php
├── SETUP.md                          ← Full deployment guide (FR)
└── README.md                         ← You are here
```

---

## 🗺️ Routes & Pages

| Slug | Template | Purpose |
|------|----------|---------|
| `/` | `front-page.php` | Homepage |
| `/bien/` | `archive-property.php` | Property listing |
| `/bien/{slug}/` | `single-property.php` | Property detail |
| `/categorie-bien/{cat}/` | archive | Filter by category |
| `/localisation/{city}/` | archive | Filter by city |
| `/submit-property/` | page-template | Visitor submission |
| `/favoris/` | page-template | User favorites |
| `/compare-property/` | page-template | Comparator |
| `/contact/` | page-template | Contact form |
| `/about-us/` · `/faq/` · `/blog/` | page-templates | Static |

---

## 🌍 Internationalization

Two modes, fully supported out-of-the-box:

| Mode | Setup | URL Style | SEO |
|------|-------|-----------|-----|
| **Native** | Zero-config | `/page/?lang=en` | Good |
| **Polylang** | Install plugin | `/en/page/` | Best |

Strings live in `inc/i18n-strings.php` and are auto-registered with `pll_register_string()` when Polylang is active.

---

## 🧪 Troubleshooting

| Symptom | Cause | Fix |
|---------|-------|-----|
| `/bien/page/2/` → 404 | Rewrite rules not flushed | Re-save Permalinks |
| "Invalid request" on form submit | Autofill triggered honeypot | Already patched in v1.0 |
| No emails received | SMTP misconfigured | Verify Gmail App Password |
| Blank page | `WP_DEBUG = false` masking error | Enable, check `debug.log` |
| Footer shows "rentup" | Site Title not changed | Settings → General |

Full troubleshooting in [`SETUP.md` § 16](SETUP.md).

---

## 🛣️ Roadmap

- [ ] Stripe-based featured-listing checkout
- [ ] Saved searches with email alerts
- [ ] Map clustering on `/bien/` archive
- [ ] Agent dashboards (multi-user listings)
- [ ] PWA wrap with offline favorites

---

## 🤝 Contributing

This is a client project, but pull requests for bug fixes are welcome. Please open an issue first to discuss any major changes.

```bash
git checkout -b fix/your-fix
git commit -m "fix: clear description"
git push origin fix/your-fix
```

---

## 📜 License

Released under the **GNU GPL v2 or later** — same license as WordPress core.

---

## 👤 Credits

<div align="center">

**Designed & developed by [CodeSommet](https://codesommet.com/)**
For **Agence Murailles Immobilier** · Marrakech, Maroc

📍 13 Rue Mouslim, Résidence Boukar — Marrakech 40000
📞 +212 6 61 42 51 50 · ✉️ contact@murailles-immobilier.com

[Website](https://murailles-immobilier.com) · [Facebook](https://www.facebook.com/profile.php?id=100063563441285)

---

*Made with care in Marrakech* 🇲🇦

</div>
