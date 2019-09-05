<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
?>
<article id="jobs" <?php post_class('bkg-white'); ?>>

  <?php get_template_part( 'template-parts/partial/partial', 'header-no-desc' ); ?>

  <section id="jobs-accordion" class="entry-wrapper-padding inview animated delay-3">
    <div class="jobs-wrapper container">
      <?php the_content() ?>
    </div>
    <script>
      function resizeResumatorIframe(height,nojump){
        if(nojump== 0){
          window.scrollTo(0,0);
        }
        document.getElementById("resumator-job-frame").height = parseInt(height)+20;
        document.getElementById("resumator-park-job-frame").height = parseInt(height)+20;
      }
    </script>
  </section>

</article>
