<?php
/**
 * The main shop/category archive template — overrides
 * woocommerce/archive-product.php.
 *
 * Intentionally bypasses WooCommerce's default content wrapper and
 * after-loop hooks (woocommerce_before_main_content /
 * woocommerce_after_shop_loop) since this is a fully custom layout —
 * see inline notes below for what's kept vs replaced.
 *
 * @package Blueva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primary" class="blueva-shop">

	<?php get_template_part( 'template-parts/shop/archive-header' ); ?>

	<div class="blueva-container blueva-shop-body">

		<?php
		// Cart/checkout/wishlist notices ("Added to cart", errors, etc.)
		// — still fired even though we skip the default content wrapper.
		woocommerce_output_all_notices();
		?>

		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) && is_product_category() ) : ?>
			<?php
			$blueva_cat_description = category_description();
			if ( $blueva_cat_description ) :
				?>
				<div class="blueva-shop-description"><?php echo wp_kses_post( $blueva_cat_description ); ?></div>
			<?php endif; ?>
		<?php endif; ?>

		<?php get_template_part( 'template-parts/shop/filters' ); ?>

		<?php do_action( 'blueva_before_product_grid' ); ?>

		<?php if ( woocommerce_product_loop() ) : ?>

			<ul class="blueva-product-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					wc_get_template_part( 'content', 'product' );
				endwhile;
				?>
			</ul>

			<?php if ( wc_get_loop_prop( 'total_pages' ) > 1 ) : ?>
				<div class="blueva-shop-pagination">
					<?php woocommerce_pagination(); ?>
				</div>
			<?php endif; ?>

		<?php else : ?>

			<div class="blueva-shop-empty">
				<p><?php esc_html_e( 'Aucun produit ne correspond à votre sélection.', 'blueva' ); ?></p>
				<a class="blueva-btn" href="<?php echo esc_url( blueva_get_shop_url() ); ?>">
					<?php esc_html_e( 'Voir tous les produits', 'blueva' ); ?>
				</a>
			</div>

		<?php endif; ?>

	</div>

</main>

<?php
get_footer();
