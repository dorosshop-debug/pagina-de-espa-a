<?php
/**
 * The Template for displaying product archives (shop)
 *
 * Compatible with WooCommerce and Elementor Theme Builder.
 *
 * @package Doroshopping
 */

defined( 'ABSPATH' ) || exit;

get_header();

if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'archive' ) ) {
    get_footer();
    return;
}

$is_offers = function_exists( 'doroshopping_is_offers_view' ) && doroshopping_is_offers_view();
?>

<main id="main-content" class="doro-shop<?php echo $is_offers ? ' doro-shop--offers' : ''; ?>">
    <div class="doro-shop__container">
        <?php
        /**
         * @hooked woocommerce_breadcrumb - 10
         */
        do_action( 'doroshopping_shop_before_content' );
        ?>

        <?php if ( $is_offers ) : ?>
            <section class="doro-offers-hero" aria-label="<?php esc_attr_e( 'Ofertas', 'doroshopping' ); ?>">
                <div class="doro-offers-hero__badge"><?php esc_html_e( 'Super Ofertas', 'doroshopping' ); ?></div>
                <h1 class="doro-offers-hero__title"><?php esc_html_e( 'Ofertas', 'doroshopping' ); ?></h1>
                <p class="doro-offers-hero__text">
                    <?php esc_html_e( 'Descuentos flash, precios bajos y novedades. Filtra a la izquierda y encuentra tu próxima compra.', 'doroshopping' ); ?>
                </p>
                <ul class="doro-offers-hero__tags" aria-hidden="true">
                    <li><?php esc_html_e( 'Envío rápido', 'doroshopping' ); ?></li>
                    <li><?php esc_html_e( 'Pago seguro', 'doroshopping' ); ?></li>
                    <li><?php esc_html_e( 'Devoluciones fáciles', 'doroshopping' ); ?></li>
                </ul>
            </section>
        <?php else : ?>
            <header class="doro-shop__header">
                <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
                    <h1 class="doro-shop__title woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
                <?php endif; ?>
                <?php do_action( 'woocommerce_archive_description' ); ?>
            </header>
        <?php endif; ?>

        <div class="doro-shop__layout">
            <aside class="doro-shop__sidebar" aria-label="<?php esc_attr_e( 'Filtros', 'doroshopping' ); ?>">
                <?php doroshopping_shop_sidebar(); ?>
            </aside>

            <div class="doro-shop__main">
                <?php if ( woocommerce_product_loop() ) : ?>

                    <?php
                    /**
                     * @hooked doroshopping_shop_toolbar - 20
                     */
                    do_action( 'woocommerce_before_shop_loop' );
                    ?>

                    <?php woocommerce_product_loop_start(); ?>

                    <?php if ( wc_get_loop_prop( 'total' ) ) : ?>
                        <?php while ( have_posts() ) : ?>
                            <?php the_post(); ?>
                            <?php wc_get_template_part( 'content', 'product' ); ?>
                        <?php endwhile; ?>
                    <?php endif; ?>

                    <?php woocommerce_product_loop_end(); ?>

                    <?php do_action( 'woocommerce_after_shop_loop' ); ?>

                <?php else : ?>
                    <?php do_action( 'woocommerce_no_products_found' ); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
