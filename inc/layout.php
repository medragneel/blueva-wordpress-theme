<?php
/**
 * Layout control.
 *
 * BLUEVA's templates (front page, and later shop/cart/checkout) are
 * fully custom and manage their own width via .blueva-container, so
 * Astra's own boxed content wrapper (.ast-container, with its own
 * max-width and padding) needs to get out of the way rather than
 * double-constrain everything.
 *
 * Astra has a built-in "Page Builder" content layout made exactly for
 * this (used for Elementor/Beaver Builder canvas templates): it adds
 * the `ast-page-builder-template` body class and removes .ast-container's
 * max-width/padding via Astra's own CSS. Using Astra's own mechanism
 * here is more robust than overriding its container with !important CSS.
 *
 * @package Blueva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Pages/templates that should render full-width, edge-to-edge.
 */
function blueva_uses_full_width_layout() {
	return is_front_page();
}

/**
 * Force Astra's "page-builder" (full width, no padding) content layout
 * on the pages above.
 */
function blueva_force_full_width_layout( $layout ) {
	if ( blueva_uses_full_width_layout() ) {
		return 'page-builder';
	}
	return $layout;
}
add_filter( 'astra_get_content_layout', 'blueva_force_full_width_layout' );
