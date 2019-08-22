<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
 $imgPath = '/wp-content/themes/twobitcircus/img/about/';
?>
<article id="about" <?php post_class(); ?>>

  <section id="hero-block" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <a class="about-logo mt-4 mx-auto inview animated"><img class="img-fluid" src="<?php echo $imgPath;?>logo_white.png" alt="<?php echo get_field('header_title');?>"/></a>
        <div class="container carousel-caption bottom">
          <div class="col-md-12">
            <h1 class="text-uppercase inview animated delay-2"><?php echo get_field('header_title');?></h1>
            <div class="w-75 mx-auto inview animated delay-3"><?php echo get_field('header_description');?></div>
            <div class="arrow-down mx-auto"><img class="img-fluid" src="<?php echo $imgPath;?>dark_red_arrow.png" alt="<?php echo get_field('header_title');?>"/></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="level-escape-block" class="position-relative">
    <div class="row no-gutters inview animated z-2">
      <div class="col-md-6">
        <?php if(get_field('escape_image')) : ?>
        <div class="inview animated" data-ease="fadeInLeftBig"><img class="img-fluid" src="<?php echo get_field('escape_image')['url'];?>" alt="<?php echo get_field('escape_title');?>" /></div>
        <?php endif ?>
      </div>
      <div class="col-md-6 text-center">
        <h4 class="pt-5 text-uppercase inview animated"><?php echo get_field('escape_title');?></h4>
        <h3 class="text-uppercase inview animated delay-1"><?php echo get_field('escape_subtitle');?></h3>
        <div class="text w-75 mx-auto inview animated delay-2"><?php echo get_field('escape_description');?></div>
        <div class="vector vector-rooms inview animated delay-2" data-ease="fadeInUpBig">
          <img class="img-fluid" src="<?php echo $imgPath;?>about_storyroom.png" alt="<?php echo get_field('escape_title');?>" />
        </div>
        <div class="vector vector-icons inview animated delay-3" data-ease="fadeInUp">
          <img class="img-fluid" src="<?php echo $imgPath;?>escape_icons.png" alt="<?php echo get_field('escape_title');?>" />
        </div>
      </div>
    </div>
  </section>

  <section id="level-gear-block" class="position-relative">
    <div class="row no-gutters inview animated z-2">
      <div class="col-md-6 text-center">
        <h4 class="pt-5 text-uppercase inview animated"><?php echo get_field('gear_title');?></h4>
        <h3 class="text-uppercase inview animated delay-1"><?php echo get_field('gear_subtitle');?></h3>
        <div class="text w-75 mx-auto inview animated delay-2"><?php echo get_field('gear_description');?></div>
        <div class="vector vector-rooms inview animated delay-2" data-ease="fadeInUpBig">
          <img class="img-fluid" src="<?php echo $imgPath;?>about_arena.png" alt="<?php echo get_field('gear_title');?>" />
        </div>
        <div class="vector vector-icons inview animated delay-3" data-ease="fadeInLeftBig">
          <img class="img-fluid" src="<?php echo $imgPath;?>about_vr_tv.png" alt="<?php echo get_field('gear_title');?>" />
        </div>
      </div>
      <div class="col-md-6 overflow-hidden">
        <?php if(get_field('gear_image')) : ?>
        <div class="inview animated text-right" data-ease="fadeInRightBig"><img class="img-fluid" src="<?php echo get_field('gear_image')['url'];?>" alt="<?php echo get_field('gear_title');?>" /></div>
        <?php endif ?>
      </div>
    </div>
    <div id="red-layer" class="bkg-layer w-100 inview animated" data-ease="active"><img class="img-fluid w-100" src="<?php echo $imgPath;?>about_red_shape.png" alt="<?php echo get_field('gear_title');?>" /></div>
  </section>

  <section id="level-club-block" class="position-relative">
    <div class="row no-gutters inview animated z-2">
      <div class="col-md-6">
        <?php if(get_field('club_image')) : ?>
        <div class="inview animated" data-ease="fadeInLeftBig"><img class="img-fluid" src="<?php echo get_field('club_image')['url'];?>" alt="<?php echo get_field('club_title');?>" /></div>
        <?php endif ?>
      </div>
      <div class="col-md-6 text-center">
        <h4 class="pt-5 text-uppercase inview animated"><?php echo get_field('club_title');?></h4>
        <h3 class="text-uppercase inview animated delay-1"><?php echo get_field('club_subtitle');?></h3>
        <div class="text w-75 mx-auto inview animated delay-2"><?php echo get_field('club_description');?></div>
        <div class="vector vector-rooms inview animated delay-2" data-ease="fadeInUpBig">
          <img class="img-fluid" src="<?php echo $imgPath;?>about_club01.png" alt="<?php echo get_field('club_title');?>" />
        </div>
        <div class="vector vector-icons inview animated delay-3" data-ease="fadeInUp">
          <img class="img-fluid" data-ease="fadeInRightBig" src="<?php echo $imgPath;?>about_club01_icons.png" alt="<?php echo get_field('club_title');?>" />
        </div>
      </div>
    </div>
    <div id="yellow-layer" class="bkg-layer w-100 inview animated" data-ease="active"><img class="img-fluid w-100" src="<?php echo $imgPath;?>about_yellow_shape.png" alt="<?php echo get_field('club_title');?>" /></div>
  </section>

  <section id="level-food-block" class="position-relative">
    <div class="row no-gutters inview animated z-2">
      <div class="col-md-6 text-center">
        <h4 class="pt-5 text-uppercase inview animated"><?php echo get_field('food_title');?></h4>
        <h3 class="text-uppercase inview animated delay-1"><?php echo get_field('food_subtitle');?></h3>
        <div class="text w-75 mx-auto inview animated delay-2"><?php echo get_field('food_description');?></div>
        <div class="vector vector-rooms inview animated delay-2" data-ease="fadeInUpBig">
          <img class="img-fluid" src="<?php echo $imgPath;?>food_cafe.png" alt="<?php echo get_field('food_title');?>" />
        </div>
        <div class="vector vector-icons inview animated delay-3" data-ease="fadeInUp">
          <img class="img-fluid" src="<?php echo $imgPath;?>food_icons.png" alt="<?php echo get_field('food_title');?>" />
        </div>
        <div class="vector vector-icons inview animated delay-4" data-ease="fadeInUp">
          <img class="img-fluid" src="<?php echo $imgPath;?>about_food_single_icon.png" alt="<?php echo get_field('food_title');?>" />
        </div>
      </div>
      <div class="col-md-6 overflow-hidden">
        <?php if(get_field('food_image')) : ?>
        <div class="inview animated text-right" data-ease="fadeInRightBig"><img class="img-fluid" src="<?php echo get_field('food_image')['url'];?>" alt="<?php echo get_field('food_title');?>" /></div>
        <?php endif ?>
      </div>
    </div>
    <div id="green-layer" class="bkg-layer w-100 inview animated" data-ease="active"><img class="img-fluid w-100" src="<?php echo $imgPath;?>about_green_shape.png" alt="<?php echo get_field('food_title');?>" /></div>
  </section>

  <section id="level-robo-block" class="container-fluid position-relative">
    <div class="robo-drink inview animated" data-ease="fadeIn">
      <?php if(get_field('food_image')) : ?>
      <img class="img-fluid" src="<?php echo $imgPath;?>robo_drink.png" alt="<?php echo get_field('robo_title');?>" />
      <?php endif ?>
    </div>
    <h2 class="text-uppercase text-center"><?php echo get_field('robo_title');?></h2>
  </section>

  <?php if(!empty(get_field('packages'))) :?>
  <section id="packages-block" class="inview animated">
    <div class="container text-center">
      <h2 class="headline text-uppercase"><?php echo get_field('package_title'); ?></h2>
      <div class="w-50 mx-auto"><?php echo get_field('package_description'); ?></div>
    </div>
    <div class="package-wrapper">
      <div class="row no-gutters">
      <?php foreach(get_field('packages') as $package) :?>
        <div class="col-md-4 bkg-img" style="background-image: url('<?php echo $package['background_image'];?>">
          <div class="package-block">
            <h4 class="text-center"><?php echo $package['package_name'];?></h4>
            <div class="package-description">
              <?php echo $package['package_description'];?>
            </div>
          </div>
        </div>
      <?php endforeach ?>
      </div>
    </div>
  </section>
  <?php endif ?>

</article>
