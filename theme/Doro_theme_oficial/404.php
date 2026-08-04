<?php
/**
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Plantilla 404.
 *
 * @package Doroshopping
 */

get_header();
?>

<main id="main-content" class="doro-page doro-page--404">
    <div class="doro-page__container">
        <header class="doro-page__header">
            <h1 class="doro-page__title"><?php esc_html_e( 'Página no encontrada', 'doroshopping' ); ?></h1>
            <p class="doro-page__lead"><?php esc_html_e( 'La página que buscas no existe o se ha movido.', 'doroshopping' ); ?></p>
        </header>
        <p>
            <a class="doro-page__cta" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <?php esc_html_e( 'Volver al inicio', 'doroshopping' ); ?>
            </a>
            <?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
                <a class="doro-page__cta doro-page__cta--secondary" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">
                    <?php esc_html_e( 'Ir a la tienda', 'doroshopping' ); ?>
                </a>
            <?php endif; ?>
        </p>
    </div>
</main>

<?php
get_footer();
