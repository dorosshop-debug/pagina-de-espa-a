<?php
/**
 * Template Name: Métodos de pago
 * Template post type: page
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

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
			<p class="doro-support__eyebrow"><?php esc_html_e( 'Compra segura', 'doroshopping' ); ?></p>
			<h1 class="doro-support__title"><?php esc_html_e( 'Métodos de pago', 'doroshopping' ); ?></h1>
			<p class="doro-support__lead">
				<?php esc_html_e( 'Paga con los métodos disponibles en el checkout. Todas las transacciones se procesan con cifrado y pasarelas certificadas.', 'doroshopping' ); ?>
			</p>
		</div>
	</div>

	<div class="doro-support__container">
		<section class="doro-info__panel">
			<div class="doro-info__panel-head">
				<h2 class="doro-support__section-title"><?php esc_html_e( 'Formas de pago aceptadas', 'doroshopping' ); ?></h2>
				<p><?php esc_html_e( 'Las opciones visibles en el checkout pueden variar según tu país, moneda y la configuración de la tienda.', 'doroshopping' ); ?></p>
			</div>
			<div class="doro-info__methods">
				<article class="doro-info__method">
					<span class="doro-info__method-icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
					</span>
					<h3><?php esc_html_e( 'Tarjeta de crédito / débito', 'doroshopping' ); ?></h3>
					<p><?php esc_html_e( 'Visa, Mastercard y otras tarjetas admitidas por la pasarela. El cargo o preautorización se realiza al confirmar el pedido.', 'doroshopping' ); ?></p>
				</article>
				<article class="doro-info__method">
					<span class="doro-info__method-icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M12 3v18"/><path d="M5 8h14"/><path d="M7 12h10"/><path d="M9 16h6"/></svg>
					</span>
					<h3><?php esc_html_e( 'Pago aplazado / local', 'doroshopping' ); ?></h3>
					<p><?php esc_html_e( 'Métodos como Klarna u otras soluciones locales europeas cuando estén habilitadas en tu país.', 'doroshopping' ); ?></p>
				</article>
				<article class="doro-info__method">
					<span class="doro-info__method-icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
					</span>
					<h3><?php esc_html_e( 'Wallets y otros', 'doroshopping' ); ?></h3>
					<p><?php esc_html_e( 'Si están activados (p. ej. PayPal u otros wallets), aparecerán automáticamente en la página de pago.', 'doroshopping' ); ?></p>
				</article>
			</div>
			<?php if ( $payment_img ) : ?>
				<div class="doro-info__payments-visual">
					<img src="<?php echo esc_url( $payment_img ); ?>" alt="<?php esc_attr_e( 'Medios de pago aceptados', 'doroshopping' ); ?>" loading="lazy" width="480" height="60">
				</div>
			<?php endif; ?>
		</section>

		<section class="doro-info__split">
			<article class="doro-info__card">
				<h2><?php esc_html_e( 'Seguridad del pago', 'doroshopping' ); ?></h2>
				<ul class="doro-info__checklist">
					<li><?php esc_html_e( 'Conexión HTTPS en toda la tienda.', 'doroshopping' ); ?></li>
					<li><?php esc_html_e( 'Datos de tarjeta gestionados por la pasarela; no guardamos el número completo.', 'doroshopping' ); ?></li>
					<li><?php esc_html_e( 'Confirmación por email tras un pago correcto.', 'doroshopping' ); ?></li>
				</ul>
				<a class="doro-support__btn doro-support__btn--ghost" href="<?php echo esc_url( $protect_url ); ?>"><?php esc_html_e( 'Protección del comprador', 'doroshopping' ); ?></a>
			</article>
			<article class="doro-info__card">
				<h2><?php esc_html_e( 'Consejos útiles', 'doroshopping' ); ?></h2>
				<ul class="doro-info__checklist">
					<li><?php esc_html_e( 'Revisa el importe y la moneda antes de confirmar.', 'doroshopping' ); ?></li>
					<li><?php esc_html_e( 'Si ves una preautorización pendiente, suele liberarse si el pedido no se completa.', 'doroshopping' ); ?></li>
					<li><?php esc_html_e( 'Guarda el número de pedido para cualquier consulta de facturación.', 'doroshopping' ); ?></li>
				</ul>
				<a class="doro-support__btn" href="<?php echo esc_url( $help_url ); ?>"><?php esc_html_e( 'Ayuda con un pago', 'doroshopping' ); ?></a>
			</article>
		</section>

		<section class="doro-faq__cta">
			<h2><?php esc_html_e( '¿Listo para comprar?', 'doroshopping' ); ?></h2>
			<p><?php esc_html_e( 'Elige tus productos y completa el pago en un checkout seguro.', 'doroshopping' ); ?></p>
			<a class="doro-support__btn" href="<?php echo esc_url( $checkout_url ); ?>"><?php esc_html_e( 'Ir al checkout', 'doroshopping' ); ?></a>
		</section>
	</div>
</main>

<?php
get_footer();
