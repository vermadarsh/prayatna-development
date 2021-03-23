<?php
	include_once get_template_directory() . '/vc_templates/gt3_google_fonts_render.php';
	$defaults = array(
		'icon_type' => 'font',
		'text_align' => 'center',
		'icon_fontawesome' => 'fa fa-adjust',
		'image' => '',
		'img_width' => '60',
		'icon_position' => 'left',
		'image_proportions' => 'original',
		'counter_title' => '',
		'counter_value' => '2001',
		'counter_prefix' => '',
		'counter_suffix' => '',
		'display_inline' => false,
		'item_el_class' => '',
		'css' => '',
		'icon_color' => '#27323d',
		'icon_size' => 'normal',
		'counter_title_size' => '16',
		'counter_value_size' => '48',
		'title_color' => '#848d95',
		'counter_value_color' => '#27323d',
		'css_animation' => ''
	);

	$atts = vc_shortcode_attribute_parse($defaults, $atts);
	extract($atts);

	$compile = '';

	//wp_enqueue_script( 'waypoints' );
	wp_enqueue_script('gt3_waypoint_js', get_template_directory_uri() . '/js/jquery.waypoints.min.js', array(), false, true);

	$class_to_filter = vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $item_el_class );
	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

	// Counter Title and Value Google Fonts

	// Render Google Fonts
	$obj = new GoogleFontsRender();
	$shortc = $this->shortcode;
	extract( $obj->getAttributes( $atts, $this, $shortc, array('google_fonts_counter_title', 'google_fonts_counter_value') ) );

	if ( ! empty( $styles_google_fonts_counter_value ) ) {
		$counter_value_font = '' . esc_attr( $styles_google_fonts_counter_value ) . ';';
	} else {
		$counter_value_font = '';
	}

	if ( ! empty( $styles_google_fonts_counter_title ) ) {
		$counter_title_font = '' . esc_attr( $styles_google_fonts_counter_title ) . ';';
	} else {
		$counter_title_font = '';
	}

	if ($icon_type == 'font') {
		// Enqueue needed icon font.
		vc_icon_element_fonts_enqueue( 'fontawesome' );
	} else {
		$img_id = preg_replace( '/[^\d]/', '', $image );
		$featured_image = wp_get_attachment_image_src($img_id, 'single-post-thumbnail');
		if (strlen($featured_image[0]) > 0) {
		  $featured_image_url = $featured_image[0];
		} else {
		  $featured_image_url = "";
		}
	}

	// Icon block
	$imageblock_content = '';
	if ($icon_type == 'image') {
		if (strlen($featured_image_url))
			$img_height = '';
			if ($img_width != '') {
				if ($image_proportions == 'original') {
					$img_height = '';
				} else {
					$img_height = $img_width*2;
				}
				$imageblock_content .= '<div class="icon_container icon_proportions_' . esc_attr($image_proportions) . '"><img src="' . aq_resize($featured_image_url, $img_width*2, $img_height, true, true, true) . '" alt="img" style="width:' . esc_attr($img_width) . 'px;" /></div>';
			} else {
				$imageblock_content .= '<div class="icon_container"><img src="' . esc_url($featured_image_url) . '" alt="img" /></div>';
			}
	} else if ($icon_type == 'font') {
		$imageblock_content .= '<div class="icon_container"><span class="gt3_counter_icon counter_icon_size_' . esc_attr($icon_size) . ' ' . esc_attr($icon_fontawesome) . '" style="color:' . esc_attr( $icon_color ) . '"></span></div>';
	}

	// Counter Value
	if ($counter_value_color != '') {
		$counter_value_color_style = 'color: ' . esc_attr($counter_value_color) . '; ';
	} else {
		$counter_value_color_style = ' ';
	}
	if ($counter_value_size != '') {
		$counter_value_line = $counter_value_size - 4;
		$counter_value_css = 'font-size: ' . esc_attr($counter_value_size) . 'px; line-height: ' . esc_attr($counter_value_line) . 'px; ';
	} else {
		$counter_value_css = ' ';
	}

	// Counter Title
	if ($title_color != '') {
		$title_color_style = 'color: ' . esc_attr($title_color) . '; ';
	} else {
		$title_color_style = ' ';
	}
	if ($counter_title_size != '') {
		$counter_title_line = $counter_title_size + 6;
		$counter_title_css = 'font-size: ' . esc_attr($counter_title_size) . 'px; line-height: ' . esc_attr($counter_title_line) . 'px; ';
	} else {
		$counter_title_css = ' ';
	}

	// Animation
	if (! empty($atts['css_animation'])) {
		$animation_class = $this->getCSSAnimation( $atts['css_animation'] );
	} else {
		$animation_class = '';
	}

	$compile .= '<div class="gt3_module_counter '.$animation_class.' ' . (strlen($icon_position) ? 'icon-position-' . esc_attr($icon_position) . ' ' : ''). 'counter_icon_type_' . esc_attr($icon_type) . ' ' . esc_attr($css_class) . '" ' . ((bool)$display_inline ? 'style="display:inline-block;"' : '') . '>';
	if ($icon_position !== 'bottom') {
		$compile .= $imageblock_content;
	}
	
	if ($icon_type == 'none') {
		$align_style = 'style="text-align: ' . esc_html($text_align) . '"';
	} else {
		$align_style = '';
	}

	$compile .= '<div class="stat_count_wrapper" ' . $align_style . '>';
		if($counter_value !== '') {
			$compile .= '<div class="stat_count" data-suffix="' . esc_html($counter_suffix) . '" data-prefix="' . esc_html($counter_prefix) . '" data-value="' . esc_html($counter_value) . '" style="' . $counter_value_color_style . $counter_value_font . $counter_value_css .'">' . esc_html($counter_prefix) . esc_html($counter_value) . esc_html($counter_suffix) . '</div>';
		}
		if($counter_title !== '') {
			$compile .= '<div class="cont_info" style="' . $title_color_style . $counter_title_font . $counter_title_css .'">' . $counter_title . '</div>';
		}
		$compile .= '<div class="stat_temp"></div></div>';

		if ($icon_position == 'bottom') {
			$compile .= $imageblock_content;
		}
	$compile .= '<div class="clear"></div></div>';
	
	echo sprintf("%s", $compile);

?>
    
