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
                <?php
                foreach ( $products as $product ) {
                    $post_object = get_post( $product->get_id() );
                    if ( ! $post_object ) {
                        continue;
                    }
                    setup_postdata( $GLOBALS['post'] = $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
                    echo '<div class="doro-elementor-grid__item">';
                    // Reutilizar markup de tienda (sin <li>).
                    ob_start();
                    wc_get_template_part( 'content', 'product' );
                    $card = ob_get_clean();
                    $card = preg_replace( '/^<li\b[^>]*>/', '<article class="home-product-card product" data-product-id="' . esc_attr( (string) $product->get_id() ) . '">', $card, 1 );
                    $card = preg_replace( '/<\/li>\s*$/', '</article>', $card, 1 );
                    echo $card; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    echo '</div>';
                }
                wp_reset_postdata();
                ?>
            </div>
            <?php
            $more_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
            if ( $cat_id > 0 ) {
                $term_link = get_term_link( $cat_id, 'product_cat' );
                if ( ! is_wp_error( $term_link ) ) {
                    $more_url = $term_link;
                }
            }
            ?>
            <div class="doro-load-more">
                <a class="doro-load-more__btn" href="<?php echo esc_url( $more_url ); ?>">
                    <?php
                    echo esc_html(
                        function_exists( 'doroshopping_ui_text' )
                            ? doroshopping_ui_text( 'doroshopping_ui_home_ver_mas' )
                            : __( 'Ver más', 'doroshopping' )
                    );
                    ?>
                </a>
            </div>
        </section>
        <?php
    }
}
