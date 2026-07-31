<?php
/**
 * Carrito vacío: mismo shell que la cesta llena (main + resumen + sugeridos).
 * WooCommerce carga este archivo cuando WC()->cart->is_empty().
 *
 * @package Doroshopping
 */

defined( 'ABSPATH' ) || exit;

$ui = static function ( $key ) {
	return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : '';
};

$count = 0;
?>

<div class="doro-cesta">
	<div class="doro-cesta__grid">
		<section class="doro-cesta__main" aria-label="<?php echo esc_attr( $ui( 'doroshopping_ui_cart_title' ) ); ?>">
			<header class="doro-cesta__head">
				<h1 class="doro-cesta__title"><?php echo esc_html( $ui( 'doroshopping_ui_cart_title' ) ); ?></h1>
			</header>

			<?php get_template_part( 'template-parts/cart/empty', 'state' ); ?>
		</section>

		<aside class="doro-cesta__aside" aria-label="<?php echo esc_attr( $ui( 'doroshopping_ui_cart_aside_summary' ) ); ?>">
			<?php get_template_part( 'template-parts/cart/summary', null, array( 'count' => $count, 'is_empty' => true ) ); ?>
			<?php get_template_part( 'template-parts/cart/trust' ); ?>
		</aside>
	</div>

	<?php get_template_part( 'template-parts/cart/recommendations' ); ?>
</div>
