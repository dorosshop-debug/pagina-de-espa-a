<?php
/**
 * Autenticacion: Google, modal de login y helpers.
 *
 * Listo para plugins (Nextend Social Login, WP Social Login, etc.)
 * via filtros doroshopping_google_login_url / doroshopping_google_login_enabled.
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * URL de inicio / registro con Google.
 *
 * Los plugins sociales deben filtrar doroshopping_google_login_url
 * con la URL real del proveedor.
 *
 * @return string
 */
function doroshopping_get_google_login_url() {
    $account  = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : wp_login_url();
    $fallback = add_query_arg( 'doro_google', '1', $account );

    /**
     * URL del proveedor Google (plugin social).
     *
     * @param string $url URL.
     */
    return esc_url( apply_filters( 'doroshopping_google_login_url', $fallback ) );
}

/**
 * Si el boton Google debe mostrarse.
 * Por defecto solo si un plugin ha sustituido la URL placeholder.
 *
 * @return bool
 */
function doroshopping_is_google_login_enabled() {
    $url      = doroshopping_get_google_login_url();
    $has_real = is_string( $url ) && '' !== $url && false === strpos( $url, 'doro_google=1' );

    /**
     * @param bool $enabled Enabled.
     */
    return (bool) apply_filters( 'doroshopping_google_login_enabled', $has_real );
}

/**
 * URL de la pagina de registro (pantalla completa).
 *
 * @return string
 */
function doroshopping_get_register_url() {
    $account = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : wp_registration_url();
    return add_query_arg( 'action', 'register', $account );
}

/**
 * ¿Estamos en la vista de registro completa?
 *
 * @return bool
 */
function doroshopping_is_register_view() {
    return isset( $_GET['action'] ) && 'register' === sanitize_key( wp_unslash( $_GET['action'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
}

/**
 * Nombre corto para el header.
 *
 * @return string
 */
function doroshopping_get_header_user_name() {
    if ( ! is_user_logged_in() ) {
        return __( 'Ingresar', 'doroshopping' );
    }

    $user = wp_get_current_user();
    $name = trim( (string) $user->first_name );
    if ( '' === $name ) {
        $name = trim( (string) $user->display_name );
    }
    if ( '' === $name ) {
        $name = (string) $user->user_login;
    }

    if ( function_exists( 'mb_strlen' ) && mb_strlen( $name ) > 16 ) {
        $name = mb_substr( $name, 0, 14 ) . '…';
    } elseif ( strlen( $name ) > 16 ) {
        $name = substr( $name, 0, 14 ) . '…';
    }

    return $name;
}

/**
 * Etiqueta superior del header (Bienvenido / Hola).
 *
 * @return string
 */
function doroshopping_get_header_user_greeting() {
    return is_user_logged_in()
        ? __( 'Hola', 'doroshopping' )
        : __( 'Bienvenido', 'doroshopping' );
}

/**
 * Markup del boton Google reutilizable.
 *
 * @param string $context Context class suffix (modal|dropdown|page).
 * @return void
 */
function doroshopping_render_google_button( $context = 'page' ) {
    if ( ! doroshopping_is_google_login_enabled() ) {
        return;
    }

    $url   = doroshopping_get_google_login_url();
    $class = 'doro-google-btn doro-google-btn--' . sanitize_html_class( $context );

    /**
     * Antes del boton (plugins pueden inyectar shortcodes).
     *
     * @param string $context Context.
     */
    do_action( 'doroshopping_before_google_button', $context );
    ?>
    <a
        href="<?php echo esc_url( $url ); ?>"
        class="<?php echo esc_attr( $class ); ?>"
        data-google-login
        data-google-context="<?php echo esc_attr( $context ); ?>"
    >
        <svg class="doro-google-btn__icon" viewBox="0 0 24 24" aria-hidden="true" width="18" height="18">
            <path fill="#EA4335" d="M12 10.2v3.6h5.1c-.2 1.2-.9 2.3-1.9 3l3.1 2.4c1.8-1.7 2.9-4.1 2.9-7 0-.7-.1-1.3-.2-1.9H12z"/>
            <path fill="#34A853" d="M6.6 14.3l-.7.5-2.4 1.9C5.1 19.5 8.3 21.5 12 21.5c2.4 0 4.4-.8 5.9-2.1l-3.1-2.4c-.8.6-1.9.9-2.8.9-2.2 0-4-1.5-4.7-3.5z"/>
            <path fill="#4A90E2" d="M3.5 7.3C2.9 8.5 2.5 9.9 2.5 11.5s.4 3 1 4.2c0 .1 3.1-2.4 3.1-2.4-.2-.5-.3-1.1-.3-1.7 0-.6.1-1.2.3-1.7L3.5 7.3z"/>
            <path fill="#FBBC05" d="M12 5.1c1.3 0 2.5.5 3.4 1.3l2.6-2.6C16.4 2.3 14.4 1.5 12 1.5 8.3 1.5 5.1 3.5 3.5 7.3l3.1 2.4C7.9 6.6 9.8 5.1 12 5.1z"/>
        </svg>
        <span><?php esc_html_e( 'Inicia o Regístrate con Google', 'doroshopping' ); ?></span>
    </a>
    <?php
    /**
     * @param string $context Context.
     */
    do_action( 'doroshopping_after_google_button', $context );
}

/**
 * Imprimir modal de login en el footer (solo visitantes).
 *
 * @return void
 */
function doroshopping_render_login_modal() {
    if ( is_user_logged_in() || is_admin() ) {
        return;
    }
    get_template_part( 'template-parts/auth/login-modal' );
}
add_action( 'wp_footer', 'doroshopping_render_login_modal', 20 );

/**
 * Clase body en vista de registro.
 *
 * @param string[] $classes Classes.
 * @return string[]
 */
function doroshopping_auth_body_class( $classes ) {
    if ( doroshopping_is_register_view() ) {
        $classes[] = 'doro-register-view';
    }
    return $classes;
}
add_filter( 'body_class', 'doroshopping_auth_body_class' );
