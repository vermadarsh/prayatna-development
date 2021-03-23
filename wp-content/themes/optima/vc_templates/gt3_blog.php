<?php

$defaults = array(
	'build_query' => '',
	'item_el_class' => '',
	'css' => '',
	'css_animation' => '',
	'items_per_line' => '1',
	'spacing_beetween_items' => '5',
	'blog_post_listing_content_module' => 'yes',
	'pf_post_icon' => 'no',
	'meta_author' => 'yes',
	'meta_date' => 'yes',
	'meta_comments' => 'yes',
	'meta_categories' => 'yes',
);

$atts = vc_shortcode_attribute_parse($defaults, $atts);
extract($atts);
$compile = '';

$class_to_filter = vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $item_el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

// Animation
if (! empty($atts['css_animation'])) {
	$animation_class = $this->getCSSAnimation( $atts['css_animation'] );
} else {
	$animation_class = '';
}

$blog_masonry = $blog_masonry_item = '';

if ($items_per_line !== '1') {
	$blog_masonry = 'isotope_blog_items';
	$blog_masonry_item = 'element';
}

?>
<div class="vc_row">
	<div class="vc_col-sm-12 gt3_module_blog <?php echo esc_attr($animation_class); ?> <?php echo esc_attr($css_class); ?> items<?php echo esc_attr($items_per_line); ?>">
		
		<?php
		list($query_args, $build_query) = vc_build_loop_query($build_query);
		
		global $paged;
		if (empty($paged)) {
			$paged = (get_query_var('page')) ? get_query_var('page') : 1;
		}
		
		$query_args['paged'] = $paged;
		
		global $gt3_wp_query_in_shortcodes;
		$gt3_wp_query_in_shortcodes = new WP_Query($query_args);
		
		$show_likes = gt3_option('blog_post_likes');
		$show_share = gt3_option('blog_post_share');
			
		if ($gt3_wp_query_in_shortcodes->have_posts()) {
			
			if ($items_per_line !== '1') {
				$compile .= '<div class="spacing_beetween_items_'.$spacing_beetween_items.' ' . esc_attr($blog_masonry) . '">';
			}
			
				while ($gt3_wp_query_in_shortcodes->have_posts()) {
					$gt3_wp_query_in_shortcodes->the_post();
					
					$all_likes = gt3pb_get_option("likes");
					
					$comments_num = '' . get_comments_number(get_the_ID()) . '';
					
					if ($comments_num == 1) {
						$comments_text = '' . esc_html__('comment', 'optima') . '';
					} else {
						$comments_text = '' . esc_html__('comments', 'optima') . '';
					}
					
					$post_date = $post_author = $post_category_compile = $post_comments = '';
					
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
					$post_meta = $post_author . $post_date . $post_category_compile . $post_comments;
					$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
					$pf = get_post_format();
					if (empty($pf)) $pf = "standard";
					ob_start();
					if (has_excerpt()) {
						$post_excerpt = the_excerpt();
					} else {
						$post_excerpt = the_content();
					}
					$post_excerpt = ob_get_clean();
					
					$width = '1170';
					$height = '725';
					
					$pf_media = gt3_get_pf_type_output($pf, $width, $height, $featured_image);
					
					$pf = $pf_media['pf'];
					
					if ($pf == 'audio' || $pf == 'quote' || $pf == 'link') {
						$symbol_count = '190';
					} else {
						$symbol_count = '400';
					}
					
					if ($items_per_line == '3' || $items_per_line == '4') {
						$symbol_count = $symbol_count/3;
					}
					
					if ($blog_post_listing_content_module == 'yes') {
						$post_excerpt = preg_replace( '~\[[^\]]+\]~', '', $post_excerpt);
						$post_excerpt_without_tags = strip_tags($post_excerpt);
						$post_descr = gt3_smarty_modifier_truncate($post_excerpt_without_tags, $symbol_count, "...");
					} else {
						$post_descr = $post_excerpt;
					}
					
					$post_title = get_the_title();
					
					$compile .= '
						<div class="blog_post_preview ' . esc_attr($blog_masonry_item) . ' format-' . esc_attr($pf) . '">
							<div class="item_wrapper">
								<div class="blog_content">';
									$compile .= $pf_media['content'];

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
											} else {
												$pf_icon = '<i class="fa fa-file-text"></i>';
											}
										}
										if ( is_sticky() ) {
											$pf_icon = '<i class="fa fa-thumb-tack"></i>';
										}
										$compile .= '<h3 class="blogpost_title">' . $pf_icon . '<a href="' . esc_url(get_permalink()) . '">' . esc_html($post_title) . '</a></h3>';
									}

									$compile .= '' . (strlen($post_meta) ? '<div class="listing_meta">' . $post_meta . '</div>' : '') . '';
										
										$compile .= '<div class="blog-content-wrapp">' . (strlen($post_descr) ? $post_descr : '').'</div>' . '<div class="clear post_clear"></div><a href="'. esc_url(get_permalink()) .'" class="learn_more">'. esc_html__('Learn More', 'optima') .'<span></span></a><div class="post_info">';
											if ($show_share == "1") {
												$compile .= '
												<div class="post_share">
													<a href="#">'. /*__('Share', 'optima') .*/'</a>
													<div class="share_wrap">
														<ul>';
															$compile .='    
																<li><a target="_blank" href="'. esc_url('https://www.facebook.com/share.php?u='. get_permalink()) .'"><span class="fa fa-facebook"></span></a></li>';
															$compile .= '<li><a target="_blank" href="'. 'https://plus.google.com/share?url='.urlencode(get_permalink()) .'" class="share_gplus"><span class="fa fa-google-plus"></span></a></li>';
															if (strlen($featured_image[0]) > 0) {
																$compile .= '<li><a target="_blank" href="'. esc_url('https://pinterest.com/pin/create/button/?url='. get_permalink() .'&media='. $featured_image[0]) .'"><span class="fa fa-pinterest"></span></a></li>';
															}
															$compile .='
																<li><a target="_blank" href="'. esc_url('https://twitter.com/intent/tweet?text='. get_the_title() .'&amp;url='. get_permalink()) .'"><span class="fa fa-twitter"></span></a></li>
																<li><a target="_blank" href="'. esc_url('https://www.linkedin.com/shareArticle?mini=true&url='.get_permalink().'&title='.esc_attr(get_the_title()).'&source='.get_bloginfo("name")) .'"><span class="fa fa-linkedin"></span></a></li>
														</ul>
													</div>
												</div>';
											}
												$likes = (isset($all_likes[get_the_ID()]) && $all_likes[get_the_ID()]>0) ? $all_likes[get_the_ID()] : '';
												if (isset($all_likes[get_the_ID()]) && $all_likes[get_the_ID()] == 1) {
													$likes_text_label = esc_html__('Like', 'optima');
												} else {
													$likes_text_label = esc_html__('Likes', 'optima');
												}

												if ($show_likes == "1") {
													$compile .= '
													<div  title="'. (isset($all_likes[get_the_ID()]) ? $all_likes[get_the_ID()] : 0 ). ' ' . $likes_text_label .'" class="likes_block post_likes_add '. (isset($_COOKIE['like_post'.get_the_ID()]) ? "already_liked" : "") .'" data-postid="'. esc_attr(get_the_ID()).'" data-modify="like_post">
														<span class="fa fa-heart-o icon"></span>
														<span class="like_count">'.$likes. ' ' . (!empty($likes) ? ($likes == '1' ? esc_html__( 'Like', 'optima' ) : esc_html__( 'Likes', 'optima' )) : '') .'</span>
													</div>';
												}
										$compile .= '
										</div>
									<div class="clear"></div>
								</div>
							</div>
						</div>
					';
				}
				wp_reset_postdata();
				
				if ($items_per_line !== '1') {
					$compile .= '</div>';
				}
				
				$compile .= gt3_get_theme_pagination("10", "show_in_shortcodes");
			}
			echo sprintf("%s", $compile);
		?>
	</div>
</div>