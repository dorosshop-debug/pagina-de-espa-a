<?php
/**
 * Content single product - layout estilo AliExpress
 *
 * @package Doroshopping
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Mover add to cart al buy box.
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

$is_variable = $product && $product->is_type( 'variable' );
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'doro-product__inner' . ( $is_variable ? ' doro-product__inner--variable' : '' ), $product ); ?>>

    <?php
    do_action( 'woocommerce_before_single_product' );

    if ( post_password_required() ) {
        echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        return;
    }
    ?>

    <nav class="doro-product__anchors" aria-label="<?php esc_attr_e( 'Secciones del producto', 'doroshopping' ); ?>">
        <a href="#doro-reviews"><?php esc_html_e( 'Valoraciones', 'doroshopping' ); ?></a>
        <a href="#doro-details"><?php esc_html_e( 'Detalles', 'doroshopping' ); ?></a>
        <a href="#doro-description"><?php esc_html_e( 'Descripción', 'doroshopping' ); ?></a>
        <a href="#doro-related"><?php esc_html_e( 'Artículos similares', 'doroshopping' ); ?></a>
    </nav>

    <div class="doro-product__top<?php echo $is_variable ? ' doro-product__top--variable' : ''; ?>">
        <div class="doro-product__gallery">
            <?php
            /**
             * @hooked woocommerce_show_product_sale_flash - 10
             * @hooked woocommerce_show_product_images - 20
             */
            do_action( 'woocommerce_before_single_product_summary' );
            ?>
        </div>

        <div class="doro-product__summary summary entry-summary">
            <?php
            /**
             * @hooked woocommerce_template_single_title - 5
             * @hooked doroshopping_single_rating - 8
             * @hooked doroshopping_single_meta_line - 9
             * @hooked woocommerce_template_single_price - 10
             * @hooked woocommerce_template_single_excerpt - 20
             */
            do_action( 'woocommerce_single_product_summary' );
            ?>
        </div>

        <aside class="doro-product__buybox" aria-label="<?php esc_attr_e( 'Compra', 'doroshopping' ); ?>">
            <?php get_template_part( 'template-parts/product/buybox' ); ?>
        </aside>
    </div>

    <div class="doro-product__below" id="doro-details">
        <?php
        /**
         * @hooked woocommerce_output_product_data_tabs - 10
         * @hooked woocommerce_upsell_display - 15
         * @hooked woocommerce_output_related_products - 20
         */
        do_action( 'woocommerce_after_single_product_summary' );
        ?>
    </div>

    <?php do_action( 'woocommerce_after_single_product' ); ?>
</div>
