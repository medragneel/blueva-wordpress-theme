<?php
/**
 * Front page — Scrolling brand marquee.
 *
 * @package Blueva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blueva_marquee_items = blueva_get_marquee_items();

if ( empty( $blueva_marquee_items ) ) {
	return;
}
?>
<section class="blueva-marquee" aria-label="<?php esc_attr_e( 'Points forts de la marque BLUEVA', 'blueva' ); ?>">
	<div class="blueva-marquee-track">
		<?php
		// Render the item list twice back-to-back so the CSS animation
		// (translateX 0 -> -50%) loops seamlessly with no visible seam.
		for ( $blueva_pass = 0; $blueva_pass < 2; $blueva_pass++ ) :
			?>
			<div class="blueva-marquee-group" <?php echo 1 === $blueva_pass ? 'aria-hidden="true"' : ''; ?>>
				<?php foreach ( $blueva_marquee_items as $blueva_item ) : ?>
					<span class="blueva-marquee-item"><?php echo esc_html( $blueva_item ); ?></span>
					<span class="blueva-marquee-dot" aria-hidden="true">·</span>
				<?php endforeach; ?>
			</div>
		<?php endfor; ?>
	</div>
</section>
