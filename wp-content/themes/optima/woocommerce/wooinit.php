<?php

// declare woocommerce custom theme stylesheets and js
function wp_enqueue_woocommerce_style() {
    wp_register_style( 'woocommerce', get_template_directory_uri() . '/woocommerce/css/woocommerce.css' );
    wp_enqueue_style( 'woocommerce' );
}
add_action( 'wp_enqueue_scripts', 'wp_enqueue_woocommerce_style' );

function css_js_woocomerce() {
    wp_enqueue_script('gt3_main_woo_js', get_template_directory_uri() . '/woocommerce/js/theme-woo.js', array(), false, false);
    wp_enqueue_script('gt3_slick_js', get_template_directory_uri() . '/js/slick.min.js', array(), false, false);
    wp_enqueue_script('gt3_zoom', get_template_directory_uri() . '/woocommerce/js/easyzoom.js', array('jquery'), false, false);
    if (class_exists( 'WC_List_Grid' )) {
        global $WC_List_Grid;
        add_action( 'wp_enqueue_scripts', array( $WC_List_Grid, 'setup_scripts_styles' ), 20);
    }
}
add_action('wp_enqueue_scripts', 'css_js_woocomerce');
// end of declare woocommerce custom theme stylesheets and js

// Remove action if ListGrid Plugin is active
if (class_exists('WC_List_Grid')) {
    function gt3_remove_plugin_actions(){
        global $WC_List_Grid;

        // Remove ListGrid plugin defaul wrapper in product
        remove_action( 'woocommerce_after_shop_loop_item', array( $WC_List_Grid, 'gridlist_buttonwrap_open' ), 9);
        remove_action( 'woocommerce_after_shop_loop_item', array( $WC_List_Grid, 'gridlist_buttonwrap_close' ), 11);
        remove_action( 'woocommerce_after_shop_loop_item', array( $WC_List_Grid, 'gridlist_hr' ), 30);

        add_action('woocommerce_shortcode_after_recent_products_loop', 'woocommerce_pagination', 10);
    }
    add_action('woocommerce_archive_description','gt3_remove_plugin_actions');
}


function gt3_open_controll_tag () {
	echo '<div class="gt3_woocommerce_open_controll_tag">';
}

function gt3_close_controll_tag () {
	echo '</div>';
}

function gt3_wrapper_product_thumbnail_open () {
	echo '<div class="gt3-product-thumbnail-wrapper">';
}

function gt3_wrapper_product_thumbnail_close () {
	echo '</div>';
}

function gt3_product_title_wrapper () {
    echo '<h3 class="gt3-product-title">'.get_the_title().'</h3>';
}

// GT3 Product Excerpt
add_action('woocommerce_single_product_summary', 'gt3_product_excerpt_wrapper', 6);
function gt3_product_excerpt_wrapper () {
    global $product;
    $product_excerpt = get_post_meta( $product->get_id(), '_product_excerpt', true );
    if ( strlen($product_excerpt) > 0 ) {
        $by_author = '';
        if (is_single() && get_post_type() == 'product') {
            $by_author = ''.esc_html__('by', 'optima').' ';
        }
        echo '<div class="gt3-product-excerpt">' . $by_author . $product_excerpt . '</div>';
    }
}

function gt3_product_image_wrap_open () {
    echo '<div class="gt3-product-image-wrapper">';
}

function gt3_product_image_wrap_close () {
    echo '</div>';
}

// Pagination Arrows change to custom
function gt3_change_pagination ($args) {
    $args['prev_text'] = '<i class="fa fa-angle-double-left"></i>';
    $args['next_text'] = '<i class="fa fa-angle-double-right"></i>';
    return $args;
}
add_filter('woocommerce_pagination_args', 'gt3_change_pagination', 30, 1);

function gt3_add_label_outofstock () {
    global $product;
    if (!($product->is_in_stock())) {
        $woocommerce_out_of_stock = gt3_option('woocommerce_out_of_stock');
        if ( $woocommerce_out_of_stock ) {
            echo '<a href="'.esc_url( get_the_permalink() ).'" class="gt3-product-outofstock"><span class="gt3-product-outofstock__inner">'.esc_html__('Out Of Stock', 'optima').'</span></a>';
        } else{
            echo '<div class="gt3-product-outofstock"><span class="gt3-product-outofstock__inner">'.esc_html__('Out Of Stock', 'optima').'</span></div>';
        }
    }
}
add_action('woocommerce_before_shop_loop_item_title', 'gt3_add_label_outofstock', 6);

// Remove woocommerce breadcrumb
remove_action('woocommerce_before_main_content','woocommerce_breadcrumb', 20);
//add breadcrumb to single product
if (gt3_option('shop_title_conditional') != '1' && gt3_option('page_title_breadcrumbs_conditional') == '1' && gt3_option('page_title_conditional') == '1' ) {
    add_action('woocommerce_single_product_summary','woocommerce_breadcrumb', 4);
}
if (gt3_option('shop_title_conditional') == '1' && gt3_option('page_title_conditional') == '1') {
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
}


add_action( 'yith_wcqv_product_image', 'gt3_product_image_wrap_open', 9 );
add_action( 'yith_wcqv_product_image', 'gt3_product_image_wrap_close', 21 );



function gt3_add_thumb_wcqv () {
    add_action('woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 25);
}
add_action( 'wp_ajax_yith_load_product_quick_view', "gt3_add_thumb_wcqv", 1);
add_action( 'wp_ajax_nopriv_yith_load_product_quick_view', 'gt3_add_thumb_wcqv',1 );

//Replace Ratings in popup
remove_action( 'yith_wcqv_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'yith_wcqv_product_summary', 'woocommerce_template_single_rating', 4 );

remove_action( 'yith_wcqv_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'yith_wcqv_product_summary', 'woocommerce_template_single_meta', 30 );
add_action( 'yith_wcqv_product_summary', 'woocommerce_template_single_meta', 17 );


function gt3_add_instock () {
    global $product;

    $availability      = $product->get_availability();
    $availability_icon = $availability['class'] === "in-stock" ? '<i class="fa fa-check"></i>' : '';
    $availability_html = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . $availability_icon . esc_html( $availability['availability'] ) . '</p>';
    echo (($availability_html));
}
add_action( 'yith_wcqv_product_summary', 'gt3_add_instock', 16 );
add_action( 'woocommerce_single_product_summary', 'gt3_add_instock', 11 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 25 );

function gt3_remove_stockhtml ($content) {
    return '';
}
add_filter( 'woocommerce_get_stock_html', 'gt3_remove_stockhtml');


/* Woocomerce Template */
add_filter( 'woocommerce_show_page_title', '__return_false' );

// set custom count pro
function gt3_products_per_page () {
    $products_count = gt3_option('products_per_page');
    $products_count = !empty($products_count) ? $products_count : 9;
    return $products_count;
}
add_filter(  'loop_shop_per_page', 'gt3_products_per_page', 20 );

function gt3_page_template () {

    switch (is_single()) {
        case true:
            $layout = gt3_option('product_sidebar_layout');
            $sidebar = gt3_option('product_sidebar_def');
            break;
        case false:
            $layout = gt3_option('products_sidebar_layout');
            $sidebar = gt3_option('products_sidebar_def');
            break;
        default:
            $layout = gt3_option('products_sidebar_layout');
            $sidebar = gt3_option('products_sidebar_def');
    }
    if (class_exists( 'RWMB_Loader' ) && get_queried_object_id() !== 0 && !(class_exists('WooCommerce') && is_product_category())) {
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
    $row_class = ' sidebar_'.esc_attr($layout);

    $class_columns = '';
    if ( !is_single() && get_post_type() == 'product') {
        global $woocommerce_loop;
        $columns = gt3_option('woocommerce_def_columns');
        $columns = empty($columns) ? 4 : $columns;
        $columns                     = absint( $columns );
        $woocommerce_loop['columns'] = $columns;

        $class_columns = 'class="woocommerce columns-'.esc_attr($columns).'"';
    }

    $container_class = 'container';

    ?>

    <div class="<?php echo esc_html($container_class) ?>">
        <div class="row<?php echo esc_attr($row_class); ?>">
            <div class="content-container span<?php echo (int)$column; ?>">
                <section id='main_content' <?php echo esc_attr($class_columns); ?> >
    <?php
}
add_action('woocommerce_before_main_content', 'gt3_page_template', 9);

// add bottom part of page template
function gt3_page_template_close () {
    switch (is_single()) {
        case true:
            $layout = gt3_option('product_sidebar_layout');
            $sidebar = gt3_option('product_sidebar_def');
            break;
        case false:
            $layout = gt3_option('products_sidebar_layout');
            $sidebar = gt3_option('products_sidebar_def');
            break;
        default:
            $layout = gt3_option('products_sidebar_layout');
            $sidebar = gt3_option('products_sidebar_def');
    }
    if (class_exists( 'RWMB_Loader' ) && get_queried_object_id() !== 0 && !(class_exists('WooCommerce') && is_product_category())) {
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
}
add_action('woocommerce_after_main_content', 'gt3_page_template_close', 11);

/* Woocommerce Template */


/* Products Page filter bar */
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
add_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10 );

function gt3_woo_header_products_open () {
    echo '<div class="gt3-products-header">';
}
function gt3_woo_header_products_close () {
    echo '</div>';
}
add_action('woocommerce_before_shop_loop', 'gt3_woo_header_products_open', 9);
add_action('woocommerce_before_shop_loop', 'gt3_woo_header_products_close', 35);

/* ! Products Page filter bar */


/* zoom image */
function gt3_wrapper_zoom ($content) {
    global $post, $product;
    $attachment_ids = $product->get_gallery_image_ids();
    $thumb_str = '';
    if ( $attachment_ids ) {
        $loop = 0;
        $columns = 1;
        foreach ( $attachment_ids as $attachment_id ) {

            $classes = array( 'zoom' );

            if ( $loop === 0 || $loop % $columns === 0 ) {
                $classes[] = 'first';
            }

            if ( ( $loop + 1 ) % $columns === 0 ) {
                $classes[] = 'last';
            }

            $image_class = implode( ' ', $classes );
            $props       = wc_get_product_attachment_props( $attachment_id, $post );

            if ( ! $props['url'] ) {
                continue;
            }

            $thumb_str .= sprintf(
                    '<div class="easyzoom"><a href="%s" class="%s" title="%s" data-rel="prettyPhoto[product-gallery]">%s</a></div>',
                    esc_url( $props['url'] ),
                    esc_attr( $image_class ),
                    esc_attr( $props['caption'] ),
                    wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'full' ), 0, $props )
                );

            $loop++;
        }
    }

    return '<div class="gt3-single-woo-slick"><div class="easyzoom">'.$content.'</div>'.$thumb_str.'</div>';
}
add_filter('woocommerce_single_product_image_html', 'gt3_wrapper_zoom', 30, 1);

/* !zoom image */

add_filter( 'woocommerce_output_related_products_args', 'gt3_related_products_args' );
function gt3_related_products_args( $args ) {
    $args['posts_per_page'] = 3; // 3 related products
    $args['columns'] = 3; // arranged in 3 columns
    return $args;
}

/* Add image size for masonry product listing */
if( !function_exists( 'gt3_filter_single_product_archive_thumbnail_size' )){
    function gt3_filter_single_product_archive_thumbnail_size( $size ) {
        global $thumbnail_dim;
        $size = $thumbnail_dim;
        return $size;
    };
}
/* ! Add image size for masonry product listing */


/**/
/********** AFTER UPDATE WOOO ******************/
/**/
function gt3_wrap_single_product_open () {
    echo '<div class="gt3-single-content-wrapper">';
}
function gt3_wrap_single_product_close () {
    echo '</div>';
}
function gt3_add_sticky_parent_open () {
    echo '<div class="gt3-single-product-sticky">';
}
function gt3_add_sticky_parent_close () {
    echo '</div>';
}
// Add theme support for single product
function gt3_add_single_product_opts () {
    add_image_size( 'gt3_540x600', 540, 600, true );
    add_image_size( 'gt3_442x350', 442, 350, true );
    add_image_size( 'gt3_442x730', 442, 730, true );
    add_image_size( 'gt3_912x730', 912, 730, true );

    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-slider');
    add_theme_support('wc-product-gallery-lightbox');
}
add_action('after_setup_theme','gt3_add_single_product_opts');


// add vertical thumbnails options
function gt3_option_thumbnail_slider () {
    return array(
        'rtl'            => is_rtl(),
        'animation'      => "fade",
        'smoothHeight'   => false,
        'directionNav'   => false,
        'controlNav'     => 'thumbnails',
        'slideshow'      => false,
        'animationSpeed' => 500,
        'animationLoop'  => false, // Breaks photoswipe pagination if true.
    );
}
add_filter('woocommerce_single_product_carousel_options', 'gt3_option_thumbnail_slider');

function gt3_get_template ($tmpl, $extension = NULL) {
    get_template_part( 'woocommerce/gt3-templates/' . $tmpl, $extension );
}

remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display' );

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
add_action("woocommerce_product_thumbnails", "woocommerce_show_product_sale_flash", 5);

/* Add next/prev buttons on single product */
if ( (bool) gt3_option( 'next_prev_product' ) && class_exists( 'GT3_WooCommerce_Adjacent_Products' ) ) {
	add_action( 'woocommerce_after_single_product_summary', 'gt3_prev_next_product', 17 );
	function gt3_prev_next_product() {
		// Show only products in the same category?
		$in_same_term   = apply_filters( 'gt3_single_product_pagination_same_category', true );
		$excluded_terms = apply_filters( 'gt3_single_product_pagination_excluded_terms', '' );
		$taxonomy       = apply_filters( 'gt3_single_product_pagination_taxonomy', 'product_cat' );

		$previous_product = gt3_get_previous_product( $in_same_term, $excluded_terms, $taxonomy );
		$next_product     = gt3_get_next_product( $in_same_term, $excluded_terms, $taxonomy );

		if ( ! $previous_product && ! $next_product ) {
			return;
		}

		?>
        <ul class='gt3_product_list_nav'>
		<?php if ( $previous_product ) : ?>
            <li>
                <a href="<?php echo esc_url( $previous_product->get_permalink() ); ?>" rel="prev">
					<?php
					if ( apply_filters( 'gt3_next_prev_product_img', true ) ) {
						echo '<div class="product_list_nav_thumbnail">';
						echo wp_kses_post( $previous_product->get_image() );
						echo '</div>';
					}

					echo '<div class="product_list_nav_text">';
					echo '<span class="nav_title">';
					echo wp_kses_post( $previous_product->get_name() );
					echo '</span>';
					echo '<span class="nav_text">'.esc_html__('PREV', 'optima').'</span>';
					echo '<span class="nav_price">'. wp_kses_post( $previous_product->get_price_html() ).'</span>';
					echo '</div>';
					?>
                </a>
            </li>
		<?php endif; ?>

		<?php if ( $next_product ) : ?>
            <li>
                <a href="<?php echo esc_url( $next_product->get_permalink() ); ?>" rel="next">
					<?php
					if ( apply_filters( 'gt3_next_prev_product_img', true ) ) {
						echo '<div class="product_list_nav_thumbnail">';
						echo wp_kses_post( $next_product->get_image() );
						echo '</div>';
					}

					echo '<div class="product_list_nav_text">';
					echo '<span class="nav_title">';
					echo wp_kses_post( $next_product->get_name() );
					echo '</span>';
					echo '<span class="nav_text">'.esc_html__('NEXT', 'optima').'</span>';
					echo '<span class="nav_price">'. wp_kses_post( $next_product->get_price_html() ).'</span>';
					echo '</div>';
					?>
                </a>
            </li>
		<?php endif; ?>
        </ul><?php
	}
}
function gt3_get_previous_product( $in_same_term = false, $excluded_terms = '', $taxonomy = 'product_cat' ) {
	$product = new GT3_WooCommerce_Adjacent_Products( $in_same_term, $excluded_terms, $taxonomy, true );
	return $product->get_product();
}
function gt3_get_next_product( $in_same_term = false, $excluded_terms = '', $taxonomy = 'product_cat' ) {
	$product = new GT3_WooCommerce_Adjacent_Products( $in_same_term, $excluded_terms, $taxonomy );
	return $product->get_product();
}

// Wishlist button moving
if ( class_exists( 'YITH_WCWL_Shortcode' ) && get_option('yith_wcwl_enabled') == true && get_option('yith_wcwl_button_position') == 'add-to-cart') {
    function output_wishlist_button() {
        echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
    }
    add_action('woocommerce_after_add_to_cart_quantity', 'output_wishlist_button', 5);
}

add_action( 'template_redirect', 'yith_wcqv_remove_from_wishlist' );
function yith_wcqv_remove_from_wishlist(){
    if( function_exists( 'YITH_WCQV_Frontend' ) && defined('YITH_WCQV_FREE_INIT') ) {
        remove_action( 'yith_wcwl_table_after_product_name', array( YITH_WCQV_Frontend(), 'yith_add_quick_view_button' ), 15 );
    }
}

// Add Hot/New label for product
add_action( 'woocommerce_product_options_general_product_data', 'woo_add_custom_general_field' );
add_action( 'woocommerce_process_product_meta', 'woo_add_custom_general_fields_save' );
function woo_add_custom_general_field() {
    global $woocommerce, $post;

    echo '<div class="options_group">';
    woocommerce_wp_checkbox( array(
        'id'            => '_checkbox_hot',
        'label'         => esc_html__( 'Hot Product', 'optima' ),
        'description'   => esc_html__( 'Check for Hot Product', 'optima' )
    ) );
    woocommerce_wp_checkbox( array(
        'id'            => '_checkbox_new',
        'label'         => esc_html__( 'New Product', 'optima' ),
        'description'   => esc_html__( 'Check for New Product', 'optima' )
    ) );
    woocommerce_wp_text_input( array(
        'id'            => '_product_excerpt',
        'label'         => esc_html__( 'Product excerpt', 'optima' ),
        'description'   => ''
    ) );
    echo '</div>';
}
function woo_add_custom_general_fields_save( $post_id )
{
    $woocommerce_checkbox = isset($_POST['_checkbox_hot']) ? 'yes' : 'no';
    update_post_meta($post_id, '_checkbox_hot', $woocommerce_checkbox);

    $woocommerce_checkbox = isset($_POST['_checkbox_new']) ? 'yes' : 'no';
    update_post_meta($post_id, '_checkbox_new', $woocommerce_checkbox);

    $woocommerce_text_field = $_POST['_product_excerpt'];

    if (!empty($woocommerce_text_field)) {
        update_post_meta($post_id, '_product_excerpt', $woocommerce_text_field);
    }
}

add_action('woocommerce_product_thumbnails','gt3_hot_new_product', 30);
add_action('woocommerce_before_shop_loop_item_title','gt3_hot_new_product', 7);
add_action('yith_wcqv_product_image', 'gt3_hot_new_product', 10 );
add_action('gt3_hot_new_label_product','gt3_hot_new_product', 10);
function gt3_hot_new_product(){
    global $product;

    $is_hot = get_post_meta( $product->get_id(), '_checkbox_hot', true );
    if ( 'yes' == $is_hot ) {
        echo '<span class="onsale hot-product">'.esc_html__('Hot','optima').'</span>';
    }

    $is_new = get_post_meta( $product->get_id(), '_checkbox_new', true );
    if ( 'yes' == $is_new ) {
        echo '<span class="onsale new-product">'.esc_html__('New','optima').'</span>';
    }
}

// Social Links
add_action('woocommerce_single_product_summary', 'gt3_get_social_links', 75);
function gt3_get_social_links() {
    $share_social = gt3_option('share_social');
    if ($share_social != 1) return;

    $share_social_select = gt3_option('share_social_select');
    $compile = '';
    if (!empty($share_social_select)) {
        foreach ($share_social_select as $gt3_social_data) {
            $links_array[] = gt3_build_share_button($gt3_social_data);
        }
        $compile  = '<div class="product_share">';
            $compile .= '<a href="#">'.esc_html__('SHARE','optima').'</a>';
            $compile .= '<div class="gt3_social_links">'.implode('', $links_array).'</div>';
        $compile .= '</div>';
    }
    echo (($compile));
}
function gt3_build_share_button($gt3_social_data) {
    $share_social_facebook  = gt3_option('share_social-facebook');
    $share_social_twitter   = gt3_option('share_social-twitter');
    $share_social_pinterest = gt3_option('share_social-pinterest');
    $share_social_google    = gt3_option('share_social-google');
    $share_social_linkedin  = gt3_option('share_social-linkedin');
    $share_social_vk        = gt3_option('share_social-vk');
    $share_social_tumblr    = gt3_option('share_social-tumblr');
    $share_social_mail      = gt3_option('share_social-mail');
    $share_social_reddit    = gt3_option('share_social-reddit');

    $icon_lib = array(
        'facebook'  => 'facebook',
        'twitter'   => 'twitter',
        'pinterest' => 'pinterest',
        'google'    => 'google-plus',
        'linkedin'  => 'linkedin',
        'vk'        => 'vk',
        'tumblr'    => 'tumblr',
        'mail'      => 'envelope',
        'reddit'    => 'reddit',
    );
    $gt3_social_title = array(
        'facebook'  => $share_social_facebook,
        'twitter'   => $share_social_twitter,
        'pinterest' => $share_social_pinterest,
        'google'    => $share_social_google,
        'linkedin'  => $share_social_linkedin,
        'vk'        => $share_social_vk,
        'tumblr'    => $share_social_tumblr,
        'mail'      => $share_social_mail,
        'reddit'    => $share_social_reddit,
    );
    $title = esc_attr($gt3_social_title[$gt3_social_data]);
    $title = !empty($title) || $title !== '' ? '<span>'.$title.'</span>' : '' ;


    return '<a class="gt3_social_icon" data-service="'.esc_attr($gt3_social_data).'" data-postID="'.get_the_ID().'" href="'.gt3_get_social_url($gt3_social_data).'" target="_blank" data-href='.urlencode(get_permalink()).'">
                <i class="fa fa-'.esc_attr($icon_lib[$gt3_social_data]).'"></i>'
                .$title.
            '</a>';
}
function gt3_get_social_url($gt3_social_data) {
    global $post;
    $text = urlencode(esc_html__('A great post: ', 'optima').$post->post_title);
    $escaped_url = urlencode(get_permalink());
    $image = has_post_thumbnail( $post->ID ) ? wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-thumbnail' ) : '';

    switch ($gt3_social_data) {
        case 'twitter' :
            $api_link = 'https://twitter.com/intent/tweet?source=webclient&amp;original_referer='.$escaped_url.'&amp;text='.esc_attr($text).'&amp;url='.$escaped_url;
            break;

        case 'facebook' :
            $api_link = 'https://www.facebook.com/sharer.php?u='.$escaped_url;
            break;

        case 'google' :
            $api_link = 'https://plus.google.com/share?url='.$escaped_url;
            break;

        case 'pinterest' :
            if (isset($image) && $image != '') {
                $api_link = 'http://pinterest.com/pin/create/bookmarklet/?media='.esc_url($image[0]).'&amp;url='.$escaped_url.'&amp;title='.rawurlencode(esc_attr(get_the_title())).'&amp;description='.rawurlencode(esc_html( $post->post_excerpt ));
            }
            else {
                $api_link = "javascript:void((function(){var%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)})());";
            }
            break;

        case 'tumblr' :
            $api_link = 'https://www.tumblr.com/widgets/share/tool?canonicalUrl='.$escaped_url.'&title='.$text;
            break;

        case 'mail' :
            $subject = esc_html__('Check this!', 'optima');
            $body = esc_html__('See more at: ', 'optima');
            $api_link = 'mailto:?subject='.str_replace('&amp;','%26',rawurlencode($subject)).'&body='.str_replace('&amp;','%26',rawurlencode($body).$escaped_url);
            break;

        case 'reddit' :
            $api_link = '//www.reddit.com/submit?url='.$escaped_url;
            break;

        case 'linkedin' :
            $api_link = 'https://www.linkedin.com/shareArticle?mini=true&url='.$escaped_url.'&title='.$text;
            break;

        case 'vk' :
            $api_link = 'http://vk.com/share.php?url='.$escaped_url.'&title='.$text.'&noparse=true';
            break;

    }
    return $api_link;
}

remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

//GT3 Products Grid Thumb parent wrap
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

function gt3_template_div(){
    echo '<div class="gt3-product_parent_wrapper">';
}
add_action('woocommerce_before_shop_loop_item_title', 'gt3_template_div', 6);

function gt3_template_div_product_links_wrap(){
    echo '<div class="gt3-template_div_product_links_wrap">';
}
function gt3_template_div_product_links_wrap_close(){
    echo '</div>';
}
add_action('woocommerce_before_shop_loop_item_title', 'gt3_template_div_product_links_wrap', 14);

add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 15);

add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 16);
function gt3_template_loop_product_link(){
    esc_html_e('Learn More','optima');
}
add_action('woocommerce_before_shop_loop_item_title', 'gt3_template_loop_product_link', 16);
add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 16);

function gt3_template_div_close(){
    echo '</div>';
}
add_action('woocommerce_before_shop_loop_item_title', 'gt3_template_div_close', 16);

add_action('woocommerce_before_shop_loop_item_title', 'gt3_template_div_product_links_wrap_close', 17);

add_filter( 'woocommerce_product_tabs', 'gt3_rename_tabs', 98 );
function gt3_rename_tabs( $tabs ) {
    $tabs['additional_information']['title'] = esc_html__('Additional Info','optima');  // Rename the additional information tab
    return $tabs;
}

add_filter( 'woocommerce_breadcrumb_defaults', 'jk_woocommerce_breadcrumbs' );
function jk_woocommerce_breadcrumbs() {
    return array(
        'delimiter'   => '<span class="delimiter">></span>',
        'wrap_before' => '<nav class="woocommerce-breadcrumb" itemprop="breadcrumb">',
        'wrap_after'  => '</nav>',
        'before'      => '',
        'after'       => '',
        'home'        => _x( 'Home', 'breadcrumb', 'optima' ),
    );
}