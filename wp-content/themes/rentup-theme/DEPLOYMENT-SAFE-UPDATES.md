# Safe Theme Updates

This theme is intended to be updated by replacing theme files only.

## Before Updating

Back up these three things first:

1. WordPress database
2. `wp-content/uploads/`
3. Current `wp-content/themes/rentup-theme/` folder

Recommended tools:

- Hosting backup snapshot
- `UpdraftPlus` or equivalent backup plugin
- Manual database export from phpMyAdmin

## Is “Replace installed with uploaded” safe?

Yes, if the ZIP only contains the theme folder and the theme code does not run automatic imports on load.

That button replaces files in:

- `wp-content/themes/rentup-theme/`

It does not directly delete or reset database content such as:

- biens / properties
- pages
- menus
- categories and taxonomies
- Polylang translations
- SEO metadata
- media library items
- users
- contact submissions
- property submissions

## What This Action Changes

- PHP templates
- CSS/JS/assets inside the theme
- theme helper code
- admin metabox code
- theme documentation files

## What This Action Does Not Change

- WordPress core
- plugins
- uploads
- database tables and saved content by itself

## Current Theme Safeguards

- No automatic page import on normal theme load
- No automatic page repair on `admin_init`
- No automatic taxonomy import on theme update
- No automatic demo blog seeding on theme update
- Manual setup actions are nonce-protected admin actions
- Manual page creation is create-only by default
- Manual repair action is explicit and intended for missing pages/templates only

## Safe Update Workflow

1. Back up database, uploads, and the current theme folder.
2. Confirm the ZIP contains only:
   - `rentup-theme/style.css`
   - `rentup-theme/functions.php`
   - `rentup-theme/index.php`
   - `rentup-theme/assets/`
   - `rentup-theme/inc/`
   - `rentup-theme/page-templates/`
   - `rentup-theme/template-parts/`
3. In WordPress admin, go to `Appearance > Themes > Add New > Upload Theme`.
4. Upload the new `rentup-theme-production.zip`.
5. When WordPress shows `Replace installed with uploaded`, continue only after backups are confirmed.
6. After replacement, open:
   - homepage
   - one property archive page
   - one single property page
   - one FR page
   - one EN page
   - admin pages for `Biens`, `Pages`, `Menus`, `Soumissions biens`, `Demandes`
7. If permalinks or templates behave oddly, visit `Settings > Permalinks` and save once.

## Post-Update Verification Checklist

Verify that all of these still exist:

- published biens
- property categories, locations, areas, features
- FR/EN linked pages
- menus and menu assignments
- media images
- Yoast / Rank Math / custom SEO meta
- contact submissions
- property submissions

Verify that none of these happened unexpectedly:

- demo posts inserted
- pages recreated without request
- page content overwritten
- translations relinked incorrectly
- property content deleted

## Rollback

If something breaks:

1. Restore the previous theme folder backup.
2. Restore the database backup only if content or settings were actually changed.
3. Clear caches.
4. Save permalinks once.

## Important Notes

- Theme replacement is normally a file-only operation.
- Database changes can still happen if a theme contains unsafe auto-run setup code.
- This theme has been hardened so setup/import actions require explicit admin action.
