<?php
/**
 * Template Name: Legal / políticas
 * Template Post Type: page
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$queried_id = get_queried_object_id();
$slug       = (string) get_post_field( 'post_name', $queried_id );
$page_title = get_the_title( $queried_id );
$site_name  = get_bloginfo( 'name' ) ? get_bloginfo( 'name' ) : 'Doroshopping';
$ui         = 'doroshopping_ui_text';
$ui_defaults = function_exists( 'doroshopping_i18n_ui_defaults' ) ? doroshopping_i18n_ui_defaults() : array();

$document_map = array(
	'politica-de-privacidad' => 'privacy',
	'aviso-legal'            => 'notice',
	'terminos-y-condiciones' => 'terms',
	'politica-de-cookies'    => 'cookies',
	'cookies'                => 'cookies',
);
$document = isset( $document_map[ $slug ] ) ? $document_map[ $slug ] : '';

$text_key = static function ( $cms_key, $legal_key ) use ( $ui_defaults ) {
	return isset( $ui_defaults[ $cms_key ] ) ? $cms_key : $legal_key;
};
$text = static function ( $key, $fallback = '' ) use ( $ui ) {
	$value = is_callable( $ui ) ? $ui( $key ) : '';
	return '' !== $value ? $value : $fallback;
};
$section = static function ( $heading_key, $paragraph_key = '', $list_keys = array() ) use ( $text ) {
	if ( '' !== $heading_key ) {
		echo '<h2>' . esc_html( $text( $heading_key ) ) . '</h2>';
	}
	if ( '' !== $paragraph_key ) {
		echo '<p>' . esc_html( $text( $paragraph_key ) ) . '</p>';
	}
	if ( ! empty( $list_keys ) ) {
		echo '<ul>';
		foreach ( $list_keys as $list_key ) {
			echo '<li>' . esc_html( $text( $list_key ) ) . '</li>';
		}
		echo '</ul>';
	}
};

$related = array(
	'metodos-de-pago'          => 'doroshopping_ui_cms_rel_payments',
	'envios'                   => 'doroshopping_ui_cms_rel_shipping',
	'proteccion-del-comprador' => 'doroshopping_ui_cms_rel_protect',
	'politica-de-devoluciones' => 'doroshopping_ui_cms_rel_returns',
	'terminos-y-condiciones'   => 'doroshopping_ui_cms_rel_terms',
	'aviso-legal'              => 'doroshopping_ui_cms_rel_legal',
	'politica-de-cookies'      => 'doroshopping_ui_cms_rel_cookies',
	'politica-de-privacidad'   => 'doroshopping_ui_cms_rel_privacy',
	'centro-de-ayuda'          => 'doroshopping_ui_cms_rel_help',
);
unset( $related[ $slug ] );
if ( 'cookies' === $slug ) {
	unset( $related['politica-de-cookies'] );
}

$updated_date = get_the_modified_date( get_option( 'date_format' ), $queried_id );
if ( ! $updated_date ) {
	$updated_date = get_the_date( get_option( 'date_format' ), $queried_id );
}
?>

<main id="main-content" class="doro-page doro-page--legal">
	<div class="doro-page__hero">
		<div class="doro-page__hero-inner">
			<p class="doro-page__eyebrow"><?php echo esc_html( $text( $text_key( 'doroshopping_ui_cms_eyebrow_legal', 'doroshopping_ui_legal_eyebrow' ) ) ); ?></p>
			<h1 class="doro-page__title"><?php echo esc_html( $page_title ); ?></h1>
			<p class="doro-page__lead">
				<?php echo esc_html( doroshopping_ui_sprintf( $text_key( 'doroshopping_ui_cms_updated', 'doroshopping_ui_legal_updated' ), $updated_date ) ); ?>
			</p>
		</div>
	</div>

	<div class="doro-page__container doro-page__container--wide">
		<?php while ( have_posts() ) : the_post(); ?>
			<div class="doro-page__layout doro-page__layout--legal">
				<aside class="doro-page__sidebar" aria-label="<?php echo esc_attr( $text( $text_key( 'doroshopping_ui_cms_toc_aria', 'doroshopping_ui_legal_toc_aria' ) ) ); ?>">
					<nav class="doro-page__toc" data-doro-toc hidden>
						<p class="doro-page__toc-title"><?php echo esc_html( $text( $text_key( 'doroshopping_ui_cms_toc_title', 'doroshopping_ui_legal_toc_title' ) ) ); ?></p>
						<ol class="doro-page__toc-list" data-doro-toc-list></ol>
					</nav>

					<nav class="doro-page__related" aria-label="<?php echo esc_attr( $text( $text_key( 'doroshopping_ui_cms_related_aria', 'doroshopping_ui_legal_related_aria' ) ) ); ?>">
						<p class="doro-page__toc-title"><?php echo esc_html( $text( $text_key( 'doroshopping_ui_cms_related_title', 'doroshopping_ui_legal_related_title' ) ) ); ?></p>
						<ul class="doro-page__related-list">
							<?php
							$count = 0;
							foreach ( $related as $related_slug => $related_key ) :
								if ( $count >= 5 ) {
									break;
								}
								++$count;
								?>
								<li><a href="<?php echo esc_url( doroshopping_get_page_url( $related_slug ) ); ?>"><?php echo esc_html( $text( $related_key ) ); ?></a></li>
							<?php endforeach; ?>
						</ul>
					</nav>
				</aside>

				<article <?php post_class( 'doro-page__article doro-page__article--legal' ); ?>>
					<div class="doro-page__content doro-page__content--legal entry-content" data-doro-page-content>
						<?php if ( 'privacy' === $document ) : ?>
							<p><?php echo esc_html( $text( 'doroshopping_ui_legal_privacy_intro' ) ); ?></p>
							<?php
							$section( 'doroshopping_ui_legal_privacy_h1', 'doroshopping_ui_legal_privacy_p1' );
							$section( 'doroshopping_ui_legal_privacy_h2', '', array( 'doroshopping_ui_legal_privacy_li1', 'doroshopping_ui_legal_privacy_li2', 'doroshopping_ui_legal_privacy_li3', 'doroshopping_ui_legal_privacy_li4' ) );
							$section( 'doroshopping_ui_legal_privacy_h3', '', array( 'doroshopping_ui_legal_privacy_li5', 'doroshopping_ui_legal_privacy_li6', 'doroshopping_ui_legal_privacy_li7', 'doroshopping_ui_legal_privacy_li8' ) );
							$section( 'doroshopping_ui_legal_privacy_h4', 'doroshopping_ui_legal_privacy_p4' );
							$section( 'doroshopping_ui_legal_privacy_h5', 'doroshopping_ui_legal_privacy_p5' );
							$section( 'doroshopping_ui_legal_privacy_h6', 'doroshopping_ui_legal_privacy_p6' );
							?>
						<?php elseif ( 'notice' === $document ) : ?>
							<p><?php echo esc_html( doroshopping_ui_sprintf( 'doroshopping_ui_legal_notice_intro', $site_name ) ); ?></p>
							<?php
							$section( 'doroshopping_ui_legal_notice_h1', 'doroshopping_ui_legal_notice_p1', array( 'doroshopping_ui_legal_notice_li1', 'doroshopping_ui_legal_notice_li2' ) );
							$section( 'doroshopping_ui_legal_notice_h2', 'doroshopping_ui_legal_notice_p2' );
							$section( 'doroshopping_ui_legal_notice_h3', '', array( 'doroshopping_ui_legal_notice_li3', 'doroshopping_ui_legal_notice_li4', 'doroshopping_ui_legal_notice_li5' ) );
							$section( 'doroshopping_ui_legal_notice_h4', 'doroshopping_ui_legal_notice_p4' );
							$section( 'doroshopping_ui_legal_notice_h5', 'doroshopping_ui_legal_notice_p5' );
							$section( 'doroshopping_ui_legal_notice_h6', 'doroshopping_ui_legal_notice_p6' );
							?>
						<?php elseif ( 'terms' === $document ) : ?>
							<p><?php echo esc_html( doroshopping_ui_sprintf( 'doroshopping_ui_legal_terms_intro', $site_name ) ); ?></p>
							<?php
							$section( 'doroshopping_ui_legal_terms_h1', 'doroshopping_ui_legal_terms_p1' );
							$section( 'doroshopping_ui_legal_terms_h2', 'doroshopping_ui_legal_terms_p2' );
							$section( 'doroshopping_ui_legal_terms_h3', '', array( 'doroshopping_ui_legal_terms_li1', 'doroshopping_ui_legal_terms_li2', 'doroshopping_ui_legal_terms_li3' ) );
							for ( $index = 4; $index <= 10; ++$index ) {
								$section( 'doroshopping_ui_legal_terms_h' . $index, 'doroshopping_ui_legal_terms_p' . $index );
							}
							?>
						<?php elseif ( 'cookies' === $document ) : ?>
							<p><?php echo esc_html( $text( 'doroshopping_ui_legal_cookies_intro' ) ); ?></p>
							<?php
							$section( 'doroshopping_ui_legal_cookies_h1', 'doroshopping_ui_legal_cookies_p1' );
							$section( 'doroshopping_ui_legal_cookies_h2', '', array( 'doroshopping_ui_legal_cookies_li1', 'doroshopping_ui_legal_cookies_li2', 'doroshopping_ui_legal_cookies_li3', 'doroshopping_ui_legal_cookies_li4' ) );
							$section( 'doroshopping_ui_legal_cookies_h3', 'doroshopping_ui_legal_cookies_p3' );
							$section( 'doroshopping_ui_legal_cookies_h4', '', array( 'doroshopping_ui_legal_cookies_li5', 'doroshopping_ui_legal_cookies_li6', 'doroshopping_ui_legal_cookies_li7' ) );
							$section( 'doroshopping_ui_legal_cookies_h5', 'doroshopping_ui_legal_cookies_p5' );
							?>
						<?php elseif ( '' !== trim( get_the_content() ) ) : ?>
							<?php the_content(); ?>
						<?php else : ?>
							<p><?php echo esc_html( $text( 'doroshopping_ui_legal_unknown' ) ); ?></p>
						<?php endif; ?>
					</div>

					<footer class="doro-page__footer-links">
						<p class="doro-page__footer-links-title"><?php echo esc_html( $text( $text_key( 'doroshopping_ui_cms_footer_links', 'doroshopping_ui_legal_footer_title' ) ) ); ?></p>
						<div class="doro-page__footer-links-row">
							<?php
							$count = 0;
							foreach ( $related as $related_slug => $related_key ) :
								if ( $count >= 4 ) {
									break;
								}
								++$count;
								?>
								<a class="doro-page__pill" href="<?php echo esc_url( doroshopping_get_page_url( $related_slug ) ); ?>"><?php echo esc_html( $text( $related_key ) ); ?></a>
							<?php endforeach; ?>
						</div>
					</footer>
				</article>
			</div>
		<?php endwhile; ?>
	</div>
</main>

<?php get_footer(); ?>
