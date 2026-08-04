<?php
/**
 * Template Name: Lista de deseos
 * Template post type: page
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

$wishlist_ids = function_exists( 'doroshopping_get_wishlist_ids' ) ? doroshopping_get_wishlist_ids() : array();
$products     = array();

if ( class_exists( 'WooCommerce' ) && ! empty( $wishlist_ids ) ) {
    foreach ( $wishlist_ids as $product_id ) {
        $product = wc_get_product( absint( $product_id ) );
        if ( $product && $product->is_visible() ) {
            $products[] = $product;
        }
    }
}
?>

<main id="main-content" class="doro-wishlist">
    <div class="doro-wishlist__container">
        <header class="doro-wishlist__header">
            <h1 class="doro-wishlist__title"><?php esc_html_e( 'Lista de deseos', 'doroshopping' ); ?></h1>
            <p class="doro-wishlist__subtitle"><?php esc_html_e( 'Guarda tus productos favoritos y vuelve a ellos cuando quieras.', 'doroshopping' ); ?></p>
        </header>

        <?php if ( ! is_user_logged_in() ) : ?>
            <div class="doro-wishlist__notice">
                <p><?php esc_html_e( 'Inicia sesión para sincronizar tu lista de deseos en todos tus dispositivos.', 'doroshopping' ); ?></p>
                <?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
                    <a class="doro-wishlist__cta" href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>">
                        <?php esc_html_e( 'Acceder / Registrarse', 'doroshopping' ); ?>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ( empty( $products ) ) : ?>
            <div class="doro-wishlist__empty" data-wishlist-empty>
                <svg class="doro-wishlist__empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/></svg>
                <h2><?php esc_html_e( 'Tu lista está vacía', 'doroshopping' ); ?></h2>
                <p><?php esc_html_e( 'Explora la tienda y añade productos con el icono de corazón.', 'doroshopping' ); ?></p>
                <a class="doro-wishlist__cta" href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ) ); ?>">
                    <?php esc_html_e( 'Ir a la tienda', 'doroshopping' ); ?>
                </a>
            </div>
        <?php else : ?>
            <ul class="products columns-4 doro-wishlist__grid" data-wishlist-grid>
                <?php
                foreach ( $products as $product ) {
                    $post_object = get_post( $product->get_id() );
                    if ( ! $post_object ) {
                        continue;
                    }
                    setup_postdata( $GLOBALS['post'] = $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
                    wc_get_template_part( 'content', 'product' );
                }
                wp_reset_postdata();
                ?>
            </ul>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
