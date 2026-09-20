<?php
/**
 * PHASE 1 — Header.
 *
 * Astra's own header is produced by its Header Builder (a set of actions
 * hooked to `astra_header`, several of them bound to class instances).
 * Unhooking those individually is fragile across Astra updates, so instead
 * BLUEVA renders its own header markup earlier in the page — on
 * `wp_body_open`, which fires immediately after <body> and before Astra's
 * `#page` wrapper — and hides Astra's generated masthead with CSS
 * (see assets/css/header.css, `.blueva-custom-header #masthead`).
 *
 * This keeps the parent theme completely untouched and update-safe while
 * giving BLUEVA full control of header markup and behaviour.
 *
 * @package Blueva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Output the BLUEVA header (announcement bar + primary nav + mobile drawer).
 */
function blueva_render_header() {
	get_template_part( 'template-parts/header/site-header' );
}
add_action( 'wp_body_open', 'blueva_render_header', 5 );

/**
 * Helpers used by the header template. Kept here, not inline in the
 * template, so the markup file stays readable.
 */

/**
 * URL for the "Boutique" link — the WooCommerce shop page when
 * WooCommerce is active, otherwise the site home as a safe fallback.
 */
function blueva_get_shop_url() {
	if ( function_exists( 'wc_get_page_permalink' ) ) {
		$url = wc_get_page_permalink( 'shop' );
		if ( $url ) {
			return $url;
		}
	}
	return home_url( '/' );
}

/**
 * URL for the Contact link. Looks for a published page with slug
 * "contact" (the Phase 7 Contact page) before falling back to "#".
 */
function blueva_get_contact_url() {
	$page = get_page_by_path( 'contact' );
	if ( $page ) {
		return get_permalink( $page );
	}
	return '#';
}

/**
 * URL for the cart icon.
 */
function blueva_get_cart_url() {
	if ( function_exists( 'wc_get_cart_url' ) ) {
		return wc_get_cart_url();
	}
	return '#';
}

/**
 * Current number of items in the cart, for the badge on the cart icon.
 * Returns 0 (and hides the badge in the template) when WooCommerce is
 * inactive or the cart hasn't loaded yet.
 */
function blueva_get_cart_count() {
	if ( function_exists( 'WC' ) && WC()->cart ) {
		return WC()->cart->get_cart_contents_count();
	}
	return 0;
}

/**
 * Category links for the "Categories" dropdown.
 *
 * Prefers an assigned `blueva-categories` nav menu (site owner can manage
 * it from Appearance > Menus without touching code). Falls back to the
 * four BLUEVA product lines as WooCommerce product_cat terms when the
 * matching category slugs exist, and finally to plain static links so the
 * dropdown is never empty on a fresh install.
 *
 * @return array<int, array{label: string, url: string}>
 */
function blueva_get_category_links() {
	$locations = get_nav_menu_locations();

	if ( ! empty( $locations['blueva-categories'] ) ) {
		$menu = wp_get_nav_menu_object( $locations['blueva-categories'] );
		if ( $menu ) {
			$items = wp_get_nav_menu_items( $menu->term_id );
			if ( $items ) {
				return array_map(
					function ( $item ) {
						return array(
							'label' => $item->title,
							'url'   => $item->url,
						);
					},
					$items
				);
			}
		}
	}

	$fallback_slugs = array(
		'HOMMES'    => array( 'hommes' ),
		'FEMMES'    => array( 'femmes' ),
		'INFANTILS' => array( 'infantil', 'infantils' ),
		'JUVENILES' => array( 'juvenil', 'juvenils', 'juveniles', 'juvenile' ),
	);

	$links = array();

	if ( taxonomy_exists( 'product_cat' ) ) {
		foreach ( $fallback_slugs as $label => $slugs ) {
			foreach ( $slugs as $slug ) {
				$term = get_term_by( 'slug', $slug, 'product_cat' );
				if ( $term && ! is_wp_error( $term ) ) {
					$links[] = array(
						'label' => $label,
						'url'   => get_term_link( $term ),
					);
					break;
				}
			}
		}
	}

	if ( ! empty( $links ) ) {
		return $links;
	}

	// Last-resort static fallback (e.g. WooCommerce not yet installed).
	foreach ( $fallback_slugs as $label => $slugs ) {
		$links[] = array(
			'label' => $label,
			'url'   => home_url( '/product-category/' . $slugs[0] . '/' ),
		);
	}

	return $links;
}

/**
 * Keep the header's cart badge in sync via WooCommerce's own cart
 * fragments mechanism, so it updates after an AJAX add-to-cart without a
 * full page reload (needed again in later phases, wired up now).
 */
function blueva_cart_count_fragment( $fragments ) {
	ob_start();
	$count = blueva_get_cart_count();
	?>
	<span class="blueva-cart-count" data-count="<?php echo esc_attr( $count ); ?>"<?php echo 0 === $count ? ' hidden' : ''; ?>>
		<?php echo esc_html( $count ); ?>
	</span>
	<?php
	$fragments['.blueva-cart-count'] = ob_get_clean();
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'blueva_cart_count_fragment' );
