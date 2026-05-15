/**
 * Murailles Immobilier — Compare Property page renderer
 *
 * Reads localStorage compare snapshots from window.MuraillesWC and renders
 * the side-by-side comparison table.
 */
( function () {
	'use strict';

	function escapeHtml( s ) {
		return String( s || '' ).replace( /[&<>"']/g, function ( c ) {
			return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[ c ];
		} );
	}
	function val( v ) { return ( v && String( v ).trim() ) ? v : '—'; }

	function render() {
		var props   = ( window.MuraillesWC && window.MuraillesWC.getCompare ) ? window.MuraillesWC.getCompare() : [];
		var empty   = document.getElementById( 'murailles-compare-empty' );
		var content = document.getElementById( 'murailles-compare-content' );
		if ( ! empty || ! content ) return; // not on this page

		if ( ! props.length ) {
			empty.style.display   = 'block';
			content.style.display = 'none';
			return;
		}
		empty.style.display   = 'none';
		content.style.display = 'block';

		var fallback = 'data:image/svg+xml;utf8,' + encodeURIComponent(
			'<svg xmlns="http://www.w3.org/2000/svg" width="240" height="140" viewBox="0 0 240 140"><rect width="240" height="140" fill="%23e9ecef"/><text x="120" y="74" text-anchor="middle" fill="%23adb5bd" font-family="Arial" font-size="13">Aucune image</text></svg>'
		);
		var headers = '<th style="width:200px;">Critère</th>'
			+ props.map( function ( p ) {
				var thumb = ( p.thumb && p.thumb.length > 4 ) ? p.thumb : fallback;
				var title = p.title || 'Bien sans titre';
				return '<th class="murailles-compare-th">'
					+ '<img src="' + escapeHtml( thumb ) + '" alt="">'
					+ '<h4>' + escapeHtml( title ) + '</h4>'
					+ '<div class="murailles-compare-th-price">' + escapeHtml( val( p.price ) ) + '</div>'
					+ '<a class="murailles-compare-th-link" href="' + escapeHtml( p.url || '#' ) + '">Voir le bien</a>'
					+ '</th>';
			} ).join( '' );
		document.getElementById( 'murailles-compare-headers' ).innerHTML = headers;

		var rows = [
			[ 'Statut',          'action' ],
			[ 'Type',            'category' ],
			[ 'Adresse',         'address' ],
			[ 'Prix',            'price' ],
			[ 'Chambres',        'beds' ],
			[ 'Salles de bain',  'baths' ],
			[ 'Surface',         'size' ],
		];
		document.getElementById( 'murailles-compare-rows' ).innerHTML = rows.map( function ( r ) {
			return '<tr><td class="murailles-compare-row-label">' + r[ 0 ] + '</td>'
				+ props.map( function ( p ) {
					var v = val( p[ r[ 1 ] ] );
					if ( r[ 1 ] === 'price' ) {
						v = '<strong class="murailles-compare-row-price">' + escapeHtml( v ) + '</strong>';
					} else {
						v = escapeHtml( v );
					}
					return '<td>' + v + '</td>';
				} ).join( '' )
				+ '</tr>';
		} ).join( '' );
	}

	function boot() {
		render();
		var clear = document.getElementById( 'murailles-compare-clear' );
		if ( clear ) {
			clear.addEventListener( 'click', function () {
				if ( window.MuraillesWC && window.MuraillesWC.clearCompare ) {
					window.MuraillesWC.clearCompare();
					render();
				}
			} );
		}
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', boot );
	} else {
		boot();
	}
} )();
