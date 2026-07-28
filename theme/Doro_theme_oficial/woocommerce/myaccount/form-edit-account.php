<?php
/**
 * Edit account form — diseño DoroTheme.
 *
 * @package Doroshopping
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' );
?>

<section class="doro-account-details">
	<header class="doro-account-section__header">
		<p class="doro-account-section__eyebrow"><?php esc_html_e( 'Mi cuenta', 'doroshopping' ); ?></p>
		<h2 class="doro-account-section__title"><?php esc_html_e( 'Detalles de la cuenta', 'doroshopping' ); ?></h2>
		<p class="doro-account-section__text">
			<?php esc_html_e( 'Actualiza tu información personal y cambia tu contraseña cuando lo necesites.', 'doroshopping' ); ?>
		</p>
	</header>

	<form class="woocommerce-EditAccountForm edit-account doro-account-details__form" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?>>
		<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

		<div class="doro-account-details__grid">
			<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
				<label for="account_first_name"><?php esc_html_e( 'Nombre', 'doroshopping' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" required />
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
				<label for="account_last_name"><?php esc_html_e( 'Apellidos', 'doroshopping' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" required />
			</p>
		</div>

		<p class="woocommerce-form-row form-row">
			<label for="account_display_name"><?php esc_html_e( 'Nombre visible', 'doroshopping' ); ?>&nbsp;<span class="required">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" required />
			<span class="doro-account-details__hint"><?php esc_html_e( 'Así se mostrará tu nombre en la cuenta y en las valoraciones.', 'doroshopping' ); ?></span>
		</p>

		<p class="woocommerce-form-row form-row">
			<label for="account_email"><?php esc_html_e( 'Correo electrónico', 'doroshopping' ); ?>&nbsp;<span class="required">*</span></label>
			<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" required />
		</p>

		<fieldset class="doro-account-details__password">
			<legend><?php esc_html_e( 'Cambio de contraseña', 'doroshopping' ); ?></legend>
			<p class="woocommerce-form-row form-row">
				<label for="password_current"><?php esc_html_e( 'Contraseña actual', 'doroshopping' ); ?></label>
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="current-password" />
				<span class="doro-account-details__hint"><?php esc_html_e( 'Déjalo en blanco para no cambiarla.', 'doroshopping' ); ?></span>
			</p>
			<p class="woocommerce-form-row form-row">
				<label for="password_1"><?php esc_html_e( 'Nueva contraseña', 'doroshopping' ); ?></label>
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="new-password" />
			</p>
			<p class="woocommerce-form-row form-row">
				<label for="password_2"><?php esc_html_e( 'Confirmar nueva contraseña', 'doroshopping' ); ?></label>
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="new-password" />
			</p>
		</fieldset>

		<?php do_action( 'woocommerce_edit_account_form' ); ?>

		<p class="doro-account-details__actions">
			<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
			<button type="submit" class="doro-account-details__submit woocommerce-Button button" name="save_account_details" value="<?php esc_attr_e( 'Guardar cambios', 'doroshopping' ); ?>">
				<?php esc_html_e( 'Guardar cambios', 'doroshopping' ); ?>
			</button>
			<input type="hidden" name="action" value="save_account_details" />
		</p>

		<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
	</form>
</section>

<?php
do_action( 'woocommerce_after_edit_account_form' );
