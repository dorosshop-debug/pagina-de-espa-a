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

    ob_start();
    ?>
    <div class="product-rating" role="img" aria-label="<?php echo esc_attr( $label ); ?>">
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
                <svg class="product-rating__star-empty" viewBox="0 0 24 24" width="14" height="14">
                    <path d="M12 2l2.9 6.3 6.9.8-5.1 4.7 1.4 6.8L12 17.8 5.9 20.6l1.4-6.8L2.2 9.1l6.9-.8L12 2z" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                </svg>
                <span class="product-rating__star-fill" style="width: <?php echo esc_attr( (string) $fill ); ?>%;">
                    <svg viewBox="0 0 24 24" width="14" height="14">
                        <path d="M12 2l2.9 6.3 6.9.8-5.1 4.7 1.4 6.8L12 17.8 5.9 20.6l1.4-6.8L2.2 9.1l6.9-.8L12 2z" fill="currentColor"/>
                    </svg>
                </span>
            </span>
        <?php endfor; ?>
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
