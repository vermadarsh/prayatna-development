<?php
/**
 * HTML markup for the counselor email verification.
 *
 * @link       https://github.com/vermadarsh/
 * @since      1.0.0
 *
 * @package    Cognify_Core
 * @subpackage Cognify_Core/public/templates
 */
defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

// Check for the requesting user ID.
$random_number = filter_input( INPUT_GET, 'atts', FILTER_SANITIZE_NUMBER_INT );
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<?php 
				if ( ! is_null( $random_number ) ) {
					// Get the user based on random number.
					$user_ids = get_users(
						array(
							'fields'     => 'ids',
							'meta_query' => array(
								array(
									'key'     => 'email_verification_random_number',
									'value'   => $random_number,
									'compare' => '=',
								),
							),
						)
					);

					// Check if the user exists for the requesting user ID.
					if ( empty( $user_ids ) ) {
						?>
						<div class="alert alert-danger" role="alert">
						<?php esc_html_e( 'No such user exists.', 'cognify-core' ); ?>
						</div>
						<?php
					} else {
						$user_id        = $user_ids[0];
						$current_status = get_user_meta( $user_id, 'cf_user_email_verification', true );
						echo '<div class="alert alert-success">';

						if ( 'verified' === $current_status ) {
							echo sprintf( __( 'The user account is already active. Click %1$shere%2$s to login.', 'core-functions' ), '<a href="' . home_url( '/login/' ) . '">', '</a>' );
						} elseif ( 'pending' === $current_status ) {
							// update_user_meta( $user_id, 'cf_user_email_verification', 'verified' );
							$is_therapist = cf_is_user_therapist( $user_id );
							$is_client    = cf_is_user_client( $user_id );
							
							if ( $is_therapist ) {
								echo get_field( 'therapist_email_verification_success_message', 'option' );
							} else {
								echo get_field( 'client_email_verification_success_message', 'option' );
							}
						}
						echo '</div>';
					}
				} else {
					?>
					<div class="alert alert-danger" role="alert">
						<?php esc_html_e( 'Invalid request !!', 'cognify-core' ); ?>
					</div>
					<?php
				}
			?>
		</div>
	</div>
</div>
