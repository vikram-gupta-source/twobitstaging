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
          'post_type' => 'news',
          'posts_per_page' => 9999
        );
        $query = new WP_Query( $args );
        if($query->have_posts() ) : while ($query->have_posts() ) : $query->the_post(); ?>
        <?php $_video = get_field('video_embed', $post->ID);?>
        <?php $gallery = get_field('gallery', $post->ID);?>

        <div class="grid-item card">
          <?php if(!empty($_video)) :?>
          <div class="embed-responsive embed-responsive-16by9"><iframe src="<?php echo $_video;?>" width="640" height="360" frameborder="0" allow="autoplay; fullscreen" allowfullscreen="" data-ready="true"></iframe>
          </div>
          <?php else: ?>
          <?php if(!empty($gallery[0]['url'])) :?>
          <a href="<?php the_permalink(); ?>" class="card-image bkg-img" style="background-image: url('<?php echo $gallery[0]['url']; ?>');background-position: center top;"></a>
          <?php else :?>
          <a href="<?php the_permalink(); ?>" class="card-image"><img class="lazy-load img-fluid" data-src="/wp-content/uploads/2019/09/default_logo.png" alt="<?php the_title();?>" /></a></a>
          <?php endif ?>
          <?php endif ?>
          <div class="card-title mb-0 d-flex justify-content-between align-items-center event-link">
            <a href="<?php the_permalink(); ?>"><h5 class="lubalin white"><?php echo wp_trim_words(get_the_title(), 8);?></h5></a>
          </div>
          <div class="card-body pt-2 pb-3 text-left">
            <small class="pull-left"><?php the_time( get_option( 'date_format' ) ); ?></small>
            <div class="cta-btn mx-auto pull-right"><a class="btn btn-twobit btn-sm" href="<?php the_permalink() ?>"><span><?php _e( 'Read More', 'twobitcircus' )?></span></a><div class="btn-behind sm">&nbsp;</div></div>
          </div>
        </div>

      <?php endwhile; wp_reset_query(); endif  ?>
      </div>
    </div>
  </section>

</article>
