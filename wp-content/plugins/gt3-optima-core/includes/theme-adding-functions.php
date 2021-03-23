<?php
// Adding functions for theme

remove_filter('pre_user_description', 'wp_filter_kses');

function gt3_types_init(){
    if (is_plugin_active('js_composer/js_composer.php')) {
        if (function_exists('gt3_shift_title_function')) {
            call_user_func('vc_add_shortcode_param','gt3_shift_title_position' , 'gt3_shift_title_function', get_template_directory_uri().'/core/vc/custom_types/js/gt3_shift_title.js');
        }
        if (function_exists('gt3_on_off_function')) {
            call_user_func('vc_add'.'_shortcode_param','gt3_on_off_function', get_template_directory_uri().'/core/vc/custom_types/js/gt3_on_off.js');
        }
        if (function_exists('gt3_packery_layout_select_function')) {
            call_user_func('vc_add'.'_shortcode_param','gt3_packery_layout_select' , 'gt3_packery_layout_select_function', get_template_directory_uri().'/core/vc/custom_types/js/gt3_packery_layout.js');
        }
        if (function_exists('gt3_image_select')) {
            call_user_func('vc_add'.'_shortcode_param','gt3_dropdown', 'gt3_image_select', get_template_directory_uri().'/core/vc/custom_types/js/gt3_image_select.js' );
        }
        if (function_exists('gt3_multi_select')) {
            call_user_func('vc_add'.'_shortcode_param','gt3-multi-select', 'gt3_multi_select', get_template_directory_uri().'/core/vc/custom_types/js/gt3_multi_select.js' );
        }
    }
}
add_action( 'init', 'gt3_types_init' );


function gt3_sort_place (){
    $mb_logo_position = rwmb_meta('mb_logo_position'); 
    $mb_menu_position = rwmb_meta('mb_menu_position'); 
    $mb_left_bar_position = rwmb_meta('mb_left_bar_position'); 
    $mb_right_bar_position = rwmb_meta('mb_right_bar_position');

    $mb_logo_order = rwmb_meta('mb_logo_order'); 
    $mb_menu_order = rwmb_meta('mb_menu_order');
    $mb_left_bar_order = rwmb_meta('mb_left_bar_order'); 
    $mb_right_bar_order = rwmb_meta('mb_right_bar_order'); 
    $positions = array(
        'logo' => $mb_logo_position,
        'menu' => $mb_menu_position,
        'left_bar' => $mb_left_bar_position,
        'right_bar' => $mb_right_bar_position
    );
    $sorting_array = array(
        'Left align side' => '',
        'Center align side' => '',
        'Right align side' => ''
    );
    foreach ($positions as $pos => $value) {
        switch ($value) {
            case 'left_align_side':
                $sorting_array['Left align side'][$pos] = ${'mb_'.$pos.'_order'};
                break;
            case 'center_align_side':
                $sorting_array['Center align side'][$pos] = $pos;
                break;
            case 'right_align_side':
                $sorting_array['Right align side'][$pos] = $pos;
                break;
        }
    }   
    foreach ($sorting_array as $key => $value) {
        if (is_array($sorting_array[$key])) {   
            asort($value);                         
            $sorting_array[$key] = $value;
        }
        $sorting_array[$key]['placebo'] = 'placebo';
    }                           
    return $sorting_array;
}
        


// out search shortcode
if (!function_exists('gt3_search_shortcode')) {
    function gt3_search_shortcode(){
        if (function_exists('gt3_option')) {
            $header_height = gt3_option('header_height');
        }
        $header_height = $header_height['height'];
        if (class_exists( 'RWMB_Loader' ) && get_queried_object_id() !== 0) {
            if (rwmb_meta('mb_customize_header_layout') == 'custom') {
                $header_height = rwmb_meta("mb_header_height");
            }
        }

        $search_style = '';
        $search_style .= !empty($header_height) ? 'height:'.$header_height.'px;' : '';
        $search_style = !empty($search_style) ? ' style="'.$search_style.'"' : '' ;
        

        $out = '<div class="header_search"'.$search_style.'>';
            $out .= '<div class="header_search__container">';
                $out .= '<div class="header_search__icon">';
                    $out .= '<i></i>';
                $out .= '</div>';            
                $out .= '<div class="header_search__inner">';
                    $out .= get_search_form(false);
                $out .= '</div>';
            $out .= '</div>';
        $out .= '</div>';
        return $out;
    }
    add_shortcode('gt3_search', 'gt3_search_shortcode');
}

if (!function_exists('gt3_menu_shortcode')) {
    function gt3_menu_shortcode(){
        if (function_exists('gt3_option')) {
            $header_height = gt3_option('header_height');
        }
        $header_height = $header_height['height'];
        if (class_exists( 'RWMB_Loader' ) && get_queried_object_id() !== 0) {
            if (rwmb_meta('mb_customize_header_layout') == 'custom') {
                $header_height = rwmb_meta("mb_header_height");
            }
        }

        $search_style = '';
        $search_style .= !empty($header_height) ? 'height:'.$header_height.'px;' : '';
        $search_style = !empty($search_style) ? ' style="'.$search_style.'"' : '' ;
        
        ob_start();
        if (has_nav_menu( 'top_header_menu' )) {
            echo "<nav class='top-menu main-menu main_menu_container'>";
                gt3_top_menu ();
            echo "</nav>";
            echo '<div class="mobile-navigation-toggle"><div class="toggle-box"><div class="toggle-inner"></div></div></div>';
        }
        $out = ob_get_clean();
        return !empty($out) ? $out : '';
    }
    add_shortcode('gt3_menu', 'gt3_menu_shortcode');
}

if (!function_exists('gt3_top_menu')) {
    function gt3_top_menu (){
        wp_nav_menu( array(
            'theme_location'  => 'top_header_menu',
            'container' => '',
            'container_class' => '',  
            'after' => '',
            'link_before'     => '<span>',
            'link_after'      => '</span>',            
            'walker' => ''
        ) );
    }
}

add_action('wp_head','gt3_wp_head_custom_code',1000);
function gt3_wp_head_custom_code() {
    // this code not only js or css / can insert any type of code
    
    if (function_exists('gt3_option')) {
        $header_custom_code = gt3_option('header_custom_js');
    }
    echo isset($header_custom_code) ? $header_custom_code : '';
}

add_action('wp_footer', 'gt3_custom_footer_js',1000);
function gt3_custom_footer_js() {
    if (function_exists('gt3_option')) {
        $custom_js = gt3_option('custom_js');
    }
    echo isset($custom_js) ? '<script type="text/javascript" id="gt3_custom_footer_js">'.$custom_js.'</script>' : '';
}

if (!function_exists('gt3_string_coding')) {
    function gt3_string_coding($code){
        if (!empty($code)) {
            return base64_encode($code);
        }   
        return;     
    }
}

function gt3_portfolio_team_query_var( $vars ){
    $vars[] = "portfolio_term_id";
    $vars[] = "team_term_id";
    return $vars;
}
add_filter( 'query_vars', 'gt3_portfolio_team_query_var' );

add_image_size( 'gt3-admin-post-featured-image', 120, 120, true );
add_filter('manage_portfolio_posts_columns', 'gt3_add_post_admin_thumbnail_column', 2);
add_filter('manage_team_posts_columns', 'gt3_add_post_admin_thumbnail_column', 2);
add_filter('manage_post_posts_columns', 'gt3_add_post_admin_thumbnail_column', 2);

function gt3_add_post_admin_thumbnail_column($gt3_columns){
    $gt3_columns['post_thumb'] = __('Featured Image','gt3_core');
    return $gt3_columns;
}

add_action('manage_portfolio_posts_custom_column', 'gt3_show_post_thumbnail_column', 5, 2);
add_action('manage_team_posts_custom_column', 'gt3_show_post_thumbnail_column', 5, 2);
add_action('manage_post_posts_custom_column', 'gt3_show_post_thumbnail_column', 5, 2);

function gt3_show_post_thumbnail_column($gt3_columns, $portfolio_id){
    switch($gt3_columns){
        case 'post_thumb':
            if( function_exists('the_post_thumbnail') ) {
                echo the_post_thumbnail( 'gt3-admin-post-featured-image' );
            }
            else
                echo 'hmm... your theme doesn\'t support featured image...';
            break;
    }
}
