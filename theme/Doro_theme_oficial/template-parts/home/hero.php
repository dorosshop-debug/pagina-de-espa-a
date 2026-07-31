<?php
/**
 * Hero carousel - imagenes/textos/alineacion desde Customizer
 *
 * @package Doroshopping
 */

$uri      = get_template_directory_uri() . '/assets/images/banners';
$defaults = array(
    1 => array(
        'image'    => $uri . '/hero1.png',
        'title'    => __( 'Tecnologia para tu hogar.', 'doroshopping' ),
        'subtitle' => __( 'Descubre gadgets inteligentes y accesorios esenciales.', 'doroshopping' ),
        'cta'      => __( 'Ultimos productos', 'doroshopping' ),
        'url'      => function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ),
        'align'    => 'left',
    ),
    2 => array(
        'image'    => $uri . '/hero2.webp',
        'title'    => __( 'Gadgets de ultima generacion.', 'doroshopping' ),
        'subtitle' => __( 'Lo ultimo en tecnologia al mejor precio.', 'doroshopping' ),
        'cta'      => __( 'Comprar ahora', 'doroshopping' ),
        'url'      => function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ),
        'align'    => 'left',
    ),
    3 => array(
        'image'    => $uri . '/hero3.webp',
        'title'    => __( 'Promociones de Verano.', 'doroshopping' ),
        'subtitle' => __( 'Se parte de la alegria del Mundial 2026!', 'doroshopping' ),
        'cta'      => __( 'Ver Ofertas', 'doroshopping' ),
        'url'      => function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ),
        'align'    => 'right',
    ),
);

$get_mod = static function ( $key, $default = '' ) {
    return function_exists( 'doroshopping_get_theme_mod' )
        ? doroshopping_get_theme_mod( $key, $default )
        : get_theme_mod( $key, $default );
};

$slides = array();
foreach ( $defaults as $i => $default ) {
    $image = function_exists( 'doroshopping_get_theme_image_url' )
        ? doroshopping_get_theme_image_url( 'hero_' . $i . '_image', $default['image'] )
        : $default['image'];
    $title = $get_mod( 'doroshopping_hero_' . $i . '_title', '' );
    $sub   = $get_mod( 'doroshopping_hero_' . $i . '_subtitle', '' );
    $cta   = $get_mod( 'doroshopping_hero_' . $i . '_cta', '' );
    $url   = $get_mod( 'doroshopping_hero_' . $i . '_url', '' );
    $align = $get_mod( 'doroshopping_hero_' . $i . '_align', $default['align'] );
    if ( ! in_array( $align, array( 'left', 'right' ), true ) ) {
        $align = $default['align'];
    }

    $slides[] = array(
        'image'    => $image,
        'title'    => $title ? $title : $default['title'],
        'subtitle' => $sub ? $sub : $default['subtitle'],
        'cta'      => $cta ? $cta : $default['cta'],
        'url'      => $url ? $url : $default['url'],
        'align'    => $align,
    );
}
?>

<section class="home-hero" aria-roledescription="carousel" aria-label="<?php esc_attr_e( 'Promociones principales', 'doroshopping' ); ?>">
    <div class="home-hero__track">
        <?php foreach ( $slides as $index => $slide ) : ?>
            <?php
            $slide_class = 'home-hero__slide home-hero__slide--align-' . $slide['align'];
            if ( 0 === $index ) {
                $slide_class .= ' is-active';
            }
            ?>
            <article class="<?php echo esc_attr( $slide_class ); ?>" data-slide="<?php echo esc_attr( (string) $index ); ?>" <?php echo 0 !== $index ? 'hidden' : ''; ?>>
                <img class="home-hero__image" src="<?php echo esc_url( $slide['image'] ); ?>" alt="<?php echo esc_attr( $slide['title'] ); ?>">
                <div class="home-hero__content">
                    <h2 class="home-hero__title"><?php echo esc_html( $slide['title'] ); ?></h2>
                    <p class="home-hero__subtitle"><?php echo esc_html( $slide['subtitle'] ); ?></p>
                    <a href="<?php echo esc_url( $slide['url'] ); ?>" class="home-hero__cta"><?php echo esc_html( $slide['cta'] ); ?></a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

    <button type="button" class="home-hero__nav home-hero__nav--prev" aria-label="<?php esc_attr_e( 'Anterior', 'doroshopping' ); ?>">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M15 18l-6-6 6-6"/></svg>
    </button>
    <button type="button" class="home-hero__nav home-hero__nav--next" aria-label="<?php esc_attr_e( 'Siguiente', 'doroshopping' ); ?>">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
    </button>

    <div class="home-hero__dots" role="tablist">
        <?php foreach ( $slides as $index => $slide ) : ?>
            <button type="button" class="home-hero__dot<?php echo 0 === $index ? ' is-active' : ''; ?>" data-slide="<?php echo esc_attr( (string) $index ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Ir a slide %d', 'doroshopping' ), $index + 1 ) ); ?>"></button>
        <?php endforeach; ?>
    </div>
</section>
