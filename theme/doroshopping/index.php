<?php
/**
 * Fallback template
 *
 * @package Doroshopping
 */

get_header();
?>

<main class="home">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();
            the_content();
        endwhile;
    endif;
    ?>
</main>

<?php
get_footer();
