<?php
/**
 * Lista de deseos - helpers y endpoints AJAX (sin plugin externo)
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Meta key / cookie key para IDs de productos en wishlist.
 */
define( 'DOROSHOPPING_WISHLIST_META', '_doroshopping_wishlist' );
define( 'DOROSHOPPING_WISHLIST_COOKIE', 'doroshopping_wishlist' );
define( 'DOROSHOPPING_WISHLIST_MAX', 100 );

/**
 * Obtiene IDs de wishlist del usuario (meta) o cookie (invitado).
 *
 * @return int[]
 */
function doroshopping_get_wishlist_ids() {
    $ids = array();

    if ( is_user_logged_in() ) {
        $raw = get_user_meta( get_current_user_id(), DOROSHOPPING_WISHLIST_META, true );
        if ( is_array( $raw ) ) {
            $ids = $raw;
        }
    } elseif ( ! empty( $_COOKIE[ DOROSHOPPING_WISHLIST_COOKIE ] ) ) {
        $decoded = json_decode( wp_unslash( $_COOKIE[ DOROSHOPPING_WISHLIST_COOKIE ] ), true ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
        if ( is_array( $decoded ) ) {
            $ids = $decoded;
        }
    }

    $ids = array_values( array_unique( array_filter( array_map( 'absint', $ids ) ) ) );
    return $ids;
}

/**
 * Guarda IDs de wishlist.
 *
 * @param int[] $ids Product IDs.
 */
function doroshopping_save_wishlist_ids( $ids ) {
    $ids = array_values( array_unique( array_filter( array_map( 'absint', (array) $ids ) ) ) );
    $max = defined( 'DOROSHOPPING_WISHLIST_MAX' ) ? (int) DOROSHOPPING_WISHLIST_MAX : 100;
    if ( $max > 0 && count( $ids ) > $max ) {
        $ids = array_slice( $ids, 0, $max );
    }

    if ( is_user_logged_in() ) {
        update_user_meta( get_current_user_id(), DOROSHOPPING_WISHLIST_META, $ids );
    }

    $expire = time() + MONTH_IN_SECONDS;
    $json   = wp_json_encode( $ids );
    if ( function_exists( 'doroshopping_set_cookie' ) ) {
        doroshopping_set_cookie( DOROSHOPPING_WISHLIST_COOKIE, $json, $expire, true );
    } else {
        setcookie( DOROSHOPPING_WISHLIST_COOKIE, $json, $expire, COOKIEPATH ? COOKIEPATH : '/', COOKIE_DOMAIN, is_ssl(), true );
    }
    $_COOKIE[ DOROSHOPPING_WISHLIST_COOKIE ] = $json;
}

/**
 * URL de la pagina Lista de deseos (plantilla page-wishlist.php o slug).
 *
 * @return string
 */
function doroshopping_get_wishlist_url() {
    $pages = get_posts(
        array(
            'post_type'      => 'page',
            'post_status'    => 'publish',
            'posts_per_page' => 1,
            'meta_key'       => '_wp_page_template',
            'meta_value'     => 'page-wishlist.php',
        )
    );

    if ( ! empty( $pages ) ) {
        return get_permalink( $pages[0]->ID );
    }

    $by_slug = function_exists( 'doroshopping_get_page_by_slug' )
        ? doroshopping_get_page_by_slug( 'lista-de-deseos' )
        : null;
    if ( $by_slug instanceof WP_Post ) {
        return get_permalink( $by_slug );
    }

    return home_url( '/lista-de-deseos/' );
}

/**
 * ¿Estamos en la página Lista de deseos?
 *
 * @return bool
 */
function doroshopping_is_wishlist_page() {
    if ( is_page_template( 'page-wishlist.php' ) ) {
        return true;
    }

    if ( is_page( 'lista-de-deseos' ) ) {
        return true;
    }

    return false;
}

/**
 * Fusiona wishlist de cookie con user meta al iniciar sesión.
 *
 * @param string $user_login Username.
 * @param WP_User $user User object.
 */
function doroshopping_merge_wishlist_on_login( $user_login, $user ) {
    if ( empty( $user->ID ) || empty( $_COOKIE[ DOROSHOPPING_WISHLIST_COOKIE ] ) ) {
        return;
    }

    $decoded = json_decode( wp_unslash( $_COOKIE[ DOROSHOPPING_WISHLIST_COOKIE ] ), true ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
    if ( ! is_array( $decoded ) || empty( $decoded ) ) {
        return;
    }

    $cookie_ids = array_values( array_unique( array_filter( array_map( 'absint', $decoded ) ) ) );
    $meta_raw   = get_user_meta( $user->ID, DOROSHOPPING_WISHLIST_META, true );
    $meta_ids   = is_array( $meta_raw ) ? $meta_raw : array();
    $merged     = array_values( array_unique( array_filter( array_map( 'absint', array_merge( $meta_ids, $cookie_ids ) ) ) ) );

    update_user_meta( $user->ID, DOROSHOPPING_WISHLIST_META, $merged );

    $expire = time() + MONTH_IN_SECONDS;
    setcookie( DOROSHOPPING_WISHLIST_COOKIE, wp_json_encode( $merged ), $expire, COOKIEPATH ? COOKIEPATH : '/', COOKIE_DOMAIN, is_ssl(), true );
}
add_action( 'wp_login', 'doroshopping_merge_wishlist_on_login', 10, 2 );

/**
 * AJAX: anadir / quitar producto.
 */
function doroshopping_ajax_toggle_wishlist() {
    check_ajax_referer( 'doroshopping_wishlist', 'nonce' );

    if ( function_exists( 'doroshopping_rate_limit' ) && ! doroshopping_rate_limit( 'wishlist', 40, 60 ) ) {
        doroshopping_rate_limit_ajax_block();
    }

    $product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
    if ( ! $product_id ) {
        wp_send_json_error( array( 'message' => __( 'Producto no valido.', 'doroshopping' ) ), 400 );
    }

    $product = function_exists( 'wc_get_product' ) ? wc_get_product( $product_id ) : null;
    if ( ! $product || 'publish' !== $product->get_status() ) {
        wp_send_json_error( array( 'message' => __( 'Producto no valido.', 'doroshopping' ) ), 400 );
    }

    $ids    = doroshopping_get_wishlist_ids();
    $added  = false;
    $key    = array_search( $product_id, $ids, true );

    if ( false !== $key ) {
        unset( $ids[ $key ] );
        $ids = array_values( $ids );
    } else {
        $max = defined( 'DOROSHOPPING_WISHLIST_MAX' ) ? (int) DOROSHOPPING_WISHLIST_MAX : 100;
        if ( $max > 0 && count( $ids ) >= $max ) {
            wp_send_json_error(
                array(
                    'message' => __( 'La lista de deseos está llena. Elimina algún producto para añadir otro.', 'doroshopping' ),
                ),
                400
            );
        }
        $ids[] = $product_id;
        $added = true;
    }

    doroshopping_save_wishlist_ids( $ids );

    wp_send_json_success(
        array(
            'added'   => $added,
            'count'   => count( $ids ),
            'ids'     => $ids,
            'message' => $added
                ? __( 'Añadido a la lista de deseos.', 'doroshopping' )
                : __( 'Eliminado de la lista de deseos.', 'doroshopping' ),
        )
    );
}
add_action( 'wp_ajax_doroshopping_toggle_wishlist', 'doroshopping_ajax_toggle_wishlist' );
add_action( 'wp_ajax_nopriv_doroshopping_toggle_wishlist', 'doroshopping_ajax_toggle_wishlist' );
