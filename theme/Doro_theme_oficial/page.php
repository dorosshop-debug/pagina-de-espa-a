<?php
/**
 * Plantilla de páginas estáticas (CMS).
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
	$eyebrow = __( 'Información legal', 'doroshopping' );
} elseif ( $is_info ) {
	$eyebrow = __( 'Guía de compra', 'doroshopping' );
}

$related = array();
if ( $is_legal || $is_info ) {
	$related = array(
		'metodos-de-pago'          => __( 'Métodos de pago', 'doroshopping' ),
		'envios'                   => __( 'Envíos', 'doroshopping' ),
		'proteccion-del-comprador' => __( 'Protección del comprador', 'doroshopping' ),
		'politica-de-devoluciones' => __( 'Devoluciones', 'doroshopping' ),
		'terminos-y-condiciones'   => __( 'Términos', 'doroshopping' ),
		'aviso-legal'              => __( 'Aviso legal', 'doroshopping' ),
		'politica-de-cookies'      => __( 'Cookies', 'doroshopping' ),
		'politica-de-privacidad'   => __( 'Privacidad', 'doroshopping' ),
		'centro-de-ayuda'          => __( 'Centro de ayuda', 'doroshopping' ),
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
						echo esc_html(
							sprintf(
								/* translators: %s: last updated date */
								__( 'Última actualización: %s', 'doroshopping' ),
								get_the_modified_date() ? get_the_modified_date() : get_the_date()
							)
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
					<aside class="doro-page__sidebar" aria-label="<?php esc_attr_e( 'Índice de la página', 'doroshopping' ); ?>">
						<nav class="doro-page__toc" data-doro-toc hidden>
							<p class="doro-page__toc-title"><?php esc_html_e( 'En esta página', 'doroshopping' ); ?></p>
							<ol class="doro-page__toc-list" data-doro-toc-list></ol>
						</nav>
						<?php if ( ! empty( $related ) ) : ?>
							<nav class="doro-page__related" aria-label="<?php esc_attr_e( 'Páginas relacionadas', 'doroshopping' ); ?>">
								<p class="doro-page__toc-title"><?php esc_html_e( 'También te puede interesar', 'doroshopping' ); ?></p>
								<ul class="doro-page__related-list">
									<?php
									$count = 0;
									foreach ( $related as $rel_slug => $rel_label ) :
										if ( $count >= 5 ) {
											break;
										}
										++$count;
										?>
										<li>
											<a href="<?php echo esc_url( doroshopping_get_page_url( $rel_slug ) ); ?>">
												<?php echo esc_html( $rel_label ); ?>
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
							<p class="doro-page__footer-links-title"><?php esc_html_e( 'Enlaces útiles', 'doroshopping' ); ?></p>
							<div class="doro-page__footer-links-row">
								<?php
								$i = 0;
								foreach ( $related as $rel_slug => $rel_label ) :
									if ( $i >= 4 ) {
										break;
									}
									++$i;
									?>
									<a class="doro-page__pill" href="<?php echo esc_url( doroshopping_get_page_url( $rel_slug ) ); ?>">
										<?php echo esc_html( $rel_label ); ?>
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
