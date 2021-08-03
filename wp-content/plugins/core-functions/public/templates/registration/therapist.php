<?php
/**
 * HTML markup for the therapist registration.
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
					<input class="width__100_percent input__field input__field--hfd" type="text" name="therapist-first-name" id="therapist-first-name" onkeypress="return /[a-z]/i.test(event.key)" />
					<label class="input__label input__label--hfd" for="therapist-first-name">
						<span class="input__label-content input__label-content--hfd "><?php esc_html_e( 'First Name*', 'core-functions' ); ?></span>
					</label>
				</span>
			</div>
			<!-- LAST NAME -->
			<div class="col-md-6">
				<span class="input input--hfd">
					<input class="width__100_percent input__field input__field--hfd" type="text" name="therapist-last-name" id="therapist-last-name" onkeypress="return /[a-z]/i.test(event.key)" />
					<label class="input__label input__label--hfd" for="therapist-last-name">
						<span class="input__label-content input__label-content--hfd "><?php esc_html_e( 'Last Name*', 'core-functions' ); ?></span>
					</label>
				</span>
			</div>
			<!-- PHONE NUMBER -->
			<div class="col-md-6 top__margin__10 cf_user_registration_phone_field">
				<span class="input input--hfd">
					<input class="width__100_percent input__field input__field--hfd" type="text" maxlength="10" minlength="10" name="therapist-phone" id="therapist-phone" onkeypress="return /[0-9]/i.test(event.key)" />
					<label class="input__label input__label--hfd" for="therapist-phone">
						<span class="input__label-content input__label-content--hfd "><?php esc_html_e( 'Phone* (+91)', 'core-functions' ); ?></span>
					</label>
				</span>
			</div>
			<!-- PASSWORD -->
			<div class="col-md-6 top__margin__10">
				<span class="input input--hfd">
					<input class="width__100_percent input__field input__field--hfd" type="password" name="therapist-password" id="therapist-password" />
					<label class="input__label input__label--hfd" for="therapist-password">
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
					<input class="input__field input__field--hfd" type="email" name="therapist-email" id="therapist-email" />
					<label class="input__label input__label--hfd" for="therapist-email">
						<span class="input__label-content input__label-content--hfd "><?php esc_html_e( 'Email*', 'core-functions' ); ?></span>
					</label>
				</span>
			</div>
			<!-- DOB -->
			<div class="col-md-6 top__margin__10">
				<span class="input input--hfd">
					<input class="width__100_percent input__field input__field--hfd cf__date__field" type="text" name="therapist-dob" id="therapist-dob" />
					<label class="input__label input__label--hfd" for="therapist-dob">
						<span class="input__label-content input__label-content--hfd "><?php esc_html_e( 'DOB* (DD-MM-YYYY)', 'core-functions' ); ?></span>
					</label>
				</span>
			</div>
			<!-- GENDER -->
			<div class="col-md-6 top__margin__10 therapist-gender-div">
				<select name="therapist-gender" id="therapist-gender" class="width__100_percent">
					<option value=""><?php esc_html_e( 'Gender*', 'core-functions' ); ?></option>
					<option value="male"><?php esc_html_e( 'Male', 'core-functions' ); ?></option>
					<option value="female"><?php esc_html_e( 'Female', 'core-functions' ); ?></option>
					<option value="other"><?php esc_html_e( 'Other', 'core-functions' ); ?></option>
				</select>
			</div>
			<!-- TEMPORARY ADDRESS -->
			<div class="col-md-6 top__margin__10">
				<textarea placeholder="<?php esc_html_e( 'Temporary address', 'cognify-core' ); ?>" class="form-control therapist-temporary-address" rows="3"></textarea>
			</div>
			<!-- PERMANENT ADDRESS -->
			<div class="col-md-6 top__margin__10">
				<textarea placeholder="<?php esc_html_e( 'Permanent address', 'cognify-core' ); ?>" class="form-control therapist-permanent-address" rows="3"></textarea>
			</div>
			<!-- PROFILE PICTURE -->
			<div class="col-md-12 top__margin__10">
				<div class="custom-file therapist-profile-picture">
					<input type="file" class="custom-file-input" id="therapist-profile-picture" name="therapist-profile-picture">
					<label class="custom-file-label" for="therapist-profile-picture"><?php esc_html_e( 'Upload Your Profile Picture. (maximum size 500Kb)*', 'core-functions' ); ?></label>
				</div>
			</div>
			<!-- FIRST NAME -->
			<div class="col-md-12">
				<span class="input input--hfd">
					<input class="width__100_percent input__field input__field--hfd" type="number" name="therapist-salary" id="therapist-salary" onkeypress="return /[0-9]/i.test(event.key)" />
					<label class="input__label input__label--hfd" for="therapist-salary">
						<span class="input__label-content input__label-content--hfd "><?php esc_html_e( 'Monthly Salary*', 'core-functions' ); ?></span>
					</label>
				</span>
			</div>
			<!-- TERMS & CONDITIONS ACCEPTANCE -->
			<div class="col-md-12 top__margin__10">
				<div class="custom-control custom-checkbox therapist-registration-acceptance">
					<input type="checkbox" class="custom-control-input" id="therapist-registration-terms-n-conditions-acceptance" />
					<label class="custom-control-label" for="therapist-registration-terms-n-conditions-acceptance">
						<?php echo sprintf( __( 'By clicking Sign Up, you agree to our %3$sTerms of Services%2$s and %1$sPrivacy Policy%2$s. You may receive SMS/Email notifications from us and can opt out at any time.', 'core-functions' ), '<a class="" href="/privacy-policy/">', '</a>', '<a class="" href="/terms-of-services-therapist/">' ); ?>
					</label>
				</div>
			</div>
			<!-- SUBMIT -->
			<div class="col-md-6 top__margin__10 cf_user_registration_button">
				<input class="btn btn-secondary" type="button" name="register-therapist-button" value="<?php esc_html_e( 'Register as Therapist', 'core-functions' ); ?>">
			</div>
		</div>
	</section>
</div>
