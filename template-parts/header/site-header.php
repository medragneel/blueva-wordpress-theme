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
			<a class="blueva-nav-link blueva-nav-text" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php esc_html_e( 'Home', 'blueva' ); ?>
			</a>

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
				<svg fill="currentColor" width="25px" height="25px" viewBox="0 0 56 56" xmlns="http://www.w3.org/2000/svg"><path d="M 14.5586 51.9531 L 42.1445 51.9531 C 46.3633 51.9531 48.8008 49.5156 48.8008 44.6875 L 48.8008 20.4297 C 48.8008 15.6016 46.3398 13.1641 41.4414 13.1641 L 37.7148 13.1641 C 37.5742 8.2422 33.3086 4.0469 28.0117 4.0469 C 22.6914 4.0469 18.4258 8.2422 18.2852 13.1641 L 14.5586 13.1641 C 9.6836 13.1641 7.1992 15.5781 7.1992 20.4297 L 7.1992 44.6875 C 7.1992 49.5391 9.6836 51.9531 14.5586 51.9531 Z M 28.0117 7.6094 C 31.3164 7.6094 33.8242 10.0938 33.9414 13.1641 L 22.0820 13.1641 C 22.1758 10.0938 24.6836 7.6094 28.0117 7.6094 Z M 14.6289 48.1797 C 12.2852 48.1797 10.9726 46.9375 10.9726 44.5000 L 10.9726 20.6172 C 10.9726 18.1797 12.2852 16.9375 14.6289 16.9375 L 41.3945 16.9375 C 43.6914 16.9375 45.0274 18.1797 45.0274 20.6172 L 45.0274 44.5000 C 45.0274 46.9375 43.6914 48.1797 42.0742 48.1797 Z"/></svg>
				<span class="blueva-cart-count" data-count="<?php echo esc_attr( $blueva_cart_count ); ?>"<?php echo 0 === $blueva_cart_count ? ' hidden' : ''; ?>>
					<?php echo esc_html( $blueva_cart_count ); ?>
				</span>
			</a>
		</div>
	</div>

	<!-- Mobile-only slide-down search bar -->
	<div class="blueva-mobile-search-panel" data-blueva-search-panel>
		<form class="blueva-search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label class="screen-reader-text" for="blueva-search-input-mobile"><?php esc_html_e( 'Rechercher', 'blueva' ); ?></label>
			<input id="blueva-search-input-mobile" type="search" name="s" placeholder="<?php esc_attr_e( 'Rechercher un produit...', 'blueva' ); ?>" autocomplete="off" />
			<?php if ( function_exists( 'is_woocommerce' ) ) : ?>
				<input type="hidden" name="post_type" value="product" />
			<?php endif; ?>
			<button type="submit" aria-label="<?php esc_attr_e( 'Rechercher', 'blueva' ); ?>">
				<svg fill="currentColor" width="18" height="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M21.71,20.29,18,16.61A9,9,0,1,0,16.61,18l3.68,3.68a1,1,0,0,0,1.42,0A1,1,0,0,0,21.71,20.29ZM11,18a7,7,0,1,1,7-7A7,7,0,0,1,11,18Z"/></svg>
			</button>
			<button type="button" class="blueva-mobile-search-close" data-blueva-close-search aria-label="<?php esc_attr_e( 'Fermer la recherche', 'blueva' ); ?>">
				<svg width="16" height="16" viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 4L16 16M16 4L4 16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
			</button>
		</form>
	</div>
</header>

<?php get_template_part( 'template-parts/header/mobile-menu' ); ?>
