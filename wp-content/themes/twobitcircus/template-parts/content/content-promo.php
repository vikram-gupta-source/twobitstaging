<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
?>
<article id="promotions" <?php post_class(); ?>>
  <div class="container-fluid text-center main-headline">
    <?php the_title( '<h1 class="headline inview animated" data-ease="fadeInDown">', '</h1>' ); ?>
  </div>
  <?php if (!empty( get_the_content())):?>
  <div class="container-fluid text-center sub-headline">
    <div class="inview animated w-50 mx-auto delay-2"><?php the_content(); ?></div>
  </div>
  <?php endif ?>
  <!-- Go to www.addthis.com/dashboard to customize your tools -->
  <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5d40d77186a2f4a8"></script>
  <section id="promo-block" class="entry-wrapper-padding inview animated delay-3">
    <?php if(!empty(get_field('promotions'))) :?>
    <?php $promotions = filter_locations(get_field('promotions'));?>
    <div class="container">
      <div class="grid-isotope">
        <?php foreach($promotions as $promo) : ?>
        <div class="grid-item card">
          <a href="#" class="event-link"><img class="card-img-top" src="https://via.placeholder.com/329x289"/></a>
          <div class="card-title mb-0 d-flex justify-content-between align-items-center event-link">
            <h5><?php echo $promo['title'];?></h5>
            <i class="fa fa-lg fa-angle-down" aria-hidden="true"></i>
          </div><div class="card-body text-left">
            <?php if(!empty($promo['summary'])) :?>
            <h6><?php echo $promo['summary'];?></h6>
            <?php endif ?>
          </div>
          <div class="card-body text-left collapse fade">
            <?php if(!empty($promo['description'])) :?>
            <p><?php echo $promo['description'];?></p>
            <?php endif ?>
            <div class="addthis_inline_share_toolbox mb-2" data-url="<?php echo $promo['link'];?>" data-title="<?php echo $promo['title'];?>"></div>
            <div class="link-wrapper">
              <a href="#" class="btn btn-twobit"><?php _e( 'Book Now', 'twobitcircus' )?></a>
            </div>
          </div>  
        </div>
        <?php endforeach ?>
      </div>
    </div>
    <?php endif ?>
  </section>

</article>
