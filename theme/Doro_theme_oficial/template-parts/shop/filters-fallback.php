<?php
/**
 * Fallback filters sidebar for shop (URLs reales WooCommerce)
 *
 * @package Doroshopping
 */

$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
$base_url = is_product_taxonomy() ? get_term_link( get_queried_object() ) : $shop_url;
if ( is_wp_error( $base_url ) ) {
	$base_url = $shop_url;
}

/**
 * Conserva filtros actuales al cambiar uno (precio, atributo, etc.).
 *
 * @param string $url Base.
 * @return string
 */
$doroshopping_filter_base = static function ( $url ) {
	$keep = array();
	if ( empty( $_GET ) || ! is_array( $_GET ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return $url;
	}
	foreach ( $_GET as $key => $value ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$key = sanitize_key( (string) $key );
		if ( '' === $key ) {
			continue;
		}
		if ( ! preg_match( '/^(filter_|min_price|max_price|min_rating|orderby|on_sale)/', $key ) ) {
			continue;
		}
		if ( is_array( $value ) ) {
			continue;
		}
		$keep[ $key ] = wc_clean( wp_unslash( $value ) );
	}
	return $keep ? add_query_arg( $keep, $url ) : $url;
};

$base_url = $doroshopping_filter_base( $base_url );

$current_term_id   = 0;
$current_ancestors = array();
if ( is_product_category() ) {
	$qo = get_queried_object();
	if ( $qo && ! empty( $qo->term_id ) ) {
		$current_term_id   = (int) $qo->term_id;
		$current_ancestors = array_map( 'intval', get_ancestors( $current_term_id, 'product_cat' ) );
	}
}

$exclude_ids = array();
if ( taxonomy_exists( 'product_cat' ) ) {
	foreach ( array( 'uncategorized', 'sin-categorizar' ) as $uncat_slug ) {
		$uncat = get_term_by( 'slug', $uncat_slug, 'product_cat' );
		if ( $uncat && ! is_wp_error( $uncat ) ) {
			$exclude_ids[] = (int) $uncat->term_id;
		}
	}
}

/**
 * IDs de productos del contexto actual (categoría/taxonomía) para no listar filtros vacíos.
 *
 * @return int[]|null null = sin restringir (tienda general).
 */
$context_product_ids = null;
if ( is_product_taxonomy() ) {
	$qo = get_queried_object();
	if ( $qo && ! empty( $qo->term_id ) && ! empty( $qo->taxonomy ) ) {
		$context_product_ids = get_posts(
			array(
				'post_type'              => 'product',
				'post_status'            => 'publish',
				'posts_per_page'         => -1,
				'fields'                 => 'ids',
				'no_found_rows'          => true,
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
				'tax_query'              => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
					array(
						'taxonomy'         => $qo->taxonomy,
						'field'            => 'term_id',
						'terms'            => array( (int) $qo->term_id ),
						'include_children' => true,
					),
				),
			)
		);
		if ( ! is_array( $context_product_ids ) ) {
			$context_product_ids = array();
		}
	}
}

$categories = array();
if ( taxonomy_exists( 'product_cat' ) ) {
	$categories = get_terms(
		array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => true,
			'parent'     => 0,
			'exclude'    => $exclude_ids,
			'number'     => 0,
			'orderby'    => 'name',
			'order'      => 'ASC',
		)
	);
	if ( is_wp_error( $categories ) ) {
		$categories = array();
	}
	$categories = array_values(
		array_filter(
			$categories,
			static function ( $term ) {
				$slug = strtolower( (string) $term->slug );
				$name = strtolower( (string) $term->name );
				if ( preg_match( '/^(uncategorized|sin[-_]?categor|non[-_]?class|unkategor)/', $slug ) ) {
					return false;
				}
				if ( false !== strpos( $name, 'sin categoriz' ) || 'uncategorized' === $name ) {
					return false;
				}
				return (int) $term->count > 0;
			}
		)
	);
}

$doroshopping_cat_is_open = static function ( $term, $current_id, $ancestors ) {
	$tid = (int) $term->term_id;
	if ( $current_id === $tid ) {
		return true;
	}
	return in_array( $tid, $ancestors, true );
};

$price_ranges = array(
	array( 'label' => __( 'Hasta 20 EUR', 'doroshopping' ), 'min' => 0, 'max' => 20 ),
	array( 'label' => __( '20 - 50 EUR', 'doroshopping' ), 'min' => 20, 'max' => 50 ),
	array( 'label' => __( '50 - 100 EUR', 'doroshopping' ), 'min' => 50, 'max' => 100 ),
	array( 'label' => __( 'Mas de 100 EUR', 'doroshopping' ), 'min' => 100, 'max' => '' ),
);

$current_min    = isset( $_GET['min_price'] ) ? wc_clean( wp_unslash( $_GET['min_price'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$current_max    = isset( $_GET['max_price'] ) ? wc_clean( wp_unslash( $_GET['max_price'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$current_rating = isset( $_GET['min_rating'] ) ? absint( $_GET['min_rating'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
?>

<div class="doro-shop__widget" data-doro-filter-widget data-filter-label="<?php esc_attr_e( 'Categorías', 'doroshopping' ); ?>">
	<h3 class="doro-shop__widget-title"><?php esc_html_e( 'Categorías', 'doroshopping' ); ?></h3>
	<ul class="doro-shop__filter-list doro-shop__filter-list--cats">
		<li class="doro-shop__cat-item">
			<a href="<?php echo esc_url( $shop_url ); ?>" class="<?php echo ! $current_term_id ? 'is-active' : ''; ?>"<?php echo ! $current_term_id ? ' aria-current="page"' : ''; ?>>
				<?php esc_html_e( 'Todas las categorías', 'doroshopping' ); ?>
			</a>
		</li>

		<?php if ( ! empty( $categories ) ) : ?>
			<?php foreach ( $categories as $category ) : ?>
				<?php
				$children = get_terms(
					array(
						'taxonomy'   => 'product_cat',
						'hide_empty' => true,
						'parent'     => (int) $category->term_id,
						'orderby'    => 'name',
						'order'      => 'ASC',
					)
				);
				if ( is_wp_error( $children ) ) {
					$children = array();
				}
				$children = array_values(
					array_filter(
						$children,
						static function ( $t ) {
							return (int) $t->count > 0;
						}
					)
				);
				$has_children = ! empty( $children );
				$is_current   = $current_term_id === (int) $category->term_id;
				$is_open      = $has_children && $doroshopping_cat_is_open( $category, $current_term_id, $current_ancestors );
				$panel_id     = 'doro-shop-cat-' . (int) $category->term_id;
				$cat_link     = get_term_link( $category );
				if ( is_wp_error( $cat_link ) ) {
					continue;
				}
				?>
				<li class="doro-shop__cat-item<?php echo $has_children ? ' has-children' : ''; ?><?php echo $is_open ? ' is-open' : ''; ?>">
					<div class="doro-shop__cat-row">
						<a
							href="<?php echo esc_url( $cat_link ); ?>"
							class="doro-shop__cat-link<?php echo $is_current ? ' is-active' : ''; ?>"
							<?php echo $is_current ? ' aria-current="page"' : ''; ?>
						>
							<span class="doro-shop__cat-name"><?php echo esc_html( $category->name ); ?></span>
							<span class="doro-shop__cat-count">(<?php echo esc_html( (string) $category->count ); ?>)</span>
						</a>
						<?php if ( $has_children ) : ?>
							<button
								type="button"
								class="doro-shop__cat-toggle"
								data-doro-cat-toggle
								aria-expanded="<?php echo $is_open ? 'true' : 'false'; ?>"
								aria-controls="<?php echo esc_attr( $panel_id ); ?>"
								aria-label="<?php echo esc_attr( sprintf( __( 'Mostrar subcategorías de %s', 'doroshopping' ), $category->name ) ); ?>"
							>
								<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
							</button>
						<?php endif; ?>
					</div>

					<?php if ( $has_children ) : ?>
						<ul
							id="<?php echo esc_attr( $panel_id ); ?>"
							class="doro-shop__subcats"
							<?php echo $is_open ? '' : ' hidden'; ?>
						>
							<?php foreach ( $children as $child ) : ?>
								<?php
								$child_current = $current_term_id === (int) $child->term_id;
								$grandchildren = get_terms(
									array(
										'taxonomy'   => 'product_cat',
										'hide_empty' => true,
										'parent'     => (int) $child->term_id,
										'orderby'    => 'name',
										'order'      => 'ASC',
									)
								);
								if ( is_wp_error( $grandchildren ) ) {
									$grandchildren = array();
								}
								$grandchildren = array_values(
									array_filter(
										$grandchildren,
										static function ( $t ) {
											return (int) $t->count > 0;
										}
									)
								);
								$child_has   = ! empty( $grandchildren );
								$child_open  = $child_has && ( $child_current || in_array( (int) $child->term_id, $current_ancestors, true ) );
								$child_panel = 'doro-shop-cat-' . (int) $child->term_id;
								$child_link  = get_term_link( $child );
								if ( is_wp_error( $child_link ) ) {
									continue;
								}
								?>
								<li class="doro-shop__cat-item doro-shop__cat-item--child<?php echo $child_has ? ' has-children' : ''; ?><?php echo $child_open ? ' is-open' : ''; ?>">
									<div class="doro-shop__cat-row">
										<a
											href="<?php echo esc_url( $child_link ); ?>"
											class="doro-shop__cat-link<?php echo $child_current ? ' is-active' : ''; ?>"
											<?php echo $child_current ? ' aria-current="page"' : ''; ?>
										>
											<span class="doro-shop__cat-name"><?php echo esc_html( $child->name ); ?></span>
											<span class="doro-shop__cat-count">(<?php echo esc_html( (string) $child->count ); ?>)</span>
										</a>
										<?php if ( $child_has ) : ?>
											<button
												type="button"
												class="doro-shop__cat-toggle"
												data-doro-cat-toggle
												aria-expanded="<?php echo $child_open ? 'true' : 'false'; ?>"
												aria-controls="<?php echo esc_attr( $child_panel ); ?>"
												aria-label="<?php echo esc_attr( sprintf( __( 'Mostrar subcategorías de %s', 'doroshopping' ), $child->name ) ); ?>"
											>
												<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
											</button>
										<?php endif; ?>
									</div>
									<?php if ( $child_has ) : ?>
										<ul
											id="<?php echo esc_attr( $child_panel ); ?>"
											class="doro-shop__subcats doro-shop__subcats--nested"
											<?php echo $child_open ? '' : ' hidden'; ?>
										>
											<?php foreach ( $grandchildren as $gchild ) : ?>
												<?php
												$g_current = $current_term_id === (int) $gchild->term_id;
												$g_link    = get_term_link( $gchild );
												if ( is_wp_error( $g_link ) ) {
													continue;
												}
												?>
												<li class="doro-shop__cat-item doro-shop__cat-item--grand">
													<a
														href="<?php echo esc_url( $g_link ); ?>"
														class="doro-shop__cat-link<?php echo $g_current ? ' is-active' : ''; ?>"
														<?php echo $g_current ? ' aria-current="page"' : ''; ?>
													>
														<span class="doro-shop__cat-name"><?php echo esc_html( $gchild->name ); ?></span>
														<span class="doro-shop__cat-count">(<?php echo esc_html( (string) $gchild->count ); ?>)</span>
													</a>
												</li>
											<?php endforeach; ?>
										</ul>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		<?php else : ?>
			<li><a href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Ver todos los productos', 'doroshopping' ); ?></a></li>
		<?php endif; ?>
	</ul>
</div>

<?php
$attribute_taxonomies = function_exists( 'wc_get_attribute_taxonomies' ) ? wc_get_attribute_taxonomies() : array();

if ( ! empty( $attribute_taxonomies ) && ( null === $context_product_ids || ! empty( $context_product_ids ) ) ) {
	foreach ( $attribute_taxonomies as $tax ) {
		$attr_name = $tax->attribute_name;
		$taxonomy  = function_exists( 'wc_attribute_taxonomy_name' ) ? wc_attribute_taxonomy_name( $attr_name ) : 'pa_' . $attr_name;
		if ( ! taxonomy_exists( $taxonomy ) ) {
			continue;
		}

		$term_args = array(
			'taxonomy'   => $taxonomy,
			'hide_empty' => true,
			'orderby'    => 'name',
			'order'      => 'ASC',
			'number'     => 40,
		);
		// En categoría: solo términos usados por productos de esa categoría.
		if ( is_array( $context_product_ids ) ) {
			$term_args['object_ids'] = $context_product_ids;
		}

		$terms = get_terms( $term_args );
		if ( empty( $terms ) || is_wp_error( $terms ) ) {
			continue;
		}

		$terms = array_values(
			array_filter(
				$terms,
				static function ( $term ) {
					return (int) $term->count > 0;
				}
			)
		);
		if ( empty( $terms ) ) {
			continue;
		}

		$filter_key     = 'filter_' . sanitize_title( $attr_name );
		$current_filter = isset( $_GET[ $filter_key ] ) ? sanitize_title( wp_unslash( $_GET[ $filter_key ] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$label          = ! empty( $tax->attribute_label ) ? $tax->attribute_label : ucfirst( str_replace( array( '-', '_' ), ' ', $attr_name ) );
		$slug_l         = strtolower( $attr_name . ' ' . $label );
		$is_color       = (bool) preg_match( '/color|colour|couleur|farbe|colore/', $slug_l );
		$is_size        = (bool) preg_match( '/size|talla|taille|größe|grosse|taglia|medida/', $slug_l );
		$list_class     = 'doro-shop__filter-list';
		if ( $is_color ) {
			$list_class .= ' doro-shop__filter-list--colors';
		} elseif ( $is_size ) {
			$list_class .= ' doro-shop__filter-list--sizes';
		}
		?>
		<div class="doro-shop__widget" data-doro-filter-widget data-filter-label="<?php echo esc_attr( $label ); ?>">
			<h3 class="doro-shop__widget-title"><?php echo esc_html( $label ); ?></h3>
			<ul class="<?php echo esc_attr( $list_class ); ?>">
				<?php foreach ( $terms as $term ) : ?>
					<?php
					$url       = add_query_arg( $filter_key, $term->slug, remove_query_arg( $filter_key, $base_url ) );
					$is_active = $current_filter === $term->slug;
					$swatch    = '';
					if ( $is_color ) {
						$hex = get_term_meta( $term->term_id, 'product_attribute_color', true );
						if ( ! $hex ) {
							$hex = get_term_meta( $term->term_id, 'color', true );
						}
						if ( ! $hex && preg_match( '/^#?[0-9a-f]{3,6}$/i', $term->slug ) ) {
							$hex = $term->slug;
						}
						if ( $hex && '#' !== substr( (string) $hex, 0, 1 ) ) {
							$hex = '#' . ltrim( (string) $hex, '#' );
						}
						if ( $hex && preg_match( '/^#[0-9a-f]{3,6}$/i', $hex ) ) {
							$swatch = $hex;
						}
					}
					?>
					<li>
						<a
							href="<?php echo esc_url( $url ); ?>"
							class="<?php echo $is_active ? 'is-active' : ''; ?><?php echo $is_color ? ' doro-shop__color-swatch' : ''; ?><?php echo $is_size ? ' doro-shop__size-chip' : ''; ?>"
							<?php echo $is_active ? ' aria-current="true"' : ''; ?>
							title="<?php echo esc_attr( $term->name ); ?>"
						>
							<?php if ( $is_color ) : ?>
								<span
									class="doro-shop__color-dot"
									<?php echo $swatch ? ' style="background:' . esc_attr( $swatch ) . ';"' : ''; ?>
									aria-hidden="true"
								></span>
								<span class="doro-shop__color-label"><?php echo esc_html( $term->name ); ?></span>
								<span class="doro-shop__cat-count">(<?php echo esc_html( (string) $term->count ); ?>)</span>
							<?php else : ?>
								<span class="doro-shop__cat-name"><?php echo esc_html( $term->name ); ?></span>
								<span class="doro-shop__cat-count">(<?php echo esc_html( (string) $term->count ); ?>)</span>
							<?php endif; ?>
						</a>
					</li>
				<?php endforeach; ?>
				<?php if ( $current_filter ) : ?>
					<li>
						<a href="<?php echo esc_url( remove_query_arg( $filter_key, $base_url ) ); ?>">
							<?php
							echo esc_html( sprintf( __( 'Quitar filtro de %s', 'doroshopping' ), $label ) );
							?>
						</a>
					</li>
				<?php endif; ?>
			</ul>
		</div>
		<?php
	}
}
?>

<div class="doro-shop__widget" data-doro-filter-widget data-filter-label="<?php esc_attr_e( 'Precio', 'doroshopping' ); ?>">
	<h3 class="doro-shop__widget-title"><?php esc_html_e( 'Precio', 'doroshopping' ); ?></h3>
	<ul class="doro-shop__filter-list">
		<?php foreach ( $price_ranges as $range ) : ?>
			<?php
			$price_base = remove_query_arg( array( 'min_price', 'max_price' ), $base_url );
			$args       = array();
			if ( '' !== $range['min'] && null !== $range['min'] ) {
				$args['min_price'] = $range['min'];
			}
			if ( '' !== $range['max'] && null !== $range['max'] ) {
				$args['max_price'] = $range['max'];
			}
			$url       = add_query_arg( $args, $price_base );
			$is_active = (string) $current_min === (string) $range['min']
				&& (string) $current_max === (string) $range['max'];
			?>
			<li>
				<a href="<?php echo esc_url( $url ); ?>"<?php echo $is_active ? ' aria-current="true" class="is-active"' : ''; ?>>
					<?php echo esc_html( $range['label'] ); ?>
				</a>
			</li>
		<?php endforeach; ?>
		<?php if ( $current_min !== '' || $current_max !== '' ) : ?>
			<li><a href="<?php echo esc_url( remove_query_arg( array( 'min_price', 'max_price' ), $base_url ) ); ?>"><?php esc_html_e( 'Quitar filtro de precio', 'doroshopping' ); ?></a></li>
		<?php endif; ?>
	</ul>
</div>

<div class="doro-shop__widget" data-doro-filter-widget data-filter-label="<?php esc_attr_e( 'Valoración', 'doroshopping' ); ?>">
	<h3 class="doro-shop__widget-title"><?php esc_html_e( 'Valoración', 'doroshopping' ); ?></h3>
	<ul class="doro-shop__filter-list">
		<?php foreach ( array( 4, 3 ) as $stars ) : ?>
			<?php
			$url       = add_query_arg( 'min_rating', $stars, remove_query_arg( 'min_rating', $base_url ) );
			$is_active = $current_rating === $stars;
			?>
			<li>
				<a href="<?php echo esc_url( $url ); ?>"<?php echo $is_active ? ' aria-current="true" class="is-active"' : ''; ?>>
					<?php
					echo esc_html( sprintf( __( '%d estrellas o más', 'doroshopping' ), $stars ) );
					?>
				</a>
			</li>
		<?php endforeach; ?>
		<?php if ( $current_rating ) : ?>
			<li><a href="<?php echo esc_url( remove_query_arg( 'min_rating', $base_url ) ); ?>"><?php esc_html_e( 'Quitar filtro de valoración', 'doroshopping' ); ?></a></li>
		<?php endif; ?>
	</ul>
</div>
