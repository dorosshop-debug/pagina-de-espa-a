<?php
/**
 * Front page template
 *
 * @package Doroshopping
 */

get_header();
?>

<main id="main-content" class="home">
    <?php get_template_part( 'template-parts/home/hero' ); ?>
    <?php get_template_part( 'template-parts/home/categories' ); ?>
    <?php get_template_part( 'template-parts/home/promo-banner' ); ?>
    <?php get_template_part( 'template-parts/home/featured-products' ); ?>
</main>

<?php
get_footer();
