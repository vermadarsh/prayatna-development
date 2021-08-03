<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/vermadarsh/
 * @since      1.0.0
 *
 * @package    Core_Functions
 * @subpackage Core_Functions/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Core_Functions
 * @subpackage Core_Functions/admin
 * @author     Adarsh Verma <adarsh.srmcem@gmail.com>
 */
class Core_Functions_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function cf_admin_enqueue_scripts_callback() {
		// Modal custom style.
		wp_enqueue_style(
			$this->plugin_name . '-modal-style',
			CF_PLUGIN_URL . 'admin/css/core-functions-modal.css',
			array(),
			filemtime( CF_PLUGIN_PATH . 'admin/css/core-functions-modal.css' ),
			'all'
		);

		// Admin custom style.
		wp_enqueue_style(
			$this->plugin_name,
			CF_PLUGIN_URL . 'admin/css/core-functions-admin.css',
			array(),
			filemtime( CF_PLUGIN_PATH . 'admin/css/core-functions-admin.css' ),
			'all'
		);

		// Admin custom script.
		wp_enqueue_script(
			$this->plugin_name,
			CF_PLUGIN_URL . 'admin/js/core-functions-admin.js',
			array( 'jquery' ),
			filemtime( CF_PLUGIN_PATH . 'admin/js/core-functions-admin.js' ),
			false
		);

		// Localize admin script.
		wp_localize_script(
			$this->plugin_name,
			'CF_Admin_JS_Script_Vars',
			array(
				'ajaxurl'                     => admin_url( 'admin-ajax.php' ),
				'export_logs_button_text'     => __( 'Export Log', 'core-functions' ),
				'exporting_logs_button_text'  => __( 'Processing...', 'core-functions' ),
				'is_administrator'            => ( current_user_can( 'manage_options' ) ) ? 'yes' : 'no',
				'therapist_decline_alert_msg' => __( 'Reason for declining this therapist?', 'core-functions' ),
			)
		);
	}

	/**
	 * Change the defailt avatar URL, if set by the admin.
	 *
	 * @param string     $avatar_url Avatar image URL.
	 * @param int|string $id_or_email User's ID or email address.
	 * @return string
	 */
	public function cf_get_avatar_url_callback( $avatar_url, $id_or_email ) {
		/**
		 * If the $id_or_email variable is string, means it is email.
		 * Get the user ID from email.
		 */
		if ( is_string( $id_or_email ) ) {
			$user        = get_user_by( 'user_email', $id_or_email );
			$id_or_email = $user->ID;
		}

		// If the value reveived is integer, it is user ID.
		$profile_picture_id = get_field( 'cf_profile_picture', "user_{$id_or_email}" );

		// Return, if the attachment is not saved as ACF field value.
		if ( is_null( $profile_picture_id ) ) {
			return $avatar_url;
		}

		// Get the custom picture ID.
		$profile_picture_url = cf_get_image_url_by_attachment_id( $profile_picture_id );

		// Return, if the received image ID doesn't exist.
		if ( false === $profile_picture_url ) {
			return $avatar_url;
		}

		return $profile_picture_url;
	}

	/**
	 * Check the logging in user's status while login from /wp-admin/
	 *
	 * @param object $user Holds the user object.
	 * @return object
	 */
	public function cf_wp_authenticate_user_callback( $user ) {
		// Return, if the user data is not available.
		if ( empty( $user ) || empty( $user->ID ) ) {
			return $user;
		}

		$status                    = get_user_meta( $user->ID, 'cf_user_status', true );
		$email_verification_status = get_user_meta( $user->ID, 'cf_user_email_verification', true );

		// Email verification status pending.
		if ( ! empty( $email_verification_status ) && 'pending' === $email_verification_status ) {
			return new WP_Error( 'user-email-verification-pending', __( 'Sorry, but your email verification is pending. Please verify your email and try again.', 'core-functions' ) );
		}

		// Registration status denied.
		if ( ! empty( $status ) && 'registration-declined' === $status ) {
			return new WP_Error( 'user-status-declined', sprintf( __( 'Sorry, but your registration request has been declined. Please contact %1$ssite administrator%2$s for further details.', 'core-functions' ), '<a href="mailto:' . get_option( 'admin_email' ) . '">', '</a>' ) );
		}

		// Registration status pending.
		if ( ! empty( $status ) && 'pending' === $status ) {
			return new WP_Error( 'user-status-pending', sprintf( __( 'Sorry, but your registration request is pending. Please contact %1$ssite administrator%2$s for further details.', 'core-functions' ), '<a href="mailto:' . get_option( 'admin_email' ) . '">', '</a>' ) );
		}

		// Account suspended.
		if ( ! empty( $status ) && 'suspended' === $status ) {
			return new WP_Error( 'user-suspended', sprintf( __( 'Sorry, but your account has been suspended. Please contact admin on: %1$s.', 'core-functions' ), get_option( 'admin_email' ) ) );
		}

		return $user;
	}

	/**
	 * Redirect the login based on user roles.
	 *
	 * @param string  $redirect_to Holds the redirect URL.
	 * @param string  $requested_redirect_to Holds the requested redirect URL.
	 * @param WP_User $user Holds the user object.
	 * @return string
	 */
	public function cf_login_redirect_callback( $redirect_to, $requested_redirect_to, $user ) {
		// If the user is logged in and roles are available to check.
		if ( isset( $user->roles ) && is_array( $user->roles ) ) {
			if ( in_array( 'administrator', $user->roles ) ) {
				$redirect_to = admin_url();
			} else {
				$redirect_to = admin_url( 'profile.php' );
			}
		}

		return $redirect_to;
	}

	/**
	 * Change the author titled metabox to Therapist.
	 */
	public function cf_add_meta_boxes_callback() {
		global $wp_meta_boxes;

		// Check for client log metaboxes.
		if ( empty( $wp_meta_boxes['client-log']['normal']['core']['authordiv'] ) ) {
			return;
		}

		// Change the title now.
		$wp_meta_boxes['client-log']['normal']['core']['authordiv']['title'] = __( 'Therapist', 'core-functions' );
		$screens = array('client-log','therapist-log');

		// Add a custom metabox to display all the children.
		add_meta_box(
			'child-for-client-log',
			__( 'Child', 'core-functions' ),
			array( $this, 'cf_child_for_client_log_callback' ),
			$screens,
			'normal',
		);
		// add_meta_box(
		// 	'child-for-therapist-log',
		// 	__( 'Child', 'core-functions' ),
		// 	array( $this, 'cf_child_for_therapist_los_callback' ),
		// 	'therapist-log',
		// 	'normal',
		// );
	}

	public function cf_child_for_therapist_los_callback(){
		die("pooop");
		$children       = cf_get_children();
		$post_id        = filter_input( INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT );
		$selected_child = ( ! is_null( $post_id ) ) ? get_post_meta( $post_id, 'child', true ) : false;

		// Prepare the select html markup.
		echo '<select name="cf-child" required>';
		echo '<option value="">' . __( 'Select child', 'core-functions' ) . '</option>';
		if ( ! empty( $children ) && is_array( $children ) ) {
			foreach ( $children as $child_data ) {
				$client_id     = $child_data['client_id'];
				$first_name    = $child_data['first_name'];
				$last_name     = $child_data['last_name'];
				$dob           = $child_data['dob'];
				$option_string = sprintf( __( 'Parent-#%1$s - %2$s %3$s - %4$s', 'core-functions' ), $client_id, $first_name, $last_name, $dob );
				$option_val    = sanitize_title( $option_string );
				$selected      = ( false !== $selected_child && $selected_child === $option_val ) ? 'selected' : '';
				echo '<option ' . $selected . ' value="' . $option_val . '">' . $option_string . '</option>';
			}
		}
		echo '</select>';
	}

	/**
	 * Metabox markup for child selection while creating/updating client log.
	 */
	public function cf_child_for_client_log_callback() {
		$children       = cf_get_children();
		$post_id        = filter_input( INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT );
		$selected_child = ( ! is_null( $post_id ) ) ? get_post_meta( $post_id, 'child', true ) : false;

		// Prepare the select html markup.
		echo '<select name="cf-child" required>';
		echo '<option value="">' . __( 'Select child', 'core-functions' ) . '</option>';
		if ( ! empty( $children ) && is_array( $children ) ) {
			foreach ( $children as $child_data ) {
				$client_id     = $child_data['client_id'];
				$first_name    = $child_data['first_name'];
				$last_name     = $child_data['last_name'];
				$dob           = $child_data['dob'];
				$option_string = sprintf( __( 'Parent-#%1$s - %2$s %3$s - %4$s', 'core-functions' ), $client_id, $first_name, $last_name, $dob );
				$option_val    = sanitize_title( $option_string );
				$selected      = ( false !== $selected_child && $selected_child === $option_val ) ? 'selected' : '';
				echo '<option ' . $selected . ' value="' . $option_val . '">' . $option_string . '</option>';
			}
		}
		echo '</select>';
	}

	/**
	 * Save the child details for client log.
	 */
	public function cf_save_post_callback( $post_id,$post ) {
		// Check for client log post type.
		if ( 'client-log' === get_post_type( $post_id ) ) {
			$child = filter_input( INPUT_POST, 'cf-child', FILTER_SANITIZE_STRING );
			update_post_meta( $post_id, 'child', $child );
		}
		if ( 'therapist-log' === get_post_type( $post_id ) ) {
			$child = filter_input( INPUT_POST, 'cf-child', FILTER_SANITIZE_STRING );
			update_post_meta( $post_id, 'child', $child );
		}

		// Update the leaves meta data.
	 	if ( 'leave' === get_post_type( $post_id ) ) {
	 		// Return, if the post status is not published.
			if ( isset( $post->post_status ) && ( 'auto-draft' === $post->post_status || 'trash' === $post->post_status ) ) {
				return;
			}

			// Get the current user.
			$user = wp_get_current_user();

			// Return, if the current user is not therapist.
			if (  cf_is_user_therapist( $user->ID ) ) {
				$leaveStartDate   = get_field( 'leave_from',$post_id );
				$leaveEndDate     = get_field( 'to',$post_id );
				$time             = strtotime($leaveStartDate);
				$month            = date("m",$time);
				$year             = date("Y",$time);
				$leave_date       = date("d",$time);
				$leave_type       = get_field('leave_duration',$post_id);
				$leave_type       = ( 'full' === $leave_type ) ? 1 : 0.5;
				$userFname        = $user->user_firstname;
				$userLname        = $user->user_lastname;
				$userEmail        = $user->user_email;
				$date1            = new DateTime( $leaveStartDate );
				$unix1            = strtotime( $date1->format( 'Y-m-d' ) );
				$date2            = new DateTime( $leaveEndDate );
				$unix2            = strtotime( $date2->format( 'Y-m-d' ) );
				$numberOfDayLeave = ( 0 === ( $unix1 - $unix2 ) ) ? '1 Day' : human_time_diff( $unix1, $unix2 );
				$leaves_days      = cf_get_dates_within_2_dates( $leaveStartDate, $leaveEndDate );

				// Prepare the leaves array.
				$leaves            = get_user_meta( $user->ID, 'prayatna_leaves', true );
				$leaves            = ( ! empty( $leaves ) ) ? $leaves : array();
				if ( ! empty( $leaves_days ) && is_array( $leaves_days ) ) {
					foreach( $leaves_days as $leave_full_date ) {
						$leave_year  = gmdate( 'Y', strtotime( $leave_full_date ) );
						$leave_month = gmdate( 'm', strtotime( $leave_full_date ) );
						$leave_date  = gmdate( 'd', strtotime( $leave_full_date ) );
						$leaves[ $leave_year ][ $leave_month ][ $leave_date ] = array(
							'type'          => $leave_type,
							'reason'        => get_field( 'reason_for_leave', $post_id ),
							'status'        => 'pending',
							'reject_reason' => '',
						);
					}
				}

				// Update the leaves in the database.
				update_user_meta( $user->ID, 'prayatna_leaves', $leaves );

				// Update the leave status.
				update_field( 'leave_approval', 'pending', $post_id );

				// Prepare the email template for apply leave.
				$leave_apply_email_subject         = get_field('leave_apply_email_subject','option');
				$emailTemplateBody                 = get_field('leave_apply_email','option');
				$emailTemplateBody                 = str_replace('{first_name}',$userFname.' '.$userLname,$emailTemplateBody);
				$emailTemplateBody                 = str_replace('{number_of_days}',$numberOfDayLeave,$emailTemplateBody);
				$emailTemplateBody                 = str_replace('{from_date}',$leaveStartDate,$emailTemplateBody);
				$emailTemplateBody                 = str_replace('{to_date}',$leaveEndDate,$emailTemplateBody);
				$emailTemplateBody                 = str_replace('{reason}.',$leaveReason,$emailTemplateBody);
				$emailTemplateBody                 = str_replace('{Therapist_name}',$userFname.' '.$userLname,$emailTemplateBody);
				
				$adminEmail                        = 'nirmehta4491@gmail.com';
				$AdminEmailSubject                 = $userFname.' is apply for leave application';
				$leave_apply_email_subject         = str_replace('{first_name}',$userFname,$leave_apply_email_subject);
				wp_mail( $adminEmail, $leave_apply_email_subject, $emailTemplateBody, array('Content-Type: text/html; charset=UTF-8'));
			} elseif( cf_is_user_admin( $user->ID ) ){
				$author_id        = $post->post_author;
				$user             = get_userdata($author_id);
				$userFname        = $user->user_firstname;
				$leaveStartDate   = get_field( 'leave_from',$post_id );
				$leaveEndDate     = get_field( 'to',$post_id );
				$rejected_message = get_field( 'reject_message',$post_id );
				$leaves_days      = cf_get_dates_within_2_dates( $leaveStartDate, $leaveEndDate );
				$leaves           = get_user_meta( $author_id, 'prayatna_leaves', true );
				$leaves           = ( ! empty( $leaves ) ) ? $leaves : array();
				if ( ! empty( $leaves_days ) && is_array( $leaves_days ) ) {
					foreach( $leaves_days as $leave_full_date ) {
						$leave_year  = gmdate( 'Y', strtotime( $leave_full_date ) );
						$leave_month = gmdate( 'm', strtotime( $leave_full_date ) );
						$leave_date  = gmdate( 'd', strtotime( $leave_full_date ) );
						$leaves[ $leave_year ][ $leave_month ][ $leave_date ] = array(
							'type'          => $leave_type,
							'reason'        => get_field( 'reason_for_leave', $post_id ),
							'status'        => get_field('leave_approval',$post_id),
							'reject_reason' => $rejected_message,
						);
					}
				}
				// Update the leaves in the database.
				update_user_meta( $author_id, 'prayatna_leaves', $leaves );
				$leave_day                    = gmdate( 'D', strtotime( $leave_full_date ) );
				$leave_type                   = get_field('leave_duration',$post_id);
				$email_template_body_approved = get_field('leave_approved_email','option');
				$email_template_body_rejected = get_field('leave_reject_email','option');
				// debug($leaves[ $leave_year ][ $leave_month ][ $leave_date ]['status']);
				// die;
				if( 'approved' === $leaves[ $leave_year ][ $leave_month ][ $leave_date ]['status'] ) {
					// Prepare the email template for approved leave.
					$leave_approved_email_subject         = get_field('leave_approved_email_subject','option');
					$leave_approved_email_subject         = str_replace('{first_name}',$userFname,$leave_approved_email_subject);
					$email_template_body_approved         = str_replace('{first_name}',$userFname,$email_template_body_approved);
					$email_template_body_approved         = str_replace('{leave_type}',$leave_type,$email_template_body_approved);
					$email_template_body_approved         = str_replace('{day}',$leave_day,$email_template_body_approved);
					$email_template_body_approved         = str_replace('{from_date}',$leaveStartDate,$email_template_body_approved);
					wp_mail($userEmail, $leave_approved_email_subject, $email_template_body_approved, array('Content-Type: text/html; charset=UTF-8'));
					// debug($leave_approved_email_subject);
					// debug($email_template_body_approved);
				} else {
					// Prepare the email template for rejected leave.
					$leave_reject_email_subject            = get_field('leave_reject_email_subject','option');
					$leave_reject_email_subject            = str_replace('{first_name}',$userFname,$leave_reject_email_subject);
					$email_template_body_rejected          = str_replace('{first_name}',$userFname,$email_template_body_rejected);
					$email_template_body_rejected          = str_replace('{leave_type}',$leave_type,$email_template_body_rejected);
					$email_template_body_rejected          = str_replace('{day}',$leave_day,$email_template_body_rejected);
					$email_template_body_rejected          = str_replace('{from_date}',$leaveStartDate,$email_template_body_rejected);
					$email_template_body_rejected          = str_replace('{leave_reason}',$rejected_message,$email_template_body_rejected);
					wp_mail($userEmail, $leave_reject_email_subject, $email_template_body_rejected, array('Content-Type: text/html; charset=UTF-8'));
					// debug($leave_reject_email_subject);
					// debug($email_template_body_rejected);
				}
			}
		}
	}

	/**
	 * Add custom assets to admin footer.
	 */
	public function cf_admin_footer_callback() {
		$post_type = filter_input( INPUT_GET, 'post_type', FILTER_SANITIZE_STRING );

		// Require the modal markup for client log post type.
		if ( ! is_null( $post_type ) && 'client-log' === $post_type ) {
			require_once CF_PLUGIN_PATH . 'admin/templates/modals/export-client-log.php';
		}

		// Require the modal markup for learning lounge log post type.
		if ( ! is_null( $post_type ) && 'learning-lounge-log' === $post_type ) {
			require_once CF_PLUGIN_PATH . 'admin/templates/modals/export-learning-lounge-log.php';
		}

		// Include the notification popup.
		ob_start();
		?>
		<div class="cf_notification_popup">
			<span class="cf_notification_close"></span>
			<div class="cf_notification_icon"><i class="fa" aria-hidden="true"></i></div>
			<div class="cf_notification_message">
				<h3 class="title"></h3>
				<p class="message"></p>
			</div>
		</div>
		<?php

		echo wp_kses_post( ob_get_clean() );
	}

	/**
	 * AJAX to collect the client logs.
	 */
	public function cf_export_client_log_callback() {
		$action = filter_input( INPUT_POST, 'action', FILTER_SANITIZE_STRING );

		// Return, if the action doesn't match.
		if ( 'export_client_log' !== $action ) {
			echo 0;
			wp_die();
		}

		// Fetch the clubs.
		$logs_query = cf_get_client_logs();
		$logs       = $logs_query->posts;

		// Exit the query if there are no clubs.
		if ( empty( $logs ) || ! is_array( $logs ) ) {
			exit();
		}

		// Iterate through the clubs array to fetch the data.
		foreach ( $logs as $log_id ) {
			$log_post = get_post( $log_id );
			$session_date    = gmdate( 'F j, Y', strtotime( get_field( 'session_date', $log_id ) ) );
			$homework_done   = get_field( 'homework_done', $log_id );
			$homework_done   = ( true === $homework_done ) ? 'Yes' : 'No';

			// Gather the data now.
			$logs_data[ $log_id ] = array(
				'ID'              => $log_id,
				'Log Title'       => $log_post->post_title,
				'Log URL'         => get_permalink( $log_id ),
				'Session Date'    => $session_date,
				'Time In'         => get_field( 'time_in', $log_id ),
				'Time Out'        => get_field( 'time_out', $log_id ),
				'Homework Done?'  => $homework_done,
				'At Session'      => get_field( 'at_session', $log_id ),
				'Kid\'s Feelings' => get_field( 'kids_feelings', $log_id ),
				'Homework'        => get_field( 'homework', $log_id ),
				'Payment Due'     => get_field( 'payment_due', $log_id ),
			);
		}

		// Send this array of clubs to be downloaded.
		return $this->download_csv( $logs_data );
	}

	/**
	 * Modify the client log arguments to fetch the data.
	 *
	 * @param array $args Holds the client logs post arguments.
	 * @return array
	 */
	public function cf_cf_client_logs_args_callback( $args ) {
		// Posted data.
		$start_date = filter_input( INPUT_POST, 'start_date', FILTER_SANITIZE_STRING );
		$end_date   = filter_input( INPUT_POST, 'end_date', FILTER_SANITIZE_STRING );

		// If start date is available.
		if ( ! empty( $start_date ) ) {
			$args['date_query']['after'] = array(
				'year'  => gmdate( 'Y', strtotime( $start_date ) ),
				'month' => gmdate( 'm', strtotime( $start_date ) ),
				'day'   => gmdate( 'd', strtotime( $start_date ) ),
			);
		}

		// If end date is available.
		if ( ! empty( $end_date ) ) {
			$args['date_query']['before'] = array(
				'year'  => gmdate( 'Y', strtotime( $end_date ) ),
				'month' => gmdate( 'm', strtotime( $end_date ) ),
				'day'   => gmdate( 'd', strtotime( $end_date ) ),
			);
		}

		return $args;
	}

	/**
	 * Download the data in CSV format.
	 */
	public function download_csv( $data ) {
		// Exit, if the data is empty.
		if ( empty( $data ) || ! is_array( $data ) ) {
			exit();
		}

		// Create the CSV now.
		$fp = fopen( 'php://output', 'w' );
		fputcsv( $fp, array_keys( reset( $data ) ) );

		// Iterate through the data to download.
		foreach ( $data as $data_val ) {
			fputcsv( $fp, $data_val );
		}

		fclose( $fp );
		exit();
	}

	/**
	 * Add custom filters on the client logs listing page.
	 */
	public function cf_restrict_manage_posts_callback() {
		$post_type                      = filter_input( INPUT_GET, 'post_type', FILTER_SANITIZE_STRING );
		$client_log_start_date          = filter_input( INPUT_GET, 'client-log-start-date', FILTER_SANITIZE_STRING );
		$client_log_end_date            = filter_input( INPUT_GET, 'client-log-end-date', FILTER_SANITIZE_STRING );
		$learning_lounge_log_start_date = filter_input( INPUT_GET, 'learning-lounge-log-start-date', FILTER_SANITIZE_STRING );
		$learning_lounge_log_end_date   = filter_input( INPUT_GET, 'learning-lounge-log-end-date', FILTER_SANITIZE_STRING );

		// Check for client log post type.
		if ( 'client-log' === $post_type ) {
			ob_start();
			?>
			<input type="text" name="client-log-start-date" value="<?php echo esc_html( $client_log_start_date ); ?>" placeholder="<?php esc_html_e( 'Logs From', 'core-functions' ); ?>" onfocus="(this.type='date')" onfocusout="(this.type='text')" />
			<input type="text" name="client-log-end-date" value="<?php echo esc_html( $client_log_end_date ); ?>" placeholder="<?php esc_html_e( 'Logs To', 'core-functions' ); ?>" onfocus="(this.type='date')" onfocusout="(this.type='text')" />
			<?php
			echo ob_get_clean();
		}

		// Check for client log post type.
		if ( 'learning-lounge-log' === $post_type ) {
			ob_start();
			?>
			<input type="text" name="learning-lounge-log-start-date" value="<?php echo esc_html( $learning_lounge_log_start_date ); ?>" placeholder="<?php esc_html_e( 'Logs From', 'core-functions' ); ?>" onfocus="(this.type='date')" onfocusout="(this.type='text')" />
			<input type="text" name="learning-lounge-log-end-date" value="<?php echo esc_html( $learning_lounge_log_end_date ); ?>" placeholder="<?php esc_html_e( 'Logs To', 'core-functions' ); ?>" onfocus="(this.type='date')" onfocusout="(this.type='text')" />
			<?php
			echo ob_get_clean();
		}
	}

	/**
	 * Parse the client log listing query to filter by start date and end date.
	 */
	public function cf_parse_query_callback( $query ) {
		// Modify the query only if it admin and main query.
		if ( ! ( is_admin() && $query->is_main_query() ) ) {
			return $query;
		}

		// Get the post type.
		$post_type  = filter_input( INPUT_GET, 'post_type', FILTER_SANITIZE_STRING );

		// Post type - client log.
		if ( 'client-log' === $post_type ) {
			// Get the custom filters.
			$start_date = filter_input( INPUT_GET, 'client-log-start-date', FILTER_SANITIZE_STRING );
			$end_date   = filter_input( INPUT_GET, 'client-log-end-date', FILTER_SANITIZE_STRING );

			// Proceed only when either the start date or the end date is requested.
			if ( ! empty( $start_date ) || ! empty( $end_date ) ) {
				$date_query_args = array();
				// If the start date is provided.
				if ( ! empty( $start_date ) ) {
					$date_query_args['after']     = array(
						'year'  => gmdate( 'Y', strtotime( $start_date ) ),
						'month' => gmdate( 'm', strtotime( $start_date ) ),
						'day'   => gmdate( 'd', strtotime( $start_date ) ),
					);
					$date_query_args['inclusive'] = true;
				}

				// If the end date is provided.
				if ( ! empty( $end_date ) ) {
					$date_query_args['before']    = array(
						'year'  => gmdate( 'Y', strtotime( $end_date ) ),
						'month' => gmdate( 'm', strtotime( $end_date ) ),
						'day'   => gmdate( 'd', strtotime( $end_date ) ),
					);
					$date_query_args['inclusive'] = true;
				}

				if ( ! empty( $date_query_args ) ) {
					$query->set( 'date_query', $date_query_args );
				}
			}

			// If not admin, show the client logs created by self.
			if ( ! current_user_can( 'manage_options' ) ) {
				$query->set( 'author', get_current_user_id() );
			}
		}

		// Post type - learning lounge log.
		if ( 'learning-lounge-log' === $post_type ) {
			// Get the custom filters.
			$start_date = filter_input( INPUT_GET, 'learning-lounge-log-start-date', FILTER_SANITIZE_STRING );
			$end_date   = filter_input( INPUT_GET, 'learning-lounge-log-end-date', FILTER_SANITIZE_STRING );

			// Proceed only when either the start date or the end date is requested.
			if ( ! empty( $start_date ) || ! empty( $end_date ) ) {
				$date_query_args = array();
				// If the start date is provided.
				if ( ! empty( $start_date ) ) {
					$date_query_args['after']     = array(
						'year'  => gmdate( 'Y', strtotime( $start_date ) ),
						'month' => gmdate( 'm', strtotime( $start_date ) ),
						'day'   => gmdate( 'd', strtotime( $start_date ) ),
					);
					$date_query_args['inclusive'] = true;
				}

				// If the end date is provided.
				if ( ! empty( $end_date ) ) {
					$date_query_args['before']    = array(
						'year'  => gmdate( 'Y', strtotime( $end_date ) ),
						'month' => gmdate( 'm', strtotime( $end_date ) ),
						'day'   => gmdate( 'd', strtotime( $end_date ) ),
					);
					$date_query_args['inclusive'] = true;
				}

				if ( ! empty( $date_query_args ) ) {
					$query->set( 'date_query', $date_query_args );
				}
			}
		}

		// Post type - leave.
		if ( 'leave' === $post_type ) {
			// If not admin, show the leaves created by self.
			if ( ! current_user_can( 'manage_options' ) ) {
				$query->set( 'author', get_current_user_id() );
			}
		}

		// Post type - Therapist Logs.
		if ( 'therapist-log' === $post_type ) {
			// If not admin, show the leaves created by self.
			if ( ! current_user_can( 'manage_options' ) ) {
				$query->set( 'author', get_current_user_id() );
			}
		}

		return $query;
	}

	/**
	 * AJAX to collect the learning lounge logs.
	 */
	public function cf_export_learning_lounge_log_callback() {
		$action = filter_input( INPUT_POST, 'action', FILTER_SANITIZE_STRING );

		// Return, if the action doesn't match.
		if ( 'export_learning_lounge_log' !== $action ) {
			echo 0;
			wp_die();
		}

		// Fetch the clubs.
		$logs_query = cf_get_learning_lounge_logs();
		$logs       = $logs_query->posts;

		// Exit the query if there are no clubs.
		if ( empty( $logs ) || ! is_array( $logs ) ) {
			exit();
		}

		// Iterate through the clubs array to fetch the data.
		foreach ( $logs as $log_id ) {
			$log_post = get_post( $log_id );

			// Gather the data now.
			$logs_data[ $log_id ] = array(
				'ID'                  => $log_id,
				'Log Title'           => $log_post->post_title,
				'Log URL'             => get_permalink( $log_id ),
				'Student Name'        => get_field( 'student_name', $log_id ),
				'Internship Duration' => get_field( 'internship_duration', $log_id ),
				'Amount Paid'         => get_field( 'amount_paid', $log_id ),
				'Course Opted'        => get_field( 'course_opted', $log_id ),
				'Mode of Payment'     => get_field( 'mode_of_payment', $log_id ),
				'Payment Date'        => get_field( 'payment_date', $log_id ),
				'Bank Name'           => get_field( 'name_of_the_bank', $log_id ),
			);
		}

		// Send this array of clubs to be downloaded.
		return $this->download_csv( $logs_data );
	}

	/**
	 * Modify the learning lounge log arguments to fetch the data.
	 *
	 * @param array $args Holds the learning lounge logs post arguments.
	 * @return array
	 */
	public function cf_cf_learning_lounge_logs_args_callback( $args ) {
		// Posted data.
		$start_date = filter_input( INPUT_POST, 'start_date', FILTER_SANITIZE_STRING );
		$end_date   = filter_input( INPUT_POST, 'end_date', FILTER_SANITIZE_STRING );

		// If start date is available.
		if ( ! empty( $start_date ) ) {
			$args['date_query']['after'] = array(
				'year'  => gmdate( 'Y', strtotime( $start_date ) ),
				'month' => gmdate( 'm', strtotime( $start_date ) ),
				'day'   => gmdate( 'd', strtotime( $start_date ) ),
			);
		}

		// If end date is available.
		if ( ! empty( $end_date ) ) {
			$args['date_query']['before'] = array(
				'year'  => gmdate( 'Y', strtotime( $end_date ) ),
				'month' => gmdate( 'm', strtotime( $end_date ) ),
				'day'   => gmdate( 'd', strtotime( $end_date ) ),
			);
		}

		return $args;
	}

	/**
	 * Function to add custom columns to the learning lounge logs.
	 *
	 * @param $columns array Holds the default columns array.
	 * @return array
	 */
	public function cf_manage_learning_lounge_log_posts_columns_callback( $columns = array() ) {
		$columns['student_name']        = __( 'Student Name', 'core-functions' );
		$columns['internship_duration'] = __( 'Internship Duration', 'core-functions' );
		$columns['amount_paid']         = __( 'Amount Paid', 'core-functions' );

		return $columns;
	}

	/**
	 * Function to add custom columns content on the learning lounge logs.
	 *
	 * @param string $column_name Holds the column name.
	 * @param int $post_id Holds the post ID.
	 */
	public function cf_manage_learning_lounge_log_posts_custom_column_callback( $column_name, $post_id ) {
		// Check for student name column.
		if ( 'student_name' === $column_name ) {
			echo get_field( 'student_name', $post_id );
		}

		// Check for internship duration column.
		if ( 'internship_duration' === $column_name ) {
			echo get_field( 'internship_duration', $post_id );
			$course_opted = get_field( 'course_opted', $post_id );

			if ( ! empty( $course_opted ) ) {
				echo '<br />';
				echo sprintf( __( 'Course Opted: %1$s', 'core-functions' ), $course_opted );
			}
		}

		// Check for amount paid column.
		if ( 'amount_paid' === $column_name ) {
			echo '₹' . get_field( 'amount_paid', $post_id );
			$mode_of_payment = get_field( 'mode_of_payment', $post_id );
			$bank_name       = get_field( 'name_of_the_bank', $post_id );
			$payment_date    = get_field( 'payment_date', $post_id );
			$transaction_id  = get_field( 'transaction_id', $post_id );

			// Display the mode of payment.
			if ( ! empty( $mode_of_payment ) ) {
				echo " ({$mode_of_payment})";
			}

			// Display the payment date.
			if ( ! empty( $payment_date ) ) {
				echo '<br />';
				echo sprintf( __( 'on: %1$s', 'core-functions' ), $payment_date );
			}

			// Display the bank name.
			if ( ! empty( $bank_name ) ) {
				echo '<br />';
				echo sprintf( __( 'via: %1$s', 'core-functions' ), $bank_name );
			}

			// Display the transaction ID.
			if ( ! empty( $transaction_id ) ) {
				echo '<br />';
				echo sprintf( __( 'Txn. ID: %1$s', 'core-functions' ), $transaction_id );
			}
		}
	}

	/**
	 * Add custom menu page.
	 */
	public function cf_admin_menu_callback() {
		// Payment history page.
		add_menu_page(
			__( 'Payment History', 'core-functions' ),
			__( 'Payment History', 'core-functions' ),
			'can_create_learning_lounge_log',
			'payment-history',
			array( $this, 'cf_payment_history_callback' ),
			'dashicons-backup'
		);

		// Add payment information page.
		add_submenu_page(
			'payment-history',
			__( 'Payment Information', 'core-functions' ),
			__( 'Payment Information', 'core-functions' ),
			'can_create_learning_lounge_log',
			'payment-information',
			array( $this, 'cf_payment_information_callback' ),
		);

		// Update client's payment balance.
		add_menu_page(
			__( 'Add Client Payment', 'core-functions' ),
			__( 'Add Client Payment', 'core-functions' ),
			'cf_update_client_payment_balance',
			'add-client-payment',
			array( $this, 'cf_add_client_payment_callback' ),
			'dashicons-money-alt'
		);
	}

	/**
	 * Template for showing payment history.
	 */
	public function cf_payment_history_callback() {
		?>
		<div class="wrap">
			<div>
				<h1 class="wp-heading-inline"><?php esc_html_e( 'Your Payment History', 'core-functions' ); ?></h1>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=payment-information' ) ); ?>" class="page-title-action"><?php esc_html_e( 'Add Payment Information', 'core-functions' ); ?></a>
			</div>
			<p><?php esc_html_e( 'Following is the list of all the payment records added by you.', 'core-functions' ); ?></p>
			<?php
			require_once CF_PLUGIN_PATH . 'admin/templates/menu-pages/payment-history.php';
			$payment_history_obj = new Cf_Payment_History_Table();
			$payment_history_obj->prepare_items();
			$payment_history_obj->display();
			?>
		</div>
		<?php
	}

	/**
	 * Template for adding payment information.
	 */
	public function cf_payment_information_callback() {
		require_once CF_PLUGIN_PATH . 'admin/templates/menu-pages/payment-information.php';
	}

	/**
	 * Function to add custom columns to the client logs.
	 *
	 * @param array $columns Holds the default columns array.
	 * @return array
	 */
	public function cf_manage_client_log_posts_columns_callback( $columns = array() ) {
		$columns['session_date']  = __( 'Session Date', 'core-functions' );
		$columns['time_in_out']   = __( 'Time In & Out', 'core-functions' );
		$columns['homework_done'] = __( 'Homework Done?', 'core-functions' );
		$columns['payment_due']   = __( 'Payment Due', 'core-functions' );

		return $columns;
	}

	/**
	 * Function to add custom columns content on the client logs.
	 *
	 * @param string $column_name Holds the column name.
	 * @param int $post_id Holds the post ID.
	 */
	public function cf_manage_client_log_posts_custom_column_callback( $column_name, $post_id ) {
		// Check for session date column.
		if ( 'session_date' === $column_name ) {
			echo gmdate( 'F j, Y', strtotime( get_field( 'session_date', $post_id ) ) );
		}

		// Check for time in and out column.
		if ( 'time_in_out' === $column_name ) {
			$time_in  = gmdate( 'H:i A', strtotime( get_field( 'time_in', $post_id ) ) );
			$time_out = gmdate( 'H:i A', strtotime( get_field( 'time_out', $post_id ) ) );
			echo sprintf( __( 'Time In: %1$s%2$sTime Out: %3$s', 'core-functions' ), $time_in, '<br />', $time_out );
		}

		// Check for homework done column.
		if ( 'homework_done' === $column_name ) {
			$homework_done = get_field( 'homework_done', $post_id );
			echo ( true === $homework_done ) ? __( 'Yes', 'core-functions' ) : __( 'No', 'core-functions' );
		}

		// Check for payment due status column.
		if ( 'payment_due' === $column_name ) {
			echo get_field( 'payment_due', $post_id );
		}
	}

	/**
	 * Template for adding payment information.
	 */
	public function cf_add_client_payment_callback() {
		require_once CF_PLUGIN_PATH . 'admin/templates/menu-pages/add-client-payment.php';
	}

	/*
	* Function to return add custom field for user profile
	*/
	public function cf_extra_user_profile_fields( $user ) {
		$current_user = wp_get_current_user(); ?>
		<h3><?php _e("Salary information", "blank"); ?></h3>
		<table class="form-table">
	    <tr>
	        <th><label for="monthly_salary"><?php _e("Monthly Net Salary"); ?></label></th>
					<?php
					if (user_can( $current_user, 'administrator' )) { ?>
	        <td>
	            <input type="number" name="monthly_salary" id="monthly_salary" value="<?php echo esc_attr( get_the_author_meta( 'monthly_salary', $user->ID ) ); ?>" class="regular-text" /><br />
	        </td>
				<?php } elseif(user_can( $current_user, 'therapist' )) { ?>
					<td>
	            <strong><label for="monthly_salary"><?php echo esc_attr( get_the_author_meta( 'monthly_salary', $user->ID ) ); ?></label></strong>
	        </td>

				<?php } ?>
	    </tr>
	  </table>
		<?php
	}
	/*
	Function to save usermeta
	*/
	public function cf_save_extra_user_profile_fields( $user_id ) {
    if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'update-user_' . $user_id ) ) {
        return;
    }

    if ( !current_user_can( 'edit_user', $user_id ) ) {
        return false;
    }
		$current_user = wp_get_current_user();
		if (user_can( $current_user, 'administrator' )) {
    		update_user_meta( $user_id, 'monthly_salary', $_POST['monthly_salary'] );
    }
	}
	public function cf_acf_read_only( $field ) {
		if( current_user_can('therapist') ){
			// Disabled
			$field['disabled'] = true;
			// Readonly
			$field['readonly'] = true;
			
		}
		return $field;
	}
	public function cf_acf_read_only_reject_reason( $field ) {
		if( current_user_can('therapist') ){
			// Disabled
			$field['disabled'] = true;
			// Readonly
			$field['readonly'] = true;
			
		}
		return $field;
	}

	/**
	 * Function to add custom columns to the leaves listing.
	 *
	 * @param $columns array Holds the default columns array.
	 * @return array
	 */
	public function cf_manage_leave_posts_columns_callback( $columns = array() ) {
		$columns['leave_dates']   = __( 'Date(s)', 'core-functions' );
		$columns['leave_type']    = __( 'Type', 'core-functions' );
		$columns['leave_remarks'] = __( 'Remarks', 'core-functions' );
		$columns['leave_status']  = __( 'Status', 'core-functions' );

		return $columns;
	}

	/**
	 * Function to add custom columns content on the leaves listing.
	 *
	 * @param $column_name array Holds the column name.
	 * @param $post_id array Holds the post ID.
	 */
	public function cf_manage_leave_posts_custom_column( $column_name, $post_id ) {
		// Check for leave dates status columns.
		if ( 'leave_dates' === $column_name ) {
			$leave_from = gmdate( 'd M, Y', strtotime( get_post_meta( $post_id, 'leave_from', true ) ) );
			$leave_to   = gmdate( 'd M, Y', strtotime( get_post_meta( $post_id, 'to', true ) ) );

			// Select the only date if from and to are same.
			if ( $leave_from === $leave_to ) {
				echo "<p>{$leave_from}</p>";
			} else {
				echo "<p>{$leave_from}</p>";
				echo '<p>to</p>';
				echo "<p>{$leave_to}</p>";
			}
		}

		// Check for the leave type column.
		if ( 'leave_type' === $column_name ) {
			echo ucfirst( get_post_meta( $post_id, 'leave_duration', true ) );
		}

		// Check for the leave remarks column.
		if ( 'leave_remarks' === $column_name ) {
			echo get_post_meta( $post_id, 'reason_for_leave', true );
		}

		// Check for the leave status column.
		if ( 'leave_status' === $column_name ) {
			$leave_status = get_post_meta( $post_id, 'leave_approval', true );
			echo ucfirst( $leave_status );

			// Display the reject message, if rejected.
			if ( 'rejected' === $leave_status ) {
				echo sprintf( __( '%1$s[Message from admin: %3$s]%2$s', 'core-functions' ), '<p>', '</p>', get_field( 'reject_message', $post_id ) );
			}
		}
	}

	/**
	 * Add custom post row actions.
	 *
	 * @param array  $actions Holds the user row actions.
	 * @param object $post Holds the post data object.
	 * @return array
	 */
	public function cf_post_row_actions_callback( $actions = array(), $post ) {
		$current_user_id = get_current_user_id();
		// Add row actions to leaves.
		if ( 'leave' === $post->post_type ) {
			unset( $actions['inline hide-if-no-js'] );
			unset( $actions['view'] );
			unset( $actions['trash'] );

			$actions['post_id'] = sprintf( __( 'ID: %1$d', 'core-functions' ), $post->ID );

			// Add actions to approve and reject leaves for admin.
			if ( current_user_can( 'manage_options' ) ) {
				$leave_status = get_field( 'leave_approval', $post->ID );

				if ( 'approved' === $leave_status ) {
					$actions['reject_leave']  = '<a href="javascript:void(0);" data-leaveid="' . $post->ID . '" class="cf-reject-leave">' . __( 'Reject', 'core-functions' ) . '</a>';
				} elseif ( 'rejected' === $leave_status ) {
					$actions['approve_leave'] = '<a href="javascript:void(0);" data-leaveid="' . $post->ID . '" class="cf-approve-leave">' . __( 'Approve', 'core-functions' ) . '</a>';
				} else {
					$actions['reject_leave']  = '<a href="javascript:void(0);" data-leaveid="' . $post->ID . '" class="cf-reject-leave">' . __( 'Reject', 'core-functions' ) . '</a>';
					$actions['approve_leave'] = '<a href="javascript:void(0);" data-leaveid="' . $post->ID . '" class="cf-approve-leave">' . __( 'Approve', 'core-functions' ) . '</a>';
				}
			} else if ( true === cf_is_user_therapist( $current_user_id ) ) {
				$actions['cancel_leave']  = '<a href="javascript:void(0);" data-leaveid="' . $post->ID . '" class="cf-cancel-leave">' . __( 'Cancel', 'core-functions' ) . '</a>';
			}
		}

		return $actions;
	}

	/**
	 * AJAX to approve leave.
	 */
	public function cf_approve_leave_callback() {
		$action = filter_input( INPUT_POST, 'action', FILTER_SANITIZE_STRING );

		// Exit, if action mismatches.
		if ( empty( $action ) || 'approve_leave' !== $action ) {
			echo 0;
			wp_die();
		}

		// Leave ID.
		$leave_id = filter_input( INPUT_POST, 'leave_id', FILTER_SANITIZE_NUMBER_INT );

		// Get the leave dates.
		$leave_from  = gmdate( 'Y-m-d', strtotime( get_post_meta( $leave_id, 'leave_from', true ) ) );
		$leave_to    = gmdate( 'Y-m-d', strtotime( get_post_meta( $leave_id, 'to', true ) ) );
		$leave_dates = cf_get_dates_within_2_dates( $leave_from, $leave_to );

		// Get the leave author.
		$therapist_id = get_post_field( 'post_author', $leave_id );

		// Get the leave meta from user meta.
		$user_leaves = get_user_meta( $therapist_id, 'prayatna_leaves', true );

		// Iterate through the leave dates to remove them from user meta.
		if ( ! empty( $leave_dates ) && is_array( $leave_dates ) ) {
			foreach ( $leave_dates as $leave_date ) {
				$leave_year  = gmdate( 'Y', strtotime( $leave_date ) );
				$leave_month = gmdate( 'm', strtotime( $leave_date ) );
				$leave_date  = gmdate( 'd', strtotime( $leave_date ) );

				$user_leaves[ $leave_year ][ $leave_month ][ $leave_date ]['status']        = 'approved';
				$user_leaves[ $leave_year ][ $leave_month ][ $leave_date ]['reject_reason'] = '';
			}
		}

		// Update the remaining leaves to user meta.
		update_user_meta( $therapist_id, 'prayatna_leaves', $user_leaves );

		// Update the leave status.
		update_field( 'leave_approval', 'approved', $leave_id );

		$response = array(
			'code' => 'leave-approved'
		);
		wp_send_json_success( $response );
		wp_die();
	}

	/**
	 * AJAX to reject leave.
	 */
	public function cf_reject_leave_callback() {
		$action = filter_input( INPUT_POST, 'action', FILTER_SANITIZE_STRING );

		// Exit, if action mismatches.
		if ( empty( $action ) || 'reject_leave' !== $action ) {
			echo 0;
			wp_die();
		}

		// Posted data.
		$leave_id = filter_input( INPUT_POST, 'leave_id', FILTER_SANITIZE_NUMBER_INT );
		$message  = filter_input( INPUT_POST, 'message', FILTER_SANITIZE_STRING );

		// Get the leave dates.
		$leave_from  = gmdate( 'Y-m-d', strtotime( get_post_meta( $leave_id, 'leave_from', true ) ) );
		$leave_to    = gmdate( 'Y-m-d', strtotime( get_post_meta( $leave_id, 'to', true ) ) );
		$leave_dates = cf_get_dates_within_2_dates( $leave_from, $leave_to );

		// Get the leave author.
		$therapist_id = get_post_field( 'post_author', $leave_id );

		// Get the leave meta from user meta.
		$user_leaves = get_user_meta( $therapist_id, 'prayatna_leaves', true );

		// Iterate through the leave dates to remove them from user meta.
		if ( ! empty( $leave_dates ) && is_array( $leave_dates ) ) {
			foreach ( $leave_dates as $leave_date ) {
				$leave_year  = gmdate( 'Y', strtotime( $leave_date ) );
				$leave_month = gmdate( 'm', strtotime( $leave_date ) );
				$leave_date  = gmdate( 'd', strtotime( $leave_date ) );

				$user_leaves[ $leave_year ][ $leave_month ][ $leave_date ]['status']        = 'rejected';
				$user_leaves[ $leave_year ][ $leave_month ][ $leave_date ]['reject_reason'] = $message;
			}
		}

		// Update the remaining leaves to user meta.
		update_user_meta( $therapist_id, 'prayatna_leaves', $user_leaves );

		// Update the leave status.
		update_field( 'leave_approval', 'rejected', $leave_id );
		update_field( 'reject_message', $message, $leave_id );

		$response = array(
			'code' => 'leave-rejected'
		);
		wp_send_json_success( $response );
		wp_die();
	}

	/**
	 * AJAX to cancel leave.
	 */
	public function cf_cancel_leave_callback() {
		$action = filter_input( INPUT_POST, 'action', FILTER_SANITIZE_STRING );

		// Exit, if action mismatches.
		if ( empty( $action ) || 'cancel_leave' !== $action ) {
			echo 0;
			wp_die();
		}

		// Posted data.
		$leave_id = filter_input( INPUT_POST, 'leave_id', FILTER_SANITIZE_NUMBER_INT );

		// Get the leave dates.
		$leave_from  = gmdate( 'Y-m-d', strtotime( get_post_meta( $leave_id, 'leave_from', true ) ) );
		$leave_to    = gmdate( 'Y-m-d', strtotime( get_post_meta( $leave_id, 'to', true ) ) );
		$leave_dates = cf_get_dates_within_2_dates( $leave_from, $leave_to );

		// Get the leave author.
		$therapist_id = get_post_field( 'post_author', $leave_id );

		// Get the leave meta from user meta.
		$user_leaves = get_user_meta( $therapist_id, 'prayatna_leaves', true );

		// Iterate through the leave dates to remove them from user meta.
		if ( ! empty( $leave_dates ) && is_array( $leave_dates ) ) {
			foreach ( $leave_dates as $leave_date ) {
				$leave_year  = gmdate( 'Y', strtotime( $leave_date ) );
				$leave_month = gmdate( 'm', strtotime( $leave_date ) );
				$leave_date  = gmdate( 'd', strtotime( $leave_date ) );

				unset( $user_leaves[ $leave_year ][ $leave_month ][ $leave_date ] );
			}
		}

		// Update the remaining leaves to user meta.
		update_user_meta( $therapist_id, 'prayatna_leaves', $user_leaves );

		// Delete the leave post.
		wp_delete_post( $leave_id, true );

		$response = array(
			'code' => 'leave-cancelled'
		);
		wp_send_json_success( $response );
		wp_die();
	}

	/**
	 * Add custom user row actions.
	 *
	 * @param array  $actions Holds the user row actions.
	 * @param object $user Holds the user data object.
	 * @return array
	 */
	public function cf_user_row_actions_callback( $actions = array(), $user ) {
		// Remove the not-required row actions.
		if ( array_key_exists( 'view', $actions ) ) unset( $actions['view'] );
		if ( array_key_exists( 'resetpassword', $actions ) ) unset( $actions['resetpassword'] );
		if ( array_key_exists( 'capabilities', $actions ) ) unset( $actions['capabilities'] );

		$user_status  = get_user_meta( $user->ID, 'cf_user_status', true );
		$is_therapist = cf_is_user_therapist( $user->ID );

		// If the user status is pending.
		if ( true === $is_therapist && 'pending' === $user_status ) {
			// Add the action to approve the request.
			$actions['approve_request'] = '<a href="javascript:void(0);" class="cf-approve-request">' . __( 'Approve', 'core-functions' ) . '</a>';

			// Add the action to decline the request.
			$actions['decline_request'] = '<a href="javascript:void(0);" class="cf-decline-request">' . __( 'Decline', 'core-functions' ) . '</a>';
		}

		// If the user status .
		if ( true === $is_therapist && 'registration-declined' === $user_status ) {
			// Add the action to re-approve the request.
			$actions['reapprove_request'] = '<a href="javascript:void(0);" class="cf-reapprove-request">' . __( 'Reactivate', 'core-functions' ) . '</a>';
		}

		/**
		 * Email the salary slip.
		 * This action should only be displayed between 1st to 7th of every month.
		 *
		 * Check the current date.
		 */
		$current_date = (int) cf_get_current_date( 'd' );
		$current_date = 5; // for testing

		if ( 1 <= $current_date && 7 >= $current_date ) {
			if ( current_user_can( 'manage_options' ) && true === $is_therapist ) {
				// Mail the salary slip.
				$last_month                  = gmdate( 'M Y', strtotime( 'last month' ) );
				$email_salary_slip_link_text = sprintf( __( 'Email Salary Slip for %1$s', 'core-functions' ), $last_month );
				$actions['mail_salary_slip'] = '<a href="javascript:void(0);" class="cf-email-salary-slip">' . $email_salary_slip_link_text . '</a>';
			}
		}

		return $actions;
	}

	/**
	 * AJAX served to approve the registration request.
	 */
	public function cf_approve_therapist_registration_callback() {
		$action = filter_input( INPUT_POST, 'action', FILTER_SANITIZE_STRING );

		// Return, if the action doesn't match.
		if ( 'approve_therapist_registration' !== $action ) {
			echo 0;
			wp_die();
		}

		// Posted data.
		$user_id    = (int) filter_input( INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT );
		$user       = get_userdata( $user_id );
		$first_name = get_user_meta( $user_id, 'first_name', true );

		// Update the user status.
		update_user_meta( $user_id, 'cf_user_status', 'active' );

		// Send the registration approval email.
		$email_body = get_field( 'therapist_registration_approval_email_body', 'option' );
		$email_body = str_replace( '{first_name}', $first_name, $email_body );
		$email_body = str_replace( '{site_url}', home_url(), $email_body );
		$email_body = str_replace( '{site_name}', get_bloginfo( 'name' ), $email_body );
		$email_body = str_replace( '{login_link}', home_url( '/login/' ), $email_body );

		// Send the email now.
		wp_mail(
			$user->data->user_email,
			__( 'Prayatna Counselling - You\'re Most Welcome!!', 'core-functions' ),
			$email_body
		);

		// Send the ajax response.
		$response = array(
			'code'     => 'request-approved',
			'message'  => __( 'Request Approved !! Reloading..', 'core-functions' ),
		);
		wp_send_json_success( $response );
		wp_die();
	}

	/**
	 * AJAX served to decline the registration request.
	 */
	public function cf_decline_therapist_registration_callback() {
		$action = filter_input( INPUT_POST, 'action', FILTER_SANITIZE_STRING );

		// Return, if the action doesn't match.
		if ( 'decline_therapist_registration' !== $action ) {
			echo 0;
			wp_die();
		}

		// Posted data.
		$user_id = (int) filter_input( INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT );
		$reason  = filter_input( INPUT_POST, 'decline_reason', FILTER_SANITIZE_STRING );
		$user    = get_userdata( $user_id );

		// Update the user status and decline reason.
		update_user_meta( $user_id, 'cf_user_status', 'registration-declined' );
		update_user_meta( $user_id, 'cf_user_registration_decline_reason', $reason );

		// Send the registration denial email.
		$email_body = get_field( 'therapist_registration_denial_email_body', 'option' );
		$email_body = str_replace( '{first_name}', cf_get_user_full_name( $user_id ), $email_body );
		$email_body = str_replace( '{site_url}', home_url(), $email_body );
		$email_body = str_replace( '{site_name}', get_bloginfo( 'name' ), $email_body );
		$email_body = str_replace( '{denial_reason}', $reason, $email_body );
		$email_body = str_replace( '{admin_email}', get_option( 'admin_email' ), $email_body );

		// Send the email now.
		wp_mail(
			$user->data->user_email,
			__( 'Prayatna Counselling - Registration Request Declined', 'core-functions' ),
			$email_body
		);

		// Send the ajax response.
		$response = array(
			'code'    => 'request-declined',
			'message' => __( 'Request Declined !! Reloading..', 'core-functions' ),
		);
		wp_send_json_success( $response );
		wp_die();
	}

	/**
	 * AJAX served to reapprove user.
	 */
	public function cf_reapprove_therapist_registration_callback() {
		$action = filter_input( INPUT_POST, 'action', FILTER_SANITIZE_STRING );

		// Return, if the action doesn't match.
		if ( 'reapprove_therapist_registration' !== $action ) {
			echo 0;
			wp_die();
		}

		// Posted data.
		$user_id    = (int) filter_input( INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT );
		$user       = get_userdata( $user_id );
		$fullname   = cf_get_user_full_name( $user_id );
		$first_name = get_user_meta( $user_id, 'first_name', true );

		// Update the user status.
		update_user_meta( $user_id, 'cf_user_status', 'active' );

		// Send the suspension email.
		$email_body = get_field( 'therapist_registration_reapproval_email_body', 'option' );
		$email_body = str_replace( '{first_name}', $fullname, $email_body );
		$email_body = str_replace( '{site_url}', home_url(), $email_body );
		$email_body = str_replace( '{site_name}', get_bloginfo( 'name' ), $email_body );
		$email_body = str_replace( '{admin_email}', get_option( 'admin_email' ), $email_body );
		$email_body = str_replace( '{login_link}', home_url( '/login/' ), $email_body );

		// Send the email now.
		wp_mail(
			$user->data->user_email,
			__( 'Prayatna Counselling - You\'re Most Welcome!!', 'core-functions' ),
			$email_body
		);

		// Send the ajax response.
		$response = array(
			'code'    => 'user-reapproved',
			'message' => __( 'User account reactivated !! Reloading..', 'core-functions' ),
		);
		wp_send_json_success( $response );
		wp_die();
	}

	/**
	 * AJAX served to reapprove user.
	 */
	public function cf_email_salary_slip_to_therapist_callback() {
		$action = filter_input( INPUT_POST, 'action', FILTER_SANITIZE_STRING );

		// Return, if the action doesn't match.
		if ( 'email_salary_slip_to_therapist' !== $action ) {
			echo 0;
			wp_die();
		}

		// Posted data.
		$user_id    = (int) filter_input( INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT );
		$user       = get_userdata( $user_id );
		$fullname   = cf_get_user_full_name( $user_id );
		$first_name = get_user_meta( $user_id, 'first_name', true );

		// Get the last month.
		$last_year  = gmdate( 'Y', strtotime( 'last month' ) );
		$last_month = gmdate( 'm', strtotime( 'last month' ) );

		// Therapist leaves.
		$user_leaves = get_user_meta( $user_id, 'prayatna_leaves', true );

		// Get the monthly salary.
		$salary = (float) get_user_meta( $user_id, 'monthly_salary', true );

		// Check if the user has leaves in last month.
		if ( ! empty( $user_leaves[ $last_year ][ $last_month ] ) && is_array( $user_leaves[ $last_year ][ $last_month ] ) ) {
			$fullday_leaves = 0;
			$halfday_leaves = 0;
			$leaves_data    = $user_leaves[ $last_year ][ $last_month ];

			// Iterate through the leaves.
			foreach ( $leaves_data as $leave_data ) {
				if ( 1 === $leave_data['type'] ) {
					$fullday_leaves++;
				} elseif ( 0.5 === $leave_data['type'] ) {
					$halfday_leaves++;
				}
			}

			// Convert the halfday leaves into fullday, if they are more than 1.
			if ( 1 < $halfday_leaves ) {
				$convertible_fullday_leaves = (int) ( $halfday_leaves / 2 );
				$remaining_halfday_leaves   = $halfday_leaves % 2;

				// Update the leaves count now.
				$fullday_leaves += $convertible_fullday_leaves;
				$halfday_leaves  = $remaining_halfday_leaves;
			}

			// Get the paid leaves.
			$paid_leaves = (int) get_field( 'paid_leaves_per_month', 'option' );
			$total_leaves = $fullday_leaves + $halfday_leaves;
			// Deduct the paid leaves.
			if ( $paid_leaves <= $fullday_leaves ) {
				$fullday_leaves -= $paid_leaves;
			} else {
				$fullday_leaves = 0;
				$halfday_leaves = 0;
			}

			// Calculate the salary now, if there are leaves.
			if ( 0 < $fullday_leaves && 0 < $halfday_leaves ) {
				$num_of_days   = (int) gmdate( 't', mktime( 0, 0, 0, $last_month, 1, $last_year ) ); // Days in last month.
				$perday_salary = ( $salary / $num_of_days ); // Perday salary.
				$perday_salary = number_format( (float) $perday_salary, 2, '.', '' );

				// Amount to be deducted.
				$fullday_leaves_deduction = $perday_salary * $fullday_leaves;
				$fullday_leaves_deduction = number_format( (float) $fullday_leaves_deduction, 2, '.', '' );
				$halfday_leaves_deduction = $perday_salary * 0.5;
				$halfday_leaves_deduction = number_format( (float) $halfday_leaves_deduction, 2, '.', '' );
				$total_deduction          = $fullday_leaves_deduction + $halfday_leaves_deduction;
				$salary                   = $salary - $total_deduction;
			}
		}
		// debug($total_leaves);
		// die;
		// var_dump( $salary );
		

		// Send the suspension email.
		$email_body = get_field( 'salary_slip_email_body', 'option' );
		$email_body = str_replace( '{first_name}', $fullname, $email_body );
		$email_body = str_replace( '{site_url}', home_url(), $email_body );
		$email_body = str_replace( '{site_name}', get_bloginfo( 'name' ), $email_body );
		$email_body = str_replace( '{admin_email}', get_option( 'admin_email' ), $email_body );
		$email_body = str_replace( '{login_link}', home_url( '/login/' ), $email_body );
		
		// creating PDF for salary
		
		$last_month_text  = gmdate( 'M', strtotime( 'last month' ) );
		echo cf_create_exporting_pdf($user_id,$first_name,$last_month_text,$total_leaves,$paid_leaves,$total_deduction,$salary);
		$attachments = array(CF_PLUGIN_PATH . 'pdf-generation/salary_'.$first_name.'_'.$last_month_text.'.pdf');
		// echo $email_body;
		// die;

		// Send the email now.
		wp_mail(
			$user->data->user_email,
			__( 'Prayatna Counselling - You\'re Most Welcome!!', 'core-functions' ),
			$email_body,
			'',
			$attachments
		);

		// Send the ajax response.
		$response = array(
			'code'    => 'user-reapproved',
			'message' => __( 'User account reactivated !! Reloading..', 'core-functions' ),
		);
		wp_send_json_success( $response );
		wp_die();
	}
}
