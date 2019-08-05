<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
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

  <section id="faq-accordion" class="entry-wrapper-padding inview animated delay-3">
    <?php if(get_field('question_answers')) :?>
    <div class="faq-wrapper accordion-wrapper container clearfix">
      <?php $faqs = filter_locations(get_field('question_answers'));?>
      <?php foreach($faqs as $fkey => $faq) :?>

      <div class="card">
        <div class="card-header" id="heading-<?php echo $fkey; ?>">
          <h5 class="mb-0 clearfix collapse-title collapsed" data-toggle="collapse" data-target="#collapse-<?php echo $fkey; ?>" aria-expanded="true" aria-controls="collapse-<?php echo $fkey; ?>">
              <?php the_title(); ?>
              <i class="fa fa-angle-down"></i>
          </h5>
        </div>
        <div id="collapse-<?php echo $fkey; ?>" class="collapse" aria-labelledby="heading-<?php echo $fkey; ?>" data-parent="#faq-accordion">
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
