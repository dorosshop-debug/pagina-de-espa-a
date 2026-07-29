<?php
/**
 * Estilos y plantillas de emails WooCommerce (marca Doro).
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Colores base de emails.
 *
 * @param array $settings Settings.
 * @return array
 */
function doroshopping_email_brand_settings( $settings ) {
	$settings['woocommerce_email_base_color']      = get_option( 'woocommerce_email_base_color', '#f8942d' );
	$settings['woocommerce_email_background_color'] = get_option( 'woocommerce_email_background_color', '#f5f5f5' );
	$settings['woocommerce_email_body_background_color'] = get_option( 'woocommerce_email_body_background_color', '#ffffff' );
	$settings['woocommerce_email_text_color']      = get_option( 'woocommerce_email_text_color', '#222222' );
	return $settings;
}

/**
 * Forzar color base naranja Doro si sigue el púrpura por defecto de WC.
 *
 * @param string $color Color.
 * @return string
 */
function doroshopping_email_base_color( $color ) {
	$purple_defaults = array( '#96588a', '#7f54b3', '#720eec' );
	if ( in_array( strtolower( (string) $color ), $purple_defaults, true ) || '' === trim( (string) $color ) ) {
		return '#f8942d';
	}
	return $color;
}
add_filter( 'woocommerce_email_base_color', 'doroshopping_email_base_color' );

/**
 * CSS extra para emails.
 *
 * @param string $css CSS.
 * @return string
 */
function doroshopping_email_styles( $css ) {
	$extra = '
#wrapper { background-color: #f5f5f5 !important; padding: 28px 12px !important; }
#template_header { background-color: #f8942d !important; border-radius: 12px 12px 0 0 !important; }
#template_header h1 { color: #ffffff !important; font-size: 24px !important; font-weight: 700 !important; }
#template_header_image img { max-height: 48px !important; margin: 0 auto 8px !important; }
#template_body { border-radius: 0 0 12px 12px !important; box-shadow: 0 8px 24px rgba(0,0,0,0.06) !important; }
#body_content_inner { color: #333333 !important; font-size: 15px !important; line-height: 1.55 !important; }
#body_content_inner h2 { color: #222222 !important; }
.doro-email-card {
  margin: 18px 0;
  padding: 14px 16px;
  border: 1px solid #eee;
  border-radius: 10px;
  background: #fafafa;
}
.doro-email-card strong { display: block; font-size: 12px; color: #777; margin-bottom: 4px; text-transform: uppercase; letter-spacing: .04em; }
.doro-email-btn {
  display: inline-block !important;
  margin: 18px 0 8px !important;
  padding: 12px 22px !important;
  border-radius: 999px !important;
  background: #f8942d !important;
  color: #ffffff !important;
  text-decoration: none !important;
  font-weight: 700 !important;
}
.doro-email-muted { color: #777777 !important; font-size: 13px !important; }
#template_footer #credit { color: #888888 !important; font-size: 12px !important; }
';
	return $css . $extra;
}
add_filter( 'woocommerce_email_styles', 'doroshopping_email_styles', 20 );
