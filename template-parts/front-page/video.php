<?php
/**
 * Front page — "Watch our best product in action" video section.
 *
 * @package Blueva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blueva_video_url    = get_theme_mod( 'blueva_video_section_file', '' );
$blueva_poster_id    = get_theme_mod( 'blueva_video_section_poster', '' );
$blueva_poster_url   = $blueva_poster_id ? wp_get_attachment_image_url( $blueva_poster_id, 'full' ) : '';

if ( ! $blueva_video_url && ! $blueva_poster_url ) {
	return;
}
?>
<section class="blueva-video-section">
	<h2 class="blueva-heading blueva-section-heading blueva-section-heading--center">
		<?php esc_html_e( 'WATCH OUR BEST PRODUCT IN ACTION', 'blueva' ); ?>
	</h2>

	<div class="blueva-video-wrap" data-blueva-video-wrap>
		<?php if ( $blueva_video_url ) : ?>
			<video
				class="blueva-video"
				data-blueva-video
				<?php echo $blueva_poster_url ? 'poster="' . esc_url( $blueva_poster_url ) . '"' : ''; ?>
				muted
				loop
				playsinline
				preload="metadata"
			>
				<source src="<?php echo esc_url( $blueva_video_url ); ?>" type="video/mp4" />
			</video>

			<div class="blueva-video-controls">
				<button type="button" class="blueva-video-control" data-blueva-video-playpause aria-label="<?php esc_attr_e( 'Lecture', 'blueva' ); ?>">
					<svg data-blueva-icon-play width="14" height="14" viewBox="0 0 14 14" fill="currentColor"><path d="M2 1.5 12.5 7 2 12.5V1.5Z"/></svg>
					<svg data-blueva-icon-pause width="14" height="14" viewBox="0 0 14 14" fill="currentColor" hidden><rect x="2" y="1.5" width="3.2" height="11"/><rect x="8.8" y="1.5" width="3.2" height="11"/></svg>
				</button>
				<button type="button" class="blueva-video-control" data-blueva-video-mute aria-label="<?php esc_attr_e( 'Couper le son', 'blueva' ); ?>">
					<svg data-blueva-icon-unmuted width="16" height="16" viewBox="0 0 20 20" fill="none" hidden><path d="M3 8v4h3l4 3.5v-11L6 8H3Z" fill="currentColor"/><path d="M14 7c1 1 1 5 0 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
					<svg data-blueva-icon-muted width="16" height="16" viewBox="0 0 20 20" fill="none"><path d="M3 8v4h3l4 3.5v-11L6 8H3Z" fill="currentColor"/><path d="m13.5 7.5 3 3m0-3-3 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
				</button>
			</div>

			<button type="button" class="blueva-video-big-play" data-blueva-video-bigplay aria-label="<?php esc_attr_e( 'Lire la vidéo', 'blueva' ); ?>">
				<svg width="28" height="28" viewBox="0 0 28 28" fill="none"><circle cx="14" cy="14" r="13" stroke="currentColor" stroke-width="1.5"/><path d="M11 8.5 19 14l-8 5.5v-11Z" fill="currentColor"/></svg>
			</button>
		<?php elseif ( $blueva_poster_url ) : ?>
			<img class="blueva-video-fallback-image" src="<?php echo esc_url( $blueva_poster_url ); ?>" alt="<?php esc_attr_e( 'BLUEVA en action', 'blueva' ); ?>" loading="lazy" />
		<?php endif; ?>
	</div>
</section>
