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
							<span class="input__label-content input__label-content--hfd cognify-text-color"><?php esc_html_e( 'First Name*', 'cognify-core' ); ?></span>
						</label>
					</span>
				</div>
				<!-- LAST NAME -->
				<div class="col-md-6">
					<span class="input input--hfd">
						<input class="input__field input__field--hfd" type="text" value="<?php echo esc_html( $last_name ); ?>" name="therapist-last-name" id="therapist-last-name" required onkeypress="return /[a-z]/i.test(event.key)" />
						<label class="input__label input__label--hfd" for="therapist-last-name">
							<span class="input__label-content input__label-content--hfd cognify-text-color"><?php esc_html_e( 'Last Name*', 'cognify-core' ); ?></span>
						</label>
					</span>
				</div>
				<!-- PHONE NUMBER -->
				<div class="col-md-6 top__margin__10 cognify_user_registration_phone_field">
					<span class="input input--hfd">
						<input class="input__field input__field--hfd" type="text" value="<?php echo esc_html( $phone ); ?>" maxlength="10" name="therapist-phone" id="therapist-phone" required onkeypress="return /[0-9]/i.test(event.key)" />
						<label class="input__label input__label--hfd" for="therapist-phone">
							<span class="input__label-content input__label-content--hfd cognify-text-color"><?php esc_html_e( 'Phone*', 'cognify-core' ); ?></span>
						</label>
					</span>
				</div>
				<!-- SEND OTP -->
				<!-- <div class="col-md-6 top__margin__10 cognify_send_otp_button_field dnone">
					<input type="hidden" id="registration_user" value="therapist" />
					<button type="button" class="btn btn-secondary cognify-button" data-toggle="modal" data-target="#cognify_send_otp_modal"><?php // esc_html_e( 'Send OTP', 'cognify-core' ); ?></button>
				</div> -->
				<!-- EMAIL -->
				<div class="col-md-6 top__margin__10 cognify_user_registration_email_field">
					<span class="input input--hfd">
						<input class="input__field input__field--hfd" type="email" value="<?php echo esc_html( $email ); ?>" name="therapist-email" id="therapist-email" required />
						<label class="input__label input__label--hfd" for="therapist-email">
							<span class="input__label-content input__label-content--hfd cognify-text-color"><?php esc_html_e( 'Email*', 'cognify-core' ); ?></span>
						</label>
					</span>
				</div>
				<!-- DOB -->
				<div class="col-md-6 top__margin__10">
					<span class="input input--hfd">
						<input class="input__field input__field--hfd cognify__date__field" type="text" value="<?php echo esc_html( $dob ); ?>" name="therapist-dob" id="therapist-dob" required />
						<label class="input__label input__label--hfd" for="therapist-dob">
							<span class="input__label-content input__label-content--hfd cognify-text-color"><?php esc_html_e( 'Date of Birth* (MM-DD-YYYY)', 'cognify-core' ); ?></span>
						</label>
					</span>
				</div>
				<!-- GENDER -->
				<div class="col-md-6 top__margin__10 therapist-gender-div">
					<select multiple data-max-options="1" name="therapist-gender" data-style="rounded-pill px-4 py-3 shadow-sm" class="gender-selectpicker w-75">
						<option <?php echo ( ! empty( $gender ) && 'male' === $gender ) ? 'selected' : ''; ?> value="male"><?php esc_html_e( 'Male', 'cognify-core' ); ?></option>
						<option <?php echo ( ! empty( $gender ) && 'female' === $gender ) ? 'selected' : ''; ?> value="female"><?php esc_html_e( 'Female', 'cognify-core' ); ?></option>
						<option <?php echo ( ! empty( $gender ) && 'other' === $gender ) ? 'selected' : ''; ?> value="other"><?php esc_html_e( 'Other', 'cognify-core' ); ?></option>
					</select>
				</div>
				<!-- PASSWORD -->
				<div class="col-md-6 top__margin__10">
					<span class="input input--hfd">
						<input class="input__field input__field--hfd" type="password" name="therapist-password" id="therapist-password" required />
						<label class="input__label input__label--hfd" for="therapist-password">
							<span class="input__label-content input__label-content--hfd cognify-text-color"><?php esc_html_e( 'Password*', 'cognify-core' ); ?></span>
						</label>
					</span>
					<div class="cognify-toggle-password">
						<input type="checkbox" id="toggle-password" />
						<label for="toggle-password" class="cognify-text-color"><?php esc_html_e( 'Show Password', 'cognify-core' ); ?></label>
					</div>
				</div>
				<!-- QUALIFICATION -->
				<div class="col-md-6 top__margin__10">
					<span class="input input--hfd">
						<input class="input__field input__field--hfd" type="text" value="<?php echo esc_html( $qualification ); ?>" name="therapist-qualification" id="therapist-qualification" required />
						<label class="input__label input__label--hfd" for="therapist-qualification">
							<span class="input__label-content input__label-content--hfd cognify-text-color"><?php esc_html_e( 'Qualification*', 'cognify-core' ); ?></span>
						</label>
					</span>
				</div>
				<!-- YEARS OF EXPERIENCE -->
				<div class="col-md-6 top__margin__10">
					<span class="input input--hfd">
						<input class="input__field input__field--hfd" type="number" value="<?php echo esc_html( $experience ); ?>" step="0.1" min="0.1" name="therapist-experience" id="therapist-experience" required />
						<label class="input__label input__label--hfd" for="therapist-experience">
							<span class="input__label-content input__label-content--hfd cognify-text-color"><?php esc_html_e( 'Years of Experience*', 'cognify-core' ); ?></span>
						</label>
					</span>
				</div>
				<!-- CONSULTATION FEES -->
				<!-- <div class="col-md-6 top__margin__10">
					<span class="input input--hfd">
						<input class="input__field input__field--hfd" type="number" value="<?php // echo esc_html( $fees ); ?>" step="0.01" min="0.01" name="therapist-fees" id="therapist-fees" required />
						<label class="input__label input__label--hfd" for="therapist-fees">
							<span class="input__label-content input__label-content--hfd cognify-text-color"><?php // esc_html_e( 'Consultation Fees*', 'cognify-core' ); ?></span>
						</label>
					</span>
				</div> -->
				<!-- BRIEF DESCRIPTION -->
				<div class="col-md-6 top__margin__10">
					<textarea required name="therapist-brief-description" placeholder="<?php esc_html_e( 'Write something about yourself..', 'cognify-core' ); ?>" class="form-control therapist-brief-description" rows="3"><?php echo esc_html( $short_desc ); ?></textarea>
				</div>
				<!-- SPECIALITIES -->
				<div class="col-md-6 top__margin__10 therapist-specialities-div">
					<select name="therapist-specialities[]" multiple data-style="rounded-pill px-4 py-3 shadow-sm" class="specialities-selectpicker w-75">
					<?php
						if ( have_rows( 'cognify_therapists_specialities_list', 'option' ) ) {
							while ( have_rows( 'cognify_therapists_specialities_list', 'option' ) ) {
								the_row();
								$speciality = get_sub_field( 'speciality' );
								$selected   = ( ! empty( $specialities ) && in_array( $speciality, $specialities ) ) ? 'selected' : '';
								echo "<option {$selected} value='{$speciality}'>{$speciality}</option>";
							}
						}
						?>
					</select>
				</div>
				<!-- PROFILE PICTURE -->
				<div class="col-md-12 top__margin__10">
					<div class="custom-file therapist-profile-picture">
						<input type="file" class="custom-file-input" id="therapist-profile-picture" name="therapist-profile-picture" required>
						<label class="custom-file-label cognify-text-light-color" for="therapist-profile-picture"><?php esc_html_e( 'Upload Your Profile Picture. (maximum size 500Kb)*', 'cognify-core' ); ?></label>
					</div>
				</div>
				<!-- QUALIFICATION DOCUMENT(S) -->
				<div class="col-md-12 top__margin__10">
					<div class="custom-file therapist-qualification-document">
						<input type="file" class="custom-file-input" id="therapist-qualification-document" name="therapist-qualification-document[]" multiple required>
						<label class="custom-file-label cognify-text-light-color" for="therapist-qualification-document"><?php esc_html_e( 'Upload your qualification document(s)*', 'cognify-core' ); ?></label>
						<span class="cognify-therapist-qualification-documents-error" style="display: none;"><?php esc_html_e( 'You can upload only 5 files at maximum.', 'cognify-core' ); ?></span>
					</div>
				</div>
				<!-- TERMS & CONDITIONS ACCEPTANCE -->
				<div class="col-md-12 top__margin__10">
					<div class="custom-control custom-checkbox counselee-registration-acceptance">
						<input type="checkbox" class="custom-control-input" id="counselee-registration-terms-n-conditions-acceptance" required />
						<label class="custom-control-label cognify-text-light-color" for="counselee-registration-terms-n-conditions-acceptance">
							<?php echo sprintf( __( 'By clicking Sign Up, you agree to our %3$sTerms of Services%2$s and %1$sPrivacy Policy%2$s. You may receive SMS/Email notifications from us and can opt out at any time.', 'cognify-core' ), '<a class="cognify-seagreen-text-color" href="/privacy-policy/">', '</a>', '<a class="cognify-seagreen-text-color" href="/terms-of-services-therapist/">' ); ?>
						</label>
					</div>
				</div>
				<!-- SUBMIT -->
				<div class="col-md-6 top__margin__10 cognify_user_registration_button">
					<input class="btn btn-secondary cognify-button" type="submit" name="register-therapist-button" value="<?php esc_html_e( 'Register as therapist', 'cognify-core' ); ?>">
				</div>
			</div>
		</form>
	</section>
</div>
