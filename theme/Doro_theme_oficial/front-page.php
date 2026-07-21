<?php
/**
 * Front page template
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

// Elementor Pro Theme Builder (location single / front).
if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'single' ) ) {
    get_footer();
    return;
}

$front_uses_elementor = false;
if ( is_singular() && function_exists( '\Elementor\Plugin' ) ) {
    $front_id = (int) get_queried_object_id();
    if ( $front_id > 0 ) {
        if ( 'builder' === get_post_meta( $front_id, '_elementor_edit_mode', true ) ) {
            $front_uses_elementor = true;
        } else {
            $document = \Elementor\Plugin::$instance->documents->get( $front_id );
            $front_uses_elementor = $document
                && method_exists( $document, 'is_built_with_elementor' )
                && $document->is_built_with_elementor();
        }
    }
}

if ( $front_uses_elementor ) :
    ?>
<main id="main-content" class="home home--elementor">
    <?php
    while ( have_posts() ) :
        the_post();
        the_content();
    endwhile;
    ?>
</main>
    <?php
    get_footer();
    return;
endif;
?>

<main id="main-content" class="home">
    <?php get_template_part( 'template-parts/home/hero' ); ?>
    <?php get_template_part( 'template-parts/home/categories' ); ?>
    <?php get_template_part( 'template-parts/home/promo-banner' ); ?>
    <?php get_template_part( 'template-parts/home/featured-products' ); ?>
</main>

<?php
get_footer();
