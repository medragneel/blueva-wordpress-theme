
<?php
/**
 * BLUEVA child theme functions.
 *
 * Astra child theme. Extends the Astra parent theme without modifying it,
 * so parent theme updates remain safe.
 *
 * @package Blueva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'BLUEVA_VERSION', '1.3.2' );
define( 'BLUEVA_DIR', get_stylesheet_directory() );
define( 'BLUEVA_URI', get_stylesheet_directory_uri() );

/**
 * Load modular includes.
 * Each phase of the build adds its include here; nothing is ever dumped
 * directly into this file.
 */
require_once BLUEVA_DIR . '/inc/setup.php';
require_once BLUEVA_DIR . '/inc/layout.php';
require_once BLUEVA_DIR . '/inc/enqueue.php';
require_once BLUEVA_DIR . '/inc/customizer.php';
require_once BLUEVA_DIR . '/inc/header.php';
require_once BLUEVA_DIR . '/inc/footer.php';
<<<<<<< HEAD

/**
 * Phases not yet implemented (front page, shop, cart, checkout, contact,
 * b2b) will each add their own inc/*.php include here, in order, once
 * built — so this file stays a stable manifest of what exists.
=======
require_once BLUEVA_DIR . '/inc/front-page.php';

/**
 * Phases not yet implemented (shop, cart, checkout, contact, b2b) will
 * each add their own inc/*.php include here, in order, once built — so
 * this file stays a stable manifest of what exists.
>>>>>>> front-page
 */
