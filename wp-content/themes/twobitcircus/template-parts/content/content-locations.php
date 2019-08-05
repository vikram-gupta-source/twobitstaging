<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
 global $location;
?>
<article id="locations" <?php post_class(); ?>>
  <div class="container-fluid text-center main-headline">
    <?php the_title( '<h1 class="headline inview animated" data-ease="fadeInDown">', '</h1>' ); ?>
  </div>
  <?php if (!empty( get_the_content())):?>
  <div class="container-fluid text-center sub-headline">
    <div class="inview animated w-50 mx-auto delay-2"><?php the_content(); ?></div>
  </div>
  <?php endif ?>

  <section id="findus-block" class="entry-wrapper-padding">
    <div class="container">
      <h2 class="headline inview animated text-center mb-5"><?php echo get_field('find_us_title'); ?></h2>
      <div class="map-wrapper">
        <div id="main-map" style="height: 500px;"></div>
        <div class="directions">
          <div class="text-content flex-content">
            <a class="map-link car" href="<?php echo $location['driving_map_link'];?>" target="_blank" rel="noopener"><i class="fa fa-car" aria-hidden="true"></i></a>
            <a class="map-link bus" href="<?php echo $location['bus_map_link'];?>" target="_blank" rel="noopener"><i class="fa fa-bus" aria-hidden="true"></i></a>
            <a class="map-link walk" href="<?php echo $location['walking_map_link'];?>" target="_blank" rel="noopener"><svg aria-hidden="true" data-prefix="fas" data-icon="walking" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-walking fa-w-10"><path fill="currentColor" d="M208 96c26.5 0 48-21.5 48-48S234.5 0 208 0s-48 21.5-48 48 21.5 48 48 48zm94.5 149.1l-23.3-11.8-9.7-29.4c-14.7-44.6-55.7-75.8-102.2-75.9-36-.1-55.9 10.1-93.3 25.2-21.6 8.7-39.3 25.2-49.7 46.2L17.6 213c-7.8 15.8-1.5 35 14.2 42.9 15.6 7.9 34.6 1.5 42.5-14.3L81 228c3.5-7 9.3-12.5 16.5-15.4l26.8-10.8-15.2 60.7c-5.2 20.8.4 42.9 14.9 58.8l59.9 65.4c7.2 7.9 12.3 17.4 14.9 27.7l18.3 73.3c4.3 17.1 21.7 27.6 38.8 23.3 17.1-4.3 27.6-21.7 23.3-38.8l-22.2-89c-2.6-10.3-7.7-19.9-14.9-27.7l-45.5-49.7 17.2-68.7 5.5 16.5c5.3 16.1 16.7 29.4 31.7 37l23.3 11.8c15.6 7.9 34.6 1.5 42.5-14.3 7.7-15.7 1.4-35.1-14.3-43zM73.6 385.8c-3.2 8.1-8 15.4-14.2 21.5l-50 50.1c-12.5 12.5-12.5 32.8 0 45.3s32.7 12.5 45.2 0l59.4-59.4c6.1-6.1 10.9-13.4 14.2-21.5l13.5-33.8c-55.3-60.3-38.7-41.8-47.4-53.7l-20.7 51.5z" class=""></path></svg></a>
            <a class="map-link bike" href="<?php echo $location['bike_map_link'];?>" target="_blank" rel="noopener"><i class="fa fa-bicycle" aria-hidden="true"></i></a>
          </div>
        </div>
        <?php if(get_field('hours')) :?>
        <div class="overlay inview animated delay-2" data-ease="fadeInDown">
          <?php $hours = filter_locations(get_field('hours'));?>
          <?php foreach($hours as $hour) :?>
            <?php echo $hour['hours'];?>
          <?php endforeach ?>
        </div>
        <?php endif ?>
      </div>
    </div>
  </section>

  <section id="calendar-block" class="entry-wrapper-padding">
    <div class="container-fluid">
      <h2 class="headline inview animated text-center"><?php echo get_field('calendar_title'); ?></h2>
    </div>
    <div class="container-fluid">
    <?php get_template_part( 'template-parts/partial/partial', 'calendar' ); ?>
    </div>
  </section>

  <section id="newsletter-block" class="entry-wrapper-padding bkg-color">
    <div class="container">
      <div class="inview animated">
      <?php echo get_field('newsletter_block', 'option');?>
      </div>
    </div>
  </section>

  <?php if(get_field('venue_details')) :?>
  <section id="venue-block" class="entry-wrapper-padding">
    <div class="container">
      <h2 class="headline inview animated text-center"><?php echo get_field('venue_title'); ?></h2>
      <div class="venue-wrapper accordion-wrapper inview animated delay-1 clearfix">
      <?php $venues = filter_locations(get_field('venue_details'));?>
      <?php foreach($venues as $vkey => $venue) :?>

        <div class="card">
          <div class="card-header" id="heading-<?php echo $vkey; ?>" role="button">
            <h5 class="mb-0 clearfix collapse-title collapsed" data-toggle="collapse" data-target="#collapse-<?php echo $vkey; ?>" aria-expanded="true" aria-controls="collapse-<?php echo $vkey; ?>">
                <i class="<?php echo $venue['icon']; ?>"></i> <?php echo $venue['title']; ?>
                <i class="fa fa-angle-down"></i>
            </h5>
          </div>
          <div id="collapse-<?php echo $vkey; ?>" class="collapse" aria-labelledby="heading-<?php echo $vkey; ?>" data-parent="#venue-block">
            <div class="card-body">
              <?php echo $venue['content']; ?>
            </div>
          </div>
        </div>

      <?php endforeach ?>
      </div>
    </div>
  </section>
  <?php endif?>
</article>
<?php if(isset($location)) : ?>
<script>
  // Google Map Parkings
  <?php foreach($location['parking_locations'] as $pkey => $pk) :?>
  var parking<?php echo $pkey; ?> = {
    info:
      '<strong>Parking</strong><br>\
           <?php echo $pk['address'];?><br>\
           <a href="<?php echo $pk['link'];?>" target="_blank" rel="noopener"><b><?php _e( 'Get Directions', 'twobitcircus' );?></b></a>',
    lat: <?php echo $pk['latitude'];?>,
    long: <?php echo $pk['longitude'];?>,
    icon: site_path + "/wp-content/uploads/2019/07/parking_logo.png"
  };
  locations.push([parking<?php echo $pkey; ?>.info, parking<?php echo $pkey; ?>.lat, parking<?php echo $pkey; ?>.long, <?php echo ($pkey+1); ?>, parking<?php echo $pkey; ?>.icon]);
<?php endforeach ?>
</script>
<?php endif ?>
