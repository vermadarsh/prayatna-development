<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product, $thumbnail_dim;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

//woocommerce_before_shop_loop_item
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);

// Add wrapper tag
add_action('woocommerce_after_shop_loop_item', 'gt3_open_controll_tag', 9);
add_action('woocommerce_after_shop_loop_item', 'gt3_close_controll_tag', 15);

// Add secondary thumbnail
add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 6);
add_action('woocommerce_before_shop_loop_item_title', 'gt3_wrapper_product_thumbnail_open', 7);
add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 8);
add_action('woocommerce_before_shop_loop_item_title', 'gt3_wrapper_product_thumbnail_close', 13);

//Add wrapper link to product
add_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 8 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
add_action('woocommerce_shop_loop_item_title', 'gt3_product_title_wrapper');
add_action('woocommerce_shop_loop_item_title', 'gt3_product_excerpt_wrapper');
add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 12);
add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 12 );


$gt3_classes = array();
?>
<li <?php wc_product_class( $gt3_classes, $product ); ?>>
	<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item_title', $product );
	/**
	 * Hook: woocommerce_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	do_action( 'woocommerce_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item' );
	?>
</li>
