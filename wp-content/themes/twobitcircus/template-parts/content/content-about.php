<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
 $imgPath = '/wp-content/themes/twobitcircus/img/about/';
?>
<article id="about" <?php post_class(); ?>>

  <section id="about-header">
    <div class="container text-center caption-top inview animated reverse">
      <h1 class="headline mx-auto inview animated reverse delay-3"><?php echo get_field('header_title');?></h1>
      <div class="w-75 mx-auto inview animated reverse delay-4"><?php echo get_field('header_description');?></div>
      <div class="arrow-down mx-auto"><img class="img-fluid" src="<?php echo $imgPath;?>down_arrow.png" alt="<?php echo get_field('header_title');?>"/></div>
    </div>
    <div class="bkg-wrapper"></div>
  </section>
  <div id="trigger-element" class="section-wrapper">
    <section id="level-escape-block" class="about-sections">
      <div class="row no-gutters inview animated z-2">
        <div class="col-md-6">
          <?php if(get_field('escape_image')) : ?>
          <div class="inview animated mt-5" data-ease="fadeInLeftBig"><img class="img-fluid lazyload" data-src="<?php echo get_field('escape_image')['url'];?>" alt="<?php echo get_field('escape_title');?>" /></div>
          <?php endif ?>
        </div>
        <div class="col-md-6 text-center white">
          <h3 class="header-line lubalinB mt-5 text-uppercase inview animated yellow"><?php echo get_field('escape_title');?></h3>
          <h2 class="headline inview animated delay-1"><?php echo get_field('escape_subtitle');?></h2>
          <div class="text w-75 mx-auto inview animated delay-2"><?php echo get_field('escape_description');?></div>
          <div class="vector vector-rooms inview animated delay-2" data-ease="fadeInUp">
            <img class="img-fluid" src="<?php echo $imgPath;?>about_storyroom.png" alt="<?php echo get_field('escape_title');?>" />
          </div>
          <div class="vector vector-icons inview animated delay-3" data-ease="fadeInUp">
            <img class="img-fluid" src="<?php echo $imgPath;?>escape_icons.png" alt="<?php echo get_field('escape_title');?>" />
          </div>
        </div>
      </div>
      <div id="dark-red-layer" class="bkg-layer w-100">
        <svg width="1440px" height="25px" viewBox="0 0 1440 25" preserveAspectRatio="none"><g data-svg-origin="0 0"><path fill="currentColor" d="M 0 12.5 q 360 -25 720 0 t 720 0 t 720 0 t 720 0 t 720 0 t 720 0 V 0 H 0 V 12.5"></path></g></svg>
      </div>
    </section>

    <section id="level-gear-block" class="about-sections">
      <div class="row no-gutters inview animated z-2">
        <div class="col-md-6 overflow-hidden d-md-none">
          <?php if(get_field('gear_image')) : ?>
          <div class="inview animated text-right" data-ease="fadeInRightBig"><img class="img-fluid lazyload" data-src="<?php echo get_field('gear_image')['url'];?>" alt="<?php echo get_field('gear_title');?>" /></div>
          <?php endif ?>
        </div>
        <div class="col-md-6 text-center white">
          <h3 class="header-line lubalinB mt-5 text-uppercase inview animated yellow"><?php echo get_field('gear_title');?></h3>
          <h2 class="headline inview animated delay-1"><?php echo get_field('gear_subtitle');?></h2>
          <div class="text w-75 mx-auto inview animated delay-2"><?php echo get_field('gear_description');?></div>
          <div class="vector vector-rooms inview animated delay-2" data-ease="fadeInUp">
            <img class="img-fluid" src="<?php echo $imgPath;?>about_arena.png" alt="<?php echo get_field('gear_title');?>" />
          </div>
          <div class="vector vector-icons inview animated delay-3" data-ease="fadeInUp">
            <img class="img-fluid" src="<?php echo $imgPath;?>about_vr_tv.png" alt="<?php echo get_field('gear_title');?>" />
          </div>
        </div>
        <div class="col-md-6 overflow-hidden d-none d-md-block">
          <?php if(get_field('gear_image')) : ?>
          <div class="inview animated text-right mt-5" data-ease="fadeInRightBig"><img class="img-fluid lazyload" data-src="<?php echo get_field('gear_image')['url'];?>" alt="<?php echo get_field('gear_title');?>" /></div>
          <?php endif ?>
        </div>
      </div>
      <div id="red-layer" class="bkg-layer w-100">
        <svg width="1440px" height="25px" viewBox="0 0 1440 25" preserveAspectRatio="none"><g data-svg-origin="0 0"><path fill="currentColor" d="M 0 12.5 q 360 -25 720 0 t 720 0 t 720 0 t 720 0 t 720 0 t 720 0 V 0 H 0 V 12.5"></path></g></svg>
      </div>
    </section>

    <section id="level-club-block" class="about-sections">
      <div class="row no-gutters inview animated z-2">
        <div class="col-md-6">
          <?php if(get_field('club_image')) : ?>
          <div class="inview animated mt-5" data-ease="fadeInLeftBig"><img class="img-fluid lazyload" data-src="<?php echo get_field('club_image')['url'];?>" alt="<?php echo get_field('club_title');?>" /></div>
          <?php endif ?>
        </div>
        <div class="col-md-6 text-center">
          <h3 class="header-line lubalinB mt-5 text-uppercase inview animated red"><?php echo get_field('club_title');?></h3>
          <h2 class="headline inview animated delay-1 white"><?php echo get_field('club_subtitle');?></h2>
          <div class="text w-75 mx-auto inview animated delay-2"><?php echo get_field('club_description');?></div>
          <div class="vector vector-rooms inview animated delay-2" data-ease="fadeInUp">
            <img class="img-fluid" src="<?php echo $imgPath;?>about_club01.png" alt="<?php echo get_field('club_title');?>" />
          </div>
          <div class="vector vector-icons inview animated delay-3" data-ease="fadeInUp">
            <img class="img-fluid lazyload" data-ease="fadeInRightBig" data-src="<?php echo $imgPath;?>about_club01_icons.png" alt="<?php echo get_field('club_title');?>" />
          </div>
        </div>
      </div>
      <div id="yellow-layer" class="bkg-layer w-100">
        <svg width="1440px" height="25px" viewBox="0 0 1440 25" preserveAspectRatio="none"><g data-svg-origin="0 0"><path fill="currentColor" d="M 0 12.5 q 360 -25 720 0 t 720 0 t 720 0 t 720 0 t 720 0 t 720 0 V 0 H 0 V 12.5"></path></g></svg>
      </div>
    </section>

    <section id="level-food-block" class="about-sections">
      <div class="row no-gutters inview animated z-2">
        <div class="col-md-6 overflow-hidden d-md-none">
          <?php if(get_field('food_image')) : ?>
          <div class="inview animated text-right" data-ease="fadeInRightBig"><img class="img-fluid lazyload" data-src="<?php echo get_field('food_image')['url'];?>" alt="<?php echo get_field('food_title');?>" /></div>
          <?php endif ?>
        </div>
        <div class="col-md-6 text-center white">
          <h3 class="header-line lubalinB mt-5 text-uppercase inview animated yellow"><?php echo get_field('food_title');?></h3>
          <h2 class="headline inview animated delay-1"><?php echo get_field('food_subtitle');?></h2>
          <div class="text w-75 mx-auto inview animated delay-2"><?php echo get_field('food_description');?></div>
          <div class="vector vector-rooms inview animated delay-2" data-ease="fadeInUp">
            <img class="img-fluid" src="<?php echo $imgPath;?>food_cafe.png" alt="<?php echo get_field('food_title');?>" />
          </div>
          <div class="vector vector-icons inview animated delay-3" data-ease="fadeInUp">
            <img class="img-fluid" src="<?php echo $imgPath;?>food_icons.png" alt="<?php echo get_field('food_title');?>" />
          </div>
          <div class="vector vector-icons inview animated delay-4" data-ease="fadeInUp">
            <img class="img-fluid" src="<?php echo $imgPath;?>about_food_single_icon.png" alt="<?php echo get_field('food_title');?>" />
          </div>
        </div>
        <div class="col-md-6 overflow-hidden d-none d-md-block">
          <?php if(get_field('food_image')) : ?>
          <div class="inview animated text-right mt-5" data-ease="fadeInRightBig"><img class="img-fluid lazyload" data-src="<?php echo get_field('food_image')['url'];?>" alt="<?php echo get_field('food_title');?>" /></div>
          <?php endif ?>
        </div>
      </div>
      <div id="green-layer" class="bkg-layer w-100">
        <svg width="1440px" height="25px" viewBox="0 0 1440 25" preserveAspectRatio="none"><g data-svg-origin="0 0"><path fill="currentColor" d="M 0 12.5 q 360 -25 720 0 t 720 0 t 720 0 t 720 0 t 720 0 t 720 0 V 0 H 0 V 12.5"></path></g></svg>
      </div>
    </section>
  </div>
  <section id="level-robo-block">
    <div class="position-relative">
      <div class="robo-drink inview animated" data-ease="fadeIn">
        <?php if(get_field('food_image')) : ?>
        <img class="img-fluid lazyload" data-src="<?php echo $imgPath;?>robo_drink.png" alt="<?php echo get_field('robo_title');?>" />
        <?php endif ?>
      </div>
      <h2 class="headline text-center yellow inview animated delay-2"><?php echo get_field('robo_title');?></h2>
    </div>
    <div class="slope"></div>
    <div class="arrow"></div>
  </section>

  <?php if(!empty(get_field('packages'))) :?>
  <section id="packages-block" class="pt-5">
    <div class="container text-center">
      <h2 class="headline text-uppercase inview animated"><?php echo get_field('package_title'); ?></h2>
      <div class="w-50 mx-auto inview animated delay-2"><?php echo get_field('package_description'); ?></div>
    </div>
    <div class="package-wrapper mt-5 inview animated delay-3">
      <div class="row no-gutters">
      <?php foreach(get_field('packages') as $package) :?>
        <div class="col-md-4 bkg-img" style="background-image: url('<?php echo $package['background_image'];?>">
          <div class="package-block">
            <h2 class="lubalinB box-shadow"><?php echo $package['package_name'];?></h2>
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
