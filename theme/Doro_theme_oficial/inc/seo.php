<?php
/**
 * SEO Schema.org (Product, BreadcrumbList)
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * JSON-LD en ficha de producto.
 */
function doroshopping_product_schema() {
    if ( ! function_exists( 'is_product' ) || ! is_product() ) {
        return;
    }

    global $product;
    if ( ! $product instanceof WC_Product ) {
        $product = wc_get_product( get_the_ID() );
    }
    if ( ! $product ) {
        return;
    }

    $image_id = $product->get_image_id();
    $image    = $image_id ? wp_get_attachment_image_url( $image_id, 'full' ) : '';

    $data = array(
        '@context'    => 'https://schema.org/',
        '@type'       => 'Product',
        'name'        => $product->get_name(),
        'description' => wp_strip_all_tags( $product->get_short_description() ? $product->get_short_description() : $product->get_description() ),
        'sku'         => $product->get_sku(),
        'url'         => get_permalink( $product->get_id() ),
        'image'       => $image ? array( $image ) : array(),
        'offers'      => array(
            '@type'         => 'Offer',
            'url'           => get_permalink( $product->get_id() ),
            'priceCurrency' => get_woocommerce_currency(),
            'price'         => $product->get_price(),
            'availability'  => $product->is_in_stock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
            'itemCondition' => 'https://schema.org/NewCondition',
        ),
    );

    if ( $product->get_review_count() > 0 ) {
        $data['aggregateRating'] = array(
            '@type'       => 'AggregateRating',
            'ratingValue' => $product->get_average_rating(),
            'reviewCount' => $product->get_review_count(),
        );
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'doroshopping_product_schema', 30 );

/**
 * BreadcrumbList schema en tienda / producto / taxonomías.
 */
function doroshopping_breadcrumb_schema() {
    if ( ! function_exists( 'is_woocommerce' ) || ! is_woocommerce() ) {
        return;
    }

    $items   = array();
    $position = 1;

    $items[] = array(
        '@type'    => 'ListItem',
        'position' => $position++,
        'name'     => __( 'Inicio', 'doroshopping' ),
        'item'     => home_url( '/' ),
    );

    if ( function_exists( 'is_shop' ) && ( is_shop() || is_product() || is_product_taxonomy() ) ) {
        $shop_id = wc_get_page_id( 'shop' );
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => $shop_id ? get_the_title( $shop_id ) : __( 'Tienda', 'doroshopping' ),
            'item'     => wc_get_page_permalink( 'shop' ),
        );
    }

    if ( is_product_taxonomy() ) {
        $term = get_queried_object();
        if ( $term && ! is_wp_error( $term ) ) {
            $items[] = array(
                '@type'    => 'ListItem',
                'position' => $position++,
                'name'     => $term->name,
                'item'     => get_term_link( $term ),
            );
        }
    }

    if ( is_product() ) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => get_the_title(),
            'item'     => get_permalink(),
        );
    }

    if ( count( $items ) < 2 ) {
        return;
    }

    $data = array(
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $items,
    );

    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'doroshopping_breadcrumb_schema', 31 );
