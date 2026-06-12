/**
 * Murailles Immobilier — Single Property page scripts
 *
 * Runs on /bien/<slug>/ and the legacy /single-property-1/ template:
 *  - Native date picker defaults + min/max enforcement
 *  - Bookmark (wishlist) toggle + Share modal
 *  - Star rating widget for the review form
 *
 * Depends on: MuraillesWC global (from wishlist-compare.js)
 */
( function () {
	'use strict';

	/* ---------- Booking dates ---------- */
	function initBookingDates() {
		var ci = document.getElementById( 'murailles-checkin' );
		var co = document.getElementById( 'murailles-checkout' );
		if ( ! ci || ! co ) return;
		var today    = new Date();
		var tomorrow = new Date( Date.now() + 86400000 );
		var nextWeek = new Date( Date.now() + 7 * 86400000 );
		var fmt = function ( d ) { return d.toISOString().split( 'T' )[ 0 ]; };
		if ( ! ci.value ) ci.value = fmt( today );
		if ( ! co.value ) co.value = fmt( nextWeek );
		ci.min = fmt( today );
		co.min = fmt( tomorrow );
		ci.addEventListener( 'change', function () {
			var next = new Date( new Date( ci.value ).getTime() + 86400000 );
			co.min = fmt( next );
			if ( new Date( co.value ) <= new Date( ci.value ) ) {
				co.value = fmt( next );
			}
		} );
	}

	/* ---------- Bookmark + Share ---------- */
	function initBookmarkShare() {
		var saveBtn  = document.querySelector( '.murailles-prop-save' );
		var shareBtn = document.querySelector( '.murailles-prop-share' );

		function buildSnapshot() {
			var pid    = saveBtn ? parseInt( saveBtn.getAttribute( 'data-murailles-id' ), 10 ) : 0;
			var titleE = document.querySelector( '.property_info_detail_wrap_first h2' );
			var addrE  = document.querySelector( '.property_info_detail_wrap_first span' );
			var imgE   = document.querySelector( '.gallery_parts .gg_single_part.left img' )
				|| document.querySelector( '.featured_slick_gallery img' );
			var beds = '', baths = '', size = '';
			document.querySelectorAll( '.prs_lists li' ).forEach( function ( li ) {
				var t = li.textContent.trim();
				if ( /Ch|Bed|Chambre/i.test( t ) )      beds = t;
				else if ( /SdB|Bath/i.test( t ) )       baths = t;
				else if ( /m²|sqft/i.test( t ) )        size = t;
			} );
			return {
				id:      pid,
				title:   titleE ? titleE.textContent.trim() : document.title,
				url:     window.location.href,
				thumb:   imgE ? imgE.src : '',
				price:   '',
				action:  '',
				address: addrE ? addrE.textContent.trim() : '',
				category:'Bien',
				beds:    beds,
				baths:   baths,
				size:    size,
			};
		}

		function refreshSaveLabel() {
			if ( ! saveBtn || ! window.MuraillesWC ) return;
			var pid = parseInt( saveBtn.getAttribute( 'data-murailles-id' ), 10 );
			var on  = window.MuraillesWC.isInWishlist( pid );
			saveBtn.classList.toggle( 'is-saved', on );
			saveBtn.style.color = on ? '#dc3545' : '';
			var labelEl = saveBtn.querySelector( '.murailles-prop-label' );
			if ( labelEl ) labelEl.textContent = on ? 'Enregistré' : 'Enregistrer';
			var icon = saveBtn.querySelector( 'i' );
			if ( icon ) icon.style.color = on ? '#dc3545' : '';
		}

		if ( saveBtn ) {
			refreshSaveLabel();
			saveBtn.addEventListener( 'click', function ( e ) {
				e.preventDefault();
				if ( ! window.MuraillesWC ) return;
				window.MuraillesWC.toggleWishlistSnap( buildSnapshot() );
				refreshSaveLabel();
			} );
		}

		if ( shareBtn ) {
			shareBtn.addEventListener( 'click', function ( e ) {
				e.preventDefault();
				openShareModal( buildSnapshot() );
			} );
		}

		function openShareModal( snap ) {
			var url   = encodeURIComponent( snap.url );
			var text  = encodeURIComponent( snap.title + ' — ' + ( snap.address || '' ) );
			var fb    = 'https://www.facebook.com/sharer/sharer.php?u=' + url;
			var tw    = 'https://twitter.com/intent/tweet?text=' + text + '&url=' + url;
			var wa    = 'https://wa.me/?text=' + text + '%20' + url;
			var mail  = 'mailto:?subject=' + text + '&body=' + url;

			var overlay = document.createElement( 'div' );
			overlay.className = 'murailles-share-overlay';
			overlay.innerHTML =
				'<div class="murailles-share-modal">'
					+ '<div class="murailles-share-head">'
						+ '<h3>Partager ce bien</h3>'
						+ '<p>' + esc( snap.title ) + '</p>'
					+ '</div>'
					+ '<div class="murailles-share-grid">'
						+ shareIcon( 'fa-brands fa-facebook-f', '#1877f2', fb,   'Facebook' )
						+ shareIcon( 'fa-brands fa-twitter',    '#1da1f2', tw,   'Twitter' )
						+ shareIcon( 'fa-brands fa-whatsapp',   '#25d366', wa,   'WhatsApp' )
						+ shareIcon( 'fa-solid fa-envelope',    '#dc3545', mail, 'E-mail' )
					+ '</div>'
					+ '<div class="murailles-share-link">'
						+ '<label>Lien direct</label>'
						+ '<div class="murailles-share-link-row">'
							+ '<input id="murailles-share-link" type="text" readonly value="' + esc( snap.url ) + '">'
							+ '<button type="button" id="murailles-share-copy">Copier</button>'
						+ '</div>'
					+ '</div>'
					+ '<div class="murailles-share-foot">'
						+ '<button type="button" id="murailles-share-close">Fermer</button>'
					+ '</div>'
				+ '</div>';
			document.body.appendChild( overlay );

			overlay.addEventListener( 'click', function ( e ) { if ( e.target === overlay ) overlay.remove(); } );
			overlay.querySelector( '#murailles-share-close' ).addEventListener( 'click', function () { overlay.remove(); } );
			overlay.querySelector( '#murailles-share-copy' ).addEventListener( 'click', function () {
				var inp = overlay.querySelector( '#murailles-share-link' );
				inp.select();
				try { document.execCommand( 'copy' ); } catch ( e ) {}
				if ( navigator.clipboard ) navigator.clipboard.writeText( inp.value );
				this.textContent = 'Copié !';
				this.classList.add( 'is-copied' );
				setTimeout( function () { overlay.remove(); }, 900 );
			} );
		}

		function shareIcon( fa, color, href, label ) {
			return '<a class="murailles-share-icon" href="' + href + '" target="_blank" rel="noopener" style="--c:' + color + ';">'
				+ '<span><i class="' + fa + '"></i></span>'
				+ label
			+ '</a>';
		}

		function esc( s ) {
			return String( s || '' ).replace( /[&<>"']/g, function ( c ) {
				return { '&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;' }[ c ];
			} );
		}
	}

	/* ---------- Star rating widget ---------- */
	function initStarRating() {
		var widget = document.getElementById( 'murailles-stars-widget' );
		if ( ! widget ) return;
		var input = document.getElementById( 'murailles-rating-input' );
		var stars = widget.querySelectorAll( '.murailles-star' );
		var hover = function ( n ) {
			stars.forEach( function ( s, i ) {
				s.style.color = i < n ? '#f9b704' : '#d0d4d8';
			} );
		};
		var current = function () { return parseInt( input.value, 10 ) || 0; };
		stars.forEach( function ( s, i ) {
			s.addEventListener( 'mouseenter', function () { hover( i + 1 ); } );
			s.addEventListener( 'click',      function () { input.value = i + 1; hover( i + 1 ); } );
		} );
		widget.addEventListener( 'mouseleave', function () { hover( current() ); } );
		hover( current() );
	}

	/* ---------- Boot ---------- */
	function boot() {
		initBookingDates();
		initBookmarkShare();
		initStarRating();
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', boot );
	} else {
		boot();
	}
} )();
