<?php
/**
 * Filas de totales del checkout (se refrescan por AJAX).
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
    return;
}

$ui = static function ( $key ) {
    return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : '';
};

$cart = WC()->cart;
?>
<div class="doro-checkout-summary__live">
    <div class="doro-checkout-summary__rows">
        <div class="doro-checkout-summary__row">
            <span><?php echo esc_html( $ui( 'doroshopping_ui_checkout_subtotal' ) ); ?></span>
            <span><?php wc_cart_totals_subtotal_html(); ?></span>
        </div>

        <?php foreach ( $cart->get_coupons() as $code => $coupon ) : ?>
            <div class="doro-checkout-summary__row cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                <span><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
                <span><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
            </div>
        <?php endforeach; ?>

        <?php
        if ( function_exists( 'doroshopping_render_checkout_shipping_rows' ) ) {
            doroshopping_render_checkout_shipping_rows();
        }
        ?>

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
        <?php echo esc_html( $ui( 'doroshopping_ui_checkout_tax_note' ) ); ?>
    </div>

    <div class="doro-checkout-summary__total">
        <span><?php echo esc_html( $ui( 'doroshopping_ui_checkout_total' ) ); ?></span>
        <strong><?php wc_cart_totals_order_total_html(); ?></strong>
    </div>
</div>
