<?php
	include_once get_template_directory() . '/vc_templates/gt3_google_fonts_render.php';
	$defaults = array(
		'title' => '',
		'icon_type' => 'none',
		'proc_icon' => '',
		'proc_thumb' => '',
		'proc_number' => '',
		'proc_heading' => '',
		'proc_descr' => '',
		'per_line' => '3',
		'icon_size' => 'regular',
		'icon_color' => esc_attr(gt3_option("theme-custom-color")),
		'number_color' => esc_attr(gt3_option("theme-custom-color")),
		'title_size' => '24',
		'title_weight' => '300',
	);
	
	$atts = vc_shortcode_attribute_parse($defaults, $atts);
	extract($atts);
	$output = $classes = '';
	$column = 12/(int)$per_line;
	
	$values = (array) vc_param_group_parse_atts( $values );
	$proc_data = array();
	foreach ( $values as $data ) {
		$new_proc = $data;
		$new_proc['icon_type'] = isset( $data['icon_type'] ) ? $data['icon_type'] : 'none';
		$new_proc['proc_number'] = isset( $data['proc_number'] ) ? $data['proc_number'] : '';
		$new_proc['proc_heading'] = isset( $data['proc_heading'] ) ? $data['proc_heading'] : '';
		$new_proc['proc_descr'] = isset( $data['proc_descr'] ) ? $data['proc_descr'] : '';
		$new_proc['proc_icon'] = $new_proc['icon_type'] == 'font' && !empty($data['proc_icon']) ? $data['proc_icon'] : '';
		$new_proc['proc_thumb'] = $new_proc['icon_type'] == 'image' && !empty($data['proc_thumb']) ? $data['proc_thumb'] : '';
		$proc_data[] = $new_proc;
	}
	$classes .= ' icon_size_'.$icon_size;
	$heading_size = !empty($title_size) ? 'font-size:'.$title_size.'px;' : '';
	$heading_weight = !empty($title_weight) ? 'font-weight:'.$title_weight.';' : '';
	$heading_style = !empty($heading_size) || !empty($heading_weight) ? ' style="'.$heading_size.$heading_weight.'"' : '';
	$output .= '<div class="gt3_processes">';
	foreach ( $proc_data as $proc ) {
		if ($proc['icon_type'] == 'font' && !empty($proc['proc_icon'])) {
			wp_enqueue_style("font_awesome", get_template_directory_uri() . '/css/font-awesome.min.css');
			$icon = '<i class="process_icon '.esc_attr($proc['proc_icon']).'" style="color:'.esc_attr($icon_color).';"></i>';
		} else if ($proc['icon_type'] == 'image' && !empty($proc['proc_thumb'])) {
			$thumbnail = wp_get_attachment_image( $proc['proc_thumb'] , 'full');
			$icon = '<i class="process_icon">'.$thumbnail.'</i>';
		} else if ($proc['icon_type'] == 'none') {
			$icon = '';
		}
		$output .= '<div class="process_item span'.esc_attr($column).$classes.($proc['icon_type'] == 'none' ? ' no_icon' : '').'">';
			$output .= '<div class="process_media">';
				$output .= $icon;
				$output .= !empty($proc['proc_number']) ? '<span class="process_num" style="background:'.esc_attr($number_color).';">'.$proc['proc_number'].'</span>' : '';
			$output .= '</div>';
			$output .= !empty($proc['proc_heading']) ? '<h3 class="process_heading" '.$heading_style.'>'.$proc['proc_heading'].'</h3>' : '';
			$output .= !empty($proc['proc_descr']) ? '<div class="process_descr">'.$proc['proc_descr'].'</div>' : '';
		$output .= '</div>';
	}
	$output .= '</div>';
	echo sprintf("%s", $output);
?>