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
  <!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-87816008-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());
	  gtag('config', 'UA-87816008-1');
	</script>
  <?php echo (!empty(get_field('tracking', 'option'))) ? get_field('tracking', 'option') : '';?>
  <?php if (isset($location)) : ?>
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
  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-NHQ8NNQ');</script>
  <!-- End Google Tag Manager -->
  <!-- Global site tag (gtag.js) - Google Marketing Platform -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=DC-8812747"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'DC-8812747');
  </script>
  <!-- End of global snippet: Please do not remove -->
  <!-- MAIL CHIMP Tracking -->
  <script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/4d4b1d17d592f7bbe31182862/d5e39c5af151c49205aa0d0ae.js");</script>

  <!-- CRAZYEGG Tracking -->
  <script type="text/javascript" src="//script.crazyegg.com/pages/scripts/0078/9623.js" async="async"></script>
  <!-- Facebook Pixel Code -->
  <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window,document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
     fbq('init', '1869285869829604');
     fbq('track', 'PageView');
  </script>
  <noscript>
   <img height="1" width="1"
  src="https://www.facebook.com/tr?id=1869285869829604&ev=PageView
  &noscript=1"/>
  </noscript>
  <!-- End Facebook Pixel Code -->
</head>

<body <?php body_class(); ?>>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NHQ8NNQ"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  	<!-- End Google Tag Manager (noscript) -->
  <?php get_template_part('template-parts/partial/partial', 'menu'); ?>

  <main id="main" role="main">
