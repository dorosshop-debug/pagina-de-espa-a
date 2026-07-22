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
 * Fuerza shortcodes clásicos en páginas Carrito/Checkout.
 * Los bloques no usan cart.php del tema y pueden mostrar carrito vacío.
 *
 * @param bool $force Ignorar flag de "ya migrado".
 * @return void
 */
function doroshopping_ensure_classic_cart_checkout_pages( $force = false ) {
    if ( ! class_exists( 'WooCommerce' ) ) {
        return;
    }

    if ( ! $force && get_option( 'doroshopping_classic_cart_checkout' ) === DOROSHOPPING_VERSION ) {
        return;
    }

    $map = array(
        'woocommerce_cart_page_id'     => '[woocommerce_cart]',
        'woocommerce_checkout_page_id' => '[woocommerce_checkout]',
    );

    foreach ( $map as $option => $shortcode ) {
        $page_id = (int) get_option( $option, 0 );
        if ( $page_id <= 0 ) {
            continue;
        }

        $post = get_post( $page_id );
        if ( ! $post || 'page' !== $post->post_type ) {
            continue;
        }

        $content = (string) $post->post_content;

        // Ya tiene el shortcode clásico y no hay bloques.
        if ( false !== strpos( $content, $shortcode ) && ! doroshopping_content_has_wc_cart_checkout_blocks( $content ) ) {
            continue;
        }

        if ( ! doroshopping_content_has_wc_cart_checkout_blocks( $content ) && trim( $content ) === $shortcode ) {
            continue;
        }

        if ( doroshopping_content_has_wc_cart_checkout_blocks( $content ) || '' === trim( wp_strip_all_tags( $content ) ) ) {
            wp_update_post(
                array(
                    'ID'           => $page_id,
                    'post_content' => $shortcode,
                )
            );
        }
    }

    update_option( 'doroshopping_classic_cart_checkout', DOROSHOPPING_VERSION, false );
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
    if ( get_option( 'doroshopping_classic_cart_checkout' ) === DOROSHOPPING_VERSION ) {
        return;
    }
    doroshopping_ensure_classic_cart_checkout_pages( true );
}
add_action( 'admin_init', 'doroshopping_maybe_ensure_classic_cart_checkout_admin' );
