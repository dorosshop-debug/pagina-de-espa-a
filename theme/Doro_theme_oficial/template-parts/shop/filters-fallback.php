<?php
/**
 * Fallback filters sidebar for shop (URLs reales WooCommerce)
 *
 * @package Doroshopping
 */

$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
$base_url = is_product_taxonomy() ? get_term_link( get_queried_object() ) : $shop_url;
if ( is_wp_error( $base_url ) ) {
    $base_url = $shop_url;
}

$categories = array();
if ( taxonomy_exists( 'product_cat' ) ) {
    $categories = get_terms(
        array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => true,
            'parent'     => 0,
            'number'     => 12,
        )
    );
}

$price_ranges = array(
    array( 'label' => __( 'Hasta 20 EUR', 'doroshopping' ), 'min' => 0, 'max' => 20 ),
    array( 'label' => __( '20 - 50 EUR', 'doroshopping' ), 'min' => 20, 'max' => 50 ),
    array( 'label' => __( '50 - 100 EUR', 'doroshopping' ), 'min' => 50, 'max' => 100 ),
    array( 'label' => __( 'Mas de 100 EUR', 'doroshopping' ), 'min' => 100, 'max' => '' ),
);

$current_min = isset( $_GET['min_price'] ) ? wc_clean( wp_unslash( $_GET['min_price'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$current_max = isset( $_GET['max_price'] ) ? wc_clean( wp_unslash( $_GET['max_price'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$current_rating = isset( $_GET['min_rating'] ) ? absint( $_GET['min_rating'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
?>

<div class="doro-shop__widget">
    <h3 class="doro-shop__widget-title"><?php esc_html_e( 'Categorías', 'doroshopping' ); ?></h3>
    <ul class="doro-shop__filter-list">
        <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
            <?php foreach ( $categories as $category ) : ?>
                <li>
                    <a href="<?php echo esc_url( get_term_link( $category ) ); ?>">
                        <?php echo esc_html( $category->name ); ?>
                        <span>(<?php echo esc_html( (string) $category->count ); ?>)</span>
                    </a>
                </li>
            <?php endforeach; ?>
        <?php else : ?>
            <li><a href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Ver todos los productos', 'doroshopping' ); ?></a></li>
        <?php endif; ?>
    </ul>
</div>

<div class="doro-shop__widget">
    <h3 class="doro-shop__widget-title"><?php esc_html_e( 'Precio', 'doroshopping' ); ?></h3>
    <ul class="doro-shop__filter-list">
        <?php foreach ( $price_ranges as $range ) : ?>
            <?php
            $args = array();
            if ( '' !== $range['min'] && null !== $range['min'] ) {
                $args['min_price'] = $range['min'];
            }
            if ( '' !== $range['max'] && null !== $range['max'] ) {
                $args['max_price'] = $range['max'];
            }
            $url = add_query_arg( $args, $base_url );
            $is_active = (string) $current_min === (string) $range['min']
                && (string) $current_max === (string) $range['max'];
            ?>
            <li>
                <a href="<?php echo esc_url( $url ); ?>"<?php echo $is_active ? ' aria-current="true" class="is-active"' : ''; ?>>
                    <?php echo esc_html( $range['label'] ); ?>
                </a>
            </li>
        <?php endforeach; ?>
        <?php if ( $current_min !== '' || $current_max !== '' ) : ?>
            <li><a href="<?php echo esc_url( remove_query_arg( array( 'min_price', 'max_price' ), $base_url ) ); ?>"><?php esc_html_e( 'Quitar filtro de precio', 'doroshopping' ); ?></a></li>
        <?php endif; ?>
    </ul>
</div>

<div class="doro-shop__widget">
    <h3 class="doro-shop__widget-title"><?php esc_html_e( 'Valoración', 'doroshopping' ); ?></h3>
    <ul class="doro-shop__filter-list">
        <?php foreach ( array( 4, 3 ) as $stars ) : ?>
            <?php
            $url = add_query_arg( 'min_rating', $stars, remove_query_arg( 'min_rating', $base_url ) );
            $is_active = $current_rating === $stars;
            ?>
            <li>
                <a href="<?php echo esc_url( $url ); ?>"<?php echo $is_active ? ' aria-current="true" class="is-active"' : ''; ?>>
                    <?php
                    /* translators: %d: minimum stars */
                    echo esc_html( sprintf( __( '%d estrellas o más', 'doroshopping' ), $stars ) );
                    ?>
                </a>
            </li>
        <?php endforeach; ?>
        <?php if ( $current_rating ) : ?>
            <li><a href="<?php echo esc_url( remove_query_arg( 'min_rating', $base_url ) ); ?>"><?php esc_html_e( 'Quitar filtro de valoración', 'doroshopping' ); ?></a></li>
        <?php endif; ?>
    </ul>
</div>
