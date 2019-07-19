<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
 global $region;
?>
<article id="media-assets" <?php post_class(); ?>>
  <div class="container-fluid text-center main-headline">
    <?php the_title( '<h1 class="headline inview animated" data-ease="fadeInDown">', '</h1>' ); ?>
  </div>
  <?php if (!empty( get_the_content())):?>
  <div class="container-fluid text-center sub-headline">
    <div class="inview animated w-50 mx-auto delay-2"><?php the_content(); ?></div>
  </div>
  <?php endif ?>
  <section id="media-assets-block" class="entry-wrapper-padding inview animated delay-3">
    <?php if(!empty(get_field('media-assets'))) :?>
    <div class="container-fluid">
      <div class="assets">
        <?php foreach($media_assets as $asset) : ?>
        <div class="card">
          <img class="card-img-top" src="https://via.placeholder.com/329x289"/>
        </div>
        <?php endforeach ?>
      </div>
    </div>
    <?php endif ?>
  </section>

</article>
