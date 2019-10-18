<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
 remove_filter ('the_content', 'wpautop');
?>
<article id="parties" <?php post_class(); ?>>

  <?php get_template_part( 'template-parts/partial/partial', 'header' ); ?>

  <section id="parties-block" class="entry-wrapper-padding inview animated delay-3">
    <?php if(!empty(get_field('event'))) :?>
      <?php $events = filter_locations(get_field('event'));?>
    <div class="container-fluid">
      <div class="grid-flex">
        <?php foreach($events as $shows) : ?>
        <div class="grid-item card" data-event="<?php echo $shows['event_type'];?>" id="<?php echo sanitize_title($shows['title']);?>">
          <a href="#" class="event-link card-image"><img class="img-fluid w-100" src="<?php echo $shows['event_image']; ?>"/></a>
          <?php if(!empty($shows['title'])) :?>
          <div class="card-title mb-0 d-flex justify-content-between align-items-center event-link">
            <h5 class="lubalin"><?php echo $shows['title'];?>
            <?php if(!empty($shows['event_subtitle'])) :?>
            <br><span class="roboto"><?php echo $shows['event_subtitle'];?></span>
            <?php endif ?>
            </h5>
            <i class="fa fa-lg fa-angle-down" aria-hidden="true"></i>
          </div>
          <?php endif ?>
          <div class="card-body text-left collapse fade">
            <?php if(!empty($shows['event_summary'])) :?>
            <p><?php echo $shows['event_summary'];?></p>
            <?php endif ?>
            <div class="link-wrapper my-2">
              <div class="cta-btn mx-auto"><a class="btn btn-twobit" data-toggle="modal" data-target="#event-form" href="#"><span><?php echo $shows['event_cta_title'];?></span></a><div class="btn-behind">&nbsp;</div></div>
            </div>
          </div>
        </div>
        <?php endforeach ?>
      </div>
    </div>
    <?php endif ?>
  </section>

  <div class="modal fade" id="event-form" tabindex="-1" role="dialog" aria-labelledby="event-form" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?php echo do_shortcode('[contact-form-7 id="431" title="Parties & Events"]');?>
        </div>
      </div>
    </div>
  </div>

  <?php if(!empty(get_field('footer_block'))) :?>
  <?php $footer = filter_locations(get_field('footer_block'));?>
  <?php foreach($footer as $banner) : ?>
  <section id="footer-event-block" class="entry-wrapper-padding inview animated delay bkg-img" style="background-image: url('<?php echo $banner['image'];?>');">
    <div class="container text-center">
      <h2 class="headline text-uppercase"><?php echo $banner['title'];?></h2>
      <?php echo apply_filters('the_content', $banner['description']);?>
    </div>
  </section>
  <?php endforeach ?>
  <?php endif ?>

</article>
