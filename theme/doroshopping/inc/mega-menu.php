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
                'image'   => $thumbs[0],
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
                    'image'   => $thumbs[ $ci % 2 ],
                    'links'   => $links,
                );
            }
        }

        $panels[] = array(
            'id'      => 'nav-' . $top->ID,
            'label'   => $top->title,
            'icon'    => doroshopping_mega_menu_icon_key( sanitize_title( $top->title ), $top->title ),
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
            'hide_empty' => true,
            'parent'     => 0,
            'number'     => 8,
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
                'hide_empty' => true,
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
                        'hide_empty' => true,
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
                    'image'   => $thumbs[ $ci % 2 ],
                    'links'   => $links,
                );
            }
        } else {
            $columns[] = array(
                'heading' => $parent->name,
                'url'     => get_term_link( $parent ),
                'image'   => $thumbs[ $pi % 2 ],
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
            'columns' => $columns,
        );
    }

    return $panels;
}

/**
 * Fallback estático (sin WooCommerce / sin categorías).
 *
 * @return array
 */
function doroshopping_mega_menu_fallback() {
    $img = get_template_directory_uri() . '/assets/images/banners';
    $shop = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );

    return array(
        array(
            'id'      => 'electronica',
            'label'   => __( 'Electrónica', 'doroshopping' ),
            'icon'    => 'phone',
            'columns' => array(
                array(
                    'heading' => __( 'Teléfonos y Tabletas', 'doroshopping' ),
                    'url'     => $shop,
                    'image'   => $img . '/Banner_mundial_doro.webp',
                    'links'   => array(
                        array( 'label' => __( 'Accesorios para móviles y tabletas', 'doroshopping' ), 'url' => $shop ),
                        array( 'label' => __( 'Auriculares Bluetooth', 'doroshopping' ), 'url' => $shop ),
                        array( 'label' => __( 'Relojes inteligentes', 'doroshopping' ), 'url' => $shop ),
                        array( 'label' => __( 'Teléfonos móviles', 'doroshopping' ), 'url' => $shop ),
                    ),
                ),
                array(
                    'heading' => __( 'Sonido', 'doroshopping' ),
                    'url'     => $shop,
                    'image'   => $img . '/Banner_doro_6.webp',
                    'links'   => array(
                        array( 'label' => __( 'Barras de sonido', 'doroshopping' ), 'url' => $shop ),
                        array( 'label' => __( 'Auriculares inalámbricos', 'doroshopping' ), 'url' => $shop ),
                    ),
                ),
                array(
                    'heading' => __( 'Fotografía y Vídeo', 'doroshopping' ),
                    'url'     => $shop,
                    'image'   => $img . '/Banner_mundial_doro.webp',
                    'links'   => array(
                        array( 'label' => __( 'Cámaras', 'doroshopping' ), 'url' => $shop ),
                        array( 'label' => __( 'Accesorios', 'doroshopping' ), 'url' => $shop ),
                    ),
                ),
            ),
        ),
        array(
            'id'      => 'informatica',
            'label'   => __( 'Informática', 'doroshopping' ),
            'icon'    => 'laptop',
            'columns' => array(
                array(
                    'heading' => __( 'Ordenadores', 'doroshopping' ),
                    'url'     => $shop,
                    'image'   => $img . '/Banner_doro_6.webp',
                    'links'   => array(
                        array( 'label' => __( 'Portátiles', 'doroshopping' ), 'url' => $shop ),
                        array( 'label' => __( 'Monitores', 'doroshopping' ), 'url' => $shop ),
                    ),
                ),
                array(
                    'heading' => __( 'Componentes', 'doroshopping' ),
                    'url'     => $shop,
                    'image'   => $img . '/Banner_mundial_doro.webp',
                    'links'   => array(
                        array( 'label' => __( 'Almacenamiento', 'doroshopping' ), 'url' => $shop ),
                        array( 'label' => __( 'Tarjetas gráficas', 'doroshopping' ), 'url' => $shop ),
                    ),
                ),
            ),
        ),
        array(
            'id'      => 'promociones',
            'label'   => __( 'Promociones & Ofertas', 'doroshopping' ),
            'icon'    => 'tag',
            'columns' => array(
                array(
                    'heading' => __( 'Ofertas', 'doroshopping' ),
                    'url'     => $shop,
                    'image'   => $img . '/Banner_mundial_doro.webp',
                    'links'   => array(
                        array( 'label' => __( 'Súper Ofertas', 'doroshopping' ), 'url' => $shop ),
                        array( 'label' => __( 'Liquidación', 'doroshopping' ), 'url' => $shop ),
                    ),
                ),
            ),
        ),
    );
}
