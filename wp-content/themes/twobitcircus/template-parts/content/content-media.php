<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
?>
<article id="media-assets" <?php post_class(); ?>>

  <?php get_template_part( 'template-parts/partial/partial', 'header' ); ?>
  
  <section id="media-assets-block" class="entry-wrapper-padding">
    <div class="container">
      <div id="grid-filter" class="inview animated mx-auto delay-2 text-center" data-ease="fadeInDown">
        <a href="#" data-filter=".image" class="btn btn-twobit"><?php _e('Images', 'twobitcircus');?></a>
        <a href="#" data-filter=".video" class="btn btn-twobit"><?php _e('Videos', 'twobitcircus');?></a>
        <a href="#" data-filter=".podcast" class="btn btn-twobit"><?php _e('Podcasts', 'twobitcircus');?></a>
      </div>
      <div class="grid-isotope mt-5">
        <?php if(!empty(get_field('image'))) :?>
        <?php foreach(get_field('image') as $asset) : ?>
        <div class="grid-item image">
          <img class="lazyload img-fluid" src="<?php echo $asset['asset']['url'];?>" alt="<?php echo $asset['asset']['title'];?>"/>
        </div>
        <?php endforeach ?>
        <?php endif ?>
        <?php if(!empty(get_field('video'))) :?>
        <?php foreach(get_field('video') as $asset) : ?>
        <div class="grid-item video">
          <div class="embed-responsive embed-responsive-16by9">
            <?php echo $asset['embed_code'];?>
          </div>
        </div>
        <?php endforeach ?>
        <?php endif ?>
        <?php if(!empty(get_field('podcast'))) :?>
        <?php foreach(get_field('podcast') as $asset) : ?>
        <div class="grid-item podcast">
          <img class="card-img-top lazyload img-fluid" data-src="<?php $asset['embed_code'];?>"/>
        </div>
        <?php endforeach ?>
        <?php endif ?>
      </div>
    </div>

  </section>

</article>
