<?php
	include_once get_template_directory() . '/vc_templates/gt3_google_fonts_render.php';
	$defaults = array(
		'pref_text' => '',
		'text' => '',
		'text_decor' => 'none',
		'font_size' => '',
		'text_color' => '',
		'use_theme_fonts' => '',
		'line_height' => '140',
		'font_weight' => '600',
		'responsive_font' => '',
		'font_size_sm_desctop' => '',
		'font_size_tablet' => '',
		'font_size_mobile' => '',

	);
	$atts = vc_shortcode_attribute_parse($defaults, $atts);
	extract($atts);
	$compile = '';
	wp_enqueue_script('gt3_typed_js', get_template_directory_uri() . '/js/jquery.typed.min.js', array(), false, false);
	// Render Google Fonts
	$obj = new GoogleFontsRender();
	extract( $obj->getAttributes( $atts, $this, $this->shortcode, array('google_fonts_text') ) );

	if ( ! empty( $styles_google_fonts_text ) ) {
		$text_font = '' . esc_attr( $styles_google_fonts_text );
	} else {
		$text_font = '';
	}
	// // Font Size of Title
	if ($font_size != '') {
		$text_css = ' font-size: ' . (int)$font_size . 'px; line-height: ' . (int)$line_height . '%; font-weight: '.$font_weight.';';
	} else {
		$text_css = ' ';
	}

	$values = (array) vc_param_group_parse_atts( $values );
	$proc_data = array();
	foreach ( $values as $data ) {
		$new_proc = $data;
		$new_proc['text'] = isset( $data['text'] ) ? $data['text'] : '';
		$proc_data[] = $new_proc;
	}
	$count = count($proc_data);

	$compile .= '<div data-color="#ffffff" class="gt3_custom_text gt3_typed" style="color:'.esc_attr($text_color).';'.esc_attr($text_font) . esc_attr($text_css).'">';
	if ($responsive_font == 'true') {
		$compile .= !empty($font_size_sm_desctop) ? ' <div class="gt3_custom_text-font_size_sm_desctop" style="font-size:'.(int)$font_size_sm_desctop.'px;line-height: ' . (int)$line_height . '%;">' : '';
		$compile .= !empty($font_size_tablet) ? ' <div class="gt3_custom_text-font_size_tablet" style="font-size:'.(int)$font_size_tablet.'px;line-height: ' . (int)$line_height . '%;">' : '';
		$compile .= !empty($font_size_mobile) ? ' <div class="gt3_custom_text-font_size_mobile" style="font-size:'.(int)$font_size_mobile.'px;line-height: ' . (int)$line_height . '%;">' : '';
	}
	$compile .= '<span class="pref_text">'.(esc_html($pref_text)).' </span>';
	$compile .= '<span class="gt3_typed_text" '.($text_decor !== 'none' ? ' style="text-decoration: '.$text_decor.';"' : '').'';
		for($x=0;$x<$count;$x++){
			if (!empty($proc_data[$x]['text'])) {
				$compile .= ' data-text-'.$x.'="'.$proc_data[$x]['text'].'"';
			}
		}
		$compile .= ' data-count="'.$count.'"';
	$compile .= '></span>';
	if ($responsive_font == 'true') {
		$compile .= !empty($font_size_sm_desctop) ? ' </div>' : '';
		$compile .= !empty($font_size_tablet) ? ' </div>' : '';
		$compile .= !empty($font_size_mobile) ? ' </div>' : '';
	}
	$compile .= '</div>';
	
	echo sprintf("%s", $compile);

?>  
