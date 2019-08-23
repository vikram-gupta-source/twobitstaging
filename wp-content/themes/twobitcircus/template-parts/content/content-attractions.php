<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
 $attractions = composeShows();
?>
<article id="attractions" <?php post_class(); ?>>
  <div class="container-fluid text-center main-headline">
    <?php the_title( '<h1 class="headline inview animated" data-ease="fadeInDown">', '</h1>' ); ?>
  </div>
  <?php if (!empty( get_the_content())):?>
  <div class="container-fluid text-center sub-headline">
    <div class="inview animated w-50 mx-auto delay-1"><?php the_content(); ?></div>
  </div>
  <?php endif ?>

  <div id="filters" class="inview animated mx-auto delay-1">
    <div class="container">
      <nav id="subnav" class="navbar navbar-expand-sm" role="navigation">
        <ul class="navbar-nav mx-auto">
          <?php foreach($attractions as $cat => $shows) : ?>
            <?php $hasDrop = (count($shows['posts']) > 1) ? true : false; ?>

            <li class="nav-item text-center nav-parent">
              <?php if($hasDrop) :?>
              <a class="nav-link link-parent dropdown-toggle" href="#" aria-controls="<?php echo $shows['terms']->slug;?>" data-toggle="tooltip" data-placement="top" title="<?php echo $shows['terms']->category_description;?>" id="navbarDropdown-<?php echo $shows['terms']->slug;?>" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="<?php echo @get_term_meta($shows['terms']->term_id, 'category_icon', true) ;?>"></i>
                <?php echo $shows['terms']->name;?>
              </a>
              <?php else: ?>
              <a class="nav-link link-parent" href="#" aria-controls="<?php echo $shows['terms']->slug;?>" data-toggle="tooltip" data-placement="top" title="<?php echo $shows['terms']->category_description;?>">
                <i class="<?php echo @get_term_meta($shows['terms']->term_id, 'category_icon', true) ;?>"></i>
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
  <section id="attractions-block" class="entry-wrapper-padding inview animated mt-4 delay-1">
    <div class="container">
      <?php if(!empty($attractions)) :?>
        <div class="attractions-slick">
          <?php foreach($attractions as $cat => $shows) :?>
          <div class="item-attraction">

            <div class="slick-shows" id="<?php echo $cat;?>">
              <?php $num = count($shows['posts']); ?>
              <?php foreach($shows['posts'] as $skey => $show) :?>
                <?php if(!filter_location_by_field(get_field('available_in', $show->ID))) continue; ?>
                <?php $composedDates = composeTickets(get_field('tickets', $show->ID));?>
                <?php $info = filter_locations(get_field('information', $show->ID));?>
                <?php $_cat = get_the_category($show->ID);?>
                <div id="<?php echo sanitize_title($show->post_title);?>" class="item-shows">

                  <div class="row">
                    <div class="assets-wrapper col-md-7 mb-4">
                      <div class="show-asset-wrapper">
                        <div class="slick-media">
                          <div class="img"><img class="img-fluid w-100" src="https://via.placeholder.com/640x360"/></div>
                          <div class="img"><img class="img-fluid w-100" src="https://via.placeholder.com/640x360"/></div>
                          <div class="img"><img class="img-fluid w-100" src="https://via.placeholder.com/640x360"/></div>
                          <div class="img"><img class="img-fluid w-100" src="https://via.placeholder.com/640x360"/></div>
                          <div class="img"><img class="img-fluid w-100" src="https://via.placeholder.com/640x360"/></div>
                          <div class="img"><img class="img-fluid w-100" src="https://via.placeholder.com/640x360"/></div>
                        </div>
                        <div class="overlay">
                          <div class="slick-media-nav">
                            <div class="thumb"><img class="img-fluid w-100" src="https://via.placeholder.com/640x360"/></div>
                            <div class="thumb"><img class="img-fluid w-100" src="https://via.placeholder.com/640x360"/></div>
                            <div class="thumb"><img class="img-fluid w-100" src="https://via.placeholder.com/640x360"/></div>
                            <div class="thumb"><img class="img-fluid w-100" src="https://via.placeholder.com/640x360"/></div>
                            <div class="thumb"><img class="img-fluid w-100" src="https://via.placeholder.com/640x360"/></div>
                            <div class="thumb"><img class="img-fluid w-100" src="https://via.placeholder.com/640x360"/></div>
                          </div>
                        </div>
                      </div>
                      <?php if(isset($_cat[0])) :?>
                      <div class="mt-2 addthis_inline_share_toolbox pull-right" data-url="<?php echo get_site_url() ?>/attractions/?cat=<?php echo $_cat[0]->slug ?>&id=<?php echo $skey ?>" data-title="<?php echo $show->post_title;?>"></div>
                      <?php endif ?>
                    </div>
                    <div class="show-content-block col-md-5">
                      <div class="row">
                        <div class="col-9">
                          <h2 class="title mb-0"><?php echo $show->post_title;?></h2>
                        </div>
                        <?php if($num > 1) :?>
                        <div class="col-3 btn-group">
                          <div class="cta-btn">
                            <button type="button" class="btn btn-twobit prev">
                              <span class="fa fa-chevron-left"></span>
                            </button>
                            <div class="btn-behind">&nbsp;</div>
                          </div>
                          <div class="cta-btn">
                            <button type="button" class="btn btn-twobit next">
                              <span class="fa fa-chevron-right"></span>
                            </button>
                            <div class="btn-behind">&nbsp;</div>
                          </div>
                        </div>
                        <?php endif ?>
                      </div>
                      <?php if(!empty(get_field('sub_title', $show->ID))):?>
                      <h4 class="subtitle mt-2"><?php echo get_field('sub_title', $show->ID);?></h4>
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
                      <h4 class="mt-5 clearfix"><?php _e( 'Showtimes' , 'twobitcircus'); ?> <button type="button" class="btn btn-twobit open-times-modal pull-right" data-toggle="modal" data-target="#modal-showtimes"><?php _e( 'All Times' , 'twobitcircus'); ?></button></h4>
                      <div class="showtimes-cycle">
                        <div id="cycle-<?php echo $show->ID;?>">
                          <?php $slickObj = (count($composedDates) > 5) ? '{"centerMode": true }' : ''; ?>
                          <div class="slick-days" data-slick='<?php echo $slickObj;?>' data-target="<?php echo $cat;?>">
                            <?php foreach($composedDates as $date => $tickets) :?>
                            <div class="item-days text-center">
                              <div class="day-header">
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
                                <a href="https://twobitcircus.centeredgeonline.com<?php echo $timeInfo->link;?>" class="btn btn-twobit"><?php echo $timeInfo->ticket;?></a>
                              <?php endif ?>
                              <?php endforeach ?>
                              </div>
                            </div>
                            <?php endforeach ?>
                          </div>
                        </div>
                      </div>
                      <div class="available-dates text-center">

                        <a href="#" class="btn btn-twobit confirm text-uppercase fade" target="_blank"><?php _e( 'Go to Purchase' , 'twobitcircus'); ?></a>

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
                                    <a href="https://twobitcircus.centeredgeonline.com<?php echo $timeInfo->link;?>" class="btn btn-twobit" target="_blank"><?php echo $timeInfo->ticket;?></a>
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
