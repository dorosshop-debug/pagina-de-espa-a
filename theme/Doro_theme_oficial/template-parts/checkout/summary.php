<?php
/**
 * Resumen lateral del checkout.
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
    return;
}

$cart = WC()->cart;
?>

<div class="doro-checkout-summary">
    <h2 class="doro-checkout-summary__title"><?php esc_html_e( 'Resumen', 'doroshopping' ); ?></h2>

    <div class="doro-checkout-summary__rows">
        <div class="doro-checkout-summary__row">
            <span><?php esc_html_e( 'Subtotal', 'doroshopping' ); ?></span>
            <span><?php wc_cart_totals_subtotal_html(); ?></span>
        </div>

        <?php foreach ( $cart->get_coupons() as $code => $coupon ) : ?>
            <div class="doro-checkout-summary__row cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                <span><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
                <span><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
            </div>
        <?php endforeach; ?>

        <?php if ( $cart->needs_shipping() && $cart->show_shipping() ) : ?>
            <?php do_action( 'woocommerce_review_order_before_shipping' ); ?>
            <?php wc_cart_totals_shipping_html(); ?>
            <?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
        <?php endif; ?>

        <?php foreach ( $cart->get_fees() as $fee ) : ?>
            <div class="doro-checkout-summary__row fee">
                <span><?php echo esc_html( $fee->name ); ?></span>
                <span><?php wc_cart_totals_fee_html( $fee ); ?></span>
            </div>
        <?php endforeach; ?>

        <?php if ( wc_tax_enabled() && ! $cart->display_prices_including_tax() ) : ?>
            <?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
                <?php foreach ( $cart->get_tax_totals() as $code => $tax ) : ?>
                    <div class="doro-checkout-summary__row tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                        <span><?php echo esc_html( $tax->label ); ?></span>
                        <span><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="doro-checkout-summary__row tax-total">
                    <span><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></span>
                    <span><?php wc_cart_totals_taxes_total_html(); ?></span>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <div class="doro-checkout-summary__tax-note">
        <?php esc_html_e( 'No se cobrarán impuestos adicionales al entregar', 'doroshopping' ); ?>
    </div>

    <div class="doro-checkout-summary__total">
        <span><?php esc_html_e( 'Total', 'doroshopping' ); ?></span>
        <strong><?php wc_cart_totals_order_total_html(); ?></strong>
    </div>

    <div class="doro-checkout-summary__place form-row place-order">
        <noscript>
            <?php
            printf(
                esc_html__( 'Como JavaScript está desactivado, debes hacer clic en “%1$s” antes de realizar el pedido. Ten en cuenta que se pueden aplicar tasas de envío adicionales a las mostradas.', 'doroshopping' ),
                esc_html__( 'Actualizar totales', 'woocommerce' )
            );
            ?>
            <br/><button type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e( 'Actualizar totales', 'woocommerce' ); ?>"><?php esc_html_e( 'Actualizar totales', 'woocommerce' ); ?></button>
        </noscript>

        <?php wc_get_template( 'checkout/terms.php' ); ?>

        <?php do_action( 'woocommerce_review_order_before_submit' ); ?>

        <?php echo apply_filters( 'woocommerce_order_button_html', '<button type="submit" class="button alt doro-checkout-summary__cta" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( __( 'Realizar pedido', 'doroshopping' ) ) . '" data-value="' . esc_attr( __( 'Realizar pedido', 'doroshopping' ) ) . '">' . esc_html( __( 'Realizar pedido', 'doroshopping' ) ) . '</button>' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

        <?php do_action( 'woocommerce_review_order_after_submit' ); ?>

        <?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
    </div>

    <p class="doro-checkout-summary__legal">
        <?php
        echo wp_kses_post(
            sprintf(
                /* translators: 1: terms URL, 2: privacy URL */
                __( 'Al realizar el pedido aceptas nuestros <a href="%1$s">términos y condiciones</a> y la <a href="%2$s">política de privacidad</a>.', 'doroshopping' ),
                esc_url( doroshopping_get_page_url( 'terminos-y-condiciones' ) ),
                esc_url( doroshopping_get_page_url( 'politica-de-privacidad' ) )
            )
        );
        ?>
    </p>
</div>
