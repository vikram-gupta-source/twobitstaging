<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
?>
<article id="contact" <?php post_class(); ?>>

  <?php get_template_part( 'template-parts/partial/partial', 'header-no-desc' ); ?>

  <section id="contact-block" class="entry-wrapper-padding bkg-img">
    <div class="container">
      <?php the_content(); ?>
    </div>
  </section>

  <?php if(get_field('question_answers')) :?>
  <section id="faq-block" class="entry-wrapper-padding">
    <div class="container">
      <h2 class="headline inview animated text-center white"><?php echo __( 'FAQ', 'twobitcircus' ); ?></h2>
      <div class="faq-wrapper accordion-wrapper inview animated delay-1 clearfix my-4">
      <?php foreach(get_field('question_answers') as $key => $faq) :?>

        <div class="card">
          <div class="card-header" id="heading-<?php echo $key; ?>" role="button">
            <h5 class="lubalin mb-0 clearfix collapse-title collapsed" data-toggle="collapse" data-target="#collapse-<?php echo $key; ?>" aria-expanded="true" aria-controls="collapse-<?php echo $key; ?>">
                <?php echo $faq['question']; ?>
                <i class="fa fa-angle-down"></i>
            </h5>
          </div>
          <div id="collapse-<?php echo $key; ?>" class="collapse" aria-labelledby="heading-<?php echo $key; ?>" data-parent="#faq-block">
            <div class="card-body">
              <?php echo $faq['answer']; ?>
            </div>
          </div>
        </div>

      <?php endforeach ?>
      </div>
    </div>
  </section>
  <?php endif?>

  <section id="jobs-banner-block" class="entry-wrapper-padding bkg-img" <?php echo ((!empty(get_field('banner_background_image'))) ? 'style="url('.get_field('banner_image').')"' : (!empty(get_field('banner_background_color'))) ? 'style="background-color:'.get_field('banner_background_color').'"' : '');?>>
    <div class="container">
      <h2 class="headline inview animated text-center white"><?php echo get_field('banner_title');?></h2>
      <div class="w-75 mx-auto text-center white inview animated delay-1">
        <?php echo get_field('banner_description');?>
      </div>
    </div>
  </section>

</article>
