<?php
/**
 * Resumen lateral del carrito.
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$count    = isset( $args['count'] ) ? (int) $args['count'] : 0;
$is_empty = ! empty( $args['is_empty'] );
$total    = ( function_exists( 'WC' ) && WC()->cart ) ? WC()->cart->get_total() : wc_price( 0 );
$checkout = function_exists( 'doroshopping_get_checkout_url' ) ? doroshopping_get_checkout_url() : '';
$shop     = function_exists( 'doroshopping_get_wc_page_url' ) ? doroshopping_get_wc_page_url( 'shop' ) : '';
if ( ! $shop ) {
    $shop = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
}
if ( ! $checkout ) {
    $checkout = $shop;
}
?>

<div class="doro-cesta-summary">
    <h2 class="doro-cesta-summary__title"><?php esc_html_e( 'Resumen', 'doroshopping' ); ?></h2>

    <div
        class="doro-cesta-summary__shipping"
        data-doro-shipping
        data-shipping-context="cart"
        data-shipping-ready="0"
        hidden
    >
        <p class="doro-cesta-summary__shipping-title"><?php esc_html_e( 'Envío estimado', 'doroshopping' ); ?></p>
        <p class="doro-cesta-summary__shipping-dest">
            <?php esc_html_e( 'Destino:', 'doroshopping' ); ?>
            <strong data-shipping-destination>&mdash;</strong>
        </p>
        <ul class="doro-cesta-summary__shipping-list">
            <li><span><?php esc_html_e( 'Transportista', 'doroshopping' ); ?></span> <strong data-shipping-carrier>&mdash;</strong></li>
            <li><span><?php esc_html_e( 'Tiempo', 'doroshopping' ); ?></span> <strong data-shipping-eta>&mdash;</strong></li>
            <li><span><?php esc_html_e( 'Coste', 'doroshopping' ); ?></span> <strong data-shipping-cost>&mdash;</strong></li>
        </ul>
        <p class="doro-cesta-summary__shipping-note" data-shipping-note></p>
    </div>

    <div class="doro-cesta-summary__row">
        <span><?php esc_html_e( 'Estimación total', 'doroshopping' ); ?></span>
        <strong class="doro-cesta-summary__total"><?php echo $is_empty ? wp_kses_post( wc_price( 0 ) ) : wp_kses_post( $total ); ?></strong>
    </div>

    <?php if ( $is_empty ) : ?>
        <a class="doro-cesta-summary__cta is-disabled" href="<?php echo esc_url( $shop ); ?>" aria-disabled="true">
            <?php
            printf(
                /* translators: %d: cart item count */
                esc_html__( 'Continuar (%d)', 'doroshopping' ),
                $count
            );
            ?>
        </a>
            <?php else : ?>
                <a class="doro-cesta-summary__cta" href="<?php echo esc_url( $checkout ); ?>">
                    <?php
                    printf(
                        /* translators: %d: cart item count */
                        esc_html__( 'Continuar (%d)', 'doroshopping' ),
                        $count
                    );
                    ?>
                </a>
            <?php endif; ?>
</div>
