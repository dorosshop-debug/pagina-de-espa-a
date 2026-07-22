<?php
/**
 * WooCommerce helpers, hooks y compat Elementor
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Columnas del loop de tienda.
 *
 * @return int
 */
function doroshopping_loop_columns() {
    return 4;
}
add_filter( 'loop_shop_columns', 'doroshopping_loop_columns' );

/**
 * Productos por pagina.
 *
 * @param int $cols Default.
 * @return int
 */
function doroshopping_products_per_page( $cols ) {
    return 24;
}
add_filter( 'loop_shop_per_page', 'doroshopping_products_per_page', 20 );

/**
 * Wrapper de contenido WooCommerce (fallback cuando no hay template override).
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

function doroshopping_wc_wrapper_start() {
    echo '<main class="doro-shop"><div class="doro-shop__container">';
}
add_action( 'woocommerce_before_main_content', 'doroshopping_wc_wrapper_start', 10 );

function doroshopping_wc_wrapper_end() {
    echo '</div></main>';
}
add_action( 'woocommerce_after_main_content', 'doroshopping_wc_wrapper_end', 10 );

/**
 * Breadcrumb dentro del layout de tienda.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
add_action( 'doroshopping_shop_before_content', 'woocommerce_breadcrumb', 10 );

/**
 * Result count + ordering en barra superior.
 */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

/**
 * El loop usa content-product.php (card Home). Quitar markup WC por defecto.
 */
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

function doroshopping_shop_toolbar() {
    echo '<div class="doro-shop__toolbar">';
    woocommerce_result_count();
    woocommerce_catalog_ordering();
    echo '</div>';
}
add_action( 'woocommerce_before_shop_loop', 'doroshopping_shop_toolbar', 20 );

/**
 * Rating en ficha de producto con estrellas del tema.
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_single_product_summary', 'doroshopping_single_rating', 8 );

function doroshopping_single_rating() {
    global $product;
    if ( ! $product ) {
        return;
    }

    $rating = (float) $product->get_average_rating();
    $count  = (int) $product->get_review_count();
    $sold   = (int) $product->get_total_sales();

    echo '<div class="doro-product__rating-row">';
    echo doroshopping_get_star_rating_html( $rating, $count ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    if ( $count > 0 ) {
        echo '<a class="doro-product__rating-count" href="#tab-reviews">' . esc_html( sprintf( _n( '%d valoracion', '%d valoraciones', $count, 'doroshopping' ), $count ) ) . '</a>';
    }
    if ( $sold > 0 ) {
        /* translators: %s: number of sales */
        echo '<span class="doro-product__sold">' . esc_html( sprintf( __( '%s+ vendidos', 'doroshopping' ), number_format_i18n( $sold ) ) ) . '</span>';
    }
    echo '</div>';
}

/**
 * Abrir/cerrar contenedor de relacionados.
 */
function doroshopping_related_wrap_start() {
    echo '<div id="doro-related" class="doro-product__related-wrap">';
}
function doroshopping_related_wrap_end() {
    echo '</div>';
}
add_action( 'woocommerce_after_single_product_summary', 'doroshopping_related_wrap_start', 19 );
add_action( 'woocommerce_after_single_product_summary', 'doroshopping_related_wrap_end', 21 );

/**
 * Más productos relacionados.
 *
 * @param array $args Args.
 * @return array
 */
function doroshopping_related_products_args( $args ) {
    $args['posts_per_page'] = 10;
    $args['columns']        = 5;
    return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'doroshopping_related_products_args' );

/**
 * Upsells también en 5 columnas.
 *
 * @param int $columns Columns.
 * @return int
 */
function doroshopping_upsell_columns( $columns ) {
    return 5;
}
add_filter( 'woocommerce_upsells_columns', 'doroshopping_upsell_columns' );

/**
 * @param int $limit Limit.
 * @return int
 */
function doroshopping_upsell_limit( $limit ) {
    return 10;
}
add_filter( 'woocommerce_upsells_total', 'doroshopping_upsell_limit' );

/**
 * Sección extra de productos debajo de relacionados (upsells / recientes).
 */
function doroshopping_more_products_section() {
    if ( ! is_product() ) {
        return;
    }

    $ids = wc_get_products(
        array(
            'status'  => 'publish',
            'limit'   => 10,
            'orderby' => 'rand',
            'return'  => 'ids',
            'exclude' => array( get_the_ID() ),
        )
    );

    if ( empty( $ids ) ) {
        return;
    }
    ?>
    <section id="doro-more-products" class="doro-product__more-wrap">
        <h2 class="doro-product__more-title"><?php esc_html_e( 'Más productos para ti', 'doroshopping' ); ?></h2>
        <?php
        woocommerce_product_loop_start();
        foreach ( $ids as $product_id ) {
            $post_object = get_post( $product_id );
            if ( ! $post_object ) {
                continue;
            }
            setup_postdata( $GLOBALS['post'] = $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
            wc_get_template_part( 'content', 'product' );
        }
        woocommerce_product_loop_end();
        wp_reset_postdata();
        ?>
    </section>
    <?php
}
add_action( 'woocommerce_after_single_product_summary', 'doroshopping_more_products_section', 25 );

/**
 * Envolver panel de reviews.
 */
function doroshopping_review_tab_panel_class( $class ) {
    return $class;
}

/**
 * Sidebar de filtros de tienda.
 */
function doroshopping_shop_sidebar() {
    if ( ! is_active_sidebar( 'shop-filters' ) ) {
        get_template_part( 'template-parts/shop/filters', 'fallback' );
    } else {
        dynamic_sidebar( 'shop-filters' );
    }
    // Ads vertical solo en la página de tienda.
    if ( function_exists( 'is_shop' ) && is_shop() ) {
        get_template_part( 'template-parts/shop/promo', 'ad' );
    }
}

function doroshopping_register_shop_sidebar() {
    register_sidebar(
        array(
            'name'          => __( 'Filtros de tienda', 'doroshopping' ),
            'id'            => 'shop-filters',
            'description'   => __( 'Widgets de filtros para la página de tienda. Si está vacío se usa el fallback del tema.', 'doroshopping' ),
            'before_widget' => '<div id="%1$s" class="doro-shop__widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="doro-shop__widget-title">',
            'after_title'   => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'doroshopping_register_shop_sidebar' );

/**
 * Filtro por valoración mínima (?min_rating=3|4).
 *
 * @param WP_Query $q Query.
 */
function doroshopping_filter_by_min_rating( $q ) {
    if ( is_admin() || ! $q->is_main_query() ) {
        return;
    }
    if ( ! isset( $_GET['min_rating'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        return;
    }
    $min = absint( $_GET['min_rating'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    if ( $min < 1 || $min > 5 ) {
        return;
    }

    $meta_query   = (array) $q->get( 'meta_query' );
    $meta_query[] = array(
        'key'     => '_wc_average_rating',
        'value'   => $min,
        'compare' => '>=',
        'type'    => 'DECIMAL',
    );
    $q->set( 'meta_query', $meta_query );
}
add_action( 'woocommerce_product_query', 'doroshopping_filter_by_min_rating' );

/**
 * Lazy-load en miniaturas de producto WC.
 *
 * @param array $attr Attributes.
 * @return array
 */
function doroshopping_product_image_lazy_attrs( $attr ) {
    if ( empty( $attr['loading'] ) ) {
        $attr['loading'] = 'lazy';
    }
    if ( empty( $attr['decoding'] ) ) {
        $attr['decoding'] = 'async';
    }
    return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'doroshopping_product_image_lazy_attrs' );

/**
 * Aviso cuando producto variable sin stock / no comprable.
 */
function doroshopping_out_of_stock_notice() {
    global $product;
    if ( ! $product || $product->is_in_stock() ) {
        return;
    }
    echo '<p class="doro-product__oos" role="status">' . esc_html__( 'Este producto no está disponible actualmente.', 'doroshopping' ) . '</p>';
}
add_action( 'woocommerce_single_product_summary', 'doroshopping_out_of_stock_notice', 15 );
