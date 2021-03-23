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
		// Public custom style.
		wp_enqueue_style(
			$this->plugin_name,
			CF_PLUGIN_URL . 'public/css/core-functions-public.css',
			array(),
			filemtime( CF_PLUGIN_PATH . 'public/css/core-functions-public.css' ),
			'all'
		);

		// Public custom script.
		wp_enqueue_script(
			$this->plugin_name,
			CF_PLUGIN_URL . 'public/js/core-functions-public.js',
			array( 'jquery' ),
			filemtime( CF_PLUGIN_PATH . 'public/js/core-functions-public.js' ),
			false
		);

		// Localize public script.
		wp_localize_script(
			$this->plugin_name,
			'CF_Public_JS_Script_Vars',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
			)
		);
	}
}
