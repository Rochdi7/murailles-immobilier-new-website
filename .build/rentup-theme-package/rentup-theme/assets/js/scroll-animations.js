/**
 * Murailles Immobilier — Scroll Animations
 * Observes <section> and <footer> containers.
 * Sets data-anim-state="in" when they enter the viewport.
 * CSS keyframes animate the content inside. Nothing hidden on load.
 *
 * Homepage : skips the first <section> (full-viewport hero banner).
 * Inner pages: .page-title is a <div>, so all <section> tags are content
 *              and should all animate — skippedFirst stays false until the
 *              first real section is seen, which may already be in view,
 *              so we reveal it immediately via setAttribute.
 */
(function () {
    'use strict';

    if (document.body.classList.contains('wp-admin')) return;
    if (document.body.id === 'login') return;
    if (!('IntersectionObserver' in window)) return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    var isHomepage = document.body.classList.contains('home') ||
                     document.body.classList.contains('front-page') ||
                     document.querySelector('.hero_banner') !== null;

    var obs = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) return;
            entry.target.setAttribute('data-anim-state', 'in');
            obs.unobserve(entry.target);
        });
    }, { threshold: 0.04 });

    var sections = document.querySelectorAll('section, footer');
    var heroSkipped = false;

    sections.forEach(function (el) {
        /* On homepage only: skip the very first <section> (hero banner) */
        if (isHomepage && !heroSkipped && el.tagName === 'SECTION') {
            heroSkipped = true;
            return;
        }
        /* If section is already in viewport at load, reveal immediately */
        var rect = el.getBoundingClientRect();
        var vh   = window.innerHeight || document.documentElement.clientHeight;
        if (rect.top < vh && rect.bottom > 0) {
            el.setAttribute('data-anim-state', 'in');
        } else {
            obs.observe(el);
        }
    });

}());
