<?php
/**
 * Textos UI de páginas (locale, shipping, cart, checkout, shop, product, account, auth).
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Textos UI adicionales (locale, shipping, cart, checkout, shop, product, account pages, auth).
 *
 * @return array<string, array{default:string,label:string,section:string,type?:string}>
 */
function doroshopping_i18n_ui_page_defaults() {
	return array(
		// Locale.
		'doroshopping_ui_locale_title'           => array(
			'default' => __( 'Elige país de envío, idioma y moneda.', 'doroshopping' ),
			'label'   => __( 'Locale: titulo', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_locale_choose_location' => array(
			'default' => __( 'Elegir ubicación', 'doroshopping' ),
			'label'   => __( 'Locale: elegir ubicacion', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_locale_location_label'  => array(
			'default' => __( 'Ubicación (envío)', 'doroshopping' ),
			'label'   => __( 'Locale: etiqueta ubicacion', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_locale_location_hint'   => array(
			'default' => __( 'La ubicación tambien sugiere el envio', 'doroshopping' ),
			'label'   => __( 'Locale: hint ubicacion', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_locale_language_label'  => array(
			'default' => __( 'Lengua', 'doroshopping' ),
			'label'   => __( 'Locale: etiqueta lengua', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_locale_language_hint'   => array(
			'default' => __( 'Elegir idioma.', 'doroshopping' ),
			'label'   => __( 'Locale: hint lengua', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_locale_polylang_hint'   => array(
			'default' => __( 'Activa Polylang para cambiar de idioma.', 'doroshopping' ),
			'label'   => __( 'Locale: hint Polylang', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_locale_choose_currency' => array(
			'default' => __( 'Elegir moneda', 'doroshopping' ),
			'label'   => __( 'Locale: elegir moneda', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_locale_currency_label'  => array(
			'default' => __( 'Moneda', 'doroshopping' ),
			'label'   => __( 'Locale: etiqueta moneda', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_locale_save'            => array(
			'default' => __( 'Guardar', 'doroshopping' ),
			'label'   => __( 'Locale: guardar', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_locale_detected'        => array(
			'default' => __( 'Detectado: %s', 'doroshopping' ),
			'label'   => __( 'Locale: detectado (usa %s)', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_lang_es'                => array(
			'default' => __( 'Español', 'doroshopping' ),
			'label'   => __( 'Idioma: espanol', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_lang_en'                => array(
			'default' => __( 'Inglés', 'doroshopping' ),
			'label'   => __( 'Idioma: ingles', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_lang_de'                => array(
			'default' => __( 'Alemán', 'doroshopping' ),
			'label'   => __( 'Idioma: aleman', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_lang_fr'                => array(
			'default' => __( 'Francés', 'doroshopping' ),
			'label'   => __( 'Idioma: frances', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_lang_it'                => array(
			'default' => __( 'Italiano', 'doroshopping' ),
			'label'   => __( 'Idioma: italiano', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_lang_pt'                => array(
			'default' => __( 'Portugués', 'doroshopping' ),
			'label'   => __( 'Idioma: portugues', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_currency_eur'           => array(
			'default' => __( 'Euro (€) - EUR', 'doroshopping' ),
			'label'   => __( 'Moneda: EUR', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_currency_chf'           => array(
			'default' => __( 'Franco suizo (CHF)', 'doroshopping' ),
			'label'   => __( 'Moneda: CHF', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_currency_gbp'           => array(
			'default' => __( 'Libra esterlina (£) - GBP', 'doroshopping' ),
			'label'   => __( 'Moneda: GBP', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_currency_usd'           => array(
			'default' => __( 'Dólar estadounidense ($) - USD', 'doroshopping' ),
			'label'   => __( 'Moneda: USD', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_country_es'             => array(
			'default' => __( 'España', 'doroshopping' ),
			'label'   => __( 'Pais: Espana', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_country_pt'             => array(
			'default' => __( 'Portugal', 'doroshopping' ),
			'label'   => __( 'Pais: Portugal', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_country_fr'             => array(
			'default' => __( 'Francia', 'doroshopping' ),
			'label'   => __( 'Pais: Francia', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_country_de'             => array(
			'default' => __( 'Alemania', 'doroshopping' ),
			'label'   => __( 'Pais: Alemania', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_country_it'             => array(
			'default' => __( 'Italia', 'doroshopping' ),
			'label'   => __( 'Pais: Italia', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_country_ch'             => array(
			'default' => __( 'Suiza', 'doroshopping' ),
			'label'   => __( 'Pais: Suiza', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_country_gb'             => array(
			'default' => __( 'Reino Unido', 'doroshopping' ),
			'label'   => __( 'Pais: Reino Unido', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_geo_message'            => array(
			'default' => __( 'Parece que estás en %s. ¿Quieres usar esta ubicación para envíos?', 'doroshopping' ),
			'label'   => __( 'Geo: mensaje (usa %s)', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
			'type'    => 'textarea',
		),
		'doroshopping_ui_geo_accept'             => array(
			'default' => __( 'Sí, usar', 'doroshopping' ),
			'label'   => __( 'Geo: aceptar', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_geo_dismiss'            => array(
			'default' => __( 'Ahora no', 'doroshopping' ),
			'label'   => __( 'Geo: ahora no', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		'doroshopping_ui_geo_change'             => array(
			'default' => __( 'Elegir otra', 'doroshopping' ),
			'label'   => __( 'Geo: elegir otra', 'doroshopping' ),
			'section' => 'doroshopping_ui_locale',
		),
		// Shipping.
		'doroshopping_ui_ship_close'             => array(
			'default' => __( 'Cerrar', 'doroshopping' ),
			'label'   => __( 'Envio: cerrar', 'doroshopping' ),
			'section' => 'doroshopping_ui_shipping',
		),
		'doroshopping_ui_ship_title'             => array(
			'default' => __( 'Dirección de envío', 'doroshopping' ),
			'label'   => __( 'Envio: titulo', 'doroshopping' ),
			'section' => 'doroshopping_ui_shipping',
		),
		'doroshopping_ui_ship_country'           => array(
			'default' => __( 'País', 'doroshopping' ),
			'label'   => __( 'Envio: pais', 'doroshopping' ),
			'section' => 'doroshopping_ui_shipping',
		),
		'doroshopping_ui_ship_state'             => array(
			'default' => __( 'Provincia / Estado', 'doroshopping' ),
			'label'   => __( 'Envio: provincia', 'doroshopping' ),
			'section' => 'doroshopping_ui_shipping',
		),
		'doroshopping_ui_ship_city'              => array(
			'default' => __( 'Ciudad', 'doroshopping' ),
			'label'   => __( 'Envio: ciudad', 'doroshopping' ),
			'section' => 'doroshopping_ui_shipping',
		),
		'doroshopping_ui_ship_postcode'          => array(
			'default' => __( 'Código postal', 'doroshopping' ),
			'label'   => __( 'Envio: codigo postal', 'doroshopping' ),
			'section' => 'doroshopping_ui_shipping',
		),
		'doroshopping_ui_ship_empty'             => array(
			'default' => __( 'Aún no has añadido una dirección de entrega.', 'doroshopping' ),
			'label'   => __( 'Envio: sin direccion', 'doroshopping' ),
			'section' => 'doroshopping_ui_shipping',
		),
		'doroshopping_ui_ship_save'              => array(
			'default' => __( 'Guardar dirección', 'doroshopping' ),
			'label'   => __( 'Envio: guardar', 'doroshopping' ),
			'section' => 'doroshopping_ui_shipping',
		),
		// Cart.
		'doroshopping_ui_cart_title'             => array(
			'default' => __( 'Cesta', 'doroshopping' ),
			'label'   => __( 'Carrito: titulo', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_count_one'         => array(
			'default' => __( '%d artículo', 'doroshopping' ),
			'label'   => __( 'Carrito: contador (1)', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_count_many'        => array(
			'default' => __( '%d artículos', 'doroshopping' ),
			'label'   => __( 'Carrito: contador (n)', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_products_aria'     => array(
			'default' => __( 'Productos en la cesta', 'doroshopping' ),
			'label'   => __( 'Carrito: productos aria', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_product'           => array(
			'default' => __( 'Producto', 'doroshopping' ),
			'label'   => __( 'Carrito: producto', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_price'             => array(
			'default' => __( 'Precio', 'doroshopping' ),
			'label'   => __( 'Carrito: precio', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_qty'               => array(
			'default' => __( 'Cantidad', 'doroshopping' ),
			'label'   => __( 'Carrito: cantidad', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_subtotal'          => array(
			'default' => __( 'Subtotal', 'doroshopping' ),
			'label'   => __( 'Carrito: subtotal', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_coupon'            => array(
			'default' => __( 'Cupón', 'doroshopping' ),
			'label'   => __( 'Carrito: cupon', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_coupon_ph'         => array(
			'default' => __( 'Código de cupón', 'doroshopping' ),
			'label'   => __( 'Carrito: cupon placeholder', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_apply'             => array(
			'default' => __( 'Aplicar', 'doroshopping' ),
			'label'   => __( 'Carrito: aplicar', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_apply_coupon'      => array(
			'default' => __( 'Aplicar cupón', 'doroshopping' ),
			'label'   => __( 'Carrito: aplicar cupon', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_update'            => array(
			'default' => __( 'Actualizar cesta', 'doroshopping' ),
			'label'   => __( 'Carrito: actualizar', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_remove'            => array(
			'default' => __( 'Eliminar %s del carrito', 'doroshopping' ),
			'label'   => __( 'Carrito: eliminar (con %s)', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_summary'           => array(
			'default' => __( 'Resumen', 'doroshopping' ),
			'label'   => __( 'Carrito: resumen', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_shipping_est'      => array(
			'default' => __( 'Envío estimado', 'doroshopping' ),
			'label'   => __( 'Carrito: envio estimado', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_dest'              => array(
			'default' => __( 'Destino:', 'doroshopping' ),
			'label'   => __( 'Carrito: destino', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_carrier'           => array(
			'default' => __( 'Transportista', 'doroshopping' ),
			'label'   => __( 'Carrito: transportista', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_time'              => array(
			'default' => __( 'Tiempo', 'doroshopping' ),
			'label'   => __( 'Carrito: tiempo', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_cost'              => array(
			'default' => __( 'Coste', 'doroshopping' ),
			'label'   => __( 'Carrito: coste', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_total_est'         => array(
			'default' => __( 'Estimación total', 'doroshopping' ),
			'label'   => __( 'Carrito: estimacion total', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_continue'          => array(
			'default' => __( 'Continuar (%d)', 'doroshopping' ),
			'label'   => __( 'Carrito: continuar', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_empty'             => array(
			'default' => __( 'Tu carrito está vacío', 'doroshopping' ),
			'label'   => __( 'Carrito: vacio', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_identify'          => array(
			'default' => __( 'Identifícate', 'doroshopping' ),
			'label'   => __( 'Carrito: identificate', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_explore'           => array(
			'default' => __( 'Explora artículos', 'doroshopping' ),
			'label'   => __( 'Carrito: explorar', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_recs'              => array(
			'default' => __( 'Seguro que te gusta', 'doroshopping' ),
			'label'   => __( 'Carrito: recomendados', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_recs_aria'         => array(
			'default' => __( 'Recomendados', 'doroshopping' ),
			'label'   => __( 'Carrito: recomendados aria', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_modal_title'       => array(
			'default' => __( 'Tu Carrito', 'doroshopping' ),
			'label'   => __( 'Carrito modal: titulo', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_modal_close'       => array(
			'default' => __( 'Cerrar carrito', 'doroshopping' ),
			'label'   => __( 'Carrito modal: cerrar', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_modal_empty'       => array(
			'default' => __( 'Tu carrito esta vacio.', 'doroshopping' ),
			'label'   => __( 'Carrito modal: vacio', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_modal_subtotal'    => array(
			'default' => __( 'Subtotal:', 'doroshopping' ),
			'label'   => __( 'Carrito modal: subtotal', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_modal_checkout'    => array(
			'default' => __( 'CHECKOUT', 'doroshopping' ),
			'label'   => __( 'Carrito modal: checkout', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_modal_recs'        => array(
			'default' => __( 'Productos que no puedes dejar pasar.', 'doroshopping' ),
			'label'   => __( 'Carrito modal: recomendados', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_fab'               => array(
			'default' => __( 'Ver carrito', 'doroshopping' ),
			'label'   => __( 'Carrito: FAB', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_trust_security'    => array(
			'default' => __( 'Seguridad & Privacidad', 'doroshopping' ),
			'label'   => __( 'Carrito: confianza seguridad', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_trust_security_sub' => array(
			'default' => __( 'Datos personales seguros', 'doroshopping' ),
			'label'   => __( 'Carrito: confianza seguridad sub', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_trust_payments'    => array(
			'default' => __( 'Pagos seguros', 'doroshopping' ),
			'label'   => __( 'Carrito: confianza pagos', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_trust_payments_sub' => array(
			'default' => __( 'Pagos seguros · Datos personales seguros', 'doroshopping' ),
			'label'   => __( 'Carrito: confianza pagos sub', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_secure_title'      => array(
			'default' => __( '¿Por qué el pago es seguro?', 'doroshopping' ),
			'label'   => __( 'Carrito: modal seguro titulo', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_secure_ssl'        => array(
			'default' => __( 'Cifrado SSL/TLS', 'doroshopping' ),
			'label'   => __( 'Carrito: seguro SSL titulo', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_secure_ssl_text'   => array(
			'default' => __( 'La conexión está protegida. Tus datos viajan cifrados entre tu navegador y nuestros servidores.', 'doroshopping' ),
			'label'   => __( 'Carrito: seguro SSL texto', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
			'type'    => 'textarea',
		),
		'doroshopping_ui_cart_secure_gateways'   => array(
			'default' => __( 'Pasarelas certificadas', 'doroshopping' ),
			'label'   => __( 'Carrito: pasarelas titulo', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_secure_gateways_text' => array(
			'default' => __( 'El cobro lo procesan proveedores de pago homologados. No almacenamos el número completo de tu tarjeta.', 'doroshopping' ),
			'label'   => __( 'Carrito: pasarelas texto', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
			'type'    => 'textarea',
		),
		'doroshopping_ui_cart_secure_privacy'    => array(
			'default' => __( 'Datos personales protegidos', 'doroshopping' ),
			'label'   => __( 'Carrito: privacidad titulo', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_secure_privacy_text' => array(
			'default' => __( 'Usamos tu información solo para gestionar el pedido, según nuestra Política de privacidad.', 'doroshopping' ),
			'label'   => __( 'Carrito: privacidad texto', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
			'type'    => 'textarea',
		),
		'doroshopping_ui_cart_secure_buyer'      => array(
			'default' => __( 'Protección del comprador', 'doroshopping' ),
			'label'   => __( 'Carrito: comprador titulo', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_secure_buyer_text' => array(
			'default' => __( 'Si hay una incidencia con el cobro, la entrega o el producto, puedes contactar con soporte para ayudarte.', 'doroshopping' ),
			'label'   => __( 'Carrito: comprador texto', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
			'type'    => 'textarea',
		),
		'doroshopping_ui_cart_secure_ok'         => array(
			'default' => __( 'Entendido', 'doroshopping' ),
			'label'   => __( 'Carrito: seguro entendido', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_aside_summary'     => array(
			'default' => __( 'Resumen', 'doroshopping' ),
			'label'   => __( 'Carrito: resumen (aside aria)', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		'doroshopping_ui_cart_close'             => array(
			'default' => __( 'Cerrar', 'doroshopping' ),
			'label'   => __( 'Carrito: cerrar', 'doroshopping' ),
			'section' => 'doroshopping_ui_cart',
		),
		// Checkout.
		'doroshopping_ui_checkout_must_login'    => array(
			'default' => __( 'Debes iniciar sesión para finalizar la compra.', 'doroshopping' ),
			'label'   => __( 'Checkout: login requerido', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_checkout_helpers_aria'  => array(
			'default' => __( 'Opciones del checkout', 'doroshopping' ),
			'label'   => __( 'Checkout: helpers aria', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_checkout_delivery'      => array(
			'default' => __( 'Dirección de entrega', 'doroshopping' ),
			'label'   => __( 'Checkout: direccion entrega', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_checkout_add_address'   => array(
			'default' => __( 'Añadir nueva dirección', 'doroshopping' ),
			'label'   => __( 'Checkout: anadir direccion', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_checkout_edit_address'  => array(
			'default' => __( 'Editar dirección', 'doroshopping' ),
			'label'   => __( 'Checkout: editar direccion', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_checkout_payment_methods' => array(
			'default' => __( 'Métodos de pago', 'doroshopping' ),
			'label'   => __( 'Checkout: metodos de pago', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_checkout_your_order'    => array(
			'default' => __( 'Tu pedido', 'doroshopping' ),
			'label'   => __( 'Checkout: tu pedido', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_checkout_helper_customer' => array(
			'default' => __( '¿Ya eres cliente?', 'doroshopping' ),
			'label'   => __( 'Checkout: helper cliente', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_checkout_helper_customer_sub' => array(
			'default' => __( 'Inicia sesión para un checkout más rápido', 'doroshopping' ),
			'label'   => __( 'Checkout: helper cliente sub', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_checkout_helper_access' => array(
			'default' => __( 'Acceder', 'doroshopping' ),
			'label'   => __( 'Checkout: helper acceder', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_checkout_helper_coupon' => array(
			'default' => __( '¿Tienes un cupón?', 'doroshopping' ),
			'label'   => __( 'Checkout: helper cupon', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_checkout_helper_coupon_sub' => array(
			'default' => __( 'Aplica tu código de descuento aquí', 'doroshopping' ),
			'label'   => __( 'Checkout: helper cupon sub', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_checkout_helper_add'    => array(
			'default' => __( 'Añadir', 'doroshopping' ),
			'label'   => __( 'Checkout: helper anadir', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_checkout_address_modal_title' => array(
			'default' => __( 'Añadir nueva dirección', 'doroshopping' ),
			'label'   => __( 'Checkout: modal direccion titulo', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_checkout_confirm'       => array(
			'default' => __( 'Confirmar', 'doroshopping' ),
			'label'   => __( 'Checkout: confirmar', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_checkout_cancel'        => array(
			'default' => __( 'Cancelar', 'doroshopping' ),
			'label'   => __( 'Checkout: cancelar', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_checkout_summary'       => array(
			'default' => __( 'Resumen', 'doroshopping' ),
			'label'   => __( 'Checkout: resumen', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_checkout_subtotal'      => array(
			'default' => __( 'Subtotal', 'doroshopping' ),
			'label'   => __( 'Checkout: subtotal', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_checkout_total'         => array(
			'default' => __( 'Total', 'doroshopping' ),
			'label'   => __( 'Checkout: total', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_checkout_tax_note'      => array(
			'default' => __( 'No se cobrarán impuestos adicionales al entregar', 'doroshopping' ),
			'label'   => __( 'Checkout: nota impuestos', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
			'type'    => 'textarea',
		),
		'doroshopping_ui_checkout_place_order'   => array(
			'default' => __( 'Realizar pedido', 'doroshopping' ),
			'label'   => __( 'Checkout: realizar pedido', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_checkout_empty_address' => array(
			'default' => __( 'Aún no has añadido una dirección de entrega.', 'doroshopping' ),
			'label'   => __( 'Checkout: sin direccion', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
			'type'    => 'textarea',
		),
		'doroshopping_ui_checkout_legal'         => array(
			'default' => __( 'Al realizar el pedido aceptas nuestros <a href="%1$s">términos y condiciones</a> y la <a href="%2$s">política de privacidad</a>.', 'doroshopping' ),
			'label'   => __( 'Checkout: aviso legal (usa %1$s y %2$s)', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
			'type'    => 'textarea',
		),
		'doroshopping_ui_thankyou_fail_title'    => array(
			'default' => __( 'El pago no se completó', 'doroshopping' ),
			'label'   => __( 'Gracias: fallo titulo', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_thankyou_fail_text'      => array(
			'default' => __( 'Hubo un problema con tu pago. Puedes intentar de nuevo o contactar con soporte.', 'doroshopping' ),
			'label'   => __( 'Gracias: fallo texto', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
			'type'    => 'textarea',
		),
		'doroshopping_ui_thankyou_retry'         => array(
			'default' => __( 'Reintentar pago', 'doroshopping' ),
			'label'   => __( 'Gracias: reintentar', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_thankyou_back_shop'     => array(
			'default' => __( 'Volver a la tienda', 'doroshopping' ),
			'label'   => __( 'Gracias: volver tienda', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_thankyou_ok_title'      => array(
			'default' => __( '¡Gracias por tu compra!', 'doroshopping' ),
			'label'   => __( 'Gracias: ok titulo', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_thankyou_ok_text'       => array(
			'default' => __( 'Tu pedido %s se ha recibido correctamente. Te enviaremos actualizaciones por correo.', 'doroshopping' ),
			'label'   => __( 'Gracias: ok texto', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_thankyou_order_num'     => array(
			'default' => __( 'Número de pedido', 'doroshopping' ),
			'label'   => __( 'Gracias: numero pedido', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_thankyou_date'          => array(
			'default' => __( 'Fecha', 'doroshopping' ),
			'label'   => __( 'Gracias: fecha', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_thankyou_total'         => array(
			'default' => __( 'Total', 'doroshopping' ),
			'label'   => __( 'Gracias: total', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_thankyou_pay_method'    => array(
			'default' => __( 'Método de pago', 'doroshopping' ),
			'label'   => __( 'Gracias: metodo pago', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_thankyou_account'       => array(
			'default' => __( 'Ir a Mi cuenta', 'doroshopping' ),
			'label'   => __( 'Gracias: ir cuenta', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_thankyou_orders'        => array(
			'default' => __( 'Ver mis pedidos', 'doroshopping' ),
			'label'   => __( 'Gracias: ver pedidos', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_thankyou_continue'      => array(
			'default' => __( 'Seguir comprando', 'doroshopping' ),
			'label'   => __( 'Gracias: seguir comprando', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_thankyou_generic_title' => array(
			'default' => __( '¡Gracias!', 'doroshopping' ),
			'label'   => __( 'Gracias: generico titulo', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
		),
		'doroshopping_ui_thankyou_generic_text'  => array(
			'default' => __( 'Tu pedido se ha procesado. Si tienes dudas, revisa Mi cuenta o contáctanos.', 'doroshopping' ),
			'label'   => __( 'Gracias: generico texto', 'doroshopping' ),
			'section' => 'doroshopping_ui_checkout',
			'type'    => 'textarea',
		),
		// Shop.
		'doroshopping_ui_shop_offers_badge'      => array(
			'default' => __( 'Super Ofertas', 'doroshopping' ),
			'label'   => __( 'Tienda: badge ofertas', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_shop_offers_title'      => array(
			'default' => __( 'Ofertas', 'doroshopping' ),
			'label'   => __( 'Tienda: titulo ofertas', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_shop_offers_lead'       => array(
			'default' => __( 'Descuentos flash, precios bajos y novedades. Filtra a la izquierda y encuentra tu próxima compra.', 'doroshopping' ),
			'label'   => __( 'Tienda: lead ofertas', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
			'type'    => 'textarea',
		),
		'doroshopping_ui_shop_ship_fast'         => array(
			'default' => __( 'Envío rápido', 'doroshopping' ),
			'label'   => __( 'Tienda: envio rapido', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_shop_pay_secure'        => array(
			'default' => __( 'Pago seguro', 'doroshopping' ),
			'label'   => __( 'Tienda: pago seguro', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_shop_returns_easy'      => array(
			'default' => __( 'Devoluciones fáciles', 'doroshopping' ),
			'label'   => __( 'Tienda: devoluciones faciles', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_shop_filters'           => array(
			'default' => __( 'Filtros', 'doroshopping' ),
			'label'   => __( 'Tienda: filtros', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_shop_categories'        => array(
			'default' => __( 'Categorías', 'doroshopping' ),
			'label'   => __( 'Tienda: categorias', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_shop_all_categories'    => array(
			'default' => __( 'Todas las categorías', 'doroshopping' ),
			'label'   => __( 'Tienda: todas categorias', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_shop_price'             => array(
			'default' => __( 'Precio', 'doroshopping' ),
			'label'   => __( 'Tienda: precio', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_shop_price_1'           => array(
			'default' => __( 'Hasta 20 EUR', 'doroshopping' ),
			'label'   => __( 'Tienda: precio rango 1', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_shop_price_2'           => array(
			'default' => __( '20 - 50 EUR', 'doroshopping' ),
			'label'   => __( 'Tienda: precio rango 2', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_shop_price_3'           => array(
			'default' => __( '50 - 100 EUR', 'doroshopping' ),
			'label'   => __( 'Tienda: precio rango 3', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_shop_price_4'           => array(
			'default' => __( 'Mas de 100 EUR', 'doroshopping' ),
			'label'   => __( 'Tienda: precio rango 4', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_shop_rating'            => array(
			'default' => __( 'Valoración', 'doroshopping' ),
			'label'   => __( 'Tienda: valoracion', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_shop_rating_stars'      => array(
			'default' => __( '%d estrellas o más', 'doroshopping' ),
			'label'   => __( 'Tienda: estrellas filtro', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_shop_remove_price'      => array(
			'default' => __( 'Quitar filtro de precio', 'doroshopping' ),
			'label'   => __( 'Tienda: quitar filtro precio', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_shop_remove_rating'     => array(
			'default' => __( 'Quitar filtro de valoración', 'doroshopping' ),
			'label'   => __( 'Tienda: quitar filtro valoracion', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_shop_view_all'          => array(
			'default' => __( 'Ver todos los productos', 'doroshopping' ),
			'label'   => __( 'Tienda: ver todos', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_shop_promo'             => array(
			'default' => __( 'Promoción', 'doroshopping' ),
			'label'   => __( 'Tienda: promocion', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_shop_offers_empty_chip' => array(
			'default' => __( 'Ofertas del momento', 'doroshopping' ),
			'label'   => __( 'Tienda: chip ofertas vacias', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_shop_offers_empty_title' => array(
			'default' => __( 'Ahora mismo no hay ofertas activas', 'doroshopping' ),
			'label'   => __( 'Tienda: ofertas vacias titulo', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_shop_offers_empty_text' => array(
			'default' => __( 'Estamos preparando nuevas promociones. Mientras tanto, mira estos productos populares o usa los filtros de la izquierda.', 'doroshopping' ),
			'label'   => __( 'Tienda: ofertas vacias texto', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
			'type'    => 'textarea',
		),
		'doroshopping_ui_shop_offers_rec_title'  => array(
			'default' => __( 'Productos recomendados para ti', 'doroshopping' ),
			'label'   => __( 'Tienda: recomendados titulo', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_shop_offers_hot'        => array(
			'default' => __( 'Tendencia', 'doroshopping' ),
			'label'   => __( 'Tienda: tendencia', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_shop_offers_explore'    => array(
			'default' => __( 'Explora por categoría', 'doroshopping' ),
			'label'   => __( 'Tienda: explorar categoria', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_shop_offers_all'        => array(
			'default' => __( 'Ver toda la tienda', 'doroshopping' ),
			'label'   => __( 'Tienda: ver toda tienda', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_shop_cat_subs'          => array(
			'default' => __( 'Subcategorías', 'doroshopping' ),
			'label'   => __( 'Tienda: subcategorias', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_shop_cat_badge'         => array(
			'default' => __( 'Categoría', 'doroshopping' ),
			'label'   => __( 'Tienda: badge categoria', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_shop_cat_lead'          => array(
			'default' => __( 'Explora esta categoría y encuentra lo que necesitas, con envío rápido y compra segura.', 'doroshopping' ),
			'label'   => __( 'Tienda: lead categoria', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
			'type'    => 'textarea',
		),
		'doroshopping_ui_shop_cat_more'          => array(
			'default' => __( 'Más formas de comprar', 'doroshopping' ),
			'label'   => __( 'Tienda: mas formas comprar', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_shop_cat_for_you'       => array(
			'default' => __( 'Para ti', 'doroshopping' ),
			'label'   => __( 'Tienda: para ti', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_shop_cat_empty'         => array(
			'default' => __( 'No hay productos en esta categoría todavía.', 'doroshopping' ),
			'label'   => __( 'Tienda: categoria vacia', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_home_ver_mas'           => array(
			'default' => __( 'Ver más', 'doroshopping' ),
			'label'   => __( 'Tienda: ver mas', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		'doroshopping_ui_home_ver_mas_shop'      => array(
			'default' => __( 'Ver más en la tienda', 'doroshopping' ),
			'label'   => __( 'Tienda: ver mas en tienda', 'doroshopping' ),
			'section' => 'doroshopping_ui_shop',
		),
		// Product.
		'doroshopping_ui_product_wishlist'       => array(
			'default' => __( 'Lista de deseos', 'doroshopping' ),
			'label'   => __( 'Producto: lista deseos', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_product_wishlist_aria'  => array(
			'default' => __( 'Añadir a lista de deseos', 'doroshopping' ),
			'label'   => __( 'Producto: lista deseos aria', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_product_share'          => array(
			'default' => __( 'Compartir', 'doroshopping' ),
			'label'   => __( 'Producto: compartir', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_product_specs'          => array(
			'default' => __( 'Información adicional', 'doroshopping' ),
			'label'   => __( 'Producto: informacion adicional', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_product_ship_info'      => array(
			'default' => __( 'Información de envío', 'doroshopping' ),
			'label'   => __( 'Producto: info envio', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_product_dest'           => array(
			'default' => __( 'Destino:', 'doroshopping' ),
			'label'   => __( 'Producto: destino', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_product_carrier'        => array(
			'default' => __( 'Transportista', 'doroshopping' ),
			'label'   => __( 'Producto: transportista', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_product_eta'            => array(
			'default' => __( 'Tiempo estimado', 'doroshopping' ),
			'label'   => __( 'Producto: tiempo estimado', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_product_cost_est'       => array(
			'default' => __( 'Coste estimado', 'doroshopping' ),
			'label'   => __( 'Producto: coste estimado', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_product_ship_note'      => array(
			'default' => __( 'Coste estimado según destino. El importe final puede variar ligeramente en checkout.', 'doroshopping' ),
			'label'   => __( 'Producto: nota envio', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
			'type'    => 'textarea',
		),
		'doroshopping_ui_product_out_of_stock'   => array(
			'default' => __( 'Agotado', 'doroshopping' ),
			'label'   => __( 'Producto: agotado', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_product_more_title'     => array(
			'default' => __( 'Más productos para ti', 'doroshopping' ),
			'label'   => __( 'Producto: mas productos titulo', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_product_buy_now'        => array(
			'default' => __( 'Ir a la compra', 'doroshopping' ),
			'label'   => __( 'Producto: ir a la compra', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_product_stock_one'      => array(
			'default' => __( 'Solo quedan %d disponible', 'doroshopping' ),
			'label'   => __( 'Producto: stock singular (usa %d)', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_product_stock_many'     => array(
			'default' => __( 'Solo quedan %d disponibles', 'doroshopping' ),
			'label'   => __( 'Producto: stock plural (usa %d)', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_product_eta_days'       => array(
			'default' => __( '%s días hábiles', 'doroshopping' ),
			'label'   => __( 'Producto: dias habiles (usa %s, ej. 2 - 4)', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_product_ship_note_api'  => array(
			'default' => __( 'Tarifa BigBuy (opción más económica). El coste final puede variar en checkout.', 'doroshopping' ),
			'label'   => __( 'Producto: nota envio API', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
			'type'    => 'textarea',
		),
		'doroshopping_ui_product_ship_note_local'=> array(
			'default' => __( 'Estimación local. Configura la API key de BigBuy en Personalizar o wp-config.', 'doroshopping' ),
			'label'   => __( 'Producto: nota envio local', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
			'type'    => 'textarea',
		),
		'doroshopping_ui_product_reviews_one'    => array(
			'default' => __( '%d valoracion', 'doroshopping' ),
			'label'   => __( 'Producto: valoracion singular (usa %d)', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_product_reviews_many'   => array(
			'default' => __( '%d valoraciones', 'doroshopping' ),
			'label'   => __( 'Producto: valoraciones plural (usa %d)', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_product_sold'           => array(
			'default' => __( '%s+ vendidos', 'doroshopping' ),
			'label'   => __( 'Producto: vendidos (usa %s)', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_loading'                => array(
			'default' => __( 'Cargando…', 'doroshopping' ),
			'label'   => __( 'General: cargando', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_ship_calc_loading'      => array(
			'default' => __( 'Calculando envío…', 'doroshopping' ),
			'label'   => __( 'Envio: calculando', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_ship_calc_error'        => array(
			'default' => __( 'No se pudo calcular el envío.', 'doroshopping' ),
			'label'   => __( 'Envio: error calculo', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_product_trust_security' => array(
			'default' => __( 'Seguridad y Privacidad', 'doroshopping' ),
			'label'   => __( 'Producto: confianza seguridad', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_product_trust_pay'      => array(
			'default' => __( 'Pago 100% Seguro', 'doroshopping' ),
			'label'   => __( 'Producto: confianza pago', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_product_trust_privacy'  => array(
			'default' => __( 'Privacidad segura', 'doroshopping' ),
			'label'   => __( 'Producto: confianza privacidad', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_product_trust_returns'  => array(
			'default' => __( 'Devoluciones GRATIS', 'doroshopping' ),
			'label'   => __( 'Producto: confianza devoluciones', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_product_trust_returns_30' => array(
			'default' => __( 'Devoluciones gratis en 30 días', 'doroshopping' ),
			'label'   => __( 'Producto: devoluciones 30 dias', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_product_trust_refund'   => array(
			'default' => __( 'Reembolso por artículos dañados', 'doroshopping' ),
			'label'   => __( 'Producto: reembolso danos', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_product_trust_service'  => array(
			'default' => __( 'Servicio Profesional', 'doroshopping' ),
			'label'   => __( 'Producto: servicio profesional', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_product_trust_warranty' => array(
			'default' => __( 'Garantía Oficial', 'doroshopping' ),
			'label'   => __( 'Producto: garantia oficial', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_product_trust_support'  => array(
			'default' => __( 'Soporte al Cliente', 'doroshopping' ),
			'label'   => __( 'Producto: soporte cliente', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_product_add_aria'       => array(
			'default' => __( 'Añadir %s al carrito', 'doroshopping' ),
			'label'   => __( 'Producto: añadir aria (con %s)', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_product_view_aria'      => array(
			'default' => __( 'Ver %s', 'doroshopping' ),
			'label'   => __( 'Producto: ver aria (con %s)', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		'doroshopping_ui_product_card_wishlist'  => array(
			'default' => __( 'Anadir a lista de deseos', 'doroshopping' ),
			'label'   => __( 'Producto: card lista deseos', 'doroshopping' ),
			'section' => 'doroshopping_ui_product',
		),
		// Account pages.
		'doroshopping_ui_acc_eyebrow'            => array(
			'default' => __( 'Mi cuenta', 'doroshopping' ),
			'label'   => __( 'Cuenta: eyebrow', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_hello'              => array(
			'default' => __( 'Hola, %s', 'doroshopping' ),
			'label'   => __( 'Cuenta: saludo', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_dash_lead'          => array(
			'default' => __( 'Gestiona tus pedidos, direcciones y datos personales desde un solo lugar.', 'doroshopping' ),
			'label'   => __( 'Cuenta: dashboard lead', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
			'type'    => 'textarea',
		),
		'doroshopping_ui_acc_stat_orders'        => array(
			'default' => __( 'Pedidos', 'doroshopping' ),
			'label'   => __( 'Cuenta: stat pedidos', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_card_orders'        => array(
			'default' => __( 'Mis pedidos', 'doroshopping' ),
			'label'   => __( 'Cuenta: card pedidos', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_card_orders_desc'   => array(
			'default' => __( 'Historial y seguimiento', 'doroshopping' ),
			'label'   => __( 'Cuenta: card pedidos desc', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_card_addresses'     => array(
			'default' => __( 'Direcciones', 'doroshopping' ),
			'label'   => __( 'Cuenta: card direcciones', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_card_addresses_desc' => array(
			'default' => __( 'Facturación y envío', 'doroshopping' ),
			'label'   => __( 'Cuenta: card direcciones desc', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_card_details'       => array(
			'default' => __( 'Datos de cuenta', 'doroshopping' ),
			'label'   => __( 'Cuenta: card datos', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_card_details_desc'  => array(
			'default' => __( 'Perfil y contraseña', 'doroshopping' ),
			'label'   => __( 'Cuenta: card datos desc', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_card_wishlist'      => array(
			'default' => __( 'Lista de deseos', 'doroshopping' ),
			'label'   => __( 'Cuenta: card wishlist', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_card_wishlist_desc' => array(
			'default' => __( 'Tus productos guardados', 'doroshopping' ),
			'label'   => __( 'Cuenta: card wishlist desc', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_card_shop'          => array(
			'default' => __( 'Seguir comprando', 'doroshopping' ),
			'label'   => __( 'Cuenta: card tienda', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_card_shop_desc'     => array(
			'default' => __( 'Volver a la tienda', 'doroshopping' ),
			'label'   => __( 'Cuenta: card tienda desc', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_nav_hello'          => array(
			'default' => __( 'Hola', 'doroshopping' ),
			'label'   => __( 'Cuenta: nav hola', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_details_title'      => array(
			'default' => __( 'Detalles de la cuenta', 'doroshopping' ),
			'label'   => __( 'Cuenta: detalles titulo', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_details_lead'       => array(
			'default' => __( 'Actualiza tu información personal y cambia tu contraseña cuando lo necesites.', 'doroshopping' ),
			'label'   => __( 'Cuenta: detalles lead', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
			'type'    => 'textarea',
		),
		'doroshopping_ui_acc_first_name'         => array(
			'default' => __( 'Nombre', 'doroshopping' ),
			'label'   => __( 'Cuenta: nombre', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_last_name'          => array(
			'default' => __( 'Apellidos', 'doroshopping' ),
			'label'   => __( 'Cuenta: apellidos', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_display_name'       => array(
			'default' => __( 'Nombre visible', 'doroshopping' ),
			'label'   => __( 'Cuenta: nombre visible', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_display_hint'       => array(
			'default' => __( 'Así se mostrará tu nombre en la cuenta y en las valoraciones.', 'doroshopping' ),
			'label'   => __( 'Cuenta: hint nombre visible', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_email'              => array(
			'default' => __( 'Correo electrónico', 'doroshopping' ),
			'label'   => __( 'Cuenta: email', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_pw_legend'          => array(
			'default' => __( 'Cambio de contraseña', 'doroshopping' ),
			'label'   => __( 'Cuenta: leyenda password', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_pw_current'         => array(
			'default' => __( 'Contraseña actual', 'doroshopping' ),
			'label'   => __( 'Cuenta: password actual', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_pw_blank'           => array(
			'default' => __( 'Déjalo en blanco para no cambiarla.', 'doroshopping' ),
			'label'   => __( 'Cuenta: hint password blank', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_pw_new'             => array(
			'default' => __( 'Nueva contraseña', 'doroshopping' ),
			'label'   => __( 'Cuenta: password nueva', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_pw_confirm'         => array(
			'default' => __( 'Confirmar nueva contraseña', 'doroshopping' ),
			'label'   => __( 'Cuenta: password confirmar', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_save'               => array(
			'default' => __( 'Guardar cambios', 'doroshopping' ),
			'label'   => __( 'Cuenta: guardar', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_addr_title'         => array(
			'default' => __( 'Direcciones', 'doroshopping' ),
			'label'   => __( 'Cuenta: direcciones titulo', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_addr_lead'          => array(
			'default' => __( 'Las siguientes direcciones se usarán por defecto en el pago y en el envío.', 'doroshopping' ),
			'label'   => __( 'Cuenta: direcciones lead', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
			'type'    => 'textarea',
		),
		'doroshopping_ui_acc_addr_billing'       => array(
			'default' => __( 'Dirección de facturación', 'doroshopping' ),
			'label'   => __( 'Cuenta: facturacion', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_addr_shipping'      => array(
			'default' => __( 'Dirección de envío', 'doroshopping' ),
			'label'   => __( 'Cuenta: envio', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_edit'               => array(
			'default' => __( 'Editar', 'doroshopping' ),
			'label'   => __( 'Cuenta: editar', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_add'                => array(
			'default' => __( 'Añadir', 'doroshopping' ),
			'label'   => __( 'Cuenta: anadir', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_addr_empty'         => array(
			'default' => __( 'Aún no has configurado este tipo de dirección.', 'doroshopping' ),
			'label'   => __( 'Cuenta: direccion vacia', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_pw_security'        => array(
			'default' => __( 'Seguridad de la cuenta', 'doroshopping' ),
			'label'   => __( 'Cuenta: seguridad titulo', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_pw_create'          => array(
			'default' => __( 'Crea tu contraseña', 'doroshopping' ),
			'label'   => __( 'Cuenta: crear password', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_pw_set'             => array(
			'default' => __( 'Establece una nueva contraseña', 'doroshopping' ),
			'label'   => __( 'Cuenta: establecer password', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_pw_create_lead'     => array(
			'default' => __( 'Tu cuenta está casi lista. Elige una contraseña segura para acceder a tus pedidos y favoritos.', 'doroshopping' ),
			'label'   => __( 'Cuenta: crear password lead', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
			'type'    => 'textarea',
		),
		'doroshopping_ui_acc_pw_set_lead'        => array(
			'default' => __( 'Introduce y confirma tu nueva contraseña para continuar.', 'doroshopping' ),
			'label'   => __( 'Cuenta: establecer password lead', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_pw_save'            => array(
			'default' => __( 'Guardar contraseña', 'doroshopping' ),
			'label'   => __( 'Cuenta: guardar password', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		'doroshopping_ui_acc_pw_login'           => array(
			'default' => __( 'Ir a iniciar sesión', 'doroshopping' ),
			'label'   => __( 'Cuenta: ir login', 'doroshopping' ),
			'section' => 'doroshopping_ui_account_pages',
		),
		// Auth.
		'doroshopping_ui_auth_welcome'           => array(
			'default' => __( '¡Bienvenido!', 'doroshopping' ),
			'label'   => __( 'Auth: bienvenido', 'doroshopping' ),
			'section' => 'doroshopping_ui_auth',
		),
		'doroshopping_ui_auth_subtitle'          => array(
			'default' => __( 'Inicia sesión para comprar más rápido y seguir tus pedidos.', 'doroshopping' ),
			'label'   => __( 'Auth: subtitulo', 'doroshopping' ),
			'section' => 'doroshopping_ui_auth',
			'type'    => 'textarea',
		),
		'doroshopping_ui_auth_or_email'          => array(
			'default' => __( 'o con tu correo', 'doroshopping' ),
			'label'   => __( 'Auth: o con correo', 'doroshopping' ),
			'section' => 'doroshopping_ui_auth',
		),
		'doroshopping_ui_auth_user'              => array(
			'default' => __( 'Correo o usuario', 'doroshopping' ),
			'label'   => __( 'Auth: usuario', 'doroshopping' ),
			'section' => 'doroshopping_ui_auth',
		),
		'doroshopping_ui_auth_email_ph'          => array(
			'default' => __( 'tu@email.com', 'doroshopping' ),
			'label'   => __( 'Auth: placeholder email', 'doroshopping' ),
			'section' => 'doroshopping_ui_auth',
		),
		'doroshopping_ui_auth_password'          => array(
			'default' => __( 'Contraseña', 'doroshopping' ),
			'label'   => __( 'Auth: password', 'doroshopping' ),
			'section' => 'doroshopping_ui_auth',
		),
		'doroshopping_ui_auth_password_ph'       => array(
			'default' => __( 'Tu contraseña', 'doroshopping' ),
			'label'   => __( 'Auth: placeholder password', 'doroshopping' ),
			'section' => 'doroshopping_ui_auth',
		),
		'doroshopping_ui_auth_remember'          => array(
			'default' => __( 'Recuérdame', 'doroshopping' ),
			'label'   => __( 'Auth: recordarme', 'doroshopping' ),
			'section' => 'doroshopping_ui_auth',
		),
		'doroshopping_ui_auth_forgot'            => array(
			'default' => __( '¿Olvidaste tu contraseña?', 'doroshopping' ),
			'label'   => __( 'Auth: olvide password', 'doroshopping' ),
			'section' => 'doroshopping_ui_auth',
		),
		'doroshopping_ui_auth_login'             => array(
			'default' => __( 'Iniciar sesión', 'doroshopping' ),
			'label'   => __( 'Auth: login', 'doroshopping' ),
			'section' => 'doroshopping_ui_auth',
		),
		'doroshopping_ui_auth_no_account'        => array(
			'default' => __( '¿No tienes cuenta?', 'doroshopping' ),
			'label'   => __( 'Auth: sin cuenta', 'doroshopping' ),
			'section' => 'doroshopping_ui_auth',
		),
		'doroshopping_ui_auth_register'          => array(
			'default' => __( 'Regístrate', 'doroshopping' ),
			'label'   => __( 'Auth: registrarse', 'doroshopping' ),
			'section' => 'doroshopping_ui_auth',
		),
		'doroshopping_ui_auth_join'              => array(
			'default' => __( 'Únete a Doroshopping y compra con confianza.', 'doroshopping' ),
			'label'   => __( 'Auth: unete', 'doroshopping' ),
			'section' => 'doroshopping_ui_auth',
		),
		'doroshopping_ui_auth_register_title'    => array(
			'default' => __( 'Registro', 'doroshopping' ),
			'label'   => __( 'Auth: registro titulo', 'doroshopping' ),
			'section' => 'doroshopping_ui_auth',
		),
		'doroshopping_ui_auth_username'          => array(
			'default' => __( 'Usuario', 'doroshopping' ),
			'label'   => __( 'Auth: nombre usuario', 'doroshopping' ),
			'section' => 'doroshopping_ui_auth',
		),
		'doroshopping_ui_auth_reg_hint'          => array(
			'default' => __( 'Te enviaremos un enlace para definir tu contraseña.', 'doroshopping' ),
			'label'   => __( 'Auth: hint registro', 'doroshopping' ),
			'section' => 'doroshopping_ui_auth',
		),
		'doroshopping_ui_auth_have_account'      => array(
			'default' => __( '¿Ya tienes una cuenta?', 'doroshopping' ),
			'label'   => __( 'Auth: ya tienes cuenta', 'doroshopping' ),
			'section' => 'doroshopping_ui_auth',
		),
		'doroshopping_ui_auth_quick'             => array(
			'default' => __( 'Acceso rápido con', 'doroshopping' ),
			'label'   => __( 'Auth: acceso rapido', 'doroshopping' ),
			'section' => 'doroshopping_ui_auth',
		),
		'doroshopping_ui_auth_login_lead'        => array(
			'default' => __( 'Inicia sesión para continuar.', 'doroshopping' ),
			'label'   => __( 'Auth: login lead', 'doroshopping' ),
			'section' => 'doroshopping_ui_auth',
		),
		'doroshopping_ui_auth_close'             => array(
			'default' => __( 'Cerrar', 'doroshopping' ),
			'label'   => __( 'Auth: cerrar', 'doroshopping' ),
			'section' => 'doroshopping_ui_auth',
		),
		'doroshopping_ui_auth_lost_title'        => array(
			'default' => __( '¿Olvidaste tu contraseña?', 'doroshopping' ),
			'label'   => __( 'Auth: recuperar titulo', 'doroshopping' ),
			'section' => 'doroshopping_ui_auth',
		),
		'doroshopping_ui_auth_lost_lead'         => array(
			'default' => __( 'Introduce tu correo electrónico y te enviaremos un enlace para restablecerla.', 'doroshopping' ),
			'label'   => __( 'Auth: recuperar lead', 'doroshopping' ),
			'section' => 'doroshopping_ui_auth',
			'type'    => 'textarea',
		),
		'doroshopping_ui_auth_lost_email'        => array(
			'default' => __( 'Correo electrónico', 'doroshopping' ),
			'label'   => __( 'Auth: recuperar email', 'doroshopping' ),
			'section' => 'doroshopping_ui_auth',
		),
		'doroshopping_ui_auth_lost_submit'       => array(
			'default' => __( 'Restablecer contraseña', 'doroshopping' ),
			'label'   => __( 'Auth: recuperar boton', 'doroshopping' ),
			'section' => 'doroshopping_ui_auth',
		),
		'doroshopping_ui_auth_lost_back'         => array(
			'default' => __( 'Volver a iniciar sesión', 'doroshopping' ),
			'label'   => __( 'Auth: recuperar volver', 'doroshopping' ),
			'section' => 'doroshopping_ui_auth',
		),

		// Página Cupones (plantilla page-coupons.php).
		'doroshopping_ui_coupons_eyebrow'        => array(
			'default' => __( 'Ofertas y descuentos', 'doroshopping' ),
			'label'   => __( 'Cupones: eyebrow', 'doroshopping' ),
			'section' => 'doroshopping_ui_coupons',
		),
		'doroshopping_ui_coupons_title'          => array(
			'default' => __( 'Mis cupones', 'doroshopping' ),
			'label'   => __( 'Cupones: titulo', 'doroshopping' ),
			'section' => 'doroshopping_ui_coupons',
		),
		'doroshopping_ui_coupons_lead'           => array(
			'default' => __( 'Aplica un código de descuento y ahorra en tu próxima compra. Los cupones se validan automáticamente en el carrito.', 'doroshopping' ),
			'label'   => __( 'Cupones: lead', 'doroshopping' ),
			'section' => 'doroshopping_ui_coupons',
			'type'    => 'textarea',
		),
		'doroshopping_ui_coupons_applied_ok'     => array(
			'default' => __( 'Cupón aplicado correctamente. Revisa tu carrito para ver el descuento.', 'doroshopping' ),
			'label'   => __( 'Cupones: aplicado OK', 'doroshopping' ),
			'section' => 'doroshopping_ui_coupons',
			'type'    => 'textarea',
		),
		'doroshopping_ui_coupons_apply_title'    => array(
			'default' => __( 'Aplicar código', 'doroshopping' ),
			'label'   => __( 'Cupones: aplicar titulo', 'doroshopping' ),
			'section' => 'doroshopping_ui_coupons',
		),
		'doroshopping_ui_coupons_code_label'     => array(
			'default' => __( 'Código de cupón', 'doroshopping' ),
			'label'   => __( 'Cupones: label codigo', 'doroshopping' ),
			'section' => 'doroshopping_ui_coupons',
		),
		'doroshopping_ui_coupons_code_ph'        => array(
			'default' => __( 'Introduce tu código', 'doroshopping' ),
			'label'   => __( 'Cupones: placeholder codigo', 'doroshopping' ),
			'section' => 'doroshopping_ui_coupons',
		),
		'doroshopping_ui_coupons_apply_btn'      => array(
			'default' => __( 'Aplicar cupón', 'doroshopping' ),
			'label'   => __( 'Cupones: boton aplicar', 'doroshopping' ),
			'section' => 'doroshopping_ui_coupons',
		),
		'doroshopping_ui_coupons_hint'           => array(
			'default' => __( 'También puedes aplicar cupones desde el <a href="%s">carrito</a> o el checkout.', 'doroshopping' ),
			'label'   => __( 'Cupones: hint (usa %s = URL carrito)', 'doroshopping' ),
			'section' => 'doroshopping_ui_coupons',
			'type'    => 'textarea',
		),
		'doroshopping_ui_coupons_howto_title'    => array(
			'default' => __( 'Cómo funcionan los cupones', 'doroshopping' ),
			'label'   => __( 'Cupones: como funcionan', 'doroshopping' ),
			'section' => 'doroshopping_ui_coupons',
		),
		'doroshopping_ui_coupons_step1_title'    => array(
			'default' => __( 'Consigue un código', 'doroshopping' ),
			'label'   => __( 'Cupones: paso 1 titulo', 'doroshopping' ),
			'section' => 'doroshopping_ui_coupons',
		),
		'doroshopping_ui_coupons_step1_text'     => array(
			'default' => __( 'Recibe cupones por email, campañas o promociones activas de Doroshopping.', 'doroshopping' ),
			'label'   => __( 'Cupones: paso 1 texto', 'doroshopping' ),
			'section' => 'doroshopping_ui_coupons',
			'type'    => 'textarea',
		),
		'doroshopping_ui_coupons_step2_title'    => array(
			'default' => __( 'Aplícalo aquí o en el carrito', 'doroshopping' ),
			'label'   => __( 'Cupones: paso 2 titulo', 'doroshopping' ),
			'section' => 'doroshopping_ui_coupons',
		),
		'doroshopping_ui_coupons_step2_text'     => array(
			'default' => __( 'Introduce el código exacto. Distingue mayúsculas/minúsculas según indique la promoción.', 'doroshopping' ),
			'label'   => __( 'Cupones: paso 2 texto', 'doroshopping' ),
			'section' => 'doroshopping_ui_coupons',
			'type'    => 'textarea',
		),
		'doroshopping_ui_coupons_step3_title'    => array(
			'default' => __( 'Disfruta el descuento', 'doroshopping' ),
			'label'   => __( 'Cupones: paso 3 titulo', 'doroshopping' ),
			'section' => 'doroshopping_ui_coupons',
		),
		'doroshopping_ui_coupons_step3_text'     => array(
			'default' => __( 'El descuento se refleja al instante si el cupón es válido y cumple las condiciones.', 'doroshopping' ),
			'label'   => __( 'Cupones: paso 3 texto', 'doroshopping' ),
			'section' => 'doroshopping_ui_coupons',
			'type'    => 'textarea',
		),
		'doroshopping_ui_coupons_empty_title'    => array(
			'default' => __( 'Aún no tienes cupones guardados', 'doroshopping' ),
			'label'   => __( 'Cupones: vacio titulo', 'doroshopping' ),
			'section' => 'doroshopping_ui_coupons',
		),
		'doroshopping_ui_coupons_empty_text'     => array(
			'default' => __( 'Cuando tengamos promociones activas o recibas un código personalizado, podrás usarlo aquí.', 'doroshopping' ),
			'label'   => __( 'Cupones: vacio texto', 'doroshopping' ),
			'section' => 'doroshopping_ui_coupons',
			'type'    => 'textarea',
		),
		'doroshopping_ui_coupons_go_shop'        => array(
			'default' => __( 'Ir a la tienda', 'doroshopping' ),
			'label'   => __( 'Cupones: ir a tienda', 'doroshopping' ),
			'section' => 'doroshopping_ui_coupons',
		),
		'doroshopping_ui_coupons_go_account'     => array(
			'default' => __( 'Mi cuenta', 'doroshopping' ),
			'label'   => __( 'Cupones: mi cuenta', 'doroshopping' ),
			'section' => 'doroshopping_ui_coupons',
		),
	);
}
