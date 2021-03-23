<?php

namespace GT3\PhotoVideoGallery\Block;
defined('ABSPATH') OR exit;

use GT3\PhotoVideoGallery\Settings;
use WP_REST_Server;
use WP_REST_Request;

abstract class Basic {
	use Traits\Get_Attachment_Image_Trait;
	use Traits\Lightbox_Trait;
	use Traits\Attributes_Trait;
	use Traits\Inline_Style_Trait;
	use Traits\Default_Attributes_Trait;
	use Traits\Clear_Attributes_Trait;

	protected $enqueue_scripts = array();
	protected $enqueue_styles = array();
	protected $_id = array();
	protected $WRAP = '';
	protected $wrapper_classes = array();
	protected static $index = 0;

	protected $render_index = 1;
	protected $slug = 'gt3pg-pro/basic';
	protected $name = 'basic';

	protected $is_rest = false;
	protected $is_editor = false;
	protected $is_elementor_editor = false;

	protected static $instance = null;

	public static function instance(){
		if(!static::$instance instanceof static) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	protected function getPrepareAttributes(){
		return array();
	}


	protected function __construct(){
		$this->default_attributes = $this->getDefaultsAttributes();
		$this->name               = substr($this->slug, strpos($this->slug, '/')+1);

		add_action('init', array( $this, 'initHandler' ));

		$this->construct();
	}

	function rest_api_init(){
		$namespace = 'gt3/v1/block-renderer';

		register_rest_route($namespace,
			'/'.$this->slug,
			array(
				array(
					'methods'  => WP_REST_Server::CREATABLE,
					'callback' => array( $this, 'restHandler' ),
				),
			)
		);
	}

	public function restHandler(WP_REST_Request $Request){
		$data = array(
			'rendered' => $this->render_block($Request->get_params()),
		);

		return rest_ensure_response($data);
	}


	public function initHandler(){
		if(function_exists('register_block_type')) {
			register_block_type($this->slug, array(
				'attributes'      => $this->default_attributes,
				'render_callback' => array( $this, 'render_block' ),
			));

			if(is_user_logged_in() && current_user_can('edit_posts')) {
				add_action('rest_api_init', array( $this, 'rest_api_init' ));
			}
		}
	}

	protected function construct(){
		$this->add_script_depends('imageloaded');
		$this->add_script_depends('isotope');
		$this->add_script_depends('youtube_api');
		$this->add_script_depends('vimeo_api');
	}

	function the_content($content){
		return $this->get_styles().$content;
	}

	protected function serializeImages(&$settings){
		$settings['ids'] = is_array($settings['ids']) ? $settings['ids'] :
			(!empty($settings['ids']) ? explode(',', $settings['ids']) : array());
	}


	protected function add_script_depends($slug){
		if(is_array($slug) && count($slug)) {
			foreach($slug as $script) {
				$this->enqueue_scripts[] = $script;
			}
		} else {
			$this->enqueue_scripts[] = $slug;
		}
	}

	protected function add_style_depends($slug){
		if(is_array($slug) && count($slug)) {
			foreach($slug as $styles) {
				$this->enqueue_styles[] = $styles;
			}
		} else {
			$this->enqueue_styles[] = $slug;
		}
	}

	protected function enqueue_scripts(){
		if(is_array($this->enqueue_scripts) && count($this->enqueue_scripts)) {
			foreach($this->enqueue_scripts as $script) {
				wp_enqueue_script($script);
			}
		}
	}

	public function render_block($settings){

		self::$index++;
		$this->render_index       = 1;
		$this->responsive_style   = array();
		$this->wrapper_classes    = array();
		$this->_render_attributes = array();
		$this->style              = array();

		$this->is_rest             = defined('REST_REQUEST');
		$this->is_elementor_editor = class_exists('\Elementor\Plugin') && \Elementor\Plugin::$instance->editor->is_edit_mode();
		$this->is_editor           = $this->is_rest || $this->is_elementor_editor;

		$this->enqueue_scripts();

		$default_settings = Settings::instance()->getSettings();
		if($settings instanceof WP_REST_Request) {
			$settings = $settings->get_params();
		}

		$settings = array_merge($this->getDefaults(), $settings);
		$settings = $this->deprecatedSettings($settings);
		$settings = $this->removeDefaultsSettings($settings);

		if(!key_exists('_blockName', $settings) || empty($settings['_blockName'])) {
			$settings['_blockName'] = $this->name;
		}

		$default_settings = array_merge(
			$default_settings['basic'],
			key_exists($settings['_blockName'], $default_settings) ? $default_settings[$settings['_blockName']] : array()
		);

		$settings = array_merge(
			$default_settings,
			$settings
		);
		$settings = $this->checkTypeSettings($settings);

		$this->_id       = 'uid-'.substr(md5(mt_rand(100, 9999)), 0, 16);
		$this->WRAP      = esc_html('.'.$this->_id.' ');
		$wrapper_classes = array(
			$this->_id,
			'gt3pg-lite--wrapper',
			'gt3pg-lite--'.(str_replace('_', '-', $settings['_blockName'])),
			$settings['className'],
		);

		$this->add_render_attribute('_wrapper', 'id', $this->_id);
		$this->add_render_attribute('_wrapper', 'data-gt3pg-block', $settings['_blockName']);
		$this->add_render_attribute('_wrapper', 'data-index', self::$index);

		$settings['blockAlignment'] = isset($settings['align']) && !empty($settings['align']) ? $settings['align'] : $settings['blockAlignment'];
		if(!empty($settings['blockAlignment'])) {
			$this->add_render_attribute('_wrapper', 'data-align', $settings['blockAlignment']);
		}

		if(!empty($settings['blockAnimation']) && is_array($settings['blockAnimation']) && key_exists('type', $settings['blockAnimation']) && !empty($settings['blockAnimation']['type'])) {
			$wrapper_classes[] = 'animated';
			$this->add_render_attribute('_wrapper', 'data-animation', $settings['blockAnimation']['type']);

			if(key_exists('infinite', $settings['blockAnimation']) && (bool) $settings['blockAnimation']['infinite']) {
				$wrapper_classes[] = 'infinite';
			}
			if(key_exists('speed', $settings['blockAnimation']) && $settings['blockAnimation']['speed'] !== 'normal') {
				$wrapper_classes[] = $settings['blockAnimation']['speed'];
			}
			if(key_exists('delay', $settings['blockAnimation']) && $settings['blockAnimation']['delay'] > 0) {
				$wrapper_classes[] = sprintf('delay-%ss', (int) $settings['blockAnimation']['delay']);
			}
		}

		$settings['uid']          = $this->_id;
		$settings['WRAP']         = $this->WRAP;
		$settings['filter_array'] = array();

		$this->serializeImages($settings);

		if(!is_array($settings['ids'])) {
			$settings['ids'] = array();
		}

		ob_start();
		$this->render($settings);
		$content = ob_get_clean();

		$styles = '';
		if($this->style_print) {
			$styles = $this->get_styles();
		}

		$wrapper_classes = array_merge($wrapper_classes, $this->wrapper_classes);

		$this->add_render_attribute('_wrapper', 'class', $wrapper_classes);

		return $styles.'<div '.$this->get_render_attribute_string('_wrapper').'>'.$content.'</div>';
	}

	protected function render($settings){
	}

	protected function _renderItem(){
		$this->render_index++;
	}

	protected function checkImagesNoEmpty($settings){
		if($this->is_editor && !count($settings['ids'])) {
			echo esc_html__('Select Images in Editor', 'gt3pg');
		}
	}
}
