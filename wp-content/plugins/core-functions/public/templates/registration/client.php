<?php
/**
 * HTML markup for the client registration.
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
		<h3 class="cf-registration-subheading"><?php esc_html_e( 'Parent Basic Details', 'core-functions' ); ?></h3>
		<div class="row">
			<!-- FIRST NAME -->
			<div class="col-md-6">
				<span class="input input--hfd">
					<input class="width__100_percent input__field input__field--hfd" type="text" name="client-first-name" id="client-first-name" onkeypress="return /[a-z]/i.test(event.key)" />
					<label class="input__label input__label--hfd" for="client-first-name">
						<span class="input__label-content input__label-content--hfd "><?php esc_html_e( 'First Name*', 'core-functions' ); ?></span>
					</label>
				</span>
			</div>
			<!-- LAST NAME -->
			<div class="col-md-6">
				<span class="input input--hfd">
					<input class="width__100_percent input__field input__field--hfd" type="text" name="client-last-name" id="client-last-name" onkeypress="return /[a-z]/i.test(event.key)" />
					<label class="input__label input__label--hfd" for="client-last-name">
						<span class="input__label-content input__label-content--hfd "><?php esc_html_e( 'Last Name*', 'core-functions' ); ?></span>
					</label>
				</span>
			</div>
			<!-- PHONE NUMBER -->
			<div class="col-md-6 top__margin__10 cf_user_registration_phone_field">
				<span class="input input--hfd">
					<input class="width__100_percent input__field input__field--hfd" type="text" maxlength="10" name="client-phone" id="client-phone" onkeypress="return /[0-9]/i.test(event.key)" />
					<label class="input__label input__label--hfd" for="client-phone">
						<span class="input__label-content input__label-content--hfd "><?php esc_html_e( 'Phone* (+91)', 'core-functions' ); ?></span>
					</label>
				</span>
			</div>
			<!-- PASSWORD -->
			<div class="col-md-6 top__margin__10">
				<span class="input input--hfd">
					<input class="width__100_percent input__field input__field--hfd" type="password" name="client-password" id="client-password" />
					<label class="input__label input__label--hfd" for="client-password">
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
					<input class="input__field input__field--hfd" type="email" name="client-email" id="client-email" />
					<label class="input__label input__label--hfd" for="client-email">
						<span class="input__label-content input__label-content--hfd "><?php esc_html_e( 'Email*', 'core-functions' ); ?></span>
					</label>
				</span>
			</div>
			<!-- TEMPORARY ADDRESS -->
			<div class="col-md-6 top__margin__10">
				<textarea placeholder="<?php esc_html_e( 'Temporary address', 'cognify-core' ); ?>" class="form-control client-temporary-address" rows="3"></textarea>
			</div>
			<!-- PERMANENT ADDRESS -->
			<div class="col-md-6 top__margin__10">
				<textarea placeholder="<?php esc_html_e( 'Permanent address', 'cognify-core' ); ?>" class="form-control client-permanent-address" rows="3"></textarea>
			</div>
		</div>
		<h3 class="cf-registration-subheading top__margin__20"><?php esc_html_e( 'Child/Children Basic Details', 'core-functions' ); ?></h3>
		<div class="row top__margin__10">
			<?php echo cf_get_child_profile_registration_fields_html( 1 ); ?>
			<div class="col-md-12 top__margin__10 cf_child_addition_button">
				<input class="btn btn-secondary" type="button" value="<?php esc_html_e( 'Add child', 'core-functions' ); ?>">
			</div>
		</div>

		<div class="row">
			<!-- TERMS & CONDITIONS ACCEPTANCE -->
			<div class="col-md-12 top__margin__10">
				<div class="custom-control custom-checkbox client-registration-acceptance">
					<input type="checkbox" class="custom-control-input" id="client-registration-terms-n-conditions-acceptance" />
					<label class="custom-control-label" for="client-registration-terms-n-conditions-acceptance">
						<?php echo sprintf( __( 'By clicking Sign Up, you agree to our %3$sTerms of Services%2$s and %1$sPrivacy Policy%2$s. You may receive SMS/Email notifications from us and can opt out at any time.', 'core-functions' ), '<a class="" href="/privacy-policy/">', '</a>', '<a class="" href="/terms-of-services-client/">' ); ?>
					</label>
				</div>
			</div>
			<!-- SUBMIT -->
			<div class="col-md-6 top__margin__10 cf_user_registration_button">
				<input class="btn btn-secondary" type="button" name="register-client-button" value="<?php esc_html_e( 'Register as Client', 'core-functions' ); ?>">
			</div>
		</div>
	</section>
</div>
