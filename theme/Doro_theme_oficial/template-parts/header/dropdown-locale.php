<?php
/**
 * Dropdown idioma / moneda (ubicación e idioma con banderas).
 *
 * @package Doroshopping
 */

$flags_uri = get_template_directory_uri() . '/assets/images/flags';

$locations = array(
    'es' => array(
        'label' => __( 'Espana', 'doroshopping' ),
        'flag'  => $flags_uri . '/spain.png',
    ),
    'pt' => array(
        'label' => __( 'Portugal', 'doroshopping' ),
        'flag'  => $flags_uri . '/ptg.png',
    ),
    'fr' => array(
        'label' => __( 'Francia', 'doroshopping' ),
        'flag'  => $flags_uri . '/francia.png',
    ),
    'de' => array(
        'label' => __( 'Alemania', 'doroshopping' ),
        'flag'  => $flags_uri . '/alemania.png',
    ),
    'it' => array(
        'label' => __( 'Italia', 'doroshopping' ),
        'flag'  => $flags_uri . '/italia.png',
    ),
    'uk' => array(
        'label' => __( 'Reino Unido', 'doroshopping' ),
        'flag'  => $flags_uri . '/reino-unido.png',
    ),
);

$languages = array(
    'es' => array(
        'label' => 'Espanol',
        'flag'  => $flags_uri . '/spain.png',
    ),
    'en' => array(
        'label' => 'English',
        'flag'  => $flags_uri . '/reino-unido.png',
    ),
    'de' => array(
        'label' => 'Deutsch',
        'flag'  => $flags_uri . '/alemania.png',
    ),
    'fr' => array(
        'label' => 'Francais',
        'flag'  => $flags_uri . '/francia.png',
    ),
    'it' => array(
        'label' => 'Italiano',
        'flag'  => $flags_uri . '/italia.png',
    ),
    'pt' => array(
        'label' => 'Portugues',
        'flag'  => $flags_uri . '/ptg.png',
    ),
);

/**
 * Renderiza un select custom con bandera al lado del nombre.
 *
 * @param string               $field_id   ID del campo (ubicacion|lengua).
 * @param string               $name       name del input.
 * @param string               $label_id   ID del label asociado.
 * @param array<string,array>  $items      Opciones.
 * @param string               $selected   Valor seleccionado.
 * @param string               $placeholder Texto si no hay seleccion.
 */
$doroshopping_render_flag_select = static function ( $field_id, $name, $label_id, $items, $selected, $placeholder = '' ) {
    $current = isset( $items[ $selected ] ) ? $items[ $selected ] : null;
    $current_label = $current ? $current['label'] : $placeholder;
    $current_flag  = $current ? $current['flag'] : '';
    ?>
    <div class="header-locale-select" data-locale-select="<?php echo esc_attr( $field_id ); ?>">
        <input type="hidden" name="<?php echo esc_attr( $name ); ?>" id="locale-<?php echo esc_attr( $field_id ); ?>" value="<?php echo esc_attr( $selected ); ?>">
        <button
            type="button"
            class="header-locale-select__toggle"
            aria-haspopup="listbox"
            aria-expanded="false"
            aria-labelledby="<?php echo esc_attr( $label_id ); ?>"
            data-locale-toggle
        >
            <span class="header-locale-select__value">
                <?php if ( $current_flag ) : ?>
                    <img class="header-locale-select__flag" src="<?php echo esc_url( $current_flag ); ?>" alt="" width="16" height="16" decoding="async">
                <?php endif; ?>
                <span class="header-locale-select__text"><?php echo esc_html( $current_label ); ?></span>
            </span>
            <svg class="header-locale-select__chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <ul class="header-locale-select__menu" role="listbox" hidden data-locale-menu>
            <?php foreach ( $items as $code => $item ) : ?>
                <li role="presentation">
                    <button
                        type="button"
                        class="header-locale-select__option<?php echo $code === $selected ? ' is-selected' : ''; ?>"
                        role="option"
                        aria-selected="<?php echo $code === $selected ? 'true' : 'false'; ?>"
                        data-value="<?php echo esc_attr( $code ); ?>"
                        data-flag="<?php echo esc_url( $item['flag'] ); ?>"
                        data-label="<?php echo esc_attr( $item['label'] ); ?>"
                    >
                        <img class="header-locale-select__flag" src="<?php echo esc_url( $item['flag'] ); ?>" alt="" width="16" height="16" loading="lazy" decoding="async">
                        <span><?php echo esc_html( $item['label'] ); ?></span>
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php
};
?>

<div class="header-dropdown header-dropdown--locale" id="dropdown-locale" hidden>
    <p class="header-dropdown__title"><?php esc_html_e( 'Selecciona tu Ubicacion Lengua y Moneda de preferencia.', 'doroshopping' ); ?></p>

    <form class="header-dropdown__form" action="#" method="post" data-locale-form>
        <label id="locale-ubicacion-label" for="locale-ubicacion-toggle"><?php esc_html_e( 'Ubicacion', 'doroshopping' ); ?></label>
        <?php
        $doroshopping_render_flag_select( 'ubicacion', 'ubicacion', 'locale-ubicacion-label', $locations, 'es', __( 'Elegir ubicacion.', 'doroshopping' ) );
        ?>

        <label id="locale-lengua-label" for="locale-lengua-toggle"><?php esc_html_e( 'Lengua', 'doroshopping' ); ?></label>
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
            $doroshopping_render_flag_select( 'lengua', 'lengua', 'locale-lengua-label', $languages, 'es' );
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
