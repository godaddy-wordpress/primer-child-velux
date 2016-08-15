<?php

/**
 * Moving templates elements around
 *
 * @action template_redirect
 * @since 1.0.0
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
 * Add mobile menu to header
 *
 * @action primer_header
 * @since 1.0.0
 *
 * @link https://codex.wordpress.org/Function_Reference/get_template_part
 */
function velux_add_mobile_menu() {

	get_template_part( 'templates/parts/mobile-menu' );

}
add_action( 'primer_header', 'velux_add_mobile_menu', 0 );

/**
 * Add foother navigation
 *
 * @action primer_before_site_info
 * @since 1.0.0
 */
function velux_add_footer_navigation() {

	get_template_part( 'templates/parts/footer-navigation' );

}
add_action( 'primer_before_site_info', 'velux_add_footer_navigation' );

/**
 * Add background images if there is one
 *
 * @filter primer_header_style_attr
 * @since 1.0.0
 *
 * @param string $header_styles
 *
 * @return string
 */
function velux_header_style_attr( $header_styles ) {

	if ( primer_has_hero_image() ) {

		$header_styles .= sprintf( "background:url('%s') no-repeat top center; background-size: cover;", esc_attr( primer_get_hero_image() ) );

	}

	return $header_styles;

}
add_filter( 'primer_header_style_attr', 'velux_header_style_attr' );

/**
 * If there is a custom logo we don't want to print the site title text.
 *
 * @filter primer_print_site_title_text
 * @param boolean $bool
 * @param boolean $has_logo
 *
 * @return bool
 */
function velux_print_site_title( $bool, $has_logo ) {

	return ! $has_logo;

}
add_filter( 'primer_print_site_title_text', 'velux_print_site_title', 10, 2 );

/**
 * Add child and parent theme files.
 *
 * @action wp_enqueue_scripts
 * @since 1.0.0
 */
function velux_theme_enqueue_styles() {

	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'parent-style' ) );

}
add_action( 'wp_enqueue_scripts', 'velux_theme_enqueue_styles' );

/**
 * Register Footer Menu.
 *
 * @filter primer_nav_menus
 * @since   1.0.0
 *
 * @param $menu
 */
function velux_register_nav_menu( $menu ) {

	$menu[ 'footer' ] = __( 'Footer Menu', 'activation' );

	return $menu;

}
add_filter( 'primer_nav_menus', 'velux_register_nav_menu' );

/**
 * Register sidebar areas.
 *
 * @link    http://codex.wordpress.org/Function_Reference/register_sidebar
 *
 * @filter primer_sidebars
 * @since   1.0.0
 *
 * @param array $sidebars
 *
 * @return array
 */
function velux_register_sidebars( $sidebars ) {

	/**
	 * Register Hero Widget.
	 */
	$sidebars['hero'] = array(
		'name'          => esc_attr__( 'Hero', 'velux' ),
		'id'            => 'hero',
		'description'   => esc_attr__( 'The Hero widget area.', 'velux' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h6 class="widget-title">',
		'after_title'   => '</h6>',
	);

	return $sidebars;

}
add_filter( 'primer_sidebars', 'velux_register_sidebars' );

/**
 * Add image size for hero image
 *
 * @filter primer_image_sizes
 * @since   1.0.0
 * @link    https://codex.wordpress.org/Function_Reference/add_image_size
 *
 * @param array $images_sizes
 *
 * @return array
 */
function velux_add_image_size( $images_sizes ) {

	$images_sizes['primer-hero']['width']  = 2400;
	$images_sizes['primer-hero']['height'] = 1320;

	return $images_sizes;

}
add_filter( 'primer_image_sizes', 'velux_add_image_size' );

/**
 * Update custom header arguments
 *
 * @filter primer_custom_header_args
 * @since 1.0.0
 * @param $args
 *
 * @return mixed
 */
function velux_update_custom_header_args( $args ) {

	$args['width']  = 2400;
	$args['height'] = 1320;

	return $args;

}
add_filter( 'primer_custom_header_args', 'velux_update_custom_header_args' );

/**
 * Update colors
 *
 * @filter primer_colors
 * @since 1.0.0
 * @action primer_colors
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
 * Change velux color schemes
 *
 * @action primer_color_schemes
 * @since 1.0.0
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

/**
 *
 * Add selectors for font customizing.
 *
 * @filter primer_font_types
 * @since 1.0.0
 *
 * @return array
 */
function velux_update_font_types() {

	return array(
		'primary_font' => array(
			'label'   => __( 'Primary Font', 'velux' ),
			'default' => 'Roboto',
			'css'     => array(
				'body, p, .hero-wrapper .textwidget p, .site-description, .search-form input[type="search"], .widget li a, .site-info-text, h6, body p, .widget p, ' => array(
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
