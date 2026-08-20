<?php
/**
 * Doroshopping / Doro_theme_oficial
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'DOROSHOPPING_VERSION', '1.9.11' );
define( 'DOROSHOPPING_DIR', get_template_directory() );
define( 'DOROSHOPPING_URI', get_template_directory_uri() );

require_once DOROSHOPPING_DIR . '/inc/setup.php';
require_once DOROSHOPPING_DIR . '/inc/helpers.php';
require_once DOROSHOPPING_DIR . '/inc/security.php';
require_once DOROSHOPPING_DIR . '/inc/auth.php';
require_once DOROSHOPPING_DIR . '/inc/pages.php';
require_once DOROSHOPPING_DIR . '/inc/support.php';
require_once DOROSHOPPING_DIR . '/inc/mega-menu.php';
require_once DOROSHOPPING_DIR . '/inc/i18n-ui-chrome.php';
require_once DOROSHOPPING_DIR . '/inc/i18n-ui-pages.php';
require_once DOROSHOPPING_DIR . '/inc/i18n-ui-legal-pages.php';
require_once DOROSHOPPING_DIR . '/inc/i18n-ui-support-pages.php';
require_once DOROSHOPPING_DIR . '/inc/i18n-ui-content-pages.php';
require_once DOROSHOPPING_DIR . '/inc/i18n-ui-translations-pages.php';
require_once DOROSHOPPING_DIR . '/inc/i18n-ui-translations-legal.php';
require_once DOROSHOPPING_DIR . '/inc/i18n-ui-translations-support.php';
require_once DOROSHOPPING_DIR . '/inc/i18n-ui-translations-content.php';
require_once DOROSHOPPING_DIR . '/inc/i18n-ui-translations.php';
require_once DOROSHOPPING_DIR . '/inc/i18n-mods.php';
require_once DOROSHOPPING_DIR . '/inc/customizer.php';
require_once DOROSHOPPING_DIR . '/inc/enqueue.php';
require_once DOROSHOPPING_DIR . '/inc/ajax-cart.php';
require_once DOROSHOPPING_DIR . '/inc/ajax-search.php';
require_once DOROSHOPPING_DIR . '/inc/seo.php';
require_once DOROSHOPPING_DIR . '/inc/performance-guard.php';
require_once DOROSHOPPING_DIR . '/inc/geolocation.php';
require_once DOROSHOPPING_DIR . '/inc/compatibility.php';
require_once DOROSHOPPING_DIR . '/inc/bigbuy-shipping.php';
require_once DOROSHOPPING_DIR . '/inc/wishlist.php';
// HPOS / blocks: registrar el hook cuanto antes (antes de before_woocommerce_init).
require_once DOROSHOPPING_DIR . '/inc/woocommerce-compat.php';
require_once DOROSHOPPING_DIR . '/inc/emails.php';

/**
 * WooCommerce hooks only when the plugin is active.
 */
function doroshopping_load_woocommerce_integration() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        return;
    }
    require_once DOROSHOPPING_DIR . '/inc/woocommerce.php';
    require_once DOROSHOPPING_DIR . '/inc/cart-ux.php';
    require_once DOROSHOPPING_DIR . '/inc/cart-checkout.php';
}
add_action( 'after_setup_theme', 'doroshopping_load_woocommerce_integration', 20 );

/**
 * Elementor integration when plugin is active.
 */
function doroshopping_load_elementor_integration() {
    require_once DOROSHOPPING_DIR . '/inc/elementor.php';
}
add_action( 'elementor/loaded', 'doroshopping_load_elementor_integration' );
