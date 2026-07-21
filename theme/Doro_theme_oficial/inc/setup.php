<?php
/**
 * Theme setup
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function doroshopping_setup() {
    load_theme_textdomain( 'doroshopping', get_template_directory() . '/languages' );

    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
    add_theme_support( 'custom-logo', array(
        'height'      => 80,
        'width'       => 240,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    register_nav_menus(
        array(
            'primary'    => __( 'Menú principal', 'doroshopping' ),
            'categories' => __( 'Mega menú categorías', 'doroshopping' ),
            'footer'     => __( 'Menú footer', 'doroshopping' ),
        )
    );

    add_theme_support(
        'woocommerce',
        array(
            'thumbnail_image_width' => 400,
            'single_image_width'    => 800,
            'product_grid'          => array(
                'default_rows'    => 4,
                'min_rows'        => 1,
                'default_columns' => 4,
                'min_columns'     => 2,
                'max_columns'     => 5,
            ),
        )
    );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'doroshopping_setup' );

/**
 * URL del logo. Prioriza custom logo de WP; fallback al archivo del tema.
 *
 * @return string
 */
function doroshopping_logo_url() {
    $from_customizer = function_exists( 'doroshopping_get_theme_image_url' )
        ? doroshopping_get_theme_image_url( 'logo_header', '' )
        : '';
    if ( $from_customizer ) {
        return $from_customizer;
    }

    $custom_logo_id = get_theme_mod( 'custom_logo' );
    if ( $custom_logo_id ) {
        $url = wp_get_attachment_image_url( $custom_logo_id, 'full' );
        if ( $url ) {
            return $url;
        }
    }
    return get_template_directory_uri() . '/assets/images/logo/logo_header.png';
}

/**
 * Logo del footer (Customizer o fallback).
 *
 * @return string
 */
function doroshopping_footer_logo_url() {
    $custom = function_exists( 'doroshopping_get_theme_image_url' )
        ? doroshopping_get_theme_image_url( 'logo_footer', '' )
        : '';
    if ( $custom ) {
        return $custom;
    }
    return get_template_directory_uri() . '/assets/images/logo/logo_doro_blanco.png';
}

/**
 * Favicon / icono del sitio.
 *
 * @return string
 */
function doroshopping_icon_url() {
    return get_template_directory_uri() . '/assets/images/icon.png';
}

/**
 * Encolar favicon del tema.
 */
function doroshopping_site_icon() {
    if ( has_site_icon() ) {
        return;
    }
    echo '<link rel="icon" href="' . esc_url( doroshopping_icon_url() ) . '" type="image/png">' . "\n";
}
add_action( 'wp_head', 'doroshopping_site_icon', 5 );
