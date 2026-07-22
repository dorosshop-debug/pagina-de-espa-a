<?php
/**
 * Featured products - categoría desde Customizer
 *
 * @package Doroshopping
 */

$cat_id   = absint( get_theme_mod( 'doroshopping_home_featured_cat', 0 ) );
$limit    = absint( get_theme_mod( 'doroshopping_home_featured_limit', 24 ) );
$title    = get_theme_mod( 'doroshopping_home_featured_title', __( 'Descubre productos únicos.', 'doroshopping' ) );
$products = function_exists( 'doroshopping_get_products_by_category' )
    ? doroshopping_get_products_by_category( $cat_id, $limit ? $limit : 24 )
    : array();
?>

<section class="home-products" aria-labelledby="home-products-title">
    <div class="home-products__header">
        <span class="home-products__line" aria-hidden="true"></span>
        <h2 class="home-products__title" id="home-products-title"><?php echo esc_html( $title ); ?></h2>
        <span class="home-products__line" aria-hidden="true"></span>
    </div>

    <div class="home-products__grid">
        <?php if ( ! empty( $products ) ) : ?>
            <?php foreach ( $products as $product ) : ?>
                <?php
                $rating      = (float) $product->get_average_rating();
                $count       = (int) $product->get_review_count();
                $product_id  = $product->get_id();
                $purchasable = $product->is_purchasable() && $product->is_in_stock() && $product->is_type( 'simple' );
                $image_html  = $product->get_image(
                    'woocommerce_thumbnail',
                    array(
                        'loading'  => 'lazy',
                        'decoding' => 'async',
                        'alt'      => $product->get_name(),
                    )
                );
                ?>
                <article class="home-product-card" data-product-id="<?php echo esc_attr( (string) $product_id ); ?>">
                    <div class="home-product-card__image-wrap">
                        <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="home-product-card__image-link">
                            <?php echo $image_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        </a>
                        <?php if ( $purchasable ) : ?>
                            <a
                                href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"
                                class="home-product-card__cart-btn ajax_add_to_cart add_to_cart_button"
                                data-product_id="<?php echo esc_attr( (string) $product_id ); ?>"
                                data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"
                                data-quantity="1"
                                aria-label="<?php echo esc_attr( sprintf( __( 'Añadir %s al carrito', 'doroshopping' ), $product->get_name() ) ); ?>"
                                rel="nofollow"
                            >
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            </a>
                        <?php else : ?>
                            <a
                                href="<?php echo esc_url( $product->get_permalink() ); ?>"
                                class="home-product-card__cart-btn"
                                aria-label="<?php echo esc_attr( sprintf( __( 'Ver %s', 'doroshopping' ), $product->get_name() ) ); ?>"
                            >
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            </a>
                        <?php endif; ?>
                        <button
                            type="button"
                            class="home-product-card__wish-btn"
                            data-wishlist-toggle
                            data-product-id="<?php echo esc_attr( (string) $product_id ); ?>"
                            aria-pressed="false"
                            aria-label="<?php esc_attr_e( 'Anadir a lista de deseos', 'doroshopping' ); ?>"
                        >
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/></svg>
                        </button>
                    </div>
                    <div class="home-product-card__info">
                        <?php echo doroshopping_get_sale_savings_html( $product ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        <p class="home-product-card__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></p>
                        <?php echo doroshopping_get_star_rating_html( $rating, $count ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        <h3 class="home-product-card__name">
                            <a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
                        </h3>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>
