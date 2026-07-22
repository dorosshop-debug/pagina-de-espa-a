<?php
/**
 * My Account page (logueado)
 *
 * @package Doroshopping
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="doro-account">
    <?php do_action( 'woocommerce_account_navigation' ); ?>

    <div class="woocommerce-MyAccount-content doro-account__content">
        <?php do_action( 'woocommerce_account_content' ); ?>
    </div>
</div>
