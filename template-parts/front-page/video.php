<?php
/**
 * Front page — "Watch our best product in action" video section.
 *
 * @package Blueva
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blueva_video_url  = get_theme_mod( 'blueva_video_section_file', '' );
$blueva_poster_url = get_theme_mod( 'blueva_video_section_poster', '' );

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
                <svg fill="#fff" width="25px" height="25px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M18.54,9,8.88,3.46a3.42,3.42,0,0,0-5.13,3V17.58A3.42,3.42,0,0,0,7.17,21a3.43,3.43,0,0,0,1.71-.46L18.54,15a3.42,3.42,0,0,0,0-5.92Zm-1,4.19L7.88,18.81a1.44,1.44,0,0,1-1.42,0,1.42,1.42,0,0,1-.71-1.23V6.42a1.42,1.42,0,0,1,.71-1.23A1.51,1.51,0,0,1,7.17,5a1.54,1.54,0,0,1,.71.19l9.66,5.58a1.42,1.42,0,0,1,0,2.46Z"/></svg>
				</button>
				<button type="button" class="blueva-video-control" data-blueva-video-mute aria-label="<?php esc_attr_e( 'Couper le son', 'blueva' ); ?>">
					<svg data-blueva-icon-muted width="25px" height="25px" viewBox="0 0 24 24" fill="none"><path d="M3 8v4h3l4 3.5v-11L6 8H3Z" fill="currentColor"/><path d="m13.5 7.5 4 4m0-4-4 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
					<svg data-blueva-icon-unmuted width="25px" height="25px" viewBox="0 0 24 24" fill="none" class="blueva-icon-hidden"><path d="M3 8v4h3l4 3.5v-11L6 8H3Z" fill="currentColor"/><path d="M14 7c1 1 1 5 0 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
				</button>
			</div>

			<button type="button" class="blueva-video-big-play" data-blueva-video-bigplay aria-label="<?php esc_attr_e( 'Lire la vidéo', 'blueva' ); ?>">
				<span class="blueva-video-big-play-icon" aria-hidden="true"></span>
			</button>
		<?php elseif ( $blueva_poster_url ) : ?>
			<img class="blueva-video-fallback-image" src="<?php echo esc_url( $blueva_poster_url ); ?>" alt="<?php esc_attr_e( 'BLUEVA en action', 'blueva' ); ?>" loading="lazy" />
		<?php endif; ?>
	</div>
</section>
