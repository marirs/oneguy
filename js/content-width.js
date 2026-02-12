/**
 * Oneguy Child Theme - Content Width Behavior
 * When constrained mode is active, undo the parent theme's full-width Gutenberg sizing
 */
(function () {
	if (window.minimalioContentWidthBehavior === 'constrained') {
		// Remove full-width sizing applied by parent theme
		var alignfullElements = document.querySelectorAll('.entry-content > .alignfull');
		alignfullElements.forEach(function (element) {
			element.style.width = '';
			element.style.marginLeft = '';
		});

		// Also handle resize events
		window.addEventListener('resize', function () {
			var els = document.querySelectorAll('.entry-content > .alignfull');
			els.forEach(function (element) {
				element.style.width = '';
				element.style.marginLeft = '';
			});
		});
	}
})();
