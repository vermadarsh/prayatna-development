<?php
$layout = gt3_option('portfolio_single_sidebar_layout');
$sidebar = gt3_option('portfolio_single_sidebar_def');
if (class_exists( 'RWMB_Loader' )) {
    $mb_layout = rwmb_meta('mb_page_sidebar_layout');
    if (!empty($mb_layout) && $mb_layout != 'default') {
        $layout = $mb_layout;
        $sidebar = rwmb_meta('mb_page_sidebar_def');
    }
}
$column = 12;
if ( $layout == 'left' || $layout == 'right' ) {
    $column = 9;
}else{
    $sidebar = '';
}
$row_class = ' sidebar_'.$layout;

$mb_show_portfolio_info = rwmb_meta('mb_show_portfolio_info');

get_header ();
?>

<div class="container gt3_portfolio_single">
    <div class="row<?php echo $row_class; ?>">
        <div class="content-container span<?php echo (int)$column; ?>">
            <section id='main_content'>
                <?php
                    while ( have_posts() ):
                        the_post();
                        if (get_post_thumbnail_id(get_the_id())) {
                            $post_img_url = wp_get_attachment_url(get_post_thumbnail_id(get_the_id()), 'single-post-thumbnail');                            
                            if (function_exists('gt3_get_image_srcset')) {
                                $responsive_dimensions = array(
                                    array('1200','1170'),
                                    array('992','950'),
                                    array('768','728')
                                );
                                $gt3_featured_image_url = gt3_get_image_srcset($post_img_url,null,$responsive_dimensions);
                            }else{
                                $gt3_featured_image_url = 'src="'.esc_attr(aq_resize($post_img_url, "1170", "", true, true, true)).'"';
                            }
                            echo '<img '.$gt3_featured_image_url.' class="gt3_single_portfolio_thumbnail" alt="">';
                        }

                        $page_title_conditional = ((gt3_option('page_title_conditional') == '1' || gt3_option('page_title_conditional') == true) && (gt3_option('portfolio_title_conditional') == '1' || gt3_option('portfolio_title_conditional') == true )) ? 'yes' : 'no' ;

                        if (class_exists( 'RWMB_Loader' ) && get_queried_object_id() !== 0) {
                        $mb_page_title_conditional = rwmb_meta('mb_page_title_conditional');
                              if ($mb_page_title_conditional == 'yes') {
                                  $page_title_conditional = 'yes';
                              }elseif($mb_page_title_conditional == 'no'){
                                  $page_title_conditional = 'no';
                              }
                        }

                        if ( $page_title_conditional != 'yes') {
                            ?><div class="gt3_portfolio_title"><?php
                            echo '<h3>'.get_the_title().'</h3>';
                            ?></div><?php
                        } 

                        if ($mb_show_portfolio_info == '1') {
                            $mb_portfolio_info = rwmb_meta('mb_portfolio_info');
                            if (!empty($mb_portfolio_info) && is_array($mb_portfolio_info)) {
                                ?><div class="gt3_portfolio_info__wrapper"><div class="gt3_portfolio_info"><?php
                                foreach ($mb_portfolio_info as $mb_portfolio_info_item) {
                                    if (!empty($mb_portfolio_info_item) && is_array($mb_portfolio_info_item)) {
                                        if (!empty($mb_portfolio_info_item['custom_field_type'])) {
                                            switch ($mb_portfolio_info_item['custom_field_type']) {
                                                case 'category':                                                 
                                                    if ($mb_portfolio_info_item['value'] == '1') {
                                                        ?><div class="gt3_portfolio_info__item"><?php
                                                        if (!empty($mb_portfolio_info_item['name'])) {
                                                            
                                                            $post_cats = wp_get_post_terms(get_the_id(), 'portfolio-category');
                                                            ?><div class="gt3_portfolio_info__item_category_wrapper"><?php
                                                            for ($i=0; $i<count( $post_cats ); $i++) {
                                                                $post_cat_term = $post_cats[$i];
                                                                $post_cat_name = $post_cat_term->slug;
                                                                if ($i > 0) {
                                                                    ?><span class="gt3_portfolio_list__categories_delimiter">, </span><?php
                                                                }
                                                                ?><a href="<?php echo esc_url(get_term_link($post_cat_term->term_id,'portfolio-category')); ?>"><?php echo $post_cat_term->name; ?></a><?php
                                                            }
                                                            ?></div><?php
                                                        }
                                                        ?></div><?php
                                                    }
                                                    break;
                                                case 'date':
                                                    if ($mb_portfolio_info_item['value'] == '1') {
                                                        ?><div class="gt3_portfolio_info__item"><?php
                                                        /*if (!empty($mb_portfolio_info_item['name'])) {
                                                            ?><h4 class="gt3_portfolio_info__item_title"><?php echo $mb_portfolio_info_item['name']; ?></h4><?php
                                                        }*/
                                                            ?><div class="gt3_portfolio_info__item_date"><?php
                                                            $unixTime = get_the_time('U');
                                                            $compile = '';
                                                            if ((current_time('timestamp') - $unixTime) < DAY_IN_SECONDS) {
                                                                echo human_time_diff($unixTime, current_time('timestamp')) . ' ' . esc_html__("ago", 'gt3_wize_core');
                                                            }else{
                                                                echo esc_html(get_the_time(get_option( 'date_format' )));                
                                                            }
                                                            ?></div><?php
                                                        ?></div><?php
                                                    }
                                                    break;
                                                case 'comments':
                                                    if ($mb_portfolio_info_item['value'] == '1') {
                                                        ?><div class="gt3_portfolio_info__item"><?php
                                                        /*if (!empty($mb_portfolio_info_item['name'])) {
                                                            ?><h4 class="gt3_portfolio_info__item_title"><?php echo $mb_portfolio_info_item['name']; ?></h4><?php
                                                        }*/
                                                        $comments_num = '' . get_comments_number(get_the_ID()) . '';
                                                        if ($comments_num == 1) {
                                                            $comments_text = '' . esc_html__('comment', 'gt3_wize_core') . '';
                                                        } else {
                                                            $comments_text = '' . esc_html__('comments', 'gt3_wize_core') . '';
                                                        }
                                                        ?><div class="gt3_portfolio_info__item_comments_wrapper"><span><a href="<?php echo esc_url(get_comments_link()); ?>"><?php echo esc_html(get_comments_number(get_the_ID())); ?> <?php echo sprintf("%s", $comments_text); ?></a></span></div><?php
                                                           
                                                        ?></div><?php
                                                    }
                                                    break;
                                            }
                                        }else{
                                            ?><div class="gt3_portfolio_info__item"><?php
                                                if (!empty($mb_portfolio_info_item['name'])) {
                                                    ?><h4 class="gt3_portfolio_info__item_title"><?php echo $mb_portfolio_info_item['name']; ?></h4><?php
                                                }
                                                ?><div class="gt3_portfolio_info__item_adding"><?php
                                                    if (!empty($mb_portfolio_info_item['address'])) {
                                                        ?><a href="<?php echo esc_url($mb_portfolio_info_item['address']); ?>"><?php
                                                    }
                                                    if (!empty($mb_portfolio_info_item['description'])) {
                                                        ?><div class="gt3_portfolio_info__item_text"><?php
                                                        echo $mb_portfolio_info_item['description'];
                                                        ?></div><?php
                                                    }
                                                    if (!empty($mb_portfolio_info_item['address'])) {
                                                        ?></a><?php
                                                    }
                                                ?></div><?php
                                            ?></div><?php
                                        }
                                    }
                                }
                                ?></div></div><?php

                            }
                        }

                    endwhile;
                    the_content(esc_html__('Read more!', 'gt3_core'));
                    if (true && rwmb_meta('mb_show_portfolio_post_footer') == '1') {
                        ?><div class="gt3_portfolio__footer"><?php
                            $post_tag = wp_get_post_terms(get_the_id(), 'portfolio-tag');
                            ?><div class="gt3_portfolio_info__item_tag_wrapper"><?php
                            for ($i=0; $i<count( $post_tag ); $i++) {
                                $post_tag_term = $post_tag[$i];
                                $post_tag_name = $post_tag_term->slug;
                                ?><a href="<?php echo esc_url(get_term_link($post_tag_term->term_id,'portfolio-tag')); ?>"><?php echo $post_tag_term->name; ?></a><?php
                            }
                            ?></div><?php

                            //portfolio like and comments count
                            ?><div class="gt3_portfolio__like_and_comments"><?php
                                if (gt3_option('portfolio_post_share')) {
                                    $mb_show_portfolio_facebook = rwmb_meta('mb_show_portfolio_facebook');
                                    $mb_show_portfolio_google = rwmb_meta('mb_show_portfolio_google');
                                    $mb_show_portfolio_twitter = rwmb_meta('mb_show_portfolio_twitter');
                                    $mb_show_portfolio_pinterest = rwmb_meta('mb_show_portfolio_pinterest');

                                    ?><ul class="gt3_portfolio_info__item_share"><?php
                                        if ($mb_show_portfolio_facebook == '1') {
                                            ?><li><a target="_blank" href="<?php echo esc_url('https://www.facebook.com/share.php?u='. get_permalink()); ?>" class="share_facebook"><span class="fa fa-facebook"></span><?php //echo esc_html_e('Facebook','gt3_core'); ?></a></li><?php
                                        }
                                        if ($mb_show_portfolio_twitter == '1') {
                                            ?><li><a target="_blank" href="<?php echo esc_url('https://twitter.com/intent/tweet?text='. get_the_title() .'&amp;url='. get_permalink()); ?>" class="share_twitter"><span class="fa fa-twitter"></span><?php //echo esc_html_e('Twitter','gt3_core'); ?></a></li><?php
                                        }
                                        if ($mb_show_portfolio_google == '1') {
                                            ?><li><a target="_blank" href="<?php echo 'https://plus.google.com/share?url='.urlencode(get_permalink()); ?>" class="share_gplus"><span class="fa fa-google-plus"></span><?php //echo esc_html_e('Google+','gt3_core'); ?></a></li><?php
                                        }
                                        if ($mb_show_portfolio_pinterest == '1' && has_post_thumbnail()) {
                                            ?><li><a target="_blank" href="<?php echo esc_url('https://pinterest.com/pin/create/button/?url=' . get_permalink() .'&media='. get_the_post_thumbnail());?>" class="share_pinterest"><span class="fa fa-pinterest"></span><?php //echo esc_html_e('Pinterest','gt3_core'); ?></a></li><?php
                                        }          
                                    ?></ul><?php
                                }
                                if (gt3_option('portfolio_likes')) {
                                    $all_likes = gt3pb_get_option("likes");
                                    wp_enqueue_script('jquery.cookie');
                                    if (isset($all_likes[get_the_ID()]) && $all_likes[get_the_ID()] == 1) {
                                        $likes_text_label = esc_html__('Like', 'gt3_wize_core');
                                    } else {
                                        $likes_text_label = esc_html__('Likes', 'gt3_wize_core');
                                    }
                                    ?>
                                    <div class="gt3_list__post_likes likes_block post_likes_add<?php echo isset($_COOKIE['like_post'.get_the_ID()]) ? ' already_liked' : ''; ?>" data-postid="<?php echo esc_attr(get_the_ID()); ?>"  data-modify="like_post">
                                        <span class="gt3_post_likes__icon fa fa-heart-o"></span>
                                        <span class="gt3_post_likes__value like_count" title="<?php echo (isset($all_likes[get_the_ID()]) ? $all_likes[get_the_ID()] : 0 ). ' ' . $likes_text_label; ?>"><?php echo ((isset($all_likes[get_the_ID()]) && $all_likes[get_the_ID()]>0) ? $all_likes[get_the_ID()] : 0);?></span></span>
                                    </div><?php
                                }
                                

                            ?></div><?php

                        ?></div><?php
                    }
                    the_post_navigation( array(
                        'prev_text' => '<span>' . __( 'Prev', 'gt3_wize_core' ) . '</span>',
                        'next_text' => '<span>' . __( 'Next', 'gt3_wize_core' ) . '</span>',
                    ));
                    wp_reset_postdata();

                    if ( (comments_open() || get_comments_number()) && gt3_option('portfolio_comments') == "1") :
                        comments_template();
                    endif;

                ?>
            </section>

        </div>
        <?php
        if ($layout == 'left' || $layout == 'right') {
            echo '<div class="sidebar-container span'.(12 - (int)$column).'">';
                if (is_active_sidebar( $sidebar )) {
                    echo "<aside class='sidebar'>";
                    dynamic_sidebar( $sidebar );
                    echo "</aside>";
                }
            echo "</div>";
        }
        ?>
    </div>
    
</div>

<?php
get_footer();