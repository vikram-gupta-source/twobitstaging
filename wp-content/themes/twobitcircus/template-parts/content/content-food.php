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
  <section id="events-block" class="entry-wrapper-padding">
    <div class="container-fluid inview animated">
      <div class="row">
        <?php foreach($events as $event) :?>
          <div class="col-sm-0 col-lg-2 bkg-img" style="background-image: url('<?php echo $event['event_side_image']; ?>')"></div>
          <div class="col-sm-12 col-lg-8 event">
            <div class="event-header clearfix">
              <div class="top text-center">
              <?php if(!empty($event['events_header'])) :?>
              <h2 class="lubalinB text-uppercase"><?php echo $event['events_header']; ?></h2>
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
            <div class="event-image" style="background-image: url('<?php echo $event['event_image']; ?>')"></div>
          </div>
          <div class="col-sm-0 col-lg-2 bkg-img" style="background-image: url('<?php echo $event['event_side_image_2']; ?>')"></div>
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
        <div class="col-md-6 banner-image inview animated delay-2" data-ease="fadeIn"><img class="lazy-load img-fluid" data-src="<?php echo get_field('banner_image'); ?>"/></div>
      </div>
    </div>
  </section>
  <?php endif ?>

  <?php if(get_field('menus')) :?>
  <?php $menus = filter_locations(get_field('menus'));?>
  <section id="menu-block">
    <div class="container-fluid">
      <div class="row no-gutters">
      <?php foreach($menus as $menu) :?>
        <?php if(!empty($menu['menu_download'])) :?>
        <div class="col-md-4 inview animated delay-1" data-ease="fadeIn">
          <img class="img-fuild w-100" src="<?php echo $menu['menu_image'] ?>" />
          <div class="cta-wrapper">
            <div class="cta-btn mx-auto"><a class="btn btn-twobit" href="<?php echo $menu['menu_download'] ?>" target="_blank"><span><?php echo $menu['menu_title'];?></span></a><div class="btn-behind">&nbsp;</div></div>
          </div>
        </div>
        <?php endif ?>
      <?php endforeach ?>
      </div>
    </div>
  </section>
  <?php endif ?>

</article>
