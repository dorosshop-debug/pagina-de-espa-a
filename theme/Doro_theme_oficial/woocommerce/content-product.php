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
        <button
            type="button"
            class="doro-product-card__wish-btn"
            data-wishlist-toggle
            data-product-id="<?php echo esc_attr( (string) $product->get_id() ); ?>"
            aria-pressed="false"
            aria-label="<?php esc_attr_e( 'Anadir a lista de deseos', 'doroshopping' ); ?>"
        >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/></svg>
        </button>
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
