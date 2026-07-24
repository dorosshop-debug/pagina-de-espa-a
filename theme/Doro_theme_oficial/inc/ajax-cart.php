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
 * Asegura carrito WooCommerce en AJAX.
 * IMPORTANTE: no crear sesión vacía nueva en lecturas (pisa la cookie del add-to-cart).
 *
 * @param bool $create_session Si true, inicia cookie de sesión (solo al modificar carrito).
 * @return bool
 */
function doroshopping_ensure_wc_cart( $create_session = false ) {
    if ( ! function_exists( 'WC' ) ) {
        return false;
    }

    if ( is_null( WC()->cart ) && function_exists( 'wc_load_cart' ) ) {
        wc_load_cart();
    }

    if ( $create_session && WC()->session && ! WC()->session->has_session() ) {
        WC()->session->set_customer_session_cookie( true );
    }

    return (bool) WC()->cart;
}

/**
 * Serializa el carrito actual para el modal.
 *
 * @return array
 */
function doroshopping_get_cart_payload() {
    $items           = array();
    $count           = 0;
    $subtotal_html   = '';
    $checkout_url    = function_exists( 'doroshopping_get_checkout_url' ) ? doroshopping_get_checkout_url() : '';
    if ( ! $checkout_url && function_exists( 'wc_get_checkout_url' ) ) {
        $candidate = wc_get_checkout_url();
        if ( $candidate && ! ( function_exists( 'doroshopping_url_is_home' ) && doroshopping_url_is_home( $candidate ) ) ) {
            $checkout_url = $candidate;
        }
    }
    $recommendations = array();

    if ( ! doroshopping_ensure_wc_cart( false ) ) {
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
            'key'        => $cart_item_key,
            'product_id' => $product_id,
            'name'       => $product->get_name(),
            'quantity'   => $quantity,
            'price_html' => WC()->cart->get_product_price( $product ),
            'image'      => $image_url,
            'permalink'  => get_permalink( $product_id ),
            'max_qty'    => $product->get_max_purchase_quantity() > 0 ? $product->get_max_purchase_quantity() : 99,
        );
    }

    $subtotal_html = $cart->get_cart_subtotal();

    $recs = wc_get_products(
        array(
            'limit'   => 2,
            'status'  => 'publish',
            'orderby' => 'popularity',
            'exclude' => array_column( $items, 'product_id' ),
        )
    );

    foreach ( $recs as $rec ) {
        $thumb_id = $rec->get_image_id();
        $recommendations[] = array(
            'id'         => $rec->get_id(),
            'name'       => $rec->get_name(),
            'price_html' => $rec->get_price_html(),
            'image'      => $thumb_id
                ? wp_get_attachment_image_url( $thumb_id, 'thumbnail' )
                : wc_placeholder_img_src( 'thumbnail' ),
            'permalink'  => $rec->get_permalink(),
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
    doroshopping_ensure_wc_cart( false );
    wp_send_json_success( doroshopping_get_cart_payload() );
}
add_action( 'wp_ajax_doroshopping_get_cart', 'doroshopping_ajax_get_cart' );
add_action( 'wp_ajax_nopriv_doroshopping_get_cart', 'doroshopping_ajax_get_cart' );

/**
 * Update quantity.
 */
function doroshopping_ajax_update_cart_item() {
    check_ajax_referer( 'doroshopping_cart', 'nonce' );

    if ( ! doroshopping_ensure_wc_cart( true ) ) {
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

    if ( ! doroshopping_ensure_wc_cart( true ) ) {
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

/**
 * Añadir producto al carrito (AJAX del tema, con sesión persistente).
 */
function doroshopping_ajax_add_to_cart() {
    check_ajax_referer( 'doroshopping_cart', 'nonce' );

    if ( ! doroshopping_ensure_wc_cart( true ) ) {
        wp_send_json_error( array( 'message' => __( 'Carrito no disponible.', 'doroshopping' ) ), 400 );
    }

    $product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
    $quantity   = isset( $_POST['quantity'] ) ? max( 1, absint( $_POST['quantity'] ) ) : 1;

    if ( $product_id <= 0 ) {
        wp_send_json_error( array( 'message' => __( 'Producto invalido.', 'doroshopping' ) ), 400 );
    }

    $product = wc_get_product( $product_id );
    if ( ! $product || ! $product->is_purchasable() || ! $product->is_in_stock() ) {
        wp_send_json_error( array( 'message' => __( 'Este producto no se puede añadir.', 'doroshopping' ) ), 400 );
    }

    $added = WC()->cart->add_to_cart( $product_id, $quantity );
    if ( ! $added ) {
        wp_send_json_error( array( 'message' => __( 'No se pudo añadir al carrito.', 'doroshopping' ) ), 400 );
    }

    if ( WC()->session ) {
        WC()->session->set_customer_session_cookie( true );
    }

    WC()->cart->calculate_totals();

    // Fragments al estilo WooCommerce (contadores del tema incluidos).
    ob_start();
    woocommerce_mini_cart();
    $mini_cart = ob_get_clean();

    $fragments = apply_filters(
        'woocommerce_add_to_cart_fragments',
        array(
            'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>',
        )
    );

    wp_send_json_success(
        array(
            'fragments' => $fragments,
            'cart_hash' => WC()->cart->get_cart_hash(),
            'count'     => WC()->cart->get_cart_contents_count(),
        )
    );
}
add_action( 'wp_ajax_doroshopping_add_to_cart', 'doroshopping_ajax_add_to_cart' );
add_action( 'wp_ajax_nopriv_doroshopping_add_to_cart', 'doroshopping_ajax_add_to_cart' );

