<?php
/**
 * AJAX del carrito flotante (WooCommerce)
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Serializa el carrito actual para el modal.
 *
 * @return array
 */
function doroshopping_get_cart_payload() {
    $items          = array();
    $count          = 0;
    $subtotal_html  = '';
    $checkout_url   = function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : home_url( '/' );
    $recommendations = array();

    if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
        return array(
            'items'           => $items,
            'count'           => 0,
            'subtotal_html'   => '',
            'checkout_url'    => $checkout_url,
            'recommendations' => $recommendations,
            'empty_message'   => __( 'Tu carrito esta vacio.', 'doroshopping' ),
        );
    }

    $cart = WC()->cart;

    foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
        $product = $cart_item['data'];
        if ( ! $product || ! $product->exists() ) {
            continue;
        }

        $product_id   = $cart_item['product_id'];
        $quantity     = (int) $cart_item['quantity'];
        $count       += $quantity;
        $thumbnail_id = $product->get_image_id();
        $image_url    = $thumbnail_id
            ? wp_get_attachment_image_url( $thumbnail_id, 'thumbnail' )
            : wc_placeholder_img_src( 'thumbnail' );

        $items[] = array(
            'key'       => $cart_item_key,
            'product_id'=> $product_id,
            'name'      => $product->get_name(),
            'quantity'  => $quantity,
            'price_html'=> WC()->cart->get_product_price( $product ),
            'image'     => $image_url,
            'permalink' => get_permalink( $product_id ),
            'max_qty'   => $product->get_max_purchase_quantity() > 0 ? $product->get_max_purchase_quantity() : 99,
        );
    }

    $subtotal_html = $cart->get_cart_subtotal();

    $recs = wc_get_products(
        array(
            'limit'    => 2,
            'status'   => 'publish',
            'orderby'  => 'popularity',
            'exclude'  => array_column( $items, 'product_id' ),
        )
    );

    foreach ( $recs as $rec ) {
        $thumb_id = $rec->get_image_id();
        $recommendations[] = array(
            'id'        => $rec->get_id(),
            'name'      => $rec->get_name(),
            'price_html'=> $rec->get_price_html(),
            'image'     => $thumb_id
                ? wp_get_attachment_image_url( $thumb_id, 'thumbnail' )
                : wc_placeholder_img_src( 'thumbnail' ),
            'permalink' => $rec->get_permalink(),
        );
    }

    return array(
        'items'           => $items,
        'count'           => $count,
        'subtotal_html'   => $subtotal_html,
        'checkout_url'    => $checkout_url,
        'recommendations' => $recommendations,
        'empty_message'   => __( 'Tu carrito esta vacio.', 'doroshopping' ),
    );
}

/**
 * GET cart.
 */
function doroshopping_ajax_get_cart() {
    check_ajax_referer( 'doroshopping_cart', 'nonce' );
    wp_send_json_success( doroshopping_get_cart_payload() );
}
add_action( 'wp_ajax_doroshopping_get_cart', 'doroshopping_ajax_get_cart' );
add_action( 'wp_ajax_nopriv_doroshopping_get_cart', 'doroshopping_ajax_get_cart' );

/**
 * Update quantity.
 */
function doroshopping_ajax_update_cart_item() {
    check_ajax_referer( 'doroshopping_cart', 'nonce' );

    if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
        wp_send_json_error( array( 'message' => __( 'Carrito no disponible.', 'doroshopping' ) ), 400 );
    }

    $key = isset( $_POST['key'] ) ? sanitize_text_field( wp_unslash( $_POST['key'] ) ) : '';
    $qty = isset( $_POST['quantity'] ) ? absint( $_POST['quantity'] ) : 0;

    if ( '' === $key ) {
        wp_send_json_error( array( 'message' => __( 'Item invalido.', 'doroshopping' ) ), 400 );
    }

    if ( $qty < 1 ) {
        WC()->cart->remove_cart_item( $key );
    } else {
        WC()->cart->set_quantity( $key, $qty, true );
    }

    WC()->cart->calculate_totals();
    wp_send_json_success( doroshopping_get_cart_payload() );
}
add_action( 'wp_ajax_doroshopping_update_cart_item', 'doroshopping_ajax_update_cart_item' );
add_action( 'wp_ajax_nopriv_doroshopping_update_cart_item', 'doroshopping_ajax_update_cart_item' );

/**
 * Remove item.
 */
function doroshopping_ajax_remove_cart_item() {
    check_ajax_referer( 'doroshopping_cart', 'nonce' );

    if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
        wp_send_json_error( array( 'message' => __( 'Carrito no disponible.', 'doroshopping' ) ), 400 );
    }

    $key = isset( $_POST['key'] ) ? sanitize_text_field( wp_unslash( $_POST['key'] ) ) : '';

    if ( '' === $key ) {
        wp_send_json_error( array( 'message' => __( 'Item invalido.', 'doroshopping' ) ), 400 );
    }

    WC()->cart->remove_cart_item( $key );
    WC()->cart->calculate_totals();
    wp_send_json_success( doroshopping_get_cart_payload() );
}
add_action( 'wp_ajax_doroshopping_remove_cart_item', 'doroshopping_ajax_remove_cart_item' );
add_action( 'wp_ajax_nopriv_doroshopping_remove_cart_item', 'doroshopping_ajax_remove_cart_item' );
