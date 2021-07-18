<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/vermadarsh/
 * @since             1.0.0
 * @package           Core_Functions
 *
 * @wordpress-plugin
 * Plugin Name:       Core Functions
 * Plugin URI:        https://github.com/vermadarsh/
 * Description:       This plugin does all that the client demands.
 * Version:           1.0.0
 * Author:            Adarsh Verma
 * Author URI:        https://github.com/vermadarsh/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       core-functions
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// error_reporting( E_ALL );
// ini_set( 'display_errors', '1' );

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CF_PLUGIN_VERSION', '1.0.0' );

// Plugin path.
if ( ! defined( 'CF_PLUGIN_PATH' ) ) {
	define( 'CF_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
}

// Plugin URL.
if ( ! defined( 'CF_PLUGIN_URL' ) ) {
	define( 'CF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-core-functions-activator.php
 */
function cf_activate_core_functions() {
	require_once CF_PLUGIN_PATH . 'includes/class-core-functions-activator.php';
	Core_Functions_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-core-functions-deactivator.php
 */
function cf_deactivate_core_functions() {
	require_once CF_PLUGIN_PATH . 'includes/class-core-functions-deactivator.php';
	Core_Functions_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'cf_activate_core_functions' );
register_deactivation_hook( __FILE__, 'cf_deactivate_core_functions' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_core_functions() {
	// The core plugin class that is used to define internationalization, admin-specific hooks, and public-facing site hooks.
	require CF_PLUGIN_PATH . 'includes/class-core-functions.php';
	$plugin = new Core_Functions();
	$plugin->run();
}

/**
 * Include the requirement of any plugin here.
 */
function cf_plugins_loaded_callback() {
	run_core_functions();
}

add_action( 'plugins_loaded', 'cf_plugins_loaded_callback' );

/**
 * Debugger function which shall be removed in production.
 */
if ( ! function_exists( 'debug' ) ) {
	/**
	 * Debug function definition.
	 */
	function debug( $params ) {
		echo '<pre>';
		print_r( $params );
		echo '</pre>';
	}
}

// add_action( 'init', function() {
// 	debug( get_user_meta( 20 ) );
// 	die("pool");
// } );
