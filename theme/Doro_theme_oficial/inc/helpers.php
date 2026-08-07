<?php
/**
 * Theme helpers
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Renderiza estrellas de valoración (0-5). Vacías si no hay valoraciones.
 *
 * @param float $rating Promedio 0-5.
 * @param int   $count  Número de valoraciones.
 * @return string
 */
function doroshopping_get_star_rating_html( $rating = 0, $count = 0 ) {
    $rating = max( 0, min( 5, (float) $rating ) );
    $count  = (int) $count;
    $label  = $count > 0
        /* translators: 1: average rating, 2: review count */
        ? sprintf( __( 'Valoración %.1f de 5 (%d valoraciones)', 'doroshopping' ), $rating, $count )
        : __( 'Sin valoraciones', 'doroshopping' );

    $star_path = 'M12 2l2.9 6.3 6.9.8-5.1 4.7 1.4 6.8L12 17.8 5.9 20.6l1.4-6.8L2.2 9.1l6.9-.8L12 2z';

    ob_start();
    ?>
    <div class="product-rating<?php echo $count > 0 ? ' product-rating--rated' : ''; ?>" role="img" aria-label="<?php echo esc_attr( $label ); ?>">
        <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
            <?php
            $fill = 0;
            if ( $count > 0 ) {
                if ( $rating >= $i ) {
                    $fill = 100;
                } elseif ( $rating > ( $i - 1 ) ) {
                    $fill = ( $rating - ( $i - 1 ) ) * 100;
                }
            }
            ?>
            <span class="product-rating__star" aria-hidden="true">
                <svg class="product-rating__star-empty" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true">
                    <path d="<?php echo esc_attr( $star_path ); ?>" fill="#fff" stroke="#111" stroke-width="1.6" stroke-linejoin="round"/>
                </svg>
                <span class="product-rating__star-fill" style="width: <?php echo esc_attr( (string) $fill ); ?>%;">
                    <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true">
                        <path d="<?php echo esc_attr( $star_path ); ?>" fill="#FFD100" stroke="#111" stroke-width="1.6" stroke-linejoin="round"/>
                    </svg>
                </span>
            </span>
        <?php endfor; ?>
        <?php if ( $count > 0 ) : ?>
            <span class="product-rating__count">(<?php echo esc_html( (string) $count ); ?>)</span>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Badge de ahorro cuando el producto está en oferta (encima del precio).
 *
 * @param WC_Product|null $product Producto.
 * @return string
 */
function doroshopping_get_sale_savings_html( $product = null ) {
    if ( ! $product && function_exists( 'wc_get_product' ) ) {
        $product = wc_get_product( get_the_ID() );
    }
    if ( ! $product || ! is_a( $product, 'WC_Product' ) || ! $product->is_on_sale() ) {
        return '';
    }

    $regular = 0.0;
    $sale    = 0.0;

    if ( $product->is_type( 'variable' ) ) {
        $regular = (float) $product->get_variation_regular_price( 'min', true );
        $sale    = (float) $product->get_variation_sale_price( 'min', true );
    } else {
        $regular = (float) $product->get_regular_price();
        $sale    = (float) $product->get_sale_price();
        if ( $sale <= 0 ) {
            $sale = (float) $product->get_price();
        }
    }

    if ( $regular <= 0 || $sale <= 0 || $sale >= $regular ) {
        return '';
    }

    $saved = $regular - $sale;
    $ends  = '';
    $to    = $product->get_date_on_sale_to();
    if ( $to ) {
        /* translators: %s: end date */
        $ends = sprintf( __( 'Hasta %s', 'doroshopping' ), date_i18n( 'j M', $to->getTimestamp() ) );
    }

    ob_start();
    ?>
    <div class="product-sale-save">
        <span class="product-sale-save__amount">
            ↓ <?php echo esc_html( sprintf( __( 'Ahorras %s', 'doroshopping' ), wp_strip_all_tags( wc_price( $saved ) ) ) ); ?>
        </span>
        <?php if ( $ends ) : ?>
            <span class="product-sale-save__ends"><?php echo esc_html( $ends ); ?></span>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Echo del badge de ahorro (hook de loop).
 */
function doroshopping_loop_sale_savings() {
    global $product;
    echo doroshopping_get_sale_savings_html( $product ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Header compacto (hamburguesa + logo) en tienda / producto / taxonomías de producto.
 *
 * @return bool
 */
function doroshopping_is_compact_header() {
    if ( function_exists( 'is_shop' ) && is_shop() ) {
        return true;
    }
    if ( function_exists( 'is_product' ) && is_product() ) {
        return true;
    }
    if ( function_exists( 'is_product_taxonomy' ) && is_product_taxonomy() ) {
        return true;
    }
    if ( function_exists( 'is_product_category' ) && is_product_category() ) {
        return true;
    }
    if ( function_exists( 'is_product_tag' ) && is_product_tag() ) {
        return true;
    }
    if ( function_exists( 'is_cart' ) && is_cart() ) {
        return true;
    }
    if ( function_exists( 'is_checkout' ) && is_checkout() ) {
        return true;
    }
    if ( function_exists( 'is_account_page' ) && is_account_page() ) {
        return true;
    }
    if ( function_exists( 'doroshopping_is_wishlist_page' ) && doroshopping_is_wishlist_page() ) {
        return true;
    }
    if ( ( is_page() && ! is_front_page() ) || is_404() || is_search() ) {
        return true;
    }

    /**
     * Permite forzar header compacto desde templates/preview.
     *
     * @param bool $compact Default false outside WC contexts.
     */
    return (bool) apply_filters( 'doroshopping_is_compact_header', false );
}

/**
 * URL de la página / listado de ofertas.
 *
 * Prioridad: categoría promociones-ofertas → shop con ?on_sale=1.
 *
 * @return string
 */
function doroshopping_get_offers_url() {
    if ( taxonomy_exists( 'product_cat' ) ) {
        $term = get_term_by( 'slug', 'promociones-ofertas', 'product_cat' );
        if ( ! $term || is_wp_error( $term ) ) {
            $term = get_term_by( 'slug', 'ofertas', 'product_cat' );
        }
        if ( $term && ! is_wp_error( $term ) ) {
            $link = get_term_link( $term );
            if ( ! is_wp_error( $link ) ) {
                return $link;
            }
        }
    }

    $shop = function_exists( 'doroshopping_get_wc_page_url' ) ? doroshopping_get_wc_page_url( 'shop' ) : '';
    if ( ! $shop && function_exists( 'wc_get_page_permalink' ) ) {
        $shop = wc_get_page_permalink( 'shop' );
    }
    if ( ! $shop ) {
        $shop = home_url( '/' );
    }
    return add_query_arg( 'on_sale', '1', $shop );
}

/**
 * ¿Vista de ofertas (on_sale o categoría de promociones)?
 *
 * @return bool
 */
function doroshopping_is_offers_view() {
    if ( ! is_admin() && ! empty( $_GET['on_sale'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        return true;
    }

    if ( is_product_category() ) {
        $term = get_queried_object();
        if ( $term instanceof WP_Term ) {
            if ( in_array( $term->slug, array( 'promociones-ofertas', 'ofertas' ), true ) ) {
                return true;
            }
        }
    }

    return (bool) apply_filters( 'doroshopping_is_offers_view', false );
}

/**
 * Productos sugeridos cuando no hay ofertas disponibles.
 *
 * @param int $limit Límite.
 * @return WC_Product[]
 */
function doroshopping_get_suggested_products( $limit = 16 ) {
    if ( ! function_exists( 'wc_get_products' ) ) {
        return array();
    }

    $limit = max( 4, min( 24, absint( $limit ) ) );
    $args  = array(
        'status'  => 'publish',
        'limit'   => $limit,
        'orderby' => 'popularity',
        'order'   => 'DESC',
    );

    $products = wc_get_products( $args );
    if ( empty( $products ) ) {
        $products = wc_get_products(
            array(
                'status'  => 'publish',
                'limit'   => $limit,
                'orderby' => 'date',
                'order'   => 'DESC',
            )
        );
    }

    return is_array( $products ) ? $products : array();
}

/**
 * URL segura de una página WooCommerce (no cae a home si falta la página).
 *
 * @param string $page shop|cart|checkout|myaccount.
 * @return string URL o cadena vacía.
 */
function doroshopping_get_wc_page_url( $page ) {
    $page = sanitize_key( $page );
    if ( ! $page ) {
        return '';
    }

    if ( function_exists( 'wc_get_page_id' ) ) {
        $id = (int) wc_get_page_id( $page );
        if ( $id > 0 ) {
            $link = get_permalink( $id );
            if ( $link && ! doroshopping_url_is_home( $link ) ) {
                return $link;
            }
            // ID apuntaba a home / inválido: seguir a fallbacks.
        }
    }

    $slug_map = array(
        'shop'      => array( 'tienda', 'shop' ),
        'cart'      => array( 'carrito', 'cart' ),
        'checkout'  => array( 'finalizar-compra', 'checkout', 'pago' ),
        'myaccount' => array( 'mi-cuenta', 'my-account' ),
    );

    if ( empty( $slug_map[ $page ] ) ) {
        return '';
    }

    foreach ( $slug_map[ $page ] as $slug ) {
        if ( function_exists( 'doroshopping_get_page_by_slug' ) ) {
            $found = doroshopping_get_page_by_slug( $slug );
            if ( $found instanceof WP_Post ) {
                $link = get_permalink( $found );
                if ( $link ) {
                    return $link;
                }
            }
        }
    }

    return '';
}

/**
 * @param string $url URL.
 * @return bool
 */
function doroshopping_url_is_home( $url ) {
    if ( ! $url ) {
        return true;
    }
    $home = untrailingslashit( home_url( '/' ) );
    $url  = untrailingslashit( $url );
    return strtolower( $home ) === strtolower( $url );
}

/**
 * URL de checkout (vacía si no hay página; nunca fuerza home).
 *
 * @return string
 */
function doroshopping_get_checkout_url() {
    return doroshopping_get_wc_page_url( 'checkout' );
}

/**
 * URL de carrito.
 *
 * @return string
 */
function doroshopping_get_cart_url() {
    return doroshopping_get_wc_page_url( 'cart' );
}

/**
 * HTML de tarjeta de producto (home / AJAX Ver más).
 *
 * @param WC_Product $product Producto.
 * @return string
 */
function doroshopping_render_home_product_card( $product ) {
    if ( ! $product || ! is_a( $product, 'WC_Product' ) ) {
        return '';
    }

    if ( function_exists( 'doroshopping_pll_product' ) ) {
        $product = doroshopping_pll_product( $product );
    }

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

    ob_start();
    ?>
    <article class="home-product-card" data-product-id="<?php echo esc_attr( (string) $product_id ); ?>">
        <div class="home-product-card__image-wrap">
            <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="home-product-card__image-link">
                <?php echo $image_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </a>
            <?php if ( $purchasable ) : ?>
                <button
                    type="button"
                    class="home-product-card__cart-btn ajax_add_to_cart add_to_cart_button"
                    data-product_id="<?php echo esc_attr( (string) $product_id ); ?>"
                    data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"
                    data-quantity="1"
                    aria-label="<?php echo esc_attr( function_exists( 'doroshopping_ui_sprintf' ) ? doroshopping_ui_sprintf( 'doroshopping_ui_product_add_aria', $product->get_name() ) : $product->get_name() ); ?>"
                >
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                </button>
            <?php else : ?>
                <a
                    href="<?php echo esc_url( $product->get_permalink() ); ?>"
                    class="home-product-card__cart-btn"
                    aria-label="<?php echo esc_attr( function_exists( 'doroshopping_ui_sprintf' ) ? doroshopping_ui_sprintf( 'doroshopping_ui_product_view_aria', $product->get_name() ) : $product->get_name() ); ?>"
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
                aria-label="<?php echo esc_attr( function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( 'doroshopping_ui_product_card_wishlist' ) : __( 'Anadir a lista de deseos', 'doroshopping' ) ); ?>"
            >
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/></svg>
            </button>
        </div>
        <div class="home-product-card__info">
            <?php echo function_exists( 'doroshopping_get_sale_savings_html' ) ? doroshopping_get_sale_savings_html( $product ) : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            <p class="home-product-card__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></p>
            <?php echo function_exists( 'doroshopping_get_star_rating_html' ) ? doroshopping_get_star_rating_html( $rating, $count ) : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            <h3 class="home-product-card__name">
                <a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
            </h3>
        </div>
    </article>
    <?php
    return ob_get_clean();
}


