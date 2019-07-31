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
 $sf = new SocialFeed();
 $social_feed = $sf->get_social_feeds();
 $social_cat = $sf->get_distinct_social();
?>
<article id="home" <?php post_class(); ?>>

  <section id="featured-block" class="entry-wrapper-padding inview animated">
    <?php if(!empty(get_field('feature'))) :?>
    <?php $featured = filter_locations(get_field('feature'));?>
    <div class="featured mt-3 slick slick-center-init">
      <?php foreach($featured as $feature) : ?>
      <div class="card">
        <div class="row no-gutters">
          <div class="col-6">
            <img class="card-img-top" src="https://via.placeholder.com/329x289"/>
          </div>
          <div class="col-6">
            <div class="card-body">
              <?php if(!empty($feature['title'])) :?>
              <h5 class="card-title"><?php echo $feature['title'];?></h5>
              <?php endif ?>
              <?php if(!empty($feature['summary'])) :?>
              <p><?php echo $feature['summary'];?></p>
              <?php endif ?>
              <div class="link-wrapper">
                <?php if(!empty($feature['more_title'])) :?>
                <div class="d-inline-block more"><a href="<?php echo $feature['more_link'];?>" class="btn btn-sm btn-twobit"><?php echo $feature['more_title'];?></a></div>
                <?php endif ?>
                <?php if(!empty($feature['link_title'])) :?>
                <div class="d-inline-block link"><a href="<?php echo $feature['link'];?>" class="btn btn-sm btn-twobit" target="_blank" rel="noopener noreferrer"><?php echo $feature['link_title'];?></a></div>
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
    <div class="container">
      <?php if(!empty( get_field('events_title'))) :?>
      <h2 class="headline text-uppercase text-center mb-5 inview animated"><?php echo get_field('events_title'); ?></h2>
      <?php endif ?>
      <?php if(!empty(get_field('featured_events'))) :?>
      <?php $feature_events = filter_locations(get_field('featured_events'));?>
      <h4 class="text-uppercase inview animated">Featured</h4>
      <div class="featured mt-3 row inview animated delay-1">
        <?php foreach($feature_events as $feature) : ?>
        <div class="col-lg-4">
          <div class="card">
            <a href="<?php echo $feature['link'];?>"><img class="card-img-top lazy-load img-fluid" data-src="https://via.placeholder.com/352x198"/></a>
            <div class="card-body text-center">
              <?php if(!empty($feature['title'])) :?>
              <h5 class="card-title"><?php echo $feature['title'];?></h5>
              <?php endif ?>
              <div class="link-wrapper">
                <?php if(!empty($feature['time'])) :?>
                <div class="d-inline-block time"><?php echo $feature['time'];?></div>
                <?php endif ?>
                <?php if(!empty($feature['link_title'])) :?>
                <div class="d-inline-block link"><a href="<?php echo $feature['link'];?>" class="btn btn-sm btn-twobit" target="_blank" rel="noopener noreferrer"><?php echo $feature['link_title'];?></a></div>
                <?php endif ?>
                <div class="addthis_inline_share_toolbox" data-url="<?php echo $feature['link'];?>" data-title="<?php echo $feature['title'];?>"></div>
              </div>
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
      <h2 class="headline text-uppercase text-center mb-5 inview animated"><?php echo get_field('about_title'); ?></h2>
      <div class="w-75 mx-auto inview animated delay-1" data-ease="fadeInDown"><?php echo get_field('about_description');?></div>
    </div>
  </section>

  <section id="newsletter-block" class="entry-wrapper-padding bkg-color">
    <div class="container">
      <?php echo get_field('newsletter_block', 'option');?>
    </div>
  </section>

  <section id="social-block" class="entry-wrapper-padding">
    <div class="container">
      <h2 class="headline text-uppercase text-center mb-5 inview animated"><?php echo get_field('social_title'); ?></h2>
      <h4 class="text-center text-uppercase inview animated delay-1" data-ease="fadeInDown">Follow what we're up to</h4>
      <div class="row inview animated delay-2">

        <?php if(!empty($social_feed)):?>
        <div class="item-content">

          <?php if(!empty($social_cat)):?>
          <div class="grid-social slick slick-feed">

            <?php foreach($social_cat as $cat): ?>
            <div class="grid-item <?php echo $cat->type;?>">
              <div class="header text-uppercase">
                <?php
                    if($cat->type == 'facebook')
                        $title = '<i class="fa fa-facebook mr-2"></i> <span>Facebook</span>';
                    elseif($cat->type == 'twitter')
                        $title = '<i class="fa fa-twitter mr-2"></i> <span>Twitter</span>';
                    elseif($cat->type == 'youtube')
                        $title = '<i class="fa fa-youtube mr-2"></i> <span>Youtube</span>';
                    elseif($cat->type == 'instagram')
                        $title = '<i class="fa fa-instagram mr-2"></i> <span>Instagram</span>';
                    else $title = '';
                    echo $title;
                ?>
              </div>
              <div class="slick slick-social">
                <?php foreach($social_feed[$cat->type] as $feed): ?>
                <div class="grid-feed">
                  <?php
                      if($feed->type == 'facebook')
                          $likes = $feed->count. ' <i class="fa fa-thumbs-up"></i><span>Likes</span>  Views <i class="fa fa-comment"></i> <span>Comments</span>';
                      elseif($feed->type == 'twitter')
                          $likes = $feed->count. ' <i class="fa fa-retweet"></i><span>Retweet</span>  Views <i class="fa fa-heart"></i><span>Favorited</span>';
                      elseif($feed->type == 'youtube')
                          $likes = $feed->count. ' <i class="fa fa-eye"></i> &nbsp; Views <i class="fa fa-thumbs-up"></i> <span>Likes</span>';
                      elseif($feed->type == 'instagram')
                          $likes = $feed->count. ' <i class="fa fa-thumbs-up"></i> <span>Likes</span>  Views <i class="fa fa-heart"></i><span>Favorited</span>';
                      else $likes = '';
                  ?>
                  <div class="overlay-content">
                    <?php if(!empty($feed->user)):?>
                    <h2 class="profile">
                      <div class="user">
                          <?php if($feed->link) :?><a href="<?php echo $feed->link;?>"  target="_blank"><?php endif ?>
                          <?php echo $feed->user;?><?php if($feed->link) :?></a><?php endif ?>
                          <div class="date"><?php echo human_time_diff($feed->pubdate, current_time('timestamp'));?></div>
                      </div>
                    </h2>
                    <?php endif ?>
                    <?php if($feed->type=='youtube'):?>
                    <div class="video-wrapper">
                      <div class="embed-responsive embed-responsive-16by9">
                          <div class="embed-data" data-src="//www.youtube.com/embed/<?php echo str_replace('https://www.youtube.com/watch?v=', '', $feed->link);?>"></div>
                      </div>
                    </div>
                    <?php elseif(!empty($feed->image)):?>
                    <div class="set"><img class="img-fluid w-100" src="<?php echo $feed->image;?>"/></div>
                    <?php else:?>
                    <div class="set empty"></div>
                    <?php endif ?>
                    <?php if($feed->type != 'youtube'):?>
                    <div class="content">
                        <?php if(!empty($feed->title)):?>
                        <?php if($feed->link) :?><a class="title" href="<?php echo $feed->link;?>" target="_blank"><?php endif ?>
                        <?php echo $feed->title;?><?php if($feed->link) :?></a><?php endif ?>
                        <?php elseif(!empty($feed->text)):?>
                        <p class="text <?php echo @$feed->image;?>">
                        <?php if(!empty($feed->image)):?>
                        <?php if($feed->link) :?><a href="<?php echo $feed->link;?>" target="_blank"><?php endif ?>
                        <?php echo wp_trim_words($feed->text, 160, true);?><?php if($feed->link) :?></a><?php endif ?>
                        <?php else: ?>
                        <?php if($feed->link) :?><a href="<?php echo $feed->link;?>" target="_blank"><?php endif ?>
                        <?php echo wp_trim_words($feed->text, 460, true);?><?php if($feed->link) :?></a><?php endif ?>
                        <?php endif ?>
                        </p>
                        <?php endif ?>
                    </div>
                    <?php elseif($feed->type == 'youtube'):?>
                    <div class="content">
                      <?php if(!empty($feed->title)):?>
                      <?php if($feed->link) :?><a class="title" href="<?php echo $feed->link;?>" target="_blank"><?php endif ?>
                      <?php echo $feed->title;?>
                      <?php if($feed->link) :?></a><?php endif ?>
                    </div>
                    <?php endif ?>
                    <?php endif ?>
                    <?php if(!empty($likes)):?>
                    <div class="likes"><?php echo $likes;?></div>
                    <?php endif ?>
                  </div>

                </div>
                <?php endforeach ?>
              </div>
            </div>
            <?php endforeach ?>

          </div>
          <?php endif ?>

        </div>
        <?php endif ?>

      </div>
    </div>
  </section>

</article>
