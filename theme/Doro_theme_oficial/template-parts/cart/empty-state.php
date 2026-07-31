<?php
/**
 * Bloque visual de cesta vacía (imagen + CTAs).
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ui = static function ( $key ) {
	return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : '';
};

$img         = get_template_directory_uri() . '/assets/images/cart/carrito_doro.png';
$shop_url    = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
$account_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : wp_login_url();
?>

<div class="doro-cesta-empty">
	<img
		class="doro-cesta-empty__image"
		src="<?php echo esc_url( $img ); ?>"
		alt=""
		width="220"
		height="180"
		loading="lazy"
		decoding="async"
	>

	<p class="doro-cesta-empty__text"><?php echo esc_html( $ui( 'doroshopping_ui_cart_empty' ) ); ?></p>

	<div class="doro-cesta-empty__actions">
		<?php if ( ! is_user_logged_in() ) : ?>
			<a class="doro-cesta-empty__btn doro-cesta-empty__btn--primary" href="<?php echo esc_url( $account_url ); ?>">
				<?php echo esc_html( $ui( 'doroshopping_ui_cart_identify' ) ); ?>
			</a>
		<?php endif; ?>
		<a class="doro-cesta-empty__btn doro-cesta-empty__btn--dark" href="<?php echo esc_url( $shop_url ); ?>">
			<?php echo esc_html( $ui( 'doroshopping_ui_cart_explore' ) ); ?>
		</a>
	</div>
</div>
