<?php
/**
 * Ajustes visuales de Carrito y Checkout.
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Texto del botón de checkout.
 *
 * @param string $text Default text.
 * @return string
 */
function doroshopping_order_button_text( $text ) {
    return __( 'Realizar pedido', 'doroshopping' );
}
add_filter( 'woocommerce_order_button_text', 'doroshopping_order_button_text' );

/**
 * Clases body extra para cart/checkout.
 *
 * @param string[] $classes Classes.
 * @return string[]
 */
function doroshopping_cart_checkout_body_class( $classes ) {
    if ( function_exists( 'is_cart' ) && is_cart() ) {
        $classes[] = 'doro-cart-page';
    }
    if ( function_exists( 'is_checkout' ) && is_checkout() ) {
        $classes[] = 'doro-checkout-page';
    }
    return $classes;
}
add_filter( 'body_class', 'doroshopping_cart_checkout_body_class' );

/**
 * Evita el bloque de collaterals/totales nativo (usamos Resumen propio).
 */
function doroshopping_remove_cart_collaterals() {
    remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );
}
add_action( 'wp', 'doroshopping_remove_cart_collaterals' );

/**
 * Evita duplicar payment + place order del review por defecto.
 */
function doroshopping_checkout_hooks() {
    remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );
    remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
}
add_action( 'wp', 'doroshopping_checkout_hooks' );
