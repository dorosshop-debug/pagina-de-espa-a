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

    <?php get_template_part( 'template-parts/checkout/summary-live' ); ?>

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
