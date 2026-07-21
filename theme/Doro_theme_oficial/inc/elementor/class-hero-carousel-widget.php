<?php
/**
 * Elementor widget: Hero carousel Doroshopping
 *
 * @package Doroshopping
 */

namespace Doroshopping\Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Hero_Carousel_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'doroshopping_hero_carousel';
    }

    public function get_title() {
        return __( 'Hero Carrusel Doro', 'doroshopping' );
    }

    public function get_icon() {
        return 'eicon-slider-push';
    }

    public function get_categories() {
        return array( 'doroshopping' );
    }

    public function get_keywords() {
        return array( 'hero', 'banner', 'carousel', 'slider', 'doro' );
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_slides',
            array( 'label' => __( 'Slides', 'doroshopping' ) )
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'image',
            array(
                'label'   => __( 'Imagen', 'doroshopping' ),
                'type'    => \Elementor\Controls_Manager::MEDIA,
                'default' => array( 'url' => '' ),
            )
        );

        $repeater->add_control(
            'title',
            array(
                'label'   => __( 'Titulo', 'doroshopping' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Titulo del slide', 'doroshopping' ),
            )
        );

        $repeater->add_control(
            'subtitle',
            array(
                'label'   => __( 'Subtitulo', 'doroshopping' ),
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __( 'Texto de apoyo', 'doroshopping' ),
            )
        );

        $repeater->add_control(
            'cta_text',
            array(
                'label'   => __( 'Texto CTA', 'doroshopping' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Ver Ofertas', 'doroshopping' ),
            )
        );

        $repeater->add_control(
            'cta_url',
            array(
                'label'       => __( 'Enlace CTA', 'doroshopping' ),
                'type'        => \Elementor\Controls_Manager::URL,
                'placeholder' => 'https://',
                'default'     => array( 'url' => '#' ),
            )
        );

        $repeater->add_control(
            'text_align',
            array(
                'label'   => __( 'Orientacion del texto', 'doroshopping' ),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => array(
                    'left'  => array(
                        'title' => __( 'Izquierda', 'doroshopping' ),
                        'icon'  => 'eicon-text-align-left',
                    ),
                    'right' => array(
                        'title' => __( 'Derecha', 'doroshopping' ),
                        'icon'  => 'eicon-text-align-right',
                    ),
                ),
                'default' => 'left',
                'toggle'  => false,
            )
        );

        $this->add_control(
            'slides',
            array(
                'label'       => __( 'Slides del hero', 'doroshopping' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => array(
                    array(
                        'title'      => __( 'Tecnologia para tu hogar.', 'doroshopping' ),
                        'subtitle'   => __( 'Descubre gadgets inteligentes y accesorios esenciales.', 'doroshopping' ),
                        'cta_text'   => __( 'Ver Ofertas', 'doroshopping' ),
                        'text_align' => 'left',
                    ),
                    array(
                        'title'      => __( 'Gadgets de ultima generacion.', 'doroshopping' ),
                        'subtitle'   => __( 'Lo ultimo en tecnologia al mejor precio.', 'doroshopping' ),
                        'cta_text'   => __( 'Comprar ahora', 'doroshopping' ),
                        'text_align' => 'left',
                    ),
                    array(
                        'title'      => __( 'Promociones de Verano.', 'doroshopping' ),
                        'subtitle'   => __( 'Se parte de la alegria del Mundial 2026!', 'doroshopping' ),
                        'cta_text'   => __( 'Ver Ofertas', 'doroshopping' ),
                        'text_align' => 'right',
                    ),
                ),
                'title_field' => '{{{ title }}}',
            )
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $slides   = isset( $settings['slides'] ) ? $settings['slides'] : array();

        if ( empty( $slides ) ) {
            return;
        }
        ?>
        <section class="home-hero" aria-roledescription="carousel" aria-label="<?php esc_attr_e( 'Promociones principales', 'doroshopping' ); ?>">
            <div class="home-hero__track">
                <?php foreach ( $slides as $index => $slide ) : ?>
                    <?php
                    $align = ( isset( $slide['text_align'] ) && 'right' === $slide['text_align'] ) ? 'right' : 'left';
                    $class = 'home-hero__slide home-hero__slide--align-' . $align;
                    if ( 0 === $index ) {
                        $class .= ' is-active';
                    }
                    $image = ! empty( $slide['image']['url'] ) ? $slide['image']['url'] : '';
                    $url   = ! empty( $slide['cta_url']['url'] ) ? $slide['cta_url']['url'] : '#';
                    $target = ! empty( $slide['cta_url']['is_external'] ) ? ' target="_blank"' : '';
                    $rel    = ! empty( $slide['cta_url']['nofollow'] ) ? ' rel="nofollow"' : '';
                    ?>
                    <article class="<?php echo esc_attr( $class ); ?>" data-slide="<?php echo esc_attr( (string) $index ); ?>" <?php echo 0 !== $index ? 'hidden' : ''; ?>>
                        <?php if ( $image ) : ?>
                            <img class="home-hero__image" src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $slide['title'] ); ?>">
                        <?php endif; ?>
                        <div class="home-hero__content">
                            <?php if ( ! empty( $slide['title'] ) ) : ?>
                                <h2 class="home-hero__title"><?php echo esc_html( $slide['title'] ); ?></h2>
                            <?php endif; ?>
                            <?php if ( ! empty( $slide['subtitle'] ) ) : ?>
                                <p class="home-hero__subtitle"><?php echo esc_html( $slide['subtitle'] ); ?></p>
                            <?php endif; ?>
                            <?php if ( ! empty( $slide['cta_text'] ) ) : ?>
                                <a href="<?php echo esc_url( $url ); ?>" class="home-hero__cta"<?php echo $target . $rel; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $slide['cta_text'] ); ?></a>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <?php if ( count( $slides ) > 1 ) : ?>
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
            <?php endif; ?>
        </section>
        <?php
    }
}
