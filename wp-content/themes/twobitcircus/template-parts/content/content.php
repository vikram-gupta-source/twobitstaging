<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */

?>

<article id="page" <?php post_class('mb-6'); ?>>
  <div class="container-fluid text-center main-headline">
    <?php the_title( '<h1 class="headline inview animated" data-ease="fadeInDown">', '</h1>' ); ?>
  </div> 
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
