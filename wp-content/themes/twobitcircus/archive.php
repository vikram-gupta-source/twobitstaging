<?php
/**
 * The template for displaying archive pages
 *
 * @package twobitcircus
 */

get_header();
?>

	<section id="archive-template" class="container">

		<?php if ( have_posts() ) : ?>

			<?php the_archive_title( '<h1 class="headline inview animated">', '</h1>' ); 	?>

			<?php
			// Start the Loop.
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content/content' );

				// End the loop.
			endwhile;

			// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content/content' );

		endif;
		?>
	</section><!-- #primary -->

<?php
get_footer();
