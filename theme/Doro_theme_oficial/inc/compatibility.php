<?php
/**
 * Compatibilidad: Polylang, YayCurrency, Geo Controller / CF Geo Plugin.
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * ¿Polylang activo?
 *
 * @return bool
 */
function doroshopping_has_polylang() {
    return function_exists( 'pll_the_languages' ) && function_exists( 'pll_current_language' );
}

/**
 * Idiomas para el selector del header (Polylang o fallback).
 *
 * @return array<string,array{label:string,flag:string,url:string}>
 */
function doroshopping_get_header_languages() {
    $flags_uri = get_template_directory_uri() . '/assets/images/flags';
    $flag_map  = array(
        'es' => $flags_uri . '/spain.png',
        'en' => $flags_uri . '/reino-unido.png',
        'gb' => $flags_uri . '/reino-unido.png',
        'uk' => $flags_uri . '/reino-unido.png',
        'de' => $flags_uri . '/alemania.png',
        'fr' => $flags_uri . '/francia.png',
        'it' => $flags_uri . '/italia.png',
        'pt' => $flags_uri . '/ptg.png',
    );

    if ( doroshopping_has_polylang() ) {
        $raw = pll_the_languages(
            array(
                'raw'                    => 1,
                'hide_if_empty'          => 0,
                'hide_current'           => 0,
                'force_home'             => 0,
            )
        );
        $out = array();
        if ( is_array( $raw ) ) {
            foreach ( $raw as $lang ) {
                $code = isset( $lang['slug'] ) ? sanitize_key( $lang['slug'] ) : '';
                if ( '' === $code ) {
                    continue;
                }
                $flag = '';
                // Polylang a menudo devuelve HTML de bandera, no una URL.
                if ( ! empty( $lang['flag'] ) && is_string( $lang['flag'] ) ) {
                    if ( preg_match( '/src=["\']([^"\']+)["\']/', $lang['flag'], $m ) ) {
                        $flag = $m[1];
                    } elseif ( 0 === strpos( $lang['flag'], 'http' ) || 0 === strpos( $lang['flag'], '/' ) ) {
                        $flag = $lang['flag'];
                    }
                }
                if ( ! $flag && isset( $flag_map[ $code ] ) ) {
                    $flag = $flag_map[ $code ];
                }
                if ( ! $flag ) {
                    $flag = $flags_uri . '/spain.png';
                }
                $out[ $code ] = array(
                    'label' => isset( $lang['name'] ) ? (string) $lang['name'] : strtoupper( $code ),
                    'flag'  => $flag,
                    'url'   => isset( $lang['url'] ) ? (string) $lang['url'] : '',
                );
            }
        }
        if ( ! empty( $out ) ) {
            return $out;
        }
    }

    return array(
        'es' => array( 'label' => 'Español', 'flag' => $flag_map['es'], 'url' => '' ),
        'en' => array( 'label' => 'English', 'flag' => $flag_map['en'], 'url' => '' ),
        'de' => array( 'label' => 'Deutsch', 'flag' => $flag_map['de'], 'url' => '' ),
        'fr' => array( 'label' => 'Français', 'flag' => $flag_map['fr'], 'url' => '' ),
        'it' => array( 'label' => 'Italiano', 'flag' => $flag_map['it'], 'url' => '' ),
        'pt' => array( 'label' => 'Português', 'flag' => $flag_map['pt'], 'url' => '' ),
    );
}

/**
 * Código de idioma actual.
 *
 * @return string
 */
function doroshopping_get_current_language_code() {
    if ( doroshopping_has_polylang() ) {
        $code = pll_current_language( 'slug' );
        if ( $code ) {
            return sanitize_key( $code );
        }
    }
    $locale = determine_locale();
    return strtolower( substr( (string) $locale, 0, 2 ) );
}

/**
 * Etiqueta de idioma para el botón del header.
 *
 * @return string
 */
function doroshopping_get_header_language_label() {
    $code  = doroshopping_get_current_language_code();
    $langs = doroshopping_get_header_languages();
    if ( isset( $langs[ $code ]['label'] ) ) {
        return $langs[ $code ]['label'];
    }
    return __( 'Idioma', 'doroshopping' );
}

/**
 * Bandera actual (URL).
 *
 * @return string
 */
function doroshopping_get_header_language_flag() {
    $code  = doroshopping_get_current_language_code();
    $langs = doroshopping_get_header_languages();
    if ( isset( $langs[ $code ]['flag'] ) ) {
        return $langs[ $code ]['flag'];
    }
    return get_template_directory_uri() . '/assets/images/flags/spain.png';
}

/**
 * Etiqueta de moneda actual (CURCY / YayCurrency / WooCommerce).
 *
 * @return string
 */
function doroshopping_get_header_currency_label() {
    $code = doroshopping_get_current_currency_code();
    $list = doroshopping_get_header_currencies();
    if ( isset( $list[ $code ]['label'] ) ) {
        return $list[ $code ]['label'];
    }
    $names = array(
        'EUR' => 'Euro',
        'USD' => 'US Dollar',
        'GBP' => 'Pound',
        'CHF' => 'Franco suizo',
    );
    $name = isset( $names[ $code ] ) ? $names[ $code ] : $code;
    return $name . ' · ' . $code;
}

/**
 * Código de moneda activa.
 *
 * @return string
 */
function doroshopping_get_current_currency_code() {
    $code = '';

    if ( ! empty( $_COOKIE['doroshopping_currency'] ) ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
        $code = strtoupper( sanitize_text_field( wp_unslash( $_COOKIE['doroshopping_currency'] ) ) );
    }
    if ( ! $code && ! empty( $_COOKIE['wmc_current_currency'] ) ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
        $code = strtoupper( sanitize_text_field( wp_unslash( $_COOKIE['wmc_current_currency'] ) ) );
    }
    if ( ! $code && isset( $_GET['wmc-currency'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $code = strtoupper( sanitize_text_field( wp_unslash( $_GET['wmc-currency'] ) ) );
    }

    // CURCY (VillaTheme).
    if ( ! $code ) {
        foreach ( array( 'WOOMULTI_CURRENCY_F_Data', 'WOOMULTI_CURRENCY_Data' ) as $class ) {
            if ( class_exists( $class ) && is_callable( array( $class, 'get_ins' ) ) ) {
                $settings = $class::get_ins();
                if ( $settings && is_callable( array( $settings, 'get_current_currency' ) ) ) {
                    $code = strtoupper( (string) $settings->get_current_currency() );
                    break;
                }
            }
        }
    }

    // YayCurrency.
    if ( ! $code && class_exists( 'Yay_Currency\Helpers\YayCurrencyHelper', false ) && is_callable( array( 'Yay_Currency\Helpers\YayCurrencyHelper', 'detect_current_currency' ) ) ) {
        $current = \Yay_Currency\Helpers\YayCurrencyHelper::detect_current_currency();
        if ( is_array( $current ) && ! empty( $current['currency'] ) ) {
            $code = strtoupper( (string) $current['currency'] );
        }
    }

    if ( ! $code && function_exists( 'get_woocommerce_currency' ) ) {
        $code = get_woocommerce_currency();
    }
    if ( ! $code ) {
        $code = 'EUR';
    }

    return strtoupper( apply_filters( 'doroshopping_header_currency_code', $code ) );
}

/**
 * Monedas disponibles para el selector del header (YayCurrency + CURCY, fusionadas).
 *
 * @return array<string,array{label:string,flag:string}>
 */
function doroshopping_get_header_currencies() {
    $flags_uri = get_template_directory_uri() . '/assets/images/flags';
    $meta      = array(
        'EUR' => array(
            'label' => 'Euro (€) - EUR',
            'flag'  => $flags_uri . '/euro.svg',
        ),
        'CHF' => array(
            'label' => 'Franco suizo (CHF)',
            'flag'  => $flags_uri . '/suiza.svg',
        ),
        'GBP' => array(
            'label' => 'Libra esterlina (£) - GBP',
            'flag'  => $flags_uri . '/reino-unido.png',
        ),
        'USD' => array(
            'label' => 'US Dollar ($) - USD',
            'flag'  => $flags_uri . '/euro.svg',
        ),
    );

    $codes = array();

    /**
     * Añade códigos ISO a la lista.
     *
     * @param mixed $raw Raw list.
     * @return void
     */
    $push = static function ( $raw ) use ( &$codes ) {
        if ( empty( $raw ) ) {
            return;
        }
        if ( ! is_array( $raw ) ) {
            $raw = array( $raw );
        }
        foreach ( $raw as $key => $item ) {
            $c = '';
            if ( is_string( $item ) && strlen( $item ) >= 3 && strlen( $item ) <= 4 && ! is_numeric( $item ) ) {
                $c = $item;
            } elseif ( is_string( $key ) && strlen( $key ) >= 3 && strlen( $key ) <= 4 && ctype_alpha( $key ) ) {
                $c = $key;
            } elseif ( is_array( $item ) ) {
                if ( ! empty( $item['currency'] ) ) {
                    $c = $item['currency'];
                } elseif ( ! empty( $item['code'] ) ) {
                    $c = $item['code'];
                }
            } elseif ( is_object( $item ) ) {
                if ( isset( $item->currency ) ) {
                    $c = $item->currency;
                } elseif ( isset( $item->post_title ) ) {
                    $c = $item->post_title;
                }
            }
            $c = strtoupper( sanitize_text_field( (string) $c ) );
            if ( $c && preg_match( '/^[A-Z]{3}$/', $c ) ) {
                $codes[] = $c;
            }
        }
    };

    // 1) YayCurrency (CPT yay-currency: el código es el post_title).
    if ( post_type_exists( 'yay-currency' ) ) {
        $yay_posts = get_posts(
            array(
                'post_type'      => 'yay-currency',
                'post_status'    => 'publish',
                'posts_per_page' => 50,
                'orderby'        => 'menu_order title',
                'order'          => 'ASC',
            )
        );
        foreach ( $yay_posts as $post ) {
            $push( $post->post_title );
        }
    }
    if ( class_exists( 'Yay_Currency\Helpers\Helper', false ) && is_callable( array( 'Yay_Currency\Helpers\Helper', 'get_currencies_post_type' ) ) ) {
        $push( \Yay_Currency\Helpers\Helper::get_currencies_post_type() );
    }
    if ( class_exists( 'Yay_Currency\Helpers\YayCurrencyHelper', false ) ) {
        if ( is_callable( array( 'Yay_Currency\Helpers\YayCurrencyHelper', 'get_currencies' ) ) ) {
            $push( \Yay_Currency\Helpers\YayCurrencyHelper::get_currencies() );
        }
        // Lista convertida / aplicada.
        if ( is_callable( array( 'Yay_Currency\Helpers\YayCurrencyHelper', 'converted_currency' ) ) ) {
            $push( \Yay_Currency\Helpers\YayCurrencyHelper::converted_currency() );
        }
    }

    // 2) CURCY (fusionar, no sustituir).
    foreach ( array( 'WOOMULTI_CURRENCY_F_Data', 'WOOMULTI_CURRENCY_Data' ) as $class ) {
        if ( ! class_exists( $class ) || ! is_callable( array( $class, 'get_ins' ) ) ) {
            continue;
        }
        $settings = $class::get_ins();
        if ( ! $settings ) {
            continue;
        }
        if ( is_callable( array( $settings, 'get_currencies' ) ) ) {
            $push( $settings->get_currencies() );
        }
        if ( is_callable( array( $settings, 'get_list_currencies' ) ) ) {
            $push( $settings->get_list_currencies() );
        }
    }
    $params = get_option( 'woo_multi_currency_params', array() );
    if ( is_array( $params ) && ! empty( $params['currency'] ) ) {
        $push( $params['currency'] );
    }

    // 3) Fallback si los plugins no devolvieron nada.
    if ( empty( $codes ) ) {
        $codes = array( 'EUR', 'CHF', 'GBP' );
    }

    // Orden preferido: EUR, CHF, GBP y el resto.
    $preferred = array( 'EUR', 'CHF', 'GBP', 'USD' );
    $codes     = array_values( array_unique( array_filter( $codes ) ) );
    $ordered   = array();
    foreach ( $preferred as $p ) {
        if ( in_array( $p, $codes, true ) ) {
            $ordered[] = $p;
        }
    }
    foreach ( $codes as $c ) {
        if ( ! in_array( $c, $ordered, true ) ) {
            $ordered[] = $c;
        }
    }

    $out = array();
    foreach ( $ordered as $code ) {
        $out[ $code ] = isset( $meta[ $code ] )
            ? $meta[ $code ]
            : array(
                'label' => $code,
                'flag'  => $flags_uri . '/euro.svg',
            );
    }

    return apply_filters( 'doroshopping_header_currencies', $out );
}

/**
 * Aplica una moneda en CURCY / cookies / plugins.
 *
 * @param string $currency Código ISO.
 * @return void
 */
function doroshopping_apply_currency( $currency ) {
    $currency = strtoupper( sanitize_text_field( $currency ) );
    if ( ! $currency ) {
        return;
    }

    $path   = defined( 'COOKIEPATH' ) && COOKIEPATH ? COOKIEPATH : '/';
    $domain = defined( 'COOKIE_DOMAIN' ) ? COOKIE_DOMAIN : '';

    setcookie( 'doroshopping_currency', $currency, time() + YEAR_IN_SECONDS, $path, $domain, is_ssl(), false );
    $_COOKIE['doroshopping_currency'] = $currency;

    // CURCY.
    setcookie( 'wmc_current_currency', $currency, time() + YEAR_IN_SECONDS, $path, $domain, is_ssl(), false );
    setcookie( 'wmc_current_currency_old', $currency, time() + YEAR_IN_SECONDS, $path, $domain, is_ssl(), false );
    $_COOKIE['wmc_current_currency'] = $currency;

    // YayCurrency / genéricos.
    setcookie( 'yay_currency_code', $currency, time() + YEAR_IN_SECONDS, $path, $domain, is_ssl(), false );
    setcookie( 'woocommerce_currency', $currency, time() + YEAR_IN_SECONDS, $path, $domain, is_ssl(), false );

    if ( class_exists( 'Yay_Currency\Helpers\YayCurrencyHelper', false ) && is_callable( array( 'Yay_Currency\Helpers\YayCurrencyHelper', 'set_currency_code' ) ) ) {
        \Yay_Currency\Helpers\YayCurrencyHelper::set_currency_code( $currency );
    }

    // YayCurrency suele usar cookie/param con el código.
    setcookie( 'yay_currency_code', $currency, time() + YEAR_IN_SECONDS, $path, $domain, is_ssl(), false );
    $_COOKIE['yay_currency_code'] = $currency;

    // Si existe el CPT, guardar ID para el switcher de Yay.
    if ( post_type_exists( 'yay-currency' ) ) {
        $yay_id = 0;
        $all    = get_posts(
            array(
                'post_type'      => 'yay-currency',
                'post_status'    => 'publish',
                'posts_per_page' => 50,
            )
        );
        foreach ( $all as $p ) {
            if ( strtoupper( $p->post_title ) === $currency ) {
                $yay_id = (int) $p->ID;
                break;
            }
        }
        if ( $yay_id ) {
            setcookie( 'yay_currency_id', (string) $yay_id, time() + YEAR_IN_SECONDS, $path, $domain, is_ssl(), false );
            $_COOKIE['yay_currency_id'] = (string) $yay_id;
        }
    }

    do_action( 'doroshopping_set_currency', $currency );
    do_action( 'wmc_set_currency', $currency );
}

/**
 * País detectado / guardado para ubicación.
 *
 * @return array{code:string,label:string}
 */
function doroshopping_get_header_location() {
    $flags_uri = get_template_directory_uri() . '/assets/images/flags';
    $ui_label  = static function ( $code, $fallback ) {
        return function_exists( 'doroshopping_ui_country_label' )
            ? doroshopping_ui_country_label( $code )
            : $fallback;
    };
    $map       = array(
        'ES' => array( 'label' => $ui_label( 'ES', __( 'España', 'doroshopping' ) ), 'flag' => $flags_uri . '/spain.png', 'lang' => 'es', 'currency' => 'EUR' ),
        'PT' => array( 'label' => $ui_label( 'PT', __( 'Portugal', 'doroshopping' ) ), 'flag' => $flags_uri . '/ptg.png', 'lang' => 'pt', 'currency' => 'EUR' ),
        'FR' => array( 'label' => $ui_label( 'FR', __( 'Francia', 'doroshopping' ) ), 'flag' => $flags_uri . '/francia.png', 'lang' => 'fr', 'currency' => 'EUR' ),
        'DE' => array( 'label' => $ui_label( 'DE', __( 'Alemania', 'doroshopping' ) ), 'flag' => $flags_uri . '/alemania.png', 'lang' => 'de', 'currency' => 'EUR' ),
        'IT' => array( 'label' => $ui_label( 'IT', __( 'Italia', 'doroshopping' ) ), 'flag' => $flags_uri . '/italia.png', 'lang' => 'it', 'currency' => 'EUR' ),
        'GB' => array( 'label' => $ui_label( 'GB', __( 'Reino Unido', 'doroshopping' ) ), 'flag' => $flags_uri . '/reino-unido.png', 'lang' => 'en', 'currency' => 'GBP' ),
        'CH' => array( 'label' => $ui_label( 'CH', __( 'Suiza', 'doroshopping' ) ), 'flag' => $flags_uri . '/suiza.svg', 'lang' => 'fr', 'currency' => 'CHF' ),
    );

    $code = '';

    // Preferencia guardada por el usuario (cookie).
    if ( ! empty( $_COOKIE['doroshopping_country'] ) ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
        $code = strtoupper( sanitize_text_field( wp_unslash( $_COOKIE['doroshopping_country'] ) ) );
    }

    // WooCommerce customer country (sin forzar IP: el aviso suave pide confirmación).
    if ( '' === $code && function_exists( 'WC' ) && WC()->customer ) {
        $ship = WC()->customer->get_shipping_country();
        $bill = WC()->customer->get_billing_country();
        $code = $ship ? $ship : $bill;
    }

    if ( ! $code ) {
        $code = 'ES';
    }
    $code = strtoupper( $code );
    if ( 'UK' === $code ) {
        $code = 'GB';
    }

    $label = isset( $map[ $code ]['label'] ) ? $map[ $code ]['label'] : $code;
    $flag  = isset( $map[ $code ]['flag'] ) ? $map[ $code ]['flag'] : $flags_uri . '/spain.png';

    return array(
        'code'  => $code,
        'label' => $label,
        'flag'  => $flag,
        'map'   => $map,
    );
}

/**
 * Mapa país → idioma / moneda (para header y JS).
 *
 * @return array<string,array{lang:string,currency:string}>
 */
function doroshopping_get_location_locale_map() {
    $loc = doroshopping_get_header_location();
    $out = array();
    if ( empty( $loc['map'] ) || ! is_array( $loc['map'] ) ) {
        return $out;
    }
    foreach ( $loc['map'] as $code => $item ) {
        $out[ strtoupper( $code ) ] = array(
            'lang'     => isset( $item['lang'] ) ? (string) $item['lang'] : 'es',
            'currency' => isset( $item['currency'] ) ? (string) $item['currency'] : 'EUR',
        );
    }
    return $out;
}

/**
 * Polylang: selector de idioma en el header (lista nativa).
 */
function doroshopping_header_language_switcher() {
    // El dropdown del tema construye su propio select con URLs de Polylang.
    // Este hook queda como fallback si se necesita el dropdown nativo.
    if ( ! doroshopping_has_polylang() ) {
        do_action( 'doroshopping_header_language' );
    }
}
add_action( 'doroshopping_header_utility_language', 'doroshopping_header_language_switcher' );

/**
 * YayCurrency / CURCY / otros selectores de moneda (slot opcional; el dropdown usa selector propio).
 */
function doroshopping_header_currency_switcher() {
    // Preferir CURCY si está activo (evita Yay con 1 moneda tapando las 3 de CURCY).
    if ( shortcode_exists( 'woo_multi_currency' ) ) {
        echo '<div class="site-header__plugin-slot site-header__plugin-slot--currency" data-curcy-currency-slot hidden aria-hidden="true">';
        echo do_shortcode( '[woo_multi_currency]' );
        echo '</div>';
        return;
    }
    if ( shortcode_exists( 'woo_multi_currency_plain_horizontal' ) ) {
        echo '<div class="site-header__plugin-slot site-header__plugin-slot--currency" data-curcy-currency-slot hidden aria-hidden="true">';
        echo do_shortcode( '[woo_multi_currency_plain_horizontal]' );
        echo '</div>';
        return;
    }

    if ( shortcode_exists( 'yaycurrency-switcher' ) ) {
        echo '<div class="site-header__plugin-slot site-header__plugin-slot--currency" data-yay-currency-slot hidden aria-hidden="true">';
        echo do_shortcode( '[yaycurrency-switcher switcher_size="small" show_flag="yes" show_name="yes" show_symbol="yes" show_code="yes" device="all"]' );
        echo '</div>';
        return;
    }

    if ( shortcode_exists( 'yith_woocommerce_currency_switcher' ) ) {
        echo '<div class="site-header__plugin-slot site-header__plugin-slot--currency" hidden aria-hidden="true">';
        echo do_shortcode( '[yith_woocommerce_currency_switcher]' );
        echo '</div>';
        return;
    }

    if ( shortcode_exists( 'woocs' ) ) {
        echo '<div class="site-header__plugin-slot site-header__plugin-slot--currency" hidden aria-hidden="true">';
        echo do_shortcode( '[woocs]' );
        echo '</div>';
        return;
    }

    do_action( 'doroshopping_header_currency' );
}
add_action( 'doroshopping_header_utility_currency', 'doroshopping_header_currency_switcher' );

/**
 * Ubicación (Geo Controller + selector de país).
 */
function doroshopping_header_location_slot() {
    $loc = doroshopping_get_header_location();
    echo '<div class="site-header__plugin-slot site-header__plugin-slot--location" data-geo-location>';
    echo '<p class="header-dropdown__geo-hint">';
    echo esc_html(
        sprintf(
            /* translators: %s: country name */
            __( 'Detectado: %s', 'doroshopping' ),
            $loc['label']
        )
    );
    echo '</p>';
    do_action( 'doroshopping_header_location', $loc );
    echo '</div>';
}
add_action( 'doroshopping_header_utility_location', 'doroshopping_header_location_slot' );

/**
 * URL de vuelta tras guardar preferencias del header.
 *
 * @return string
 */
function doroshopping_prefs_redirect_url() {
    $redirect = home_url( '/' );
    if ( ! empty( $_POST['doroshopping_redirect'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
        $candidate = esc_url_raw( wp_unslash( $_POST['doroshopping_redirect'] ) );
        if ( $candidate ) {
            $redirect = $candidate;
        }
    } elseif ( wp_get_referer() ) {
        $redirect = wp_get_referer();
    }
    return $redirect;
}

/**
 * URL de la página/contenido actual en otro idioma (Polylang).
 * Si no hay traducción (p. ej. producto solo en ES), va al home de ese idioma.
 *
 * @param string $lang     Slug idioma destino.
 * @param string $fallback URL de respaldo (p. ej. la actual).
 * @return string
 */
function doroshopping_url_for_language( $lang, $fallback = '' ) {
    $lang = sanitize_key( $lang );
    $home = function_exists( 'pll_home_url' ) ? pll_home_url( $lang ) : home_url( '/' );
    if ( ! $lang || ! doroshopping_has_polylang() ) {
        return $fallback ? $fallback : $home;
    }

    $from_id   = isset( $_POST['doroshopping_from_id'] ) ? absint( $_POST['doroshopping_from_id'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Missing
    $from_type = isset( $_POST['doroshopping_from_type'] ) ? sanitize_key( wp_unslash( $_POST['doroshopping_from_type'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing

    if ( 'home' === $from_type ) {
        if ( $from_id && function_exists( 'pll_get_post' ) ) {
            $tr = pll_get_post( $from_id, $lang );
            if ( $tr ) {
                $link = get_permalink( (int) $tr );
                if ( $link ) {
                    return $link;
                }
            }
        }
        return $home;
    }

    if ( $from_id && 'term' === $from_type && function_exists( 'pll_get_term' ) ) {
        $tr = pll_get_term( $from_id, $lang );
        if ( $tr ) {
            $link = get_term_link( (int) $tr );
            if ( ! is_wp_error( $link ) ) {
                return $link;
            }
        }
        // Sin categoría traducida → home del idioma.
        return $home;
    }

    if ( $from_id && in_array( $from_type, array( 'post', 'page', 'product' ), true ) && function_exists( 'pll_get_post' ) ) {
        $tr = pll_get_post( $from_id, $lang );
        if ( $tr ) {
            $link = get_permalink( (int) $tr );
            if ( $link ) {
                return $link;
            }
        }
        // Producto/página sin traducción → home del idioma elegido.
        return $home;
    }

    // Sin contexto claro: intentar switcher Polylang; si apunta a la misma URL, home.
    $langs = doroshopping_get_header_languages();
    if ( ! empty( $langs[ $lang ]['url'] ) ) {
        $candidate = (string) $langs[ $lang ]['url'];
        $current   = $fallback ? $fallback : ( ! empty( $_POST['doroshopping_redirect'] ) ? esc_url_raw( wp_unslash( $_POST['doroshopping_redirect'] ) ) : '' ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
        if ( $candidate && $current && untrailingslashit( $candidate ) !== untrailingslashit( $current ) ) {
            return $candidate;
        }
    }

    return $home;
}

/**
 * Guardar preferencias del dropdown (idioma / país / moneda).
 */
function doroshopping_handle_locale_preferences() {
    if ( empty( $_POST['doroshopping_locale_nonce'] ) && empty( $_POST['doroshopping_locale_submit'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
        return;
    }

    $redirect = doroshopping_prefs_redirect_url();

    if ( empty( $_POST['doroshopping_locale_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['doroshopping_locale_nonce'] ) ), 'doroshopping_locale_prefs' ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
        wp_safe_redirect( $redirect );
        exit;
    }

    if ( function_exists( 'doroshopping_prefs_rate_limit_ok' ) && ! doroshopping_prefs_rate_limit_ok( 'locale_prefs' ) ) {
        wp_safe_redirect( $redirect );
        exit;
    }

    // País → solo envío / cookie. NO cambia el idioma.
    if ( isset( $_POST['ubicacion'] ) ) {
        $country = strtoupper( sanitize_text_field( wp_unslash( $_POST['ubicacion'] ) ) );
        if ( strlen( $country ) >= 2 ) {
            $country = substr( $country, 0, 2 );
            if ( 'UK' === $country ) {
                $country = 'GB';
            }
            if ( function_exists( 'doroshopping_set_cookie' ) ) {
                doroshopping_set_cookie( 'doroshopping_country', $country, time() + YEAR_IN_SECONDS, false );
            } else {
                $path   = defined( 'COOKIEPATH' ) && COOKIEPATH ? COOKIEPATH : '/';
                $domain = defined( 'COOKIE_DOMAIN' ) ? COOKIE_DOMAIN : '';
                setcookie( 'doroshopping_country', $country, time() + YEAR_IN_SECONDS, $path, $domain, is_ssl(), false );
                $_COOKIE['doroshopping_country'] = $country;
            }

            if ( function_exists( 'WC' ) && WC()->customer ) {
                WC()->customer->set_billing_country( $country );
                WC()->customer->set_shipping_country( $country );
                WC()->customer->save();
            }

            // País sugiere idioma/moneda por defecto (el usuario puede cambiar lengua luego).
            $locale_map = doroshopping_get_location_locale_map();
            if ( empty( $_POST['lengua'] ) && isset( $locale_map[ $country ]['lang'] ) ) {
                $_POST['lengua'] = $locale_map[ $country ]['lang'];
            }
            if ( empty( $_POST['divisa'] ) && isset( $locale_map[ $country ]['currency'] ) ) {
                $_POST['divisa'] = $locale_map[ $country ]['currency'];
            }
        }
    }

    // Idioma → misma página/producto traducido (no forzar home).
    if ( ! empty( $_POST['lengua'] ) && doroshopping_has_polylang() ) {
        $lang     = sanitize_key( wp_unslash( $_POST['lengua'] ) );
        $current  = function_exists( 'pll_current_language' ) ? sanitize_key( (string) pll_current_language( 'slug' ) ) : '';
        if ( $lang && $lang !== $current ) {
            $redirect = doroshopping_url_for_language( $lang, $redirect );
        }
    }

    if ( ! empty( $_POST['divisa'] ) ) {
        $currency = strtoupper( sanitize_text_field( wp_unslash( $_POST['divisa'] ) ) );
        doroshopping_apply_currency( $currency );
        $redirect = add_query_arg(
            array(
                'wmc-currency' => $currency,
                'yay-currency' => $currency,
            ),
            $redirect
        );
    }

    nocache_headers();
    wp_safe_redirect( $redirect );
    exit;
}
add_action( 'admin_post_doroshopping_save_locale', 'doroshopping_handle_locale_preferences' );
add_action( 'admin_post_nopriv_doroshopping_save_locale', 'doroshopping_handle_locale_preferences' );
// Compat por si queda algún formulario antiguo.
add_action( 'template_redirect', 'doroshopping_handle_locale_preferences', 5 );

/**
 * Guardar dirección rápida del dropdown de envío.
 */
function doroshopping_handle_shipping_preferences() {
    if ( empty( $_POST['doroshopping_shipping_nonce'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
        return;
    }

    $redirect = doroshopping_prefs_redirect_url();
    if ( wp_get_referer() ) {
        $redirect = wp_get_referer();
    }

    if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['doroshopping_shipping_nonce'] ) ), 'doroshopping_shipping_prefs' ) ) {
        wp_safe_redirect( $redirect );
        exit;
    }

    if ( function_exists( 'doroshopping_prefs_rate_limit_ok' ) && ! doroshopping_prefs_rate_limit_ok( 'shipping_prefs' ) ) {
        wp_safe_redirect( $redirect );
        exit;
    }

    $country  = isset( $_POST['pais'] ) ? strtoupper( sanitize_text_field( wp_unslash( $_POST['pais'] ) ) ) : '';
    $state    = isset( $_POST['provincia'] ) ? sanitize_text_field( wp_unslash( $_POST['provincia'] ) ) : '';
    $city     = isset( $_POST['ciudad'] ) ? sanitize_text_field( wp_unslash( $_POST['ciudad'] ) ) : '';
    $postcode = isset( $_POST['codigo_postal'] ) ? sanitize_text_field( wp_unslash( $_POST['codigo_postal'] ) ) : '';

    if ( $country ) {
        $country = substr( $country, 0, 2 );
        if ( function_exists( 'doroshopping_set_cookie' ) ) {
            doroshopping_set_cookie( 'doroshopping_country', $country, time() + YEAR_IN_SECONDS, false );
        } else {
            $path    = defined( 'COOKIEPATH' ) && COOKIEPATH ? COOKIEPATH : '/';
            $domain  = defined( 'COOKIE_DOMAIN' ) ? COOKIE_DOMAIN : '';
            setcookie( 'doroshopping_country', $country, time() + YEAR_IN_SECONDS, $path, $domain, is_ssl(), false );
            $_COOKIE['doroshopping_country'] = $country;
        }
    }

    if ( function_exists( 'WC' ) && WC()->customer ) {
        if ( $country ) {
            WC()->customer->set_shipping_country( $country );
            WC()->customer->set_billing_country( $country );
        }
        if ( $state ) {
            WC()->customer->set_shipping_state( $state );
        }
        if ( $city ) {
            WC()->customer->set_shipping_city( $city );
        }
        if ( $postcode ) {
            WC()->customer->set_shipping_postcode( $postcode );
        }
        WC()->customer->save();
    }

    if ( $postcode ) {
        if ( function_exists( 'doroshopping_set_cookie' ) ) {
            doroshopping_set_cookie( 'doroshopping_postcode', $postcode, time() + YEAR_IN_SECONDS, false );
        } else {
            $path   = defined( 'COOKIEPATH' ) && COOKIEPATH ? COOKIEPATH : '/';
            $domain = defined( 'COOKIE_DOMAIN' ) ? COOKIE_DOMAIN : '';
            setcookie( 'doroshopping_postcode', $postcode, time() + YEAR_IN_SECONDS, $path, $domain, is_ssl(), false );
            $_COOKIE['doroshopping_postcode'] = $postcode;
        }
    }

    wp_safe_redirect( $redirect );
    exit;
}
add_action( 'admin_post_doroshopping_save_shipping', 'doroshopping_handle_shipping_preferences' );
add_action( 'admin_post_nopriv_doroshopping_save_shipping', 'doroshopping_handle_shipping_preferences' );
add_action( 'template_redirect', 'doroshopping_handle_shipping_preferences', 5 );

/**
 * Copiar páginas esenciales a un nuevo idioma Polylang (helper admin).
 *
 * @param string $lang_slug Slug idioma destino (ej. en, fr).
 * @return int Número de páginas creadas/enlazadas.
 */
function doroshopping_polylang_sync_essential_pages( $lang_slug ) {
    if ( ! doroshopping_has_polylang() || ! function_exists( 'pll_set_post_language' ) || ! function_exists( 'pll_save_post_translations' ) ) {
        return 0;
    }
    if ( ! function_exists( 'doroshopping_essential_pages' ) || ! function_exists( 'doroshopping_get_page_by_slug' ) ) {
        return 0;
    }

    $lang_slug = sanitize_key( $lang_slug );
    $created   = 0;
    $default   = function_exists( 'pll_default_language' ) ? pll_default_language( 'slug' ) : 'es';

    foreach ( array_keys( doroshopping_essential_pages() ) as $slug ) {
        $source = doroshopping_get_page_by_slug( $slug );
        if ( ! $source instanceof WP_Post ) {
            continue;
        }

        // ¿Ya hay traducción?
        if ( function_exists( 'pll_get_post' ) ) {
            $existing = pll_get_post( $source->ID, $lang_slug );
            if ( $existing ) {
                continue;
            }
        }

        $new_id = wp_insert_post(
            array(
                'post_title'   => $source->post_title . ' (' . strtoupper( $lang_slug ) . ')',
                'post_content' => $source->post_content,
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_author'  => $source->post_author,
            ),
            true
        );
        if ( is_wp_error( $new_id ) || ! $new_id ) {
            continue;
        }

        pll_set_post_language( (int) $new_id, $lang_slug );
        $translations = function_exists( 'pll_get_post_translations' ) ? pll_get_post_translations( $source->ID ) : array();
        if ( ! is_array( $translations ) ) {
            $translations = array();
        }
        $translations[ $default ]   = $source->ID;
        $translations[ $lang_slug ] = (int) $new_id;
        pll_save_post_translations( $translations );
        $created++;
    }

    return $created;
}

/**
 * Declare Elementor support.
 */
function doroshopping_woocommerce_setup() {
    add_theme_support( 'elementor' );
}
add_action( 'after_setup_theme', 'doroshopping_woocommerce_setup' );

/**
 * ¿Autocomplete Google Address activo?
 *
 * @return bool
 */
function doroshopping_is_aga_active() {
    if ( defined( 'AGA_VERSION' ) ) {
        return true;
    }
    $plugin = 'autocomplete-google-address/autocomplete-google-address.php';
    if ( ! function_exists( 'is_plugin_active' ) ) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    return function_exists( 'is_plugin_active' ) && is_plugin_active( $plugin );
}

/**
 * Parche defensivo: AGA llama querySelectorAll('') si main_selector está vacío
 * en alguna config (rompe la consola). Saltamos selectores vacíos.
 *
 * Arreglo real: Google Address → configs → Trigger Field = #billing_address_1 etc.
 *
 * @return void
 */
function doroshopping_aga_empty_selector_guard() {
    if ( is_admin() || ! doroshopping_is_aga_active() ) {
        return;
    }
    ?>
<script>
(function () {
    function patchAga() {
        if (!window.aga || typeof window.aga.setupAutocomplete !== 'function' || window.aga.__doroGuard) {
            return !!window.aga;
        }
        var orig = window.aga.setupAutocomplete;
        window.aga.setupAutocomplete = function (config) {
            if (!config || !config.main_selector || !String(config.main_selector).trim()) {
                return;
            }
            return orig.call(this, config);
        };
        window.aga.__doroGuard = true;
        if (Array.isArray(window.aga_form_configs)) {
            window.aga_form_configs = window.aga_form_configs.filter(function (c) {
                return c && c.main_selector && String(c.main_selector).trim();
            });
        }
        return true;
    }

    if (patchAga()) {
        return;
    }

    var tries = 0;
    var timer = setInterval(function () {
        tries += 1;
        if (patchAga() || tries > 80) {
            clearInterval(timer);
        }
    }, 50);
})();
</script>
    <?php
}
add_action( 'wp_head', 'doroshopping_aga_empty_selector_guard', 1 );
add_action( 'wp_footer', 'doroshopping_aga_empty_selector_guard', 1 );
