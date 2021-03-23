<?php
	$defaults = array(
		'icon_type' => 'font',
		'countdown_year' => '2017',
		'countdown_month' => '8',
		'countdown_day' => '14',
		'countdown_hours' => '12',
		'countdown_min' => '00',
	);
	
	wp_enqueue_script('gt3_coundown', get_template_directory_uri() . '/js/jquery.countdown.min.js', array(), false, false);
	
	$atts = vc_shortcode_attribute_parse($defaults, $atts);
	extract($atts);
	
	$label_years = esc_html__('Years', 'optima');
	$label_months = esc_html__('Months', 'optima');
	$label_weeks = esc_html__('Weeks', 'optima');
	$label_days = esc_html__('Days', 'optima');
	$label_hours = esc_html__('Hours', 'optima');
	$label_minutes = esc_html__('Minutes', 'optima');
	$label_seconds = esc_html__('Seconds', 'optima');
	
	$label_year = esc_html__('Year', 'optima');
	$label_month = esc_html__('Month', 'optima');
	$label_week = esc_html__('Week', 'optima');
	$label_day = esc_html__('Day', 'optima');
	$label_hour = esc_html__('Hour', 'optima');
	$label_minute = esc_html__('Minute', 'optima');
	$label_second = esc_html__('Second', 'optima');
	
	$compile = '';
	$compile .= '<div class="countdown_wrapper">
								<div class="gt3-countdown" data-year="'.esc_attr($countdown_year).'" data-month="'.esc_attr($countdown_month).'" data-day="'.esc_attr($countdown_day).'" data-hours="'.esc_attr($countdown_hours).'" data-min="'.esc_attr($countdown_min).'" data-label_years="'.esc_attr($label_years).'" data-label_months="'.esc_attr($label_months).'" data-label_weeks="'.esc_attr($label_weeks).'" data-label_days="'.esc_attr($label_days).'" data-label_hours="'.esc_attr($label_hours).'" data-label_minutes="'.esc_attr($label_minutes).'" data-label_seconds="'.esc_attr($label_seconds).'" data-label_year="'.esc_attr($label_year).'" data-label_month="'.esc_attr($label_month).'" data-label_week="'.esc_attr($label_week).'" data-label_day="'.esc_attr($label_day).'" data-label_hour="'.esc_attr($label_hour).'" data-label_minute="'.esc_attr($label_minute).'" data-label_second="'.esc_attr($label_second).'"></div>
							</div>';
	
	echo sprintf("%s", $compile);
?>