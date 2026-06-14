/**
 * Murailles Immobilier — Custom Select Enhancer
 *
 * Replaces every native <select> on the page with a Bootstrap-styled
 * dropdown that matches the "Trier par" component. The underlying
 * <select> stays in the DOM (visually hidden) so form submission and
 * any existing JS reading select.value keep working.
 *
 * Opt-out: add data-murailles-skip="1" to the <select>.
 */
( function () {
	'use strict';

	// Module-level handle to the currently-open dropdown's close() so the
	// global closeAll() can release per-instance scroll/resize listeners.
	var activeClose = null;

	function enhanceSelect( select ) {
		if ( select.dataset.muraillesEnhanced === '1' ) { return; }
		if ( select.getAttribute( 'data-murailles-skip' ) === '1' ) { return; }
		if ( select.multiple || select.size > 1 ) { return; }

		select.dataset.muraillesEnhanced = '1';

		var wrap = document.createElement( 'div' );
		wrap.className = 'murailles-select';
		select.parentNode.insertBefore( wrap, select );
		wrap.appendChild( select );

		var trigger = document.createElement( 'button' );
		trigger.type = 'button';
		trigger.className = 'murailles-select__trigger';
		trigger.setAttribute( 'aria-haspopup', 'listbox' );
		trigger.setAttribute( 'aria-expanded', 'false' );

		var labelEl = document.createElement( 'span' );
		labelEl.className = 'murailles-select__label';
		trigger.appendChild( labelEl );

		// chevron (SVG, inherits color)
		trigger.insertAdjacentHTML(
			'beforeend',
			'<svg class="murailles-select__chevron" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="2,4 6,8 10,4"></polyline></svg>'
		);

		var menu = document.createElement( 'div' );
		menu.className = 'murailles-select__menu';
		menu.setAttribute( 'role', 'listbox' );

		Array.prototype.forEach.call( select.options, function ( opt, idx ) {
			// Skip rows that are pure placeholders with no visible label —
			// e.g. <option value="">&nbsp;</option> or <option value=""></option>.
			// The empty value still acts as the default in the trigger label,
			// but it shouldn't appear as a clickable empty row in the menu.
			var labelText = ( opt.text || '' ).replace( / /g, ' ' ).trim();
			if ( opt.value === '' && labelText === '' ) {
				return;
			}
			var item = document.createElement( 'div' );
			item.className = 'murailles-select__option';
			item.setAttribute( 'role', 'option' );
			item.dataset.value = opt.value;
			item.dataset.index = idx;
			item.textContent = opt.text;
			if ( opt.value === '' || opt.value === '0' ) {
				item.classList.add( 'is-placeholder' );
			}
			if ( opt.selected ) {
				item.classList.add( 'is-selected' );
			}
			menu.appendChild( item );
		} );

		wrap.appendChild( trigger );
		// Menu is portaled to <body> with position:fixed so it escapes every
		// parent stacking context (e.g. ._awards_group with z-index:3 was
		// covering the popover regardless of how high we set z-index on the
		// trigger's ancestors).
		menu.classList.add( 'murailles-select__menu--portal' );
		// Tag the portaled menu with a hint so CSS can apply scoped styling
		// (e.g. hero search bar gets a larger min-width and padding).
		if ( select.closest( '.full_search_box' ) ) {
			menu.setAttribute( 'data-murailles-from', 'hero' );
		}
		document.body.appendChild( menu );

		function positionMenu() {
			var rect = trigger.getBoundingClientRect();
			menu.style.top = ( rect.bottom + 6 ) + 'px';
			menu.style.left = rect.left + 'px';
			// Use trigger width but allow grow up to the viewport edge for
			// long option labels like "De 500 000 € à 1 000 000 €".
			var minWidth = Math.max( rect.width, 220 );
			var maxAvail = window.innerWidth - rect.left - 16;
			menu.style.minWidth = minWidth + 'px';
			menu.style.maxWidth = maxAvail + 'px';
		}

		function syncLabel() {
			var opt = select.options[ select.selectedIndex ];
			if ( ! opt ) {
				labelEl.textContent = '';
				labelEl.classList.add( 'murailles-select__label--placeholder' );
				return;
			}
			labelEl.textContent = opt.text;
			var isPlaceholder = ( opt.value === '' || opt.value === '0' );
			labelEl.classList.toggle( 'murailles-select__label--placeholder', isPlaceholder );
		}

		function open() {
			closeAll();
			wrap.classList.add( 'is-open' );
			menu.classList.add( 'is-open' );
			trigger.setAttribute( 'aria-expanded', 'true' );
			positionMenu();
			window.addEventListener( 'scroll', positionMenu, true );
			window.addEventListener( 'resize', positionMenu );
			activeClose = close;
			// scroll selected into view
			var sel = menu.querySelector( '.is-selected' );
			if ( sel ) { sel.scrollIntoView( { block: 'nearest' } ); }
		}

		function close() {
			wrap.classList.remove( 'is-open' );
			menu.classList.remove( 'is-open' );
			trigger.setAttribute( 'aria-expanded', 'false' );
			window.removeEventListener( 'scroll', positionMenu, true );
			window.removeEventListener( 'resize', positionMenu );
			if ( activeClose === close ) { activeClose = null; }
		}

		function selectValue( value ) {
			select.value = value;
			Array.prototype.forEach.call( menu.children, function ( item ) {
				item.classList.toggle( 'is-selected', item.dataset.value === value );
			} );
			syncLabel();
			// Fire native events so any other listeners (e.g. on the page) react
			select.dispatchEvent( new Event( 'change', { bubbles: true } ) );
			select.dispatchEvent( new Event( 'input', { bubbles: true } ) );
		}

		trigger.addEventListener( 'click', function ( e ) {
			e.preventDefault();
			e.stopPropagation();
			if ( wrap.classList.contains( 'is-open' ) ) { close(); } else { open(); }
		} );

		menu.addEventListener( 'click', function ( e ) {
			var item = e.target.closest( '.murailles-select__option' );
			if ( ! item ) { return; }
			selectValue( item.dataset.value );
			close();
		} );

		// Keyboard nav on the trigger
		trigger.addEventListener( 'keydown', function ( e ) {
			var keys = [ 'ArrowDown', 'ArrowUp', 'Enter', ' ', 'Escape' ];
			if ( keys.indexOf( e.key ) === -1 ) { return; }
			e.preventDefault();
			if ( e.key === 'Escape' ) { close(); return; }
			if ( ! wrap.classList.contains( 'is-open' ) ) { open(); return; }
			if ( e.key === 'ArrowDown' || e.key === 'ArrowUp' ) {
				var items = menu.querySelectorAll( '.murailles-select__option' );
				var current = menu.querySelector( '.is-focused' ) || menu.querySelector( '.is-selected' );
				var idx = current ? Array.prototype.indexOf.call( items, current ) : -1;
				idx = e.key === 'ArrowDown' ? Math.min( items.length - 1, idx + 1 ) : Math.max( 0, idx - 1 );
				items.forEach( function ( i ) { i.classList.remove( 'is-focused' ); } );
				if ( items[ idx ] ) {
					items[ idx ].classList.add( 'is-focused' );
					items[ idx ].scrollIntoView( { block: 'nearest' } );
				}
			}
			if ( e.key === 'Enter' ) {
				var focused = menu.querySelector( '.is-focused' );
				if ( focused ) { selectValue( focused.dataset.value ); }
				close();
			}
		} );

		// React to programmatic changes to the <select>
		select.addEventListener( 'change', function () {
			Array.prototype.forEach.call( menu.children, function ( item ) {
				item.classList.toggle( 'is-selected', item.dataset.value === select.value );
			} );
			syncLabel();
		} );

		syncLabel();
	}

	function closeAll() {
		// Invoke the active instance's close() so its scroll/resize listeners
		// are removed; the class toggling below is a defensive fallback.
		if ( activeClose ) { activeClose(); }
		document.querySelectorAll( '.murailles-select.is-open' ).forEach( function ( el ) {
			el.classList.remove( 'is-open' );
			var t = el.querySelector( '.murailles-select__trigger' );
			if ( t ) { t.setAttribute( 'aria-expanded', 'false' ); }
		} );
		document.querySelectorAll( '.murailles-select__menu.is-open' ).forEach( function ( m ) {
			m.classList.remove( 'is-open' );
		} );
	}

	function enhanceAll( root ) {
		( root || document ).querySelectorAll( 'select.form-control, select.form-select' ).forEach( enhanceSelect );
	}

	document.addEventListener( 'click', function ( e ) {
		// Don't close when clicking inside a trigger wrapper OR inside a portaled menu.
		if ( e.target.closest( '.murailles-select' ) ) { return; }
		if ( e.target.closest( '.murailles-select__menu' ) ) { return; }
		closeAll();
	} );

	document.addEventListener( 'keydown', function ( e ) {
		if ( e.key === 'Escape' ) { closeAll(); }
	} );

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', function () { enhanceAll(); } );
	} else {
		enhanceAll();
	}

	// Watch for selects added later (AJAX, etc.)
	if ( 'MutationObserver' in window ) {
		var mo = new MutationObserver( function ( muts ) {
			muts.forEach( function ( m ) {
				m.addedNodes.forEach( function ( n ) {
					if ( n.nodeType !== 1 ) { return; }
					if ( n.matches && n.matches( 'select.form-control, select.form-select' ) ) {
						enhanceSelect( n );
					}
					if ( n.querySelectorAll ) {
						enhanceAll( n );
					}
				} );
			} );
		} );
		mo.observe( document.body, { childList: true, subtree: true } );
	}

	// Public API for re-enhancement after partial renders
	window.MuraillesDropdown = { enhanceAll: enhanceAll, enhance: enhanceSelect };
} )();
