<?php
/**
 * Template Name: Centro de ayuda
 * Template post type: page
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$faq_url    = function_exists( 'doroshopping_get_page_url' ) ? doroshopping_get_page_url( 'preguntas-frecuentes' ) : home_url( '/preguntas-frecuentes/' );
$orders_url = ( function_exists( 'wc_get_endpoint_url' ) && function_exists( 'doroshopping_get_account_url' ) )
	? wc_get_endpoint_url( 'orders', '', doroshopping_get_account_url() )
	: home_url( '/' );
$sent       = isset( $_GET['support'] ) && 'sent' === sanitize_key( wp_unslash( $_GET['support'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$error      = isset( $_GET['support'] ) && 'error' === sanitize_key( wp_unslash( $_GET['support'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$user       = wp_get_current_user();
$whatsapp   = function_exists( 'doroshopping_get_whatsapp_url' ) ? doroshopping_get_whatsapp_url() : '';
?>

<main id="main-content" class="doro-support doro-help">
	<div class="doro-support__hero">
		<div class="doro-support__hero-inner">
			<p class="doro-support__eyebrow"><?php esc_html_e( 'Soporte Doroshopping', 'doroshopping' ); ?></p>
			<h1 class="doro-support__title"><?php esc_html_e( 'Centro de ayuda', 'doroshopping' ); ?></h1>
			<p class="doro-support__lead">
				<?php esc_html_e( '¿Tienes una duda sobre tu pedido, un pago o una devolución? Envíanos un mensaje y nuestro equipo te responderá lo antes posible.', 'doroshopping' ); ?>
			</p>
		</div>
	</div>

	<div class="doro-support__container">
		<div class="doro-help__layout">
			<section class="doro-help__form-wrap">
				<?php if ( $sent ) : ?>
					<div class="doro-support__notice doro-support__notice--success" role="status">
						<?php esc_html_e( 'Mensaje enviado. Te responderemos lo antes posible a tu correo.', 'doroshopping' ); ?>
					</div>
				<?php elseif ( $error ) : ?>
					<div class="doro-support__notice doro-support__notice--error" role="alert">
						<?php esc_html_e( 'No pudimos enviar el mensaje. Revisa los campos e inténtalo de nuevo.', 'doroshopping' ); ?>
					</div>
				<?php endif; ?>

				<h2 class="doro-support__section-title"><?php esc_html_e( 'Formulario de soporte', 'doroshopping' ); ?></h2>
				<form class="doro-help__form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" novalidate>
					<input type="hidden" name="action" value="doroshopping_support_form">
					<?php wp_nonce_field( 'doroshopping_support_form', 'doroshopping_support_nonce' ); ?>
					<p class="doro-help__honeypot" aria-hidden="true">
						<label for="doro_support_website"><?php esc_html_e( 'Sitio web', 'doroshopping' ); ?></label>
						<input type="text" name="doro_support_website" id="doro_support_website" value="" tabindex="-1" autocomplete="off">
					</p>

					<div class="doro-help__grid">
						<p class="doro-help__field">
							<label for="support_name"><?php esc_html_e( 'Nombre', 'doroshopping' ); ?> <span class="required">*</span></label>
							<input type="text" id="support_name" name="support_name" required value="<?php echo esc_attr( $user->exists() ? $user->display_name : '' ); ?>">
						</p>
						<p class="doro-help__field">
							<label for="support_email"><?php esc_html_e( 'Correo electrónico', 'doroshopping' ); ?> <span class="required">*</span></label>
							<input type="email" id="support_email" name="support_email" required value="<?php echo esc_attr( $user->exists() ? $user->user_email : '' ); ?>">
						</p>
					</div>

					<div class="doro-help__grid">
						<p class="doro-help__field">
							<label for="support_phone"><?php esc_html_e( 'Teléfono', 'doroshopping' ); ?> <span class="required">*</span></label>
							<input type="tel" id="support_phone" name="support_phone" required autocomplete="tel" placeholder="<?php esc_attr_e( 'Ej. +34 600 000 000', 'doroshopping' ); ?>" value="">
						</p>
						<p class="doro-help__field">
							<label for="support_order"><?php esc_html_e( 'Número de pedido (opcional)', 'doroshopping' ); ?></label>
							<input type="text" id="support_order" name="support_order" placeholder="<?php esc_attr_e( 'Ej. 10452', 'doroshopping' ); ?>">
						</p>
					</div>

					<p class="doro-help__field">
						<label for="support_topic"><?php esc_html_e( 'Tema', 'doroshopping' ); ?> <span class="required">*</span></label>
						<select id="support_topic" name="support_topic" required>
							<option value=""><?php esc_html_e( 'Selecciona un tema', 'doroshopping' ); ?></option>
							<option value="pedido"><?php esc_html_e( 'Pedido / seguimiento', 'doroshopping' ); ?></option>
							<option value="pago"><?php esc_html_e( 'Pago / factura', 'doroshopping' ); ?></option>
							<option value="envio"><?php esc_html_e( 'Envío / entrega', 'doroshopping' ); ?></option>
							<option value="devolucion"><?php esc_html_e( 'Devolución / reembolso', 'doroshopping' ); ?></option>
							<option value="producto"><?php esc_html_e( 'Producto / calidad', 'doroshopping' ); ?></option>
							<option value="cuenta"><?php esc_html_e( 'Cuenta / acceso', 'doroshopping' ); ?></option>
							<option value="otro"><?php esc_html_e( 'Otro', 'doroshopping' ); ?></option>
						</select>
					</p>

					<p class="doro-help__field">
						<label for="support_message"><?php esc_html_e( 'Mensaje', 'doroshopping' ); ?> <span class="required">*</span></label>
						<textarea id="support_message" name="support_message" rows="6" required placeholder="<?php esc_attr_e( 'Cuéntanos qué necesitas con el mayor detalle posible…', 'doroshopping' ); ?>"></textarea>
					</p>

					<p class="doro-help__actions">
						<button type="submit" class="doro-support__btn"><?php esc_html_e( 'Enviar solicitud', 'doroshopping' ); ?></button>
						<?php if ( $whatsapp ) : ?>
							<a class="doro-help__whatsapp doro-help__whatsapp--inline" href="<?php echo esc_url( $whatsapp ); ?>" target="_blank" rel="noopener noreferrer">
								<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.5 3.5A11 11 0 0 0 2.1 17.3L1 23l5.9-1.5A11 11 0 1 0 20.5 3.5zm-8.5 17a9 9 0 0 1-4.6-1.3l-.3-.2-3.5.9.9-3.4-.2-.3A9 9 0 1 1 12 20.5zm5.2-6.7c-.3-.1-1.7-.8-1.9-.9s-.5-.1-.7.1-.8.9-1 .9-.5.1-.9-.1a7.4 7.4 0 0 1-2.2-1.4 8.2 8.2 0 0 1-1.5-1.9c-.2-.3 0-.5.1-.6l.4-.5c.1-.1.2-.3.3-.5s0-.3 0-.5-.7-1.7-1-2.3c-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4s-1 1-1 2.4 1.1 2.8 1.2 3 .2.4 2.1 3.2a12.4 12.4 0 0 0 3.4 2.5c.5.2.9.2 1.2.1s1-.4 1.1-.8.1-.7.1-.8-.1-.2-.4-.3z"/></svg>
								<?php esc_html_e( 'WhatsApp', 'doroshopping' ); ?>
							</a>
						<?php endif; ?>
					</p>
					<p class="doro-help__meta">
						<?php esc_html_e( 'Tu mensaje se enviará a atencionalcliente@doroshopping.com', 'doroshopping' ); ?>
					</p>
				</form>
			</section>

			<aside class="doro-help__aside">
				<div class="doro-help__aside-card doro-help__aside-card--whatsapp">
					<h2><?php esc_html_e( 'WhatsApp', 'doroshopping' ); ?></h2>
					<?php if ( $whatsapp ) : ?>
						<p><?php esc_html_e( 'Si prefieres escribirnos por chat, contáctanos por WhatsApp.', 'doroshopping' ); ?></p>
						<a class="doro-help__whatsapp" href="<?php echo esc_url( $whatsapp ); ?>" target="_blank" rel="noopener noreferrer">
							<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.5 3.5A11 11 0 0 0 2.1 17.3L1 23l5.9-1.5A11 11 0 1 0 20.5 3.5zm-8.5 17a9 9 0 0 1-4.6-1.3l-.3-.2-3.5.9.9-3.4-.2-.3A9 9 0 1 1 12 20.5zm5.2-6.7c-.3-.1-1.7-.8-1.9-.9s-.5-.1-.7.1-.8.9-1 .9-.5.1-.9-.1a7.4 7.4 0 0 1-2.2-1.4 8.2 8.2 0 0 1-1.5-1.9c-.2-.3 0-.5.1-.6l.4-.5c.1-.1.2-.3.3-.5s0-.3 0-.5-.7-1.7-1-2.3c-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4s-1 1-1 2.4 1.1 2.8 1.2 3 .2.4 2.1 3.2a12.4 12.4 0 0 0 3.4 2.5c.5.2.9.2 1.2.1s1-.4 1.1-.8.1-.7.1-.8-.1-.2-.4-.3z"/></svg>
							<?php esc_html_e( 'Escribir por WhatsApp', 'doroshopping' ); ?>
						</a>
					<?php else : ?>
						<p><?php esc_html_e( 'Pronto podrás escribirnos también por WhatsApp.', 'doroshopping' ); ?></p>
						<?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
							<p class="doro-help__admin-hint">
								<?php
								echo wp_kses_post(
									sprintf(
										/* translators: %s: customizer link */
										__( 'Admin: configura el número en %s (Redes sociales → WhatsApp).', 'doroshopping' ),
										'<a href="' . esc_url( admin_url( 'customize.php?autofocus[control]=doroshopping_whatsapp' ) ) . '">' . esc_html__( 'Personalizar', 'doroshopping' ) . '</a>'
									)
								);
								?>
							</p>
						<?php endif; ?>
					<?php endif; ?>
				</div>
				<div class="doro-help__aside-card">
					<h2><?php esc_html_e( 'Ayuda rápida', 'doroshopping' ); ?></h2>
					<ul class="doro-help__links">
						<li><a href="<?php echo esc_url( $faq_url ); ?>"><?php esc_html_e( 'Preguntas frecuentes', 'doroshopping' ); ?></a></li>
						<li><a href="<?php echo esc_url( $orders_url ); ?>"><?php esc_html_e( 'Rastrear mi pedido', 'doroshopping' ); ?></a></li>
						<li><a href="<?php echo esc_url( doroshopping_get_page_url( 'politica-de-devoluciones' ) ); ?>"><?php esc_html_e( 'Devoluciones y reembolsos', 'doroshopping' ); ?></a></li>
						<li><a href="<?php echo esc_url( doroshopping_get_page_url( 'envios' ) ); ?>"><?php esc_html_e( 'Información de envíos', 'doroshopping' ); ?></a></li>
						<li><a href="<?php echo esc_url( doroshopping_get_page_url( 'metodos-de-pago' ) ); ?>"><?php esc_html_e( 'Métodos de pago', 'doroshopping' ); ?></a></li>
					</ul>
				</div>
				<div class="doro-help__aside-card">
					<h2><?php esc_html_e( 'Horario de atención', 'doroshopping' ); ?></h2>
					<p><?php esc_html_e( 'Lunes a viernes, 9:00 – 18:00 (CET). Respondemos por correo en un plazo habitual de 24–48 h laborables.', 'doroshopping' ); ?></p>
				</div>
			</aside>
		</div>
	</div>
</main>

<?php
get_footer();
