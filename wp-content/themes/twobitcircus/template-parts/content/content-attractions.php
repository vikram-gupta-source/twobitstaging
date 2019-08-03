<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
 $categories = get_categories();
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
  <?php if(!empty($categories)):?>
  <div id="filters" class="inview animated mx-auto delay-1">
    <div class="container">
      <div class="slick-filter" role="tablist">
        <?php foreach($categories as $category) : ?>
          <div class="nav-item text-center" data-toggle="tooltip" data-placement="bottom" title="<?php echo $category->category_description;?>">
            <a class="nav-link" href="#<?php echo $category->slug;?>" aria-controls="<?php echo $category->slug;?>"><i class="<?php echo @get_term_meta($category->term_id, 'category_icon', true) ;?>" aria-hidden="true"></i> <?php echo $category->name;?></a>
          </div>
        <?php endforeach ?>
      </div>
    </div>
  </div>
  <?php endif ?>
  <!-- Go to www.addthis.com/dashboard to customize your tools -->
  <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5d40d77186a2f4a8"></script>
  <section id="attractions-block" class="entry-wrapper-padding inview animated delay-1">
    <div class="container">
      <?php if(!empty($attractions)) :?>
        <div class="attractions-slick">
          <?php foreach($attractions as $cat => $shows) :?>
          <div class="item-attraction">

            <div class="slick-shows" id="<?php echo $cat;?>">
              <?php $num = count($shows); ?>
              <?php foreach($shows as $skey => $show) :?>
                <?php if(!filter_location_by_field(get_field('available_in', $show->ID))) continue; ?>
                <?php $composedDates = composeTickets(get_field('tickets', $show->ID));?>
                <?php $info = filter_locations(get_field('information', $show->ID));?>
                <?php $_cat = get_the_category($show->ID);?>
                <div class="item-shows">

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
                          <button type="button" class="btn btn-twobit prev">
                            <span class="fa fa-chevron-left"></span>
                          </button>
                          <button type="button" class="btn btn-twobit next">
                            <span class="fa fa-chevron-right"></span>
                          </button>
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
                        <a class="btn btn-sm btn-twobit" href="<?php echo $info[0]['buy_link'];?>" rel="noopener noreferrer" target="_blank"><?php _e('Buy Players Card', 'twobitcircus');?></a>
                      </div>
                      <?php endif ?>
                      <?php if(!empty($composedDates)) :?>
                      <h4 class="mt-5 clearfix"><?php _e( 'Showtimes' , 'twobitcircus'); ?> <button type="button" class="btn btn-sm btn-twobit open-times-modal pull-right" data-toggle="modal" data-target="#modal-showtimes"><?php _e( 'All Times' , 'twobitcircus'); ?></button></h4>
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
                                <a href="https://twobitcircus.centeredgeonline.com<?php echo $timeInfo->link;?>" class="btn btn-sm btn-twobit"><?php echo $timeInfo->ticket;?></a>
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
                                    <a href="https://twobitcircus.centeredgeonline.com<?php echo $timeInfo->link;?>" class="btn btn-sm btn-twobit" target="_blank"><?php echo $timeInfo->ticket;?></a>
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
