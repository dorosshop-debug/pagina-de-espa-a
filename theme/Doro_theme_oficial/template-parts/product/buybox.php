<?php
/**
 * Buy box lateral (estilo AliExpress)
 *
 * @package Doroshopping
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product ) {
    return;
}
?>

<div class="doro-buybox">
    <div class="doro-buybox__badge"><?php esc_html_e( 'Envío Doro', 'doroshopping' ); ?></div>

    <ul class="doro-buybox__perks">
        <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12l4 4L19 6"/></svg>
            <?php esc_html_e( 'Envío gratis en pedidos seleccionados', 'doroshopping' ); ?>
        </li>
        <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12l4 4L19 6"/></svg>
            <?php esc_html_e( 'Entrega rápida disponible', 'doroshopping' ); ?>
        </li>
        <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12l4 4L19 6"/></svg>
            <?php esc_html_e( 'Devoluciones fáciles', 'doroshopping' ); ?>
        </li>
    </ul>

    <div class="doro-buybox__shipping">
        <p class="doro-buybox__shipping-title"><?php esc_html_e( 'Envío', 'doroshopping' ); ?></p>
        <p class="doro-buybox__shipping-text"><?php esc_html_e( 'Entrega estimada en 3-7 días laborables según tu ubicación.', 'doroshopping' ); ?></p>
    </div>

    <div class="doro-buybox__actions" data-doro-buybox-actions>
        <?php woocommerce_template_single_add_to_cart(); ?>
    </div>

    <div class="doro-buybox__secondary">
        <button
            type="button"
            class="doro-buybox__wish"
            data-wishlist-toggle
            data-product-id="<?php echo esc_attr( (string) $product->get_id() ); ?>"
            aria-pressed="false"
            aria-label="<?php esc_attr_e( 'Anadir a lista de deseos', 'doroshopping' ); ?>"
        >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/></svg>
            <?php esc_html_e( 'Lista de deseos', 'doroshopping' ); ?>
        </button>
        <button type="button" class="doro-buybox__share" aria-label="<?php esc_attr_e( 'Compartir', 'doroshopping' ); ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><path d="M8.6 13.5l6.8 4M15.4 6.5l-6.8 4"/></svg>
            <?php esc_html_e( 'Compartir', 'doroshopping' ); ?>
        </button>
    </div>

    <div class="doro-buybox__meta">
        <?php woocommerce_template_single_meta(); ?>
    </div>
</div>
