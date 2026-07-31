<?php
/**
 * Aviso suave de ubicación detectada.
 *
 * @package Doroshopping
 *
 * @var array $args
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$payload = ( isset( $args['payload'] ) && is_array( $args['payload'] ) ) ? $args['payload'] : array();
if ( empty( $payload['country'] ) ) {
	return;
}

$country = esc_attr( $payload['country'] );
$label   = isset( $payload['label'] ) ? (string) $payload['label'] : $payload['country'];
$flag    = ! empty( $payload['flag'] ) ? (string) $payload['flag'] : '';
$message = isset( $payload['message'] ) ? (string) $payload['message'] : '';
?>
<div
	class="doro-geo-banner"
	id="doro-geo-banner"
	role="dialog"
	aria-live="polite"
	aria-labelledby="doro-geo-banner-title"
	data-geo-banner
	data-geo-country="<?php echo $country; ?>"
	hidden
>
	<div class="doro-geo-banner__inner">
		<?php if ( $flag ) : ?>
			<img class="doro-geo-banner__flag" src="<?php echo esc_url( $flag ); ?>" alt="" width="28" height="20" loading="lazy" decoding="async">
		<?php endif; ?>

		<div class="doro-geo-banner__text">
			<p id="doro-geo-banner-title" class="doro-geo-banner__message"><?php echo esc_html( $message ); ?></p>
		</div>

		<div class="doro-geo-banner__actions">
			<button type="button" class="doro-geo-banner__btn doro-geo-banner__btn--primary" data-geo-accept>
				<?php echo esc_html( isset( $payload['acceptLabel'] ) ? $payload['acceptLabel'] : __( 'Sí, usar', 'doroshopping' ) ); ?>
			</button>
			<button type="button" class="doro-geo-banner__btn" data-geo-change>
				<?php echo esc_html( isset( $payload['changeLabel'] ) ? $payload['changeLabel'] : __( 'Elegir otra', 'doroshopping' ) ); ?>
			</button>
			<button type="button" class="doro-geo-banner__btn doro-geo-banner__btn--ghost" data-geo-dismiss>
				<?php echo esc_html( isset( $payload['dismissLabel'] ) ? $payload['dismissLabel'] : __( 'Ahora no', 'doroshopping' ) ); ?>
			</button>
		</div>

		<button
			type="button"
			class="doro-geo-banner__close"
			data-geo-dismiss
			aria-label="<?php echo esc_attr( isset( $payload['closeLabel'] ) ? $payload['closeLabel'] : __( 'Cerrar', 'doroshopping' ) ); ?>"
		>
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
</div>
