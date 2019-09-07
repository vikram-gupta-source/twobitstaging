<?php
/**
 * The template for displaying all single posts
 *
 * @package twobitcircus
 */

get_header();
?>

	<section id="single-template">

			<?php

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

        get_template_part( 'template-parts/content/content', 'news-single');
  
			endwhile; // End of the loop.
			?>

		</main>
	</section>

<?php
get_footer();
