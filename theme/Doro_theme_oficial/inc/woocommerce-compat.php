<?php
/**
 * Declaración de compatibilidad WooCommerce HPOS / features.
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action(
    'before_woocommerce_init',
    function () {
        if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
            \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', get_template_directory() . '/style.css', true );
            \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'cart_checkout_blocks', get_template_directory() . '/style.css', true );
        }
    }
);
