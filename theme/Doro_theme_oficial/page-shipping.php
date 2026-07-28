<?php
/**
 * Template Name: Envíos
 * Template post type: page
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

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
			<p class="doro-support__eyebrow"><?php esc_html_e( 'Logística', 'doroshopping' ); ?></p>
			<h1 class="doro-support__title"><?php esc_html_e( 'Envíos', 'doroshopping' ); ?></h1>
			<p class="doro-support__lead">
				<?php esc_html_e( 'Plazos orientativos, costes en el carrito y seguimiento de tu pedido. La estimación final depende del destino y del producto.', 'doroshopping' ); ?>
			</p>
		</div>
	</div>

	<div class="doro-support__container">
		<section class="doro-coupons__howto">
			<h2 class="doro-support__section-title"><?php esc_html_e( 'Cómo llega tu pedido', 'doroshopping' ); ?></h2>
			<div class="doro-support__cards">
				<article class="doro-support__card">
					<span class="doro-support__card-num" aria-hidden="true">1</span>
					<h3><?php esc_html_e( 'Confirmación', 'doroshopping' ); ?></h3>
					<p><?php esc_html_e( 'Tras el pago recibes un email de confirmación con el resumen del pedido.', 'doroshopping' ); ?></p>
				</article>
				<article class="doro-support__card">
					<span class="doro-support__card-num" aria-hidden="true">2</span>
					<h3><?php esc_html_e( 'Preparación y envío', 'doroshopping' ); ?></h3>
					<p><?php esc_html_e( 'El pedido se prepara y se entrega al transportista. Los plazos de expedición varían según stock y origen.', 'doroshopping' ); ?></p>
				</article>
				<article class="doro-support__card">
					<span class="doro-support__card-num" aria-hidden="true">3</span>
					<h3><?php esc_html_e( 'Seguimiento', 'doroshopping' ); ?></h3>
					<p><?php esc_html_e( 'Cuando haya tracking, lo verás por email y en Mi cuenta → Pedidos.', 'doroshopping' ); ?></p>
				</article>
			</div>
		</section>

		<section class="doro-info__split">
			<article class="doro-info__card">
				<h2><?php esc_html_e( 'Zonas y plazos', 'doroshopping' ); ?></h2>
				<ul class="doro-info__checklist">
					<li><?php esc_html_e( 'España peninsular y UE: normalmente entre unos días y un par de semanas tras la expedición.', 'doroshopping' ); ?></li>
					<li><?php esc_html_e( 'Islas, zonas remotas o fuera de la UE: plazos más largos y posibles trámites adicionales.', 'doroshopping' ); ?></li>
					<li><?php esc_html_e( 'En la ficha del producto verás estimaciones orientativas cuando estén disponibles.', 'doroshopping' ); ?></li>
				</ul>
				<p class="doro-info__note"><?php esc_html_e( 'Los plazos son estimados y pueden verse afectados por picos de demanda, aduanas o incidencias del transportista.', 'doroshopping' ); ?></p>
			</article>
			<article class="doro-info__card">
				<h2><?php esc_html_e( 'Costes y aduanas', 'doroshopping' ); ?></h2>
				<ul class="doro-info__checklist">
					<li><?php esc_html_e( 'El coste de envío se calcula en el carrito según dirección y peso/volumen.', 'doroshopping' ); ?></li>
					<li><?php esc_html_e( 'Fuera de la UE pueden aplicarse aranceles o IVA de importación a cargo del destinatario.', 'doroshopping' ); ?></li>
					<li><?php esc_html_e( 'Revisa siempre la dirección antes de pagar para evitar retrasos o reenvíos.', 'doroshopping' ); ?></li>
				</ul>
				<a class="doro-support__btn doro-support__btn--ghost" href="<?php echo esc_url( $returns_url ); ?>"><?php esc_html_e( 'Política de devoluciones', 'doroshopping' ); ?></a>
			</article>
		</section>

		<section class="doro-info__panel doro-info__panel--accent">
			<div class="doro-info__panel-head">
				<h2 class="doro-support__section-title"><?php esc_html_e( '¿Dónde está mi pedido?', 'doroshopping' ); ?></h2>
				<p><?php esc_html_e( 'Consulta el estado en tu cuenta o contacta con soporte si el tracking no se actualiza en 48–72 h.', 'doroshopping' ); ?></p>
			</div>
			<div class="doro-coupons__actions doro-info__actions">
				<a class="doro-support__btn" href="<?php echo esc_url( $orders_url ); ?>"><?php esc_html_e( 'Ver mis pedidos', 'doroshopping' ); ?></a>
				<a class="doro-support__btn doro-support__btn--ghost" href="<?php echo esc_url( $help_url ); ?>"><?php esc_html_e( 'Contactar soporte', 'doroshopping' ); ?></a>
			</div>
		</section>
	</div>
</main>

<?php
get_footer();
