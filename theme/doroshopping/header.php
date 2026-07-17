<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="site-header__top">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-header__logo">
            <img src="<?php echo esc_url( doroshopping_logo_url() ); ?>" alt="<?php bloginfo( 'name' ); ?>">
        </a>

        <form class="site-header__search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <svg class="site-header__search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input type="search" name="s" placeholder="<?php esc_attr_e( 'Buscar productos', 'doroshopping' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>">
            <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                <input type="hidden" name="post_type" value="product">
            <?php endif; ?>
        </form>

        <div class="site-header__utilities">
            <a href="<?php echo function_exists( 'wc_get_page_permalink' ) ? esc_url( wc_get_page_permalink( 'myaccount' ) ) : esc_url( wp_login_url() ); ?>" class="site-header__utility">
                <svg class="site-header__utility-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span class="site-header__utility-text">
                    <span class="site-header__utility-label"><?php esc_html_e( 'Bienvenido', 'doroshopping' ); ?></span>
                    <span><?php echo is_user_logged_in() ? esc_html__( 'Mi cuenta', 'doroshopping' ) : esc_html__( 'Ingresar', 'doroshopping' ); ?></span>
                </span>
            </a>

            <div class="site-header__utility site-header__utility--plugin">
                <svg class="site-header__utility-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                <span class="site-header__utility-text">
                    <?php
                    /**
                     * Polylang / WPML / YITH currency via hooks.
                     *
                     * @hook doroshopping_header_utility_language
                     * @hook doroshopping_header_utility_currency
                     */
                    ob_start();
                    do_action( 'doroshopping_header_utility_language' );
                    do_action( 'doroshopping_header_utility_currency' );
                    $lang_currency = trim( ob_get_clean() );
                    if ( $lang_currency ) {
                        echo $lang_currency; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    } else {
                        echo '<span class="site-header__utility-label">' . esc_html__( 'Espanol', 'doroshopping' ) . '</span>';
                        echo '<span>' . esc_html__( 'Moneda', 'doroshopping' ) . '</span>';
                    }
                    ?>
                </span>
            </div>

            <div class="site-header__utility site-header__utility--plugin">
                <svg class="site-header__utility-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                <span class="site-header__utility-text">
                    <?php
                    ob_start();
                    do_action( 'doroshopping_header_utility_location' );
                    $location = trim( ob_get_clean() );
                    if ( $location ) {
                        echo $location; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    } else {
                        echo '<span class="site-header__utility-label">' . esc_html__( 'Ubicacion', 'doroshopping' ) . '</span>';
                        echo '<span>' . esc_html__( 'Envio', 'doroshopping' ) . '</span>';
                    }
                    ?>
                </span>
            </div>

            <a href="<?php echo function_exists( 'wc_get_cart_url' ) ? esc_url( wc_get_cart_url() ) : '#'; ?>" class="site-header__utility">
                <svg class="site-header__utility-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                <span class="site-header__utility-text">
                    <span><?php esc_html_e( 'Carrito', 'doroshopping' ); ?></span>
                    <?php if ( function_exists( 'WC' ) && WC()->cart ) : ?>
                        <span class="site-header__cart-count"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
                    <?php else : ?>
                        <span class="site-header__cart-count">0</span>
                    <?php endif; ?>
                </span>
            </a>
        </div>
    </div>

    <nav class="site-nav" aria-label="<?php esc_attr_e( 'Navegacion principal', 'doroshopping' ); ?>">
        <div class="site-nav__inner">
            <div class="site-nav__categories">
                <button type="button" class="site-nav__categories-btn" aria-expanded="false" aria-controls="mega-menu">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
                    <?php esc_html_e( 'Todas las categorias', 'doroshopping' ); ?>
                    <svg class="site-nav__categories-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
                </button>
                <?php get_template_part( 'template-parts/header/mega-menu' ); ?>
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
</header>
