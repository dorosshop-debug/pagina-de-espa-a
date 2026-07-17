<?php
/**
 * Hero carousel - 3 slides
 *
 * @package Doroshopping
 */

$uri = get_template_directory_uri() . '/assets/images/banners';

$slides = array(
    array(
        'image'    => $uri . '/hero1.png',
        'title'    => __( 'Tecnologia para tu hogar.', 'doroshopping' ),
        'subtitle' => __( 'Descubre gadgets inteligentes y accesorios esenciales.', 'doroshopping' ),
        'cta'      => __( 'Ver Ofertas', 'doroshopping' ),
        'url'      => '#',
    ),
    array(
        'image'    => $uri . '/hero2.webp',
        'title'    => __( 'Gadgets de ultima generacion.', 'doroshopping' ),
        'subtitle' => __( 'Lo ultimo en tecnologia al mejor precio.', 'doroshopping' ),
        'cta'      => __( 'Comprar ahora', 'doroshopping' ),
        'url'      => '#',
    ),
    array(
        'image'    => $uri . '/hero3.webp',
        'title'    => __( 'Promociones de Verano.', 'doroshopping' ),
        'subtitle' => __( 'Se parte de la alegria del Mundial 2026!', 'doroshopping' ),
        'cta'      => __( 'Ver Ofertas', 'doroshopping' ),
        'url'      => '#',
    ),
);
?>

<section class="home-hero" aria-roledescription="carousel" aria-label="<?php esc_attr_e( 'Promociones principales', 'doroshopping' ); ?>">
    <div class="home-hero__track">
        <?php foreach ( $slides as $index => $slide ) : ?>
            <article class="home-hero__slide<?php echo 0 === $index ? ' is-active' : ''; ?>" data-slide="<?php echo esc_attr( (string) $index ); ?>" <?php echo 0 !== $index ? 'hidden' : ''; ?>>
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
