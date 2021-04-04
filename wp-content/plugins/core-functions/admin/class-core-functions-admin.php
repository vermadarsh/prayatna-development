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
	public function cf_save_post_callback( $post_id ) {
		// Check for client log post type.
		if ( 'client-log' === get_post_type( $post_id ) ) {
			$child = filter_input( INPUT_POST, 'cf-child', FILTER_SANITIZE_STRING );
			update_post_meta( $post_id, 'child', $child );
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
		$post_type  = filter_input( INPUT_GET, 'post_type', FILTER_SANITIZE_STRING );
		$start_date = filter_input( INPUT_GET, 'client-log-start-date', FILTER_SANITIZE_STRING );
		$end_date   = filter_input( INPUT_GET, 'client-log-end-date', FILTER_SANITIZE_STRING );

		if ( 'client-log' === $post_type ) {
			ob_start();
			?>
			<input type="text" name="client-log-start-date" value="<?php echo esc_html( $start_date ); ?>" placeholder="<?php esc_html_e( 'Logs From', 'core-functions' ); ?>" onfocus="(this.type='date')" onfocusout="(this.type='text')" />
			<input type="text" name="client-log-end-date" value="<?php echo esc_html( $end_date ); ?>" placeholder="<?php esc_html_e( 'Logs To', 'core-functions' ); ?>" onfocus="(this.type='date')" onfocusout="(this.type='text')" />
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

		// Get the custom filters.
		$start_date = filter_input( INPUT_GET, 'client-log-start-date', FILTER_SANITIZE_STRING );
		$end_date   = filter_input( INPUT_GET, 'client-log-end-date', FILTER_SANITIZE_STRING );
		$post_type  = filter_input( INPUT_GET, 'post_type', FILTER_SANITIZE_STRING );

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
}
