/**
 * BLUEVA footer scroll-reveal.
 *
 * Pure progressive enhancement: the footer is fully visible by default.
 * Only if JS runs AND IntersectionObserver exists AND the person hasn't
 * asked for reduced motion do we add the classes that fade/slide it in
 * on scroll — so nothing ever depends on this running.
 *
 * @package Blueva
 */
( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		var footer = document.getElementById( 'blueva-footer' );

		if ( ! footer || ! ( 'IntersectionObserver' in window ) ) {
			return;
		}

		var prefersReducedMotion = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
		if ( prefersReducedMotion ) {
			return;
		}

		footer.classList.add( 'blueva-fade-init' );

		var observer = new IntersectionObserver(
			function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( entry.isIntersecting ) {
						footer.classList.add( 'is-visible' );
						observer.unobserve( entry.target );
					}
				} );
			},
			{ threshold: 0.15 }
		);

		observer.observe( footer );
	} );
} )();
