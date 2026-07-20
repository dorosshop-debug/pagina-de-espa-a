<?php
/**
 * Dropdown idioma / moneda
 *
 * @package Doroshopping
 */
?>

<div class="header-dropdown header-dropdown--locale" id="dropdown-locale" hidden>
    <p class="header-dropdown__title"><?php esc_html_e( 'Selecciona tu Ubicacion Lengua y Moneda de preferencia.', 'doroshopping' ); ?></p>

    <form class="header-dropdown__form" action="#" method="post">
        <label for="locale-ubicacion"><?php esc_html_e( 'Ubicacion', 'doroshopping' ); ?></label>
        <select id="locale-ubicacion" name="ubicacion">
            <option value=""><?php esc_html_e( 'Elegir ubicacion.', 'doroshopping' ); ?></option>
            <option value="es"><?php esc_html_e( 'Espana', 'doroshopping' ); ?></option>
            <option value="pt"><?php esc_html_e( 'Portugal', 'doroshopping' ); ?></option>
            <option value="fr"><?php esc_html_e( 'Francia', 'doroshopping' ); ?></option>
            <option value="de"><?php esc_html_e( 'Alemania', 'doroshopping' ); ?></option>
            <option value="it"><?php esc_html_e( 'Italia', 'doroshopping' ); ?></option>
            <option value="uk"><?php esc_html_e( 'Reino Unido', 'doroshopping' ); ?></option>
        </select>

        <label for="locale-lengua"><?php esc_html_e( 'Lengua', 'doroshopping' ); ?></label>
        <?php
        /**
         * Polylang puede inyectar selector aqui.
         *
         * @hook doroshopping_header_utility_language
         */
        ob_start();
        do_action( 'doroshopping_header_utility_language' );
        $lang_slot = trim( ob_get_clean() );
        if ( $lang_slot ) {
            echo '<div class="header-dropdown__plugin-slot">' . $lang_slot . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        } else {
            ?>
            <select id="locale-lengua" name="lengua">
                <option value="es" selected>Espanol</option>
                <option value="en">English</option>
                <option value="de">Deutsch</option>
                <option value="fr">Francais</option>
                <option value="it">Italiano</option>
                <option value="pt">Portugues</option>
            </select>
            <?php
        }
        ?>

        <label for="locale-divisa"><?php esc_html_e( 'Divisa', 'doroshopping' ); ?></label>
        <?php
        ob_start();
        do_action( 'doroshopping_header_utility_currency' );
        $currency_slot = trim( ob_get_clean() );
        if ( $currency_slot ) {
            echo '<div class="header-dropdown__plugin-slot">' . $currency_slot . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        } else {
            ?>
            <select id="locale-divisa" name="divisa">
                <option value="EUR" selected>Euro - EUR</option>
                <option value="USD">US Dollar - USD</option>
                <option value="GBP">Pound - GBP</option>
            </select>
            <?php
        }
        ?>

        <button type="submit" class="header-dropdown__submit"><?php esc_html_e( 'Guardar', 'doroshopping' ); ?></button>
    </form>
</div>
