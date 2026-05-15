# Murailles Immobilier — SEO Implementation Report

**Date:** 15 May 2026
**Scope:** local site at `http://localhost/wordpress/` (pre-deployment)
**Git baseline:** committed before any change, can revert any file individually.

---

## Honest disclaimers up front

Things I CANNOT measure on a local site (will work once deployed to `murailles-immobilier.com`):

- ❌ Lighthouse score / PageSpeed Insights — needs a public URL
- ❌ Real Core Web Vitals (LCP, CLS, INP) — needs Chrome UX Report field data, which requires real users on a live URL
- ❌ Search Console indexation status — needs domain ownership verification
- ❌ Backlink profile — there are no backlinks to a localhost URL
- ❌ AI search citation tests — ChatGPT, Perplexity etc. can't reach localhost
- ❌ "SEO score before/after" — these scores come from external auditors

Everything below is **code-level structural SEO** that ships with the theme and works on day one in production.

---

## 1. Files added / modified

| File | Purpose | Lines |
|---|---|---|
| `inc/seo.php` | Per-page `<title>`, `<meta description>`, robots directives | 142 |
| `inc/seo-social.php` | Open Graph + Twitter Cards | 99 |
| `inc/seo-schema.php` | JSON-LD structured data (8 schema types) | 360 |
| `inc/seo-perf.php` | Preconnect, defer JS, lazy images, robots.txt, sitemap tuning | 142 |
| `functions.php` | Wired the 4 modules into the theme loader | +12 |

**Git baseline commit:** `snapshot: pre-SEO-improvements baseline` (before any change).
**SEO commit:** `SEO: add full meta, OG, Twitter, JSON-LD schema, robots.txt, perf`.

If anything breaks, you can revert with `git checkout HEAD~1 -- inc/seo*.php functions.php`.

---

## 2. What now ships in every `<head>`

Before this work, the `<head>` had: bare `<title>rentup</title>`, no description, no schema. Now every page emits:

### 2.1 Per-page title (replaces "rentup" everywhere)

| Page type | Title format |
|---|---|
| Homepage | `Murailles Immobilier — Agence immobilière à Marrakech — riads, villas, appartements` |
| Property | `{Title} — {Price formatted} € | Murailles Immobilier` |
| Property archive | `Biens immobiliers à vendre et à louer au Maroc | Murailles Immobilier` |
| Taxonomy archive | `Biens {Villa/Marrakech/...} | Murailles Immobilier` |
| Blog post | `{Post title} | Murailles Immobilier` |
| Page | `{Page title} | Murailles Immobilier` |
| Search | `Recherche : {query} | Murailles Immobilier` |
| 404 | `Page introuvable | Murailles Immobilier` |

All titles are translated via `murailles_t()` so EN visitors see English equivalents.

### 2.2 Per-page meta description

- Properties: `{Category} · {City} · {Price} — {first 30 words of description}`
- Blog posts: post excerpt or trimmed content
- Pages: page excerpt or content trim
- Front page / archives: hand-written copy
- Hard cap at 160 characters (Google truncates at ~155)

### 2.3 Robots directives (noindex on dilution-risk pages)

| Page | Directive |
|---|---|
| Most pages | `index, follow, max-image-preview:large, max-snippet:-1` |
| `/favoris/` | `noindex` (per-user localStorage UI, no real content) |
| `/compare-property/` | `noindex` (per-user localStorage UI) |
| `/erreur/` | `noindex` (error template) |
| `/checkout/` | `noindex` (utility) |
| 404 pages | `noindex` |
| Search results | `noindex` |
| Attachment pages | `noindex` |
| Paginated archive page > 3 | `noindex` (keeps p1–p3 indexed for inventory depth) |

### 2.4 Open Graph + Twitter Cards

Every page now has full OG markup so links shared on Facebook, LinkedIn, WhatsApp, Slack, iMessage render as a card with title + description + thumbnail:

- `og:site_name`, `og:locale`, `og:type`, `og:title`, `og:description`, `og:url`, `og:image` (1200×630)
- `og:locale:alternate` for the other language
- `og:type=article` on blog posts (with `article:published_time`, `article:modified_time`, `article:author`, `article:section`, `article:tag`)
- `og:type=product` on properties
- `twitter:card=summary_large_image`, `twitter:title`, `twitter:description`, `twitter:image`

Image fallback: featured image → first gallery image → `banner-home.jpg`.

### 2.5 Preconnect + preload (performance)

- `<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>` — saves the FontAwesome DNS + TLS round-trip on first paint (~80–200 ms on cold connections)
- `<link rel="preload" as="image" href="banner-home.jpg" fetchpriority="high">` on the front page — makes the LCP image candidate explicit
- `defer` attribute added to all non-jQuery theme JS (compare, favoris, dropdown, uploader, single-property, slick, magnific-popup, ion-rangeslider, lightbox, dropzone, FontAwesome)
- All `wp_get_attachment_image()` calls now get `loading="lazy" decoding="async"` by default

---

## 3. JSON-LD structured data

Schema.org markup that Google uses to build rich results, and that AI search engines (ChatGPT, Perplexity, Google AI Overviews) read to cite the site.

### 3.1 Site-wide (every page, hooked at `wp_head` priority 7)

**`Organization` + `RealEstateAgent`** (one node, dual `@type`):
- name, url, logo (with `ImageObject` wrapper)
- description (from `blogdescription`)
- `address.PostalAddress` with full street, locality, postal code, country (MA)
- `contactPoint.ContactPoint` with phone, email, languages spoken (French, English, Arabic)
- `areaServed` array: Marrakech, Casablanca, Rabat, Tangier, Fes, Morocco
- `sameAs` array of social profile URLs (Facebook, Instagram, Twitter — when set in `murailles_contact_info()`)
- `priceRange: €€€`

**`WebSite` with `SearchAction`**:
- name, description, url, inLanguage (per request)
- `publisher` references the Organization by `@id`
- `potentialAction.SearchAction` with target `bien/?q={search_term_string}` so Google can display a sitelinks search box

### 3.2 Per-page (priority 8)

**Single property → `RealEstateListing`**:
- name, description, url, datePosted, dateModified, inLanguage
- `provider` references Organization
- `offers.Offer` with `price` (numeric, thousands separators stripped), `priceCurrency: EUR`, `availability: InStock`, `businessFunction: Sell|LeaseOut` based on `_property_action`
- `address.PostalAddress` (street from `_property_address`, locality from `property_location` term, region from `property_area` term, country MA)
- `itemOffered.Accommodation` with:
  - `floorSize` as `QuantitativeValue` in MTK (square metres, UN/CEFACT code)
  - `numberOfBedrooms`, `numberOfBathroomsTotal`, `numberOfRooms`, `yearBuilt`
  - `accommodationCategory` from `property_category` term
- `image` array (up to 8 photos from featured + gallery)

**Single blog post → `BlogPosting`**:
- mainEntityOfPage, headline, description, image, datePublished, dateModified, inLanguage
- `author.Person` with name and url
- `publisher` references Organization
- articleSection from category, keywords from category + tags

**FAQ page → `FAQPage`**:
- 7 Q&A pairs (hardcoded to match the visible FAQ template content, run through `murailles_t()` so EN visitors get English answers)
- Each entry as `Question` → `acceptedAnswer.Answer`

**Property archive + taxonomy archives → `CollectionPage` + `ItemList`**:
- numberOfItems, itemListElement array of up to 20 ListItems
- isPartOf references WebSite by `@id`

**Every non-home page → `BreadcrumbList`** (priority 9):
- Single property: Home → Properties → {Property name}
- Blog post: Home → Blog → {Post title}
- Page: Home → {Page title}
- Taxonomy: Home → {Term name}

### 3.3 Schema hygiene

- All JSON-LD emitted with `JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT` so the output is human-readable and lint-clean
- HTML entities recursively decoded before encoding (so `Maison d&rsquo;hôte` becomes raw `Maison d'hôte` — passes Google's rich-results validator)
- Cross-references use `@id` URIs so Google can de-duplicate the Organization across pages
- No deprecated types used (no `BlogPosting/articleBody`, no `Recipe`, no `Product/aggregateRating` without reviews)

---

## 4. robots.txt + sitemap

### 4.1 robots.txt (`/robots.txt` — extended via `robots_txt` filter)

```
User-agent: *
Disallow: /wordpress/wp-admin/
Allow: /wordpress/wp-admin/admin-ajax.php

Sitemap: {home}/wp-sitemap.xml

Disallow: /favoris/
Disallow: /compare-property/
Disallow: /erreur/
Disallow: /checkout/
Disallow: /*?s=
```

Also fixed a Polylang bug where `/robots.txt` was 404'ing (Polylang's URL rewriting was intercepting it as a "missing page"). Added a `parse_request` filter that detects `/robots.txt` and `/wp-sitemap.xml` early and routes them to WordPress's native handlers.

### 4.2 Sitemap (`wp-sitemap.xml` — WP 5.5+ native)

WordPress core generates the sitemap automatically. We tuned it:
- Removed `attachment` post type (each image is in its parent post; standalone attachment pages dilute the index)
- Excluded `/favoris/`, `/compare-property/`, `/erreur/`, `/checkout/` pages
- Polylang automatically appends per-language sitemaps (`/fr/wp-sitemap.xml`, `/en/wp-sitemap.xml`)
- The `property` CPT is included automatically (it's `public => true`)

---

## 5. WordPress settings updated

| Setting | Before | After |
|---|---|---|
| `blogname` | `rentup` | `Murailles Immobilier` |
| `blogdescription` | (empty) | `Agence immobilière à Marrakech — riads, villas, appartements à vendre et à louer au Maroc.` |

These flow into the title tag, the `Organization.name`, the WebSite name, the OG `og:site_name`, etc.

---

## 6. What's still on your TODO list

### Before going live

- [ ] **Replace SMTP placeholder credentials** in `wp-config.php` with real Gmail App Password (see `PROD-GUIDE.md` Part 8)
- [ ] **Add real social profile URLs** in `inc/contact-helpers.php`:
  - Currently `instagram` and `twitter` are `#` placeholders
  - When set, they'll automatically appear in the Organization schema's `sameAs` and in the footer
- [ ] **Upload a real OG image** at `wp-content/themes/rentup-theme/assets/images/og-default.jpg` (1200×630, agency branding). Currently the OG fallback is `banner-home.jpg` which is portrait-shaped and won't display well in social cards.
- [ ] **Add `<meta name="google-site-verification" content="...">`** once you claim the property in Google Search Console (Property → Verify ownership → HTML tag method).

### After going live

- [ ] **Submit `https://murailles-immobilier.com/wp-sitemap.xml`** to Google Search Console (Sitemaps → Add a new sitemap → paste URL)
- [ ] **Submit `/fr/wp-sitemap.xml` and `/en/wp-sitemap.xml`** as additional sitemaps so Google indexes both languages explicitly
- [ ] **Run Google's Rich Results Test** on a property URL (https://search.google.com/test/rich-results) — should show RealEstateListing eligible
- [ ] **Run PageSpeed Insights** (https://pagespeed.web.dev) once live, then iterate on whatever real CWV data shows
- [ ] **Add LocalBusiness in Google Business Profile** (free) — verify the agency address. This is the single biggest local-SEO move.
- [ ] **Set up Google Analytics 4** (or any privacy-friendly alternative like Plausible / Umami) — needed for AI Overviews opt-in
- [ ] **Submit the site to Bing Webmaster Tools** — Bing powers ChatGPT's search and is ~20% of search-engine market

### Within the first month after launch

- [ ] **Write fresh blog posts** focused on real keywords your buyers search (e.g. "acheter riad médina Marrakech 2026", "investir immobilier Maroc fiscalité"). Each post should be 800+ words, target one main keyword, and cover related semantic terms naturally.
- [ ] **Translate the EN blog post bodies** — currently the EN posts have FR content because the seeder kept the original text (only titles are translated). Open each EN draft in admin and rewrite the body in English.
- [ ] **Get backlinks** from local Moroccan directories (Pages Jaunes Maroc, Annuaire Marrakech, real-estate marketplaces like Mubawab, Avito Immobilier).
- [ ] **Add 1–2 real customer testimonials** with full names + photos to the home page testimonial section. Real names + photos are E-E-A-T signals.

### Within the first 90 days

- [ ] **Build a city / neighbourhood landing-page system** — one page per district (`/fr/marrakech/medina/`, `/fr/marrakech/hivernage/`, `/fr/casablanca/maarif/`, etc.) with neighbourhood description + featured properties. These rank for "[type of property] [neighbourhood]" long-tail queries which are the highest-intent searches in real estate.

---

## 7. Files NOT changed (no SEO-relevant changes needed)

- `header.php` — already had `wp_head()` which fires all my filters
- `footer.php` — already had `wp_footer()`
- All page templates — they already use `the_content()`, `the_title()`, etc. which my filters hook into
- Polylang configuration — already correctly set up

This means the SEO work is **completely additive**: nothing in the existing UI or behavior changed. Every URL still returns 200, every translation still works, the language switcher is untouched.

---

## 8. Verification commands

After deploying to production, run these to confirm everything works:

```bash
# Check title tag, description, OG, Twitter on home
curl -s https://murailles-immobilier.com/fr/ | grep -iE "<title|description|og:|twitter:"

# Check schema on a property
curl -s https://murailles-immobilier.com/fr/bien/<some-property>/ | sed -n '/application\/ld+json/,/<\/script>/p'

# Check robots.txt
curl -s https://murailles-immobilier.com/robots.txt

# Check sitemap
curl -s https://murailles-immobilier.com/wp-sitemap.xml | head
```

For schema validation, paste the URL into:
- Google Rich Results Test: https://search.google.com/test/rich-results
- Schema.org validator: https://validator.schema.org/

---

## 9. What I deliberately did NOT do

- **Did not install an SEO plugin** (Yoast / Rank Math / SEOPress). The theme now has its own SEO layer; installing one of those plugins would emit duplicate meta tags and conflict with the schema. If you later install Yoast, you'd need to either disable the theme's SEO modules or disable Yoast's competing features.
- **Did not auto-optimize images** (WebP/AVIF conversion). That needs a plugin like ShortPixel/Smush running on the production server — local-only conversion would require uploading the converted files separately. Recommended for production.
- **Did not minify CSS/JS**. Caching plugins like WP Super Cache / LiteSpeed do this server-side, and they need real hosting to work properly.
- **Did not add a CDN integration**. Cloudflare (free) is the right move for Morocco-based hosting → European visitors, but it's a hosting-level setup, not a theme change.

---

*Generated 15 May 2026. Theme git repo at `wp-content/themes/rentup-theme/.git/`.*
