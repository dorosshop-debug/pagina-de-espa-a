<?php
/**
 * Template Name: Política de devoluciones
 * Template post type: page
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

$help_url    = function_exists( 'doroshopping_get_page_url' ) ? doroshopping_get_page_url( 'centro-de-ayuda' ) : home_url( '/centro-de-ayuda/' );
$protect_url = function_exists( 'doroshopping_get_page_url' ) ? doroshopping_get_page_url( 'proteccion-del-comprador' ) : home_url( '/' );
?>

<main id="main-content" class="doro-support doro-info doro-returns">
	<div class="doro-support__hero">
		<div class="doro-support__hero-inner">
			<p class="doro-support__eyebrow"><?php echo esc_html( $ui( 'doroshopping_ui_returns_eyebrow' ) ); ?></p>
			<h1 class="doro-support__title"><?php echo esc_html( $ui( 'doroshopping_ui_returns_title' ) ); ?></h1>
			<p class="doro-support__lead"><?php echo esc_html( $ui( 'doroshopping_ui_returns_lead' ) ); ?></p>
		</div>
	</div>

	<div class="doro-support__container">
		<section class="doro-coupons__howto">
			<h2 class="doro-support__section-title"><?php echo esc_html( $ui( 'doroshopping_ui_returns_howto_title' ) ); ?></h2>
			<div class="doro-support__cards">
				<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
					<article class="doro-support__card">
						<span class="doro-support__card-num" aria-hidden="true"><?php echo esc_html( (string) $i ); ?></span>
						<h3><?php echo esc_html( $ui( 'doroshopping_ui_returns_s' . $i . '_title' ) ); ?></h3>
						<p><?php echo esc_html( $ui( 'doroshopping_ui_returns_s' . $i . '_text' ) ); ?></p>
					</article>
				<?php endfor; ?>
			</div>
		</section>

		<section class="doro-info__split">
			<article class="doro-info__card">
				<h2><?php echo esc_html( $ui( 'doroshopping_ui_returns_rights_title' ) ); ?></h2>
				<ul class="doro-info__checklist">
					<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
						<li><?php echo esc_html( $ui( 'doroshopping_ui_returns_rights_' . $i ) ); ?></li>
					<?php endfor; ?>
				</ul>
			</article>
			<article class="doro-info__card">
				<h2><?php echo esc_html( $ui( 'doroshopping_ui_returns_process_title' ) ); ?></h2>
				<ul class="doro-info__checklist">
					<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
						<li><?php echo esc_html( $ui( 'doroshopping_ui_returns_process_' . $i ) ); ?></li>
					<?php endfor; ?>
				</ul>
			</article>
		</section>

		<section class="doro-info__panel doro-info__panel--accent">
			<div class="doro-info__panel-head">
				<h2 class="doro-support__section-title"><?php echo esc_html( $ui( 'doroshopping_ui_returns_help_title' ) ); ?></h2>
				<p><?php echo esc_html( $ui( 'doroshopping_ui_returns_help_text' ) ); ?></p>
			</div>
			<div class="doro-coupons__actions doro-info__actions">
				<a class="doro-support__btn" href="<?php echo esc_url( $help_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_returns_help_btn' ) ); ?></a>
				<a class="doro-support__btn doro-support__btn--ghost" href="<?php echo esc_url( $protect_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_returns_protect_btn' ) ); ?></a>
			</div>
		</section>
	</div>
</main>

<?php
get_footer();
