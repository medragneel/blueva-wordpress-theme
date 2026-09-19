<?php
/**
 * Front page — Hero section.
 *
 * @package Blueva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blueva_hero_image_url = get_theme_mod( 'blueva_hero_image', '' );
?>
<section
	class="blueva-hero"
	<?php if ( $blueva_hero_image_url ) : ?>
		style="background-image: url('<?php echo esc_url( $blueva_hero_image_url ); ?>');"
	<?php else : ?>
		style="background-image: var(--blueva-placeholder-gradient);"
	<?php endif; ?>
>
	<div class="blueva-hero-overlay"></div>

	<div class="blueva-hero-content">
		<div class="blueva-hero-top-block">
			<div class="blueva-hero-top">
				<span class="blueva-hero-line" aria-hidden="true"></span>
				<span class="blueva-hero-wordmark">BLUEVA</span>
				<span class="blueva-hero-line" aria-hidden="true"></span>
			</div>
			<p class="blueva-hero-kicker-big">
				<?php esc_html_e( 'SUMMER COLLECTION', 'blueva' ); ?>
			</p>
		</div>

		<div class="blueva-hero-bottom blueva-container">
			<div class="blueva-hero-copy">
				<p class="blueva-hero-kicker">
					<?php esc_html_e( 'Fabriqué en Algérie · 100% EVA', 'blueva' ); ?>
				</p>
				<h1 class="blueva-hero-heading">
					<?php esc_html_e( 'LE CONFORT, RÉINVENTÉ.', 'blueva' ); ?>
				</h1>
				<p class="blueva-hero-text">
					<?php esc_html_e( "Pensés pour suivre votre rythme, du matin jusqu'au coucher du soleil.", 'blueva' ); ?>
				</p>
			</div>

			<a class="blueva-btn blueva-btn-ghost blueva-hero-cta" href="<?php echo esc_url( blueva_get_shop_url() ); ?>">
				<?php esc_html_e( 'Explorer la collection', 'blueva' ); ?>
				<span aria-hidden="true">→</span>
			</a>
		</div>
	</div>
</section>
