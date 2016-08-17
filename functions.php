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
 * If there is a custom logo we don't want to print the site title text.
 *
 * @filter primer_print_site_title_text
 * @since  1.0.0
 *
 * @param bool $bool
 * @param bool $has_logo
 *
 * @return bool
 */
function velux_print_site_title( $bool, $has_logo ) {

	return ! $has_logo;

}
add_filter( 'primer_print_site_title_text', 'velux_print_site_title', 10, 2 );

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
 * Register font types.
 *
 * @filter primer_font_types
 * @since  1.0.0
 *
 * @return array
 */
function velux_update_font_types() {

	return array(
		'primary_font' => array(
			'label'   => __( 'Primary Font', 'velux' ),
			'default' => 'Roboto',
			'css'     => array(
				'p, .site-description, .search-form input[type="search"], .widget a, .site-info-text, h6, .widget p, ' => array(
					'font-family' => '"%s", sans-serif',
				),
			),
		),
		'secondary_font' => array(
			'label'   => __( 'Secondary Font', 'velux' ),
			'default' => 'Playfair Display',
			'css'     => array(
				'h1, h2, h3, h4, h5, h6, label, legend, table th, .site-title, .entry-title, .widget-title, .main-navigation li a, button, a.button, input[type="button"], input[type="reset"], input[type="submit"], blockquote, .entry-meta, .entry-footer, .comment-list li .comment-meta .says, .comment-list li .comment-metadata, .comment-reply-link, #respond .logged-in-as, .fl-callout-text, .site-title, .hero-wrapper .textwidget h1, .hero-wrapper .textwidget .button, .main-navigation li a, .widget-title, .footer-menu ul li a, h1, h2, h3, h4, h5, .entry-title, .single .entry-meta, .hero .widget h1, button, .button, .btn, input[type="submit"], .fl-button, .fl-button a' => array(
					'font-family' => '"%s", serif',
				),
			),
		),
	);

}
add_filter( 'primer_font_types', 'velux_update_font_types' );

/**
 * Register colors.
 *
 * @filter primer_colors
 * @since  1.0.0
 *
 * @return array
 */
function velux_colors() {

	return array(
		'link_color' => array(
			'label'   => __( 'Link Color', 'velux' ),
			'default' => '#51748e',
			'css'     => array(
				'#content a, #content a:visited, .entry-footer a, .entry-footer a:visited, .sticky .entry-title a:before, .footer-widget-area .footer-widget .widget a, .footer-widget-area .footer-widget .widget a:visited, header .main-navigation-container .menu li.current-menu-item > a:hover ,
				header .main-navigation-container .menu li.current-menu-item > a {' => array(
					'color' => '%1$s',
				),
			),
		),
		'background_color' => array(
			'default' => '#fff',
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
add_filter( 'primer_colors', 'velux_colors', 9 );

/**
 * Register color schemes.
 *
 * @filter primer_color_schemes
 * @since  1.0.0
 *
 * @return array
 */
function velux_color_schemes() {

	return array(
		'dark_blue' => array(
			'label'  => esc_html__( 'Dark Blue', 'velux' ),
			'colors' => array(
				'background_color'         => '#ffffff',
				'link_color'               => '#363a3d',
				'button_color'			   => '#3f7b84',
				'w_background_color'	   => '#212121',
				'footer_background_color'  => '#191919',
			),
		),
	);

}
add_filter( 'primer_color_schemes', 'velux_color_schemes' );
