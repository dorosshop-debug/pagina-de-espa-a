<?php
/**
 * My Account page
 *
 * @package Doroshopping
 */

defined( 'ABSPATH' ) || exit;

/**
 * My Account navigation.
 */
do_action( 'woocommerce_account_navigation' );
?>

<div class="woocommerce-MyAccount-content">
    <?php
    /**
     * My Account content.
     */
    do_action( 'woocommerce_account_content' );
    ?>
</div>
