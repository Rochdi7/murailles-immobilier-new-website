/**
 * Wishlist + Compare — fully client-side state in localStorage.
 *
 * Storage shape (objects, not bare ids — so demo cards without a DB id still work):
 *   murailles_wishlist : [ { id, title, price, thumb, url, address, beds, baths, size, category } ]
 *   murailles_compare  : [ { ...same shape... } ]  // max 2
 *
 * Card identity:
 *   - Real WP properties carry data-murailles-id on the wrapper (server-side $pid).
 *   - Demo cards get a stable synth id stamped at init time, derived from
 *     title+price+addr+idx so each card has a unique signature.
 */
( function () {
	'use strict';

	var WC = window.MuraillesWC || { ajax_url: '/wp-admin/admin-ajax.php', max_compare: 2, i18n: {} };
	var I  = WC.i18n;

	/* ---------- storage helpers ---------- */
	function read( key ) {
		try {
			var v = JSON.parse( localStorage.getItem( key ) ) || [];
			// Migration from old format (bare ids) → new (objects)
			if ( v.length && typeof v[ 0 ] !== 'object' ) {
				return v.map( function ( id ) { return { id: id }; } );
			}
			return v;
		} catch ( e ) { return []; }
	}
	function write( key, list ) {
		try { localStorage.setItem( key, JSON.stringify( list ) ); }
		catch ( e ) {}
	}
	function getWishlist() { return read( 'murailles_wishlist' ); }
	function setWishlist( v ) { write( 'murailles_wishlist', v ); refreshWishlistUI(); refreshFloatingFavoris(); }
	function getCompare()  { return read( 'murailles_compare' ); }
	function setCompare( v ) { write( 'murailles_compare', v ); refreshCompareUI(); refreshFloatingCompare(); }

	/* ---------- toast ---------- */
	function toast( msg, type ) {
		var t = document.createElement( 'div' );
		t.textContent = msg;
		t.style.cssText = 'position:fixed;z-index:99999;left:50%;bottom:32px;transform:translateX(-50%);background:'
			+ ( type === 'error' ? '#dc3545' : '#1a2332' )
			+ ';color:#fff;padding:12px 24px;border-radius:8px;font-weight:600;font-size:14px;box-shadow:0 8px 24px rgba(0,0,0,0.2);opacity:0;transition:opacity .3s;';
		document.body.appendChild( t );
		requestAnimationFrame( function () { t.style.opacity = '1'; } );
		setTimeout( function () {
			t.style.opacity = '0';
			setTimeout( function () { t.remove(); }, 300 );
		}, 2400 );
	}

	/* ---------- hash + card identity ---------- */
	function hashCode( str ) {
		var h = 0;
		for ( var i = 0; i < ( str || '' ).length; i++ ) {
			h = ( ( h << 5 ) - h + str.charCodeAt( i ) ) | 0;
		}
		return Math.abs( h );
	}

	function stampCardIds() {
		document.querySelectorAll( '.property-listing' ).forEach( function ( card, idx ) {
			if ( card.closest( '[data-murailles-id]' ) ) return;
			var title = ( card.querySelector( '.listing-name a, .listing-name, h4 a, h4' ) || {} ).textContent || '';
			var price = ( card.querySelector( '.listing-card-info-price' ) || {} ).textContent || '';
			var addr  = ( card.querySelector( '.foot-location' ) || {} ).textContent || '';
			var sig   = title.trim() + '|' + price.trim() + '|' + addr.trim() + '|' + idx;
			var id    = hashCode( sig );
			var target = card.closest( '.col-lg-4, .col-lg-6, .col-md-4, .col-md-6, .col-sm-12' ) || card;
			target.setAttribute( 'data-murailles-id', id );
		} );
	}

	function getCardId( el ) {
		var card = el.closest( '[data-murailles-id]' );
		if ( card && card.dataset.muraillesId ) {
			return parseInt( card.dataset.muraillesId, 10 );
		}
		return null;
	}

	/**
	 * Pick the best real image for a card, skipping Slick clones and
	 * lazy-loaded srcs that aren't populated yet.
	 */
	function pickRealImage( card ) {
		var imgs = card.querySelectorAll( '.listing-img-wrapper img, .gtid_blog_thumb img, img' );
		for ( var i = 0; i < imgs.length; i++ ) {
			var im = imgs[ i ];
			// Skip Slick-cloned slides (aria-hidden ancestor) and decorative icons
			if ( im.closest( '.slick-cloned' ) ) continue;
			if ( im.width && im.width < 30 ) continue; // bed/bath/pin icons
			var src = im.getAttribute( 'src' ) || im.getAttribute( 'data-src' ) || im.getAttribute( 'data-lazy-src' );
			if ( src && src.length > 4 && src.indexOf( 'data:' ) !== 0 ) {
				return src;
			}
		}
		return '';
	}

	/**
	 * Build a snapshot object from the card the element belongs to.
	 * Used at save time so the compare/favoris pages can render without a DB lookup.
	 */
	function getCardSnapshot( el ) {
		var wrapper = el.closest( '[data-murailles-id]' );
		if ( ! wrapper ) return null;
		var card = wrapper.querySelector( '.property-listing' ) || wrapper;
		var id   = parseInt( wrapper.dataset.muraillesId, 10 );

		// Title — try listing-name link first, then plain h4
		var titleEl = card.querySelector( '.listing-name .prt-link-detail' )
			|| card.querySelector( '.listing-name a' )
			|| card.querySelector( '.listing-name' )
			|| card.querySelector( 'h4 a' )
			|| card.querySelector( 'h4' );

		// URL — prefer the detail link on the title, fall back to first non-hash anchor
		var urlEl = card.querySelector( '.prt-link-detail' )
			|| card.querySelector( '.listing-name a' )
			|| card.querySelector( 'a[href*="single-property"]' )
			|| card.querySelector( 'a[href]:not([href="#"])' );

		var priceEl  = card.querySelector( '.listing-card-info-price' );
		var actionEl = card.querySelector( '._exlio_125, .property_types_vlix' );
		var addrEl   = card.querySelector( '.foot-location' );
		var typeEl   = card.querySelector( '._list_blickes.types' );

		// Beds/baths/size from icon rows — strip out the icon img alt text
		var icons = card.querySelectorAll( '.listing-card-info-icon' );
		var beds = '', baths = '', size = '';
		icons.forEach( function ( ic ) {
			var t = ic.textContent.replace( /\s+/g, ' ' ).trim();
			if ( /Ch\.|Beds|Chambres/i.test( t ) ) beds = t;
			else if ( /SdB|Bath/i.test( t ) ) baths = t;
			else if ( /m²|sqft/i.test( t ) ) size = t;
		} );

		// Resolve title text — strip out any embedded icons
		var titleText = '';
		if ( titleEl ) {
			titleText = ( titleEl.textContent || '' ).replace( /\s+/g, ' ' ).trim();
		}

		return {
			id:      id,
			title:   titleText,
			url:     ( urlEl && urlEl.href ) || '#',
			thumb:   pickRealImage( card ),
			price:   ( priceEl ? priceEl.textContent : '' ).trim(),
			action:  ( actionEl ? actionEl.textContent : '' ).trim(),
			address: ( addrEl ? addrEl.textContent.replace( /\s+/g, ' ' ).trim() : '' ),
			category:( typeEl ? typeEl.textContent : '' ).trim(),
			beds:    beds,
			baths:   baths,
			size:    size,
		};
	}

	/* ---------- UI sync ---------- */
	function refreshWishlistUI() {
		var list = getWishlist();
		document.querySelectorAll( '.murailles-fav-count' ).forEach( function ( b ) {
			b.textContent = list.length;
			b.style.background = list.length ? '#dc3545' : '#6c757d';
		} );
		var ids = list.map( function ( x ) { return x.id; } );
		document.querySelectorAll( '.toggler input[type="checkbox"]' ).forEach( function ( cb ) {
			var id = getCardId( cb );
			if ( id === null ) return;
			cb.checked = ids.indexOf( id ) !== -1;
		} );
	}

	function refreshCompareUI() {
		var list = getCompare();
		var ids  = list.map( function ( x ) { return x.id; } );
		document.querySelectorAll( '.murailles-compare-trigger' ).forEach( function ( a ) {
			var id = getCardId( a );
			if ( id === null ) return;
			if ( ids.indexOf( id ) !== -1 ) {
				a.classList.add( 'is-active' );
				a.style.color = '#dc3545';
			} else {
				a.classList.remove( 'is-active' );
				a.style.color = '';
			}
		} );
	}

	/* ---------- floating buttons (compare + favoris) ---------- */
	function makeFloatingBtn( id, opts ) {
		if ( document.getElementById( id ) ) return document.getElementById( id );
		var btn = document.createElement( 'button' );
		btn.id    = id;
		btn.type  = 'button';
		btn.title = opts.title;
		btn.className = 'murailles-fab';
		btn.style.cssText = [
			'position:fixed',
			'right:24px',
			'bottom:' + opts.bottom + 'px',
			'z-index:9998',
			'width:56px',
			'height:56px',
			'padding:0',
			'border-radius:50%',
			'background:' + opts.color,
			'color:#fff',
			'border:none',
			'display:none',
			'align-items:center',
			'justify-content:center',
			'font-size:22px',
			'line-height:1',
			'box-shadow:0 8px 24px ' + opts.shadow,
			'cursor:pointer',
			'transition:transform .2s ease,box-shadow .2s ease'
		].join( ';' ) + ';';
		// Inner icon wrapper enforces exact centering — the FA glyph itself has uneven
		// horizontal whitespace inside its em-box, so we wrap and use fixed flex centering.
		btn.innerHTML =
			'<span style="display:flex;align-items:center;justify-content:center;width:100%;height:100%;pointer-events:none;">'
				+ '<i class="' + opts.icon + '" style="color:#fff;display:block;line-height:1;font-size:22px;"></i>'
			+ '</span>'
			+ '<span class="' + opts.countClass + '" style="position:absolute;top:-6px;right:-6px;min-width:22px;height:22px;padding:0 6px;background:#1a2332;color:#fff;border-radius:11px;font-size:12px;font-weight:700;line-height:22px;text-align:center;font-family:Arial,Helvetica,sans-serif;border:2px solid #fff;pointer-events:none;">0</span>';
		// Reset any inherited margin from our global icon→text spacing rule (icon is solo)
		var iconEl = btn.querySelector( 'i' );
		if ( iconEl ) iconEl.style.marginRight = '0';
		btn.addEventListener( 'mouseenter', function () { btn.style.transform = 'scale(1.08)'; } );
		btn.addEventListener( 'mouseleave', function () { btn.style.transform = 'scale(1)'; } );
		btn.addEventListener( 'click', opts.onClick );
		document.body.appendChild( btn );
		return btn;
	}

	function ensureFloatingCompare() {
		return makeFloatingBtn( 'murailles-floating-compare', {
			title:      'Voir la comparaison',
			bottom:     108,
			color:      '#dc3545',
			shadow:     'rgba(220,53,69,0.45)',
			icon:       'fa-solid fa-scale-balanced',
			countClass: 'murailles-compare-count',
			onClick:    showFloatingComparePreview
		} );
	}

	function ensureFloatingFavoris() {
		return makeFloatingBtn( 'murailles-floating-favoris', {
			title:      'Voir mes favoris',
			bottom:     180,
			color:      '#e91e63',
			shadow:     'rgba(233,30,99,0.45)',
			icon:       'fa-solid fa-heart',
			countClass: 'murailles-favoris-count',
			onClick:    showFloatingFavorisPreview
		} );
	}

	function refreshFloatingCompare() {
		var btn = ensureFloatingCompare();
		var list = getCompare();
		var countEl = btn.querySelector( '.murailles-compare-count' );
		if ( countEl ) {
			countEl.textContent = list.length;
			// Dim the badge when count is 0 so the button doesn't scream
			countEl.style.background = list.length ? '#1a2332' : '#6c757d';
			countEl.style.opacity    = list.length ? '1' : '0.7';
		}
		btn.style.display = list.length ? 'flex' : 'none';
	}

	function refreshFloatingFavoris() {
		var btn = ensureFloatingFavoris();
		var list = getWishlist();
		var countEl = btn.querySelector( '.murailles-favoris-count' );
		if ( countEl ) {
			countEl.textContent = list.length;
			countEl.style.background = list.length ? '#1a2332' : '#6c757d';
			countEl.style.opacity    = list.length ? '1' : '0.7';
		}
		btn.style.display = list.length ? 'flex' : 'none';
	}

	/* ---------- floating modal previews ---------- */
	function fallbackThumb() {
		return 'data:image/svg+xml;utf8,' + encodeURIComponent(
			'<svg xmlns="http://www.w3.org/2000/svg" width="120" height="80" viewBox="0 0 120 80"><rect width="120" height="80" fill="%23e9ecef"/><text x="60" y="44" text-anchor="middle" fill="%23adb5bd" font-family="Arial" font-size="11">Aucune image</text></svg>'
		);
	}

	function renderPreviewCard( p ) {
		var thumb    = ( p.thumb && p.thumb.length > 4 ) ? p.thumb : fallbackThumb();
		var title    = p.title || 'Bien sans titre';
		var price    = p.price || '';
		var action   = p.action || '';
		var category = p.category || '';
		var address  = p.address || '';
		var beds     = ( p.beds  || '' ).replace( /\s+/g, ' ' ).trim();
		var baths    = ( p.baths || '' ).replace( /\s+/g, ' ' ).trim();
		var size     = ( p.size  || '' ).replace( /\s+/g, ' ' ).trim();

		// Build specs row only if at least one value
		var specs = '';
		if ( beds || baths || size ) {
			specs = '<div style="display:flex;gap:14px;flex-wrap:wrap;font-size:12px;color:#6c757d;margin-top:8px;padding-top:8px;border-top:1px dashed #e5e7eb;">'
				+ ( beds  ? '<span style="display:inline-flex;align-items:center;gap:5px;"><i class="fa-solid fa-bed"    style="color:#dc3545;font-size:11px;"></i>' + escapeHtml( beds )  + '</span>' : '' )
				+ ( baths ? '<span style="display:inline-flex;align-items:center;gap:5px;"><i class="fa-solid fa-bath"   style="color:#dc3545;font-size:11px;"></i>' + escapeHtml( baths ) + '</span>' : '' )
				+ ( size  ? '<span style="display:inline-flex;align-items:center;gap:5px;"><i class="fa-solid fa-expand" style="color:#dc3545;font-size:11px;"></i>' + escapeHtml( size )  + '</span>' : '' )
			+ '</div>';
		}

		// Top tags row (category pill + action pill if present)
		var tags = '';
		if ( category || action ) {
			tags = '<div style="display:flex;gap:6px;flex-wrap:wrap;margin-bottom:6px;">'
				+ ( category ? '<span style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.4px;color:#0e8763;background:rgba(14,135,99,0.1);padding:3px 8px;border-radius:12px;">' + escapeHtml( category ) + '</span>' : '' )
				+ ( action   ? '<span style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.4px;color:#fff;background:#dc3545;padding:3px 8px;border-radius:12px;">' + escapeHtml( action ) + '</span>' : '' )
			+ '</div>';
		}

		return '<div style="display:flex;gap:14px;padding:14px;background:#f8f9fa;border-radius:10px;margin-bottom:10px;align-items:flex-start;border:1px solid #f0f0f0;">'
			+ '<img src="' + thumb + '" alt="" style="width:96px;height:80px;object-fit:cover;border-radius:8px;flex-shrink:0;">'
			+ '<div style="flex:1;min-width:0;">'
				+ tags
				+ '<div style="font-size:13px;color:#1a2332;font-weight:700;line-height:1.3;margin-bottom:4px;overflow:hidden;text-overflow:ellipsis;display:-webkit-box;-webkit-line-clamp:2;line-clamp:2;-webkit-box-orient:vertical;">' + escapeHtml( title ) + '</div>'
				+ ( address ? '<div style="font-size:12px;color:#6c757d;line-height:1.4;display:flex;align-items:center;gap:5px;"><i class="fa-solid fa-location-dot" style="color:#dc3545;font-size:11px;"></i>' + escapeHtml( address ) + '</div>' : '' )
				+ ( price   ? '<div style="font-size:14px;color:#dc3545;font-weight:800;margin-top:6px;">' + escapeHtml( price ) + '</div>' : '' )
				+ specs
			+ '</div>'
		+ '</div>';
	}

	function escapeHtml( s ) {
		return String( s || '' ).replace( /[&<>"']/g, function ( c ) {
			return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[ c ];
		} );
	}

	function emptyStateHtml( icon, msg ) {
		return '<div style="text-align:center;padding:20px 0;">'
			+ '<i class="' + icon + '" style="font-size:48px;color:#e5e7eb;display:block;margin-bottom:12px;"></i>'
			+ '<p style="margin:0;color:#6c757d;font-size:14px;">' + msg + '</p>'
		+ '</div>';
	}

	function showFloatingComparePreview() {
		var props = getCompare();
		var body, buttons;
		if ( ! props.length ) {
			body = emptyStateHtml( 'fa-solid fa-scale-balanced', 'Aucun bien sélectionné. Cliquez sur l\'icône ↗ d\'un bien pour l\'ajouter à la comparaison.' );
			buttons = [ { label: 'Fermer' } ];
		} else {
			body = props.map( renderPreviewCard ).join( '' );
			if ( props.length < WC.max_compare ) {
				body += '<p style="margin:8px 0 0;padding:10px;background:#fff3cd;color:#856404;border-radius:6px;font-size:13px;">'
					+ ( I.add_one_more || 'Ajoutez un autre bien pour comparer' ) + '</p>';
			}
			buttons = [
				{ label: I.cancel || 'Fermer' },
				{ label: I.view_compare || 'Tout voir', primary: true, onClick: function () {
					window.location.href = WC.compare_url;
				} },
			];
		}
		buildModal( 'Ma comparaison (' + props.length + '/' + WC.max_compare + ')', body, buttons );
	}

	function showFloatingFavorisPreview() {
		var props = getWishlist();
		var body, buttons;
		if ( ! props.length ) {
			body = emptyStateHtml( 'fa-regular fa-heart', 'Aucun favori pour l\'instant. Cliquez sur le ♡ d\'un bien pour l\'enregistrer ici.' );
			buttons = [ { label: 'Fermer' } ];
		} else {
			body = props.slice( 0, 5 ).map( renderPreviewCard ).join( '' );
			if ( props.length > 5 ) {
				body += '<p style="margin:8px 0 0;text-align:center;color:#6c757d;font-size:13px;">+ ' + ( props.length - 5 ) + ' autre(s) bien(s)</p>';
			}
			buttons = [
				{ label: I.cancel || 'Fermer' },
				{ label: 'Tout voir', primary: true, onClick: function () {
					window.location.href = WC.favoris_url;
				} },
			];
		}
		buildModal( 'Mes favoris (' + props.length + ')', body, buttons );
	}

	/* ---------- actions ---------- */
	function toggleWishlist( snapshot ) {
		if ( ! snapshot ) return;
		var list = getWishlist();
		var i    = list.findIndex( function ( x ) { return x.id === snapshot.id; } );
		if ( i === -1 ) {
			list.push( snapshot );
			toast( I.added_favoris || 'Ajouté aux favoris' );
		} else {
			list.splice( i, 1 );
			toast( I.removed_favoris || 'Retiré des favoris' );
		}
		setWishlist( list );
	}

	function toggleCompare( snapshot ) {
		if ( ! snapshot ) return;
		var list = getCompare();
		var i    = list.findIndex( function ( x ) { return x.id === snapshot.id; } );
		if ( i !== -1 ) {
			list.splice( i, 1 );
			setCompare( list );
			toast( I.removed_compare || 'Retiré de la comparaison' );
			return;
		}
		if ( list.length < WC.max_compare ) {
			list.push( snapshot );
			setCompare( list );
			toast( I.added_compare || 'Ajouté à la comparaison' );
			if ( list.length === WC.max_compare ) {
				showCompareReadyModal();
			}
		} else {
			showReplaceModal( snapshot );
		}
	}

	/* ---------- modals ---------- */
	function buildModal( titleHtml, bodyHtml, buttons ) {
		var overlay = document.createElement( 'div' );
		overlay.className = 'murailles-modal-overlay';
		overlay.style.cssText = 'position:fixed;inset:0;z-index:100000;background:rgba(15,22,32,0.7);display:flex;align-items:center;justify-content:center;padding:16px;backdrop-filter:blur(2px);';
		var modal = document.createElement( 'div' );
		modal.style.cssText = 'background:#fff;border-radius:12px;max-width:520px;width:100%;box-shadow:0 24px 64px rgba(0,0,0,0.25);overflow:hidden;font-family:Arial,Helvetica,sans-serif;';
		modal.innerHTML = '<div style="padding:24px 28px;border-bottom:1px solid #e9ecef;"><h3 style="margin:0;font-size:18px;color:#1a2332;">' + titleHtml + '</h3></div>'
			+ '<div class="murailles-modal-body" style="padding:24px 28px;color:#4a5568;font-size:14px;line-height:1.6;">' + bodyHtml + '</div>'
			+ '<div class="murailles-modal-actions" style="padding:16px 28px;background:#fafbfc;border-top:1px solid #e9ecef;display:flex;gap:12px;justify-content:flex-end;flex-wrap:wrap;"></div>';
		var actions = modal.querySelector( '.murailles-modal-actions' );
		( buttons || [] ).forEach( function ( b ) {
			var btn = document.createElement( 'button' );
			btn.type = 'button';
			btn.textContent = b.label;
			btn.style.cssText = 'padding:10px 20px;border-radius:6px;border:1px solid ' + ( b.primary ? '#dc3545' : '#ced4da' ) + ';background:' + ( b.primary ? '#dc3545' : '#fff' ) + ';color:' + ( b.primary ? '#fff' : '#495057' ) + ';font-weight:600;cursor:pointer;font-size:14px;';
			btn.addEventListener( 'click', function () { if ( typeof b.onClick === 'function' ) b.onClick(); overlay.remove(); } );
			actions.appendChild( btn );
		} );
		overlay.appendChild( modal );
		overlay.addEventListener( 'click', function ( e ) { if ( e.target === overlay ) overlay.remove(); } );
		document.body.appendChild( overlay );
		return overlay;
	}

	function showCompareReadyModal() {
		var props = getCompare();
		var cards = props.map( function ( p ) {
			return '<div style="flex:1;text-align:center;padding:12px;background:#f8f9fa;border-radius:8px;min-width:0;">'
				+ '<img src="' + ( p.thumb || '' ) + '" alt="" style="width:100%;height:100px;object-fit:cover;border-radius:6px;">'
				+ '<h4 style="margin:10px 0 4px;font-size:14px;color:#1a2332;line-height:1.3;">' + ( p.title || '' ) + '</h4>'
				+ '<div style="color:#dc3545;font-weight:700;font-size:15px;">' + ( p.price || '' ) + '</div>'
				+ '</div>';
		} ).join( '' ) || '<p style="text-align:center;color:#6c757d;">Aucun bien sélectionné.</p>';
		var body = '<p style="margin:0 0 16px;">' + ( I.compare_ready || 'Vous comparez 2 biens.' ) + '</p>'
			+ '<div style="display:flex;gap:12px;">' + cards + '</div>';
		buildModal( 'Comparaison prête', body, [
			{ label: I.cancel || 'Annuler' },
			{ label: I.view_compare || 'Voir la comparaison', primary: true, onClick: function () { window.location.href = WC.compare_url; } },
		] );
	}

	function showReplaceModal( newSnap ) {
		var current = getCompare();
		var newCard = '<div style="margin-bottom:16px;padding:12px;background:#fff3cd;border-radius:8px;display:flex;gap:12px;align-items:center;">'
			+ '<img src="' + ( newSnap.thumb || '' ) + '" style="width:60px;height:60px;object-fit:cover;border-radius:6px;">'
			+ '<div><strong style="color:#856404;">À ajouter :</strong><br>' + newSnap.title + '</div></div>';
		var pickButtons = current.map( function ( p ) {
			return { label: 'Remplacer « ' + ( p.title || 'bien' ).substring( 0, 30 ) + '… »', onClick: function () {
				var list = getCompare().filter( function ( x ) { return x.id !== p.id; } );
				list.push( newSnap );
				setCompare( list );
				toast( I.added_compare || 'Ajouté à la comparaison' );
				setTimeout( showCompareReadyModal, 200 );
			} };
		} );
		buildModal(
			I.compare_full || 'Comparaison pleine',
			newCard + '<p style="margin:0;">Choisissez le bien à retirer pour le remplacer.</p>',
			pickButtons.concat( [ { label: I.cancel || 'Annuler' } ] )
		);
	}

	/* ---------- event delegation ---------- */
	document.addEventListener( 'click', function ( e ) {
		var heart = e.target.closest( '.toggler input[type="checkbox"]' );
		if ( heart ) {
			var snap = getCardSnapshot( heart );
			if ( snap ) setTimeout( function () { toggleWishlist( snap ); }, 0 );
			return;
		}
		var share = e.target.closest( '.murailles-compare-trigger' );
		if ( share ) {
			e.preventDefault();
			var snap2 = getCardSnapshot( share );
			if ( snap2 ) toggleCompare( snap2 );
			return;
		}
	} );

	/* Header "Favoris" pill removed — the header now shows Sign In + Add Property
	   only. Favourites remain accessible via the floating heart button bottom-right
	   and via the /favoris/ page directly. */
	function injectHeaderFavBadge() { /* no-op */ }

	/* ---------- init ---------- */
	function init() {
		injectHeaderFavBadge();
		stampCardIds();
		document.querySelectorAll( '.property-listing a' ).forEach( function ( a ) {
			if ( a.querySelector( '.fa-share' ) ) {
				a.classList.add( 'murailles-compare-trigger' );
				a.setAttribute( 'title', 'Comparer ce bien' );
			}
		} );
		ensureFloatingCompare();
		ensureFloatingFavoris();
		refreshWishlistUI();
		refreshCompareUI();
		refreshFloatingCompare();
		refreshFloatingFavoris();
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}

	window.MuraillesWC = Object.assign( WC, {
		getWishlist: getWishlist,
		getCompare:  getCompare,
		clearCompare:    function () { setCompare( [] ); },
		clearWishlist:   function () { setWishlist( [] ); },
		removeFromCompare: function ( id ) {
			setCompare( getCompare().filter( function ( x ) { return x.id !== id; } ) );
		},
		removeFromWishlist: function ( id ) {
			setWishlist( getWishlist().filter( function ( x ) { return x.id !== id; } ) );
		},
		/**
		 * Toggle a property in the wishlist via a full snapshot object.
		 * Used by the bookmark icon on the single-property page.
		 * Returns true if the item is now saved, false if it was removed.
		 */
		toggleWishlistSnap: function ( snap ) {
			if ( ! snap || ! snap.id ) return false;
			var list = getWishlist();
			var i    = list.findIndex( function ( x ) { return x.id === snap.id; } );
			if ( i === -1 ) {
				list.push( snap );
				setWishlist( list );
				toast( I.added_favoris || 'Ajouté aux favoris' );
				return true;
			}
			list.splice( i, 1 );
			setWishlist( list );
			toast( I.removed_favoris || 'Retiré des favoris' );
			return false;
		},
		isInWishlist: function ( id ) {
			return getWishlist().some( function ( x ) { return x.id === id; } );
		},
	} );
} )();
