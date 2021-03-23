<?php

/**
 * Fired during plugin activation
 *
 * @link       https://themeforest.net/user/gt3themes
 * @since      1.0.0
 *
 * @package    Gt3_wize_core
 * @subpackage Gt3_wize_core/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Gt3_wize_core
 * @subpackage Gt3_wize_core/includes
 * @author     GT3themes <GT3themes@gmail.com>
 */
class Gt3_wize_core_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		GT3PostTypesRegister::getInstance()->register();
		flush_rewrite_rules();
	}

}
