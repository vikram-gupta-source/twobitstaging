<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
 $promotions = filter_locations(get_field('promotions'));
 $promotionContent = filter_locations(get_field('promotion_content'));
?>
<article id="promotions" <?php post_class(); ?>>

  <?php get_template_part( 'template-parts/partial/partial', 'header' ); ?>

  <!-- Go to www.addthis.com/dashboard to customize your tools -->
  <script defer async type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5d40d77186a2f4a8"></script>
  <section id="promo-block" class="entry-wrapper-padding inview animated delay-3">
    <?php if(!empty($promotions)) :?>

    <div class="container-fluid">
      <?php if(!empty($promotionContent[0])) :?>
      <div class="content-block container mt-2 mb-6 px-md-5">
        <h2 class="default white"><?php echo $promotionContent[0]['content'];?></h2>
        <div class="white"><?php echo $promotionContent[0]['content'];?></div>
      </div>
      <?php endif ?>
      <div class="grid-flex">
        <?php foreach($promotions as $promo) : ?>
        <div class="grid-item card">
          <?php if(!empty($promo['video_embed'])) :?>
          <div class="embed-responsive embed-responsive-16by9"><iframe src="<?php echo $promo['video_embed'];?>" width="640" height="360" frameborder="0" allow="autoplay; fullscreen" allowfullscreen="" data-ready="true"></iframe>
          </div>
          <?php else: ?>
          <a href="#" class="event-link card-image"><img class="img-fluid w-100" src="<?php echo $promo['image']; ?>"/></a>
          <?php endif ?>
          <div class="card-title mb-0 d-flex justify-content-between align-items-center event-link">
            <h5 class="lubalin"><?php echo $promo['title'];?></h5>
            <i class="fa fa-lg fa-angle-down" aria-hidden="true"></i>
          </div><div class="card-body pb-2 text-left">
            <?php if(!empty($promo['summary'])) :?>
            <h6><?php echo $promo['summary'];?></h6>
            <?php endif ?>
          </div>
          <div class="card-body text-left collapse fade">
            <?php if(!empty($promo['description'])) :?>
            <p><?php echo $promo['description'];?></p>
            <?php endif ?>
            <?php if(!empty($promo['link'])) :?>
            <div class="mb-3 text-center mx-auto addthis_toolbox" addthis:url="<?php echo permalinkUrl($promo['link']);?>" addthis:title="<?php echo $promo['title'];?>" addthis:media="<?php echo $promo['image']; ?>">
              <a class="addthis_button_facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
              <a class="addthis_button_twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
            </div>
            <div class="link-wrapper my-2">
              <?php if(!empty($promo['link'])):?>
              <?php $isInternalLink = checkInternalLink($promo['link']);?>
              <div class="cta-btn mx-auto"><a class="btn btn-twobit" href="<?php echo $promo['link'];?>" <?php echo $isInternalLink;?>><span><?php echo (!empty($promo['link_title'])) ? $promo['link_title'] :'Book Now'; ?></span></a><div class="btn-behind">&nbsp;</div></div>
              <?php endif ?>
            </div>
            <?php endif ?>
          </div>
        </div>
        <?php endforeach ?>
      </div>
    </div>
    <?php endif ?>
  </section>

</article>
