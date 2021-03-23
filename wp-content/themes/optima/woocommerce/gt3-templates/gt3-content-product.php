<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $grid_style, $thumbnail_dim, $animation_class;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

//woocommerce_before_shop_loop_item
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);

// Add wrapper tag
add_action('woocommerce_after_shop_loop_item', 'gt3_open_controll_tag', 9);
add_action('woocommerce_after_shop_loop_item', 'gt3_close_controll_tag', 15);

$gt3_classes = array();

// Get masonry settings
switch ($thumbnail_dim) {
	case 'gt3_912x730':
		array_push( $gt3_classes, 'large' );
		break;
	case 'gt3_442x730':
		array_push( $gt3_classes, 'large_vertical' );
		break;
	default:
		break;
}

?>
<li <?php post_class($gt3_classes); ?>>
	<div class="gt3-animation-wrapper <?php echo esc_attr($animation_class); ?>">
		<?php echo gt3_add_label_outofstock(); ?>
		<?php echo woocommerce_show_product_loop_sale_flash(); ?>
		<?php do_action('gt3_hot_new_label_product');  // gt3_hot_new_product - 10 ?>
		<div class="gt3-product-thumbnail-wrapper">
			<a href="<?php echo get_the_permalink(); ?>" class="woocommerce-LoopProduct-link">
				<?php
				if ($grid_style !== "grid_packery") {
					do_action('gt3_before_shop_thumbnail', $product, $thumbnail_dim);
					echo woocommerce_get_product_thumbnail($thumbnail_dim);
				} else {
					if ( has_post_thumbnail() ) {
						$url = get_the_post_thumbnail_url(get_the_ID());
					} elseif ( wc_placeholder_img_src() ) {
						$url = wc_placeholder_img_src();
					}
					echo '<span class="gt3-product__packery-thumb" style="background-image:url('.$url.')"></span>';
				}
				?>
			</a>
		</div>
		
		<div class="gt3-product-info">
			<a href="<?php echo get_the_permalink();?>" class="woocommerce-LoopProduct-link">
				<h3 class="gt3-product-title"><?php echo get_the_title(); ?></h3>
			</a>
			<?php
			echo woocommerce_template_loop_price(); 
			echo woocommerce_template_single_excerpt();
			do_action( 'woocommerce_after_shop_loop_item' );
			?>
		</div>
	</div>
</li>
