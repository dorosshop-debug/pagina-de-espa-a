<?php
/**
 * Protección de rendimiento ante crawlers / filtros abusivos.
 *
 * Los logs muestran 503 por URLs con muchos ?filter_* (Facebook/Meta bots)
 * y 404/410 a rutas terminadas en /null, /undefined, etc.
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
 * ¿User-Agent tipicamente bot/crawler?
 *
 * @return bool
 */
function doroshopping_is_likely_bot_request() {
	$ua = isset( $_SERVER['HTTP_USER_AGENT'] ) ? strtolower( (string) wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
	if ( '' === $ua ) {
		return true;
	}

	$needles = array(
		'bot',
		'spider',
		'crawl',
		'slurp',
		'facebookexternalhit',
		'facebot',
		'meta-externalagent',
		'bytespider',
		'semrush',
		'ahrefs',
		'dotbot',
		'petalbot',
		'yandex',
		'bingpreview',
		'gptbot',
		'claudebot',
		'amazonbot',
	);

	foreach ( $needles as $needle ) {
		if ( false !== strpos( $ua, $needle ) ) {
			return true;
		}
	}

	/**
	 * @param bool   $is_bot Is bot.
	 * @param string $ua     User agent lowercased.
	 */
	return (bool) apply_filters( 'doroshopping_is_likely_bot_request', false, $ua );
}

/**
 * Crawlers “conocidos” (Meta/Google/Bing…): 410 OK, nunca soft-ban / Fail2ban.
 *
 * @return bool
 */
function doroshopping_is_trusted_crawler() {
	$ua = isset( $_SERVER['HTTP_USER_AGENT'] ) ? strtolower( (string) wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
	if ( '' === $ua ) {
		return false;
	}

	$trusted = array(
		'meta-externalagent',
		'facebookexternalhit',
		'facebot',
		'googlebot',
		'google-inspectiontool',
		'bingbot',
		'applebot',
		'duckduckbot',
	);

	foreach ( $trusted as $needle ) {
		if ( false !== strpos( $ua, $needle ) ) {
			/**
			 * @param bool   $trusted Trusted.
			 * @param string $ua      UA.
			 */
			return (bool) apply_filters( 'doroshopping_is_trusted_crawler', true, $ua );
		}
	}

	/**
	 * @param bool   $trusted Trusted.
	 * @param string $ua      UA.
	 */
	return (bool) apply_filters( 'doroshopping_is_trusted_crawler', false, $ua );
}

/**
 * ¿URI basura típica de JS roto / scrapers?
 *
 * @param string $uri Request URI.
 * @return bool
 */
function doroshopping_is_junk_request_uri( $uri ) {
	$uri = (string) $uri;
	if ( '' === $uri ) {
		return false;
	}

	// Segmentos literales: /null, /undefined, /NaN (con o sin trailing slash / query).
	if ( preg_match( '#/(?:null|undefined|nan)(?:/|\?|$)#i', $uri ) ) {
		return true;
	}

	// Path con "null" como último segmento decodificado.
	$path = (string) wp_parse_url( $uri, PHP_URL_PATH );
	if ( $path && preg_match( '#/(?:null|undefined|nan)/?$#i', rawurldecode( $path ) ) ) {
		return true;
	}

	/**
	 * @param bool   $junk Is junk.
	 * @param string $uri  URI.
	 */
	return (bool) apply_filters( 'doroshopping_is_junk_request_uri', false, $uri );
}

/**
 * Respuesta barata 410 Gone.
 *
 * @return void
 */
function doroshopping_send_gone_and_exit() {
	status_header( 410 );
	nocache_headers();
	header( 'X-Robots-Tag: noindex, nofollow' );
	exit;
}

/**
 * Cortar rutas basura y filtros abusivos antes de montar la página.
 *
 * @return void
 */
function doroshopping_performance_guard() {
	if ( is_admin() || wp_doing_ajax() || wp_doing_cron() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}

	$uri = isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_unslash( $_SERVER['REQUEST_URI'] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput

	if ( doroshopping_is_junk_request_uri( $uri ) ) {
		// Meta/Google: solo 410. Soft-ban/Fail2ban solo para scrapers desconocidos.
		if ( function_exists( 'doroshopping_abuse_strike' ) && ! doroshopping_is_trusted_crawler() ) {
			doroshopping_abuse_strike( 'junk_path', 6, 10 * MINUTE_IN_SECONDS );
		}
		doroshopping_send_gone_and_exit();
	}

	$stats = doroshopping_request_filter_stats();

	/**
	 * Máximo de filtros filter_* simultáneos antes de redirigir / cortar.
	 *
	 * @param int $max Max filters.
	 */
	$max_filters = (int) apply_filters( 'doroshopping_max_shop_filters', 3 );

	$abuse = $stats['legacy'] || ( $stats['count'] > max( 1, $max_filters ) );

	if ( ! $abuse ) {
		return;
	}

	// Bots: 410 inmediato (no gastar redirect + segunda petición).
	if ( doroshopping_is_likely_bot_request() ) {
		// No soft-banear Meta: rompería previews al compartir. Solo scrapers genéricos.
		if ( function_exists( 'doroshopping_abuse_strike' ) && ! doroshopping_is_trusted_crawler() ) {
			doroshopping_abuse_strike( 'filter_abuse', 10, 15 * MINUTE_IN_SECONDS );
		}
		doroshopping_send_gone_and_exit();
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
// init: corta antes que template_redirect (menos trabajo de query principal).
add_action( 'init', 'doroshopping_performance_guard', 0 );

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
 * @param string $output Robots txt.
 * @param bool   $public Blog public.
 * @return string
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
	$extra .= "Disallow: /*/undefined\n";
	$extra .= "Disallow: /*/undefined/\n";
	return $output . $extra;
}
add_filter( 'robots_txt', 'doroshopping_robots_txt_filters', 20, 2 );
