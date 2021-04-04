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
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
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
		$children = cf_get_children();

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
				echo '<option value="' . $option_val . '">' . $option_string . '</option>';
			}
		}
		echo '</select>';
	}
}
