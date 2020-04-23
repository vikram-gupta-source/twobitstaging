<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
?>
<article id="food-drink" <?php post_class(); ?>>

  <?php if(get_field('events')) :?>
  <?php $events = filter_locations(get_field('events'));?>
  <section id="events-block" class="entry-wrapper-padding pt-0">
    <div class="container-fluid inview animated">
      <div class="row">
        <?php foreach($events as $event) :?>
          <div class="col-md-0 col-lg-2"></div>
          <div class="col-md-12 col-lg-8 event">
            <div class="event-image" style="background-image: url('<?php echo $event['event_image']; ?>')"></div>
            <div class="event-header">
              <div class="top">
              <?php if(!empty($event['events_header'])) :?>
              <h4 class="lubalinB text-uppercase"><?php echo $event['events_header']; ?></h4>
              <?php endif ?>
              </div>
              <div class="bottom">
              <?php if(!empty($event['event_title'])) :?>
              <h4 class="lubalinB card-title text-uppercase"><?php echo $event['event_title']; ?></h4>
              <?php endif ?>
              <?php if(!empty($event['event_sub_title'])) :?>
              <h5><?php echo $event['event_sub_title']; ?></h5>
              <?php endif ?>
              </div>
            </div>
          </div>
          <div class="col-md-0 col-lg-2"></div>
        <?php endforeach ?>
      </div>
    </div>
  </section>
  <?php endif ?>


  <?php if(get_field('banner_title')) :?>
  <section id="banner-block">
    <div class="container-fluid">
      <div class="row h-100">
        <div class="col-md-6 my-auto text-center content-block inview animated delay-1">
          <div class="py-4">
            <h2 class="headline red"><?php echo get_field('banner_title'); ?></h2>
            <h4 class="white"><?php echo get_field('banner_sub_title'); ?></h4>
            <h5 class="white"><?php echo get_field('banner_description'); ?></h5>
          </div>
        </div>
        <div class="col-md-6 banner-image inview animated delay-2" data-ease="fadeIn">
          <?php if(!empty(get_field('video_embed'))) :?>
          <div class="embed-responsive embed-responsive-16by9"><iframe src="<?php echo get_field('video_embed');?>" width="640" height="360" frameborder="0" allow="autoplay; fullscreen" allowfullscreen="" data-ready="true"></iframe></div>
          <?php else: ?>
            <img class="lazy-load img-fluid" data-src="<?php echo get_field('banner_image'); ?>"/>
          <?php endif ?>
        </div>
      </div>
    </div>
  </section>
  <?php endif ?>

  <?php if(get_field('menus')) :?>
  <?php $menus = filter_locations(get_field('menus'));?>
  <section id="menu-block">
    <div class="container-fluid">
      <div class="row no-gutters">
        <div class="col-12 bkg-img"  style="background-image: url('<?php echo $menus[0]['menu_image'] ?>');">
          <?php if(!empty($menus[0]['menu_download'])) :?>
          <div class="cta-wrapper inview animated" data-ease="fadeIn">
            <div class="cta-btn mx-auto"><a class="btn btn-twobit" href="<?php echo $menus[0]['menu_download'] ?>" target="_blank"><span><?php echo $menus[0]['menu_title'];?></span></a><div class="btn-behind">&nbsp;</div></div>
          </div>
          <?php endif ?>
        </div>
      </div>
    </div>
  </section>
  <?php endif ?>

</article>
