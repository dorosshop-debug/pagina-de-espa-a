<?php
/**
 * Dropdown / modal direccion de envio
 *
 * @package Doroshopping
 */
?>

<div class="header-dropdown header-dropdown--shipping" id="dropdown-shipping" hidden>
    <div class="header-dropdown__shipping-card">
        <button type="button" class="header-dropdown__shipping-close" data-dropdown-close aria-label="<?php esc_attr_e( 'Cerrar', 'doroshopping' ); ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
        <h3 class="header-dropdown__shipping-title"><?php esc_html_e( 'Direccion de Envio', 'doroshopping' ); ?></h3>

        <form class="header-dropdown__form" action="#" method="post">
            <label for="shipping-pais"><?php esc_html_e( 'Pais', 'doroshopping' ); ?></label>
            <select id="shipping-pais" name="pais">
                <option value="es"><?php esc_html_e( 'Espana', 'doroshopping' ); ?></option>
                <option value="pt"><?php esc_html_e( 'Portugal', 'doroshopping' ); ?></option>
                <option value="fr"><?php esc_html_e( 'Francia', 'doroshopping' ); ?></option>
                <option value="de"><?php esc_html_e( 'Alemania', 'doroshopping' ); ?></option>
                <option value="it"><?php esc_html_e( 'Italia', 'doroshopping' ); ?></option>
                <option value="ch"><?php esc_html_e( 'Suiza', 'doroshopping' ); ?></option>
                <option value="uk"><?php esc_html_e( 'Reino Unido', 'doroshopping' ); ?></option>
            </select>

            <label for="shipping-provincia"><?php esc_html_e( 'Provincia / Estado', 'doroshopping' ); ?></label>
            <input id="shipping-provincia" type="text" name="provincia" placeholder="<?php esc_attr_e( 'Provincia / Estado', 'doroshopping' ); ?>">

            <label for="shipping-ciudad"><?php esc_html_e( 'Ciudad', 'doroshopping' ); ?></label>
            <input id="shipping-ciudad" type="text" name="ciudad" placeholder="<?php esc_attr_e( 'Ciudad', 'doroshopping' ); ?>">

            <button type="submit" class="header-dropdown__submit header-dropdown__submit--solid"><?php esc_html_e( 'Guardar Direccion', 'doroshopping' ); ?></button>
        </form>
    </div>
</div>
