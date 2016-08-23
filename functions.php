<?php

/**
 * Move some elements around.
 *
 * @action template_redirect
 * @since  1.0.0
 */
function velux_move_elements() {

	remove_action( 'primer_header',                    'primer_add_hero' );
	remove_action( 'primer_after_header',              'primer_add_primary_navigation' );
	remove_action( 'primer_after_header',              'primer_add_page_title' );
	remove_action( 'primer_before_site_navigation',    'primer_add_mobile_menu' );
	remove_action( 'primer_after_post_title_template', 'primer_add_post_meta' );

	add_action( 'primer_header',                    'primer_add_primary_navigation' );
	add_action( 'primer_after_site_header_wrapper', 'primer_add_page_title' );
	add_action( 'primer_after_post_title',          'primer_add_post_meta' );

	if ( is_front_page() && is_active_sidebar( 'hero' ) ) {

		add_action( 'primer_after_site_header_wrapper', 'primer_add_hero' );

	}

}
add_action( 'template_redirect', 'velux_move_elements' );

/**
 * Add mobile menu to header.
 *
 * @action primer_header
 * @since  1.0.0
 */
function velux_add_mobile_menu() {

	get_template_part( 'templates/parts/mobile-menu' );

}
add_action( 'primer_header', 'velux_add_mobile_menu', 0 );

/**
 * Hide site title and description when a custom logo is present.
 *
 * @filter primer_the_site_title
 * @filter primer_the_site_description
 * @since  1.0.0
 *
 * @param  string $html
 *
 * @return string|null
 */
function velux_the_site_title( $html ) {

	return primer_has_custom_logo() ? null : $html;

}
add_filter( 'primer_the_site_title',       'velux_the_site_title' );
add_filter( 'primer_the_site_description', 'velux_the_site_title' );

/**
 * Set custom logo args.
 *
 * @filter primer_custom_logo_args
 * @since  1.0.0
 *
 * @param  array $args
 *
 * @return array
 */
function velux_custom_logo_args( $args ) {

	$args['width']  = 325;
	$args['height'] = 120;

	return $args;

}
add_filter( 'primer_custom_logo_args', 'velux_custom_logo_args' );

/**
 * Set the default hero image description.
 *
 * @filter primer_default_hero_images
 * @since  1.0.0
 *
 * @param  array $defaults
 *
 * @return array
 */
function velux_default_hero_images( $defaults ) {

	$defaults['default']['description'] = esc_html__( 'Dress shoes and tie', 'velux' );

	return $defaults;

}
add_filter( 'primer_default_hero_images', 'velux_default_hero_images' );

/**
 * Set fonts.
 *
 * @filter primer_fonts
 * @since  1.0.0
 *
 * @param  array $fonts
 *
 * @return array
 */
function velux_fonts( $fonts ) {

	$fonts[] = 'Playfair Display';
	$fonts[] = 'Raleway';
	$fonts[] = 'Roboto';

	return $fonts;

}
add_filter( 'primer_fonts', 'velux_fonts' );

/**
 * Set font types.
 *
 * @filter primer_font_types
 * @since  1.0.0
 *
 * @param  array $font_types
 *
 * @return array
 */
function velux_font_types( $font_types ) {

	$overrides = array(
		'site_title_font' => array(
			'default' => 'Playfair Display',
		),
		'navigation_font' => array(
			'default' => 'Playfair Display',
		),
		'heading_font' => array(
			'default' => 'Playfair Display',
		),
		'primary_font' => array(
			'default' => 'Roboto',
		),
		'secondary_font' => array(
			'default' => 'Raleway',
		),
	);

	return primer_array_replace_recursive( $font_types, $overrides );

}
add_filter( 'primer_font_types', 'velux_font_types' );

/**
 * Set colors.
 *
 * @filter primer_colors
 * @since  1.0.0
 *
 * @param  array $colors
 *
 * @return array
 */
function velux_colors( $colors ) {

	unset(
		$colors['content_background_color'],
		$colors['footer_widget_content_background_color']
	);

	$overrides = array(
		/**
		 * Text colors
		 */
		'menu_text_color' => array(
			'rgba_css' => array(
				'.site-header-wrapper' => array(
					'border-color' => 'rgba(%1$s, 0.1)',
				),
			),
		),
		'footer_widget_heading_text_color' => array(
			'default' => '#ffffff',
		),
		'footer_widget_text_color' => array(
			'default' => '#999999',
		),
		'footer_menu_text_color' => array(
			'css' => array(
				'.footer-menu ul li a:hover' => array(
					'border-color' => '%1$s',
				),
			),
		),
		/**
		 * Link / Button colors
		 */
		'link_color' => array(
			'default' => '#51748e',
			'css'     => array(
				'.main-navigation ul ul, .main-navigation .sub-menu' => array(
					'background-color' => '%1$s',
				),
				'.main-navigation ul.menu > li > a:hover' => array(
					'border-color' => '%1$s',
				),
			),
		),
		'button_color' => array(
			'default' => '#8e452a',
		),
		/**
		 * Background colors
		 */
		'background_color' => array(
			'default' => '#ffffff',
		),
		'hero_background_color' => array(
			'default' => '#435f75',
		),
		'menu_background_color' => array(
			'default'     => '#212121',
			'description' => esc_html__( 'Sub-menu only', 'velux' ),
			'css'         => array(
				'.main-navigation-container' => array(
					'background-color' => 'transparent',
				),
			),
		),
		'footer_widget_background_color' => array(
			'default' => '#212121',
		),
		'footer_background_color' => array(
			'default' => '#191919',
		),
	);

	return primer_array_replace_recursive( $colors, $overrides );

}
add_filter( 'primer_colors', 'velux_colors' );

/**
 * Set color schemes.
 *
 * @filter primer_color_schemes
 * @since  1.0.0
 *
 * @param  array $color_schemes
 *
 * @return array
 */
function velux_color_schemes( $color_schemes ) {

	$overrides = array(
		'blush' => array(
			'colors' => array(
				'menu_background_color'          => '#212121',
				'footer_widget_background_color' => '#212121',
			),
		),
		'bronze' => array(
			'colors' => array(
				'menu_background_color'          => '#212121',
				'footer_widget_background_color' => '#212121',
			),
		),
		'canary' => array(
			'colors' => array(
				'menu_background_color'          => '#212121',
				'footer_widget_background_color' => '#212121',
			),
		),
		'dark' => array(
			'colors' => array(
				'footer_widget_text_color'       => '#999999',
				'link_color'                     => '#51748e',
				'button_color'                   => '#51748e',
				'background_color'               => '#191919',
				'hero_background_color'          => '#191919',
				'menu_background_color'          => '#212121',
				'footer_widget_background_color' => '#212121',
				'footer_background_color'        => '#191919',
			),
		),
		'iguana' => array(
			'colors' => array(
				'menu_background_color'          => '#212121',
				'footer_widget_background_color' => '#212121',
			),
		),
		'muted' => array(
			'colors' => array(
				'footer_widget_heading_text_color' => '#ffffff',
				'footer_widget_text_color'         => '#d5d6e0',
				'footer_widget_background_color'   => '#767f99',
			),
		),
		'plum' => array(
			'colors' => array(
				'menu_background_color'          => '#212121',
				'footer_widget_background_color' => '#212121',
			),
		),
		'rose' => array(
			'colors' => array(
				'menu_background_color'          => '#212121',
				'footer_widget_background_color' => '#212121',
			),
		),
		'tangerine' => array(
			'colors' => array(
				'menu_background_color'          => '#212121',
				'footer_widget_background_color' => '#212121',
			),
		),
		'turquoise' => array(
			'colors' => array(
				'menu_background_color'          => '#212121',
				'footer_widget_background_color' => '#212121',
			),
		),
	);

	return primer_array_replace_recursive( $color_schemes, $overrides );

}
add_filter( 'primer_color_schemes', 'velux_color_schemes' );
