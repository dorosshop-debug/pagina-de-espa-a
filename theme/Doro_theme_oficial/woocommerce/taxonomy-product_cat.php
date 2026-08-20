<?php
/**
 * Plantilla de archivo de categoría de producto (product_cat).
 * Hero visual alineado con Ofertas + subcategorías + filtros + productos.
 *
 * @package Doroshopping
 */

defined( 'ABSPATH' ) || exit;

$ui = static function ( $key ) {
    return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : '';
};

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
$intro       = ! empty( $term->description )
    ? wp_strip_all_tags( $term->description )
    : $ui( 'doroshopping_ui_shop_cat_lead' );
if ( '' === $intro ) {
    $intro = $ui( 'doroshopping_ui_shop_offers_lead' );
}
?>

<main id="main-content" class="doro-category">
    <div class="doro-category__container">
        <nav class="doro-category__breadcrumb woocommerce-breadcrumb" aria-label="<?php esc_attr_e( 'Migas de pan', 'doroshopping' ); ?>">
            <?php
            if ( function_exists( 'woocommerce_breadcrumb' ) ) {
                woocommerce_breadcrumb(
                    array(
                        'delimiter'   => ' <span class="doro-category__breadcrumb-sep" aria-hidden="true">/</span> ',
                        'wrap_before' => '',
                        'wrap_after'  => '',
                        'before'      => '',
                        'after'       => '',
                        'home'        => _x( 'Inicio', 'breadcrumb', 'doroshopping' ),
                    )
                );
            }
            ?>
        </nav>

        <section class="doro-offers-hero doro-offers-hero--category" aria-label="<?php echo esc_attr( $term->name ); ?>">
            <div class="doro-offers-hero__badge"><?php echo esc_html( $ui( 'doroshopping_ui_shop_cat_badge' ) ); ?></div>
            <h1 class="doro-offers-hero__title"><?php echo esc_html( $term->name ); ?></h1>
            <?php if ( $intro ) : ?>
                <p class="doro-offers-hero__text"><?php echo esc_html( $intro ); ?></p>
            <?php endif; ?>
            <ul class="doro-offers-hero__tags" aria-hidden="true">
                <li><?php echo esc_html( $ui( 'doroshopping_ui_shop_ship_fast' ) ); ?></li>
                <li><?php echo esc_html( $ui( 'doroshopping_ui_shop_pay_secure' ) ); ?></li>
                <li><?php echo esc_html( $ui( 'doroshopping_ui_shop_returns_easy' ) ); ?></li>
            </ul>
        </section>

        <?php if ( ! empty( $children ) ) : ?>
            <section class="doro-category__subs" aria-label="<?php echo esc_attr( $ui( 'doroshopping_ui_shop_cat_subs' ) ); ?>">
                <div class="doro-category__subs-grid">
                    <?php foreach ( $children as $child ) : ?>
                        <?php
                        $thumb_id = function_exists( 'doroshopping_get_product_cat_thumbnail_id' )
                            ? doroshopping_get_product_cat_thumbnail_id( $child->term_id )
                            : (int) get_term_meta( $child->term_id, 'thumbnail_id', true );
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
                            <span class="doro-category__sub-count" aria-label="<?php echo esc_attr( sprintf( _n( '%d producto', '%d productos', (int) $child->count, 'doroshopping' ), (int) $child->count ) ); ?>">
                                <?php echo esc_html( (string) (int) $child->count ); ?>
                            </span>
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

        <div class="doro-category__layout">
            <aside class="doro-category__filters" data-doro-filters aria-label="<?php echo esc_attr( $ui( 'doroshopping_ui_shop_filters' ) ); ?>">
                <div class="doro-category__filters-card">
                    <h2 class="doro-category__filters-title"><?php echo esc_html( $ui( 'doroshopping_ui_shop_filters' ) ); ?></h2>
                    <?php
                    if ( ! is_active_sidebar( 'shop-filters' ) ) {
                        get_template_part( 'template-parts/shop/filters', 'fallback' );
                    } else {
                        dynamic_sidebar( 'shop-filters' );
                    }
                    ?>
                </div>
            </aside>

            <section class="doro-category__shop">
                <div class="doro-category__shop-header">
                    <h2 class="doro-category__shop-title"><?php echo esc_html( $ui( 'doroshopping_ui_shop_cat_more' ) ); ?></h2>
                    <span class="doro-category__chip"><?php echo esc_html( $ui( 'doroshopping_ui_shop_cat_for_you' ) ); ?></span>
                </div>

                <?php do_action( 'woocommerce_before_shop_loop' ); ?>

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
                    <p class="doro-category__empty"><?php echo esc_html( $ui( 'doroshopping_ui_shop_cat_empty' ) ); ?></p>
                <?php endif; ?>
            </section>
        </div>
    </div>
</main>

<?php
get_footer();
