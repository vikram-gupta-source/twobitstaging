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
    <ul class="nav justify-content-center" role="tablist">
    <?php foreach($categories as $category) : ?>
      <li class="nav-item">
        <a class="nav-link" id="<?php echo $category->slug;?>-tab" data-toggle="tab" href="#<?php echo $category->slug;?>" role="tab" aria-controls="<?php echo $category->slug;?>" aria-selected="true" href="#<?php echo $category->slug;?>"><i class="<?php echo @get_term_meta($category->term_id, 'category_icon', true) ;?>" aria-hidden="true"></i> <?php echo $category->name;?></a>
      </li>
    <?php endforeach ?>
    </ul>
  </div>
  <?php endif ?>
  <!-- Go to www.addthis.com/dashboard to customize your tools -->
  <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5d40d77186a2f4a8"></script>
  <section id="attractions-block" class="entry-wrapper-padding inview animated delay-1">
    <div class="container">
      <?php if(!empty($attractions)) :?>
      <div class="tab-content attraction" id="showTabContent">
        <?php foreach($attractions as $cat => $shows) :?>
        <div class="tab-pane fade" id="<?php echo $cat;?>" role="tabpanel" aria-labelledby="<?php echo $cat;?>-tab">
          <div class="slick slick-shows">
            <?php foreach($shows as $skey => $show) :?>
              <?php if(!filter_location_by_field(get_field('available_in', $show->ID))) continue; ?>
              <?php $composedDates = composeTickets(get_field('tickets', $show->ID));?>
              <?php $info = filter_locations(get_field('information', $show->ID));?>
              <div class="item">

                <div class="row">
                  <div class="col-md-5 mb-4">
                    <img class="img-fluid w-100" src="https://via.placeholder.com/400x300"/>

                    <?php if(!empty($composedDates)) :?>
                    <h4 class="mt-3"><?php _e( 'Showtimes' , 'twobitcircus'); ?></h4>
                    <div class="showtimes-cycle">
                      <div id="cycle-<?php echo $show->ID;?>">
                        <div class="slick-days">
                          <?php foreach($composedDates as $date => $tickets) :?>
                          <div class="items">
                            <div class="card-header">
                              <?php echo date('D, M j', strtotime(str_replace('-', '/', $date)));?>
                            </div>
                          </div>
                          <?php endforeach ?>
                        </div>
                        <div class="slick-times">
                          <?php foreach($composedDates as $date => $tickets) :?>
                          <div class="items">
                            <div class="card-body">
                            <?php foreach($tickets as $timeInfo) : ?>
                            <?php if(!preg_match('/(Out)/', $timeInfo->ticket)): ?>
                              <a href="https://twobitcircus.centeredgeonline.com<?php echo $timeInfo->link;?>" class="btn btn-twobit" target="_blank"><?php echo $timeInfo->ticket;?></a>
                            <?php endif ?>
                            <?php endforeach ?>
                            </div>
                          </div>
                          <?php endforeach ?>
                        </div>
                      </div>
                    </div>
                    <div class="available-dates text-center">
     									<button type="button" class="btn btn-twobit open-times-modal" data-toggle="modal" data-target="#modal-showtimes"><?php _e( 'All Showtimes' , 'twobitcircus'); ?></button>

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
                  <div class="col-md-7">
                    <h2 class="title"><?php echo $show->post_title;?></h2>
                    <?php if(!empty(get_field('sub_title', $show->ID))):?>
                    <h3 class="subtitle"><?php echo get_field('sub_title', $show->ID);?></h3>
                    <?php endif ?>
                    <?php if(!empty($info[0])):?>
                    <div class="info-block">
                      <div class="d-inline-block"><i class="fa fa-user pr-1"></i><?php echo $info[0]['players'];?></div>
                      <div class="d-inline-block pl-3 pr-4"><i class="fa fa-clock-o pr-1"></i><?php echo $info[0]['show_duration'];?></div>
                      <div class="d-inline-block"><i class="fa fa-money pr-1"></i><?php echo $info[0]['price'];?></div>
                    </div>
                    <?php if(!empty($info[0]['buy_link']) && empty($composedDates)): ?>
                    <div class="buy-link">
                      <a class="btn btn-sm btn-twobit" href="<?php echo $info[0]['buy_link'];?>" rel="noopener noreferrer" target="_blank"><?php _e('Buy Tickets', 'twobitcircus');?></a>
                    </div>
                    <?php endif ?>
                    <?php endif ?>
                    <p><?php echo $show->post_content;?></p> 
                    <?php $_cat = get_the_category($show->ID);?>
                    <?php if(isset($_cat[0])) :?>
                    <div class="addthis_inline_share_toolbox" data-url="<?php echo get_site_url() ?>/attractions/?cat=<?php echo $_cat[0]->slug ?>&id=<?php echo $skey ?>" data-title="<?php echo $show->post_title;?>"></div>
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
  </section>

</article>
