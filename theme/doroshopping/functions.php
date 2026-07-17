<?php
/**
 * Doroshopping Theme
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'DOROSHOPPING_VERSION', '1.0.0' );
define( 'DOROSHOPPING_DIR', get_template_directory() );
define( 'DOROSHOPPING_URI', get_template_directory_uri() );

require_once DOROSHOPPING_DIR . '/inc/setup.php';
require_once DOROSHOPPING_DIR . '/inc/enqueue.php';
require_once DOROSHOPPING_DIR . '/inc/compatibility.php';
