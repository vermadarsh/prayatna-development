jQuery(document).ready( function( $ ) {
	'use strict';

	// Localized variables.
	var ajaxurl            = CF_Public_JS_Script_Vars.ajaxurl;
	var show_password_text = CF_Public_JS_Script_Vars.show_password_text;
	var hide_password_text = CF_Public_JS_Script_Vars.hide_password_text;

	// Show hide password.
	$( document ).on( 'click', '#toggle-password', function() {
		var this_checkbox = $( this );
		if ( ( this_checkbox ).is( ':checked' ) ) {
			$( '#therapist-password, #client-password' ).attr( 'type', 'text' );
			this_checkbox.next( 'label' ).text( hide_password_text );
		} else {
			$( '#therapist-password, #client-password' ).attr( 'type', 'password' );
			this_checkbox.next( 'label' ).text( show_password_text );
		}
	} );

	/**
	 * Block element.
	 *
	 * @param {string} $element
	 */
	 function block_element( element ) {
		element.addClass( 'non-clickable' );
	}

	/**
	 * Unblock element.
	 *
	 * @param {string} $element
	 */
	function unblock_element( element ) {
		element.removeClass( 'non-clickable' );
	}

	/**
	 * Check if a string is valid.
	 *
	 * @param {string} $data
	 */
	 function is_valid_string( data ) {
		if ( '' === data || undefined === data || ! isNaN( data ) || 0 === data ) {
			return -1;
		} else {
			return 1;
		}
	}

	/**
	 * Check if a number is valid.
	 *
	 * @param {number} $data
	 */
	function is_valid_number( data ) {
		if ( '' === data || undefined === data || isNaN( data ) || 0 === data ) {
			return -1;
		} else {
			return 1;
		}
	}
} );
