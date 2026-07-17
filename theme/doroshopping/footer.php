<footer class="site-footer">
    <div class="site-footer__inner">
        <div class="site-footer__col">
            <h4>Doro Shopping</h4>
            <a href="#">Sobre nosotros</a>
            <a href="#">Contacto</a>
            <a href="#">Blog</a>
        </div>
        <div class="site-footer__col">
            <h4>Ayuda</h4>
            <a href="#">Envios</a>
            <a href="#">Devoluciones</a>
            <a href="#">Preguntas frecuentes</a>
        </div>
        <div class="site-footer__col">
            <h4>Legal</h4>
            <a href="#">Terminos y condiciones</a>
            <a href="#">Politica de privacidad</a>
            <a href="#">Cookies</a>
        </div>
        <div class="site-footer__col">
            <h4>Siguenos</h4>
            <a href="#">Instagram</a>
            <a href="#">Facebook</a>
            <a href="#">TikTok</a>
        </div>
    </div>
    <div class="site-footer__payments">
        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/payment.png' ); ?>" alt="Metodos de pago">
    </div>
    <p class="site-footer__copy">&copy; <?php echo esc_html( date( 'Y' ) ); ?> Doroshopping.es. Todos los derechos reservados.</p>
</footer>

<?php wp_footer(); ?>
</body>
</html>
