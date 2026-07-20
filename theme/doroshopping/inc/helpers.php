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

    /**
     * Permite forzar header compacto desde templates/preview.
     *
     * @param bool $compact Default false outside WC contexts.
     */
    return (bool) apply_filters( 'doroshopping_is_compact_header', false );
}
