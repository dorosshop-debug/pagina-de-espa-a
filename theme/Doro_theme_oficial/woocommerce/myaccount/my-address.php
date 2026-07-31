<?php
/**
 * My Addresses — diseño DoroTheme.
 *
 * @package Doroshopping
 */

defined( 'ABSPATH' ) || exit;

$ui = static function ( $key ) {
	return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : '';
};

$customer_id = get_current_user_id();
$get_addresses = apply_filters(
	'woocommerce_my_account_get_addresses',
	array(
		'billing'  => $ui( 'doroshopping_ui_acc_addr_billing' ),
		'shipping' => $ui( 'doroshopping_ui_acc_addr_shipping' ),
	),
	$customer_id
);
?>

<section class="doro-account-addresses">
	<header class="doro-account-section__header">
		<p class="doro-account-section__eyebrow"><?php echo esc_html( $ui( 'doroshopping_ui_acc_eyebrow' ) ); ?></p>
		<h2 class="doro-account-section__title"><?php echo esc_html( $ui( 'doroshopping_ui_acc_addr_title' ) ); ?></h2>
		<p class="doro-account-section__text">
			<?php echo esc_html( $ui( 'doroshopping_ui_acc_addr_lead' ) ); ?>
		</p>
	</header>

	<div class="doro-account-addresses__grid">
		<?php foreach ( $get_addresses as $name => $title ) : ?>
			<?php
			$address = wc_get_account_formatted_address( $name );
			$edit_url = wc_get_endpoint_url( 'edit-address', $name );
			?>
			<article class="doro-account-addresses__card">
				<header class="doro-account-addresses__card-head">
					<h3 class="doro-account-addresses__card-title"><?php echo esc_html( $title ); ?></h3>
					<a class="doro-account-addresses__edit" href="<?php echo esc_url( $edit_url ); ?>">
						<?php echo $address ? esc_html( $ui( 'doroshopping_ui_acc_edit' ) ) : esc_html( $ui( 'doroshopping_ui_acc_add' ) ); ?>
					</a>
				</header>
				<div class="doro-account-addresses__card-body">
					<?php if ( $address ) : ?>
						<address><?php echo wp_kses_post( $address ); ?></address>
					<?php else : ?>
						<p class="doro-account-addresses__empty">
							<?php echo esc_html( $ui( 'doroshopping_ui_acc_addr_empty' ) ); ?>
						</p>
					<?php endif; ?>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
</section>
