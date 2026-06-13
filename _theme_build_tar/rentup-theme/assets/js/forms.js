/**
 * Murailles forms — AJAX submission with inline feedback.
 *
 * Each form opts in by adding class="murailles-form" and data-action="<wp_ajax_action>".
 * Required hidden fields (rendered server-side):
 *   - name="action"          → wp_ajax action slug
 *   - name="_murailles_nonce"   → wp_nonce_field value
 *   - name="_murailles_ts"      → time() when page rendered
 *   - name="_mw_hp_url"     → honeypot (must remain empty; obscure name avoids browser autofill)
 *
 * The script:
 *   1. Hides the honeypot via CSS (display:none) — kept here so a missing stylesheet
 *      still triggers the trap (bots see it and fill it; humans don't).
 *   2. Intercepts submit, POSTs via fetch with FormData (supports file uploads).
 *   3. Renders a .murailles-form__notice element near the submit button.
 */
( function () {
	'use strict';

	function ensureHoneypotHidden() {
		// Clear any value that browser autofill or password managers may have
		// dropped in — happened with the old name="website_url" honeypot which
		// Edge/Chrome treated as a URL field and prefilled, blocking real users.
		document.querySelectorAll( 'input[name="_mw_hp_url"]' ).forEach( function ( el ) {
			el.value           = '';
			el.style.position  = 'absolute';
			el.style.left      = '-9999px';
			el.style.top       = '-9999px';
			el.style.opacity   = '0';
			el.style.width     = '1px';
			el.style.height    = '1px';
			el.style.pointerEvents = 'none';
			el.tabIndex        = -1;
			el.autocomplete    = 'new-password';
			el.setAttribute( 'aria-hidden', 'true' );
		} );
	}

	function getNotice( form ) {
		var notice = form.querySelector( '.murailles-form__notice' );
		if ( ! notice ) {
			notice = document.createElement( 'div' );
			notice.className = 'murailles-form__notice';
			// Append at the end of the form so it stacks below the input/button row,
			// rather than being injected inside a flex .input-group that squeezes the input.
			form.appendChild( notice );
		}
		return notice;
	}

	function setNotice( form, state, text ) {
		var notice = getNotice( form );
		notice.textContent = text;
		notice.classList.remove( 'is-success', 'is-error', 'is-info' );
		notice.classList.add( 'is-' + ( state === 'success' || state === 'error' ? state : 'info' ) );
	}

	function submitForm( form ) {
		var submitBtn = form.querySelector( '[type="submit"]' );
		var originalLabel = submitBtn ? submitBtn.innerHTML : '';
		if ( submitBtn ) {
			submitBtn.disabled = true;
			submitBtn.innerHTML = ( window.MuraillesForms && MuraillesForms.msg_sending ) || 'Envoi en cours…';
		}
		setNotice( form, 'info', ( window.MuraillesForms && MuraillesForms.msg_sending ) || 'Envoi en cours…' );

		var data = new FormData( form );
		var action = data.get( 'action' );
		if ( action === 'murailles_property_inquiry' ) {
			if ( ! data.get( 'phone' ) ) {
				var textInputs = form.querySelectorAll( 'input.form-control.light[type="text"]' );
				if ( textInputs.length > 1 ) {
					data.set( 'phone', textInputs[ 1 ].value || '' );
				}
			}
			if ( ! data.get( 'message' ) ) {
				var messageField = form.querySelector( 'textarea.form-control.light' );
				if ( messageField ) {
					data.set( 'message', messageField.value || '' );
				}
			}
		}
		data.append( '_ajax', '1' );

		var endpoint = ( window.MuraillesForms && MuraillesForms.ajax_url ) || '/wp-admin/admin-ajax.php';

		fetch( endpoint, {
			method: 'POST',
			credentials: 'same-origin',
			body: data,
		} )
			.then( function ( r ) { return r.json().catch( function () { return { success: false, message: '' }; } ); } )
			.then( function ( res ) {
				if ( res && res.success ) {
					setNotice( form, 'success', res.message || 'Merci !' );
					form.reset();
				} else {
					setNotice( form, 'error', ( res && res.message ) || ( window.MuraillesForms && MuraillesForms.msg_default_error ) || 'Erreur.' );
				}
			} )
			.catch( function () {
				setNotice( form, 'error', ( window.MuraillesForms && MuraillesForms.msg_default_error ) || 'Erreur réseau.' );
			} )
			.finally( function () {
				if ( submitBtn ) {
					submitBtn.disabled = false;
					submitBtn.innerHTML = originalLabel;
				}
			} );
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		ensureHoneypotHidden();
		document.querySelectorAll( 'form.murailles-form' ).forEach( function ( form ) {
			var actionField = form.querySelector( 'input[name="action"]' );
			if ( actionField && actionField.value === 'murailles_property_inquiry' ) {
				var textInputs = form.querySelectorAll( 'input.form-control.light[type="text"]' );
				if ( textInputs.length > 1 && ! textInputs[ 1 ].getAttribute( 'name' ) ) {
					textInputs[ 1 ].setAttribute( 'name', 'phone' );
				}
				var messageField = form.querySelector( 'textarea.form-control.light' );
				if ( messageField && ! messageField.getAttribute( 'name' ) ) {
					messageField.setAttribute( 'name', 'message' );
				}
			}
			form.addEventListener( 'submit', function ( e ) {
				e.preventDefault();
				submitForm( form );
			} );
		} );
	} );
} )();
