<?php
/**
 * Result Count
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/result-count.php.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @author      GT3
 * @package     WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $products;
 ?>

<p class="woocommerce-result-count">
    <?php
    $paged    = max( 1, $products->get( 'paged' ) );
    $per_page = $products->get( 'posts_per_page' );
    $total    = $products->found_posts;
    $first    = ( $per_page * $paged ) - $per_page + 1;
    $last     = min( $total, $products->get( 'posts_per_page' ) * $paged );

    if ( $total <= $per_page || -1 === $per_page ) {
        /* translators: %d: total results */
        printf( _n( 'Showing the single result', 'Showing all %d results', $total, 'optima' ), $total );
    } else {
        /* translators: 1: first result 2: last result 3: total results */
        printf( _nx( 'Showing the single result', 'Showing %1$d&ndash;%2$d of %3$d results', $total, 'with first and last result', 'optima' ), $first, $last, $total );
    }
    ?>
</p>