<?php
/**
 * WordPress Customizer - logos, colores, imagenes, categorias
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register Customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Manager.
 */
function doroshopping_customize_register( $wp_customize ) {
    $wp_customize->add_panel(
        'doroshopping_panel',
        array(
            'title'    => __( 'DoroTheme', 'doroshopping' ),
            'priority' => 30,
        )
    );

    /* ---- Colores ---- */
    $wp_customize->add_section(
        'doroshopping_colors',
        array(
            'title' => __( 'Colores', 'doroshopping' ),
            'panel' => 'doroshopping_panel',
        )
    );

    $colors = array(
        'color_orange'     => array( 'label' => __( 'Acento (naranja)', 'doroshopping' ), 'default' => '#f8942d' ),
        'color_dark'       => array( 'label' => __( 'Texto oscuro', 'doroshopping' ), 'default' => '#1a1a1a' ),
        'color_grey_bg'    => array( 'label' => __( 'Fondo gris claro', 'doroshopping' ), 'default' => '#f5f5f5' ),
        'color_red_accent' => array( 'label' => __( 'Rojo CTA / precios', 'doroshopping' ), 'default' => '#e53935' ),
        'color_footer_bg'  => array( 'label' => __( 'Fondo footer', 'doroshopping' ), 'default' => '#000000' ),
    );

    foreach ( $colors as $id => $args ) {
        $wp_customize->add_setting(
            'doroshopping_' . $id,
            array(
                'default'           => $args['default'],
                'sanitize_callback' => 'sanitize_hex_color',
                'transport'         => 'postMessage',
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'doroshopping_' . $id,
                array(
                    'label'   => $args['label'],
                    'section' => 'doroshopping_colors',
                )
            )
        );
    }

    /* ---- Branding ---- */
    $wp_customize->add_section(
        'doroshopping_branding',
        array(
            'title' => __( 'Logos e imagenes de marca', 'doroshopping' ),
            'panel' => 'doroshopping_panel',
        )
    );

    $images_brand = array(
        'logo_header'    => __( 'Logo header (si no usas Logo del sitio)', 'doroshopping' ),
        'logo_footer'    => __( 'Logo footer', 'doroshopping' ),
        'register_image' => __( 'Imagen lateral pagina de registro', 'doroshopping' ),
        'payment_image'  => __( 'Imagen medios de pago', 'doroshopping' ),
        'footer_figure'  => __( 'Figura decorativa footer', 'doroshopping' ),
    );

    foreach ( $images_brand as $id => $label ) {
        $wp_customize->add_setting(
            'doroshopping_' . $id,
            array(
                'default'           => 0,
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Media_Control(
                $wp_customize,
                'doroshopping_' . $id,
                array(
                    'label'     => $label,
                    'section'   => 'doroshopping_branding',
                    'mime_type' => 'image',
                )
            )
        );
    }

    /* ---- Home imagenes ---- */
    $wp_customize->add_section(
        'doroshopping_home_images',
        array(
            'title'       => __( 'Home: banners e imagenes', 'doroshopping' ),
            'description' => __( 'Hero, banner de la seccion 3 y productos flotantes. Usa «Idioma a editar» para EN/DE/FR/IT/PT. Los flotantes se configuran mas abajo (imagen + enlace).', 'doroshopping' ),
            'panel'       => 'doroshopping_panel',
        )
    );

    for ( $i = 1; $i <= 3; $i++ ) {
        $wp_customize->add_setting(
            'doroshopping_hero_' . $i . '_image',
            array(
                'default'           => 0,
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Media_Control(
                $wp_customize,
                'doroshopping_hero_' . $i . '_image',
                array(
                    'label'     => sprintf( __( 'Hero slide %d - imagen', 'doroshopping' ), $i ),
                    'section'   => 'doroshopping_home_images',
                    'mime_type' => 'image',
                )
            )
        );
        $wp_customize->add_setting(
            'doroshopping_hero_' . $i . '_title',
            array(
                'default'           => '',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );
        $wp_customize->add_control(
            'doroshopping_hero_' . $i . '_title',
            array(
                'label'   => sprintf( __( 'Hero slide %d - titulo', 'doroshopping' ), $i ),
                'section' => 'doroshopping_home_images',
                'type'    => 'text',
            )
        );
        $wp_customize->add_setting(
            'doroshopping_hero_' . $i . '_subtitle',
            array(
                'default'           => '',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );
        $wp_customize->add_control(
            'doroshopping_hero_' . $i . '_subtitle',
            array(
                'label'   => sprintf( __( 'Hero slide %d - subtitulo', 'doroshopping' ), $i ),
                'section' => 'doroshopping_home_images',
                'type'    => 'text',
            )
        );
        $wp_customize->add_setting(
            'doroshopping_hero_' . $i . '_url',
            array(
                'default'           => '',
                'sanitize_callback' => 'esc_url_raw',
            )
        );
        $wp_customize->add_control(
            'doroshopping_hero_' . $i . '_url',
            array(
                'label'   => sprintf( __( 'Hero slide %d - enlace CTA', 'doroshopping' ), $i ),
                'section' => 'doroshopping_home_images',
                'type'    => 'url',
            )
        );
        $wp_customize->add_setting(
            'doroshopping_hero_' . $i . '_align',
            array(
                'default'           => ( 3 === $i ) ? 'right' : 'left',
                'sanitize_callback' => function ( $value ) {
                    return in_array( $value, array( 'left', 'right' ), true ) ? $value : 'left';
                },
            )
        );
        $wp_customize->add_control(
            'doroshopping_hero_' . $i . '_align',
            array(
                'label'   => sprintf( __( 'Hero slide %d - orientacion del texto', 'doroshopping' ), $i ),
                'section' => 'doroshopping_home_images',
                'type'    => 'select',
                'choices' => array(
                    'left'  => __( 'Izquierda', 'doroshopping' ),
                    'right' => __( 'Derecha', 'doroshopping' ),
                ),
            )
        );
    }

    $wp_customize->add_setting(
        'doroshopping_promo_image',
        array(
            'default'           => 0,
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Media_Control(
            $wp_customize,
            'doroshopping_promo_image',
            array(
                'label'     => __( 'Banner promocional (seccion media)', 'doroshopping' ),
                'section'   => 'doroshopping_home_images',
                'mime_type' => 'image',
            )
        )
    );

    for ( $f = 1; $f <= 3; $f++ ) {
        $wp_customize->add_setting(
            'doroshopping_promo_float_' . $f . '_image',
            array(
                'default'           => 0,
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Media_Control(
                $wp_customize,
                'doroshopping_promo_float_' . $f . '_image',
                array(
                    'label'       => sprintf( __( 'Producto flotante %d - imagen', 'doroshopping' ), $f ),
                    'description' => ( 1 === $f )
                        ? __( 'Seccion 3 del home (banner gadgets). En movil solo se muestra el flotante 1.', 'doroshopping' )
                        : '',
                    'section'     => 'doroshopping_home_images',
                    'mime_type'   => 'image',
                )
            )
        );
        $wp_customize->add_setting(
            'doroshopping_promo_float_' . $f . '_url',
            array(
                'default'           => '',
                'sanitize_callback' => 'esc_url_raw',
            )
        );
        $wp_customize->add_control(
            'doroshopping_promo_float_' . $f . '_url',
            array(
                'label'   => sprintf( __( 'Producto flotante %d - enlace', 'doroshopping' ), $f ),
                'section' => 'doroshopping_home_images',
                'type'    => 'url',
            )
        );
    }

    /* ---- Home categorias / grids ---- */
    $wp_customize->add_section(
        'doroshopping_home_grids',
        array(
            'title'       => __( 'Home: categorias y grids', 'doroshopping' ),
            'description' => __( 'Elige categorias de WooCommerce para los bloques de productos. Elementor puede sobrescribir la home con Theme Builder.', 'doroshopping' ),
            'panel'       => 'doroshopping_panel',
        )
    );

    $cat_choices = doroshopping_get_product_category_choices();

    $wp_customize->add_setting(
        'doroshopping_home_block_1_title',
        array(
            'default'           => __( 'Tecnologia para tu hogar', 'doroshopping' ),
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control(
        'doroshopping_home_block_1_title',
        array(
            'label'   => __( 'Titulo bloque izquierdo', 'doroshopping' ),
            'section' => 'doroshopping_home_grids',
            'type'    => 'text',
        )
    );
    $wp_customize->add_setting(
        'doroshopping_home_block_1_cat',
        array(
            'default'           => 0,
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'doroshopping_home_block_1_cat',
        array(
            'label'   => __( 'Categoria bloque izquierdo (carrusel)', 'doroshopping' ),
            'section' => 'doroshopping_home_grids',
            'type'    => 'select',
            'choices' => $cat_choices,
        )
    );

    $wp_customize->add_setting(
        'doroshopping_home_block_2_title',
        array(
            'default'           => __( 'Promociones de Lanzamiento', 'doroshopping' ),
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control(
        'doroshopping_home_block_2_title',
        array(
            'label'   => __( 'Titulo bloque derecho', 'doroshopping' ),
            'section' => 'doroshopping_home_grids',
            'type'    => 'text',
        )
    );
    $wp_customize->add_setting(
        'doroshopping_home_block_2_cat',
        array(
            'default'           => 0,
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'doroshopping_home_block_2_cat',
        array(
            'label'   => __( 'Categoria bloque derecho (carrusel)', 'doroshopping' ),
            'section' => 'doroshopping_home_grids',
            'type'    => 'select',
            'choices' => $cat_choices,
        )
    );

    $tile_defs = array(
        'doroshopping_home_tile_1_cat' => __( 'Tile 1 (Microfonos y auriculares)', 'doroshopping' ),
        'doroshopping_home_tile_2_cat' => __( 'Tile 2 (Gaming)', 'doroshopping' ),
        'doroshopping_home_tile_3_cat' => __( 'Tile 3 (Deportes)', 'doroshopping' ),
        'doroshopping_home_tile_4_cat' => __( 'Tile 4 (Hogar y Gadgets)', 'doroshopping' ),
    );
    foreach ( $tile_defs as $setting_id => $label ) {
        $wp_customize->add_setting(
            $setting_id,
            array(
                'default'           => 0,
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control(
            $setting_id,
            array(
                'label'       => $label,
                'description' => __( 'Categoria de WooCommerce al hacer clic en la imagen.', 'doroshopping' ),
                'section'     => 'doroshopping_home_grids',
                'type'        => 'select',
                'choices'     => $cat_choices,
            )
        );
    }

    $wp_customize->add_setting(
        'doroshopping_home_featured_title',
        array(
            'default'           => __( 'Descubre productos unicos.', 'doroshopping' ),
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control(
        'doroshopping_home_featured_title',
        array(
            'label'   => __( 'Titulo grid productos destacados', 'doroshopping' ),
            'section' => 'doroshopping_home_grids',
            'type'    => 'text',
        )
    );
    $wp_customize->add_setting(
        'doroshopping_home_featured_cat',
        array(
            'default'           => 0,
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'doroshopping_home_featured_cat',
        array(
            'label'   => __( 'Categoria grid productos destacados', 'doroshopping' ),
            'section' => 'doroshopping_home_grids',
            'type'    => 'select',
            'choices' => $cat_choices,
        )
    );
    $wp_customize->add_setting(
        'doroshopping_home_featured_limit',
        array(
            'default'           => 90,
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'doroshopping_home_featured_limit',
        array(
            'label'       => __( 'Cantidad de productos destacados', 'doroshopping' ),
            'description' => __( 'Máximo de productos en el home. Se muestran de 30 en 30 con «Ver más». Al alcanzar este límite, el botón lleva a la tienda.', 'doroshopping' ),
            'section'     => 'doroshopping_home_grids',
            'type'        => 'number',
            'input_attrs' => array(
                'min' => 30,
                'max' => 300,
                'step' => 30,
            ),
        )
    );

    doroshopping_customize_register_i18n( $wp_customize );

    /* ---- Tienda: anuncio sidebar ---- */
    $wp_customize->add_section(
        'doroshopping_shop',
        array(
            'title'       => __( 'Tienda', 'doroshopping' ),
            'description' => __( 'Imagen vertical bajo los filtros de la tienda (ADS / promo).', 'doroshopping' ),
            'panel'       => 'doroshopping_panel',
        )
    );
    $wp_customize->add_setting(
        'doroshopping_shop_sidebar_ad',
        array(
            'default'           => 0,
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Media_Control(
            $wp_customize,
            'doroshopping_shop_sidebar_ad',
            array(
                'label'     => __( 'Imagen promo / ADS (vertical)', 'doroshopping' ),
                'section'   => 'doroshopping_shop',
                'mime_type' => 'image',
            )
        )
    );
    $wp_customize->add_setting(
        'doroshopping_shop_sidebar_ad_link',
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        'doroshopping_shop_sidebar_ad_link',
        array(
            'label'   => __( 'Enlace del anuncio (opcional)', 'doroshopping' ),
            'section' => 'doroshopping_shop',
            'type'    => 'url',
        )
    );

    /* ---- Redes footer ---- */
    $wp_customize->add_section(
        'doroshopping_social',
        array(
            'title' => __( 'Redes sociales', 'doroshopping' ),
            'panel' => 'doroshopping_panel',
        )
    );

    foreach ( array( 'instagram', 'facebook', 'youtube' ) as $network ) {
        $wp_customize->add_setting(
            'doroshopping_social_' . $network,
            array(
                'default'           => '',
                'sanitize_callback' => 'esc_url_raw',
            )
        );
        $wp_customize->add_control(
            'doroshopping_social_' . $network,
            array(
                'label'   => ucfirst( $network ),
                'section' => 'doroshopping_social',
                'type'    => 'url',
            )
        );
    }

    $wp_customize->add_setting(
        'doroshopping_whatsapp',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control(
        'doroshopping_whatsapp',
        array(
            'label'       => __( 'WhatsApp (Centro de ayuda)', 'doroshopping' ),
            'description' => __( 'Número internacional sin espacios (ej. 34600000000) o URL completa de wa.me. Solo se muestra en Centro de ayuda.', 'doroshopping' ),
            'section'     => 'doroshopping_social',
            'type'        => 'text',
        )
    );

    /* ---- BigBuy envío ---- */
    $wp_customize->add_section(
        'doroshopping_bigbuy',
        array(
            'title'       => __( 'BigBuy / Envíos', 'doroshopping' ),
            'description' => __( 'Shipping API oficial BigBuy (POST /rest/shipping/orders.json). También: DORO_BIGBUY_API_KEY y DORO_BIGBUY_MODE en wp-config.php.', 'doroshopping' ),
            'panel'       => 'doroshopping_panel',
        )
    );

    $wp_customize->add_setting(
        'doroshopping_bigbuy_api_key',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control(
        'doroshopping_bigbuy_api_key',
        array(
            'label'       => __( 'API Key BigBuy', 'doroshopping' ),
            'section'     => 'doroshopping_bigbuy',
            'type'        => 'password',
            'description' => __( 'Header: Authorization Bearer. Sin clave se usa estimación local por país.', 'doroshopping' ),
        )
    );

    $wp_customize->add_setting(
        'doroshopping_bigbuy_mode',
        array(
            'default'           => 'live',
            'sanitize_callback' => static function ( $value ) {
                $value = sanitize_key( (string) $value );
                return in_array( $value, array( 'live', 'sandbox' ), true ) ? $value : 'live';
            },
        )
    );
    $wp_customize->add_control(
        'doroshopping_bigbuy_mode',
        array(
            'label'       => __( 'Entorno API', 'doroshopping' ),
            'section'     => 'doroshopping_bigbuy',
            'type'        => 'select',
            'choices'     => array(
                'live'    => __( 'Producción (api.bigbuy.eu)', 'doroshopping' ),
                'sandbox' => __( 'Sandbox / pruebas (api.sandbox.bigbuy.eu)', 'doroshopping' ),
            ),
            'description' => __( 'Según la guía BigBuy. También: define(\'DORO_BIGBUY_MODE\', \'sandbox\');', 'doroshopping' ),
        )
    );

    $wp_customize->add_setting(
        'doroshopping_bigbuy_endpoint',
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        'doroshopping_bigbuy_endpoint',
        array(
            'label'       => __( 'Endpoint shipping (opcional)', 'doroshopping' ),
            'section'     => 'doroshopping_bigbuy',
            'type'        => 'url',
            'description' => __( 'Vacío = /rest/shipping/orders.json según el entorno. Solo rellénalo si BigBuy te da otra URL.', 'doroshopping' ),
        )
    );

    /* ---- Auth / Google ---- */
    $wp_customize->add_section(
        'doroshopping_auth',
        array(
            'title'       => __( 'Login / Google', 'doroshopping' ),
            'description' => __( 'El botón Google se muestra siempre. Conecta Nextend Social Login o pega la URL del proveedor.', 'doroshopping' ),
            'panel'       => 'doroshopping_panel',
        )
    );

    $wp_customize->add_setting(
        'doroshopping_google_login_url',
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        'doroshopping_google_login_url',
        array(
            'label'       => __( 'URL login con Google', 'doroshopping' ),
            'description' => __( 'Ej. URL que te da Nextend. Vacío = detección automática del plugin.', 'doroshopping' ),
            'section'     => 'doroshopping_auth',
            'type'        => 'url',
        )
    );

    $wp_customize->add_setting(
        'doroshopping_allow_elementor_chrome',
        array(
            'default'           => false,
            'sanitize_callback' => static function ( $v ) {
                return (bool) $v;
            },
        )
    );
    $wp_customize->add_control(
        'doroshopping_allow_elementor_chrome',
        array(
            'label'       => __( 'Permitir header/footer de Elementor', 'doroshopping' ),
            'description' => __( 'Desactivado por defecto: el tema usa su header (cuenta, login popup, mega menú). Actívalo solo si diseñaste header en Elementor Theme Builder.', 'doroshopping' ),
            'section'     => 'doroshopping_auth',
            'type'        => 'checkbox',
        )
    );
}
add_action( 'customize_register', 'doroshopping_customize_register' );

/**
 * Personalizar: selector de idioma + settings por lengua (hero / títulos home).
 *
 * @param WP_Customize_Manager $wp_customize Manager.
 */
function doroshopping_customize_register_i18n( $wp_customize ) {
	if ( ! function_exists( 'doroshopping_i18n_language_slugs' ) ) {
		return;
	}

	$langs   = doroshopping_i18n_language_slugs();
	$default = doroshopping_i18n_default_lang();
	$choices = array();

	if ( function_exists( 'pll_the_languages' ) ) {
		$pll = pll_the_languages( array( 'raw' => 1, 'hide_if_empty' => 0 ) );
		if ( is_array( $pll ) ) {
			foreach ( $pll as $row ) {
				if ( empty( $row['slug'] ) ) {
					continue;
				}
				$slug             = sanitize_key( $row['slug'] );
				$choices[ $slug ] = ! empty( $row['name'] ) ? $row['name'] : strtoupper( $slug );
			}
		}
	}
	if ( empty( $choices ) ) {
		$labels = array(
			'es' => 'Español',
			'en' => 'English',
			'de' => 'Deutsch',
			'fr' => 'Français',
			'it' => 'Italiano',
			'pt' => 'Português',
		);
		foreach ( $langs as $slug ) {
			$choices[ $slug ] = isset( $labels[ $slug ] ) ? $labels[ $slug ] : strtoupper( $slug );
		}
	}

	$wp_customize->add_setting(
		'doroshopping_i18n_edit_lang',
		array(
			'default'           => $default,
			'sanitize_callback' => 'sanitize_key',
			'transport'         => 'postMessage',
		)
	);

	$lang_control_args = array(
		'label'       => __( 'Idioma a editar', 'doroshopping' ),
		'description' => __( 'Elige el idioma y rellena imagen/títulos de ese idioma. Si dejas vacío, hereda el español.', 'doroshopping' ),
		'type'        => 'select',
		'choices'     => $choices,
		'priority'    => 1,
	);

	$wp_customize->add_control(
		'doroshopping_i18n_edit_lang',
		array_merge( $lang_control_args, array( 'section' => 'doroshopping_home_images' ) )
	);
	$wp_customize->add_control(
		'doroshopping_i18n_edit_lang_grids',
		array_merge(
			$lang_control_args,
			array(
				'settings' => 'doroshopping_i18n_edit_lang',
				'section'  => 'doroshopping_home_grids',
			)
		)
	);

	$defs = function_exists( 'doroshopping_i18n_home_setting_defs' ) ? doroshopping_i18n_home_setting_defs() : array();

	foreach ( $langs as $lang ) {
		$lang = sanitize_key( $lang );
		if ( ! $lang || $lang === $default ) {
			continue;
		}

		foreach ( $defs as $base_id => $type ) {
			$setting_id = $base_id . '__' . $lang;
			$section    = ( false !== strpos( $base_id, 'doroshopping_home_block_' ) || false !== strpos( $base_id, 'doroshopping_home_featured_' ) )
				? 'doroshopping_home_grids'
				: 'doroshopping_home_images';

			$base_setting = $wp_customize->get_setting( $base_id );
			$default_val  = $base_setting ? $base_setting->default : ( 'media' === $type ? 0 : '' );
			$sanitize     = ( $base_setting && is_callable( $base_setting->sanitize_callback ) )
				? $base_setting->sanitize_callback
				: ( 'media' === $type ? 'absint' : ( 'url' === $type ? 'esc_url_raw' : 'sanitize_text_field' ) );

			$wp_customize->add_setting(
				$setting_id,
				array(
					'default'           => $default_val,
					'sanitize_callback' => $sanitize,
				)
			);

			$base_control = $wp_customize->get_control( $base_id );
			$label        = $base_control ? $base_control->label : $base_id;
			$label        = sprintf(
				/* translators: 1: field label 2: language code */
				__( '%1$s (%2$s)', 'doroshopping' ),
				$label,
				strtoupper( $lang )
			);

			$control_args = array(
				'label'           => $label,
				'section'         => $section,
				'active_callback' => static function () use ( $lang ) {
					$edit = get_theme_mod( 'doroshopping_i18n_edit_lang', '' );
					if ( ! $edit && function_exists( 'doroshopping_i18n_default_lang' ) ) {
						$edit = doroshopping_i18n_default_lang();
					}
					return sanitize_key( (string) $edit ) === $lang;
				},
			);

			if ( 'media' === $type ) {
				$wp_customize->add_control(
					new WP_Customize_Media_Control(
						$wp_customize,
						$setting_id,
						array_merge( $control_args, array( 'mime_type' => 'image' ) )
					)
				);
			} else {
				$choices_ctrl = array();
				$input_type   = 'text';
				if ( $base_control ) {
					if ( ! empty( $base_control->type ) ) {
						$input_type = $base_control->type;
					}
					if ( ! empty( $base_control->choices ) && is_array( $base_control->choices ) ) {
						$choices_ctrl = $base_control->choices;
					}
				}
				$wp_customize->add_control(
					$setting_id,
					array_merge(
						$control_args,
						array(
							'type'    => $input_type,
							'choices' => $choices_ctrl,
						)
					)
				);
			}
		}
	}

	foreach ( array_keys( $defs ) as $base_id ) {
		$control = $wp_customize->get_control( $base_id );
		if ( ! $control ) {
			continue;
		}
		$control->active_callback = static function () use ( $default ) {
			$edit = get_theme_mod( 'doroshopping_i18n_edit_lang', $default );
			if ( ! $edit ) {
				$edit = $default;
			}
			return sanitize_key( (string) $edit ) === $default;
		};
	}
}

/**
 * JS: mostrar/ocultar controles al cambiar “Idioma a editar”.
 */
function doroshopping_customize_i18n_controls_js() {
	$default = function_exists( 'doroshopping_i18n_default_lang' ) ? doroshopping_i18n_default_lang() : 'es';
	$defs    = function_exists( 'doroshopping_i18n_home_setting_defs' ) ? array_keys( doroshopping_i18n_home_setting_defs() ) : array();
	?>
	<script>
	(function (api) {
		if (!api) return;
		var defaultLang = <?php echo wp_json_encode( $default ); ?>;
		var baseIds = <?php echo wp_json_encode( array_values( $defs ) ); ?>;

		function syncLangVisibility() {
			var setting = api( 'doroshopping_i18n_edit_lang' );
			if ( ! setting ) return;
			var lang = setting.get() || defaultLang;
			baseIds.forEach( function ( baseId ) {
				var defCtrl = api.control( baseId );
				if ( defCtrl ) {
					defCtrl.active.set( lang === defaultLang );
				}
				api.control.each( function ( control ) {
					if ( control.id.indexOf( baseId + '__' ) === 0 ) {
						var suffix = control.id.slice( ( baseId + '__' ).length );
						control.active.set( suffix === lang );
					}
				} );
			} );
		}

		api.bind( 'ready', function () {
			var setting = api( 'doroshopping_i18n_edit_lang' );
			if ( ! setting ) return;
			setting.bind( function () {
				syncLangVisibility();
				if ( api.previewer ) {
					api.previewer.refresh();
				}
			} );
			syncLangVisibility();
		} );
	})( window.wp && window.wp.customize );
	</script>
	<?php
}
add_action( 'customize_controls_print_footer_scripts', 'doroshopping_customize_i18n_controls_js' );

/**
 * Choices de categorias de producto.
 *
 * @return array
 */
function doroshopping_get_product_category_choices() {
    $cached = get_transient( 'doroshopping_product_cat_choices' );
    if ( false !== $cached && is_array( $cached ) ) {
        return $cached;
    }

    $choices = array( 0 => __( '— Automático / Todas —', 'doroshopping' ) );

    if ( ! taxonomy_exists( 'product_cat' ) ) {
        return $choices;
    }

    $terms = get_terms(
        array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
        )
    );

    if ( is_wp_error( $terms ) || empty( $terms ) ) {
        return $choices;
    }

    foreach ( $terms as $term ) {
        $choices[ $term->term_id ] = $term->name;
    }

    set_transient( 'doroshopping_product_cat_choices', $choices, HOUR_IN_SECONDS );

    return $choices;
}

/**
 * URL de imagen desde attachment ID del customizer.
 *
 * @param string $mod_key  Setting key sin prefijo.
 * @param string $fallback URL fallback.
 * @return string
 */
function doroshopping_get_theme_image_url( $mod_key, $fallback = '' ) {
    $setting = 'doroshopping_' . $mod_key;
    $id      = absint(
        function_exists( 'doroshopping_get_theme_mod' )
            ? doroshopping_get_theme_mod( $setting, 0 )
            : get_theme_mod( $setting, 0 )
    );
    if ( $id ) {
        $url = wp_get_attachment_image_url( $id, 'full' );
        if ( $url ) {
            return $url;
        }
    }
    return $fallback;
}

/**
 * CSS variables desde Customizer.
 */
function doroshopping_customizer_css() {
    $orange = sanitize_hex_color( get_theme_mod( 'doroshopping_color_orange', '#f8942d' ) ) ?: '#f8942d';
    $dark   = sanitize_hex_color( get_theme_mod( 'doroshopping_color_dark', '#1a1a1a' ) ) ?: '#1a1a1a';
    $grey   = sanitize_hex_color( get_theme_mod( 'doroshopping_color_grey_bg', '#f5f5f5' ) ) ?: '#f5f5f5';
    $red    = sanitize_hex_color( get_theme_mod( 'doroshopping_color_red_accent', '#e53935' ) ) ?: '#e53935';
    $footer = sanitize_hex_color( get_theme_mod( 'doroshopping_color_footer_bg', '#000000' ) ) ?: '#000000';

    $css = ':root{';
    $css .= '--color-orange:' . $orange . ';';
    $css .= '--color-dark:' . $dark . ';';
    $css .= '--color-grey-bg:' . $grey . ';';
    $css .= '--color-red-accent:' . $red . ';';
    $css .= '}';
    $css .= '.site-footer{background:' . $footer . ';}';
    $css .= '.site-fab-cart,.site-fab-cart__count,.cart-modal__checkout,.doro-buybox__buy-now,.doro-cesta-summary__cta,.doro-cesta-empty__btn--primary,.woocommerce-checkout #place_order{--doro-cta:' . $red . ';}';
    $css .= '.site-fab-cart{color:var(--doro-cta);}';
    $css .= '.site-fab-cart__count,.cart-modal__checkout,.doro-buybox__buy-now,.doro-cesta-summary__cta:not(.is-disabled),.doro-cesta-empty__btn--primary,.woocommerce-checkout #place_order{background:var(--doro-cta);}';

    wp_add_inline_style( 'doroshopping-main', $css );
}
add_action( 'wp_enqueue_scripts', 'doroshopping_customizer_css', 20 );

/**
 * Productos WC por categoria.
 *
 * @param int    $cat_id Term ID.
 * @param int    $limit  Limit.
 * @param string $orderby Orderby.
 * @return array
 */
function doroshopping_get_products_by_category( $cat_id = 0, $limit = 8, $orderby = 'popularity', $page = 1 ) {
    if ( ! function_exists( 'wc_get_products' ) ) {
        return array();
    }

    $args = array(
        'limit'   => max( 1, (int) $limit ),
        'page'    => max( 1, (int) $page ),
        'status'  => 'publish',
        'orderby' => $orderby,
        'return'  => 'objects',
    );

    $cat_id = absint( $cat_id );
    if ( $cat_id > 0 ) {
        $term = get_term( $cat_id, 'product_cat' );
        if ( $term && ! is_wp_error( $term ) ) {
            $args['category'] = array( $term->slug );
        }
    }

    return wc_get_products( $args );
}
