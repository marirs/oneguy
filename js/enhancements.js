/**
 * Oneguy Child Theme - UI Enhancements
 * 1. Fade-in on scroll for portfolio grid images (IntersectionObserver)
 * 2. Back to top button
 */
(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', function () {

		// =====================================================================
		// 1. Fade-in on scroll for portfolio grid items
		// =====================================================================

		var items = document.querySelectorAll('.post-item, .post-card');
		if (items.length && 'IntersectionObserver' in window) {
			items.forEach(function (item) {
				item.style.opacity = '0';
				item.style.transform = 'translateY(20px)';
				item.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
			});

			var observer = new IntersectionObserver(function (entries) {
				entries.forEach(function (entry) {
					if (entry.isIntersecting) {
						entry.target.style.opacity = '1';
						entry.target.style.transform = 'translateY(0)';
						observer.unobserve(entry.target);
					}
				});
			}, { threshold: 0.1 });

			items.forEach(function (item) {
				observer.observe(item);
			});
		}

		// =====================================================================
		// 2. Back to top button
		// =====================================================================

		var btn = document.createElement('button');
		btn.className = 'oneguy-back-to-top';
		btn.setAttribute('aria-label', 'Back to top');
		btn.textContent = '\u2191';
		document.body.appendChild(btn);

		var scrollThreshold = 300;
		var visible = false;

		function toggleBtn() {
			var shouldShow = window.scrollY > scrollThreshold;
			if (shouldShow && !visible) {
				btn.style.opacity = '1';
				btn.style.pointerEvents = 'auto';
				visible = true;
			} else if (!shouldShow && visible) {
				btn.style.opacity = '0';
				btn.style.pointerEvents = 'none';
				visible = false;
			}
		}

		window.addEventListener('scroll', toggleBtn, { passive: true });
		toggleBtn();

		btn.addEventListener('click', function () {
			window.scrollTo({ top: 0, behavior: 'smooth' });
		});
	});
})();
