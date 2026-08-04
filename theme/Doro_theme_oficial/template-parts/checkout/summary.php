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

$ui = static function ( $key ) {
    return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : '';
};

$cart        = WC()->cart;
$place_order = $ui( 'doroshopping_ui_checkout_place_order' );
if ( '' === $place_order ) {
    $place_order = __( 'Realizar pedido', 'doroshopping' );
}

$legal_html = '';
if ( function_exists( 'doroshopping_ui_sprintf' ) ) {
    $legal_html = doroshopping_ui_sprintf(
        'doroshopping_ui_checkout_legal',
        esc_url( doroshopping_get_page_url( 'terminos-y-condiciones' ) ),
        esc_url( doroshopping_get_page_url( 'politica-de-privacidad' ) )
    );
}
if ( '' === $legal_html ) {
    $legal_html = sprintf(
        /* translators: 1: terms URL, 2: privacy URL */
        __( 'Al realizar el pedido aceptas nuestros <a href="%1$s">términos y condiciones</a> y la <a href="%2$s">política de privacidad</a>.', 'doroshopping' ),
        esc_url( doroshopping_get_page_url( 'terminos-y-condiciones' ) ),
        esc_url( doroshopping_get_page_url( 'politica-de-privacidad' ) )
    );
}
?>

<div class="doro-checkout-summary">
    <h2 class="doro-checkout-summary__title"><?php echo esc_html( $ui( 'doroshopping_ui_checkout_summary' ) ); ?></h2>

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
        <?php echo esc_html( $ui( 'doroshopping_ui_checkout_tax_note' ) ); ?>
    </div>

    <div class="doro-checkout-summary__total">
        <span><?php echo esc_html( $ui( 'doroshopping_ui_checkout_total' ) ); ?></span>
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

        <?php
        echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            'woocommerce_order_button_html',
            '<button type="submit" class="button alt doro-checkout-summary__cta" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $place_order ) . '" data-value="' . esc_attr( $place_order ) . '">' . esc_html( $place_order ) . '</button>'
        );
        ?>

        <?php do_action( 'woocommerce_review_order_after_submit' ); ?>

        <?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
    </div>

    <p class="doro-checkout-summary__legal">
        <?php echo wp_kses_post( $legal_html ); ?>
    </p>
</div>
