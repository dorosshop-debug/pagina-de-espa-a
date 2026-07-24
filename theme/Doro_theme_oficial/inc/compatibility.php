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
 * Etiqueta de moneda actual (YayCurrency / WooCommerce).
 *
 * @return string
 */
function doroshopping_get_header_currency_label() {
    $code = function_exists( 'get_woocommerce_currency' ) ? get_woocommerce_currency() : 'EUR';
    $code = apply_filters( 'doroshopping_header_currency_code', $code );

    $names = array(
        'EUR' => 'Euro',
        'USD' => 'US Dollar',
        'GBP' => 'Pound',
        'CHF' => 'Franc',
    );
    $name = isset( $names[ $code ] ) ? $names[ $code ] : $code;
    return $name . ' · ' . $code;
}

/**
 * País detectado / guardado para ubicación.
 *
 * @return array{code:string,label:string}
 */
function doroshopping_get_header_location() {
    $flags_uri = get_template_directory_uri() . '/assets/images/flags';
    $map       = array(
        'ES' => array( 'label' => __( 'España', 'doroshopping' ), 'flag' => $flags_uri . '/spain.png' ),
        'PT' => array( 'label' => __( 'Portugal', 'doroshopping' ), 'flag' => $flags_uri . '/ptg.png' ),
        'FR' => array( 'label' => __( 'Francia', 'doroshopping' ), 'flag' => $flags_uri . '/francia.png' ),
        'DE' => array( 'label' => __( 'Alemania', 'doroshopping' ), 'flag' => $flags_uri . '/alemania.png' ),
        'IT' => array( 'label' => __( 'Italia', 'doroshopping' ), 'flag' => $flags_uri . '/italia.png' ),
        'GB' => array( 'label' => __( 'Reino Unido', 'doroshopping' ), 'flag' => $flags_uri . '/reino-unido.png' ),
        'UK' => array( 'label' => __( 'Reino Unido', 'doroshopping' ), 'flag' => $flags_uri . '/reino-unido.png' ),
        'CH' => array( 'label' => __( 'Suiza', 'doroshopping' ), 'flag' => $flags_uri . '/reino-unido.png' ),
    );

    $code = '';

    // Preferencia guardada por el usuario (cookie).
    if ( ! empty( $_COOKIE['doroshopping_country'] ) ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
        $code = strtoupper( sanitize_text_field( wp_unslash( $_COOKIE['doroshopping_country'] ) ) );
    }

    // Geo Controller / CF Geo Plugin.
    if ( '' === $code && function_exists( 'do_shortcode' ) && shortcode_exists( 'cfgeo' ) ) {
        $detected = trim( wp_strip_all_tags( do_shortcode( '[cfgeo return="country_code" default=""]' ) ) );
        if ( $detected ) {
            $code = strtoupper( sanitize_text_field( $detected ) );
        }
    }

    // WooCommerce customer country.
    if ( '' === $code && function_exists( 'WC' ) && WC()->customer ) {
        $ship = WC()->customer->get_shipping_country();
        $bill = WC()->customer->get_billing_country();
        $code = $ship ? $ship : $bill;
    }

    if ( ! $code ) {
        $code = 'ES';
    }
    $code = strtoupper( $code );

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
 * YayCurrency / otros selectores de moneda.
 */
function doroshopping_header_currency_switcher() {
    if ( shortcode_exists( 'yaycurrency-switcher' ) ) {
        echo '<div class="site-header__plugin-slot site-header__plugin-slot--currency" data-yay-currency-slot>';
        echo do_shortcode( '[yaycurrency-switcher switcher_size="small" show_flag="yes" show_name="yes" show_symbol="yes" show_code="yes" device="all"]' );
        echo '</div>';
        return;
    }

    if ( shortcode_exists( 'yith_woocommerce_currency_switcher' ) ) {
        echo '<div class="site-header__plugin-slot site-header__plugin-slot--currency">';
        echo do_shortcode( '[yith_woocommerce_currency_switcher]' );
        echo '</div>';
        return;
    }

    if ( shortcode_exists( 'woocs' ) ) {
        echo '<div class="site-header__plugin-slot site-header__plugin-slot--currency">';
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

    // País → cookie + cliente WooCommerce.
    if ( isset( $_POST['ubicacion'] ) ) {
        $country = strtoupper( sanitize_text_field( wp_unslash( $_POST['ubicacion'] ) ) );
        if ( strlen( $country ) >= 2 ) {
            $country = substr( $country, 0, 2 );
            $path    = defined( 'COOKIEPATH' ) && COOKIEPATH ? COOKIEPATH : '/';
            $domain  = defined( 'COOKIE_DOMAIN' ) ? COOKIE_DOMAIN : '';
            setcookie( 'doroshopping_country', $country, time() + YEAR_IN_SECONDS, $path, $domain, is_ssl(), false );
            $_COOKIE['doroshopping_country'] = $country;

            if ( function_exists( 'WC' ) && WC()->customer ) {
                WC()->customer->set_billing_country( $country );
                WC()->customer->set_shipping_country( $country );
                WC()->customer->save();
            }
        }
    }

    // Idioma Polylang → redirigir a URL del idioma.
    if ( ! empty( $_POST['lengua'] ) && doroshopping_has_polylang() ) {
        $lang  = sanitize_key( wp_unslash( $_POST['lengua'] ) );
        $langs = doroshopping_get_header_languages();
        if ( isset( $langs[ $lang ]['url'] ) && $langs[ $lang ]['url'] ) {
            $redirect = $langs[ $lang ]['url'];
        } elseif ( function_exists( 'pll_home_url' ) ) {
            $redirect = pll_home_url( $lang );
        }
    }

    if ( ! empty( $_POST['divisa'] ) ) {
        $currency = strtoupper( sanitize_text_field( wp_unslash( $_POST['divisa'] ) ) );
        $path     = defined( 'COOKIEPATH' ) && COOKIEPATH ? COOKIEPATH : '/';
        $domain   = defined( 'COOKIE_DOMAIN' ) ? COOKIE_DOMAIN : '';
        setcookie( 'doroshopping_currency', $currency, time() + YEAR_IN_SECONDS, $path, $domain, is_ssl(), false );
    }

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

    $country  = isset( $_POST['pais'] ) ? strtoupper( sanitize_text_field( wp_unslash( $_POST['pais'] ) ) ) : '';
    $state    = isset( $_POST['provincia'] ) ? sanitize_text_field( wp_unslash( $_POST['provincia'] ) ) : '';
    $city     = isset( $_POST['ciudad'] ) ? sanitize_text_field( wp_unslash( $_POST['ciudad'] ) ) : '';
    $postcode = isset( $_POST['codigo_postal'] ) ? sanitize_text_field( wp_unslash( $_POST['codigo_postal'] ) ) : '';

    if ( $country ) {
        $country = substr( $country, 0, 2 );
        $path    = defined( 'COOKIEPATH' ) && COOKIEPATH ? COOKIEPATH : '/';
        $domain  = defined( 'COOKIE_DOMAIN' ) ? COOKIE_DOMAIN : '';
        setcookie( 'doroshopping_country', $country, time() + YEAR_IN_SECONDS, $path, $domain, is_ssl(), false );
        $_COOKIE['doroshopping_country'] = $country;
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
        $path   = defined( 'COOKIEPATH' ) && COOKIEPATH ? COOKIEPATH : '/';
        $domain = defined( 'COOKIE_DOMAIN' ) ? COOKIE_DOMAIN : '';
        setcookie( 'doroshopping_postcode', $postcode, time() + YEAR_IN_SECONDS, $path, $domain, is_ssl(), false );
        $_COOKIE['doroshopping_postcode'] = $postcode;
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
