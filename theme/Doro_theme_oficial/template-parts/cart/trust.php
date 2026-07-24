<?php
/**
 * Bloque confianza / seguridad (sidebar carrito).
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<div class="doro-cesta-trust">
    <a class="doro-cesta-trust__item" href="<?php echo esc_url( function_exists( 'doroshopping_get_page_url' ) ? doroshopping_get_page_url( 'proteccion-del-comprador' ) : home_url( '/' ) ); ?>">
        <span class="doro-cesta-trust__icon" aria-hidden="true">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        </span>
        <span class="doro-cesta-trust__body">
            <strong><?php esc_html_e( 'Seguridad & Privacidad', 'doroshopping' ); ?></strong>
            <small><?php esc_html_e( 'Datos personales seguros', 'doroshopping' ); ?></small>
        </span>
        <span class="doro-cesta-trust__chevron" aria-hidden="true">›</span>
    </a>
    <div class="doro-cesta-trust__item doro-cesta-trust__item--static">
        <span class="doro-cesta-trust__icon" aria-hidden="true">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        </span>
        <span class="doro-cesta-trust__body">
            <strong><?php esc_html_e( 'Pagos seguros', 'doroshopping' ); ?></strong>
            <small><?php esc_html_e( 'Pagos seguros · Datos personales seguros', 'doroshopping' ); ?></small>
        </span>
    </div>
</div>
