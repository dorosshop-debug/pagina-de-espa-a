<?php
/**
 * Ajustes visuales de Carrito y Checkout + forzar plantillas clásicas.
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
    $is_cart_page = ( function_exists( 'is_cart' ) && is_cart() ) || is_page( array( 'carrito', 'cart' ) );
    $is_checkout_page = ( function_exists( 'is_checkout' ) && is_checkout() ) || is_page( array( 'finalizar-compra', 'checkout' ) );

    if ( $is_cart_page ) {
        $classes[] = 'doro-cart-page';
        $classes[] = 'woocommerce-cart';
        $classes[] = 'woocommerce-page';
    }
    if ( $is_checkout_page ) {
        $classes[] = 'doro-checkout-page';
        $classes[] = 'woocommerce-checkout';
        $classes[] = 'woocommerce-page';
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

/**
 * Detecta si el contenido de una página usa bloques Cart/Checkout.
 *
 * @param string $content Contenido.
 * @return bool
 */
function doroshopping_content_has_wc_cart_checkout_blocks( $content ) {
    if ( '' === $content ) {
        return false;
    }

    return (bool) preg_match(
        '/wp:woocommerce\/(cart|checkout|filled-cart-block|empty-cart-block|cart-items-block|checkout-fields-block)/',
        $content
    );
}

/**
 * Fuerza shortcodes clásicos en páginas Carrito/Checkout y las crea si faltan.
 *
 * @param bool $force Ignorar flag de "ya migrado".
 * @return void
 */
function doroshopping_ensure_classic_cart_checkout_pages( $force = false ) {
    if ( ! class_exists( 'WooCommerce' ) ) {
        return;
    }

    $defs = array(
        'woocommerce_cart_page_id'      => array(
            'slug'    => 'carrito',
            'title'   => __( 'Carrito', 'doroshopping' ),
            'content' => '[woocommerce_cart]',
        ),
        'woocommerce_checkout_page_id'  => array(
            'slug'    => 'finalizar-compra',
            'title'   => __( 'Finalizar compra', 'doroshopping' ),
            'content' => '[woocommerce_checkout]',
        ),
        'woocommerce_myaccount_page_id' => array(
            'slug'    => 'mi-cuenta',
            'title'   => __( 'Mi cuenta', 'doroshopping' ),
            'content' => '[woocommerce_my_account]',
        ),
    );

    $created_any = false;

    foreach ( $defs as $option => $def ) {
        $page_id = (int) get_option( $option, 0 );
        $post    = $page_id > 0 ? get_post( $page_id ) : null;

        if ( ! $post || 'page' !== $post->post_type || 'publish' !== $post->post_status ) {
            $existing = function_exists( 'doroshopping_get_page_by_slug' ) ? doroshopping_get_page_by_slug( $def['slug'] ) : null;
            if ( $existing instanceof WP_Post ) {
                $page_id = (int) $existing->ID;
                $post    = $existing;
            } else {
                $page_id = wp_insert_post(
                    array(
                        'post_title'   => $def['title'],
                        'post_name'    => $def['slug'],
                        'post_content' => $def['content'],
                        'post_status'  => 'publish',
                        'post_type'    => 'page',
                        'post_author'  => get_current_user_id() ? get_current_user_id() : 1,
                    ),
                    true
                );
                if ( is_wp_error( $page_id ) || ! $page_id ) {
                    continue;
                }
                $page_id     = (int) $page_id;
                $post        = get_post( $page_id );
                $created_any = true;
            }
            update_option( $option, $page_id );
        }

        if ( ! $post ) {
            continue;
        }

        $content   = (string) $post->post_content;
        $shortcode = $def['content'];

        if ( false !== strpos( $content, $shortcode ) && ! doroshopping_content_has_wc_cart_checkout_blocks( $content ) ) {
            continue;
        }

        if ( doroshopping_content_has_wc_cart_checkout_blocks( $content ) || '' === trim( wp_strip_all_tags( $content ) ) || false === strpos( $content, $shortcode ) ) {
            wp_update_post(
                array(
                    'ID'           => (int) $post->ID,
                    'post_content' => $shortcode,
                )
            );
            $created_any = true;
        }
    }

    update_option( 'doroshopping_classic_cart_checkout', DOROSHOPPING_VERSION, false );

    if ( $created_any ) {
        flush_rewrite_rules( false );
    }
}
add_action( 'after_switch_theme', 'doroshopping_ensure_classic_cart_checkout_pages' );

/**
 * Una pasada en admin tras actualizar el tema (instalaciones ya activas).
 *
 * @return void
 */
function doroshopping_maybe_ensure_classic_cart_checkout_admin() {
    if ( ! is_admin() || ! current_user_can( 'manage_woocommerce' ) ) {
        return;
    }
    doroshopping_ensure_classic_cart_checkout_pages( false );
}
add_action( 'admin_init', 'doroshopping_maybe_ensure_classic_cart_checkout_admin' );

/**
 * No usar Cart/Checkout Blocks por defecto (el diseño del tema es shortcode clásico).
 *
 * @return bool
 */
function doroshopping_disable_cart_checkout_blocks_default() {
    return false;
}
add_filter( 'woocommerce_blocks_is_cart_block_default', 'doroshopping_disable_cart_checkout_blocks_default' );
add_filter( 'woocommerce_blocks_is_checkout_block_default', 'doroshopping_disable_cart_checkout_blocks_default' );
