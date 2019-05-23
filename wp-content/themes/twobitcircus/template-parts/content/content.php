<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */

?>

<article id="page" <?php post_class('container mb-6'); ?>>
	<div class="entry-content inview animated">
    <?php the_title( '<h1 class="headline">', '</h1>' ); ?>
    <?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'twobitcircus' ),
				'after'  => '</div>',
			)
		);
		?>
	</div>
</article>
