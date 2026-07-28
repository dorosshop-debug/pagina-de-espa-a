<?php
/**
 * Template Name: Protección del comprador
 * Template post type: page
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$help_url     = function_exists( 'doroshopping_get_page_url' ) ? doroshopping_get_page_url( 'centro-de-ayuda' ) : home_url( '/centro-de-ayuda/' );
$payments_url = function_exists( 'doroshopping_get_page_url' ) ? doroshopping_get_page_url( 'metodos-de-pago' ) : home_url( '/metodos-de-pago/' );
$privacy_url  = function_exists( 'doroshopping_get_page_url' ) ? doroshopping_get_page_url( 'politica-de-privacidad' ) : home_url( '/politica-de-privacidad/' );
$returns_url  = function_exists( 'doroshopping_get_page_url' ) ? doroshopping_get_page_url( 'politica-de-devoluciones' ) : home_url( '/politica-de-devoluciones/' );
$site_name    = get_bloginfo( 'name' ) ? get_bloginfo( 'name' ) : 'Doroshopping';
?>

<main id="main-content" class="doro-support doro-info doro-protect">
	<div class="doro-support__hero">
		<div class="doro-support__hero-inner">
			<p class="doro-support__eyebrow"><?php esc_html_e( 'Confianza', 'doroshopping' ); ?></p>
			<h1 class="doro-support__title"><?php esc_html_e( 'Seguridad y protección del comprador', 'doroshopping' ); ?></h1>
			<p class="doro-support__lead">
				<?php
				echo esc_html(
					sprintf(
						/* translators: %s: site name */
						__( 'En %s protegemos tu compra con pagos seguros, seguimiento del pedido y soporte ante incidencias.', 'doroshopping' ),
						$site_name
					)
				);
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
				<h3><?php esc_html_e( 'Pagos seguros', 'doroshopping' ); ?></h3>
				<p><?php esc_html_e( 'Transacciones con cifrado SSL/TLS a través de pasarelas certificadas. No almacenamos el número completo de tu tarjeta.', 'doroshopping' ); ?></p>
			</article>
			<article class="doro-info__method">
				<span class="doro-info__method-icon" aria-hidden="true">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
				</span>
				<h3><?php esc_html_e( 'Seguimiento del pedido', 'doroshopping' ); ?></h3>
				<p><?php esc_html_e( 'Confirmación por email y acceso al estado del envío desde tu cuenta cuando el tracking esté disponible.', 'doroshopping' ); ?></p>
			</article>
			<article class="doro-info__method">
				<span class="doro-info__method-icon" aria-hidden="true">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M3 14h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-7a9 9 0 0 1 18 0v7a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3"/></svg>
				</span>
				<h3><?php esc_html_e( 'Soporte ante incidencias', 'doroshopping' ); ?></h3>
				<p><?php esc_html_e( 'Si hay un problema de entrega, producto o cobro, nuestro equipo te ayuda desde el Centro de ayuda.', 'doroshopping' ); ?></p>
			</article>
		</section>

		<section class="doro-info__split doro-info__split--spaced">
			<article class="doro-info__card">
				<h2><?php esc_html_e( 'Tus derechos como consumidor', 'doroshopping' ); ?></h2>
				<ul class="doro-info__checklist">
					<li><?php esc_html_e( 'Derecho de desistimiento según la normativa de la UE (consulta la Política de devoluciones).', 'doroshopping' ); ?></li>
					<li><?php esc_html_e( 'Garantía legal de conformidad aplicable a productos defectuosos.', 'doroshopping' ); ?></li>
					<li><?php esc_html_e( 'Información clara de precios, envío y condiciones antes de pagar.', 'doroshopping' ); ?></li>
				</ul>
				<a class="doro-support__btn doro-support__btn--ghost" href="<?php echo esc_url( $returns_url ); ?>"><?php esc_html_e( 'Ver devoluciones', 'doroshopping' ); ?></a>
			</article>
			<article class="doro-info__card">
				<h2><?php esc_html_e( 'Consejos prácticos', 'doroshopping' ); ?></h2>
				<ul class="doro-info__checklist">
					<li><?php esc_html_e( 'Revisa la dirección de entrega antes de confirmar.', 'doroshopping' ); ?></li>
					<li><?php esc_html_e( 'Guarda el email de confirmación y el número de pedido.', 'doroshopping' ); ?></li>
					<li><?php esc_html_e( 'Contacta con nosotros si detectas un cargo no reconocido.', 'doroshopping' ); ?></li>
					<li><?php esc_html_e( 'Usa siempre la web por HTTPS y no compartas tus credenciales.', 'doroshopping' ); ?></li>
				</ul>
				<a class="doro-support__btn doro-support__btn--ghost" href="<?php echo esc_url( $privacy_url ); ?>"><?php esc_html_e( 'Política de privacidad', 'doroshopping' ); ?></a>
			</article>
		</section>

		<section class="doro-faq__cta">
			<h2><?php esc_html_e( '¿Necesitas ayuda con una compra?', 'doroshopping' ); ?></h2>
			<p><?php esc_html_e( 'Escríbenos con tu número de pedido y te responderemos lo antes posible.', 'doroshopping' ); ?></p>
			<div class="doro-coupons__actions doro-info__actions doro-info__actions--center">
				<a class="doro-support__btn" href="<?php echo esc_url( $help_url ); ?>"><?php esc_html_e( 'Centro de ayuda', 'doroshopping' ); ?></a>
				<a class="doro-support__btn doro-support__btn--ghost" href="<?php echo esc_url( $payments_url ); ?>"><?php esc_html_e( 'Métodos de pago', 'doroshopping' ); ?></a>
			</div>
		</section>
	</div>
</main>

<?php
get_footer();
