jQuery(document).ready( function( $ ) {
	'use strict';

	// Localized variables.
	var ajaxurl               = CF_Public_JS_Script_Vars.ajaxurl;
	var show_password_text    = CF_Public_JS_Script_Vars.show_password_text;
	var hide_password_text    = CF_Public_JS_Script_Vars.hide_password_text;
	var registering_user_text = CF_Public_JS_Script_Vars.registering_user_text;

	cf_show_notification( 'fa fa-bell', 'Notice', 'Hello, you are most welcome.', 'notice' );

	// Show hide password.
	$( document ).on( 'click', '#toggle-password', function() {
		var this_checkbox = $( this );
		if ( ( this_checkbox ).is( ':checked' ) ) {
			$( '#therapist-password, #client-password, #student-password' ).attr( 'type', 'text' );
			this_checkbox.next( 'label' ).text( hide_password_text );
		} else {
			$( '#therapist-password, #client-password, #student-password' ).attr( 'type', 'password' );
			this_checkbox.next( 'label' ).text( show_password_text );
		}
	} );

	// Close the notification.
	$( document ).on( 'click', '.notification_close', function() {
		cf_hide_notification();
	} );

	// Submit the data for therapist registration.
	$( document ).on( 'click', 'input[name="register-therapist-button"]', function() {
		var this_button       = $( this );
		var this_button_text  = this_button.val();
		var first_name        = $( '#therapist-first-name' ).val();
		var last_name         = $( '#therapist-last-name' ).val();
		var phone             = $( '#therapist-phone' ).val();
		var password          = $( '#therapist-password' ).val();
		var email             = $( '#therapist-email' ).val();
		var dob               = $( '#therapist-dob' ).val();
		var gender            = $( '#therapist-gender' ).val();
		var temporary_address = $( '.therapist-temporary-address' ).val();
		var permanent_address = $( '.therapist-permanent-address' ).val();
		var profile_picture   = $( '#therapist-profile-picture' ).val();
		var agree_tos         = ( $( '#therapist-registration-terms-n-conditions-acceptance' ).is( ':checked' ) ) ? true : false;
		var error_message     = '';

		// Hide the error notification.
		cf_hide_notification();

		// Validate first name.
		if ( -1 === is_valid_string( first_name ) ) {
			error_message += '<li>First name is required.</li>';
		}

		// Validate last name.
		if ( -1 === is_valid_string( last_name ) ) {
			error_message += '<li>Last name is required.</li>';
		}

		// Validate phone.
		if ( '' === phone ) {
			error_message += '<li>Phone number is required.</li>';
		} else if ( 10 !== phone.length ) {
			error_message += '<li>Phone number is invalid.</li>';
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

		// Validate gender.
		if ( -1 === is_valid_string( gender ) ) {
			error_message += '<li>Gender is required.</li>';
		}

		// Validate permanent address.
		if ( -1 === is_valid_string( permanent_address ) ) {
			error_message += '<li>Permanent address is required.</li>';
		}

		// Validate profile picture.
		if ( -1 === is_valid_string( profile_picture ) ) {
			error_message += '<li>Profile picture is required.</li>';
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
		// Block the element now.
		block_element( this_button );

		// Change button text.
		this_button.val( registering_user_text );

		// Send the AJAX now.
		var data = {
			action: 'register_therapist',
			first_name: first_name,
			last_name: last_name,
			phone: phone,
			password: password,
			dob: dob,
			email: email,
			gender: gender,
			temporary_address: temporary_address,
			permanent_address: permanent_address,
		};
		$.ajax( {
			dataType: 'JSON',
			url: ajaxurl,
			type: 'POST',
			data: data,
			success: function ( response ) {
				// If user already exists.
				if ( 'therapist-exists' === response.data.code || 'therapist-not-created' === response.data.code ) {
					// Unblock the element.
					unblock_element( this_button );

					// Change button text.
					this_button.val( this_button_text );

					// Show the notification now.
					cf_show_notification( 'fa fa-warning', 'Error', response.data.notification_text, 'error' );
				}

				// User is created.
				if ( 'therapist-created-upload-profile-photo' === response.data.code ) {
					cf_show_notification( 'fa fa-check', 'Success', response.data.notification_text, 'success' );
					setTimeout( function () {
						cf_hide_notification();

						// Send the AJAX now for uploading the profile picture.
						var fd              = new FormData();
						var profile_picture = $( '#therapist-profile-picture' ).prop( 'files' )[0];

						// Append other data.
						fd.append( 'action', 'upload_therapist_profile_picture' );
						fd.append( 'profile_picture', profile_picture );
						fd.append( 'random_number', response.data.random_number );
						fd.append( 'user_id', response.data.user_id );
						fd.append( 'first_name', response.data.first_name );
						fd.append( 'email', response.data.email );

						$.ajax( {
							dataType: 'JSON',
							url: ajaxurl,
							type: 'POST',
							data: fd,
							cache: false,
							contentType: false,
							processData: false,
							success: function( response ) {
								// If therapist is registered.
								if ( 'therapist-registration-complete' === response.data.code ) {
									// Unblock the element.
									unblock_element( this_button );

									// Change button text.
									this_button.val( this_button_text );

									// Show the notification now.
									cf_show_notification( 'fa fa-check', 'Success', response.data.notification_text, 'success' );
									setTimeout( function () {
										location.reload();
									}, 6000 );
								}
							},
						} );
					}, 4000 );
				}
			},
		} );
	} );

	// Datepicker for date of birth fields.
	if ( $( '.cf__date__field' ).length ) {
		$( '.cf__date__field#therapist-dob' ).datepicker( {
			dateFormat: 'dd-mm-yy',
			changeMonth: true,
			changeYear: true,
			onSelect: function( dateText, inst ) {
				$( '.cf__date__field' ).parent( 'span' ).addClass( 'input--filled' );
			},
			maxDate: 0
		} );

		$( '.cf__date__field.child-dob' ).datepicker( {
			dateFormat: 'dd-mm-yy',
			changeMonth: true,
			changeYear: true,
			onSelect: function( dateText, inst ) {
				$( '.cf__date__field' ).parent( 'span' ).addClass( 'input--filled' );
			},
			maxDate: 0
		} );

		$( '.cf__date__field#student-dob' ).datepicker( {
			dateFormat: 'dd-mm-yy',
			changeMonth: true,
			changeYear: true,
			onSelect: function( dateText, inst ) {
				$( '.cf__date__field' ).parent( 'span' ).addClass( 'input--filled' );
			},
			maxDate: 0
		} );

		// Mask the date field.
		$( '.cf__date__field' ).inputmask( { 'mask': '99-99-9999'} );
	}

	// Over-write the file inpur field text when user selects the file.
	$( document ).on( 'change', '#therapist-profile-picture, #client-profile-picture', function( e ) {
		var this_input    = $( this );
		var this_input_id = this_input.attr( 'id' );
		var file_name;

		// If the file name is bigger than 40 characters, break it.
		if ( 40 < e.target.files[0].name.length ) {
			file_name     = e.target.files[0].name;
			var extension = file_name.substring( file_name.lastIndexOf( '.' ) + 1 );
			file_name     = file_name.substr( 0, 40 ) + '....' + extension;
		} else {
			file_name = e.target.files[0].name;
		}

		// Set the final file name.
		$( 'label[for="' + this_input_id + '"]' ).text( file_name );
	} );

	// Add child html on client registration page.
	$( document ).on( 'click', '.cf_child_addition_button input', function() {
		var this_button       = $( this );
		var this_button_text  = this_button.val();
		var existing_profiles = $( '.child-profile-fields' ).length;
		var index             = existing_profiles + 1;

		// Block the button.
		block_element( this_button );

		this_button.val( '...' );

		var data = {
			action: 'add_child_profile_html',
			index: index,
		};
		$.ajax( {
			dataType: 'JSON',
			url: ajaxurl,
			type: 'POST',
			data: data,
			success: function ( response ) {
				if ( 'child-profile-added' === response.data.code ) {
					// Unblock the button.
					unblock_element( this_button );

					this_button.val( this_button_text );

					$( response.data.html ).insertBefore( '.cf_child_addition_button' );

					$( '.cf__date__field.child-dob' ).datepicker( {
						dateFormat: 'mm-dd-yy',
						onSelect: function( dateText, inst ) {
							$( '.cf__date__field' ).parent( 'span' ).addClass( 'input--filled' );
						},
						maxDate: 0
					} );
				}
			},
		} );
	} );

	// Submit the data for client registration.
	$( document ).on( 'click', 'input[name="register-client-button"]', function() {
		var this_button              = $( this );
		var this_button_text         = this_button.val();
		var parent_first_name        = $( '#client-first-name' ).val();
		var parent_last_name         = $( '#client-last-name' ).val();
		var parent_phone             = $( '#client-phone' ).val();
		var parent_password          = $( '#client-password' ).val();
		var parent_email             = $( '#client-email' ).val();
		var parent_temporary_address = $( '.client-temporary-address' ).val();
		var parent_permanent_address = $( '.client-permanent-address' ).val();
		var agree_tos                = ( $( '#client-registration-terms-n-conditions-acceptance' ).is( ':checked' ) ) ? true : false;
		var children                 = [];
		var error_message            = '';
		var invalid_child_data_count = 0;

		// Collect the child details.
		$( '.child-profile-fields' ).each( function() {
			var this_div = $( this );

			// Child data.
			var child_first_name = this_div.find( '.child-first-name' ).val();
			var child_last_name  = this_div.find( '.child-last-name' ).val();
			var child_dob        = this_div.find( '.child-dob' ).val();
			var child_gender     = this_div.find( '.child-gender' ).val();

			// Validate child first name.
			if ( -1 === is_valid_string( child_first_name ) ) {
				invalid_child_data_count++;
			}

			// Validate child last name.
			if ( -1 === is_valid_string( child_last_name ) ) {
				invalid_child_data_count++;
			}

			// Validate child dob.
			if ( -1 === is_valid_string( child_dob ) ) {
				invalid_child_data_count++;
			}

			// Validate child gender.
			if ( -1 === is_valid_string( child_gender ) ) {
				invalid_child_data_count++;
			}
			
			// Put all the data in array.
			var temp_data = {
				first_name: child_first_name,
				last_name: child_last_name,
				dob: child_dob,
				gender: child_gender,
			};

			// Insert the data in array.
			children.push( temp_data );
		} );

		// Hide the error notification.
		cf_hide_notification();

		// Validate first name.
		if ( -1 === is_valid_string( parent_first_name ) ) {
			error_message += '<li>First name is required.</li>';
		}

		// Validate last name.
		if ( -1 === is_valid_string( parent_last_name ) ) {
			error_message += '<li>Last name is required.</li>';
		}

		// Validate phone.
		if ( '' === parent_phone ) {
			error_message += '<li>Phone number is required.</li>';
		} else if ( 10 !== parent_phone.length ) {
			error_message += '<li>Phone number is invalid.</li>';
		}

		// Validate password.
		if ( -1 === is_valid_string( parent_password ) ) {
			error_message += '<li>Password is required.</li>';
		} else if ( 8 > parent_password.length ) {
			error_message += '<li>Password should be min. 8 characters length.</li>';
		}

		// Validate email.
		if ( -1 === is_valid_string( parent_email ) ) {
			error_message += '<li>Email is required.</li>';
		} else if ( -1 === is_valid_email( parent_email ) ) {
			error_message += '<li>Email is of invalid format.</li>';
		}

		// Validate permanent address.
		if ( -1 === is_valid_string( parent_permanent_address ) ) {
			error_message += '<li>Permanent address is required.</li>';
		}

		// Validate children data.
		if ( 0 < invalid_child_data_count ) {
			error_message += '<li>Eithor of the child\'s data in empty or invalid.</li>';
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
		// Block the element now.
		block_element( this_button );

		// Change button text.
		this_button.val( registering_user_text );

		// Send the AJAX now.
		var data = {
			action: 'register_client',
			first_name: parent_first_name,
			last_name: parent_last_name,
			phone: parent_phone,
			password: parent_password,
			email: parent_email,
			temporary_address: parent_temporary_address,
			permanent_address: parent_permanent_address,
			children: children,
		};
		$.ajax( {
			dataType: 'JSON',
			url: ajaxurl,
			type: 'POST',
			data: data,
			success: function ( response ) {
				// If user already exists.
				if ( 'client-exists' === response.data.code || 'client-not-created' === response.data.code ) {
					// Unblock the element.
					unblock_element( this_button );

					// Change button text.
					this_button.val( this_button_text );

					// Show the notification now.
					cf_show_notification( 'fa fa-warning', 'Error', response.data.notification_text, 'error' );
				}

				// If client is registered.
				if ( 'client-registration-complete' === response.data.code ) {
					// Unblock the element.
					unblock_element( this_button );

					// Change button text.
					this_button.val( this_button_text );

					// Show the notification now.
					cf_show_notification( 'fa fa-check', 'Success', response.data.notification_text, 'success' );
					setTimeout( function () {
						location.reload();
					}, 6000 );
				}
			},
		} );
	} );

	// Submit the data for student registration.
	$( document ).on( 'click', 'input[name="register-student-button"]', function() {
		var this_button             = $( this );
		var this_button_text        = this_button.val();
		var first_name              = $( '#student-first-name' ).val();
		var last_name               = $( '#student-last-name' ).val();
		var phone                   = $( '#student-phone' ).val();
		var password                = $( '#student-password' ).val();
		var email                   = $( '#student-email' ).val();
		var address                 = $( '.student-address' ).val();
		var dob                     = $( '#student-dob' ).val();
		var mode_of_learning        = $( '#student-mode-of-learning' ).val();
		var education_qualification = $( '#student-education-qualification' ).val();
		var institute_name          = $( '#student-institute-name' ).val();
		var expectation             = $( '.student-expectation' ).val();
		var agree_tos               = ( $( '#student-registration-terms-n-conditions-acceptance' ).is( ':checked' ) ) ? true : false;
		var error_message           = '';

		// Hide the error notification.
		cf_hide_notification();

		// Validate first name.
		if ( -1 === is_valid_string( first_name ) ) {
			error_message += '<li>First name is required.</li>';
		}

		// Validate last name.
		if ( -1 === is_valid_string( last_name ) ) {
			error_message += '<li>Last name is required.</li>';
		}

		// Validate phone.
		if ( '' === phone ) {
			error_message += '<li>Phone number is required.</li>';
		} else if ( 10 !== phone.length ) {
			error_message += '<li>Phone number is invalid.</li>';
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

		// Validate address.
		if ( -1 === is_valid_string( address ) ) {
			error_message += '<li>Address is required.</li>';
		}

		// Validate dob.
		if ( -1 === is_valid_string( dob ) ) {
			error_message += '<li>Date of Birth is required.</li>';
		}

		// Validate mode of learning.
		if ( -1 === is_valid_string( mode_of_learning ) ) {
			error_message += '<li>Mode of Learning is required.</li>';
		}

		// Validate education qualification.
		if ( -1 === is_valid_string( education_qualification ) ) {
			error_message += '<li>Education Qualification is required.</li>';
		}

		// Validate institute name.
		if ( -1 === is_valid_string( institute_name ) ) {
			error_message += '<li>Institute Name is required.</li>';
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
		// Block the element now.
		block_element( this_button );

		// Change button text.
		this_button.val( registering_user_text );

		// Send the AJAX now.
		var data = {
			action: 'register_student',
			first_name: first_name,
			last_name: last_name,
			phone: phone,
			password: password,
			email: email,
			address: address,
			dob: dob,
			mode_of_learning: mode_of_learning,
			education_qualification: education_qualification,
			institute_name: institute_name,
			expectation: expectation,
		};
		$.ajax( {
			dataType: 'JSON',
			url: ajaxurl,
			type: 'POST',
			data: data,
			success: function ( response ) {
				// If user already exists.
				if ( 'student-exists' === response.data.code || 'student-not-created' === response.data.code ) {
					// Unblock the element.
					unblock_element( this_button );

					// Change button text.
					this_button.val( this_button_text );

					// Show the notification now.
					cf_show_notification( 'fa fa-warning', 'Error', response.data.notification_text, 'error' );
				}

				// If student is registered.
				if ( 'student-registration-complete' === response.data.code ) {
					// Unblock the element.
					unblock_element( this_button );

					// Change button text.
					this_button.val( this_button_text );

					// Show the notification now.
					cf_show_notification( 'fa fa-check', 'Success', response.data.notification_text, 'success' );
					setTimeout( function () {
						location.reload();
					}, 6000 );
				}
			},
		} );
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
		$( '.notification_popup').removeClass( 'is-success is-error is-notice' );
		
		// Add classes based on success|error.
		if ( 'error' === success_or_error ) {
			$( '.notification_popup' ).addClass( 'active is-error' );
		} else if ( 'success' === success_or_error ) {
			$( '.notification_popup' ).addClass( 'active is-success' );
		} else if ( 'notice' === success_or_error ) {
			$( '.notification_popup' ).addClass( 'active is-notice' );
		}
    }
} );
