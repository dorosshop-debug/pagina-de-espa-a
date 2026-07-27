<?php
/**
 * Payment methods — sin botón de pedido (va en el Resumen).
 *
 * @package Doroshopping
 * @var array $available_gateways
 */

defined( 'ABSPATH' ) || exit;

if ( ! isset( $available_gateways ) ) {
    $available_gateways = WC()->payment_gateways()->get_available_payment_gateways();
}

if ( ! wp_doing_ajax() ) {
    do_action( 'woocommerce_review_order_before_payment' );
}
?>

<div id="payment" class="woocommerce-checkout-payment doro-checkout-payment">
    <?php if ( WC()->cart->needs_payment() ) : ?>
        <ul class="wc_payment_methods payment_methods methods">
            <?php
            if ( ! empty( $available_gateways ) ) {
                foreach ( $available_gateways as $gateway ) {
                    wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
                }
            } else {
                $no_gateways_msg = apply_filters(
                    'woocommerce_no_available_payment_methods_message',
                    WC()->customer->get_billing_country()
                        ? __( 'No hay métodos de pago disponibles. Contacta con la tienda.', 'doroshopping' )
                        : __( 'Introduce tu dirección para ver métodos de pago.', 'doroshopping' )
                );
                // Plugins (p. ej. Elementor) pueden devolver HTML; no escapar como texto plano.
                echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . wp_kses_post( $no_gateways_msg ) . '</li>';
            }
            ?>
        </ul>
    <?php endif; ?>
</div>

<?php
if ( ! wp_doing_ajax() ) {
    do_action( 'woocommerce_review_order_after_payment' );
}
?>
