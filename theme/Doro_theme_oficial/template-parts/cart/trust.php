<?php
/**
 * Bloque confianza / seguridad (sidebar carrito).
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$ui = static function ( $key ) {
    return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : '';
};

$protect_url  = function_exists( 'doroshopping_get_page_url' ) ? doroshopping_get_page_url( 'proteccion-del-comprador' ) : home_url( '/' );
$payments_url = function_exists( 'doroshopping_get_page_url' ) ? doroshopping_get_page_url( 'metodos-de-pago' ) : home_url( '/' );
$privacy_url  = function_exists( 'doroshopping_get_page_url' ) ? doroshopping_get_page_url( 'politica-de-privacidad' ) : home_url( '/' );
?>

<div class="doro-cesta-trust">
    <a class="doro-cesta-trust__item" href="<?php echo esc_url( $protect_url ); ?>">
        <span class="doro-cesta-trust__icon" aria-hidden="true">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        </span>
        <span class="doro-cesta-trust__body">
            <strong><?php echo esc_html( $ui( 'doroshopping_ui_cart_trust_security' ) ); ?></strong>
            <small><?php echo esc_html( $ui( 'doroshopping_ui_cart_trust_security_sub' ) ); ?></small>
        </span>
        <span class="doro-cesta-trust__chevron" aria-hidden="true">›</span>
    </a>
    <button
        type="button"
        class="doro-cesta-trust__item doro-cesta-trust__item--btn"
        data-secure-payments-open
        aria-haspopup="dialog"
        aria-controls="doro-secure-payments-modal"
    >
        <span class="doro-cesta-trust__icon" aria-hidden="true">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        </span>
        <span class="doro-cesta-trust__body">
            <strong><?php echo esc_html( $ui( 'doroshopping_ui_cart_trust_payments' ) ); ?></strong>
            <small><?php echo esc_html( $ui( 'doroshopping_ui_cart_trust_payments_sub' ) ); ?></small>
        </span>
        <span class="doro-cesta-trust__chevron" aria-hidden="true">›</span>
    </button>
</div>

<div class="doro-modal" id="doro-secure-payments-modal" hidden data-secure-payments-modal>
    <div class="doro-modal__backdrop" data-secure-payments-close tabindex="-1"></div>
    <div class="doro-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="doro-secure-payments-title">
        <div class="doro-modal__header">
            <h2 class="doro-modal__title" id="doro-secure-payments-title"><?php echo esc_html( $ui( 'doroshopping_ui_cart_secure_title' ) ); ?></h2>
            <button type="button" class="doro-modal__close" data-secure-payments-close aria-label="<?php echo esc_attr( $ui( 'doroshopping_ui_cart_close' ) ); ?>">×</button>
        </div>
        <div class="doro-modal__body doro-secure-payments">
            <ul class="doro-secure-payments__list">
                <li>
                    <strong><?php echo esc_html( $ui( 'doroshopping_ui_cart_secure_ssl' ) ); ?></strong>
                    <span><?php echo esc_html( $ui( 'doroshopping_ui_cart_secure_ssl_text' ) ); ?></span>
                </li>
                <li>
                    <strong><?php echo esc_html( $ui( 'doroshopping_ui_cart_secure_gateways' ) ); ?></strong>
                    <span><?php echo esc_html( $ui( 'doroshopping_ui_cart_secure_gateways_text' ) ); ?></span>
                </li>
                <li>
                    <strong><?php echo esc_html( $ui( 'doroshopping_ui_cart_secure_privacy' ) ); ?></strong>
                    <span><?php echo esc_html( $ui( 'doroshopping_ui_cart_secure_privacy_text' ) ); ?></span>
                </li>
                <li>
                    <strong><?php echo esc_html( $ui( 'doroshopping_ui_cart_secure_buyer' ) ); ?></strong>
                    <span><?php echo esc_html( $ui( 'doroshopping_ui_cart_secure_buyer_text' ) ); ?></span>
                </li>
            </ul>
            <div class="doro-secure-payments__links">
                <a href="<?php echo esc_url( $payments_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_footer_payments' ) ); ?></a>
                <a href="<?php echo esc_url( $privacy_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_footer_legal_privacy' ) ); ?></a>
                <a href="<?php echo esc_url( $protect_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_footer_buyer' ) ); ?></a>
            </div>
        </div>
        <div class="doro-modal__footer">
            <button type="button" class="doro-modal__btn doro-modal__btn--primary" data-secure-payments-close><?php echo esc_html( $ui( 'doroshopping_ui_cart_secure_ok' ) ); ?></button>
        </div>
    </div>
</div>
