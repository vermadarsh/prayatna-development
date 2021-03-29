jQuery(document).ready( function( $ ) {
	'use strict';

	// Localized variables.
	var ajaxurl            = CF_Public_JS_Script_Vars.ajaxurl;
	var show_password_text = CF_Public_JS_Script_Vars.show_password_text;
	var hide_password_text = CF_Public_JS_Script_Vars.hide_password_text;

	// cf_show_notification( 'fa fa-warning', 'Error', 'Sample error message', 'error' );
	// setTimeout( function () {
	// 	cf_hide_notification();
	// }, 5000 );

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
