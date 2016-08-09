<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/template-files-section/partial-and-miscellaneous-template-files/#header-php
 *
 * @package Velux
 */
?><!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="profile" href="http://gmpg.org/xfn/11">

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<?php do_action( 'primer_body_inside' ); ?>

	<div id="page" class="hfeed site">

		<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'primer' ); ?></a>

		<?php do_action( 'primer_before_header' ); ?>

		<?php $header_img = velux_get_header_image(); ?>

		<header id="masthead" class="site-header" role="banner"<?php if ( ! empty( $header_img ) ) : ?> style="background:url('<?php echo $header_img; ?>') no-repeat top center; background-size: cover;"<?php endif; ?>>

			<div class="site-header-wrapper">

				<div class="site-header-inner">

					<?php do_action( 'primer_header' ); ?>

				</div>

			</div>

			<div class="row">

				<?php do_action( 'primer_after_header' ); ?>

			</div>

		</header><!-- #masthead -->



		<div id="content" class="site-content">
