<?php
/**
 * The header for our theme
 *
 * @package twobitcircus
 */
 global $location;
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="profile" href="https://gmpg.org/xfn/11" />
    <?php wp_head(); ?>
  <?php if (isset($location)) : ?>
        <?php if(isset($location['state_abrv']) && $location['state_abrv'] == 'TX') :?>
            <?php echo (!empty(get_field('tracking_dallas', 'option'))) ? get_field('tracking_dallas', 'option') : '';?>
  <?php else :?>
      <?php echo (!empty(get_field('tracking', 'option'))) ? get_field('tracking', 'option') : '';?>
  <?php endif ?>
  <script type='text/javascript'>
    // Google Map TwoBit Location
    var site_path = '<?php echo get_site_url();?>';
    var twobit = {
      info: '<strong>Two Bit Circus</strong><br><?php echo $location['address'];?><br><?php echo $location['city'];?>, <?php echo $location['state_abrv'];?> <?php echo $location['zip_code'];?><br><a href="<?php echo $location['driving_map_link'];?>" target="_blank" rel="noopener"><b><?php _e('Get Directions', 'twobitcircus');?></b></a>',
      lat: <?php echo $location['latitude'];?>,
      long: <?php echo $location['longitude'];?>,
      icon:  site_path + "/wp-content/uploads/2019/07/Logo_anim_32.gif"
    };
    var locations = [[twobit.info, twobit.lat, twobit.long, 0, twobit.icon]];
  </script>
  <script type='text/javascript' src='/wp-content/themes/twobitcircus/js/googlemaps.js'></script>
  <?php endif ?>
</head>

<body <?php body_class(); ?>>
  <?php get_template_part('template-parts/partial/partial', 'menu'); ?>

  <main id="main" role="main">
