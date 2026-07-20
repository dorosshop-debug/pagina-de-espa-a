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
                    <li>
                        <button
                            type="button"
                            class="mega-menu__cat<?php echo 0 === $index ? ' is-active' : ''; ?>"
                            data-panel="<?php echo esc_attr( $panel['id'] ); ?>"
                            role="tab"
                            aria-selected="<?php echo 0 === $index ? 'true' : 'false'; ?>"
                            id="mega-tab-<?php echo esc_attr( $panel['id'] ); ?>"
                            aria-controls="mega-panel-<?php echo esc_attr( $panel['id'] ); ?>"
                        >
                            <?php echo doroshopping_mega_menu_icon( $panel['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            <?php echo esc_html( $panel['label'] ); ?>
                        </button>
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
                                <?php if ( ! empty( $column['image'] ) ) : ?>
                                    <img class="mega-menu__thumb" src="<?php echo esc_url( $column['image'] ); ?>" alt="" loading="lazy" decoding="async" width="280" height="120">
                                <?php endif; ?>
                                <?php if ( ! empty( $column['heading'] ) ) : ?>
                                    <h4 class="mega-menu__heading">
                                        <?php if ( ! empty( $column['url'] ) ) : ?>
                                            <a href="<?php echo esc_url( $column['url'] ); ?>"><?php echo esc_html( $column['heading'] ); ?></a>
                                        <?php else : ?>
                                            <?php echo esc_html( $column['heading'] ); ?>
                                        <?php endif; ?>
                                    </h4>
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
