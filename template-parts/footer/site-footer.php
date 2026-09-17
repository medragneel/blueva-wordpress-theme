<?php
/**
 * BLUEVA site footer markup.
 *
 * @package Blueva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blueva_useful_links   = blueva_get_footer_useful_links();
$blueva_categories     = blueva_get_footer_categories();
$blueva_phone          = get_theme_mod( 'blueva_phone', '0784284722 / 044361306' );
$blueva_email          = get_theme_mod( 'blueva_email', 'info@blueva.dz' );
$blueva_facebook       = get_theme_mod( 'blueva_facebook_url', '' );
$blueva_instagram      = get_theme_mod( 'blueva_instagram_url', '' );
$blueva_footer_logo_id = get_theme_mod( 'blueva_footer_logo', '' );
?>
<footer id="blueva-footer" class="blueva-footer">
	<div class="blueva-container blueva-footer-inner">

		<div class="blueva-footer-col blueva-footer-brand">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="blueva-footer-logo" rel="home">
				<?php if ( $blueva_footer_logo_id ) : ?>
					<?php
					echo wp_get_attachment_image(
						$blueva_footer_logo_id,
						'full',
						false,
						array( 'class' => 'blueva-footer-logo-img' )
					);
					?>
				<?php elseif ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<span class="blueva-logo-word blueva-logo-word--footer">BLUEVA<sup class="blueva-logo-reg">®</sup></span>
					<span class="blueva-logo-tagline blueva-logo-tagline--footer"><?php esc_html_e( 'KEEP WALKING · KEEP SMILING', 'blueva' ); ?></span>
				<?php endif; ?>
			</a>

			<p class="blueva-footer-description">
				<?php esc_html_e( 'Votre fabricant 100% algérien préféré pour les chaussures de qualité supérieure.', 'blueva' ); ?>
				<?php esc_html_e( "Passionnés par le confort, déterminés à vous offrir une expérience d'achat facile et rapide.", 'blueva' ); ?>
			</p>

			<?php if ( $blueva_facebook || $blueva_instagram ) : ?>
				<div class="blueva-footer-social">
					<?php if ( $blueva_facebook ) : ?>
						<a href="<?php echo esc_url( $blueva_facebook ); ?>" class="blueva-social-icon" aria-label="Facebook" target="_blank" rel="noopener noreferrer">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M15 8.5h2V5.4c-.35-.05-1.54-.15-2.94-.15-2.9 0-4.89 1.83-4.89 5.2v2.8H6.2V17h2.97v10h3.6V17h2.85l.45-3.75h-3.3v-2.4c0-1.08.29-1.35 1.23-1.35Z" fill="currentColor"/></svg>
						</a>
					<?php endif; ?>
					<?php if ( $blueva_instagram ) : ?>
						<a href="<?php echo esc_url( $blueva_instagram ); ?>" class="blueva-social-icon" aria-label="Instagram" target="_blank" rel="noopener noreferrer">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="3.5" y="3.5" width="17" height="17" rx="5" stroke="currentColor" stroke-width="1.7"/><circle cx="12" cy="12" r="3.7" stroke="currentColor" stroke-width="1.7"/><circle cx="17.2" cy="6.8" r="1.1" fill="currentColor"/></svg>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>

		<nav class="blueva-footer-col" aria-label="<?php esc_attr_e( 'Liens utiles', 'blueva' ); ?>">
			<h3 class="blueva-footer-heading"><?php esc_html_e( 'LIENS UTILES', 'blueva' ); ?></h3>
			<ul class="blueva-footer-links">
				<?php foreach ( $blueva_useful_links as $blueva_link ) : ?>
					<li><a href="<?php echo esc_url( $blueva_link['url'] ); ?>"><?php echo esc_html( $blueva_link['label'] ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</nav>

		<nav class="blueva-footer-col" aria-label="<?php esc_attr_e( 'Catégories', 'blueva' ); ?>">
			<h3 class="blueva-footer-heading"><?php esc_html_e( 'CATEGORIES', 'blueva' ); ?></h3>
			<ul class="blueva-footer-links blueva-footer-links--caps">
				<?php foreach ( $blueva_categories as $blueva_cat ) : ?>
					<li><a href="<?php echo esc_url( $blueva_cat['url'] ); ?>"><?php echo esc_html( $blueva_cat['label'] ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</nav>

		<div class="blueva-footer-col blueva-footer-contact">
			<h3 class="blueva-footer-heading"><?php esc_html_e( 'CONTACT', 'blueva' ); ?></h3>
			<ul class="blueva-footer-links">
				<?php if ( $blueva_phone ) : ?>
					<li class="blueva-footer-contact-item">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M6.6 10.8c1.3 2.6 3.4 4.7 6 6l2-2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.5.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C9.9 21 3 14.1 3 5.9c0-.6.4-1 1-1h3.8c.6 0 1 .4 1 1 0 1.2.2 2.4.6 3.5.1.3 0 .7-.2 1l-2 2.4Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg>
						<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', explode( '/', $blueva_phone )[0] ) ); ?>"><?php echo esc_html( $blueva_phone ); ?></a>
					</li>
				<?php endif; ?>
				<?php if ( $blueva_email ) : ?>
					<li class="blueva-footer-contact-item">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="m4 6.5 8 6 8-6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
						<a href="mailto:<?php echo esc_attr( $blueva_email ); ?>"><?php echo esc_html( $blueva_email ); ?></a>
					</li>
				<?php endif; ?>
			</ul>
		</div>
	</div>

	<div class="blueva-footer-bottom">
		<p class="blueva-small">
			<?php
			printf(
				/* translators: 1: current year */
				esc_html__( '© %1$s . MARKCOM Tous droits réservés.', 'blueva' ),
				esc_html( gmdate( 'Y' ) )
			);
			?>
		</p>
	</div>
</footer>
