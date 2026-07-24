<?php
/**
 * Mega menu de categorías (menú WP, product_cat o fallback estático)
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$img     = get_template_directory_uri() . '/assets/images/banners';
$panels  = doroshopping_get_mega_menu_panels();
$default = ! empty( $panels ) ? $panels[0]['id'] : 'fallback';
?>

<div class="mega-menu" id="mega-menu" hidden>
    <div class="mega-menu__inner">
        <aside class="mega-menu__sidebar">
            <ul class="mega-menu__cats" role="tablist">
                <?php foreach ( $panels as $index => $panel ) : ?>
                    <?php
                    $panel_url = ! empty( $panel['url'] ) ? $panel['url'] : '#';
                    if ( is_wp_error( $panel_url ) ) {
                        $panel_url = '#';
                    }
                    ?>
                    <li>
                        <a
                            href="<?php echo esc_url( $panel_url ); ?>"
                            class="mega-menu__cat<?php echo 0 === $index ? ' is-active' : ''; ?>"
                            data-panel="<?php echo esc_attr( $panel['id'] ); ?>"
                            role="tab"
                            aria-selected="<?php echo 0 === $index ? 'true' : 'false'; ?>"
                            id="mega-tab-<?php echo esc_attr( $panel['id'] ); ?>"
                            aria-controls="mega-panel-<?php echo esc_attr( $panel['id'] ); ?>"
                        >
                            <?php echo doroshopping_mega_menu_icon( $panel['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            <?php echo esc_html( $panel['label'] ); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </aside>

        <div class="mega-menu__panels">
            <?php foreach ( $panels as $index => $panel ) : ?>
                <div
                    class="mega-menu__panel<?php echo 0 === $index ? ' is-active' : ''; ?>"
                    data-panel="<?php echo esc_attr( $panel['id'] ); ?>"
                    role="tabpanel"
                    id="mega-panel-<?php echo esc_attr( $panel['id'] ); ?>"
                    aria-labelledby="mega-tab-<?php echo esc_attr( $panel['id'] ); ?>"
                    <?php echo 0 === $index ? '' : 'hidden'; ?>
                >
                    <div class="mega-menu__columns">
                        <?php foreach ( $panel['columns'] as $column ) : ?>
                            <div class="mega-menu__column">
                                <?php if ( ! empty( $column['url'] ) ) : ?>
                                    <a class="mega-menu__thumb-link" href="<?php echo esc_url( $column['url'] ); ?>">
                                        <?php if ( ! empty( $column['image'] ) ) : ?>
                                            <span class="mega-menu__thumb-wrap">
                                                <img class="mega-menu__thumb" src="<?php echo esc_url( $column['image'] ); ?>" alt="" loading="lazy" decoding="async" width="160" height="110">
                                            </span>
                                        <?php endif; ?>
                                        <?php if ( ! empty( $column['heading'] ) ) : ?>
                                            <span class="mega-menu__heading"><?php echo esc_html( $column['heading'] ); ?></span>
                                        <?php endif; ?>
                                    </a>
                                <?php else : ?>
                                    <?php if ( ! empty( $column['image'] ) ) : ?>
                                        <span class="mega-menu__thumb-wrap">
                                            <img class="mega-menu__thumb" src="<?php echo esc_url( $column['image'] ); ?>" alt="" loading="lazy" decoding="async" width="160" height="110">
                                        </span>
                                    <?php endif; ?>
                                    <?php if ( ! empty( $column['heading'] ) ) : ?>
                                        <h4 class="mega-menu__heading"><?php echo esc_html( $column['heading'] ); ?></h4>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if ( ! empty( $column['links'] ) ) : ?>
                                    <ul>
                                        <?php foreach ( $column['links'] as $link ) : ?>
                                            <li>
                                                <a href="<?php echo esc_url( $link['url'] ); ?>"><?php echo esc_html( $link['label'] ); ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
