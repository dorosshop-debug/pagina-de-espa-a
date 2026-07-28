<?php
/**
 * My Addresses — diseño DoroTheme.
 *
 * @package Doroshopping
 */

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();
$get_addresses = apply_filters(
	'woocommerce_my_account_get_addresses',
	array(
		'billing'  => __( 'Dirección de facturación', 'doroshopping' ),
		'shipping' => __( 'Dirección de envío', 'doroshopping' ),
	),
	$customer_id
);
?>

<section class="doro-account-addresses">
	<header class="doro-account-section__header">
		<p class="doro-account-section__eyebrow"><?php esc_html_e( 'Mi cuenta', 'doroshopping' ); ?></p>
		<h2 class="doro-account-section__title"><?php esc_html_e( 'Direcciones', 'doroshopping' ); ?></h2>
		<p class="doro-account-section__text">
			<?php esc_html_e( 'Las siguientes direcciones se usarán por defecto en el pago y en el envío.', 'doroshopping' ); ?>
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
						<?php echo $address ? esc_html__( 'Editar', 'doroshopping' ) : esc_html__( 'Añadir', 'doroshopping' ); ?>
					</a>
				</header>
				<div class="doro-account-addresses__card-body">
					<?php if ( $address ) : ?>
						<address><?php echo wp_kses_post( $address ); ?></address>
					<?php else : ?>
						<p class="doro-account-addresses__empty">
							<?php esc_html_e( 'Aún no has configurado este tipo de dirección.', 'doroshopping' ); ?>
						</p>
					<?php endif; ?>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
</section>
