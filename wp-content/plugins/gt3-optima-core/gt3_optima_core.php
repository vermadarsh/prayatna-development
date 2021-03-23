<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://themeforest.net/user/gt3themes
 * @since             1.0.0
 * @package           Gt3_wize_core
 *
 * @wordpress-plugin
 * Plugin Name:       GT3 Optima Core
 * Plugin URI:        https://themeforest.net/user/gt3themes
 * Description:       Core plugin for Optima Theme.
 * Version:           1.0.7
 * Author:            GT3themes
 * Author URI:        https://themeforest.net/user/gt3themes
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gt3_wize_core
 * Domain Path:       /languages
 */
 
 // If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'OPTIMA_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-gt3_wize_core-activator.php
 */
function activate_gt3_wize_core() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gt3_wize_core-activator.php';
	Gt3_wize_core_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-gt3_wize_core-deactivator.php
 */
function deactivate_gt3_wize_core() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gt3_wize_core-deactivator.php';
	Gt3_wize_core_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_gt3_wize_core' );
register_deactivation_hook( __FILE__, 'deactivate_gt3_wize_core' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-gt3_wize_core.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_gt3_wize_core() {

	$plugin = new Gt3_wize_core();
	$plugin->run();

}
run_gt3_wize_core();
