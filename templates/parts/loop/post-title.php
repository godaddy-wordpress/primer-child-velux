<?php
/**
 * Template part for displaying the post title inside The Loop.
 *
 * @package Velux
 */
?>

<header class="entry-header">

	<div class="entry-header-row">

		<div class="entry-header-column">

			<?php
			/**
			 * Fires before the post title element.
			 *
			 * @package Velux
			 * @since 1.0.0
			 */
			do_action( 'primer_before_post_title' );
			?>

			<?php if ( is_singular() ) : ?>

				<h1 class="entry-title"><?php the_title(); ?></h1>

			<?php else : ?>

				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="permalink"><?php the_title(); ?></a></h2>

			<?php endif; ?>

			<div class="entry-meta">

				<span class="posted-meta">

					<?php printf( esc_html_x( '%1$s | %2$s', '1. post date, 2. author name', 'velux' ), get_the_author_link(), get_the_date() ); ?>

				</span>

			</div><!-- .entry-meta -->

			<?php
			/**
			 * Fires after the post title element.
			 *
			 * @package Velux
			 * @since 1.0.0
			 */
			do_action( 'primer_after_post_title' );
			?>

		</div><!-- .entry-header-column -->

	</div><!-- .entry-header-row -->

</header><!-- .entry-header -->
