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
?>

<main id="main-content" class="doro-shop">
    <div class="doro-shop__container">
        <?php
        /**
         * @hooked woocommerce_breadcrumb - 10
         */
        do_action( 'doroshopping_shop_before_content' );
        ?>

        <header class="doro-shop__header">
            <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
                <h1 class="doro-shop__title woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
            <?php endif; ?>

            <?php do_action( 'woocommerce_archive_description' ); ?>
        </header>

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
