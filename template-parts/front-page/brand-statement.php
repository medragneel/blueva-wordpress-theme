<?php
/**
 * Front page — Brand statement + Collection CTA
 * ("LE MONDE EST PLUS BEAU DEHORS.").
 *
 * @package Blueva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blueva_statement_logo_url = get_theme_mod( 'blueva_footer_logo', '' );
?>
<section class="blueva-statement">
	<div class="blueva-statement-inner blueva-container">
		<span class="blueva-statement-logo-wrap">
			<?php if ( $blueva_statement_logo_url ) : ?>
				<img src="<?php echo esc_url( $blueva_statement_logo_url ); ?>" class="blueva-statement-logo-img" alt="<?php bloginfo( 'name' ); ?>" />
			<?php elseif ( has_custom_logo() ) : ?>
				<?php blueva_the_footer_logo(); ?>
			<?php else : ?>
				<span class="blueva-logo-word blueva-statement-logo">
					BLUEVA<sup class="blueva-logo-reg">®</sup>
				</span>
				<span class="blueva-logo-tagline blueva-statement-tagline">
					<?php esc_html_e( 'KEEP WALKING · KEEP SMILING', 'blueva' ); ?>
				</span>
			<?php endif; ?>
		</span>

		<p class="blueva-statement-kicker">
			<?php esc_html_e( 'LA NOUVELLE COLLECTION', 'blueva' ); ?>
		</p>
		<h2 class="blueva-heading blueva-statement-heading">
			<?php esc_html_e( 'LE MONDE EST PLUS BEAU DEHORS.', 'blueva' ); ?>
		</h2>

		<a class="blueva-btn blueva-btn-ghost" href="<?php echo esc_url( blueva_get_shop_url() ); ?>">
			<?php esc_html_e( 'Explorer la collection', 'blueva' ); ?>
			<span aria-hidden="true">→</span>
		</a>
	</div>
</section>

