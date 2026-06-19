/**
 * Front-office currency switcher (MAD / EUR / USD).
 *
 * - Reads the per-property base currency + amount from each `.js-price`
 *   element (data-amount / data-currency).
 * - Converts to the visitor's chosen currency using the rates localized in
 *   MURAILLES_CURRENCY.rates (1 unit = X MAD pivot).
 * - Formats big numbers with the correct grouping per currency.
 * - Remembers the choice in localStorage so it sticks across pages.
 *
 * No jQuery dependency — vanilla JS.
 */
(function () {
	'use strict';

	var CFG = window.MURAILLES_CURRENCY || {};
	var CURRENCIES = CFG.currencies || {};
	var RATES = CFG.rates || {};
	var DEFAULT = CFG.default || 'MAD';
	var STORAGE_KEY = 'murailles_currency';

	if (!CURRENCIES || !Object.keys(CURRENCIES).length) {
		return;
	}

	/** Read the saved currency, falling back to the site default. */
	function getActive() {
		var saved;
		try {
			saved = window.localStorage.getItem(STORAGE_KEY);
		} catch (e) {
			saved = null;
		}
		return (saved && CURRENCIES[saved]) ? saved : DEFAULT;
	}

	function setActive(code) {
		try {
			window.localStorage.setItem(STORAGE_KEY, code);
		} catch (e) {
			/* storage disabled — choice just won't persist */
		}
	}

	/** Convert an amount from one currency to another via the MAD pivot. */
	function convert(amount, from, to) {
		if (from === to) {
			return amount;
		}
		var rFrom = RATES[from] > 0 ? RATES[from] : 1;
		var rTo = RATES[to] > 0 ? RATES[to] : 1;
		return (amount * rFrom) / rTo;
	}

	/** Group a number string with a thousands separator. */
	function groupThousands(intPart, sep) {
		return intPart.replace(/\B(?=(\d{3})+(?!\d))/g, sep);
	}

	/** Format a numeric amount according to a currency's display rules. */
	function format(amount, code) {
		var c = CURRENCIES[code];
		if (!c) {
			return String(amount);
		}

		// Prices are whole amounts; converted values are rounded to the
		// currency's decimal count (0 for MAD/EUR/USD here).
		var decimals = Math.max(c.decimals || 0, 0);
		var fixed = Math.abs(amount).toFixed(decimals);
		var parts = fixed.split('.');
		var intPart = groupThousands(parts[0], c.thousands || ' ');
		var number = intPart;
		if (decimals > 0 && parts[1]) {
			number += (c.dec_point || '.') + parts[1];
		}
		if (amount < 0) {
			number = '-' + number;
		}

		if (c.position === 'before') {
			return c.symbol + number;
		}
		return number + ' ' + c.symbol;
	}

	/** Re-render every price element to the active currency. */
	function render(active) {
		var prices = document.querySelectorAll('.js-price[data-amount][data-currency]');
		for (var i = 0; i < prices.length; i++) {
			var el = prices[i];
			var base = el.getAttribute('data-currency');
			var amount = parseFloat(el.getAttribute('data-amount'));
			if (isNaN(amount)) {
				continue;
			}
			var converted = convert(amount, base, active);
			el.textContent = format(converted, active);
		}

		// Sync every switcher's active button.
		var btns = document.querySelectorAll('.murailles-currency-switcher .mcs-btn');
		for (var j = 0; j < btns.length; j++) {
			var btn = btns[j];
			var isActive = btn.getAttribute('data-currency') === active;
			btn.classList.toggle('is-active', isActive);
			btn.setAttribute('aria-pressed', isActive ? 'true' : 'false');
		}
	}

	function onClick(e) {
		var btn = e.target.closest ? e.target.closest('.mcs-btn') : null;
		if (!btn) {
			return;
		}
		var code = btn.getAttribute('data-currency');
		if (!code || !CURRENCIES[code]) {
			return;
		}
		e.preventDefault();
		setActive(code);
		render(code);
	}

	function init() {
		render(getActive());
		// Delegate clicks so switchers added later (AJAX listings) still work.
		document.addEventListener('click', onClick);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
