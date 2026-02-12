/**
 * Oneguy Child Theme - Customizer Controls JS
 * Handles visibility toggles and custom font support
 */
(function () {
	wp.customize.bind('ready', function () {

		// Disable divider options in the font dropdown
		wp.customize.control('minimalio_typography_options_google_font', function (control) {
			control.container.find('select option').each(function () {
				if (this.value.indexOf('---') === 0) {
					this.disabled = true;
				}
			});
		});

		// Handle custom font selection in the font dropdown
		wp.customize('minimalio_typography_settings_google_font', function (setting) {
			wp.customize.control('minimalio_typography_options_google_font', function (control) {
				control.setting.bind(function (to) {
					// Check if selected font is a custom font
					if (to && (to.indexOf('custom_') === 0 || to.indexOf('simple_') === 0)) {
						var fontWeight = wp.customize.control('minimalio_typography_options_google_font_weight').container.find('select');
						var fontStyle = wp.customize.control('minimalio_typography_options_google_font_style').container.find('select');

						if (to.indexOf('simple_') === 0) {
							// Simple fonts: 400 and 700
							fontWeight.empty();
							fontWeight.append('<option value="400" selected>400</option><option value="700">700</option>');
							fontStyle.empty();
							fontStyle.append('<option value="normal" selected>Regular</option><option value="italic">Italic</option>');
						} else {
							// Advanced fonts: default weights (will be populated by PHP on reload)
							fontWeight.empty();
							fontWeight.append('<option value="400" selected>400</option><option value="700">700</option>');
							fontStyle.empty();
							fontStyle.append('<option value="normal" selected>Regular</option><option value="italic">Italic</option>');
						}

						// Prevent the parent theme's Google API fetch
						return false;
					}
				});
			});
		});

		// Only show tagline color when show tagline is yes
		wp.customize('minimalio_settings_show_tagline', function (setting) {
			wp.customize.control('minimalio_options_tagline_color', function (control) {
				var visibility = function () {
					if ('yes' === setting.get()) {
						control.container.slideDown(180);
					} else {
						control.container.slideUp(180);
					}
				};

				visibility();
				setting.bind(visibility);
			});
		});

		// Only show header extra text controls when vertical header is selected
		wp.customize('minimalio_settings_header_variation', function (setting) {
			var extraTextControls = [
				'minimalio_header_options_header_extra_text',
				'minimalio_header_options_header_extra_text_font_size',
				'minimalio_header_options_header_extra_text_font'
			];

			extraTextControls.forEach(function (controlId) {
				wp.customize.control(controlId, function (control) {
					var visibility = function () {
						if ('vertical' === setting.get()) {
							control.container.slideDown(180);
						} else {
							control.container.slideUp(180);
						}
					};

					visibility();
					setting.bind(visibility);
				});
			});
		});

		// Disable divider options in the extra text font dropdown
		wp.customize.control('minimalio_header_options_header_extra_text_font', function (control) {
			control.container.find('select option').each(function () {
				if (this.value.indexOf('---') === 0) {
					this.disabled = true;
				}
			});
		});

	});
})();
