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
		'header_font' => array(
			'default' => 'Playfair Display',
			'css'     => array(
				'nav.main-navigation ul li a' => array(
					'font-family' => '"%1$s", serif',
				),
			),
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

	return array(
		'link_color' => array(
			'label'   => __( 'Link Color', 'velux' ),
			'default' => '#51748e',
			'css'     => array(
				'#content a, #content a:visited,
				.entry-footer a, .entry-footer a:visited,
				.sticky .entry-title a:before,
				.footer-widget-area .footer-widget .widget a,
				.footer-widget-area .footer-widget .widget a:visited,
				header .main-navigation-container .menu li.current-menu-item > a:hover,
				header .main-navigation-container .menu li.current-menu-item > a {' => array(
					'color' => '%1$s',
				),
			),
		),
		'background_color' => array(
			'default' => '#ffffff',
			'css'     => array(
				'body' => array(
					'background-color' => '%1$s',
				),
			),
		),
		'button_color' => array(
			'label'   => __( 'Button Color', 'velux' ),
			'default' => '#8e452a',
			'css'     => array(
				'.cta, button, input[type="button"], input[type="reset"], input[type="submit"]:not(.search-submit), a.fl-button' => array(
					'border-bottom' => '2px solid %1$s',
					'color' => '%1$s',
				),
			),
		),
		'w_background_color' => array(
			'label'   => __( 'Widget Background Color', 'velux' ),
			'default' => '#212121',
			'css'     => array(
				'.site-footer' => array(
					'background-color' => '%1$s',
				),
			),
		),
		'footer_background_color' => array(
			'label'   => __( 'Footer Background Color', 'velux' ),
			'default' => '#191919',
			'css'     => array(
				'.site-info-wrapper, .site-info-wrapper' => array(
					'background-color' => '%1$s',
				),
			),
		),
	);

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

	return array(
		'dark_blue' => array(
			'label'  => esc_html__( 'Dark Blue', 'velux' ),
			'colors' => array(
				'background_color'        => '#ffffff',
				'link_color'              => '#363a3d',
				'button_color'            => '#3f7b84',
				'w_background_color'      => '#212121',
				'footer_background_color' => '#191919',
			),
		),
	);

}
add_filter( 'primer_color_schemes', 'velux_color_schemes' );
