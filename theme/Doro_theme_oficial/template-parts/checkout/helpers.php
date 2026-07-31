<?php
/**
 * Accesos rápidos del checkout: login y cupón (sustituye avisos WC por defecto).
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ui = static function ( $key ) {
	return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : '';
};

$show_login  = ! is_user_logged_in() && 'no' !== get_option( 'woocommerce_enable_checkout_login_reminder' );
$show_coupon = wc_coupons_enabled();

if ( ! $show_login && ! $show_coupon ) {
	return;
}
?>

<div class="doro-checkout-helpers" aria-label="<?php echo esc_attr( $ui( 'doroshopping_ui_checkout_helpers_aria' ) ); ?>">
	<?php if ( $show_login ) : ?>
		<button type="button" class="doro-checkout-helper" data-doro-checkout-toggle="login" aria-expanded="false" aria-controls="doro-checkout-login-panel">
			<span class="doro-checkout-helper__icon" aria-hidden="true">
				<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
			</span>
			<span class="doro-checkout-helper__text">
				<strong><?php echo esc_html( $ui( 'doroshopping_ui_checkout_helper_customer' ) ); ?></strong>
				<span><?php echo esc_html( $ui( 'doroshopping_ui_checkout_helper_customer_sub' ) ); ?></span>
			</span>
			<span class="doro-checkout-helper__cta"><?php echo esc_html( $ui( 'doroshopping_ui_checkout_helper_access' ) ); ?></span>
		</button>
	<?php endif; ?>

	<?php if ( $show_coupon ) : ?>
		<button type="button" class="doro-checkout-helper" data-doro-checkout-toggle="coupon" aria-expanded="false" aria-controls="doro-checkout-coupon-panel">
			<span class="doro-checkout-helper__icon" aria-hidden="true">
				<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
			</span>
			<span class="doro-checkout-helper__text">
				<strong><?php echo esc_html( $ui( 'doroshopping_ui_checkout_helper_coupon' ) ); ?></strong>
				<span><?php echo esc_html( $ui( 'doroshopping_ui_checkout_helper_coupon_sub' ) ); ?></span>
			</span>
			<span class="doro-checkout-helper__cta"><?php echo esc_html( $ui( 'doroshopping_ui_checkout_helper_add' ) ); ?></span>
		</button>
	<?php endif; ?>
</div>
