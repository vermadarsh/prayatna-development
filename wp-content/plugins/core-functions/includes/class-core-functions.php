<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/vermadarsh/
 * @since      1.0.0
 *
 * @package    Core_Functions
 * @subpackage Core_Functions/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Core_Functions
 * @subpackage Core_Functions/includes
 * @author     Adarsh Verma <adarsh.srmcem@gmail.com>
 */
class Core_Functions {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Core_Functions_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->version     = ( defined( 'CF_PLUGIN_VERSION' ) ) ? CF_PLUGIN_VERSION : '1.0.0';
		$this->plugin_name = 'core-functions';
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Core_Functions_Loader. Orchestrates the hooks of the plugin.
	 * - Core_Functions_i18n. Defines internationalization functionality.
	 * - Core_Functions_Admin. Defines all hooks for the admin area.
	 * - Core_Functions_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		// The class responsible for orchestrating the actions and filters of the core plugin.
		require_once CF_PLUGIN_PATH . 'includes/class-core-functions-loader.php';

		// The class responsible for defining internationalization functionality of the plugin.
		require_once CF_PLUGIN_PATH . 'includes/class-core-functions-i18n.php';

		// The class responsible for defining all custom functions.
		require_once CF_PLUGIN_PATH . 'includes/core-functions.php';

		// The class responsible for defining all actions that occur in the admin area.
		require_once CF_PLUGIN_PATH . 'admin/class-core-functions-admin.php';

		// The class responsible for defining all actions that occur in the public-facing side of the site.
		require_once CF_PLUGIN_PATH . 'public/class-core-functions-public.php';

		$this->loader = new Core_Functions_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Core_Functions_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Core_Functions_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Core_Functions_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'cf_admin_enqueue_scripts_callback' );
		$this->loader->add_filter( 'get_avatar_url', $plugin_admin, 'cf_get_avatar_url_callback', 10, 2 );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new Core_Functions_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'cf_wp_enqueue_scripts_callback' );
		$this->loader->add_shortcode( 'register_as_therapist', $plugin_public, 'cf_register_as_therapist_callback' );
		$this->loader->add_shortcode( 'register_as_client', $plugin_public, 'cf_register_as_client_callback' );
		$this->loader->add_action( 'init', $plugin_public, 'cf_init_callback' );
		$this->loader->add_action( 'wp_footer', $plugin_public, 'cf_wp_footer_callback' );
		$this->loader->add_action( 'wp_ajax_nopriv_register_therapist', $plugin_public, 'cf_register_therapist_callback' );
		$this->loader->add_action( 'wp_ajax_nopriv_upload_therapist_profile_picture', $plugin_public, 'cf_upload_therapist_profile_picture_callback' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Core_Functions_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}
