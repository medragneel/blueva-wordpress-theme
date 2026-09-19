<?php
/**
 * PHASE 3 — Front page (homepage).
 *
 * WordPress template hierarchy gives this file top priority for the
 * site's front page regardless of the Reading Settings choice, so it's
 * the correct place for the BLUEVA homepage rather than home.php/index.php.
 *
 * Section order matches the PDF design reference:
 * Hero → Featured Collection carousel → Material marquee → Categories
 * grid → Video → New Collection carousel → Brand statement/CTA → Footer
 * (footer renders itself via the astra_body_bottom hook, see inc/footer.php).
 *
 * @package Blueva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primary" class="blueva-front-page">

	<?php get_template_part( 'template-parts/front-page/hero' ); ?>

	<?php
	get_template_part(
		'template-parts/front-page/product-carousel',
		null,
		array(
			'title'   => __( 'Best Sellers', 'blueva' ),
			'context' => 'featured',
		)
	);
	?>

	<?php get_template_part( 'template-parts/front-page/marquee' ); ?>

	<?php get_template_part( 'template-parts/front-page/categories' ); ?>

	<?php get_template_part( 'template-parts/front-page/video' ); ?>

	<?php
	get_template_part(
		'template-parts/front-page/product-carousel',
		null,
		array(
			'title'   => __( 'Nouveautés', 'blueva' ),
			'context' => 'new',
		)
	);
	?>

	<?php get_template_part( 'template-parts/front-page/brand-statement' ); ?>

</main>

<?php
get_footer();
