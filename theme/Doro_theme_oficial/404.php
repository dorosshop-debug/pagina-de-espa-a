<?php
/**
 * Plantilla 404.
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

<main id="main-content" class="doro-page doro-page--404">
	<div class="doro-page__container">
		<header class="doro-page__header">
			<h1 class="doro-page__title"><?php echo esc_html( $ui( 'doroshopping_ui_404_title' ) ); ?></h1>
			<p class="doro-page__lead"><?php echo esc_html( $ui( 'doroshopping_ui_404_lead' ) ); ?></p>
		</header>
		<p>
			<a class="doro-page__cta" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php echo esc_html( $ui( 'doroshopping_ui_404_home_btn' ) ); ?>
			</a>
			<?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
				<a class="doro-page__cta doro-page__cta--secondary" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">
					<?php echo esc_html( $ui( 'doroshopping_ui_404_shop_btn' ) ); ?>
				</a>
			<?php endif; ?>
		</p>
	</div>
</main>

<?php
get_footer();
