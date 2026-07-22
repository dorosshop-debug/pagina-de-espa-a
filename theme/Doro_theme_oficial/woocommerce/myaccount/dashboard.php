<?php
/**
 * My Account Dashboard
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$current_user = wp_get_current_user();
$orders_url   = wc_get_endpoint_url( 'orders' );
$edit_url     = wc_get_endpoint_url( 'edit-account' );
$address_url  = wc_get_endpoint_url( 'edit-address' );
?>

<section class="doro-account-dash">
    <header class="doro-account-dash__hero">
        <p class="doro-account-dash__eyebrow"><?php esc_html_e( 'Mi cuenta', 'doroshopping' ); ?></p>
        <h2 class="doro-account-dash__title">
            <?php
            printf(
                /* translators: %s: customer display name */
                esc_html__( 'Hola, %s', 'doroshopping' ),
                esc_html( $current_user->display_name ? $current_user->display_name : $current_user->user_login )
            );
            ?>
        </h2>
        <p class="doro-account-dash__text">
            <?php esc_html_e( 'Desde aquí puedes ver tus pedidos, gestionar direcciones y actualizar los datos de tu cuenta.', 'doroshopping' ); ?>
        </p>
    </header>

    <div class="doro-account-dash__grid">
        <a class="doro-account-dash__card" href="<?php echo esc_url( $orders_url ); ?>">
            <span class="doro-account-dash__card-label"><?php esc_html_e( 'Pedidos', 'doroshopping' ); ?></span>
            <span class="doro-account-dash__card-desc"><?php esc_html_e( 'Historial y seguimiento', 'doroshopping' ); ?></span>
        </a>
        <a class="doro-account-dash__card" href="<?php echo esc_url( $address_url ); ?>">
            <span class="doro-account-dash__card-label"><?php esc_html_e( 'Direcciones', 'doroshopping' ); ?></span>
            <span class="doro-account-dash__card-desc"><?php esc_html_e( 'Facturación y envío', 'doroshopping' ); ?></span>
        </a>
        <a class="doro-account-dash__card" href="<?php echo esc_url( $edit_url ); ?>">
            <span class="doro-account-dash__card-label"><?php esc_html_e( 'Detalles', 'doroshopping' ); ?></span>
            <span class="doro-account-dash__card-desc"><?php esc_html_e( 'Datos y contraseña', 'doroshopping' ); ?></span>
        </a>
        <a class="doro-account-dash__card doro-account-dash__card--muted" href="<?php echo esc_url( wc_logout_url() ); ?>">
            <span class="doro-account-dash__card-label"><?php esc_html_e( 'Salir', 'doroshopping' ); ?></span>
            <span class="doro-account-dash__card-desc"><?php esc_html_e( 'Cerrar sesión', 'doroshopping' ); ?></span>
        </a>
    </div>
</section>
