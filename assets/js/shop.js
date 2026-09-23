/**
 * BLUEVA shop/category page interactions.
 *
 * @package Blueva
 */
( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		initFilterDropdowns();
		initPriceBandSync();
		document.querySelectorAll( '[data-blueva-video-wrap]' ).forEach( initVideo );
	} );

	/**
	 * <details> dropdowns already work with zero JS. This just adds the
	 * expected "only one open at a time" + outside-click-to-close polish
	 * that a native <details> doesn't give you for free.
	 */
	function initFilterDropdowns() {
		var dropdowns = document.querySelectorAll( '[data-blueva-filter-dropdown]' );

		if ( ! dropdowns.length ) {
			return;
		}

		dropdowns.forEach( function ( dropdown ) {
			dropdown.addEventListener( 'toggle', function () {
				if ( dropdown.open ) {
					dropdowns.forEach( function ( other ) {
						if ( other !== dropdown ) {
							other.open = false;
						}
					} );
				}
			} );
		} );

		document.addEventListener( 'click', function ( e ) {
			dropdowns.forEach( function ( dropdown ) {
				if ( dropdown.open && ! dropdown.contains( e.target ) ) {
					dropdown.open = false;
				}
			} );
		} );

		document.addEventListener( 'keydown', function ( e ) {
			if ( 'Escape' === e.key ) {
				dropdowns.forEach( function ( dropdown ) {
					dropdown.open = false;
				} );
			}
		} );
	}

	/**
	 * The "Prix" dropdown uses one radio per band (with data-min/data-max)
	 * so only one can be active at a time. Since WooCommerce's query
	 * reads blueva_min_price/blueva_max_price GET params (deliberately not
	 * WooCommerce's own reserved min_price/max_price names - see inc/shop.php),
	 * copy the checked
	 * band's range into the hidden fields before the form submits.
	 */
	function initPriceBandSync() {
		var radios    = document.querySelectorAll( 'input[name="price_band"]' );
		var minField  = document.querySelector( '[data-blueva-min-price]' );
		var maxField  = document.querySelector( '[data-blueva-max-price]' );

		if ( ! radios.length || ! minField || ! maxField ) {
			return;
		}

		function sync() {
			var checked = document.querySelector( 'input[name="price_band"]:checked' );
			minField.value = checked ? ( checked.getAttribute( 'data-min' ) || '' ) : '';
			maxField.value = checked ? ( checked.getAttribute( 'data-max' ) || '' ) : '';
		}

		radios.forEach( function ( radio ) {
			radio.addEventListener( 'change', sync );
		} );

		// Also sync right before submit, in case the browser restored a
		// checked radio without firing 'change' (e.g. back/forward nav).
		var form = document.querySelector( '.blueva-shop-filters-form' );
		if ( form ) {
			form.addEventListener( 'submit', sync );
		}
	}

	/**
	 * Archive header video controls — same behavior as the homepage
	 * video section, duplicated here since this bundle only loads on
	 * shop/category pages (see inc/shop.php).
	 */
	function initVideo( wrap ) {
		var video      = wrap.querySelector( '[data-blueva-video]' );
		var playPause  = wrap.querySelector( '[data-blueva-video-playpause]' );
		var muteBtn    = wrap.querySelector( '[data-blueva-video-mute]' );

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
				playIcon.classList.toggle( 'blueva-icon-hidden', ! isPaused );
			}
			if ( pauseIcon ) {
				pauseIcon.classList.toggle( 'blueva-icon-hidden', isPaused );
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
				mutedIcon.classList.toggle( 'blueva-icon-hidden', ! video.muted );
			}
			if ( unmutedIcon ) {
				unmutedIcon.classList.toggle( 'blueva-icon-hidden', video.muted );
			}
			muteBtn.setAttribute( 'aria-label', video.muted ? 'Activer le son' : 'Couper le son' );
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

		video.addEventListener( 'play', updatePlayIcon );
		video.addEventListener( 'pause', updatePlayIcon );

		video.play().catch( function () {
			// Autoplay blocked (some mobile browsers) — leave paused,
			// the visible play button lets the person start it.
			updatePlayIcon();
		} );

		updatePlayIcon();
		updateMuteIcon();
	}
} )();
