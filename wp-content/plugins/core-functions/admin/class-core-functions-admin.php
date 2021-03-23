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
}
