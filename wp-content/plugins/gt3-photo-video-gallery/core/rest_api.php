<?php

namespace GT3\Gallery\PhotoVideo;

defined('ABSPATH') OR exit;

use WP_REST_Server;
use WP_REST_Request;
use GT3\PhotoVideoGallery\Settings;


class Rest {
	private static $instance = null;

	public static function instance(){
		if(!self::$instance instanceof self) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct(){
		add_action('rest_api_init', array( $this, 'rest_api_init' ));
	}

	function rest_api_init(){
		if(!\is_user_logged_in()) {
//			return;
		}

		$namespace = 'gt3/v1/';

		register_rest_route($namespace,
			'admin-save-settings',
			array(
				array(
					'methods'  => WP_REST_Server::CREATABLE,
					'callback' => array( $this, 'save_settings' ),
				)
			)
		);
		register_rest_route($namespace,
			'admin-reset-settings',
			array(
				array(
					'methods'  => WP_REST_Server::READABLE,
					'callback' => array( $this, 'reset_settings' ),
				)
			)
		);
		register_rest_route($namespace,
			'admin-settings-get-page',
			array(
				array(
					'methods'  => WP_REST_Server::CREATABLE,
					'callback' => array( $this, 'get_page' ),
				)
			)
		);
	}

	function save_settings(WP_REST_Request $request){
		if(current_user_can('manage_options')) {
			$new_options = $request->get_json_params();
			if(is_object($new_options)) {
				$new_options = get_object_vars($new_options);
			}
			if(!is_array($new_options)) {
				$new_options = array();
			}

			Settings::instance()->setSettings($new_options);

			return rest_ensure_response(array(
				'saved' => true,
			));
		} else {
			return rest_ensure_response(array(
				'saved' => false,
			));
		}
	}

	function reset_settings(WP_REST_Request $request){
		if(current_user_can('manage_options')) {
			Settings::instance()->resetSettings();

			return rest_ensure_response(array(
				'saved' => true,
			));
		} else {
			return rest_ensure_response(array(
				'saved' => false,
			));
		}
	}

	function get_page(WP_REST_Request $request){
		$respond = array();
		$pages    = $request->get_json_params();
		foreach($pages as $page ) {
			if(in_array($page, array(
				'started',
				'foundation',
				'components',
				'plugins',
				'premium_themes',
			))) {
				$page_path = __DIR__.'/pages/'.$page.'.php';
				if(file_exists($page_path) && is_readable($page_path)) {
					ob_start();
					require_once $page_path;
					$respond[$page] = ob_get_clean();
				} else {
					$respond[$page] = 'File not found';
				}
			} else {
				$respond[$page] = 'Page not found';
			}
		}

		return rest_ensure_response($respond);
	}
}

Rest::instance();

