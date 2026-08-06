<?php
/**
 * Template Name: Envíos
 * Template post type: page
 *
 * Textos vía doroshopping_ui_text (Personalizar + packs por idioma).
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
$account_url = function_exists( 'doroshopping_get_account_url' ) ? doroshopping_get_account_url() : home_url( '/' );
$orders_url  = ( function_exists( 'wc_get_endpoint_url' ) && $account_url )
	? wc_get_endpoint_url( 'orders', '', $account_url )
	: $account_url;
$returns_url = function_exists( 'doroshopping_get_page_url' ) ? doroshopping_get_page_url( 'politica-de-devoluciones' ) : home_url( '/' );
?>

<main id="main-content" class="doro-support doro-info doro-shipping">
	<div class="doro-support__hero">
		<div class="doro-support__hero-inner">
			<p class="doro-support__eyebrow"><?php echo esc_html( $ui( 'doroshopping_ui_shippage_eyebrow' ) ); ?></p>
			<h1 class="doro-support__title"><?php echo esc_html( $ui( 'doroshopping_ui_shippage_title' ) ); ?></h1>
			<p class="doro-support__lead"><?php echo esc_html( $ui( 'doroshopping_ui_shippage_lead' ) ); ?></p>
		</div>
	</div>

	<div class="doro-support__container">
		<section class="doro-coupons__howto">
			<h2 class="doro-support__section-title"><?php echo esc_html( $ui( 'doroshopping_ui_shippage_howto' ) ); ?></h2>
			<div class="doro-support__cards">
				<article class="doro-support__card">
					<span class="doro-support__card-num" aria-hidden="true">1</span>
					<h3><?php echo esc_html( $ui( 'doroshopping_ui_shippage_s1_title' ) ); ?></h3>
					<p><?php echo esc_html( $ui( 'doroshopping_ui_shippage_s1_text' ) ); ?></p>
				</article>
				<article class="doro-support__card">
					<span class="doro-support__card-num" aria-hidden="true">2</span>
					<h3><?php echo esc_html( $ui( 'doroshopping_ui_shippage_s2_title' ) ); ?></h3>
					<p><?php echo esc_html( $ui( 'doroshopping_ui_shippage_s2_text' ) ); ?></p>
				</article>
				<article class="doro-support__card">
					<span class="doro-support__card-num" aria-hidden="true">3</span>
					<h3><?php echo esc_html( $ui( 'doroshopping_ui_shippage_s3_title' ) ); ?></h3>
					<p><?php echo esc_html( $ui( 'doroshopping_ui_shippage_s3_text' ) ); ?></p>
				</article>
			</div>
		</section>

		<section class="doro-info__split">
			<article class="doro-info__card">
				<h2><?php echo esc_html( $ui( 'doroshopping_ui_shippage_zones_title' ) ); ?></h2>
				<ul class="doro-info__checklist">
					<li><?php echo esc_html( $ui( 'doroshopping_ui_shippage_zones_1' ) ); ?></li>
					<li><?php echo esc_html( $ui( 'doroshopping_ui_shippage_zones_2' ) ); ?></li>
					<li><?php echo esc_html( $ui( 'doroshopping_ui_shippage_zones_3' ) ); ?></li>
				</ul>
				<p class="doro-info__note"><?php echo esc_html( $ui( 'doroshopping_ui_shippage_zones_note' ) ); ?></p>
			</article>
			<article class="doro-info__card">
				<h2><?php echo esc_html( $ui( 'doroshopping_ui_shippage_costs_title' ) ); ?></h2>
				<ul class="doro-info__checklist">
					<li><?php echo esc_html( $ui( 'doroshopping_ui_shippage_costs_1' ) ); ?></li>
					<li><?php echo esc_html( $ui( 'doroshopping_ui_shippage_costs_2' ) ); ?></li>
					<li><?php echo esc_html( $ui( 'doroshopping_ui_shippage_costs_3' ) ); ?></li>
				</ul>
				<a class="doro-support__btn doro-support__btn--ghost" href="<?php echo esc_url( $returns_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_shippage_returns_btn' ) ); ?></a>
			</article>
		</section>

		<section class="doro-info__panel doro-info__panel--accent">
			<div class="doro-info__panel-head">
				<h2 class="doro-support__section-title"><?php echo esc_html( $ui( 'doroshopping_ui_shippage_where_title' ) ); ?></h2>
				<p><?php echo esc_html( $ui( 'doroshopping_ui_shippage_where_text' ) ); ?></p>
			</div>
			<div class="doro-coupons__actions doro-info__actions">
				<a class="doro-support__btn" href="<?php echo esc_url( $orders_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_shippage_orders_btn' ) ); ?></a>
				<a class="doro-support__btn doro-support__btn--ghost" href="<?php echo esc_url( $help_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_shippage_support_btn' ) ); ?></a>
			</div>
		</section>
	</div>
</main>

<?php
get_footer();
