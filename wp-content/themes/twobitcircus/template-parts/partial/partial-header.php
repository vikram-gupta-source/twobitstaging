<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
?>
  <!-- ******************* Header Page ******************* -->
  <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
  <?php if(!empty($image) && get_the_title()) :?>
  <div class="main-headline header-bkg-right" style="background-image: url('<?php echo $image[0]; ?>')">
    <div class="row no-gutters">
      <div class="col-md-7 col-lg-6 col-xl-5 header-bkg-left">
        <?php the_title( '<h1 class="headline inview animated text-center" data-ease="fadeInDown">', '</h1>' ); ?>
        <?php if (!empty( get_the_content())):?>
        <div class="text-center w-65 mx-auto"><?php the_content(); ?></div>
        <?php endif ?>
      </div>
      <div class="col-md-5 col-lg-6 col-xl-7"></div>
    </div>
  </div>
  <?php endif ?>
