jQuery(document).ready( function( $ ) {
	'use strict';

	// Localized variables.
	var ajaxurl            = CF_Public_JS_Script_Vars.ajaxurl;
	var show_password_text = CF_Public_JS_Script_Vars.show_password_text;
	var hide_password_text = CF_Public_JS_Script_Vars.hide_password_text;

	// cf_show_notification( 'fa fa-check', 'Success', 'Invoice created', 'success' );
	// setTimeout( function () {
	// 	cf_hide_notification();
	// }, 5000 );

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

	// Close the notification.
	$( document ).on( 'click', '.notification_close', function() {
		cf_hide_notification();
	} );

	// Submit the data for therapist registration.
	$( document ).on( 'click', 'input[name="register-therapist-button"]', function() {
		var first_name        = $( '#therapist-first-name' ).val();
		var last_name         = $( '#therapist-last-name' ).val();
		var phone             = $( '#therapist-phone' ).val();
		var password          = $( '#therapist-password' ).val();
		var email             = $( '#therapist-email' ).val();
		var dob               = $( '#therapist-dob' ).val();
		var gender            = $( '#therapist-gender' ).val();
		var temporary_address = $( '.therapist-temporary-address' ).val();
		var permanent_address = $( '.therapist-permanent-address' ).val();
		var agree_tos         = ( $( '#therapist-registration-terms-n-conditions-acceptance' ).is( 'checked' ) ) ? true : false;
		var error_message     = '';

		console.log( 'agree_tos', agree_tos );

		// Validate first name.
		if ( -1 === is_valid_string( first_name ) ) {
			error_message += '<li>First name is required.</li>';
		}

		// Validate last name.
		if ( -1 === is_valid_string( last_name ) ) {
			error_message += '<li>Last name is required.</li>';
		}

		// Validate password.
		if ( -1 === is_valid_string( password ) ) {
			error_message += '<li>Password is required.</li>';
		} else if ( 8 > password.length ) {
			error_message += '<li>Password should be min. 8 characters length.</li>';
		}

		// Validate email.
		if ( -1 === is_valid_string( email ) ) {
			error_message += '<li>Email is required.</li>';
		} else if ( -1 === is_valid_email( email ) ) {
			error_message += '<li>Email is of invalid format.</li>';
		}

		// Validate permanent address.
		if ( -1 === is_valid_string( permanent_address ) ) {
			error_message += '<li>Permanent address is required.</li>';
		}

		// Validate the terms of service checkbox.
		if ( false === agree_tos ) {
			error_message += '<li>You must agree to the terms of service before proceeding for registration.</li>';
		}

		// Display the error message if there are.
		if ( 0 < error_message.length ) {
			error_message = '<ol>' + error_message + '</ol>';
			cf_show_notification( 'fa fa-warning', 'Error', error_message, 'error' );
			setTimeout( function () {
				cf_hide_notification();
			}, 8000 );

			return false;
		}

		// If you're here, means everything is OK, proceed for registering the user.
		console.log( 'first_name', first_name );
		console.log( 'last_name', last_name );
		console.log( 'phone', phone );
		console.log( 'password', password );
		console.log( 'email', email );
		console.log( 'dob', dob );
		console.log( 'gender', gender );
		console.log( 'temporary_address', temporary_address );
		console.log( 'permanent_address', permanent_address );
		console.log( 'agree_tos', agree_tos );
	} );

	// Datepicker for date of birth fields.
	if ( $( '.cf__date__field' ).length ) {
		$( '.cf__date__field#therapist-dob' ).datepicker( {
			dateFormat: 'mm-dd-yy',
			onSelect: function( dateText, inst ) {
				$( '.cf__date__field' ).parent( 'span' ).addClass( 'input--filled' );
			},
			maxDate: 0
		} );

		$( '.cf__date__field' ).inputmask( { 'mask': '99-99-9999'} );
	}

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

	/**
	 * Check if email is valid.
	 * 
	 * @param {string} email 
	 */
	 function is_valid_email( email ) {
		var email_regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if ( ! email_regex.test( email ) ) {
			return -1;
		} else {
			return 1;
		}
	}

	/**
     * Function to hide notification
     */
	 function cf_hide_notification() {
        $( '.notification_popup' ).removeClass( 'active' );
    }

    /**
     * Function defined to show the notification.
     *
     * @param icon_class
     * @param header_text
     * @param message
     * @param success_or_error
     */
    function cf_show_notification( icon_class, header_text, message, success_or_error ) {
		$( '.notification_popup .notification_icon i' ).removeClass().addClass( icon_class );
		$( '.notification_popup .notification_message h3' ).html( header_text );
		$( '.notification_popup .notification_message p' ).html( message );
		$( '.notification_popup').removeClass( 'is-success is-error' );
		
		// Add classes based on success|error.
		if ( 'error' === success_or_error ) {
			$( '.notification_popup' ).addClass( 'active is-error' );
		} else if ( 'success' === success_or_error ) {
			$( '.notification_popup' ).addClass( 'active is-success' );
		}
    }
} );
