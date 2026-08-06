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
    return 6;
}
add_filter( 'loop_shop_columns', 'doroshopping_loop_columns' );

/**
 * Productos por pagina.
 *
 * @param int $cols Default.
 * @return int
 */
function doroshopping_products_per_page( $cols ) {
    return 30;
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
 * Sustituye la paginación numérica por botón «Ver más» (carga AJAX en tienda).
 */
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
add_action( 'woocommerce_after_shop_loop', 'doroshopping_shop_load_more_button', 10 );

/**
 * Botón Ver más al final del loop de tienda / categoría.
 *
 * @return void
 */
function doroshopping_shop_load_more_button() {
    $total   = (int) wc_get_loop_prop( 'total_pages' );
    $current = (int) wc_get_loop_prop( 'current_page' );
    if ( $total < 2 || $current >= $total ) {
        return;
    }

    $next_page = $current + 1;
    $next_url  = get_pagenum_link( $next_page, false );
    $view_more = function_exists( 'doroshopping_ui_text' )
        ? doroshopping_ui_text( 'doroshopping_ui_home_ver_mas' )
        : __( 'Ver más', 'doroshopping' );
    ?>
    <div class="doro-load-more" data-doro-load-more>
        <button
            type="button"
            class="doro-load-more__btn"
            data-doro-load-more-btn
            data-next-url="<?php echo esc_url( $next_url ); ?>"
            data-next-page="<?php echo esc_attr( (string) $next_page ); ?>"
            data-total-pages="<?php echo esc_attr( (string) $total ); ?>"
        >
            <?php echo esc_html( $view_more ); ?>
        </button>
    </div>
    <?php
}

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
        $reviews_key = ( 1 === $count ) ? 'doroshopping_ui_product_reviews_one' : 'doroshopping_ui_product_reviews_many';
        $reviews_txt = function_exists( 'doroshopping_ui_sprintf' )
            ? doroshopping_ui_sprintf( $reviews_key, $count )
            : sprintf( _n( '%d valoracion', '%d valoraciones', $count, 'doroshopping' ), $count );
        echo '<a class="doro-product__rating-count" href="#tab-reviews">' . esc_html( $reviews_txt ) . '</a>';
    }
    if ( $sold > 0 ) {
        $sold_txt = function_exists( 'doroshopping_ui_sprintf' )
            ? doroshopping_ui_sprintf( 'doroshopping_ui_product_sold', number_format_i18n( $sold ) )
            : sprintf( __( '%s+ vendidos', 'doroshopping' ), number_format_i18n( $sold ) );
        echo '<span class="doro-product__sold">' . esc_html( $sold_txt ) . '</span>';
    }
    echo '</div>';
}

/**
 * Wishlist, compartir, SKU/categorías e info adicional bajo el precio.
 */
function doroshopping_single_summary_tools() {
    if ( ! is_product() ) {
        return;
    }
    get_template_part( 'template-parts/product/summary', 'tools' );
}
add_action( 'woocommerce_single_product_summary', 'doroshopping_single_summary_tools', 15 );

/**
 * Quitar pestaña "Información adicional" (ya va en columna central).
 *
 * @param array $tabs Tabs.
 * @return array
 */
function doroshopping_remove_additional_info_tab( $tabs ) {
    unset( $tabs['additional_information'] );
    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'doroshopping_remove_additional_info_tab', 98 );

/**
 * Abrir/cerrar contenedor de relacionados.
 */
function doroshopping_related_wrap_start() {
    echo '<div id="doro-related" class="doro-product__related-wrap" data-related-carousel>';
}
function doroshopping_related_wrap_end() {
    echo '</div>';
}
add_action( 'woocommerce_after_single_product_summary', 'doroshopping_related_wrap_start', 19 );
add_action( 'woocommerce_after_single_product_summary', 'doroshopping_related_wrap_end', 21 );

/**
 * Más productos relacionados (carrusel).
 *
 * @param array $args Args.
 * @return array
 */
function doroshopping_related_products_args( $args ) {
    $args['posts_per_page'] = 16;
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
 * Sección extra de productos debajo de relacionados (con Ver más hasta 240).
 */
function doroshopping_more_products_section() {
    if ( ! is_product() ) {
        return;
    }

    $exclude_id = (int) get_the_ID();
    $batch      = 20;
    $max_limit  = 240;
    $shop_url   = function_exists( 'doroshopping_get_wc_page_url' )
        ? doroshopping_get_wc_page_url( 'shop' )
        : ( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ) );

    $ids = wc_get_products(
        function_exists( 'doroshopping_pll_product_query_args' )
            ? doroshopping_pll_product_query_args(
                array(
                    'status'  => 'publish',
                    'limit'   => $batch,
                    'page'    => 1,
                    'orderby' => 'date',
                    'order'   => 'DESC',
                    'return'  => 'ids',
                    'exclude' => array( $exclude_id ),
                )
            )
            : array(
                'status'  => 'publish',
                'limit'   => $batch,
                'page'    => 1,
                'orderby' => 'date',
                'order'   => 'DESC',
                'return'  => 'ids',
                'exclude' => array( $exclude_id ),
            )
    );

    if ( empty( $ids ) ) {
        return;
    }

    $shown         = count( $ids );
    $can_load_more = $shown >= $batch && $shown < $max_limit;
    $more_title    = function_exists( 'doroshopping_ui_text' )
        ? doroshopping_ui_text( 'doroshopping_ui_product_more_title' )
        : __( 'Más productos para ti', 'doroshopping' );
    $view_more     = function_exists( 'doroshopping_ui_text' )
        ? doroshopping_ui_text( 'doroshopping_ui_home_ver_mas' )
        : __( 'Ver más', 'doroshopping' );
    $view_shop     = function_exists( 'doroshopping_ui_text' )
        ? doroshopping_ui_text( 'doroshopping_ui_home_ver_mas_shop' )
        : __( 'Ver más en la tienda', 'doroshopping' );
    ?>
    <section
        id="doro-more-products"
        class="doro-product__more-wrap"
        data-product-more
        data-exclude="<?php echo esc_attr( (string) $exclude_id ); ?>"
        data-page="1"
        data-shown="<?php echo esc_attr( (string) $shown ); ?>"
        data-batch="30"
        data-max="<?php echo esc_attr( (string) $max_limit ); ?>"
        data-shop-url="<?php echo esc_url( $shop_url ); ?>"
    >
        <h2 class="doro-product__more-title"><?php echo esc_html( $more_title ); ?></h2>
        <ul class="products columns-5" data-product-more-grid>
            <?php
            foreach ( $ids as $product_id ) {
                $post_object = get_post( $product_id );
                if ( ! $post_object ) {
                    continue;
                }
                setup_postdata( $GLOBALS['post'] = $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
                wc_get_template_part( 'content', 'product' );
            }
            wp_reset_postdata();
            ?>
        </ul>
        <div class="doro-load-more" data-product-more-wrap>
            <?php if ( $can_load_more ) : ?>
                <button
                    type="button"
                    class="doro-load-more__btn"
                    data-product-more-btn
                >
                    <?php echo esc_html( $view_more ); ?>
                </button>
            <?php else : ?>
                <a class="doro-load-more__btn" href="<?php echo esc_url( $shop_url ); ?>">
                    <?php echo esc_html( $view_shop ); ?>
                </a>
            <?php endif; ?>
        </div>
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
 * Aplica filtros de atributos (?filter_color=slug) al loop de tienda.
 *
 * @param WC_Query $q Query.
 * @return void
 */
function doroshopping_apply_attribute_filters( $q ) {
    if ( is_admin() || ! $q->is_main_query() ) {
        return;
    }
    if ( ! function_exists( 'wc_get_attribute_taxonomies' ) ) {
        return;
    }

    $tax_query = (array) $q->get( 'tax_query' );
    if ( empty( $tax_query ) ) {
        $tax_query = array();
    }

    $added = false;
    foreach ( wc_get_attribute_taxonomies() as $tax ) {
        $attr_name  = $tax->attribute_name;
        $filter_key = 'filter_' . sanitize_title( $attr_name );
        if ( empty( $_GET[ $filter_key ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            continue;
        }
        $slug     = sanitize_title( wp_unslash( $_GET[ $filter_key ] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $taxonomy = wc_attribute_taxonomy_name( $attr_name );
        if ( ! $slug || ! taxonomy_exists( $taxonomy ) ) {
            continue;
        }
        $tax_query[] = array(
            'taxonomy' => $taxonomy,
            'field'    => 'slug',
            'terms'    => array( $slug ),
            'operator' => 'IN',
        );
        $added = true;
    }

    if ( $added ) {
        if ( count( $tax_query ) > 1 && empty( $tax_query['relation'] ) ) {
            $tax_query['relation'] = 'AND';
        }
        $q->set( 'tax_query', $tax_query );
    }
}
add_action( 'woocommerce_product_query', 'doroshopping_apply_attribute_filters' );

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
 * Filtrar tienda por productos en oferta (?on_sale=1).
 *
 * @param WP_Query $q Query.
 * @return void
 */
function doroshopping_filter_shop_on_sale( $q ) {
    if ( is_admin() || ! $q->is_main_query() ) {
        return;
    }
    if ( empty( $_GET['on_sale'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        return;
    }
    if ( ! function_exists( 'wc_get_product_ids_on_sale' ) ) {
        return;
    }
    $ids = array_filter( array_map( 'absint', wc_get_product_ids_on_sale() ) );
    // Sin ofertas: forzar resultado vacío (no listar todo el catálogo).
    $q->set( 'post__in', $ids ? $ids : array( 0 ) );
}
add_action( 'woocommerce_product_query', 'doroshopping_filter_shop_on_sale' );

/**
 * Estado vacío personalizado (ofertas sin productos).
 */
remove_action( 'woocommerce_no_products_found', 'wc_no_products_found' );
add_action( 'woocommerce_no_products_found', 'doroshopping_no_products_found', 10 );

/**
 * Mensaje / sugerencias cuando no hay productos en el listado.
 */
function doroshopping_no_products_found() {
    if ( function_exists( 'doroshopping_is_offers_view' ) && doroshopping_is_offers_view() ) {
        get_template_part( 'template-parts/shop/offers-empty' );
        return;
    }

    wc_get_template( 'loop/no-products-found.php' );
}

/**
 * Corrige enlaces "Ofertas" del menú principal si apuntan a # o home.
 *
 * @param WP_Post[] $items Menu items.
 * @return WP_Post[]
 */
function doroshopping_fix_offers_menu_links( $items ) {
    if ( empty( $items ) || ! function_exists( 'doroshopping_get_offers_url' ) ) {
        return $items;
    }
    $offers = doroshopping_get_offers_url();
    $home   = untrailingslashit( home_url( '/' ) );
    foreach ( $items as $item ) {
        $title = isset( $item->title ) ? (string) $item->title : '';
        if ( ! preg_match( '/ofertas/i', $title ) ) {
            continue;
        }
        $url = isset( $item->url ) ? untrailingslashit( (string) $item->url ) : '';
        if ( '' === $url || '#' === $url || $url === $home ) {
            $item->url = $offers;
        }
    }
    return $items;
}
add_filter( 'wp_nav_menu_objects', 'doroshopping_fix_offers_menu_links' );

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
