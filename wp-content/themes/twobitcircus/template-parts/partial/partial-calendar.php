<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
date_default_timezone_set('America/Los_Angeles');
$cal = new Calendar();
$calendar = $cal->init();
$_enddate = $cal->get_endDate();
$_closed = $cal->get_closed();
?>
<?php if ( !empty($calendar) ) : ?>
<div id="calendar-block" class="entry-wrapper-padding">
  <div class="container">
    <?php if ( !empty(get_field('calendar_title')) ) : ?>
    <h2 class="headline text-uppercase text-center mb-5 inview animated red"><?php echo get_field('calendar_title'); ?></h2>
    <?php endif ?>
    <div class="calender-planner">
      <div class="calender-wrapper inview animated delay-1">
        <div class="calender slick-calendar">

        <?php
          $current_date = time();
          $day_count = 0;
          $addEventCal = [];

          do {
            $isClosed = false;
            $day = date('d', $current_date);
            $dayname = date('D', $current_date);
          ?>
          <?php if(in_array($dayname, $_closed)) $isClosed = true; ?>
            <div class="grid <?php echo ($isClosed) ? 'closed' : '';?> <?php echo ($day_count==0)?'active':'';?>">
              <div class="grid-time text-center">
                <div class="header clearfix lubalinB">
                  <div class="day text-uppercase"><?php echo $dayname;?></div>
                  <div class="date text-uppercase"><?php echo date('M d', $current_date);?></div>
                </div>
                <?php if($isClosed) : ?>
                <div class="entry text-uppercase">
                  <div class="cell">
                    <div class="cell-box">
                      <h5 class="time"><?php echo get_field('calendar_closed_text', 'option');?></h5>
                    </div>
                  </div>
                </div>
              <?php elseif(!empty($calendar[$day])) :?>
                <div class="entry">
                  <div class="cell">

                    <?php ksort($calendar[$day]); ?>
                    <?php foreach($calendar[$day] as $times) : ?>
                    <?php foreach($times as $time) :?>
                    <div class="cell-box">
                      <h5 class="text-uppercase franchise"><?php echo preg_replace('/Club\s01\s|Club01\s/', '', $time->name);?></h5>
                      <div class="cta-btn mx-auto">
                      <?php if(!empty($time->link)) :?>
                        <a href="<?php echo (isset($time->target)) ? $time->link : 'https://twobitcircus.centeredgeonline.com'.$time->link;?>" class="time btn btn-twobit btn-white btn-sm" target="<?php echo (isset($time->target) && $time->target == '_self') ? '_self' : '_blank';?>" rel="noopener" onclick="gtag('event', '<?php echo preg_replace('/Club\s01\s|Club01\s/', '', $time->name);?>', {'event_category': 'Calendar Link', 'event_label': '<?php echo (isset($time->target)) ? $time->link : 'https://twobitcircus.centeredgeonline.com'.$time->link;?>'});">
                      <?php else:  ?>
                      <?php if(!empty($time->ticket_alt) || !empty($time->ticket)) :?>
                        <div class="time btn btn-twobit btn-white  btn-sm">
                          <span><?php echo (!empty($time->ticket_alt)) ? $time->ticket_alt : ltrim($time->ticket, '0');?></span>
                        </div>
                        <div class="btn-behind sm">&nbsp;</div>
                      <?php endif ?>
                        <?php if(!empty($time->link)) :?>
                        </a>
                        <div class="btn-behind sm">&nbsp;</div>
                      <?php endif ?>
                      </div>
                      <?php
                      $_timeRaw = str_replace('-','/', $time->posted);
                      $getTime = (!empty($time->ticket_alt)) ? trim($time->ticket_alt) : trim($time->ticket);
                      $_link = (isset($time->target) && $time->link) ? $time->link : (($time->link) ? 'https://twobitcircus.centeredgeonline.com'.$time->link : '');
                      $startTime = 0;
                      $endTime = 0;
                      $arrayStr = ['title' => $time->name, 'url' => $_link, 'textColor' => '', 'id' => ''];
                      if(preg_match('/-/', $getTime)) {
                        $parseTime = explode('-', $getTime);
                        $startTime = date('Y-m-d H:i', (strtotime($_timeRaw  .' ' .trim($parseTime[0]))));
                        $endTime = date('Y-m-d H:i', (strtotime($_timeRaw  .' ' .trim($parseTime[1]))));
                        $arrayStr += ['start' => $startTime];
                        $arrayStr += ['end' => $endTime];
                      } else {
                        $startTime = date('Y-m-d H:i', (strtotime($_timeRaw .' '. $getTime)));
                        $arrayStr += ['start' => $startTime];
                      }
                      $addEventCal[] = $arrayStr; ?>
                    </div>
                    <?php endforeach ?>
                    <?php endforeach ?>

                  </div>
                </div>
                <?php else :?>
                <div class="entry no-shows text-uppercase">
                  <div class="cell">
                    <div class="cell-box">
                      <h5 class="time"><?php echo get_field('calendar_blank_text', 'option');?></h5>
                    </div>
                  </div>
                </div>
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
    <div class="mx-auto mt-6 mb-2 text-center inview animated delay-2 d-none d-lg-block">
      <?php echo do_shortcode('[button parent="mx-auto" class="full-calendar btn-green"]View Full Calendar[/button]') ?>
    </div>
  </div>
</div>
<?php if(!empty($addEventCal)) :?>
<script>
var _cal_events = <?php echo json_encode($addEventCal); ?>;
</script>
<?php endif ?>
<div class="more-calendar-block collapse pt-4 fade">
  <div class="d-none d-lg-block">
    <div class="container position-relative">
      <div class="row">
        <div class="col-sm-8 mx-auto">
          <div id="full-calendar"></div>
        </div>
        <div class="event-show col-sm-4 collapse fade">
          <div id="event-window">
            <button type="button" class="close" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <div class="card">
              <div class="card-header clearfix">
                <div class="day pull-left"></div>
                <div class="date pull-right"></div>
              </div>
              <div class="card-body">
                <h4 class="card-title"></h4>
                <div class="card-text">
                  <div class="start"></div>
                  <div class="end"></div>
                  <div class="text"></div>
                </div>
                <?php echo do_shortcode('[button parent="mt-2" class="btn-sm link"]Buy Now[/button]');?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif ?>
