<?php
/**
 * Dropdown cuenta
 *
 * @package Doroshopping
 */

$account_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : wp_login_url();
$orders_url  = ( function_exists( 'wc_get_endpoint_url' ) && $account_url )
    ? wc_get_endpoint_url( 'orders', '', $account_url )
    : $account_url;
$edit_url    = ( function_exists( 'wc_get_endpoint_url' ) && $account_url )
    ? wc_get_endpoint_url( 'edit-account', '', $account_url )
    : $account_url;
$payment_url = ( function_exists( 'wc_get_endpoint_url' ) && $account_url )
    ? wc_get_endpoint_url( 'payment-methods', '', $account_url )
    : doroshopping_get_page_url( 'metodos-de-pago' );
$google_url  = apply_filters( 'doroshopping_google_login_url', $account_url );
?>

<div class="header-dropdown header-dropdown--account" id="dropdown-account" hidden>
    <a href="<?php echo esc_url( $account_url ); ?>" class="header-dropdown__login-btn">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        <?php esc_html_e( 'Acceder a tu cuenta', 'doroshopping' ); ?>
    </a>
    <a href="<?php echo esc_url( $google_url ); ?>" class="header-dropdown__google-btn" data-google-login>
        <svg class="header-dropdown__google-icon" viewBox="0 0 24 24" aria-hidden="true" width="18" height="18">
            <path fill="#EA4335" d="M12 10.2v3.6h5.1c-.2 1.2-.9 2.3-1.9 3l3.1 2.4c1.8-1.7 2.9-4.1 2.9-7 0-.7-.1-1.3-.2-1.9H12z"/>
            <path fill="#34A853" d="M6.6 14.3l-.7.5-2.4 1.9C5.1 19.5 8.3 21.5 12 21.5c2.4 0 4.4-.8 5.9-2.1l-3.1-2.4c-.8.6-1.9.9-2.8.9-2.2 0-4-1.5-4.7-3.5z"/>
            <path fill="#4A90E2" d="M3.5 7.3C2.9 8.5 2.5 9.9 2.5 11.5s.4 3 1 4.2c0 .1 3.1-2.4 3.1-2.4-.2-.5-.3-1.1-.3-1.7 0-.6.1-1.2.3-1.7L3.5 7.3z"/>
            <path fill="#FBBC05" d="M12 5.1c1.3 0 2.5.5 3.4 1.3l2.6-2.6C16.4 2.3 14.4 1.5 12 1.5 8.3 1.5 5.1 3.5 3.5 7.3l3.1 2.4C7.9 6.6 9.8 5.1 12 5.1z"/>
        </svg>
        <?php esc_html_e( 'Iniciar sesion con Google', 'doroshopping' ); ?>
    </a>
    <a href="<?php echo esc_url( $account_url ); ?>" class="header-dropdown__register"><?php esc_html_e( 'Registrate', 'doroshopping' ); ?></a>

    <ul class="header-dropdown__list">
        <li>
            <a href="<?php echo esc_url( $orders_url ); ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M1 3h15v13H1zM16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="1.5"/><circle cx="18.5" cy="18.5" r="1.5"/></svg>
                <?php esc_html_e( 'Rastrear envio', 'doroshopping' ); ?>
            </a>
        </li>
        <li>
            <a href="<?php echo esc_url( $orders_url ); ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M6 2h12l1 7H5L6 2z"/><path d="M5 9v11a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V9"/></svg>
                <?php esc_html_e( 'Mis Pedidos', 'doroshopping' ); ?>
            </a>
        </li>
        <li>
            <a href="<?php echo esc_url( $account_url ); ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 9h16v2H4z"/><path d="M7 9V7a5 5 0 0 1 10 0v2"/><path d="M9 13h6"/></svg>
                <?php esc_html_e( 'Mis Cupones', 'doroshopping' ); ?>
            </a>
        </li>
        <li>
            <a href="<?php echo esc_url( doroshopping_get_page_url( 'contacto' ) ); ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 14h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-7a9 9 0 0 1 18 0v7a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3"/></svg>
                <?php esc_html_e( 'Centro de Ayuda & Soporte', 'doroshopping' ); ?>
            </a>
        </li>
        <li>
            <a href="<?php echo esc_url( doroshopping_get_wishlist_url() ); ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/></svg>
                <?php esc_html_e( 'Lista de Deseos', 'doroshopping' ); ?>
            </a>
        </li>
    </ul>

    <ul class="header-dropdown__list header-dropdown__list--plain">
        <li><a href="<?php echo esc_url( $edit_url ); ?>"><?php esc_html_e( 'Configuracion', 'doroshopping' ); ?></a></li>
        <li><a href="<?php echo esc_url( $edit_url ); ?>"><?php esc_html_e( 'Mi perfil', 'doroshopping' ); ?></a></li>
        <li><a href="<?php echo esc_url( $payment_url ); ?>"><?php esc_html_e( 'Metodos de pago', 'doroshopping' ); ?></a></li>
    </ul>

    <ul class="header-dropdown__list header-dropdown__list--footer">
        <li><a href="<?php echo esc_url( doroshopping_get_page_url( 'contacto' ) ); ?>"><?php esc_html_e( 'Centro de ayuda', 'doroshopping' ); ?></a></li>
        <li><a href="<?php echo esc_url( doroshopping_get_page_url( 'ayuda-faq' ) ); ?>"><?php esc_html_e( 'FAQ\'s - Preguntas Frecuentes', 'doroshopping' ); ?></a></li>
        <li><a href="<?php echo esc_url( doroshopping_get_page_url( 'politica-de-devoluciones' ) ); ?>"><?php esc_html_e( 'Politica de devoluciones y reembolsos', 'doroshopping' ); ?></a></li>
        <li><a href="<?php echo esc_url( doroshopping_get_page_url( 'politica-de-privacidad' ) ); ?>"><?php esc_html_e( 'Politica de proteccion de datos personales', 'doroshopping' ); ?></a></li>
    </ul>
</div>
