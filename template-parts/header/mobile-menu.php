<?php
/**
 * BLUEVA mobile navigation drawer.
 *
 * @package Blueva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blueva_shop_url    = blueva_get_shop_url();
$blueva_contact_url = blueva_get_contact_url();
$blueva_cart_url    = blueva_get_cart_url();
$blueva_categories  = blueva_get_category_links();
?>
<div class="blueva-mobile-overlay" data-blueva-overlay hidden></div>

<div
	id="blueva-mobile-menu"
	class="blueva-mobile-menu"
	aria-hidden="true"
	aria-label="<?php esc_attr_e( 'Menu de navigation', 'blueva' ); ?>"
>
	<div class="blueva-mobile-menu-header">
		<span class="blueva-logo-word blueva-logo-word--sm">
			<span class="blueva-logo-dark">BLU</span><span class="blueva-logo-light">EVA</span>
		</span>
		<button
			type="button"
			class="blueva-mobile-close"
			aria-label="<?php esc_attr_e( 'Fermer le menu', 'blueva' ); ?>"
			data-blueva-close-menu
		>
			<svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true">
				<path d="M4 4L16 16M16 4L4 16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
			</svg>
		</button>
	</div>

	<nav class="blueva-mobile-nav" aria-label="<?php esc_attr_e( 'Navigation mobile', 'blueva' ); ?>">
		<a class="blueva-mobile-link" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'blueva' ); ?></a>
		<a class="blueva-mobile-link" href="<?php echo esc_url( $blueva_shop_url ); ?>"><?php esc_html_e( 'Boutique', 'blueva' ); ?></a>

		<div class="blueva-mobile-accordion">
			<button
				type="button"
				class="blueva-mobile-link blueva-mobile-accordion-toggle"
				aria-expanded="false"
				aria-controls="blueva-mobile-categories"
				data-blueva-accordion-toggle
			>
				<?php esc_html_e( 'Categories', 'blueva' ); ?>
				<svg class="blueva-chevron" width="12" height="8" viewBox="0 0 12 8" fill="none" aria-hidden="true">
					<path d="M1 1.5L6 6.5L11 1.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</button>
			<div id="blueva-mobile-categories" class="blueva-mobile-accordion-panel" data-blueva-accordion-panel hidden>
				<?php foreach ( $blueva_categories as $blueva_cat ) : ?>
					<a href="<?php echo esc_url( $blueva_cat['url'] ); ?>"><?php echo esc_html( $blueva_cat['label'] ); ?></a>
				<?php endforeach; ?>
			</div>
		</div>

		<a class="blueva-mobile-link" href="<?php echo esc_url( $blueva_contact_url ); ?>"><?php esc_html_e( 'Contact', 'blueva' ); ?></a>
		<a class="blueva-mobile-link" href="<?php echo esc_url( $blueva_cart_url ); ?>"><?php esc_html_e( 'Panier', 'blueva' ); ?></a>
	</nav>

	<div class="blueva-mobile-menu-footer blueva-small">
		<p><?php esc_html_e( 'Fabriqué en Algérie · 100% EVA', 'blueva' ); ?></p>
	</div>
</div>
