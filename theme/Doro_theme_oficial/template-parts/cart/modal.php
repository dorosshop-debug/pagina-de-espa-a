<?php
/**
 * Modal emergente del carrito flotante
 *
 * @package Doroshopping
 */

$ui = static function ( $key ) {
    return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : '';
};

$checkout_url = function_exists( 'doroshopping_get_checkout_url' ) ? doroshopping_get_checkout_url() : '';
if ( ! $checkout_url ) {
    $checkout_url = '#';
}
$cart_count   = ( function_exists( 'WC' ) && WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0;
?>

<div class="cart-modal" id="cart-modal" hidden aria-hidden="true">
    <div class="cart-modal__backdrop" data-cart-close></div>

    <div
        class="cart-modal__dialog"
        role="dialog"
        aria-modal="true"
        aria-labelledby="cart-modal-title"
        tabindex="-1"
    >
        <header class="cart-modal__header">
            <h2 id="cart-modal-title" class="cart-modal__title"><?php echo esc_html( $ui( 'doroshopping_ui_cart_modal_title' ) ); ?></h2>
            <button type="button" class="cart-modal__close" data-cart-close aria-label="<?php echo esc_attr( $ui( 'doroshopping_ui_cart_modal_close' ) ); ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M18 6L6 18M6 6l12 12"/></svg>
            </button>
        </header>

        <div class="cart-modal__body">
            <div class="cart-modal__items" data-cart-items>
                <p class="cart-modal__empty"><?php echo esc_html( $ui( 'doroshopping_ui_cart_modal_empty' ) ); ?></p>
            </div>

            <div class="cart-modal__summary">
                <p class="cart-modal__subtotal">
                    <?php echo esc_html( $ui( 'doroshopping_ui_cart_modal_subtotal' ) ); ?>
                    <span data-cart-subtotal>—</span>
                </p>
                <a href="<?php echo esc_url( $checkout_url ); ?>" class="cart-modal__checkout" data-cart-checkout>
                    <?php echo esc_html( $ui( 'doroshopping_ui_cart_modal_checkout' ) ); ?>
                </a>
            </div>
        </div>

        <div class="cart-modal__recs">
            <h3 class="cart-modal__recs-title"><?php echo esc_html( $ui( 'doroshopping_ui_cart_modal_recs' ) ); ?></h3>
            <div class="cart-modal__recs-grid" data-cart-recs></div>
        </div>
    </div>
</div>

<button
    type="button"
    class="site-fab-cart"
    id="site-fab-cart"
    aria-haspopup="dialog"
    aria-controls="cart-modal"
    aria-expanded="false"
    aria-label="<?php echo esc_attr( $ui( 'doroshopping_ui_cart_fab' ) ); ?>"
>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
    <span class="site-fab-cart__count" data-cart-count><?php echo esc_html( (string) $cart_count ); ?></span>
</button>
