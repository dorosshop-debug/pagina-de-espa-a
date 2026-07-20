<?php
/**
 * Elementor widget: grid de productos por categoria
 *
 * @package Doroshopping
 */

namespace Doroshopping\Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Products_Grid_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'doroshopping_products_grid';
    }

    public function get_title() {
        return __( 'Grid productos Doro', 'doroshopping' );
    }

    public function get_icon() {
        return 'eicon-products';
    }

    public function get_categories() {
        return array( 'doroshopping', 'woocommerce-elements' );
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_content',
            array( 'label' => __( 'Contenido', 'doroshopping' ) )
        );

        $this->add_control(
            'title',
            array(
                'label'   => __( 'Titulo', 'doroshopping' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Descubre productos unicos.', 'doroshopping' ),
            )
        );

        $choices = array( '0' => __( 'Todas / populares', 'doroshopping' ) );
        if ( taxonomy_exists( 'product_cat' ) ) {
            $terms = get_terms(
                array(
                    'taxonomy'   => 'product_cat',
                    'hide_empty' => false,
                )
            );
            if ( ! is_wp_error( $terms ) ) {
                foreach ( $terms as $term ) {
                    $choices[ (string) $term->term_id ] = $term->name;
                }
            }
        }

        $this->add_control(
            'category',
            array(
                'label'   => __( 'Categoria', 'doroshopping' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'options' => $choices,
                'default' => '0',
            )
        );

        $this->add_control(
            'limit',
            array(
                'label'   => __( 'Cantidad', 'doroshopping' ),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 12,
                'min'     => 1,
                'max'     => 48,
            )
        );

        $this->add_control(
            'columns',
            array(
                'label'   => __( 'Columnas', 'doroshopping' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => '4',
                'options' => array(
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ),
            )
        );

        $this->end_controls_section();
    }

    protected function render() {
        if ( ! function_exists( 'wc_get_products' ) ) {
            echo '<p>' . esc_html__( 'WooCommerce es necesario para este widget.', 'doroshopping' ) . '</p>';
            return;
        }

        $settings = $this->get_settings_for_display();
        $cat_id   = absint( $settings['category'] );
        $limit    = absint( $settings['limit'] ) ?: 12;
        $columns  = absint( $settings['columns'] ) ?: 4;
        $title    = $settings['title'];

        $products = function_exists( 'doroshopping_get_products_by_category' )
            ? doroshopping_get_products_by_category( $cat_id, $limit )
            : wc_get_products(
                array(
                    'limit'  => $limit,
                    'status' => 'publish',
                )
            );

        if ( empty( $products ) ) {
            return;
        }
        ?>
        <section class="home-products doro-elementor-grid">
            <?php if ( $title ) : ?>
                <div class="home-products__header">
                    <span class="home-products__line"></span>
                    <h2 class="home-products__title"><?php echo esc_html( $title ); ?></h2>
                    <span class="home-products__line"></span>
                </div>
            <?php endif; ?>
            <div class="home-products__grid" style="grid-template-columns: repeat(<?php echo esc_attr( (string) $columns ); ?>, 1fr);">
                <?php foreach ( $products as $product ) : ?>
                    <?php
                    $rating = (float) $product->get_average_rating();
                    $count  = (int) $product->get_review_count();
                    ?>
                    <article class="home-product-card">
                        <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="home-product-card__image-wrap">
                            <?php echo wp_kses_post( $product->get_image() ); ?>
                        </a>
                        <div class="home-product-card__info">
                            <p class="home-product-card__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></p>
                            <?php
                            if ( function_exists( 'doroshopping_get_star_rating_html' ) ) {
                                echo doroshopping_get_star_rating_html( $rating, $count ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            }
                            ?>
                            <h3 class="home-product-card__name"><?php echo esc_html( $product->get_name() ); ?></h3>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
        <?php
    }
}
