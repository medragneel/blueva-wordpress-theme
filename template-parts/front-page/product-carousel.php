<?php
/**
 * Front page — Product carousel ("Nouvelle Collection").
 *
 * Reusable: called twice from front-page.php with a different $args
 * so the same markup/CSS/JS powers both the "featured" and "new
 * products" sections of the homepage, per the design reference.
 *
 * $args:
 *   title   string  Section heading.
 *   context string  'featured' | 'new' — see blueva_get_carousel_products().
 *
 * @package Blueva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

$blueva_title   = ! empty( $args['title'] ) ? $args['title'] : __( 'Nouvelle Collection', 'blueva' );
$blueva_context = ! empty( $args['context'] ) ? $args['context'] : 'new';
$blueva_query   = blueva_get_carousel_products( $blueva_context, 8 );

if ( ! $blueva_query || ! $blueva_query->have_posts() ) {
	return;
}

$blueva_carousel_id = 'blueva-carousel-' . esc_attr( $blueva_context );
$blueva_slide_index = 0;
?>
<section class="blueva-carousel-section">
	<div class="blueva-container">
		<h2 class="blueva-heading blueva-section-heading"><?php echo esc_html( $blueva_title ); ?></h2>

		<div class="blueva-carousel" id="<?php echo esc_attr( $blueva_carousel_id ); ?>" data-blueva-carousel>
			<button type="button" class="blueva-carousel-arrow blueva-carousel-arrow--prev" data-blueva-carousel-prev aria-label="<?php esc_attr_e( 'Produit précédent', 'blueva' ); ?>">
				<svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M12.5 4.5 6.5 10l6 5.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
			</button>

			<div class="blueva-carousel-viewport">
				<ul class="blueva-carousel-track" data-blueva-carousel-track>
					<?php
					while ( $blueva_query->have_posts() ) :
						$blueva_query->the_post();
						global $product;

						if ( ! $product instanceof WC_Product ) {
							continue;
						}

						$blueva_is_active = ( 0 === $blueva_slide_index );
						$blueva_colors    = wc_get_product_terms( $product->get_id(), 'pa_color', array( 'fields' => 'all' ) );
						?>
						<li class="blueva-carousel-slide<?php echo $blueva_is_active ? ' is-active' : ''; ?>" data-blueva-carousel-slide>
							<div class="blueva-carousel-slide-inner">
								<a class="blueva-carousel-image" href="<?php the_permalink(); ?>" tabindex="<?php echo $blueva_is_active ? '0' : '-1'; ?>">
									<?php echo wp_kses_post( $product->get_image( 'blueva-product-card' ) ); ?>
								</a>

								<div class="blueva-carousel-info">
									<h3 class="blueva-product-title">
										<a href="<?php the_permalink(); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
									</h3>
									<p class="blueva-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></p>

									<?php if ( ! empty( $blueva_colors ) && ! is_wp_error( $blueva_colors ) ) : ?>
										<div class="blueva-carousel-swatches">
											<?php foreach ( $blueva_colors as $blueva_color ) : ?>
												<?php $blueva_swatch = get_term_meta( $blueva_color->term_id, 'product_attribute_color', true ); ?>
												<span
													class="blueva-swatch"
													title="<?php echo esc_attr( $blueva_color->name ); ?>"
													<?php if ( $blueva_swatch ) : ?>
														style="background-color: <?php echo esc_attr( $blueva_swatch ); ?>;"
													<?php endif; ?>
												></span>
											<?php endforeach; ?>
										</div>
									<?php endif; ?>

									<div class="blueva-carousel-cta">
										<?php woocommerce_template_loop_add_to_cart(); ?>
									</div>
								</div>
							</div>
						</li>
						<?php
						++$blueva_slide_index;
					endwhile;
					wp_reset_postdata();
					?>
				</ul>
			</div>

			<button type="button" class="blueva-carousel-arrow blueva-carousel-arrow--next" data-blueva-carousel-next aria-label="<?php esc_attr_e( 'Produit suivant', 'blueva' ); ?>">
				<svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M7.5 4.5 13.5 10l-6 5.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
			</button>
		</div>
	</div>
</section>
