/**
 * Oneguy Child Theme - Portfolio Heart/Like
 * Handles click events and AJAX calls for the heart/like feature.
 */
(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', function () {
		var btn = document.querySelector('.oneguy-heart-btn');
		if (!btn) return;

		var icon = btn.querySelector('.oneguy-heart-icon');
		var countEl = btn.querySelector('.oneguy-heart-count');
		var busy = false;
		var isOverlay = oneguyHeart.position === 'bottom-left' || oneguyHeart.position === 'bottom-right';

		function formatCount(n) {
			if (n >= 1000000) {
				var m = (n / 1000000).toFixed(1);
				return parseFloat(m) + 'M';
			}
			if (n >= 1000) {
				var k = (n / 1000).toFixed(1);
				return parseFloat(k) + 'k';
			}
			return String(n);
		}

		function setLiked() {
			icon.setAttribute('fill', '#e74c3c');
			icon.setAttribute('stroke', '#e74c3c');
		}

		function setUnliked() {
			icon.setAttribute('fill', 'none');
			icon.setAttribute('stroke', isOverlay ? '#fff' : 'currentColor');
		}

		// Set initial state
		if (oneguyHeart.liked) {
			setLiked();
		}

		btn.addEventListener('click', function (e) {
			e.preventDefault();
			if (busy) return;
			busy = true;

			var xhr = new XMLHttpRequest();
			xhr.open('POST', oneguyHeart.ajaxUrl, true);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

			xhr.onreadystatechange = function () {
				if (xhr.readyState !== 4) return;
				busy = false;

				if (xhr.status === 200) {
					try {
						var res = JSON.parse(xhr.responseText);
						if (res.success) {
							countEl.textContent = formatCount(res.data.count);
							if (res.data.liked) {
								setLiked();
							} else {
								setUnliked();
							}
						}
					} catch (err) {
						// Silent fail
					}
				}
			};

			xhr.send(
				'action=oneguy_portfolio_heart'
				+ '&post_id=' + oneguyHeart.postId
				+ '&nonce=' + oneguyHeart.nonce
			);
		});

		// Hover effect — only for image overlay mode
		if (isOverlay) {
			btn.addEventListener('mouseenter', function () {
				btn.style.background = 'rgba(0,0,0,0.7)';
			});
			btn.addEventListener('mouseleave', function () {
				btn.style.background = 'rgba(0,0,0,0.5)';
			});
		}
	});
})();
