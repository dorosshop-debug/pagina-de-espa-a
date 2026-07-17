<?php
/**
 * Categorias & Ofertas - 2 bloques
 * Cada bloque: carrusel de productos + 2 imagenes de categoria
 *
 * @package Doroshopping
 */

$products_uri = get_template_directory_uri() . '/assets/images/products';
$cat_uri      = get_template_directory_uri() . '/assets/images/categories';

$block_left = array(
    'title'    => __( 'Tecnologia para tu hogar', 'doroshopping' ),
    'products' => array(
        array( 'image' => $products_uri . '/Producto1.jpg', 'name' => __( 'Auriculares', 'doroshopping' ), 'price' => '23.99' ),
        array( 'image' => $products_uri . '/Producto2.png', 'name' => __( 'Monitor', 'doroshopping' ), 'price' => '45.50' ),
        array( 'image' => $products_uri . '/Producto3.jpg', 'name' => __( 'Cable USB-C', 'doroshopping' ), 'price' => '12.99' ),
        array( 'image' => $products_uri . '/Producto4.jpg', 'name' => __( 'Teclado RGB', 'doroshopping' ), 'price' => '89.00' ),
        array( 'image' => $products_uri . '/Producto5.jpg', 'name' => __( 'Raton', 'doroshopping' ), 'price' => '34.75' ),
        array( 'image' => $products_uri . '/Producto6.jpg', 'name' => __( 'Tablet', 'doroshopping' ), 'price' => '156.00' ),
    ),
    'categories' => array(
        array(
            'image' => $cat_uri . '/auriculares.png',
            'label' => __( 'Microfonos y auriculares', 'doroshopping' ),
            'url'   => '#',
            'file'  => 'auriculares.png',
        ),
        array(
            'image' => $cat_uri . '/videjuegos.png',
            'label' => __( 'Gaming', 'doroshopping' ),
            'url'   => '#',
            'file'  => 'videjuegos.png',
        ),
    ),
);

$block_right = array(
    'title'    => __( 'Promociones de Lanzamiento', 'doroshopping' ),
    'products' => array(
        array( 'image' => $products_uri . '/Producto7.jpg', 'name' => __( 'Altavoz', 'doroshopping' ), 'price' => '28.50' ),
        array( 'image' => $products_uri . '/Producto8.jpg', 'name' => __( 'Smartwatch', 'doroshopping' ), 'price' => '67.99' ),
        array( 'image' => $products_uri . '/Producto1.jpg', 'name' => __( 'Auriculares Pro', 'doroshopping' ), 'price' => '39.99' ),
        array( 'image' => $products_uri . '/Producto3.jpg', 'name' => __( 'Accesorio', 'doroshopping' ), 'price' => '9.99' ),
        array( 'image' => $products_uri . '/Producto5.jpg', 'name' => __( 'Periferico', 'doroshopping' ), 'price' => '22.00' ),
        array( 'image' => $products_uri . '/Producto2.png', 'name' => __( 'Pantalla', 'doroshopping' ), 'price' => '119.00' ),
    ),
    'categories' => array(
        array(
            'image' => $cat_uri . '/deportes.png',
            'label' => __( 'Deportes', 'doroshopping' ),
            'url'   => '#',
            'file'  => 'deportes.png',
        ),
        array(
            'image' => $cat_uri . '/hogar.png',
            'label' => __( 'Hogar y Gadgets', 'doroshopping' ),
            'url'   => '#',
            'file'  => 'hogar.png',
        ),
    ),
);

$blocks = array( $block_left, $block_right );

/**
 * Renderiza un bloque de categorias.
 *
 * @param array $block Datos del bloque.
 * @param int   $index Indice del bloque.
 */
function doroshopping_render_category_block( $block, $index ) {
    ?>
    <div class="home-categories__col" data-block="<?php echo esc_attr( (string) $index ); ?>">
        <h3 class="home-categories__col-title"><?php echo esc_html( $block['title'] ); ?></h3>

        <div class="home-categories__carousel-wrap">
            <button type="button" class="home-categories__arrow home-categories__arrow--prev" aria-label="<?php esc_attr_e( 'Anterior', 'doroshopping' ); ?>">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M15 18l-6-6 6-6"/></svg>
            </button>

            <div class="home-categories__carousel" data-carousel>
                <div class="home-categories__carousel-track">
                    <?php foreach ( $block['products'] as $product ) : ?>
                        <article class="home-categories__product">
                            <a href="#" class="home-categories__product-link">
                                <div class="home-categories__product-image">
                                    <img src="<?php echo esc_url( $product['image'] ); ?>" alt="<?php echo esc_attr( $product['name'] ); ?>">
                                </div>
                                <p class="home-categories__product-price"><?php echo esc_html( $product['price'] ); ?> EUR</p>
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
