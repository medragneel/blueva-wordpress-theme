/**
 * BLUEVA header interactions.
 * No dependencies (no jQuery required) — vanilla JS, deferred by default
 * since it is enqueued with `true` for the footer arg in inc/enqueue.php.
 *
 * @package Blueva
 */
( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		initMobileMenu();
		initCategoriesDropdown();
		initMobileAccordion();
		initMobileSearchToggle();
	} );

	/**
	 * Off-canvas mobile navigation drawer.
	 */
	function initMobileMenu() {
		var openBtn = document.querySelector( '[data-blueva-open-menu]' );
		var closeBtn = document.querySelector( '[data-blueva-close-menu]' );
		var menu = document.getElementById( 'blueva-mobile-menu' );
		var overlay = document.querySelector( '[data-blueva-overlay]' );

		if ( ! openBtn || ! menu || ! overlay ) {
			return;
		}

		function open() {
			menu.classList.add( 'is-open' );
			overlay.hidden = false;
			requestAnimationFrame( function () {
				overlay.classList.add( 'is-visible' );
			} );
			menu.setAttribute( 'aria-hidden', 'false' );
			openBtn.setAttribute( 'aria-expanded', 'true' );
			document.body.style.overflow = 'hidden';
			var firstLink = menu.querySelector( 'a, button' );
			if ( firstLink ) {
				firstLink.focus();
			}
		}

		function close() {
			menu.classList.remove( 'is-open' );
			overlay.classList.remove( 'is-visible' );
			menu.setAttribute( 'aria-hidden', 'true' );
			openBtn.setAttribute( 'aria-expanded', 'false' );
			document.body.style.overflow = '';
			setTimeout( function () {
				overlay.hidden = true;
			}, 250 );
			openBtn.focus();
		}

		openBtn.addEventListener( 'click', open );
		if ( closeBtn ) {
			closeBtn.addEventListener( 'click', close );
		}
		overlay.addEventListener( 'click', close );

		document.addEventListener( 'keydown', function ( e ) {
			if ( 'Escape' === e.key && menu.classList.contains( 'is-open' ) ) {
				close();
			}
		} );
	}

	/**
	 * Desktop "Categories" dropdown — click to open, click outside or
	 * Escape to close, keyboard accessible via native button semantics.
	 */
	function initCategoriesDropdown() {
		var toggle = document.querySelector( '[data-blueva-dropdown-toggle]' );
		var dropdown = document.querySelector( '[data-blueva-dropdown-menu]' );

		if ( ! toggle || ! dropdown ) {
			return;
		}

		function close() {
			dropdown.classList.remove( 'is-open' );
			toggle.setAttribute( 'aria-expanded', 'false' );
		}

		function toggleOpen() {
			var isOpen = dropdown.classList.toggle( 'is-open' );
			toggle.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
		}

		toggle.addEventListener( 'click', function ( e ) {
			e.stopPropagation();
			toggleOpen();
		} );

		document.addEventListener( 'click', function ( e ) {
			if ( ! dropdown.contains( e.target ) && e.target !== toggle ) {
				close();
			}
		} );

		document.addEventListener( 'keydown', function ( e ) {
			if ( 'Escape' === e.key ) {
				close();
			}
		} );
	}

	/**
	 * Mobile drawer "Categories" accordion.
	 */
	function initMobileAccordion() {
		var toggle = document.querySelector( '[data-blueva-accordion-toggle]' );
		var panel = document.querySelector( '[data-blueva-accordion-panel]' );

		if ( ! toggle || ! panel ) {
			return;
		}

		toggle.addEventListener( 'click', function () {
			var isOpen = toggle.getAttribute( 'aria-expanded' ) === 'true';
			toggle.setAttribute( 'aria-expanded', isOpen ? 'false' : 'true' );
			panel.hidden = isOpen;
		} );
	}

	/**
	 * Mobile slide-down search bar under the compact header.
	 */
	function initMobileSearchToggle() {
		var toggle = document.querySelector( '[data-blueva-open-search]' );
		var panel = document.querySelector( '[data-blueva-search-panel]' );
		var closeBtn = document.querySelector( '[data-blueva-close-search]' );

		if ( ! toggle || ! panel ) {
			return;
		}

		function open() {
			panel.classList.add( 'is-open' );
			toggle.setAttribute( 'aria-expanded', 'true' );
			var input = panel.querySelector( 'input[type="search"]' );
			if ( input ) {
				// Wait for the open transition so mobile keyboards don't
				// fight the panel's slide-down animation.
				setTimeout( function () {
					input.focus();
				}, 150 );
			}
		}

		function close() {
			panel.classList.remove( 'is-open' );
			toggle.setAttribute( 'aria-expanded', 'false' );
		}

		toggle.addEventListener( 'click', function () {
			if ( panel.classList.contains( 'is-open' ) ) {
				close();
			} else {
				open();
			}
		} );

		if ( closeBtn ) {
			closeBtn.addEventListener( 'click', close );
		}

		document.addEventListener( 'keydown', function ( e ) {
			if ( 'Escape' === e.key && panel.classList.contains( 'is-open' ) ) {
				close();
			}
		} );

		document.addEventListener( 'click', function ( e ) {
			if ( panel.classList.contains( 'is-open' ) && ! panel.contains( e.target ) && e.target !== toggle ) {
				close();
			}
		} );
	}
} )();
