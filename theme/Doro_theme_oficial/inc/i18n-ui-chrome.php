<?php
/**
 * Textos UI de chrome (header, dropdown cuenta, footer).
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Textos UI header / cuenta / footer.
 *
 * @return array<string, array{default:string,label:string,section:string}>
 */
function doroshopping_i18n_ui_chrome_defaults() {
	return array(
		// Header.
		'doroshopping_ui_search_placeholder' => array(
			'default' => __( 'Buscar productos', 'doroshopping' ),
			'label'   => __( 'Header: buscar placeholder', 'doroshopping' ),
			'section' => 'doroshopping_ui_header',
		),
		'doroshopping_ui_search_all'         => array(
			'default' => __( 'Ver todos los resultados', 'doroshopping' ),
			'label'   => __( 'Header: ver todos resultados', 'doroshopping' ),
			'section' => 'doroshopping_ui_header',
		),
		'doroshopping_ui_search_empty'       => array(
			'default' => __( 'No se encontraron productos.', 'doroshopping' ),
			'label'   => __( 'Header: busqueda vacia', 'doroshopping' ),
			'section' => 'doroshopping_ui_header',
		),
		'doroshopping_ui_search_loading'     => array(
			'default' => __( 'Buscando...', 'doroshopping' ),
			'label'   => __( 'Header: buscando', 'doroshopping' ),
			'section' => 'doroshopping_ui_header',
		),
		'doroshopping_ui_all_categories'     => array(
			'default' => __( 'Todas las categorias', 'doroshopping' ),
			'label'   => __( 'Header: todas categorias', 'doroshopping' ),
			'section' => 'doroshopping_ui_header',
		),
		'doroshopping_ui_nav_shop'           => array(
			'default' => __( 'Tienda', 'doroshopping' ),
			'label'   => __( 'Header: nav tienda', 'doroshopping' ),
			'section' => 'doroshopping_ui_header',
		),
		'doroshopping_ui_nav_offers'         => array(
			'default' => __( 'Ofertas', 'doroshopping' ),
			'label'   => __( 'Header: nav ofertas', 'doroshopping' ),
			'section' => 'doroshopping_ui_header',
		),
		'doroshopping_ui_nav_contact'        => array(
			'default' => __( 'Contacto', 'doroshopping' ),
			'label'   => __( 'Header: nav contacto', 'doroshopping' ),
			'section' => 'doroshopping_ui_header',
		),
		'doroshopping_ui_shipping_label'     => array(
			'default' => __( 'Envío', 'doroshopping' ),
			'label'   => __( 'Header: etiqueta envio', 'doroshopping' ),
			'section' => 'doroshopping_ui_header',
		),
		'doroshopping_ui_cart_label'         => array(
			'default' => __( 'Carrito', 'doroshopping' ),
			'label'   => __( 'Header: etiqueta carrito', 'doroshopping' ),
			'section' => 'doroshopping_ui_header',
		),
		'doroshopping_ui_greeting_guest'     => array(
			'default' => __( 'Bienvenido', 'doroshopping' ),
			'label'   => __( 'Header: saludo invitado', 'doroshopping' ),
			'section' => 'doroshopping_ui_header',
		),
		'doroshopping_ui_greeting_user'      => array(
			'default' => __( 'Hola', 'doroshopping' ),
			'label'   => __( 'Header: saludo usuario', 'doroshopping' ),
			'section' => 'doroshopping_ui_header',
		),
		'doroshopping_ui_login_label'        => array(
			'default' => __( 'Ingresar', 'doroshopping' ),
			'label'   => __( 'Header: ingresar', 'doroshopping' ),
			'section' => 'doroshopping_ui_header',
		),
		'doroshopping_ui_mega_view_all'      => array(
			'default' => __( 'Ver todo', 'doroshopping' ),
			'label'   => __( 'Header: mega ver todo', 'doroshopping' ),
			'section' => 'doroshopping_ui_header',
		),
		'doroshopping_ui_mega_view_category' => array(
			'default' => __( 'Ver categoría', 'doroshopping' ),
			'label'   => __( 'Header: mega ver categoria', 'doroshopping' ),
			'section' => 'doroshopping_ui_header',
		),
		// Dropdown cuenta.
		'doroshopping_ui_account_go'         => array(
			'default' => __( 'Ir a Mi cuenta', 'doroshopping' ),
			'label'   => __( 'Cuenta: ir a mi cuenta', 'doroshopping' ),
			'section' => 'doroshopping_ui_account',
		),
		'doroshopping_ui_account_login'      => array(
			'default' => __( 'Acceder a tu cuenta', 'doroshopping' ),
			'label'   => __( 'Cuenta: acceder', 'doroshopping' ),
			'section' => 'doroshopping_ui_account',
		),
		'doroshopping_ui_account_track'      => array(
			'default' => __( 'Rastrear envio', 'doroshopping' ),
			'label'   => __( 'Cuenta: rastrear envio', 'doroshopping' ),
			'section' => 'doroshopping_ui_account',
		),
		'doroshopping_ui_account_orders'     => array(
			'default' => __( 'Mis Pedidos', 'doroshopping' ),
			'label'   => __( 'Cuenta: mis pedidos', 'doroshopping' ),
			'section' => 'doroshopping_ui_account',
		),
		'doroshopping_ui_account_coupons'    => array(
			'default' => __( 'Mis Cupones', 'doroshopping' ),
			'label'   => __( 'Cuenta: mis cupones', 'doroshopping' ),
			'section' => 'doroshopping_ui_account',
		),
		'doroshopping_ui_account_support'    => array(
			'default' => __( 'Centro de Ayuda & Soporte', 'doroshopping' ),
			'label'   => __( 'Cuenta: centro ayuda soporte', 'doroshopping' ),
			'section' => 'doroshopping_ui_account',
		),
		'doroshopping_ui_account_wishlist'   => array(
			'default' => __( 'Lista de Deseos', 'doroshopping' ),
			'label'   => __( 'Cuenta: lista deseos', 'doroshopping' ),
			'section' => 'doroshopping_ui_account',
		),
		'doroshopping_ui_account_settings'   => array(
			'default' => __( 'Configuracion', 'doroshopping' ),
			'label'   => __( 'Cuenta: configuracion', 'doroshopping' ),
			'section' => 'doroshopping_ui_account',
		),
		'doroshopping_ui_account_profile'    => array(
			'default' => __( 'Mi perfil', 'doroshopping' ),
			'label'   => __( 'Cuenta: mi perfil', 'doroshopping' ),
			'section' => 'doroshopping_ui_account',
		),
		'doroshopping_ui_account_payments'   => array(
			'default' => __( 'Metodos de pago', 'doroshopping' ),
			'label'   => __( 'Cuenta: metodos de pago', 'doroshopping' ),
			'section' => 'doroshopping_ui_account',
		),
		'doroshopping_ui_account_help'       => array(
			'default' => __( 'Centro de ayuda', 'doroshopping' ),
			'label'   => __( 'Cuenta: centro de ayuda', 'doroshopping' ),
			'section' => 'doroshopping_ui_account',
		),
		'doroshopping_ui_account_faq'        => array(
			'default' => __( "FAQ's - Preguntas Frecuentes", 'doroshopping' ),
			'label'   => __( 'Cuenta: FAQ', 'doroshopping' ),
			'section' => 'doroshopping_ui_account',
		),
		'doroshopping_ui_account_returns'    => array(
			'default' => __( 'Politica de devoluciones y reembolsos', 'doroshopping' ),
			'label'   => __( 'Cuenta: politica devoluciones', 'doroshopping' ),
			'section' => 'doroshopping_ui_account',
		),
		'doroshopping_ui_account_privacy'    => array(
			'default' => __( 'Politica de proteccion de datos personales', 'doroshopping' ),
			'label'   => __( 'Cuenta: politica privacidad', 'doroshopping' ),
			'section' => 'doroshopping_ui_account',
		),
		'doroshopping_ui_account_logout'     => array(
			'default' => __( 'Cerrar sesion', 'doroshopping' ),
			'label'   => __( 'Cuenta: cerrar sesion', 'doroshopping' ),
			'section' => 'doroshopping_ui_account',
		),
		// Footer.
		'doroshopping_ui_footer_stores'          => array(
			'default' => __( 'Nuestras tiendas', 'doroshopping' ),
			'label'   => __( 'Footer: nuestras tiendas', 'doroshopping' ),
			'section' => 'doroshopping_ui_footer',
		),
		'doroshopping_ui_footer_customer'        => array(
			'default' => __( 'Atencion al Cliente', 'doroshopping' ),
			'label'   => __( 'Footer: atencion al cliente', 'doroshopping' ),
			'section' => 'doroshopping_ui_footer',
		),
		'doroshopping_ui_footer_about'           => array(
			'default' => __( 'Sobre Nosotros', 'doroshopping' ),
			'label'   => __( 'Footer: sobre nosotros', 'doroshopping' ),
			'section' => 'doroshopping_ui_footer',
		),
		'doroshopping_ui_footer_privacy'         => array(
			'default' => __( 'Politicas de Privacidad', 'doroshopping' ),
			'label'   => __( 'Footer: politicas privacidad', 'doroshopping' ),
			'section' => 'doroshopping_ui_footer',
		),
		'doroshopping_ui_footer_help'            => array(
			'default' => __( 'Centro de ayuda', 'doroshopping' ),
			'label'   => __( 'Footer: centro de ayuda', 'doroshopping' ),
			'section' => 'doroshopping_ui_footer',
		),
		'doroshopping_ui_footer_faq'             => array(
			'default' => __( "FAQ's", 'doroshopping' ),
			'label'   => __( 'Footer: FAQ', 'doroshopping' ),
			'section' => 'doroshopping_ui_footer',
		),
		'doroshopping_ui_footer_contact'         => array(
			'default' => __( 'Contacto', 'doroshopping' ),
			'label'   => __( 'Footer: contacto', 'doroshopping' ),
			'section' => 'doroshopping_ui_footer',
		),
		'doroshopping_ui_footer_guide'           => array(
			'default' => __( 'Guia de Compra', 'doroshopping' ),
			'label'   => __( 'Footer: guia de compra', 'doroshopping' ),
			'section' => 'doroshopping_ui_footer',
		),
		'doroshopping_ui_footer_payment'         => array(
			'default' => __( 'Pago', 'doroshopping' ),
			'label'   => __( 'Footer: pago', 'doroshopping' ),
			'section' => 'doroshopping_ui_footer',
		),
		'doroshopping_ui_footer_shipping'        => array(
			'default' => __( 'Envio', 'doroshopping' ),
			'label'   => __( 'Footer: envio', 'doroshopping' ),
			'section' => 'doroshopping_ui_footer',
		),
		'doroshopping_ui_footer_coupons'         => array(
			'default' => __( 'Cupones', 'doroshopping' ),
			'label'   => __( 'Footer: cupones', 'doroshopping' ),
			'section' => 'doroshopping_ui_footer',
		),
		'doroshopping_ui_footer_create_account'  => array(
			'default' => __( 'Crear una cuenta', 'doroshopping' ),
			'label'   => __( 'Footer: crear cuenta', 'doroshopping' ),
			'section' => 'doroshopping_ui_footer',
		),
		'doroshopping_ui_footer_buyer'           => array(
			'default' => __( 'Proteccion del Comprador', 'doroshopping' ),
			'label'   => __( 'Footer: proteccion comprador', 'doroshopping' ),
			'section' => 'doroshopping_ui_footer',
		),
		'doroshopping_ui_footer_payments'        => array(
			'default' => __( 'Medios de Pago', 'doroshopping' ),
			'label'   => __( 'Footer: medios de pago', 'doroshopping' ),
			'section' => 'doroshopping_ui_footer',
		),
		'doroshopping_ui_footer_newsletter'      => array(
			'default' => __( 'Registrate y recibe novedades unicas.', 'doroshopping' ),
			'label'   => __( 'Footer: newsletter titulo', 'doroshopping' ),
			'section' => 'doroshopping_ui_footer',
		),
		'doroshopping_ui_footer_email_ph'        => array(
			'default' => __( 'Direccion de Correo electronico', 'doroshopping' ),
			'label'   => __( 'Footer: email placeholder', 'doroshopping' ),
			'section' => 'doroshopping_ui_footer',
		),
		'doroshopping_ui_footer_subscribe'       => array(
			'default' => __( 'Suscribirse', 'doroshopping' ),
			'label'   => __( 'Footer: suscribirse', 'doroshopping' ),
			'section' => 'doroshopping_ui_footer',
		),
		'doroshopping_ui_footer_follow'          => array(
			'default' => __( 'Siguenos', 'doroshopping' ),
			'label'   => __( 'Footer: siguenos', 'doroshopping' ),
			'section' => 'doroshopping_ui_footer',
		),
		'doroshopping_ui_footer_rights'          => array(
			'default' => __( 'All Rights Reserved', 'doroshopping' ),
			'label'   => __( 'Footer: derechos reservados', 'doroshopping' ),
			'section' => 'doroshopping_ui_footer',
		),
		'doroshopping_ui_footer_returns'         => array(
			'default' => __( 'Devoluciones', 'doroshopping' ),
			'label'   => __( 'Footer: devoluciones', 'doroshopping' ),
			'section' => 'doroshopping_ui_footer',
		),
		'doroshopping_ui_footer_legal_privacy'   => array(
			'default' => __( 'Privacidad', 'doroshopping' ),
			'label'   => __( 'Footer: legal privacidad', 'doroshopping' ),
			'section' => 'doroshopping_ui_footer',
		),
		'doroshopping_ui_footer_terms'           => array(
			'default' => __( 'Términos', 'doroshopping' ),
			'label'   => __( 'Footer: terminos', 'doroshopping' ),
			'section' => 'doroshopping_ui_footer',
		),
		'doroshopping_ui_footer_legal_notice'    => array(
			'default' => __( 'Aviso legal', 'doroshopping' ),
			'label'   => __( 'Footer: aviso legal', 'doroshopping' ),
			'section' => 'doroshopping_ui_footer',
		),
		'doroshopping_ui_footer_cookies'         => array(
			'default' => __( 'Cookies', 'doroshopping' ),
			'label'   => __( 'Footer: cookies', 'doroshopping' ),
			'section' => 'doroshopping_ui_footer',
		),
	);
}
