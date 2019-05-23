<?php
/**
 * The template for displaying search results pages
 *
 * @package twobitcircus
  */

get_header();
?>

	<section id="search-template" class="container">

		<?php if ( have_posts() ) : ?>

			<h1 class="headline inview animated">
				<?php _e( 'Search results for:', 'Two Bit Circus' ); ?>
			</h1>
			<div class="page-description"><?php echo get_search_query(); ?></div>

			<?php
			// Start the Loop.
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content/content');

				// End the loop.
			endwhile;

			// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content/content' );

		endif;
		?>
	</section>

<?php
get_footer();
