<?php
/**
 * Plantilla del carrito WooCommerce (lleno o vacío).
 *
 * @package Doroshopping
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' );

$shop_url    = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
$account_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : wp_login_url();
$is_empty    = WC()->cart->is_empty();
$count       = WC()->cart->get_cart_contents_count();
?>

<div class="doro-cesta">
    <div class="doro-cesta__grid">
        <section class="doro-cesta__main" aria-label="<?php esc_attr_e( 'Cesta', 'doroshopping' ); ?>">
            <h1 class="doro-cesta__title"><?php esc_html_e( 'Cesta', 'doroshopping' ); ?></h1>

            <?php if ( $is_empty ) : ?>
                <?php wc_get_template( 'cart/cart-empty.php' ); ?>
            <?php else : ?>
                <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
                    <?php do_action( 'woocommerce_before_cart_table' ); ?>

                    <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="product-remove"><span class="screen-reader-text"><?php esc_html_e( 'Eliminar', 'doroshopping' ); ?></span></th>
                                <th class="product-thumbnail"><span class="screen-reader-text"><?php esc_html_e( 'Imagen', 'doroshopping' ); ?></span></th>
                                <th class="product-name"><?php esc_html_e( 'Producto', 'doroshopping' ); ?></th>
                                <th class="product-price"><?php esc_html_e( 'Precio', 'doroshopping' ); ?></th>
                                <th class="product-quantity"><?php esc_html_e( 'Cantidad', 'doroshopping' ); ?></th>
                                <th class="product-subtotal"><?php esc_html_e( 'Subtotal', 'doroshopping' ); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php do_action( 'woocommerce_before_cart_contents' ); ?>

                            <?php
                            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                                $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                                $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                                if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                                    $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                                    ?>
                                    <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
                                        <td class="product-remove">
                                            <?php
                                            echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                                'woocommerce_cart_item_remove_link',
                                                sprintf(
                                                    '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                                                    esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                                    esc_attr( sprintf( __( 'Eliminar %s del carrito', 'doroshopping' ), wp_strip_all_tags( $_product->get_name() ) ) ),
                                                    esc_attr( $product_id ),
                                                    esc_attr( $_product->get_sku() )
                                                ),
                                                $cart_item_key
                                            );
                                            ?>
                                        </td>
                                        <td class="product-thumbnail">
                                            <?php
                                            $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
                                            if ( ! $product_permalink ) {
                                                echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                            } else {
                                                printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                            }
                                            ?>
                                        </td>
                                        <td class="product-name" data-title="<?php esc_attr_e( 'Producto', 'doroshopping' ); ?>">
                                            <?php
                                            if ( ! $product_permalink ) {
                                                echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
                                            } else {
                                                echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                                            }
                                            do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );
                                            echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                            ?>
                                        </td>
                                        <td class="product-price" data-title="<?php esc_attr_e( 'Precio', 'doroshopping' ); ?>">
                                            <?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                        </td>
                                        <td class="product-quantity" data-title="<?php esc_attr_e( 'Cantidad', 'doroshopping' ); ?>">
                                            <?php
                                            if ( $_product->is_sold_individually() ) {
                                                $min_quantity = 1;
                                                $max_quantity = 1;
                                            } else {
                                                $min_quantity = 0;
                                                $max_quantity = $_product->get_max_purchase_quantity();
                                            }
                                            $product_quantity = woocommerce_quantity_input(
                                                array(
                                                    'input_name'   => "cart[{$cart_item_key}][qty]",
                                                    'input_value'  => $cart_item['quantity'],
                                                    'max_value'    => $max_quantity,
                                                    'min_value'    => $min_quantity,
                                                    'product_name' => $_product->get_name(),
                                                ),
                                                $_product,
                                                false
                                            );
                                            echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                            ?>
                                        </td>
                                        <td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'doroshopping' ); ?>">
                                            <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>

                            <?php do_action( 'woocommerce_cart_contents' ); ?>

                            <tr>
                                <td colspan="6" class="actions">
                                    <?php if ( wc_coupons_enabled() ) : ?>
                                        <div class="coupon">
                                            <label for="coupon_code" class="screen-reader-text"><?php esc_html_e( 'Cupón', 'doroshopping' ); ?></label>
                                            <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Código de cupón', 'doroshopping' ); ?>">
                                            <button type="submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="apply_coupon" value="<?php esc_attr_e( 'Aplicar cupón', 'doroshopping' ); ?>"><?php esc_html_e( 'Aplicar cupón', 'doroshopping' ); ?></button>
                                            <?php do_action( 'woocommerce_cart_coupon' ); ?>
                                        </div>
                                    <?php endif; ?>

                                    <button type="submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="update_cart" value="<?php esc_attr_e( 'Actualizar carrito', 'doroshopping' ); ?>"><?php esc_html_e( 'Actualizar carrito', 'doroshopping' ); ?></button>

                                    <?php do_action( 'woocommerce_cart_actions' ); ?>
                                    <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                                </td>
                            </tr>

                            <?php do_action( 'woocommerce_after_cart_contents' ); ?>
                        </tbody>
                    </table>

                    <?php do_action( 'woocommerce_after_cart_table' ); ?>
                </form>
            <?php endif; ?>
        </section>

        <aside class="doro-cesta__aside" aria-label="<?php esc_attr_e( 'Resumen', 'doroshopping' ); ?>">
            <?php get_template_part( 'template-parts/cart/summary', null, array( 'count' => $count, 'is_empty' => $is_empty ) ); ?>
            <?php get_template_part( 'template-parts/cart/trust' ); ?>
        </aside>
    </div>

    <?php get_template_part( 'template-parts/cart/recommendations' ); ?>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
