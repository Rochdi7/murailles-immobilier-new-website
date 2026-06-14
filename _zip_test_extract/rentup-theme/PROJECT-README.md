# Murailles Immobilier — Project README
> Give this file to ChatGPT or any AI assistant to explain the full project structure.

---

## 1. What this project is

**Murailles Immobilier** is a custom WordPress real estate website for a Moroccan property agency based in Marrakech.
It is built as a **fully custom WordPress theme** named `rentup-theme` — there is no parent theme, no page builder controlling the layout. All pages are PHP template files.

- **Local dev URL:** `http://localhost/wordpress`
- **Production URL:** `https://www.murailles-immobilier.com` (Hostinger, LiteSpeed)
- **WordPress:** 6.9.4
- **PHP:** 8.2 (production target: PHP 8.3)
- **Theme folder:** `wp-content/themes/rentup-theme/`
- **Theme version:** 1.0.0

---

## 2. Tech stack

| Layer | Technology |
|-------|-----------|
| CMS | WordPress 6.9.4 |
| Theme | Custom PHP theme (`rentup-theme`) |
| CSS framework | Bootstrap 5 (bundled in `assets/css/styles.css`) |
| Icons | Font Awesome 6 (CDN) + Themify Icons (bundled) |
| JS | jQuery 3.6 (theme copy), Slick carousel, Select2, Magnific Popup, Ion Range Slider |
| Forms | Vanilla JS Fetch API (`assets/js/forms.js`) |
| Animations | Custom IntersectionObserver (`assets/js/scroll-animations.js`) |
| Email | Gmail SMTP via `phpmailer_init` hook (constants in `wp-config.php`) |
| i18n | Polylang (FR primary, EN secondary) |
| SEO | Custom SEO system (no Yoast/Rank Math) — see Section 7 |
| Server | Apache/Nginx + LiteSpeed (Hostinger), Cloudflare CDN, MariaDB 10.11 |

---

## 3. Active plugins

| Plugin | Purpose |
|--------|---------|
| **Polylang** | FR/EN bilingual site |
| **All In One WP Security** | Security hardening |
| **Burst Statistics** | Cookie-free analytics |
| **Elementor** (Free) | Available but NOT used for layout — only for optional Elementor canvas pages |
| **WP Bakery Page Builder** | Installed but NOT used — pages are pure PHP |
| **Royal MCP** | Royal Elementor Addons companion |
| **UpdraftPlus** | Backups |
| **WP-Optimize** | Cache + DB optimization |

> **Important:** Neither Elementor nor WP Bakery controls any page layout. All pages render from PHP template files. The WordPress page editor is intentionally empty for all pages.

---

## 4. Theme file structure

```
rentup-theme/
│
├── functions.php              # Master bootstrap: loads all inc/ files, registers CPTs,
│                              # menus, enqueues CSS/JS, widget areas, nav walker
│
├── front-page.php             # Homepage (WordPress static front page, ID=6)
├── header.php                 # Site header — transparent or light depending on page
├── footer.php                 # Site footer with contact info, social links, menus
├── single-property.php        # Single property listing page (CPT template)
├── archive-property.php       # Property listing / search results page (/bien/)
├── single.php                 # Blog post template
├── page.php                   # Generic fallback page template
├── 404.php                    # 404 error page
├── search.php                 # Search results
│
├── page-templates/            # Custom page templates (assigned per page in WP admin)
│   ├── about-us.php           # À propos page
│   ├── contact.php            # Contact page with form + map
│   ├── faq.php                # FAQ accordion (5 sections, 20 Q&As)
│   ├── nos-services.php       # Services page
│   ├── blog.php               # Blog listing page
│   ├── submit-property.php    # Public property submission form
│   ├── favoris.php            # Saved favourites (localStorage)
│   ├── compare-property.php   # Side-by-side property comparison
│   ├── grid-layout-with-sidebar.php  # Property search with filters + sidebar
│   ├── single-property-1.php  # Property detail page layout variant
│   ├── terms.php              # Conditions générales
│   ├── privacy.php            # Privacy policy
│   ├── error.php              # Custom error/404 page
│   ├── assistance-conseils.php
│   ├── histoire-marrakech.php
│   ├── tourisme-marrakech.php
│   ├── elementor-canvas.php   # Blank canvas (no header/footer) for Elementor
│   └── elementor-header-footer.php  # Elementor with theme header/footer
│
├── template-parts/            # Reusable partial templates
│   ├── call-to-action.php     # CTA banner (appears on most pages)
│   ├── blog-card.php          # Blog post card
│   ├── page-title.php         # Page hero banner with breadcrumb
│   ├── login-modal.php        # Login modal HTML
│   └── message-modal.php      # Message/contact modal HTML
│
├── inc/                       # PHP modules (all required in functions.php)
│   ├── custom-post-types.php  # Property CPT, 3 taxonomies, tabbed metabox, admin columns
│   ├── agent-post-type.php    # Agent CPT registration + metabox
│   ├── forms.php              # SMTP config, Lead CPT, form handlers (contact/review/
│   │                          # newsletter/submit-property), CSV export
│   ├── interactive.php        # AJAX property payload, wishlist/compare JS, WhatsApp btn
│   ├── i18n.php               # murailles_t() helper, Polylang integration, cookie switcher
│   ├── i18n-strings.php       # FR→EN translation dictionary (seeds Polylang)
│   ├── email-templates.php    # HTML email templates for form notifications
│   ├── theme-options.php      # "Options du thème" admin panel (6 tabs: text/images/team)
│   ├── seo.php                # Title tags, meta description, robots directives
│   ├── seo-social.php         # Open Graph + Twitter Cards
│   ├── seo-schema.php         # Schema.org JSON-LD (Organization, RealEstateListing, etc.)
│   ├── seo-perf.php           # Preconnect hints, defer JS, lazy images, robots.txt, sitemap
│   ├── seo-advanced.php       # Advanced SEO features
│   └── seo-multilingual.php   # Multilingual SEO (hreflang, per-language schema)
│
├── assets/
│   ├── css/
│   │   ├── styles.css         # Main stylesheet (Bootstrap + all vendor CSS combined)
│   │   ├── slick.css          # Slick carousel core
│   │   ├── murailles-custom.css  # Theme overrides and custom components
│   │   ├── murailles-dropdown.css # Dropdown/select/datepicker styling
│   │   └── scroll-animations.css  # Scroll animation classes
│   └── js/
│       ├── jquery.min.js      # jQuery 3.6 (theme copy)
│       ├── custom.js          # Main theme JS: Slick carousels, tooltips, nav behavior
│       ├── forms.js           # AJAX form handler (Fetch API, honeypot, MuraillesForms object)
│       ├── scroll-animations.js  # IntersectionObserver scroll animations
│       └── [vendor libs]      # bootstrap.min.js, slick.js, select2.min.js, etc.
│
├── DEPLOY/
│   └── wp-config-production-template.php  # Production wp-config template (fill <<REPLACE>>)
│
├── AUDIT-REPORT.md            # Full production readiness audit (issues, fixes, checklist)
└── PROJECT-README.md          # This file
```

---

## 5. Pages and their templates

| WP Page ID | Page Title | Template File | Notes |
|-----------|-----------|---------------|-------|
| 6 | Home | `front-page.php` | Static front page (Settings→Reading) |
| 7 | About Us | `page-templates/about-us.php` | Story, counters, team carousel |
| 8 | Contact | `page-templates/contact.php` | Contact form + map |
| 9 | Blog | `page-templates/blog.php` | Blog listing |
| 10 | FAQ | `page-templates/faq.php` | 5-section accordion, 20 Q&As |
| 12 | Privacy Policy | `page-templates/privacy.php` | |
| 20 | Submit Property | `page-templates/submit-property.php` | Public form, file upload |
| 21 | Compare Property | `page-templates/compare-property.php` | JS-driven comparison table |
| 22 | Single Property 1 | `page-templates/single-property-1.php` | Property detail layout |
| 31 | Grid Layout With Sidebar | `page-templates/grid-layout-with-sidebar.php` | Property search/filter |
| 90 | Assistance & Conseils | `page-templates/assistance-conseils.php` | |
| 91 | Histoire de Marrakech | `page-templates/histoire-marrakech.php` | Editorial content page |
| 92 | Tourisme à Marrakech | `page-templates/tourisme-marrakech.php` | Editorial content page |
| 120 | Mes favoris | `page-templates/favoris.php` | localStorage-based favourites |
| 123 | Erreur | `page-templates/error.php` | Custom error page |
| 127 | Conditions générales | `page-templates/terms.php` | |
| 130 | Nos Services | `page-templates/nos-services.php` | Services grid |

> **Rule:** The WordPress page editor content (post_content) is **ignored** for all these pages — the PHP template file controls 100% of the output. To edit page content, use **Admin → Options du thème**.

---

## 6. Custom Post Types & Taxonomies

### CPT: `property`
The core data type. Each property has a tabbed metabox with 7 tabs:

| Meta field key | Description |
|---------------|-------------|
| `_property_price` | Price (number) |
| `_property_price_suffix` | Price suffix (e.g. "/mois") |
| `_property_action` | "Vente" / "Location" / "Location saisonnière" |
| `_property_address` | Full address string |
| `_property_size` | Area in m² |
| `_property_bedrooms` | Number of bedrooms |
| `_property_bathrooms` | Number of bathrooms |
| `_property_garage` | Garage count |
| `_property_year` | Year built |
| `_property_description` | Long description |
| `_property_video_url` | YouTube/Vimeo URL |
| `_property_map_lat` / `_property_map_lng` | GPS coordinates |
| `_property_gallery_ids` | Comma-separated attachment IDs for gallery |
| `_property_amenities` | Comma-separated amenity keys |
| `_property_featured` | "1" if featured |

**Taxonomies on `property`:**

| Taxonomy | Slug | Description |
|----------|------|-------------|
| `property_category` | `property_category` | Type: Riad, Villa, Appartement, Terrain, Commerce… |
| `property_location` | `property_location` | Hierarchical: Country → City (Marrakech, Casablanca, etc.) |
| `property_area` | `property_area` | Neighbourhood/district |

### CPT: `agent`
Agent profiles with photo, phone, email, WhatsApp, bio, social links.

### CPT: `murailles_lead`
Auto-created when a contact/property inquiry form is submitted. Stores name, email, phone, message, source page.

### CPT: `murailles_subscriber`
Newsletter subscribers. Has CSV export via admin-post endpoint.

---

## 7. SEO system (custom, no plugin)

All SEO is handled by theme files in `inc/`. There is **no Yoast, Rank Math, or AIOSEO**.

| File | What it does |
|------|-------------|
| `inc/seo.php` | `<title>` tag via `pre_get_document_title`, meta description, robots noindex for search/archive |
| `inc/seo-social.php` | Open Graph (`og:title`, `og:image`, `og:description`, `og:type`) + Twitter Cards |
| `inc/seo-schema.php` | JSON-LD Schema.org: `Organization`, `RealEstateAgent`, `WebSite+SearchAction`, `RealEstateListing`, `BlogPosting`, `FAQPage`, `BreadcrumbList`, `CollectionPage+ItemList` |
| `inc/seo-perf.php` | Preconnect hints, defer JS, `loading="lazy"` on images, robots.txt extension, XML sitemap filter, `lang` attribute, skip link |
| `inc/seo-multilingual.php` | `hreflang` tags for FR/EN, per-language schema `inLanguage` |

**Guards:** All SEO output checks for active SEO plugins (`WPSEO_VERSION`, `RANK_MATH_VERSION`, `AIOSEO`, `SEOPRESS_VERSION`) and suppresses itself to avoid duplicates.

---

## 8. i18n / Multilingual

- **Plugin:** Polylang (FR = primary, EN = secondary)
- **Helper function:** `murailles_t( $string, $echo = true )` — translates a string via Polylang's `pll__()` if available, falls back to direct output
- **String registration:** `inc/i18n-strings.php` seeds all UI strings into Polylang's string translation panel on activation
- **Language switcher:** rendered in `header.php` using `pll_the_languages()`
- **Cookie:** `murailles_lang` stores the user's language preference (1 year)
- **Schema:** All JSON-LD outputs include `"inLanguage": "fr-MA"` (or `"en"`)

---

## 9. Forms and AJAX endpoints

All forms use: **nonce** + **honeypot** (`_mw_hp_url` field) + **minimum fill time** check (via `_murailles_ts` timestamp).

| Action name | Handler | What it does |
|-------------|---------|-------------|
| `murailles_contact` | `inc/forms.php` | Contact form → saves `murailles_lead` CPT + sends email notification |
| `murailles_review` | `inc/forms.php` | Property review submission |
| `murailles_newsletter` | `inc/forms.php` | Newsletter signup → saves `murailles_subscriber` CPT |
| `murailles_submit_property` | `inc/forms.php` | Public property submission form → saves pending `property` CPT + uploads photos via `media_handle_upload()` |
| `murailles_get_properties` | `inc/interactive.php` | AJAX: returns property data JSON for compare/wishlist by ID array |

Frontend JS form handler: `assets/js/forms.js` — uses Fetch API, reads `MuraillesForms` localized object (nonce, ajaxurl, messages).

---

## 10. Theme Options (admin panel)

**Location:** Admin sidebar → **"Options du thème"**

A custom settings page with 6 tabs, storing all values in `wp_options` under key `murailles_options`.

| Tab | Editable fields |
|-----|----------------|
| Accueil | Hero background image, H1 title, subtitle, "Qui sommes-nous?" image + years badge + 2 paragraphs, 3 "Comment ça marche?" steps |
| À propos | Banner image, story section image + title + 2 paragraphs, 4 counter numbers + labels |
| Contact | Banner image, phone, email, address lines 1+2, WhatsApp number, Google Maps embed URL, page title + subtitle |
| Agence | Agency name, tagline, logo (normal + transparent), founder name, years experience, Facebook/Instagram/LinkedIn/Twitter URLs |
| Équipe | Repeater: add/remove/edit team members (photo via media library, name, role, social links) |
| Témoignages | Repeater: add/remove/edit client testimonials (photo, name, role/city, star rating, text) |

**PHP helper:** `murailles_opt( $key, $default )` — reads from the options array with static caching.

---

## 11. Header behavior

`header.php` supports two modes controlled by `$murailles_header_style`:

- **`'transparent'`** — set in `front-page.php`. Dark transparent header that becomes light on scroll. Uses white logo variant.
- **`'light'`** (default) — solid white header. Uses dark logo. Used on all inner pages.

The nav walker is a custom `Murailles_Nav_Walker` class (in `functions.php`) that adds Bootstrap 5 dropdown markup.

---

## 12. Homepage sections (front-page.php)

In order from top to bottom:

1. **Hero banner** — full-screen background image, H1 title + subtitle, property search form (location/type/price dropdowns → submits GET to `/bien/`)
2. **Awards bar** — Trustpilot / Google / immobilier ratings strip
3. **Property categories** — taxonomy term cards
4. **Affaires du Mois** — featured properties carousel (IDs stored in `murailles_affaires_du_mois` option, set in WP Admin)
5. **Biens à la une** — latest 9 properties carousel
6. **Comment ça marche** — 3-step process section
7. **Qui sommes-nous** — about section with image + expandable text
8. **Villes phares** — 5 city cards (Casablanca, Marrakech, Rabat, Tanger, Fès) linking to filtered property archive
9. **Avis clients** — testimonials carousel (data from Options du thème → Témoignages)
10. **Blog articles** — latest 3 blog posts
11. **Call to Action** — banner with contact button (from `template-parts/call-to-action.php`)

---

## 13. Property archive / search (`archive-property.php`)

URL: `/bien/` (custom rewrite via `add_rewrite_rule`)

**GET parameters:**
| Param | Description |
|-------|------------|
| `location` | `property_location` taxonomy slug |
| `ptype` | `property_category` taxonomy slug |
| `price_min` | Minimum price (meta query) |
| `price_max` | Maximum price (meta query) |
| `q` | Keyword search (post title) |
| `area` | `property_area` taxonomy slug |
| `action` | "vente" / "location" (meta query on `_property_action`) |

---

## 14. Key WordPress hooks used

| Hook | File | Purpose |
|------|------|---------|
| `after_setup_theme` | functions.php | Theme supports, menus, image sizes |
| `wp_enqueue_scripts` | functions.php | CSS/JS loading |
| `pre_get_document_title` | inc/seo.php | Custom title tag |
| `wp_head` (priority 7,8,9) | inc/seo-schema.php | JSON-LD schema output |
| `wp_head` | inc/seo-social.php | OG/Twitter meta tags |
| `wp_robots` | inc/seo-perf.php | Robots directives |
| `robots_txt` | inc/seo-perf.php | robots.txt extension |
| `wp_sitemaps_add_provider` | inc/seo-perf.php | Sitemap customization |
| `template_redirect` (p.0) | inc/seo-perf.php | `ob_start()` for img lazy-load rewriting |
| `save_post_property` | inc/custom-post-types.php | Property meta save |
| `phpmailer_init` | inc/forms.php | Gmail SMTP configuration |
| `use_block_editor_for_post` | functions.php | Disables Gutenberg for theme-templated pages |
| `use_block_editor_for_post_type` | inc/custom-post-types.php | Disables Gutenberg for `property` CPT |
| `admin_menu` | inc/theme-options.php | "Options du thème" admin page |
| `admin_post_murailles_save_options` | inc/theme-options.php | Options save handler |

---

## 15. Things that are NOT done yet (known issues)

See `AUDIT-REPORT.md` for the full list. Critical ones:

1. **SMTP not configured** — `MURAILLES_SMTP_*` constants must be defined in `wp-config.php` before forms send email
2. **`DEPLOY/` directory** is publicly accessible — delete before going live
3. **jQuery deregister** at `functions.php:144-145` — breaks Elementor; should be removed (WordPress ships jQuery 3.7.1)
4. **SVG upload without sanitization** at `functions.php:375` — XSS risk
5. **`pre_get_document_title`** not guarded against SEO plugins at `inc/seo.php:31`
6. **Hero image** is a CSS background (not `<img>`) — suboptimal LCP score
7. **18 JS files** loaded globally on every page — should be conditional

---

## 16. How to ask ChatGPT to help with this project

When asking for help, always specify:

- **Which file** you want to change (e.g. `inc/forms.php`, `front-page.php`)
- **Which section** (e.g. "the hero banner section", "the contact form handler")
- **The function or hook name** if relevant (e.g. `murailles_save_options`, `murailles_t()`)

Example prompts:
- *"In `inc/forms.php`, the `murailles_handle_submit_property` function — add a limit of 10 uploaded files"*
- *"In `front-page.php`, the hero section — convert the background-image div to an `<img>` tag with `fetchpriority='high'`"*
- *"In `inc/seo.php`, guard the `pre_get_document_title` filter against Yoast and Rank Math being active"*
- *"In `inc/theme-options.php`, add a new field to the Contact tab for the agency's opening hours"*
- *"In `archive-property.php`, add a `bedrooms` GET parameter filter to the WP_Query"*
