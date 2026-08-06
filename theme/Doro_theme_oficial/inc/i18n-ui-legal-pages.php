<?php
/**
 * Textos UI de las páginas legales.
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Textos editables de las páginas legales.
 *
 * @return array<string, array{default:string,label:string,section:string,type?:string}>
 */
function doroshopping_i18n_ui_legal_page_defaults() {
	$section = 'doroshopping_ui_legal_page';
	$items   = array(
		'doroshopping_ui_legal_eyebrow'      => array( 'Información legal', 'Legal: antetítulo' ),
		'doroshopping_ui_legal_updated'      => array( 'Última actualización: %s', 'Legal: última actualización (usa %s)' ),
		'doroshopping_ui_legal_toc_aria'     => array( 'Índice de la página', 'Legal: índice aria' ),
		'doroshopping_ui_legal_toc_title'    => array( 'En esta página', 'Legal: título índice' ),
		'doroshopping_ui_legal_related_aria' => array( 'Páginas relacionadas', 'Legal: relacionadas aria' ),
		'doroshopping_ui_legal_related_title'=> array( 'También te puede interesar', 'Legal: título relacionadas' ),
		'doroshopping_ui_legal_footer_title' => array( 'Enlaces útiles', 'Legal: enlaces útiles' ),
		'doroshopping_ui_legal_unknown'      => array( 'No hay contenido legal específico disponible para esta página.', 'Legal: contenido no disponible' ),
		'doroshopping_ui_cms_rel_payments'   => array( 'Métodos de pago', 'CMS: relación pagos' ),
		'doroshopping_ui_cms_rel_shipping'   => array( 'Envíos', 'CMS: relación envíos' ),
		'doroshopping_ui_cms_rel_protect'    => array( 'Protección del comprador', 'CMS: relación protección' ),
		'doroshopping_ui_cms_rel_returns'    => array( 'Devoluciones', 'CMS: relación devoluciones' ),
		'doroshopping_ui_cms_rel_terms'      => array( 'Términos', 'CMS: relación términos' ),
		'doroshopping_ui_cms_rel_legal'      => array( 'Aviso legal', 'CMS: relación aviso legal' ),
		'doroshopping_ui_cms_rel_cookies'    => array( 'Cookies', 'CMS: relación cookies' ),
		'doroshopping_ui_cms_rel_privacy'    => array( 'Privacidad', 'CMS: relación privacidad' ),
		'doroshopping_ui_cms_rel_help'       => array( 'Centro de ayuda', 'CMS: relación ayuda' ),

		'doroshopping_ui_legal_privacy_intro' => array( 'Esta Política de Privacidad describe cómo tratamos tus datos personales cuando usas nuestra tienda online, de conformidad con el RGPD (UE) 2016/679 y la LOPDGDD.', 'Privacidad: introducción', 'textarea' ),
		'doroshopping_ui_legal_privacy_h1'    => array( '1. Responsable del tratamiento', 'Privacidad: sección 1' ),
		'doroshopping_ui_legal_privacy_p1'    => array( 'El responsable es el titular de %s. Los datos de contacto corporativos y domicilio social se detallan en el Aviso legal.', 'Privacidad: sección 1 texto (usa %s)', 'textarea' ),
		'doroshopping_ui_legal_privacy_h2'    => array( '2. Datos que tratamos', 'Privacidad: sección 2' ),
		'doroshopping_ui_legal_privacy_li1'   => array( 'Identificación y contacto: nombre, apellidos, email, teléfono, dirección de envío/facturación.', 'Privacidad: datos 1', 'textarea' ),
		'doroshopping_ui_legal_privacy_li2'   => array( 'Datos de cuenta y pedidos: historial de compra, preferencias e incidencias.', 'Privacidad: datos 2', 'textarea' ),
		'doroshopping_ui_legal_privacy_li3'   => array( 'Datos técnicos: IP, cookies y métricas de navegación (ver Política de cookies).', 'Privacidad: datos 3', 'textarea' ),
		'doroshopping_ui_legal_privacy_li4'   => array( 'Datos de pago: gestionados por pasarelas seguras; no almacenamos el número completo de tarjeta.', 'Privacidad: datos 4', 'textarea' ),
		'doroshopping_ui_legal_privacy_h3'    => array( '3. Finalidades y base legal', 'Privacidad: sección 3' ),
		'doroshopping_ui_legal_privacy_li5'   => array( 'Gestionar pedidos y atención al cliente (ejecución del contrato).', 'Privacidad: finalidades 1', 'textarea' ),
		'doroshopping_ui_legal_privacy_li6'   => array( 'Cumplir obligaciones legales (fiscales y de consumo).', 'Privacidad: finalidades 2', 'textarea' ),
		'doroshopping_ui_legal_privacy_li7'   => array( 'Mejorar la web y la seguridad (interés legítimo).', 'Privacidad: finalidades 3', 'textarea' ),
		'doroshopping_ui_legal_privacy_li8'   => array( 'Envío de novedades comerciales solo con tu consentimiento, cuando aplique.', 'Privacidad: finalidades 4', 'textarea' ),
		'doroshopping_ui_legal_privacy_h4'    => array( '4. Destinatarios', 'Privacidad: sección 4' ),
		'doroshopping_ui_legal_privacy_p4'    => array( 'Podemos compartir datos con proveedores de logística, pago, hosting y herramientas necesarias para prestar el servicio, bajo acuerdos de confidencialidad. No vendemos tus datos a terceros.', 'Privacidad: sección 4 texto', 'textarea' ),
		'doroshopping_ui_legal_privacy_h5'    => array( '5. Conservación', 'Privacidad: sección 5' ),
		'doroshopping_ui_legal_privacy_p5'    => array( 'Conservamos los datos el tiempo necesario para la relación comercial y los plazos legales aplicables.', 'Privacidad: sección 5 texto', 'textarea' ),
		'doroshopping_ui_legal_privacy_h6'    => array( '6. Tus derechos', 'Privacidad: sección 6' ),
		'doroshopping_ui_legal_privacy_p6'    => array( 'Puedes solicitar acceso, rectificación, supresión, oposición, limitación y portabilidad escribiendo a la dirección de contacto de la tienda. También puedes reclamar ante la AEPD (www.aepd.es).', 'Privacidad: sección 6 texto', 'textarea' ),

		'doroshopping_ui_legal_notice_intro' => array( 'Este aviso legal regula el uso del sitio web de %s. Al navegar por la web aceptas las condiciones aquí descritas.', 'Aviso: introducción (usa %s)', 'textarea' ),
		'doroshopping_ui_legal_notice_h1'    => array( '1. Datos identificativos', 'Aviso: sección 1' ),
		'doroshopping_ui_legal_notice_p1'    => array( 'Titular del sitio: completa razón social, CIF/NIF, domicilio social y datos de inscripción registral (si aplica).', 'Aviso: sección 1 texto', 'textarea' ),
		'doroshopping_ui_legal_notice_li1'   => array( 'Email de contacto: atencionalcliente@doroshopping.com', 'Aviso: datos 1' ),
		'doroshopping_ui_legal_notice_li2'   => array( 'Sitio web: doroshopping.com y dominios asociados.', 'Aviso: datos 2' ),
		'doroshopping_ui_legal_notice_h2'    => array( '2. Objeto', 'Aviso: sección 2' ),
		'doroshopping_ui_legal_notice_p2'    => array( 'La web ofrece información comercial y la posibilidad de adquirir productos a través de la tienda online. El titular se reserva el derecho de modificar contenidos, precios y disponibilidad sin previo aviso, sin perjuicio de los pedidos ya confirmados.', 'Aviso: sección 2 texto', 'textarea' ),
		'doroshopping_ui_legal_notice_h3'    => array( '3. Condiciones de uso', 'Aviso: sección 3' ),
		'doroshopping_ui_legal_notice_li3'   => array( 'Debes usar la web de forma lícita y respetuosa con la normativa vigente.', 'Aviso: condiciones 1', 'textarea' ),
		'doroshopping_ui_legal_notice_li4'   => array( 'No está permitido alterar, dañar o interferir en el funcionamiento del sitio o de sistemas asociados.', 'Aviso: condiciones 2', 'textarea' ),
		'doroshopping_ui_legal_notice_li5'   => array( 'Eres responsable de la veracidad de los datos que facilites en pedidos y registro.', 'Aviso: condiciones 3', 'textarea' ),
		'doroshopping_ui_legal_notice_h4'    => array( '4. Propiedad intelectual', 'Aviso: sección 4' ),
		'doroshopping_ui_legal_notice_p4'    => array( 'Textos, diseños, logotipos, imágenes y código de la web están protegidos. Queda prohibida su reproducción, distribución o transformación sin autorización, salvo usos permitidos por ley.', 'Aviso: sección 4 texto', 'textarea' ),
		'doroshopping_ui_legal_notice_h5'    => array( '5. Responsabilidad', 'Aviso: sección 5' ),
		'doroshopping_ui_legal_notice_p5'    => array( 'No garantizamos la ausencia total de interrupciones o errores técnicos. No respondemos de daños derivados del uso indebido de la web ni de contenidos de terceros enlazados, sin perjuicio de las obligaciones legales de consumo aplicables a la venta de productos.', 'Aviso: sección 5 texto', 'textarea' ),
		'doroshopping_ui_legal_notice_h6'    => array( '6. Legislación aplicable', 'Aviso: sección 6' ),
		'doroshopping_ui_legal_notice_p6'    => array( 'Este aviso se rige por la legislación española y europea aplicable. Para controversias, serán competentes los juzgados correspondientes conforme a la normativa de consumidores cuando proceda.', 'Aviso: sección 6 texto', 'textarea' ),

		'doroshopping_ui_legal_terms_intro' => array( 'Estas condiciones generales regulan la compra en %s. Al realizar un pedido aceptas estas condiciones junto con la Política de privacidad y, en su caso, la Política de cookies.', 'Términos: introducción (usa %s)', 'textarea' ),
		'doroshopping_ui_legal_terms_h1'    => array( '1. Ámbito y aceptación', 'Términos: sección 1' ),
		'doroshopping_ui_legal_terms_p1'    => array( 'Las condiciones se aplican a todos los pedidos realizados a través de la tienda online. Si no estás de acuerdo, no uses el servicio de compra.', 'Términos: sección 1 texto', 'textarea' ),
		'doroshopping_ui_legal_terms_h2'    => array( '2. Productos e información', 'Términos: sección 2' ),
		'doroshopping_ui_legal_terms_p2'    => array( 'Las fichas de producto incluyen descripción, precio e información orientativa de envío cuando esté disponible. Las imágenes son ilustrativas. Nos esforzamos por mantener la información actualizada; ante discrepancias relevantes, contacta con soporte.', 'Términos: sección 2 texto', 'textarea' ),
		'doroshopping_ui_legal_terms_h3'    => array( '3. Precios y pagos', 'Términos: sección 3' ),
		'doroshopping_ui_legal_terms_li1'   => array( 'Los precios se muestran en la moneda indicada en la tienda e incluyen impuestos cuando así se indique.', 'Términos: precios 1', 'textarea' ),
		'doroshopping_ui_legal_terms_li2'   => array( 'El coste de envío se calcula antes de confirmar el pedido.', 'Términos: precios 2' ),
		'doroshopping_ui_legal_terms_li3'   => array( 'El pago se realiza mediante las pasarelas habilitadas en el checkout.', 'Términos: precios 3' ),
		'doroshopping_ui_legal_terms_h4'    => array( '4. Pedidos y contrato', 'Términos: sección 4' ),
		'doroshopping_ui_legal_terms_p4'    => array( 'El pedido constituye una oferta de compra. La aceptación se confirma por email y/o cambio de estado del pedido. Nos reservamos el derecho de rechazar pedidos por error manifiesto de precio, falta de stock, sospecha de fraude o datos incompletos.', 'Términos: sección 4 texto', 'textarea' ),
		'doroshopping_ui_legal_terms_h5'    => array( '5. Envíos y entrega', 'Términos: sección 5' ),
		'doroshopping_ui_legal_terms_p5'    => array( 'Los plazos de entrega son estimados. El riesgo de pérdida o deterioro se transmite conforme a la normativa aplicable. Debes facilitar una dirección de entrega correcta y accesible.', 'Términos: sección 5 texto', 'textarea' ),
		'doroshopping_ui_legal_terms_h6'    => array( '6. Desistimiento y devoluciones', 'Términos: sección 6' ),
		'doroshopping_ui_legal_terms_p6'    => array( 'Si eres consumidor en la UE, dispones del derecho de desistimiento en los términos legales (normalmente 14 días desde la recepción), con las excepciones previstas. Consulta la Política de devoluciones para el procedimiento.', 'Términos: sección 6 texto', 'textarea' ),
		'doroshopping_ui_legal_terms_h7'    => array( '7. Garantía', 'Términos: sección 7' ),
		'doroshopping_ui_legal_terms_p7'    => array( 'Los productos gozan de la garantía legal de conformidad. Conserva la factura o confirmación de pedido para gestionar cualquier reclamación.', 'Términos: sección 7 texto', 'textarea' ),
		'doroshopping_ui_legal_terms_h8'    => array( '8. Uso de la cuenta', 'Términos: sección 8' ),
		'doroshopping_ui_legal_terms_p8'    => array( 'Eres responsable de custodiar tus credenciales. Notifícanos cualquier uso no autorizado de tu cuenta.', 'Términos: sección 8 texto', 'textarea' ),
		'doroshopping_ui_legal_terms_h9'    => array( '9. Modificaciones', 'Términos: sección 9' ),
		'doroshopping_ui_legal_terms_p9'    => array( 'Podemos actualizar estas condiciones. La versión vigente es la publicada en esta página en la fecha de la compra.', 'Términos: sección 9 texto', 'textarea' ),
		'doroshopping_ui_legal_terms_h10'   => array( '10. Contacto', 'Términos: sección 10' ),
		'doroshopping_ui_legal_terms_p10'   => array( 'Para dudas contractuales o de pedidos: atencionalcliente@doroshopping.com o el Centro de ayuda.', 'Términos: sección 10 texto', 'textarea' ),

		'doroshopping_ui_legal_cookies_intro' => array( 'Esta Política de cookies explica qué son las cookies, cuáles usamos y cómo puedes gestionarlas.', 'Cookies: introducción', 'textarea' ),
		'doroshopping_ui_legal_cookies_h1'    => array( '1. ¿Qué son las cookies?', 'Cookies: sección 1' ),
		'doroshopping_ui_legal_cookies_p1'    => array( 'Son pequeños archivos que el sitio o terceros guardan en tu dispositivo para recordar preferencias, mantener la sesión, analizar el uso o personalizar contenidos.', 'Cookies: sección 1 texto', 'textarea' ),
		'doroshopping_ui_legal_cookies_h2'    => array( '2. Tipos de cookies que podemos usar', 'Cookies: sección 2' ),
		'doroshopping_ui_legal_cookies_li1'   => array( 'Técnicas / necesarias: permiten navegar, usar el carrito, el checkout y la seguridad del sitio.', 'Cookies: tipos 1', 'textarea' ),
		'doroshopping_ui_legal_cookies_li2'   => array( 'Preferencias: recuerdan idioma, ubicación o moneda cuando aplique.', 'Cookies: tipos 2' ),
		'doroshopping_ui_legal_cookies_li3'   => array( 'Analíticas: ayudan a entender el uso de la web de forma agregada.', 'Cookies: tipos 3' ),
		'doroshopping_ui_legal_cookies_li4'   => array( 'Marketing: solo si las aceptas y están activadas, para medir campañas.', 'Cookies: tipos 4' ),
		'doroshopping_ui_legal_cookies_h3'    => array( '3. Base legal', 'Cookies: sección 3' ),
		'doroshopping_ui_legal_cookies_p3'    => array( 'Las cookies necesarias se basan en el interés legítimo / ejecución del servicio. El resto requieren tu consentimiento cuando la normativa lo exija.', 'Cookies: sección 3 texto', 'textarea' ),
		'doroshopping_ui_legal_cookies_h4'    => array( '4. Cómo gestionar las cookies', 'Cookies: sección 4' ),
		'doroshopping_ui_legal_cookies_li5'   => array( 'Puedes configurar tu navegador para bloquear o eliminar cookies.', 'Cookies: gestión 1' ),
		'doroshopping_ui_legal_cookies_li6'   => array( 'Si usamos un banner de consentimiento, podrás aceptar, rechazar o configurar categorías no esenciales.', 'Cookies: gestión 2', 'textarea' ),
		'doroshopping_ui_legal_cookies_li7'   => array( 'Bloquear cookies necesarias puede impedir el funcionamiento del carrito o del login.', 'Cookies: gestión 3', 'textarea' ),
		'doroshopping_ui_legal_cookies_h5'    => array( '5. Más información', 'Cookies: sección 5' ),
		'doroshopping_ui_legal_cookies_p5'    => array( 'Para el tratamiento de datos personales, consulta la Política de privacidad. Contacto: atencionalcliente@doroshopping.com.', 'Cookies: sección 5 texto', 'textarea' ),
	);

	$defaults = array();
	foreach ( $items as $key => $item ) {
		$defaults[ $key ] = array(
			'default' => __( $item[0], 'doroshopping' ),
			'label'   => __( $item[1], 'doroshopping' ),
			'section' => $section,
		);
		if ( isset( $item[2] ) ) {
			$defaults[ $key ]['type'] = $item[2];
		}
	}

	return $defaults;
}
