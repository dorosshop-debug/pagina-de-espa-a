<?php
/**
 * Template Name: Protección del comprador
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

$help_url     = function_exists( 'doroshopping_get_page_url' ) ? doroshopping_get_page_url( 'centro-de-ayuda' ) : home_url( '/centro-de-ayuda/' );
$payments_url = function_exists( 'doroshopping_get_page_url' ) ? doroshopping_get_page_url( 'metodos-de-pago' ) : home_url( '/metodos-de-pago/' );
$privacy_url  = function_exists( 'doroshopping_get_page_url' ) ? doroshopping_get_page_url( 'politica-de-privacidad' ) : home_url( '/politica-de-privacidad/' );
$returns_url  = function_exists( 'doroshopping_get_page_url' ) ? doroshopping_get_page_url( 'politica-de-devoluciones' ) : home_url( '/politica-de-devoluciones/' );
$site_name    = get_bloginfo( 'name' ) ? get_bloginfo( 'name' ) : 'Doroshopping';
?>

<main id="main-content" class="doro-support doro-info doro-protect">
	<div class="doro-support__hero">
		<div class="doro-support__hero-inner">
			<p class="doro-support__eyebrow"><?php echo esc_html( $ui( 'doroshopping_ui_protect_eyebrow' ) ); ?></p>
			<h1 class="doro-support__title"><?php echo esc_html( $ui( 'doroshopping_ui_protect_title' ) ); ?></h1>
			<p class="doro-support__lead">
				<?php
				echo esc_html( function_exists( 'doroshopping_ui_sprintf' ) ? doroshopping_ui_sprintf( 'doroshopping_ui_protect_lead', $site_name ) : sprintf( $ui( 'doroshopping_ui_protect_lead' ), $site_name ) );
				?>
			</p>
		</div>
	</div>

	<div class="doro-support__container">
		<section class="doro-info__methods">
			<article class="doro-info__method">
				<span class="doro-info__method-icon" aria-hidden="true">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
				</span>
				<h3><?php echo esc_html( $ui( 'doroshopping_ui_protect_pay_title' ) ); ?></h3>
				<p><?php echo esc_html( $ui( 'doroshopping_ui_protect_pay_text' ) ); ?></p>
			</article>
			<article class="doro-info__method">
				<span class="doro-info__method-icon" aria-hidden="true">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
				</span>
				<h3><?php echo esc_html( $ui( 'doroshopping_ui_protect_track_title' ) ); ?></h3>
				<p><?php echo esc_html( $ui( 'doroshopping_ui_protect_track_text' ) ); ?></p>
			</article>
			<article class="doro-info__method">
				<span class="doro-info__method-icon" aria-hidden="true">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M3 14h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-7a9 9 0 0 1 18 0v7a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3"/></svg>
				</span>
				<h3><?php echo esc_html( $ui( 'doroshopping_ui_protect_support_title' ) ); ?></h3>
				<p><?php echo esc_html( $ui( 'doroshopping_ui_protect_support_text' ) ); ?></p>
			</article>
		</section>

		<section class="doro-info__split doro-info__split--spaced">
			<article class="doro-info__card">
				<h2><?php echo esc_html( $ui( 'doroshopping_ui_protect_rights_title' ) ); ?></h2>
				<ul class="doro-info__checklist">
					<li><?php echo esc_html( $ui( 'doroshopping_ui_protect_rights_1' ) ); ?></li>
					<li><?php echo esc_html( $ui( 'doroshopping_ui_protect_rights_2' ) ); ?></li>
					<li><?php echo esc_html( $ui( 'doroshopping_ui_protect_rights_3' ) ); ?></li>
				</ul>
				<a class="doro-support__btn doro-support__btn--ghost" href="<?php echo esc_url( $returns_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_protect_returns_btn' ) ); ?></a>
			</article>
			<article class="doro-info__card">
				<h2><?php echo esc_html( $ui( 'doroshopping_ui_protect_tips_title' ) ); ?></h2>
				<ul class="doro-info__checklist">
					<li><?php echo esc_html( $ui( 'doroshopping_ui_protect_tips_1' ) ); ?></li>
					<li><?php echo esc_html( $ui( 'doroshopping_ui_protect_tips_2' ) ); ?></li>
					<li><?php echo esc_html( $ui( 'doroshopping_ui_protect_tips_3' ) ); ?></li>
					<li><?php echo esc_html( $ui( 'doroshopping_ui_protect_tips_4' ) ); ?></li>
				</ul>
				<a class="doro-support__btn doro-support__btn--ghost" href="<?php echo esc_url( $privacy_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_protect_privacy_btn' ) ); ?></a>
			</article>
		</section>

		<section class="doro-faq__cta">
			<h2><?php echo esc_html( $ui( 'doroshopping_ui_protect_cta_title' ) ); ?></h2>
			<p><?php echo esc_html( $ui( 'doroshopping_ui_protect_cta_text' ) ); ?></p>
			<div class="doro-coupons__actions doro-info__actions doro-info__actions--center">
				<a class="doro-support__btn" href="<?php echo esc_url( $help_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_protect_help_btn' ) ); ?></a>
				<a class="doro-support__btn doro-support__btn--ghost" href="<?php echo esc_url( $payments_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_protect_pay_btn' ) ); ?></a>
			</div>
		</section>
	</div>
</main>

<?php
get_footer();
