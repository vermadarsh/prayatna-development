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
				'ajaxurl'                    => admin_url( 'admin-ajax.php' ),
				'export_logs_button_text'    => __( 'Export Log', 'core-functions' ),
				'exporting_logs_button_text' => __( 'Processing...', 'core-functions' ),
				'is_administrator'           => ( current_user_can( 'manage_options' ) ) ? 'yes' : 'no',
			)
		);
	}

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
		if ( null === $profile_picture_id ) {
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

		$status = get_user_meta( $user->ID, 'cf_user_status', true );

		// Registration status pending.
		if ( ! empty( $status ) && 'pending' === $status ) {
			return new WP_Error( 'user-status-pending', sprintf( __( 'Sorry, but your email verification is pending. Please verify your email and try again.', 'core-functions' ), get_option( 'admin_email' ) ) );
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

		// Add a custom metabox to display all the children.
		add_meta_box(
			'child-for-client-log',
			__( 'Child', 'core-functions' ),
			array( $this, 'cf_child_for_client_log_callback' ),
			'client-log',
			'normal',
		);
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

		// Update the leaves meta data.
	 	if ( 'leave' === get_post_type( $post_id ) ) {
	 		// Return, if the post status is not published.
			if ( isset( $post->post_status ) && ( 'auto-draft' === $post->post_status || 'trash' === $post->post_status ) ) {
				return;
			}

			// Get the current user.
			$user = wp_get_current_user();

			// Return, if the current user is not therapist.
			if ( ! cf_is_user_therapist( $user->ID ) ) {
				return;
			}


			$leaveStartDate   = get_field( 'leave_from',$post_id );
			$leaveEndDate     = get_field( 'to',$post_id );
			$time             = strtotime($leaveStartDate);
			$month            = date("m",$time);
			$year             = date("Y",$time);
			$leave_date       = date("d",$time);
			$leave_type       = get_field('leave_duration',$post_id);
			$leave_type       = ('full' === $leave_type) ? 1 : 0.5;
			$userFname        = $user->user_firstname;
			$userLname        = $user->user_lastname;
			$date1            = new DateTime( $leaveStartDate );
			$unix1            = strtotime( $date1->format( 'Y-m-d' ) );
			$date2            = new DateTime( $leaveEndDate );
			$unix2            = strtotime( $date2->format( 'Y-m-d' ) );
			$numberOfDayLeave = ( 0 === ( $unix1 - $unix2 ) ) ? '1 Day' : human_time_diff( $unix1, $unix2 );
			$leaves_days      = cf_get_dates_within_2_dates( $leaveStartDate, $leaveEndDate );

			// Prepare the leaves array.
			$leaves                                   = get_post_meta( $user->ID, 'prayatna_leaves', true );
			$leaves                                   = ( ! empty( $leaves ) ) ? $leaves : array();
			if ( ! empty( $leaves_days ) && is_array( $leaves_days ) ) {
				foreach( $leaves_days as $leave_full_date ) {
					$leave_year  = gmdate( 'Y', strtotime( $leave_full_date ) );
					$leave_month = gmdate( 'm', strtotime( $leave_full_date ) );
					$leave_date  = gmdate( 'd', strtotime( $leave_full_date ) );
					$leaves[ $leave_year ][ $leave_month ][ $leave_date ] = array(
						'type'   => $leave_type,
						'reason' => get_field( 'reason_for_leave', $post_id ),
					);
				}
			}

			// Update the leaves in the database.
			update_user_meta( $user->ID, 'prayatna_leaves', $leaves );

			// Prepare the email template.
			$emailTemplateBody = get_field('leave_apply_email','option');
			$emailTemplateBody = str_replace('{first_name}',$userFname.' '.$userLname,$emailTemplateBody);
			$emailTemplateBody = str_replace('{number_of_days}',$numberOfDayLeave,$emailTemplateBody);
			$emailTemplateBody = str_replace('{from_date}',$leaveStartDate,$emailTemplateBody);
			$emailTemplateBody = str_replace('{to_date}',$leaveEndDate,$emailTemplateBody);
			$emailTemplateBody = str_replace('{reason}.',$leaveReason,$emailTemplateBody);
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
}
