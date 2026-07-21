<?php
/**
 * Resumen lateral del carrito.
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$count    = isset( $args['count'] ) ? (int) $args['count'] : 0;
$is_empty = ! empty( $args['is_empty'] );
$total    = ( function_exists( 'WC' ) && WC()->cart ) ? WC()->cart->get_total() : wc_price( 0 );
$checkout = function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : home_url( '/' );
$shop     = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
?>

<div class="doro-cesta-summary">
    <h2 class="doro-cesta-summary__title"><?php esc_html_e( 'Resumen', 'doroshopping' ); ?></h2>

    <div class="doro-cesta-summary__row">
        <span><?php esc_html_e( 'Estimación total', 'doroshopping' ); ?></span>
        <strong class="doro-cesta-summary__total"><?php echo $is_empty ? wp_kses_post( wc_price( 0 ) ) : wp_kses_post( $total ); ?></strong>
    </div>

    <?php if ( $is_empty ) : ?>
        <a class="doro-cesta-summary__cta is-disabled" href="<?php echo esc_url( $shop ); ?>" aria-disabled="true">
            <?php
            printf(
                /* translators: %d: cart item count */
                esc_html__( 'Continuar (%d)', 'doroshopping' ),
                $count
            );
            ?>
        </a>
            <?php else : ?>
                <a class="doro-cesta-summary__cta" href="<?php echo esc_url( $checkout ); ?>">
                    <?php
                    printf(
                        /* translators: %d: cart item count */
                        esc_html__( 'Continuar (%d)', 'doroshopping' ),
                        $count
                    );
                    ?>
                </a>
            <?php endif; ?>
</div>
