<?php
/**
 * Resumen lateral del carrito.
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$ui = static function ( $key ) {
    return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : '';
};

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

$continue_label = function_exists( 'doroshopping_ui_sprintf' )
    ? doroshopping_ui_sprintf( 'doroshopping_ui_cart_continue', $count )
    : '';
?>

<div class="doro-cesta-summary">
    <h2 class="doro-cesta-summary__title"><?php echo esc_html( $ui( 'doroshopping_ui_cart_summary' ) ); ?></h2>

    <div
        class="doro-cesta-summary__shipping"
        data-doro-shipping
        data-shipping-context="cart"
        data-shipping-ready="0"
        hidden
    >
        <p class="doro-cesta-summary__shipping-title"><?php echo esc_html( $ui( 'doroshopping_ui_cart_shipping_est' ) ); ?></p>
        <p class="doro-cesta-summary__shipping-dest">
            <?php echo esc_html( $ui( 'doroshopping_ui_cart_dest' ) ); ?>
            <strong data-shipping-destination>&mdash;</strong>
        </p>
        <ul class="doro-cesta-summary__shipping-list">
            <li><span><?php echo esc_html( $ui( 'doroshopping_ui_cart_carrier' ) ); ?></span> <strong data-shipping-carrier>&mdash;</strong></li>
            <li><span><?php echo esc_html( $ui( 'doroshopping_ui_cart_time' ) ); ?></span> <strong data-shipping-eta>&mdash;</strong></li>
            <li><span><?php echo esc_html( $ui( 'doroshopping_ui_cart_cost' ) ); ?></span> <strong data-shipping-cost>&mdash;</strong></li>
        </ul>
        <p class="doro-cesta-summary__shipping-note" data-shipping-note></p>
    </div>

    <div class="doro-cesta-summary__row">
        <span><?php echo esc_html( $ui( 'doroshopping_ui_cart_total_est' ) ); ?></span>
        <strong class="doro-cesta-summary__total"><?php echo $is_empty ? wp_kses_post( wc_price( 0 ) ) : wp_kses_post( $total ); ?></strong>
    </div>

    <?php if ( $is_empty ) : ?>
        <a class="doro-cesta-summary__cta is-disabled" href="<?php echo esc_url( $shop ); ?>" aria-disabled="true">
            <?php echo esc_html( $continue_label ); ?>
        </a>
    <?php else : ?>
        <a class="doro-cesta-summary__cta" href="<?php echo esc_url( $checkout ); ?>">
            <?php echo esc_html( $continue_label ); ?>
        </a>
    <?php endif; ?>
</div>
