<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
?>
<?php
  if ( !empty(get_field('hero')) ) :
    $slides = filter_locations(get_field('hero'));
    $heroCnt = count($slides);
  ?>
  <div id="hero-block" class="carousel slide" data-ride="carousel" data-interval="false">
    <?php if($heroCnt > 1) :?>
    <ol class="carousel-indicators">
      <?php foreach($slides as $sky => $slide) :?>
      <?php $slideActive = ($sky == 0) ? 'class="active"' : '';?>
      <li data-target="#hero-block" data-slide-to="<?php echo $sky;?>" <?php echo $slideActive;?>></li>
      <?php endforeach ?>
    </ol>
    <?php endif ?>
    <div class="carousel-inner">
      <?php foreach($slides as $sky => $slide) : ?>
      <?php $slideActive = ($sky == 0) ? 'active' : '';?>
      <?php $darken = ($slide['darken'] != 'none') ? 'darken ' . $slide['darken'] : ''; ?>
      <div class="carousel-item <?php echo $slideActive;?> <?php echo $darken;?>" <?php echo (!empty($slide['image']['url'])) ? 'style="background-image: url(\'' . $slide['image']['url'] . '\');"' : '' ;?>>
        <?php $postion_y = ($slide['position_y'] == 'top') ? 'top' : ((($slide['position_y'] == 'bottom')) ? 'bottom' : 'd-flex h-100 align-items-center justify-content-center') ?>
        <div class="container carousel-caption <?php echo $postion_y;?> inview animated delay-2">
          <?php $postion_x = ($slide['position_text'] == 'right') ? 'col-md-6 offset-md-6' : ((($slide['position_text'] == 'left')) ? 'offset-left-md-6 col-md-6' : 'col-md-12') ?>
          <div class="<?php echo $postion_x;?>">
          <?php $slideActive = ($sky == 0) ? 'active' : '';?>
          <?php if(!empty($slide['description'])):?>
          <?php echo wpautop($slide['description'], false);?>
          <?php endif ?>
          </div>
        </div>
      </div>
      <?php endforeach ?>
    </div>
    <?php if($heroCnt > 1) :?>
    <a class="carousel-control-prev" href="#hero-block" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#hero-block" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
    <?php endif ?>
  </div>
<?php endif ?>
