<?php
/**
 * HTML markup for the showing the already loggedin user.
 *
 * @link       https://github.com/vermadarsh/
 * @since      1.0.0
 *
 * @package    Core_Functions
 * @subpackage Core_Functions/public/templates/registration
 */
defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

$user_id      = get_current_user_id();
$fullname     = cf_get_user_full_name( $user_id );
$welcome_text = cf_get_time_based_text();
$welcome_text = str_replace( '{name}', $fullname, $welcome_text );
?>
<div class="cognify-already-loggedin">
	<div class="container">
		<section class="content">
			<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-4">
					<h5 class="cognify-text-color"><?php echo esc_html( $welcome_text ); ?></h5>
					<a class="cognify-button btn" href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>"><?php esc_html_e( 'Logout', 'cognify-core' ); ?></a>
				</div>
				<div class="col-md-4"></div>
			</div>
		</section>
	</div>
</div>
