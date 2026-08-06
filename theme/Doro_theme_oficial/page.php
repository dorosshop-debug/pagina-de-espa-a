<?php
/**
 * Plantilla de páginas estáticas (CMS).
 *
 * Cromado (eyebrows, TOC, enlaces) vía doroshopping_ui_text.
 * El cuerpo sigue siendo el contenido del editor / Elementor.
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$ui = static function ( $key ) {
	return function_exists( 'doroshopping_ui_text' ) ? doroshopping_ui_text( $key ) : '';
};

$queried_id = get_queried_object_id();
$slug       = (string) get_post_field( 'post_name', $queried_id );
$page_title = get_the_title( $queried_id );

$legal_slugs = array(
	'politica-de-privacidad',
	'terminos-y-condiciones',
	'aviso-legal',
	'cookies',
	'politica-de-cookies',
	'politica-de-devoluciones',
);

$info_slugs = array(
	'metodos-de-pago',
	'envios',
	'proteccion-del-comprador',
	'nosotros',
	'contacto',
);

$is_legal = in_array( $slug, $legal_slugs, true );
$is_info  = in_array( $slug, $info_slugs, true );

$main_class = 'doro-page';
if ( $is_legal ) {
	$main_class .= ' doro-page--legal';
} elseif ( $is_info ) {
	$main_class .= ' doro-page--info';
}

$eyebrow = '';
if ( $is_legal ) {
	$eyebrow = $ui( 'doroshopping_ui_cms_eyebrow_legal' );
} elseif ( $is_info ) {
	$eyebrow = $ui( 'doroshopping_ui_cms_eyebrow_info' );
}

$related = array();
if ( $is_legal || $is_info ) {
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
}
?>

<main id="main-content" class="<?php echo esc_attr( $main_class ); ?>">
	<?php if ( $is_legal || $is_info ) : ?>
		<div class="doro-page__hero">
			<div class="doro-page__hero-inner">
				<?php if ( $eyebrow ) : ?>
					<p class="doro-page__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
				<?php endif; ?>
				<h1 class="doro-page__title"><?php echo esc_html( $page_title ); ?></h1>
				<?php if ( $is_legal ) : ?>
					<p class="doro-page__lead">
						<?php
						$updated = get_the_modified_date() ? get_the_modified_date() : get_the_date();
						echo esc_html(
							function_exists( 'doroshopping_ui_sprintf' )
								? doroshopping_ui_sprintf( 'doroshopping_ui_cms_updated', $updated )
								: sprintf( $ui( 'doroshopping_ui_cms_updated' ), $updated )
						);
						?>
					</p>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>

	<div class="doro-page__container<?php echo ( $is_legal || $is_info ) ? ' doro-page__container--wide' : ''; ?>">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<div class="doro-page__layout<?php echo $is_legal ? ' doro-page__layout--legal' : ''; ?>">
				<?php if ( $is_legal ) : ?>
					<aside class="doro-page__sidebar" aria-label="<?php echo esc_attr( $ui( 'doroshopping_ui_cms_toc_aria' ) ); ?>">
						<nav class="doro-page__toc" data-doro-toc hidden>
							<p class="doro-page__toc-title"><?php echo esc_html( $ui( 'doroshopping_ui_cms_toc_title' ) ); ?></p>
							<ol class="doro-page__toc-list" data-doro-toc-list></ol>
						</nav>
						<?php if ( ! empty( $related ) ) : ?>
							<nav class="doro-page__related" aria-label="<?php echo esc_attr( $ui( 'doroshopping_ui_cms_related_aria' ) ); ?>">
								<p class="doro-page__toc-title"><?php echo esc_html( $ui( 'doroshopping_ui_cms_related_title' ) ); ?></p>
								<ul class="doro-page__related-list">
									<?php
									$count = 0;
									foreach ( $related as $rel_slug => $rel_key ) :
										if ( $count >= 5 ) {
											break;
										}
										++$count;
										?>
										<li>
											<a href="<?php echo esc_url( doroshopping_get_page_url( $rel_slug ) ); ?>">
												<?php echo esc_html( $ui( $rel_key ) ); ?>
											</a>
										</li>
									<?php endforeach; ?>
								</ul>
							</nav>
						<?php endif; ?>
					</aside>
				<?php endif; ?>

				<article <?php post_class( 'doro-page__article' . ( $is_legal ? ' doro-page__article--legal' : '' ) . ( $is_info ? ' doro-page__article--info' : '' ) ); ?>>
					<?php if ( ! $is_legal && ! $is_info ) : ?>
						<header class="doro-page__header">
							<h1 class="doro-page__title"><?php the_title(); ?></h1>
						</header>
					<?php endif; ?>
					<div class="doro-page__content entry-content<?php echo $is_legal ? ' doro-page__content--legal' : ''; ?><?php echo $is_info ? ' doro-page__content--info' : ''; ?>" data-doro-page-content>
						<?php the_content(); ?>
					</div>

					<?php if ( ( $is_info || $is_legal ) && ! empty( $related ) ) : ?>
						<footer class="doro-page__footer-links">
							<p class="doro-page__footer-links-title"><?php echo esc_html( $ui( 'doroshopping_ui_cms_footer_links' ) ); ?></p>
							<div class="doro-page__footer-links-row">
								<?php
								$i = 0;
								foreach ( $related as $rel_slug => $rel_key ) :
									if ( $i >= 4 ) {
										break;
									}
									++$i;
									?>
									<a class="doro-page__pill" href="<?php echo esc_url( doroshopping_get_page_url( $rel_slug ) ); ?>">
										<?php echo esc_html( $ui( $rel_key ) ); ?>
									</a>
								<?php endforeach; ?>
							</div>
						</footer>
					<?php endif; ?>
				</article>
			</div>
			<?php
		endwhile;
		?>
	</div>
</main>

<?php
get_footer();
