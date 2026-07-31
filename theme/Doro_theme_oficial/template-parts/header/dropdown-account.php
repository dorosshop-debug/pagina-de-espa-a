<?php
/**
 * Dropdown cuenta (header)
 *
 * @package Doroshopping
 */

$account_url = function_exists( 'doroshopping_get_account_url' ) ? doroshopping_get_account_url() : ( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : wp_login_url() );
$orders_url  = ( function_exists( 'wc_get_endpoint_url' ) && $account_url )
    ? wc_get_endpoint_url( 'orders', '', $account_url )
    : $account_url;
$edit_url    = ( function_exists( 'wc_get_endpoint_url' ) && $account_url )
    ? wc_get_endpoint_url( 'edit-account', '', $account_url )
    : $account_url;
$payment_url = ( function_exists( 'wc_get_endpoint_url' ) && $account_url )
    ? wc_get_endpoint_url( 'payment-methods', '', $account_url )
    : doroshopping_get_page_url( 'metodos-de-pago' );
$logged_in   = is_user_logged_in();
$ui          = static function ( $key ) {
    return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : '';
};
?>

<div class="header-dropdown header-dropdown--account" id="dropdown-account" hidden>
    <?php if ( $logged_in ) : ?>
        <div class="header-dropdown__user">
            <p class="header-dropdown__user-name"><?php echo esc_html( doroshopping_get_header_user_name() ); ?></p>
            <a class="header-dropdown__user-link" href="<?php echo esc_url( $account_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_account_go' ) ); ?></a>
        </div>
    <?php else : ?>
        <button type="button" class="header-dropdown__login-btn" data-auth-modal-open>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <?php echo esc_html( $ui( 'doroshopping_ui_account_login' ) ); ?>
        </button>
        <?php
        if ( function_exists( 'doroshopping_render_google_button' ) ) {
            doroshopping_render_google_button( 'dropdown' );
        }
        ?>
    <?php endif; ?>

    <ul class="header-dropdown__list">
        <li>
            <a href="<?php echo esc_url( $orders_url ); ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M1 3h15v13H1zM16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="1.5"/><circle cx="18.5" cy="18.5" r="1.5"/></svg>
                <?php echo esc_html( $ui( 'doroshopping_ui_account_track' ) ); ?>
            </a>
        </li>
        <li>
            <a href="<?php echo esc_url( $orders_url ); ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M6 2h12l1 7H5L6 2z"/><path d="M5 9v11a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V9"/></svg>
                <?php echo esc_html( $ui( 'doroshopping_ui_account_orders' ) ); ?>
            </a>
        </li>
        <li>
            <a href="<?php echo esc_url( doroshopping_get_page_url( 'cupones' ) ); ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 9h16v2H4z"/><path d="M7 9V7a5 5 0 0 1 10 0v2"/><path d="M9 13h6"/></svg>
                <?php echo esc_html( $ui( 'doroshopping_ui_account_coupons' ) ); ?>
            </a>
        </li>
        <li>
            <a href="<?php echo esc_url( doroshopping_get_page_url( 'centro-de-ayuda' ) ); ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 14h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-7a9 9 0 0 1 18 0v7a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3"/></svg>
                <?php echo esc_html( $ui( 'doroshopping_ui_account_support' ) ); ?>
            </a>
        </li>
        <li>
            <a href="<?php echo esc_url( doroshopping_get_wishlist_url() ); ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/></svg>
                <?php echo esc_html( $ui( 'doroshopping_ui_account_wishlist' ) ); ?>
            </a>
        </li>
    </ul>

    <ul class="header-dropdown__list header-dropdown__list--plain">
        <li><a href="<?php echo esc_url( $edit_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_account_settings' ) ); ?></a></li>
        <li><a href="<?php echo esc_url( $edit_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_account_profile' ) ); ?></a></li>
        <li><a href="<?php echo esc_url( $payment_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_account_payments' ) ); ?></a></li>
    </ul>

    <ul class="header-dropdown__list header-dropdown__list--footer">
        <li><a href="<?php echo esc_url( doroshopping_get_page_url( 'centro-de-ayuda' ) ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_account_help' ) ); ?></a></li>
        <li><a href="<?php echo esc_url( doroshopping_get_page_url( 'preguntas-frecuentes' ) ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_account_faq' ) ); ?></a></li>
        <li><a href="<?php echo esc_url( doroshopping_get_page_url( 'politica-de-devoluciones' ) ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_account_returns' ) ); ?></a></li>
        <li><a href="<?php echo esc_url( doroshopping_get_page_url( 'politica-de-privacidad' ) ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_account_privacy' ) ); ?></a></li>
        <?php if ( $logged_in ) : ?>
            <li><a href="<?php echo esc_url( function_exists( 'wc_logout_url' ) ? wc_logout_url() : wp_logout_url( home_url( '/' ) ) ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_account_logout' ) ); ?></a></li>
        <?php endif; ?>
    </ul>
</div>
