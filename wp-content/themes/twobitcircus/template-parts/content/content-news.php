<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
?>
<article id="news" <?php post_class(); ?>>

  <?php get_template_part( 'template-parts/partial/partial', 'header' ); ?>

  <section id="news" class="entry-wrapper-padding inview animated delay-3">
    <div class="container-fluid">
      <div class="grid-isotope media-grid">
      <?php
        $args = array(
          'post_type' => 'news',
          'posts_per_page' => 9999
        );
        $query = new WP_Query( $args );
        if($query->have_posts() ) : while ($query->have_posts() ) : $query->the_post(); ?>
        <?php $video = get_field('video', $post->ID);?>
        <?php $gallery = get_field('gallery', $post->ID);?>
        <div class="grid-item card">
          <?php if(!empty($video)) :?>
          <div class="embed-responsive embed-responsive-16by9"><?php echo $video ?></div>
          <?php else: ?>
          <?php if(!empty($gallery[0]['url'])) :?>
          <a href="<?php the_permalink(); ?>" class="card-image"><img class="img-fluid w-100" src="<?php echo $gallery[0]['url']; ?>" alt="<?php the_title();?>"/></a>
          <?php endif ?>
          <?php endif ?>
          <div class="card-title mb-0">
            <a href="<?php the_permalink(); ?>"><h5 class="lubalin white"><?php the_title();?></h5></a>
          </div>
          <div class="card-body text-left">
            <i class="d-block mt-2"><small><?php the_time( get_option( 'date_format' ) ); ?></small></i>
            <hr class="mt-1 mb-2">
            <?php the_excerpt();?>
            <div class="link-wrapper mb-2">
              <div class="cta-btn mx-auto"><a class="btn btn-twobit" href="<?php the_permalink() ?>"><span><?php _e( 'Read More', 'twobitcircus' )?></span></a><div class="btn-behind">&nbsp;</div></div>
            </div>
          </div>
        </div>
      <?php endwhile; wp_reset_query(); endif  ?>
      </div>
    </div>
  </section>

</article>
