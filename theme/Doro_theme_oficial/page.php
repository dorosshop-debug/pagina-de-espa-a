<?php
/**
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Plantilla de páginas estáticas (CMS).
 *
 * @package Doroshopping
 */

get_header();
?>

<main id="main-content" class="doro-page">
    <div class="doro-page__container">
        <?php
        while ( have_posts() ) :
            the_post();
            ?>
            <article <?php post_class( 'doro-page__article' ); ?>>
                <header class="doro-page__header">
                    <h1 class="doro-page__title"><?php the_title(); ?></h1>
                </header>
                <div class="doro-page__content entry-content">
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
