<?php
/**
 * Template Name: Cupones
 * Template post type: page
 *
 * Textos vía doroshopping_ui_text (Personalizar + packs por idioma).
 * Polylang solo enlaza título/URL; el cuerpo del editor puede estar vacío.
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$ui = static function ( $key ) {
	return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : '';
};

$shop_url    = function_exists( 'doroshopping_get_wc_page_url' ) ? doroshopping_get_wc_page_url( 'shop' ) : home_url( '/' );
$cart_url    = function_exists( 'doroshopping_get_cart_url' ) ? doroshopping_get_cart_url() : home_url( '/' );
$account_url = function_exists( 'doroshopping_get_account_url' ) ? doroshopping_get_account_url() : home_url( '/' );
$coupon_code = isset( $_GET['coupon'] ) ? sanitize_text_field( wp_unslash( $_GET['coupon'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$applied_ok  = isset( $_GET['coupon_applied'] ) && '1' === $_GET['coupon_applied']; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$applied_err = isset( $_GET['coupon_error'] ) ? sanitize_text_field( wp_unslash( $_GET['coupon_error'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
?>

<main id="main-content" class="doro-support doro-coupons">
	<div class="doro-support__hero">
		<div class="doro-support__hero-inner">
			<p class="doro-support__eyebrow"><?php echo esc_html( $ui( 'doroshopping_ui_coupons_eyebrow' ) ); ?></p>
			<h1 class="doro-support__title"><?php echo esc_html( $ui( 'doroshopping_ui_coupons_title' ) ); ?></h1>
			<p class="doro-support__lead"><?php echo esc_html( $ui( 'doroshopping_ui_coupons_lead' ) ); ?></p>
		</div>
	</div>

	<div class="doro-support__container">
		<?php if ( $applied_ok ) : ?>
			<div class="doro-support__notice doro-support__notice--success" role="status">
				<?php echo esc_html( $ui( 'doroshopping_ui_coupons_applied_ok' ) ); ?>
			</div>
		<?php elseif ( $applied_err ) : ?>
			<div class="doro-support__notice doro-support__notice--error" role="alert">
				<?php echo esc_html( $applied_err ); ?>
			</div>
		<?php endif; ?>

		<section class="doro-coupons__apply">
			<h2 class="doro-support__section-title"><?php echo esc_html( $ui( 'doroshopping_ui_coupons_apply_title' ) ); ?></h2>
			<form class="doro-coupons__form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="doroshopping_apply_coupon">
				<?php wp_nonce_field( 'doroshopping_apply_coupon', 'doroshopping_coupon_nonce' ); ?>
				<label class="screen-reader-text" for="doro-coupon-code"><?php echo esc_html( $ui( 'doroshopping_ui_coupons_code_label' ) ); ?></label>
				<input
					id="doro-coupon-code"
					type="text"
					name="coupon_code"
					value="<?php echo esc_attr( $coupon_code ); ?>"
					placeholder="<?php echo esc_attr( $ui( 'doroshopping_ui_coupons_code_ph' ) ); ?>"
					autocomplete="off"
					required
				>
				<button type="submit" class="doro-support__btn"><?php echo esc_html( $ui( 'doroshopping_ui_coupons_apply_btn' ) ); ?></button>
			</form>
			<p class="doro-coupons__hint">
				<?php
				$hint = function_exists( 'doroshopping_ui_sprintf' )
					? doroshopping_ui_sprintf( 'doroshopping_ui_coupons_hint', esc_url( $cart_url ) )
					: '';
				echo wp_kses_post( $hint );
				?>
			</p>
		</section>

		<section class="doro-coupons__howto">
			<h2 class="doro-support__section-title"><?php echo esc_html( $ui( 'doroshopping_ui_coupons_howto_title' ) ); ?></h2>
			<div class="doro-support__cards">
				<article class="doro-support__card">
					<span class="doro-support__card-num" aria-hidden="true">1</span>
					<h3><?php echo esc_html( $ui( 'doroshopping_ui_coupons_step1_title' ) ); ?></h3>
					<p><?php echo esc_html( $ui( 'doroshopping_ui_coupons_step1_text' ) ); ?></p>
				</article>
				<article class="doro-support__card">
					<span class="doro-support__card-num" aria-hidden="true">2</span>
					<h3><?php echo esc_html( $ui( 'doroshopping_ui_coupons_step2_title' ) ); ?></h3>
					<p><?php echo esc_html( $ui( 'doroshopping_ui_coupons_step2_text' ) ); ?></p>
				</article>
				<article class="doro-support__card">
					<span class="doro-support__card-num" aria-hidden="true">3</span>
					<h3><?php echo esc_html( $ui( 'doroshopping_ui_coupons_step3_title' ) ); ?></h3>
					<p><?php echo esc_html( $ui( 'doroshopping_ui_coupons_step3_text' ) ); ?></p>
				</article>
			</div>
		</section>

		<section class="doro-coupons__empty-panel">
			<div class="doro-coupons__empty">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M4 9h16v2H4z"/><path d="M7 9V7a5 5 0 0 1 10 0v2"/><path d="M9 13h6"/></svg>
				<h2><?php echo esc_html( $ui( 'doroshopping_ui_coupons_empty_title' ) ); ?></h2>
				<p><?php echo esc_html( $ui( 'doroshopping_ui_coupons_empty_text' ) ); ?></p>
				<div class="doro-coupons__actions">
					<a class="doro-support__btn" href="<?php echo esc_url( $shop_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_coupons_go_shop' ) ); ?></a>
					<a class="doro-support__btn doro-support__btn--ghost" href="<?php echo esc_url( $account_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_coupons_go_account' ) ); ?></a>
				</div>
			</div>
		</section>
	</div>
</main>

<?php
get_footer();
