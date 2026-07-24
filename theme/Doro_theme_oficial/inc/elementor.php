<?php
/**
 * Integracion Elementor Theme Builder + widgets
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Registrar locations de Elementor Pro Theme Builder.
 *
 * @param object $manager Locations manager.
 */
function doroshopping_register_elementor_locations( $manager ) {
    if ( method_exists( $manager, 'register_all_core_location' ) ) {
        $manager->register_all_core_location();
    }
}
add_action( 'elementor/theme/register_locations', 'doroshopping_register_elementor_locations' );

/**
 * Preferir header/footer del tema (cuenta, login popup, mega menú, FAB).
 * Elementor Theme Builder solo los sustituye si el usuario lo activa en Personalizar.
 *
 * @param bool   $overwrite Si Elementor debe sustituir la location.
 * @param string $location  Location (header|footer|...).
 * @return bool
 */
function doroshopping_prefer_theme_chrome( $overwrite, $location ) {
	if ( ! in_array( $location, array( 'header', 'footer' ), true ) ) {
		return $overwrite;
	}

	if ( get_theme_mod( 'doroshopping_allow_elementor_chrome', false ) ) {
		return $overwrite;
	}

	return false;
}
add_filter( 'elementor/theme/need_override_location', 'doroshopping_prefer_theme_chrome', 20, 2 );

/**
 * Cargar widgets de Elementor.
 */
function doroshopping_register_elementor_widgets( $widgets_manager ) {
    require_once DOROSHOPPING_DIR . '/inc/elementor/class-products-grid-widget.php';
    require_once DOROSHOPPING_DIR . '/inc/elementor/class-hero-carousel-widget.php';

    if ( class_exists( '\Doroshopping\Elementor\Products_Grid_Widget' ) ) {
        $widgets_manager->register( new \Doroshopping\Elementor\Products_Grid_Widget() );
    }
    if ( class_exists( '\Doroshopping\Elementor\Hero_Carousel_Widget' ) ) {
        $widgets_manager->register( new \Doroshopping\Elementor\Hero_Carousel_Widget() );
    }
}
add_action( 'elementor/widgets/register', 'doroshopping_register_elementor_widgets' );

/**
 * Categoria de widgets Doroshopping en Elementor.
 *
 * @param \Elementor\Elements_Manager $elements_manager Manager.
 */
function doroshopping_elementor_category( $elements_manager ) {
    $elements_manager->add_category(
        'doroshopping',
        array(
            'title' => __( 'Doroshopping', 'doroshopping' ),
            'icon'  => 'fa fa-shopping-cart',
        )
    );
}
add_action( 'elementor/elements/categories_registered', 'doroshopping_elementor_category' );
