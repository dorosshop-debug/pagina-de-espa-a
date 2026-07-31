<?php
/**
 * Modal de inicio de sesion (estilo AliExpress).
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$ui = static function ( $key ) {
    return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : '';
};

$account_url  = function_exists( 'doroshopping_get_account_url' ) ? doroshopping_get_account_url() : home_url( '/' );
$register_url = function_exists( 'doroshopping_get_register_url' ) ? doroshopping_get_register_url() : $account_url;
?>

<div class="doro-auth-modal" id="doro-auth-modal" hidden aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="doro-auth-modal-title">
    <div class="doro-auth-modal__backdrop" data-auth-modal-close></div>
    <div class="doro-auth-modal__dialog">
        <button type="button" class="doro-auth-modal__close" data-auth-modal-close aria-label="<?php echo esc_attr( $ui( 'doroshopping_ui_auth_close' ) ); ?>">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>

        <div class="doro-auth-modal__brand">
            <img src="<?php echo esc_url( doroshopping_logo_url() ); ?>" alt="<?php bloginfo( 'name' ); ?>">
        </div>

        <h2 id="doro-auth-modal-title" class="doro-auth-modal__title"><?php echo esc_html( $ui( 'doroshopping_ui_auth_welcome' ) ); ?></h2>
        <p class="doro-auth-modal__subtitle"><?php echo esc_html( $ui( 'doroshopping_ui_auth_subtitle' ) ); ?></p>

        <?php
        if ( function_exists( 'doroshopping_render_google_button' ) ) {
            doroshopping_render_google_button( 'modal' );
        }
        ?>

        <div class="doro-auth-modal__divider"><span><?php echo esc_html( $ui( 'doroshopping_ui_auth_or_email' ) ); ?></span></div>

        <form class="doro-auth-modal__form woocommerce-form woocommerce-form-login login" method="post" action="<?php echo esc_url( $account_url ); ?>" novalidate>
            <?php do_action( 'woocommerce_login_form_start' ); ?>

            <label class="doro-auth-modal__label" for="doro-modal-username"><?php echo esc_html( $ui( 'doroshopping_ui_auth_user' ) ); ?></label>
            <input
                type="text"
                class="doro-auth-modal__input input-text"
                name="username"
                id="doro-modal-username"
                autocomplete="username"
                required
                placeholder="<?php echo esc_attr( $ui( 'doroshopping_ui_auth_email_ph' ) ); ?>"
            >

            <label class="doro-auth-modal__label" for="doro-modal-password"><?php echo esc_html( $ui( 'doroshopping_ui_auth_password' ) ); ?></label>
            <input
                type="password"
                class="doro-auth-modal__input input-text"
                name="password"
                id="doro-modal-password"
                autocomplete="current-password"
                required
                placeholder="<?php echo esc_attr( $ui( 'doroshopping_ui_auth_password_ph' ) ); ?>"
            >

            <?php do_action( 'woocommerce_login_form' ); ?>

            <div class="doro-auth-modal__row">
                <label class="doro-auth-modal__remember">
                    <input name="rememberme" type="checkbox" value="forever">
                    <span><?php echo esc_html( $ui( 'doroshopping_ui_auth_remember' ) ); ?></span>
                </label>
                <a class="doro-auth-modal__link" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_auth_forgot' ) ); ?></a>
            </div>

            <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
            <button type="submit" class="doro-auth-modal__submit" name="login" value="<?php echo esc_attr( $ui( 'doroshopping_ui_auth_login' ) ); ?>">
                <?php echo esc_html( $ui( 'doroshopping_ui_auth_login' ) ); ?>
            </button>

            <?php do_action( 'woocommerce_login_form_end' ); ?>
        </form>

        <p class="doro-auth-modal__footer">
            <?php echo esc_html( $ui( 'doroshopping_ui_auth_no_account' ) ); ?>
            <a href="<?php echo esc_url( $register_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_auth_register' ) ); ?></a>
        </p>
    </div>
</div>
