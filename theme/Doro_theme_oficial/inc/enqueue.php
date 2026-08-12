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
        'doroshopping-geo-banner'   => '/css/components/geo-banner.css',
    );

    foreach ( $components as $handle => $path ) {
        wp_enqueue_style( $handle, $uri . $path, array( 'doroshopping-a11y' ), $ver );
    }

    $style_deps = array( 'doroshopping-header', 'doroshopping-footer', 'doroshopping-cart-modal', 'doroshopping-live-search', 'doroshopping-product-card', 'doroshopping-auth-modal', 'doroshopping-geo-banner' );

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

    $is_cart_like = ( function_exists( 'is_cart' ) && is_cart() )
        || ( function_exists( 'is_checkout' ) && is_checkout() )
        || ( function_exists( 'is_wc_endpoint_url' ) && is_wc_endpoint_url( 'order-received' ) )
        || ( is_page( array( 'carrito', 'finalizar-compra', 'cart', 'checkout' ) ) );

    if ( $is_cart_like ) {
        wp_enqueue_style( 'doroshopping-cart-checkout', $uri . '/css/pages/cart-checkout.css', $style_deps, $ver );
        wp_enqueue_style( 'doroshopping-shop', $uri . '/css/pages/shop.css', $style_deps, $ver );
    }

    if ( function_exists( 'doroshopping_is_wishlist_page' ) && doroshopping_is_wishlist_page() ) {
        wp_enqueue_style( 'doroshopping-wishlist', $uri . '/css/pages/wishlist.css', $style_deps, $ver );
        wp_enqueue_style( 'doroshopping-shop', $uri . '/css/pages/shop.css', $style_deps, $ver );
    }

    $is_support_page = is_page_template( array(
            'page-coupons.php',
            'page-help.php',
            'page-faq.php',
            'page-payments.php',
            'page-shipping.php',
            'page-buyer-protection.php',
            'page-about.php',
            'page-contact.php',
            'page-returns.php',
            'page-legal.php',
        ) )
        || is_page( array(
            'cupones',
            'centro-de-ayuda',
            'preguntas-frecuentes',
            'ayuda-faq',
            'metodos-de-pago',
            'envios',
            'proteccion-del-comprador',
            'nosotros',
            'contacto',
            'politica-de-devoluciones',
            'politica-de-privacidad',
            'aviso-legal',
            'terminos-y-condiciones',
            'politica-de-cookies',
            'cookies',
        ) );

    if ( $is_support_page ) {
        wp_enqueue_style( 'doroshopping-support', $uri . '/css/pages/support.css', $style_deps, $ver );
    }

    $is_legal_page = is_page_template( 'page-legal.php' )
        || is_page( array(
            'politica-de-privacidad',
            'aviso-legal',
            'terminos-y-condiciones',
            'politica-de-cookies',
            'cookies',
        ) );

    if ( $is_legal_page ) {
        wp_enqueue_style( 'doroshopping-page', $uri . '/css/pages/page.css', $style_deps, $ver );
    }

    if ( is_search() ) {
        wp_enqueue_style( 'doroshopping-shop', $uri . '/css/pages/shop.css', $style_deps, $ver );
        wp_enqueue_style( 'doroshopping-page', $uri . '/css/pages/page.css', $style_deps, $ver );
    } elseif ( is_404() || ( is_page() && ! is_front_page() && ! $is_support_page && ! ( function_exists( 'is_cart' ) && is_cart() ) && ! ( function_exists( 'is_checkout' ) && is_checkout() ) && ! ( function_exists( 'is_account_page' ) && is_account_page() ) && ! ( function_exists( 'doroshopping_is_wishlist_page' ) && doroshopping_is_wishlist_page() ) ) ) {
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
        && ! wp_style_is( 'doroshopping-support', 'enqueued' )
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
    $ui         = static function ( $key, $fallback = '' ) {
        return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : $fallback;
    };

    wp_localize_script(
        'doroshopping-main',
        'doroshoppingHome',
        array(
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'doroshopping_home' ),
            'i18n'    => array(
                'loading'  => $ui( 'doroshopping_ui_loading', __( 'Cargando…', 'doroshopping' ) ),
                'viewMore' => $ui( 'doroshopping_ui_home_ver_mas', __( 'Ver más', 'doroshopping' ) ),
                'viewShop' => $ui( 'doroshopping_ui_home_ver_mas_shop', __( 'Ver más en la tienda', 'doroshopping' ) ),
            ),
        )
    );

    wp_localize_script(
        'doroshopping-main',
        'doroshoppingProductMore',
        array(
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'doroshopping_product_more' ),
            'i18n'    => array(
                'loading'  => $ui( 'doroshopping_ui_loading', __( 'Cargando…', 'doroshopping' ) ),
                'viewMore' => $ui( 'doroshopping_ui_home_ver_mas', __( 'Ver más', 'doroshopping' ) ),
                'viewShop' => $ui( 'doroshopping_ui_home_ver_mas_shop', __( 'Ver más en la tienda', 'doroshopping' ) ),
            ),
        )
    );

    wp_localize_script(
        'doroshopping-main',
        'doroshoppingCart',
        array(
            'ajaxUrl'      => admin_url( 'admin-ajax.php' ),
            'wcAjaxUrl'    => class_exists( 'WC_AJAX' ) ? WC_AJAX::get_endpoint( '%%endpoint%%' ) : '',
            'nonce'        => wp_create_nonce( 'doroshopping_cart' ),
            'checkoutUrl'  => function_exists( 'doroshopping_get_checkout_url' ) ? doroshopping_get_checkout_url() : '',
            'cartUrl'      => function_exists( 'doroshopping_get_cart_url' ) ? doroshopping_get_cart_url() : '',
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

    wp_localize_script(
        'doroshopping-main',
        'doroshoppingGeo',
        array(
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'doroshopping_geo' ),
            'enabled' => function_exists( 'doroshopping_geo_enabled' ) ? (bool) doroshopping_geo_enabled() : false,
            'probe'   => function_exists( 'doroshopping_geo_should_probe' ) ? (bool) doroshopping_geo_should_probe() : false,
        )
    );

    $loc = function_exists( 'doroshopping_get_header_location' ) ? doroshopping_get_header_location() : array( 'code' => 'ES', 'label' => 'España' );
    $cart_lines = array();
    if ( function_exists( 'WC' ) && WC()->cart ) {
        foreach ( WC()->cart->get_cart() as $item ) {
            $p = isset( $item['data'] ) ? $item['data'] : null;
            if ( ! $p || ! is_a( $p, 'WC_Product' ) ) {
                continue;
            }
            $ref = function_exists( 'doroshopping_bigbuy_product_reference' ) ? doroshopping_bigbuy_product_reference( $p ) : $p->get_sku();
            if ( ! $ref ) {
                continue;
            }
            $cart_lines[] = array(
                'reference' => $ref,
                'sku'       => $ref,
                'quantity'  => isset( $item['quantity'] ) ? (int) $item['quantity'] : 1,
            );
        }
    }

    $country_ui = static function ( $code, $fallback ) {
        return function_exists( 'doroshopping_ui_country_label' )
            ? doroshopping_ui_country_label( $code )
            : $fallback;
    };

    wp_localize_script(
        'doroshopping-main',
        'doroshoppingShipping',
        array(
            'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
            'prefsNonce' => wp_create_nonce( 'doroshopping_shipping_prefs' ),
            'restUrl'   => esc_url_raw( rest_url( 'doro/v1/bigbuy-shipping' ) ),
            'nonce'     => wp_create_nonce( 'wp_rest' ),
            'country'   => isset( $loc['code'] ) ? $loc['code'] : 'ES',
            'label'     => isset( $loc['code'] ) && function_exists( 'doroshopping_ui_country_label' )
                ? doroshopping_ui_country_label( $loc['code'] )
                : ( isset( $loc['label'] ) ? $loc['label'] : 'España' ),
            'postcode'  => function_exists( 'doroshopping_get_shipping_postcode' ) ? doroshopping_get_shipping_postcode() : '',
            'cartLines' => $cart_lines,
            'labels'    => array(
                'ES' => $country_ui( 'ES', __( 'España', 'doroshopping' ) ),
                'PT' => $country_ui( 'PT', __( 'Portugal', 'doroshopping' ) ),
                'FR' => $country_ui( 'FR', __( 'Francia', 'doroshopping' ) ),
                'DE' => $country_ui( 'DE', __( 'Alemania', 'doroshopping' ) ),
                'IT' => $country_ui( 'IT', __( 'Italia', 'doroshopping' ) ),
                'GB' => $country_ui( 'GB', __( 'Reino Unido', 'doroshopping' ) ),
                'UK' => $country_ui( 'GB', __( 'Reino Unido', 'doroshopping' ) ),
                'CH' => $country_ui( 'CH', __( 'Suiza', 'doroshopping' ) ),
            ),
            'fallbacks' => array(
                'DE' => array( 'carrier' => 'DHL / DPD', 'range' => '3 - 5', 'cost' => '8.90 EUR' ),
                'GB' => array( 'carrier' => 'Royal Mail / DHL', 'range' => '5 - 8', 'cost' => '12.90 GBP' ),
                'UK' => array( 'carrier' => 'Royal Mail / DHL', 'range' => '5 - 8', 'cost' => '12.90 GBP' ),
                'ES' => array( 'carrier' => 'Correos Express / SEUR', 'range' => '2 - 4', 'cost' => '6.90 EUR' ),
                'FR' => array( 'carrier' => 'Colissimo / DHL', 'range' => '3 - 5', 'cost' => '7.90 EUR' ),
                'IT' => array( 'carrier' => 'BRT / DHL', 'range' => '4 - 6', 'cost' => '8.90 EUR' ),
                'PT' => array( 'carrier' => 'CTT / DHL', 'range' => '3 - 5', 'cost' => '6.90 EUR' ),
                'CH' => array( 'carrier' => 'Swiss Post / DHL', 'range' => '5 - 8', 'cost' => '14.90 CHF' ),
            ),
            'i18n'      => array(
                'loading'      => $ui( 'doroshopping_ui_ship_calc_loading', __( 'Calculando envío…', 'doroshopping' ) ),
                'error'        => $ui( 'doroshopping_ui_ship_calc_error', __( 'No se pudo calcular el envío.', 'doroshopping' ) ),
                'emptyAddress' => $ui( 'doroshopping_ui_checkout_empty_address', $ui( 'doroshopping_ui_ship_empty', __( 'Aún no has añadido una dirección de entrega.', 'doroshopping' ) ) ),
                'addressAdd'   => $ui( 'doroshopping_ui_checkout_address_modal_title', __( 'Añadir nueva dirección', 'doroshopping' ) ),
                'addressEdit'  => $ui( 'doroshopping_ui_checkout_edit_address', __( 'Editar dirección', 'doroshopping' ) ),
                'etaDays'      => $ui( 'doroshopping_ui_product_eta_days', __( '%s días hábiles', 'doroshopping' ) ),
                'note'         => $ui( 'doroshopping_ui_product_ship_note', __( 'Coste estimado según destino. El importe final puede variar ligeramente en checkout.', 'doroshopping' ) ),
            ),
            'localeMap' => function_exists( 'doroshopping_get_location_locale_map' ) ? doroshopping_get_location_locale_map() : array(),
            'preview'   => false,
            'checkoutUrl' => function_exists( 'doroshopping_get_checkout_url' ) ? doroshopping_get_checkout_url() : '',
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
