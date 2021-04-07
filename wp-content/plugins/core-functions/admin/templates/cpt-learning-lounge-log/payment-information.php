<?php
/**
 * This file holds the markup for adding new learning lounge log by the student.
 *
 * @since   1.0.0
 * @package Core_Functions
 * @subpackage Core_Functions/admin/templates/cpt-learning-lounge-log
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

$current_user_id   = get_current_user_id();
$current_user_name = cf_get_user_full_name( $current_user_id );
$submit_log        = filter_input( INPUT_POST, 'add-new-learning-lounge-log', FILTER_SANITIZE_STRING );
$new_log_nonce     = filter_input( INPUT_POST, 'new-learning-lounge-log-nonce', FILTER_SANITIZE_STRING );

// If the submit button it pressed, add the new log to the database.
if ( isset( $submit_log ) && wp_verify_nonce( $new_log_nonce, 'new-learning-lounge-log' ) ) {
	$student_name        = filter_input( INPUT_POST, 'student-name', FILTER_SANITIZE_STRING );
	$internship_duration = filter_input( INPUT_POST, 'internship-duration', FILTER_SANITIZE_STRING );
	$course_opted        = filter_input( INPUT_POST, 'course-opted', FILTER_SANITIZE_STRING );
	$amount_paid         = filter_input( INPUT_POST, 'amount-paid', FILTER_SANITIZE_STRING );
	$mode_of_payment     = filter_input( INPUT_POST, 'mode-of-payment', FILTER_SANITIZE_STRING );
	$payment_date        = filter_input( INPUT_POST, 'payment-date', FILTER_SANITIZE_STRING );
	$payment_date        = gmdate( 'Y-m-d', strtotime( $payment_date ) );
	$bank_name           = filter_input( INPUT_POST, 'bank-name', FILTER_SANITIZE_STRING );

	// Create the log post now.
	$log_id = wp_insert_post(
		array(
			'post_type'   => 'learning-lounge-log',
			'post_status' => 'publish',
			'post_date'   => gmdate( 'Y-m-d H:i:s' ),
			'post_author' => get_current_user_id(),
			'post_title'  => sprintf( __( 'Log - %1$s - %2$s', 'core-functions' ), $student_name, gmdate( 'Y-m-d-H:i:s' ) ),
		)
	);

	// Update the ACF fields.
	update_field( 'student_name', $student_name, $log_id );
	update_field( 'internship_duration', $internship_duration, $log_id );
	update_field( 'course_opted', $course_opted, $log_id );
	update_field( 'amount_paid', $amount_paid, $log_id );
	update_field( 'mode_of_payment', $mode_of_payment, $log_id );
	update_field( 'payment_date', $payment_date, $log_id );
	update_field( 'name_of_the_bank', $bank_name, $log_id );

	// Create the site is it does not already exist.
	echo '<div class="notice updated" id="message"><p>' . __( 'New log added successfully.', 'core-functions' ) . '</p></div>';
}
?>
<div class="wrap">
	<h1><?php esc_html_e( 'Payment Information', 'core-functions' ); ?></h1>
	<form class="cf-new-learning-lounge-log-form" action="" method="POST">
		<h4><?php esc_html_e( 'Fill in the details below to add a new log.', 'core-functions' ); ?></h4>
		<table class="form-table">
			<tbody>
				<!-- FIELD: STUDENT NAME -->
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

				<!-- FIELD: COURSE OPTED -->
				<tr>
					<th scope="row"><label for="course-opted"><?php esc_html_e( 'Course Opted', 'core-functions' ); ?><span class="required">*</span></label></th>
					<td>
						<input type="text" name="course-opted" id="course-opted" class="regular-text" required />
						<p class="cf-form-description-text"><?php esc_html_e( 'Which course did you opt?', 'core-functions' ); ?></p>
					</td>
				</tr>

				<!-- FIELD: AMOUNT PAID -->
				<tr>
					<th scope="row"><label for="amount-paid"><?php esc_html_e( 'Amount Paid (₹)', 'core-functions' ); ?><span class="required">*</span></label></th>
					<td>
						<input type="text" name="amount-paid" id="amount-paid" class="regular-text" onkeypress="return /[0-9]/i.test(event.key)" required />
						<p class="cf-form-description-text"><?php esc_html_e( 'How much did the student pay?', 'core-functions' ); ?></p>
					</td>
				</tr>

				<!-- FIELD: MODE OF PAYMENT -->
				<tr>
					<th scope="row"><label for="mode-of-payment"><?php esc_html_e( 'Mode of Payment', 'core-functions' ); ?><span class="required">*</span></label></th>
					<td>
						<select name="mode-of-payment" id="mode-of-payment" required>
							<option value=""><?php esc_html_e( '--Select--', 'core-functions' ); ?></option>
							<option value="cash"><?php esc_html_e( 'Cash', 'core-functions' ); ?></option>
							<option value="neft"><?php esc_html_e( 'NEFT', 'core-functions' ); ?></option>
							<option value="upi"><?php esc_html_e( 'UPI', 'core-functions' ); ?></option>
						</select>
						<p class="cf-form-description-text"><?php esc_html_e( 'How was the payment made?', 'core-functions' ); ?></p>
					</td>
				</tr>

				<!-- FIELD: PAYMENT DATE -->
				<tr>
					<th scope="row"><label for="payment-date"><?php esc_html_e( 'Date of Payment', 'core-functions' ); ?><span class="required">*</span></label></th>
					<td>
						<input type="date" name="payment-date" id="payment-date" class="regular-text" required />
						<p class="cf-form-description-text"><?php esc_html_e( 'When was the payment done?', 'core-functions' ); ?></p>
					</td>
				</tr>

				<!-- FIELD: BANK NAME -->
				<tr class="cf-bank-name-field">
					<th scope="row"><label for="bank-name"><?php esc_html_e( 'Name of the Bank', 'core-functions' ); ?><span class="required">*</span></label></th>
					<td>
						<input type="text" name="bank-name" id="bank-name" class="regular-text" required />
						<p class="cf-form-description-text"><?php esc_html_e( 'From which bank was the payment initiated?', 'core-functions' ); ?></p>
					</td>
				</tr>

				<!-- FIELD: TRANSACTION ID -->
				<tr class="cf-transaction-id-field">
					<th scope="row"><label for="transaction-id"><?php esc_html_e( 'Transaction ID', 'core-functions' ); ?><span class="required">*</span></label></th>
					<td>
						<input type="text" name="transaction-id" id="transaction-id" class="regular-text" required />
						<p class="cf-form-description-text"><?php esc_html_e( 'Put in the transaction ID for verification purposes.', 'core-functions' ); ?></p>
					</td>
				</tr>
			</tbody>
		</table>
		<?php wp_nonce_field( 'new-learning-lounge-log', 'new-learning-lounge-log-nonce' );
		submit_button( __( 'Submit', 'core-functions' ), 'submit', 'add-new-learning-lounge-log' ); ?>
	</form>
</div>
