<footer class="site-footer">
    <div class="site-footer__edge" aria-hidden="true"></div>

    <div class="site-footer__main">
        <div class="site-footer__grid">
            <div class="site-footer__col site-footer__col--brand">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-footer__logo">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo/logo_doro_blanco.png' ); ?>" alt="<?php bloginfo( 'name' ); ?>">
                </a>
                <h4 class="site-footer__heading"><?php esc_html_e( 'Atencion al Cliente', 'doroshopping' ); ?></h4>
                <ul class="site-footer__links">
                    <li><a href="#"><?php esc_html_e( 'Sobre Nosotros', 'doroshopping' ); ?></a></li>
                    <li><a href="#"><?php esc_html_e( 'Politicas de Privacidad', 'doroshopping' ); ?></a></li>
                    <li><a href="#"><?php esc_html_e( 'Ayuda y FAQ\'s', 'doroshopping' ); ?></a></li>
                    <li><a href="#"><?php esc_html_e( 'Contacto', 'doroshopping' ); ?></a></li>
                </ul>
            </div>

            <div class="site-footer__col">
                <h4 class="site-footer__heading"><?php esc_html_e( 'Guia de Compra', 'doroshopping' ); ?></h4>
                <ul class="site-footer__links">
                    <li><a href="#"><?php esc_html_e( 'Pago', 'doroshopping' ); ?></a></li>
                    <li><a href="#"><?php esc_html_e( 'Envio', 'doroshopping' ); ?></a></li>
                    <li><a href="#"><?php esc_html_e( 'Crear una cuenta', 'doroshopping' ); ?></a></li>
                    <li><a href="#"><?php esc_html_e( 'Proteccion del Comprador', 'doroshopping' ); ?></a></li>
                </ul>
            </div>

            <div class="site-footer__col site-footer__col--visual">
                <h4 class="site-footer__heading"><?php esc_html_e( 'Medios de Pago', 'doroshopping' ); ?></h4>
                <div class="site-footer__payments">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/payment.png' ); ?>" alt="<?php esc_attr_e( 'Medios de pago', 'doroshopping' ); ?>">
                </div>
                <img class="site-footer__figure" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/imagen_footer.webp' ); ?>" alt="">
            </div>

            <div class="site-footer__col site-footer__col--newsletter">
                <h4 class="site-footer__heading"><?php esc_html_e( 'Registrate y recibe novedades unicas.', 'doroshopping' ); ?></h4>
                <form class="site-footer__newsletter" action="#" method="post">
                    <label class="screen-reader-text" for="footer-newsletter-email"><?php esc_html_e( 'Direccion de Correo electronico', 'doroshopping' ); ?></label>
                    <input id="footer-newsletter-email" type="email" name="email" placeholder="<?php esc_attr_e( 'Direccion de Correo electronico', 'doroshopping' ); ?>" required>
                    <button type="submit"><?php esc_html_e( 'Suscribirse', 'doroshopping' ); ?></button>
                </form>

                <h4 class="site-footer__heading site-footer__heading--social"><?php esc_html_e( 'Siguenos', 'doroshopping' ); ?></h4>
                <div class="site-footer__social">
                    <a href="#" aria-label="Instagram">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>
                    </a>
                    <a href="#" aria-label="Facebook">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14 9h3V6h-3c-1.7 0-3 1.3-3 3v2H9v3h2v7h3v-7h2.5l.5-3H14V9z"/></svg>
                    </a>
                    <a href="#" aria-label="YouTube">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.5 3.5 12 3.5 12 3.5s-7.5 0-9.4.6A3 3 0 0 0 .5 6.2 31.5 31.5 0 0 0 0 12a31.5 31.5 0 0 0 .5 5.8 3 3 0 0 0 2.1 2.1c1.9.6 9.4.6 9.4.6s7.5 0 9.4-.6a3 3 0 0 0 2.1-2.1A31.5 31.5 0 0 0 24 12a31.5 31.5 0 0 0-.5-5.8zM9.8 15.5v-7l6.3 3.5-6.3 3.5z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="site-footer__bottom">
        <div class="site-footer__bottom-inner">
            <p class="site-footer__copy">DOROSHOPPING &copy; <?php echo esc_html( date( 'Y' ) ); ?> &ndash; <?php esc_html_e( 'All Rights Reserved', 'doroshopping' ); ?></p>
            <nav class="site-footer__legal" aria-label="<?php esc_attr_e( 'Enlaces legales', 'doroshopping' ); ?>">
                <a href="#"><?php esc_html_e( 'Refund policy', 'doroshopping' ); ?></a>
                <span aria-hidden="true">|</span>
                <a href="#"><?php esc_html_e( 'Privacy policy', 'doroshopping' ); ?></a>
                <span aria-hidden="true">|</span>
                <a href="#"><?php esc_html_e( 'Terms of service', 'doroshopping' ); ?></a>
            </nav>
        </div>
    </div>
</footer>

<?php if ( function_exists( 'wc_get_cart_url' ) ) : ?>
    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="site-fab-cart" aria-label="<?php esc_attr_e( 'Ver carrito', 'doroshopping' ); ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
        <span class="site-fab-cart__count"><?php echo function_exists( 'WC' ) && WC()->cart ? esc_html( WC()->cart->get_cart_contents_count() ) : '0'; ?></span>
    </a>
<?php else : ?>
    <a href="#" class="site-fab-cart" aria-label="<?php esc_attr_e( 'Ver carrito', 'doroshopping' ); ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
        <span class="site-fab-cart__count">0</span>
    </a>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
