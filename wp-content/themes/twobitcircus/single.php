<?php
/**
 * The template for displaying all single posts
 *
 * @package twobitcircus
 */

get_header();
?>

	<section id="single-template" class="container">

			<?php

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

        get_template_part( 'template-parts/content/content' ); 

				if ( is_singular( 'attachment' ) ) {
					// Parent post navigation.
					the_post_navigation(
						array(
							/* translators: %s: parent post link */
							'prev_text' => sprintf( __( '<span class="meta-nav">Published in</span><span class="post-title">%s</span>', 'twobitcircus' ), '%title' ),
						)
					);
				} elseif ( is_singular( 'post' ) ) {
					// Previous/next post navigation.
					the_post_navigation(
						array(
							'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next Post', 'twobitcircus' ) . '</span> ' .
								'<span class="screen-reader-text">' . __( 'Next post:', 'twobitcircus' ) . '</span> <br/>' .
								'<span class="post-title">%title</span>',
							'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous Post', 'twobitcircus' ) . '</span> ' .
								'<span class="screen-reader-text">' . __( 'Previous post:', 'twobitcircus' ) . '</span> <br/>' .
								'<span class="post-title">%title</span>',
						)
					);
				}

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}

			endwhile; // End of the loop.
			?>

		</main>
	</section>

<?php
get_footer();
