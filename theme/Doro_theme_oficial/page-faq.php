<?php
/**
 * Template Name: Preguntas frecuentes
 * Template post type: page
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$help_url = function_exists( 'doroshopping_get_page_url' ) ? doroshopping_get_page_url( 'centro-de-ayuda' ) : home_url( '/centro-de-ayuda/' );

$faqs = array(
	__( 'Pedidos y cuenta', 'doroshopping' ) => array(
		array(
			'q' => __( '¿Cómo puedo rastrear mi pedido?', 'doroshopping' ),
			'a' => __( 'Cuando tu pedido se envíe, recibirás un email con el número de seguimiento. También puedes consultar el estado en Mi cuenta → Pedidos. Si el tracking no se actualiza en 48–72 h, contacta con soporte e indica tu número de pedido.', 'doroshopping' ),
		),
		array(
			'q' => __( '¿Puedo modificar o cancelar un pedido?', 'doroshopping' ),
			'a' => __( 'Si el pedido aún no se ha procesado ni enviado, podemos intentar modificarlo o cancelarlo. Escribe cuanto antes al Centro de ayuda con tu número de pedido. Una vez en tránsito, solo podrás gestionar devolución tras recibirlo.', 'doroshopping' ),
		),
		array(
			'q' => __( 'No he recibido el email de confirmación', 'doroshopping' ),
			'a' => __( 'Revisa la carpeta de spam o promociones. Confirma que el correo de tu cuenta es correcto en Mi cuenta → Detalles. Si el pago se completó, el pedido debería aparecer en tu historial aunque el email se haya retrasado.', 'doroshopping' ),
		),
	),
	__( 'Pagos', 'doroshopping' )           => array(
		array(
			'q' => __( '¿Qué métodos de pago aceptáis?', 'doroshopping' ),
			'a' => __( 'Aceptamos las pasarelas disponibles en checkout (tarjeta, métodos locales europeos como Klarna cuando aplique, y otros habilitados en tu país/moneda). El pago se procesa de forma segura; no almacenamos el número completo de tu tarjeta.', 'doroshopping' ),
		),
		array(
			'q' => __( '¿Por qué se me ha cobrado / autorizado un importe?', 'doroshopping' ),
			'a' => __( 'Al pagar con tarjeta es habitual una preautorización o cargo al confirmar el pedido. Si cancelas a tiempo o el pedido falla, el importe se libera según los plazos de tu banco (puede tardar varios días laborables).', 'doroshopping' ),
		),
		array(
			'q' => __( '¿Puedo usar un cupón de descuento?', 'doroshopping' ),
			'a' => __( 'Sí. Introduce el código en la página Cupones, en el carrito o en el checkout. El cupón debe estar activo, no caducado y cumplir condiciones (importe mínimo, productos, un solo uso, etc.).', 'doroshopping' ),
		),
	),
	__( 'Envíos', 'doroshopping' )          => array(
		array(
			'q' => __( '¿Cuánto tarda el envío?', 'doroshopping' ),
			'a' => __( 'Los plazos dependen del destino, el producto y el transportista. En España y UE suelen oscilar entre unos días y un par de semanas tras la expedición. En la ficha del producto y en Envíos verás estimaciones orientativas.', 'doroshopping' ),
		),
		array(
			'q' => __( '¿Hay gastos de envío o aduanas?', 'doroshopping' ),
			'a' => __( 'El coste de envío se calcula en el carrito según dirección y peso/volumen. En envíos internacionales fuera de la UE pueden aplicarse aranceles o IVA de importación a cargo del destinatario, según la normativa local.', 'doroshopping' ),
		),
		array(
			'q' => __( 'El paquete aparece como entregado pero no lo he recibido', 'doroshopping' ),
			'a' => __( 'Revisa con vecinos, portería o puntos de recogida. Si no aparece en 24–48 h, contacta con soporte con el tracking y fotos de la incidencia; abriremos reclamación con el transportista.', 'doroshopping' ),
		),
	),
	__( 'Devoluciones y reembolsos', 'doroshopping' ) => array(
		array(
			'q' => __( '¿Cómo solicito una devolución?', 'doroshopping' ),
			'a' => __( 'Dentro del plazo legal de desistimiento (normalmente 14 días desde la recepción en la UE), solicita la devolución desde el Centro de ayuda o consulta la Política de devoluciones. El producto debe estar en buen estado, con embalaje cuando sea posible.', 'doroshopping' ),
		),
		array(
			'q' => __( '¿Cuándo recibiré el reembolso?', 'doroshopping' ),
			'a' => __( 'Tras recibir y verificar la devolución, procesamos el reembolso al método de pago original. El abono en tu cuenta bancaria puede tardar varios días laborables según el banco o la pasarela.', 'doroshopping' ),
		),
		array(
			'q' => __( 'El producto llegó dañado o incorrecto', 'doroshopping' ),
			'a' => __( 'Contáctanos en las primeras 48 h con número de pedido, fotos del daño/embalaje y descripción. Gestionaremos reposición, reembolso o solución equivalente según el caso.', 'doroshopping' ),
		),
	),
	__( 'Productos y garantía', 'doroshopping' ) => array(
		array(
			'q' => __( 'La descripción no coincide con el producto', 'doroshopping' ),
			'a' => __( 'Las fichas se basan en información del proveedor. Si hay una discrepancia relevante, envíanos fotos y el número de pedido para revisarlo y ofrecerte una solución.', 'doroshopping' ),
		),
		array(
			'q' => __( '¿Los productos tienen garantía?', 'doroshopping' ),
			'a' => __( 'Aplican los derechos de garantía legal de conformidad en la UE. Conserva la factura/confirmación de pedido. Para fallos de funcionamiento, contacta con soporte indicando el defecto y las pruebas.', 'doroshopping' ),
		),
	),
);
?>

<main id="main-content" class="doro-support doro-faq">
	<div class="doro-support__hero">
		<div class="doro-support__hero-inner">
			<p class="doro-support__eyebrow"><?php esc_html_e( 'Ayuda', 'doroshopping' ); ?></p>
			<h1 class="doro-support__title"><?php esc_html_e( 'Preguntas frecuentes', 'doroshopping' ); ?></h1>
			<p class="doro-support__lead">
				<?php esc_html_e( 'Respuestas rápidas sobre pedidos, pagos, envíos, devoluciones y tu cuenta. Si no encuentras lo que buscas, escribe a nuestro equipo.', 'doroshopping' ); ?>
			</p>
			<a class="doro-support__btn" href="<?php echo esc_url( $help_url ); ?>"><?php esc_html_e( 'Contactar soporte', 'doroshopping' ); ?></a>
		</div>
	</div>

	<div class="doro-support__container">
		<?php foreach ( $faqs as $section => $items ) : ?>
			<section class="doro-faq__section">
				<h2 class="doro-support__section-title"><?php echo esc_html( $section ); ?></h2>
				<div class="doro-faq__list">
					<?php foreach ( $items as $item ) : ?>
						<details class="doro-faq__item">
							<summary class="doro-faq__question"><?php echo esc_html( $item['q'] ); ?></summary>
							<div class="doro-faq__answer">
								<p><?php echo esc_html( $item['a'] ); ?></p>
							</div>
						</details>
					<?php endforeach; ?>
				</div>
			</section>
		<?php endforeach; ?>

		<section class="doro-faq__cta">
			<h2><?php esc_html_e( '¿Sigues necesitando ayuda?', 'doroshopping' ); ?></h2>
			<p><?php esc_html_e( 'Nuestro equipo de atención al cliente está listo para ayudarte con tu caso concreto.', 'doroshopping' ); ?></p>
			<a class="doro-support__btn" href="<?php echo esc_url( $help_url ); ?>"><?php esc_html_e( 'Ir al Centro de ayuda', 'doroshopping' ); ?></a>
		</section>
	</div>
</main>

<?php
get_footer();
