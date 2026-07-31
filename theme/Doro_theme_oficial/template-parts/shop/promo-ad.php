<?php
/**
 * Slot vertical de anuncio / promo en sidebar de tienda.
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$ui = static function ( $key ) {
    return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : '';
};

$ad_url = function_exists( 'doroshopping_get_theme_image_url' )
    ? doroshopping_get_theme_image_url( 'shop_sidebar_ad', '' )
    : '';
$ad_link = get_theme_mod( 'doroshopping_shop_sidebar_ad_link', '' );

// Sin imagen configurada: no pintar cuadro vacío en la tienda.
if ( ! $ad_url ) {
    return;
}
?>

<div class="doro-shop__ad" aria-label="<?php echo esc_attr( $ui( 'doroshopping_ui_shop_promo' ) ); ?>">
    <?php if ( $ad_link ) : ?>
        <a class="doro-shop__ad-link" href="<?php echo esc_url( $ad_link ); ?>">
            <img class="doro-shop__ad-image" src="<?php echo esc_url( $ad_url ); ?>" alt="<?php echo esc_attr( $ui( 'doroshopping_ui_shop_promo' ) ); ?>" loading="lazy" decoding="async">
        </a>
    <?php else : ?>
        <img class="doro-shop__ad-image" src="<?php echo esc_url( $ad_url ); ?>" alt="<?php echo esc_attr( $ui( 'doroshopping_ui_shop_promo' ) ); ?>" loading="lazy" decoding="async">
    <?php endif; ?>
</div>
