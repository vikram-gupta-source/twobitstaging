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
    <div class="container">
      <div class="grid-isotope">
      <?php
        $args = array(
          'post_type' => 'news'
        );
        $query = new WP_Query( $args );
        if($query->have_posts() ) : while ($query->have_posts() ) : $query->the_post(); ?>
        <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
        <div class="grid-item card">
          <a href="<?php the_permalink(); ?>"><img class="card-img-top" src="<?php echo $image[0]; ?>"/></a>
          <div class="card-body">
            <h5 class="card-title lubalin"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h5>
            <?php the_excerpt();?>
            <div class="cta-btn mx-auto"><a class="btn btn-twobit" href="<?php the_permalink() ?>"><span><?php _e( 'Read More', 'twobitcircus' )?></span></a><div class="btn-behind">&nbsp;</div></div>
          </div>
        </div>
      <?php endwhile; wp_reset_query(); endif  ?>
      </div>
    </div>
  </section>

</article>
