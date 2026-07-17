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
            'primary'    => __( 'Menu principal', 'doroshopping' ),
            'categories' => __( 'Mega menu categorias', 'doroshopping' ),
            'footer'     => __( 'Menu footer', 'doroshopping' ),
        )
    );
}
add_action( 'after_setup_theme', 'doroshopping_setup' );

/**
 * URL del logo. Prioriza custom logo de WP; fallback al archivo del tema.
 *
 * @return string
 */
function doroshopping_logo_url() {
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    if ( $custom_logo_id ) {
        $url = wp_get_attachment_image_url( $custom_logo_id, 'full' );
        if ( $url ) {
            return $url;
        }
    }
    return get_template_directory_uri() . '/assets/images/logo/logo_doro_v2.png';
}
