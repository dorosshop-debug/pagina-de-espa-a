<?php
/**
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Resultados de búsqueda.
 *
 * @package Doroshopping
 */

get_header();
?>

<main id="main-content" class="doro-page doro-page--search">
    <div class="doro-page__container">
        <header class="doro-page__header">
            <h1 class="doro-page__title">
                <?php
                printf(
                    /* translators: %s: search query */
                    esc_html__( 'Resultados para: %s', 'doroshopping' ),
                    '<span>' . esc_html( get_search_query() ) . '</span>'
                );
                ?>
            </h1>
        </header>

        <?php if ( have_posts() ) : ?>
            <ul class="doro-page__results">
                <?php
                while ( have_posts() ) :
                    the_post();
                    ?>
                    <li class="doro-page__result">
                        <h2 class="doro-page__result-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <div class="doro-page__result-excerpt"><?php the_excerpt(); ?></div>
                    </li>
                    <?php
                endwhile;
                ?>
            </ul>
            <?php the_posts_pagination(); ?>
        <?php else : ?>
            <p class="doro-page__lead"><?php esc_html_e( 'No se encontraron resultados.', 'doroshopping' ); ?></p>
            <p>
                <a class="doro-page__cta" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <?php esc_html_e( 'Volver al inicio', 'doroshopping' ); ?>
                </a>
            </p>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
