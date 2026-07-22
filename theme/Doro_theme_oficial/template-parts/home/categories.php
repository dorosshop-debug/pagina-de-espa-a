<?php
/**
 * Categorias & Ofertas - 2 bloques
 * Titulos y categorias desde Customizer; productos desde WooCommerce.
 *
 * @package Doroshopping
 */

$products_uri = get_template_directory_uri() . '/assets/images/products';
$cat_uri      = get_template_directory_uri() . '/assets/images/categories';

if ( ! function_exists( 'doroshopping_map_wc_products_for_carousel' ) ) {
    /**
     * Convierte productos WC a datos de carrusel.
     *
     * @param array $wc_products WC_Product[].
     * @return array
     */
    function doroshopping_map_wc_products_for_carousel( $wc_products ) {
        $out = array();
        foreach ( $wc_products as $product ) {
            $image_id = $product->get_image_id();
            $out[]    = array(
                'image' => $image_id ? wp_get_attachment_image_url( $image_id, 'woocommerce_thumbnail' ) : wc_placeholder_img_src( 'woocommerce_thumbnail' ),
                'name'  => $product->get_name(),
                'price' => wp_strip_all_tags( $product->get_price_html() ),
                'url'   => $product->get_permalink(),
            );
        }
        return $out;
    }
}

$fallback_left = array(
    array( 'image' => $products_uri . '/Producto1.jpg', 'name' => __( 'Auriculares', 'doroshopping' ), 'price' => '23.99 EUR', 'url' => '#' ),
    array( 'image' => $products_uri . '/Producto2.png', 'name' => __( 'Monitor', 'doroshopping' ), 'price' => '45.50 EUR', 'url' => '#' ),
    array( 'image' => $products_uri . '/Producto3.jpg', 'name' => __( 'Cable USB-C', 'doroshopping' ), 'price' => '12.99 EUR', 'url' => '#' ),
    array( 'image' => $products_uri . '/Producto4.jpg', 'name' => __( 'Teclado RGB', 'doroshopping' ), 'price' => '89.00 EUR', 'url' => '#' ),
    array( 'image' => $products_uri . '/Producto5.jpg', 'name' => __( 'Raton', 'doroshopping' ), 'price' => '34.75 EUR', 'url' => '#' ),
    array( 'image' => $products_uri . '/Producto6.jpg', 'name' => __( 'Tablet', 'doroshopping' ), 'price' => '156.00 EUR', 'url' => '#' ),
);

$fallback_right = array(
    array( 'image' => $products_uri . '/Producto7.jpg', 'name' => __( 'Altavoz', 'doroshopping' ), 'price' => '28.50 EUR', 'url' => '#' ),
    array( 'image' => $products_uri . '/Producto8.jpg', 'name' => __( 'Smartwatch', 'doroshopping' ), 'price' => '67.99 EUR', 'url' => '#' ),
    array( 'image' => $products_uri . '/Producto1.jpg', 'name' => __( 'Auriculares Pro', 'doroshopping' ), 'price' => '39.99 EUR', 'url' => '#' ),
    array( 'image' => $products_uri . '/Producto3.jpg', 'name' => __( 'Accesorio', 'doroshopping' ), 'price' => '9.99 EUR', 'url' => '#' ),
    array( 'image' => $products_uri . '/Producto5.jpg', 'name' => __( 'Periferico', 'doroshopping' ), 'price' => '22.00 EUR', 'url' => '#' ),
    array( 'image' => $products_uri . '/Producto2.png', 'name' => __( 'Pantalla', 'doroshopping' ), 'price' => '119.00 EUR', 'url' => '#' ),
);

$cat_1 = absint( get_theme_mod( 'doroshopping_home_block_1_cat', 0 ) );
$cat_2 = absint( get_theme_mod( 'doroshopping_home_block_2_cat', 0 ) );

$products_left  = function_exists( 'doroshopping_get_products_by_category' ) ? doroshopping_get_products_by_category( $cat_1, 6 ) : array();
$products_right = function_exists( 'doroshopping_get_products_by_category' ) ? doroshopping_get_products_by_category( $cat_2, 6 ) : array();

/**
 * URL de archivo de categoría WC (o #).
 *
 * @param int $term_id Term ID.
 * @return string
 */
$doroshopping_tile_url = static function ( $term_id ) {
    $term_id = absint( $term_id );
    if ( $term_id <= 0 || ! taxonomy_exists( 'product_cat' ) ) {
        return '#';
    }
    $link = get_term_link( $term_id, 'product_cat' );
    return is_wp_error( $link ) ? '#' : $link;
};

$tile_1 = absint( get_theme_mod( 'doroshopping_home_tile_1_cat', 0 ) );
$tile_2 = absint( get_theme_mod( 'doroshopping_home_tile_2_cat', 0 ) );
$tile_3 = absint( get_theme_mod( 'doroshopping_home_tile_3_cat', 0 ) );
$tile_4 = absint( get_theme_mod( 'doroshopping_home_tile_4_cat', 0 ) );

$block_left = array(
    'title'      => get_theme_mod( 'doroshopping_home_block_1_title', __( 'Tecnologia para tu hogar', 'doroshopping' ) ),
    'products'   => ! empty( $products_left ) ? doroshopping_map_wc_products_for_carousel( $products_left ) : $fallback_left,
    'categories' => array(
        array(
            'image' => $cat_uri . '/auriculares.png',
            'label' => __( 'Microfonos y auriculares', 'doroshopping' ),
            'url'   => $doroshopping_tile_url( $tile_1 ),
            'file'  => 'auriculares.png',
        ),
        array(
            'image' => $cat_uri . '/videjuegos.png',
            'label' => __( 'Gaming', 'doroshopping' ),
            'url'   => $doroshopping_tile_url( $tile_2 ),
            'file'  => 'videjuegos.png',
        ),
    ),
);

$block_right = array(
    'title'      => get_theme_mod( 'doroshopping_home_block_2_title', __( 'Promociones de Lanzamiento', 'doroshopping' ) ),
    'products'   => ! empty( $products_right ) ? doroshopping_map_wc_products_for_carousel( $products_right ) : $fallback_right,
    'categories' => array(
        array(
            'image' => $cat_uri . '/deportes.png',
            'label' => __( 'Deportes', 'doroshopping' ),
            'url'   => $doroshopping_tile_url( $tile_3 ),
            'file'  => 'deportes.png',
        ),
        array(
            'image' => $cat_uri . '/hogar.png',
            'label' => __( 'Hogar y Gadgets', 'doroshopping' ),
            'url'   => $doroshopping_tile_url( $tile_4 ),
            'file'  => 'hogar.png',
        ),
    ),
);

$blocks = array( $block_left, $block_right );

if ( ! function_exists( 'doroshopping_render_category_block' ) ) {
/**
 * Renderiza un bloque de categorias.
 *
 * @param array $block Datos del bloque.
 * @param int   $index Indice del bloque.
 */
function doroshopping_render_category_block( $block, $index ) {
    ?>
    <div class="home-categories__col" data-block="<?php echo esc_attr( (string) $index ); ?>">
        <div class="home-categories__panel">
            <h3 class="home-categories__col-title"><?php echo esc_html( $block['title'] ); ?></h3>

            <div class="home-categories__carousel-wrap">
                <button type="button" class="home-categories__arrow home-categories__arrow--prev" aria-label="<?php esc_attr_e( 'Anterior', 'doroshopping' ); ?>">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M15 18l-6-6 6-6"/></svg>
                </button>

                <div class="home-categories__carousel" data-carousel>
                    <div class="home-categories__carousel-track">
                        <?php foreach ( $block['products'] as $product ) : ?>
                            <article class="home-categories__product">
                                <a href="<?php echo esc_url( isset( $product['url'] ) ? $product['url'] : '#' ); ?>" class="home-categories__product-link">
                                    <div class="home-categories__product-image">
                                        <img src="<?php echo esc_url( $product['image'] ); ?>" alt="<?php echo esc_attr( $product['name'] ); ?>">
                                    </div>
                                    <p class="home-categories__product-price"><?php echo esc_html( $product['price'] ); ?></p>
                                    <h4 class="home-categories__product-name"><?php echo esc_html( $product['name'] ); ?></h4>
                                </a>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>

                <button type="button" class="home-categories__arrow home-categories__arrow--next" aria-label="<?php esc_attr_e( 'Siguiente', 'doroshopping' ); ?>">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
                </button>
            </div>

            <div class="home-categories__dots" data-dots></div>
        </div>

        <div class="home-categories__tiles">
            <?php foreach ( $block['categories'] as $category ) : ?>
                <a href="<?php echo esc_url( $category['url'] ); ?>" class="home-categories__tile" data-category-file="<?php echo esc_attr( $category['file'] ); ?>">
                    <img src="<?php echo esc_url( $category['image'] ); ?>" alt="<?php echo esc_attr( $category['label'] ); ?>">
                    <span class="home-categories__tile-label"><?php echo esc_html( $category['label'] ); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}
} // function_exists doroshopping_render_category_block
?>

<section class="home-categories">
    <h2 class="home-categories__title"><?php esc_html_e( 'Categorias & Ofertas', 'doroshopping' ); ?></h2>
    <div class="home-categories__grid">
        <?php
        foreach ( $blocks as $index => $block ) {
            doroshopping_render_category_block( $block, $index );
        }
        ?>
    </div>
</section>
