<?php
/**
 * Dropdown idioma / moneda / ubicación (Polylang + YayCurrency + Geo Controller).
 *
 * Importante: YayCurrency NO va dentro del <form> (rompe el submit si anida formularios).
 *
 * @package Doroshopping
 */

$flags_uri = get_template_directory_uri() . '/assets/images/flags';
$languages = function_exists( 'doroshopping_get_header_languages' ) ? doroshopping_get_header_languages() : array();
$lang_code = function_exists( 'doroshopping_get_current_language_code' ) ? doroshopping_get_current_language_code() : 'es';
$location  = function_exists( 'doroshopping_get_header_location' ) ? doroshopping_get_header_location() : array( 'code' => 'ES', 'label' => 'España', 'map' => array() );

$locations = array();
if ( ! empty( $location['map'] ) && is_array( $location['map'] ) ) {
    foreach ( $location['map'] as $code => $item ) {
        $locations[ strtolower( $code ) ] = array(
            'label' => $item['label'],
            'flag'  => $item['flag'],
        );
    }
}
if ( empty( $locations ) ) {
    $locations = array(
        'es' => array( 'label' => __( 'España', 'doroshopping' ), 'flag' => $flags_uri . '/spain.png' ),
        'pt' => array( 'label' => __( 'Portugal', 'doroshopping' ), 'flag' => $flags_uri . '/ptg.png' ),
        'fr' => array( 'label' => __( 'Francia', 'doroshopping' ), 'flag' => $flags_uri . '/francia.png' ),
        'de' => array( 'label' => __( 'Alemania', 'doroshopping' ), 'flag' => $flags_uri . '/alemania.png' ),
        'it' => array( 'label' => __( 'Italia', 'doroshopping' ), 'flag' => $flags_uri . '/italia.png' ),
        'gb' => array( 'label' => __( 'Reino Unido', 'doroshopping' ), 'flag' => $flags_uri . '/reino-unido.png' ),
    );
}

$selected_loc = strtolower( isset( $location['code'] ) ? $location['code'] : 'es' );
if ( 'uk' === $selected_loc ) {
    $selected_loc = 'gb';
}

$doroshopping_render_flag_select = static function ( $field_id, $name, $label_id, $items, $selected, $placeholder = '' ) {
    $current       = isset( $items[ $selected ] ) ? $items[ $selected ] : null;
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
                        <?php if ( ! empty( $item['url'] ) ) : ?>
                            data-url="<?php echo esc_url( $item['url'] ); ?>"
                        <?php endif; ?>
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
    <p class="header-dropdown__title"><?php esc_html_e( 'Selecciona tu ubicación, lengua y moneda de preferencia.', 'doroshopping' ); ?></p>

    <?php
    // Divisa fuera del form: YayCurrency suele renderizar su propio formulario.
    ob_start();
    do_action( 'doroshopping_header_utility_currency' );
    $currency_slot = trim( ob_get_clean() );
    ?>

    <?php if ( $currency_slot ) : ?>
        <label><?php esc_html_e( 'Divisa', 'doroshopping' ); ?></label>
        <div class="header-dropdown__plugin-slot"><?php echo $currency_slot; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
        <p class="header-dropdown__hint"><?php esc_html_e( 'La moneda se aplica al elegirla en el selector.', 'doroshopping' ); ?></p>
    <?php endif; ?>

    <?php
    // Geo / ubicación detectada fuera del form (plugins pueden inyectar markup con forms).
    ob_start();
    do_action( 'doroshopping_header_utility_location' );
    $location_slot = trim( ob_get_clean() );
    if ( $location_slot ) {
        echo '<div class="header-dropdown__plugin-slot header-dropdown__plugin-slot--location">' . $location_slot . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }

    $redirect_to = home_url( '/' );
    if ( ! empty( $_SERVER['REQUEST_URI'] ) ) {
        $redirect_to = home_url( wp_unslash( $_SERVER['REQUEST_URI'] ) );
    }
    ?>

    <form
        class="header-dropdown__form"
        action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"
        method="post"
        data-locale-form
    >
        <input type="hidden" name="action" value="doroshopping_save_locale">
        <input type="hidden" name="doroshopping_redirect" value="<?php echo esc_url( $redirect_to ); ?>">
        <?php wp_nonce_field( 'doroshopping_locale_prefs', 'doroshopping_locale_nonce' ); ?>

        <label id="locale-ubicacion-label"><?php esc_html_e( 'Ubicación', 'doroshopping' ); ?></label>
        <?php
        $doroshopping_render_flag_select( 'ubicacion', 'ubicacion', 'locale-ubicacion-label', $locations, $selected_loc, __( 'Elegir ubicación', 'doroshopping' ) );
        ?>

        <label id="locale-lengua-label"><?php esc_html_e( 'Lengua', 'doroshopping' ); ?></label>
        <?php
        if ( ! empty( $languages ) ) {
            $doroshopping_render_flag_select( 'lengua', 'lengua', 'locale-lengua-label', $languages, $lang_code );
        } else {
            echo '<p class="header-dropdown__hint">' . esc_html__( 'Activa Polylang para cambiar de idioma.', 'doroshopping' ) . '</p>';
        }
        ?>

        <?php if ( ! $currency_slot ) : ?>
            <label for="locale-divisa"><?php esc_html_e( 'Divisa', 'doroshopping' ); ?></label>
            <select id="locale-divisa" name="divisa">
                <option value="EUR" selected>Euro - EUR</option>
                <option value="USD">US Dollar - USD</option>
                <option value="GBP">Pound - GBP</option>
            </select>
            <p class="header-dropdown__hint"><?php esc_html_e( 'Instala YayCurrency para sincronizar precios.', 'doroshopping' ); ?></p>
        <?php endif; ?>

        <button type="submit" class="header-dropdown__submit" name="doroshopping_locale_submit" value="1"><?php esc_html_e( 'Guardar', 'doroshopping' ); ?></button>
    </form>
</div>
