<?php
/**
 * Carrito vacío: mismo shell que la cesta llena (main + resumen + sugeridos).
 * WooCommerce carga este archivo cuando WC()->cart->is_empty().
 *
 * @package Doroshopping
 */

defined( 'ABSPATH' ) || exit;

$count = 0;
?>

<div class="doro-cesta">
	<div class="doro-cesta__grid">
		<section class="doro-cesta__main" aria-label="<?php esc_attr_e( 'Cesta', 'doroshopping' ); ?>">
			<header class="doro-cesta__head">
				<h1 class="doro-cesta__title"><?php esc_html_e( 'Cesta', 'doroshopping' ); ?></h1>
			</header>

			<?php get_template_part( 'template-parts/cart/empty', 'state' ); ?>
		</section>

		<aside class="doro-cesta__aside" aria-label="<?php esc_attr_e( 'Resumen', 'doroshopping' ); ?>">
			<?php get_template_part( 'template-parts/cart/summary', null, array( 'count' => $count, 'is_empty' => true ) ); ?>
			<?php get_template_part( 'template-parts/cart/trust' ); ?>
		</aside>
	</div>

	<?php get_template_part( 'template-parts/cart/recommendations' ); ?>
</div>
