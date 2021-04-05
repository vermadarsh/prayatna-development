<?php
/**
 * This file holds the markup for adding new learning lounge log by the student.
 *
 * @since   1.0.0
 * @package Core_Functions
 * @subpackage Core_Functions/admin/templates/cpt-learning-lounge-log
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.
?>
<div class="wrap">
	<h1><?php esc_html_e( 'Register for Learning Lounge', 'core-functions' ); ?></h1>
	<form class="cf-new-learning-lounge-log-form" action="" method="POST">
		<h4><?php esc_html_e( 'Fill in the details below to add a new log.', 'core-functions' ); ?></h4>
		<table class="form-table">
			<tbody>
				<!-- FIELD: STUDENT NAME -->
				<tr>
					<th scope="row"><label for="student-name"><?php esc_html_e( 'Student Name', 'core-functions' ); ?></label></th>
					<td>
						<input type="text" name="student-name" id="student-name" class="regular-text" required />
						<p class="cf-form-description-text"><?php esc_html_e( 'Your name goes here.', 'core-functions' ); ?></p>
					</td>
				</tr>
			</tbody>
		</table>
		<?php wp_nonce_field( 'new-learning-lounge-log', 'new-learning-lounge-log-nonce' );
		submit_button( __( 'Submit', 'core-functions' ), 'submit', 'add-new-learning-lounge-log' ); ?>
	</form>
</div>
