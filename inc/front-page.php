<?php
/**
 * PHASE 3 — Front page (homepage).
 *
 * Helpers used by front-page.php and its template-parts. Assets are only
 * enqueued on the front page itself, not site-wide.
 *
 * @package Blueva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue homepage-only styles/scripts.
 */
function blueva_front_page_assets() {
	if ( ! is_front_page() ) {
		return;
	}

	wp_enqueue_style(
		'blueva-front-page',
		BLUEVA_URI . '/assets/css/front-page.css',
		array( 'blueva-style' ),
		BLUEVA_VERSION
	);

	wp_enqueue_script(
		'blueva-front-page',
		BLUEVA_URI . '/assets/js/front-page.js',
		array(),
		BLUEVA_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'blueva_front_page_assets' );

/**
 * Products for the two "Nouvelle Collection" carousels.
 *
 * $context is 'featured' (top carousel, right after the hero — WooCommerce
 * "featured" products, the site owner's own curation via Quick Edit /
 * Catalog visibility) or 'new' (lower carousel — most recently published
 * products). Both fall back to the newest published products so the
 * section is never empty on a fresh install with nothing marked featured.
 *
 * @param string $context 'featured' or 'new'.
 * @param int    $limit   Max products to pull.
 * @return WP_Query|null Null when WooCommerce isn't active.
 */
function blueva_get_carousel_products( $context = 'new', $limit = 8 ) {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return null;
	}

	$args = array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => $limit,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'no_found_rows'  => true,
	);

	if ( 'featured' === $context ) {
		$args['tax_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
			array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'featured',
			),
		);
	}

	$query = new WP_Query( $args );

	// No featured products set yet? Fall back to newest products rather
	// than rendering an empty section.
	if ( 'featured' === $context && ! $query->have_posts() ) {
		unset( $args['tax_query'] );
		$query = new WP_Query( $args );
	}

	return $query;
}

/**
 * The four BLUEVA product lines for the homepage category grid, each
 * resolved to a real product_cat term (image + link) when it exists.
 * Order and labels match the brand's category structure used in the
 * header/footer ("Infantils"/"Juveniles" there are the same lines shown
 * here as "Infantil"/"Juvenil" per the homepage design reference).
 *
 * @return array<int, array{label: string, url: string, image: string}>
 */
function blueva_get_homepage_categories() {
	$categories = array(
		'INFANTIL' => array( 'infantils', 'infantil' ),
		'JUVENIL'  => array( 'juvenil', 'juvenils', 'juveniles', 'juvenile' ),
		'FEMME'    => array( 'femmes' ),
		'HOMME'    => array( 'hommes' ),
	);

	$cards = array();

	foreach ( $categories as $label => $slugs ) {
		$url   = '';
		$image = '';

		if ( taxonomy_exists( 'product_cat' ) ) {
			foreach ( $slugs as $slug ) {
				$term = get_term_by( 'slug', $slug, 'product_cat' );
				if ( $term && ! is_wp_error( $term ) ) {
					$url            = get_term_link( $term );
					$thumbnail_id   = get_term_meta( $term->term_id, 'thumbnail_id', true );
					$image          = $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, 'large' ) : '';
					break;
				}
			}
		}

		if ( ! $url ) {
			$url = home_url( '/product-category/' . $slugs[0] . '/' );
		}

		$cards[] = array(
			'label' => $label,
			'url'   => $url,
			'image' => $image,
		);
	}

	return $cards;
}

/**
 * Repeating marquee phrases. Editable via Customizer so the site owner
 * can adjust brand messaging without touching code; defaults to the
 * exact BLUEVA brand messaging from the brief.
 *
 * @return array<int, string>
 */
function blueva_get_marquee_items() {
	$default = implode(
		' , ',
		array(
			__( '100% EVA', 'blueva' ),
			__( 'Fabriqué en Algérie', 'blueva' ),
			__( 'Léger', 'blueva' ),
			__( 'Durable', 'blueva' ),
			__( 'Personnalisable', 'blueva' ),
			__( 'Livraison vers les wilayas', 'blueva' ),
			__( 'Paiement à la livraison', 'blueva' ),
		)
	);

	$text = get_theme_mod( 'blueva_marquee_text', $default );

	return array_map( 'trim', explode( ',', $text ) );
}
