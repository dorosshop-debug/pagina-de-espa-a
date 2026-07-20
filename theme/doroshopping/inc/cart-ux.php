<?php
/**
 * Add to cart AJAX, buy now redirect, fragments
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Tras "Comprar ahora", redirigir a checkout.
 *
 * @param string $url URL.
 * @return string
 */
function doroshopping_buy_now_redirect( $url ) {
    if ( ! empty( $_REQUEST['doroshopping_buy_now'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        return wc_get_checkout_url();
    }
    return $url;
}
add_filter( 'woocommerce_add_to_cart_redirect', 'doroshopping_buy_now_redirect' );

/**
 * Habilitar AJAX add to cart en loop / home.
 */
function doroshopping_enable_ajax_add_to_cart() {
    if ( 'yes' !== get_option( 'woocommerce_enable_ajax_add_to_cart' ) ) {
        update_option( 'woocommerce_enable_ajax_add_to_cart', 'yes' );
    }
}
add_action( 'after_switch_theme', 'doroshopping_enable_ajax_add_to_cart' );
add_action( 'admin_init', 'doroshopping_enable_ajax_add_to_cart' );

/**
 * Botón "Comprar ahora" dentro del formulario de add to cart.
 */
function doroshopping_buy_now_button() {
    global $product;
    if ( ! $product || ! $product->is_purchasable() || ! $product->is_in_stock() ) {
        return;
    }
    echo '<button type="submit" name="doroshopping_buy_now" value="1" class="doro-buybox__buy-now">';
    echo esc_html__( 'Comprar ahora', 'doroshopping' );
    echo '</button>';
}
add_action( 'woocommerce_after_add_to_cart_button', 'doroshopping_buy_now_button', 5 );

/**
 * Fragmentos extra: contadores del tema.
 *
 * @param array $fragments Fragments.
 * @return array
 */
function doroshopping_cart_count_fragments( $fragments ) {
    $count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
    $fragments['span.site-header__cart-count'] = '<span class="site-header__cart-count" data-cart-count>' . esc_html( (string) $count ) . '</span>';
    $fragments['span.site-fab-cart__count']    = '<span class="site-fab-cart__count" data-cart-count>' . esc_html( (string) $count ) . '</span>';
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'doroshopping_cart_count_fragments' );
