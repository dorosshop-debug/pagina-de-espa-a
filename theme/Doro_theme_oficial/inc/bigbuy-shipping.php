<?php
/**
 * Estimación de envío BigBuy (REST + fallback por país).
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
 * Endpoint REST BigBuy shipping orders.
 *
 * @return string
 */
function doroshopping_bigbuy_endpoint() {
    if ( defined( 'DORO_BIGBUY_ENDPOINT' ) && DORO_BIGBUY_ENDPOINT ) {
        return (string) DORO_BIGBUY_ENDPOINT;
    }
    $custom = (string) get_theme_mod( 'doroshopping_bigbuy_endpoint', '' );
    if ( $custom ) {
        return $custom;
    }
    return 'https://api.bigbuy.eu/rest/shipping/orders.json';
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
            'time'    => '3 - 5 días hábiles',
            'cost'    => '8.90 EUR',
        ),
        'GB' => array(
            'carrier' => 'Royal Mail / DHL',
            'time'    => '5 - 8 días hábiles',
            'cost'    => '12.90 GBP',
        ),
        'UK' => array(
            'carrier' => 'Royal Mail / DHL',
            'time'    => '5 - 8 días hábiles',
            'cost'    => '12.90 GBP',
        ),
        'ES' => array(
            'carrier' => 'Correos Express / SEUR',
            'time'    => '2 - 4 días hábiles',
            'cost'    => '6.90 EUR',
        ),
        'FR' => array(
            'carrier' => 'Colissimo / DHL',
            'time'    => '3 - 5 días hábiles',
            'cost'    => '7.90 EUR',
        ),
        'IT' => array(
            'carrier' => 'BRT / DHL',
            'time'    => '4 - 6 días hábiles',
            'cost'    => '8.90 EUR',
        ),
        'PT' => array(
            'carrier' => 'CTT / DHL',
            'time'    => '3 - 5 días hábiles',
            'cost'    => '6.90 EUR',
        ),
        'CH' => array(
            'carrier' => 'Swiss Post / DHL',
            'time'    => '5 - 8 días hábiles',
            'cost'    => '14.90 CHF',
        ),
    );

    $data = isset( $fallbacks[ $country ] ) ? $fallbacks[ $country ] : $fallbacks['ES'];

    $note = __( 'Coste estimado según destino. El importe final puede variar ligeramente en checkout.', 'doroshopping' );
    if ( $reason && ! doroshopping_bigbuy_api_key() ) {
        $note = __( 'Estimación local. Configura la API key de BigBuy en Personalizar o wp-config.', 'doroshopping' );
    }

    return array(
        'success'  => true,
        'source'   => 'fallback',
        'carrier'  => $data['carrier'],
        'time'     => $data['time'],
        'cost'     => $data['cost'],
        'note'     => $note,
        'country'  => $country,
    );
}

/**
 * Parsear respuesta BigBuy.
 *
 * @param array  $body    JSON.
 * @param string $country ISO2.
 * @return array
 */
function doroshopping_parse_bigbuy_shipping_response( $body, $country ) {
    if ( ! is_array( $body ) ) {
        return doroshopping_bigbuy_shipping_fallback( $country, 'invalid_body' );
    }

    $methods = $body['shippingMethods']
        ?? $body['shipping_methods']
        ?? $body['carriers']
        ?? $body['data']
        ?? $body;

    if ( ! is_array( $methods ) ) {
        return doroshopping_bigbuy_shipping_fallback( $country, 'no_carriers' );
    }

    $first = array_values( $methods )[0] ?? array();
    if ( ! is_array( $first ) ) {
        return doroshopping_bigbuy_shipping_fallback( $country, 'bad_carrier' );
    }

    $carrier = $first['name']
        ?? $first['carrier']
        ?? $first['transport']
        ?? $first['shipping_service']
        ?? 'Transportista BigBuy';

    $price = $first['price']
        ?? $first['cost']
        ?? $first['amount']
        ?? null;

    $currency = $first['currency'] ?? 'EUR';

    $days = $first['deliveryTime']
        ?? $first['delivery_time']
        ?? $first['transitTime']
        ?? __( 'Según disponibilidad', 'doroshopping' );

    if ( is_array( $days ) ) {
        $days = implode( ' - ', $days ) . ' ' . __( 'días hábiles', 'doroshopping' );
    }

    return array(
        'success' => true,
        'source'  => 'bigbuy',
        'carrier' => (string) $carrier,
        'time'    => (string) $days,
        'cost'    => null !== $price
            ? number_format( (float) $price, 2, '.', '' ) . ' ' . $currency
            : __( 'Calculado por BigBuy', 'doroshopping' ),
        'note'    => __( 'Información calculada según BigBuy. El coste final puede variar en checkout.', 'doroshopping' ),
        'country' => strtoupper( $country ),
    );
}

/**
 * Referencia BigBuy de un producto WC.
 *
 * @param WC_Product $product Producto.
 * @return string
 */
function doroshopping_bigbuy_product_reference( $product ) {
    if ( ! $product ) {
        return '';
    }
    $id  = $product->get_id();
    $ref = get_post_meta( $id, '_bigbuy_id', true );
    if ( ! $ref ) {
        $ref = $product->get_sku();
    }
    return $ref ? (string) $ref : '';
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

    $payload = array(
        'destination' => array(
            'country'  => $country,
            'postcode' => $postcode,
        ),
        'products'    => $products,
    );

    $response = wp_remote_post(
        doroshopping_bigbuy_endpoint(),
        array(
            'timeout' => 8,
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
        return doroshopping_bigbuy_shipping_fallback( $country, 'bad_response' );
    }

    return doroshopping_parse_bigbuy_shipping_response( $body, $country );
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

    $estimate['destination'] = isset( $loc['label'] ) ? $loc['label'] : $country;
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
        if ( ! empty( $loc['label'] ) ) {
            return $loc['label'];
        }
    }
    return $label;
}
add_filter( 'doroshopping_shipping_destination_label', 'doroshopping_filter_shipping_destination_label' );

