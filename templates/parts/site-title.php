<?php
/**
 * Displays the site title.
 *
 * @package Velux
 */
?>

<div class="site-title-wrapper">

	<?php if ( has_custom_logo() ) : ?>

		<?php the_custom_logo() ?>

	<?php else : ?>

		<h1 class="site-title">

			<a href="<?php echo esc_url( home_url( '/' ) ) ?>" rel="home"><?php bloginfo( 'name' ) ?> </a>

		</h1>

		<span class="site-description"><?php bloginfo( 'description' ) ?></span>

	<?php endif; ?>

</div><!-- .site-title-wrapper -->
