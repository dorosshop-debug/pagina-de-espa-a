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

$front_id = is_singular() ? (int) get_queried_object_id() : 0;

$is_elementor_edit = false;
if ( function_exists( '\Elementor\Plugin' ) ) {
    $plugin = \Elementor\Plugin::$instance;
    if ( ! empty( $plugin->editor ) && method_exists( $plugin->editor, 'is_edit_mode' ) && $plugin->editor->is_edit_mode() ) {
        $is_elementor_edit = true;
    } elseif ( ! empty( $plugin->preview ) && method_exists( $plugin->preview, 'is_preview_mode' ) && $plugin->preview->is_preview_mode() ) {
        $is_elementor_edit = true;
    }
}
if ( ! $is_elementor_edit && ( isset( $_GET['elementor-preview'] ) || isset( $_GET['elementor_library'] ) ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    $is_elementor_edit = true;
}

$front_uses_elementor = false;
if ( $front_id > 0 && function_exists( '\Elementor\Plugin' ) ) {
    if ( 'builder' === get_post_meta( $front_id, '_elementor_edit_mode', true ) ) {
        $front_uses_elementor = true;
    } else {
        $document = \Elementor\Plugin::$instance->documents->get( $front_id );
        $front_uses_elementor = $document
            && method_exists( $document, 'is_built_with_elementor' )
            && $document->is_built_with_elementor();
    }
}

// En editor Elementor o si la página está construida con Elementor: mostrar el contenido.
if ( $is_elementor_edit || $front_uses_elementor ) :
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
