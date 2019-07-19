<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
 global $region;
 $cal = new Calendar();
 $calendar = $cal->init();
 $_enddate = $cal->get_endDate();
 $_closed = $cal->get_closed();
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

  <section id="events-block" class="entry-wrapper-padding bkg-color">
    <div class="container">
      <?php if(!empty( get_field('events_title'))) :?>
      <h2 class="headline text-uppercase text-center mb-5 inview animated"><?php echo get_field('events_title'); ?></h2>
      <?php endif ?>
      <?php if(!empty(get_field('featured_events'))) :?>
      <?php $feature_events = filter_locations(get_field('featured_events'));?>
      <h4 class="text-uppercase inview animated delay-1">Featured</h4>
      <div class="featured mt-3 row inview animated delay-2">
        <?php foreach($feature_events as $feature) : ?>
        <div class="col-lg-4">
          <div class="card">
            <img class="card-img-top lazy-load img-fluid" data-src="https://via.placeholder.com/352x198"/>
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
              </div>
            </div>
          </div>
        </div>
        <?php endforeach ?>
      </div>
      <?php endif ?>

      <?php if(!empty($calendar)) :?>
      <div class="calender-planner">
        <div class="calender-wrapper inview animated">
          <div class="calender slick slick-init">

          <?php
            $current_date = time();
            $day_count = 0;

            do {
              $isClosed = false;
              $day = date('d', $current_date);
              $dayname = date('D', $current_date);
            ?>
            <?php if(in_array($dayname, $_closed)) $isClosed = true; ?>
              <div class="grid <?php echo ($isClosed) ? 'closed' : '';?> <?php echo ($day_count==0)?'active':'';?>">
                <div class="grid-time text-center">
                  <div class="header clearfix">
                    <div class="day text-uppercase"><?php echo $dayname;?></div>
                    <div class="date text-uppercase"><?php echo date('M d', $current_date);?></div>
                  </div>
                  <?php if($isClosed) : ?>
                  <div class="entry text-uppercase"><div class="cell"><span class="time"><?php echo get_field('calendar_closed_text', 'option');?></span></div></div>
                <?php elseif(!empty($calendar[$day])) :?>
                  <div class="entry">
                    <div class="cell">
                      <?php ksort($calendar[$day]); ?>
                      <?php foreach($calendar[$day] as $times) : ?>
                      <?php foreach($times as $time) :?>
                      <?php if(!empty($time->link)) :?>
                      <a href="<?php echo (isset($time->target)) ? $time->link : 'https://twobitcircus.centeredgeonline.com'.$time->link;?>" class="time" target="<?php echo (isset($time->target) && $time->target == '_self') ? '_self' : '_blank';?>" rel="noopener" onclick="gtag('event', '<?php echo preg_replace('/Club\s01\s|Club01\s/', '', $time->name);?>', {'event_category': 'Calendar Link', 'event_label': '<?php echo (isset($time->target)) ? $time->link : 'https://twobitcircus.centeredgeonline.com'.$time->link;?>'});">
                      <?php else :?>
                      <span class="time">
                      <?php endif ?>
                        <?php echo preg_replace('/Club\s01\s|Club01\s/', '', $time->name);?>
                        <?php if(!empty($time->ticket_alt) || !empty($time->ticket)) :?>
                        <button type="button" class="button"><?php echo (!empty($time->ticket_alt)) ? $time->ticket_alt : ltrim($time->ticket, '0');?></button>
                        <?php endif ?>
                      <?php if(!empty($time->link)) :?>
                      </a>
                      <?php else :?>
                      </span>
                      <?php endif ?>
                      <?php endforeach ?>
                      <?php endforeach ?>
                    </div>
                  </div>
                  <?php else :?>
                  <div class="entry no-shows text-uppercase"><div class="cell"><span class="time"><?php echo get_field('calendar_blank_text', 'option');?></span></div></div>
                  <?php endif ?>
                </div>
              </div>
            <?php
                $current_date = strtotime('+1 day', $current_date);
                $day_count ++;
            } while ($current_date <= $_enddate);
            ?>
          </div>
        </div>
      </div>
      <?php endif ?>

    </div>
  </section>

  <section id="about-block" class="entry-wrapper-padding text-center">
    <div class="container">
      <h2 class="headline text-uppercase text-center mb-5 inview animated delay-1"><?php echo get_field('about_title'); ?></h2>
      <div class="w-75 mx-auto inview animated delay-2" data-ease="fadeInDown"><?php echo get_field('about_description');?></div>
    </div>
  </section>

  <section id="social-block" class="entry-wrapper-padding bkg-color">
    <div class="container">
      <div class="row inview animated delay-1">
      <?php echo get_field('newsletter');?>
      </div>
    </div>
  </section>

  <section id="social-block" class="entry-wrapper-padding">
    <div class="container">
      <h2 class="headline text-uppercase text-center mb-5 inview animated"><?php echo get_field('social_title'); ?></h2>
      <h4 class="text-center text-uppercase inview animated delay-1" data-ease="fadeInDown">Follow what we're up to</h4>
      <div class="row inview animated delay-2">
      </div>
    </div>
  </section>

</article>
