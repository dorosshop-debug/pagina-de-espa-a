<?php
/**
 * Reset / establecer contraseña — diseño DoroTheme.
 *
 * Usado tras registro por correo o enlace de recuperación.
 *
 * @package Doroshopping
 */

defined( 'ABSPATH' ) || exit;

$account_url = function_exists( 'doroshopping_get_account_url' ) ? doroshopping_get_account_url() : wc_get_page_permalink( 'myaccount' );
$is_new_user = isset( $_GET['action'] ) && 'newaccount' === sanitize_key( wp_unslash( $_GET['action'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

do_action( 'woocommerce_before_reset_password_form' );
?>

<div class="doro-password-page doro-password-page--reset">
	<div class="doro-password-page__card">
		<div class="doro-password-page__brand">
			<img src="<?php echo esc_url( doroshopping_logo_url() ); ?>" alt="<?php bloginfo( 'name' ); ?>">
		</div>

		<p class="doro-password-page__eyebrow"><?php esc_html_e( 'Seguridad de la cuenta', 'doroshopping' ); ?></p>
		<h1 class="doro-password-page__title">
			<?php echo $is_new_user ? esc_html__( 'Crea tu contraseña', 'doroshopping' ) : esc_html__( 'Establece una nueva contraseña', 'doroshopping' ); ?>
		</h1>
		<p class="doro-password-page__lead">
			<?php
			echo $is_new_user
				? esc_html__( 'Tu cuenta está casi lista. Elige una contraseña segura para acceder a tus pedidos y favoritos.', 'doroshopping' )
				: esc_html__( 'Introduce y confirma tu nueva contraseña para continuar.', 'doroshopping' );
			?>
		</p>

		<form method="post" class="woocommerce-ResetPassword lost_reset_password doro-password-page__form">
			<p class="woocommerce-form-row form-row">
				<label for="password_1"><?php esc_html_e( 'Nueva contraseña', 'doroshopping' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password_1" id="password_1" autocomplete="new-password" required />
			</p>
			<p class="woocommerce-form-row form-row">
				<label for="password_2"><?php esc_html_e( 'Confirmar contraseña', 'doroshopping' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password_2" id="password_2" autocomplete="new-password" required />
			</p>

			<input type="hidden" name="reset_key" value="<?php echo esc_attr( $args['key'] ); ?>" />
			<input type="hidden" name="reset_login" value="<?php echo esc_attr( $args['login'] ); ?>" />
			<input type="hidden" name="wc_reset_password" value="true" />

			<?php do_action( 'woocommerce_resetpassword_form' ); ?>

			<p class="woocommerce-form-row form-row">
				<button type="submit" class="doro-password-page__submit woocommerce-Button button" value="<?php esc_attr_e( 'Guardar contraseña', 'doroshopping' ); ?>">
					<?php esc_html_e( 'Guardar contraseña', 'doroshopping' ); ?>
				</button>
			</p>

			<?php wp_nonce_field( 'reset_password', 'woocommerce-reset-password-nonce' ); ?>
		</form>

		<p class="doro-password-page__footer">
			<a href="<?php echo esc_url( $account_url ); ?>"><?php esc_html_e( 'Ir a iniciar sesión', 'doroshopping' ); ?></a>
		</p>
	</div>
</div>

<?php
do_action( 'woocommerce_after_reset_password_form' );
