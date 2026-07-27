<?php
/**
 * Plantilla de páginas estáticas (CMS).
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

$slug = get_post_field( 'post_name', get_queried_object_id() );
$is_legal = in_array(
    $slug,
    array(
        'politica-de-privacidad',
        'terminos-y-condiciones',
        'proteccion-del-comprador',
        'aviso-legal',
        'cookies',
        'politica-de-cookies',
    ),
    true
);

$main_class = 'doro-page' . ( $is_legal ? ' doro-page--legal' : '' );
?>

<main id="main-content" class="<?php echo esc_attr( $main_class ); ?>">
    <div class="doro-page__container">
        <?php
        while ( have_posts() ) :
            the_post();
            ?>
            <article <?php post_class( 'doro-page__article' . ( $is_legal ? ' doro-page__article--legal' : '' ) ); ?>>
                <header class="doro-page__header<?php echo $is_legal ? ' doro-page__header--legal' : ''; ?>">
                    <?php if ( $is_legal ) : ?>
                        <p class="doro-page__eyebrow"><?php esc_html_e( 'Información legal', 'doroshopping' ); ?></p>
                    <?php endif; ?>
                    <h1 class="doro-page__title"><?php the_title(); ?></h1>
                    <?php if ( $is_legal ) : ?>
                        <p class="doro-page__lead">
                            <?php
                            echo esc_html(
                                sprintf(
                                    /* translators: %s: last updated date */
                                    __( 'Última actualización: %s', 'doroshopping' ),
                                    get_the_modified_date() ? get_the_modified_date() : get_the_date()
                                )
                            );
                            ?>
                        </p>
                    <?php endif; ?>
                </header>
                <div class="doro-page__content entry-content<?php echo $is_legal ? ' doro-page__content--legal' : ''; ?>">
                    <?php the_content(); ?>
                </div>
            </article>
            <?php
        endwhile;
        ?>
    </div>
</main>

<?php
get_footer();
