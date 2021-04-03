<?php
/**
 * This file is used for writing all the re-usable custom functions.
 *
 * @since 1.0.0
 * @package Core_Functions
 * @subpackage Core_Functions/includes
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

/**
 * Fetch the user full name.
 *
 * @param $user_id int Holds the user ID.
 * @return string
 */
function cf_get_user_full_name( $user_id ) {
	$first_name = get_user_meta( $user_id, 'first_name', true );
	$last_name  = get_user_meta( $user_id, 'last_name', true );

	return "{$first_name} {$last_name}";
}

/**
 * Get the time based text.
 *
 * @return string
 */
function cf_get_time_based_text() {
	$text         = '';
	$current_time = gmdate( 'H:i:s' );

	if ( have_rows( 'good_morning_good_evening_texts', 'option' ) ) {
		while( have_rows( 'good_morning_good_evening_texts', 'option' ) ) {
			the_row();
			$start_time = get_sub_field( 'start_time' );
			$end_time   = get_sub_field( 'end_time' );
			$is_between = cf_time_is_between_two_times( $start_time, $end_time, $current_time );

			if ( $is_between ) {
				$text = get_sub_field( 'time_dependant_text' );
			}
		}
	}

	return $text;
}

/**
 * Check if a time falls in between 2 time values. Format - H:i:s
 *
 * @param $from string Holds the from time.
 * @param $till string Holds the till time.
 * @param $input string Holds the input time.
 * @return boolean
 */
function cf_time_is_between_two_times( $from, $till, $input ) {
	$f = DateTime::createFromFormat( 'H:i:s', $from );
	$t = DateTime::createFromFormat( 'H:i:s', $till );
	$i = DateTime::createFromFormat( 'H:i:s', $input );

	if ( $f > $t ) {
		$t->modify('+1 day');
	}

	return ( $f <= $i && $i <= $t ) || ( $f <= $i->modify( '+1 day' ) && $i <= $t );
}

/**
 * Returns the image source by attachment id.
 *
 * @param int $attachment_id Holds the attachment ID.
 * @return boolean|string
 */
function cf_get_image_url_by_attachment_id( $attachment_id ) {
	// Return false, if the attachment ID is empty.
	if ( empty( $attachment_id ) ) {
		return false;
	}

	return apply_filters( 'cf_prayatna_image_source', wp_get_attachment_url( $attachment_id ), $attachment_id );
}

/**
 * Check to see if the asked user is a therapist.
 *
 * @param int $user_id Holds the user ID.
 * @return boolean
 */
function cf_is_user_therapist( $user_id ) {
	$user = get_userdata( $user_id );

	if ( empty( $user->roles ) || ! is_array( $user->roles ) ) {
		return false;
	}

	if ( ! in_array( 'therapist', $user->roles, true ) ) {
		return false;
	}

	return true;
}

/**
 * Check to see if the asked user is a client.
 *
 * @param int $user_id Holds the user ID.
 * @return boolean
 */
function cf_is_user_client( $user_id ) {
	$user = get_userdata( $user_id );

	if ( empty( $user->roles ) || ! is_array( $user->roles ) ) {
		return false;
	}

	if ( ! in_array( 'client', $user->roles, true ) ) {
		return false;
	}

	return true;
}

/**
 * Return child's profile registration fields.
 *
 * @param int $index Holds the html index.
 * @return string
 */
function cf_get_child_profile_registration_fields_html( $index ) {
	ob_start();
	?>
	<div class="child-<?php echo esc_attr( $index ); ?> child-profile-fields">
		<!-- FIRST NAME -->
		<div class="col-md-6">
			<span class="input input--hfd">
				<input class="input__field input__field--hfd" type="text" name="child-first-name" id="child-first-name" required onkeypress="return /[a-z]/i.test(event.key)" />
				<label class="input__label input__label--hfd" for="child-first-name">
					<span class="input__label-content input__label-content--hfd "><?php esc_html_e( 'First Name*', 'core-functions' ); ?></span>
				</label>
			</span>
		</div>
		<!-- LAST NAME -->
		<div class="col-md-6">
			<span class="input input--hfd">
				<input class="input__field input__field--hfd" type="text" name="child-last-name" id="child-last-name" required onkeypress="return /[a-z]/i.test(event.key)" />
				<label class="input__label input__label--hfd" for="child-last-name">
					<span class="input__label-content input__label-content--hfd "><?php esc_html_e( 'Last Name*', 'core-functions' ); ?></span>
				</label>
			</span>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
