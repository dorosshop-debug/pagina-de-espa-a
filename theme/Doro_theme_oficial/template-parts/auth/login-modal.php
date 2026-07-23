<?php
/**
 * Modal de inicio de sesion (estilo AliExpress).
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$account_url  = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : home_url( '/' );
$register_url = function_exists( 'doroshopping_get_register_url' ) ? doroshopping_get_register_url() : $account_url;
?>

<div class="doro-auth-modal" id="doro-auth-modal" hidden aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="doro-auth-modal-title">
    <div class="doro-auth-modal__backdrop" data-auth-modal-close></div>
    <div class="doro-auth-modal__dialog">
        <button type="button" class="doro-auth-modal__close" data-auth-modal-close aria-label="<?php esc_attr_e( 'Cerrar', 'doroshopping' ); ?>">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>

        <div class="doro-auth-modal__brand">
            <img src="<?php echo esc_url( doroshopping_logo_url() ); ?>" alt="<?php bloginfo( 'name' ); ?>">
        </div>

        <h2 id="doro-auth-modal-title" class="doro-auth-modal__title"><?php esc_html_e( '¡Bienvenido!', 'doroshopping' ); ?></h2>
        <p class="doro-auth-modal__subtitle"><?php esc_html_e( 'Inicia sesión para comprar más rápido y seguir tus pedidos.', 'doroshopping' ); ?></p>

        <?php
        if ( function_exists( 'doroshopping_render_google_button' ) ) {
            doroshopping_render_google_button( 'modal' );
        }
        ?>

        <div class="doro-auth-modal__divider"><span><?php esc_html_e( 'o con tu correo', 'doroshopping' ); ?></span></div>

        <form class="doro-auth-modal__form woocommerce-form woocommerce-form-login login" method="post" action="<?php echo esc_url( $account_url ); ?>" novalidate>
            <?php do_action( 'woocommerce_login_form_start' ); ?>

            <label class="doro-auth-modal__label" for="doro-modal-username"><?php esc_html_e( 'Correo o usuario', 'doroshopping' ); ?></label>
            <input
                type="text"
                class="doro-auth-modal__input input-text"
                name="username"
                id="doro-modal-username"
                autocomplete="username"
                required
                placeholder="<?php esc_attr_e( 'tu@email.com', 'doroshopping' ); ?>"
            >

            <label class="doro-auth-modal__label" for="doro-modal-password"><?php esc_html_e( 'Contraseña', 'doroshopping' ); ?></label>
            <input
                type="password"
                class="doro-auth-modal__input input-text"
                name="password"
                id="doro-modal-password"
                autocomplete="current-password"
                required
                placeholder="<?php esc_attr_e( 'Tu contraseña', 'doroshopping' ); ?>"
            >

            <?php do_action( 'woocommerce_login_form' ); ?>

            <div class="doro-auth-modal__row">
                <label class="doro-auth-modal__remember">
                    <input name="rememberme" type="checkbox" value="forever">
                    <span><?php esc_html_e( 'Recuérdame', 'doroshopping' ); ?></span>
                </label>
                <a class="doro-auth-modal__link" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( '¿Olvidaste tu contraseña?', 'doroshopping' ); ?></a>
            </div>

            <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
            <button type="submit" class="doro-auth-modal__submit" name="login" value="<?php esc_attr_e( 'Iniciar sesión', 'doroshopping' ); ?>">
                <?php esc_html_e( 'Iniciar sesión', 'doroshopping' ); ?>
            </button>

            <?php do_action( 'woocommerce_login_form_end' ); ?>
        </form>

        <p class="doro-auth-modal__footer">
            <?php esc_html_e( '¿No tienes cuenta?', 'doroshopping' ); ?>
            <a href="<?php echo esc_url( $register_url ); ?>"><?php esc_html_e( 'Regístrate', 'doroshopping' ); ?></a>
        </p>
    </div>
</div>
