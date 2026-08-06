<?php
/**
 * Template Name: Métodos de pago
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
$protect_url  = function_exists( 'doroshopping_get_page_url' ) ? doroshopping_get_page_url( 'proteccion-del-comprador' ) : home_url( '/proteccion-del-comprador/' );
$checkout_url = function_exists( 'doroshopping_get_checkout_url' ) ? doroshopping_get_checkout_url() : home_url( '/' );
$payment_img  = function_exists( 'doroshopping_get_theme_image_url' )
	? doroshopping_get_theme_image_url( 'payment_image', get_template_directory_uri() . '/assets/images/payment.png' )
	: get_template_directory_uri() . '/assets/images/payment.png';
?>

<main id="main-content" class="doro-support doro-info doro-payments">
	<div class="doro-support__hero">
		<div class="doro-support__hero-inner">
			<p class="doro-support__eyebrow"><?php echo esc_html( $ui( 'doroshopping_ui_paypage_eyebrow' ) ); ?></p>
			<h1 class="doro-support__title"><?php echo esc_html( $ui( 'doroshopping_ui_paypage_title' ) ); ?></h1>
			<p class="doro-support__lead"><?php echo esc_html( $ui( 'doroshopping_ui_paypage_lead' ) ); ?></p>
		</div>
	</div>

	<div class="doro-support__container">
		<section class="doro-info__panel">
			<div class="doro-info__panel-head">
				<h2 class="doro-support__section-title"><?php echo esc_html( $ui( 'doroshopping_ui_paypage_methods_title' ) ); ?></h2>
				<p><?php echo esc_html( $ui( 'doroshopping_ui_paypage_methods_intro' ) ); ?></p>
			</div>
			<div class="doro-info__methods">
				<article class="doro-info__method">
					<span class="doro-info__method-icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
					</span>
					<h3><?php echo esc_html( $ui( 'doroshopping_ui_paypage_card_title' ) ); ?></h3>
					<p><?php echo esc_html( $ui( 'doroshopping_ui_paypage_card_text' ) ); ?></p>
				</article>
				<article class="doro-info__method">
					<span class="doro-info__method-icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M12 3v18"/><path d="M5 8h14"/><path d="M7 12h10"/><path d="M9 16h6"/></svg>
					</span>
					<h3><?php echo esc_html( $ui( 'doroshopping_ui_paypage_local_title' ) ); ?></h3>
					<p><?php echo esc_html( $ui( 'doroshopping_ui_paypage_local_text' ) ); ?></p>
				</article>
				<article class="doro-info__method">
					<span class="doro-info__method-icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
					</span>
					<h3><?php echo esc_html( $ui( 'doroshopping_ui_paypage_wallet_title' ) ); ?></h3>
					<p><?php echo esc_html( $ui( 'doroshopping_ui_paypage_wallet_text' ) ); ?></p>
				</article>
			</div>
			<?php if ( $payment_img ) : ?>
				<div class="doro-info__payments-visual">
					<img src="<?php echo esc_url( $payment_img ); ?>" alt="<?php echo esc_attr( $ui( 'doroshopping_ui_paypage_img_alt' ) ); ?>" loading="lazy" width="480" height="60">
				</div>
			<?php endif; ?>
		</section>

		<section class="doro-info__split">
			<article class="doro-info__card">
				<h2><?php echo esc_html( $ui( 'doroshopping_ui_paypage_secure_title' ) ); ?></h2>
				<ul class="doro-info__checklist">
					<li><?php echo esc_html( $ui( 'doroshopping_ui_paypage_secure_1' ) ); ?></li>
					<li><?php echo esc_html( $ui( 'doroshopping_ui_paypage_secure_2' ) ); ?></li>
					<li><?php echo esc_html( $ui( 'doroshopping_ui_paypage_secure_3' ) ); ?></li>
				</ul>
				<a class="doro-support__btn doro-support__btn--ghost" href="<?php echo esc_url( $protect_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_paypage_protect_btn' ) ); ?></a>
			</article>
			<article class="doro-info__card">
				<h2><?php echo esc_html( $ui( 'doroshopping_ui_paypage_tips_title' ) ); ?></h2>
				<ul class="doro-info__checklist">
					<li><?php echo esc_html( $ui( 'doroshopping_ui_paypage_tips_1' ) ); ?></li>
					<li><?php echo esc_html( $ui( 'doroshopping_ui_paypage_tips_2' ) ); ?></li>
					<li><?php echo esc_html( $ui( 'doroshopping_ui_paypage_tips_3' ) ); ?></li>
				</ul>
				<a class="doro-support__btn" href="<?php echo esc_url( $help_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_paypage_help_btn' ) ); ?></a>
			</article>
		</section>

		<section class="doro-faq__cta">
			<h2><?php echo esc_html( $ui( 'doroshopping_ui_paypage_cta_title' ) ); ?></h2>
			<p><?php echo esc_html( $ui( 'doroshopping_ui_paypage_cta_text' ) ); ?></p>
			<a class="doro-support__btn" href="<?php echo esc_url( $checkout_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_paypage_cta_btn' ) ); ?></a>
		</section>
	</div>
</main>

<?php
get_footer();
