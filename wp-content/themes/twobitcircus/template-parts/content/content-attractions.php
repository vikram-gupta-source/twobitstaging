<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
 $attractions = composeShows();
?>
<article id="attractions" <?php post_class(); ?>>
  <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
  <div class="main-headline header-bkg-right" style="background-image: url('<?php echo $image[0]; ?>')">
    <div class="row no-gutters">
      <div class="col-md-7 col-lg-6 col-xl-5 header-bkg-left">
        <?php the_title( '<h1 class="headline inview animated text-center" data-ease="fadeInDown">', '</h1>' ); ?>
        <div class="text-center"><?php the_content(); ?></div>
      </div>
      <div class="col-md-5 col-lg-6 col-xl-7"></div>
    </div>
  </div>

  <div id="filters" class="inview animated mx-auto delay-1">
    <div class="wrapper">
      <nav id="subnav" class="navbar navbar-expand-sm" role="navigation">
        <ul class="navbar-nav mx-auto">
          <?php foreach($attractions as $cat => $shows) : ?>
            <?php $hasDrop = (count($shows['posts']) > 1) ? true : false; ?>

            <li class="nav-item text-center nav-parent lubalinB">
              <?php if($hasDrop) :?>
              <a class="nav-link link-parent dropdown-toggle" href="#" aria-controls="<?php echo $shows['terms']->slug;?>" data-toggle="tooltip" data-placement="top" title="<?php echo $shows['terms']->category_description;?>" id="navbarDropdown-<?php echo $shows['terms']->slug;?>" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo $shows['terms']->name;?>
              </a>
              <?php else: ?>
              <a class="nav-link link-parent" href="#" aria-controls="<?php echo $shows['terms']->slug;?>" data-toggle="tooltip" data-placement="top" title="<?php echo $shows['terms']->category_description;?>">
                <?php echo $shows['terms']->name;?>
              </a>
              <?php endif ?>
              <?php if($hasDrop) :?>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown-<?php echo $shows['terms']->slug;?>">
                <div class="navbar navbar-expand-sm">
                  <ul class="navbar-nav mx-auto">
                    <?php foreach($shows['posts'] as $skey => $show) :?>
                    <li class="nav-item"><a class="nav-link" href="#" aria-controls="<?php echo sanitize_title($show->post_title);?>"><?php echo $show->post_title;?></a></li>
                    <?php endforeach ?>
                  </ul>
                </div>
              </div>
              <?php endif ?>
            </li>

          <?php endforeach ?>
        </ul>
      </nav>
    </div>
  </div>

  <!-- Go to www.addthis.com/dashboard to customize your tools -->
  <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5d40d77186a2f4a8"></script>
  <section id="attractions-block" class="inview animated delay-1">
    <div class="bkg-red-angle"></div>
    <div class="container">
      <?php if(!empty($attractions)) :?>
        <div class="attractions-slick entry-wrapper-padding">
          <?php foreach($attractions as $cat => $shows) :?>
          <div class="item-attraction">

            <div class="slick-shows" id="<?php echo $cat;?>">
              <?php $num = count($shows['posts']); ?>
              <?php foreach($shows['posts'] as $skey => $show) :?>
                <?php if(!filter_location_by_field(get_field('available_in', $show->ID))) continue; ?>
                <?php $composedDates = composeTickets(get_field('tickets', $show->ID));?>
                <?php $info = filter_locations(get_field('information', $show->ID));?>
                <?php $_cat = get_the_category($show->ID);?>
                <?php $gallery = get_field('gallery', $show->ID);?>
                <div id="<?php echo sanitize_title($show->post_title);?>" class="item-shows">
                  <div class="row">
                    <div class="assets-wrapper col-md-6 col-lg-7 mb-4">
                      <?php if(!empty($gallery)) :?>
                      <div class="show-asset-wrapper">
                        <div class="slick-media">
                          <?php foreach($gallery as $gal) :?>
                          <div class="img"><img class="img-fluid w-100" src="<?php echo $gal['url']; ?>" alt="<?php echo $gal['title']; ?>" /></div>
                          <?php endforeach ?>
                        </div>
                        <div class="overlay">
                          <div class="slick-media-nav">
                            <?php foreach($gallery as $gal) :?>
                            <div class="thumb"><img class="img-fluid w-100" src="<?php echo $gal['sizes']['medium']; ?>" alt="<?php echo $gal['title']; ?>" /></div>
                            <?php endforeach ?>
                          </div>
                        </div>
                      </div>
                      <?php endif ?>
                      <?php if(isset($_cat[0])) :?>
                      <div class="mt-2 addthis_inline_share_toolbox pull-right" data-url="<?php echo get_site_url() ?>/attractions/?cat=<?php echo $_cat[0]->slug ?>&id=<?php echo $skey ?>" data-title="<?php echo $show->post_title;?>"></div>
                      <?php endif ?>
                    </div>
                    <div class="show-content-block col-md-6 col-lg-5">
                      <h2 class="title lubalinB text-uppercase mb-0"><?php echo $show->post_title;?></h2>
                      <?php if(!empty(get_field('sub_title', $show->ID))):?>
                      <h3 class="subtitle mt-2 yellow"><?php echo get_field('sub_title', $show->ID);?></h3>
                      <?php endif ?>
                      <?php if(!empty($info[0]['players']) || !empty($info[0]['show_duration']) || !empty($info[0]['price'])):?>
                      <div class="info-block mt-3 mb-3">
                        <?php if(!empty($info[0]['players'])):?>
                        <div class="d-inline-block"><i class="fa fa-user pr-1"></i><?php echo $info[0]['players'];?></div>
                        <?php endif ?>
                        <?php if(!empty($info[0]['show_duration'])):?>
                        <div class="d-inline-block pl-3"><i class="fa fa-clock-o pr-1"></i><?php echo $info[0]['show_duration'];?></div>
                        <?php endif ?>
                        <?php if(!empty($info[0]['price'])):?>
                        <div class="d-inline-block pl-3"><i class="fa fa-money pr-1"></i><?php echo $info[0]['price'];?></div>
                        <?php endif ?>
                      </div>
                      <?php endif ?>
                      <p><?php echo apply_filters('the_content', $show->post_content);?></p>
                      <?php if(!empty($info[0]['buy_link']) && empty($composedDates)): ?>
                      <div class="buy-link mt-4">
                        <?php echo do_shortcode('[button link="'.$info[0]['buy_link'].'" target="_blank"]Buy Players Card[/button]') ?>
                      </div>
                      <?php endif ?>
                      <?php if(!empty($composedDates)) :?>
                      <h3 class="mt-5 text-uppercase franchise clearfix offwhite"><?php _e( 'Showtimes' , 'twobitcircus'); ?>
                        <div class="cta-btn pull-right"><button type="button" class="btn btn-sm btn-twobit open-times-modal" data-toggle="modal" data-target="#modal-showtimes"><span><?php _e( 'All Times' , 'twobitcircus'); ?></span></button><div class="btn-behind sm">&nbsp;</div></div>
                      </h3>
                      <div class="showtimes-cycle">
                        <div id="cycle-<?php echo $show->ID;?>">
                          <?php $slickObj = (count($composedDates) > 5) ? '{"centerMode": true }' : ''; ?>
                          <div class="slick-days" data-slick='<?php echo $slickObj;?>' data-target="<?php echo $cat;?>">
                            <?php foreach($composedDates as $date => $tickets) :?>
                            <div class="item-days text-center">
                              <div class="day-header lubalin">
                                <?php echo date('D', strtotime(str_replace('-', '/', $date)));?>
                              </div>
                              <div class="day-date">
                                <div class="month"><?php echo date('M', strtotime(str_replace('-', '/', $date)));?></div>
                                <div class="day"><?php echo date('j', strtotime(str_replace('-', '/', $date)));?></div>
                              </div>
                            </div>
                            <?php endforeach ?>
                          </div>
                          <div class="slick-times">
                            <?php foreach($composedDates as $date => $tickets) :?>
                            <div class="item-time">
                              <div class="card-body">
                              <?php foreach($tickets as $timeInfo) : ?>
                              <?php if(!preg_match('/(Out)/', $timeInfo->ticket)): ?>

                                <div class="cta-btn mb-2"><a class="btn btn-twobit btn-white btn-sm" href="https://twobitcircus.centeredgeonline.com<?php echo $timeInfo->link;?>" target="_blank" rel="noopener noreferrer"><span><?php echo $timeInfo->ticket;?></span></a><div class="btn-behind sm">&nbsp;</div></div>

                              <?php endif ?>
                              <?php endforeach ?>
                              </div>
                            </div>
                            <?php endforeach ?>
                          </div>
                        </div>
                      </div>
                      <div class="available-dates text-center">

                        <?php echo do_shortcode('[button parent="confirm fade mx-auto" target="_blank"]Go to Purchase[/button]') ?>

                        <div class="showtimes d-none">
                          <div id="accordion-<?php echo $show->ID;?>" class="accordion">
                            <?php foreach($composedDates as $date => $tickets) :?>
                            <div class="card">
                              <div class="card-header">
                                <a class="card-link" data-toggle="collapse" href="#collapse-<?php echo $show->ID;?>-<?php echo $date;?>">
                                  <?php echo date('l, F j', strtotime(str_replace('-', '/', $date)));?>
                                </a>
                              </div>
                              <div id="collapse-<?php echo $show->ID;?>-<?php echo $date;?>" class="collapse" data-parent="#accordion-<?php echo $show->ID;?>">
                                <div class="card-body">
                                  <?php foreach($tickets as $timeInfo) : ?>
                                  <?php if(!preg_match('/(Out)/', $timeInfo->ticket)): ?>
                                    <div class="cta-btn"><a class="btn btn-twobit btn-sm" href="https://twobitcircus.centeredgeonline.com<?php echo $timeInfo->link;?>" target="_blank" rel="noopener noreferrer"><span><?php echo $timeInfo->ticket;?></span></a><div class="btn-behind sm">&nbsp;</div></div>
                                  <?php endif ?>
                                  <?php endforeach ?>
                                </div>
                              </div>
                            </div>
                            <?php endforeach ?>
                          </div>
                        </div>

                      </div>
                      <?php endif ?>

                    </div>
                  </div>

                </div>
              <?php endforeach ?>
            </div>

          </div>
          <?php endforeach ?>
        </div>
        <?php endif ?>
      </div>
    </div>
  </section>

</article>
