<?php

include_once get_template_directory() . '/vc_templates/gt3_google_fonts_render.php';

$header_font = gt3_option('header-font');
$main_font = gt3_option('main-font');

$defaults = array(
	'build_query' => '',
	'item_el_class' => '',
	'css' => '',
	'css_animation' => '',
	'module_title' => '',
	'external_link_text' => '',
	'external_link' => '',
	'meta_author' => 'yes',
	'meta_date' => 'yes',
	'meta_comments' => 'yes',
	'meta_categories' => 'yes',
	'items_per_line' => '1',
	'items_per_line_type2' => '1',
	'view_type' => 'type4',
	'image_proportions' => '4_3',
	'meta_position' => 'before_title',
	'content_alignment' => 'left',
	'use_theme_blog_style' => 'yes',
	'content_letter_count' => '85',
	'spacing_beetween_items' => '30',
	'autoplay_carousel' => 'yes',
	'auto_play_time' => '3000',
	'infinite_scroll' => 'yes',
	'items_per_column' => '1',
	'adaptive_height' => 'yes',
	'use_carousel' => '',
	'pf_post_icon' => '',
	'post_read_more_link' => '',
	'scroll_items' => 'yes',
	'use_pagination_carousel' => 'yes',
	'use_prev_next_carousel' => '',
	'custom_theme_color' => esc_attr(gt3_option("theme-custom-color")),
	'custom_headings_color' => esc_attr($header_font['color']),
	'custom_content_color' => esc_attr($main_font['color']),
	'heading_font_size' => '',
	'content_font_size' => '',
	'post_meta_uppercase' => 'no',
	'first_post_image' => ''
);

$atts = vc_shortcode_attribute_parse($defaults, $atts);
extract($atts);
$compile = '';

$class_to_filter = vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $item_el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

// Render Google Fonts
$obj = new GoogleFontsRender();
$shortc = $this->shortcode;
extract( $obj->getAttributes( $atts, $this, $shortc, array('google_fonts_blog', 'google_fonts_blog_headings')));

if ( ! empty( $styles_google_fonts_blog ) ) {
	$blog_value_font = '' . esc_attr( $styles_google_fonts_blog ) . '';
} else {
	$blog_value_font = '';
}

if ( ! empty( $styles_google_fonts_blog_headings ) ) {
	$blog_value_font_headings = '' . esc_attr( $styles_google_fonts_blog_headings ) . '';
} else {
	$blog_value_font_headings = '';
}

// Animation
if (! empty($atts['css_animation'])) {
	$animation_class = $this->getCSSAnimation( $atts['css_animation'] );
} else {
	$animation_class = '';
}

if ($view_type == 'type2') {
	$items_per_line = $items_per_line_type2;
}

$carousel_parent = '';

if ($use_carousel == 'yes') {
	$carousel_parent = 'gt3_module_carousel';
	
	$auto_play_time = (int)$auto_play_time;
	
	wp_enqueue_script('gt3_slick_js', get_template_directory_uri() . '/js/slick.min.js', array(), false, false);
	switch ($items_per_line) {
		case '1':
			$responsive_1024 = 1;
			$responsive_760 = 1;
			
			$responsive_sltscrl_1024 = 1;
			$responsive_sltscrl_760 = 1;
			break;
		case '2':
			$responsive_1024 = 2;
			$responsive_760 = 1;
			break;
		case '3':
			$responsive_1024 = 3;
			$responsive_760 = 1;
			break;
		case '4':
			$responsive_1024 = 4;
			$responsive_760 = 1;
			break;
			
		default:
			$responsive_1024 = 1;
			$responsive_760 = 1;
			break;
	}
	
	$responsive_sltscrl_1024 = $responsive_1024;
	$responsive_sltscrl_760 = $responsive_760;
	if ($scroll_items == 'yes') {
		$responsive_sltscrl_1024 = $responsive_sltscrl_760 = '1';
	}
	$slick_settings = '';
	$slick_settings .= isset($items_per_line) ? '"slidesToShow": '.esc_attr($items_per_line).',' : '"slidesToShow": 1,';
	if ($scroll_items == 'yes') {
		$slick_settings .= '"slidesToScroll": 1,';
	} else {
		$slick_settings .= '"slidesToScroll": '.esc_attr($items_per_line).',';
	}
	if ($autoplay_carousel == 'yes') {
		$slick_settings .= '"autoplay": true,';
	} else {
		$slick_settings .= '"autoplay": false,';
	}
	$slick_settings .= isset($auto_play_time) ? '"autoplaySpeed": '.esc_attr($auto_play_time).',' : '"autoplaySpeed": 3000,';
	if ($infinite_scroll == 'yes') {
		$slick_settings .= '"infinite": true,';
	} else {
		$slick_settings .= '"infinite": false,';
	}
	if ($use_prev_next_carousel == 'yes') {
		$slick_settings .= '"arrows": false,';
	} else {
		$slick_settings .= '"arrows": true,';
	}
	if ($use_pagination_carousel == 'yes') {
		$slick_settings .= '"dots": false,';
	} else {
		$slick_settings .= '"dots": true,';
	}
	if ($adaptive_height == 'yes') {
		$slick_settings .= '"adaptiveHeight": true,';
	} else {
		$slick_settings .= '"adaptiveHeight": false,';
	}
	$slick_settings .= '"responsive": [{"breakpoint": 1024,"settings": {"slidesToShow": '.esc_attr($responsive_1024).',"slidesToScroll": '.esc_attr($responsive_sltscrl_1024).'}},{"breakpoint": 760, "settings": {"slidesToShow": '.esc_attr($responsive_760).', "slidesToScroll": '.esc_attr($responsive_sltscrl_760).'}} ]';
}

// Blog styles
$blog_style = $blog_value_font;
$blog_title_headings = $blog_value_font_headings;

// Button font-size
if ($heading_font_size != '') {
	$heading_font_size = (int)$heading_font_size;
	$heading_font_line = $heading_font_size + 4;
	$heading_font_size_style = 'font-size: ' . $heading_font_size . 'px; line-height: ' . $heading_font_line . 'px; ';
} else {
	$heading_font_size_style = '';
}

$blog_style_headings = $blog_value_font_headings . $heading_font_size_style;

// Content font-size
if ($content_font_size != '') {
	$content_font_size = (int)$content_font_size;
	$content_font_line = $content_font_size + 14;
	$content_font_size_style = 'font-size: ' . $content_font_size . 'px; line-height: ' . $content_font_line . 'px; ';
} else {
	$content_font_size_style = '';
}

$rand_class = mt_rand(0, 9999);

// Post Meta Uppercase
$uppercase_class = '';
if ($post_meta_uppercase == 'yes') {
	$uppercase_class = 'upper_text';
}

?>
<div class="vc_row">
	<div class="vc_col-sm-12 gt3_module_featured_posts blog_alignment_<?php echo esc_attr($content_alignment); ?> <?php echo esc_attr($animation_class); ?> <?php echo esc_attr($css_class); ?> blog_<?php echo esc_attr($view_type); ?> items<?php echo esc_attr($items_per_line); ?> <?php echo esc_attr($carousel_parent); ?> class_<?php echo esc_attr($rand_class); ?>" <?php echo (strlen($blog_style) ? 'style="' . esc_attr($blog_style) . '"' : ''); ?>>
		
		<?php
		$external_btn = '';
		// External Link Settings
		$ext_link_temp = vc_build_link($external_link);
		$ext_url = $ext_link_temp['url'];
		$ext_link_title = $ext_link_temp['title'];
		$ext_target = $ext_link_temp['target'];
		if($ext_url !== '') {
			$ext_url = $ext_url;
		} else {
			$ext_url = home_url('?post_type=post');
		}
		if($ext_link_title !== '') {
			$title_for_ext = 'title="' . $ext_link_title . '"';
		} else {
			$title_for_ext = '';
		}
		if($ext_target !== '') {
			$target_ext = 'target="' . $ext_target . '"';
		} else {
			$target_ext = '';
		}
		if ($external_link_text !== '') {
			$external_btn = '<div class="external_link"><a href="'.esc_attr($ext_url).'" '.$title_for_ext.' '.$target_ext.' class="learn_more">' . $external_link_text . '<span></span></a></div>';
		}
		?>
		
		<?php
			$moduletitle = $module_title_block = $carousel_arrows = '';
			if (strlen($module_title) > 0) {
				$moduletitle = '<h2 ' . (strlen($blog_title_headings) ? 'style="' . esc_attr($blog_title_headings) . '"' : '') . '>' . esc_attr($module_title) . '</h2>';
			}
			if ($use_carousel == 'yes' && $use_prev_next_carousel !== 'yes') {
				$carousel_arrows = '<div class="carousel_arrows"><a href="#" class="left_slick_arrow"><span></span></a><a href="#" class="right_slick_arrow"><span></span></a></div>';
			}
			
			$module_title_block = $moduletitle . $external_btn . $carousel_arrows;
			
			 echo (strlen($module_title_block) ? '<div class="gt3_module_title">' . $module_title_block . '</div>' : '');
		?>
			
			<?php
			list($query_args, $build_query) = vc_build_loop_query($build_query);
			
			global $gt3_wp_query_in_shortcodes;
			$gt3_wp_query_in_shortcodes = new WP_Query($query_args);
			
			// Default Image Size
			switch ($items_per_line) {
				case '1':
					$width = '1170';
					$height = '725';
					break;
				case '2':
					$width = '800';
					$height = '495';
					break;
				case '3':
					$width = '600';
					$height = '370';
					break;
				case '4':
					$width = '400';
					$height = '250';
					break;
			}
			
			if ($view_type == 'type2') {
				$width = '150';
				$height = '150';
			} else {
				if ($image_proportions == '4_3') {
					$height = $width*3/4;
				} else if ($image_proportions == 'horizontal') {
					$height = $width/1.85;
				} else if ($image_proportions == 'vertical') {
					$height = $width*4/3;
				} else if ($image_proportions == 'square') {
					$height = $width;
				} else if ($image_proportions == 'original') {
					$width = $height = '';
				};
			}
			
			if ($gt3_wp_query_in_shortcodes->have_posts()) {
				if ($view_type !== 'type1') {
					$compile .= '<div class="spacing_beetween_items_'.esc_attr($spacing_beetween_items).'">';
				}
				if ($use_carousel == 'yes') {
					$compile .= '<div class="gt3_carousel_list" data-slick="{'.esc_attr($slick_settings).'}">';
				}
				$j= 1;
				$n = 1;
				$all_post_count = $gt3_wp_query_in_shortcodes->post_count;
					
					while ($gt3_wp_query_in_shortcodes->have_posts()) {
							$gt3_wp_query_in_shortcodes->the_post();
							
							$comments_num = '' . get_comments_number(get_the_ID()) . '';
							
							if ($comments_num == 1) {
								$comments_text = '' . esc_html__('comment', 'optima') . '';
							} else {
								$comments_text = '' . esc_html__('comments', 'optima') . '';
							}
							
							$post_date = $post_author = $post_category_compile = $post_comments = $has_post_thumb = '';
							
							$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
							
							// Letter Count
							$content_letter_count = (int)$content_letter_count;
							if (has_excerpt()) {
								$post_excerpt = get_the_excerpt();
							} else {
								$post_excerpt = get_the_content();
							}
							
							$post_excerpt = preg_replace( '~\[[^\]]+\]~', '', $post_excerpt);
							$post_excerpt_without_tags = strip_tags($post_excerpt);
							
							if ($content_letter_count != '') {
								$post_descr = gt3_smarty_modifier_truncate($post_excerpt_without_tags, $content_letter_count, "...");
							} else {
								$post_descr = $post_excerpt_without_tags;
							}
							if ($content_letter_count == '0' || (strlen($featured_image[0]) > 0 && $view_type == 'type3')) {
								$post_descr = '';
							}
							
							// Categories
							if ($meta_categories == 'yes') {
								if (get_the_category()) $categories = get_the_category();
								if ($categories) {
									$post_categ = '';
									$post_category_compile = '<span>';
									foreach ($categories as $category) {
										$post_categ = $post_categ . '<a href="' . get_category_link($category->term_id) . '">' . $category->cat_name . '</a>' . ', ';
									}
									$post_category_compile .= ' ' . trim($post_categ, ', ') . '</span>';
								}
							}
							
							$post = get_post();
							
							if ($meta_date == 'yes') {
								$post_date = '<span>' . esc_html(get_the_time(get_option( 'date_format' ))) . '</span>';
							}
							
							if ($meta_author == 'yes') {
								$post_author = '<span>' . esc_html__("by", "optima") . ' <a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author_meta('display_name')) . '</a></span>';
							}
							
							if ($meta_comments == 'yes') {
								$post_comments = '<span><a href="' . esc_url(get_comments_link()) . '">' . esc_html(get_comments_number(get_the_ID())) . ' ' . $comments_text . '</a></span>';
							}
							
							// Post meta
							if ($view_type == 'type3') {
								$post_meta = $post_author . $post_date . $post_comments;
							} else {
								$post_meta = $post_author . $post_date . $post_category_compile . $post_comments;
							}
							
							$pf = get_post_format();
							if (empty($pf)) $pf = "standard";
							
							$pf_media = gt3_get_pf_type_output($pf, $width, $height, $featured_image);
							
							$pf = $pf_media['pf'];
							
							$post_title = get_the_title();
							$post_link_title = '';
							
							if (strlen($post_title) > 0) {
								$pf_icon = '';
								if ($pf_post_icon == 'yes') {
									if ($pf == 'standard-image') {
										$pf_icon = '<i class="fa fa-camera"></i>';
									} else if ($pf == 'gallery') {
										$pf_icon = '<i class="fa fa-files-o"></i>';
									} else if ($pf == 'audio') {
										$pf_icon = '<i class="fa fa-headphones"></i>';
									} else if ($pf == 'video') {
										$pf_icon = '<i class="fa fa-youtube-play"></i>';
									} else if ($pf == 'quote') {
										$pf_icon = '<i class="fa fa-quote-left"></i>';
									} else if ($pf == 'link') {
										$pf_icon = '<i class="fa fa-link"></i>';
									} else {
										$pf_icon = '<i class="fa fa-file-text"></i>';
									}
								}
								$post_link_title = '<h5 class="blogpost_title" ' . (strlen($blog_style_headings) ? 'style="' . esc_attr($blog_style_headings) . '"' : '') . '>' . $pf_icon . '<a href="' . esc_url(get_permalink()) . '" ' . (strlen($blog_style_headings) ? 'style="' . esc_attr($blog_style_headings) . '"' : '') . '>' . esc_html(get_the_title()) /*. '<span></span>'*/ . '</a></h5>';
							}
							
							if ($j == 1 && $items_per_column !== '1') {
								$compile .= '<div class="per_column_wrap">';
							}
							
							if (strlen($featured_image[0]) > 0) {
								$has_post_thumb = 'has_post_thumb';
							} else {
								$has_post_thumb = 'without_post_thumb';
							}
							
							if (strlen($featured_image[0]) > 0 && ($view_type == 'type1' && $n == 1)) {
								$has_post_thumb .= ' first_post_with_thumb';
								$width = '1170';
								$height = '630';
							}
							
							$compile .= '
								<div class="blog_post_preview format-' . $pf . ' ' . $has_post_thumb . '">
										<div class="item_wrapper">
											<div class="blog_content">';
												if (strlen($featured_image[0]) > 0 && ($view_type !== 'type1' || ($view_type == 'type1' && $n == 1 && $first_post_image == 'yes')) ) {
													$compile .= '<div class="blog_post_media"><a href="' . esc_url(get_permalink()) . '"><img src="' . esc_url(aq_resize($featured_image[0], $width, $height, true, true, true)) . '" alt="img" /></a>';
													if ($view_type == 'type3') {
														$compile .= ''.$post_category_compile.'';
													}
													$compile .= '</div>';
												}
												$compile .= '<div class="featured_post_info ">';
												
												if ($meta_position == 'after_title') {
													$compile .= '' . $post_link_title . '';
												}
												$compile .= '' . (strlen($post_meta) ? '<div class="listing_meta '.esc_attr($uppercase_class).'">' . $post_meta . '</div>' : '') . '';
												
												if ($meta_position == 'before_title') {
													$compile .= '' . $post_link_title . '';
												}
												
												$compile .= '' . (strlen($post_descr) ? '<p ' . (strlen($content_font_size_style) ? 'style="' . esc_attr($content_font_size_style) . '"' : '') . '>' . $post_descr . '</p>' : '') . '';
												if ($post_read_more_link == 'yes') {
													$compile .= '<div><a href="'. esc_url(get_permalink()) .'" class="learn_more">'. esc_html__('Learn more', 'optima') .'<span></span></a></div>';
												}
												
											$compile .= '</div>
										</div>
									</div>
								</div>';
								
							if (($j == $items_per_column || $n == $all_post_count )&& $items_per_column !== '1' ) {
								$compile .= '</div>';
							}
							
							$j++;
							if ($j > $items_per_column) {
								$j = 1;
							}
							$n++;
						}
						
					// end while
					wp_reset_postdata();
					
					if ($use_carousel == 'yes') {
						$compile .= '</div>';
					}
					
					if ($view_type !== 'type1') {
						$compile .= '</div>';
					}
				}
				
			echo sprintf("%s", $compile);
			
		?>
	</div>
</div>

<?php
// Custom Colors
$custom_blog_css = '';

if ($use_theme_blog_style !== 'yes') {
	// Custom Theme Color
	$custom_blog_css .= '.gt3_module_featured_posts.class_'.esc_attr($rand_class).' .listing_meta, .gt3_module_featured_posts.class_'.esc_attr($rand_class).' .listing_meta a, .gt3_module_featured_posts.class_'.esc_attr($rand_class).' h4 a:hover, .gt3_module_featured_posts.class_'.esc_attr($rand_class).' .learn_more, .gt3_module_featured_posts.class_'.esc_attr($rand_class).' .blogpost_title i {color: '.esc_attr($custom_theme_color).'; } .gt3_module_featured_posts.class_'.esc_attr($rand_class).' .learn_more span, .gt3_module_featured_posts.class_'.esc_attr($rand_class).' .gt3_module_title .carousel_arrows a:hover span {background: '.esc_attr($custom_theme_color).'; } .gt3_module_featured_posts.class_'.esc_attr($rand_class).' .learn_more span:before, .gt3_module_featured_posts.class_'.esc_attr($rand_class).' .gt3_module_title .carousel_arrows a:hover span:before {border-color: '.esc_attr($custom_theme_color).'; }';

	// Custom Headings Color
	$custom_blog_css .= '.gt3_module_featured_posts.class_'.esc_attr($rand_class).' h2, .gt3_module_featured_posts.class_'.esc_attr($rand_class).' h4, .gt3_module_featured_posts.class_'.esc_attr($rand_class).' h4 span, .gt3_module_featured_posts.class_'.esc_attr($rand_class).' h4 a, .gt3_module_featured_posts.class_'.esc_attr($rand_class).' .learn_more:hover {color: '.esc_attr($custom_headings_color).'; } .blog_type1.class_'.esc_attr($rand_class).' .blog_post_preview:before, .gt3_module_featured_posts.class_'.esc_attr($rand_class).' .learn_more:hover span, .gt3_module_featured_posts.class_'.esc_attr($rand_class).' .gt3_module_title .carousel_arrows a span {background: '.esc_attr($custom_headings_color).'; } .gt3_module_featured_posts.class_'.esc_attr($rand_class).' .learn_more:hover span:before, .gt3_module_featured_posts.class_'.esc_attr($rand_class).' .gt3_module_title .carousel_arrows a span:before {border-color: '.esc_attr($custom_headings_color).'; }';

	// Custom Content Color
	$custom_blog_css .= '.gt3_module_featured_posts.class_'.esc_attr($rand_class).' .blog_content p, .gt3_module_featured_posts.class_'.esc_attr($rand_class).' .listing_meta a:hover {color: '.esc_attr($custom_content_color).'; }';

	$custom_blog_css;

}
gt3_blog_custom_styles_js($custom_blog_css);
?>