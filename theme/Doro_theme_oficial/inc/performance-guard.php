<?php
/**
 * Protección de rendimiento ante crawlers / filtros abusivos.
 *
 * Los logs muestran 503 por URLs con muchos ?filter_* (Facebook/Meta bots)
 * y 404 a rutas terminadas en /null.
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Contar parámetros de filtro en la petición.
 *
 * @return array{count:int,legacy:bool,keys:string[]}
 */
function doroshopping_request_filter_stats() {
	$count  = 0;
	$legacy = false;
	$keys   = array();

	if ( empty( $_GET ) || ! is_array( $_GET ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return array(
			'count'  => 0,
			'legacy' => false,
			'keys'   => array(),
		);
	}

	foreach ( array_keys( $_GET ) as $key ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$key = sanitize_key( (string) $key );
		if ( '' === $key ) {
			continue;
		}
		if ( 0 === strpos( $key, 'filter_' ) ) {
			++$count;
			$keys[] = $key;
			if ( 0 === strpos( $key, 'filter_attributegroup_' ) || 'filter_brand' === $key ) {
				$legacy = true;
			}
		}
		if ( in_array( $key, array( 'min_price', 'max_price', 'min_rating', 'on_sale' ), true ) ) {
			$keys[] = $key;
		}
	}

	return array(
		'count'  => $count,
		'legacy' => $legacy,
		'keys'   => array_values( array_unique( $keys ) ),
	);
}

/**
 * URL limpia (sin query) de la petición actual.
 *
 * @return string
 */
function doroshopping_request_path_url() {
	$uri  = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '/'; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
	$path = (string) wp_parse_url( $uri, PHP_URL_PATH );
	if ( '' === $path ) {
		$path = '/';
	}
	return home_url( $path );
}

/**
 * Cortar rutas /null y filtros abusivos antes de montar la página.
 *
 * @return void
 */
function doroshopping_performance_guard() {
	if ( is_admin() || wp_doing_ajax() || wp_doing_cron() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}

	$uri = isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_unslash( $_SERVER['REQUEST_URI'] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput

	// 404/410 barato: bots pidiendo .../null
	if ( preg_match( '#/null(?:/|\?|$)#i', $uri ) ) {
		status_header( 410 );
		nocache_headers();
		header( 'X-Robots-Tag: noindex, nofollow' );
		exit; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	$stats = doroshopping_request_filter_stats();

	/**
	 * Máximo de filtros filter_* simultáneos antes de redirigir a URL limpia.
	 *
	 * @param int $max Max filters.
	 */
	$max_filters = (int) apply_filters( 'doroshopping_max_shop_filters', 3 );

	$abuse = $stats['legacy'] || ( $stats['count'] > max( 1, $max_filters ) );

	if ( ! $abuse ) {
		return;
	}

	$clean = doroshopping_request_path_url();

	/**
	 * @param string               $clean Clean URL.
	 * @param array{count:int,legacy:bool,keys:string[]} $stats Stats.
	 */
	$clean = (string) apply_filters( 'doroshopping_abusive_filter_redirect', $clean, $stats );

	if ( ! $clean ) {
		return;
	}

	nocache_headers();
	header( 'X-Robots-Tag: noindex, nofollow' );
	wp_safe_redirect( $clean, 302 );
	exit;
}
add_action( 'template_redirect', 'doroshopping_performance_guard', 0 );

/**
 * noindex en páginas de tienda con filtros (evita que bots indexen combinaciones).
 *
 * @param array<string,bool|string> $robots Robots directives.
 * @return array<string,bool|string>
 */
function doroshopping_robots_noindex_filtered_shop( $robots ) {
	$stats = doroshopping_request_filter_stats();
	if ( $stats['count'] > 0 || ! empty( $_GET['min_price'] ) || ! empty( $_GET['max_price'] ) || ! empty( $_GET['min_rating'] ) || ! empty( $_GET['on_sale'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$robots['noindex']  = true;
		$robots['nofollow'] = true;
	}
	return $robots;
}
add_filter( 'wp_robots', 'doroshopping_robots_noindex_filtered_shop', 20 );

/**
 * Cabecera X-Robots-Tag en respuestas filtradas.
 *
 * @return void
 */
function doroshopping_send_robots_header_for_filters() {
	if ( is_admin() ) {
		return;
	}
	$stats = doroshopping_request_filter_stats();
	if ( $stats['count'] > 0 || isset( $_GET['min_price'] ) || isset( $_GET['max_price'] ) || isset( $_GET['min_rating'] ) || isset( $_GET['on_sale'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		header( 'X-Robots-Tag: noindex, nofollow', false );
	}
}
add_action( 'send_headers', 'doroshopping_send_robots_header_for_filters' );

/**
 * Disallow patrones de filtro en robots.txt dinámico.
 *
 * @return void
 */
function doroshopping_robots_txt_filters( $output, $public ) {
	if ( ! $public ) {
		return $output;
	}
	$extra  = "\n# Doro: evitar crawl de combinaciones de filtros\n";
	$extra .= "User-agent: *\n";
	$extra .= "Disallow: /*?*filter_\n";
	$extra .= "Disallow: /*?*min_price=\n";
	$extra .= "Disallow: /*?*max_price=\n";
	$extra .= "Disallow: /*/null\n";
	$extra .= "Disallow: /*/null/\n";
	return $output . $extra;
}
add_filter( 'robots_txt', 'doroshopping_robots_txt_filters', 20, 2 );
