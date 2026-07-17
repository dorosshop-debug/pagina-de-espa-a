<?php
/**
 * Enqueue scripts and styles
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function doroshopping_enqueue_assets() {
    wp_enqueue_style(
        'doroshopping-main',
        get_template_directory_uri() . '/assets/css/main.css',
        array(),
        DOROSHOPPING_VERSION
    );

    wp_enqueue_script(
        'doroshopping-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        DOROSHOPPING_VERSION,
        true
    );
}
add_action( 'wp_enqueue_scripts', 'doroshopping_enqueue_assets' );
