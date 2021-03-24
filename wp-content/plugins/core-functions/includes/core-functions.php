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
