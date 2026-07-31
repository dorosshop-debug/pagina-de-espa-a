<?php
/**
 * Buy box lateral — envío (BigBuy/WC), confianza y compra.
 *
 * Los datos de envío se rellenan vía filtros/hooks para plugins (p. ej. BigBuy).
 * Sin plugin activo se muestran placeholders listos para hidratar.
 *
 * @package Doroshopping
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product ) {
    return;
}

$ui = static function ( $key ) {
    return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : '';
};

$destination = apply_filters(
    'doroshopping_shipping_destination_label',
    $ui( 'doroshopping_ui_country_es' ),
    $product
);

/**
 * Estimación de envío. Plugins (BigBuy / WC shipping) pueden completar:
 * carrier, eta, cost_html, cost_raw, note, destination.
 *
 * @var array{
 *   destination?: string,
 *   carrier?: string,
 *   eta?: string,
 *   cost_html?: string,
 *   note?: string,
 *   ready?: bool
 * }
 */
$shipping = apply_filters(
    'doroshopping_product_shipping_estimate',
    array(
        'destination' => $destination,
        'carrier'     => '',
        'eta'         => '',
        'cost_html'   => '',
        'note'        => $ui( 'doroshopping_ui_product_ship_note' ),
        'ready'       => false,
    ),
    $product
);

$carrier   = isset( $shipping['carrier'] ) ? (string) $shipping['carrier'] : '';
$eta       = isset( $shipping['eta'] ) ? (string) $shipping['eta'] : '';
$cost_html = isset( $shipping['cost_html'] ) ? (string) $shipping['cost_html'] : '';
$note      = isset( $shipping['note'] ) ? (string) $shipping['note'] : '';
$dest      = ! empty( $shipping['destination'] ) ? (string) $shipping['destination'] : $destination;
$ready     = ! empty( $shipping['ready'] ) || ( $carrier || $eta || $cost_html );

$stock_qty  = $product->managing_stock() ? $product->get_stock_quantity() : null;
$stock_text = '';
if ( null !== $stock_qty && $stock_qty > 0 ) {
    /* translators: %d: stock quantity */
    $stock_text = sprintf( _n( 'Solo quedan %d disponible', 'Solo quedan %d disponibles', $stock_qty, 'doroshopping' ), $stock_qty );
} elseif ( ! $product->is_in_stock() ) {
    $stock_text = $ui( 'doroshopping_ui_product_out_of_stock' );
}
?>

<div class="doro-buybox" data-doro-buybox data-product-id="<?php echo esc_attr( (string) $product->get_id() ); ?>">
    <?php
    /**
     * Antes del bloque de envío (plugins BigBuy / shipping).
     *
     * @param WC_Product $product Producto.
     * @param array      $shipping Estimación filtrada.
     */
    do_action( 'doroshopping_buybox_before_shipping', $product, $shipping );
    ?>

    <section
        class="doro-buybox__ship-card"
        data-doro-shipping
        data-shipping-ready="<?php echo $ready ? '1' : '0'; ?>"
        aria-label="<?php echo esc_attr( $ui( 'doroshopping_ui_product_ship_info' ) ); ?>"
    >
        <header class="doro-buybox__ship-head">
            <span class="doro-buybox__ship-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 3h15v13H1zM16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="1.5"/><circle cx="18.5" cy="18.5" r="1.5"/></svg>
            </span>
            <div>
                <h3 class="doro-buybox__ship-title"><?php echo esc_html( $ui( 'doroshopping_ui_product_ship_info' ) ); ?></h3>
                <p class="doro-buybox__ship-dest">
                    <?php echo esc_html( $ui( 'doroshopping_ui_product_dest' ) ); ?>
                    <strong data-shipping-destination><?php echo esc_html( $dest ); ?></strong>
                </p>
            </div>
        </header>

        <dl class="doro-buybox__ship-rows">
            <div class="doro-buybox__ship-row">
                <dt><?php echo esc_html( $ui( 'doroshopping_ui_product_carrier' ) ); ?></dt>
                <dd data-shipping-carrier><?php echo $carrier ? esc_html( $carrier ) : '&mdash;'; ?></dd>
            </div>
            <div class="doro-buybox__ship-row">
                <dt><?php echo esc_html( $ui( 'doroshopping_ui_product_eta' ) ); ?></dt>
                <dd data-shipping-eta><?php echo $eta ? esc_html( $eta ) : '&mdash;'; ?></dd>
            </div>
            <div class="doro-buybox__ship-row">
                <dt><?php echo esc_html( $ui( 'doroshopping_ui_product_cost_est' ) ); ?></dt>
                <dd data-shipping-cost><?php echo $cost_html ? wp_kses_post( $cost_html ) : '&mdash;'; ?></dd>
            </div>
        </dl>

        <?php if ( $note ) : ?>
            <p class="doro-buybox__ship-note" data-shipping-note><?php echo esc_html( $note ); ?></p>
        <?php endif; ?>

        <?php
        /**
         * Tras filas de envío — ideal para inyectar HTML/JS de BigBuy.
         *
         * @param WC_Product $product Producto.
         * @param array      $shipping Estimación.
         */
        do_action( 'doroshopping_buybox_shipping', $product, $shipping );
        ?>
    </section>

    <ul class="doro-buybox__trust">
        <li>
            <span class="doro-buybox__trust-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </span>
            <div>
                <strong><?php echo esc_html( $ui( 'doroshopping_ui_product_trust_security' ) ); ?></strong>
                <span><?php echo esc_html( $ui( 'doroshopping_ui_product_trust_pay' ) ); ?></span>
                <span><?php echo esc_html( $ui( 'doroshopping_ui_product_trust_privacy' ) ); ?></span>
            </div>
        </li>
        <li>
            <span class="doro-buybox__trust-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 8v13H3V8"/><path d="M1 3h22v5H1z"/><path d="M10 12h4"/></svg>
            </span>
            <div>
                <strong><?php echo esc_html( $ui( 'doroshopping_ui_product_trust_returns' ) ); ?></strong>
                <span><?php echo esc_html( $ui( 'doroshopping_ui_product_trust_returns_30' ) ); ?></span>
                <span><?php echo esc_html( $ui( 'doroshopping_ui_product_trust_refund' ) ); ?></span>
            </div>
        </li>
        <li>
            <span class="doro-buybox__trust-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/><path d="M16 3.1a4 4 0 0 1 0 7.8"/></svg>
            </span>
            <div>
                <strong><?php echo esc_html( $ui( 'doroshopping_ui_product_trust_service' ) ); ?></strong>
                <span><?php echo esc_html( $ui( 'doroshopping_ui_product_trust_warranty' ) ); ?></span>
                <span><?php echo esc_html( $ui( 'doroshopping_ui_product_trust_support' ) ); ?></span>
            </div>
        </li>
    </ul>

    <?php if ( $stock_text ) : ?>
        <p class="doro-buybox__stock" data-buybox-stock role="status"><?php echo esc_html( $stock_text ); ?></p>
    <?php endif; ?>

    <div class="doro-buybox__actions" data-doro-buybox-actions>
        <?php woocommerce_template_single_add_to_cart(); ?>
    </div>
</div>
