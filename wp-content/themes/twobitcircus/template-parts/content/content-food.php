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
    <div class="container">
      <div class="row">
        <div class="col-md-3"></div>
        <div class="col-sm-12 col-md-6 event inview animated">
        <?php foreach($events as $event) :?>
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
        <?php endforeach ?>
        </div>
        <div class="col-md-3"></div>
      </div>
    </div>
  </section>
  <?php endif ?>


  <?php if(get_field('banner_title')) :?>
  <section id="banner-block">
    <div class="container-fluid">
      <div class="row h-100">
        <div class="col-md-6 my-auto text-center content-block inview animated delay-1">
          <div class="">
            <h2 class="headline"><?php echo get_field('banner_title'); ?></h2>
            <h4><?php echo get_field('banner_sub_title'); ?></h4>
            <h5><?php echo get_field('banner_description'); ?></h5>
          </div>
        </div>
        <div class="col-md-6 banner-image inview animated delay-2" data-ease="fadeIn"><img class="lazy-load img-fluid" data-src="<?php echo get_field('banner_image'); ?>"/></div>
      </div>
    </div>
  </section>
  <?php endif ?>

  <?php if(get_field('menus')) :?>
  <?php $menus = filter_locations(get_field('menus'));?>
  <section id="menu-block" class="entry-wrapper-padding text-center">
    <div class="container">
    <?php foreach($menus as $menu) :?>
      <?php if(!empty($menu['menu_title'])) :?>
      <h2 class="headline inview animated"><?php echo $menu['menu_title'];?></h2>
      <?php endif ?>
      <?php if(!empty($menu['menu_download'])) :?>
      <div class="mt-4 inview animated delay-1" data-ease="fadeInDown">
        <div class="cta-btn mx-auto"><a class="btn btn-twobit" href="<?php echo $menu['menu_download'] ?>" target="_blank"><span><?php _e( 'DOWNLOAD', 'twobitcircus' ) ?></span></a><div class="btn-behind">&nbsp;</div></div>
      </div>
      <?php endif ?>
    <?php endforeach ?>
    </div>
  </section>
  <?php endif ?>

</article>
