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
debug( $clients ); die;

// If the submit button it pressed, add the new payment to the client's database.
if ( isset( $submit_payment ) && wp_verify_nonce( $payment_nonce, 'add-client-payment' ) ) {
	$client_id = filter_input( INPUT_POST, 'client-id', FILTER_SANITIZE_STRING );
	$amount    = filter_input( INPUT_POST, 'amount', FILTER_SANITIZE_STRING );

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
					<th scope="row"><label for="student-name"><?php esc_html_e( 'Student Name', 'core-functions' ); ?><span class="required">*</span></label></th>
					<td>
						<input type="text" name="student-name" id="student-name" class="regular-text" value="<?php echo esc_html( $current_user_name ); ?>" required />
						<p class="cf-form-description-text"><?php esc_html_e( 'Provide the student name here.', 'core-functions' ); ?></p>
					</td>
				</tr>

				<!-- FIELD: INTERNSHIP DURATION -->
				<tr>
					<th scope="row"><label for="internship-duration"><?php esc_html_e( 'Internship Duration', 'core-functions' ); ?><span class="required">*</span></label></th>
					<td>
						<input type="text" name="internship-duration" id="internship-duration" class="regular-text" required />
						<p class="cf-form-description-text"><?php esc_html_e( 'How long would the internship go?', 'core-functions' ); ?></p>
					</td>
				</tr>
			</tbody>
		</table>
		<?php wp_nonce_field( 'add-client-payment', 'add-client-payment-nonce' );
		submit_button( __( 'Submit', 'core-functions' ), 'submit', 'add-client-payment' ); ?>
	</form>
</div>
