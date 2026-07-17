<?php
/**
 * Mega menu de categorias
 *
 * @package Doroshopping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$img = get_template_directory_uri() . '/assets/images/banners';
?>

<div class="mega-menu" id="mega-menu" hidden>
    <div class="mega-menu__inner">
        <aside class="mega-menu__sidebar">
            <ul class="mega-menu__cats" role="tablist">
                <li>
                    <button type="button" class="mega-menu__cat is-active" data-panel="electronica" role="tab" aria-selected="true">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/></svg>
                        <?php esc_html_e( 'Electronica', 'doroshopping' ); ?>
                    </button>
                </li>
                <li>
                    <button type="button" class="mega-menu__cat" data-panel="informatica" role="tab" aria-selected="false">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                        <?php esc_html_e( 'Informatica', 'doroshopping' ); ?>
                    </button>
                </li>
                <li>
                    <button type="button" class="mega-menu__cat" data-panel="hogar" role="tab" aria-selected="false">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><path d="M9 22V12h6v10"/></svg>
                        <?php esc_html_e( 'Hogar y Cocina', 'doroshopping' ); ?>
                    </button>
                </li>
                <li>
                    <button type="button" class="mega-menu__cat" data-panel="deportes" role="tab" aria-selected="false">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 0 20"/></svg>
                        <?php esc_html_e( 'Deportes y Recreacion', 'doroshopping' ); ?>
                    </button>
                </li>
                <li>
                    <button type="button" class="mega-menu__cat" data-panel="promociones" role="tab" aria-selected="false">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><circle cx="7" cy="7" r="1.5"/></svg>
                        <?php esc_html_e( 'Promociones & Ofertas', 'doroshopping' ); ?>
                    </button>
                </li>
            </ul>
        </aside>

        <div class="mega-menu__panels">
            <div class="mega-menu__panel is-active" data-panel="electronica" role="tabpanel">
                <div class="mega-menu__columns">
                    <div class="mega-menu__column">
                        <img class="mega-menu__thumb" src="<?php echo esc_url( $img . '/Banner_mundial_doro.webp' ); ?>" alt="">
                        <h4 class="mega-menu__heading"><?php esc_html_e( 'Telefonos y Tabletas', 'doroshopping' ); ?></h4>
                        <ul>
                            <li><a href="#"><?php esc_html_e( 'Accesorios para moviles y tabletas', 'doroshopping' ); ?></a></li>
                            <li><a href="#"><?php esc_html_e( 'Auriculares con microfono', 'doroshopping' ); ?></a></li>
                            <li><a href="#"><?php esc_html_e( 'Auriculares Bluetooth con microfono', 'doroshopping' ); ?></a></li>
                            <li><a href="#"><?php esc_html_e( 'Relojes inteligentes', 'doroshopping' ); ?></a></li>
                            <li><a href="#"><?php esc_html_e( 'Telefonos moviles', 'doroshopping' ); ?></a></li>
                            <li><a href="#"><?php esc_html_e( 'Tabletas', 'doroshopping' ); ?></a></li>
                        </ul>
                    </div>
                    <div class="mega-menu__column">
                        <img class="mega-menu__thumb" src="<?php echo esc_url( $img . '/Banner_doro_6.webp' ); ?>" alt="">
                        <h4 class="mega-menu__heading"><?php esc_html_e( 'Sonido', 'doroshopping' ); ?></h4>
                        <ul>
                            <li><a href="#"><?php esc_html_e( 'Barras de sonido', 'doroshopping' ); ?></a></li>
                            <li><a href="#"><?php esc_html_e( 'Auriculares Bluetooth', 'doroshopping' ); ?></a></li>
                            <li><a href="#"><?php esc_html_e( 'Auriculares inalambricos', 'doroshopping' ); ?></a></li>
                            <li><a href="#"><?php esc_html_e( 'Componentes y Accesorios', 'doroshopping' ); ?></a></li>
                        </ul>
                    </div>
                    <div class="mega-menu__column">
                        <img class="mega-menu__thumb" src="<?php echo esc_url( $img . '/Banner_mundial_doro.webp' ); ?>" alt="">
                        <h4 class="mega-menu__heading"><?php esc_html_e( 'Fotografia y Video', 'doroshopping' ); ?></h4>
                        <ul>
                            <li><a href="#"><?php esc_html_e( 'Accesorios para Camaras y Videocamaras', 'doroshopping' ); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="mega-menu__panel" data-panel="informatica" role="tabpanel" hidden>
                <div class="mega-menu__columns">
                    <div class="mega-menu__column">
                        <img class="mega-menu__thumb" src="<?php echo esc_url( $img . '/Banner_doro_6.webp' ); ?>" alt="">
                        <h4 class="mega-menu__heading"><?php esc_html_e( 'Ordenadores', 'doroshopping' ); ?></h4>
                        <ul>
                            <li><a href="#"><?php esc_html_e( 'Portatiles', 'doroshopping' ); ?></a></li>
                            <li><a href="#"><?php esc_html_e( 'Sobremesa', 'doroshopping' ); ?></a></li>
                            <li><a href="#"><?php esc_html_e( 'Monitores', 'doroshopping' ); ?></a></li>
                        </ul>
                    </div>
                    <div class="mega-menu__column">
                        <img class="mega-menu__thumb" src="<?php echo esc_url( $img . '/Banner_mundial_doro.webp' ); ?>" alt="">
                        <h4 class="mega-menu__heading"><?php esc_html_e( 'Componentes', 'doroshopping' ); ?></h4>
                        <ul>
                            <li><a href="#"><?php esc_html_e( 'Almacenamiento', 'doroshopping' ); ?></a></li>
                            <li><a href="#"><?php esc_html_e( 'Tarjetas graficas', 'doroshopping' ); ?></a></li>
                            <li><a href="#"><?php esc_html_e( 'Memoria RAM', 'doroshopping' ); ?></a></li>
                        </ul>
                    </div>
                    <div class="mega-menu__column">
                        <img class="mega-menu__thumb" src="<?php echo esc_url( $img . '/Banner_doro_6.webp' ); ?>" alt="">
                        <h4 class="mega-menu__heading"><?php esc_html_e( 'Perifericos', 'doroshopping' ); ?></h4>
                        <ul>
                            <li><a href="#"><?php esc_html_e( 'Teclados', 'doroshopping' ); ?></a></li>
                            <li><a href="#"><?php esc_html_e( 'Ratones', 'doroshopping' ); ?></a></li>
                            <li><a href="#"><?php esc_html_e( 'Webcams', 'doroshopping' ); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="mega-menu__panel" data-panel="hogar" role="tabpanel" hidden>
                <div class="mega-menu__columns">
                    <div class="mega-menu__column">
                        <img class="mega-menu__thumb" src="<?php echo esc_url( $img . '/Banner_mundial_doro.webp' ); ?>" alt="">
                        <h4 class="mega-menu__heading"><?php esc_html_e( 'Cocina', 'doroshopping' ); ?></h4>
                        <ul>
                            <li><a href="#"><?php esc_html_e( 'Electrodomesticos', 'doroshopping' ); ?></a></li>
                            <li><a href="#"><?php esc_html_e( 'Utensilios', 'doroshopping' ); ?></a></li>
                        </ul>
                    </div>
                    <div class="mega-menu__column">
                        <img class="mega-menu__thumb" src="<?php echo esc_url( $img . '/Banner_doro_6.webp' ); ?>" alt="">
                        <h4 class="mega-menu__heading"><?php esc_html_e( 'Hogar inteligente', 'doroshopping' ); ?></h4>
                        <ul>
                            <li><a href="#"><?php esc_html_e( 'Iluminacion', 'doroshopping' ); ?></a></li>
                            <li><a href="#"><?php esc_html_e( 'Seguridad', 'doroshopping' ); ?></a></li>
                        </ul>
                    </div>
                    <div class="mega-menu__column">
                        <img class="mega-menu__thumb" src="<?php echo esc_url( $img . '/Banner_mundial_doro.webp' ); ?>" alt="">
                        <h4 class="mega-menu__heading"><?php esc_html_e( 'Gadgets', 'doroshopping' ); ?></h4>
                        <ul>
                            <li><a href="#"><?php esc_html_e( 'Novedades hogar', 'doroshopping' ); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="mega-menu__panel" data-panel="deportes" role="tabpanel" hidden>
                <div class="mega-menu__columns">
                    <div class="mega-menu__column">
                        <img class="mega-menu__thumb" src="<?php echo esc_url( $img . '/Banner_doro_6.webp' ); ?>" alt="">
                        <h4 class="mega-menu__heading"><?php esc_html_e( 'Outdoor', 'doroshopping' ); ?></h4>
                        <ul>
                            <li><a href="#"><?php esc_html_e( 'Camping', 'doroshopping' ); ?></a></li>
                            <li><a href="#"><?php esc_html_e( 'Ciclismo', 'doroshopping' ); ?></a></li>
                        </ul>
                    </div>
                    <div class="mega-menu__column">
                        <img class="mega-menu__thumb" src="<?php echo esc_url( $img . '/Banner_mundial_doro.webp' ); ?>" alt="">
                        <h4 class="mega-menu__heading"><?php esc_html_e( 'Fitness', 'doroshopping' ); ?></h4>
                        <ul>
                            <li><a href="#"><?php esc_html_e( 'Wearables', 'doroshopping' ); ?></a></li>
                            <li><a href="#"><?php esc_html_e( 'Accesorios deporte', 'doroshopping' ); ?></a></li>
                        </ul>
                    </div>
                    <div class="mega-menu__column">
                        <img class="mega-menu__thumb" src="<?php echo esc_url( $img . '/Banner_doro_6.webp' ); ?>" alt="">
                        <h4 class="mega-menu__heading"><?php esc_html_e( 'Recreacion', 'doroshopping' ); ?></h4>
                        <ul>
                            <li><a href="#"><?php esc_html_e( 'Juegos exteriores', 'doroshopping' ); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="mega-menu__panel" data-panel="promociones" role="tabpanel" hidden>
                <div class="mega-menu__columns">
                    <div class="mega-menu__column">
                        <img class="mega-menu__thumb" src="<?php echo esc_url( $img . '/Banner_mundial_doro.webp' ); ?>" alt="">
                        <h4 class="mega-menu__heading"><?php esc_html_e( 'Ofertas', 'doroshopping' ); ?></h4>
                        <ul>
                            <li><a href="#"><?php esc_html_e( 'Super Ofertas', 'doroshopping' ); ?></a></li>
                            <li><a href="#"><?php esc_html_e( 'Liquidacion', 'doroshopping' ); ?></a></li>
                        </ul>
                    </div>
                    <div class="mega-menu__column">
                        <img class="mega-menu__thumb" src="<?php echo esc_url( $img . '/Banner_doro_6.webp' ); ?>" alt="">
                        <h4 class="mega-menu__heading"><?php esc_html_e( 'Lanzamientos', 'doroshopping' ); ?></h4>
                        <ul>
                            <li><a href="#"><?php esc_html_e( 'Novedades', 'doroshopping' ); ?></a></li>
                            <li><a href="#"><?php esc_html_e( 'Productos Virales', 'doroshopping' ); ?></a></li>
                        </ul>
                    </div>
                    <div class="mega-menu__column">
                        <img class="mega-menu__thumb" src="<?php echo esc_url( $img . '/Banner_mundial_doro.webp' ); ?>" alt="">
                        <h4 class="mega-menu__heading"><?php esc_html_e( 'Reacondicionados', 'doroshopping' ); ?></h4>
                        <ul>
                            <li><a href="#"><?php esc_html_e( 'Remanufacturados', 'doroshopping' ); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
