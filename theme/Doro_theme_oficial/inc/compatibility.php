<?php
/**
 * Compatibilidad con plugins (Polylang, WooCommerce, YITH Currency, geolocalizacion)
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Polylang: selector de idioma en el header.
 */
function doroshopping_header_language_switcher() {
    if ( function_exists( 'pll_the_languages' ) ) {
        echo '<div class="site-header__plugin-slot site-header__plugin-slot--language">';
        pll_the_languages(
            array(
                'dropdown'               => 1,
                'show_flags'             => 1,
                'show_names'             => 1,
                'display_names_as'       => 'name',
                'hide_if_empty'          => 0,
                'hide_current'           => 0,
            )
        );
        echo '</div>';
        return;
    }

    /**
     * Fallback / inyeccion alternativa (WPML u otros).
     *
     * @hook doroshopping_header_language
     */
    do_action( 'doroshopping_header_language' );
}
add_action( 'doroshopping_header_utility_language', 'doroshopping_header_language_switcher' );

/**
 * YITH Multi Currency / selectores de moneda.
 */
function doroshopping_header_currency_switcher() {
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

    /**
     * @hook doroshopping_header_currency
     */
    do_action( 'doroshopping_header_currency' );
}
add_action( 'doroshopping_header_utility_currency', 'doroshopping_header_currency_switcher' );

/**
 * Geolocalizacion / envio.
 */
function doroshopping_header_location_slot() {
    /**
     * Plugins de geolocalizacion pueden enganchar aqui.
     *
     * @hook doroshopping_header_location
     */
    do_action( 'doroshopping_header_location' );
}
add_action( 'doroshopping_header_utility_location', 'doroshopping_header_location_slot' );

/**
 * Busqueda WooCommerce (productos).
 *
 * @return string
 */
function doroshopping_product_search_action() {
    if ( function_exists( 'wc_get_page_permalink' ) ) {
        return esc_url( home_url( '/' ) );
    }
    return esc_url( home_url( '/' ) );
}

/**
 * Declare Elementor support (WooCommerce support vive en setup.php).
 */
function doroshopping_woocommerce_setup() {
    add_theme_support( 'elementor' );
}
add_action( 'after_setup_theme', 'doroshopping_woocommerce_setup' );
