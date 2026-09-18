<?php
/**
 * PHASE 2 — Footer.
 *
 * Same reasoning as inc/header.php: Astra's own footer comes from its
 * Footer Builder (`astra_footer`, also bound to class instances), so
 * instead of unhooking it, BLUEVA renders its own footer on
 * `astra_body_bottom` — which fires right after Astra's `#page` wrapper
 * closes and before `wp_footer()` — and hides Astra's `#colophon` with
 * CSS. Parent theme stays untouched.
 *
 * @package Blueva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Output the BLUEVA footer.
 */
function blueva_render_footer() {
	get_template_part( 'template-parts/footer/site-footer' );
}
add_action( 'astra_body_bottom', 'blueva_render_footer' );

/**
 * Renders the Site Identity logo tagged with an extra `footer-custom-logo`
 * class, so footer.css can force it to a white silhouette (see
 * .footer-custom-logo in footer.css) without touching core's `.custom-logo`
 * class anywhere else it's used (header, admin bar, etc).
 *
 * @return bool True if a custom logo was output, false if none is set.
 */
function blueva_the_footer_logo() {
	if ( ! has_custom_logo() ) {
		return false;
	}

	$html = get_custom_logo();
	$html = str_replace( 'class="custom-logo"', 'class="custom-logo footer-custom-logo"', $html );

	// get_custom_logo() output is already escaped by WordPress core.
	echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	return true;
}

/**
 * Resolve a page's URL by slug, with a safe fallback when the page
 * doesn't exist yet (e.g. the site owner hasn't created it, or it's a
 * later phase that hasn't shipped). Never fatals, never links to "#"
 * silently without the fallback the caller chose.
 */
function blueva_get_page_url_by_slug( $slug, $fallback = '#' ) {
	$page = get_page_by_path( $slug );
	if ( $page ) {
		return get_permalink( $page );
	}
	return $fallback;
}

/**
 * "LIENS UTILES" column links.
 *
 * Politique de confidentialité uses WordPress's own Privacy Policy page
 * mechanism (Settings > Privacy) when one is set, which is the correct,
 * non-hardcoded way to link it. The others look for a page by slug and
 * fall back to "#" so the footer never fatals on a fresh install.
 */
function blueva_get_footer_useful_links() {
	$privacy_url = function_exists( 'get_privacy_policy_url' ) ? get_privacy_policy_url() : '';

	return array(
		array(
			'label' => __( 'B To B', 'blueva' ),
			'url'   => blueva_get_page_url_by_slug( 'b2b', blueva_get_page_url_by_slug( 'devenir-vendeur' ) ),
		),
		array(
			'label' => __( 'Politique de confidentialité', 'blueva' ),
			'url'   => $privacy_url ? $privacy_url : blueva_get_page_url_by_slug( 'politique-de-confidentialite' ),
		),
		array(
			'label' => __( "Procédure d'échange", 'blueva' ),
			'url'   => blueva_get_page_url_by_slug( 'procedure-echange' ),
		),
		array(
			'label' => __( 'Détails sur la livraison', 'blueva' ),
			'url'   => blueva_get_page_url_by_slug( 'livraison' ),
		),
	);
}

/**
 * "CATEGORIES" column links.
 *
 * Labels are the exact brand wording from the design reference (all
 * caps, "JUVENILS" with no accent/E — preserved as specified rather than
 * "corrected"). URLs resolve to the real product_cat term when it
 * exists, trying a couple of likely slugs per category before falling
 * back to a predictable /product-category/ URL.
 */
function blueva_get_footer_categories() {
	$categories = array(
		'HOMMES'    => array( 'hommes' ),
		'FEMMES'    => array( 'femmes' ),
		'INFANTILS' => array( 'infantils', 'infantil' ),
		'JUVENILS'  => array( 'juvenils', 'juveniles', 'juvenile' ),
	);

	$links = array();

	foreach ( $categories as $label => $slugs ) {
		$url = '';

		if ( taxonomy_exists( 'product_cat' ) ) {
			foreach ( $slugs as $slug ) {
				$term = get_term_by( 'slug', $slug, 'product_cat' );
				if ( $term && ! is_wp_error( $term ) ) {
					$url = get_term_link( $term );
					break;
				}
			}
		}

		if ( ! $url ) {
			$url = home_url( '/product-category/' . $slugs[0] . '/' );
		}

		$links[] = array(
			'label' => $label,
			'url'   => $url,
		);
	}

	return $links;
}
