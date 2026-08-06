<?php
/**
 * Template Name: Sobre nosotros
 * Template post type: page
 *
 * Textos vía doroshopping_ui_text (Personalizar + packs por idioma).
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

$help_url = function_exists( 'doroshopping_get_page_url' ) ? doroshopping_get_page_url( 'centro-de-ayuda' ) : home_url( '/centro-de-ayuda/' );
$shop_url = function_exists( 'doroshopping_get_wc_page_url' ) ? doroshopping_get_wc_page_url( 'shop' ) : home_url( '/' );
$img_base = get_template_directory_uri() . '/assets/images';

$hero_img   = $img_base . '/banners/hero2.webp';
$who_img    = $img_base . '/banners/hero1.png';
$mosaic     = array(
	$img_base . '/categories/auriculares.png',
	$img_base . '/categories/hogar.png',
	$img_base . '/categories/deportes.png',
	$img_base . '/products/Producto1.jpg',
);

$reach_icons = array(
	1 => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><path d="M3 7h18v12H3z"/><path d="M3 7l3-4h12l3 4"/><path d="M8 11h8"/></svg>',
	2 => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><path d="M3 7h11v10H3z"/><path d="M14 10h4l3 3v4h-7"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>',
	3 => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>',
	4 => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><path d="M3 14h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-7a9 9 0 0 1 18 0v7a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3"/></svg>',
);
?>

<main id="main-content" class="doro-support doro-info doro-about">
	<section class="doro-about__hero">
		<div class="doro-about__hero-media" aria-hidden="true">
			<img src="<?php echo esc_url( $hero_img ); ?>" alt="" loading="eager" decoding="async" width="1600" height="700">
		</div>
		<div class="doro-about__hero-overlay" aria-hidden="true"></div>
		<div class="doro-about__hero-inner">
			<p class="doro-support__eyebrow"><?php echo esc_html( $ui( 'doroshopping_ui_about_eyebrow' ) ); ?></p>
			<h1 class="doro-support__title"><?php echo esc_html( $ui( 'doroshopping_ui_about_title' ) ); ?></h1>
			<p class="doro-support__lead"><?php echo esc_html( $ui( 'doroshopping_ui_about_lead' ) ); ?></p>
			<div class="doro-about__hero-actions">
				<a class="doro-support__btn" href="<?php echo esc_url( $shop_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_about_cta_shop' ) ); ?></a>
				<a class="doro-support__btn doro-support__btn--ghost doro-about__btn-light" href="<?php echo esc_url( $help_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_about_cta_help' ) ); ?></a>
			</div>
		</div>
	</section>

	<div class="doro-support__container doro-about__container">
		<section class="doro-about__who">
			<div class="doro-about__who-copy">
				<p class="doro-about__kicker"><?php echo esc_html( $ui( 'doroshopping_ui_about_eyebrow' ) ); ?></p>
				<h2 class="doro-support__section-title"><?php echo esc_html( $ui( 'doroshopping_ui_about_who_title' ) ); ?></h2>
				<p><?php echo esc_html( $ui( 'doroshopping_ui_about_who_text' ) ); ?></p>
			</div>
			<div class="doro-about__who-visual">
				<figure class="doro-about__who-main">
					<img src="<?php echo esc_url( $who_img ); ?>" alt="" loading="lazy" decoding="async" width="720" height="480">
				</figure>
				<div class="doro-about__mosaic" aria-hidden="true">
					<?php foreach ( $mosaic as $src ) : ?>
						<img src="<?php echo esc_url( $src ); ?>" alt="" loading="lazy" decoding="async" width="160" height="160">
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="doro-about__reach">
			<div class="doro-about__reach-head">
				<h2 class="doro-support__section-title"><?php echo esc_html( $ui( 'doroshopping_ui_about_reach_title' ) ); ?></h2>
			</div>
			<div class="doro-about__reach-grid">
				<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
					<article class="doro-about__reach-card">
						<span class="doro-about__reach-icon" aria-hidden="true">
							<?php echo $reach_icons[ $i ]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
						</span>
						<span class="doro-about__reach-num" aria-hidden="true"><?php echo esc_html( (string) $i ); ?></span>
						<h3><?php echo esc_html( $ui( 'doroshopping_ui_about_reach_' . $i . '_title' ) ); ?></h3>
						<p><?php echo esc_html( $ui( 'doroshopping_ui_about_reach_' . $i . '_text' ) ); ?></p>
					</article>
				<?php endfor; ?>
			</div>
		</section>

		<section class="doro-about__commit">
			<div class="doro-about__commit-inner">
				<div class="doro-about__commit-copy">
					<h2 class="doro-support__section-title"><?php echo esc_html( $ui( 'doroshopping_ui_about_commit_title' ) ); ?></h2>
					<p><?php echo esc_html( $ui( 'doroshopping_ui_about_commit_text' ) ); ?></p>
					<div class="doro-about__commit-actions">
						<a class="doro-support__btn" href="<?php echo esc_url( $help_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_about_cta_help' ) ); ?></a>
						<a class="doro-support__btn doro-support__btn--ghost doro-about__btn-on-dark" href="<?php echo esc_url( $shop_url ); ?>"><?php echo esc_html( $ui( 'doroshopping_ui_about_cta_shop' ) ); ?></a>
					</div>
				</div>
				<figure class="doro-about__commit-visual" aria-hidden="true">
					<img src="<?php echo esc_url( $img_base . '/imagen_footer.webp' ); ?>" alt="" loading="lazy" decoding="async" width="520" height="360">
				</figure>
			</div>
		</section>
	</div>
</main>

<?php
get_footer();
