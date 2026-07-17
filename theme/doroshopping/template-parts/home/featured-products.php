<?php
/**
 * Featured products section
 *
 * @package Doroshopping
 */

$products = array();

if ( function_exists( 'wc_get_products' ) ) {
    $products = wc_get_products( array(
        'limit'   => 24,
        'status'  => 'publish',
        'orderby' => 'popularity',
    ) );
}
?>

<section class="home-products">
    <div class="home-products__header">
        <span class="home-products__line"></span>
        <h2 class="home-products__title">Descubre productos unicos.</h2>
        <span class="home-products__line"></span>
    </div>

    <div class="home-products__grid">
        <?php if ( ! empty( $products ) ) : ?>
            <?php foreach ( $products as $product ) : ?>
                <article class="home-product-card">
                    <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="home-product-card__image-wrap">
                        <?php echo wp_kses_post( $product->get_image() ); ?>
                        <button type="button" class="home-product-card__cart-btn" aria-label="Anadir al carrito">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        </button>
                    </a>
                    <div class="home-product-card__info">
                        <p class="home-product-card__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></p>
                        <h3 class="home-product-card__name"><?php echo esc_html( $product->get_name() ); ?></h3>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>
