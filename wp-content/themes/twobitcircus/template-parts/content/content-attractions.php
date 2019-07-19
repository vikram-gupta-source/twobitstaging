<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
 global $region;
?>
<article id="attractions" <?php post_class(); ?>>
  <div class="container-fluid text-center main-headline">
    <?php the_title( '<h1 class="headline inview animated" data-ease="fadeInDown">', '</h1>' ); ?>
  </div>
  <?php if (!empty( get_the_content())):?>
  <div class="container-fluid text-center sub-headline">
    <div class="inview animated w-50 mx-auto delay-2"><?php the_content(); ?></div>
  </div>
  <?php endif ?>
  <section id="attractions-block" class="entry-wrapper-padding inview animated delay-3">
    <?php if(!empty(get_field('attractions'))) :?>
    <div class="container-fluid">
      <div class="attraction">
        <?php foreach($attractionss as $shows) : ?>
        <div class="card">
          <img class="card-img-top" src="https://via.placeholder.com/329x289"/>
          <div class="card-body">
            <?php if(!empty($shows['title'])) :?>
            <h5 class="card-title"><?php echo $shows['title'];?></h5>
            <?php endif ?>
            <?php if(!empty($shows['description'])) :?>
            <p><?php echo $shows['description'];?></p>
            <?php endif ?>
            <div class="link-wrapper">
              <?php if(!empty($shows['book_now'])) :?>
              <a href="<?php echo $shows['book_now'];?>" class="btn btn-twobit"><?php _e( 'Book Now', 'twobitcircus' )?></a>
              <?php endif ?>
            </div>
          </div>
        </div>
        <?php endforeach ?>
      </div>
    </div>
    <?php endif ?>
  </section>

</article>
