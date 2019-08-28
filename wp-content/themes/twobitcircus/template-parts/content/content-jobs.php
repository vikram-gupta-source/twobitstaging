<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
?>
<article id="jobs" <?php post_class(); ?>>

  <?php get_template_part( 'template-parts/partial/partial', 'header' ); ?>

  <section id="jobs-accordion" class="entry-wrapper-padding inview animated delay-3">
    <?php if(get_field('question_answers')) :?>
    <div class="jobs-wrapper accordion-wrapper container clearfix">
      <?php $jobs = filter_locations(get_field('question_answers'));?>
      <?php foreach($jobs as $fkey => $faq) :?>

      <div class="card">
        <div class="card-header" id="heading-<?php echo $fkey; ?>" role="tab">
          <h5 class="lubalin mb-0 clearfix collapse-title collapsed" data-toggle="collapse" data-target="#collapse-<?php echo $fkey; ?>" aria-expanded="true" aria-controls="collapse-<?php echo $fkey; ?>">
              <?php the_title(); ?>
              <i class="fa fa-angle-down"></i>
          </h5>
        </div>
        <div id="collapse-<?php echo $fkey; ?>" class="collapse" aria-labelledby="heading-<?php echo $fkey; ?>" data-parent="#jobs-accordion">
          <div class="card-body">
            <?php echo $faq['answer']; ?>
          </div>
        </div>
      </div>

    <?php endforeach ?>
    </div>

  <?php endif ?>

  </section>

</article>
