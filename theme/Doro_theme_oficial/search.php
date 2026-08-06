<?php
/**
 * Resultados de búsqueda.
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$ui = static function ( $key ) {
	return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : '';
};
?>

<main id="main-content" class="doro-page doro-page--search">
	<div class="doro-page__container">
		<header class="doro-page__header">
			<h1 class="doro-page__title">
				<?php
				$search_tpl = $ui( 'doroshopping_ui_search_title' );
				$parts      = explode( '%s', $search_tpl, 2 );
				echo esc_html( isset( $parts[0] ) ? $parts[0] : '' );
				echo '<span>' . esc_html( get_search_query() ) . '</span>';
				echo esc_html( isset( $parts[1] ) ? $parts[1] : '' );
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
			<p class="doro-page__lead"><?php echo esc_html( $ui( 'doroshopping_ui_search_empty' ) ); ?></p>
			<p>
				<a class="doro-page__cta" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php echo esc_html( $ui( 'doroshopping_ui_search_home' ) ); ?>
				</a>
			</p>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
