
<?php
/**
 * Theme setup: nav menu locations, supports, image sizes.
 *
 * @package Blueva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the nav menu locations BLUEVA's custom header uses.
 * Falls back to a static link list in the template if nothing is assigned,
 * so the header never renders empty for a new install.
 */
function blueva_register_menus() {
	register_nav_menus(
		array(
			'blueva-categories' => __( 'BLUEVA — Categories Dropdown', 'blueva' ),
			'blueva-mobile'     => __( 'BLUEVA — Mobile Drawer Menu', 'blueva' ),
		)
	);
}
add_action( 'after_setup_theme', 'blueva_register_menus' );

/**
 * Product-card image size used across the shop, homepage and category
 * grids so every card crops consistently regardless of the source image.
 */
function blueva_image_sizes() {
	add_image_size( 'blueva-product-card', 600, 750, true );
}
add_action( 'after_setup_theme', 'blueva_image_sizes' );

/**
 * Custom logo support — if a logo is set via Customizer > Site Identity,
 * the header template uses it; otherwise it falls back to the styled
 * text wordmark that matches the BLUEVA brand reference.
 */
function blueva_custom_logo_setup() {
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 72,
			'width'       => 220,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
}
add_action( 'after_setup_theme', 'blueva_custom_logo_setup' );

/**
 * Body classes used by the header CSS to know a custom (non-Astra-builder)
 * header is active, and whether WooCommerce is present.
 */
function blueva_body_classes( $classes ) {
	$classes[] = 'blueva-custom-header';

	if ( class_exists( 'WooCommerce' ) ) {
		$classes[] = 'blueva-woocommerce-active';
	}

	return $classes;
}
add_filter( 'body_class', 'blueva_body_classes' );
