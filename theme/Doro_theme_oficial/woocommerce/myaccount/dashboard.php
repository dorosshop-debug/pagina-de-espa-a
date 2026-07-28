<?php
/**
 * My Account Dashboard
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$current_user = wp_get_current_user();
$orders_url   = wc_get_endpoint_url( 'orders' );
$edit_url     = wc_get_endpoint_url( 'edit-account' );
$address_url  = wc_get_endpoint_url( 'edit-address' );
$wishlist_url = function_exists( 'doroshopping_get_wishlist_url' ) ? doroshopping_get_wishlist_url() : '';
$shop_url     = function_exists( 'doroshopping_get_wc_page_url' ) ? doroshopping_get_wc_page_url( 'shop' ) : home_url( '/' );

$order_count = 0;
if ( function_exists( 'wc_get_customer_order_count' ) ) {
	$order_count = (int) wc_get_customer_order_count( $current_user->ID );
}
?>

<section class="doro-account-dash">
	<header class="doro-account-dash__hero">
		<div class="doro-account-dash__hero-main">
			<p class="doro-account-dash__eyebrow"><?php esc_html_e( 'Mi cuenta', 'doroshopping' ); ?></p>
			<h2 class="doro-account-dash__title">
				<?php
				printf(
					/* translators: %s: customer display name */
					esc_html__( 'Hola, %s', 'doroshopping' ),
					esc_html( $current_user->display_name ? $current_user->display_name : $current_user->user_login )
				);
				?>
			</h2>
			<p class="doro-account-dash__text">
				<?php esc_html_e( 'Gestiona tus pedidos, direcciones y datos personales desde un solo lugar.', 'doroshopping' ); ?>
			</p>
		</div>
		<?php if ( $order_count > 0 ) : ?>
			<div class="doro-account-dash__stat">
				<span class="doro-account-dash__stat-value"><?php echo esc_html( (string) $order_count ); ?></span>
				<span class="doro-account-dash__stat-label"><?php esc_html_e( 'Pedidos', 'doroshopping' ); ?></span>
			</div>
		<?php endif; ?>
	</header>

	<div class="doro-account-dash__grid">
		<a class="doro-account-dash__card" href="<?php echo esc_url( $orders_url ); ?>">
			<span class="doro-account-dash__card-icon" aria-hidden="true">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2h12l1 7H5L6 2z"/><path d="M5 9v11a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V9"/></svg>
			</span>
			<span class="doro-account-dash__card-label"><?php esc_html_e( 'Mis pedidos', 'doroshopping' ); ?></span>
			<span class="doro-account-dash__card-desc"><?php esc_html_e( 'Historial y seguimiento', 'doroshopping' ); ?></span>
		</a>

		<a class="doro-account-dash__card" href="<?php echo esc_url( $address_url ); ?>">
			<span class="doro-account-dash__card-icon" aria-hidden="true">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 1 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
			</span>
			<span class="doro-account-dash__card-label"><?php esc_html_e( 'Direcciones', 'doroshopping' ); ?></span>
			<span class="doro-account-dash__card-desc"><?php esc_html_e( 'Facturación y envío', 'doroshopping' ); ?></span>
		</a>

		<a class="doro-account-dash__card" href="<?php echo esc_url( $edit_url ); ?>">
			<span class="doro-account-dash__card-icon" aria-hidden="true">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
			</span>
			<span class="doro-account-dash__card-label"><?php esc_html_e( 'Datos de cuenta', 'doroshopping' ); ?></span>
			<span class="doro-account-dash__card-desc"><?php esc_html_e( 'Perfil y contraseña', 'doroshopping' ); ?></span>
		</a>

		<?php if ( $wishlist_url ) : ?>
			<a class="doro-account-dash__card" href="<?php echo esc_url( $wishlist_url ); ?>">
				<span class="doro-account-dash__card-icon" aria-hidden="true">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/></svg>
				</span>
				<span class="doro-account-dash__card-label"><?php esc_html_e( 'Lista de deseos', 'doroshopping' ); ?></span>
				<span class="doro-account-dash__card-desc"><?php esc_html_e( 'Tus productos guardados', 'doroshopping' ); ?></span>
			</a>
		<?php endif; ?>

		<a class="doro-account-dash__card doro-account-dash__card--shop" href="<?php echo esc_url( $shop_url ); ?>">
			<span class="doro-account-dash__card-icon" aria-hidden="true">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
			</span>
			<span class="doro-account-dash__card-label"><?php esc_html_e( 'Seguir comprando', 'doroshopping' ); ?></span>
			<span class="doro-account-dash__card-desc"><?php esc_html_e( 'Volver a la tienda', 'doroshopping' ); ?></span>
		</a>
	</div>
</section>
