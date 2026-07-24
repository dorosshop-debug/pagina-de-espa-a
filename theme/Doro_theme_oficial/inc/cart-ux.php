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
    if ( empty( $_REQUEST['doroshopping_buy_now'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        return $url;
    }
    $checkout = function_exists( 'doroshopping_get_checkout_url' ) ? doroshopping_get_checkout_url() : '';
    if ( $checkout ) {
        return $checkout;
    }
    $cart = function_exists( 'doroshopping_get_cart_url' ) ? doroshopping_get_cart_url() : '';
    return $cart ? $cart : $url;
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
 * En productos simples WC pone add-to-cart solo en el botón "Añadir".
 * Sin un hidden, "Comprar ahora" no añade el producto al carrito.
 */
function doroshopping_buy_now_ensure_add_to_cart_field() {
    global $product;
    if ( ! $product || ! $product->is_type( 'simple' ) ) {
        return;
    }
    if ( ! $product->is_purchasable() || ! $product->is_in_stock() ) {
        return;
    }
    printf(
        '<input type="hidden" name="add-to-cart" value="%d" data-doroshopping-buy-now-pid />',
        absint( $product->get_id() )
    );
}
add_action( 'woocommerce_before_add_to_cart_button', 'doroshopping_buy_now_ensure_add_to_cart_field', 5 );

/**
 * Botón "Comprar ahora" dentro del formulario de add to cart.
 */
function doroshopping_buy_now_button() {
    global $product;
    if ( ! $product || ! $product->is_purchasable() || ! $product->is_in_stock() ) {
        return;
    }
    echo '<button type="submit" name="doroshopping_buy_now" value="1" class="doro-buybox__buy-now">';
    echo '<span>' . esc_html__( 'Ir a la compra', 'doroshopping' ) . '</span>';
    echo '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>';
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

/**
 * Persistir cookie de sesión justo al añadir (evita perder el carrito al navegar).
 */
function doroshopping_persist_cart_session() {
    if ( function_exists( 'WC' ) && WC()->session && ! WC()->session->has_session() ) {
        WC()->session->set_customer_session_cookie( true );
    }
}
add_action( 'woocommerce_add_to_cart', 'doroshopping_persist_cart_session', 5 );

/**
 * No cachear carrito/checkout (páginas con sesión).
 */
function doroshopping_nocache_cart_checkout() {
    if ( ! function_exists( 'is_cart' ) ) {
        return;
    }
    if ( is_cart() || is_checkout() || ( function_exists( 'is_account_page' ) && is_account_page() ) ) {
        if ( ! defined( 'DONOTCACHEPAGE' ) ) {
            define( 'DONOTCACHEPAGE', true );
        }
        if ( ! defined( 'DONOTCACHEOBJECT' ) ) {
            define( 'DONOTCACHEOBJECT', true );
        }
        if ( function_exists( 'nocache_headers' ) ) {
            nocache_headers();
        }
    }
}
add_action( 'template_redirect', 'doroshopping_nocache_cart_checkout', 1 );
