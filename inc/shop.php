<?php
/**
 * PHASE 4 — Shop & Category archive pages.
 *
 * @package Blueva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue shop-only styles/scripts.
 */
function blueva_shop_assets() {
	if ( ! is_shop() && ! is_product_category() && ! is_product_tag() ) {
		return;
	}

	wp_enqueue_style(
		'blueva-shop',
		BLUEVA_URI . '/assets/css/shop.css',
		array( 'blueva-style' ),
		BLUEVA_VERSION
	);

	wp_enqueue_script(
		'blueva-shop',
		BLUEVA_URI . '/assets/js/shop.js',
		array(),
		BLUEVA_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'blueva_shop_assets' );

/**
 * ------------------------------------------------------------------
 * Filters: price bands + color attribute.
 * ------------------------------------------------------------------
 */

/**
 * Price bands for the "Prix" filter. Kept simple (radio-style, one
 * active band at a time) rather than a slider, matching the pill/dropdown
 * design and needing no JS to function.
 *
 * Filterable — to add or change bands without touching this file, hook:
 *   add_filter( 'blueva_price_filter_bands', function( $bands ) {
 *       $bands[] = array( 'label' => '5000+ DA', 'min' => '5000', 'max' => '' );
 *       return $bands;
 *   } );
 *
 * @return array<int, array{label:string, min:string, max:string}>
 */
function blueva_get_price_filter_bands() {
	$bands = array(
		array(
			'label' => __( 'Moins de 1000 DA', 'blueva' ),
			'min'   => '',
			'max'   => '1000',
		),
		array(
			'label' => __( '1000 - 1500 DA', 'blueva' ),
			'min'   => '1000',
			'max'   => '1500',
		),
		array(
			'label' => __( '1500 - 2000 DA', 'blueva' ),
			'min'   => '1500',
			'max'   => '2000',
		),
		array(
			'label' => __( '2000 - 2500 DA', 'blueva' ),
			'min'   => '2000',
			'max'   => '2500',
		),
		array(
			'label' => __( 'Plus de 2500 DA', 'blueva' ),
			'min'   => '2500',
			'max'   => '',
		),
	);

	/**
	 * Filter the "Prix" dropdown's price bands.
	 *
	 * @param array $bands Default bands, covering the 850-2500 DA range.
	 */
	return apply_filters( 'blueva_price_filter_bands', $bands );
}

/**
 * Reference color palette (name => hex). Used as a fallback so a color's
 * swatch shows correctly everywhere (shop filter, product card badge,
 * homepage carousel) without the site owner having to manually set the
 * "product_attribute_color" term meta on every pa_color term one by one.
 *
 * Term meta always wins when set — this is only the fallback.
 *
 * Filterable — to add a new color without touching this file, hook:
 *   add_filter( 'blueva_color_palette', function( $palette ) {
 *       $palette['Midnight Teal'] = '#0a3d3f';
 *       return $palette;
 *   } );
 *
 * @return array<string, string>
 */
function blueva_get_color_palette() {
	$palette = array(
		'Charcoral Gray'    => '#6d6d6d',
		'Mirage Gray'       => '#a1adab',
		'Bay'               => '#beeadb',
		'Bluing'            => '#323e83',
		'Nantuket'          => '#b7d1ea',
		'Pear Sorbet'       => '#f3eac3',
		'Creme De Peche'    => '#f6d7c6',
		'Aruba Blue'        => '#80d7d3',
		'Babys Breath'      => '#e8e2d0',
		'Juniper'           => '#3d7245',
		'Noir'              => '#363938',
		'Orient Bleu'       => '#3f4f5c',
		'Raspberry Rose'    => '#cb4385',
		'Thyme'             => '#51574c',
		'Fire'              => '#3b725f',
		'Colonial Bleu'     => '#2d6471',
		'Brown'             => '#a78d7a',
		'High Risk Red'     => '#c71f2c',
		'Ice Green'         => '#88d8c4',
		'Lemon Chrome'      => '#ffc400',
		'Brillant White'    => '#ecf1ff',
		'Pale Iris'         => '#8796c6',
		'Light Pink'        => '#eed4d8',
		'Camel'             => '#a47044',
		'Dark Red'          => '#c44080',
		'Dark Orange'       => '#b84b00',
		'Endive'            => '#ccc67c',
		'White'             => '#efe8dd',
		'Horizon Blue'      => '#359bba',
		'Baby Blue'         => '#b5c8d4',
		'Winterberry'       => '#be3850',
		'Hot Chocolate'     => '#683b38',
		'Lyons Blue'        => '#015872',
		'Aventurine'        => '#005349',
		'Ice Flow'          => '#c6d2d2',
		'Peony'             => '#ee9ca8',
		'Damson'            => '#864c65',
		'Pantone 18-0937'   => '#825e2f',
		'Hot Cyan Blue'     => '#359bba',
		'Smokey Taupe'      => '#cdc5b5',
	);

	/**
	 * Filter the reference color palette used to auto-fill swatches.
	 *
	 * @param array $palette Default name => hex map.
	 */
	return apply_filters( 'blueva_color_palette', $palette );
}

/**
 * Resolve the swatch hex for a pa_color term: its own term meta first
 * (the site owner's explicit choice, always wins), falling back to a
 * name match against the reference palette so common color names "just
 * work" with no manual setup.
 *
 * @param WP_Term $term A pa_color term.
 * @return string Hex color, or '' if nothing matched.
 */
function blueva_resolve_color_swatch( $term ) {
	$meta_color = get_term_meta( $term->term_id, 'product_attribute_color', true );
	if ( $meta_color ) {
		return $meta_color;
	}

	$palette      = blueva_get_color_palette();
	$term_name    = trim( $term->name );
	$term_name_lc = strtolower( $term_name );

	foreach ( $palette as $name => $hex ) {
		$name_lc = strtolower( $name );
		// Exact match, or the term name is a prefix of a composite
		// palette entry (e.g. term "Mirage Gray" matching a palette key
		// like "Mirage Gray Micro Chip").
		if ( $term_name_lc === $name_lc || 0 === strpos( $name_lc, $term_name_lc ) ) {
			return $hex;
		}
	}

	return '';
}

/**
 * Real color attribute terms in the store (pa_color), each resolved to
 * a swatch via blueva_resolve_color_swatch().
 *
 * @return array<int, array{slug:string, name:string, color:string}>
 */
function blueva_get_color_filter_options() {
	if ( ! taxonomy_exists( 'pa_color' ) ) {
		return array();
	}

	$terms = get_terms(
		array(
			'taxonomy'   => 'pa_color',
			'hide_empty' => true,
		)
	);

	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return array();
	}

	return array_map(
		function ( $term ) {
			return array(
				'slug'  => $term->slug,
				'name'  => $term->name,
				'color' => blueva_resolve_color_swatch( $term ),
			);
		},
		$terms
	);
}

/**
 * Size attribute terms (pa_size) for the "Tailles" filter — same shape
 * as the color options, minus the swatch.
 *
 * @return array<int, array{slug:string, name:string}>
 */
function blueva_get_size_filter_options() {
	if ( ! taxonomy_exists( 'pa_size' ) ) {
		return array();
	}

	$terms = get_terms(
		array(
			'taxonomy'   => 'pa_size',
			'hide_empty' => true,
		)
	);

	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return array();
	}

	return array_map(
		function ( $term ) {
			return array(
				'slug' => $term->slug,
				'name' => $term->name,
			);
		},
		$terms
	);
}

/**
 * Product categories for the "Catégories" filter — only relevant on the
 * main shop page (a category archive is already scoped to one category,
 * so filtering by category there would be redundant/confusing).
 *
 * @return array<int, array{slug:string, name:string}>
 */
function blueva_get_category_filter_options() {
	if ( ! is_shop() || ! taxonomy_exists( 'product_cat' ) ) {
		return array();
	}

	$terms = get_terms(
		array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => true,
		)
	);

	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return array();
	}

	return array_map(
		function ( $term ) {
			return array(
				'slug' => $term->slug,
				'name' => $term->name,
			);
		},
		$terms
	);
}

/**
 * Apply the "Prix" and "Couleurs" filters (from the shop filter bar's
 * GET params) to the main shop/category query. Only touches the front-end
 * main query on shop/category archives — never admin, never other queries.
 */
function blueva_apply_shop_filters( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( ! ( is_shop() || is_product_category() || is_product_tag() ) ) {
		return;
	}

	// Price band.
	$min_price = isset( $_GET['blueva_min_price'] ) ? sanitize_text_field( wp_unslash( $_GET['blueva_min_price'] ) ) : '';
	$max_price = isset( $_GET['blueva_max_price'] ) ? sanitize_text_field( wp_unslash( $_GET['blueva_max_price'] ) ) : '';

	if ( '' !== $min_price || '' !== $max_price ) {
		$meta_query = $query->get( 'meta_query' );
		if ( ! is_array( $meta_query ) ) {
			$meta_query = array();
		}

		if ( '' !== $min_price && '' !== $max_price ) {
			$meta_query[] = array(
				'key'     => '_price',
				'value'   => array( floatval( $min_price ), floatval( $max_price ) ),
				'compare' => 'BETWEEN',
				'type'    => 'NUMERIC',
			);
		} elseif ( '' !== $min_price ) {
			$meta_query[] = array(
				'key'     => '_price',
				'value'   => floatval( $min_price ),
				'compare' => '>=',
				'type'    => 'NUMERIC',
			);
		} else {
			$meta_query[] = array(
				'key'     => '_price',
				'value'   => floatval( $max_price ),
				'compare' => '<=',
				'type'    => 'NUMERIC',
			);
		}

		$query->set( 'meta_query', $meta_query ); // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
	}

	$tax_query = $query->get( 'tax_query' );
	if ( ! is_array( $tax_query ) ) {
		$tax_query = array();
	}

	// Colors (multi-select).
	$colors = isset( $_GET['color'] ) ? (array) $_GET['color'] : array();
	$colors = array_filter( array_map( 'sanitize_title', $colors ) );

	if ( ! empty( $colors ) ) {
		$tax_query[] = array(
			'taxonomy' => 'pa_color',
			'field'    => 'slug',
			'terms'    => $colors,
		);
	}

	// Sizes (multi-select).
	$sizes = isset( $_GET['size'] ) ? (array) $_GET['size'] : array();
	$sizes = array_filter( array_map( 'sanitize_title', $sizes ) );

	if ( ! empty( $sizes ) ) {
		$tax_query[] = array(
			'taxonomy' => 'pa_size',
			'field'    => 'slug',
			'terms'    => $sizes,
		);
	}

	// Categories (multi-select, main shop page only).
	$cats = isset( $_GET['cat_filter'] ) ? (array) $_GET['cat_filter'] : array();
	$cats = array_filter( array_map( 'sanitize_title', $cats ) );

	if ( ! empty( $cats ) ) {
		$tax_query[] = array(
			'taxonomy' => 'product_cat',
			'field'    => 'slug',
			'terms'    => $cats,
		);
	}

	if ( ! empty( $colors ) || ! empty( $sizes ) || ! empty( $cats ) ) {
		$query->set( 'tax_query', $tax_query ); // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
	}

	// Stash what happened, for the admin-only debug panel below.
	$GLOBALS['blueva_shop_filter_debug'] = array(
		'hook_fired'   => true,
		'get_params'   => array(
			'color'      => isset( $_GET['color'] ) ? $_GET['color'] : null, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			'size'       => isset( $_GET['size'] ) ? $_GET['size'] : null, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			'cat_filter' => isset( $_GET['cat_filter'] ) ? $_GET['cat_filter'] : null, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			'min_price'  => isset( $_GET['blueva_min_price'] ) ? $_GET['blueva_min_price'] : null, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			'max_price'  => isset( $_GET['blueva_max_price'] ) ? $_GET['blueva_max_price'] : null, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		),
		'parsed'       => array(
			'colors' => $colors,
			'sizes'  => $sizes,
			'cats'   => $cats,
		),
		'tax_query'    => $tax_query,
		'taxonomies_exist' => array(
			'pa_color' => taxonomy_exists( 'pa_color' ),
			'pa_size'  => taxonomy_exists( 'pa_size' ),
		),
	);
}
add_action( 'woocommerce_product_query', 'blueva_apply_shop_filters' );

/**
 * Admin-only diagnostic panel for the shop filters — shows exactly what
 * GET params arrived, how they were parsed, the tax_query that was built,
 * and how many products the final query actually found. Only ever
 * visible to logged-in administrators; completely inert for everyone
 * else. Safe to leave in — remove once filtering is confirmed working.
 */
function blueva_shop_filter_debug_panel() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( ! ( is_shop() || is_product_category() || is_product_tag() ) ) {
		return;
	}

	global $wp_query;
	$debug = isset( $GLOBALS['blueva_shop_filter_debug'] ) ? $GLOBALS['blueva_shop_filter_debug'] : null;
	?>
	<div style="background:#1a1a1a;color:#0f0;font-family:monospace;font-size:12px;padding:16px;margin:16px 0;border-radius:8px;overflow:auto;white-space:pre-wrap;">
		<strong style="color:#fff;">BLUEVA FILTER DEBUG (admins only)</strong><br><br>
		<?php if ( ! $debug ) : ?>
			⚠ blueva_apply_shop_filters() never ran on this request — the woocommerce_product_query hook did not fire.
		<?php else : ?>
Taxonomies registered: pa_color=<?php echo $debug['taxonomies_exist']['pa_color'] ? 'YES' : 'NO'; ?>, pa_size=<?php echo $debug['taxonomies_exist']['pa_size'] ? 'YES' : 'NO'; ?>

WooCommerce's own RESERVED min_price/max_price present in $_GET? <?php echo ( isset( $_GET['min_price'] ) || isset( $_GET['max_price'] ) ) ? 'YES — this alone would corrupt every filtered request' : 'no (good)'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>

Raw $_GET: <?php echo esc_html( wp_json_encode( $debug['get_params'] ) ); ?>

Parsed (after sanitize): <?php echo esc_html( wp_json_encode( $debug['parsed'] ) ); ?>

Tax query applied: <?php echo esc_html( wp_json_encode( $debug['tax_query'] ) ); ?>

Final result count: <?php echo esc_html( $wp_query->found_posts ); ?> products found
Final SQL request: <?php echo esc_html( $wp_query->request ); ?>

--- RAW DATABASE CHECK (bypasses our filter code entirely) ---
Every product actually linked to a pa_color term right now:
<?php
global $wpdb;
$rows = $wpdb->get_results(
	"SELECT tr.object_id, p.post_title, p.post_status, tt.term_taxonomy_id, t.name, t.slug
	 FROM {$wpdb->term_relationships} tr
	 JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
	 JOIN {$wpdb->terms} t ON tt.term_id = t.term_id
	 JOIN {$wpdb->posts} p ON tr.object_id = p.ID
	 WHERE tt.taxonomy = 'pa_color'"
);
if ( empty( $rows ) ) {
	echo "(none — no product is actually linked to any pa_color term in the database)";
} else {
	foreach ( $rows as $row ) {
		printf(
			"product_id=%d \"%s\" [%s]  -->  term_taxonomy_id=%d  term=\"%s\" (slug: %s)\n",
			(int) $row->object_id,
			esc_html( $row->post_title ),
			esc_html( $row->post_status ),
			(int) $row->term_taxonomy_id,
			esc_html( $row->name ),
			esc_html( $row->slug )
		);
	}
}
?>
		<?php endif; ?>
	</div>
	<?php
}
add_action( 'blueva_before_product_grid', 'blueva_shop_filter_debug_panel' );

/**
 * Our woocommerce/content-product.php override builds the entire card
 * (image, badge, sizes, title, price, add-to-cart) itself, but still
 * fires the standard woocommerce_before/after_shop_loop_item actions for
 * plugin compatibility (wishlists, quick-view, etc). Astra's own theme
 * also hooks a full duplicate title/price/add-to-cart block onto
 * woocommerce_after_shop_loop_item via its "Shop Product Structure"
 * feature — this is Astra's own sanctioned way to opt out of that
 * entire feature at once, rather than unhooking its individual pieces.
 */
add_filter( 'astra_woo_shop_product_structure_override', '__return_true' );

/**
 * With Astra's Shop Product Structure feature disabled above, Astra no
 * longer removes WooCommerce core's own default add-to-cart callback
 * (normally bundled into that same feature) — so remove it ourselves,
 * since our content-product.php already renders its own Add to Cart
 * button inside .blueva-product-card-cta.
 */
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

/**
 * ------------------------------------------------------------------
 * Archive header (category title band with image/video background).
 * ------------------------------------------------------------------
 */

/**
 * Optional header video URL, editable per-category from Products >
 * Categories > edit category. Falls back to no video (just the
 * category/shop image, desaturated) when not set.
 */
function blueva_add_category_video_field() {
	?>
	<div class="form-field">
		<label for="blueva_header_video"><?php esc_html_e( 'Header video (MP4)', 'blueva' ); ?></label>
		<input type="url" name="blueva_header_video" id="blueva_header_video" value="" placeholder="https://" />
		<p class="description"><?php esc_html_e( 'Optional. Shown behind the category title on the shop page. Falls back to the category thumbnail if left empty.', 'blueva' ); ?></p>
	</div>
	<?php
}
add_action( 'product_cat_add_form_fields', 'blueva_add_category_video_field' );

function blueva_edit_category_video_field( $term ) {
	$value = get_term_meta( $term->term_id, 'blueva_header_video', true );
	?>
	<tr class="form-field">
		<th scope="row"><label for="blueva_header_video"><?php esc_html_e( 'Header video (MP4)', 'blueva' ); ?></label></th>
		<td>
			<input type="url" name="blueva_header_video" id="blueva_header_video" value="<?php echo esc_attr( $value ); ?>" placeholder="https://" style="width:100%;max-width:400px;" />
			<p class="description"><?php esc_html_e( 'Optional. Shown behind the category title on the shop page. Falls back to the category thumbnail if left empty.', 'blueva' ); ?></p>
		</td>
	</tr>
	<?php
}
add_action( 'product_cat_edit_form_fields', 'blueva_edit_category_video_field' );

function blueva_save_category_video_field( $term_id ) {
	if ( isset( $_POST['blueva_header_video'] ) ) {
		update_term_meta( $term_id, 'blueva_header_video', esc_url_raw( wp_unslash( $_POST['blueva_header_video'] ) ) );
	}
}
add_action( 'created_product_cat', 'blueva_save_category_video_field' );
add_action( 'edited_product_cat', 'blueva_save_category_video_field' );

/**
 * Title, image and optional video for the current shop/category archive
 * header band.
 *
 * @return array{title:string, image:string, video:string}
 */
function blueva_get_archive_header_data() {
	$title = '';
	$image = '';
	$video = '';

	if ( is_product_category() ) {
		$term       = get_queried_object();
		$title      = $term->name;
		$thumb_id   = get_term_meta( $term->term_id, 'thumbnail_id', true );
		$image      = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'full' ) : '';
		$video      = get_term_meta( $term->term_id, 'blueva_header_video', true );
	} else {
		$title = __( 'Boutique', 'blueva' );
		$shop_page_id = wc_get_page_id( 'shop' );
		if ( $shop_page_id > 0 ) {
			$image = get_the_post_thumbnail_url( $shop_page_id, 'full' );
		}
	}

	return array(
		'title' => $title,
		'image' => $image,
		'video' => $video,
	);
}

/**
 * ------------------------------------------------------------------
 * Product card helpers.
 * ------------------------------------------------------------------
 */

/**
 * Accent color for a product's circular corner badge — the first color
 * attribute term's swatch value, falling back to the brand teal so a
 * product with no color attribute still gets a nicely colored badge.
 */
function blueva_get_product_badge_color( $product ) {
	$colors = wc_get_product_terms( $product->get_id(), 'pa_color', array( 'fields' => 'all' ) );

	if ( ! empty( $colors ) && ! is_wp_error( $colors ) ) {
		$swatch = blueva_resolve_color_swatch( $colors[0] );
		if ( $swatch ) {
			return $swatch;
		}
	}

	return 'var(--blueva-primary)';
}

/**
 * Size attribute terms for a product (pa_size), for the row of size
 * circles on each product card.
 *
 * @return array<int, string>
 */
function blueva_get_product_sizes( $product ) {
	$sizes = wc_get_product_terms( $product->get_id(), 'pa_size', array( 'fields' => 'names' ) );
	return ( ! is_wp_error( $sizes ) && ! empty( $sizes ) ) ? $sizes : array();
}
