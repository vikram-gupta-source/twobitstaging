<?php
/**
 * The template for displaying all single posts
 *
 * @package twobitcircus
 */

get_header();
?>

	<section id="page-template">

			<?php

			/* Start the Loop */
			while ( have_posts() ) :
        if ( !empty(get_field('header_image')) ) {
          $header_image = get_field('header_image');
        ?>
          <section class="hero parallax-container">
            <div class="parallax"><img class="animated fadeIn delay-1" src="<?php echo $header_image['url']; ?>" alt="<?php echo $header_image['title']; ?>" /></div>
          </section>
        <?php
        }
				the_post();
        if(is_front_page()) {
          get_template_part( 'template-parts/content/content', 'home' );
        } else {
          get_template_part( 'template-parts/content/content' );
        }
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}

        if ( !empty(get_field('footer_image')) ) {
          $footer_image = get_field('footer_image');
        ?>
        <section class="hero footer darken parallax-container inview animated" data-ease="fadeIn" data-offset="80%">
          <div class="parallax"><img class="lazy-loaded" data-src="<?php echo $footer_image['url']; ?>" alt="<?php echo $footer_image['title']; ?>" /></div>
          <div class="container">
            <div class="footer-cell">
            <?php if(!empty(get_field('footer_title'))) :?>
            <h2 class="inview animated" data-ease="fadeInUp"><?php echo get_field('footer_title'); ?></h2>
            <?php endif ?>
            <?php if(!empty(get_field('footer_description'))) :?>
            <div class="copy mt-3 w-50 inview animated delay-2" data-ease="fadeInDown"><?php echo get_field('footer_description'); ?></div>
            <?php endif ?>
          </div>
          </div>
        </section>
        <?php
        }

			endwhile; // End of the loop.
			?>

	</section><!-- #primary -->

<?php
get_footer();
