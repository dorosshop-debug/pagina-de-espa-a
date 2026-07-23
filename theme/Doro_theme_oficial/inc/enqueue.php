<?php
/**
 * Enqueue scripts and styles (modular, sin @import en cascada)
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Estilos del tema.
 */
function doroshopping_enqueue_assets() {
    $uri = get_template_directory_uri() . '/assets';
    $ver = DOROSHOPPING_VERSION;

    wp_enqueue_style(
        'doroshopping-fonts',
        'https://fonts.googleapis.com/css2?family=Amiko:wght@400;600;700&display=swap',
        array(),
        null
    );

    $base = array(
        'doroshopping-variables' => '/css/base/variables.css',
        'doroshopping-reset'     => '/css/base/reset.css',
        'doroshopping-typography'=> '/css/base/typography.css',
        'doroshopping-a11y'      => '/css/base/a11y.css',
    );

    $deps_prev = array( 'doroshopping-fonts' );
    foreach ( $base as $handle => $path ) {
        wp_enqueue_style( $handle, $uri . $path, $deps_prev, $ver );
        $deps_prev = array( $handle );
    }

    $components = array(
        'doroshopping-header'       => '/css/components/header.css',
        'doroshopping-footer'       => '/css/components/footer.css',
        'doroshopping-cart-modal'   => '/css/components/cart-modal.css',
        'doroshopping-live-search'  => '/css/components/live-search.css',
        'doroshopping-product-card' => '/css/components/product-card.css',
        'doroshopping-auth-modal'   => '/css/components/auth-modal.css',
    );

    foreach ( $components as $handle => $path ) {
        wp_enqueue_style( $handle, $uri . $path, array( 'doroshopping-a11y' ), $ver );
    }

    $style_deps = array( 'doroshopping-header', 'doroshopping-footer', 'doroshopping-cart-modal', 'doroshopping-live-search', 'doroshopping-product-card', 'doroshopping-auth-modal' );

    if ( is_front_page() || is_home() ) {
        wp_enqueue_style( 'doroshopping-home', $uri . '/css/pages/home.css', $style_deps, $ver );
    }

    if ( function_exists( 'is_shop' ) && ( is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag() ) ) {
        wp_enqueue_style( 'doroshopping-shop', $uri . '/css/pages/shop.css', $style_deps, $ver );
    }

    if ( function_exists( 'is_product_category' ) && is_product_category() ) {
        wp_enqueue_style( 'doroshopping-category', $uri . '/css/pages/category.css', array( 'doroshopping-shop' ), $ver );
    }

    if ( function_exists( 'is_product' ) && is_product() ) {
        wp_enqueue_style( 'doroshopping-product', $uri . '/css/pages/product.css', $style_deps, $ver );
    }

    if ( ( function_exists( 'is_cart' ) && is_cart() ) || ( function_exists( 'is_checkout' ) && is_checkout() ) || ( function_exists( 'is_wc_endpoint_url' ) && is_wc_endpoint_url( 'order-received' ) ) ) {
        wp_enqueue_style( 'doroshopping-cart-checkout', $uri . '/css/pages/cart-checkout.css', $style_deps, $ver );
        wp_enqueue_style( 'doroshopping-shop', $uri . '/css/pages/shop.css', $style_deps, $ver );
    }

    if ( function_exists( 'doroshopping_is_wishlist_page' ) && doroshopping_is_wishlist_page() ) {
        wp_enqueue_style( 'doroshopping-wishlist', $uri . '/css/pages/wishlist.css', $style_deps, $ver );
        wp_enqueue_style( 'doroshopping-shop', $uri . '/css/pages/shop.css', $style_deps, $ver );
    }

    if ( is_search() ) {
        wp_enqueue_style( 'doroshopping-shop', $uri . '/css/pages/shop.css', $style_deps, $ver );
        wp_enqueue_style( 'doroshopping-page', $uri . '/css/pages/page.css', $style_deps, $ver );
    } elseif ( is_404() || ( is_page() && ! is_front_page() && ! ( function_exists( 'is_cart' ) && is_cart() ) && ! ( function_exists( 'is_checkout' ) && is_checkout() ) && ! ( function_exists( 'is_account_page' ) && is_account_page() ) && ! ( function_exists( 'doroshopping_is_wishlist_page' ) && doroshopping_is_wishlist_page() ) ) ) {
        wp_enqueue_style( 'doroshopping-page', $uri . '/css/pages/page.css', $style_deps, $ver );
    }

    if ( function_exists( 'is_account_page' ) && is_account_page() ) {
        wp_enqueue_style( 'doroshopping-account', $uri . '/css/pages/account.css', $style_deps, $ver );
    }

    // Fallback bundle para plantillas Elementor / otras.
    if (
        ! wp_style_is( 'doroshopping-home', 'enqueued' )
        && ! wp_style_is( 'doroshopping-shop', 'enqueued' )
        && ! wp_style_is( 'doroshopping-product', 'enqueued' )
        && ! wp_style_is( 'doroshopping-cart-checkout', 'enqueued' )
        && ! wp_style_is( 'doroshopping-wishlist', 'enqueued' )
        && ! wp_style_is( 'doroshopping-account', 'enqueued' )
        && ! wp_style_is( 'doroshopping-page', 'enqueued' )
        && ! wp_style_is( 'doroshopping-category', 'enqueued' )
    ) {
        wp_enqueue_style( 'doroshopping-home', $uri . '/css/pages/home.css', $style_deps, $ver );
        wp_enqueue_style( 'doroshopping-shop', $uri . '/css/pages/shop.css', $style_deps, $ver );
        wp_enqueue_style( 'doroshopping-product', $uri . '/css/pages/product.css', $style_deps, $ver );
    }

    // Handle fantasma para inline CSS del customizer.
    wp_register_style( 'doroshopping-main', false, $style_deps, $ver );
    wp_enqueue_style( 'doroshopping-main' );

    $script_deps = array();
    if ( class_exists( 'WooCommerce' ) ) {
        $script_deps[] = 'jquery';
        wp_enqueue_script( 'wc-add-to-cart' );
        wp_enqueue_script( 'wc-cart-fragments' );
    }

    wp_enqueue_script( 'doroshopping-main', $uri . '/js/main.js', $script_deps, $ver, true );

    $cart_count = ( function_exists( 'WC' ) && WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0;

    wp_localize_script(
        'doroshopping-main',
        'doroshoppingCart',
        array(
            'ajaxUrl'      => admin_url( 'admin-ajax.php' ),
            'wcAjaxUrl'    => class_exists( 'WC_AJAX' ) ? WC_AJAX::get_endpoint( '%%endpoint%%' ) : '',
            'nonce'        => wp_create_nonce( 'doroshopping_cart' ),
            'checkoutUrl'  => function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : home_url( '/' ),
            'cartUrl'      => function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/' ),
            'i18n'         => array(
                'empty'     => __( 'Tu carrito está vacío.', 'doroshopping' ),
                'remove'    => __( 'Eliminar producto', 'doroshopping' ),
                'decrease'  => __( 'Reducir cantidad', 'doroshopping' ),
                'increase'  => __( 'Aumentar cantidad', 'doroshopping' ),
                'adding'    => __( 'Añadiendo…', 'doroshopping' ),
                'added'     => __( 'Añadido al carrito', 'doroshopping' ),
                'error'     => __( 'No se pudo añadir al carrito.', 'doroshopping' ),
            ),
            'initialCount' => $cart_count,
        )
    );

    wp_localize_script(
        'doroshopping-main',
        'doroshoppingSearch',
        array(
            'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'doroshopping_search' ),
            'minChars' => 2,
            'i18n'     => array(
                'empty'   => __( 'No se encontraron productos.', 'doroshopping' ),
                'loading' => __( 'Buscando…', 'doroshopping' ),
                'viewAll' => __( 'Ver todos los resultados', 'doroshopping' ),
            ),
        )
    );

    wp_localize_script(
        'doroshopping-main',
        'doroshoppingWishlist',
        array(
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'doroshopping_wishlist' ),
            'pageUrl' => function_exists( 'doroshopping_get_wishlist_url' ) ? doroshopping_get_wishlist_url() : home_url( '/lista-de-deseos/' ),
            'ids'     => function_exists( 'doroshopping_get_wishlist_ids' ) ? doroshopping_get_wishlist_ids() : array(),
            'i18n'    => array(
                'added'   => __( 'Añadido a la lista de deseos.', 'doroshopping' ),
                'removed' => __( 'Eliminado de la lista de deseos.', 'doroshopping' ),
            ),
        )
    );
}
add_action( 'wp_enqueue_scripts', 'doroshopping_enqueue_assets' );

/**
 * Preload fuente / LCP opcional.
 */
function doroshopping_resource_hints( $urls, $relation_type ) {
    if ( 'preconnect' === $relation_type ) {
        $urls[] = array(
            'href' => 'https://fonts.googleapis.com',
            'crossorigin' => false,
        );
        $urls[] = array(
            'href'        => 'https://fonts.gstatic.com',
            'crossorigin' => 'anonymous',
        );
    }
    return $urls;
}
add_filter( 'wp_resource_hints', 'doroshopping_resource_hints', 10, 2 );
