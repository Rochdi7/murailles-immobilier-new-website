/**
 * Murailles Immobilier — File Uploader with previews
 *
 * Wraps every [data-murailles-uploader] block:
 *   - drag-and-drop on the drop zone
 *   - click-to-browse via the hidden <input type=file>
 *   - thumbnail grid preview of selected images
 *   - per-thumb remove button (resyncs the file input's FileList)
 *
 * The original <input type=file name="gallery[]" multiple> stays intact so
 * the form submits exactly as before; we only mutate its `files` property
 * via DataTransfer when the user removes a thumbnail.
 */
( function () {
	'use strict';

	function bytesToReadable( n ) {
		if ( n < 1024 ) { return n + ' B'; }
		if ( n < 1024 * 1024 ) { return ( n / 1024 ).toFixed( 1 ) + ' KB'; }
		return ( n / 1024 / 1024 ).toFixed( 1 ) + ' MB';
	}

	function init( root ) {
		var input = root.querySelector( 'input[type=file]' );
		var preview = root.querySelector( '[data-murailles-uploader-preview]' );
		var drop = root.querySelector( '.murailles-uploader__drop' );
		if ( ! input || ! preview || ! drop ) { return; }
		if ( root.dataset.muraillesUploaderReady === '1' ) { return; }
		root.dataset.muraillesUploaderReady = '1';

		// Internal list of File objects mirroring input.files
		// (FileList is read-only; we use DataTransfer to write a new one).
		var files = [];

		function syncInputFiles() {
			if ( typeof DataTransfer === 'undefined' ) { return; }
			var dt = new DataTransfer();
			files.forEach( function ( f ) { dt.items.add( f ); } );
			input.files = dt.files;
		}

		function renderThumbs() {
			preview.innerHTML = '';
			files.forEach( function ( file, idx ) {
				if ( ! file.type || file.type.indexOf( 'image/' ) !== 0 ) { return; }
				var thumb = document.createElement( 'div' );
				thumb.className = 'murailles-uploader__thumb';

				var img = document.createElement( 'img' );
				img.alt = file.name;
				var url = URL.createObjectURL( file );
				img.src = url;
				img.addEventListener( 'load', function () { URL.revokeObjectURL( url ); } );
				thumb.appendChild( img );

				var removeBtn = document.createElement( 'button' );
				removeBtn.type = 'button';
				removeBtn.className = 'murailles-uploader__thumb-remove';
				removeBtn.setAttribute( 'aria-label', 'Retirer ' + file.name );
				removeBtn.innerHTML = '&times;';
				removeBtn.addEventListener( 'click', function ( e ) {
					e.preventDefault();
					e.stopPropagation();
					files.splice( idx, 1 );
					syncInputFiles();
					renderThumbs();
				} );
				thumb.appendChild( removeBtn );

				var name = document.createElement( 'div' );
				name.className = 'murailles-uploader__thumb-name';
				name.textContent = file.name + ' · ' + bytesToReadable( file.size );
				thumb.appendChild( name );

				preview.appendChild( thumb );
			} );
		}

		function addFiles( fileList ) {
			Array.prototype.forEach.call( fileList, function ( file ) {
				if ( ! file.type || file.type.indexOf( 'image/' ) !== 0 ) { return; }
				// De-duplicate by name + size + lastModified
				var dup = files.some( function ( f ) {
					return f.name === file.name && f.size === file.size && f.lastModified === file.lastModified;
				} );
				if ( ! dup ) { files.push( file ); }
			} );
			syncInputFiles();
			renderThumbs();
		}

		// Native picker
		input.addEventListener( 'change', function () {
			addFiles( input.files );
		} );

		// Drag & drop
		[ 'dragenter', 'dragover' ].forEach( function ( evt ) {
			drop.addEventListener( evt, function ( e ) {
				e.preventDefault();
				e.stopPropagation();
				root.classList.add( 'is-dragover' );
			} );
		} );

		[ 'dragleave', 'drop' ].forEach( function ( evt ) {
			drop.addEventListener( evt, function ( e ) {
				e.preventDefault();
				e.stopPropagation();
				root.classList.remove( 'is-dragover' );
			} );
		} );

		drop.addEventListener( 'drop', function ( e ) {
			if ( e.dataTransfer && e.dataTransfer.files ) {
				addFiles( e.dataTransfer.files );
			}
		} );
	}

	function initAll( scope ) {
		( scope || document ).querySelectorAll( '[data-murailles-uploader]' ).forEach( init );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', function () { initAll(); } );
	} else {
		initAll();
	}

	// Watch for uploaders added dynamically.
	if ( 'MutationObserver' in window ) {
		new MutationObserver( function ( muts ) {
			muts.forEach( function ( m ) {
				m.addedNodes.forEach( function ( n ) {
					if ( n.nodeType !== 1 ) { return; }
					if ( n.matches && n.matches( '[data-murailles-uploader]' ) ) { init( n ); }
					if ( n.querySelectorAll ) { initAll( n ); }
				} );
			} );
		} ).observe( document.body, { childList: true, subtree: true } );
	}

	window.MuraillesUploader = { init: init, initAll: initAll };
} )();
