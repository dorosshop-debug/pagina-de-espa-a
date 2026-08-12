<?php
/**
 * Formularios de soporte y cupones (páginas del tema).
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Email de atención al cliente.
 *
 * @return string
 */
function doroshopping_get_support_email() {
	/**
	 * Filtro del destinatario de soporte.
	 *
	 * @param string $email Email.
	 */
	return (string) apply_filters( 'doroshopping_support_email', 'atencionalcliente@doroshopping.com' );
}

/**
 * URL de WhatsApp (solo usado en Centro de ayuda).
 *
 * Orden: constante DORO_WHATSAPP → Personalizar → filtro.
 * Número internacional sin espacios (ej. 34600000000) o URL wa.me.
 *
 * @return string
 */
function doroshopping_get_whatsapp_url() {
	$raw = '';
	if ( defined( 'DORO_WHATSAPP' ) && DORO_WHATSAPP ) {
		$raw = (string) DORO_WHATSAPP;
	}
	if ( '' === trim( $raw ) ) {
		$raw = trim( (string) get_theme_mod( 'doroshopping_whatsapp', '' ) );
	}
	/**
	 * Filtro del enlace/número de WhatsApp.
	 *
	 * @param string $raw Valor actual.
	 */
	$raw = (string) apply_filters( 'doroshopping_whatsapp', $raw );
	$raw = trim( $raw );
	if ( '' === $raw ) {
		return '';
	}
	if ( preg_match( '#^https?://#i', $raw ) ) {
		return esc_url_raw( $raw );
	}
	$digits = preg_replace( '/\D+/', '', $raw );
	if ( ! $digits ) {
		return '';
	}
	return 'https://wa.me/' . $digits;
}

/**
 * Procesar formulario del Centro de ayuda.
 *
 * @return void
 */
function doroshopping_handle_support_form() {
	$redirect = function_exists( 'doroshopping_get_page_url' )
		? doroshopping_get_page_url( 'centro-de-ayuda' )
		: home_url( '/centro-de-ayuda/' );

	if ( ! isset( $_POST['doroshopping_support_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['doroshopping_support_nonce'] ) ), 'doroshopping_support_form' ) ) {
		wp_safe_redirect( add_query_arg( 'support', 'error', $redirect ) );
		exit;
	}

	if ( function_exists( 'doroshopping_rate_limit' ) && ! doroshopping_rate_limit( 'support_form', 5, HOUR_IN_SECONDS ) ) {
		wp_safe_redirect( add_query_arg( 'support', 'error', $redirect ) );
		exit;
	}

	// Honeypot anti-spam.
	if ( ! empty( $_POST['doro_support_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'support', 'sent', $redirect ) );
		exit;
	}

	$name    = isset( $_POST['support_name'] ) ? sanitize_text_field( wp_unslash( $_POST['support_name'] ) ) : '';
	$email   = isset( $_POST['support_email'] ) ? sanitize_email( wp_unslash( $_POST['support_email'] ) ) : '';
	$phone   = isset( $_POST['support_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['support_phone'] ) ) : '';
	$order   = isset( $_POST['support_order'] ) ? sanitize_text_field( wp_unslash( $_POST['support_order'] ) ) : '';
	$topic   = isset( $_POST['support_topic'] ) ? sanitize_text_field( wp_unslash( $_POST['support_topic'] ) ) : '';
	$message = isset( $_POST['support_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['support_message'] ) ) : '';

	if ( '' === $name || ! is_email( $email ) || '' === $phone || '' === $topic || '' === $message ) {
		wp_safe_redirect( add_query_arg( 'support', 'error', $redirect ) );
		exit;
	}

	$topics = array(
		'pedido'     => __( 'Pedido / seguimiento', 'doroshopping' ),
		'pago'       => __( 'Pago / factura', 'doroshopping' ),
		'envio'      => __( 'Envío / entrega', 'doroshopping' ),
		'devolucion' => __( 'Devolución / reembolso', 'doroshopping' ),
		'producto'   => __( 'Producto / calidad', 'doroshopping' ),
		'cuenta'     => __( 'Cuenta / acceso', 'doroshopping' ),
		'otro'       => __( 'Otro', 'doroshopping' ),
	);
	$topic_label = isset( $topics[ $topic ] ) ? $topics[ $topic ] : $topic;

	$to      = doroshopping_get_support_email();
	$subject = sprintf(
		/* translators: 1: site name, 2: topic */
		'[%1$s] Soporte: %2$s',
		wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ),
		$topic_label
	);

	$body  = "Nombre: {$name}\n";
	$body .= "Email: {$email}\n";
	$body .= "Teléfono: {$phone}\n";
	$body .= 'Pedido: ' . ( $order ? $order : '—' ) . "\n";
	$body .= "Tema: {$topic_label}\n\n";
	$body .= "Mensaje:\n{$message}\n";

	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . sprintf( '%s <%s>', str_replace( array( "\r", "\n", '<', '>' ), '', $name ), $email ),
	);

	$sent = wp_mail( $to, $subject, $body, $headers );

	wp_safe_redirect( add_query_arg( 'support', $sent ? 'sent' : 'error', $redirect ) );
	exit;
}
add_action( 'admin_post_nopriv_doroshopping_support_form', 'doroshopping_handle_support_form' );
add_action( 'admin_post_doroshopping_support_form', 'doroshopping_handle_support_form' );

/**
 * Aplicar cupón desde la página Cupones.
 *
 * @return void
 */
function doroshopping_handle_apply_coupon() {
	$redirect = function_exists( 'doroshopping_get_page_url' )
		? doroshopping_get_page_url( 'cupones' )
		: home_url( '/cupones/' );

	if ( ! isset( $_POST['doroshopping_coupon_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['doroshopping_coupon_nonce'] ) ), 'doroshopping_apply_coupon' ) ) {
		wp_safe_redirect( add_query_arg( 'coupon_error', __( 'Sesión no válida. Inténtalo de nuevo.', 'doroshopping' ), $redirect ) );
		exit;
	}

	if ( function_exists( 'doroshopping_rate_limit' ) && ! doroshopping_rate_limit( 'coupon_apply', 12, 300 ) ) {
		wp_safe_redirect( add_query_arg( 'coupon_error', __( 'Demasiados intentos. Espera unos minutos.', 'doroshopping' ), $redirect ) );
		exit;
	}

	$code = isset( $_POST['coupon_code'] ) ? sanitize_text_field( wp_unslash( $_POST['coupon_code'] ) ) : '';
	$code = trim( $code );
	if ( function_exists( 'wc_format_coupon_code' ) ) {
		$code = wc_format_coupon_code( $code );
		$code = is_string( $code ) ? trim( $code ) : '';
	}

	if ( '' === $code ) {
		wp_safe_redirect( add_query_arg( 'coupon_error', __( 'Introduce un código de cupón.', 'doroshopping' ), $redirect ) );
		exit;
	}

	if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
		wp_safe_redirect( add_query_arg( 'coupon_error', __( 'El carrito no está disponible ahora mismo.', 'doroshopping' ), $redirect ) );
		exit;
	}

	$result = WC()->cart->apply_coupon( $code );
	if ( is_wp_error( $result ) ) {
		wp_safe_redirect(
			add_query_arg(
				array(
					'coupon'       => $code,
					'coupon_error' => $result->get_error_message(),
				),
				$redirect
			)
		);
		exit;
	}

	if ( ! $result ) {
		$notices = function_exists( 'wc_get_notices' ) ? wc_get_notices( 'error' ) : array();
		$msg     = ! empty( $notices[0]['notice'] ) ? wp_strip_all_tags( $notices[0]['notice'] ) : __( 'No se pudo aplicar el cupón.', 'doroshopping' );
		if ( function_exists( 'wc_clear_notices' ) ) {
			wc_clear_notices();
		}
		wp_safe_redirect(
			add_query_arg(
				array(
					'coupon'       => $code,
					'coupon_error' => $msg,
				),
				$redirect
			)
		);
		exit;
	}

	if ( function_exists( 'wc_clear_notices' ) ) {
		wc_clear_notices();
	}

	wp_safe_redirect( add_query_arg( 'coupon_applied', '1', $redirect ) );
	exit;
}
add_action( 'admin_post_nopriv_doroshopping_apply_coupon', 'doroshopping_handle_apply_coupon' );
add_action( 'admin_post_doroshopping_apply_coupon', 'doroshopping_handle_apply_coupon' );
