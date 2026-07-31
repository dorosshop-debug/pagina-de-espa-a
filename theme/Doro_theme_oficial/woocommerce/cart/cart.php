<?php
/**
 * Plantilla del carrito WooCommerce (lleno o vacío).
 *
 * @package Doroshopping
 */

defined( 'ABSPATH' ) || exit;

$ui = static function ( $key ) {
	return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : '';
};

do_action( 'woocommerce_before_cart' );

$shop_url    = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
$account_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : wp_login_url();
$is_empty    = WC()->cart->is_empty();
$count       = WC()->cart->get_cart_contents_count();

$count_label = '';
if ( ! $is_empty && function_exists( 'doroshopping_ui_sprintf' ) ) {
	$count_key   = ( 1 === $count ) ? 'doroshopping_ui_cart_count_one' : 'doroshopping_ui_cart_count_many';
	$count_label = doroshopping_ui_sprintf( $count_key, $count );
}
?>

<div class="doro-cesta">
	<div class="doro-cesta__grid">
		<section class="doro-cesta__main" aria-label="<?php echo esc_attr( $ui( 'doroshopping_ui_cart_title' ) ); ?>">
			<header class="doro-cesta__head">
				<h1 class="doro-cesta__title"><?php echo esc_html( $ui( 'doroshopping_ui_cart_title' ) ); ?></h1>
				<?php if ( ! $is_empty && '' !== $count_label ) : ?>
					<p class="doro-cesta__count"><?php echo esc_html( $count_label ); ?></p>
				<?php endif; ?>
			</header>

			<?php if ( $is_empty ) : ?>
				<?php get_template_part( 'template-parts/cart/empty', 'state' ); ?>
			<?php else : ?>
				<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
					<?php do_action( 'woocommerce_before_cart_table' ); ?>

					<div class="doro-cesta-items shop_table shop_table_responsive cart woocommerce-cart-form__contents" role="table" aria-label="<?php echo esc_attr( $ui( 'doroshopping_ui_cart_products_aria' ) ); ?>">
						<?php do_action( 'woocommerce_before_cart_contents' ); ?>

						<?php
						foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
							$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
							$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

							if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
								$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
								$remove_aria       = function_exists( 'doroshopping_ui_sprintf' )
									? doroshopping_ui_sprintf( 'doroshopping_ui_cart_remove', wp_strip_all_tags( $_product->get_name() ) )
									: '';
								?>
								<article class="doro-cesta-item woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>" role="row">
									<div class="doro-cesta-item__media product-thumbnail" role="cell">
										<?php
										$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'woocommerce_thumbnail' ), $cart_item, $cart_item_key );
										if ( ! $product_permalink ) {
											echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										} else {
											printf( '<a class="doro-cesta-item__thumb" href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										}
										?>
									</div>

									<div class="doro-cesta-item__body" role="cell">
										<div class="doro-cesta-item__top">
											<div class="doro-cesta-item__info product-name" data-title="<?php echo esc_attr( $ui( 'doroshopping_ui_cart_product' ) ); ?>">
												<?php
												if ( ! $product_permalink ) {
													echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', '<span class="doro-cesta-item__name">' . $_product->get_name() . '</span>', $cart_item, $cart_item_key ) );
												} else {
													echo wp_kses_post(
														apply_filters(
															'woocommerce_cart_item_name',
															sprintf( '<a class="doro-cesta-item__name" href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ),
															$cart_item,
															$cart_item_key
														)
													);
												}
												do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );
												echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
												?>
											</div>

											<div class="doro-cesta-item__remove product-remove">
												<?php
												echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
													'woocommerce_cart_item_remove_link',
													sprintf(
														'<a href="%s" class="remove doro-cesta-item__remove-btn" aria-label="%s" data-product_id="%s" data-product_sku="%s"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M18 6L6 18M6 6l12 12"/></svg></a>',
														esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
														esc_attr( $remove_aria ),
														esc_attr( $product_id ),
														esc_attr( $_product->get_sku() )
													),
													$cart_item_key
												);
												?>
											</div>
										</div>

										<div class="doro-cesta-item__meta">
											<div class="doro-cesta-item__price product-price" data-title="<?php echo esc_attr( $ui( 'doroshopping_ui_cart_price' ) ); ?>">
												<span class="doro-cesta-item__label"><?php echo esc_html( $ui( 'doroshopping_ui_cart_price' ) ); ?></span>
												<?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
											</div>

											<div class="doro-cesta-item__qty product-quantity" data-title="<?php echo esc_attr( $ui( 'doroshopping_ui_cart_qty' ) ); ?>">
												<span class="doro-cesta-item__label"><?php echo esc_html( $ui( 'doroshopping_ui_cart_qty' ) ); ?></span>
												<?php
												if ( $_product->is_sold_individually() ) {
													$min_quantity = 1;
													$max_quantity = 1;
												} else {
													$min_quantity = 0;
													$max_quantity = $_product->get_max_purchase_quantity();
												}
												$product_quantity = woocommerce_quantity_input(
													array(
														'input_name'   => "cart[{$cart_item_key}][qty]",
														'input_value'  => $cart_item['quantity'],
														'max_value'    => $max_quantity,
														'min_value'    => $min_quantity,
														'product_name' => $_product->get_name(),
													),
													$_product,
													false
												);
												echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
												?>
											</div>

											<div class="doro-cesta-item__subtotal product-subtotal" data-title="<?php echo esc_attr( $ui( 'doroshopping_ui_cart_subtotal' ) ); ?>">
												<span class="doro-cesta-item__label"><?php echo esc_html( $ui( 'doroshopping_ui_cart_subtotal' ) ); ?></span>
												<strong><?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
											</div>
										</div>
									</div>
								</article>
								<?php
							}
						}
						?>

						<?php do_action( 'woocommerce_cart_contents' ); ?>

						<div class="doro-cesta-actions actions">
							<?php if ( wc_coupons_enabled() ) : ?>
								<div class="doro-cesta-coupon coupon">
									<span class="doro-cesta-coupon__icon" aria-hidden="true">
										<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
									</span>
									<label for="coupon_code" class="screen-reader-text"><?php echo esc_html( $ui( 'doroshopping_ui_cart_coupon' ) ); ?></label>
									<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php echo esc_attr( $ui( 'doroshopping_ui_cart_coupon_ph' ) ); ?>">
									<button type="submit" class="button doro-cesta-coupon__btn<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="apply_coupon" value="<?php echo esc_attr( $ui( 'doroshopping_ui_cart_apply_coupon' ) ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_cart_apply' ) ); ?></button>
									<?php do_action( 'woocommerce_cart_coupon' ); ?>
								</div>
							<?php endif; ?>

							<button type="submit" class="button doro-cesta-update<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="update_cart" value="<?php echo esc_attr( $ui( 'doroshopping_ui_cart_update' ) ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_cart_update' ) ); ?></button>

							<?php do_action( 'woocommerce_cart_actions' ); ?>
							<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
						</div>

						<?php do_action( 'woocommerce_after_cart_contents' ); ?>
					</div>

					<?php do_action( 'woocommerce_after_cart_table' ); ?>
				</form>
			<?php endif; ?>
		</section>

		<aside class="doro-cesta__aside" aria-label="<?php echo esc_attr( $ui( 'doroshopping_ui_cart_aside_summary' ) ); ?>">
			<?php get_template_part( 'template-parts/cart/summary', null, array( 'count' => $count, 'is_empty' => $is_empty ) ); ?>
			<?php get_template_part( 'template-parts/cart/trust' ); ?>
		</aside>
	</div>

	<?php get_template_part( 'template-parts/cart/recommendations' ); ?>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
