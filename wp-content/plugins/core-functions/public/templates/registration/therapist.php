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
?>
<div class="container">
	<section class="content">
		<form method="POST" action="" enctype="multipart/form-data">
			<div class="row">
				<!-- FIRST NAME -->
				<div class="col-md-6">
					<span class="input input--hfd">
						<input class="input__field input__field--hfd" type="text" value="<?php echo esc_html( $first_name ); ?>" name="therapist-first-name" id="therapist-first-name" required onkeypress="return /[a-z]/i.test(event.key)" />
						<label class="input__label input__label--hfd" for="therapist-first-name">
							<span class="input__label-content input__label-content--hfd "><?php esc_html_e( 'First Name*', 'core-functions' ); ?></span>
						</label>
					</span>
				</div>
				<!-- LAST NAME -->
				<div class="col-md-6">
					<span class="input input--hfd">
						<input class="input__field input__field--hfd" type="text" value="<?php echo esc_html( $last_name ); ?>" name="therapist-last-name" id="therapist-last-name" required onkeypress="return /[a-z]/i.test(event.key)" />
						<label class="input__label input__label--hfd" for="therapist-last-name">
							<span class="input__label-content input__label-content--hfd "><?php esc_html_e( 'Last Name*', 'core-functions' ); ?></span>
						</label>
					</span>
				</div>
				<!-- PHONE NUMBER -->
				<div class="col-md-6 top__margin__10 cf_user_registration_phone_field">
					<span class="input input--hfd">
						<input class="input__field input__field--hfd" type="text" value="<?php echo esc_html( $phone ); ?>" maxlength="10" name="therapist-phone" id="therapist-phone" required onkeypress="return /[0-9]/i.test(event.key)" />
						<label class="input__label input__label--hfd" for="therapist-phone">
							<span class="input__label-content input__label-content--hfd "><?php esc_html_e( 'Phone*', 'core-functions' ); ?></span>
						</label>
					</span>
				</div>
				<!-- PASSWORD -->
				<div class="col-md-6 top__margin__10">
					<span class="input input--hfd">
						<input class="input__field input__field--hfd" type="password" name="therapist-password" id="therapist-password" required />
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
						<input class="input__field input__field--hfd" type="email" value="<?php echo esc_html( $email ); ?>" name="therapist-email" id="therapist-email" required />
						<label class="input__label input__label--hfd" for="therapist-email">
							<span class="input__label-content input__label-content--hfd "><?php esc_html_e( 'Email*', 'core-functions' ); ?></span>
						</label>
					</span>
				</div>
				<!-- DOB -->
				<div class="col-md-6 top__margin__10">
					<span class="input input--hfd">
						<input class="input__field input__field--hfd cf__date__field" type="text" value="<?php echo esc_html( $dob ); ?>" name="therapist-dob" id="therapist-dob" required />
						<label class="input__label input__label--hfd" for="therapist-dob">
							<span class="input__label-content input__label-content--hfd "><?php esc_html_e( 'Date of Birth* (MM-DD-YYYY)', 'core-functions' ); ?></span>
						</label>
					</span>
				</div>
				<!-- GENDER -->
				<div class="col-md-6 top__margin__10 therapist-gender-div">
					<select multiple data-max-options="1" name="therapist-gender" data-style="rounded-pill px-4 py-3 shadow-sm" class="gender-selectpicker w-75">
						<option <?php echo ( ! empty( $gender ) && 'male' === $gender ) ? 'selected' : ''; ?> value="male"><?php esc_html_e( 'Male', 'core-functions' ); ?></option>
						<option <?php echo ( ! empty( $gender ) && 'female' === $gender ) ? 'selected' : ''; ?> value="female"><?php esc_html_e( 'Female', 'core-functions' ); ?></option>
						<option <?php echo ( ! empty( $gender ) && 'other' === $gender ) ? 'selected' : ''; ?> value="other"><?php esc_html_e( 'Other', 'core-functions' ); ?></option>
					</select>
				</div>
				<!-- PROFILE PICTURE -->
				<div class="col-md-12 top__margin__10">
					<div class="custom-file therapist-profile-picture">
						<input type="file" class="custom-file-input" id="therapist-profile-picture" name="therapist-profile-picture" required>
						<label class="custom-file-label" for="therapist-profile-picture"><?php esc_html_e( 'Upload Your Profile Picture. (maximum size 500Kb)*', 'core-functions' ); ?></label>
					</div>
				</div>
				<!-- TERMS & CONDITIONS ACCEPTANCE -->
				<div class="col-md-12 top__margin__10">
					<div class="custom-control custom-checkbox counselee-registration-acceptance">
						<input type="checkbox" class="custom-control-input" id="counselee-registration-terms-n-conditions-acceptance" required />
						<label class="custom-control-label" for="counselee-registration-terms-n-conditions-acceptance">
							<?php echo sprintf( __( 'By clicking Sign Up, you agree to our %3$sTerms of Services%2$s and %1$sPrivacy Policy%2$s. You may receive SMS/Email notifications from us and can opt out at any time.', 'core-functions' ), '<a class="" href="/privacy-policy/">', '</a>', '<a class="" href="/terms-of-services-therapist/">' ); ?>
						</label>
					</div>
				</div>
				<!-- SUBMIT -->
				<div class="col-md-6 top__margin__10 cf_user_registration_button">
					<input class="btn btn-secondary" type="submit" name="register-therapist-button" value="<?php esc_html_e( 'Register as therapist', 'core-functions' ); ?>">
				</div>
			</div>
		</form>
	</section>
</div>
