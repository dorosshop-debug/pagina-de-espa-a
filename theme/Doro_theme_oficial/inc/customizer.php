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
            'description' => __( 'Hero, banner de la seccion 3 y productos flotantes. Los flotantes se configuran mas abajo (imagen + enlace).', 'doroshopping' ),
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
            'default'           => 24,
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'doroshopping_home_featured_limit',
        array(
            'label'       => __( 'Cantidad de productos destacados', 'doroshopping' ),
            'section'     => 'doroshopping_home_grids',
            'type'        => 'number',
            'input_attrs' => array(
                'min' => 4,
                'max' => 48,
            ),
        )
    );

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

    /* ---- BigBuy envío ---- */
    $wp_customize->add_section(
        'doroshopping_bigbuy',
        array(
            'title'       => __( 'BigBuy / Envíos', 'doroshopping' ),
            'description' => __( 'También puedes definir DORO_BIGBUY_API_KEY y DORO_BIGBUY_ENDPOINT en wp-config.php (prioridad sobre estos campos).', 'doroshopping' ),
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
            'description' => __( 'Sin clave se usa la estimación local por país (fallback).', 'doroshopping' ),
        )
    );

    $wp_customize->add_setting(
        'doroshopping_bigbuy_endpoint',
        array(
            'default'           => 'https://api.bigbuy.eu/rest/shipping/orders.json',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        'doroshopping_bigbuy_endpoint',
        array(
            'label'   => __( 'Endpoint shipping BigBuy', 'doroshopping' ),
            'section' => 'doroshopping_bigbuy',
            'type'    => 'url',
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
    $id = absint( get_theme_mod( 'doroshopping_' . $mod_key, 0 ) );
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
function doroshopping_get_products_by_category( $cat_id = 0, $limit = 8, $orderby = 'popularity' ) {
    if ( ! function_exists( 'wc_get_products' ) ) {
        return array();
    }

    $args = array(
        'limit'   => max( 1, (int) $limit ),
        'status'  => 'publish',
        'orderby' => $orderby,
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
