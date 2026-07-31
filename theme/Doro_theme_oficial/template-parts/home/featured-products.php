<?php
/**
 * Featured products - categoría desde Customizer
 *
 * Muestra 30 productos y «Ver más» carga de 30 en 30 hasta el máximo
 * de Apariencia → Cantidad de productos destacados. Después → tienda.
 *
 * @package Doroshopping
 */

$ui = static function ( $key ) {
	return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : '';
};

$cat_id    = absint( get_theme_mod( 'doroshopping_home_featured_cat', 0 ) );
$max_limit = absint( get_theme_mod( 'doroshopping_home_featured_limit', 90 ) );
if ( $max_limit < 30 ) {
	$max_limit = 30;
}
$batch     = 30;
$initial   = min( $batch, $max_limit );
$title     = function_exists( 'doroshopping_get_theme_mod' )
	? doroshopping_get_theme_mod( 'doroshopping_home_featured_title', __( 'Descubre productos únicos.', 'doroshopping' ) )
	: get_theme_mod( 'doroshopping_home_featured_title', __( 'Descubre productos únicos.', 'doroshopping' ) );
$products  = function_exists( 'doroshopping_get_products_by_category' )
	? doroshopping_get_products_by_category( $cat_id, $initial, 'popularity', 1 )
	: array();

$shown     = is_array( $products ) ? count( $products ) : 0;
$shop_url  = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
$more_url  = $shop_url;
if ( $cat_id > 0 ) {
	$term_link = get_term_link( $cat_id, 'product_cat' );
	if ( ! is_wp_error( $term_link ) ) {
		$more_url = $term_link;
	}
}

// ¿Hay más dentro del tope del Customizer?
$can_load_more = $shown >= $batch && $shown < $max_limit;
$go_to_shop    = $shown > 0 && ! $can_load_more;
?>

<section
	class="home-products"
	aria-labelledby="home-products-title"
	data-home-products
	data-cat-id="<?php echo esc_attr( (string) $cat_id ); ?>"
	data-batch="<?php echo esc_attr( (string) $batch ); ?>"
	data-max="<?php echo esc_attr( (string) $max_limit ); ?>"
	data-shown="<?php echo esc_attr( (string) $shown ); ?>"
	data-page="1"
	data-shop-url="<?php echo esc_url( $more_url ); ?>"
>
	<div class="home-products__header">
		<span class="home-products__line" aria-hidden="true"></span>
		<h2 class="home-products__title" id="home-products-title"><?php echo esc_html( $title ); ?></h2>
		<span class="home-products__line" aria-hidden="true"></span>
	</div>

	<div class="home-products__grid" data-home-products-grid>
		<?php if ( ! empty( $products ) ) : ?>
			<?php foreach ( $products as $product ) : ?>
				<?php echo function_exists( 'doroshopping_render_home_product_card' ) ? doroshopping_render_home_product_card( $product ) : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>

	<?php if ( ! empty( $products ) ) : ?>
		<div class="doro-load-more" data-home-load-more>
			<?php if ( $can_load_more ) : ?>
				<button
					type="button"
					class="doro-load-more__btn"
					data-home-load-more-btn
				>
					<?php echo esc_html( $ui( 'doroshopping_ui_home_ver_mas' ) ); ?>
				</button>
			<?php else : ?>
				<a class="doro-load-more__btn" href="<?php echo esc_url( $more_url ); ?>">
					<?php echo esc_html( $ui( 'doroshopping_ui_home_ver_mas_shop' ) ); ?>
				</a>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</section>
