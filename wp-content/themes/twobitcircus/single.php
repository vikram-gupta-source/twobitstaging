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
      $category = get_the_category(); 
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();
        if($category[0]->slug == 'blog')
        get_template_part( 'template-parts/content/content', 'blog-single');
        else
        get_template_part( 'template-parts/content/content', 'news-single');

			endwhile; // End of the loop.
			?>

		</main>
	</section>

<?php
get_footer();
