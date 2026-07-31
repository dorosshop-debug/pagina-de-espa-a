<?php
/**
 * Checkout form — layout tipo AliExpress.
 *
 * @package Doroshopping
 */

defined( 'ABSPATH' ) || exit;

$ui = static function ( $key ) {
    return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : '';
};

do_action( 'woocommerce_before_checkout_form', WC()->checkout() );

if ( ! WC()->checkout()->is_registration_enabled() && WC()->checkout()->is_registration_required() && ! is_user_logged_in() ) {
    echo esc_html(
        apply_filters(
            'woocommerce_checkout_must_be_logged_in_message',
            $ui( 'doroshopping_ui_checkout_must_login' )
        )
    );
    return;
}
?>

<form name="checkout" method="post" class="checkout woocommerce-checkout doro-checkout-form" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data" aria-label="<?php echo esc_attr__( 'Checkout', 'doroshopping' ); ?>">

    <div class="doro-checkout-layout">
        <div class="doro-checkout-main">
            <?php if ( WC()->checkout()->get_checkout_fields() ) : ?>
                <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

                <section class="doro-checkout-card" id="doro-checkout-address">
                    <div class="doro-checkout-card__head">
                        <h2 class="doro-checkout-card__title"><?php echo esc_html( $ui( 'doroshopping_ui_checkout_delivery' ) ); ?></h2>
                        <div class="doro-checkout-card__actions">
                            <button type="button" class="doro-checkout-card__link" data-address-modal-open data-address-mode="add">
                                + <?php echo esc_html( $ui( 'doroshopping_ui_checkout_add_address' ) ); ?>
                            </button>
                            <button type="button" class="doro-checkout-card__link doro-checkout-card__link--edit" data-address-modal-open data-address-mode="edit" hidden>
                                <?php echo esc_html( $ui( 'doroshopping_ui_checkout_edit_address' ) ); ?>
                            </button>
                        </div>
                    </div>
                    <div class="doro-checkout-address__preview" data-address-preview></div>
                </section>

                <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
            <?php endif; ?>

            <section class="doro-checkout-card" id="doro-checkout-payment">
                <h2 class="doro-checkout-card__title"><?php echo esc_html( $ui( 'doroshopping_ui_checkout_payment_methods' ) ); ?></h2>
                <?php woocommerce_checkout_payment(); ?>
            </section>

            <section class="doro-checkout-card" id="doro-checkout-products">
                <h2 class="doro-checkout-card__title"><?php echo esc_html( $ui( 'doroshopping_ui_checkout_your_order' ) ); ?></h2>
                <?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
                <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
                <div id="order_review" class="woocommerce-checkout-review-order">
                    <?php woocommerce_order_review(); ?>
                </div>
                <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
            </section>
        </div>

        <aside class="doro-checkout-aside">
            <?php get_template_part( 'template-parts/checkout/summary' ); ?>
            <?php get_template_part( 'template-parts/cart/trust' ); ?>
        </aside>
    </div>

    <?php get_template_part( 'template-parts/checkout/address-modal' ); ?>

</form>

<?php do_action( 'woocommerce_after_checkout_form', WC()->checkout() ); ?>
