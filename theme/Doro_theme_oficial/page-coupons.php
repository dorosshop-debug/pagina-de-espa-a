<?php
/**
 * Template Name: Cupones
 * Template post type: page
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$shop_url     = function_exists( 'doroshopping_get_wc_page_url' ) ? doroshopping_get_wc_page_url( 'shop' ) : home_url( '/' );
$cart_url     = function_exists( 'doroshopping_get_cart_url' ) ? doroshopping_get_cart_url() : home_url( '/' );
$account_url  = function_exists( 'doroshopping_get_account_url' ) ? doroshopping_get_account_url() : home_url( '/' );
$coupon_code  = isset( $_GET['coupon'] ) ? sanitize_text_field( wp_unslash( $_GET['coupon'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$applied_ok   = isset( $_GET['coupon_applied'] ) && '1' === $_GET['coupon_applied']; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$applied_err  = isset( $_GET['coupon_error'] ) ? sanitize_text_field( wp_unslash( $_GET['coupon_error'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
?>

<main id="main-content" class="doro-support doro-coupons">
	<div class="doro-support__hero">
		<div class="doro-support__hero-inner">
			<p class="doro-support__eyebrow"><?php esc_html_e( 'Ofertas y descuentos', 'doroshopping' ); ?></p>
			<h1 class="doro-support__title"><?php esc_html_e( 'Mis cupones', 'doroshopping' ); ?></h1>
			<p class="doro-support__lead">
				<?php esc_html_e( 'Aplica un código de descuento y ahorra en tu próxima compra. Los cupones se validan automáticamente en el carrito.', 'doroshopping' ); ?>
			</p>
		</div>
	</div>

	<div class="doro-support__container">
		<?php if ( $applied_ok ) : ?>
			<div class="doro-support__notice doro-support__notice--success" role="status">
				<?php esc_html_e( 'Cupón aplicado correctamente. Revisa tu carrito para ver el descuento.', 'doroshopping' ); ?>
			</div>
		<?php elseif ( $applied_err ) : ?>
			<div class="doro-support__notice doro-support__notice--error" role="alert">
				<?php echo esc_html( $applied_err ); ?>
			</div>
		<?php endif; ?>

		<section class="doro-coupons__apply">
			<h2 class="doro-support__section-title"><?php esc_html_e( 'Aplicar código', 'doroshopping' ); ?></h2>
			<form class="doro-coupons__form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="doroshopping_apply_coupon">
				<?php wp_nonce_field( 'doroshopping_apply_coupon', 'doroshopping_coupon_nonce' ); ?>
				<label class="screen-reader-text" for="doro-coupon-code"><?php esc_html_e( 'Código de cupón', 'doroshopping' ); ?></label>
				<input
					id="doro-coupon-code"
					type="text"
					name="coupon_code"
					value="<?php echo esc_attr( $coupon_code ); ?>"
					placeholder="<?php esc_attr_e( 'Introduce tu código', 'doroshopping' ); ?>"
					autocomplete="off"
					required
				>
				<button type="submit" class="doro-support__btn"><?php esc_html_e( 'Aplicar cupón', 'doroshopping' ); ?></button>
			</form>
			<p class="doro-coupons__hint">
				<?php
				printf(
					/* translators: %s: cart url */
					wp_kses_post( __( 'También puedes aplicar cupones desde el <a href="%s">carrito</a> o el checkout.', 'doroshopping' ) ),
					esc_url( $cart_url )
				);
				?>
			</p>
		</section>

		<section class="doro-coupons__howto">
			<h2 class="doro-support__section-title"><?php esc_html_e( 'Cómo funcionan los cupones', 'doroshopping' ); ?></h2>
			<div class="doro-support__cards">
				<article class="doro-support__card">
					<span class="doro-support__card-num" aria-hidden="true">1</span>
					<h3><?php esc_html_e( 'Consigue un código', 'doroshopping' ); ?></h3>
					<p><?php esc_html_e( 'Recibe cupones por email, campañas o promociones activas de Doroshopping.', 'doroshopping' ); ?></p>
				</article>
				<article class="doro-support__card">
					<span class="doro-support__card-num" aria-hidden="true">2</span>
					<h3><?php esc_html_e( 'Aplícalo aquí o en el carrito', 'doroshopping' ); ?></h3>
					<p><?php esc_html_e( 'Introduce el código exacto. Distingue mayúsculas/minúsculas según indique la promoción.', 'doroshopping' ); ?></p>
				</article>
				<article class="doro-support__card">
					<span class="doro-support__card-num" aria-hidden="true">3</span>
					<h3><?php esc_html_e( 'Disfruta el descuento', 'doroshopping' ); ?></h3>
					<p><?php esc_html_e( 'El descuento se refleja al instante si el cupón es válido y cumple las condiciones.', 'doroshopping' ); ?></p>
				</article>
			</div>
		</section>

		<section class="doro-coupons__empty-panel">
			<div class="doro-coupons__empty">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M4 9h16v2H4z"/><path d="M7 9V7a5 5 0 0 1 10 0v2"/><path d="M9 13h6"/></svg>
				<h2><?php esc_html_e( 'Aún no tienes cupones guardados', 'doroshopping' ); ?></h2>
				<p><?php esc_html_e( 'Cuando tengamos promociones activas o recibas un código personalizado, podrás usarlo aquí.', 'doroshopping' ); ?></p>
				<div class="doro-coupons__actions">
					<a class="doro-support__btn" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Ir a la tienda', 'doroshopping' ); ?></a>
					<a class="doro-support__btn doro-support__btn--ghost" href="<?php echo esc_url( $account_url ); ?>"><?php esc_html_e( 'Mi cuenta', 'doroshopping' ); ?></a>
				</div>
			</div>
		</section>
	</div>
</main>

<?php
get_footer();
