<?php
/**
 * BLUEVA site header markup.
 *
 * @package Blueva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blueva_shop_url    = blueva_get_shop_url();
$blueva_contact_url = blueva_get_contact_url();
$blueva_cart_url    = blueva_get_cart_url();
$blueva_cart_count  = blueva_get_cart_count();
$blueva_categories  = blueva_get_category_links();
?>
<div class="blueva-announcement-bar" role="note">
	<p>
		<span class="blueva-announcement-icon" aria-hidden="true">🚚</span>
		<?php esc_html_e( 'Livraison gratuite vers 58 wilayas · Paiement à la livraison', 'blueva' ); ?>
	</p>
</div>

<header id="blueva-header" class="blueva-header">
	<div class="blueva-header-inner blueva-container">

		<button
			type="button"
			class="blueva-mobile-toggle"
			aria-label="<?php esc_attr_e( 'Ouvrir le menu', 'blueva' ); ?>"
			aria-expanded="false"
			aria-controls="blueva-mobile-menu"
			data-blueva-open-menu
		>
			<span class="blueva-burger-line"></span>
			<span class="blueva-burger-line"></span>
			<span class="blueva-burger-line"></span>
		</button>

		<nav class="blueva-nav-left" aria-label="<?php esc_attr_e( 'Navigation principale', 'blueva' ); ?>">
			<a class="blueva-nav-link blueva-nav-text" href="<?php echo esc_url( $blueva_shop_url ); ?>">
				<?php esc_html_e( 'Boutique', 'blueva' ); ?>
			</a>

			<div class="blueva-nav-dropdown">
				<button
					type="button"
					class="blueva-categories-btn blueva-nav-text"
					aria-haspopup="true"
					aria-expanded="false"
					data-blueva-dropdown-toggle
				>
					<?php esc_html_e( 'Categories', 'blueva' ); ?>
					<svg class="blueva-chevron" width="12" height="8" viewBox="0 0 12 8" fill="none" aria-hidden="true">
						<path d="M1 1.5L6 6.5L11 1.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</button>
				<div class="blueva-dropdown-menu" data-blueva-dropdown-menu>
					<?php foreach ( $blueva_categories as $blueva_cat ) : ?>
						<a href="<?php echo esc_url( $blueva_cat['url'] ); ?>"><?php echo esc_html( $blueva_cat['label'] ); ?></a>
					<?php endforeach; ?>
				</div>
			</div>

			<a class="blueva-nav-link blueva-nav-text" href="<?php echo esc_url( $blueva_contact_url ); ?>">
				<?php esc_html_e( 'Contact', 'blueva' ); ?>
			</a>
		</nav>

		<div class="blueva-logo">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<span class="blueva-logo-word">
						<span class="blueva-logo-dark">BLU</span><span class="blueva-logo-light">EVA</span><sup class="blueva-logo-reg">®</sup>
					</span>
					<span class="blueva-logo-tagline"><?php esc_html_e( 'KEEP WALKING · KEEP SMILING', 'blueva' ); ?></span>
				<?php endif; ?>
			</a>
		</div>

		<div class="blueva-nav-right">
			<form class="blueva-search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<label class="screen-reader-text" for="blueva-search-input"><?php esc_html_e( 'Rechercher', 'blueva' ); ?></label>
				<input
					id="blueva-search-input"
					type="search"
					name="s"
					class="blueva-nav-text"
					placeholder="<?php esc_attr_e( 'Search...', 'blueva' ); ?>"
					autocomplete="off"
				/>
				<?php if ( function_exists( 'is_woocommerce' ) ) : ?>
					<input type="hidden" name="post_type" value="product" />
				<?php endif; ?>
				<button type="submit" aria-label="<?php esc_attr_e( 'Rechercher', 'blueva' ); ?>">
					<svg width="18" height="18" viewBox="0 0 18 18" fill="none" aria-hidden="true">
						<circle cx="8" cy="8" r="6.25" stroke="currentColor" stroke-width="1.6"/>
						<path d="M17 17L12.7 12.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
					</svg>
				</button>
			</form>

			<button
				type="button"
				class="blueva-mobile-search-toggle"
				aria-label="<?php esc_attr_e( 'Rechercher', 'blueva' ); ?>"
				data-blueva-open-search
			>
				<svg width="20" height="20" viewBox="0 0 18 18" fill="none" aria-hidden="true">
					<circle cx="8" cy="8" r="6.25" stroke="currentColor" stroke-width="1.6"/>
					<path d="M17 17L12.7 12.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
				</svg>
			</button>

			<a class="blueva-cart-link" href="<?php echo esc_url( $blueva_cart_url ); ?>" aria-label="<?php esc_attr_e( 'Panier', 'blueva' ); ?>">
				<svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
					<path d="M6 8h12l-1.1 11.2a2 2 0 0 1-2 1.8H9.1a2 2 0 0 1-2-1.8L6 8Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
					<path d="M9 8V6a3 3 0 0 1 6 0v2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
				</svg>
				<span class="blueva-cart-count" data-count="<?php echo esc_attr( $blueva_cart_count ); ?>"<?php echo 0 === $blueva_cart_count ? ' hidden' : ''; ?>>
					<?php echo esc_html( $blueva_cart_count ); ?>
				</span>
			</a>
		</div>
	</div>

	<!-- Mobile-only slide-down search bar -->
	<div class="blueva-mobile-search-panel" data-blueva-search-panel hidden>
		<form class="blueva-search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label class="screen-reader-text" for="blueva-search-input-mobile"><?php esc_html_e( 'Rechercher', 'blueva' ); ?></label>
			<input id="blueva-search-input-mobile" type="search" name="s" placeholder="<?php esc_attr_e( 'Search...', 'blueva' ); ?>" autocomplete="off" />
			<?php if ( function_exists( 'is_woocommerce' ) ) : ?>
				<input type="hidden" name="post_type" value="product" />
			<?php endif; ?>
			<button type="submit" aria-label="<?php esc_attr_e( 'Rechercher', 'blueva' ); ?>">
				<svg width="18" height="18" viewBox="0 0 18 18" fill="none" aria-hidden="true">
					<circle cx="8" cy="8" r="6.25" stroke="currentColor" stroke-width="1.6"/>
					<path d="M17 17L12.7 12.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
				</svg>
			</button>
		</form>
	</div>
</header>

<?php get_template_part( 'template-parts/header/mobile-menu' ); ?>
