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

$get_mod = static function ( $key, $default = '' ) {
    return function_exists( 'doroshopping_get_theme_mod' )
        ? doroshopping_get_theme_mod( $key, $default )
        : get_theme_mod( $key, $default );
};

$shop_url   = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
$promo_title = $get_mod(
    'doroshopping_promo_title',
    __( 'Gadgets de Ultima Generacion que no sabias que necesitabas.', 'doroshopping' )
);
$promo_cta = $get_mod( 'doroshopping_promo_cta', __( 'Comprar', 'doroshopping' ) );
$promo_url = $get_mod( 'doroshopping_promo_cta_url', '' );
$promo_url = $promo_url ? esc_url_raw( $promo_url ) : $shop_url;

$float_defaults = array(
    1 => array(
        'image' => $uri . '/products/Producto7.jpg',
        'alt'   => __( 'Producto destacado 1', 'doroshopping' ),
    ),
    2 => array(
        'image' => $uri . '/products/Producto8.jpg',
        'alt'   => __( 'Producto destacado 2', 'doroshopping' ),
    ),
    3 => array(
        'image' => $uri . '/products/Producto4.jpg',
        'alt'   => __( 'Producto destacado 3', 'doroshopping' ),
    ),
);

$products = array();
foreach ( $float_defaults as $index => $fallback ) {
    $image = function_exists( 'doroshopping_get_theme_image_url' )
        ? doroshopping_get_theme_image_url( 'promo_float_' . $index . '_image', $fallback['image'] )
        : $fallback['image'];
    $url   = $get_mod( 'doroshopping_promo_float_' . $index . '_url', '' );
    $url   = $url ? esc_url_raw( $url ) : $shop_url;

    $products[] = array(
        'image' => $image,
        'url'   => $url,
        'alt'   => $fallback['alt'],
    );
}
?>

<section class="home-promo" data-promo-parallax>
    <img class="home-promo__image" src="<?php echo esc_url( $promo_image ); ?>" alt="<?php echo esc_attr( $promo_title ); ?>" loading="lazy" decoding="async">

    <div class="home-promo__content">
        <h2 class="home-promo__title"><?php echo esc_html( $promo_title ); ?></h2>
        <a href="<?php echo esc_url( $promo_url ); ?>" class="home-promo__cta"><?php echo esc_html( $promo_cta ); ?></a>
    </div>

    <div class="home-promo__floats" aria-hidden="false">
        <?php foreach ( $products as $index => $product ) : ?>
            <a
                href="<?php echo esc_url( $product['url'] ); ?>"
                class="home-promo__float home-promo__float--<?php echo esc_attr( (string) ( $index + 1 ) ); ?>"
                data-float="<?php echo esc_attr( (string) ( $index + 1 ) ); ?>"
            >
                <span class="home-promo__float-inner">
                    <img src="<?php echo esc_url( $product['image'] ); ?>" alt="<?php echo esc_attr( $product['alt'] ); ?>" loading="lazy" decoding="async">
                </span>
            </a>
        <?php endforeach; ?>
    </div>
</section>
