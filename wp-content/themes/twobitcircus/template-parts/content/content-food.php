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
  <section id="events-block" class="entry-wrapper-padding inview animated">
    <div class="container">
      <div class="row">
        <div class="col-md-3"></div>
        <div class="col-sm-12 col-md-6 event bkg-color">
        <?php foreach($events as $event) :?>
          <div class="event-header clearfix">
            <div class="top text-center">
            <?php if(!empty($event['events_header'])) :?>
            <h2><?php echo $event['events_header']; ?></h2>
            <?php endif ?>
            </div>
            <div class="bottom text-center">
            <?php if(!empty($event['event_title'])) :?>
            <h5><?php echo $event['event_title']; ?></h5>
            <?php endif ?>
            <?php if(!empty($event['event_sub_title'])) :?>
            <h6><?php echo $event['event_sub_title']; ?></h6>
            <?php endif ?>
            </div>
          </div>
          <div class="event-image">
            <img class="lazy-load img-fluid" data-src="https://via.placeholder.com/228x255"/>
          </div>
        <?php endforeach ?>
        </div>
        <div class="col-md-3"></div>
      </div>
    </div>
  </section>
  <?php endif ?>


  <?php if(get_field('banner_title')) :?>
  <section id="banner-block" class="entry-wrapper-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-8 text-center content-block inview animated delay-1">
          <h2 class="headline"><?php echo get_field('banner_title'); ?></h2>
          <h4><?php echo get_field('banner_sub_title'); ?></h4>
          <h5><?php echo get_field('banner_description'); ?></h5>
        </div>
        <div class="col-md-4 inview animated delay-2"><img class="lazy-load img-fluid" data-src="https://via.placeholder.com/500x300"/></div>
      </div>
    </div>
  </section>
  <?php endif ?>

  <?php if(get_field('menus')) :?>
  <?php $menus = filter_locations(get_field('menus'));?>
  <section id="menu-block" class="entry-wrapper-padding text-center bkg-color">
    <div class="container">
    <?php foreach($menus as $menu) :?>
      <?php if(!empty($menu['menu_title'])) :?>
      <h2 class="headline inview animated"><?php echo $menu['menu_title'];?></h2>
      <?php endif ?>
      <?php if(!empty($menu['menu_download'])) :?>
      <div class="inview animated delay-1" data-ease="fadeInDown">
        <a href="<?php echo $menu['menu_download'];?>" class="btn btn-twobit" target="_blank"><?php _e( 'DOWNLOAD', 'twobitcircus' ) ?></a>
      </div>
      <?php endif ?>
    <?php endforeach ?>
    </div>
  </section>
  <?php endif ?>

</article>
