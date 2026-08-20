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
    static $cached = null;
    if ( null !== $cached ) {
        return $cached;
    }
    if ( defined( 'DORO_BIGBUY_API_KEY' ) && DORO_BIGBUY_API_KEY ) {
        $cached = trim( (string) DORO_BIGBUY_API_KEY );
        return $cached;
    }
    $cached = trim( (string) get_theme_mod( 'doroshopping_bigbuy_api_key', '' ) );
    return $cached;
}

/**
 * Sanear referencia / SKU BigBuy (longitud y caracteres).
 *
 * @param string $ref Referencia cruda.
 * @return string
 */
function doroshopping_bigbuy_sanitize_reference( $ref ) {
    $ref = sanitize_text_field( (string) $ref );
    $ref = substr( $ref, 0, 64 );
    // BigBuy suele usar alfanumérico, guiones y puntos.
    $ref = preg_replace( '/[^A-Za-z0-9._\-\/]/', '', $ref );
    return is_string( $ref ) ? $ref : '';
}

/**
 * Sanear código postal (máx. 16).
 *
 * @param string $postcode CP.
 * @return string
 */
function doroshopping_bigbuy_sanitize_postcode( $postcode ) {
    $postcode = sanitize_text_field( (string) $postcode );
    $postcode = preg_replace( '/[^\p{L}\p{N}\s\-]/u', '', $postcode );
    return substr( is_string( $postcode ) ? trim( $postcode ) : '', 0, 16 );
}

/**
 * Motivo seguro (sin mensajes internos de WP_Error / red).
 *
 * @param string $reason Reason.
 * @return string
 */
function doroshopping_bigbuy_sanitize_reason( $reason ) {
    $reason = sanitize_key( (string) $reason );
    return substr( $reason, 0, 40 );
}

/**
 * Normalizar y fusionar líneas de productos (límites anti-abuso).
 *
 * @param array $lines     Líneas crudas.
 * @param int   $max_lines Máx. líneas.
 * @param int   $max_qty   Máx. qty por línea.
 * @return array<int,array{reference:string,sku:string,quantity:int}>
 */
function doroshopping_bigbuy_normalize_lines( $lines, $max_lines = 20, $max_qty = 99 ) {
    $merged    = array();
    $max_lines = max( 1, (int) $max_lines );
    $max_qty   = max( 1, (int) $max_qty );

    if ( ! is_array( $lines ) ) {
        return array();
    }

    foreach ( $lines as $line ) {
        if ( ! is_array( $line ) ) {
            continue;
        }
        $ref = doroshopping_bigbuy_sanitize_reference( isset( $line['reference'] ) ? $line['reference'] : '' );
        $sku = doroshopping_bigbuy_sanitize_reference( isset( $line['sku'] ) ? $line['sku'] : $ref );
        if ( ! $ref && $sku ) {
            $ref = $sku;
        }
        if ( ! $ref ) {
            continue;
        }
        $upper = strtoupper( $ref );
        if ( in_array( $upper, array( 'PREVIEW', 'TEST', 'NULL', 'UNDEFINED' ), true ) ) {
            continue;
        }
        $qty = isset( $line['quantity'] ) ? absint( $line['quantity'] ) : 1;
        $qty = max( 1, min( $max_qty, $qty ) );
        if ( isset( $merged[ $ref ] ) ) {
            $merged[ $ref ]['quantity'] = min( $max_qty, $merged[ $ref ]['quantity'] + $qty );
        } else {
            $merged[ $ref ] = array(
                'reference' => $ref,
                'sku'       => $sku ? $sku : $ref,
                'quantity'  => $qty,
            );
        }
        if ( count( $merged ) >= $max_lines ) {
            break;
        }
    }

    return array_values( $merged );
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
        return doroshopping_bigbuy_sanitize_postcode( wp_unslash( $_COOKIE['doroshopping_postcode'] ) );
    }
    if ( function_exists( 'WC' ) && WC()->customer ) {
        return doroshopping_bigbuy_sanitize_postcode( WC()->customer->get_shipping_postcode() );
    }
    return '';
}

/**
 * Extraer importe numérico de una etiqueta tipo "6.90 EUR".
 *
 * @param string $label Label.
 * @return float
 */
function doroshopping_bigbuy_parse_cost_amount( $label ) {
    if ( preg_match( '/([0-9]+(?:[.,][0-9]+)?)/', (string) $label, $m ) ) {
        return (float) str_replace( ',', '.', $m[1] );
    }
    return 0.0;
}

/**
 * Contexto de peso/cantidad del package o carrito (para fallback escalado).
 *
 * @param array|null $package Package WC opcional.
 * @return array{quantity:int,weight:float,billable_kg:int}
 */
function doroshopping_bigbuy_shipping_context( $package = null ) {
    $quantity = 0;
    $weight   = 0.0;

    $contents = array();
    if ( is_array( $package ) && ! empty( $package['contents'] ) && is_array( $package['contents'] ) ) {
        $contents = $package['contents'];
    } elseif ( function_exists( 'WC' ) && WC()->cart ) {
        $contents = WC()->cart->get_cart();
        if ( is_callable( array( WC()->cart, 'get_cart_contents_weight' ) ) ) {
            $weight = (float) WC()->cart->get_cart_contents_weight();
        }
    }

    foreach ( $contents as $item ) {
        $qty = isset( $item['quantity'] ) ? absint( $item['quantity'] ) : 0;
        $quantity += $qty;
        if ( $weight <= 0 && ! empty( $item['data'] ) && is_a( $item['data'], 'WC_Product' ) ) {
            $w = (float) $item['data']->get_weight();
            if ( $w > 0 ) {
                $weight += $w * max( 1, $qty );
            }
        }
    }

    if ( $quantity < 1 ) {
        $quantity = 1;
    }

    // Kg facturables: peso real o 0,5 kg por unidad si no hay peso en catálogo.
    $kg = $weight > 0 ? $weight : (float) $quantity * 0.5;
    $billable_kg = max( 1, (int) ceil( $kg ) );

    return array(
        'quantity'    => $quantity,
        'weight'      => round( $weight, 3 ),
        'billable_kg' => $billable_kg,
    );
}

/**
 * Líneas BigBuy desde un package de WooCommerce.
 *
 * @param array $package Package.
 * @return array<int,array{reference:string,sku:string,quantity:int}>
 */
function doroshopping_bigbuy_lines_from_package( $package ) {
    $lines = array();
    if ( empty( $package['contents'] ) || ! is_array( $package['contents'] ) ) {
        return $lines;
    }

    foreach ( $package['contents'] as $item ) {
        $product = isset( $item['data'] ) ? $item['data'] : null;
        if ( ! $product || ! is_a( $product, 'WC_Product' ) ) {
            continue;
        }
        $ref = doroshopping_bigbuy_product_reference( $product );
        if ( ! $ref ) {
            continue;
        }
        $ref = doroshopping_bigbuy_sanitize_reference( $ref );
        if ( ! $ref ) {
            continue;
        }
        $qty = isset( $item['quantity'] ) ? max( 1, min( 99, absint( $item['quantity'] ) ) ) : 1;
        if ( isset( $lines[ $ref ] ) ) {
            $lines[ $ref ]['quantity'] += $qty;
        } else {
            $lines[ $ref ] = array(
                'reference' => $ref,
                'sku'       => $ref,
                'quantity'  => $qty,
            );
        }
    }

    return array_values( $lines );
}

/**
 * Líneas BigBuy desde el carrito actual.
 *
 * @return array<int,array{reference:string,sku:string,quantity:int}>
 */
function doroshopping_bigbuy_lines_from_cart() {
    if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
        return array();
    }
    return doroshopping_bigbuy_lines_from_package(
        array(
            'contents' => WC()->cart->get_cart(),
        )
    );
}

/**
 * Fallback local por país (si BigBuy no responde o no hay API key).
 * Escala por kg facturables / cantidad para no devolver siempre el mismo importe.
 *
 * @param string               $country  ISO2.
 * @param string               $reason   Motivo opcional.
 * @param array<string,mixed>  $context  quantity/weight/billable_kg opcionales.
 * @return array
 */
function doroshopping_bigbuy_shipping_fallback( $country, $reason = '', $context = array() ) {
    $country   = strtoupper( sanitize_text_field( $country ) );
    $fallbacks = array(
        'DE' => array(
            'carrier' => 'DHL / DPD',
            'range'   => '3 - 5',
            'cost'    => '8.90 EUR',
            'currency'=> 'EUR',
        ),
        'GB' => array(
            'carrier' => 'Royal Mail / DHL',
            'range'   => '5 - 8',
            'cost'    => '12.90 GBP',
            'currency'=> 'GBP',
        ),
        'UK' => array(
            'carrier' => 'Royal Mail / DHL',
            'range'   => '5 - 8',
            'cost'    => '12.90 GBP',
            'currency'=> 'GBP',
        ),
        'ES' => array(
            'carrier' => 'Correos Express / SEUR',
            'range'   => '2 - 4',
            'cost'    => '6.90 EUR',
            'currency'=> 'EUR',
        ),
        'FR' => array(
            'carrier' => 'Colissimo / DHL',
            'range'   => '3 - 5',
            'cost'    => '7.90 EUR',
            'currency'=> 'EUR',
        ),
        'IT' => array(
            'carrier' => 'BRT / DHL',
            'range'   => '4 - 6',
            'cost'    => '8.90 EUR',
            'currency'=> 'EUR',
        ),
        'PT' => array(
            'carrier' => 'CTT / DHL',
            'range'   => '3 - 5',
            'cost'    => '6.90 EUR',
            'currency'=> 'EUR',
        ),
        'CH' => array(
            'carrier' => 'Swiss Post / DHL',
            'range'   => '5 - 8',
            'cost'    => '14.90 CHF',
            'currency'=> 'CHF',
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

    if ( empty( $context ) || ! is_array( $context ) ) {
        $context = doroshopping_bigbuy_shipping_context();
    }
    $billable = isset( $context['billable_kg'] ) ? max( 1, absint( $context['billable_kg'] ) ) : 1;
    $base     = doroshopping_bigbuy_parse_cost_amount( $data['cost'] );
    // 1.er kg = base; cada kg extra ≈ 40% del base (aprox. cuando no hay API).
    $cost_num = $base + ( $base * 0.4 * max( 0, $billable - 1 ) );
    $currency = isset( $data['currency'] ) ? $data['currency'] : 'EUR';
    $cost_lbl = number_format( $cost_num, 2, '.', '' ) . ' ' . $currency;

    $options = array(
        array(
            'id'           => 'fallback_standard',
            'carrier'      => $data['carrier'],
            'service_name' => 'standard',
            'time'         => $time,
            'cost'         => $cost_num,
            'cost_label'   => $cost_lbl,
        ),
    );

    // Opción "tipo DHL" un poco más cara para poder elegirla en checkout sin API.
    $dhl_num = round( $cost_num * 1.25, 2 );
    $options[] = array(
        'id'           => 'fallback_dhl',
        'carrier'      => 'DHL',
        'service_name' => 'dhl',
        'time'         => $time,
        'cost'         => $dhl_num,
        'cost_label'   => number_format( $dhl_num, 2, '.', '' ) . ' ' . $currency,
    );

    return array(
        'success'     => true,
        'source'      => 'fallback',
        'carrier'     => $data['carrier'],
        'time'        => $time,
        'cost'        => $cost_lbl,
        'note'        => $note,
        'country'     => $country,
        'options'     => $options,
        'reason'      => $reason ? doroshopping_bigbuy_sanitize_reason( $reason ) : '',
        'billable_kg' => $billable,
        'quantity'    => isset( $context['quantity'] ) ? absint( $context['quantity'] ) : 1,
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
        'isoCountry' => strtoupper( sanitize_text_field( (string) $country ) ),
    );
    $postcode = doroshopping_bigbuy_sanitize_postcode( $postcode );
    if ( $postcode ) {
        $delivery['postcode'] = $postcode;
    }

    $lines = array();
    foreach ( doroshopping_bigbuy_normalize_lines( $products, 20, 99 ) as $product ) {
        $lines[] = array(
            'reference' => $product['reference'],
            'quantity'  => $product['quantity'],
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
    static $memo = array();

    $country  = strtoupper( sanitize_text_field( $country ) );
    $postcode = doroshopping_bigbuy_sanitize_postcode( $postcode );
    $lines    = doroshopping_bigbuy_normalize_lines( $lines, 20, 99 );

    if ( ! $country ) {
        return array(
            'success' => false,
            'message' => __( 'Faltan datos para calcular el envío.', 'doroshopping' ),
        );
    }

    $memo_key = md5( wp_json_encode( array( $country, $postcode, doroshopping_bigbuy_mode(), $lines ) ) );
    if ( isset( $memo[ $memo_key ] ) ) {
        return $memo[ $memo_key ];
    }

    $products = $lines;
    $qty_sum  = 0;
    foreach ( $products as $line ) {
        $qty_sum += isset( $line['quantity'] ) ? absint( $line['quantity'] ) : 1;
    }

    $context = doroshopping_bigbuy_shipping_context();
    if ( $qty_sum > 0 ) {
        $context['quantity'] = $qty_sum;
        if ( empty( $context['weight'] ) || $context['weight'] <= 0 ) {
            $context['billable_kg'] = max( 1, (int) ceil( $qty_sum * 0.5 ) );
        }
    }

    if ( empty( $products ) ) {
        $memo[ $memo_key ] = doroshopping_bigbuy_shipping_fallback( $country, 'no_sku', $context );
        return $memo[ $memo_key ];
    }

    $api_key = doroshopping_bigbuy_api_key();
    if ( ! $api_key ) {
        $memo[ $memo_key ] = doroshopping_bigbuy_shipping_fallback( $country, 'no_api_key', $context );
        return $memo[ $memo_key ];
    }

    if ( ! doroshopping_bigbuy_allow_remote_quote() ) {
        $memo[ $memo_key ] = doroshopping_bigbuy_shipping_fallback( $country, 'ssr_only', $context );
        return $memo[ $memo_key ];
    }

    $cache_key = 'doro_bb_ship_' . $memo_key;
    $cached    = get_transient( $cache_key );
    if ( is_array( $cached ) && ! empty( $cached['success'] ) ) {
        $cached['cached']  = true;
        $memo[ $memo_key ] = $cached;
        return $cached;
    }

    $endpoint = doroshopping_bigbuy_endpoint();
    if ( ! doroshopping_bigbuy_sanitize_endpoint( $endpoint ) ) {
        $memo[ $memo_key ] = doroshopping_bigbuy_shipping_fallback( $country, 'bad_endpoint', $context );
        return $memo[ $memo_key ];
    }

    $payload  = doroshopping_bigbuy_shipping_payload( $country, $postcode, $products );
    $response = wp_remote_post(
        $endpoint,
        array(
            'timeout'     => 8,
            'redirection' => 0,
            'headers'     => array(
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
            ),
            'body'        => wp_json_encode( $payload ),
        )
    );

    if ( is_wp_error( $response ) ) {
        $memo[ $memo_key ] = doroshopping_bigbuy_shipping_fallback( $country, 'http_error', $context );
        return $memo[ $memo_key ];
    }

    $code = (int) wp_remote_retrieve_response_code( $response );
    $raw  = wp_remote_retrieve_body( $response );
    if ( strlen( (string) $raw ) > 200000 ) {
        $memo[ $memo_key ] = doroshopping_bigbuy_shipping_fallback( $country, 'oversized', $context );
        return $memo[ $memo_key ];
    }
    $body = json_decode( (string) $raw, true );

    if ( $code < 200 || $code >= 300 || ! is_array( $body ) ) {
        $memo[ $memo_key ] = doroshopping_bigbuy_shipping_fallback( $country, 'http_' . $code, $context );
        return $memo[ $memo_key ];
    }

    $parsed = doroshopping_parse_bigbuy_shipping_response( $body, $country );
    if ( ! empty( $parsed['success'] ) && 'bigbuy' === ( $parsed['source'] ?? '' ) ) {
        set_transient( $cache_key, $parsed, 15 * MINUTE_IN_SECONDS );
        $memo[ $memo_key ] = $parsed;
        return $parsed;
    }

    if ( ! empty( $parsed['success'] ) && 'fallback' === ( $parsed['source'] ?? '' ) ) {
        $memo[ $memo_key ] = doroshopping_bigbuy_shipping_fallback(
            $country,
            isset( $parsed['reason'] ) ? $parsed['reason'] : 'parsed_fallback',
            $context
        );
        return $memo[ $memo_key ];
    }

    $memo[ $memo_key ] = $parsed;
    return $parsed;
}

function doroshopping_bigbuy_allow_remote_quote() {
    if ( defined( 'DORO_BIGBUY_SSR_ONLY' ) && DORO_BIGBUY_SSR_ONLY ) {
        return false;
    }
    return (bool) apply_filters( 'doroshopping_bigbuy_allow_remote_quote', true );
}

/**
 * Permiso REST BigBuy: nonce wp_rest obligatorio.
 *
 * @param WP_REST_Request $request Request.
 * @return bool
 */
function doroshopping_bigbuy_rest_permission( WP_REST_Request $request ) {
    // Solo POST JSON desde el propio sitio (nonce de sesión WP).
    $nonce = $request->get_header( 'X-WP-Nonce' );
    if ( ! $nonce ) {
        $nonce = $request->get_param( '_wpnonce' );
    }
    if ( ! $nonce || ! wp_verify_nonce( $nonce, 'wp_rest' ) ) {
        return false;
    }
    // Rechazar content-types raros (ataque / scraping).
    $ctype = strtolower( (string) $request->get_header( 'Content-Type' ) );
    if ( $ctype && false === strpos( $ctype, 'application/json' ) && false === strpos( $ctype, 'application/x-www-form-urlencoded' ) ) {
        return false;
    }
    return true;
}

/**
 * REST: POST /wp-json/doro/v1/bigbuy-shipping
 *
 * @param WP_REST_Request $request Request.
 * @return WP_REST_Response
 */
function doroshopping_bigbuy_shipping_endpoint( WP_REST_Request $request ) {
    if ( function_exists( 'doroshopping_rate_limit' ) && ! doroshopping_rate_limit( 'bigbuy_ship', 15, 60 ) ) {
        return new WP_REST_Response(
            array(
                'success' => false,
                'message' => __( 'Demasiadas peticiones. Espera un momento e inténtalo de nuevo.', 'doroshopping' ),
            ),
            429
        );
    }

    $country  = strtoupper( sanitize_text_field( (string) $request->get_param( 'country' ) ) );
    $postcode = doroshopping_bigbuy_sanitize_postcode( (string) $request->get_param( 'postcode' ) );
    $use_cart = (bool) $request->get_param( 'use_cart' );

    if ( 'UK' === $country ) {
        $country = 'GB';
    }

    if ( function_exists( 'doroshopping_is_allowed_country_code' ) && ! doroshopping_is_allowed_country_code( $country ) ) {
        return new WP_REST_Response(
            array(
                'success' => false,
                'message' => __( 'País de envío no válido.', 'doroshopping' ),
            ),
            400
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

    // Solo fuentes de confianza para la API remota (evita sondeo de SKU / quema de cuota).
    $trusted    = false;
    $lines      = array();
    $product_id = absint( $request->get_param( 'product_id' ) );
    $cart_lines = doroshopping_bigbuy_lines_from_cart();

    if ( $use_cart && ! empty( $cart_lines ) ) {
        $lines   = $cart_lines;
        $trusted = true;
    } elseif ( $product_id ) {
        $quantity = max( 1, min( 99, absint( $request->get_param( 'quantity' ) ) ) );

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
        if ( ! $product || 'publish' !== $product->get_status() ) {
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
            $weight = (float) $product->get_weight() * $quantity;
            $ctx    = array(
                'quantity'    => $quantity,
                'weight'      => $weight,
                'billable_kg' => max( 1, (int) ceil( max( $weight, $quantity * 0.5 ) ) ),
            );
            return new WP_REST_Response( doroshopping_bigbuy_shipping_fallback( $country, 'no_sku', $ctx ), 200 );
        }

        $lines   = array(
            array(
                'reference' => $ref,
                'sku'       => $ref,
                'quantity'  => $quantity,
            ),
        );
        $trusted = true;
    } elseif ( ! empty( $cart_lines ) ) {
        $lines   = $cart_lines;
        $trusted = true;
    }

    // products[] del cliente: solo fallback local (nunca API remota).
    if ( empty( $lines ) ) {
        $client_lines = doroshopping_bigbuy_normalize_lines( $request->get_param( 'products' ), 10, 20 );
        if ( ! empty( $client_lines ) ) {
            $lines   = $client_lines;
            $trusted = false;
        }
    }

    $lines = doroshopping_bigbuy_normalize_lines( $lines, 20, 99 );
    $ctx   = doroshopping_bigbuy_shipping_context();
    if ( ! empty( $lines ) ) {
        $qty = 0;
        foreach ( $lines as $line ) {
            $qty += isset( $line['quantity'] ) ? absint( $line['quantity'] ) : 1;
        }
        $ctx['quantity']    = max( 1, $qty );
        $ctx['billable_kg'] = max( 1, (int) ceil( max( (float) $ctx['weight'], $ctx['quantity'] * 0.5 ) ) );
    }

    if ( empty( $lines ) ) {
        return new WP_REST_Response( doroshopping_bigbuy_shipping_fallback( $country, 'no_lines', $ctx ), 200 );
    }

    if ( ! $trusted || ! doroshopping_bigbuy_allow_remote_quote() || ! doroshopping_bigbuy_api_key() ) {
        return new WP_REST_Response( doroshopping_bigbuy_shipping_fallback( $country, $trusted ? 'local_only' : 'untrusted_lines', $ctx ), 200 );
    }

    if ( function_exists( 'doroshopping_rate_limit' ) && ! doroshopping_rate_limit( 'bigbuy_ship_api', 6, 60 ) ) {
        return new WP_REST_Response( doroshopping_bigbuy_shipping_fallback( $country, 'rate_limit', $ctx ), 200 );
    }

    $parsed = doroshopping_bigbuy_quote( $country, $postcode, $lines );
    return new WP_REST_Response( $parsed, 200 );
}

function doroshopping_register_bigbuy_rest() {
    register_rest_route(
        'doro/v1',
        '/bigbuy-shipping',
        array(
            'methods'             => 'POST',
            'callback'            => 'doroshopping_bigbuy_shipping_endpoint',
            'permission_callback' => 'doroshopping_bigbuy_rest_permission',
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
