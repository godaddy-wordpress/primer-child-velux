<?php

/**
 * Remove hero for all pages except front.
 *
 * @package Velux
 * @since 1.0.0
 */
function velux_remove_hero_if_not_home() {

	remove_action( 'primer_header', 'primer_add_hero', 10 );

	if ( is_front_page() && is_active_sidebar( 'hero' ) ) {
		add_action( 'primer_after_header', 'primer_add_hero' );
	}

}
add_action( 'primer_before_header', 'velux_remove_hero_if_not_home' );

/**
 *
 * Add child and parent theme files.
 *
 * @package Velux
 * @since 1.0.0
 */
function velux_theme_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'parent-style' ) );
}
add_action( 'wp_enqueue_scripts', 'velux_theme_enqueue_styles' );

/**
 *
 * Register Footer Menu.
 *
 * @package Velux
 * @since 1.0.0
 */
function velux_theme_register_nav_menu() {
	 register_nav_menu( 'footer', __( 'Footer Menu', 'velux' ) );
}
add_action( 'after_setup_theme', 'velux_theme_register_nav_menu' );

/**
 * Add mobile menu to header
 *
 * @package Velux
 * @since 1.0.0
 *
 * @link https://codex.wordpress.org/Function_Reference/get_template_part
 */
function velux_add_mobile_menu() {
	get_template_part( 'templates/parts/mobile-menu' );
}
add_action( 'primer_header', 'velux_add_mobile_menu', 0 );

/**
 * Display the footer nav before the site info.
 *
 * @package Velux
 * @since 1.0.0
 */
function velux_add_nav_footer() {

	get_template_part( 'templates/parts/footer-nav' );

}
add_action( 'primer_after_footer', 'velux_add_nav_footer', 10 );

/**
 * Move navigation from after_header to header
 *
 * @package Velux
 * @since 1.0.0
 * @link https://codex.wordpress.org/Function_Reference/remove_action
 * @link https://codex.wordpress.org/Function_Reference/add_action
 */
function velux_move_navigation() {
	remove_action( 'primer_after_header', 'primer_add_primary_navigation', 20 );
	get_template_part( 'templates/parts/primary-navigation' );
}
add_action( 'primer_header', 'velux_move_navigation', 19 );

/**
 * Returns the featured image, custom header or false in this priority order.
 *
 * @package Velux
 * @since 1.0.0
 * @return false|string
 */
function velux_get_custom_header() {
	$post_id = get_queried_object_id();
	$image_size = (int) get_theme_mod( 'full_width' ) === 1 ? 'hero-2x' : 'hero';
	if ( has_post_thumbnail( $post_id ) ) {
		$image = get_the_post_thumbnail_url( $post_id, $image_size );
		if ( getimagesize( $image ) ) {
			return $image;
		}
	}
	$custom_header = get_custom_header();
	if ( ! empty( $custom_header->attachment_id ) ) {
		$image = wp_get_attachment_image_url( $custom_header->attachment_id, $image_size );
		if ( getimagesize( $image ) ) {
			return $image;
		}
	}
	$header_image = get_header_image();
	return $header_image;
}

/**
 * Register sidebar areas.
 *
 * @link  http://codex.wordpress.org/Function_Reference/register_sidebar
 *
 * @package Velux
 * @since 1.0.0
 */
function velux_register_sidebars() {

	/**
	 *
	 * Register Hero Widget.
	 *
	 */
	register_sidebar(
		array(
			'name'          => esc_attr__( 'Hero', 'velux' ),
			'id'            => 'hero',
			'description'   => esc_attr__( 'The Hero widget area.', 'velux' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h6 class="widget-title">',
			'after_title'   => '</h6>',
		)
	);

}
add_action( 'widgets_init', 'velux_register_sidebars' );

/**
 * Add image size for hero image
 *
 * @package Velux
 * @since 1.0.0
 * @link https://codex.wordpress.org/Function_Reference/add_image_size
 */
function velux_add_image_size() {

	add_image_size( 'hero', 2400, 1320, array( 'center', 'center' ) );

}
add_action( 'after_setup_theme', 'velux_add_image_size' );

/**
 * Update custom header arguments
 *
 * @package Velux
 * @since 1.0.0
 * @param $args
 * @return mixed
 */
function velux_update_custom_header_args( $args ) {
	$args['width'] = 2400;
	$args['height'] = 1320;

	return $args;
}
add_filter( 'primer_custom_header_args', 'velux_update_custom_header_args' );

/**
 * Get header image with image size
 *
 * @package Velux
 * @since 1.0.0
 * @return false|string
 */
function velux_get_header_image() {
	$image_size = (int) get_theme_mod( 'full_width' ) === 1 ? 'hero-2x' : 'hero';
	$custom_header = get_custom_header();

	if ( ! empty( $custom_header->attachment_id ) ) {
		$image = wp_get_attachment_image_url( $custom_header->attachment_id, $image_size );
		if ( getimagesize( $image ) ) {
			return $image;
		}
	}
	$header_image = get_header_image();
	return $header_image;
}

/**
 * Update colors
 *
 * @package Velux
 * @since 1.0.0
 * @action primer_colors
 */
function velux_colors() {
	return array(
		array(
			'name'    => 'link_color',
			'label'   => __( 'Link Color', 'velux' ),
			'default' => '#51748e',
			'css'     => array(
				'#content a, #content a:visited, .entry-footer a, .entry-footer a:visited, .sticky .entry-title a:before, .footer-widget-area .footer-widget .widget a, .footer-widget-area .footer-widget .widget a:visited' => array(
					'color' => '%1$s',
				),
			),
		),
		array(
			'name'    => 'background_color',
			'default' => '#fff',
			'css'     => array(
				'body' => array(
					'background-color' => '%1$s',
				),
			),
		),
		array(
			'name'    => 'button_color',
			'label'   => __( 'Button Color', 'velux' ),
			'default' => '#8e452a',
			'css'     => array(
				'.cta, button, input[type="button"], input[type="reset"], input[type="submit"]:not(.search-submit), a.fl-button' => array(
					'border-bottom' => '2px solid %1$s',
					'color' => '%1$s',
				),
			),
		),
		array(
			'name'    => 'w_background_color',
			'label'   => __( 'Widget Background Color', 'velux' ),
			'default' => '#212121',
			'css'     => array(
				'.site-footer' => array(
					'background-color' => '%1$s',
				),
			),
		),
		array(
			'name'    => 'footer_backgroundcolor',
			'label'   => __( 'Footer Background Color', 'velux' ),
			'default' => '#191919',
			'css'     => array(
				'.site-info-wrapper, .footer-nav, .site-info-wrapper' => array(
					'background-color' => '%1$s',
				),
			),
		),
	);
}
add_action( 'primer_colors', 'velux_colors', 9 );

/**
 * Change velux color schemes
 *
 * @action primer_color_schemes
 *
 * @package Velux
 * @since 1.0.0
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
				'footer_backgroundcolor'   => '#191919',
			),
		),
	);
}
add_action( 'primer_color_schemes', 'velux_color_schemes' );

/**
 *
 * Add selectors for font customizing.
 *
 * @package Velux
 * @since 1.0.0
 */
function velux_update_font_types() {
	return	array(
		array(
			'name'    => 'primary_font',
			'label'   => __( 'Primary Font', 'velux' ),
			'default' => 'Roboto',
			'css'     => array(
				'body, p, .hero-wrapper .textwidget p, .site-description, .search-form input[type="search"], .widget li a, .site-info-text, h6, body p, .widget p, ' => array(
					'font-family' => '"%s", sans-serif',
				),
			),
		),
		array(
			'name'    => 'secondary_font',
			'label'   => __( 'Secondary Font', 'velux' ),
			'default' => 'Playfair Display',
			'css'     => array(
				'h1, h2, h3, h4, h5, h6, label, legend, table th, .site-title, .entry-title, .widget-title, .main-navigation li a, button, a.button, input[type="button"], input[type="reset"], input[type="submit"], blockquote, .entry-meta, .entry-footer, .comment-list li .comment-meta .says, .comment-list li .comment-metadata, .comment-reply-link, #respond .logged-in-as, .fl-callout-text, .site-title, .hero-wrapper .textwidget h1, .hero-wrapper .textwidget .button, .main-navigation li a, .widget-title, .footer-nav ul li a, h1, h2, h3, h4, h5, .entry-title, .single .entry-meta, .hero .widget h1, button, .button, .btn, input[type="submit"], .fl-button, .fl-button a' => array(
					'font-family' => '"%s", serif',
				),
			),
		),
	);
}
add_action( 'primer_font_types', 'velux_update_font_types' );

/**
 * Add a default hero image in the header area.
 *
 * @package Velux
 * @since 1.0.0
 * @return array
 */
function velux_add_default_header_image( $array ) {
	$array['default-image'] = get_stylesheet_directory_uri() . '/assets/img/header.png';

	return $array;
}
add_filter( 'primer_custom_header_args', 'velux_add_default_header_image', 20 );
