<?php
/**
 * The template for displaying product content within loops
 *
 * @package Doroshopping
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}
?>
<li <?php wc_product_class( 'doro-product-card', $product ); ?>>
    <?php
    /**
     * Hook: woocommerce_before_shop_loop_item.
     */
    do_action( 'woocommerce_before_shop_loop_item' );
    ?>

    <div class="doro-product-card__media">
        <?php
        /**
         * Hook: woocommerce_before_shop_loop_item_title.
         *
         * @hooked woocommerce_show_product_loop_sale_flash - 10
         * @hooked woocommerce_template_loop_product_thumbnail - 10
         */
        do_action( 'woocommerce_before_shop_loop_item_title' );
        ?>
    </div>

    <div class="doro-product-card__body">
        <?php
        /**
         * Hook: woocommerce_shop_loop_item_title.
         */
        do_action( 'woocommerce_shop_loop_item_title' );

        /**
         * Hook: woocommerce_after_shop_loop_item_title.
         *
         * @hooked woocommerce_template_loop_price - 5
         * @hooked doroshopping_loop_rating - 6
         * @hooked doroshopping_loop_product_title - 10
         */
        do_action( 'woocommerce_after_shop_loop_item_title' );
        ?>
    </div>

    <?php
    /**
     * Hook: woocommerce_after_shop_loop_item.
     *
     * @hooked woocommerce_template_loop_product_link_close - 5
     * @hooked woocommerce_template_loop_add_to_cart - 10
     */
    do_action( 'woocommerce_after_shop_loop_item' );
    ?>
</li>
