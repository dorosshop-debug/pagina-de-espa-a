<?php
/**
 * Recomendaciones bajo el carrito ("Seguro que te gusta").
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$ui = static function ( $key ) {
    return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : '';
};

if ( ! function_exists( 'wc_get_products' ) ) {
    return;
}

$products = wc_get_products(
    array(
        'status'  => 'publish',
        'limit'   => 6,
        'orderby' => 'rand',
        'return'  => 'objects',
    )
);

if ( empty( $products ) ) {
    return;
}
?>

<section class="doro-cesta-recs" aria-label="<?php echo esc_attr( $ui( 'doroshopping_ui_cart_recs_aria' ) ); ?>">
    <h2 class="doro-cesta-recs__title"><?php echo esc_html( $ui( 'doroshopping_ui_cart_recs' ) ); ?></h2>
    <ul class="products columns-6 doro-cesta-recs__grid">
        <?php
        foreach ( $products as $product ) {
            $post_object = get_post( $product->get_id() );
            setup_postdata( $GLOBALS['post'] = $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
            wc_get_template_part( 'content', 'product' );
        }
        wp_reset_postdata();
        ?>
    </ul>
</section>
