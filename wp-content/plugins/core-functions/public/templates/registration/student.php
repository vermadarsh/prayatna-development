<?php
/**
 * HTML markup for the student registration.
 *
 * @link       https://github.com/vermadarsh/
 * @since      1.0.0
 *
 * @package    Core_Functions
 * @subpackage Core_Functions/public/templates/registration
 */
defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

$heading = ( ! empty( $args['heading'] ) ) ? $args['heading'] : '';
?>
<div class="container bottom__margin__10">
	<h3 class="cf-registration-heading"><?php echo esc_html( $heading ); ?></h3>
	<section class="content">
		<div class="row">
			<!-- FIRST NAME -->
			<div class="col-md-6">
				<span class="input input--hfd">
					<input class="width__100_percent input__field input__field--hfd" type="text" name="student-first-name" id="student-first-name" onkeypress="return /[a-z]/i.test(event.key)" />
					<label class="input__label input__label--hfd" for="student-first-name">
						<span class="input__label-content input__label-content--hfd "><?php esc_html_e( 'First Name*', 'core-functions' ); ?></span>
					</label>
				</span>
			</div>
			<!-- LAST NAME -->
			<div class="col-md-6">
				<span class="input input--hfd">
					<input class="width__100_percent input__field input__field--hfd" type="text" name="student-last-name" id="student-last-name" onkeypress="return /[a-z]/i.test(event.key)" />
					<label class="input__label input__label--hfd" for="student-last-name">
						<span class="input__label-content input__label-content--hfd "><?php esc_html_e( 'Last Name*', 'core-functions' ); ?></span>
					</label>
				</span>
			</div>
			<!-- PHONE NUMBER -->
			<div class="col-md-6 top__margin__10 cf_user_registration_phone_field">
				<span class="input input--hfd">
					<input class="width__100_percent input__field input__field--hfd" type="text" maxlength="10" name="student-phone" id="student-phone" onkeypress="return /[0-9]/i.test(event.key)" />
					<label class="input__label input__label--hfd" for="student-phone">
						<span class="input__label-content input__label-content--hfd "><?php esc_html_e( 'Phone* (+91)', 'core-functions' ); ?></span>
					</label>
				</span>
			</div>
			<!-- PASSWORD -->
			<div class="col-md-6 top__margin__10">
				<span class="input input--hfd">
					<input class="width__100_percent input__field input__field--hfd" type="password" name="student-password" id="student-password" />
					<label class="input__label input__label--hfd" for="student-password">
						<span class="input__label-content input__label-content--hfd "><?php esc_html_e( 'Password*', 'core-functions' ); ?></span>
					</label>
				</span>
				<div class="cf-toggle-password">
					<input type="checkbox" id="toggle-password" />
					<label for="toggle-password" class=""><?php esc_html_e( 'Show Password', 'core-functions' ); ?></label>
				</div>
			</div>
			<!-- EMAIL -->
			<div class="col-md-12 top__margin__10 cf_user_registration_email_field">
				<span class="input input--hfd">
					<input class="input__field input__field--hfd" type="email" name="student-email" id="student-email" />
					<label class="input__label input__label--hfd" for="student-email">
						<span class="input__label-content input__label-content--hfd "><?php esc_html_e( 'Email*', 'core-functions' ); ?></span>
					</label>
				</span>
			</div>
			<!-- ADDRESS -->
			<div class="col-md-12 top__margin__10">
				<textarea placeholder="<?php esc_html_e( 'Address', 'cognify-core' ); ?>" class="form-control student-address" rows="3"></textarea>
			</div>
			<!-- DOB -->
			<div class="col-md-6 top__margin__10">
				<span class="input input--hfd">
					<input class="width__100_percent input__field input__field--hfd cf__date__field" type="text" name="student-dob" id="student-dob" />
					<label class="input__label input__label--hfd" for="student-dob">
						<span class="input__label-content input__label-content--hfd "><?php esc_html_e( 'DOB* (DD-MM-YYYY)', 'core-functions' ); ?></span>
					</label>
				</span>
			</div>
			<!-- MODE OF LEARNING -->
			<div class="col-md-6 top__margin__10">
				<select class="width__100_percent" name="student-mode-of-learning" id="student-mode-of-learning">
					<option value=""><?php esc_html_e( 'Mode of Learning*', 'core-functions' ); ?></option>
					<option value="online"><?php esc_html_e( 'Online', 'core-functions' ); ?></option>
					<option value="offline"><?php esc_html_e( 'Offline', 'core-functions' ); ?></option>
				</select>
			</div>
			<!-- EDUCATION QUALIFICATION -->
			<div class="col-md-6 top__margin__10">
				<span class="input input--hfd">
					<input class="width__100_percent input__field input__field--hfd" type="text" name="student-education-qualification" id="student-education-qualification" />
					<label class="input__label input__label--hfd" for="student-education-qualification">
						<span class="input__label-content input__label-content--hfd "><?php esc_html_e( 'Education Qualification*', 'core-functions' ); ?></span>
					</label>
				</span>
			</div>
			<!-- INSTITUTE -->
			<div class="col-md-6 top__margin__10">
				<span class="input input--hfd">
					<input class="width__100_percent input__field input__field--hfd" type="text" name="student-institute-name" id="student-institute-name" />
					<label class="input__label input__label--hfd" for="student-institute-name">
						<span class="input__label-content input__label-content--hfd "><?php esc_html_e( 'Name of the Institute*', 'core-functions' ); ?></span>
					</label>
				</span>
			</div>
			<!-- WHAT DO YOU EXPECT FROM US? -->
			<div class="col-md-12 top__margin__10">
				<textarea placeholder="<?php esc_html_e( 'What do you expect from us?', 'cognify-core' ); ?>" class="form-control student-expectation" rows="4"></textarea>
			</div>
			<!-- TERMS & CONDITIONS ACCEPTANCE -->
			<div class="col-md-12 top__margin__10">
				<div class="custom-control custom-checkbox student-registration-acceptance">
					<input type="checkbox" class="custom-control-input" id="student-registration-terms-n-conditions-acceptance" />
					<label class="custom-control-label" for="student-registration-terms-n-conditions-acceptance">
						<?php echo sprintf( __( 'By clicking Sign Up, you agree to our %3$sTerms of Services%2$s and %1$sPrivacy Policy%2$s. You may receive SMS/Email notifications from us and can opt out at any time.', 'core-functions' ), '<a class="" href="/privacy-policy/">', '</a>', '<a class="" href="/terms-of-services-therapist/">' ); ?>
					</label>
				</div>
			</div>
			<!-- SUBMIT -->
			<div class="col-md-6 top__margin__10 cf_user_registration_button">
				<input class="btn btn-secondary" type="button" name="register-student-button" value="<?php esc_html_e( 'Register as Student', 'core-functions' ); ?>">
			</div>
		</div>
	</section>
</div>
