<?php
/**
 * Lost password form — diseño DoroTheme.
 *
 * @package Doroshopping
 */

defined( 'ABSPATH' ) || exit;

$account_url = function_exists( 'doroshopping_get_account_url' ) ? doroshopping_get_account_url() : wc_get_page_permalink( 'myaccount' );

do_action( 'woocommerce_before_lost_password_form' );
?>

<div class="doro-password-page">
	<div class="doro-password-page__card">
		<div class="doro-password-page__brand">
			<img src="<?php echo esc_url( doroshopping_logo_url() ); ?>" alt="<?php bloginfo( 'name' ); ?>">
		</div>

		<h1 class="doro-password-page__title"><?php esc_html_e( '¿Olvidaste tu contraseña?', 'doroshopping' ); ?></h1>
		<p class="doro-password-page__lead">
			<?php esc_html_e( 'Introduce tu correo electrónico y te enviaremos un enlace para restablecerla.', 'doroshopping' ); ?>
		</p>

		<form method="post" class="woocommerce-ResetPassword lost_reset_password doro-password-page__form">
			<p class="woocommerce-form-row form-row">
				<label for="user_login"><?php esc_html_e( 'Correo electrónico', 'doroshopping' ); ?>&nbsp;<span class="required">*</span></label>
				<input class="woocommerce-Input woocommerce-Input--text input-text" type="text" name="user_login" id="user_login" autocomplete="username" required />
			</p>

			<?php do_action( 'woocommerce_lostpassword_form' ); ?>

			<p class="woocommerce-form-row form-row">
				<input type="hidden" name="wc_reset_password" value="true" />
				<button type="submit" class="doro-password-page__submit woocommerce-Button button" value="<?php esc_attr_e( 'Restablecer contraseña', 'doroshopping' ); ?>">
					<?php esc_html_e( 'Restablecer contraseña', 'doroshopping' ); ?>
				</button>
			</p>

			<?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>
		</form>

		<p class="doro-password-page__footer">
			<a href="<?php echo esc_url( $account_url ); ?>"><?php esc_html_e( 'Volver a iniciar sesión', 'doroshopping' ); ?></a>
		</p>
	</div>
</div>

<?php
do_action( 'woocommerce_after_lost_password_form' );
