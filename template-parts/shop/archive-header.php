<?php
/**
 * Shop/category archive header band.
 *
 * @package Blueva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blueva_header = blueva_get_archive_header_data();
?>
<section
	class="blueva-archive-header"
	data-blueva-video-wrap
	<?php if ( $blueva_header['image'] ) : ?>
		style="background-image: url('<?php echo esc_url( $blueva_header['image'] ); ?>');"
	<?php else : ?>
		style="background-image: var(--blueva-placeholder-gradient);"
	<?php endif; ?>
>
	<?php if ( $blueva_header['video'] ) : ?>
		<video
			class="blueva-archive-header-video"
			data-blueva-video
			muted
			loop
			playsinline
			preload="metadata"
			<?php echo $blueva_header['image'] ? 'poster="' . esc_url( $blueva_header['image'] ) . '"' : ''; ?>
		>
			<source src="<?php echo esc_url( $blueva_header['video'] ); ?>" type="video/mp4" />
		</video>
	<?php endif; ?>

	<div class="blueva-archive-header-overlay"></div>

	<div class="blueva-archive-header-content">
		<span class="blueva-hero-line" aria-hidden="true"></span>
		<h1 class="blueva-archive-header-title"><?php echo esc_html( $blueva_header['title'] ); ?></h1>
		<span class="blueva-hero-line" aria-hidden="true"></span>
	</div>

	<?php if ( $blueva_header['video'] ) : ?>
		<div class="blueva-video-controls blueva-archive-header-controls">
			<button type="button" class="blueva-video-control" data-blueva-video-playpause aria-label="<?php esc_attr_e( 'Pause', 'blueva' ); ?>">
				<svg data-blueva-icon-play width="14" height="14" viewBox="0 0 14 14" fill="currentColor"><path d="M2 1.5 12.5 7 2 12.5V1.5Z"/></svg>
				<svg data-blueva-icon-pause width="14" height="14" viewBox="0 0 14 14" fill="currentColor" class="blueva-icon-hidden"><rect x="2" y="1.5" width="3.2" height="11"/><rect x="8.8" y="1.5" width="3.2" height="11"/></svg>
			</button>
			<button type="button" class="blueva-video-control" data-blueva-video-mute aria-label="<?php esc_attr_e( 'Activer le son', 'blueva' ); ?>">
				<svg data-blueva-icon-muted width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M3 8v4h3l4 3.5v-11L6 8H3Z" fill="currentColor"/><path d="m13.5 7.5 4 4m0-4-4 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
				<svg data-blueva-icon-unmuted width="14" height="14" viewBox="0 0 24 24" fill="none" class="blueva-icon-hidden"><path d="M3 8v4h3l4 3.5v-11L6 8H3Z" fill="currentColor"/><path d="M14 7c1 1 1 5 0 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
			</button>
		</div>
	<?php endif; ?>
</section>
