<?php
/**
 * Thank you / pedido recibido.
 *
 * @package Doroshopping
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;

$ui = static function ( $key ) {
    return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : '';
};

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
                <h1 class="doro-thankyou__title"><?php echo esc_html( $ui( 'doroshopping_ui_thankyou_fail_title' ) ); ?></h1>
                <p class="doro-thankyou__text"><?php echo esc_html( $ui( 'doroshopping_ui_thankyou_fail_text' ) ); ?></p>
                <div class="doro-thankyou__actions">
                    <a class="doro-thankyou__btn doro-thankyou__btn--primary" href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>">
                        <?php echo esc_html( $ui( 'doroshopping_ui_thankyou_retry' ) ); ?>
                    </a>
                    <a class="doro-thankyou__btn doro-thankyou__btn--ghost" href="<?php echo esc_url( $shop_url ); ?>">
                        <?php echo esc_html( $ui( 'doroshopping_ui_thankyou_back_shop' ) ); ?>
                    </a>
                </div>
            </div>
        <?php else : ?>
            <div class="doro-thankyou__card">
                <div class="doro-thankyou__icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12l3 3 5-6"/></svg>
                </div>
                <h1 class="doro-thankyou__title"><?php echo esc_html( $ui( 'doroshopping_ui_thankyou_ok_title' ) ); ?></h1>
                <p class="doro-thankyou__text">
                    <?php
                    $order_ref = '<strong>#' . esc_html( $order->get_order_number() ) . '</strong>';
                    echo wp_kses_post(
                        function_exists( 'doroshopping_ui_sprintf' )
                            ? doroshopping_ui_sprintf( 'doroshopping_ui_thankyou_ok_text', $order_ref )
                            : sprintf(
                                /* translators: %s: order number */
                                __( 'Tu pedido %s se ha recibido correctamente. Te enviaremos actualizaciones por correo.', 'doroshopping' ),
                                $order_ref
                            )
                    );
                    ?>
                </p>

                <ul class="doro-thankyou__meta">
                    <li>
                        <span><?php echo esc_html( $ui( 'doroshopping_ui_thankyou_order_num' ) ); ?></span>
                        <strong>#<?php echo esc_html( $order->get_order_number() ); ?></strong>
                    </li>
                    <li>
                        <span><?php echo esc_html( $ui( 'doroshopping_ui_thankyou_date' ) ); ?></span>
                        <strong><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></strong>
                    </li>
                    <li>
                        <span><?php echo esc_html( $ui( 'doroshopping_ui_thankyou_total' ) ); ?></span>
                        <strong><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></strong>
                    </li>
                    <li>
                        <span><?php echo esc_html( $ui( 'doroshopping_ui_thankyou_pay_method' ) ); ?></span>
                        <strong><?php echo esc_html( $order->get_payment_method_title() ); ?></strong>
                    </li>
                </ul>

                <div class="doro-thankyou__actions">
                    <a class="doro-thankyou__btn doro-thankyou__btn--primary" href="<?php echo esc_url( $account_url ); ?>">
                        <?php echo esc_html( $ui( 'doroshopping_ui_thankyou_account' ) ); ?>
                    </a>
                    <a class="doro-thankyou__btn doro-thankyou__btn--secondary" href="<?php echo esc_url( $orders_url ); ?>">
                        <?php echo esc_html( $ui( 'doroshopping_ui_thankyou_orders' ) ); ?>
                    </a>
                    <a class="doro-thankyou__btn doro-thankyou__btn--ghost" href="<?php echo esc_url( $shop_url ); ?>">
                        <?php echo esc_html( $ui( 'doroshopping_ui_thankyou_continue' ) ); ?>
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
            <h1 class="doro-thankyou__title"><?php echo esc_html( $ui( 'doroshopping_ui_thankyou_generic_title' ) ); ?></h1>
            <p class="doro-thankyou__text"><?php echo esc_html( $ui( 'doroshopping_ui_thankyou_generic_text' ) ); ?></p>
            <div class="doro-thankyou__actions">
                <a class="doro-thankyou__btn doro-thankyou__btn--primary" href="<?php echo esc_url( $account_url ); ?>">
                    <?php echo esc_html( $ui( 'doroshopping_ui_thankyou_account' ) ); ?>
                </a>
                <a class="doro-thankyou__btn doro-thankyou__btn--ghost" href="<?php echo esc_url( $shop_url ); ?>">
                    <?php echo esc_html( $ui( 'doroshopping_ui_thankyou_back_shop' ) ); ?>
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>
