<?php
/**
 * Template Name: Preguntas frecuentes
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

$help_url = function_exists( 'doroshopping_get_page_url' ) ? doroshopping_get_page_url( 'centro-de-ayuda' ) : home_url( '/centro-de-ayuda/' );

$faqs = array(
	array( 'cat' => 'doroshopping_ui_faq_cat_orders', 'items' => array( array( 'q' => 'doroshopping_ui_faq_q_track', 'a' => 'doroshopping_ui_faq_a_track' ), array( 'q' => 'doroshopping_ui_faq_q_modify', 'a' => 'doroshopping_ui_faq_a_modify' ), array( 'q' => 'doroshopping_ui_faq_q_email', 'a' => 'doroshopping_ui_faq_a_email' ) ) ),
	array( 'cat' => 'doroshopping_ui_faq_cat_payments', 'items' => array( array( 'q' => 'doroshopping_ui_faq_q_methods', 'a' => 'doroshopping_ui_faq_a_methods' ), array( 'q' => 'doroshopping_ui_faq_q_charge', 'a' => 'doroshopping_ui_faq_a_charge' ), array( 'q' => 'doroshopping_ui_faq_q_coupon', 'a' => 'doroshopping_ui_faq_a_coupon' ) ) ),
	array( 'cat' => 'doroshopping_ui_faq_cat_shipping', 'items' => array( array( 'q' => 'doroshopping_ui_faq_q_time', 'a' => 'doroshopping_ui_faq_a_time' ), array( 'q' => 'doroshopping_ui_faq_q_costs', 'a' => 'doroshopping_ui_faq_a_costs' ), array( 'q' => 'doroshopping_ui_faq_q_missing', 'a' => 'doroshopping_ui_faq_a_missing' ) ) ),
	array( 'cat' => 'doroshopping_ui_faq_cat_returns', 'items' => array( array( 'q' => 'doroshopping_ui_faq_q_how', 'a' => 'doroshopping_ui_faq_a_how' ), array( 'q' => 'doroshopping_ui_faq_q_refund', 'a' => 'doroshopping_ui_faq_a_refund' ), array( 'q' => 'doroshopping_ui_faq_q_damaged', 'a' => 'doroshopping_ui_faq_a_damaged' ) ) ),
	array( 'cat' => 'doroshopping_ui_faq_cat_products', 'items' => array( array( 'q' => 'doroshopping_ui_faq_q_mismatch', 'a' => 'doroshopping_ui_faq_a_mismatch' ), array( 'q' => 'doroshopping_ui_faq_q_warranty', 'a' => 'doroshopping_ui_faq_a_warranty' ) ) ),
);
?>

<main id="main-content" class="doro-support doro-faq">
	<div class="doro-support__hero">
		<div class="doro-support__hero-inner">
			<p class="doro-support__eyebrow"><?php echo esc_html( $ui( 'doroshopping_ui_faq_eyebrow' ) ); ?></p>
			<h1 class="doro-support__title"><?php echo esc_html( $ui( 'doroshopping_ui_faq_title' ) ); ?></h1>
			<p class="doro-support__lead"><?php echo esc_html( $ui( 'doroshopping_ui_faq_lead' ) ); ?></p>
			<a class="doro-support__btn" href="<?php echo esc_url( $help_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_faq_contact_btn' ) ); ?></a>
		</div>
	</div>

	<div class="doro-support__container">
		<?php foreach ( $faqs as $section ) : ?>
			<section class="doro-faq__section">
				<h2 class="doro-support__section-title"><?php echo esc_html( $ui( $section['cat'] ) ); ?></h2>
				<div class="doro-faq__list">
					<?php foreach ( $section['items'] as $item ) : ?>
						<details class="doro-faq__item">
							<summary class="doro-faq__question"><?php echo esc_html( $ui( $item['q'] ) ); ?></summary>
							<div class="doro-faq__answer">
								<p><?php echo esc_html( $ui( $item['a'] ) ); ?></p>
							</div>
						</details>
					<?php endforeach; ?>
				</div>
			</section>
		<?php endforeach; ?>

		<section class="doro-faq__cta">
			<h2><?php echo esc_html( $ui( 'doroshopping_ui_faq_cta_title' ) ); ?></h2>
			<p><?php echo esc_html( $ui( 'doroshopping_ui_faq_cta_text' ) ); ?></p>
			<a class="doro-support__btn" href="<?php echo esc_url( $help_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_faq_cta_btn' ) ); ?></a>
		</section>
	</div>
</main>

<?php
get_footer();
