<?php
/**
 * Mega menu data helpers
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Icono SVG del mega menú.
 *
 * @param string $key Icon key.
 * @return string
 */
function doroshopping_mega_menu_icon( $key = 'tag' ) {
    $icons = array(
        'phone'   => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/></svg>',
        'laptop'  => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>',
        'home'    => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><path d="M9 22V12h6v10"/></svg>',
        'sport'   => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 0 20"/></svg>',
        'tag'     => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><circle cx="7" cy="7" r="1.5"/></svg>',
        'default' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg>',
    );

    return isset( $icons[ $key ] ) ? $icons[ $key ] : $icons['default'];
}

/**
 * Detecta icono por slug/nombre.
 *
 * @param string $slug Slug.
 * @param string $name Name.
 * @return string
 */
function doroshopping_mega_menu_icon_key( $slug, $name = '' ) {
    $hay = strtolower( $slug . ' ' . $name );
    if ( preg_match( '/electro|movil|phone|tablet|tech/', $hay ) ) {
        return 'phone';
    }
    if ( preg_match( '/informa|pc|laptop|ordenad|gaming|compu/', $hay ) ) {
        return 'laptop';
    }
    if ( preg_match( '/hogar|cocina|casa|home/', $hay ) ) {
        return 'home';
    }
    if ( preg_match( '/deporte|sport|fitness|bike/', $hay ) ) {
        return 'sport';
    }
    if ( preg_match( '/oferta|promo|sale/', $hay ) ) {
        return 'tag';
    }
    return 'default';
}

/**
 * Paneles del mega menú.
 *
 * @return array
 */
function doroshopping_get_mega_menu_panels() {
    $cached = get_transient( 'doroshopping_mega_menu_panels' );
    if ( false !== $cached && is_array( $cached ) ) {
        return $cached;
    }

    $panels = doroshopping_mega_menu_from_nav();
    if ( empty( $panels ) ) {
        $panels = doroshopping_mega_menu_from_product_cats();
    }
    if ( empty( $panels ) ) {
        $panels = doroshopping_mega_menu_fallback();
    }

    /**
     * Filtra paneles del mega menú.
     *
     * @param array $panels Panels.
     */
    $panels = apply_filters( 'doroshopping_mega_menu_panels', $panels );

    set_transient( 'doroshopping_mega_menu_panels', $panels, HOUR_IN_SECONDS );

    return $panels;
}

/**
 * Invalida cache del mega menú.
 */
function doroshopping_flush_mega_menu_cache() {
    delete_transient( 'doroshopping_mega_menu_panels' );
    delete_transient( 'doroshopping_product_cat_choices' );
}
add_action( 'edited_product_cat', 'doroshopping_flush_mega_menu_cache' );
add_action( 'created_product_cat', 'doroshopping_flush_mega_menu_cache' );
add_action( 'delete_product_cat', 'doroshopping_flush_mega_menu_cache' );
add_action( 'wp_update_nav_menu', 'doroshopping_flush_mega_menu_cache' );
add_action( 'after_switch_theme', 'doroshopping_flush_mega_menu_cache' );

/**
 * Vaciar cache del mega menú al actualizar versión del tema.
 */
function doroshopping_maybe_flush_mega_menu_on_upgrade() {
    $stored = get_option( 'doroshopping_mega_menu_cache_ver', '' );
    if ( $stored === DOROSHOPPING_VERSION ) {
        return;
    }
    doroshopping_flush_mega_menu_cache();
    update_option( 'doroshopping_mega_menu_cache_ver', DOROSHOPPING_VERSION, false );
}
add_action( 'init', 'doroshopping_maybe_flush_mega_menu_on_upgrade', 5 );

/**
 * Mega menú desde menú asignado a location "categories".
 *
 * Estructura esperada: ítems top-level = pestañas; hijos = columnas; nietos = links.
 *
 * @return array
 */
function doroshopping_mega_menu_from_nav() {
    $locations = get_nav_menu_locations();
    if ( empty( $locations['categories'] ) ) {
        return array();
    }

    $items = wp_get_nav_menu_items( $locations['categories'] );
    if ( empty( $items ) || is_wp_error( $items ) ) {
        return array();
    }

    $by_parent = array();
    foreach ( $items as $item ) {
        $parent = (int) $item->menu_item_parent;
        if ( ! isset( $by_parent[ $parent ] ) ) {
            $by_parent[ $parent ] = array();
        }
        $by_parent[ $parent ][] = $item;
    }

    if ( empty( $by_parent[0] ) ) {
        return array();
    }

    $img    = get_template_directory_uri() . '/assets/images/banners';
    $thumbs = array( $img . '/Banner_mundial_doro.webp', $img . '/Banner_doro_6.webp' );
    $panels = array();

    foreach ( $by_parent[0] as $top ) {
        $columns = array();
        $children = isset( $by_parent[ $top->ID ] ) ? $by_parent[ $top->ID ] : array();

        if ( empty( $children ) ) {
            $columns[] = array(
                'heading' => $top->title,
                'url'     => $top->url,
                'image'   => doroshopping_mega_menu_item_image( $top, $thumbs[0] ),
                'links'   => array(
                    array(
                        'label' => __( 'Ver categoría', 'doroshopping' ),
                        'url'   => $top->url,
                    ),
                ),
            );
        } else {
            foreach ( $children as $ci => $child ) {
                $links = array();
                $grand = isset( $by_parent[ $child->ID ] ) ? $by_parent[ $child->ID ] : array();
                foreach ( $grand as $g ) {
                    $links[] = array(
                        'label' => $g->title,
                        'url'   => $g->url,
                    );
                }
                if ( empty( $links ) ) {
                    $links[] = array(
                        'label' => __( 'Ver todo', 'doroshopping' ),
                        'url'   => $child->url,
                    );
                }
                $columns[] = array(
                    'heading' => $child->title,
                    'url'     => $child->url,
                    'image'   => doroshopping_mega_menu_item_image( $child, $thumbs[ $ci % 2 ] ),
                    'links'   => $links,
                );
            }
        }

        $panels[] = array(
            'id'      => 'nav-' . $top->ID,
            'label'   => $top->title,
            'icon'    => doroshopping_mega_menu_icon_key( sanitize_title( $top->title ), $top->title ),
            'url'     => $top->url,
            'columns' => $columns,
        );
    }

    return $panels;
}

/**
 * Mega menú desde product_cat (padres + hijos).
 *
 * @return array
 */
function doroshopping_mega_menu_from_product_cats() {
    if ( ! taxonomy_exists( 'product_cat' ) ) {
        return array();
    }

    $parents = get_terms(
        array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
            'parent'     => 0,
            'number'     => 12,
        )
    );

    if ( is_wp_error( $parents ) || empty( $parents ) ) {
        return array();
    }

    $img    = get_template_directory_uri() . '/assets/images/banners';
    $thumbs = array( $img . '/Banner_mundial_doro.webp', $img . '/Banner_doro_6.webp' );
    $panels = array();

    foreach ( $parents as $pi => $parent ) {
        $children = get_terms(
            array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => false,
                'parent'     => $parent->term_id,
                'number'     => 6,
            )
        );

        $columns = array();
        if ( ! is_wp_error( $children ) && ! empty( $children ) ) {
            foreach ( $children as $ci => $child ) {
                $grand = get_terms(
                    array(
                        'taxonomy'   => 'product_cat',
                        'hide_empty' => false,
                        'parent'     => $child->term_id,
                        'number'     => 8,
                    )
                );
                $links = array();
                if ( ! is_wp_error( $grand ) && ! empty( $grand ) ) {
                    foreach ( $grand as $g ) {
                        $links[] = array(
                            'label' => $g->name,
                            'url'   => get_term_link( $g ),
                        );
                    }
                } else {
                    $links[] = array(
                        'label' => __( 'Ver todo', 'doroshopping' ),
                        'url'   => get_term_link( $child ),
                    );
                }
                $columns[] = array(
                    'heading' => $child->name,
                    'url'     => get_term_link( $child ),
                    'image'   => doroshopping_mega_menu_term_image( $child->term_id, $thumbs[ $ci % 2 ] ),
                    'links'   => $links,
                );
            }
        } else {
            $columns[] = array(
                'heading' => $parent->name,
                'url'     => get_term_link( $parent ),
                'image'   => doroshopping_mega_menu_term_image( $parent->term_id, $thumbs[ $pi % 2 ] ),
                'links'   => array(
                    array(
                        'label' => __( 'Ver categoría', 'doroshopping' ),
                        'url'   => get_term_link( $parent ),
                    ),
                ),
            );
        }

        $panels[] = array(
            'id'      => 'cat-' . $parent->term_id,
            'label'   => $parent->name,
            'icon'    => doroshopping_mega_menu_icon_key( $parent->slug, $parent->name ),
            'url'     => get_term_link( $parent ),
            'columns' => $columns,
        );
    }

    return $panels;
}

/**
 * URL de categoría por slug (o shop como fallback).
 *
 * @param string $slug Slug product_cat.
 * @return string
 */
function doroshopping_mega_menu_term_url( $slug ) {
    if ( taxonomy_exists( 'product_cat' ) ) {
        $term = get_term_by( 'slug', $slug, 'product_cat' );
        if ( $term && ! is_wp_error( $term ) ) {
            $link = get_term_link( $term );
            if ( ! is_wp_error( $link ) ) {
                return $link;
            }
        }
    }

    return function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
}

/**
 * Imagen de categoría de producto (miniatura WC) o fallback.
 *
 * @param int    $term_id Term ID.
 * @param string $fallback Fallback URL.
 * @return string
 */
function doroshopping_mega_menu_term_image( $term_id, $fallback = '' ) {
    $term_id = absint( $term_id );
    if ( ! $term_id ) {
        return $fallback;
    }

    $thumb_id = absint( get_term_meta( $term_id, 'thumbnail_id', true ) );
    if ( ! $thumb_id && function_exists( 'get_woocommerce_term_meta' ) ) {
        // Compat tiendas antiguas.
        $thumb_id = absint( get_woocommerce_term_meta( $term_id, 'thumbnail_id', true ) );
    }

    if ( $thumb_id ) {
        // Miniaturas compactas para el mega menú (evitar full/large).
        foreach ( array( 'woocommerce_thumbnail', 'medium', 'thumbnail', 'medium_large' ) as $size ) {
            $url = wp_get_attachment_image_url( $thumb_id, $size );
            if ( $url ) {
                return $url;
            }
        }
    }

    return $fallback;
}

/**
 * Imagen para un ítem del menú (prioriza miniatura de product_cat).
 *
 * @param object $item     WP menu item.
 * @param string $fallback Fallback URL.
 * @return string
 */
function doroshopping_mega_menu_item_image( $item, $fallback = '' ) {
    if ( ! $item ) {
        return $fallback;
    }

    // Enlace directo a categoría de producto.
    if ( isset( $item->type, $item->object, $item->object_id )
        && 'taxonomy' === $item->type
        && 'product_cat' === $item->object
    ) {
        $img = doroshopping_mega_menu_term_image( (int) $item->object_id, '' );
        if ( $img ) {
            return $img;
        }
    }

    // Intentar resolver por URL / slug si es enlace personalizado.
    if ( ! empty( $item->url ) && taxonomy_exists( 'product_cat' ) ) {
        $path = wp_parse_url( $item->url, PHP_URL_PATH );
        if ( is_string( $path ) && '' !== $path ) {
            $slug = basename( untrailingslashit( $path ) );
            if ( $slug && 'product-category' !== $slug ) {
                $term = get_term_by( 'slug', $slug, 'product_cat' );
                if ( $term && ! is_wp_error( $term ) ) {
                    $img = doroshopping_mega_menu_term_image( (int) $term->term_id, '' );
                    if ( $img ) {
                        return $img;
                    }
                }
            }
        }
    }

    return $fallback;
}

/**
 * Fallback estático (sin WooCommerce / sin categorías).
 *
 * @return array
 */
function doroshopping_mega_menu_fallback() {
    $img = get_template_directory_uri() . '/assets/images/banners';

    $electronica = doroshopping_mega_menu_term_url( 'electronica' );
    $informatica  = doroshopping_mega_menu_term_url( 'informatica' );
    $hogar        = doroshopping_mega_menu_term_url( 'hogar-y-cocina' );
    $deportes     = doroshopping_mega_menu_term_url( 'deportes-y-recreacion' );
    $promociones  = doroshopping_mega_menu_term_url( 'promociones-ofertas' );

    return array(
        array(
            'id'      => 'electronica',
            'label'   => __( 'Electrónica', 'doroshopping' ),
            'icon'    => 'phone',
            'url'     => $electronica,
            'columns' => array(
                array(
                    'heading' => __( 'Teléfonos y Tabletas', 'doroshopping' ),
                    'url'     => $electronica,
                    'image'   => $img . '/Banner_mundial_doro.webp',
                    'links'   => array(
                        array( 'label' => __( 'Accesorios para móviles y tabletas', 'doroshopping' ), 'url' => $electronica ),
                        array( 'label' => __( 'Auriculares Bluetooth', 'doroshopping' ), 'url' => $electronica ),
                        array( 'label' => __( 'Relojes inteligentes', 'doroshopping' ), 'url' => $electronica ),
                        array( 'label' => __( 'Teléfonos móviles', 'doroshopping' ), 'url' => $electronica ),
                    ),
                ),
                array(
                    'heading' => __( 'Sonido', 'doroshopping' ),
                    'url'     => $electronica,
                    'image'   => $img . '/Banner_doro_6.webp',
                    'links'   => array(
                        array( 'label' => __( 'Barras de sonido', 'doroshopping' ), 'url' => $electronica ),
                        array( 'label' => __( 'Auriculares inalámbricos', 'doroshopping' ), 'url' => $electronica ),
                    ),
                ),
                array(
                    'heading' => __( 'Fotografía y Vídeo', 'doroshopping' ),
                    'url'     => $electronica,
                    'image'   => $img . '/Banner_mundial_doro.webp',
                    'links'   => array(
                        array( 'label' => __( 'Cámaras', 'doroshopping' ), 'url' => $electronica ),
                        array( 'label' => __( 'Accesorios', 'doroshopping' ), 'url' => $electronica ),
                    ),
                ),
            ),
        ),
        array(
            'id'      => 'informatica',
            'label'   => __( 'Informática', 'doroshopping' ),
            'icon'    => 'laptop',
            'url'     => $informatica,
            'columns' => array(
                array(
                    'heading' => __( 'Ordenadores', 'doroshopping' ),
                    'url'     => $informatica,
                    'image'   => $img . '/Banner_doro_6.webp',
                    'links'   => array(
                        array( 'label' => __( 'Portátiles', 'doroshopping' ), 'url' => $informatica ),
                        array( 'label' => __( 'Monitores', 'doroshopping' ), 'url' => $informatica ),
                    ),
                ),
                array(
                    'heading' => __( 'Componentes', 'doroshopping' ),
                    'url'     => $informatica,
                    'image'   => $img . '/Banner_mundial_doro.webp',
                    'links'   => array(
                        array( 'label' => __( 'Almacenamiento', 'doroshopping' ), 'url' => $informatica ),
                        array( 'label' => __( 'Tarjetas gráficas', 'doroshopping' ), 'url' => $informatica ),
                    ),
                ),
                array(
                    'heading' => __( 'Periféricos', 'doroshopping' ),
                    'url'     => $informatica,
                    'image'   => $img . '/Banner_doro_6.webp',
                    'links'   => array(
                        array( 'label' => __( 'Teclados', 'doroshopping' ), 'url' => $informatica ),
                        array( 'label' => __( 'Ratones', 'doroshopping' ), 'url' => $informatica ),
                    ),
                ),
            ),
        ),
        array(
            'id'      => 'hogar',
            'label'   => __( 'Hogar y Cocina', 'doroshopping' ),
            'icon'    => 'home',
            'url'     => $hogar,
            'columns' => array(
                array(
                    'heading' => __( 'Cocina', 'doroshopping' ),
                    'url'     => $hogar,
                    'image'   => $img . '/Banner_mundial_doro.webp',
                    'links'   => array(
                        array( 'label' => __( 'Cafeteras', 'doroshopping' ), 'url' => $hogar ),
                        array( 'label' => __( 'Robot de cocina', 'doroshopping' ), 'url' => $hogar ),
                    ),
                ),
                array(
                    'heading' => __( 'Hogar inteligente', 'doroshopping' ),
                    'url'     => $hogar,
                    'image'   => $img . '/Banner_doro_6.webp',
                    'links'   => array(
                        array( 'label' => __( 'Iluminación', 'doroshopping' ), 'url' => $hogar ),
                        array( 'label' => __( 'Seguridad', 'doroshopping' ), 'url' => $hogar ),
                    ),
                ),
                array(
                    'heading' => __( 'Gadgets', 'doroshopping' ),
                    'url'     => $hogar,
                    'image'   => $img . '/Banner_mundial_doro.webp',
                    'links'   => array(
                        array( 'label' => __( 'Organizadores', 'doroshopping' ), 'url' => $hogar ),
                        array( 'label' => __( 'Limpieza', 'doroshopping' ), 'url' => $hogar ),
                    ),
                ),
            ),
        ),
        array(
            'id'      => 'deportes',
            'label'   => __( 'Deportes y Recreación', 'doroshopping' ),
            'icon'    => 'sport',
            'url'     => $deportes,
            'columns' => array(
                array(
                    'heading' => __( 'Outdoor', 'doroshopping' ),
                    'url'     => $deportes,
                    'image'   => $img . '/Banner_doro_6.webp',
                    'links'   => array(
                        array( 'label' => __( 'Camping', 'doroshopping' ), 'url' => $deportes ),
                        array( 'label' => __( 'Ciclismo', 'doroshopping' ), 'url' => $deportes ),
                    ),
                ),
                array(
                    'heading' => __( 'Fitness', 'doroshopping' ),
                    'url'     => $deportes,
                    'image'   => $img . '/Banner_mundial_doro.webp',
                    'links'   => array(
                        array( 'label' => __( 'Pesas', 'doroshopping' ), 'url' => $deportes ),
                        array( 'label' => __( 'Yoga', 'doroshopping' ), 'url' => $deportes ),
                    ),
                ),
                array(
                    'heading' => __( 'Recreación', 'doroshopping' ),
                    'url'     => $deportes,
                    'image'   => $img . '/Banner_doro_6.webp',
                    'links'   => array(
                        array( 'label' => __( 'Juegos', 'doroshopping' ), 'url' => $deportes ),
                        array( 'label' => __( 'Accesorios', 'doroshopping' ), 'url' => $deportes ),
                    ),
                ),
            ),
        ),
        array(
            'id'      => 'promociones',
            'label'   => __( 'Promociones & Ofertas', 'doroshopping' ),
            'icon'    => 'tag',
            'url'     => $promociones,
            'columns' => array(
                array(
                    'heading' => __( 'Ofertas', 'doroshopping' ),
                    'url'     => $promociones,
                    'image'   => $img . '/Banner_mundial_doro.webp',
                    'links'   => array(
                        array( 'label' => __( 'Súper Ofertas', 'doroshopping' ), 'url' => $promociones ),
                        array( 'label' => __( 'Liquidación', 'doroshopping' ), 'url' => $promociones ),
                    ),
                ),
                array(
                    'heading' => __( 'Lanzamientos', 'doroshopping' ),
                    'url'     => $promociones,
                    'image'   => $img . '/Banner_doro_6.webp',
                    'links'   => array(
                        array( 'label' => __( 'Novedades', 'doroshopping' ), 'url' => $promociones ),
                        array( 'label' => __( 'Tendencias', 'doroshopping' ), 'url' => $promociones ),
                    ),
                ),
                array(
                    'heading' => __( 'Reacondicionados', 'doroshopping' ),
                    'url'     => $promociones,
                    'image'   => $img . '/Banner_mundial_doro.webp',
                    'links'   => array(
                        array( 'label' => __( 'Remanufacturados', 'doroshopping' ), 'url' => $promociones ),
                    ),
                ),
            ),
        ),
    );
}
