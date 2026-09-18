/**
 * BLUEVA front page interactions: product carousels + video controls.
 *
 * @package Blueva
 */
( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		document.querySelectorAll( '[data-blueva-carousel]' ).forEach( initCarousel );
		document.querySelectorAll( '[data-blueva-video-wrap]' ).forEach( initVideo );
	} );

	/**
	 * Peek-style product carousel: one active (full-size) slide centered,
	 * neighbors dimmed and partially visible. Works by measuring real
	 * rendered slide positions, so it needs no assumptions about
	 * flex-basis units and stays correct across breakpoints.
	 */
	function initCarousel( root ) {
		var track    = root.querySelector( '[data-blueva-carousel-track]' );
		var slides   = Array.prototype.slice.call( root.querySelectorAll( '[data-blueva-carousel-slide]' ) );
		var prevBtn  = root.querySelector( '[data-blueva-carousel-prev]' );
		var nextBtn  = root.querySelector( '[data-blueva-carousel-next]' );
		var viewport = root.querySelector( '.blueva-carousel-viewport' );

		if ( ! track || ! slides.length || ! viewport ) {
			return;
		}

		var activeIndex = slides.findIndex( function ( slide ) {
			return slide.classList.contains( 'is-active' );
		} );
		if ( activeIndex < 0 ) {
			activeIndex = 0;
		}

		function setActive( index ) {
			index = Math.max( 0, Math.min( slides.length - 1, index ) );

			slides.forEach( function ( slide, i ) {
				var isActive = i === index;
				slide.classList.toggle( 'is-active', isActive );
				var link = slide.querySelector( '.blueva-carousel-image' );
				if ( link ) {
					link.setAttribute( 'tabindex', isActive ? '0' : '-1' );
				}
			} );

			activeIndex = index;
			position();

			if ( prevBtn ) {
				prevBtn.disabled = 0 === index;
			}
			if ( nextBtn ) {
				nextBtn.disabled = index === slides.length - 1;
			}
		}

		function position() {
			var slide         = slides[ activeIndex ];
			var viewportWidth = viewport.clientWidth;
			var slideCenter   = slide.offsetLeft + slide.offsetWidth / 2;
			var offset        = viewportWidth / 2 - slideCenter;
			track.style.transform = 'translateX(' + offset + 'px)';
		}

		if ( prevBtn ) {
			prevBtn.addEventListener( 'click', function () {
				setActive( activeIndex - 1 );
			} );
		}
		if ( nextBtn ) {
			nextBtn.addEventListener( 'click', function () {
				setActive( activeIndex + 1 );
			} );
		}

		// Clicking a dimmed neighbor brings it to the front, matching
		// what the peek layout visually invites people to do.
		slides.forEach( function ( slide, i ) {
			slide.addEventListener( 'click', function ( e ) {
				if ( i !== activeIndex ) {
					e.preventDefault();
					setActive( i );
				}
			} );
		} );

		var resizeTimer;
		window.addEventListener( 'resize', function () {
			clearTimeout( resizeTimer );
			resizeTimer = setTimeout( position, 100 );
		} );

		// Position after layout/fonts/images settle.
		window.addEventListener( 'load', position );
		setActive( activeIndex );
	}

	/**
	 * Product video: custom play/pause, mute/unmute, and a big center
	 * play button shown until first playback (poster fallback stays
	 * fully functional if the person never presses play).
	 */
	function initVideo( wrap ) {
		var video    = wrap.querySelector( '[data-blueva-video]' );
		var bigPlay  = wrap.querySelector( '[data-blueva-video-bigplay]' );
		var playPause = wrap.querySelector( '[data-blueva-video-playpause]' );
		var muteBtn  = wrap.querySelector( '[data-blueva-video-mute]' );

		if ( ! video ) {
			return;
		}

		function updatePlayIcon() {
			if ( ! playPause ) {
				return;
			}
			var playIcon  = playPause.querySelector( '[data-blueva-icon-play]' );
			var pauseIcon = playPause.querySelector( '[data-blueva-icon-pause]' );
			var isPaused  = video.paused;
			if ( playIcon ) {
				playIcon.hidden = ! isPaused;
			}
			if ( pauseIcon ) {
				pauseIcon.hidden = isPaused;
			}
			playPause.setAttribute( 'aria-label', isPaused ? 'Lecture' : 'Pause' );
		}

		function updateMuteIcon() {
			if ( ! muteBtn ) {
				return;
			}
			var mutedIcon   = muteBtn.querySelector( '[data-blueva-icon-muted]' );
			var unmutedIcon = muteBtn.querySelector( '[data-blueva-icon-unmuted]' );
			if ( mutedIcon ) {
				mutedIcon.hidden = ! video.muted;
			}
			if ( unmutedIcon ) {
				unmutedIcon.hidden = video.muted;
			}
			muteBtn.setAttribute( 'aria-label', video.muted ? 'Activer le son' : 'Couper le son' );
		}

		if ( bigPlay ) {
			bigPlay.addEventListener( 'click', function () {
				video.play();
				bigPlay.classList.add( 'is-hidden' );
			} );
		}

		if ( playPause ) {
			playPause.addEventListener( 'click', function () {
				if ( video.paused ) {
					video.play();
				} else {
					video.pause();
				}
			} );
		}

		if ( muteBtn ) {
			muteBtn.addEventListener( 'click', function () {
				video.muted = ! video.muted;
				updateMuteIcon();
			} );
		}

		video.addEventListener( 'play', function () {
			updatePlayIcon();
			if ( bigPlay ) {
				bigPlay.classList.add( 'is-hidden' );
			}
		} );
		video.addEventListener( 'pause', updatePlayIcon );

		updatePlayIcon();
		updateMuteIcon();
	}
} )();
