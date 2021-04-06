<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/vermadarsh/
 * @since      1.0.0
 *
 * @package    Core_Functions
 * @subpackage Core_Functions/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Core_Functions
 * @subpackage Core_Functions/public
 * @author     Adarsh Verma <adarsh.srmcem@gmail.com>
 */
class Core_Functions_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function cf_wp_enqueue_scripts_callback() {
		// Bootstrap css.
		wp_enqueue_style(
			$this->plugin_name . '-bootstrap-style',
			CF_PLUGIN_URL . 'public/css/bootstrap.min.css',
			array(),
			filemtime( CF_PLUGIN_PATH . 'public/css/bootstrap.min.css' )
		);

		// Enqueue the custom input styles.
		if ( is_page( 'register-as-therapist' ) || is_page( 'register-as-client' ) || is_page( 'register-as-student' ) ) {
			// Custom input box styles.
			wp_enqueue_style(
				$this->plugin_name . '-input-styles',
				CF_PLUGIN_URL . 'public/css/core-functions-input-styles.css',
				array(),
				filemtime( CF_PLUGIN_PATH . 'public/css/core-functions-input-styles.css' )
			);
		}

		// jQuery UI style.
		wp_enqueue_style(
			'cognify-jquery-ui-style',
			'//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'
		);

		// Custom notifications style.
		wp_enqueue_style(
			$this->plugin_name . 'custom-notifications',
			CF_PLUGIN_URL . 'public/css/core-functions-notifications.css',
			array(),
			filemtime( CF_PLUGIN_PATH . 'public/css/core-functions-notifications.css' )
		);

		// Public custom style.
		wp_enqueue_style(
			$this->plugin_name,
			CF_PLUGIN_URL . 'public/css/core-functions-public.css',
			array(),
			filemtime( CF_PLUGIN_PATH . 'public/css/core-functions-public.css' )
		);

		// Bootstrap script.
		wp_enqueue_script(
			$this->plugin_name . '-bootstrap-script',
			CF_PLUGIN_URL . 'public/js/bootstrap.min.js',
			array( 'jquery' ),
			filemtime( CF_PLUGIN_PATH . 'public/js/bootstrap.min.js' ),
			true
		);

		// Enqueue the custom input script.
		if ( is_page( 'register-as-therapist' ) || is_page( 'register-as-client' ) || is_page( 'register-as-student' ) ) {
			// Custom input box script.
			wp_enqueue_script(
				$this->plugin_name . '-input-script',
				CF_PLUGIN_URL . 'public/js/core-functions-input-script.js',
				array( 'jquery' ),
				filemtime( CF_PLUGIN_PATH . 'public/js/core-functions-input-script.js' ),
				true
			);

			// Input masking script.
			wp_enqueue_script(
				$this->plugin_name . 'inputmask-script',
				'https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.5/jquery.inputmask.min.js',
				array( 'jquery' ),
				time(),
				true
			);
		}

		// Public custom script.
		wp_enqueue_script(
			$this->plugin_name,
			CF_PLUGIN_URL . 'public/js/core-functions-public.js',
			array( 'jquery', 'jquery-ui-datepicker' ),
			filemtime( CF_PLUGIN_PATH . 'public/js/core-functions-public.js' ),
			true
		);

		// Localize public script.
		wp_localize_script(
			$this->plugin_name,
			'CF_Public_JS_Script_Vars',
			array(
				'ajaxurl'               => admin_url( 'admin-ajax.php' ),
				'show_password_text'    => __( 'Show Password', 'core-functions' ),
				'hide_password_text'    => __( 'Hide Password', 'core-functions' ),
				'registering_user_text' => __( 'We\'re getting you registered. Please wait...', 'core-functions' ),
			)
		);
	}

	/**
	 * Return the template for therapist registration form.
	 *
	 * @since 1.0.0
	 * @param array $args Holds the arguments array.
	 * @return string
	 */
	public function cf_register_as_therapist_callback( $args = array() ) {
		// Return, if it's the admin panel.
		if ( is_admin() ) {
			return;
		}

		// Render the filter HTML now.
		ob_start();
		if ( is_user_logged_in() ) {
			require_once CF_PLUGIN_PATH . 'public/templates/registration/already-logged-in.php';
		} else {
			require_once CF_PLUGIN_PATH . 'public/templates/registration/therapist.php';
		}
		return ob_get_clean();
	}

	/**
	 * Return the template for client registration form.
	 *
	 * @since 1.0.0
	 * @param array $args Holds the arguments array.
	 * @return string
	 */
	public function cf_register_as_client_callback( $args = array() ) {
		// Return, if it's the admin panel.
		if ( is_admin() ) {
			return;
		}

		// Render the filter HTML now.
		ob_start();
		if ( is_user_logged_in() ) {
			require_once CF_PLUGIN_PATH . 'public/templates/registration/already-logged-in.php';
		} else {
			require_once CF_PLUGIN_PATH . 'public/templates/registration/client.php';
		}
		return ob_get_clean();
	}

	/**
	 * Do something when WordPress initiates.
	 */
	public function cf_init_callback() {
		// Create custom settings pages for ACF Pro.
		if ( function_exists( 'acf_add_options_page' ) ) {
			// Theme options page.
			acf_add_options_page(
				array(
					'page_title' => __( 'Prayatna Settings', 'core-functions' ),
					'menu_title' => __( 'Prayatna Settings', 'core-functions' ),
					'menu_slug'  => 'prayatna-settings',
				)
			);
		}

		// Create custom post types.
		cf_register_client_log_cpt(); // Register client log CPT.
		cf_register_learning_lounge_log_cpt(); // Register learning lounge log CPT.
	}

	/**
	 * Load custom assets in the footer.
	 */
	public function cf_wp_footer_callback() {
		// Notification HTML.
		ob_start();
		?>
		<div class="notification_popup">
			<span class="notification_close"></span>
			<div class="notification_icon"><i class="fa fa-shield" aria-hidden="true"></i></div>
			<div class="notification_message">
				<h3 class="title"></h3>
				<p class="message"></p>
			</div>
		</div>
		<?php
		echo ob_get_clean();
	}

	/**
	 * AJAX for registering the therapist.
	 */
	public function cf_register_therapist_callback() {
		$action = filter_input( INPUT_POST, 'action', FILTER_SANITIZE_STRING );

		// Return, if the action doesn't match.
		if ( 'register_therapist' !== $action ) {
			echo 0;
			wp_die();
		}

		// Posted data.
		$first_name        = filter_input( INPUT_POST, 'first_name', FILTER_SANITIZE_STRING );
		$last_name         = filter_input( INPUT_POST, 'last_name', FILTER_SANITIZE_STRING );
		$phone             = filter_input( INPUT_POST, 'phone', FILTER_SANITIZE_STRING );
		$password          = filter_input( INPUT_POST, 'password', FILTER_SANITIZE_STRING );
		$dob               = filter_input( INPUT_POST, 'dob', FILTER_SANITIZE_STRING );
		$email             = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_STRING );
		$gender            = filter_input( INPUT_POST, 'gender', FILTER_SANITIZE_STRING );
		$temporary_address = filter_input( INPUT_POST, 'temporary_address', FILTER_SANITIZE_STRING );
		$permanent_address = filter_input( INPUT_POST, 'permanent_address', FILTER_SANITIZE_STRING );

		// Check if a user already exists with the email.
		if ( email_exists( $email ) ) {
			// Send the ajax response.
			$response = array(
				'code'              => 'therapist-exists',
				'notification_text' => sprintf( __( 'Email: %1$s is already registered. Please check %2$shere%3$s to login.', 'core-functions' ), $email, '<a href="' . home_url( '/login/' ) . '">', '</a>' ),
			);
			wp_send_json_success( $response );
			wp_die();
		}

		/* Register the therapist now. */

		// Extract the username from the email.
		$username = explode( '@', $email );
		$username = $username[0];

		// Create the user.
		$user_id = wp_create_user( $username, $password, $email );

		if ( $user_id ) {
			$random_number = time();
			update_user_meta( $user_id, 'cf_user_status', 'pending' );
			update_user_meta( $user_id, 'cf_user_email_verification', 'pending' );
			update_user_meta( $user_id, 'first_name', $first_name );
			update_user_meta( $user_id, 'last_name', $last_name );
			update_field( 'cf_contact_number', $phone, "user_{$user_id}" );
			update_field( 'cf_date_of_birth', $dob, "user_{$user_id}" );
			update_field( 'cf_gender', $gender, "user_{$user_id}" );
			update_field( 'cf_temporary_address', $temporary_address, "user_{$user_id}" );
			update_field( 'cf_permanent_address', $permanent_address, "user_{$user_id}" );
			update_user_meta( $user_id, 'email_verification_random_number', $random_number );

			// Set the user's role (and implicitly remove the previous role).
			$user = new \WP_User( $user_id );
			$user->set_role( 'therapist' );

			// Send back the response.
			$response = array(
				'code'              => 'therapist-created-upload-profile-photo',
				'notification_text' => __( 'Therapist account has been created. Please wait while we upload your profile picture.', 'core-functions' ),
				'random_number'     => $random_number,
				'user_id'           => $user_id,
				'first_name'        => $first_name,
				'email'             => $email,
			);
			wp_send_json_success( $response );
			wp_die();
		} else {
			$response = array(
				'code'              => 'therapist-not-created',
				'notification_text' => __( 'There is some problem creating the user. Please try again later.', 'core-functions' ),
			);
			wp_send_json_success( $response );
			wp_die();
		}
	}

	/**
	 * AJAX for uploading therapist's profile picture.
	 */
	public function cf_upload_therapist_profile_picture_callback() {
		$action = filter_input( INPUT_POST, 'action', FILTER_SANITIZE_STRING );

		// Return, if the action doesn't match.
		if ( 'upload_therapist_profile_picture' !== $action ) {
			echo 0;
			wp_die();
		}

		// Posted data.
		$random_number = filter_input( INPUT_POST, 'random_number', FILTER_SANITIZE_STRING );
		$user_id       = filter_input( INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT );
		$first_name    = filter_input( INPUT_POST, 'first_name', FILTER_SANITIZE_STRING );
		$email         = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_STRING );

		// Upload the profile picture.
		$filename    = $_FILES['profile_picture']['name'];
		$upload_file = wp_upload_bits( $filename, null, file_get_contents( $_FILES['profile_picture']['tmp_name'] ) );
		if ( ! $upload_file['error'] ) {
			$wp_filetype   = wp_check_filetype( $filename, null );
			$attachment    = array(
				'post_mime_type' => $wp_filetype['type'],
				'post_parent'    => 0,
				'post_title'     => preg_replace('/\.[^.]+$/', '', $filename),
				'post_content'   => '',
				'post_status'    => 'inherit'
			);
			$attachment_id = wp_insert_attachment( $attachment, $upload_file['file'] );
			if ( ! is_wp_error( $attachment_id ) ) {
				require_once( ABSPATH . 'wp-admin/includes/image.php' );
				$attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
				wp_update_attachment_metadata( $attachment_id,  $attachment_data );

				update_field( 'cf_profile_picture', $attachment_id, "user_{$user_id}" );
			}
		}

		// Email verification link.
		$email_verification_link = home_url( "/email-verification/?atts={$random_number}" );
		$login_link              = home_url( '/login/' );

		// Send the registration email.
		$email_body = get_field( 'therapist_registration_email_body', 'option' );
		$email_body = str_replace( '{first_name}', $first_name, $email_body );
		$email_body = str_replace( '{email_verification_link}', $email_verification_link, $email_body );
		$email_body = str_replace( '{login_link}', $login_link, $email_body );
		$email_body = str_replace( '{site_url}', home_url(), $email_body );
		$email_body = str_replace( '{site_name}', get_bloginfo( 'name' ), $email_body );
		wp_mail( $email, __( 'Prayatna - Registration Successful!!', 'core-functions' ), $email_body );

		// Set the success message.
		$registration_success = get_field( 'therapist_registration_success_message', 'option' );

		$response = array(
			'code'              => 'therapist-registration-complete',
			'notification_text' => $registration_success,
		);
		wp_send_json_success( $response );
		wp_die();
	}

	/**
	 * Return the template for user email verification.
	 *
	 * @since 1.0.0
	 * @param array $args Holds the arguments array.
	 * @return string
	 */
	public function cf_email_verification_callback( $args = array() ) {
		// Return, if it's the admin panel.
		if ( is_admin() ) {
			return;
		}

		// Render the filter HTML now.
		ob_start();
		require_once CF_PLUGIN_PATH . 'public/templates/registration/email-verification.php';
		return ob_get_clean();
	}

	/**
	 * AJAX to add child profile HTML.
	 */
	public function cf_add_child_profile_html_callback() {
		$action = filter_input( INPUT_POST, 'action', FILTER_SANITIZE_STRING );

		// Return, if the action doesn't match.
		if ( 'add_child_profile_html' !== $action ) {
			echo 0;
			wp_die();
		}

		// Posted data.
		$index = filter_input( INPUT_POST, 'index', FILTER_SANITIZE_NUMBER_INT );

		$response = array(
			'code' => 'child-profile-added',
			'html' => cf_get_child_profile_registration_fields_html( $index ),
		);
		wp_send_json_success( $response );
		wp_die();
	}

	/**
	 * AJAX for registering the client.
	 */
	public function cf_register_client_callback() {
		$action = filter_input( INPUT_POST, 'action', FILTER_SANITIZE_STRING );

		// Return, if the action doesn't match.
		if ( 'register_client' !== $action ) {
			echo 0;
			wp_die();
		}

		// Posted data.
		$first_name        = filter_input( INPUT_POST, 'first_name', FILTER_SANITIZE_STRING );
		$last_name         = filter_input( INPUT_POST, 'last_name', FILTER_SANITIZE_STRING );
		$phone             = filter_input( INPUT_POST, 'phone', FILTER_SANITIZE_STRING );
		$password          = filter_input( INPUT_POST, 'password', FILTER_SANITIZE_STRING );
		$email             = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_STRING );
		$temporary_address = filter_input( INPUT_POST, 'temporary_address', FILTER_SANITIZE_STRING );
		$permanent_address = filter_input( INPUT_POST, 'permanent_address', FILTER_SANITIZE_STRING );
		$posted_array      = filter_input_array( INPUT_POST );
		$children          = $posted_array['children'];

		// Check if a user already exists with the email.
		if ( email_exists( $email ) ) {
			// Send the ajax response.
			$response = array(
				'code'              => 'client-exists',
				'notification_text' => sprintf( __( 'Email: %1$s is already registered. Please check %2$shere%3$s to login.', 'core-functions' ), $email, '<a href="' . home_url( '/login/' ) . '">', '</a>' ),
			);
			wp_send_json_success( $response );
			wp_die();
		}

		/* Register the client now. */

		// Extract the username from the email.
		$username = explode( '@', $email );
		$username = $username[0];

		// Create the user.
		$user_id = wp_create_user( $username, $password, $email );

		if ( $user_id ) {
			$random_number = time();
			update_user_meta( $user_id, 'cf_user_status', 'pending' );
			update_user_meta( $user_id, 'cf_user_email_verification', 'pending' );
			update_user_meta( $user_id, 'first_name', $first_name );
			update_user_meta( $user_id, 'last_name', $last_name );
			update_field( 'cf_contact_number', $phone, "user_{$user_id}" );
			update_field( 'cf_temporary_address', $temporary_address, "user_{$user_id}" );
			update_field( 'cf_permanent_address', $permanent_address, "user_{$user_id}" );
			update_user_meta( $user_id, 'email_verification_random_number', $random_number );

			// Set the user's role (and implicitly remove the previous role).
			$user = new \WP_User( $user_id );
			$user->set_role( 'client' );

			// Add the children.
			if ( ! empty( $children ) && is_array( $children ) ) {
				foreach ( $children as $index => $child_data ) {
					$row_index = $index + 1;
					update_row(
						'children_details',
						$row_index,
						array(
							'child_first_name' => $child_data['first_name'],
							'child_last_name'  => $child_data['last_name'],
							'child_dob'        => $child_data['dob'],
							'child_gender'     => $child_data['gender'],
						),
						"user_{$user_id}"
					);
				}
			}

			// Email verification link.
			$email_verification_link = home_url( "/email-verification/?atts={$random_number}" );
			$login_link              = home_url( '/login/' );

			// Send the registration email.
			$email_body = get_field( 'client_registration_email_body', 'option' );
			$email_body = str_replace( '{first_name}', $first_name, $email_body );
			$email_body = str_replace( '{email_verification_link}', $email_verification_link, $email_body );
			$email_body = str_replace( '{login_link}', $login_link, $email_body );
			$email_body = str_replace( '{site_url}', home_url(), $email_body );
			$email_body = str_replace( '{site_name}', get_bloginfo( 'name' ), $email_body );
			wp_mail( $email, __( 'Prayatna - Registration Successful!!', 'core-functions' ), $email_body );

			// Set the success message.
			$registration_success = get_field( 'client_registration_success_message', 'option' );

			// Send back the response.
			$response = array(
				'code'              => 'client-registration-complete',
				'notification_text' => $registration_success,
			);
			wp_send_json_success( $response );
			wp_die();
		} else {
			$response = array(
				'code'              => 'client-not-created',
				'notification_text' => __( 'There is some problem creating the user. Please try again later.', 'core-functions' ),
			);
			wp_send_json_success( $response );
			wp_die();
		}
	}

	/**
	 * Return the template for student registration form.
	 *
	 * @since 1.0.0
	 * @param array $args Holds the arguments array.
	 * @return string
	 */
	public function cf_register_as_student_callback( $args = array() ) {
		// Return, if it's the admin panel.
		if ( is_admin() ) {
			return;
		}

		// Render the filter HTML now.
		ob_start();
		if ( is_user_logged_in() ) {
			require_once CF_PLUGIN_PATH . 'public/templates/registration/already-logged-in.php';
		} else {
			require_once CF_PLUGIN_PATH . 'public/templates/registration/student.php';
		}
		return ob_get_clean();
	}

	/**
	 * AJAX for registering the student.
	 */
	public function cf_register_student_callback() {
		$action = filter_input( INPUT_POST, 'action', FILTER_SANITIZE_STRING );

		// Return, if the action doesn't match.
		if ( 'register_student' !== $action ) {
			echo 0;
			wp_die();
		}

		// Posted data.
		$first_name              = filter_input( INPUT_POST, 'first_name', FILTER_SANITIZE_STRING );
		$last_name               = filter_input( INPUT_POST, 'last_name', FILTER_SANITIZE_STRING );
		$phone                   = filter_input( INPUT_POST, 'phone', FILTER_SANITIZE_STRING );
		$password                = filter_input( INPUT_POST, 'password', FILTER_SANITIZE_STRING );
		$email                   = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_STRING );
		$address                 = filter_input( INPUT_POST, 'address', FILTER_SANITIZE_STRING );
		$dob                     = filter_input( INPUT_POST, 'dob', FILTER_SANITIZE_STRING );
		$mode_of_learning        = filter_input( INPUT_POST, 'mode_of_learning', FILTER_SANITIZE_STRING );
		$education_qualification = filter_input( INPUT_POST, 'education_qualification', FILTER_SANITIZE_STRING );
		$institute_name          = filter_input( INPUT_POST, 'institute_name', FILTER_SANITIZE_STRING );
		$expectation             = filter_input( INPUT_POST, 'expectation', FILTER_SANITIZE_STRING );

		// Check if a user already exists with the email.
		if ( email_exists( $email ) ) {
			// Send the ajax response.
			$response = array(
				'code'              => 'student-exists',
				'notification_text' => sprintf( __( 'Email: %1$s is already registered. Please check %2$shere%3$s to login.', 'core-functions' ), $email, '<a href="' . home_url( '/login/' ) . '">', '</a>' ),
			);
			wp_send_json_success( $response );
			wp_die();
		}

		/* Register the student now. */

		// Extract the username from the email.
		$username = explode( '@', $email );
		$username = $username[0];

		// Create the user.
		$user_id = wp_create_user( $username, $password, $email );

		if ( $user_id ) {
			$random_number = time();
			update_user_meta( $user_id, 'cf_user_status', 'pending' );
			update_user_meta( $user_id, 'cf_user_email_verification', 'pending' );
			update_user_meta( $user_id, 'first_name', $first_name );
			update_user_meta( $user_id, 'last_name', $last_name );
			update_field( 'cf_contact_number', $phone, "user_{$user_id}" );
			update_field( 'cf_address', $address, "user_{$user_id}" );
			update_field( 'cf_date_of_birth', $dob, "user_{$user_id}" );
			update_field( 'cf_mode_of_learning', $mode_of_learning, "user_{$user_id}" );
			update_field( 'cf_education_qualification', $education_qualification, "user_{$user_id}" );
			update_field( 'cf_institute_name', $institute_name, "user_{$user_id}" );
			update_field( 'cf_expectation', $expectation, "user_{$user_id}" );
			update_user_meta( $user_id, 'email_verification_random_number', $random_number );

			// Set the user's role (and implicitly remove the previous role).
			$user = new \WP_User( $user_id );
			$user->set_role( 'student' );

			// Email verification link.
			$email_verification_link = home_url( "/email-verification/?atts={$random_number}" );
			$login_link              = home_url( '/login/' );

			// Send the registration email.
			$email_body = get_field( 'student_registration_email_body', 'option' );
			$email_body = str_replace( '{first_name}', $first_name, $email_body );
			$email_body = str_replace( '{email_verification_link}', $email_verification_link, $email_body );
			$email_body = str_replace( '{login_link}', $login_link, $email_body );
			$email_body = str_replace( '{site_url}', home_url(), $email_body );
			$email_body = str_replace( '{site_name}', get_bloginfo( 'name' ), $email_body );
			wp_mail( $email, __( 'Prayatna - Registration Successful!!', 'core-functions' ), $email_body );

			// Set the success message.
			$registration_success = get_field( 'student_registration_success_message', 'option' );

			// Send back the response.
			$response = array(
				'code'              => 'student-registration-complete',
				'notification_text' => $registration_success,
			);
			wp_send_json_success( $response );
			wp_die();
		} else {
			$response = array(
				'code'              => 'student-not-created',
				'notification_text' => __( 'There is some problem creating the user. Please try again later.', 'core-functions' ),
			);
			wp_send_json_success( $response );
			wp_die();
		}
	}
}
