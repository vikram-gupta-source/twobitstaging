<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
?>
  <!-- ******************* Header Page ******************* -->
  <?php if(!empty(get_field('general_header_image')) && get_the_title()) :?>
  <div class="main-headline header-bkg-right container-fluid" style="background-image: url('<?php echo get_field('general_header_image'); ?>');background-position: <?php echo get_field('general_header_position');?>;">
    <div class="row h-100">
      <div class="d-md-none"><img class="img-fluid" src="<?php echo get_field('general_header_image'); ?>" alt="<?php the_title();?>"></div>
      <div class="header-bkg-left py-5 my-auto d-flex align-items-center <?php echo get_field('general_header_background_color'); ?>-bk">
        <?php the_title( '<h1 class="headline inview animated text-center mb-0" data-ease="fadeInDown">', '</h1>' ); ?>
      </div>
    </div>
  </div>
  <?php endif ?>
