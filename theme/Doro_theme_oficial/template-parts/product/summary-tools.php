<?php
/**
 * Acciones y datos bajo el precio (columna central).
 *
 * @package Doroshopping
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product ) {
	return;
}

$ui = static function ( $key ) {
	return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : '';
};

$product_id = (int) $product->get_id();
$attrs      = $product->get_attributes();
?>

<div class="doro-product__summary-tools">
	<div class="doro-product__secondary">
		<button
			type="button"
			class="doro-product__wish"
			data-wishlist-toggle
			data-product-id="<?php echo esc_attr( (string) $product_id ); ?>"
			aria-pressed="false"
			aria-label="<?php echo esc_attr( $ui( 'doroshopping_ui_product_wishlist_aria' ) ); ?>"
		>
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/></svg>
			<?php echo esc_html( $ui( 'doroshopping_ui_product_wishlist' ) ); ?>
		</button>
		<button
			type="button"
			class="doro-product__share"
			data-share-product
			data-share-url="<?php echo esc_url( get_permalink( $product_id ) ); ?>"
			data-share-title="<?php echo esc_attr( $product->get_name() ); ?>"
			aria-label="<?php echo esc_attr( $ui( 'doroshopping_ui_product_share' ) ); ?>"
		>
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><path d="M8.6 13.5l6.8 4M15.4 6.5l-6.8 4"/></svg>
			<?php echo esc_html( $ui( 'doroshopping_ui_product_share' ) ); ?>
		</button>
	</div>

	<div class="doro-product__meta">
		<?php woocommerce_template_single_meta(); ?>
	</div>

	<?php if ( ! empty( $attrs ) ) : ?>
		<div class="doro-product__specs" id="doro-additional-info">
			<h3 class="doro-product__specs-title"><?php echo esc_html( $ui( 'doroshopping_ui_product_specs' ) ); ?></h3>
			<table class="doro-product__specs-table shop_attributes">
				<tbody>
					<?php foreach ( $attrs as $attribute ) : ?>
						<?php
						if ( ! $attribute || ( is_object( $attribute ) && ! $attribute->get_visible() ) ) {
							continue;
						}
						$label = wc_attribute_label( $attribute->get_name() );
						if ( $attribute->is_taxonomy() ) {
							$values = wc_get_product_terms( $product_id, $attribute->get_name(), array( 'fields' => 'names' ) );
							$value  = ! empty( $values ) ? implode( ', ', $values ) : '';
						} else {
							$value = $attribute->get_options() ? implode( ', ', $attribute->get_options() ) : '';
						}
						if ( '' === $value ) {
							continue;
						}
						?>
						<tr>
							<th><?php echo esc_html( $label ); ?></th>
							<td><?php echo esc_html( $value ); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	<?php endif; ?>
</div>
