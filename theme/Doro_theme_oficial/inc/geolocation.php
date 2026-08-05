<?php
/**
 * Geolocalización ligera (país por IP) + aviso suave.
 *
 * Puerta abierta a plugins:
 * - Filter `doroshopping_detect_country` — devolver ISO2 (ej. "FR") y el tema no llama a su API.
 * - Filter `doroshopping_geo_enabled` — desactivar todo el sistema.
 * - Filter `doroshopping_geo_client_ip` — IP del visitante.
 * - Filter `doroshopping_geo_supported_countries` — países del aviso.
 * - Filter `doroshopping_geo_should_suggest` — si mostrar el banner.
 * - Action `doroshopping_geo_country_accepted` — tras aceptar (país ISO2).
 * - Action `doroshopping_geo_country_dismissed` — tras descartar.
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ¿Está activo el geo del tema?
 *
 * @return bool
 */
function doroshopping_geo_enabled() {
	$enabled = (bool) get_theme_mod( 'doroshopping_geo_suggest', true );
	return (bool) apply_filters( 'doroshopping_geo_enabled', $enabled );
}

/**
 * Países soportados para sugerencia (ISO2).
 *
 * @return string[]
 */
function doroshopping_geo_supported_countries() {
	$countries = array( 'ES', 'PT', 'FR', 'DE', 'IT', 'GB', 'CH' );
	$filtered  = apply_filters( 'doroshopping_geo_supported_countries', $countries );
	if ( ! is_array( $filtered ) ) {
		return $countries;
	}
	return array_values(
		array_filter(
			array_map(
				static function ( $code ) {
					$code = strtoupper( sanitize_text_field( (string) $code ) );
					if ( 'UK' === $code ) {
						$code = 'GB';
					}
					return ( 2 === strlen( $code ) ) ? $code : '';
				},
				$filtered
			)
		)
	);
}

/**
 * Normalizar código de país.
 *
 * @param string $code Code.
 * @return string
 */
function doroshopping_geo_normalize_country( $code ) {
	$code = strtoupper( sanitize_text_field( (string) $code ) );
	$code = substr( $code, 0, 2 );
	if ( 'UK' === $code ) {
		$code = 'GB';
	}
	return ( 2 === strlen( $code ) && ctype_alpha( $code ) ) ? $code : '';
}

/**
 * IP del visitante (sin privados).
 *
 * @return string
 */
function doroshopping_geo_client_ip() {
	// Reutilizar helper de seguridad (no confiar en X-Forwarded-For genérico).
	if ( function_exists( 'doroshopping_security_client_ip' ) ) {
		$ip = doroshopping_security_client_ip();
		return (string) apply_filters( 'doroshopping_geo_client_ip', $ip );
	}

	$candidates = array();
	if ( ! empty( $_SERVER['HTTP_CF_CONNECTING_IP'] ) && ! empty( $_SERVER['HTTP_CF_RAY'] ) ) {
		$candidates[] = wp_unslash( $_SERVER['HTTP_CF_CONNECTING_IP'] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
	}
	if ( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
		$candidates[] = wp_unslash( $_SERVER['REMOTE_ADDR'] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
	}

	$ip = '';
	foreach ( $candidates as $raw ) {
		$raw = sanitize_text_field( (string) $raw );
		if ( filter_var( $raw, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE ) ) {
			$ip = $raw;
			break;
		}
	}

	return (string) apply_filters( 'doroshopping_geo_client_ip', $ip );
}

/**
 * Preferencia de país ya confirmada (cookie).
 *
 * @return string
 */
function doroshopping_geo_preferred_country() {
	if ( empty( $_COOKIE['doroshopping_country'] ) ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		return '';
	}
	return doroshopping_geo_normalize_country( wp_unslash( $_COOKIE['doroshopping_country'] ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
}

/**
 * ¿El visitante descartó el aviso?
 *
 * @return bool
 */
function doroshopping_geo_is_dismissed() {
	if ( empty( $_COOKIE['doroshopping_geo_dismiss'] ) ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		return false;
	}
	$val = sanitize_text_field( wp_unslash( $_COOKIE['doroshopping_geo_dismiss'] ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
	return '' !== $val;
}

/**
 * Path/domain cookies del tema.
 *
 * @return array{path:string,domain:string}
 */
function doroshopping_geo_cookie_args() {
	return array(
		'path'   => defined( 'COOKIEPATH' ) && COOKIEPATH ? COOKIEPATH : '/',
		'domain' => defined( 'COOKIE_DOMAIN' ) ? (string) COOKIE_DOMAIN : '',
	);
}

/**
 * Guardar cookie de país.
 *
 * @param string $country ISO2.
 * @return void
 */
function doroshopping_geo_set_country_cookie( $country ) {
	$country = doroshopping_geo_normalize_country( $country );
	if ( ! $country ) {
		return;
	}
	if ( function_exists( 'doroshopping_set_cookie' ) ) {
		doroshopping_set_cookie( 'doroshopping_country', $country, time() + YEAR_IN_SECONDS, false );
		return;
	}
	$args = doroshopping_geo_cookie_args();
	setcookie( 'doroshopping_country', $country, time() + YEAR_IN_SECONDS, $args['path'], $args['domain'], is_ssl(), false );
	$_COOKIE['doroshopping_country'] = $country;
}

/**
 * Descartar aviso (30 días).
 *
 * @return void
 */
function doroshopping_geo_set_dismiss_cookie() {
	if ( function_exists( 'doroshopping_set_cookie' ) ) {
		doroshopping_set_cookie( 'doroshopping_geo_dismiss', '1', time() + ( DAY_IN_SECONDS * 30 ), false );
		return;
	}
	$args = doroshopping_geo_cookie_args();
	setcookie( 'doroshopping_geo_dismiss', '1', time() + ( DAY_IN_SECONDS * 30 ), $args['path'], $args['domain'], is_ssl(), false );
	$_COOKIE['doroshopping_geo_dismiss'] = '1';
}

/**
 * Lookup IP vía API ligera (solo si no hay plugin).
 *
 * @param string $ip IP.
 * @return string ISO2 o vacío.
 */
function doroshopping_geo_lookup_ip_country( $ip ) {
	$ip = sanitize_text_field( (string) $ip );
	if ( ! $ip ) {
		return '';
	}

	$cache_key = 'doro_geo_' . md5( $ip );
	$cached    = get_transient( $cache_key );
	if ( false !== $cached ) {
		return doroshopping_geo_normalize_country( (string) $cached );
	}

	/**
	 * Permite a un plugin sustituir la consulta remota.
	 * Devolver ISO2 o '' (string vacío = “sin resultado, no uses API del tema”).
	 * Devolver null para dejar que el tema consulte.
	 *
	 * @param string|null $country Country or null to continue.
	 * @param string      $ip      IP.
	 */
	$from_plugin = apply_filters( 'doroshopping_geo_lookup_ip', null, $ip );
	if ( null !== $from_plugin ) {
		$code = doroshopping_geo_normalize_country( (string) $from_plugin );
		set_transient( $cache_key, $code ? $code : '-', WEEK_IN_SECONDS );
		return $code;
	}

	$code = '';

	$response = wp_remote_get(
		'https://ipwho.is/' . rawurlencode( $ip ) . '?fields=success,country_code',
		array(
			'timeout' => 2,
			'headers' => array( 'Accept' => 'application/json' ),
		)
	);

	if ( ! is_wp_error( $response ) && 200 === (int) wp_remote_retrieve_response_code( $response ) ) {
		$body = json_decode( (string) wp_remote_retrieve_body( $response ), true );
		if ( is_array( $body ) && ! empty( $body['success'] ) && ! empty( $body['country_code'] ) ) {
			$code = doroshopping_geo_normalize_country( $body['country_code'] );
		}
	}

	// Cache también los fallos breves para no martillar la API.
	set_transient( $cache_key, $code ? $code : '-', $code ? WEEK_IN_SECONDS : HOUR_IN_SECONDS );

	return $code;
}

/**
 * Detectar país del visitante (ISO2). No escribe cookies.
 *
 * Orden:
 * 1) Filter `doroshopping_detect_country` (plugin)
 * 2) Cabecera Cloudflare CF-IPCountry (si existe)
 * 3) Shortcode legacy [cfgeo] si el plugin sigue activo
 * 4) API ligera del tema (cacheada)
 *
 * @return string
 */
function doroshopping_detect_visitor_country() {
	static $memo = null;
	if ( null !== $memo ) {
		return $memo;
	}

	if ( ! doroshopping_geo_enabled() ) {
		$memo = '';
		return $memo;
	}

	$code = '';

	/**
	 * Plugin: devolver país ISO2 y el tema no sigue la cadena.
	 *
	 * @param string $code Empty by default.
	 */
	$filtered = apply_filters( 'doroshopping_detect_country', '' );
	$code     = doroshopping_geo_normalize_country( (string) $filtered );

	if ( ! $code && ! empty( $_SERVER['HTTP_CF_IPCOUNTRY'] ) ) {
		$cf = doroshopping_geo_normalize_country( wp_unslash( $_SERVER['HTTP_CF_IPCOUNTRY'] ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		if ( $cf && 'XX' !== $cf && 'T1' !== $cf ) {
			$code = $cf;
		}
	}

	if ( ! $code && function_exists( 'do_shortcode' ) && shortcode_exists( 'cfgeo' ) ) {
		$detected = trim( wp_strip_all_tags( do_shortcode( '[cfgeo return="country_code" default=""]' ) ) );
		$code     = doroshopping_geo_normalize_country( $detected );
	}

	if ( ! $code ) {
		$ip = doroshopping_geo_client_ip();
		if ( $ip ) {
			$code = doroshopping_geo_lookup_ip_country( $ip );
		}
	}

	$supported = doroshopping_geo_supported_countries();
	if ( $code && ! in_array( $code, $supported, true ) ) {
		// Fuera de mercados: no sugerimos, pero devolvemos el código por si un plugin lo usa.
		$code = (string) apply_filters( 'doroshopping_detect_country_outside_market', '', $code );
	}

	$memo = doroshopping_geo_normalize_country( $code );
	return $memo;
}

/**
 * País efectivo actual (cookie / WC / default), sin forzar IP.
 *
 * @return string
 */
function doroshopping_geo_current_country() {
	$preferred = doroshopping_geo_preferred_country();
	if ( $preferred ) {
		return $preferred;
	}

	if ( function_exists( 'WC' ) && WC()->customer ) {
		$ship = doroshopping_geo_normalize_country( (string) WC()->customer->get_shipping_country() );
		$bill = doroshopping_geo_normalize_country( (string) WC()->customer->get_billing_country() );
		if ( $ship ) {
			return $ship;
		}
		if ( $bill ) {
			return $bill;
		}
	}

	return 'ES';
}

/**
 * ¿Mostrar el aviso suave?
 *
 * @return bool
 */
function doroshopping_geo_should_suggest() {
	if ( ! doroshopping_geo_enabled() || is_customize_preview() ) {
		return false;
	}
	// admin-ajax.php reporta is_admin(); permitir sonda AJAX del geo.
	if ( is_admin() && ! wp_doing_ajax() ) {
		return false;
	}

	$detected = doroshopping_detect_visitor_country();
	if ( ! $detected ) {
		return false;
	}

	$supported = doroshopping_geo_supported_countries();
	if ( ! in_array( $detected, $supported, true ) ) {
		return false;
	}

	if ( doroshopping_geo_is_dismissed() ) {
		return false;
	}

	$current = doroshopping_geo_current_country();
	$show    = ( $detected !== $current );

	/**
	 * @param bool   $show     Whether to show.
	 * @param string $detected Detected ISO2.
	 * @param string $current  Current ISO2.
	 */
	return (bool) apply_filters( 'doroshopping_geo_should_suggest', $show, $detected, $current );
}

/**
 * Datos del banner.
 *
 * @return array<string,mixed>|null
 */
function doroshopping_geo_suggest_payload() {
	if ( ! doroshopping_geo_should_suggest() ) {
		return null;
	}

	$detected = doroshopping_detect_visitor_country();
	$map      = function_exists( 'doroshopping_get_header_location' )
		? doroshopping_get_header_location()
		: array( 'map' => array() );

	$label = isset( $map['map'][ $detected ]['label'] ) ? $map['map'][ $detected ]['label'] : $detected;
	$flag  = isset( $map['map'][ $detected ]['flag'] ) ? $map['map'][ $detected ]['flag'] : '';

	$ui = static function ( $key, $fallback ) {
		return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : $fallback;
	};

	$message_tpl = $ui(
		'doroshopping_ui_geo_message',
		/* translators: %s: country name */
		__( 'Parece que estás en %s. ¿Quieres usar esta ubicación para envíos?', 'doroshopping' )
	);

	$payload = array(
		'country'          => $detected,
		'label'            => $label,
		'flag'             => $flag,
		'applyLocale'      => (bool) get_theme_mod( 'doroshopping_geo_apply_locale', true ),
		'lang'             => isset( $map['map'][ $detected ]['lang'] ) ? $map['map'][ $detected ]['lang'] : '',
		'currency'         => isset( $map['map'][ $detected ]['currency'] ) ? $map['map'][ $detected ]['currency'] : '',
		'message'          => sprintf( $message_tpl, $label ),
		'acceptLabel'      => $ui( 'doroshopping_ui_geo_accept', __( 'Sí, usar', 'doroshopping' ) ),
		'dismissLabel'     => $ui( 'doroshopping_ui_geo_dismiss', __( 'Ahora no', 'doroshopping' ) ),
		'changeLabel'      => $ui( 'doroshopping_ui_geo_change', __( 'Elegir otra', 'doroshopping' ) ),
		'closeLabel'       => $ui( 'doroshopping_ui_ship_close', __( 'Cerrar', 'doroshopping' ) ),
	);

	/**
	 * @param array<string,mixed> $payload Payload.
	 */
	return apply_filters( 'doroshopping_geo_suggest_payload', $payload );
}

/**
 * Aplicar país (y opcionalmente idioma/moneda) tras aceptar.
 *
 * @param string $country ISO2.
 * @param bool   $apply_locale Apply lang/currency.
 * @return string Redirect URL.
 */
function doroshopping_geo_apply_country( $country, $apply_locale = true ) {
	$country = doroshopping_geo_normalize_country( $country );
	if ( ! $country ) {
		return doroshopping_prefs_redirect_url();
	}

	doroshopping_geo_set_country_cookie( $country );

	// Limpiar dismiss.
	$args = doroshopping_geo_cookie_args();
	setcookie( 'doroshopping_geo_dismiss', '', time() - YEAR_IN_SECONDS, $args['path'], $args['domain'], is_ssl(), false );
	unset( $_COOKIE['doroshopping_geo_dismiss'] );

	if ( function_exists( 'WC' ) && WC()->customer ) {
		WC()->customer->set_billing_country( $country );
		WC()->customer->set_shipping_country( $country );
		WC()->customer->save();
	}

	$redirect = function_exists( 'doroshopping_prefs_redirect_url' )
		? doroshopping_prefs_redirect_url()
		: home_url( '/' );

	if ( $apply_locale && function_exists( 'doroshopping_get_location_locale_map' ) ) {
		$map = doroshopping_get_location_locale_map();
		if ( ! empty( $map[ $country ]['lang'] ) && function_exists( 'doroshopping_has_polylang' ) && doroshopping_has_polylang() ) {
			$lang    = sanitize_key( $map[ $country ]['lang'] );
			$current = function_exists( 'pll_current_language' ) ? sanitize_key( (string) pll_current_language( 'slug' ) ) : '';
			if ( $lang && $lang !== $current && function_exists( 'doroshopping_url_for_language' ) ) {
				$redirect = doroshopping_url_for_language( $lang, $redirect );
			}
		}
		if ( ! empty( $map[ $country ]['currency'] ) && function_exists( 'doroshopping_apply_currency' ) ) {
			$currency = strtoupper( sanitize_text_field( $map[ $country ]['currency'] ) );
			doroshopping_apply_currency( $currency );
			$redirect = add_query_arg(
				array(
					'wmc-currency' => $currency,
					'yay-currency' => $currency,
				),
				$redirect
			);
		}
	}

	do_action( 'doroshopping_geo_country_accepted', $country );

	return $redirect;
}

/**
 * ¿Conviene lanzar sonda AJAX? (sin consultar IP).
 *
 * @return bool
 */
function doroshopping_geo_should_probe() {
	if ( ! doroshopping_geo_enabled() || is_admin() || wp_doing_ajax() || is_customize_preview() ) {
		return false;
	}
	if ( doroshopping_geo_is_dismissed() ) {
		return false;
	}
	/**
	 * @param bool $probe Whether JS should ask the server.
	 */
	return (bool) apply_filters( 'doroshopping_geo_should_probe', true );
}

/**
 * AJAX: sondear si hay sugerencia (aquí sí se consulta IP / plugin).
 *
 * @return void
 */
function doroshopping_ajax_geo_probe() {
	check_ajax_referer( 'doroshopping_geo', 'nonce' );

	if ( function_exists( 'doroshopping_rate_limit' ) && ! doroshopping_rate_limit( 'geo_probe', 20, 60 ) ) {
		doroshopping_rate_limit_ajax_block();
	}

	$payload = doroshopping_geo_suggest_payload();
	if ( ! $payload ) {
		wp_send_json_success( array( 'suggest' => false ) );
	}

	ob_start();
	get_template_part( 'template-parts/geo/suggest', 'banner', array( 'payload' => $payload ) );
	$html = ob_get_clean();

	wp_send_json_success(
		array(
			'suggest' => true,
			'country' => $payload['country'],
			'html'    => $html,
		)
	);
}
add_action( 'wp_ajax_doroshopping_geo_probe', 'doroshopping_ajax_geo_probe' );
add_action( 'wp_ajax_nopriv_doroshopping_geo_probe', 'doroshopping_ajax_geo_probe' );

/**
 * AJAX: aceptar sugerencia.
 *
 * @return void
 */
function doroshopping_ajax_geo_accept() {
	check_ajax_referer( 'doroshopping_geo', 'nonce' );

	$country = isset( $_POST['country'] ) ? doroshopping_geo_normalize_country( wp_unslash( $_POST['country'] ) ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
	if ( ! $country || ! in_array( $country, doroshopping_geo_supported_countries(), true ) ) {
		wp_send_json_error( array( 'message' => 'invalid_country' ), 400 );
	}

	$apply_locale = (bool) get_theme_mod( 'doroshopping_geo_apply_locale', true );
	$redirect     = doroshopping_geo_apply_country( $country, $apply_locale );

	wp_send_json_success(
		array(
			'country'  => $country,
			'redirect' => $redirect,
		)
	);
}
add_action( 'wp_ajax_doroshopping_geo_accept', 'doroshopping_ajax_geo_accept' );
add_action( 'wp_ajax_nopriv_doroshopping_geo_accept', 'doroshopping_ajax_geo_accept' );

/**
 * AJAX: descartar aviso.
 *
 * @return void
 */
function doroshopping_ajax_geo_dismiss() {
	check_ajax_referer( 'doroshopping_geo', 'nonce' );
	doroshopping_geo_set_dismiss_cookie();
	do_action( 'doroshopping_geo_country_dismissed' );
	wp_send_json_success( array( 'dismissed' => true ) );
}
add_action( 'wp_ajax_doroshopping_geo_dismiss', 'doroshopping_ajax_geo_dismiss' );
add_action( 'wp_ajax_nopriv_doroshopping_geo_dismiss', 'doroshopping_ajax_geo_dismiss' );
