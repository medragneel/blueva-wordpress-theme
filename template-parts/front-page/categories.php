<?php
/**
 * Front page — Categories grid (Infantil / Juvenil / Femme / Homme).
 *
 * @package Blueva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blueva_categories = blueva_get_homepage_categories();
?>
<section class="blueva-categories">
	<div class="blueva-container">
		<h2 class="blueva-heading blueva-section-heading blueva-section-heading--center">
			<?php esc_html_e( 'CATEGORIES', 'blueva' ); ?>
		</h2>

		<div class="blueva-categories-grid">
			<?php foreach ( $blueva_categories as $blueva_cat ) : ?>
				<a
					class="blueva-category-card"
					href="<?php echo esc_url( $blueva_cat['url'] ); ?>"
					<?php if ( $blueva_cat['image'] ) : ?>
						style="background-image: url('<?php echo esc_url( $blueva_cat['image'] ); ?>');"
					<?php endif; ?>
				>
					<span class="blueva-category-overlay"></span>
					<span class="blueva-category-title"><?php echo esc_html( $blueva_cat['label'] ); ?></span>
					<span class="blueva-category-arrow" aria-hidden="true">
						<svg width="18" height="18" viewBox="0 0 20 20" fill="none"><path d="M7.5 4.5 13.5 10l-6 5.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</span>
				</a>
			<?php endforeach; ?>
		</div>

		<div class="blueva-categories-cta">
			<a class="blueva-btn blueva-btn-outline-dark" href="<?php echo esc_url( blueva_get_shop_url() ); ?>">
				<?php esc_html_e( 'EXPLORE MORE', 'blueva' ); ?>
			</a>
		</div>
	</div>
</section>
