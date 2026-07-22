<?php
/**
 * Slot vertical de anuncio / promo en sidebar de tienda.
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$ad_url = function_exists( 'doroshopping_get_theme_image_url' )
    ? doroshopping_get_theme_image_url( 'shop_sidebar_ad', '' )
    : '';
$ad_link = get_theme_mod( 'doroshopping_shop_sidebar_ad_link', '' );
?>

<div class="doro-shop__ad" aria-label="<?php esc_attr_e( 'Promoción', 'doroshopping' ); ?>">
    <?php if ( $ad_url ) : ?>
        <?php if ( $ad_link ) : ?>
            <a class="doro-shop__ad-link" href="<?php echo esc_url( $ad_link ); ?>">
                <img class="doro-shop__ad-image" src="<?php echo esc_url( $ad_url ); ?>" alt="<?php esc_attr_e( 'Promoción', 'doroshopping' ); ?>" loading="lazy" decoding="async">
            </a>
        <?php else : ?>
            <img class="doro-shop__ad-image" src="<?php echo esc_url( $ad_url ); ?>" alt="<?php esc_attr_e( 'Promoción', 'doroshopping' ); ?>" loading="lazy" decoding="async">
        <?php endif; ?>
    <?php else : ?>
        <div class="doro-shop__ad-placeholder">
            <span><?php esc_html_e( 'Espacio publicitario', 'doroshopping' ); ?></span>
            <small><?php esc_html_e( 'Apariencia → Personalizar → Tienda', 'doroshopping' ); ?></small>
        </div>
    <?php endif; ?>
</div>
