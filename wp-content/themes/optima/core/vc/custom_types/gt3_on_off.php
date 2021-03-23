<?php

function gt3_on_off_function($settings, $value) {
	$gt3_return = '';
	$default = isset($settings['default']) ? $settings['default'] : 'on';
	
	$gt3_return .= '
	<div class="gt3_radio_selector d_block_middle">
		<div class="gt3_radio_toggle_cont gt3_on_off_style" data-value="'. $value .'">
			<input type="hidden" name="' . esc_attr( $settings['param_name'] ) . '" class="gt3_checkbox_value wpb_vc_param_value" value="'. $value .'">
			<div class="gt3_radio_toggle_mirage checked"></div>
		</div>
	</div>
	';
	return $gt3_return;
	
}