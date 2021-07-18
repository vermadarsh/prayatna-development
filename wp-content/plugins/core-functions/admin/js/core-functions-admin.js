jQuery( document ).ready( function( $ ) {
	'use strict';

	// Localized variables.
	var ajaxurl                    = CF_Admin_JS_Script_Vars.ajaxurl;
	var export_logs_button_text    = CF_Admin_JS_Script_Vars.export_logs_button_text;
	var exporting_logs_button_text = CF_Admin_JS_Script_Vars.exporting_logs_button_text;
	var is_administrator           = CF_Admin_JS_Script_Vars.is_administrator;

	// Add the export button besides the new log button.
	// Enable the exporting feature only for admin users.
	if ( 'yes' === is_administrator ) {
		$( '<a href="javascript:void(0);" class="cf-export-client-log page-title-action">' + export_logs_button_text + '</a>' ).insertAfter( 'body.post-type-client-log .wrap a.page-title-action' );
		$( '<a href="javascript:void(0);" class="cf-export-learning-lounge-log page-title-action">' + export_logs_button_text + '</a>' ).insertAfter( 'body.post-type-learning-lounge-log .wrap a.page-title-action' );
	}

	// Open the modal to allow date range selection.
	$( document ).on( 'click', '.cf-export-client-log', function() {
		$( '#cf-export-client-log-modal' ).show();
	} );

	// Open the modal to allow date range selection.
	$( document ).on( 'click', '.cf-export-learning-lounge-log', function() {
		$( '#cf-export-learning-lounge-log-modal' ).show();
	} );

	/**
	 * Close the modal.
	 */
	$( document ).on( 'click', '.cf_close', function() {
		$( '.cf_modal' ).hide();
	} );

	/**
	 * Close the modal on esc. key press.
	 */
	$( document ).on( 'keydown', function( evt ) {
		var key_code = ( evt.keyCode ? evt.keyCode : evt.which );
		// Check if esc key is pressed.
		if ( 27 === key_code ) {
			$( '.cf_modal' ).hide();
		}
	} );

	/**
	 * Generate the client logs csv file.
	 */
	$( document ).on( 'click', '#cf-export-client-log-modal .export-client-log', function() {
		var this_button      = $( this );
		var this_button_text = this_button.text();
		var start_date       = $( '#cf-date-from' ).val();
		var end_date         = $( '#cf-date-to' ).val();

		if ( '' !== start_date && '' !== end_date ) {
			var start_date_full = new Date( start_date );
			var end_date_full   = new Date( end_date );

			// Verify if end date falls after the start date.
			if ( start_date_full > end_date_full ) {
				alert( 'Invalid date range.' );
				return false;
			}
		}

		// Change the button text.
		this_button.text( exporting_logs_button_text );

		// Block the submit button.
		block_element( this_button );

		// Fire the AJAX.
		$.ajax( {
			url: ajaxurl,
			type: 'POST',
			data: {
				action: 'export_client_log',
				start_date: start_date,
				end_date: end_date,
			},
			success: function ( response ) {
				// Check for invalid ajax request.
				if ( 0 === response ) {
					console.log( 'prayatna core: invalid ajax request' );
					return false;
				}

				// Unblock the element.
				unblock_element( this_button );

				// Make the button text the previous one.
				this_button.text( this_button_text );

				// Make the CSV downloadable.
				var download_link = document.createElement( 'a' );
				var csv_data      = [ '\ufeff' + response ];
				var blob_object   = new Blob( csv_data, {
					type: 'text/csv;charset=utf-8;'
				} );

				var url            = URL.createObjectURL( blob_object );
				download_link.href = url;

				// Get the datetime now to set the csv file name.
				var today = new Date( $.now() );
				var export_time = today.getDate() + '-' + ( today.getMonth() + 1 ) + '-' + today.getFullYear() + '-' + today.getHours() + '-' + today.getMinutes() + '-' + today.getSeconds();
				download_link.download = 'client-logs-' + export_time + '.csv';

				// Force the system to download the CSV now.
				document.body.appendChild( download_link );
				download_link.click();
				document.body.removeChild( download_link );

				// Hide the modal now.
				$( '.cf_close' ).click();
			},
		} );
	} );

	/**
	 * Generate the learning lounge logs csv file.
	 */
	 $( document ).on( 'click', '#cf-export-learning-lounge-log-modal .export-learning-lounge-log', function() {
		var this_button      = $( this );
		var this_button_text = this_button.text();
		var start_date       = $( '#cf-date-from' ).val();
		var end_date         = $( '#cf-date-to' ).val();

		if ( '' !== start_date && '' !== end_date ) {
			var start_date_full = new Date( start_date );
			var end_date_full   = new Date( end_date );

			// Verify if end date falls after the start date.
			if ( start_date_full > end_date_full ) {
				alert( 'Invalid date range.' );
				return false;
			}
		}

		// Change the button text.
		this_button.text( exporting_logs_button_text );

		// Block the submit button.
		block_element( this_button );

		// Fire the AJAX.
		$.ajax( {
			url: ajaxurl,
			type: 'POST',
			data: {
				action: 'export_learning_lounge_log',
				start_date: start_date,
				end_date: end_date,
			},
			success: function ( response ) {
				// Check for invalid ajax request.
				if ( 0 === response ) {
					console.log( 'prayatna core: invalid ajax request' );
					return false;
				}

				// Unblock the element.
				unblock_element( this_button );

				// Make the button text the previous one.
				this_button.text( this_button_text );

				// Make the CSV downloadable.
				var download_link = document.createElement( 'a' );
				var csv_data      = [ '\ufeff' + response ];
				var blob_object   = new Blob( csv_data, {
					type: 'text/csv;charset=utf-8;'
				} );

				var url            = URL.createObjectURL( blob_object );
				download_link.href = url;

				// Get the datetime now to set the csv file name.
				var today = new Date( $.now() );
				var export_time = today.getDate() + '-' + ( today.getMonth() + 1 ) + '-' + today.getFullYear() + '-' + today.getHours() + '-' + today.getMinutes() + '-' + today.getSeconds();
				download_link.download = 'learning-lounge-logs-' + export_time + '.csv';

				// Force the system to download the CSV now.
				document.body.appendChild( download_link );
				download_link.click();
				document.body.removeChild( download_link );

				// Hide the modal now.
				$( '.cf_close' ).click();
			},
		} );
	} );

	/**
	 * For the payment information new log added by student, manage the fields.
	 */
	$( document ).on( 'change', '#mode-of-payment', function() {
		var mode_of_payment = $( this ).val();

		// Hide the bank name and transaction ID in case of cash mode.
		if ( 'cash' === mode_of_payment ) {
			$( '.cf-bank-name-field' ).hide();
			$( '.cf-transaction-id-field' ).hide();
			$( '#bank-name' ).attr( 'required', false );
			$( '#transaction-id' ).attr( 'required', false );
		} else {
			$( '.cf-bank-name-field' ).show();
			$( '.cf-transaction-id-field' ).show();
			$( '#bank-name' ).attr( 'required', true );
			$( '#transaction-id' ).attr( 'required', true );
		}
	} );

	/**
	 * Approve leave.
	 */
	$( document ).on( 'click', '.cf-approve-leave', function() {
		var this_link = $( this );
		var leave_id  = this_link.data( 'leaveid' );

		// Change the link text.
		this_link.text( 'Please wait...' );

		// Block element.
		block_element( this_link.parents( 'tr' ) );

		// Send the AJAX to approve the request.
		var data = {
			action: 'approve_leave',
			leave_id: leave_id
		};
		$.ajax( {
			dataType: 'JSON',
			url: ajaxurl,
			type: 'POST',
			data: data,
			success: function ( response ) {
				// If AJAX is invalid.
				if ( 0 === response ) {
					console.log( 'prayatna: invalid AJAX' );
					return false;
				}

				if ( 'leave-approved' === response.data.code ) {
					// Unblock the row.
					unblock_element( this_link.parents( 'tr' ) );

					// Reload.
					window.location.href = window.location.href;
				}
			},
		} );
	} );

	/**
	 * Reject leave.
	 */
	 $( document ).on( 'click', '.cf-reject-leave', function() {
		var this_link = $( this );
		var leave_id  = this_link.data( 'leaveid' );

		var message = prompt( 'Rejection message:' );

		// Check if the message is a valid one.
		if ( '' === message ) {
			alert( 'Please provide a message for rejecting this leave' );
			return false;
		}

		// Return, if user selects to cancel leave rejection.
		if ( null === message ) {
			return false;
		}

		// Change the link text.
		this_link.text( 'Please wait...' );

		// Block element.
		block_element( this_link.parents( 'tr' ) );

		// Send the AJAX to reject the request.
		var data = {
			action: 'reject_leave',
			leave_id: leave_id,
			message: message,
		};
		$.ajax( {
			dataType: 'JSON',
			url: ajaxurl,
			type: 'POST',
			data: data,
			success: function ( response ) {
				// If AJAX is invalid.
				if ( 0 === response ) {
					console.log( 'prayatna: invalid AJAX' );
					return false;
				}

				if ( 'leave-rejected' === response.data.code ) {
					// Unblock the row.
					unblock_element( this_link.parents( 'tr' ) );

					// Reload.
					window.location.href = window.location.href;
				}
			},
		} );
	} );

	/**
	 * Cancel leave.
	 */
	 $( document ).on( 'click', '.cf-cancel-leave', function() {
		var this_link = $( this );
		var leave_id  = this_link.data( 'leaveid' );
		var confirm   = confirm( 'Do you really want to cancel this leave? This action won\'t be undone.' );

		console.log( 'confirm', confirm );
		return false;

		// Check if the message is a valid one.
		if ( '' === message ) {
			alert( 'Please provide a message for rejecting this leave' );
			return false;
		}

		// Return, if user selects to cancel leave rejection.
		if ( null === message ) {
			return false;
		}

		// Change the link text.
		this_link.text( 'Please wait...' );

		// Block element.
		block_element( this_link.parents( 'tr' ) );

		// Send the AJAX to reject the request.
		var data = {
			action: 'reject_leave',
			leave_id: leave_id,
			message: message,
		};
		$.ajax( {
			dataType: 'JSON',
			url: ajaxurl,
			type: 'POST',
			data: data,
			success: function ( response ) {
				// If AJAX is invalid.
				if ( 0 === response ) {
					console.log( 'prayatna: invalid AJAX' );
					return false;
				}

				if ( 'leave-rejected' === response.data.code ) {
					// Unblock the row.
					unblock_element( this_link.parents( 'tr' ) );

					// Reload.
					window.location.href = window.location.href;
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
} );
