<?php
/**
 * Dropdown idioma / moneda / ubicación (Polylang + CURCY / YayCurrency + geo del tema).
 *
 * @package Doroshopping
 */

$ui        = static function ( $key ) {
	return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : '';
};
$flags_uri = get_template_directory_uri() . '/assets/images/flags';
$languages = function_exists( 'doroshopping_get_header_languages' ) ? doroshopping_get_header_languages() : array();
$lang_code = function_exists( 'doroshopping_get_current_language_code' ) ? doroshopping_get_current_language_code() : 'es';
$location  = function_exists( 'doroshopping_get_header_location' ) ? doroshopping_get_header_location() : array( 'code' => 'ES', 'label' => 'España', 'map' => array() );
$currencies = function_exists( 'doroshopping_get_header_currencies' ) ? doroshopping_get_header_currencies() : array();
$currency_code = function_exists( 'doroshopping_get_current_currency_code' ) ? doroshopping_get_current_currency_code() : 'EUR';

$locations = array();
if ( ! empty( $location['map'] ) && is_array( $location['map'] ) ) {
	foreach ( $location['map'] as $code => $item ) {
		$key = strtolower( $code );
		if ( 'uk' === $key ) {
			continue;
		}
		$locations[ $key ] = array(
			'label'    => $item['label'],
			'flag'     => $item['flag'],
			'lang'     => isset( $item['lang'] ) ? $item['lang'] : '',
			'currency' => isset( $item['currency'] ) ? $item['currency'] : '',
		);
	}
}
if ( empty( $locations ) ) {
	$locations = array(
		'es' => array( 'label' => $ui( 'doroshopping_ui_country_es' ), 'flag' => $flags_uri . '/spain.png', 'lang' => 'es', 'currency' => 'EUR' ),
		'pt' => array( 'label' => $ui( 'doroshopping_ui_country_pt' ), 'flag' => $flags_uri . '/ptg.png', 'lang' => 'pt', 'currency' => 'EUR' ),
		'fr' => array( 'label' => $ui( 'doroshopping_ui_country_fr' ), 'flag' => $flags_uri . '/francia.png', 'lang' => 'fr', 'currency' => 'EUR' ),
		'de' => array( 'label' => $ui( 'doroshopping_ui_country_de' ), 'flag' => $flags_uri . '/alemania.png', 'lang' => 'de', 'currency' => 'EUR' ),
		'it' => array( 'label' => $ui( 'doroshopping_ui_country_it' ), 'flag' => $flags_uri . '/italia.png', 'lang' => 'it', 'currency' => 'EUR' ),
		'gb' => array( 'label' => $ui( 'doroshopping_ui_country_gb' ), 'flag' => $flags_uri . '/reino-unido.png', 'lang' => 'en', 'currency' => 'GBP' ),
		'ch' => array( 'label' => $ui( 'doroshopping_ui_country_ch' ), 'flag' => $flags_uri . '/suiza.svg', 'lang' => 'fr', 'currency' => 'CHF' ),
	);
}

$selected_loc = strtolower( isset( $location['code'] ) ? $location['code'] : 'es' );
if ( 'uk' === $selected_loc ) {
	$selected_loc = 'gb';
}
if ( empty( $currencies ) ) {
	$currencies = array(
		'EUR' => array( 'label' => 'Euro (€) - EUR', 'flag' => $flags_uri . '/euro.svg' ),
		'CHF' => array( 'label' => 'Franco suizo (CHF)', 'flag' => $flags_uri . '/suiza.svg' ),
		'GBP' => array( 'label' => 'Libra esterlina (£) - GBP', 'flag' => $flags_uri . '/reino-unido.png' ),
	);
}
if ( ! isset( $currencies[ $currency_code ] ) ) {
	$currency_code = (string) array_key_first( $currencies );
}

$doroshopping_render_flag_select = static function ( $field_id, $name, $label_id, $items, $selected, $placeholder = '', $field_label = '' ) {
	$current       = isset( $items[ $selected ] ) ? $items[ $selected ] : null;
	$current_label = $current ? $current['label'] : $placeholder;
	$current_flag  = $current ? $current['flag'] : '';
	$field_label   = $field_label ? $field_label : $placeholder;
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
			<span class="header-locale-select__inner">
				<span id="<?php echo esc_attr( $label_id ); ?>" class="header-locale-select__field-label"><?php echo esc_html( $field_label ); ?></span>
				<span class="header-locale-select__value">
					<?php if ( $current_flag ) : ?>
						<img class="header-locale-select__flag" src="<?php echo esc_url( $current_flag ); ?>" alt="" width="16" height="16" decoding="async">
					<?php endif; ?>
					<span class="header-locale-select__text"><?php echo esc_html( $current_label ); ?></span>
				</span>
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
						<?php if ( ! empty( $item['lang'] ) ) : ?>
							data-lang="<?php echo esc_attr( $item['lang'] ); ?>"
						<?php endif; ?>
						<?php if ( ! empty( $item['currency'] ) ) : ?>
							data-currency="<?php echo esc_attr( $item['currency'] ); ?>"
						<?php endif; ?>
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
	<p class="header-dropdown__title"><?php echo esc_html( $ui( 'doroshopping_ui_locale_title' ) ); ?></p>

	<?php
	// Slot oculto de plugin (sincronización JS opcional); el selector visible es el del tema.
	ob_start();
	do_action( 'doroshopping_header_utility_currency' );
	$currency_slot = trim( ob_get_clean() );
	if ( $currency_slot ) {
		echo '<div class="header-dropdown__plugin-slot header-dropdown__plugin-slot--currency-sync" hidden aria-hidden="true">' . $currency_slot . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

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

	$from_id   = 0;
	$from_type = 'home';
	if ( is_singular() ) {
		$from_id   = (int) get_queried_object_id();
		$from_type = get_post_type( $from_id ) ? get_post_type( $from_id ) : 'post';
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$from_id   = (int) get_queried_object_id();
		$from_type = 'term';
	} elseif ( is_front_page() || is_home() ) {
		$from_type = 'home';
		if ( function_exists( 'pll_get_post' ) ) {
			$front = (int) get_option( 'page_on_front' );
			if ( $front ) {
				$from_id = $front;
			}
		}
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
		<input type="hidden" name="doroshopping_from_id" value="<?php echo esc_attr( (string) $from_id ); ?>">
		<input type="hidden" name="doroshopping_from_type" value="<?php echo esc_attr( $from_type ); ?>">
		<?php wp_nonce_field( 'doroshopping_locale_prefs', 'doroshopping_locale_nonce' ); ?>

		<?php
		$doroshopping_render_flag_select(
			'ubicacion',
			'ubicacion',
			'locale-ubicacion-label',
			$locations,
			$selected_loc,
			$ui( 'doroshopping_ui_locale_choose_location' ),
			$ui( 'doroshopping_ui_locale_location_label' )
		);
		?>
		<p class="header-dropdown__hint"><?php echo esc_html( $ui( 'doroshopping_ui_locale_location_hint' ) ); ?></p>

		<?php
		if ( ! empty( $languages ) ) {
			$doroshopping_render_flag_select(
				'lengua',
				'lengua',
				'locale-lengua-label',
				$languages,
				$lang_code,
				'',
				$ui( 'doroshopping_ui_locale_language_label' )
			);
			echo '<p class="header-dropdown__hint">' . esc_html( $ui( 'doroshopping_ui_locale_language_hint' ) ) . '</p>';
		} else {
			echo '<p class="header-dropdown__hint">' . esc_html( $ui( 'doroshopping_ui_locale_polylang_hint' ) ) . '</p>';
		}
		?>

		<?php
		$doroshopping_render_flag_select(
			'divisa',
			'divisa',
			'locale-divisa-label',
			$currencies,
			$currency_code,
			$ui( 'doroshopping_ui_locale_choose_currency' ),
			$ui( 'doroshopping_ui_locale_currency_label' )
		);
		?>

		<button type="submit" class="header-dropdown__submit" name="doroshopping_locale_submit" value="1"><?php echo esc_html( $ui( 'doroshopping_ui_locale_save' ) ); ?></button>
	</form>
</div>
