<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
 global $region;
?>
<article id="faq" <?php post_class(); ?>>
  <div class="container-fluid text-center main-headline">
    <?php the_title( '<h1 class="headline inview animated" data-ease="fadeInDown">', '</h1>' ); ?>
  </div>
  <?php if (!empty( get_the_content())):?>
  <div class="container-fluid text-center sub-headline">
    <div class="inview animated w-50 mx-auto delay-2"><?php the_content(); ?></div>
  </div>
  <?php endif ?>

  <?php
  $args = array(
      'post_type' => 'faqs',
      'orderby' => 'menu_order title',
      'order'   => 'DESC',
  );
  $faq = new WP_Query( $args );
  if(!empty($faq)):
  ?>
  <section id="faq-accordion" class="entry-wrapper-padding inview animated delay-3">

    <div class="faq-wrapper container">
      <?php while ( $faq->have_posts() ) : $faq->the_post(); 
      ?>
      <div class="card">
        <div class="card-header" id="heading--<?php the_ID(); ?>">
          <h5 class="mb-0 clearfix collapse-title collapsed" data-toggle="collapse" data-target="#collapse-<?php the_ID(); ?>" aria-expanded="true" aria-controls="collapse-<?php the_ID(); ?>">
              <?php the_title(); ?>
              <div class="d-line pull-right accordion-icon">
                <div class="horizontal"></div>
                <div class="vertical"></div>
              </div>
          </h5>
        </div>
        <div id="collapse-<?php the_ID(); ?>" class="collapse" aria-labelledby="heading-<?php the_ID(); ?>" data-parent="#faq-accordion">
          <div class="card-body">
            <?php the_content(); ?>
          </div>
        </div>
      </div>

      <?php endwhile; wp_reset_query(); ?>
    </div>

  <?php endif ?>

  </section>

</article>
