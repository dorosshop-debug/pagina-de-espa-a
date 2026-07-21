<?php
/**
 * The Template for displaying single products
 *
 * Compatible with WooCommerce and Elementor Theme Builder.
 *
 * @package Doroshopping
 */

defined( 'ABSPATH' ) || exit;

get_header();

if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'single' ) ) {
    get_footer();
    return;
}
?>

<main id="main-content" class="doro-product">
    <div class="doro-product__container">
        <?php
        while ( have_posts() ) :
            the_post();
            wc_get_template_part( 'content', 'single-product' );
        endwhile;
        ?>
    </div>
</main>

<?php
get_footer();
