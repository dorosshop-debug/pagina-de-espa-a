<?php
/**
 * Modal añadir dirección (solo facturación / entrega).
 * Sin envío aparte ni notas del pedido (evita el layout en 2 columnas).
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$ui = static function ( $key ) {
    return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : '';
};

if ( ! function_exists( 'WC' ) || ! WC()->checkout() ) {
    return;
}
?>

<div class="doro-modal" id="doro-address-modal" hidden aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="doro-address-modal-title">
    <div class="doro-modal__backdrop" data-address-modal-close></div>
    <div class="doro-modal__dialog">
        <header class="doro-modal__header">
            <h2 id="doro-address-modal-title" class="doro-modal__title"><?php echo esc_html( $ui( 'doroshopping_ui_checkout_address_modal_title' ) ); ?></h2>
            <button type="button" class="doro-modal__close" data-address-modal-close aria-label="<?php echo esc_attr( $ui( 'doroshopping_ui_ship_close' ) ); ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M18 6L6 18M6 6l12 12"/></svg>
            </button>
        </header>

        <div class="doro-modal__body" id="customer_details">
            <div class="doro-modal__fields">
                <?php do_action( 'woocommerce_checkout_billing' ); ?>
            </div>
        </div>

        <footer class="doro-modal__footer">
            <button type="button" class="doro-modal__btn doro-modal__btn--primary" data-address-modal-confirm>
                <?php echo esc_html( $ui( 'doroshopping_ui_checkout_confirm' ) ); ?>
            </button>
            <button type="button" class="doro-modal__btn doro-modal__btn--ghost" data-address-modal-close>
                <?php echo esc_html( $ui( 'doroshopping_ui_checkout_cancel' ) ); ?>
            </button>
        </footer>
    </div>
</div>
