<?php

	$defaults = array(
		'tstm_author' => '',
		'author_status' => '',
		'image' => '',
		'img_width' => '85',
		'img_height' => '85',
		'round_imgs' => true,
		'item_el_class' => '',
		'css' => ''
	);
	
	$atts = vc_shortcode_attribute_parse($defaults, $atts);
	extract($atts);
	$compile = '';
	extract($_POST['gt3_testimonials_opts']);
	
	$class_to_filter = vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $item_el_class );
	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );
	
	$img_id = preg_replace( '/[^\d]/', '', $image );
	$featured_image = wp_get_attachment_image_src($img_id, 'single-post-thumbnail');
	if (strlen($featured_image[0]) > 0) {
	  $featured_image_url = $featured_image[0];
	} else {
	  $featured_image_url = "";
	}
	
	$text_size_html = $text_color_html = $text_style_html = $sign_color_html = $title_color_html = '';
	if ($text_color != '') {
		$text_color_html = ' color: '.$text_color.';';
	}
	if ($testimonilas_text_size != '') {
		$text_size_html = ' font-size: '.$testimonilas_text_size.'px;';
		$text_size_html .= ' line-height: 1.5;';
	}
	
	if (($text_color_html != '') || ($testimonilas_text_size != '') ) {
		$text_style_html = ' style= "'.esc_attr($text_color_html).esc_attr($text_size_html).'"';
	}
	
	if ($sign_color != '') {
		$sign_color_html = ' color: '.$sign_color.';';
	}
	
	$testimonilas_author_size = !empty($testimonilas_author_size) ? ' font-size: '.$testimonilas_author_size.'px;' : '';
	
	$star_rate = '';
	if ( !empty($select_rate) && $select_rate != "none" ) {
		$star_rate = '<p class="testimonials-rate-wrap">';
		for ($i = 1; $i <= $select_rate; $i++) {
			$star_rate .= '<i class="fa fa-star"></i>';
		}
		for ($i; $i <= 5; $i++) {
			$star_rate .= '<i class="fa fa-star grey"></i>';
		}
		$star_rate .= '</p>';
	}
	$round_imgs = $round_imgs ? 'class=testimonials_round_img ' : '';
	
	$sign_styles = !empty($sign_color) || !empty($testimonilas_author_size) ? ' style="' . esc_attr($sign_color_html) . esc_attr($testimonilas_author_size) . '"' : '';
	$compile .= '
		<div class="testimonials_item">
			<div class="testimonial_item_wrapper">
				<div class="testimonials_content">
					<div class="testimonials-text" ' . $text_style_html . '>' . " " . $content . $star_rate .'</div>
					<div class="testimonials_photo"><img '.esc_attr($round_imgs).' src="' . aq_resize($featured_image_url, $img_width*2, $img_height*2, true, true, true) . '" alt="' . esc_html($tstm_author) . '" style="width:' . esc_attr($img_width) . 'px; height:' . esc_attr($img_height) . 'px;" /></div>
					<div class="testimonials_title_wrap">
						<div class="testimonials_title"' . $sign_styles . '>' . esc_html($tstm_author) . '
							<span class="author_status">' . esc_html($author_status) . '</span>
						</div>
						<div class="icon_wrap"><span></span><span></span><span></span></div>
					</div>
				</div>
			</div>
		</div>';
	
	echo sprintf("%s", $compile);		
?>