<?php
/**
 * Displays the site title.
 *
 * @package Primer
 */
?>

<div class="site-title-wrapper">

	<?php if ( has_custom_logo() ) : ?>

		<?php the_custom_logo() ?>

	<?php else : ?>

		<h1 class="site-title">

			<a href="<?php echo esc_url( home_url( '/' ) ) ?>" rel="home"><?php bloginfo( 'name' ) ?><span class="site-description"><?php bloginfo( 'description' ) ?></span></a>

		</h1>

	<?php endif; ?>

</div><!-- .site-title-wrapper -->
