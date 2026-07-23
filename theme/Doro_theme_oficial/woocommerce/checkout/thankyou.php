<?php
/**
 * Thank you / pedido recibido.
 *
 * @package Doroshopping
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;

$shop_url    = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
$account_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : home_url( '/' );
$orders_url  = ( function_exists( 'wc_get_endpoint_url' ) && $account_url )
    ? wc_get_endpoint_url( 'orders', '', $account_url )
    : $account_url;
?>

<div class="doro-thankyou">
    <?php if ( $order ) : ?>

        <?php if ( $order->has_status( 'failed' ) ) : ?>
            <div class="doro-thankyou__card doro-thankyou__card--error">
                <h1 class="doro-thankyou__title"><?php esc_html_e( 'El pago no se completó', 'doroshopping' ); ?></h1>
                <p class="doro-thankyou__text"><?php esc_html_e( 'Hubo un problema con tu pago. Puedes intentar de nuevo o contactar con soporte.', 'doroshopping' ); ?></p>
                <div class="doro-thankyou__actions">
                    <a class="doro-thankyou__btn doro-thankyou__btn--primary" href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>">
                        <?php esc_html_e( 'Reintentar pago', 'doroshopping' ); ?>
                    </a>
                    <a class="doro-thankyou__btn doro-thankyou__btn--ghost" href="<?php echo esc_url( $shop_url ); ?>">
                        <?php esc_html_e( 'Volver a la tienda', 'doroshopping' ); ?>
                    </a>
                </div>
            </div>
        <?php else : ?>
            <div class="doro-thankyou__card">
                <div class="doro-thankyou__icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12l3 3 5-6"/></svg>
                </div>
                <h1 class="doro-thankyou__title"><?php esc_html_e( '¡Gracias por tu compra!', 'doroshopping' ); ?></h1>
                <p class="doro-thankyou__text">
                    <?php
                    echo wp_kses_post(
                        sprintf(
                            /* translators: %s: order number */
                            __( 'Tu pedido %s se ha recibido correctamente. Te enviaremos actualizaciones por correo.', 'doroshopping' ),
                            '<strong>#' . esc_html( $order->get_order_number() ) . '</strong>'
                        )
                    );
                    ?>
                </p>

                <ul class="doro-thankyou__meta">
                    <li>
                        <span><?php esc_html_e( 'Número de pedido', 'doroshopping' ); ?></span>
                        <strong>#<?php echo esc_html( $order->get_order_number() ); ?></strong>
                    </li>
                    <li>
                        <span><?php esc_html_e( 'Fecha', 'doroshopping' ); ?></span>
                        <strong><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></strong>
                    </li>
                    <li>
                        <span><?php esc_html_e( 'Total', 'doroshopping' ); ?></span>
                        <strong><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></strong>
                    </li>
                    <li>
                        <span><?php esc_html_e( 'Método de pago', 'doroshopping' ); ?></span>
                        <strong><?php echo esc_html( $order->get_payment_method_title() ); ?></strong>
                    </li>
                </ul>

                <div class="doro-thankyou__actions">
                    <a class="doro-thankyou__btn doro-thankyou__btn--primary" href="<?php echo esc_url( $account_url ); ?>">
                        <?php esc_html_e( 'Ir a Mi cuenta', 'doroshopping' ); ?>
                    </a>
                    <a class="doro-thankyou__btn doro-thankyou__btn--secondary" href="<?php echo esc_url( $orders_url ); ?>">
                        <?php esc_html_e( 'Ver mis pedidos', 'doroshopping' ); ?>
                    </a>
                    <a class="doro-thankyou__btn doro-thankyou__btn--ghost" href="<?php echo esc_url( $shop_url ); ?>">
                        <?php esc_html_e( 'Seguir comprando', 'doroshopping' ); ?>
                    </a>
                </div>
            </div>

            <div class="doro-thankyou__details">
                <?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
                <?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
            </div>
        <?php endif; ?>

    <?php else : ?>
        <div class="doro-thankyou__card">
            <h1 class="doro-thankyou__title"><?php esc_html_e( '¡Gracias!', 'doroshopping' ); ?></h1>
            <p class="doro-thankyou__text"><?php esc_html_e( 'Tu pedido se ha procesado. Si tienes dudas, revisa Mi cuenta o contáctanos.', 'doroshopping' ); ?></p>
            <div class="doro-thankyou__actions">
                <a class="doro-thankyou__btn doro-thankyou__btn--primary" href="<?php echo esc_url( $account_url ); ?>">
                    <?php esc_html_e( 'Ir a Mi cuenta', 'doroshopping' ); ?>
                </a>
                <a class="doro-thankyou__btn doro-thankyou__btn--ghost" href="<?php echo esc_url( $shop_url ); ?>">
                    <?php esc_html_e( 'Volver a la tienda', 'doroshopping' ); ?>
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>
