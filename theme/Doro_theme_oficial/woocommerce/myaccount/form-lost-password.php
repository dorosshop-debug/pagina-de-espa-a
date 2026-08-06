<?php
/**
 * Lost password form — diseño DoroTheme.
 *
 * Textos vía doroshopping_ui_text (Personalizar + packs por idioma).
 *
 * @package Doroshopping
 */

defined( 'ABSPATH' ) || exit;

$ui = static function ( $key ) {
	return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : '';
};

$account_url = function_exists( 'doroshopping_get_account_url' ) ? doroshopping_get_account_url() : wc_get_page_permalink( 'myaccount' );

do_action( 'woocommerce_before_lost_password_form' );
?>

<div class="doro-password-page">
	<div class="doro-password-page__card">
		<div class="doro-password-page__brand">
			<img src="<?php echo esc_url( doroshopping_logo_url() ); ?>" alt="<?php bloginfo( 'name' ); ?>">
		</div>

		<h1 class="doro-password-page__title"><?php echo esc_html( $ui( 'doroshopping_ui_auth_lost_title' ) ); ?></h1>
		<p class="doro-password-page__lead">
			<?php echo esc_html( $ui( 'doroshopping_ui_auth_lost_lead' ) ); ?>
		</p>

		<form method="post" class="woocommerce-ResetPassword lost_reset_password doro-password-page__form">
			<p class="woocommerce-form-row form-row">
				<label for="user_login"><?php echo esc_html( $ui( 'doroshopping_ui_auth_lost_email' ) ); ?>&nbsp;<span class="required">*</span></label>
				<input class="woocommerce-Input woocommerce-Input--text input-text" type="text" name="user_login" id="user_login" autocomplete="username" required />
			</p>

			<?php do_action( 'woocommerce_lostpassword_form' ); ?>

			<p class="woocommerce-form-row form-row">
				<input type="hidden" name="wc_reset_password" value="true" />
				<button type="submit" class="doro-password-page__submit woocommerce-Button button" value="<?php echo esc_attr( $ui( 'doroshopping_ui_auth_lost_submit' ) ); ?>">
					<?php echo esc_html( $ui( 'doroshopping_ui_auth_lost_submit' ) ); ?>
				</button>
			</p>

			<?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>
		</form>

		<p class="doro-password-page__footer">
			<a href="<?php echo esc_url( $account_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_auth_lost_back' ) ); ?></a>
		</p>
	</div>
</div>

<?php
do_action( 'woocommerce_after_lost_password_form' );
