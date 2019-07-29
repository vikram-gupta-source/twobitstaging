<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */ 
?>
<article id="promotions" <?php post_class(); ?>>
  <div class="container-fluid text-center main-headline">
    <?php the_title( '<h1 class="headline inview animated" data-ease="fadeInDown">', '</h1>' ); ?>
  </div>
  <?php if (!empty( get_the_content())):?>
  <div class="container-fluid text-center sub-headline">
    <div class="inview animated w-50 mx-auto delay-2"><?php the_content(); ?></div>
  </div>
  <?php endif ?>
  <section id="promo-block" class="entry-wrapper-padding inview animated delay-3">
    <?php if(!empty(get_field('promotions'))) :?>
    <?php $promotions = filter_locations(get_field('promotions'));?>
    <div class="container">
      <div class="promos row row-eq-height mt-4">
        <?php foreach($promotions as $promo) : ?>
        <div class="col-md-4 mb-3">
          <div class="card">
            <img class="card-img-top" src="https://via.placeholder.com/329x289"/>
            <div class="card-body">
              <?php if(!empty($promo['title'])) :?>
              <h5 class="card-title"><?php echo $promo['title'];?></h5>
              <?php endif ?>
              <?php if(!empty($promo['description'])) :?>
              <p><?php echo $promo['description'];?></p>
              <?php endif ?>
              <div class="link-wrapper">
                <?php if(!empty($promo['link_title'])) :?>
                <div class="more"><a href="<?php echo $promo['link'];?>" class="btn btn-sm btn-twobit"><?php echo $promo['link_title'];?></a></div>
                <?php endif ?>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach ?>
      </div>
    </div>
    <?php endif ?>
  </section>

</article>
