<?php
/**
 * Textos UI de páginas de contenido, CMS, 404 y búsqueda.
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @return array<string, array{default:string,label:string,section:string,type?:string}>
 */
function doroshopping_i18n_ui_content_page_defaults() {
	$text = static function ( $default, $label, $section, $long = false ) {
		$item = array(
			'default' => __( $default, 'doroshopping' ),
			'label'   => __( $label, 'doroshopping' ),
			'section' => $section,
		);
		if ( $long ) {
			$item['type'] = 'textarea';
		}
		return $item;
	};

	return array(
		// CMS.
		'doroshopping_ui_cms_eyebrow_legal' => $text( 'Información legal', 'Antetítulo legal', 'doroshopping_ui_cms_page' ),
		'doroshopping_ui_cms_eyebrow_info' => $text( 'Guía de compra', 'Antetítulo informativo', 'doroshopping_ui_cms_page' ),
		'doroshopping_ui_cms_updated' => $text( 'Última actualización: %s', 'Fecha de actualización', 'doroshopping_ui_cms_page' ),
		'doroshopping_ui_cms_toc_aria' => $text( 'Índice de la página', 'Etiqueta ARIA del índice', 'doroshopping_ui_cms_page' ),
		'doroshopping_ui_cms_toc_title' => $text( 'En esta página', 'Título del índice', 'doroshopping_ui_cms_page' ),
		'doroshopping_ui_cms_related_aria' => $text( 'Páginas relacionadas', 'Etiqueta ARIA de relacionadas', 'doroshopping_ui_cms_page' ),
		'doroshopping_ui_cms_related_title' => $text( 'También te puede interesar', 'Título de relacionadas', 'doroshopping_ui_cms_page' ),
		'doroshopping_ui_cms_footer_links' => $text( 'Enlaces útiles', 'Título enlaces footer', 'doroshopping_ui_cms_page' ),
		'doroshopping_ui_cms_rel_payments' => $text( 'Métodos de pago', 'Enlace pagos', 'doroshopping_ui_cms_page' ),
		'doroshopping_ui_cms_rel_shipping' => $text( 'Envíos', 'Enlace envíos', 'doroshopping_ui_cms_page' ),
		'doroshopping_ui_cms_rel_protect' => $text( 'Protección del comprador', 'Enlace protección', 'doroshopping_ui_cms_page' ),
		'doroshopping_ui_cms_rel_returns' => $text( 'Devoluciones', 'Enlace devoluciones', 'doroshopping_ui_cms_page' ),
		'doroshopping_ui_cms_rel_terms' => $text( 'Términos', 'Enlace términos', 'doroshopping_ui_cms_page' ),
		'doroshopping_ui_cms_rel_legal' => $text( 'Aviso legal', 'Enlace aviso legal', 'doroshopping_ui_cms_page' ),
		'doroshopping_ui_cms_rel_cookies' => $text( 'Cookies', 'Enlace cookies', 'doroshopping_ui_cms_page' ),
		'doroshopping_ui_cms_rel_privacy' => $text( 'Privacidad', 'Enlace privacidad', 'doroshopping_ui_cms_page' ),
		'doroshopping_ui_cms_rel_help' => $text( 'Centro de ayuda', 'Enlace centro de ayuda', 'doroshopping_ui_cms_page' ),

		// 404.
		'doroshopping_ui_404_title' => $text( 'Página no encontrada', 'Título', 'doroshopping_ui_404_page' ),
		'doroshopping_ui_404_lead' => $text( 'La página que buscas no existe, se ha movido o ya no está disponible.', 'Introducción', 'doroshopping_ui_404_page', true ),
		'doroshopping_ui_404_home_btn' => $text( 'Volver al inicio', 'Botón de inicio', 'doroshopping_ui_404_page' ),
		'doroshopping_ui_404_shop_btn' => $text( 'Ir a la tienda', 'Botón de tienda', 'doroshopping_ui_404_page' ),

		// Búsqueda.
		'doroshopping_ui_search_title' => $text( 'Resultados para: %s', 'Título de resultados', 'doroshopping_ui_search_page' ),
		'doroshopping_ui_search_empty' => $text( 'No se encontraron resultados.', 'Mensaje sin resultados', 'doroshopping_ui_search_page' ),
		'doroshopping_ui_search_home' => $text( 'Volver al inicio', 'Botón de inicio', 'doroshopping_ui_search_page' ),

		// Sobre nosotros.
		'doroshopping_ui_about_eyebrow' => $text( 'Marca', 'Antetítulo', 'doroshopping_ui_about_page' ),
		'doroshopping_ui_about_title' => $text( 'Sobre nosotros', 'Título', 'doroshopping_ui_about_page' ),
		'doroshopping_ui_about_lead' => $text( 'Tienda online para España y Europa con una selección práctica de productos para tu día a día.', 'Introducción', 'doroshopping_ui_about_page', true ),
		'doroshopping_ui_about_who_title' => $text( 'Quiénes somos', 'Título quiénes somos', 'doroshopping_ui_about_page' ),
		'doroshopping_ui_about_who_text' => $text( 'Somos una tienda online de electrónica, hogar, deporte y productos de consumo. Trabajamos con proveedores internacionales para acercarte un catálogo variado, envíos a España y Europa y atención al cliente en español.', 'Texto quiénes somos', 'doroshopping_ui_about_page', true ),
		'doroshopping_ui_about_reach_title' => $text( 'Nuestro alcance', 'Título alcance', 'doroshopping_ui_about_page' ),
		'doroshopping_ui_about_reach_1_title' => $text( 'Catálogo de proveedores', 'Alcance 1: título', 'doroshopping_ui_about_page' ),
		'doroshopping_ui_about_reach_1_text' => $text( 'Una selección amplia de productos de proveedores internacionales.', 'Alcance 1: texto', 'doroshopping_ui_about_page', true ),
		'doroshopping_ui_about_reach_2_title' => $text( 'Envíos a España y la UE', 'Alcance 2: título', 'doroshopping_ui_about_page' ),
		'doroshopping_ui_about_reach_2_text' => $text( 'Entregamos en España y en destinos de la Unión Europea.', 'Alcance 2: texto', 'doroshopping_ui_about_page', true ),
		'doroshopping_ui_about_reach_3_title' => $text( 'Pagos seguros', 'Alcance 3: título', 'doroshopping_ui_about_page' ),
		'doroshopping_ui_about_reach_3_text' => $text( 'Procesamos los pagos mediante pasarelas seguras disponibles en el checkout.', 'Alcance 3: texto', 'doroshopping_ui_about_page', true ),
		'doroshopping_ui_about_reach_4_title' => $text( 'Soporte en español', 'Alcance 4: título', 'doroshopping_ui_about_page' ),
		'doroshopping_ui_about_reach_4_text' => $text( 'Nuestro equipo te atiende en español antes y después de tu compra.', 'Alcance 4: texto', 'doroshopping_ui_about_page', true ),
		'doroshopping_ui_about_commit_title' => $text( 'Compromiso', 'Título compromiso', 'doroshopping_ui_about_page' ),
		'doroshopping_ui_about_commit_text' => $text( 'Buscamos precios competitivos y una compra transparente, con información clara sobre productos, pagos, envíos y devoluciones.', 'Texto compromiso', 'doroshopping_ui_about_page', true ),
		'doroshopping_ui_about_cta_help' => $text( 'Centro de ayuda', 'Botón ayuda', 'doroshopping_ui_about_page' ),
		'doroshopping_ui_about_cta_shop' => $text( 'Ir a la tienda', 'Botón tienda', 'doroshopping_ui_about_page' ),

		// Contacto.
		'doroshopping_ui_contact_eyebrow' => $text( 'Contacto', 'Antetítulo', 'doroshopping_ui_contact_page' ),
		'doroshopping_ui_contact_title' => $text( 'Estamos aquí para ayudarte', 'Título', 'doroshopping_ui_contact_page' ),
		'doroshopping_ui_contact_lead' => $text( 'Para consultas sobre pedidos, pagos, envíos o devoluciones, contacta con nuestro equipo de atención al cliente.', 'Introducción', 'doroshopping_ui_contact_page', true ),
		'doroshopping_ui_contact_form_cta_title' => $text( '¿Cómo podemos ayudarte?', 'Título CTA de formulario', 'doroshopping_ui_contact_page' ),
		'doroshopping_ui_contact_form_cta_text' => $text( 'Envíanos los detalles de tu consulta desde el Centro de ayuda para que podamos darte una respuesta adecuada.', 'Texto CTA de formulario', 'doroshopping_ui_contact_page', true ),
		'doroshopping_ui_contact_form_btn' => $text( 'Ir al Centro de ayuda', 'Botón CTA de formulario', 'doroshopping_ui_contact_page' ),
		'doroshopping_ui_contact_email_title' => $text( 'Correo electrónico', 'Título correo', 'doroshopping_ui_contact_page' ),
		'doroshopping_ui_contact_email_text' => $text( 'Escríbenos y te responderemos lo antes posible.', 'Texto correo', 'doroshopping_ui_contact_page', true ),
		'doroshopping_ui_contact_hours_title' => $text( 'Horario de atención', 'Título horario', 'doroshopping_ui_contact_page' ),
		'doroshopping_ui_contact_hours_text' => $text( 'Lunes a viernes, 9:00 – 18:00 (CET). Respondemos por correo en un plazo habitual de 24–48 h laborables.', 'Texto horario', 'doroshopping_ui_contact_page', true ),
		'doroshopping_ui_contact_links_title' => $text( 'Enlaces rápidos', 'Título enlaces', 'doroshopping_ui_contact_page' ),
		'doroshopping_ui_contact_link_faq' => $text( 'Preguntas frecuentes', 'Enlace FAQ', 'doroshopping_ui_contact_page' ),
		'doroshopping_ui_contact_link_shipping' => $text( 'Información de envíos', 'Enlace envíos', 'doroshopping_ui_contact_page' ),
		'doroshopping_ui_contact_link_returns' => $text( 'Devoluciones y reembolsos', 'Enlace devoluciones', 'doroshopping_ui_contact_page' ),
		'doroshopping_ui_contact_link_payments' => $text( 'Métodos de pago', 'Enlace pagos', 'doroshopping_ui_contact_page' ),

		// Devoluciones.
		'doroshopping_ui_returns_eyebrow' => $text( 'Devoluciones', 'Antetítulo', 'doroshopping_ui_returns_page' ),
		'doroshopping_ui_returns_title' => $text( 'Política de devoluciones', 'Título', 'doroshopping_ui_returns_page' ),
		'doroshopping_ui_returns_lead' => $text( 'Consulta cómo solicitar una devolución, tus derechos y el proceso de reembolso.', 'Introducción', 'doroshopping_ui_returns_page', true ),
		'doroshopping_ui_returns_howto_title' => $text( 'Cómo solicitar una devolución', 'Título cómo devolver', 'doroshopping_ui_returns_page' ),
		'doroshopping_ui_returns_s1_title' => $text( 'Solicita la devolución', 'Paso 1: título', 'doroshopping_ui_returns_page' ),
		'doroshopping_ui_returns_s1_text' => $text( 'Contacta con nosotros dentro de los 14 días siguientes a la recepción del pedido.', 'Paso 1: texto', 'doroshopping_ui_returns_page', true ),
		'doroshopping_ui_returns_s2_title' => $text( 'Prepara el paquete', 'Paso 2: título', 'doroshopping_ui_returns_page' ),
		'doroshopping_ui_returns_s2_text' => $text( 'Embala el producto con cuidado, preferiblemente en su embalaje original y con todos sus accesorios.', 'Paso 2: texto', 'doroshopping_ui_returns_page', true ),
		'doroshopping_ui_returns_s3_title' => $text( 'Recibe tu reembolso', 'Paso 3: título', 'doroshopping_ui_returns_page' ),
		'doroshopping_ui_returns_s3_text' => $text( 'Procesaremos el reembolso al método de pago original después de recibir e inspeccionar la devolución.', 'Paso 3: texto', 'doroshopping_ui_returns_page', true ),
		'doroshopping_ui_returns_rights_title' => $text( 'Tus derechos', 'Título derechos', 'doroshopping_ui_returns_page' ),
		'doroshopping_ui_returns_rights_1' => $text( 'En la UE dispones, por norma general, de 14 días para ejercer el derecho de desistimiento.', 'Derecho 1', 'doroshopping_ui_returns_page', true ),
		'doroshopping_ui_returns_rights_2' => $text( 'El producto debe devolverse en buen estado y, cuando sea posible, con su embalaje original.', 'Derecho 2', 'doroshopping_ui_returns_page', true ),
		'doroshopping_ui_returns_rights_3' => $text( 'Algunos artículos pueden estar sujetos a excepciones legales por su naturaleza o condiciones de uso.', 'Derecho 3', 'doroshopping_ui_returns_page', true ),
		'doroshopping_ui_returns_process_title' => $text( 'Proceso de reembolso', 'Título proceso', 'doroshopping_ui_returns_page' ),
		'doroshopping_ui_returns_process_1' => $text( 'Te confirmaremos las instrucciones de devolución tras revisar tu solicitud.', 'Proceso 1', 'doroshopping_ui_returns_page', true ),
		'doroshopping_ui_returns_process_2' => $text( 'Cuando el paquete llegue, comprobaremos el estado del producto devuelto.', 'Proceso 2', 'doroshopping_ui_returns_page', true ),
		'doroshopping_ui_returns_process_3' => $text( 'El abono se realizará al método de pago original; el banco puede tardar varios días laborables en reflejarlo.', 'Proceso 3', 'doroshopping_ui_returns_page', true ),
		'doroshopping_ui_returns_help_title' => $text( '¿Necesitas ayuda con una devolución?', 'Título CTA de ayuda', 'doroshopping_ui_returns_page' ),
		'doroshopping_ui_returns_help_text' => $text( 'Escríbenos con tu número de pedido y los detalles de tu caso.', 'Texto CTA de ayuda', 'doroshopping_ui_returns_page', true ),
		'doroshopping_ui_returns_help_btn' => $text( 'Ir al Centro de ayuda', 'Botón ayuda', 'doroshopping_ui_returns_page' ),
		'doroshopping_ui_returns_protect_btn' => $text( 'Protección del comprador', 'Botón protección', 'doroshopping_ui_returns_page' ),
	);
}
