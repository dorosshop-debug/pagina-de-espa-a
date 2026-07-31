<?php
/**
 * Reset / establecer contraseña — diseño DoroTheme.
 *
 * Usado tras registro por correo o enlace de recuperación.
 *
 * @package Doroshopping
 */

defined( 'ABSPATH' ) || exit;

$ui = static function ( $key ) {
	return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : '';
};

$account_url = function_exists( 'doroshopping_get_account_url' ) ? doroshopping_get_account_url() : wc_get_page_permalink( 'myaccount' );
$is_new_user = isset( $_GET['action'] ) && 'newaccount' === sanitize_key( wp_unslash( $_GET['action'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

do_action( 'woocommerce_before_reset_password_form' );
?>

<div class="doro-password-page doro-password-page--reset">
	<div class="doro-password-page__card">
		<div class="doro-password-page__brand">
			<img src="<?php echo esc_url( doroshopping_logo_url() ); ?>" alt="<?php bloginfo( 'name' ); ?>">
		</div>

		<p class="doro-password-page__eyebrow"><?php echo esc_html( $ui( 'doroshopping_ui_acc_pw_security' ) ); ?></p>
		<h1 class="doro-password-page__title">
			<?php echo $is_new_user ? esc_html( $ui( 'doroshopping_ui_acc_pw_create' ) ) : esc_html( $ui( 'doroshopping_ui_acc_pw_set' ) ); ?>
		</h1>
		<p class="doro-password-page__lead">
			<?php
			echo $is_new_user
				? esc_html( $ui( 'doroshopping_ui_acc_pw_create_lead' ) )
				: esc_html( $ui( 'doroshopping_ui_acc_pw_set_lead' ) );
			?>
		</p>

		<form method="post" class="woocommerce-ResetPassword lost_reset_password doro-password-page__form">
			<p class="woocommerce-form-row form-row">
				<label for="password_1"><?php echo esc_html( $ui( 'doroshopping_ui_acc_pw_new' ) ); ?>&nbsp;<span class="required">*</span></label>
				<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password_1" id="password_1" autocomplete="new-password" required />
			</p>
			<p class="woocommerce-form-row form-row">
				<label for="password_2"><?php echo esc_html( $ui( 'doroshopping_ui_acc_pw_confirm' ) ); ?>&nbsp;<span class="required">*</span></label>
				<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password_2" id="password_2" autocomplete="new-password" required />
			</p>

			<input type="hidden" name="reset_key" value="<?php echo esc_attr( $args['key'] ); ?>" />
			<input type="hidden" name="reset_login" value="<?php echo esc_attr( $args['login'] ); ?>" />
			<input type="hidden" name="wc_reset_password" value="true" />

			<?php do_action( 'woocommerce_resetpassword_form' ); ?>

			<p class="woocommerce-form-row form-row">
				<button type="submit" class="doro-password-page__submit woocommerce-Button button" value="<?php echo esc_attr( $ui( 'doroshopping_ui_acc_pw_save' ) ); ?>">
					<?php echo esc_html( $ui( 'doroshopping_ui_acc_pw_save' ) ); ?>
				</button>
			</p>

			<?php wp_nonce_field( 'reset_password', 'woocommerce-reset-password-nonce' ); ?>
		</form>

		<p class="doro-password-page__footer">
			<a href="<?php echo esc_url( $account_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_acc_pw_login' ) ); ?></a>
		</p>
	</div>
</div>

<?php
do_action( 'woocommerce_after_reset_password_form' );
