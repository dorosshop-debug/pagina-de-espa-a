<?php
/**
 * Dropdown / modal dirección de envío (sincroniza con WooCommerce customer).
 *
 * @package Doroshopping
 */

$location = function_exists( 'doroshopping_get_header_location' ) ? doroshopping_get_header_location() : array( 'code' => 'ES' );
$country  = isset( $location['code'] ) ? strtoupper( $location['code'] ) : 'ES';
if ( 'UK' === $country ) {
    $country = 'GB';
}

$customer_state    = '';
$customer_city     = '';
$customer_postcode = '';
if ( function_exists( 'WC' ) && WC()->customer ) {
    $customer_state    = (string) WC()->customer->get_shipping_state();
    $customer_city     = (string) WC()->customer->get_shipping_city();
    $customer_postcode = (string) WC()->customer->get_shipping_postcode();
}
?>

<div class="header-dropdown header-dropdown--shipping" id="dropdown-shipping" hidden>
    <div class="header-dropdown__shipping-card">
        <button type="button" class="header-dropdown__shipping-close" data-dropdown-close aria-label="<?php esc_attr_e( 'Cerrar', 'doroshopping' ); ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
        <h3 class="header-dropdown__shipping-title"><?php esc_html_e( 'Dirección de envío', 'doroshopping' ); ?></h3>

        <form class="header-dropdown__form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
            <input type="hidden" name="action" value="doroshopping_save_shipping">
            <input type="hidden" name="doroshopping_redirect" value="<?php echo esc_url( home_url( isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '/' ) ); ?>">
            <?php wp_nonce_field( 'doroshopping_shipping_prefs', 'doroshopping_shipping_nonce' ); ?>

            <label for="shipping-pais"><?php esc_html_e( 'País', 'doroshopping' ); ?></label>
            <select id="shipping-pais" name="pais">
                <?php
                $countries = array(
                    'ES' => __( 'España', 'doroshopping' ),
                    'PT' => __( 'Portugal', 'doroshopping' ),
                    'FR' => __( 'Francia', 'doroshopping' ),
                    'DE' => __( 'Alemania', 'doroshopping' ),
                    'IT' => __( 'Italia', 'doroshopping' ),
                    'CH' => __( 'Suiza', 'doroshopping' ),
                    'GB' => __( 'Reino Unido', 'doroshopping' ),
                );
                foreach ( $countries as $code => $label ) :
                    ?>
                    <option value="<?php echo esc_attr( $code ); ?>" <?php selected( $country, $code ); ?>><?php echo esc_html( $label ); ?></option>
                <?php endforeach; ?>
            </select>

            <label for="shipping-provincia"><?php esc_html_e( 'Provincia / Estado', 'doroshopping' ); ?></label>
            <input id="shipping-provincia" type="text" name="provincia" value="<?php echo esc_attr( $customer_state ); ?>" placeholder="<?php esc_attr_e( 'Provincia / Estado', 'doroshopping' ); ?>" autocomplete="address-level1">

            <label for="shipping-ciudad"><?php esc_html_e( 'Ciudad', 'doroshopping' ); ?></label>
            <input id="shipping-ciudad" type="text" name="ciudad" value="<?php echo esc_attr( $customer_city ); ?>" placeholder="<?php esc_attr_e( 'Ciudad', 'doroshopping' ); ?>" autocomplete="address-level2">

            <label for="shipping-cp"><?php esc_html_e( 'Código postal', 'doroshopping' ); ?></label>
            <input id="shipping-cp" type="text" name="codigo_postal" value="<?php echo esc_attr( $customer_postcode ); ?>" inputmode="numeric" placeholder="<?php esc_attr_e( 'Código postal', 'doroshopping' ); ?>" autocomplete="postal-code">

            <button type="submit" class="header-dropdown__submit header-dropdown__submit--solid"><?php esc_html_e( 'Guardar dirección', 'doroshopping' ); ?></button>
        </form>
    </div>
</div>
