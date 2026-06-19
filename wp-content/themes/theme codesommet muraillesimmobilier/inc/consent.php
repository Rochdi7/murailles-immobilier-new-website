<?php
/**
 * Cookie consent banner with Google Consent Mode v2.
 *
 * Why this approach (vs. simply not printing the GA/GTM script):
 *   • Google's own recommended pattern. We set all consent signals to
 *     "denied" BEFORE the GA4/GTM tag loads (see the early wp_head hook),
 *     so the tag boots in cookieless mode and sends no analytics cookies.
 *   • When the visitor clicks "Accepter", we call gtag('consent','update',…)
 *     which flips the signals to "granted" and analytics starts properly —
 *     no page reload needed.
 *   • Choice is stored in a first-party cookie (`murailles_consent`) for 6
 *     months so the banner doesn't reappear on every page.
 *
 * Bilingual (FR default, EN on /en/ via murailles_t()). Logged-in admins
 * never see the banner (they're already excluded from analytics).
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! function_exists( 'murailles_opt' ) ) {
	function murailles_opt( $key, $default = '' ) {
		$opts = (array) get_option( 'murailles_options', array() );
		return isset( $opts[ $key ] ) && $opts[ $key ] !== '' ? $opts[ $key ] : $default;
	}
}

/**
 * True only when an analytics tag (GA4 or GTM) is actually configured.
 * No tag → no cookies → no banner needed.
 */
function murailles_consent_active() {
	if ( is_admin() ) { return false; }
	if ( current_user_can( 'manage_options' ) ) { return false; }
	return (bool) ( murailles_opt( 'seo_gtm_id' ) || murailles_opt( 'seo_ga4_id' ) );
}

/**
 * Google Consent Mode v2 defaults — printed at the very top of <head>,
 * BEFORE the GA4/GTM tag (which runs at priority 3). All storage denied
 * until the visitor accepts. If the consent cookie already says "accepted"
 * we boot straight into granted state so analytics works on the first page.
 */
add_action( 'wp_head', function () {
	if ( ! murailles_consent_active() ) { return; }

	$already_accepted = isset( $_COOKIE['murailles_consent'] ) && $_COOKIE['murailles_consent'] === 'accepted';
	$state = $already_accepted ? 'granted' : 'denied';
	?>
<!-- Consent Mode v2 defaults -->
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('consent', 'default', {
	'ad_storage': '<?php echo esc_js( $state ); ?>',
	'ad_user_data': '<?php echo esc_js( $state ); ?>',
	'ad_personalization': '<?php echo esc_js( $state ); ?>',
	'analytics_storage': '<?php echo esc_js( $state ); ?>',
	'wait_for_update': 500
});
</script>
<!-- End Consent Mode v2 defaults -->
	<?php
}, 1 ); // priority 1 → before the GA4/GTM tag at priority 3.

/**
 * The banner markup + the accept/refuse JS. Rendered in the footer.
 * Hidden via inline style when consent is already recorded.
 */
add_action( 'wp_footer', function () {
	if ( ! murailles_consent_active() ) { return; }
	if ( isset( $_COOKIE['murailles_consent'] ) ) { return; } // already chose — don't render at all.

	$title   = murailles_t( 'Nous respectons votre vie privée', false );
	$body    = murailles_t( 'Nous utilisons des cookies de mesure d\'audience pour améliorer votre expérience. Vous pouvez accepter ou refuser. Voir notre', false );
	$privacy = murailles_t( 'politique de confidentialité', false );
	$accept  = murailles_t( 'Accepter', false );
	$refuse  = murailles_t( 'Refuser', false );
	$privacy_url = home_url( '/privacy/' );
	?>
	<div id="murailles-consent" class="murailles-consent" role="dialog" aria-live="polite" aria-label="<?php echo esc_attr( $title ); ?>">
		<div class="murailles-consent__inner">
			<div class="murailles-consent__text">
				<strong class="murailles-consent__title"><?php echo esc_html( $title ); ?></strong>
				<p class="murailles-consent__body">
					<?php echo esc_html( $body ); ?>
					<a href="<?php echo esc_url( $privacy_url ); ?>"><?php echo esc_html( $privacy ); ?></a>.
				</p>
			</div>
			<div class="murailles-consent__actions">
				<button type="button" class="murailles-consent__btn murailles-consent__btn--refuse" data-consent="denied"><?php echo esc_html( $refuse ); ?></button>
				<button type="button" class="murailles-consent__btn murailles-consent__btn--accept" data-consent="granted"><?php echo esc_html( $accept ); ?></button>
			</div>
		</div>
	</div>
	<style>
		.murailles-consent{position:fixed;left:0;right:0;bottom:0;z-index:99990;background:#1a2332;color:#fff;box-shadow:0 -4px 24px rgba(0,0,0,.25);animation:murailles-consent-in .35s ease}
		@keyframes murailles-consent-in{from{transform:translateY(100%)}to{transform:translateY(0)}}
		.murailles-consent__inner{max-width:1180px;margin:0 auto;padding:18px 22px;display:flex;flex-wrap:wrap;align-items:center;gap:14px 28px;justify-content:space-between}
		.murailles-consent__title{display:block;font-size:15px;margin-bottom:4px}
		.murailles-consent__body{margin:0;font-size:13.5px;line-height:1.5;color:#cfd6e4;max-width:760px}
		.murailles-consent__body a{color:#fff;text-decoration:underline}
		.murailles-consent__actions{display:flex;gap:10px;flex-shrink:0}
		.murailles-consent__btn{cursor:pointer;border:0;border-radius:6px;padding:11px 22px;font-size:14px;font-weight:600;transition:opacity .15s ease,transform .15s ease}
		.murailles-consent__btn:hover{transform:translateY(-1px)}
		.murailles-consent__btn--refuse{background:transparent;color:#cfd6e4;border:1px solid rgba(255,255,255,.25)}
		.murailles-consent__btn--accept{background:#dc3545;color:#fff}
		@media(max-width:600px){.murailles-consent__inner{flex-direction:column;align-items:stretch;text-align:left}.murailles-consent__actions{justify-content:stretch}.murailles-consent__btn{flex:1}}
	</style>
	<script>
	(function(){
		var bar = document.getElementById('murailles-consent');
		if (!bar) { return; }
		function setCookie(v){
			var d = new Date(); d.setTime(d.getTime() + 180*24*60*60*1000); // 6 months
			document.cookie = 'murailles_consent=' + v + ';expires=' + d.toUTCString() + ';path=/;SameSite=Lax';
		}
		bar.addEventListener('click', function(e){
			var btn = e.target.closest('[data-consent]');
			if (!btn) { return; }
			var grant = btn.getAttribute('data-consent'); // 'granted' | 'denied'
			setCookie(grant === 'granted' ? 'accepted' : 'refused');
			if (typeof gtag === 'function') {
				gtag('consent', 'update', {
					'ad_storage': grant,
					'ad_user_data': grant,
					'ad_personalization': grant,
					'analytics_storage': grant
				});
			}
			bar.style.display = 'none';
		});
	})();
	</script>
	<?php
}, 30 );
