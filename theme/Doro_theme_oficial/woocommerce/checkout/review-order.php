<?php
/**
 * Review order — solo listado de productos (totales van al Resumen).
 *
 * @package Doroshopping
 */

defined( 'ABSPATH' ) || exit;
?>

<table class="shop_table woocommerce-checkout-review-order-table doro-checkout-products">
    <tbody>
        <?php
        do_action( 'woocommerce_review_order_before_cart_contents' );

        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                ?>
                <tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
                    <td class="product-thumbnail">
                        <?php echo apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'thumbnail' ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </td>
                    <td class="product-name">
                        <?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ); ?>
                        <?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">&times;&nbsp;' . esc_html( $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        <?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </td>
                    <td class="product-total">
                        <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </td>
                </tr>
                <?php
            }
        }

        do_action( 'woocommerce_review_order_after_cart_contents' );
        ?>
    </tbody>
</table>
