<?php
	include_once get_template_directory() . '/vc_templates/gt3_google_fonts_render.php';
	
	$theme_color = esc_attr(gt3_option("theme-custom-color"));
	
	$defaults = array(
		'button_title' => 'Text on the button',
		'link' => '',
		'button_size' => 'normal',
		'button_alignment' => 'inline',
		'css_animation' => '',
		'item_el_class' => '',
		'btn_bg_color' => $theme_color,
		'btn_text_color' => '#ffffff',
		'css' => '',
		'btn_border_style' => 'solid',
		'btn_border_width' => '1px',
		'btn_border_radius' => '30px',
		'btn_border_color' => $theme_color,
		'btn_font_size' => '',
		'btn_icon_type' => 'none',
		'btn_icon_fontawesome' => 'fa fa-adjust',
		'btn_image' => '',
		'btn_img_width' => '',
		'icon_font_size' => '',
		'btn_icon_color' => '#ffffff',
		'btn_icon_position' => 'left',
		'btn_bg_color_hover' => '#ffffff',
		'btn_text_color_hover' => $theme_color,
		'btn_border_color_hover' => $theme_color,
		'btn_icon_color_hover' => '#ffffff',
		'use_theme_button' => 'yes'
	);
	
	$atts = vc_shortcode_attribute_parse($defaults, $atts);
	extract($atts);
	
	$compile = '';
	
	$class_to_filter = vc_shortcode_custom_css_class( $css, ' ' );
	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );
	
	// Render Google Fonts
	$obj = new GoogleFontsRender();
	$shortc = $this->shortcode;
	extract( $obj->getAttributes( $atts, $this, $shortc, array('google_fonts_button') ) );
	
	if ( ! empty( $styles_google_fonts_button ) ) {
		$button_value_font = '' . esc_attr( $styles_google_fonts_button ) . '; ';
	} else {
		$button_value_font = '';
	}
	
	$btn_bg_color_style = $btn_text_color_style = $btn_border_width_style = $btn_border_style_style = $btn_border_radius_style = $btn_border_color_style = '';
	
	if ($use_theme_button !== 'yes') {
		
		// Button bg
		if ($btn_bg_color != '' && $btn_bg_color != $theme_color) {
			$btn_bg_color_style = 'background-color: ' . $btn_bg_color . '; ';
		} else {
			$btn_bg_color_style = '';
		}
		
		// Button color
		if ($btn_text_color != '' && $btn_text_color != '#ffffff') {
			$btn_text_color_style = 'color: ' . $btn_text_color . '; ';
		} else {
			$btn_text_color_style = '';
		}
		if ($btn_border_style != 'none') {
			if ($btn_border_color != '' && $btn_border_color != $theme_color) {
				$btn_border_color_style = 'border-color: ' . $btn_border_color . '; ';
			}
		}
	}
	
	// Button border
	$btn_border_radius_style = 'border-radius: ' . $btn_border_radius . '; ';
	if ($btn_border_style != 'none') {
		$btn_border_style_style = 'border-style: ' . $btn_border_style . '; ';
		$btn_border_width_style = 'border-width: ' . $btn_border_width . '; ';
	} else {
		$btn_border_width_style = 'border: none; ';
	}
	
	// Button font-size
	if ($btn_font_size != '') {
		$btn_font_size = (int)$btn_font_size;
		$btn_font_line = $btn_font_size + 8;
		$btn_font_size_style = 'font-size: ' . $btn_font_size . 'px; line-height: ' . $btn_font_line . 'px; ';
	} else {
		$btn_font_size_style = '';
	}
	
	// Button styles
	$btn_style = $btn_bg_color_style . $btn_text_color_style . $btn_border_width_style . $btn_border_style_style . $btn_border_radius_style . $btn_border_color_style . $btn_font_size_style . $button_value_font;
	
	// Link Settings
	$link_temp = vc_build_link($link);
	$url = $link_temp['url'];
	$btn_title = $link_temp['title'];
	$target = $link_temp['target'];
	if($url !== '') {
		$url = $url;
	} else {
		$url = '#';
	}
	if($btn_title !== '') {
		$title_for_button = 'title="' . $btn_title . '"' ;
	} else {
		$title_for_button = '';
	}
	if($target !== '') {
		$button_target = 'target="' . $target . '"' ;
	} else {
		$button_target = '';
	}
	
	// Animation
	if (! empty($atts['css_animation'])) {
		$animation_class = $this->getCSSAnimation( $atts['css_animation'] );
	} else {
		$animation_class = '';
	}
	
	// Button Icon
	if ($btn_icon_type == 'font') {
		// Enqueue needed icon font.
		vc_icon_element_fonts_enqueue( 'fontawesome' );
	} else {
		$img_id = preg_replace( '/[^\d]/', '', $btn_image );
		$featured_image = wp_get_attachment_image_src($img_id, 'single-post-thumbnail');
		if (strlen($featured_image[0]) > 0) {
			$featured_image_url = $featured_image[0];
		} else {
			$featured_image_url = "";
		}
	}
	
	// Button Icon Style
	$btn_icon_color_style = '';
	if ($use_theme_button !== 'yes') {
		if ($btn_icon_color != '' && $btn_icon_color != '#ffffff') {
			$btn_icon_color_style = 'color: ' . $btn_icon_color . '; ';
		} else {
			$btn_icon_color_style = '';
		}
	}
	
	if ($icon_font_size != '') {
		$icon_font_size = (int)$icon_font_size;
		$icon_font_line = $icon_font_size + 2;
		$icon_font_css = 'font-size: ' . $icon_font_size . 'px; line-height: ' . $icon_font_line . 'px; ';
	} else {
		$icon_font_css = '';
	}
	$btn_icon_style = $btn_icon_color_style . $icon_font_css;
	
	// Icon block
	$btn_icon_content = '';
	if ($btn_icon_type == 'image') {
		if (strlen($featured_image_url))
		if ($btn_img_width != '') {
			$btn_icon_content .= '<div class="btn_icon_container"><img src="' . aq_resize($featured_image_url, $btn_img_width*2, '', true, true, true) . '" alt="icon" style="width:' . esc_attr($btn_img_width) . 'px;" /></div>';
		} else {
			$btn_icon_content .= '<div class="btn_icon_container"><img src="' . $featured_image_url . '" alt="icon" /></div>';
		}
	} else if ($btn_icon_type == 'font') {
		
		// Button Icon Default
		$btn_icon_default_attr = '';
		if ($use_theme_button !== 'yes') {
			if ($btn_icon_color != '' && $btn_icon_color != '#ffffff') {
				$btn_icon_default_attr = 'data-default-icon="'.esc_attr($btn_icon_color).'" ';
			} else {
				$btn_icon_default_attr = '';
			}
		}
		
		// Button Icon Hover
		if ($btn_icon_color_hover != '' && $btn_icon_color_hover != '#ffffff') {
			$btn_icon_hover_attr = 'data-hover-icon="'.esc_attr($btn_icon_color_hover).'" ';
		} else {
			$btn_icon_hover_attr = '';
		}
		
		// Button Icon Attributes
		$btn_icon_attr = $btn_icon_default_attr . $btn_icon_hover_attr;
		$btn_icon_content .= '<div class="btn_icon_container"><span class="gt3_btn_icon ' . esc_attr($btn_icon_fontawesome) . '" ' . (strlen($btn_icon_style) ? 'style="' . esc_attr($btn_icon_style) . '"' : '') . ' ' . $btn_icon_attr . '></span></div>';
	}
	
	// Button Value
	$btn_text = '' . (strlen($button_title) ? '<span class="gt3_btn_text">' . esc_attr($button_title) . '</span>' : '') . '';
	
	$btn_icon_position_class = '';
	$btn_value = $btn_text;
	if ($btn_icon_type == 'image' || $btn_icon_type == 'font') {
		if ($btn_icon_position == 'left') {
			$btn_value = $btn_icon_content . $btn_text;
		} else {
			$btn_value = $btn_text . $btn_icon_content;
		}
		if ($btn_text != '') {
			$btn_icon_position_class = 'btn_icon_position_' . $btn_icon_position . '';
		}
	}
	
	$btn_bg_default_attr = $btn_color_default_attr = $btn_border_default_attr = $btn_bg_hover_attr = $btn_color_hover_attr = $btn_border_hover_attr = '';
	
	// Button Attributes
	if ($use_theme_button !== 'yes') {
		
		// Button Default
		if ($btn_bg_color != '' && $btn_bg_color != $theme_color) {
			$btn_bg_default_attr = 'data-default-bg="'.esc_attr($btn_bg_color).'" ';
		} else {
			$btn_bg_default_attr = '';
		}
		
		if ($btn_text_color != '' && $btn_text_color != '#ffffff') {
			$btn_color_default_attr = 'data-default-color="'.esc_attr($btn_text_color).'" ';
		} else {
			$btn_color_default_attr = '';
		}
		
		if ($btn_border_color != '' && $btn_border_color != $theme_color) {
			$btn_border_default_attr = 'data-default-border="'.esc_attr($btn_border_color).'" ';
		} else {
			$btn_border_default_attr = '';
		}
		
		// Button Hover
		if ($btn_bg_color_hover != '' && $btn_bg_color_hover != '#ffffff') {
			$btn_bg_hover_attr = 'data-hover-bg="'.esc_attr($btn_bg_color_hover).'" ';
		} else {
			$btn_bg_hover_attr = '';
		}
		
		if ($btn_text_color_hover != '' && $btn_text_color_hover != $theme_color) {
			$btn_color_hover_attr = 'data-hover-color="'.esc_attr($btn_text_color_hover).'" ';
		} else {
			$btn_color_hover_attr = '';
		}
		
		if ($btn_border_color_hover != '' && $btn_border_color_hover != $theme_color) {
			$btn_border_hover_attr = 'data-hover-border="'.esc_attr($btn_border_color_hover).'" ';
		} else {
			$btn_border_hover_attr = '';
		}
	}
	$btn_attr = $btn_bg_default_attr . $btn_color_default_attr . $btn_border_default_attr . $btn_bg_hover_attr . $btn_color_hover_attr . $btn_border_hover_attr;
	
	$btn_custom_class = '';
	if ($use_theme_button !== 'yes') {
		$btn_custom_class = 'gt3_btn_customize';
	}
	
	$compile .= '<div class="gt3_module_button ' . $btn_custom_class . ' button_alignment_' . esc_attr($button_alignment) . ' ' . esc_attr($animation_class) . ' ' . esc_attr($item_el_class) . '">';
	
	$compile .= '<a class="button_size_'. esc_attr($button_size) .' ' . esc_attr($btn_icon_position_class) . ' ' . esc_attr($css_class) . '" href="'.esc_attr($url).'" '.$title_for_button.' '.$button_target.' ' . (strlen($btn_style) ? 'style="' . esc_attr($btn_style) . '"' : '') . ' ' . $btn_attr . '>' . $btn_value . '</a>';
	
	$compile .= '</div>';
	
	echo sprintf("%s", $compile);
?>