<?php
/**
 * Front page — Hero section.
 *
 * @package Blueva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blueva_hero_image_id  = get_theme_mod( 'blueva_hero_image', '' );
$blueva_hero_image_url = $blueva_hero_image_id ? wp_get_attachment_image_url( $blueva_hero_image_id, 'full' ) : '';
?>
<section
	class="blueva-hero"
	<?php if ( $blueva_hero_image_url ) : ?>
		style="background-image: url('<?php echo esc_url( $blueva_hero_image_url ); ?>');"
	<?php endif; ?>
>
	<div class="blueva-hero-overlay"></div>

	<div class="blueva-hero-top">
		<span class="blueva-hero-line" aria-hidden="true"></span>
		<span class="blueva-hero-wordmark">BLUEVA</span>
		<span class="blueva-hero-line" aria-hidden="true"></span>
	</div>
	<p class="blueva-hero-kicker-big">
		<?php esc_html_e( 'SUMMER COLLECTION', 'blueva' ); ?>
	</p>

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
</section>
