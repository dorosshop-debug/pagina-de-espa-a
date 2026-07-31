<?php
/**
 * My Account navigation — diseño DoroTheme.
 *
 * @package Doroshopping
 */

defined( 'ABSPATH' ) || exit;

$ui = static function ( $key ) {
	return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : '';
};

$current_user = wp_get_current_user();
$icons        = array(
	'dashboard'       => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="3" width="8" height="8" rx="1"/><rect x="13" y="3" width="8" height="8" rx="1"/><rect x="3" y="13" width="8" height="8" rx="1"/><rect x="13" y="13" width="8" height="8" rx="1"/></svg>',
	'orders'          => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M6 2h12l1 7H5L6 2z"/><path d="M5 9v11a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V9"/></svg>',
	'downloads'       => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 3v12"/><path d="m7 10 5 5 5-5"/><path d="M5 21h14"/></svg>',
	'edit-address'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 1 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>',
	'payment-methods' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>',
	'edit-account'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
	'customer-logout' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/></svg>',
);

do_action( 'woocommerce_before_account_navigation' );
?>

<nav class="woocommerce-MyAccount-navigation doro-account__nav" aria-label="<?php esc_attr_e( 'Menú de cuenta', 'doroshopping' ); ?>">
	<div class="doro-account__nav-user">
		<span class="doro-account__nav-avatar" aria-hidden="true">
			<?php
			$display = $current_user->display_name ? $current_user->display_name : $current_user->user_login;
			$initial = function_exists( 'mb_substr' ) ? mb_substr( $display, 0, 1 ) : substr( $display, 0, 1 );
			echo esc_html( strtoupper( $initial ) );
			?>
		</span>
		<div class="doro-account__nav-user-text">
			<p class="doro-account__nav-user-label"><?php echo esc_html( $ui( 'doroshopping_ui_acc_nav_hello' ) ); ?></p>
			<p class="doro-account__nav-user-name"><?php echo esc_html( $current_user->display_name ? $current_user->display_name : $current_user->user_login ); ?></p>
		</div>
	</div>

	<ul>
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
			<?php
			$icon = isset( $icons[ $endpoint ] ) ? $icons[ $endpoint ] : $icons['dashboard'];
			?>
			<li class="<?php echo esc_attr( wc_get_account_menu_item_classes( $endpoint ) ); ?>">
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>">
					<span class="doro-account__nav-icon"><?php echo $icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<span class="doro-account__nav-label"><?php echo esc_html( $label ); ?></span>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>

<?php
do_action( 'woocommerce_after_account_navigation' );
