<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
?>

<article id="page" <?php post_class(); ?>>

  <?php get_template_part( 'template-parts/partial/partial', 'header-no-desc' ); ?>

  <section class="entry-wrapper-padding inview animated delay-2">
    <div class="container">
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
	</section>
</article>
