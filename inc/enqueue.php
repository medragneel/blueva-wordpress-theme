
<?php
/**
 * Enqueue styles and scripts.
 *
 * @package Blueva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function blueva_enqueue_assets() {
	$parent_style = 'astra-theme-css';

	// Parent Astra stylesheet.
	wp_enqueue_style(
		$parent_style,
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme( 'astra' ) ? wp_get_theme( get_template() )->get( 'Version' ) : BLUEVA_VERSION
	);

	// Child stylesheet — design system tokens + base typography.
	wp_enqueue_style(
		'blueva-style',
		get_stylesheet_uri(),
		array( $parent_style ),
		BLUEVA_VERSION
	);

	// Brand fonts. Loaded from Google Fonts only (display + body faces
	// used across the whole design system, not just the header).
	wp_enqueue_style(
		'blueva-fonts',
		'https://fonts.googleapis.com/css2?family=Anton&family=Poppins:wght@400;500;600;700;800&display=swap',
		array(),
		null
	);

	// Header component styles.
	wp_enqueue_style(
		'blueva-header',
		BLUEVA_URI . '/assets/css/header.css',
		array( 'blueva-style' ),
		BLUEVA_VERSION
	);

	// Header interactions: mobile drawer, sticky bar, dropdown, search toggle.
	wp_enqueue_script(
		'blueva-header',
		BLUEVA_URI . '/assets/js/header.js',
		array(),
		BLUEVA_VERSION,
		true
	);

	// Footer component styles.
	wp_enqueue_style(
		'blueva-footer',
		BLUEVA_URI . '/assets/css/footer.css',
		array( 'blueva-style' ),
		BLUEVA_VERSION
	);

	// Footer scroll-reveal (progressive enhancement, see assets/js/footer.js).
	wp_enqueue_script(
		'blueva-footer',
		BLUEVA_URI . '/assets/js/footer.js',
		array(),
		BLUEVA_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'blueva_enqueue_assets' );
