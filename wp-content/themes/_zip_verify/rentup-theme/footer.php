<?php

/**
 * Footer Template
 *
 * Contains the site footer, login/register modal, message modal,
 * back-to-top button, and closing wrapper tags.
 * Exact markup preserved from the original static template.
 *
 * @package Murailles Immobilier
 */

if (! defined('ABSPATH')) {
	exit;
}
?>

<!-- ============================ Footer Start ================================== -->
<footer class="dark-footer skin-dark-footer style-2">
	<div class="footer-middle">
		<div class="container">
			<div class="row">

				<div class="col-lg-5 col-md-5">
					<div class="footer_widget">
						<img src="<?php echo esc_url(murailles_img('logo.webp')); ?>" class="img-footer small mb-4" alt="" />
						<h4 class="extream mb-3"><?php murailles_t("Besoin d'aide pour"); ?><br><?php murailles_t('votre projet ?'); ?></h4>
						<p><?php murailles_t('Recevez chaque mois nos nouvelles annonces, conseils et actualités du marché immobilier marocain directement dans votre boîte mail.'); ?></p>
						<form class="foot-news-last mt-4 murailles-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
							<input type="hidden" name="action" value="murailles_newsletter">
							<?php wp_nonce_field('murailles_newsletter', '_murailles_nonce'); ?>
							<input type="hidden" name="_murailles_ts" value="<?php echo time(); ?>">
							<input type="text" name="_mw_hp_url" value="" tabindex="-1" autocomplete="new-password" aria-hidden="true" style="position:absolute;left:-9999px;top:-9999px;opacity:0;width:1px;height:1px;pointer-events:none;">
							<div class="input-group">
								<input type="email" name="email" class="form-control" placeholder="<?php echo esc_attr(murailles_t('Adresse e-mail', false)); ?>" required>
								<div class="input-group-append">
									<button type="submit" class="btn btn-danger b-0 text-light"><?php murailles_t("S'abonner"); ?></button>
								</div>
							</div>
						</form>
					</div>
				</div>

				<div class="col-lg-6 col-md-7 ms-auto">
					<div class="row">

						<div class="col-lg-4 col-md-4">
							<div class="footer_widget">
								<h4 class="widget_title"><?php murailles_t('Navigation'); ?></h4>
								<ul class="footer-menu">
									<li><a href="<?php echo esc_url(home_url('/')); ?>"><?php murailles_t('Accueil'); ?></a></li>
									<li><a href="<?php echo esc_url(murailles_bien_url()); ?>"><?php murailles_t('Biens immobiliers'); ?></a></li>
									<li><a href="<?php echo esc_url(home_url('/nos-services/')); ?>"><?php murailles_t('Nos Services'); ?></a></li>
									<li><a href="<?php echo esc_url(home_url('/compare-property/')); ?>"><?php murailles_t('Comparer'); ?></a></li>
									<li><a href="<?php echo esc_url(home_url('/blog/')); ?>"><?php murailles_t('Blog'); ?></a></li>
								</ul>
							</div>
						</div>

						<div class="col-lg-4 col-md-4">
							<div class="footer_widget">
								<h4 class="widget_title"><?php murailles_t('Informations'); ?></h4>
								<ul class="footer-menu">
									<li><a href="<?php echo esc_url(home_url('/about-us/')); ?>"><?php murailles_t('A propos'); ?></a></li>
									<li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php murailles_t('Contact'); ?></a></li>
									<li><a href="<?php echo esc_url(home_url('/faq/')); ?>"><?php murailles_t('FAQ'); ?></a></li>
									<li><a href="<?php echo esc_url(home_url('/privacy/')); ?>"><?php murailles_t('Confidentialité'); ?></a></li>
									<li><a href="<?php echo esc_url(home_url('/conditions-generales/')); ?>"><?php murailles_t('Conditions générales'); ?></a></li>
								</ul>
							</div>
						</div>

						<div class="col-lg-4 col-md-4">
							<div class="footer_widget murailles-footer-contact">
								<h4 class="widget_title"><?php murailles_t('Contact'); ?></h4>
								<?php $murailles_ci = murailles_contact_info(); ?>
								<ul class="footer-menu murailles-contact-list">
									<li>
										<i class="ti-location-pin"></i>
										<span>
											<?php echo esc_html($murailles_ci['address_line1']); ?><br>
											<?php echo esc_html($murailles_ci['address_line2']); ?><br>
											<?php echo esc_html($murailles_ci['address_city']); ?>
										</span>
									</li>
									<li>
										<i class="ti-mobile"></i>
										<a href="tel:<?php echo esc_attr($murailles_ci['phone_tel']); ?>"><?php echo esc_html($murailles_ci['contact_name']); ?> : <?php echo esc_html($murailles_ci['phone_display']); ?></a>
									</li>
									<li>
										<i class="ti-email"></i>
										<a href="mailto:<?php echo esc_attr($murailles_ci['email']); ?>"><?php echo esc_html($murailles_ci['email']); ?></a>
									</li>
								</ul>

								<!-- Social media -->
								<ul class="footer-social mt-3" style="list-style:none;padding:0;margin:0;display:flex;gap:10px;">
									<li>
										<a href="<?php echo esc_url($murailles_ci['facebook']); ?>" target="_blank" rel="noopener" aria-label="Facebook" style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,0.08);color:#fff;transition:background .15s ease, transform .15s ease;">
											<i class="fab fa-facebook-f"></i>
										</a>
									</li>
									<li>
										<a href="<?php echo esc_url($murailles_ci['instagram']); ?>" target="_blank" rel="noopener" aria-label="Instagram" style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,0.08);color:#fff;transition:background .15s ease, transform .15s ease;">
											<i class="fab fa-instagram"></i>
										</a>
									</li>
									<li>
										<a href="<?php echo esc_url($murailles_ci['twitter']); ?>" target="_blank" rel="noopener" aria-label="Twitter" style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,0.08);color:#fff;transition:background .15s ease, transform .15s ease;">
											<i class="fab fa-twitter"></i>
										</a>
									</li>
								</ul>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="footer-bottom">
		<div class="container">
			<div class="row align-items-center g-2">
				<div class="col-lg-6 col-md-6 text-center text-lg-start">
					<p class="mb-0">&copy; <?php echo date('Y'); ?> Murailles Immobilier. <?php murailles_t('Tous droits réservés.'); ?></p>
				</div>
				<div class="col-lg-6 col-md-6 text-center text-lg-end">
					<p class="mb-0 murailles-built-by">
						<?php murailles_t('Site développé par'); ?>
						<a href="https://codesommet.com/" target="_blank" rel="noopener" class="murailles-built-by__link">CodeSommet</a>
					</p>
				</div>
			</div>
		</div>
	</div>
</footer>
<!-- ============================ Footer End ================================== -->

<a id="back2Top" class="top-scroll" title="<?php echo esc_attr(murailles_t('Retour en haut', false)); ?>" href="#"><i class="ti-arrow-up"></i></a>


</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->

<?php
// Global Login / Register modal — opened by the "Sign In" header item
// (data-bs-toggle="modal" data-bs-target="#login") on every page.
get_template_part('template-parts/login-modal');
?>

<?php wp_footer(); ?>

</body>

</html>