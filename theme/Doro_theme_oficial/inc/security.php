<?php
/**
 * Endurecimiento basico del tema.
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Evita editar temas/plugins desde el admin (si no esta definido en wp-config).
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
    define( 'DISALLOW_FILE_EDIT', true );
}

/**
 * Cabeceras HTTP defensivas en el front.
 *
 * @return void
 */
function doroshopping_security_headers() {
    if ( is_admin() || headers_sent() ) {
        return;
    }

    header( 'X-Content-Type-Options: nosniff' );
    header( 'X-Frame-Options: SAMEORIGIN' );
    header( 'Referrer-Policy: strict-origin-when-cross-origin' );
    header( 'Permissions-Policy: camera=(), microphone=(), geolocation=()' );
}
add_action( 'send_headers', 'doroshopping_security_headers' );

/**
 * Reduce huella en <head>.
 *
 * @return void
 */
function doroshopping_security_cleanup_head() {
    remove_action( 'wp_head', 'wp_generator' );
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'wp_shortlink_wp_head' );
    remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
}
add_action( 'after_setup_theme', 'doroshopping_security_cleanup_head' );

/**
 * No exponer la version de WordPress en el generador RSS.
 *
 * @return string
 */
function doroshopping_remove_version_rss() {
    return '';
}
add_filter( 'the_generator', 'doroshopping_remove_version_rss' );

/**
 * Evita enumeracion simple de autores por ?author=N en el front.
 *
 * @return void
 */
function doroshopping_block_author_enumeration() {
    if ( is_admin() || ! isset( $_GET['author'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        return;
    }

    $author = (string) wp_unslash( $_GET['author'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    if ( ! preg_match( '/^\d+$/', $author ) ) {
        return;
    }

    wp_safe_redirect( home_url( '/' ), 301 );
    exit;
}
add_action( 'template_redirect', 'doroshopping_block_author_enumeration', 1 );
