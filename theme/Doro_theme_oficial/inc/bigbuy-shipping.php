<?php
/**
 * Estimación de envío BigBuy (Shipping API oficial).
 *
 * Guía: POST /rest/shipping/orders.json
 * Auth: Authorization: Bearer API_KEY
 * Base: https://api.bigbuy.eu | sandbox: https://api.sandbox.bigbuy.eu
 *
 * API key: define('DORO_BIGBUY_API_KEY', '...') en wp-config.php
 * o Personalizar > DoroTheme > BigBuy.
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Clave API BigBuy.
 *
 * @return string
 */
function doroshopping_bigbuy_api_key() {
    if ( defined( 'DORO_BIGBUY_API_KEY' ) && DORO_BIGBUY_API_KEY ) {
        return (string) DORO_BIGBUY_API_KEY;
    }
    return (string) get_theme_mod( 'doroshopping_bigbuy_api_key', '' );
}

/**
 * Modo API: live | sandbox.
 *
 * @return string
 */
function doroshopping_bigbuy_mode() {
    if ( defined( 'DORO_BIGBUY_MODE' ) && DORO_BIGBUY_MODE ) {
        $mode = strtolower( (string) DORO_BIGBUY_MODE );
        return ( 'sandbox' === $mode ) ? 'sandbox' : 'live';
    }
    $mode = strtolower( (string) get_theme_mod( 'doroshopping_bigbuy_mode', 'live' ) );
    return ( 'sandbox' === $mode ) ? 'sandbox' : 'live';
}

/**
 * URL base BigBuy según modo.
 *
 * @return string
 */
function doroshopping_bigbuy_base_url() {
    if ( defined( 'DORO_BIGBUY_BASE_URL' ) && DORO_BIGBUY_BASE_URL ) {
        return untrailingslashit( (string) DORO_BIGBUY_BASE_URL );
    }
    return ( 'sandbox' === doroshopping_bigbuy_mode() )
        ? 'https://api.sandbox.bigbuy.eu'
        : 'https://api.bigbuy.eu';
}

/**
 * Endpoint REST BigBuy shipping orders (formato oficial de la guía).
 *
 * @return string
 */
function doroshopping_bigbuy_endpoint() {
    if ( defined( 'DORO_BIGBUY_ENDPOINT' ) && DORO_BIGBUY_ENDPOINT ) {
        $forced = (string) DORO_BIGBUY_ENDPOINT;
        return doroshopping_bigbuy_sanitize_endpoint( $forced )
            ? $forced
            : doroshopping_bigbuy_base_url() . '/rest/shipping/orders.json';
    }
    $custom = (string) get_theme_mod( 'doroshopping_bigbuy_endpoint', '' );
    if ( $custom && doroshopping_bigbuy_sanitize_endpoint( $custom ) ) {
        return esc_url_raw( $custom );
    }
    return doroshopping_bigbuy_base_url() . '/rest/shipping/orders.json';
}

/**
 * Solo permitir hosts BigBuy (evita SSRF vía Customizer).
 *
 * @param string $url URL.
 * @return bool
 */
function doroshopping_bigbuy_sanitize_endpoint( $url ) {
    $url = esc_url_raw( (string) $url );
    if ( ! $url || 0 !== strpos( $url, 'https://' ) ) {
        return false;
    }
    $host = wp_parse_url( $url, PHP_URL_HOST );
    if ( ! is_string( $host ) || '' === $host ) {
        return false;
    }
    $host = strtolower( $host );
    return (bool) preg_match( '/(^|\.)bigbuy\.eu$/', $host );
}

/**
 * Código postal guardado (cookie / WC).
 *
 * @return string
 */
function doroshopping_get_shipping_postcode() {
    if ( ! empty( $_COOKIE['doroshopping_postcode'] ) ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
        return sanitize_text_field( wp_unslash( $_COOKIE['doroshopping_postcode'] ) );
    }
    if ( function_exists( 'WC' ) && WC()->customer ) {
        return (string) WC()->customer->get_shipping_postcode();
    }
    return '';
}

/**
 * Fallback local por país (si BigBuy no responde o no hay API key).
 *
 * @param string $country ISO2.
 * @param string $reason  Motivo opcional.
 * @return array
 */
function doroshopping_bigbuy_shipping_fallback( $country, $reason = '' ) {
    $country   = strtoupper( sanitize_text_field( $country ) );
    $fallbacks = array(
        'DE' => array(
            'carrier' => 'DHL / DPD',
            'range'   => '3 - 5',
            'cost'    => '8.90 EUR',
        ),
        'GB' => array(
            'carrier' => 'Royal Mail / DHL',
            'range'   => '5 - 8',
            'cost'    => '12.90 GBP',
        ),
        'UK' => array(
            'carrier' => 'Royal Mail / DHL',
            'range'   => '5 - 8',
            'cost'    => '12.90 GBP',
        ),
        'ES' => array(
            'carrier' => 'Correos Express / SEUR',
            'range'   => '2 - 4',
            'cost'    => '6.90 EUR',
        ),
        'FR' => array(
            'carrier' => 'Colissimo / DHL',
            'range'   => '3 - 5',
            'cost'    => '7.90 EUR',
        ),
        'IT' => array(
            'carrier' => 'BRT / DHL',
            'range'   => '4 - 6',
            'cost'    => '8.90 EUR',
        ),
        'PT' => array(
            'carrier' => 'CTT / DHL',
            'range'   => '3 - 5',
            'cost'    => '6.90 EUR',
        ),
        'CH' => array(
            'carrier' => 'Swiss Post / DHL',
            'range'   => '5 - 8',
            'cost'    => '14.90 CHF',
        ),
    );

    $data = isset( $fallbacks[ $country ] ) ? $fallbacks[ $country ] : $fallbacks['ES'];
    $time = function_exists( 'doroshopping_ui_eta_days' )
        ? doroshopping_ui_eta_days( $data['range'] )
        : ( $data['range'] . ' días hábiles' );

    $note = function_exists( 'doroshopping_ui_text' )
        ? doroshopping_ui_text( 'doroshopping_ui_product_ship_note' )
        : __( 'Coste estimado según destino. El importe final puede variar ligeramente en checkout.', 'doroshopping' );
    if ( $reason && ! doroshopping_bigbuy_api_key() ) {
        $note = function_exists( 'doroshopping_ui_text' )
            ? doroshopping_ui_text( 'doroshopping_ui_product_ship_note_local' )
            : __( 'Estimación local. Configura la API key de BigBuy en Personalizar o wp-config.', 'doroshopping' );
    }

    return array(
        'success'  => true,
        'source'   => 'fallback',
        'carrier'  => $data['carrier'],
        'time'     => $time,
        'cost'     => $data['cost'],
        'note'     => $note,
        'country'  => $country,
        'options'  => array(),
        'reason'   => $reason ? sanitize_key( $reason ) : '',
    );
}

/**
 * Normalizar una opción de shippingOptions (guía BigBuy).
 *
 * @param array $option Opción cruda.
 * @return array|null
 */
function doroshopping_bigbuy_normalize_shipping_option( $option ) {
    if ( ! is_array( $option ) ) {
        return null;
    }

    $service = isset( $option['shippingService'] ) && is_array( $option['shippingService'] )
        ? $option['shippingService']
        : $option;

    $name = $service['serviceName']
        ?? $service['name']
        ?? $option['name']
        ?? $option['carrier']
        ?? '';

    if ( ! $name ) {
        return null;
    }

    $delay = $service['delay']
        ?? $option['delay']
        ?? $option['deliveryTime']
        ?? $option['delivery_time']
        ?? __( 'Según disponibilidad', 'doroshopping' );

    if ( is_array( $delay ) ) {
        $delay = implode( ' - ', array_map( 'strval', $delay ) ) . ' ' . __( 'días', 'doroshopping' );
    }

    $cost_raw = $option['cost'] ?? $option['price'] ?? $option['amount'] ?? null;
    $cost_num = ( null !== $cost_raw && is_numeric( $cost_raw ) ) ? (float) $cost_raw : null;

    return array(
        'id'               => isset( $service['id'] ) ? (string) $service['id'] : '',
        'carrier'          => (string) $name,
        'service_name'     => strtolower( sanitize_title( (string) $name ) ),
        'time'             => (string) $delay,
        'cost'             => $cost_num,
        'cost_label'       => null !== $cost_num
            ? number_format( $cost_num, 2, '.', '' ) . ' EUR'
            : __( 'Consultar', 'doroshopping' ),
        'transport_method' => isset( $service['transportMethod'] ) ? (string) $service['transportMethod'] : '',
        'weight'           => isset( $option['weight'] ) ? (float) $option['weight'] : null,
    );
}

/**
 * Parsear respuesta BigBuy Shipping API (shippingOptions).
 *
 * @param array  $body    JSON.
 * @param string $country ISO2.
 * @return array
 */
function doroshopping_parse_bigbuy_shipping_response( $body, $country ) {
    if ( ! is_array( $body ) ) {
        return doroshopping_bigbuy_shipping_fallback( $country, 'invalid_body' );
    }

    // Formato oficial guía: shippingOptions[].
    $raw_options = $body['shippingOptions']
        ?? $body['shipping_options']
        ?? $body['shippingMethods']
        ?? $body['shipping_methods']
        ?? $body['carriers']
        ?? $body['data']
        ?? null;

    // A veces la raíz ya es la lista.
    if ( null === $raw_options && isset( $body[0] ) ) {
        $raw_options = $body;
    }

    if ( ! is_array( $raw_options ) || empty( $raw_options ) ) {
        return doroshopping_bigbuy_shipping_fallback( $country, 'no_carriers' );
    }

    $options = array();
    foreach ( $raw_options as $raw ) {
        $normalized = doroshopping_bigbuy_normalize_shipping_option( $raw );
        if ( $normalized ) {
            $options[] = $normalized;
        }
    }

    if ( empty( $options ) ) {
        return doroshopping_bigbuy_shipping_fallback( $country, 'bad_carrier' );
    }

    // Elegir la opción más barata (como hace BigBuy al crear pedido).
    usort(
        $options,
        static function ( $a, $b ) {
            $ca = isset( $a['cost'] ) && null !== $a['cost'] ? (float) $a['cost'] : PHP_FLOAT_MAX;
            $cb = isset( $b['cost'] ) && null !== $b['cost'] ? (float) $b['cost'] : PHP_FLOAT_MAX;
            if ( $ca === $cb ) {
                return 0;
            }
            return ( $ca < $cb ) ? -1 : 1;
        }
    );

    $best = $options[0];

    return array(
        'success' => true,
        'source'  => 'bigbuy',
        'carrier' => $best['carrier'],
        'time'    => $best['time'],
        'cost'    => $best['cost_label'],
        'note'    => function_exists( 'doroshopping_ui_text' )
            ? doroshopping_ui_text( 'doroshopping_ui_product_ship_note_api' )
            : __( 'Tarifa BigBuy (opción más económica). El coste final puede variar en checkout.', 'doroshopping' ),
        'country' => strtoupper( $country ),
        'options' => array_slice( $options, 0, 5 ),
        'mode'    => doroshopping_bigbuy_mode(),
    );
}

/**
 * Referencia BigBuy de un producto WC (SKU / meta de plugins).
 *
 * @param WC_Product $product Producto.
 * @return string
 */
function doroshopping_bigbuy_product_reference( $product ) {
    if ( ! $product ) {
        return '';
    }

    $id    = $product->get_id();
    $metas = array(
        '_bigbuy_id',
        '_bigbuy_sku',
        '_bigbuy_reference',
        'bigbuy_sku',
        'bigbuy_reference',
        '_sku_bigbuy',
    );

    foreach ( $metas as $meta_key ) {
        $ref = get_post_meta( $id, $meta_key, true );
        if ( $ref ) {
            return (string) $ref;
        }
    }

    // Variación: a veces el SKU BigBuy está en el padre.
    if ( $product->is_type( 'variation' ) ) {
        $parent_id = $product->get_parent_id();
        foreach ( $metas as $meta_key ) {
            $ref = get_post_meta( $parent_id, $meta_key, true );
            if ( $ref ) {
                return (string) $ref;
            }
        }
        $parent = wc_get_product( $parent_id );
        if ( $parent && $parent->get_sku() ) {
            return (string) $parent->get_sku();
        }
    }

    $sku = $product->get_sku();
    return $sku ? (string) $sku : '';
}

/**
 * Payload oficial según guía BigBuy Shipping API.
 *
 * @param string $country  ISO2.
 * @param string $postcode CP.
 * @param array  $products Productos normalizados.
 * @return array
 */
function doroshopping_bigbuy_shipping_payload( $country, $postcode, $products ) {
    $delivery = array(
        'isoCountry' => strtoupper( $country ),
    );
    if ( $postcode ) {
        $delivery['postcode'] = $postcode;
    }

    $lines = array();
    foreach ( $products as $product ) {
        $ref = isset( $product['reference'] ) ? (string) $product['reference'] : '';
        if ( ! $ref && ! empty( $product['sku'] ) ) {
            $ref = (string) $product['sku'];
        }
        if ( ! $ref ) {
            continue;
        }
        $lines[] = array(
            'reference' => $ref,
            'quantity'  => isset( $product['quantity'] ) ? max( 1, absint( $product['quantity'] ) ) : 1,
        );
    }

    return array(
        'order' => array(
            'delivery' => $delivery,
            'products' => $lines,
        ),
    );
}

/**
 * Consultar BigBuy (o fallback) para una lista de líneas.
 *
 * @param string $country  ISO2.
 * @param string $postcode CP.
 * @param array  $lines    [ ['reference'=>, 'sku'=>, 'quantity'=>], ... ].
 * @return array
 */
function doroshopping_bigbuy_quote( $country, $postcode, $lines ) {
    $country  = strtoupper( sanitize_text_field( $country ) );
    $postcode = sanitize_text_field( $postcode );
    $lines    = is_array( $lines ) ? $lines : array();

    if ( ! $country ) {
        return array(
            'success' => false,
            'message' => __( 'Faltan datos para calcular el envío.', 'doroshopping' ),
        );
    }

    $products = array();
    foreach ( $lines as $line ) {
        $ref = isset( $line['reference'] ) ? sanitize_text_field( $line['reference'] ) : '';
        $sku = isset( $line['sku'] ) ? sanitize_text_field( $line['sku'] ) : $ref;
        $qty = isset( $line['quantity'] ) ? max( 1, absint( $line['quantity'] ) ) : 1;
        if ( ! $ref && ! $sku ) {
            continue;
        }
        $products[] = array(
            'reference' => $ref ? $ref : $sku,
            'sku'       => $sku ? $sku : $ref,
            'quantity'  => $qty,
        );
    }

    if ( empty( $products ) ) {
        return doroshopping_bigbuy_shipping_fallback( $country, 'no_sku' );
    }

    $api_key = doroshopping_bigbuy_api_key();
    if ( ! $api_key ) {
        return doroshopping_bigbuy_shipping_fallback( $country, 'no_api_key' );
    }

    // Cache corta para no saturar la API (misma clave país+CP+productos).
    $cache_key = 'doro_bb_ship_' . md5(
        wp_json_encode(
            array(
                'c' => $country,
                'p' => $postcode,
                'm' => doroshopping_bigbuy_mode(),
                'l' => $products,
            )
        )
    );
    $cached = get_transient( $cache_key );
    if ( is_array( $cached ) && ! empty( $cached['success'] ) ) {
        $cached['cached'] = true;
        return $cached;
    }

    $payload = doroshopping_bigbuy_shipping_payload( $country, $postcode, $products );

    $response = wp_remote_post(
        doroshopping_bigbuy_endpoint(),
        array(
            'timeout' => 12,
            'headers' => array(
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
            ),
            'body'    => wp_json_encode( $payload ),
        )
    );

    if ( is_wp_error( $response ) ) {
        return doroshopping_bigbuy_shipping_fallback( $country, $response->get_error_message() );
    }

    $code = (int) wp_remote_retrieve_response_code( $response );
    $body = json_decode( wp_remote_retrieve_body( $response ), true );

    if ( $code < 200 || $code >= 300 || ! is_array( $body ) ) {
        return doroshopping_bigbuy_shipping_fallback( $country, 'http_' . $code );
    }

    $parsed = doroshopping_parse_bigbuy_shipping_response( $body, $country );
    if ( ! empty( $parsed['success'] ) && 'bigbuy' === ( $parsed['source'] ?? '' ) ) {
        set_transient( $cache_key, $parsed, 15 * MINUTE_IN_SECONDS );
    }

    return $parsed;
}

/**
 * REST: POST /wp-json/doro/v1/bigbuy-shipping
 *
 * @param WP_REST_Request $request Request.
 * @return WP_REST_Response
 */
function doroshopping_bigbuy_shipping_endpoint( WP_REST_Request $request ) {
    $nonce = $request->get_header( 'X-WP-Nonce' );
    if ( ! $nonce ) {
        $nonce = $request->get_param( '_wpnonce' );
    }
    // En preview/local sin nonce: solo fallback (no llama a BigBuy API).
    $nonce_ok = $nonce && wp_verify_nonce( $nonce, 'wp_rest' );

    if ( function_exists( 'doroshopping_rate_limit' ) && ! doroshopping_rate_limit( 'bigbuy_ship', 20, 60 ) ) {
        return new WP_REST_Response(
            array(
                'success' => false,
                'message' => __( 'Demasiadas peticiones. Espera un momento e inténtalo de nuevo.', 'doroshopping' ),
            ),
            429
        );
    }

    $country  = strtoupper( sanitize_text_field( (string) $request->get_param( 'country' ) ) );
    $postcode = sanitize_text_field( (string) $request->get_param( 'postcode' ) );
    $lines    = $request->get_param( 'products' );

    if ( ! is_array( $lines ) || empty( $lines ) ) {
        $product_id = absint( $request->get_param( 'product_id' ) );
        $quantity   = max( 1, absint( $request->get_param( 'quantity' ) ) );

        if ( ! $product_id || ! $country ) {
            return new WP_REST_Response(
                array(
                    'success' => false,
                    'message' => __( 'Faltan datos para calcular el envío.', 'doroshopping' ),
                ),
                400
            );
        }

        if ( ! function_exists( 'wc_get_product' ) ) {
            return new WP_REST_Response(
                array(
                    'success' => false,
                    'message' => __( 'WooCommerce no está disponible.', 'doroshopping' ),
                ),
                500
            );
        }

        $product = wc_get_product( $product_id );
        if ( ! $product ) {
            return new WP_REST_Response(
                array(
                    'success' => false,
                    'message' => __( 'Producto no encontrado.', 'doroshopping' ),
                ),
                404
            );
        }

        $ref = doroshopping_bigbuy_product_reference( $product );
        if ( ! $ref ) {
            return new WP_REST_Response( doroshopping_bigbuy_shipping_fallback( $country, 'no_sku' ), 200 );
        }

        $lines = array(
            array(
                'reference' => $ref,
                'sku'       => $ref,
                'quantity'  => $quantity,
            ),
        );
    }

    if ( ! $country ) {
        return new WP_REST_Response(
            array(
                'success' => false,
                'message' => __( 'Faltan datos para calcular el envío.', 'doroshopping' ),
            ),
            400
        );
    }

    // Sin nonce válido: estimación local (evita abuso de la API BigBuy).
    if ( ! $nonce_ok || ! doroshopping_bigbuy_api_key() ) {
        return new WP_REST_Response( doroshopping_bigbuy_shipping_fallback( $country, $nonce_ok ? 'no_api_key' : 'no_nonce' ), 200 );
    }

    $parsed = doroshopping_bigbuy_quote( $country, $postcode, $lines );
    return new WP_REST_Response( $parsed, 200 );
}

/**
 * Registrar ruta REST.
 */
function doroshopping_register_bigbuy_rest() {
    register_rest_route(
        'doro/v1',
        '/bigbuy-shipping',
        array(
            'methods'             => 'POST',
            'callback'            => 'doroshopping_bigbuy_shipping_endpoint',
            'permission_callback' => function () {
                return true; // Lectura pública de tarifas; el nonce se valida en callback.
            },
        )
    );
}
add_action( 'rest_api_init', 'doroshopping_register_bigbuy_rest' );

/**
 * Estimación SSR rápida (fallback por país). La API live la hidrata el JS.
 *
 * @param array      $estimate Estimación.
 * @param WC_Product $product  Producto.
 * @return array
 */
function doroshopping_filter_product_shipping_estimate( $estimate, $product ) {
    $loc     = function_exists( 'doroshopping_get_header_location' ) ? doroshopping_get_header_location() : array( 'code' => 'ES', 'label' => 'España' );
    $country = isset( $loc['code'] ) ? $loc['code'] : 'ES';
    $quote   = doroshopping_bigbuy_shipping_fallback( $country, 'ssr' );

    $estimate['destination'] = function_exists( 'doroshopping_ui_country_label' )
        ? doroshopping_ui_country_label( $country )
        : ( isset( $loc['label'] ) ? $loc['label'] : $country );
    $estimate['carrier']     = isset( $quote['carrier'] ) ? $quote['carrier'] : '';
    $estimate['eta']         = isset( $quote['time'] ) ? $quote['time'] : '';
    $estimate['cost_html']   = isset( $quote['cost'] ) ? esc_html( $quote['cost'] ) : '';
    $estimate['note']        = isset( $quote['note'] ) ? $quote['note'] : '';
    $estimate['ready']       = true;
    $estimate['source']      = 'fallback';

    return $estimate;
}
add_filter( 'doroshopping_product_shipping_estimate', 'doroshopping_filter_product_shipping_estimate', 10, 2 );

/**
 * Destino etiqueta desde ubicación header.
 *
 * @param string $label Label.
 * @return string
 */
function doroshopping_filter_shipping_destination_label( $label ) {
    if ( function_exists( 'doroshopping_get_header_location' ) ) {
        $loc = doroshopping_get_header_location();
        if ( ! empty( $loc['code'] ) && function_exists( 'doroshopping_ui_country_label' ) ) {
            return doroshopping_ui_country_label( $loc['code'] );
        }
        if ( ! empty( $loc['label'] ) ) {
            return $loc['label'];
        }
    }
    return $label;
}
add_filter( 'doroshopping_shipping_destination_label', 'doroshopping_filter_shipping_destination_label' );
