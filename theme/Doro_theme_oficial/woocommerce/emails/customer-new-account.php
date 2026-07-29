<?php
/**
 * Customer new account email (override Doro).
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-new-account.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package Doroshopping
 * @version 1.8.7
 */

defined( 'ABSPATH' ) || exit;

$user_login = isset( $user_login ) ? $user_login : '';
$blogname   = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
$account    = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : home_url( '/' );

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email );
?>

<p>
<?php
printf(
	/* translators: %s: Customer username */
	esc_html__( 'Hola %s,', 'doroshopping' ),
	esc_html( $user_login )
);
?>
</p>

<p>
<?php
printf(
	/* translators: %s: Site title */
	esc_html__( 'Gracias por crear una cuenta en %s. Ya puedes comprar más rápido, guardar direcciones y seguir tus pedidos.', 'doroshopping' ),
	esc_html( $blogname )
);
?>
</p>

<div class="doro-email-card">
	<strong><?php esc_html_e( 'Nombre de usuario', 'doroshopping' ); ?></strong>
	<span><?php echo esc_html( $user_login ); ?></span>
</div>

<p>
	<a class="doro-email-btn" href="<?php echo esc_url( $account ); ?>">
		<?php esc_html_e( 'Ir a Mi cuenta', 'doroshopping' ); ?>
	</a>
</p>

<p class="doro-email-muted">
	<?php esc_html_e( 'Desde Mi cuenta puedes ver pedidos, cambiar tu contraseña y actualizar tus datos.', 'doroshopping' ); ?>
</p>

<p><?php esc_html_e( '¡Esperamos verte pronto!', 'doroshopping' ); ?></p>

<?php
/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( ! empty( $additional_content ) ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
