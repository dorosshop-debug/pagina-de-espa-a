<?php
/**
 * Endurecimiento del tema (tienda WooCommerce).
 *
 * Capas:
 * - Cabeceras HTTP defensivas
 * - Rate limiting de AJAX/REST públicos
 * - Reducción de huella / enumeración
 * - Helpers para cookies seguras
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Evita editar temas/plugins desde el admin (si no esta definido en wp-config).
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
	define( 'DISALLOW_FILE_EDIT', true );
}

/**
 * Cabeceras HTTP defensivas en el front.
 *
 * @return void
 */
function doroshopping_security_headers() {
	if ( is_admin() || headers_sent() ) {
		return;
	}

	header( 'X-Content-Type-Options: nosniff' );
	header( 'X-Frame-Options: SAMEORIGIN' );
	header( 'Referrer-Policy: strict-origin-when-cross-origin' );
	header( 'Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=()' );
	header( 'Cross-Origin-Opener-Policy: same-origin-allow-popups' );
}
add_action( 'send_headers', 'doroshopping_security_headers' );

/**
 * Reduce huella en <head>.
 *
 * @return void
 */
function doroshopping_security_cleanup_head() {
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
}
add_action( 'after_setup_theme', 'doroshopping_security_cleanup_head' );

/**
 * No exponer la version de WordPress en el generador RSS.
 *
 * @return string
 */
function doroshopping_remove_version_rss() {
	return '';
}
add_filter( 'the_generator', 'doroshopping_remove_version_rss' );

/**
 * Evita enumeracion simple de autores por ?author=N en el front.
 *
 * @return void
 */
function doroshopping_block_author_enumeration() {
	if ( is_admin() || ! isset( $_GET['author'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return;
	}

	$author = (string) wp_unslash( $_GET['author'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( ! preg_match( '/^\d+$/', $author ) ) {
		return;
	}

	wp_safe_redirect( home_url( '/' ), 301 );
	exit;
}
add_action( 'template_redirect', 'doroshopping_block_author_enumeration', 1 );

/**
 * IP del cliente para rate limiting (prioriza REMOTE_ADDR; CF solo si hay cabecera CF).
 *
 * @return string
 */
function doroshopping_security_client_ip() {
	$ip = '';

	// Cloudflare: confiable cuando el sitio está detrás de CF.
	if ( ! empty( $_SERVER['HTTP_CF_CONNECTING_IP'] ) && ! empty( $_SERVER['HTTP_CF_RAY'] ) ) {
		$candidate = sanitize_text_field( wp_unslash( $_SERVER['HTTP_CF_CONNECTING_IP'] ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		if ( filter_var( $candidate, FILTER_VALIDATE_IP ) ) {
			$ip = $candidate;
		}
	}

	if ( ! $ip && ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
		$candidate = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		if ( filter_var( $candidate, FILTER_VALIDATE_IP ) ) {
			$ip = $candidate;
		}
	}

	/**
	 * @param string $ip IP.
	 */
	return (string) apply_filters( 'doroshopping_security_client_ip', $ip );
}

/**
 * Rate limit simple por acción + IP (transients).
 *
 * @param string $action  Clave de acción (ej. live_search).
 * @param int    $limit   Máximo de peticiones.
 * @param int    $window  Ventana en segundos.
 * @return bool True si permitido; false si excedido.
 */
function doroshopping_rate_limit( $action, $limit = 30, $window = 60 ) {
	$action = sanitize_key( (string) $action );
	$limit  = max( 1, (int) $limit );
	$window = max( 10, (int) $window );
	$ip     = doroshopping_security_client_ip();
	if ( ! $ip ) {
		$ip = 'unknown';
	}

	$key   = 'doro_rl_' . md5( $action . '|' . $ip );
	$count = (int) get_transient( $key );

	if ( $count >= $limit ) {
		/**
		 * @param string $action Action.
		 * @param string $ip     IP.
		 * @param int    $count  Count.
		 */
		do_action( 'doroshopping_rate_limit_hit', $action, $ip, $count );
		return false;
	}

	set_transient( $key, $count + 1, $window );
	return true;
}

/**
 * Responder 429 en AJAX.
 *
 * @param string $message Message.
 * @return void
 */
function doroshopping_rate_limit_ajax_block( $message = '' ) {
	if ( ! $message ) {
		$message = __( 'Demasiadas peticiones. Espera un momento e inténtalo de nuevo.', 'doroshopping' );
	}
	wp_send_json_error( array( 'message' => $message ), 429 );
}

/**
 * Cookie segura (Secure + SameSite). HttpOnly opcional (false si JS debe leerla).
 *
 * @param string $name     Nombre.
 * @param string $value    Valor.
 * @param int    $expires  Timestamp.
 * @param bool   $http_only HttpOnly.
 * @return void
 */
function doroshopping_set_cookie( $name, $value, $expires, $http_only = false ) {
	$name  = (string) $name;
	$value = (string) $value;
	$path  = defined( 'COOKIEPATH' ) && COOKIEPATH ? COOKIEPATH : '/';
	$domain = defined( 'COOKIE_DOMAIN' ) ? (string) COOKIE_DOMAIN : '';

	$options = array(
		'expires'  => (int) $expires,
		'path'     => $path,
		'domain'   => $domain,
		'secure'   => is_ssl(),
		'httponly' => (bool) $http_only,
		'samesite' => 'Lax',
	);

	// phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.cookies_setcookie
	setcookie( $name, $value, $options );
	$_COOKIE[ $name ] = $value;
}

/**
 * Quitar cookie.
 *
 * @param string $name Name.
 * @return void
 */
function doroshopping_clear_cookie( $name ) {
	doroshopping_set_cookie( $name, '', time() - YEAR_IN_SECONDS, false );
	unset( $_COOKIE[ $name ] );
}

/**
 * Hash de IP para logs (no guardar IP en claro).
 *
 * @param string $ip IP.
 * @return string
 */
function doroshopping_security_ip_hash( $ip ) {
	$ip = (string) $ip;
	if ( '' === $ip ) {
		return 'unknown';
	}
	return substr( hash_hmac( 'sha256', $ip, wp_salt( 'auth' ) ), 0, 16 );
}

/**
 * Registrar abuso (rate limit / CSP) con debounce.
 *
 * @param string               $action  Acción.
 * @param string               $ip      IP (se hashea).
 * @param int                  $count   Contador.
 * @param array<string,mixed>  $context Extra.
 * @return void
 */
function doroshopping_log_abuse( $action, $ip = '', $count = 0, $context = array() ) {
	$action = sanitize_key( (string) $action );
	if ( ! $action ) {
		return;
	}

	$ip      = $ip ? (string) $ip : doroshopping_security_client_ip();
	$ip_hash = doroshopping_security_ip_hash( $ip );
	$count   = (int) $count;

	// Evitar flood de logs (1 entrada / 5 min por acción+IP).
	$debounce = 'doro_abuse_log_' . md5( $action . '|' . $ip_hash );
	if ( get_transient( $debounce ) ) {
		return;
	}
	set_transient( $debounce, 1, 5 * MINUTE_IN_SECONDS );

	$ua = isset( $_SERVER['HTTP_USER_AGENT'] ) ? substr( sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ), 0, 180 ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
	$uri = isset( $_SERVER['REQUEST_URI'] ) ? substr( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ), 0, 180 ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput

	$extra = '';
	if ( ! empty( $context ) && is_array( $context ) ) {
		$safe = array();
		foreach ( $context as $k => $v ) {
			$safe[ sanitize_key( (string) $k ) ] = is_scalar( $v ) ? substr( sanitize_text_field( (string) $v ), 0, 80 ) : '';
		}
		$encoded = wp_json_encode( $safe );
		if ( $encoded ) {
			$extra = ' ctx=' . $encoded;
		}
	}

	$line = sprintf(
		'[Doro abuse] action=%s ip_hash=%s count=%d ua="%s" uri="%s"%s',
		$action,
		$ip_hash,
		$count,
		str_replace( '"', '', $ua ),
		str_replace( '"', '', $uri ),
		$extra
	);

	// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
	error_log( $line );

	if ( function_exists( 'wc_get_logger' ) ) {
		$logger = wc_get_logger();
		$logger->warning(
			$line,
			array(
				'source' => 'doroshopping-abuse',
			)
		);
	}

	/**
	 * @param string              $action  Action.
	 * @param string              $ip_hash Hashed IP.
	 * @param int                 $count   Count.
	 * @param array<string,mixed> $context Context.
	 */
	do_action( 'doroshopping_abuse_logged', $action, $ip_hash, $count, is_array( $context ) ? $context : array() );
}

/**
 * Hook: rate limit superado → log de abuso.
 *
 * @param string $action Action.
 * @param string $ip     IP.
 * @param int    $count  Count.
 * @return void
 */
function doroshopping_on_rate_limit_hit( $action, $ip, $count ) {
	doroshopping_log_abuse( (string) $action, (string) $ip, (int) $count );
}
add_action( 'doroshopping_rate_limit_hit', 'doroshopping_on_rate_limit_hit', 10, 3 );

/**
 * Política CSP permisiva (solo Report-Only: no bloquea nada).
 *
 * Pensada para convivir con Elementor, pasarelas, Google Fonts/Login, analytics.
 *
 * @return string
 */
function doroshopping_csp_report_only_policy() {
	$parts = array(
		"default-src 'self' https: data: blob:",
		"script-src 'self' 'unsafe-inline' 'unsafe-eval' https: blob:",
		"style-src 'self' 'unsafe-inline' https: data:",
		"img-src 'self' https: data: blob:",
		"font-src 'self' https: data:",
		"connect-src 'self' https: wss: blob:",
		"frame-src 'self' https:",
		"frame-ancestors 'self'",
		"worker-src 'self' blob: https:",
		"media-src 'self' https: data: blob:",
		"object-src 'none'",
		"base-uri 'self'",
		"form-action 'self' https:",
	);

	/**
	 * @param string[] $parts Directive list.
	 */
	$parts = apply_filters( 'doroshopping_csp_report_only_parts', $parts );
	if ( ! is_array( $parts ) ) {
		$parts = array();
	}

	$policy = implode( '; ', array_filter( array_map( 'strval', $parts ) ) );

	/**
	 * @param string $policy Full policy string.
	 */
	return (string) apply_filters( 'doroshopping_csp_report_only_policy', $policy );
}

/**
 * Enviar Content-Security-Policy-Report-Only (no enforce).
 *
 * @return void
 */
function doroshopping_send_csp_report_only() {
	if ( headers_sent() ) {
		return;
	}

	// Solo front (incluye preview de Elementor en el iframe del sitio).
	if ( is_admin() && ! wp_doing_ajax() ) {
		return;
	}

	/**
	 * Desactivar: add_filter( 'doroshopping_csp_report_only', '__return_false' );
	 *
	 * @param bool $enabled Enabled.
	 */
	if ( ! apply_filters( 'doroshopping_csp_report_only', true ) ) {
		return;
	}

	$policy = doroshopping_csp_report_only_policy();
	if ( '' === trim( $policy ) ) {
		return;
	}

	header( 'Content-Security-Policy-Report-Only: ' . $policy, false );
}
add_action( 'send_headers', 'doroshopping_send_csp_report_only', 20 );

/**
 * ¿Debe aplicarse rate limit a un POST de preferencias?
 * Límites holgados para no afectar usuarios reales.
 *
 * @param string $action locale_prefs|shipping_prefs.
 * @return bool True si se permite continuar.
 */
function doroshopping_prefs_rate_limit_ok( $action ) {
	$action = sanitize_key( (string) $action );
	if ( ! function_exists( 'doroshopping_rate_limit' ) ) {
		return true;
	}

	// 30 cambios / 5 minutos por IP (idioma, país, dirección…).
	$limit  = (int) apply_filters( 'doroshopping_prefs_rate_limit', 30, $action );
	$window = (int) apply_filters( 'doroshopping_prefs_rate_window', 5 * MINUTE_IN_SECONDS, $action );

	return doroshopping_rate_limit( $action, max( 5, $limit ), max( 60, $window ) );
}
