<?php
/**
 * AJAX busqueda en vivo (estilo FiboSearch)
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Endpoint de busqueda de productos.
 */
function doroshopping_ajax_live_search() {
    check_ajax_referer( 'doroshopping_search', 'nonce' );

    if ( function_exists( 'doroshopping_rate_limit' ) && ! doroshopping_rate_limit( 'live_search', 40, 60 ) ) {
        doroshopping_rate_limit_ajax_block();
    }

    $term = isset( $_GET['term'] ) ? sanitize_text_field( wp_unslash( $_GET['term'] ) ) : '';
    $term = trim( $term );
    if ( strlen( $term ) > 80 ) {
        $term = substr( $term, 0, 80 );
    }

    if ( strlen( $term ) < 2 ) {
        wp_send_json_success(
            array(
                'items'      => array(),
                'total'      => 0,
                'search_url' => home_url( '/?s=' . rawurlencode( $term ) . '&post_type=product' ),
            )
        );
    }

    $items = array();
    $total = 0;

    if ( function_exists( 'wc_get_products' ) ) {
        $query_args = array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            's'              => $term,
            'posts_per_page' => 8,
            'orderby'        => 'relevance',
        );
        if ( function_exists( 'doroshopping_pll_product_query_args' ) ) {
            $query_args = doroshopping_pll_product_query_args( $query_args );
        }
        $query = new WP_Query( $query_args );

        $total = (int) $query->found_posts;

        while ( $query->have_posts() ) {
            $query->the_post();
            $product = wc_get_product( get_the_ID() );
            if ( ! $product ) {
                continue;
            }

            $image_id = $product->get_image_id();
            $items[]  = array(
                'id'         => $product->get_id(),
                'title'      => wp_strip_all_tags( $product->get_name() ),
                'url'        => $product->get_permalink(),
                'price_html' => $product->get_price_html(),
                'image'      => $image_id
                    ? wp_get_attachment_image_url( $image_id, 'thumbnail' )
                    : wc_placeholder_img_src( 'thumbnail' ),
                'sku'        => wp_strip_all_tags( (string) $product->get_sku() ),
            );
        }
        wp_reset_postdata();
    } else {
        $query = new WP_Query(
            array(
                'post_type'      => 'post',
                'post_status'    => 'publish',
                's'              => $term,
                'posts_per_page' => 8,
            )
        );
        $total = (int) $query->found_posts;
        while ( $query->have_posts() ) {
            $query->the_post();
            $items[] = array(
                'id'         => get_the_ID(),
                'title'      => get_the_title(),
                'url'        => get_permalink(),
                'price_html' => '',
                'image'      => get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ) ?: '',
                'sku'        => '',
            );
        }
        wp_reset_postdata();
    }

    $search_url = add_query_arg(
        array(
            's'         => $term,
            'post_type' => 'product',
        ),
        home_url( '/' )
    );

    wp_send_json_success(
        array(
            'items'      => $items,
            'total'      => $total,
            'search_url' => $search_url,
        )
    );
}
add_action( 'wp_ajax_doroshopping_live_search', 'doroshopping_ajax_live_search' );
add_action( 'wp_ajax_nopriv_doroshopping_live_search', 'doroshopping_ajax_live_search' );
