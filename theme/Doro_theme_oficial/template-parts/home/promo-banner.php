<?php
/**
 * Banner promocional - seccion 3
 *
 * @package Doroshopping
 */

$uri         = get_template_directory_uri() . '/assets/images';
$promo_image = function_exists( 'doroshopping_get_theme_image_url' )
    ? doroshopping_get_theme_image_url( 'promo_image', $uri . '/banners/banner_seccion_3.png' )
    : $uri . '/banners/banner_seccion_3.png';
$shop_url    = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
$products    = array(
    array(
        'image' => $uri . '/products/Producto7.jpg',
        'url'   => $shop_url,
        'alt'   => __( 'Producto destacado 1', 'doroshopping' ),
    ),
    array(
        'image' => $uri . '/products/Producto8.jpg',
        'url'   => $shop_url,
        'alt'   => __( 'Producto destacado 2', 'doroshopping' ),
    ),
    array(
        'image' => $uri . '/products/Producto4.jpg',
        'url'   => $shop_url,
        'alt'   => __( 'Producto destacado 3', 'doroshopping' ),
    ),
);
?>

<section class="home-promo" data-promo-parallax>
    <img class="home-promo__image" src="<?php echo esc_url( $promo_image ); ?>" alt="<?php esc_attr_e( 'Gadgets de Ultima Generacion', 'doroshopping' ); ?>">

    <div class="home-promo__content">
        <h2 class="home-promo__title"><?php esc_html_e( 'Gadgets de Ultima Generacion que no sabias que necesitabas.', 'doroshopping' ); ?></h2>
        <a href="<?php echo esc_url( $shop_url ); ?>" class="home-promo__cta"><?php esc_html_e( 'Comprar', 'doroshopping' ); ?></a>
    </div>

    <div class="home-promo__floats" aria-hidden="false">
        <?php foreach ( $products as $index => $product ) : ?>
            <a
                href="<?php echo esc_url( $product['url'] ); ?>"
                class="home-promo__float home-promo__float--<?php echo esc_attr( (string) ( $index + 1 ) ); ?>"
                data-float="<?php echo esc_attr( (string) ( $index + 1 ) ); ?>"
            >
                <span class="home-promo__float-inner">
                    <img src="<?php echo esc_url( $product['image'] ); ?>" alt="<?php echo esc_attr( $product['alt'] ); ?>">
                </span>
            </a>
        <?php endforeach; ?>
    </div>
</section>
