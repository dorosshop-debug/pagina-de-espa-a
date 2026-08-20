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
    if ( function_exists( 'doroshopping_ui_text' ) ) {
        $custom = doroshopping_ui_text( 'doroshopping_ui_checkout_place_order' );
        if ( '' !== $custom ) {
            return $custom;
        }
    }
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
 * Sustituye avisos login/cupón WC por la franja propia del tema.
 */
function doroshopping_checkout_hooks() {
    remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );
    remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
    remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
    remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
    add_action( 'woocommerce_before_checkout_form', 'doroshopping_checkout_render_helpers', 10 );
    add_action( 'woocommerce_before_checkout_form', 'doroshopping_checkout_login_coupon_panels', 11 );
}
add_action( 'wp', 'doroshopping_checkout_hooks' );

/**
 * Franja visual login / cupón.
 *
 * @return void
 */
function doroshopping_checkout_render_helpers() {
    get_template_part( 'template-parts/checkout/helpers' );
}

/**
 * Formularios login/cupón ocultos (se abren desde .doro-checkout-helpers).
 *
 * @param WC_Checkout $checkout Checkout.
 * @return void
 */
function doroshopping_checkout_login_coupon_panels( $checkout ) {
    unset( $checkout );

    if ( ! is_user_logged_in() && 'no' !== get_option( 'woocommerce_enable_checkout_login_reminder' ) ) {
        echo '<div id="doro-checkout-login-panel" class="doro-checkout-panel" hidden>';
        woocommerce_login_form(
            array(
                'message'  => esc_html__( 'Si ya tienes cuenta, inicia sesión debajo.', 'doroshopping' ),
                'redirect' => wc_get_checkout_url(),
                'hidden'   => false,
            )
        );
        echo '</div>';
    }

    if ( wc_coupons_enabled() ) {
        echo '<div id="doro-checkout-coupon-panel" class="doro-checkout-panel" hidden>';
        ?>
        <form class="checkout_coupon woocommerce-form-coupon" method="post">
            <p><?php esc_html_e( 'Si tienes un código de cupón, introdúcelo a continuación.', 'doroshopping' ); ?></p>
            <div class="doro-checkout-coupon-row">
                <input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_attr_e( 'Código de cupón', 'doroshopping' ); ?>" id="coupon_code" value="" />
                <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Aplicar cupón', 'doroshopping' ); ?>"><?php esc_html_e( 'Aplicar', 'doroshopping' ); ?></button>
            </div>
            <div class="clear"></div>
        </form>
        <?php
        echo '</div>';
    }
}

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
/**
 * Quitar aviso técnico de zona de coincidencia en checkout (poco útil al cliente).
 *
 * @param array $notices Notices.
 * @return array
 */
function doroshopping_filter_checkout_notices( $notices ) {
    if ( ! is_array( $notices ) ) {
        return $notices;
    }

    foreach ( $notices as $type => $group ) {
        if ( ! is_array( $group ) ) {
            continue;
        }
        $notices[ $type ] = array_values(
            array_filter(
                $group,
                static function ( $item ) {
                    $msg = '';
                    if ( is_array( $item ) && isset( $item['notice'] ) ) {
                        $msg = (string) $item['notice'];
                    } elseif ( is_string( $item ) ) {
                        $msg = $item;
                    }
                    if ( '' === $msg ) {
                        return true;
                    }
                    return ( false === stripos( $msg, 'Zona de coincidencia' )
                        && false === stripos( $msg, 'matching zone' ) );
                }
            )
        );
        if ( empty( $notices[ $type ] ) ) {
            unset( $notices[ $type ] );
        }
    }

    return $notices;
}
add_filter( 'woocommerce_get_notices', 'doroshopping_filter_checkout_notices' );

/**
 * Precargar país del cliente desde cookie del header (ayuda a gateways / zonas).
 *
 * @return void
 */
function doroshopping_checkout_seed_customer_country() {
    if ( ! function_exists( 'is_checkout' ) || ! is_checkout() || is_wc_endpoint_url( 'order-received' ) ) {
        return;
    }
    if ( ! function_exists( 'WC' ) || ! WC()->customer ) {
        return;
    }

    $country = doroshopping_get_preferred_country();
    if ( ! $country ) {
        return;
    }

    if ( ! WC()->customer->get_billing_country() ) {
        WC()->customer->set_billing_country( $country );
    }
    if ( ! WC()->customer->get_shipping_country() ) {
        WC()->customer->set_shipping_country( $country );
    }

    $postcode = function_exists( 'doroshopping_get_shipping_postcode' ) ? doroshopping_get_shipping_postcode() : '';
    if ( $postcode && ! WC()->customer->get_shipping_postcode() ) {
        WC()->customer->set_shipping_postcode( $postcode );
    }
    if ( $postcode && ! WC()->customer->get_billing_postcode() ) {
        WC()->customer->set_billing_postcode( $postcode );
    }
}
add_action( 'woocommerce_checkout_init', 'doroshopping_checkout_seed_customer_country', 5 );
add_action( 'woocommerce_before_checkout_form', 'doroshopping_checkout_seed_customer_country', 1 );

/**
 * Recalcular envío/totales tras sembrar país.
 *
 * @return void
 */
function doroshopping_checkout_recalc_shipping() {
    if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
        return;
    }
    WC()->cart->calculate_shipping();
    WC()->cart->calculate_totals();
}
add_action( 'woocommerce_before_checkout_form', 'doroshopping_checkout_recalc_shipping', 20 );

/**
 * País preferido: cookie del header → cliente WC → ES.
 *
 * @return string
 */
function doroshopping_get_preferred_country() {
    $cookie = ! empty( $_COOKIE['doroshopping_country'] ) // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
        ? strtoupper( sanitize_text_field( wp_unslash( $_COOKIE['doroshopping_country'] ) ) )
        : '';
    if ( strlen( $cookie ) >= 2 ) {
        $cookie = substr( $cookie, 0, 2 );
        if ( 'UK' === $cookie ) {
            $cookie = 'GB';
        }
        return $cookie;
    }

    if ( function_exists( 'WC' ) && WC()->customer ) {
        $from_customer = WC()->customer->get_billing_country() ?: WC()->customer->get_shipping_country();
        if ( $from_customer ) {
            return strtoupper( substr( (string) $from_customer, 0, 2 ) );
        }
    }

    return 'ES';
}

/**
 * Valor por defecto de país en campos checkout (Klarna / Stripe locales).
 *
 * @param mixed  $value Value.
 * @param string $input Input key.
 * @return mixed
 */
function doroshopping_checkout_default_country_value( $value, $input ) {
    if ( $value ) {
        return $value;
    }
    if ( 'billing_country' !== $input && 'shipping_country' !== $input ) {
        return $value;
    }
    return doroshopping_get_preferred_country();
}
add_filter( 'woocommerce_checkout_get_value', 'doroshopping_checkout_default_country_value', 20, 2 );

/**
 * En update_order_review, si el POST no trae país, usar cookie (modal cerrado).
 *
 * @param string $posted_data Serialized checkout data.
 * @return void
 */
function doroshopping_checkout_posted_country_fallback( $posted_data ) {
    if ( ! function_exists( 'WC' ) || ! WC()->customer ) {
        return;
    }

    parse_str( $posted_data, $data );
    $bill = isset( $data['billing_country'] ) ? strtoupper( sanitize_text_field( $data['billing_country'] ) ) : '';
    $ship = isset( $data['shipping_country'] ) ? strtoupper( sanitize_text_field( $data['shipping_country'] ) ) : '';
    $fallback = doroshopping_get_preferred_country();

    if ( ! $bill && $fallback ) {
        WC()->customer->set_billing_country( $fallback );
    }
    if ( ! $ship && $fallback ) {
        WC()->customer->set_shipping_country( $fallback );
    }

    $post = isset( $data['billing_postcode'] ) ? sanitize_text_field( $data['billing_postcode'] ) : '';
    if ( ! $post && isset( $data['shipping_postcode'] ) ) {
        $post = sanitize_text_field( $data['shipping_postcode'] );
    }
    if ( ! $post && function_exists( 'doroshopping_get_shipping_postcode' ) ) {
        $post = doroshopping_get_shipping_postcode();
    }
    if ( $post && ! WC()->customer->get_shipping_postcode() ) {
        WC()->customer->set_shipping_postcode( $post );
    }
}
add_action( 'woocommerce_checkout_update_order_review', 'doroshopping_checkout_posted_country_fallback', 5 );

/**
 * Evita que Advanced Google Address (AGA) tumbe carrito/checkout con querySelectorAll('').
 *
 * @return void
 */
function doroshopping_guard_empty_selectors() {
    $is_cart     = function_exists( 'is_cart' ) && is_cart();
    $is_checkout = function_exists( 'is_checkout' ) && is_checkout();
    $is_shop     = function_exists( 'is_shop' ) && is_shop();
    $is_tax      = function_exists( 'is_product_taxonomy' ) && is_product_taxonomy();
    if ( ! $is_cart && ! $is_checkout && ! $is_shop && ! $is_tax ) {
        return;
    }
    ?>
    <script>
    (function () {
        try {
            function patch(proto) {
                if (!proto || !proto.querySelectorAll || proto.querySelectorAll.__doroPatched) return;
                var orig = proto.querySelectorAll;
                proto.querySelectorAll = function (sel) {
                    if (sel == null || String(sel).trim() === '') {
                        return orig.call(this, '*:not(*)');
                    }
                    try {
                        return orig.apply(this, arguments);
                    } catch (err) {
                        return orig.call(this, '*:not(*)');
                    }
                };
                proto.querySelectorAll.__doroPatched = true;
            }
            patch(Document.prototype);
            patch(Element.prototype);
            patch(DocumentFragment && DocumentFragment.prototype);
        } catch (e) { /* ignore */ }
    })();
    </script>
    <?php
}
add_action( 'wp_head', 'doroshopping_guard_empty_selectors', 0 );

// Compat: nombre antiguo del hook.
function doroshopping_checkout_guard_empty_selectors() {
    doroshopping_guard_empty_selectors();
}

/**
 * Calcular envío en checkout/carrito aunque falte la dirección completa.
 *
 * @param bool $ready Ready.
 * @return bool
 */
function doroshopping_cart_ready_to_calc_shipping( $ready ) {
    if ( $ready ) {
        return true;
    }
    if ( ( function_exists( 'is_checkout' ) && is_checkout() ) || ( function_exists( 'is_cart' ) && is_cart() ) ) {
        return true;
    }
    return $ready;
}
add_filter( 'woocommerce_cart_ready_to_calc_shipping', 'doroshopping_cart_ready_to_calc_shipping' );

/**
 * Extraer importe numérico de una etiqueta tipo "6.90 EUR".
 *
 * @param string $label Label.
 * @return float
 */
function doroshopping_parse_shipping_cost_amount( $label ) {
    if ( preg_match( '/([0-9]+(?:[.,][0-9]+)?)/', (string) $label, $m ) ) {
        return (float) str_replace( ',', '.', $m[1] );
    }
    return 0.0;
}

/**
 * ¿Las tarifas actuales son solo las inyectadas por Doro?
 *
 * @param array $rates Rates.
 * @return bool
 */
function doroshopping_shipping_rates_are_doro_only( $rates ) {
    if ( empty( $rates ) || ! is_array( $rates ) ) {
        return true;
    }
    foreach ( array_keys( $rates ) as $id ) {
        $id = (string) $id;
        if ( 0 !== strpos( $id, 'doro_' ) ) {
            return false;
        }
    }
    return true;
}

/**
 * Convertir cotización BigBuy/fallback en tarifas WC seleccionables.
 *
 * @param array  $quote   Cotización.
 * @param string $country ISO2.
 * @return array<string,WC_Shipping_Rate>
 */
function doroshopping_shipping_rates_from_quote( $quote, $country = 'ES' ) {
    $out = array();
    if ( ! class_exists( 'WC_Shipping_Rate' ) || ! is_array( $quote ) ) {
        return $out;
    }

    $max_cost = (float) apply_filters( 'doroshopping_shipping_max_cost', 9999.0, $country );

    $options = ! empty( $quote['options'] ) && is_array( $quote['options'] ) ? $quote['options'] : array();
    if ( empty( $options ) ) {
        $cost  = isset( $quote['cost'] ) ? doroshopping_parse_shipping_cost_amount( $quote['cost'] ) : 0.0;
        $cost  = max( 0, min( $max_cost, $cost ) );
        $label = ! empty( $quote['carrier'] ) ? sanitize_text_field( (string) $quote['carrier'] ) : __( 'Envío y transporte', 'doroshopping' );
        $out['doro_estimate'] = new WC_Shipping_Rate( 'doro_estimate', $label, $cost, array(), 'doro_estimate' );
        return $out;
    }

    $seen = array();
    foreach ( array_slice( $options, 0, 8 ) as $i => $opt ) {
        if ( ! is_array( $opt ) ) {
            continue;
        }
        $raw_id = ! empty( $opt['id'] ) ? (string) $opt['id'] : (string) $i;
        $slug   = sanitize_title( $raw_id );
        if ( '' === $slug ) {
            $slug = 'opt' . (int) $i;
        }
        $rate_id = 'doro_bb_' . $slug;
        if ( isset( $seen[ $rate_id ] ) ) {
            $rate_id .= '_' . (int) $i;
        }
        $seen[ $rate_id ] = true;

        $cost = null;
        if ( isset( $opt['cost'] ) && is_numeric( $opt['cost'] ) ) {
            $cost = (float) $opt['cost'];
        } elseif ( ! empty( $opt['cost_label'] ) ) {
            $cost = doroshopping_parse_shipping_cost_amount( $opt['cost_label'] );
        }
        if ( null === $cost || $cost < 0 ) {
            continue;
        }
        $cost = min( $max_cost, $cost );

        $label = ! empty( $opt['carrier'] ) ? sanitize_text_field( (string) $opt['carrier'] ) : __( 'Envío', 'doroshopping' );
        if ( ! empty( $opt['time'] ) ) {
            $label .= ' — ' . sanitize_text_field( (string) $opt['time'] );
        }

        $out[ $rate_id ] = new WC_Shipping_Rate( $rate_id, $label, $cost, array(), 'doro_bigbuy' );
    }

    if ( empty( $out ) ) {
        $cost  = isset( $quote['cost'] ) ? doroshopping_parse_shipping_cost_amount( $quote['cost'] ) : 0.0;
        $cost  = max( 0, min( $max_cost, $cost ) );
        $label = ! empty( $quote['carrier'] ) ? sanitize_text_field( (string) $quote['carrier'] ) : __( 'Envío y transporte', 'doroshopping' );
        $out['doro_estimate'] = new WC_Shipping_Rate( 'doro_estimate', $label, $cost, array(), 'doro_estimate' );
    }

    return $out;
}

/**
 * Cotizar envío real del package (BigBuy con líneas del carrito, o fallback escalado).
 *
 * @param array $rates   Rates.
 * @param array $package Package.
 * @return array
 */
function doroshopping_ensure_checkout_shipping_rates( $rates, $package ) {
    static $memo = array();
    static $busy = false;

    if ( ! class_exists( 'WC_Shipping_Rate' ) ) {
        return $rates;
    }

    // Evitar bucles / llamadas anidadas durante calculate_shipping.
    if ( $busy ) {
        return $rates;
    }

    // No cotizar en admin (salvo AJAX de frontend).
    if ( is_admin() && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
        return $rates;
    }

    $country = '';
    if ( isset( $package['destination']['country'] ) ) {
        $country = strtoupper( sanitize_text_field( (string) $package['destination']['country'] ) );
    }
    if ( ! $country && function_exists( 'doroshopping_get_preferred_country' ) ) {
        $country = doroshopping_get_preferred_country();
    }
    if ( ! $country ) {
        $country = 'ES';
    }
    if ( 'UK' === $country ) {
        $country = 'GB';
    }

    $postcode = '';
    if ( ! empty( $package['destination']['postcode'] ) ) {
        $postcode = function_exists( 'doroshopping_bigbuy_sanitize_postcode' )
            ? doroshopping_bigbuy_sanitize_postcode( (string) $package['destination']['postcode'] )
            : sanitize_text_field( (string) $package['destination']['postcode'] );
    } elseif ( function_exists( 'doroshopping_get_shipping_postcode' ) ) {
        $postcode = doroshopping_get_shipping_postcode();
    }

    $lines   = function_exists( 'doroshopping_bigbuy_lines_from_package' )
        ? doroshopping_bigbuy_lines_from_package( $package )
        : array();
    $context = function_exists( 'doroshopping_bigbuy_shipping_context' )
        ? doroshopping_bigbuy_shipping_context( $package )
        : array( 'quantity' => 1, 'weight' => 0, 'billable_kg' => 1 );

    $memo_key = md5( wp_json_encode( array( $country, $postcode, $lines, $context ) ) );
    if ( isset( $memo[ $memo_key ] ) ) {
        return $memo[ $memo_key ];
    }

    $busy  = true;
    $quote = null;

    try {
        // Con productos del carrito: cotizar siempre (API o fallback por kg), aunque WC tenga flat rate.
        if ( ! empty( $lines ) && function_exists( 'doroshopping_bigbuy_quote' ) ) {
            if ( function_exists( 'doroshopping_bigbuy_api_key' ) && doroshopping_bigbuy_api_key()
                && ( ! function_exists( 'doroshopping_bigbuy_allow_remote_quote' ) || doroshopping_bigbuy_allow_remote_quote() ) ) {
                $quote = doroshopping_bigbuy_quote( $country, $postcode, $lines );
            }
            if ( ! is_array( $quote ) || empty( $quote['success'] ) ) {
                $quote = function_exists( 'doroshopping_bigbuy_shipping_fallback' )
                    ? doroshopping_bigbuy_shipping_fallback( $country, 'checkout', $context )
                    : null;
            }
        }

        // Sin líneas (sin SKU BigBuy): si ya hay tarifas WC ajenas, respetarlas.
        if ( empty( $lines ) ) {
            if ( ! empty( $rates ) && ! doroshopping_shipping_rates_are_doro_only( $rates ) ) {
                $memo[ $memo_key ] = $rates;
                return $rates;
            }
            $quote = function_exists( 'doroshopping_bigbuy_shipping_fallback' )
                ? doroshopping_bigbuy_shipping_fallback( $country, 'checkout_no_lines', $context )
                : null;
        }

        if ( ! is_array( $quote ) || empty( $quote['success'] ) ) {
            $memo[ $memo_key ] = $rates;
            return $rates;
        }

        $doro_rates = doroshopping_shipping_rates_from_quote( $quote, $country );
        if ( empty( $doro_rates ) ) {
            $memo[ $memo_key ] = $rates;
            return $rates;
        }

        $memo[ $memo_key ] = $doro_rates;
        return $doro_rates;
    } finally {
        $busy = false;
    }
}
add_filter( 'woocommerce_package_rates', 'doroshopping_ensure_checkout_shipping_rates', 30, 2 );

/**
 * Invalidar caché de tarifas WC al cambiar el carrito.
 *
 * @return void
 */
function doroshopping_invalidate_shipping_cache() {
    static $done = false;
    if ( $done ) {
        return;
    }
    $done = true;

    if ( ! function_exists( 'WC' ) ) {
        return;
    }
    if ( WC()->shipping() && is_callable( array( WC()->shipping(), 'reset_shipping' ) ) ) {
        WC()->shipping()->reset_shipping();
    }
    if ( WC()->session ) {
        WC()->session->set( 'shipping_for_package_0', false );
    }
}
add_action( 'woocommerce_cart_updated', 'doroshopping_invalidate_shipping_cache', 20 );
add_action( 'woocommerce_add_to_cart', 'doroshopping_invalidate_shipping_cache', 20 );
add_action( 'woocommerce_cart_item_removed', 'doroshopping_invalidate_shipping_cache', 20 );
add_action( 'woocommerce_after_cart_item_quantity_update', 'doroshopping_invalidate_shipping_cache', 20 );

/**
 * Elegir la tarifa estimada si no hay otra seleccionada.
 *
 * @param string $method  Method.
 * @param array  $rates   Rates.
 * @param string $chosen  Chosen.
 * @return string
 */
function doroshopping_shipping_chosen_method( $method, $rates, $chosen ) {
    unset( $method );
    if ( $chosen && isset( $rates[ $chosen ] ) ) {
        return $chosen;
    }
    if ( isset( $rates['doro_estimate'] ) ) {
        return 'doro_estimate';
    }
    // Preferir la más barata entre doro_bb_*.
    $best_id   = '';
    $best_cost = null;
    foreach ( (array) $rates as $id => $rate ) {
        if ( 0 !== strpos( (string) $id, 'doro_' ) ) {
            continue;
        }
        $cost = is_object( $rate ) && method_exists( $rate, 'get_cost' ) ? (float) $rate->get_cost() : null;
        if ( null === $cost ) {
            continue;
        }
        if ( null === $best_cost || $cost < $best_cost ) {
            $best_cost = $cost;
            $best_id   = (string) $id;
        }
    }
    if ( $best_id ) {
        return $best_id;
    }
    $ids = array_keys( (array) $rates );
    return $ids ? (string) $ids[0] : '';
}
add_filter( 'woocommerce_shipping_chosen_method', 'doroshopping_shipping_chosen_method', 10, 3 );

/**
 * Filas de envío en el resumen (divs, no <tr>) con selector de carrier.
 *
 * @return void
 */
function doroshopping_render_checkout_shipping_rows() {
    if ( ! function_exists( 'WC' ) || ! WC()->cart || ! WC()->cart->needs_shipping() ) {
        return;
    }

    $label    = __( 'Envío y transporte', 'doroshopping' );
    $packages = WC()->shipping() ? WC()->shipping()->get_packages() : array();
    $chosen   = ( WC()->session ) ? (array) WC()->session->get( 'chosen_shipping_methods', array() ) : array();
    $printed  = false;

    foreach ( $packages as $i => $package ) {
        $avail = isset( $package['rates'] ) ? $package['rates'] : array();
        if ( empty( $avail ) ) {
            continue;
        }

        $chosen_id = isset( $chosen[ $i ] ) ? $chosen[ $i ] : '';
        $selected  = ( $chosen_id && isset( $avail[ $chosen_id ] ) ) ? $avail[ $chosen_id ] : reset( $avail );
        if ( ! $selected ) {
            continue;
        }

        echo '<div class="doro-checkout-summary__row doro-checkout-summary__row--shipping">';
        echo '<span>' . esc_html( $label ) . '</span>';
        echo '<span>' . wp_kses_post( WC()->cart->get_cart_shipping_total() ) . '</span>';
        echo '</div>';

        if ( count( $avail ) > 1 ) {
            echo '<div class="doro-checkout-summary__shipping-methods" role="radiogroup" aria-label="' . esc_attr( $label ) . '">';
            foreach ( $avail as $rate_id => $rate ) {
                $input_id = 'doro_shipping_method_' . $i . '_' . sanitize_title( $rate_id );
                $is_sel   = ( (string) $rate_id === (string) $chosen_id )
                    || ( ! $chosen_id && $rate === $selected );
                echo '<label class="doro-checkout-summary__ship-method' . ( $is_sel ? ' is-selected' : '' ) . '" for="' . esc_attr( $input_id ) . '">';
                echo '<input type="radio" name="shipping_method[' . esc_attr( (string) $i ) . ']" '
                    . 'data-index="' . esc_attr( (string) $i ) . '" '
                    . 'id="' . esc_attr( $input_id ) . '" '
                    . 'value="' . esc_attr( $rate_id ) . '" '
                    . 'class="shipping_method" '
                    . checked( $is_sel, true, false ) . ' />';
                echo '<span class="doro-checkout-summary__ship-method-label">' . esc_html( $rate->get_label() ) . '</span>';
                echo '<span class="doro-checkout-summary__ship-method-cost">' . wp_kses_post( wc_price( $rate->get_cost() ) ) . '</span>';
                echo '</label>';
            }
            echo '</div>';
        } else {
            $carrier = $selected->get_label();
            if ( $carrier ) {
                echo '<div class="doro-checkout-summary__shipping-meta">';
                echo esc_html( $carrier );
                echo '</div>';
            }
        }

        $printed = true;
        break;
    }

    if ( $printed ) {
        return;
    }

    echo '<div class="doro-checkout-summary__row doro-checkout-summary__row--shipping is-pending">';
    echo '<span>' . esc_html( $label ) . '</span>';
    echo '<span>' . esc_html__( 'Se calculará con tu dirección', 'doroshopping' ) . '</span>';
    echo '</div>';
}

/**
 * Refrescar el resumen lateral cuando WooCommerce actualiza el checkout.
 *
 * @param array $fragments Fragments.
 * @return array
 */
function doroshopping_checkout_summary_fragments( $fragments ) {
    ob_start();
    get_template_part( 'template-parts/checkout/summary-live' );
    $html = ob_get_clean();
    if ( $html ) {
        $fragments['.doro-checkout-summary__live'] = $html;
    }
    return $fragments;
}
add_filter( 'woocommerce_update_order_review_fragments', 'doroshopping_checkout_summary_fragments' );

