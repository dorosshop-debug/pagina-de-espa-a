<?php
/**
 * Login (tarjeta) / Registro (pantalla completa) — estilo AliExpress.
 *
 * @package Doroshopping
 */

defined( 'ABSPATH' ) || exit;

$is_register  = function_exists( 'doroshopping_is_register_view' ) && doroshopping_is_register_view();
$account_url  = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : home_url( '/' );
$register_url = function_exists( 'doroshopping_get_register_url' ) ? doroshopping_get_register_url() : $account_url;
$reg_enabled  = 'yes' === get_option( 'woocommerce_enable_myaccount_registration' );

$register_image = function_exists( 'doroshopping_get_theme_image_url' )
    ? doroshopping_get_theme_image_url( 'register_image', get_template_directory_uri() . '/assets/images/banners/Banner_mundial_doro.webp' )
    : get_template_directory_uri() . '/assets/images/banners/Banner_mundial_doro.webp';

do_action( 'woocommerce_before_customer_login_form' );
?>

<?php if ( $is_register && $reg_enabled ) : ?>

<section class="doro-register-page" id="customer_login">
    <aside class="doro-register-page__visual" aria-hidden="true">
        <img class="doro-register-page__visual-img" src="<?php echo esc_url( $register_image ); ?>" alt="">
        <div class="doro-register-page__visual-copy">
            <p><?php esc_html_e( 'Únete a Doroshopping y compra con confianza.', 'doroshopping' ); ?></p>
        </div>
    </aside>

    <div class="doro-register-page__panel">
        <div class="doro-register-page__panel-inner">
            <div class="doro-register-page__brand">
                <img src="<?php echo esc_url( doroshopping_logo_url() ); ?>" alt="<?php bloginfo( 'name' ); ?>">
            </div>

            <h1 class="doro-register-page__title">
                <?php esc_html_e( 'Registro', 'doroshopping' ); ?>
                <span class="doro-register-page__check" aria-hidden="true">✓</span>
            </h1>

            <form method="post" class="woocommerce-form woocommerce-form-register register doro-register-page__form" id="doro-register-form" <?php do_action( 'woocommerce_register_form_tag' ); ?> novalidate>
                <?php do_action( 'woocommerce_register_form_start' ); ?>

                <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
                    <p class="woocommerce-form-row form-row">
                        <label for="reg_username"><?php esc_html_e( 'Usuario', 'doroshopping' ); ?>&nbsp;<span class="required">*</span></label>
                        <input type="text" class="woocommerce-Input input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" required />
                    </p>
                <?php endif; ?>

                <p class="woocommerce-form-row form-row">
                    <label for="reg_email"><?php esc_html_e( 'Correo electrónico', 'doroshopping' ); ?>&nbsp;<span class="required">*</span></label>
                    <input type="email" class="woocommerce-Input input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" required />
                </p>

                <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
                    <p class="woocommerce-form-row form-row">
                        <label for="reg_password"><?php esc_html_e( 'Contraseña', 'doroshopping' ); ?>&nbsp;<span class="required">*</span></label>
                        <input type="password" class="woocommerce-Input input-text" name="password" id="reg_password" autocomplete="new-password" required />
                    </p>
                <?php else : ?>
                    <p class="doro-register-page__hint"><?php esc_html_e( 'Te enviaremos un enlace para definir tu contraseña.', 'doroshopping' ); ?></p>
                <?php endif; ?>

                <?php do_action( 'woocommerce_register_form' ); ?>

                <p class="woocommerce-form-row form-row">
                    <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                    <button type="submit" class="doro-register-page__submit woocommerce-Button woocommerce-button button" name="register" value="<?php esc_attr_e( 'Regístrate', 'doroshopping' ); ?>">
                        <?php esc_html_e( 'Regístrate', 'doroshopping' ); ?>
                    </button>
                </p>

                <?php do_action( 'woocommerce_register_form_end' ); ?>
            </form>

            <button type="button" class="doro-register-page__login-btn" data-auth-modal-open>
                <?php esc_html_e( '¿Ya tienes una cuenta?', 'doroshopping' ); ?>
            </button>

            <div class="doro-auth-modal__divider"><span><?php esc_html_e( 'Acceso rápido con', 'doroshopping' ); ?></span></div>

            <?php
            if ( function_exists( 'doroshopping_render_google_button' ) ) {
                doroshopping_render_google_button( 'register' );
            }
            ?>

            <p class="doro-register-page__legal">
                <?php
                echo wp_kses_post(
                    sprintf(
                        /* translators: 1: terms url, 2: privacy url */
                        __( 'Al continuar aceptas los <a href="%1$s">Términos</a> y la <a href="%2$s">Política de privacidad</a>.', 'doroshopping' ),
                        esc_url( doroshopping_get_page_url( 'terminos-y-condiciones' ) ),
                        esc_url( doroshopping_get_page_url( 'politica-de-privacidad' ) )
                    )
                );
                ?>
            </p>
        </div>
    </div>
</section>

<?php else : ?>

<div class="doro-login-page" id="customer_login">
    <div class="doro-login-page__card">
        <div class="doro-login-page__brand">
            <img src="<?php echo esc_url( doroshopping_logo_url() ); ?>" alt="<?php bloginfo( 'name' ); ?>">
        </div>
        <h1 class="doro-login-page__title"><?php esc_html_e( '¡Bienvenido!', 'doroshopping' ); ?></h1>
        <p class="doro-login-page__lead"><?php esc_html_e( 'Inicia sesión para continuar.', 'doroshopping' ); ?></p>

        <?php
        if ( function_exists( 'doroshopping_render_google_button' ) ) {
            doroshopping_render_google_button( 'page' );
        }
        ?>

        <div class="doro-auth-modal__divider"><span><?php esc_html_e( 'o con tu correo', 'doroshopping' ); ?></span></div>

        <form class="woocommerce-form woocommerce-form-login login doro-login-page__form" method="post" novalidate>
            <?php do_action( 'woocommerce_login_form_start' ); ?>

            <p class="woocommerce-form-row form-row">
                <label for="username"><?php esc_html_e( 'Correo o usuario', 'doroshopping' ); ?>&nbsp;<span class="required">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" required />
            </p>

            <p class="woocommerce-form-row form-row">
                <label for="password"><?php esc_html_e( 'Contraseña', 'doroshopping' ); ?>&nbsp;<span class="required">*</span></label>
                <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" required />
            </p>

            <?php do_action( 'woocommerce_login_form' ); ?>

            <p class="doro-login-page__row form-row">
                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                    <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" />
                    <span><?php esc_html_e( 'Recuérdame', 'doroshopping' ); ?></span>
                </label>
                <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( '¿Olvidaste tu contraseña?', 'doroshopping' ); ?></a>
            </p>

            <p class="form-row">
                <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                <button type="submit" class="doro-login-page__submit woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e( 'Iniciar sesión', 'doroshopping' ); ?>">
                    <?php esc_html_e( 'Iniciar sesión', 'doroshopping' ); ?>
                </button>
            </p>

            <?php do_action( 'woocommerce_login_form_end' ); ?>
        </form>

        <?php if ( $reg_enabled ) : ?>
            <p class="doro-login-page__footer">
                <?php esc_html_e( '¿No tienes cuenta?', 'doroshopping' ); ?>
                <a href="<?php echo esc_url( $register_url ); ?>"><?php esc_html_e( 'Regístrate', 'doroshopping' ); ?></a>
            </p>
        <?php endif; ?>
    </div>
</div>

<?php endif; ?>

<?php
do_action( 'woocommerce_after_customer_login_form' );
