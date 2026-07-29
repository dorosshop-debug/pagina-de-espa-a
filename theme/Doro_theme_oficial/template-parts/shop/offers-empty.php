<?php
/**
 * Ofertas vacías: banner + sugerencias + funnel.
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$products = function_exists( 'doroshopping_get_suggested_products' ) ? doroshopping_get_suggested_products( 16 ) : array();
$shop_url = function_exists( 'doroshopping_get_wc_page_url' ) ? doroshopping_get_wc_page_url( 'shop' ) : home_url( '/' );

$funnel = array();
if ( taxonomy_exists( 'product_cat' ) ) {
	$cat_slugs = array( 'electronica', 'informatica', 'hogar', 'deportes', 'gaming' );
	foreach ( $cat_slugs as $slug ) {
		$term = get_term_by( 'slug', $slug, 'product_cat' );
		if ( $term && ! is_wp_error( $term ) ) {
			$link = get_term_link( $term );
			if ( ! is_wp_error( $link ) ) {
				$funnel[] = array(
					'label' => $term->name,
					'url'   => $link,
				);
			}
		}
	}
}
?>

<section class="doro-shop-offers-empty" aria-labelledby="doro-offers-empty-title">
	<div class="doro-shop-offers-empty__banner">
		<span class="doro-shop-offers-empty__chip"><?php esc_html_e( 'Ofertas del momento', 'doroshopping' ); ?></span>
		<h2 id="doro-offers-empty-title" class="doro-shop-offers-empty__title">
			<?php esc_html_e( 'Ahora mismo no hay ofertas activas', 'doroshopping' ); ?>
		</h2>
		<p class="doro-shop-offers-empty__text">
			<?php esc_html_e( 'Estamos preparando nuevas promociones. Mientras tanto, mira estos productos populares o usa los filtros de la izquierda.', 'doroshopping' ); ?>
		</p>
	</div>

	<?php if ( ! empty( $products ) ) : ?>
		<div class="doro-shop-offers-empty__carousel-wrap" data-product-carousel>
			<div class="doro-shop-offers-empty__section-head">
				<h3 class="doro-shop-offers-empty__subtitle"><?php esc_html_e( 'Productos recomendados para ti', 'doroshopping' ); ?></h3>
				<span class="doro-shop-offers-empty__hot"><?php esc_html_e( 'Tendencia', 'doroshopping' ); ?></span>
			</div>
			<ul class="products columns-5">
				<?php
				foreach ( $products as $product ) {
					$GLOBALS['product'] = $product;
					wc_get_template_part( 'content', 'product' );
				}
				wp_reset_postdata();
				?>
			</ul>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $funnel ) ) : ?>
		<div class="doro-shop-offers-empty__funnel">
			<h3 class="doro-shop-offers-empty__subtitle"><?php esc_html_e( 'Explora por categoría', 'doroshopping' ); ?></h3>
			<div class="doro-shop-offers-empty__funnel-grid">
				<?php foreach ( $funnel as $item ) : ?>
					<a class="doro-shop-offers-empty__funnel-link" href="<?php echo esc_url( $item['url'] ); ?>">
						<?php echo esc_html( $item['label'] ); ?>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

	<div class="doro-shop-offers-empty__actions">
		<a class="doro-shop-offers-empty__cta" href="<?php echo esc_url( $shop_url ); ?>">
			<?php esc_html_e( 'Ver toda la tienda', 'doroshopping' ); ?>
		</a>
	</div>
</section>
