/**
 * Murailles Immobilier — Favoris page renderer
 *
 * Reads localStorage snapshots via window.MuraillesWC and renders the favoris grid.
 * Loaded only on the page that uses the `favoris.php` template (auto-detected by DOM).
 */
( function () {
	'use strict';

	function escapeHtml( s ) {
		return String( s || '' ).replace( /[&<>"']/g, function ( c ) {
			return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[ c ];
		} );
	}

	function fallbackThumb() {
		return 'data:image/svg+xml;utf8,' + encodeURIComponent(
			'<svg xmlns="http://www.w3.org/2000/svg" width="400" height="200" viewBox="0 0 400 200"><rect width="400" height="200" fill="%23e9ecef"/><text x="200" y="105" text-anchor="middle" fill="%23adb5bd" font-family="Arial" font-size="14">Aucune image disponible</text></svg>'
		);
	}

	function render() {
		var list    = ( window.MuraillesWC && window.MuraillesWC.getWishlist ) ? window.MuraillesWC.getWishlist() : [];
		var listEl  = document.getElementById( 'murailles-favoris-list' );
		var empty   = document.getElementById( 'murailles-favoris-empty' );
		var actions = document.getElementById( 'murailles-favoris-actions' );
		if ( ! listEl ) return; // not on this page
		if ( ! list.length ) {
			if ( empty )   empty.style.display   = 'block';
			if ( actions ) actions.style.display = 'none';
			listEl.innerHTML = '';
			return;
		}
		if ( empty )   empty.style.display   = 'none';
		if ( actions ) actions.style.display = 'block';
		listEl.innerHTML = list.map( function ( p ) {
			var thumb = ( p.thumb && p.thumb.length > 4 ) ? p.thumb : fallbackThumb();
			var title = p.title || 'Bien sans titre';
			var url   = p.url && p.url !== '#' ? p.url : '#';
			return '<div class="col-lg-4 col-md-6 col-sm-12" data-murailles-id="' + p.id + '">'
				+ '<div class="property-listing">'
					+ '<div class="listing-img-wrapper">'
						+ ( p.action ? '<div class="_exlio_125">' + escapeHtml( p.action ) + '</div>' : '' )
						+ '<a href="' + escapeHtml( url ) + '"><img src="' + escapeHtml( thumb ) + '" alt=""></a>'
					+ '</div>'
					+ '<div class="fav-card-body">'
						+ '<div class="fav-card-top">'
							+ ( p.category ? '<span class="fav-category">' + escapeHtml( p.category ) + '</span>' : '<span></span>' )
							+ ( p.price    ? '<span class="fav-price">'    + escapeHtml( p.price )    + '</span>' : '' )
						+ '</div>'
						+ '<h4 class="fav-title"><a href="' + escapeHtml( url ) + '">' + escapeHtml( title ) + '</a></h4>'
						+ '<div class="fav-specs">'
							+ ( p.beds  ? '<span><i class="fa-solid fa-bed"></i>' + escapeHtml( ( p.beds  || '' ).replace( /\s+/g, ' ' ).trim() ) + '</span>' : '' )
							+ ( p.baths ? '<span><i class="fa-solid fa-bath"></i>' + escapeHtml( ( p.baths || '' ).replace( /\s+/g, ' ' ).trim() ) + '</span>' : '' )
							+ ( p.size  ? '<span><i class="fa-solid fa-expand"></i>' + escapeHtml( ( p.size  || '' ).replace( /\s+/g, ' ' ).trim() ) + '</span>' : '' )
						+ '</div>'
					+ '</div>'
					+ '<div class="fav-card-footer">'
						+ '<div class="fav-location"><i class="fa-solid fa-location-dot"></i>' + escapeHtml( p.address || '—' ) + '</div>'
						+ '<button type="button" class="btn btn-sm btn-outline-danger murailles-remove-fav" data-id="' + p.id + '">'
							+ '<i class="fa-solid fa-trash"></i> Retirer'
						+ '</button>'
					+ '</div>'
				+ '</div>'
			+ '</div>';
		} ).join( '' );

		listEl.querySelectorAll( '.murailles-remove-fav' ).forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				var id   = parseInt( btn.dataset.id, 10 );
				var card = btn.closest( '[data-murailles-id]' );
				window.MuraillesWC.removeFromWishlist( id );
				card.style.transition = 'opacity .3s';
				card.style.opacity = '0';
				setTimeout( render, 300 );
			} );
		} );
	}

	function bindActions() {
		var clear = document.getElementById( 'murailles-favoris-clear' );
		if ( clear ) {
			clear.addEventListener( 'click', function () {
				if ( ! confirm( 'Vider toute la liste de favoris ?' ) ) return;
				if ( window.MuraillesWC && window.MuraillesWC.clearWishlist ) {
					window.MuraillesWC.clearWishlist();
					render();
				}
			} );
		}
	}

	function boot() { render(); bindActions(); }

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', boot );
	} else {
		boot();
	}
} )();
