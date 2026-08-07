<?php
/**
 * Theme mods por idioma + herramientas Polylang (páginas).
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Idiomas del sitio (slugs).
 *
 * @return string[]
 */
function doroshopping_i18n_language_slugs() {
	if ( function_exists( 'pll_languages_list' ) ) {
		$list = pll_languages_list( array( 'fields' => 'slug' ) );
		if ( is_array( $list ) && ! empty( $list ) ) {
			return array_map( 'sanitize_key', $list );
		}
	}
	return array( 'es', 'en', 'de', 'fr', 'it', 'pt' );
}

/**
 * Idioma por defecto.
 *
 * @return string
 */
function doroshopping_i18n_default_lang() {
	if ( function_exists( 'pll_default_language' ) ) {
		$code = pll_default_language( 'slug' );
		if ( $code ) {
			return sanitize_key( $code );
		}
	}
	return 'es';
}

/**
 * Idioma “activo” para leer mods (front o Personalizar).
 *
 * @return string
 */
function doroshopping_i18n_current_lang() {
	if ( is_customize_preview() ) {
		$edit = get_theme_mod( 'doroshopping_i18n_edit_lang', '' );
		if ( $edit ) {
			return sanitize_key( $edit );
		}
	}
	if ( function_exists( 'doroshopping_get_current_language_code' ) ) {
		return doroshopping_get_current_language_code();
	}
	return doroshopping_i18n_default_lang();
}

/**
 * Clave de theme_mod localizada.
 *
 * @param string      $key  Base key.
 * @param string|null $lang Lang slug.
 * @return string
 */
function doroshopping_i18n_mod_key( $key, $lang = null ) {
	$lang = $lang ? sanitize_key( $lang ) : doroshopping_i18n_current_lang();
	$def  = doroshopping_i18n_default_lang();
	if ( ! $lang || $lang === $def ) {
		// Idioma por defecto: clave legacy sin sufijo (compatibilidad).
		return $key;
	}
	return $key . '__' . $lang;
}

/**
 * Leer theme_mod con fallback al idioma por defecto / clave legacy.
 *
 * @param string $key     Setting key.
 * @param mixed  $default Default.
 * @return mixed
 */
function doroshopping_get_theme_mod( $key, $default = false ) {
	$lang = doroshopping_i18n_current_lang();
	$def  = doroshopping_i18n_default_lang();

	if ( $lang && $lang !== $def ) {
		$localized = get_theme_mod( doroshopping_i18n_mod_key( $key, $lang ), null );
		// 0 / '' = sin valor propio → pack embebido → idioma por defecto.
		if ( null !== $localized && false !== $localized && '' !== $localized && ! ( is_numeric( $localized ) && (int) $localized === 0 ) ) {
			return $localized;
		}
		if ( function_exists( 'doroshopping_i18n_builtin_text' ) ) {
			$builtin = doroshopping_i18n_builtin_text( $key, $lang );
			if ( '' !== $builtin ) {
				return $builtin;
			}
		}
	}

	return get_theme_mod( $key, $default );
}

/**
 * Settings del home que se editan por idioma en Personalizar.
 *
 * @return array<string, string> setting_id => type (text|url|select|media)
 */
function doroshopping_i18n_home_setting_defs() {
	$defs = array();
	for ( $i = 1; $i <= 3; $i++ ) {
		$defs[ 'doroshopping_hero_' . $i . '_image' ]    = 'media';
		$defs[ 'doroshopping_hero_' . $i . '_title' ]    = 'text';
		$defs[ 'doroshopping_hero_' . $i . '_subtitle' ] = 'text';
		$defs[ 'doroshopping_hero_' . $i . '_cta' ]      = 'text';
		$defs[ 'doroshopping_hero_' . $i . '_url' ]      = 'url';
		$defs[ 'doroshopping_hero_' . $i . '_align' ]    = 'select';
	}
	$defs['doroshopping_promo_image']           = 'media';
	$defs['doroshopping_promo_title']           = 'text';
	$defs['doroshopping_promo_cta']             = 'text';
	$defs['doroshopping_promo_cta_url']         = 'url';
	$defs['doroshopping_home_categories_title'] = 'text';
	$defs['doroshopping_home_block_1_title']    = 'text';
	$defs['doroshopping_home_block_2_title']    = 'text';
	for ( $t = 1; $t <= 4; $t++ ) {
		$defs[ 'doroshopping_home_tile_' . $t . '_label' ] = 'text';
	}
	$defs['doroshopping_home_featured_title'] = 'text';
	return $defs;
}

/**
 * @deprecated Use doroshopping_i18n_home_setting_defs().
 * @return string[]
 */
function doroshopping_i18n_home_text_keys() {
	return array_keys( doroshopping_i18n_home_setting_defs() );
}

/**
 * Textos UI (header/footer + paginas). Merge de chrome + pages.
 *
 * @return array<string, array{default:string,label:string,section:string,type?:string}>
 */
function doroshopping_i18n_ui_defaults() {
	static $cached = null;
	if ( null !== $cached ) {
		return $cached;
	}

	$base = array();
	if ( function_exists( 'doroshopping_i18n_ui_chrome_defaults' ) ) {
		$base = array_merge( $base, doroshopping_i18n_ui_chrome_defaults() );
	}
	if ( function_exists( 'doroshopping_i18n_ui_page_defaults' ) ) {
		$base = array_merge( $base, doroshopping_i18n_ui_page_defaults() );
	}
	if ( function_exists( 'doroshopping_i18n_ui_legal_page_defaults' ) ) {
		$base = array_merge( $base, doroshopping_i18n_ui_legal_page_defaults() );
	}
	if ( function_exists( 'doroshopping_i18n_ui_support_page_defaults' ) ) {
		$base = array_merge( $base, doroshopping_i18n_ui_support_page_defaults() );
	}
	if ( function_exists( 'doroshopping_i18n_ui_content_page_defaults' ) ) {
		$base = array_merge( $base, doroshopping_i18n_ui_content_page_defaults() );
	}

	$cached = $base;
	return $cached;
}

/**
 * Settings UI para i18n.
 *
 * @return array<string, string>
 */
function doroshopping_i18n_ui_setting_defs() {
	$defs = array();
	foreach ( doroshopping_i18n_ui_defaults() as $key => $meta ) {
		$defs[ $key ] = ( ! empty( $meta['type'] ) && 'textarea' === $meta['type'] ) ? 'textarea' : 'text';
	}
	return $defs;
}

/**
 * Home + UI settings i18n.
 *
 * @return array<string, string>
 */
function doroshopping_i18n_all_setting_defs() {
	return array_merge( doroshopping_i18n_home_setting_defs(), doroshopping_i18n_ui_setting_defs() );
}

/**
 * Texto UI multi-idioma.
 *
 * @param string $key Setting key.
 * @return string
 */
function doroshopping_ui_text( $key ) {
	$key      = (string) $key;
	$defaults = doroshopping_i18n_ui_defaults();
	$default  = isset( $defaults[ $key ]['default'] ) ? $defaults[ $key ]['default'] : '';

	if ( function_exists( 'doroshopping_get_theme_mod' ) ) {
		$value = doroshopping_get_theme_mod( $key, $default );
	} else {
		$value = get_theme_mod( $key, $default );
	}

	$value = is_string( $value ) ? trim( $value ) : '';
	return '' !== $value ? $value : $default;
}

/**
 * Texto UI con sprintf.
 *
 * @param string $key Setting key.
 * @param mixed  ...$args Args.
 * @return string
 */
function doroshopping_ui_sprintf( $key, ...$args ) {
	$template = doroshopping_ui_text( $key );
	if ( empty( $args ) || '' === $template ) {
		return $template;
	}

	try {
		return sprintf( $template, ...$args );
	} catch ( \ValueError $e ) {
		return $template;
	} catch ( \ArgumentCountError $e ) {
		return $template;
	}
}

/**
 * Etiqueta de país desde Textos UI (Personalizar).
 *
 * @param string $code ISO2.
 * @return string
 */
function doroshopping_ui_country_label( $code ) {
	$code = strtoupper( sanitize_text_field( (string) $code ) );
	if ( 'UK' === $code ) {
		$code = 'GB';
	}

	$map = array(
		'ES' => 'doroshopping_ui_country_es',
		'PT' => 'doroshopping_ui_country_pt',
		'FR' => 'doroshopping_ui_country_fr',
		'DE' => 'doroshopping_ui_country_de',
		'IT' => 'doroshopping_ui_country_it',
		'CH' => 'doroshopping_ui_country_ch',
		'GB' => 'doroshopping_ui_country_gb',
	);

	if ( isset( $map[ $code ] ) ) {
		return doroshopping_ui_text( $map[ $code ] );
	}

	return $code;
}

/**
 * Tiempo estimado “X - Y días hábiles” multiidioma.
 *
 * @param string $range Rango numérico, p. ej. "2 - 4".
 * @return string
 */
function doroshopping_ui_eta_days( $range ) {
	$range = trim( (string) $range );
	if ( '' === $range ) {
		return '';
	}
	return doroshopping_ui_sprintf( 'doroshopping_ui_product_eta_days', $range );
}

/**
 * Admin: página para crear/enlazar traducciones de páginas.
 */
function doroshopping_i18n_admin_menu() {
	add_theme_page(
		__( 'Doro: traducciones', 'doroshopping' ),
		__( 'Doro: traducciones', 'doroshopping' ),
		'manage_options',
		'doroshopping-i18n',
		'doroshopping_i18n_admin_page'
	);
}
add_action( 'admin_menu', 'doroshopping_i18n_admin_menu' );

/**
 * Render admin.
 */
function doroshopping_i18n_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$notice = '';
	if ( isset( $_POST['doroshopping_i18n_sync'] ) && check_admin_referer( 'doroshopping_i18n_sync' ) ) {
		$result = doroshopping_polylang_sync_all_site_pages();
		$notice = sprintf(
			/* translators: 1: created 2: linked 3: skipped */
			__( 'Listo. Creadas: %1$d · Ya enlazadas: %2$d · Sin origen ES: %3$d', 'doroshopping' ),
			(int) $result['created'],
			(int) $result['linked'],
			(int) $result['missing']
		);
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Doro: montar traducciones de páginas', 'doroshopping' ); ?></h1>
		<?php if ( $notice ) : ?>
			<div class="notice notice-success"><p><?php echo esc_html( $notice ); ?></p></div>
		<?php endif; ?>

		<?php if ( ! function_exists( 'pll_languages_list' ) ) : ?>
			<p><?php esc_html_e( 'Activa Polylang Pro / Business para usar esta herramienta.', 'doroshopping' ); ?></p>
		<?php else : ?>
			<p><?php esc_html_e( 'Esto NO traduce textos automáticamente. Crea (o enlaza) una copia de cada página esencial en EN, DE, FR, IT, PT a partir del español, listas para que edites el contenido.', 'doroshopping' ); ?></p>
			<p><strong><?php esc_html_e( 'Incluye:', 'doroshopping' ); ?></strong> Inicio, Tienda, Carrito, Checkout, Mi cuenta, Contacto, Cupones, Envíos, Wishlist, Sobre nosotros, legales/políticas, ayuda, FAQ, pagos, protección comprador.</p>
			<p><strong><?php esc_html_e( 'NO incluye (se hacen en WooCommerce):', 'doroshopping' ); ?></strong> productos, categorías, etiquetas y atributos.</p>
			<form method="post">
				<?php wp_nonce_field( 'doroshopping_i18n_sync' ); ?>
				<p>
					<button type="submit" name="doroshopping_i18n_sync" value="1" class="button button-primary">
						<?php esc_html_e( 'Crear / enlazar páginas en todos los idiomas', 'doroshopping' ); ?>
					</button>
				</p>
			</form>
			<hr>
			<ol>
				<li><?php esc_html_e( 'Pulsa el botón de arriba.', 'doroshopping' ); ?></li>
				<li><?php esc_html_e( 'Ve a Páginas: cada Inicio/Contacto/etc. debe mostrar banderas enlazadas (lápiz, no solo +).', 'doroshopping' ); ?></li>
				<li><?php esc_html_e( 'Edita el título/contenido de cada idioma (o Elementor en páginas de contenido).', 'doroshopping' ); ?></li>
				<li><?php esc_html_e( 'Home + Textos UI: Apariencia → Personalizar → «Idioma a editar» (Home y todas las secciones Textos UI).', 'doroshopping' ); ?></li>
				<li><?php esc_html_e( 'Mega menú (nombres): Menús / categorías con Polylang.', 'doroshopping' ); ?></li>
				<li><?php esc_html_e( 'Productos/categorías: Productos → traducir con Polylang (o DeepL si lo tienes).', 'doroshopping' ); ?></li>
			</ol>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Orígenes ES a sincronizar (ID de página).
 *
 * @return array<string,int> map label => post ID
 */
function doroshopping_i18n_source_pages() {
	$out = array();

	$front = (int) get_option( 'page_on_front' );
	if ( $front > 0 ) {
		$out['inicio'] = $front;
	}

	if ( function_exists( 'wc_get_page_id' ) ) {
		foreach ( array( 'shop' => 'tienda', 'cart' => 'carrito', 'checkout' => 'finalizar-compra', 'myaccount' => 'mi-cuenta' ) as $wc => $label ) {
			$id = (int) wc_get_page_id( $wc );
			if ( $id > 0 ) {
				$out[ $label ] = $id;
			}
		}
	}

	if ( function_exists( 'doroshopping_essential_pages' ) && function_exists( 'doroshopping_get_page_by_slug' ) ) {
		foreach ( array_keys( doroshopping_essential_pages() ) as $slug ) {
			if ( isset( $out[ $slug ] ) ) {
				continue;
			}
			$page = doroshopping_get_page_by_slug( $slug );
			if ( $page instanceof WP_Post ) {
				$out[ $slug ] = (int) $page->ID;
			}
		}
	}

	return $out;
}

/**
 * Crear/enlazar todas las páginas del sitio en todos los idiomas Polylang.
 *
 * @return array{created:int,linked:int,missing:int}
 */
function doroshopping_polylang_sync_all_site_pages() {
	$stats = array(
		'created' => 0,
		'linked'  => 0,
		'missing' => 0,
	);

	if ( ! doroshopping_has_polylang() || ! function_exists( 'pll_set_post_language' ) || ! function_exists( 'pll_save_post_translations' ) || ! function_exists( 'pll_get_post' ) ) {
		return $stats;
	}

	$langs   = doroshopping_i18n_language_slugs();
	$default = doroshopping_i18n_default_lang();
	$sources = doroshopping_i18n_source_pages();

	if ( empty( $sources ) ) {
		$stats['missing'] = 1;
		return $stats;
	}

	foreach ( $sources as $label => $source_id ) {
		$source_id = (int) $source_id;

		// Preferir la versión del idioma por defecto como origen.
		if ( function_exists( 'pll_get_post' ) ) {
			$in_default = pll_get_post( $source_id, $default );
			if ( $in_default ) {
				$source_id = function_exists( 'doroshopping_normalize_post_id' )
					? doroshopping_normalize_post_id( $in_default )
					: (int) $in_default;
			}
		}

		$source = get_post( $source_id );
		if ( ! $source || 'page' !== $source->post_type ) {
			$stats['missing']++;
			continue;
		}

		// Asegurar idioma del origen.
		if ( function_exists( 'pll_get_post_language' ) && ! pll_get_post_language( $source_id ) ) {
			pll_set_post_language( $source_id, $default );
		}

		$translations = function_exists( 'pll_get_post_translations' ) ? pll_get_post_translations( $source_id ) : array();
		if ( ! is_array( $translations ) ) {
			$translations = array();
		}
		$translations[ $default ] = $source_id;

		foreach ( $langs as $lang ) {
			$lang = sanitize_key( $lang );
			if ( ! $lang || $lang === $default ) {
				continue;
			}

			$existing = pll_get_post( $source_id, $lang );
			if ( $existing ) {
				$translations[ $lang ] = function_exists( 'doroshopping_normalize_post_id' )
					? doroshopping_normalize_post_id( $existing )
					: (int) $existing;
				$stats['linked']++;
				continue;
			}

			$new_id = wp_insert_post(
				array(
					'post_title'   => $source->post_title,
					'post_name'    => sanitize_title( $source->post_name . '-' . $lang ),
					'post_content' => $source->post_content,
					'post_status'  => 'publish',
					'post_type'    => 'page',
					'post_author'  => $source->post_author,
					'post_parent'  => 0,
				),
				true
			);

			if ( is_wp_error( $new_id ) || ! $new_id ) {
				continue;
			}

			$template = get_page_template_slug( $source_id );
			if ( $template ) {
				update_post_meta( (int) $new_id, '_wp_page_template', $template );
			}

			pll_set_post_language( (int) $new_id, $lang );
			$translations[ $lang ] = (int) $new_id;
			$stats['created']++;
		}

		pll_save_post_translations( $translations );
	}

	if ( function_exists( 'doroshopping_flush_mega_menu_cache' ) ) {
		doroshopping_flush_mega_menu_cache();
	}

	return $stats;
}
