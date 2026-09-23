<?php
/**
 * Shop/category filter bar: search + Prix (price bands) + Couleurs.
 *
 * Uses native <details>/<summary> for the dropdowns so they open/close
 * and are keyboard/screen-reader accessible with zero JavaScript;
 * assets/js/shop.js only adds polish (closing siblings, outside-click).
 *
 * @package Blueva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blueva_price_bands    = blueva_get_price_filter_bands();
$blueva_color_options  = blueva_get_color_filter_options();
$blueva_size_options   = blueva_get_size_filter_options();
$blueva_cat_options    = blueva_get_category_filter_options();
$blueva_current_min    = isset( $_GET['blueva_min_price'] ) ? sanitize_text_field( wp_unslash( $_GET['blueva_min_price'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$blueva_current_max    = isset( $_GET['blueva_max_price'] ) ? sanitize_text_field( wp_unslash( $_GET['blueva_max_price'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$blueva_current_colors = isset( $_GET['color'] ) ? array_map( 'sanitize_title', (array) $_GET['color'] ) : array(); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$blueva_current_sizes  = isset( $_GET['size'] ) ? array_map( 'sanitize_title', (array) $_GET['size'] ) : array(); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$blueva_current_cats   = isset( $_GET['cat_filter'] ) ? array_map( 'sanitize_title', (array) $_GET['cat_filter'] ) : array(); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$blueva_current_search = get_search_query();

$blueva_price_active = ( '' !== $blueva_current_min || '' !== $blueva_current_max );
?>
<div class="blueva-shop-filters">
	<form class="blueva-shop-filters-form" method="get" action="<?php echo esc_url( is_search() ? home_url( '/' ) : '' ); ?>">

		<div class="blueva-filter-search">
			<label class="screen-reader-text" for="blueva-shop-search"><?php esc_html_e( 'Rechercher', 'blueva' ); ?></label>
			<input
				id="blueva-shop-search"
				type="search"
				name="s"
				value="<?php echo esc_attr( $blueva_current_search ); ?>"
				placeholder="<?php esc_attr_e( 'Search...', 'blueva' ); ?>"
				autocomplete="off"
			/>
			<input type="hidden" name="post_type" value="product" />
			<button type="submit" aria-label="<?php esc_attr_e( 'Rechercher', 'blueva' ); ?>">
				<svg width="18" height="18" viewBox="0 0 18 18" fill="none" aria-hidden="true"><circle cx="8" cy="8" r="6.25" stroke="currentColor" stroke-width="1.6"/><path d="M17 17L12.7 12.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
			</button>
		</div>

		<div class="blueva-filter-pills">
			<details class="blueva-filter-dropdown" data-blueva-filter-dropdown>
				<summary class="blueva-filter-pill<?php echo $blueva_price_active ? ' is-active' : ''; ?>">
					<?php esc_html_e( 'Prix', 'blueva' ); ?>
					<svg class="blueva-chevron" width="12" height="8" viewBox="0 0 12 8" fill="none" aria-hidden="true"><path d="M1 1.5L6 6.5L11 1.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
				</summary>
				<div class="blueva-filter-panel">
					<label class="blueva-filter-option">
						<input type="radio" name="price_band" value="" <?php checked( ! $blueva_price_active ); ?> />
						<?php esc_html_e( 'Tous les prix', 'blueva' ); ?>
					</label>
					<?php foreach ( $blueva_price_bands as $blueva_band ) : ?>
						<?php $blueva_is_checked = ( $blueva_current_min === $blueva_band['min'] && $blueva_current_max === $blueva_band['max'] ); ?>
						<label class="blueva-filter-option">
							<input
								type="radio"
								name="price_band"
								value="<?php echo esc_attr( $blueva_band['min'] . '-' . $blueva_band['max'] ); ?>"
								data-min="<?php echo esc_attr( $blueva_band['min'] ); ?>"
								data-max="<?php echo esc_attr( $blueva_band['max'] ); ?>"
								<?php checked( $blueva_is_checked ); ?>
							/>
							<?php echo esc_html( $blueva_band['label'] ); ?>
						</label>
					<?php endforeach; ?>
					<input type="hidden" name="blueva_min_price" value="<?php echo esc_attr( $blueva_current_min ); ?>" data-blueva-min-price />
					<input type="hidden" name="blueva_max_price" value="<?php echo esc_attr( $blueva_current_max ); ?>" data-blueva-max-price />
					<button type="submit" class="blueva-filter-apply"><?php esc_html_e( 'Appliquer', 'blueva' ); ?></button>
				</div>
			</details>

			<?php if ( ! empty( $blueva_color_options ) ) : ?>
				<details class="blueva-filter-dropdown" data-blueva-filter-dropdown>
					<summary class="blueva-filter-pill<?php echo ! empty( $blueva_current_colors ) ? ' is-active' : ''; ?>">
						<?php esc_html_e( 'Couleurs', 'blueva' ); ?>
						<svg class="blueva-chevron" width="12" height="8" viewBox="0 0 12 8" fill="none" aria-hidden="true"><path d="M1 1.5L6 6.5L11 1.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</summary>
					<div class="blueva-filter-panel">
						<?php foreach ( $blueva_color_options as $blueva_color ) : ?>
							<label class="blueva-filter-option blueva-filter-option--color">
								<input
									type="checkbox"
									name="color[]"
									value="<?php echo esc_attr( $blueva_color['slug'] ); ?>"
									<?php checked( in_array( $blueva_color['slug'], $blueva_current_colors, true ) ); ?>
								/>
								<span
									class="blueva-swatch"
									<?php if ( $blueva_color['color'] ) : ?>
										style="background-color: <?php echo esc_attr( $blueva_color['color'] ); ?>;"
									<?php endif; ?>
								></span>
								<?php echo esc_html( $blueva_color['name'] ); ?>
							</label>
						<?php endforeach; ?>
						<button type="submit" class="blueva-filter-apply"><?php esc_html_e( 'Appliquer', 'blueva' ); ?></button>
					</div>
				</details>
			<?php endif; ?>

			<?php if ( ! empty( $blueva_size_options ) ) : ?>
				<details class="blueva-filter-dropdown" data-blueva-filter-dropdown>
					<summary class="blueva-filter-pill<?php echo ! empty( $blueva_current_sizes ) ? ' is-active' : ''; ?>">
						<?php esc_html_e( 'Tailles', 'blueva' ); ?>
						<svg class="blueva-chevron" width="12" height="8" viewBox="0 0 12 8" fill="none" aria-hidden="true"><path d="M1 1.5L6 6.5L11 1.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</summary>
					<div class="blueva-filter-panel">
						<?php foreach ( $blueva_size_options as $blueva_size ) : ?>
							<label class="blueva-filter-option">
								<input
									type="checkbox"
									name="size[]"
									value="<?php echo esc_attr( $blueva_size['slug'] ); ?>"
									<?php checked( in_array( $blueva_size['slug'], $blueva_current_sizes, true ) ); ?>
								/>
								<?php echo esc_html( $blueva_size['name'] ); ?>
							</label>
						<?php endforeach; ?>
						<button type="submit" class="blueva-filter-apply"><?php esc_html_e( 'Appliquer', 'blueva' ); ?></button>
					</div>
				</details>
			<?php endif; ?>

			<?php if ( ! empty( $blueva_cat_options ) ) : ?>
				<details class="blueva-filter-dropdown" data-blueva-filter-dropdown>
					<summary class="blueva-filter-pill<?php echo ! empty( $blueva_current_cats ) ? ' is-active' : ''; ?>">
						<?php esc_html_e( 'Catégories', 'blueva' ); ?>
						<svg class="blueva-chevron" width="12" height="8" viewBox="0 0 12 8" fill="none" aria-hidden="true"><path d="M1 1.5L6 6.5L11 1.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</summary>
					<div class="blueva-filter-panel">
						<?php foreach ( $blueva_cat_options as $blueva_cat ) : ?>
							<label class="blueva-filter-option">
								<input
									type="checkbox"
									name="cat_filter[]"
									value="<?php echo esc_attr( $blueva_cat['slug'] ); ?>"
									<?php checked( in_array( $blueva_cat['slug'], $blueva_current_cats, true ) ); ?>
								/>
								<?php echo esc_html( $blueva_cat['name'] ); ?>
							</label>
						<?php endforeach; ?>
						<button type="submit" class="blueva-filter-apply"><?php esc_html_e( 'Appliquer', 'blueva' ); ?></button>
					</div>
				</details>
			<?php endif; ?>
		</div>
	</form>
</div>
