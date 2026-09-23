<?php
/**
 * Product card — overrides WooCommerce's woocommerce/content-product.php.
 *
 * Keeps the standard woocommerce_before/after_shop_loop_item hooks for
 * compatibility with other plugins (wishlists, quick-view, etc.) but
 * replaces the visual markup with the BLUEVA card design: a color-matched
 * circular arrow badge over the image, a row of size circles, and an
 * underlined product name beside the price.
 *
 * @package Blueva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( ! $product || ! $product->is_visible() ) {
	return;
}

$blueva_badge_color = blueva_get_product_badge_color( $product );
$blueva_sizes        = blueva_get_product_sizes( $product );
?>
<li <?php wc_product_class( 'blueva-product-card', $product ); ?>>
	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

	<div class="blueva-product-card-inner">
		<a href="<?php the_permalink(); ?>" class="blueva-product-card-image">
			<?php echo wp_kses_post( $product->get_image( 'blueva-product-card' ) ); ?>

			<?php if ( $product->is_on_sale() ) : ?>
				<span class="blueva-product-sale-badge"><?php esc_html_e( 'Promo', 'blueva' ); ?></span>
			<?php endif; ?>

			<span class="blueva-product-arrow-badge" style="background-color: <?php echo esc_attr( $blueva_badge_color ); ?>;" aria-hidden="true">
				<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M6 14 14 6M14 6H7M14 6v7" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
			</span>
		</a>

		<div class="blueva-product-card-body">
			<?php if ( ! empty( $blueva_sizes ) ) : ?>
				<div class="blueva-product-sizes">
					<?php foreach ( $blueva_sizes as $blueva_size ) : ?>
						<span class="blueva-size-circle"><?php echo esc_html( $blueva_size ); ?></span>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<div class="blueva-product-title-row">
				<h2 class="blueva-product-card-title">
					<a href="<?php the_permalink(); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
				</h2>
				<span class="blueva-product-card-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
			</div>

			<div class="blueva-product-card-cta">
				<?php woocommerce_template_loop_add_to_cart(); ?>
			</div>
		</div>
	</div>

	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
</li>
