<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
?>
<article id="news" <?php post_class(); ?>>
  <div class="container-fluid text-center main-headline">
    <?php the_title( '<h1 class="headline inview animated" data-ease="fadeInDown">', '</h1>' ); ?>
  </div>
  <?php if (!empty( get_the_content())):?>
  <div class="container-fluid text-center sub-headline">
    <div class="inview animated w-50 mx-auto delay-2"><?php the_content(); ?></div>
  </div>
  <?php endif ?>

  <section id="news" class="entry-wrapper-padding inview animated delay-3">
    <div class="container">
      <div class="grid-isotope">
      <?php
        $args = array(
          'post_type' => 'news'
        );
        $query = new WP_Query( $args );
        if($query->have_posts() ) : while ($query->have_posts() ) : $query->the_post(); ?>
        <div class="grid-item card">
          <a href="<?php echo the_permalink(); ?>"><img class="card-img-top" src="https://via.placeholder.com/329x289"/></a>
          <div class="card-body">
            <h5 class="card-title"><a href="<?php echo the_permalink(); ?>"><?php the_title();?></a></h5> 
            <?php the_excerpt();?>
            <a href="<?php echo the_permalink(); ?>" class="btn btn-twobit"><?php _e( 'Read More', 'twobitcircus' )?></a>
          </div>
        </div>
      <?php endwhile; wp_reset_query(); endif  ?>
      </div>
    </div>
  </section>

</article>
