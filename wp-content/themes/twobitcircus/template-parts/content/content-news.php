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
      <div class="grid-flex">
      <?php
        $args = array(
          'post_type' => 'news'
        );
        $query = new WP_Query( $args );
        if($query->have_posts() ) : while ($query->have_posts() ) : $query->the_post(); ?>
        <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
        <div class="grid-item card">
          <a href="<?php the_permalink(); ?>" class="card-image"><img class="img-fluid w-100" src="<?php echo $image[0]; ?>" alt="<?php the_title();?>"/></a>
          <div class="card-title mb-0">
            <a href="<?php the_permalink(); ?>"><h5 class="lubalin white"><?php the_title();?></h5></a>
          </div>
          <div class="card-body text-left">
            <?php the_excerpt();?>
            <div class="link-wrapper my-2">
              <div class="cta-btn mx-auto"><a class="btn btn-twobit" href="<?php the_permalink() ?>"><span><?php _e( 'Read More', 'twobitcircus' )?></span></a><div class="btn-behind">&nbsp;</div></div>
            </div>
          </div>
        </div>
      <?php endwhile; wp_reset_query(); endif  ?>
      </div>
    </div>
  </section>

</article>
