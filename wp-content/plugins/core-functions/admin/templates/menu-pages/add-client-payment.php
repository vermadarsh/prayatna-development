<?php
/**
 * This file holds the markup for adding client payment.
 *
 * @since   1.0.0
 * @package Core_Functions
 * @subpackage Core_Functions/admin/templates/menu-pages
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

$submit_payment = filter_input( INPUT_POST, 'add-client-payment', FILTER_SANITIZE_STRING );
$payment_nonce  = filter_input( INPUT_POST, 'add-client-payment-nonce', FILTER_SANITIZE_STRING );
$clients        = cf_get_clients();

// If the submit button it pressed, add the new payment to the client's database.
if ( isset( $submit_payment ) && wp_verify_nonce( $payment_nonce, 'add-client-payment' ) ) {
	$client_id      = filter_input( INPUT_POST, 'client-id', FILTER_SANITIZE_STRING );
	$amount         = filter_input( INPUT_POST, 'amount', FILTER_SANITIZE_STRING );
	$no_of_sessions = filter_input( INPUT_POST, 'no-of-sessions', FILTER_SANITIZE_STRING );

	// Update the ACF fields.
	// update_field( 'student_name', $student_name, $log_id );

	// Show the success message now.
	echo '<div class="notice updated" id="message"><p>' . __( 'Payment updated successfully.', 'core-functions' ) . '</p></div>';
}
?>
<div class="wrap">
	<h1><?php esc_html_e( 'Add Payment Details', 'core-functions' ); ?></h1>
	<form class="cf-add-payemnt-form" action="" method="POST">
		<h4><?php esc_html_e( 'Fill in the details below to add a new payment log.', 'core-functions' ); ?></h4>
		<table class="form-table">
			<tbody>
				<!-- FIELD: CLIENT ID -->
				<tr>
					<th scope="row"><label for="client-id"><?php esc_html_e( 'Client', 'core-functions' ); ?><span class="required">*</span></label></th>
					<td>
						<select id="client-id">
							<option value=""><?php esc_html_e( 'Select client', 'core-functions' ); ?></option>
							<?php
							if ( ! empty( $clients ) && is_array( $clients ) ) {
								foreach ( $clients as $client_id ) {
									$client      = get_userdata( $client_id );
									$client_name = cf_get_user_full_name( $client_id );
									$client_str  = "#{$client_id} - {$client->data->user_email} - {$client_name}";
									echo '<option value="' . $client_id . '">' . $client_str . '</option>';
								}
							}
							?>
						</select>
						<p class="cf-form-description-text"><?php esc_html_e( 'Select the client who submitted the payment.', 'core-functions' ); ?></p>
					</td>
				</tr>

				<!-- FIELD: AMOUNT -->
				<tr>
					<th scope="row"><label for="amount"><?php esc_html_e( 'Amount', 'core-functions' ); ?><span class="required">*</span></label></th>
					<td>
						<input type="text" name="amount" id="amount" class="regular-text" onkeypress="return /[0-9]/i.test(event.key)" required />
						<p class="cf-form-description-text"><?php esc_html_e( 'How much did the client pay?', 'core-functions' ); ?></p>
					</td>
				</tr>

				<!-- FIELD: NUMBER OF SESSIONS -->
				<tr>
					<th scope="row"><label for="no-of-sessions"><?php esc_html_e( 'No. of Sessions', 'core-functions' ); ?><span class="required">*</span></label></th>
					<td>
						<input type="text" name="no-of-sessions" id="no-of-sessions" class="regular-text" onkeypress="return /[0-9]/i.test(event.key)" required />
						<p class="cf-form-description-text"><?php esc_html_e( 'The number of sessions that the client can undertake from the amount paid.', 'core-functions' ); ?></p>
					</td>
				</tr>
			</tbody>
		</table>
		<?php wp_nonce_field( 'add-client-payment', 'add-client-payment-nonce' );
		submit_button( __( 'Submit', 'core-functions' ), 'submit', 'add-client-payment' ); ?>
	</form>
</div>
