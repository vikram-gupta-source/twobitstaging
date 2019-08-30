<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
 $cal = new Calendar();
 $calendar = $cal->init();
 $_enddate = $cal->get_endDate();
 $_closed = $cal->get_closed();
 $insta_feed = new InstagramFeed();
 $social_feed = $insta_feed->get_instagram_feeds();
?>
<article id="home" <?php post_class(); ?>>

  <section id="featured-block" class="entry-wrapper-padding">
    <?php if(!empty(get_field('feature'))) :?>
    <?php $featured = filter_locations(get_field('feature'));?>
    <div class="featured mt-3 slick-center-init inview animated">
      <?php foreach($featured as $feature) : ?>
      <div class="card">
        <div class="row no-gutters bkg-<?php echo $feature['background_color']; ?>">
          <div class="col-md-6 bkg-img" style="background-image: url('<?php echo $feature['image']; ?>');"></div>
          <div class="col-md-6">
            <h6 class="card-heading lubalinB text-uppercase"><?php echo $feature['highlight_heading'];?></h6>
            <div class="card-body">
              <?php if(!empty($feature['title'])) :?>
              <h4 class="lubalinB card-title text-uppercase"><?php echo $feature['title'];?></h4>
              <?php endif ?>
              <?php if(!empty($feature['summary'])) :?>
              <p><?php echo $feature['summary'];?></p>
              <?php endif ?>
              <div class="link-wrapper mt-3">
                <?php if(!empty($feature['more_title'])) :?>
                <div class="more">
                  <?php echo do_shortcode('[button link="'.$feature['more_link'].'"]'.$feature['more_title'].'[/button]') ?>
                </div>
                <?php endif ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach ?>
    </div>
    <?php endif ?>
  </section>
  <!-- Go to www.addthis.com/dashboard to customize your tools -->
  <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5d40d77186a2f4a8"></script>
  <section id="events-block" class="entry-wrapper-padding bkg-color">
    <div class="container-fluid">
      <?php if(!empty( get_field('events_title'))) :?>
      <h2 class="headline text-uppercase text-center mb-5 inview animated"><?php echo get_field('events_title'); ?></h2>
      <?php endif ?>
      <?php if(!empty(get_field('featured_events'))) :?>
      <?php $feature_events = filter_locations(get_field('featured_events'));?>
      <div class="featured mt-3 slick-event inview animated">
        <?php foreach($feature_events as $feature) : ?>
        <div class="card">
          <a href="<?php echo $feature['link'];?>"><img class="card-img-top img-fluid" src="<?php echo $feature['image']; ?>"/></a>
          <div class="card-body">
            <?php if(!empty($feature['title'])) :?>
            <h5 class="lubalinB card-title text-uppercase"><?php echo $feature['title'];?></h5>
            <div class="dateline"><?php echo $feature['date'];?></div>
            <div class="time"><?php echo $feature['time'];?></div>
            <?php endif ?>
            <div class="mt-3 mx-auto addthis_toolbox" data-url="<?php echo $feature['link'];?>" data-title="<?php echo $feature['title'];?>">
              <a class="addthis_button_facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
              <a class="addthis_button_twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
              <a class="addthis_button_instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>
            </div>
            <div class="link-wrapper mt-2">
              <?php if(!empty($feature['link_title'])) :?>
              <div class="link">
                <?php echo do_shortcode('[button target="_blank" link="'.$feature['link'].'"]'.$feature['link_title'].'[/button]') ?>
              </div>
              <?php endif ?>
            </div>
          </div>
        </div>

        <?php endforeach ?>
      </div>
      <?php endif ?>
    </div>
  </section>

  <?php get_template_part( 'template-parts/partial/partial', 'calendar' ); ?>

  <section id="about-block" class="entry-wrapper-padding text-center">
    <div class="container">
      <div class="vector vector-left inview animated delay-1" data-ease="fadeIn"><img class="lazy-loaded img-fluid" data-src="/wp-content/themes/twobitcircus/img/home/home_about_left.png" alt="<?php echo get_field('about_title'); ?>" /></div>
      <div class="vector vector-right inview animated delay-1" data-ease="fadeIn"><img class="lazy-loaded img-fluid" data-src="/wp-content/themes/twobitcircus/img/home/home_about_right.png" alt="<?php echo get_field('about_title'); ?>" /></div>
      <h2 class="headline text-uppercase text-center mb-2 inview animated"><?php echo get_field('about_title'); ?></h2>
      <div class="w-65 mx-auto mb-4 inview animated white" data-ease="fadeInDown"><?php echo get_field('about_description');?></div>
    </div>
  </section>

  <section id="newsletter-block" class="entry-wrapper-padding">
    <div class="container">
      <?php echo get_field('newsletter_block', 'option');?>
    </div>
  </section>

  <section id="social-block" class="entry-wrapper-padding">
    <div class="container-fluid white">
      <h2 class="headline text-uppercase text-center mb-2 inview animated"><?php echo get_field('social_title'); ?></h2>
      <h4 class="text-center text-uppercase inview animated" data-ease="fadeInDown">Follow what we're up to</h4>
      <div class="inview animated mt-3">
      <?php if(!empty($social_feed)):?>

        <div class="slick slick-social social-item">
              <?php foreach($social_feed as $feed): ?>
              <div class="grid-feed">
                <div class="overlay-content">
                  <img class="img-fluid w-100" src="<?php echo $feed->image;?>"/>
                  <?php
                    $likes = $feed->count. ' <i class="fa fa-thumbs-up"></i> <span>Likes</span>  Views <i class="fa fa-heart"></i><span>Favorited</span>';
                  ?>
                  <?php if(!empty($likes)):?>
                  <div class="likes"><?php echo $likes;?></div>
                  <?php endif ?>
                </div>

              </div>
              <?php endforeach ?>
            </div>

      <?php endif ?>
      </div>
    </div>
  </section>

</article>
