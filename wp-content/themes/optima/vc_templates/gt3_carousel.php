<?php

$defaults = array(
	'posts_per_line' => '1',
	'scroll_items' => '1',
	'view_type' => 'grid',
	'autoplay_carousel' => true,
	'el_class' => '',
	'multiple_items' => true,
	'adaptive_height' => false,
);

$atts = vc_shortcode_attribute_parse($defaults, $atts);
extract($atts);
$compile = '';
wp_enqueue_script('gt3_slick_js', get_template_directory_uri() . '/js/slick.min.js', array(), false, false);
$rand_class = mt_rand(1, 10000);
$set_slick_class = 'slick-class-' . $rand_class;

switch ($posts_per_line) {
	case '1':
		$responsive_1024 = 1;
		$responsive_600 = 1;
		$responsive_480 = 1;
		$responsive_sltscrl_1024 = 1;
		$responsive_sltscrl_600 = 1;
		$responsive_sltscrl_480 = 1;
		break;
	case '2':
		$responsive_1024 = 2;
		$responsive_600 = 2;
		$responsive_480 = 1;
		break;
	case '3':
		$responsive_1024 = 3;
		$responsive_600 = 2;
		$responsive_480 = 1;
		break;
	case '4':
		$responsive_1024 = 4;
		$responsive_600 = 2;
		$responsive_480 = 1;
		break;
	case '5':
		$responsive_1024 = 4;
		$responsive_600 = 2;
		$responsive_480 = 1;
		break;
	case '6':
		$responsive_1024 = 4;
		$responsive_600 = 2;
		$responsive_480 = 1;
		break;
	default:
		$responsive_1024 = 1;
		$responsive_600 = 1;
		$responsive_480 = 1;
		break;
}

$responsive_sltscrl_1024 = !isset($scroll_items) && $scroll_items ? 1 : $responsive_1024;
$responsive_sltscrl_600 = !isset($scroll_items) && $scroll_items ? 1 : $responsive_600;
$responsive_sltscrl_480 = !isset($scroll_items) && $scroll_items ? 1 : $responsive_480;

$slick_settings = '';
$slick_settings .= isset($posts_per_line) ? '"slidesToShow": '.$posts_per_line.',' : '"slidesToShow": 1,';
$slick_settings .= isset($scroll_items) && $scroll_items ? '"slidesToScroll": 1,' : '"slidesToScroll": '.$posts_per_line.',';
$slick_settings .= isset($autoplay_carousel) && $autoplay_carousel ? '"autoplay": true,' : '"autoplay": false,';
$slick_settings .= isset($slider_speed) ? '"autoplaySpeed": '.$slider_speed.',' : '"autoplaySpeed": 3000,';
$slick_settings .= isset($multiple_items) && $multiple_items ? '"infinite": true,' : '"infinite": false,';
$slick_settings .= isset($use_prev_next) && !$use_prev_next ? '"arrows": true,' : '"arrows": false,';
$slick_settings .= isset($use_pagination) && !$use_pagination ? '"dots": true,' : '"dots": false,';
$slick_settings .= isset($adaptive_height) && $adaptive_height ? '"adaptiveHeight": true,' : '"adaptiveHeight": false,';
$slick_settings .= '"responsive": [{"breakpoint": 1024,"settings": {"slidesToShow": '.esc_attr($responsive_1024).',"slidesToScroll": '.esc_attr($responsive_sltscrl_1024).'}},{"breakpoint": 600, "settings": {"slidesToShow": '.esc_attr($responsive_600).', "slidesToScroll": '.esc_attr($responsive_sltscrl_600).'}}, {"breakpoint": 480,      "settings": {        "slidesToShow": '.esc_attr($responsive_480).',        "slidesToScroll": '.esc_attr($responsive_sltscrl_480).'      }    }  ]';
?>
<div class="vc_row">
	<div class="vc_col-sm-12 gt3_module_carousel">
		<div class="gt3_carousel_list <?php echo esc_attr($set_slick_class); ?>" data-slick='{<?php echo esc_attr($slick_settings); ?>}' data-slick-class="<?php echo esc_attr($rand_class); ?>">
			<?php echo do_shortcode($content); ?>
		</div>
	</div>
</div>