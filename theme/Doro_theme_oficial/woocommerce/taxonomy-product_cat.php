<?php
/**
 * Plantilla de archivo de categoría de producto (product_cat).
 * Layout tipo AliExpress: título + subcategorías circulares + productos.
 *
 * @package Doroshopping
 */

defined( 'ABSPATH' ) || exit;

get_header();

if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'archive' ) ) {
    get_footer();
    return;
}

$term = get_queried_object();
if ( ! $term || is_wp_error( $term ) ) {
    get_footer();
    return;
}

$children = get_terms(
    array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
        'parent'     => (int) $term->term_id,
    )
);

if ( is_wp_error( $children ) ) {
    $children = array();
}

$placeholder = function_exists( 'wc_placeholder_img_src' ) ? wc_placeholder_img_src( 'woocommerce_thumbnail' ) : '';
?>

<main id="main-content" class="doro-category">
    <div class="doro-category__title-bar">
        <div class="doro-category__title-inner">
            <h1 class="doro-category__title"><?php echo esc_html( $term->name ); ?></h1>
        </div>
    </div>

    <div class="doro-category__container">
        <?php if ( ! empty( $children ) ) : ?>
            <section class="doro-category__subs" aria-label="<?php esc_attr_e( 'Subcategorías', 'doroshopping' ); ?>">
                <div class="doro-category__subs-grid">
                    <?php foreach ( $children as $child ) : ?>
                        <?php
                        $thumb_id = (int) get_term_meta( $child->term_id, 'thumbnail_id', true );
                        $img_url  = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'woocommerce_thumbnail' ) : '';
                        if ( ! $img_url ) {
                            $img_url = $placeholder;
                        }
                        $link = get_term_link( $child );
                        if ( is_wp_error( $link ) ) {
                            continue;
                        }
                        ?>
                        <a class="doro-category__sub" href="<?php echo esc_url( $link ); ?>">
                            <span class="doro-category__sub-circle">
                                <?php if ( $img_url ) : ?>
                                    <img src="<?php echo esc_url( $img_url ); ?>" alt="" loading="lazy" decoding="async" width="88" height="88">
                                <?php endif; ?>
                            </span>
                            <span class="doro-category__sub-label"><?php echo esc_html( $child->name ); ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <section class="doro-category__shop">
            <div class="doro-category__shop-header">
                <h2 class="doro-category__shop-title"><?php esc_html_e( 'Más formas de comprar', 'doroshopping' ); ?></h2>
                <span class="doro-category__chip"><?php esc_html_e( 'Para ti', 'doroshopping' ); ?></span>
            </div>

            <?php
            remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
            remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
            ?>

            <?php if ( woocommerce_product_loop() ) : ?>
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
                <p class="doro-category__empty"><?php esc_html_e( 'No hay productos en esta categoría todavía.', 'doroshopping' ); ?></p>
            <?php endif; ?>
        </section>
    </div>
</main>

<?php
get_footer();
