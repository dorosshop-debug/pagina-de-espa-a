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
}
add_action( 'woocommerce_checkout_init', 'doroshopping_checkout_seed_customer_country', 5 );
add_action( 'woocommerce_before_checkout_form', 'doroshopping_checkout_seed_customer_country', 1 );

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
    if ( ! $is_cart && ! $is_checkout ) {
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

