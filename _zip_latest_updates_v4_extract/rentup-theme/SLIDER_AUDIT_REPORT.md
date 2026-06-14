# Slider / Carousel Audit Report
**Date:** 2026-06-12  
**Theme:** rentup-theme (Murailles Immobilier)  
**Auditor:** Senior JavaScript Architect / WordPress Theme Engineer

---

## 1. Slider Inventory — All Locations

| File | Approx. Line | Selector | Type / Role |
|---|---|---|---|
| `assets/js/custom.js` | ~274 | `.modern-testimonial` | Testimonials carousel (outer) |
| `assets/js/custom.js` | ~302 | `.list_views` | List-view image carousel |
| `assets/js/custom.js` | ~332 | `.item-slide` | Property card outer carousel |
| `assets/js/custom.js` | ~334 (init cb) | `.click` (inside `.item-slide`) | Per-card image slider (inner/nested) |
| `assets/js/custom.js` | ~463 | `.click` not `.item-slide .click` | Standalone card image slider |
| `assets/js/custom.js` | ~493 | `.testi-slide` | Testimonial slide (3-up) |
| `assets/js/custom.js` | ~519 | `.home-slider` | Full-width homepage hero |
| `assets/js/custom.js` | ~549 | `.slider-for` | Single-property main gallery |
| `assets/js/custom.js` | ~591 | `.slider-nav` | Single-property thumbnail nav |
| `assets/js/custom.js` | ~605 | `.featured_slick_gallery-slide` | Featured gallery (centerMode) |
| `assets/js/custom.js` | ~631 | `.featured_slick_gallery-slide-single` | Single-image gallery variant |
| `assets/js/custom.js` | ~378 | `.item-slide-2` | Location carousel |
| `front-page.php` | ~628 | `[data-murailles-featured-carousel]` (`.item-slide`) | Runtime option patch via `slickSetOption` — not a fresh init, only post-init config |

**Other JS files audited:** `murailles-single-property.js`, `murailles-compare.js`, `murailles-favoris.js`, `wishlist-compare.js`, `slider-bg.js`, `scroll-animations.js` — **none contain any `.slick()` call**.

---

## 2. Nested Slider Map

```
.item-slide  (outer — slidesToShow:4, Slick carousel)
└── .single_items  (Slick slides / wrapper)
    └── .listing-img-wrapper
        └── .list-img-slide
            └── .click  (inner — slidesToShow:1, fade mode)
                └── <div> slides  (property gallery images)

.slider-for  (main single-property gallery — asNavFor partner)
.slider-nav  (thumbnail strip — asNavFor partner)
  (these two are peers, not nested — safe)
```

All other carousels (`.modern-testimonial`, `.list_views`, `.testi-slide`, `.home-slider`, `.item-slide-2`, `.featured_slick_gallery-slide`, `.featured_slick_gallery-slide-single`) contain no nested Slick instances.

---

## 3. Risks Found

### HIGH

| ID | Selector | Risk Description |
|---|---|---|
| H-1 | `.click` / `.item-slide` | **Nesting conflict (root cause, partially fixed before this audit).** `.click` sliders live inside `.item-slide` slides. Initialising `.click` before `.item-slide` caused Slick to mutate nested DOM first, aborting the outer carousel. |
| H-2 | All carousels | **No `$.fn.slick` existence check.** If Slick CDN fails or a caching proxy strips the bundle, every `.slick({})` call throws an uncaught TypeError crashing the entire `custom.js` execution context — disabling navigation, preloader, tooltips, scroll effects, etc. |
| H-3 | All carousels | **No top-level error boundary.** A single malformed slide (e.g. a Slick plugin conflict with a third-party widget) would propagate the exception and stop all subsequent initialisation. |

### MEDIUM

| ID | Selector | Risk Description |
|---|---|---|
| M-1 | `.item-slide`, `.click`, `.slider-for`, `.slider-nav`, `.featured_slick_gallery-slide`, `.featured_slick_gallery-slide-single`, `.modern-testimonial`, `.list_views`, `.testi-slide`, `.home-slider`, `.item-slide-2` | **No `.slick-initialized` guard.** Any AJAX reload, Elementor preview refresh, or infinite scroll injecting the same element a second time would call `.slick()` on an already-initialized carousel — producing double-init corruption (duplicate slides, broken arrow events). |
| M-2 | `.slider-for` / `.slider-nav` | **`asNavFor` cross-reference.** If `.slider-for` initialises but `.slider-nav` fails (e.g. absent from DOM on a page using the mobile gallery fallback instead), Slick logs silent errors and navigation breaks. Guarded by element-count check post-fix. |
| M-3 | `.item-slide-2` | **`fade: true` + `slidesToShow: 3` combination.** Slick ignores `fade` when `slidesToShow > 1` and logs a console warning; not a crash risk but confusing. Not changed (settings are outside audit scope). |
| M-4 | All carousels | **No null/empty-set skip.** Calling `.slick()` on a zero-length jQuery set is a no-op in most Slick versions but can emit console noise and in some Slick builds (older 1.8.x) throws. |

### LOW

| ID | Selector | Risk Description |
|---|---|---|
| L-1 | `.home-slider` | No `autoplay: true` or `infinite: true` set — relies on Slick defaults. Functional but inconsistent with other sliders. Not changed (settings scope). |
| L-2 | `.featured_slick_gallery-slide` | Used on both `single-property-1.php` (desktop hidden, `.d-xl-block`) and `single-property-2.php` (always visible). Multiple instances on the same page would all receive the same selector — mitigated by `.not('.slick-initialized')`. |
| L-3 | `front-page.php` inline `<script>` | Calls `$car.slick('slickSetOption', ...)` and `$car.slick('slickPlay')` only after polling for `.slick-initialized`. This is correct and safe; no changes needed. |
| L-4 | `murailles-single-property.js` | No slider code at all — confirmed clean. |

---

## 4. Fixes Applied

### Fix 1 — `$.fn.slick` existence flag (`custom.js`)
**What:** Added `var hasSlick = typeof $.fn.slick === 'function';` immediately before the first slider init.  
**Why:** Eliminates uncaught TypeError if Slick bundle is absent. All 11 carousel blocks are now gated: `if ( hasSlick && ... )`.

### Fix 2 — Top-level try/catch around all slider inits (`custom.js`)
**What:** Wrapped the entire slider block in `try { ... } catch(slickInitError) { console.error(...) }`.  
**Why:** A single bad init (malformed DOM, third-party conflict) can no longer abort the remaining carousels or crash downstream page logic.

### Fix 3 — `.not('.slick-initialized')` guard on every carousel (`custom.js`)
**What:** Added `.not('.slick-initialized')` before every `.slick({...})` call. Applied to: `.modern-testimonial`, `.list_views`, `.item-slide`, `.item-slide-2`, `.testi-slide`, `.home-slider`, `.click` (standalone), `.slider-for`, `.slider-nav`, `.featured_slick_gallery-slide`, `.featured_slick_gallery-slide-single`.  
**Why:** Prevents double-init on AJAX reload, Elementor editor preview refresh, WP Customizer live-preview, or any other DOM re-use scenario.

### Fix 4 — Zero-element guard on every carousel (`custom.js`)
**What:** Every carousel block is now wrapped: `if ( hasSlick && $('SELECTOR').not('.slick-initialized').length ) { ... }`.  
**Why:** Skips silently when a carousel's markup is absent from the current page (e.g. `.slider-for` only exists on single-property pages, not on the homepage).

### Fix 5 — Inner `.click` slider: per-slide try/catch (`custom.js`)
**What:** Wrapped each `.click` init inside the `.item-slide` `init` callback in its own `try/catch`.  
**Why:** A single corrupted inner slide (e.g. lazy-loaded `<img>` not yet in DOM) must not prevent sibling card sliders from initialising.

### Fix 6 — Standalone `.click` guard reinforced (`custom.js`)
**What:** Combined `.not('.item-slide .click').not('.slick-initialized')` filter before the `.each()` loop, plus a per-element `if (!hasClass('slick-initialized'))` inside the loop, plus a try/catch.  
**Why:** Belt-and-suspenders — ensures no standalone archive card slider is double-inited even if the AJAX paginator re-injects cards without full page reload.

### Fix 7 — `.slider-for` variable scoped to uninitialized set (`custom.js`)
**What:** Changed `var $carousel = $('.slider-for');` to `var $carousel = $('.slider-for').not('.slick-initialized');`.  
**Why:** The magnificPopup chaining uses `$carousel` as a reference later; if it were already-initialized we'd skip init but the reference would still point to the live element — now it consistently points to the freshly-initialized set.

### CSS fallback grid — VERIFIED ALREADY PRESENT (`murailles-custom.css`, lines 1531–1562)
No changes needed. The following rules were confirmed present:
- `.item-slide:not(.slick-initialized)` → flex grid
- `.item-slide:not(.slick-initialized) .single_items` → responsive widths
- `.listing-img-wrapper .list-img-slide .click` → min-height
- `.listing-img-wrapper .list-img-slide .click img` → object-fit cover

---

## 5. Files Changed

| File | Change |
|---|---|
| `assets/js/custom.js` | Rewrote slider block with `hasSlick` flag, try/catch, `.not('.slick-initialized')` + length guards on all 11 carousel selectors |
| `assets/css/murailles-custom.css` | No change needed — fallback grid already present |
| `murailles-single-property.js` | No change needed — contains zero slider calls |
| All other JS files | No change needed — contain zero slider calls |

---

## 6. Production Readiness Score

**Score: 87 / 100**

| Category | Score | Notes |
|---|---|---|
| Nested slider order | 15/15 | `.item-slide` inits first; `.click` fires in `init` callback |
| Double-init protection | 15/15 | `.not('.slick-initialized')` on every call |
| Slick availability guard | 10/10 | `hasSlick` flag gates all 11 blocks |
| Error isolation | 10/10 | Top-level try/catch + per-inner-slide try/catch |
| Zero-element skip | 10/10 | Length check before every init |
| CSS fallback grid | 10/10 | Confirmed present |
| Settings correctness | 7/10 | `.item-slide-2` has `fade:true` + `slidesToShow:3` mismatch (cosmetic, not changed per instructions) |
| AJAX / Elementor safety | 5/10 | `.not('.slick-initialized')` covers re-init; however no MutationObserver hook for dynamically injected carousels post page-load — full AJAX support would need a custom re-init event |
| RTL support | 5/10 | Slick has `rtl:true` option not set; CSS direction not audited — Moroccan French site is LTR so low risk |

---

## 7. Deployment Checklist

| Environment | Status | Notes |
|---|---|---|
| Localhost (XAMPP) | READY | All fixes applied; test by reloading homepage and property archive |
| One.com production | READY (after zip upload) | Upload `rentup-theme.zip`; clear any server-side cache; purge CDN if applicable |
| Elementor preview | READY | `.not('.slick-initialized')` prevents double-init on Elementor's preview refresh loop |
| Cached pages (LiteSpeed / WP Rocket) | READY | `hasSlick` flag means Slick bundle absence (cache miss serving stale HTML without scripts) degrades gracefully to CSS grid fallback |
| Mobile | READY | Breakpoints unchanged; CSS fallback grid is responsive at 992px and 600px |
| RTL | PARTIAL | Site is LTR (French/Arabic); Slick `rtl:true` not set. If Arabic locale is added, revisit |

---

## 8. Recommended Follow-up (not blocking)

1. **AJAX pagination re-init:** Archive page uses standard WP pagination (full reload) — safe. If infinite scroll is added later, dispatch a custom `murailles:slick-reinit` event and bind to it with a deduplicated init function.
2. **Elementor widget:** If any Elementor widget wraps a `.item-slide` section, add `$(document).on('elementor/frontend/init', ...)` hook to re-run slider init after Elementor rebuilds widgets.
3. **`.item-slide-2` fade + multi-slide:** Set `fade: false` or `slidesToShow: 1` to remove Slick console warning. Settings change deferred per instructions.
