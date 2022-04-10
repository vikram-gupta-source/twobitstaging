<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
?>
<article id="contact" <?php post_class(); ?>>

  <?php get_template_part( 'template-parts/partial/partial', 'header-no-desc' ); ?>
 
  <?php if(get_field('question_answers')) :?>
  <section id="faq" class="entry-wrapper-padding">
    <div class="container">
      <div class="faq-wrapper accordion-wrapper inview animated delay-1 clearfix my-4">
      <?php foreach(get_field('question_answers') as $key => $faq) :?>

        <div class="card">
          <div class="card-header" id="heading-<?php echo $key; ?>" role="button">
            <h5 class="lubalin mb-0 clearfix collapse-title collapsed" data-toggle="collapse" data-target="#collapse-<?php echo $key; ?>" aria-expanded="true" aria-controls="collapse-<?php echo $key; ?>">
                <?php echo $faq['question']; ?>
                <i class="fa fa-angle-down"></i>
            </h5>
          </div>
          <div id="collapse-<?php echo $key; ?>" class="collapse" aria-labelledby="heading-<?php echo $key; ?>" data-parent="#faq">
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

</article>
