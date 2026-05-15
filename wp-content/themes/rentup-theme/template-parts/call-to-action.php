<?php
/**
 * Template Part: Call To Action Section
 *
 * "Do You Have Questions?" banner section used across multiple pages.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- ============================ Call To Action ================================== -->
<section class="bg-danger call_action_wrap-wrap">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">

				<div class="call_action_wrap">
					<div class="call_action_wrap-head">
						<h3><?php murailles_t( 'Vous avez des questions ?' ); ?></h3>
						<span><?php murailles_t( 'Nous sommes disponibles pour vous accompagner dans votre projet immobilier.' ); ?></span>
					</div>
					<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-call_action_wrap"><?php murailles_t( 'Contactez-nous' ); ?></a>
				</div>

			</div>
		</div>
	</div>
</section>
<!-- ============================ Call To Action End ================================== -->
