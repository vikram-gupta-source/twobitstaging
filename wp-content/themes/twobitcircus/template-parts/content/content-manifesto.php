<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
 remove_filter ('the_content', 'wpautop');
?>

<article id="manifesto-page" <?php post_class(); ?>>

  <?php get_template_part( 'template-parts/partial/partial', 'header-no-desc' ); ?>

  <section class="entry-wrapper-padding inview animated delay-2">
    <div class="container">
    <?php
  		the_content();
  	?>
    </div>
	</section>
</article>
