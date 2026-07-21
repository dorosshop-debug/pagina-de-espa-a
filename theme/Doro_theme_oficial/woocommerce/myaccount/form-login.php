<?php
/**
 * Login / Register form - My Account (logged out)
 *
 * @package Doroshopping
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_customer_login_form' );
?>

<div class="doro-account-page doro-account-page--auth">
    <h1 class="doro-account-page__title"><?php esc_html_e( 'Mi cuenta', 'doroshopping' ); ?></h1>

    <div class="doro-auth" id="customer_login">
        <div class="doro-auth__card">
            <h2><?php esc_html_e( 'Iniciar sesion', 'doroshopping' ); ?></h2>
            <p><?php esc_html_e( 'Accede para ver pedidos, cupones y tu lista de deseos.', 'doroshopping' ); ?></p>

            <form class="woocommerce-form woocommerce-form-login login doro-auth__form" method="post" novalidate>
                <?php do_action( 'woocommerce_login_form_start' ); ?>

                <p class="woocommerce-form-row form-row">
                    <label for="username"><?php esc_html_e( 'Usuario o correo', 'doroshopping' ); ?>&nbsp;<span class="required">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" required />
                </p>

                <p class="woocommerce-form-row form-row">
                    <label for="password"><?php esc_html_e( 'Contrasena', 'doroshopping' ); ?>&nbsp;<span class="required">*</span></label>
                    <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" required />
                </p>

                <?php do_action( 'woocommerce_login_form' ); ?>

                <p class="form-row">
                    <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                        <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" />
                        <span><?php esc_html_e( 'Recuerdame', 'doroshopping' ); ?></span>
                    </label>
                </p>

                <p class="form-row">
                    <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                    <button type="submit" class="woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e( 'Acceder', 'doroshopping' ); ?>">
                        <?php esc_html_e( 'Acceder', 'doroshopping' ); ?>
                    </button>
                </p>

                <p class="woocommerce-LostPassword lost_password doro-auth__meta">
                    <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( '¿Olvidaste tu contrasena?', 'doroshopping' ); ?></a>
                </p>

                <?php do_action( 'woocommerce_login_form_end' ); ?>
            </form>
        </div>

        <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
            <div class="doro-auth__card">
                <h2><?php esc_html_e( 'Crear cuenta', 'doroshopping' ); ?></h2>
                <p><?php esc_html_e( 'Registrate gratis para comprar mas rapido y guardar favoritos.', 'doroshopping' ); ?></p>

                <form method="post" class="woocommerce-form woocommerce-form-register register doro-auth__form" <?php do_action( 'woocommerce_register_form_tag' ); ?> novalidate>
                    <?php do_action( 'woocommerce_register_form_start' ); ?>

                    <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
                        <p class="woocommerce-form-row form-row">
                            <label for="reg_username"><?php esc_html_e( 'Usuario', 'doroshopping' ); ?>&nbsp;<span class="required">*</span></label>
                            <input type="text" class="woocommerce-Input input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" required />
                        </p>
                    <?php endif; ?>

                    <p class="woocommerce-form-row form-row">
                        <label for="reg_email"><?php esc_html_e( 'Correo electronico', 'doroshopping' ); ?>&nbsp;<span class="required">*</span></label>
                        <input type="email" class="woocommerce-Input input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" required />
                    </p>

                    <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
                        <p class="woocommerce-form-row form-row">
                            <label for="reg_password"><?php esc_html_e( 'Contrasena', 'doroshopping' ); ?>&nbsp;<span class="required">*</span></label>
                            <input type="password" class="woocommerce-Input input-text" name="password" id="reg_password" autocomplete="new-password" required />
                        </p>
                    <?php else : ?>
                        <p><?php esc_html_e( 'Se enviara un enlace para definir tu contrasena.', 'doroshopping' ); ?></p>
                    <?php endif; ?>

                    <?php do_action( 'woocommerce_register_form' ); ?>

                    <p class="woocommerce-form-row form-row">
                        <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                        <button type="submit" class="woocommerce-Button woocommerce-button button" name="register" value="<?php esc_attr_e( 'Registrarse', 'doroshopping' ); ?>">
                            <?php esc_html_e( 'Registrarse', 'doroshopping' ); ?>
                        </button>
                    </p>

                    <?php do_action( 'woocommerce_register_form_end' ); ?>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
do_action( 'woocommerce_after_customer_login_form' );
