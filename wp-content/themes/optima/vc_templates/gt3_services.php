<?php
	include_once get_template_directory() . '/vc_templates/gt3_google_fonts_render.php';
	$defaults = array(
		'box_image' => '',
		'title' => '',
		'content_text' => '',
		'rotate_direction' => 'left',
		'index_number' => '',
		'link' => '',
		'module_height' => '275',
		'css_animation' => '',
		'item_el_class' => '',
		'custom_title_size' => '30',
		'use_theme_fonts_box_title' => 'yes',
		'title_color' => '#ffffff',
		'custom_index_number_size' => '72',
		'use_theme_fonts_box_index_number' => 'yes',
		'index_number_color' => 'rgba(255,255,255,0.2)',
		'custom_content_size' => '16',
		'use_theme_fonts_box_content' => 'yes',
		'content_text_color' => '#ffffff',
		'box_hover_bg' => esc_attr(gt3_option("theme-custom-color"))
	);

	$atts = vc_shortcode_attribute_parse($defaults, $atts);
	extract($atts);

	// Render Google Fonts
	$obj = new GoogleFontsRender();
	extract( $obj->getAttributes( $atts, $this, $this->shortcode, array('google_fonts_box_title', 'google_fonts_box_index_number', 'google_fonts_box_content') ) );

	$compile = '';

	$text = $module_height_style = $box_hover_bg_style = $animation_class = $box_image_bg = $title_code = $front_box_styles = '';

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
	}

	// Box Background (Hover State)
	if ($box_hover_bg != '' && $box_hover_bg != gt3_option("theme-custom-color")) {
		$box_hover_bg_style = 'background-color: ' . $box_hover_bg . '; ';
	}

	// Box Image
	$img_id = preg_replace( '/[^\d]/', '', $box_image );
	$featured_image = wp_get_attachment_image_src($img_id, 'single-post-thumbnail');
	if (strlen($featured_image[0]) > 0) {
		$box_image_bg = 'background-image: url(' . esc_url($featured_image[0]) . '); ';
	}

	$front_box_styles = $box_hover_bg_style . $box_image_bg;

	// Module Height
	if ($module_height != '') {
		$module_height = (int)$module_height;
		$module_height_style = 'min-height: ' . $module_height . 'px; ';
	}

	// Custom Content Font
	if ( ! empty( $styles_google_fonts_box_content ) ) {
		$content_custom_font = '' . esc_attr( $styles_google_fonts_box_content ) . '; ';
	} else {
		$content_custom_font = '';
	}

	// Custom Content Text Color
	if ($content_text_color != '' && $content_text_color != '#ffffff') {
		$content_text_color_style = 'color: ' . $content_text_color . '; ';
	} else {
		$content_text_color_style = '';
	}

	// Custom Content font-size
	if ($custom_content_size != '') {
		$custom_content_size = (int)$custom_content_size;
		$custom_content_line = $custom_content_size + 14;
		$custom_content_size_style = 'font-size: ' . $custom_content_size . 'px; line-height: ' . $custom_content_line . 'px; ';
	} else {
		$custom_content_size_style = '';
	}

	// Box styles
	$box_style = $module_height_style . $box_hover_bg_style . $content_custom_font . $content_text_color_style . $custom_content_size_style;

	// Custom Title Font
	if ( ! empty( $styles_google_fonts_box_title ) ) {
		$title_custom_font = '' . esc_attr( $styles_google_fonts_box_title ) . '; ';
	} else {
		$title_custom_font = '';
	}

	// Custom Title Text Color
	if ($title_color != '' && $title_color != '#ffffff') {
		$title_color_style = 'color: ' . $title_color . '; ';
	} else {
		$title_color_style = '';
	}

	// Custom Title font-size
	if ($custom_title_size != '') {
		$custom_title_size = (int)$custom_title_size;
		$custom_title_line = $custom_title_size + 3;
		$custom_title_size_style = 'font-size: ' . $custom_title_size . 'px; line-height: ' . $custom_title_line . 'px; ';
	} else {
		$custom_title_size_style = '';
	}

	// Title styles
	$title_style = $title_custom_font . $title_color_style . $custom_title_size_style;

	// Title
	if (!empty($title)) {
		$title_code = '<div class="gt3_services_box_title" ' . (strlen($title_style) ? 'style="' . esc_attr($title_style) . '"' : '') . '>'.esc_html($title).'</div>';
	}

	// Custom Index Number Font
	if ( ! empty( $styles_google_fonts_box_index_number ) ) {
		$index_number_custom_font = '' . esc_attr( $styles_google_fonts_box_index_number ) . '; ';
	} else {
		$index_number_custom_font = '';
	}

	// Custom Index Number Text Color
	if ($index_number_color != '' && $index_number_color != 'rgba(255,255,255,0.2)') {
		$index_number_color_style = 'color: ' . $index_number_color . '; ';
	} else {
		$index_number_color_style = '';
	}

	// Custom Index Number font-size
	if ($custom_index_number_size != '') {
		$custom_index_number_size = (int)$custom_index_number_size;
		$custom_index_number_line = $custom_index_number_size - 7;
		$custom_index_number_size_style = 'font-size: ' . $custom_index_number_size . 'px; line-height: ' . $custom_index_number_line . 'px; ';
	} else {
		$custom_index_number_size_style = '';
	}

	// Index Number styles
	$index_number_style = $index_number_custom_font . $index_number_color_style . $custom_index_number_size_style;

	// Index Number
	if (!empty($index_number)) {
		$index_number_code = '<div class="index_number" ' . (strlen($index_number_style) ? 'style="' . esc_attr($index_number_style) . '"' : '') . '>'.esc_html($index_number).'</div>';
	}

	// Content
	if (!empty($content_text)) {
		$text = '<div class="text_wrap">'.$content_text.'</div>';
	}

	$compile .= '<div class="gt3_services_box to-'.esc_attr($rotate_direction).' ' . esc_attr($animation_class) . ' ' . esc_attr($item_el_class) . '">
		<div class="gt3_services_img_bg services_box-front" ' . (strlen($front_box_styles) ? 'style="' . esc_attr($front_box_styles) . '"' : '') . '>
			' . $index_number_code . $title_code . '
		</div>
		<div class="gt3_services_box_content services_box-back" ' . (strlen($box_style) ? 'style="' . esc_attr($box_style) . '"' : '') . '>' . $text .'<div class="fake_space"></div></div>
		<a class="gt3_services_box_link" href="'.esc_attr($url).'" '.$title_for_button.' '.$button_target.'>' . esc_html__("View More", "optima") . '</a>
	</div>';
	
	echo (($compile));

?>  
