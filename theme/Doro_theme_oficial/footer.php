<?php
/**
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Footer template - mismo en home, tienda y producto
 *
 * @package Doroshopping
 */

$allow_elementor_chrome = (bool) get_theme_mod( 'doroshopping_allow_elementor_chrome', false );
$elementor_footer       = $allow_elementor_chrome
	&& function_exists( 'elementor_theme_do_location' )
	&& elementor_theme_do_location( 'footer' );

$ui = static function ( $key ) {
    return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : '';
};

if ( ! $elementor_footer ) :
?>
<footer class="site-footer">
    <div class="site-footer__edge" aria-hidden="true"></div>

    <div class="site-footer__domains">
        <div class="site-footer__domains-inner">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-footer__logo">
                <img src="<?php echo esc_url( doroshopping_footer_logo_url() ); ?>" alt="<?php bloginfo( 'name' ); ?>">
            </a>
            <div class="site-footer__domains-content">
                <h4 class="site-footer__domains-title"><?php echo esc_html( $ui( 'doroshopping_ui_footer_stores' ) ); ?></h4>
                <ul class="site-footer__domains-list">
                    <?php
                    $stores = array(
                        'doroshopping.com',
                        'doroshopping.es',
                        'doroshopping.fr',
                        'doroshopping.de',
                        'doroshopping.uk',
                    );
                    $current_host = wp_parse_url( home_url( '/' ), PHP_URL_HOST );
                    $current_host = is_string( $current_host ) ? strtolower( preg_replace( '/^www\./', '', $current_host ) ) : '';
                    foreach ( $stores as $store_host ) :
                        $is_current = ( $current_host === $store_host );
                        $href       = 'https://' . $store_host . '/';
                        ?>
                        <li>
                            <a
                                href="<?php echo esc_url( $href ); ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                                <?php echo $is_current ? 'aria-current="page"' : ''; ?>
                                class="<?php echo $is_current ? 'is-current' : ''; ?>"
                            ><?php echo esc_html( $store_host ); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="site-footer__main">
        <div class="site-footer__grid">
            <div class="site-footer__col site-footer__col--brand">
                <h4 class="site-footer__heading"><?php echo esc_html( $ui( 'doroshopping_ui_footer_customer' ) ); ?></h4>
                <?php if ( has_nav_menu( 'footer' ) ) : ?>
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'footer',
                            'container'      => false,
                            'menu_class'     => 'site-footer__links',
                            'depth'          => 1,
                            'fallback_cb'    => false,
                        )
                    );
                    ?>
                <?php else : ?>
                    <ul class="site-footer__links">
                        <li><a href="<?php echo esc_url( doroshopping_get_page_url( 'nosotros' ) ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_footer_about' ) ); ?></a></li>
                        <li><a href="<?php echo esc_url( doroshopping_get_page_url( 'politica-de-privacidad' ) ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_footer_privacy' ) ); ?></a></li>
                        <li><a href="<?php echo esc_url( doroshopping_get_page_url( 'centro-de-ayuda' ) ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_footer_help' ) ); ?></a></li>
                        <li><a href="<?php echo esc_url( doroshopping_get_page_url( 'preguntas-frecuentes' ) ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_footer_faq' ) ); ?></a></li>
                        <li><a href="<?php echo esc_url( doroshopping_get_page_url( 'contacto' ) ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_footer_contact' ) ); ?></a></li>
                    </ul>
                <?php endif; ?>
                <img
                    class="site-footer__figure"
                    src="<?php echo esc_url( function_exists( 'doroshopping_get_theme_image_url' ) ? doroshopping_get_theme_image_url( 'footer_figure', get_template_directory_uri() . '/assets/images/imagen_footer.webp' ) : get_template_directory_uri() . '/assets/images/imagen_footer.webp' ); ?>"
                    alt=""
                >
            </div>

            <div class="site-footer__col">
                <h4 class="site-footer__heading"><?php echo esc_html( $ui( 'doroshopping_ui_footer_guide' ) ); ?></h4>
                <ul class="site-footer__links">
                    <li><a href="<?php echo esc_url( doroshopping_get_page_url( 'metodos-de-pago' ) ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_footer_payment' ) ); ?></a></li>
                    <li><a href="<?php echo esc_url( doroshopping_get_page_url( 'envios' ) ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_footer_shipping' ) ); ?></a></li>
                    <li><a href="<?php echo esc_url( doroshopping_get_page_url( 'cupones' ) ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_footer_coupons' ) ); ?></a></li>
                    <?php if ( ! is_user_logged_in() ) : ?>
                    <li class="site-footer__link-create-account"><a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : wp_registration_url() ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_footer_create_account' ) ); ?></a></li>
                    <?php endif; ?>
                    <li><a href="<?php echo esc_url( doroshopping_get_page_url( 'proteccion-del-comprador' ) ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_footer_buyer' ) ); ?></a></li>
                </ul>
            </div>

            <div class="site-footer__col site-footer__col--visual">
                <h4 class="site-footer__heading"><?php echo esc_html( $ui( 'doroshopping_ui_footer_payments' ) ); ?></h4>
                <div class="site-footer__payments">
                    <img
                        src="<?php echo esc_url( function_exists( 'doroshopping_get_theme_image_url' ) ? doroshopping_get_theme_image_url( 'payment_image', get_template_directory_uri() . '/assets/images/payment.png' ) : get_template_directory_uri() . '/assets/images/payment.png' ); ?>"
                        alt="<?php echo esc_attr( $ui( 'doroshopping_ui_footer_payments' ) ); ?>"
                    >
                </div>
            </div>

            <div class="site-footer__col site-footer__col--newsletter">
                <h4 class="site-footer__heading"><?php echo esc_html( $ui( 'doroshopping_ui_footer_newsletter' ) ); ?></h4>
                <form class="site-footer__newsletter" action="<?php echo esc_url( apply_filters( 'doroshopping_newsletter_action', '#' ) ); ?>" method="post">
                    <label class="screen-reader-text" for="footer-newsletter-email"><?php echo esc_html( $ui( 'doroshopping_ui_footer_email_ph' ) ); ?></label>
                    <input id="footer-newsletter-email" type="email" name="email" placeholder="<?php echo esc_attr( $ui( 'doroshopping_ui_footer_email_ph' ) ); ?>" required>
                    <button type="submit"><?php echo esc_html( $ui( 'doroshopping_ui_footer_subscribe' ) ); ?></button>
                </form>

                <h4 class="site-footer__heading site-footer__heading--social"><?php echo esc_html( $ui( 'doroshopping_ui_footer_follow' ) ); ?></h4>
                <div class="site-footer__social">
                    <?php
                    $instagram = trim( (string) get_theme_mod( 'doroshopping_social_instagram', '' ) );
                    $facebook  = trim( (string) get_theme_mod( 'doroshopping_social_facebook', '' ) );
                    $youtube   = trim( (string) get_theme_mod( 'doroshopping_social_youtube', '' ) );
                    $has_social = $instagram || $facebook || $youtube;
                    ?>
                    <?php if ( $instagram ) : ?>
                        <a href="<?php echo esc_url( $instagram ); ?>" aria-label="Instagram" target="_blank" rel="noopener noreferrer">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>
                        </a>
                    <?php endif; ?>
                    <?php if ( $facebook ) : ?>
                        <a href="<?php echo esc_url( $facebook ); ?>" aria-label="Facebook" target="_blank" rel="noopener noreferrer">
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14 9h3V6h-3c-1.7 0-3 1.3-3 3v2H9v3h2v7h3v-7h2.5l.5-3H14V9z"/></svg>
                        </a>
                    <?php endif; ?>
                    <?php if ( $youtube ) : ?>
                        <a href="<?php echo esc_url( $youtube ); ?>" aria-label="YouTube" target="_blank" rel="noopener noreferrer">
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.5 3.5 12 3.5 12 3.5s-7.5 0-9.4.6A3 3 0 0 0 .5 6.2 31.5 31.5 0 0 0 0 12a31.5 31.5 0 0 0 .5 5.8 3 3 0 0 0 2.1 2.1c1.9.6 9.4.6 9.4.6s7.5 0 9.4-.6a3 3 0 0 0 2.1-2.1A31.5 31.5 0 0 0 24 12a31.5 31.5 0 0 0-.5-5.8zM9.8 15.5v-7l6.3 3.5-6.3 3.5z"/></svg>
                        </a>
                    <?php endif; ?>
                    <?php if ( ! $has_social ) : ?>
                        <p class="site-footer__social-hint"><?php esc_html_e( 'Configura las redes en Apariencia → Personalizar.', 'doroshopping' ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="site-footer__bottom">
        <div class="site-footer__bottom-inner">
            <p class="site-footer__copy"><?php bloginfo( 'name' ); ?> &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> &ndash; <?php echo esc_html( $ui( 'doroshopping_ui_footer_rights' ) ); ?></p>
            <nav class="site-footer__legal" aria-label="<?php esc_attr_e( 'Enlaces legales', 'doroshopping' ); ?>">
                <a href="<?php echo esc_url( doroshopping_get_page_url( 'politica-de-devoluciones' ) ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_footer_returns' ) ); ?></a>
                <span aria-hidden="true">|</span>
                <a href="<?php echo esc_url( doroshopping_get_page_url( 'politica-de-privacidad' ) ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_footer_legal_privacy' ) ); ?></a>
                <span aria-hidden="true">|</span>
                <a href="<?php echo esc_url( doroshopping_get_page_url( 'terminos-y-condiciones' ) ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_footer_terms' ) ); ?></a>
                <span aria-hidden="true">|</span>
                <a href="<?php echo esc_url( doroshopping_get_page_url( 'aviso-legal' ) ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_footer_legal_notice' ) ); ?></a>
                <span aria-hidden="true">|</span>
                <a href="<?php echo esc_url( doroshopping_get_page_url( 'politica-de-cookies' ) ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_footer_cookies' ) ); ?></a>
            </nav>
        </div>
    </div>
</footer>
<?php endif; // elementor footer ?>

<?php get_template_part( 'template-parts/cart/modal' ); ?>

<?php wp_footer(); ?>
</body>
</html>
