<?php
/**
 * Template Name: Contacto
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

$page_url = static function ( $slug ) {
	return function_exists( 'doroshopping_get_page_url' ) ? doroshopping_get_page_url( $slug ) : home_url( '/' . $slug . '/' );
};
$help_url  = $page_url( 'centro-de-ayuda' );
$whatsapp  = function_exists( 'doroshopping_get_whatsapp_url' ) ? doroshopping_get_whatsapp_url() : '';
?>

<main id="main-content" class="doro-support doro-contact">
	<div class="doro-support__hero">
		<div class="doro-support__hero-inner">
			<p class="doro-support__eyebrow"><?php echo esc_html( $ui( 'doroshopping_ui_contact_eyebrow' ) ); ?></p>
			<h1 class="doro-support__title"><?php echo esc_html( $ui( 'doroshopping_ui_contact_title' ) ); ?></h1>
			<p class="doro-support__lead"><?php echo esc_html( $ui( 'doroshopping_ui_contact_lead' ) ); ?></p>
		</div>
	</div>

	<div class="doro-support__container">
		<div class="doro-help__layout">
			<section class="doro-info__panel">
				<h2 class="doro-support__section-title"><?php echo esc_html( $ui( 'doroshopping_ui_contact_form_cta_title' ) ); ?></h2>
				<p><?php echo esc_html( $ui( 'doroshopping_ui_contact_form_cta_text' ) ); ?></p>
				<a class="doro-support__btn" href="<?php echo esc_url( $help_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_contact_form_btn' ) ); ?></a>
			</section>

			<aside class="doro-help__aside">
				<div class="doro-help__aside-card">
					<h2><?php echo esc_html( $ui( 'doroshopping_ui_contact_email_title' ) ); ?></h2>
					<p><?php echo esc_html( $ui( 'doroshopping_ui_contact_email_text' ) ); ?></p>
					<p><a href="mailto:atencionalcliente@doroshopping.com">atencionalcliente@doroshopping.com</a></p>
				</div>
				<div class="doro-help__aside-card">
					<h2><?php echo esc_html( $ui( 'doroshopping_ui_contact_hours_title' ) ); ?></h2>
					<p><?php echo esc_html( $ui( 'doroshopping_ui_contact_hours_text' ) ); ?></p>
				</div>
				<?php if ( $whatsapp ) : ?>
					<div class="doro-help__aside-card doro-help__aside-card--whatsapp">
						<h2><?php echo esc_html( $ui( 'doroshopping_ui_help_wa_aside_title' ) ); ?></h2>
						<p><?php echo esc_html( $ui( 'doroshopping_ui_help_wa_aside_text' ) ); ?></p>
						<a class="doro-help__whatsapp" href="<?php echo esc_url( $whatsapp ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $ui( 'doroshopping_ui_help_wa_cta' ) ); ?></a>
					</div>
				<?php endif; ?>
				<div class="doro-help__aside-card">
					<h2><?php echo esc_html( $ui( 'doroshopping_ui_contact_links_title' ) ); ?></h2>
					<ul class="doro-help__links">
						<li><a href="<?php echo esc_url( $page_url( 'preguntas-frecuentes' ) ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_contact_link_faq' ) ); ?></a></li>
						<li><a href="<?php echo esc_url( $page_url( 'envios' ) ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_contact_link_shipping' ) ); ?></a></li>
						<li><a href="<?php echo esc_url( $page_url( 'politica-de-devoluciones' ) ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_contact_link_returns' ) ); ?></a></li>
						<li><a href="<?php echo esc_url( $page_url( 'metodos-de-pago' ) ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_contact_link_payments' ) ); ?></a></li>
					</ul>
				</div>
			</aside>
		</div>
	</div>
</main>

<?php
get_footer();
