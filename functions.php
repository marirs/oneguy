<?php
/**
 * Oneguy Child Theme - Functions
 *
 * @package oneguy
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Enqueue parent and child theme styles
 */
function oneguy_enqueue_styles() {
	wp_enqueue_style( 'minimalio-parent-style', get_template_directory_uri() . '/style.css', [], wp_get_theme()->parent()->get( 'Version' ) );
	wp_enqueue_style( 'oneguy-child-style', get_stylesheet_directory_uri() . '/style.css', [ 'minimalio-parent-style' ], wp_get_theme()->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'oneguy_enqueue_styles' );

/**
 * Include unified font upload functionality
 */
require_once get_stylesheet_directory() . '/inc/unified-font-upload.php';

/**
 * Get font family name from font selection (custom/simple fonts)
 */
function oneguy_get_font_family_name( $font_selection ) {
	// Check if it's a custom font
	if ( strpos( $font_selection, 'custom_' ) === 0 ) {
		$font_id = substr( $font_selection, 7 ); // Remove 'custom_' prefix
		$custom_fonts = get_option( 'minimalio_custom_fonts', [] );
		
		if ( isset( $custom_fonts[$font_id] ) ) {
			return $custom_fonts[$font_id]['name'];
		}
	}
	
	// Check if it's a simple custom font
	if ( strpos( $font_selection, 'simple_' ) === 0 ) {
		$font_id = substr( $font_selection, 7 ); // Remove 'simple_' prefix
		$simple_fonts = get_option( 'minimalio_simple_custom_fonts', [] );
		
		if ( isset( $simple_fonts[$font_id] ) ) {
			return $simple_fonts[$font_id]['name'];
		}
	}
	
	// Return the original font selection for Google fonts and web-safe fonts
	return $font_selection;
}

/**
 * Get font weight from variant name
 */
function oneguy_get_font_weight_from_variant( $variant ) {
	$weights = [
		'100' => '100',
		'100italic' => '100',
		'200' => '200',
		'200italic' => '200',
		'300' => '300',
		'300italic' => '300',
		'regular' => '400',
		'italic' => '400',
		'500' => '500',
		'500italic' => '500',
		'600' => '600',
		'600italic' => '600',
		'700' => '700',
		'700italic' => '700',
		'800' => '800',
		'800italic' => '800',
		'900' => '900',
		'900italic' => '900',
	];
	
	return isset( $weights[$variant] ) ? $weights[$variant] : '400';
}

// Make the function available under the parent theme's expected name too
if ( ! function_exists( 'minimalio_get_font_family_name' ) ) {
	function minimalio_get_font_family_name( $font_selection ) {
		return oneguy_get_font_family_name( $font_selection );
	}
}

if ( ! function_exists( 'minimalio_get_font_weight_from_variant' ) ) {
	function minimalio_get_font_weight_from_variant( $variant ) {
		return oneguy_get_font_weight_from_variant( $variant );
	}
}

/**
 * Fallback Google Fonts list when the API is unreachable.
 * Key = slug (spaces replaced with +), Value = display name.
 */
function oneguy_get_fallback_google_fonts() {
	return [
		'ABeeZee'              => 'ABeeZee',
		'Abel'                 => 'Abel',
		'Abril+Fatface'        => 'Abril Fatface',
		'Alegreya'             => 'Alegreya',
		'Alegreya+Sans'        => 'Alegreya Sans',
		'Amatic+SC'            => 'Amatic SC',
		'Archivo'              => 'Archivo',
		'Archivo+Narrow'       => 'Archivo Narrow',
		'Arimo'                => 'Arimo',
		'Arvo'                 => 'Arvo',
		'Asap'                 => 'Asap',
		'Assistant'            => 'Assistant',
		'Barlow'               => 'Barlow',
		'Barlow+Condensed'     => 'Barlow Condensed',
		'Bebas+Neue'           => 'Bebas Neue',
		'Bitter'               => 'Bitter',
		'Cabin'                => 'Cabin',
		'Cairo'                => 'Cairo',
		'Catamaran'            => 'Catamaran',
		'Caveat'               => 'Caveat',
		'Comfortaa'            => 'Comfortaa',
		'Cormorant+Garamond'   => 'Cormorant Garamond',
		'Crimson+Text'         => 'Crimson Text',
		'DM+Sans'              => 'DM Sans',
		'DM+Serif+Display'     => 'DM Serif Display',
		'Dancing+Script'       => 'Dancing Script',
		'Dosis'                => 'Dosis',
		'EB+Garamond'          => 'EB Garamond',
		'Exo+2'                => 'Exo 2',
		'Fira+Sans'            => 'Fira Sans',
		'Fira+Sans+Condensed'  => 'Fira Sans Condensed',
		'Fjalla+One'           => 'Fjalla One',
		'Heebo'                => 'Heebo',
		'Hind'                 => 'Hind',
		'Hind+Siliguri'        => 'Hind Siliguri',
		'IBM+Plex+Mono'        => 'IBM Plex Mono',
		'IBM+Plex+Sans'        => 'IBM Plex Sans',
		'IBM+Plex+Serif'       => 'IBM Plex Serif',
		'Inconsolata'          => 'Inconsolata',
		'Inter'                => 'Inter',
		'Josefin+Sans'         => 'Josefin Sans',
		'Josefin+Slab'         => 'Josefin Slab',
		'Jost'                 => 'Jost',
		'Kanit'                => 'Kanit',
		'Karla'                => 'Karla',
		'Lato'                 => 'Lato',
		'Lexend'               => 'Lexend',
		'Libre+Baskerville'    => 'Libre Baskerville',
		'Libre+Franklin'       => 'Libre Franklin',
		'Lora'                 => 'Lora',
		'Manrope'              => 'Manrope',
		'Maven+Pro'            => 'Maven Pro',
		'Merriweather'         => 'Merriweather',
		'Merriweather+Sans'    => 'Merriweather Sans',
		'Montserrat'           => 'Montserrat',
		'Montserrat+Alternates' => 'Montserrat Alternates',
		'Mukta'                => 'Mukta',
		'Mulish'               => 'Mulish',
		'Nanum+Gothic'         => 'Nanum Gothic',
		'Noto+Sans'            => 'Noto Sans',
		'Noto+Sans+JP'         => 'Noto Sans JP',
		'Noto+Serif'           => 'Noto Serif',
		'Nunito'               => 'Nunito',
		'Nunito+Sans'          => 'Nunito Sans',
		'Old+Standard+TT'      => 'Old Standard TT',
		'Open+Sans'            => 'Open Sans',
		'Oswald'               => 'Oswald',
		'Outfit'               => 'Outfit',
		'Overpass'             => 'Overpass',
		'Oxygen'               => 'Oxygen',
		'PT+Sans'              => 'PT Sans',
		'PT+Serif'             => 'PT Serif',
		'Pacifico'             => 'Pacifico',
		'Playfair+Display'     => 'Playfair Display',
		'Poppins'              => 'Poppins',
		'Prompt'               => 'Prompt',
		'Quicksand'            => 'Quicksand',
		'Rajdhani'             => 'Rajdhani',
		'Raleway'              => 'Raleway',
		'Roboto'               => 'Roboto',
		'Roboto+Condensed'     => 'Roboto Condensed',
		'Roboto+Mono'          => 'Roboto Mono',
		'Roboto+Slab'          => 'Roboto Slab',
		'Rubik'                => 'Rubik',
		'Saira+Condensed'      => 'Saira Condensed',
		'Satisfy'              => 'Satisfy',
		'Shadows+Into+Light'   => 'Shadows Into Light',
		'Signika+Negative'     => 'Signika Negative',
		'Slabo+27px'           => 'Slabo 27px',
		'Source+Code+Pro'      => 'Source Code Pro',
		'Source+Sans+3'        => 'Source Sans 3',
		'Source+Serif+4'       => 'Source Serif 4',
		'Space+Grotesk'        => 'Space Grotesk',
		'Space+Mono'           => 'Space Mono',
		'Spectral'             => 'Spectral',
		'Titillium+Web'        => 'Titillium Web',
		'Ubuntu'               => 'Ubuntu',
		'Varela+Round'         => 'Varela Round',
		'Work+Sans'            => 'Work Sans',
		'Yanone+Kaffeesatz'    => 'Yanone Kaffeesatz',
		'Zilla+Slab'           => 'Zilla Slab',
	];
}

/**
 * Override parent's font family CSS generation to support custom fonts
 */
function oneguy_override_dynamic_styles() {
	$main_font = get_theme_mod( 'minimalio_typography_settings_google_font' );
	if ( $main_font && ( strpos( $main_font, 'custom_' ) === 0 || strpos( $main_font, 'simple_' ) === 0 ) ) {
		$font_family_name = oneguy_get_font_family_name( $main_font );
		$css = sprintf( 'body {font-family:%s, %s } ', esc_attr( $font_family_name ), 'sans-serif' );
		wp_add_inline_style( 'layout-options', $css );
	}
}
add_action( 'wp_enqueue_scripts', 'oneguy_override_dynamic_styles', 20 );

/**
 * Add content width behavior JS variable + override script
 */
function oneguy_content_width_js() {
	wp_add_inline_script( 'minimalio-theme', "
		window.minimalioContentWidthBehavior = '" . esc_js( get_theme_mod( 'minimalio_settings_content_width_behavior', 'constrained' ) ) . "';
	", 'before' );

	wp_enqueue_script(
		'oneguy-content-width',
		get_stylesheet_directory_uri() . '/js/content-width.js',
		[ 'minimalio-theme' ],
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'oneguy_content_width_js' );

/**
 * Load Google font for header extra text if needed
 */
function oneguy_load_extra_text_font() {
	$extra_font = get_theme_mod( 'minimalio_settings_header_extra_text_font', 'inherit' );
	if ( ! $extra_font || $extra_font === 'inherit' ) {
		return;
	}

	// Skip custom fonts and simple fonts (they have their own @font-face)
	if ( strpos( $extra_font, 'custom_' ) === 0 || strpos( $extra_font, 'simple_' ) === 0 ) {
		return;
	}

	// Skip web-safe fonts
	$safe_fonts = [ 'Arial', 'Verdana', 'Tahoma', 'Times+New+Roman', 'Georgia', 'Garamond', 'Courier+New', 'Brush+Script+MT' ];
	if ( in_array( $extra_font, $safe_fonts, true ) ) {
		return;
	}

	// Skip if same as body font (already loaded by parent)
	$body_font = get_theme_mod( 'minimalio_typography_settings_google_font' );
	if ( $extra_font === $body_font ) {
		return;
	}

	// Load from Google Fonts
	wp_enqueue_style(
		'oneguy-extra-text-font',
		'https://fonts.googleapis.com/css2?family=' . esc_attr( $extra_font ) . ':wght@400;700&display=swap',
		[],
		null
	);
}
add_action( 'wp_enqueue_scripts', 'oneguy_load_extra_text_font' );

/**
 * Custom comment form title for portfolio posts
 */
function oneguy_portfolio_comment_form_title( $defaults ) {
	if ( is_singular( 'portfolio' ) ) {
		$custom_title = get_theme_mod( 'minimalio_settings_single_portfolio_comments_title' );
		if ( $custom_title ) {
			$defaults['title_reply'] = esc_html( $custom_title );
		}
	} elseif ( is_singular( 'post' ) ) {
		$custom_title = get_theme_mod( 'minimalio_settings_single_post_comments_title' );
		if ( $custom_title ) {
			$defaults['title_reply'] = esc_html( $custom_title );
		}
	}
	return $defaults;
}
add_filter( 'comment_form_defaults', 'oneguy_portfolio_comment_form_title' );

/**
 * Add comment support to portfolio post type when enabled
 */
function oneguy_portfolio_comment_support() {
	if ( get_theme_mod( 'minimalio_settings_single_portfolio_comments', 'no' ) === 'yes' ) {
		add_post_type_support( 'portfolio', 'comments' );
	}
}
add_action( 'init', 'oneguy_portfolio_comment_support' );

/**
 * Add additional dynamic CSS for child theme customizer options
 */
function oneguy_dynamic_css() {
	$css = '';

	// Text transform
	$text_transform = get_theme_mod( 'minimalio_settings_text_transform' );
	if ( $text_transform && $text_transform !== 'none' ) {
		$css .= sprintf( 'body {text-transform: %s } ', esc_attr( $text_transform ) );
	}

	// Blog text alignment
	$blog_text_align = get_theme_mod( 'minimalio_settings_blog_text_align' );
	if ( $blog_text_align ) {
		$css .= sprintf( '.single-post .entry-content, .blog-post-type .post-card__excerpt {text-align: %s } ', esc_attr( $blog_text_align ) );
	}

	// Content width behavior (blog)
	$content_width_behavior = get_theme_mod( 'minimalio_settings_content_width_behavior' );
	if ( $content_width_behavior === 'constrained' ) {
		$css .= '.single-post .single-post__thumbnail {
			max-width: 1240px !important;
			margin: 0 0 2rem 0 !important;
			width: 100% !important;
			left: auto !important;
			right: auto !important;
			transform: none !important;
			position: relative !important;
		}
		.single-post .single-post__content {
			max-width: 1240px !important;
			margin: 0 !important;
			width: 100% !important;
		}
		.single-post .entry-content > .alignfull,
		.single-post .entry-content > .alignfull[style] {
			max-width: 1240px !important;
			margin: 0 !important;
			width: 100% !important;
			margin-left: 0 !important;
			margin-right: 0 !important;
			left: auto !important;
			right: auto !important;
			transform: none !important;
			position: relative !important;
		}
		.single-post .entry-footer,
		.single-post .comment-respond,
		.single-post .comments-area {
			max-width: 1240px !important;
			margin: 0 !important;
			width: 100% !important;
		}';
	}

	// Content width behavior (portfolio)
	$portfolio_width_behavior = get_theme_mod( 'minimalio_settings_portfolio_content_width_behavior' );
	if ( $portfolio_width_behavior === 'constrained' ) {
		$css .= '.single-portfolio .single-post__thumbnail {
			max-width: 1240px !important;
			margin: 0 0 2rem 0 !important;
			width: 100% !important;
			left: auto !important;
			right: auto !important;
			transform: none !important;
			position: relative !important;
		}
		.single-portfolio .single-post__content {
			max-width: 1240px !important;
			margin: 0 !important;
			width: 100% !important;
		}
		.single-portfolio .entry-content > .alignfull,
		.single-portfolio .entry-content > .alignfull[style] {
			max-width: 1240px !important;
			margin: 0 !important;
			width: 100% !important;
			margin-left: 0 !important;
			margin-right: 0 !important;
			left: auto !important;
			right: auto !important;
			transform: none !important;
			position: relative !important;
		}
		.single-portfolio .entry-footer,
		.single-portfolio .comment-respond,
		.single-portfolio .comments-area {
			max-width: 1240px !important;
			margin: 0 !important;
			width: 100% !important;
		}';
	}

	// Typography: Font sizes
	$font_size_map = [
		'body'       => 'body',
		'p'          => 'p',
		'h1'         => 'h1',
		'h2'         => 'h2',
		'h3'         => 'h3',
		'h4'         => 'h4',
		'h5'         => 'h5',
		'h6'         => 'h6',
		'blockquote' => 'blockquote',
		'li'         => 'li, ol li, ul li',
	];
	foreach ( $font_size_map as $key => $selector ) {
		$size = get_theme_mod( 'minimalio_settings_font_size_' . $key );
		if ( $size ) {
			// Auto-append px if user entered just a number
			if ( is_numeric( $size ) ) {
				$size .= 'px';
			}
			$css .= sprintf( '%s { font-size: %s !important; } ', esc_attr( $selector ), esc_attr( $size ) );
		}
	}

	// Single portfolio featured image size
	$image_size = get_theme_mod( 'minimalio_settings_single_portfolio_image_ratio', 'original' );
	if ( $image_size && $image_size !== 'original' ) {
		$css .= sprintf(
			'.single-portfolio .single-post__thumbnail img { width: %s !important; height: auto; } ',
			esc_attr( $image_size )
		);
	}

	// Portfolio comment title colors
	// Portfolio display title color (showcase/archive page)
	$portfolio_title_color = get_theme_mod( 'minimalio_settings_portfolio_title_color' );
	if ( $portfolio_title_color ) {
		$css .= sprintf( '.portfolio-post-type .post-card__heading { color: %s !important; } ', esc_attr( $portfolio_title_color ) );
	}

	// Single portfolio title color (inner post page)
	$single_portfolio_title_color = get_theme_mod( 'minimalio_settings_single_portfolio_title_color' );
	if ( $single_portfolio_title_color ) {
		$css .= sprintf( 'body.single-portfolio .entry-title, .single-portfolio .entry-title { color: %s !important; } ', esc_attr( $single_portfolio_title_color ) );
	}

	$comment_title_color = get_theme_mod( 'minimalio_settings_single_portfolio_comments_title_color' );
	if ( $comment_title_color ) {
		$css .= sprintf( '.single-portfolio .comment-reply-title { color: %s; } ', esc_attr( $comment_title_color ) );
	}
	$comment_reply_color = get_theme_mod( 'minimalio_settings_single_portfolio_comments_reply_color' );
	if ( $comment_reply_color ) {
		$css .= sprintf( '.single-portfolio .comments-title { color: %s; } ', esc_attr( $comment_reply_color ) );
	}

	// Blog single post title color
	$blog_title_color = get_theme_mod( 'minimalio_settings_single_post_title_color' );
	if ( $blog_title_color ) {
		$css .= sprintf( '.single-post .entry-title { color: %s !important; } ', esc_attr( $blog_title_color ) );
	}

	// Blog list page title color
	$blog_list_title_color = get_theme_mod( 'minimalio_settings_blog_list_title_color' );
	if ( $blog_list_title_color ) {
		$css .= sprintf( '.blog-post-type .post-card__heading { color: %s !important; } ', esc_attr( $blog_list_title_color ) );
	}

	// Blog title bottom spacing
	$title_gap = get_theme_mod( 'minimalio_settings_single_post_title_gap', '2rem' );
	if ( $title_gap !== '2rem' ) {
		$css .= sprintf( '.single-post .entry-title { padding-bottom: %s !important; } ', esc_attr( $title_gap ) );
	}

	// Blog comment title colors
	$blog_comment_title_color = get_theme_mod( 'minimalio_settings_single_post_comments_title_color' );
	if ( $blog_comment_title_color ) {
		$css .= sprintf( '.single-post .comment-reply-title { color: %s; } ', esc_attr( $blog_comment_title_color ) );
	}
	$blog_comment_reply_color = get_theme_mod( 'minimalio_settings_single_post_comments_reply_color' );
	if ( $blog_comment_reply_color ) {
		$css .= sprintf( '.single-post .comments-title { color: %s; } ', esc_attr( $blog_comment_reply_color ) );
	}

	// Blog list view constraint
	$blog_type = get_theme_mod( 'minimalio_settings_blog_type' );
	if ( $blog_type === 'list' ) {
		$css .= '.blog-list-view .blog-list__row {
			max-width: 1000px !important;
			table-layout: fixed !important;
		}';
		$css .= '.blog-list-view .blog-list__style-2-row {
			max-width: 1500px !important;
			table-layout: fixed !important;
		}';
	}

	// Social media brand colors
	$brand_colors = get_theme_mod( 'minimalio_settings_social_brand_colors', 'no' );
	if ( $brand_colors !== 'yes' ) {
		$css .= '.socials__icon, .single-post__icons { color: currentColor; fill: currentColor; } ';
	}
	if ( $brand_colors === 'yes' ) {
		$colors = [
			'mail'       => '#EA4335',
			'facebook'   => '#1877F2',
			'instagram'  => '#E4405F',
			'twitter'    => '#1DA1F2',
			'linkedin'   => '#0A66C2',
			'pinterest'  => '#BD081C',
			'youtube'    => '#FF0000',
			'vimeo'      => '#1AB7EA',
			'applemusic' => '#FA243C',
			'bandcamp'   => '#629AA9',
			'behance'    => '#1769FF',
			'bluesky'    => '#0085FF',
			'codepen'    => '#000000',
			'deviantart' => '#05CC47',
			'dribbble'   => '#EA4C89',
			'discord'    => '#5865F2',
			'etsy'       => '#F1641E',
			'flickr'     => '#0063DC',
			'github'     => '#181717',
			'goodreads'  => '#372213',
			'imdb'       => '#F5C518',
			'lastfm'     => '#D51007',
			'mastodon'   => '#6364FF',
			'medium'     => '#000000',
			'patreon'    => '#FF424D',
			'pixelfed'   => '#6364FF',
			'reddit'     => '#FF4500',
			'rss'        => '#FFA500',
			'snapchat'   => '#FFFC00',
			'soundcloud' => '#FF3300',
			'spotify'    => '#1DB954',
			'tiktok'     => '#000000',
			'twitch'     => '#9146FF',
			'vk'         => '#0077FF',
			'x'          => '#000000',
		];

		foreach ( $colors as $network => $color ) {
			$css .= sprintf(
				'.socials__icon--%1$s, .single-post__%1$s { color: %2$s; fill: %2$s; } ',
				esc_attr( $network ),
				esc_attr( $color )
			);
		}
	}

	if ( ! empty( $css ) ) {
		wp_add_inline_style( 'layout-options', $css );
	}
}
add_action( 'wp_enqueue_scripts', 'oneguy_dynamic_css', 21 );

/**
 * Register additional customizer settings and controls
 */
function oneguy_customize_register( $customizer ) {

	// =========================================================================
	// Site Identity: Show Tagline + Tagline Color
	// =========================================================================

	// Move WP Tagline control after Site Title Size
	$tagline_control = $customizer->get_control( 'blogdescription' );
	if ( $tagline_control ) {
		$tagline_control->priority = 15;
	}

	// Reorder Site Title Size
	$title_size_control = $customizer->get_control( 'minimalio_site_title_size' );
	if ( $title_size_control ) {
		$title_size_control->priority = 11;
	}

	$customizer->add_setting( 'minimalio_settings_show_tagline', [
		'default'           => 'no',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	]);

	$customizer->add_setting( 'minimalio_settings_tagline_color', [
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	]);

	$customizer->add_control(
		new WP_Customize_Control(
			$customizer,
			'minimalio_options_show_tagline',
			[
				'label'    => esc_html__( 'Show Tagline', 'oneguy' ),
				'section'  => 'title_tagline',
				'settings' => 'minimalio_settings_show_tagline',
				'type'     => 'select',
				'priority' => 21,
				'choices'  => [
					'no'  => esc_html__( 'No', 'oneguy' ),
					'yes' => esc_html__( 'Yes', 'oneguy' ),
				],
			]
		)
	);

	$customizer->add_control(
		new Minimalio_Direction_Customizer_Alpha_Color_Control(
			$customizer,
			'minimalio_options_tagline_color',
			[
				'label'        => esc_html__( 'Tagline Color', 'oneguy' ),
				'section'      => 'title_tagline',
				'settings'     => 'minimalio_settings_tagline_color',
				'priority'     => 22,
				'show_opacity' => true,
				'palette'      => [
					'#ffffff',
					'#0a0a0a',
					'#002778',
					'#007392',
					'#3F0055',
					'#006D57',
					'#00CC99',
				],
			]
		)
	);

	// Reorder Mobile Logo and White Logo
	$mobile_logo_control = $customizer->get_control( 'minimalio_mobile-logo-options' );
	if ( $mobile_logo_control ) {
		$mobile_logo_control->priority = 40;
	}

	$white_logo_control = $customizer->get_control( 'minimalio_fixed-logo-options' );
	if ( $white_logo_control ) {
		$white_logo_control->priority = 41;
	}

	// =========================================================================
	// Typography: Text Transform
	// =========================================================================

	$customizer->add_setting( 'minimalio_settings_text_transform', [
		'default'           => 'none',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	]);

	$customizer->add_control(
		new WP_Customize_Control(
			$customizer,
			'minimalio_typography_options_text_transform',
			[
				'label'             => esc_html__( 'Text Transform', 'oneguy' ),
				'description'       => esc_html__( 'Control text case for body text', 'oneguy' ),
				'section'           => 'minimalio_typography_settings',
				'settings'          => 'minimalio_settings_text_transform',
				'type'              => 'select',
				'sanitize_callback' => 'minimalio_theme_slug_sanitize_select',
				'choices'           => [
					'none'       => esc_html__( 'Normal (Default)', 'oneguy' ),
					'capitalize' => esc_html__( 'Capitalize (First Letter)', 'oneguy' ),
					'uppercase'  => esc_html__( 'Uppercase (ALL CAPS)', 'oneguy' ),
					'lowercase'  => esc_html__( 'Lowercase (all small)', 'oneguy' ),
				],
			]
		)
	);

	// Add custom fonts to the font dropdown with dividers and disabled separators
	$font_control = $customizer->get_control( 'minimalio_typography_options_google_font' );
	if ( $font_control ) {
		// Build custom font choices
		$custom_font_choices = [];

		// Add simple custom fonts
		$simple_fonts = get_option( 'minimalio_simple_custom_fonts', [] );
		foreach ( $simple_fonts as $font_id => $font_data ) {
			$custom_font_choices[ 'simple_' . $font_id ] = $font_data['name'] . ' (Custom)';
		}

		// Add advanced custom fonts
		$advanced_fonts = get_option( 'minimalio_custom_fonts', [] );
		foreach ( $advanced_fonts as $font_id => $font_data ) {
			$custom_font_choices[ 'custom_' . $font_id ] = $font_data['name'] . ' (Custom)';
		}

		// Always rebuild with dividers and sections
		$safe_fonts = [
			'Arial', 'Verdana', 'Tahoma', 'Times+New+Roman',
			'Georgia', 'Garamond', 'Courier+New', 'Brush+Script+MT',
		];

		$safe_choices   = [];
		$google_choices = [];
		foreach ( $font_control->choices as $key => $label ) {
			if ( in_array( $key, $safe_fonts, true ) ) {
				$safe_choices[ $key ] = $label;
			} else {
				$google_choices[ $key ] = $label;
			}
		}

		// Fallback: if Google Fonts API returned nothing, use a bundled list
		if ( empty( $google_choices ) ) {
			$google_choices = oneguy_get_fallback_google_fonts();
		}

		$new_choices = [];

		// Only show custom fonts section if there are custom fonts
		if ( ! empty( $custom_font_choices ) ) {
			$new_choices['--- Your Custom Fonts ---'] = '--- Your Custom Fonts ---';
			$new_choices = array_merge( $new_choices, $custom_font_choices );
		}

		$new_choices['--- Default Fonts ---'] = '--- Default Fonts ---';
		$new_choices = array_merge( $new_choices, $safe_choices );

		if ( ! empty( $google_choices ) ) {
			$new_choices['--- Google Fonts ---'] = '--- Google Fonts ---';
			$new_choices = array_merge( $new_choices, $google_choices );
		}

		$font_control->choices = $new_choices;

		$font_control->label = esc_html__( 'Fonts', 'oneguy' );
	}

	// Handle font weight choices for custom fonts
	$weight_control = $customizer->get_control( 'minimalio_typography_options_google_font_weight' );
	if ( $weight_control ) {
		$current_font = get_theme_mod( 'minimalio_typography_settings_google_font' );

		if ( $current_font && strpos( $current_font, 'custom_' ) === 0 ) {
			$font_id = substr( $current_font, 7 );
			$adv_fonts = get_option( 'minimalio_custom_fonts', [] );
			if ( isset( $adv_fonts[ $font_id ] ) ) {
				$custom_weights = [];
				foreach ( $adv_fonts[ $font_id ]['variants'] as $variant_name => $variant_data ) {
					$w = oneguy_get_font_weight_from_variant( $variant_name );
					$custom_weights[ $w ] = $w;
				}
				if ( ! empty( $custom_weights ) ) {
					$weight_control->choices = $custom_weights;
				}
			}
		} elseif ( $current_font && strpos( $current_font, 'simple_' ) === 0 ) {
			$weight_control->choices = [
				'400' => '400',
				'700' => '700',
			];
		}
	}

	// =========================================================================
	// Header: Extra Text (vertical header only)
	// =========================================================================

	$customizer->add_setting( 'minimalio_settings_header_extra_text', [
		'default'           => '',
		'sanitize_callback' => 'wp_kses_post',
		'transport'         => 'refresh',
	]);

	$customizer->add_setting( 'minimalio_settings_header_extra_text_font_size', [
		'default'           => '14px',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	]);

	$customizer->add_setting( 'minimalio_settings_header_extra_text_font', [
		'default'           => 'inherit',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	]);

	$customizer->add_control(
		new WP_Customize_Control(
			$customizer,
			'minimalio_header_options_header_extra_text',
			[
				'label'       => esc_html__( 'Extra Text', 'oneguy' ),
				'description' => esc_html__( 'Text displayed at the end of the vertical header. HTML supported.', 'oneguy' ),
				'section'     => 'minimalio_heading_settings_fixed',
				'settings'    => 'minimalio_settings_header_extra_text',
				'type'        => 'textarea',
			]
		)
	);

	$customizer->add_control(
		new WP_Customize_Control(
			$customizer,
			'minimalio_header_options_header_extra_text_font_size',
			[
				'label'    => esc_html__( 'Extra Text Font Size', 'oneguy' ),
				'section'  => 'minimalio_heading_settings_fixed',
				'settings' => 'minimalio_settings_header_extra_text_font_size',
				'type'     => 'select',
				'choices'  => [
					'10px' => esc_html__( '10px - Tiny', 'oneguy' ),
					'11px' => esc_html__( '11px - Smaller', 'oneguy' ),
					'12px' => esc_html__( '12px - Small', 'oneguy' ),
					'13px' => esc_html__( '13px', 'oneguy' ),
					'14px' => esc_html__( '14px - Default', 'oneguy' ),
					'15px' => esc_html__( '15px', 'oneguy' ),
					'16px' => esc_html__( '16px - Normal', 'oneguy' ),
					'18px' => esc_html__( '18px - Medium', 'oneguy' ),
					'20px' => esc_html__( '20px - Large', 'oneguy' ),
					'24px' => esc_html__( '24px - Larger', 'oneguy' ),
				],
			]
		)
	);

	// Build font choices for extra text (same fonts as main font dropdown)
	$extra_text_font_choices = [ 'inherit' => esc_html__( 'Inherit (Same as body)', 'oneguy' ) ];
	if ( $font_control ) {
		$extra_text_font_choices = array_merge( $extra_text_font_choices, $font_control->choices );
	}

	$customizer->add_control(
		new WP_Customize_Control(
			$customizer,
			'minimalio_header_options_header_extra_text_font',
			[
				'label'    => esc_html__( 'Extra Text Font', 'oneguy' ),
				'section'  => 'minimalio_heading_settings_fixed',
				'settings' => 'minimalio_settings_header_extra_text_font',
				'type'     => 'select',
				'choices'  => $extra_text_font_choices,
			]
		)
	);

	// =========================================================================
	// Typography: Font Size Controls
	// =========================================================================

	$font_size_elements = [
		'body'       => [ 'label' => 'Body Font Size (px)',       'default' => '' ],
		'p'          => [ 'label' => 'Paragraph Font Size (px)',  'default' => '' ],
		'h1'         => [ 'label' => 'H1 Font Size (px)',         'default' => '' ],
		'h2'         => [ 'label' => 'H2 Font Size (px)',         'default' => '' ],
		'h3'         => [ 'label' => 'H3 Font Size (px)',         'default' => '' ],
		'h4'         => [ 'label' => 'H4 Font Size (px)',         'default' => '' ],
		'h5'         => [ 'label' => 'H5 Font Size (px)',         'default' => '' ],
		'h6'         => [ 'label' => 'H6 Font Size (px)',         'default' => '' ],
		'blockquote' => [ 'label' => 'Blockquote Font Size (px)', 'default' => '' ],
		'li'         => [ 'label' => 'List Item Font Size (px)',  'default' => '' ],
	];

	foreach ( $font_size_elements as $element => $config ) {
		$setting_id = 'minimalio_settings_font_size_' . $element;
		$control_id = 'minimalio_options_font_size_' . $element;

		$customizer->add_setting( $setting_id, [
			'default'           => $config['default'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		]);

		$customizer->add_control(
			new WP_Customize_Control(
				$customizer,
				$control_id,
				[
					'label'       => esc_html__( $config['label'], 'oneguy' ),
					'description' => $element === 'body'
						? esc_html__( 'Enter a number (px assumed) or with unit, e.g. 16, 1.2rem — leave empty for default', 'oneguy' )
						: '',
					'section'     => 'minimalio_typography_settings',
					'settings'    => $setting_id,
					'type'        => 'text',
				]
			)
		);
	}

	// =========================================================================
	// Blog Options: Excerpt Word Count
	// =========================================================================

	$customizer->add_setting( 'minimalio_settings_blog_excerpt_words', [
		'default'           => '40',
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	]);

	$customizer->add_control(
		new WP_Customize_Control(
			$customizer,
			'minimalio_options_blog_excerpt_words',
			[
				'label'       => esc_html__( 'Excerpt Word Count', 'oneguy' ),
				'description' => esc_html__( 'Number of words to show in the blog list excerpt.', 'oneguy' ),
				'section'     => 'minimalio_blog_options',
				'settings'    => 'minimalio_settings_blog_excerpt_words',
				'type'        => 'number',
				'input_attrs' => [
					'min'  => 5,
					'max'  => 100,
					'step' => 5,
				],
			]
		)
	);

	// =========================================================================
	// Blog Options: List Style (only visible when List is selected)
	// =========================================================================

	$customizer->add_setting( 'minimalio_settings_blog_list_style', [
		'default'           => 'style_1',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	]);

	$customizer->add_control(
		new WP_Customize_Control(
			$customizer,
			'minimalio_options_blog_list_style',
			[
				'label'       => esc_html__( 'Blog List Style', 'oneguy' ),
				'description' => esc_html__( 'Style 1: Thumbnail + Title/Excerpt. Style 2: Large image + Title/Excerpt/Meta columns.', 'oneguy' ),
				'section'     => 'minimalio_blog_options',
				'settings'    => 'minimalio_settings_blog_list_style',
				'type'        => 'select',
				'choices'     => [
					'style_1' => esc_html__( 'Style 1 — Compact', 'oneguy' ),
					'style_2' => esc_html__( 'Style 2 — Editorial', 'oneguy' ),
				],
			]
		)
	);

	// =========================================================================
	// Blog Options: Text Alignment + Content Width Behavior
	// =========================================================================

	$customizer->add_setting( 'minimalio_settings_blog_text_align', [
		'default'           => 'left',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	]);

	$customizer->add_setting( 'minimalio_settings_content_width_behavior', [
		'default'           => 'full',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	]);

	$customizer->add_control(
		new WP_Customize_Control(
			$customizer,
			'minimalio_options_blog_text_align',
			[
				'label'             => esc_html__( 'Blog Text Alignment', 'oneguy' ),
				'description'       => esc_html__( 'Control text alignment for blog post content', 'oneguy' ),
				'section'           => 'minimalio_blog_options',
				'settings'          => 'minimalio_settings_blog_text_align',
				'type'              => 'select',
				'sanitize_callback' => 'sanitize_text_field',
				'choices'           => [
					'left'    => esc_html__( 'Left (Normal)', 'oneguy' ),
					'center'  => esc_html__( 'Center', 'oneguy' ),
					'right'   => esc_html__( 'Right', 'oneguy' ),
					'justify' => esc_html__( 'Justified', 'oneguy' ),
				],
			]
		)
	);

	$customizer->add_control(
		new WP_Customize_Control(
			$customizer,
			'minimalio_options_content_width_behavior',
			[
				'label'             => esc_html__( 'Content Width Behavior', 'oneguy' ),
				'description'       => esc_html__( 'Control how featured images and Gutenberg content are displayed', 'oneguy' ),
				'section'           => 'minimalio_blog_options',
				'settings'          => 'minimalio_settings_content_width_behavior',
				'type'              => 'select',
				'sanitize_callback' => 'sanitize_text_field',
				'choices'           => [
					'constrained' => esc_html__( 'Constrained', 'oneguy' ),
					'full'        => esc_html__( 'Full-Width Gutenberg (Default)', 'oneguy' ),
				],
			]
		)
	);

	$customizer->add_setting( 'minimalio_settings_single_post_title_gap', [
		'default'           => '2rem',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	]);

	$customizer->add_control(
		new WP_Customize_Control(
			$customizer,
			'minimalio_options_single_post_title_gap',
			[
				'label'    => esc_html__( 'Title Bottom Spacing', 'oneguy' ),
				'section'  => 'minimalio_blog_options',
				'settings' => 'minimalio_settings_single_post_title_gap',
				'type'     => 'select',
				'choices'  => [
					'0'      => esc_html__( 'None', 'oneguy' ),
					'0.5rem' => esc_html__( '0.5rem - Tight', 'oneguy' ),
					'1rem'   => esc_html__( '1rem - Small', 'oneguy' ),
					'1.5rem' => esc_html__( '1.5rem - Medium', 'oneguy' ),
					'2rem'   => esc_html__( '2rem - Default', 'oneguy' ),
					'3rem'   => esc_html__( '3rem - Large', 'oneguy' ),
				],
			]
		)
	);

	// =========================================================================
	// Blog Options: Title Colors
	// =========================================================================

	$customizer->add_setting( 'minimalio_settings_single_post_title_color', [
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'refresh',
	]);

	$customizer->add_control(
		new WP_Customize_Color_Control(
			$customizer,
			'minimalio_options_single_post_title_color',
			[
				'label'    => esc_html__( 'Single Post Title Color', 'oneguy' ),
				'section'  => 'minimalio_blog_options',
				'settings' => 'minimalio_settings_single_post_title_color',
			]
		)
	);

	$customizer->add_setting( 'minimalio_settings_blog_list_title_color', [
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'refresh',
	]);

	$customizer->add_control(
		new WP_Customize_Color_Control(
			$customizer,
			'minimalio_options_blog_list_title_color',
			[
				'label'    => esc_html__( 'Blog List Title Color', 'oneguy' ),
				'section'  => 'minimalio_blog_options',
				'settings' => 'minimalio_settings_blog_list_title_color',
			]
		)
	);

	// Same control in Blog Options for discoverability
	$customizer->add_control(
		new WP_Customize_Control(
			$customizer,
			'minimalio_options_blog_share_brand_colors',
			[
				'label'       => esc_html__( 'Share Icons Brand Colors', 'oneguy' ),
				'description' => esc_html__( 'Applies to social icons and share buttons everywhere.', 'oneguy' ),
				'section'     => 'minimalio_blog_options',
				'settings'    => 'minimalio_settings_social_brand_colors',
				'type'        => 'select',
				'choices'     => [
					'no'  => esc_html__( 'No (Inherit Text Color)', 'oneguy' ),
					'yes' => esc_html__( 'Yes (Brand Colors)', 'oneguy' ),
				],
			]
		)
	);

	// =========================================================================
	// Blog Options: Comments
	// =========================================================================

	$customizer->add_setting( 'minimalio_settings_single_post_comments', [
		'default'           => 'yes',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	]);

	$customizer->add_control(
		new WP_Customize_Control(
			$customizer,
			'minimalio_options_single_post_comments',
			[
				'label'    => esc_html__( 'Show and Allow Comments', 'oneguy' ),
				'section'  => 'minimalio_blog_options',
				'settings' => 'minimalio_settings_single_post_comments',
				'type'     => 'select',
				'choices'  => [
					'yes' => esc_html__( 'Yes', 'oneguy' ),
					'no'  => esc_html__( 'No', 'oneguy' ),
				],
			]
		)
	);

	$customizer->add_setting( 'minimalio_settings_single_post_comments_title', [
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	]);

	$customizer->add_control(
		new WP_Customize_Control(
			$customizer,
			'minimalio_options_single_post_comments_title',
			[
				'label'       => esc_html__( 'Comment Form Title', 'oneguy' ),
				'description' => esc_html__( 'Leave empty for default "Leave a Reply".', 'oneguy' ),
				'section'     => 'minimalio_blog_options',
				'settings'    => 'minimalio_settings_single_post_comments_title',
				'type'        => 'text',
			]
		)
	);

	$customizer->add_setting( 'minimalio_settings_single_post_comments_title_color', [
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'refresh',
	]);

	$customizer->add_control(
		new WP_Customize_Color_Control(
			$customizer,
			'minimalio_options_single_post_comments_title_color',
			[
				'label'    => esc_html__( '"Leave a Reply" Title Color', 'oneguy' ),
				'section'  => 'minimalio_blog_options',
				'settings' => 'minimalio_settings_single_post_comments_title_color',
			]
		)
	);

	$customizer->add_setting( 'minimalio_settings_single_post_comments_reply_color', [
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'refresh',
	]);

	$customizer->add_control(
		new WP_Customize_Color_Control(
			$customizer,
			'minimalio_options_single_post_comments_reply_color',
			[
				'label'    => esc_html__( 'Replies Title Color', 'oneguy' ),
				'section'  => 'minimalio_blog_options',
				'settings' => 'minimalio_settings_single_post_comments_reply_color',
			]
		)
	);

	// =========================================================================
	// Portfolio Options: Single Portfolio Featured Image Aspect Ratio
	// =========================================================================

	$customizer->add_setting( 'minimalio_settings_single_portfolio_image_ratio', [
		'default'           => 'original',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	]);

	$customizer->add_control(
		new WP_Customize_Control(
			$customizer,
			'minimalio_options_single_portfolio_image_ratio',
			[
				'label'       => esc_html__( 'Featured Image Size', 'oneguy' ),
				'description' => esc_html__( 'Resize the featured image proportionally on single portfolio pages.', 'oneguy' ),
				'section'     => 'minimalio_portfolio_options',
				'settings'    => 'minimalio_settings_single_portfolio_image_ratio',
				'type'        => 'select',
				'choices'     => [
					'original' => esc_html__( 'Original (Full Width)', 'oneguy' ),
					'90%'      => esc_html__( '90%', 'oneguy' ),
					'80%'      => esc_html__( '80%', 'oneguy' ),
					'75%'      => esc_html__( '75% (3/4)', 'oneguy' ),
					'66.66%'   => esc_html__( '66% (2/3)', 'oneguy' ),
					'50%'      => esc_html__( '50% (1/2)', 'oneguy' ),
					'33.33%'   => esc_html__( '33% (1/3)', 'oneguy' ),
					'25%'      => esc_html__( '25% (1/4)', 'oneguy' ),
				],
			]
		)
	);

	// =========================================================================
	// Portfolio Options: Content Width Behavior
	// =========================================================================

	$customizer->add_setting( 'minimalio_settings_portfolio_content_width_behavior', [
		'default'           => 'full',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	]);

	$customizer->add_control(
		new WP_Customize_Control(
			$customizer,
			'minimalio_options_portfolio_content_width_behavior',
			[
				'label'             => esc_html__( 'Content Width Behavior', 'oneguy' ),
				'description'       => esc_html__( 'Control how featured images and Gutenberg content are displayed in portfolio posts', 'oneguy' ),
				'section'           => 'minimalio_portfolio_options',
				'settings'          => 'minimalio_settings_portfolio_content_width_behavior',
				'type'              => 'select',
				'sanitize_callback' => 'sanitize_text_field',
				'choices'           => [
					'constrained' => esc_html__( 'Constrained', 'oneguy' ),
					'full'        => esc_html__( 'Full-Width Gutenberg (Default)', 'oneguy' ),
				],
			]
		)
	);

	// =========================================================================
	// Portfolio Options: Portfolio Title Color (archive/grid page)
	// =========================================================================

	$customizer->add_setting( 'minimalio_settings_portfolio_title_color', [
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'refresh',
	]);

	$customizer->add_control(
		new WP_Customize_Color_Control(
			$customizer,
			'minimalio_options_portfolio_title_color',
			[
				'label'    => esc_html__( 'Portfolio Title Color', 'oneguy' ),
				'section'  => 'minimalio_portfolio_options',
				'settings' => 'minimalio_settings_portfolio_title_color',
				'priority' => 10,
			]
		)
	);

	// =========================================================================
	// Portfolio Options: Single Portfolio Title Color (inner post page)
	// =========================================================================

	$customizer->add_setting( 'minimalio_settings_single_portfolio_title_color', [
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'refresh',
	]);

	$customizer->add_control(
		new WP_Customize_Color_Control(
			$customizer,
			'minimalio_options_single_portfolio_title_color',
			[
				'label'    => esc_html__( 'Single Portfolio Title Color', 'oneguy' ),
				'section'  => 'minimalio_portfolio_options',
				'settings' => 'minimalio_settings_single_portfolio_title_color',
				'priority' => 10,
			]
		)
	);

	// =========================================================================
	// Portfolio Options: Comments
	// =========================================================================

	$customizer->add_setting( 'minimalio_settings_single_portfolio_comments', [
		'default'           => 'no',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	]);

	$customizer->add_control(
		new WP_Customize_Control(
			$customizer,
			'minimalio_options_single_portfolio_comments',
			[
				'label'    => esc_html__( 'Show and Allow Comments', 'oneguy' ),
				'section'  => 'minimalio_portfolio_options',
				'settings' => 'minimalio_settings_single_portfolio_comments',
				'type'     => 'select',
				'choices'  => [
					'no'  => esc_html__( 'No', 'oneguy' ),
					'yes' => esc_html__( 'Yes', 'oneguy' ),
				],
			]
		)
	);

	$customizer->add_setting( 'minimalio_settings_single_portfolio_comments_title', [
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	]);

	$customizer->add_control(
		new WP_Customize_Control(
			$customizer,
			'minimalio_options_single_portfolio_comments_title',
			[
				'label'       => esc_html__( 'Comment Form Title', 'oneguy' ),
				'description' => esc_html__( 'Leave empty for default "Leave a Reply".', 'oneguy' ),
				'section'     => 'minimalio_portfolio_options',
				'settings'    => 'minimalio_settings_single_portfolio_comments_title',
				'type'        => 'text',
			]
		)
	);

	$customizer->add_setting( 'minimalio_settings_single_portfolio_comments_title_color', [
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'refresh',
	]);

	$customizer->add_control(
		new WP_Customize_Color_Control(
			$customizer,
			'minimalio_options_single_portfolio_comments_title_color',
			[
				'label'    => esc_html__( '"Leave a Reply" Title Color', 'oneguy' ),
				'section'  => 'minimalio_portfolio_options',
				'settings' => 'minimalio_settings_single_portfolio_comments_title_color',
			]
		)
	);

	$customizer->add_setting( 'minimalio_settings_single_portfolio_comments_reply_color', [
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'refresh',
	]);

	$customizer->add_control(
		new WP_Customize_Color_Control(
			$customizer,
			'minimalio_options_single_portfolio_comments_reply_color',
			[
				'label'    => esc_html__( 'Replies Title Color', 'oneguy' ),
				'section'  => 'minimalio_portfolio_options',
				'settings' => 'minimalio_settings_single_portfolio_comments_reply_color',
			]
		)
	);

	// =========================================================================
	// Social Media: Brand Colors (shared setting, shown in both sections)
	// =========================================================================

	$customizer->add_setting( 'minimalio_settings_social_brand_colors', [
		'default'           => 'no',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	]);

	// Social Media brand colors control is registered in oneguy_reposition_brand_colors()

	// Same control in Portfolio Settings for discoverability
	$customizer->add_control(
		new WP_Customize_Control(
			$customizer,
			'minimalio_options_portfolio_share_brand_colors',
			[
				'label'       => esc_html__( 'Share Icons Brand Colors', 'oneguy' ),
				'description' => esc_html__( 'Applies to social icons and share buttons everywhere.', 'oneguy' ),
				'section'     => 'minimalio_portfolio_options',
				'settings'    => 'minimalio_settings_social_brand_colors',
				'type'        => 'select',
				'choices'     => [
					'no'  => esc_html__( 'No (Inherit Text Color)', 'oneguy' ),
					'yes' => esc_html__( 'Yes (Brand Colors)', 'oneguy' ),
				],
			]
		)
	);

	// =========================================================================
	// Change sanitize_callback for social links to wp_kses_post
	// =========================================================================

	$social_link_setting = $customizer->get_setting( 'minimalio_settings_social_link_1' );
	if ( $social_link_setting ) {
		$social_link_setting->sanitize_callback = 'wp_kses_post';
	}
	$social_link_setting_2 = $customizer->get_setting( 'minimalio_settings_social_link_2' );
	if ( $social_link_setting_2 ) {
		$social_link_setting_2->sanitize_callback = 'wp_kses_post';
	}
}
add_action( 'customize_register', 'oneguy_customize_register', 20 );

/**
 * Override parent's Blog Display Type control to add "List" option
 */
function oneguy_override_blog_display_type( $customizer ) {
	$control = $customizer->get_control( 'minimalio_options_blog_type' );
	if ( $control ) {
		$control->choices['list'] = esc_html__( 'List', 'oneguy' );
	}
}
add_action( 'customize_register', 'oneguy_override_blog_display_type', 999 );

/**
 * Swap blog templates to list view when list mode is active
 */
function oneguy_blog_list_template( $template ) {
	if ( get_theme_mod( 'minimalio_settings_blog_type' ) !== 'list' ) {
		return $template;
	}

	if ( is_home() || is_category() || is_tag() || is_author() || is_date() || is_page_template( 'templates/pages/blog-template.php' ) ) {
		$list_template = get_stylesheet_directory() . '/templates/pages/blog-list-page.php';
		if ( file_exists( $list_template ) ) {
			return $list_template;
		}
	}

	return $template;
}
add_filter( 'template_include', 'oneguy_blog_list_template', 99 );

/**
 * Reposition brand colors control after plugin controls have been registered
 */
function oneguy_reposition_brand_colors( $customizer ) {
	$customizer->remove_control( 'minimalio_options_social_brand_colors' );

	$customizer->add_control(
		new WP_Customize_Control(
			$customizer,
			'minimalio_options_social_brand_colors',
			[
				'label'       => esc_html__( 'Social Icons Brand Colors', 'oneguy' ),
				'description' => esc_html__( 'Applies to social icons and share buttons everywhere.', 'oneguy' ),
				'section'     => 'minimalio_social_media',
				'settings'    => 'minimalio_settings_social_brand_colors',
				'type'        => 'select',
				'priority'    => 3,
				'choices'     => [
					'no'  => esc_html__( 'No (Inherit Text Color)', 'oneguy' ),
					'yes' => esc_html__( 'Yes (Brand Colors)', 'oneguy' ),
				],
			]
		)
	);
}
add_action( 'customize_register', 'oneguy_reposition_brand_colors', 999 );

/**
 * Enqueue customizer controls JS for child theme
 */
function oneguy_customizer_controls_js() {
	wp_enqueue_script(
		'oneguy-customizer-controls',
		get_stylesheet_directory_uri() . '/js/customizer-controls.js',
		[ 'jquery', 'customize-controls' ],
		filemtime( get_stylesheet_directory() . '/js/customizer-controls.js' ),
		true
	);
}
add_action( 'customize_controls_enqueue_scripts', 'oneguy_customizer_controls_js' );

/**
 * Add custom font support to theme-support font weights
 */
function oneguy_extend_font_weights( $weights ) {
	$current_font = get_theme_mod( 'minimalio_typography_settings_google_font' );
	
	if ( $current_font && strpos( $current_font, 'custom_' ) === 0 ) {
		$font_id = substr( $current_font, 7 );
		$custom_fonts = get_option( 'minimalio_custom_fonts', [] );
		
		if ( isset( $custom_fonts[$font_id] ) ) {
			$custom_weights = [];
			foreach ( $custom_fonts[$font_id]['variants'] as $variant_name => $variant_data ) {
				$weight = oneguy_get_font_weight_from_variant( $variant_name );
				$custom_weights[$weight] = $weight;
			}
			
			if ( ! empty( $custom_weights ) ) {
				return $custom_weights;
			}
		}
		
		return [ '400' => '400' ];
	}
	
	if ( $current_font && strpos( $current_font, 'simple_' ) === 0 ) {
		return [
			'400' => '400',
			'700' => '700',
		];
	}
	
	return $weights;
}
