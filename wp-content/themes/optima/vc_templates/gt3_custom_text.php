<?php
	include_once get_template_directory() . '/vc_templates/gt3_google_fonts_render.php';
	$defaults = array(
		'font_size' => '',
		'text_color' => '',
		'use_theme_fonts' => '',
		'line_height' => '140',
		'responsive_font' => '',
		'font_size_sm_desctop' => '',
		'font_size_tablet' => '',
		'font_size_mobile' => '',
		
	);
	$atts = vc_shortcode_attribute_parse($defaults, $atts);
	extract($atts);
	
	$compile = '';
	
	// Render Google Fonts
	$obj = new GoogleFontsRender();
	extract( $obj->getAttributes( $atts, $this, $this->shortcode, array('google_fonts_text') ) );
	
	if ( ! empty( $styles_google_fonts_text ) ) {
		$text_font = '' . esc_attr( $styles_google_fonts_text );
	} else {
		$text_font = '';
	}
	
	// Font Size of Title
	if ($font_size != '') {
		$text_css = 'font-size: ' . (int)$font_size . 'px; line-height: ' . (int)$line_height . '%; ';
	} else {
		$text_css = ' ';
	}
	
	// Animation
	if (! empty($atts['css_animation'])) {
		$animation_class = $this->getCSSAnimation( $atts['css_animation'] );
	} else {
		$animation_class = '';
	}
	
	if (!empty($content)) {
		$compile = '';
		$compile .= '<div data-color="#ffffff" class="gt3_custom_text" style="color:'.esc_attr($text_color).';'.esc_attr($text_font) . esc_attr($text_css).'">';
		if ($responsive_font == 'true') {
			$compile .= !empty($font_size_sm_desctop) ? ' <div class="gt3_custom_text-font_size_sm_desctop" style="font-size:'.(int)$font_size_sm_desctop.'px;line-height: ' . (int)$line_height . '%;">' : '';
			$compile .= !empty($font_size_tablet) ? ' <div class="gt3_custom_text-font_size_tablet" style="font-size:'.(int)$font_size_tablet.'px;line-height: ' . (int)$line_height . '%;">' : '';
			$compile .= !empty($font_size_mobile) ? ' <div class="gt3_custom_text-font_size_mobile" style="font-size:'.(int)$font_size_mobile.'px;line-height: ' . (int)$line_height . '%;">' : '';
		}
		$compile .= do_shortcode($content);
		if ($responsive_font == 'true') {
			$compile .= !empty($font_size_sm_desctop) ? ' </div>' : '';
			$compile .= !empty($font_size_tablet) ? ' </div>' : '';
			$compile .= !empty($font_size_mobile) ? ' </div>' : '';
		}
		$compile .= '</div>';
	} else {
		$compile = '';
	}		
	echo sprintf("%s", $compile);	
	
?>