<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
?>
<article id="parties" <?php post_class(); ?>>
  <div class="container-fluid text-center main-headline">
    <?php the_title( '<h1 class="headline inview animated" data-ease="fadeInDown">', '</h1>' ); ?>
  </div>
  <?php if (!empty( get_the_content())):?>
  <div class="container-fluid text-center sub-headline">
    <div class="inview animated w-50 mx-auto delay-2"><?php the_content(); ?></div>
  </div>
  <?php endif ?>
  <section id="parties-block" class="entry-wrapper-padding inview animated delay-3">
    <?php if(!empty(get_field('event'))) :?>
      <?php $events = filter_locations(get_field('event'));?>
    <div class="container">
      <div class="grid-isotope">
        <?php foreach($events as $shows) : ?>
        <div class="grid-item card" data-event="<?php echo $shows['event_type'];?>">
          <a href="#" class="event-link"><img class="img-fluid w-100" src="https://via.placeholder.com/329x289"/></a>
          <?php if(!empty($shows['title'])) :?>
          <div class="card-title mb-0 d-flex justify-content-between align-items-center event-link">
            <h5><?php echo $shows['title'];?>
            <?php if(!empty($shows['event_subtitle'])) :?>
            <br><span><?php echo $shows['event_subtitle'];?></span>
            <?php endif ?>
            </h5>
            <i class="fa fa-lg fa-angle-down" aria-hidden="true"></i>
          </div>
          <?php endif ?>
          <div class="card-body text-left collapse fade">
            <?php if(!empty($shows['event_summary'])) :?>
            <p><?php echo $shows['event_summary'];?></p>
            <?php endif ?>
            <div class="link-wrapper">
              <a href="#" class="btn btn-twobit" data-toggle="modal" data-target="#event-form"><?php _e( 'Book Now', 'twobitcircus' )?></a>
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
  <section id="footer-event-block" class="entry-wrapper-padding inview animated delay bkg-color">
    <div class="container text-center">
      <h5><?php echo $banner['title'];?></h5>
      <?php echo apply_filters('the_content', $banner['description']);?>
    </div>
  </section>
  <?php endforeach ?>
  <?php endif ?>

</article>
