<?php
/**
 * Header template
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#main-content"><?php esc_html_e( 'Saltar al contenido', 'doroshopping' ); ?></a>

<?php
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) :
    $compact_header = function_exists( 'doroshopping_is_compact_header' ) && doroshopping_is_compact_header();
    $header_class   = 'site-header' . ( $compact_header ? ' site-header--compact' : '' );
?>

<header class="<?php echo esc_attr( $header_class ); ?>">
    <div class="site-header__top">
        <div class="site-header__brand">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-header__logo">
                <img src="<?php echo esc_url( doroshopping_logo_url() ); ?>" alt="<?php bloginfo( 'name' ); ?>">
            </a>

            <div class="site-nav__categories site-header__menu-wrap">
                <button
                    type="button"
                    class="site-header__menu-btn site-nav__categories-btn"
                    aria-expanded="false"
                    aria-controls="mega-menu"
                    aria-label="<?php esc_attr_e( 'Abrir menu de categorias', 'doroshopping' ); ?>"
                >
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
                </button>
            </div>
        </div>

        <div class="site-header__search-wrap" data-live-search>
            <form class="site-header__search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" autocomplete="off">
                <input
                    type="search"
                    name="s"
                    class="site-header__search-input"
                    placeholder="<?php esc_attr_e( 'Buscar productos', 'doroshopping' ); ?>"
                    value="<?php echo esc_attr( get_search_query() ); ?>"
                    aria-autocomplete="list"
                    aria-controls="live-search-results"
                    aria-expanded="false"
                    data-live-search-input
                >
                <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                    <input type="hidden" name="post_type" value="product">
                <?php endif; ?>
                <!-- Icono busqueda visual (listo para plugin / Google Vision). -->
                <div class="site-header__visual-search" data-visual-search>
                    <button
                        type="button"
                        class="site-header__visual-search-btn"
                        data-visual-search-trigger
                        aria-label="<?php esc_attr_e( 'Buscar por imagen', 'doroshopping' ); ?>"
                        title="<?php esc_attr_e( 'Buscar por imagen', 'doroshopping' ); ?>"
                    >
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                    </button>
                    <input
                        type="file"
                        class="site-header__visual-search-input"
                        data-visual-search-input
                        accept="image/jpeg,image/png,image/webp,image/gif"
                        capture="environment"
                        hidden
                        aria-hidden="true"
                    >
                </div>
                <button type="submit" class="site-header__search-submit" aria-label="<?php esc_attr_e( 'Buscar', 'doroshopping' ); ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </button>
            </form>
            <div class="live-search" id="live-search-panel" hidden data-live-search-panel>
                <ul class="live-search__list" id="live-search-results" data-live-search-results role="listbox"></ul>
                <a href="#" class="live-search__all" data-live-search-all hidden><?php esc_html_e( 'Ver todos los resultados', 'doroshopping' ); ?></a>
                <p class="live-search__empty" data-live-search-empty hidden><?php esc_html_e( 'No se encontraron productos.', 'doroshopping' ); ?></p>
                <p class="live-search__loading" data-live-search-loading hidden><?php esc_html_e( 'Buscando...', 'doroshopping' ); ?></p>
            </div>
        </div>

        <div class="site-header__utilities">
            <div class="site-header__dropdown-wrap" data-dropdown="account">
                <button type="button" class="site-header__utility site-header__utility-btn" aria-expanded="false" aria-controls="dropdown-account">
                    <svg class="site-header__utility-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <span class="site-header__utility-text">
                        <span class="site-header__utility-label"><?php esc_html_e( 'Bienvenido', 'doroshopping' ); ?></span>
                        <span><?php echo is_user_logged_in() ? esc_html__( 'Mi cuenta', 'doroshopping' ) : esc_html__( 'Ingresar', 'doroshopping' ); ?></span>
                    </span>
                    <svg class="site-header__chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
                </button>
                <?php get_template_part( 'template-parts/header/dropdown', 'account' ); ?>
            </div>

            <div class="site-header__dropdown-wrap" data-dropdown="locale">
                <button type="button" class="site-header__utility site-header__utility-btn" aria-expanded="false" aria-controls="dropdown-locale">
                    <img class="site-header__flag" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/flags/spain.png' ); ?>" alt="" width="22" height="22">
                    <span class="site-header__utility-text">
                        <span class="site-header__utility-label"><?php esc_html_e( 'Espanol', 'doroshopping' ); ?></span>
                        <span><?php esc_html_e( 'Moneda', 'doroshopping' ); ?></span>
                    </span>
                    <svg class="site-header__chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
                </button>
                <?php get_template_part( 'template-parts/header/dropdown', 'locale' ); ?>
            </div>

            <div class="site-header__dropdown-wrap" data-dropdown="shipping">
                <button type="button" class="site-header__utility site-header__utility-btn" aria-expanded="false" aria-controls="dropdown-shipping">
                    <svg class="site-header__utility-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <span class="site-header__utility-text">
                        <span class="site-header__utility-label"><?php esc_html_e( 'Ubicacion', 'doroshopping' ); ?></span>
                        <span><?php esc_html_e( 'Envio', 'doroshopping' ); ?></span>
                    </span>
                    <svg class="site-header__chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
                </button>
                <?php get_template_part( 'template-parts/header/dropdown', 'shipping' ); ?>
            </div>

            <a href="<?php echo function_exists( 'wc_get_cart_url' ) ? esc_url( wc_get_cart_url() ) : '#'; ?>" class="site-header__utility site-header__utility--cart">
                <svg class="site-header__utility-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                <span class="site-header__utility-text site-header__utility-text--cart">
                    <?php if ( function_exists( 'WC' ) && WC()->cart ) : ?>
                        <span class="site-header__cart-count" data-cart-count><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
                    <?php else : ?>
                        <span class="site-header__cart-count" data-cart-count>0</span>
                    <?php endif; ?>
                    <span class="site-header__utility-label"><?php esc_html_e( 'Carrito', 'doroshopping' ); ?></span>
                </span>
            </a>
        </div>
    </div>

    <?php if ( ! $compact_header ) : ?>
        <nav class="site-nav" aria-label="<?php esc_attr_e( 'Navegacion principal', 'doroshopping' ); ?>">
            <div class="site-nav__inner">
                <div class="site-nav__categories">
                    <button type="button" class="site-nav__categories-btn" aria-expanded="false" aria-controls="mega-menu">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
                        <?php esc_html_e( 'Todas las categorias', 'doroshopping' ); ?>
                        <svg class="site-nav__categories-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                </div>

                <?php
                if ( has_nav_menu( 'primary' ) ) {
                    wp_nav_menu(
                        array(
                            'theme_location' => 'primary',
                            'container'      => false,
                            'menu_class'     => 'site-nav__menu',
                            'depth'          => 1,
                            'fallback_cb'    => false,
                        )
                    );
                } else {
                    ?>
                    <div class="site-nav__menu">
                        <a href="#" class="is-active"><?php esc_html_e( 'Super Ofertas', 'doroshopping' ); ?></a>
                        <a href="#"><?php esc_html_e( 'Remanufacturados', 'doroshopping' ); ?></a>
                        <a href="#"><?php esc_html_e( 'Productos Virales', 'doroshopping' ); ?></a>
                        <a href="#"><?php esc_html_e( 'Gadgets Tecnologicos', 'doroshopping' ); ?></a>
                        <a href="#"><?php esc_html_e( 'Lo ultimo en Gaming', 'doroshopping' ); ?></a>
                        <a href="#"><?php esc_html_e( 'Deporte y Exterior', 'doroshopping' ); ?></a>
                    </div>
                    <?php
                }
                ?>
            </div>
        </nav>
    <?php endif; ?>

    <?php get_template_part( 'template-parts/header/mega-menu' ); ?>
</header>
<?php endif; // elementor header ?>
