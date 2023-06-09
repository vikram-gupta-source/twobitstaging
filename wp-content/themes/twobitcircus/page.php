<?php
/**
 * The template for displaying all single posts
 *
 * @package twobitcircus
 */
get_header();
?>

    <section id="page-template">

            <?php

            /* Start the Loop */
            while ( have_posts() ) :
                // Get Hero Template
                get_template_part('template-parts/partial/partial', 'hero');

                the_post();
                if(is_front_page()) {
                    get_template_part('template-parts/content/content', 'home');
                } elseif(is_page('about')) {
                    get_template_part('template-parts/content/content', 'about');
                } elseif(is_page('food-drink')) {
                    get_template_part('template-parts/content/content', 'food');
                } elseif((is_page('promotions')) || (is_page('events'))) {
                    get_template_part('template-parts/content/content', 'promo');
                } elseif(is_page('attractions')) {
                    get_template_part('template-parts/content/content', 'attractions');
                } elseif((is_page('parties-events')) || (is_page('birthday'))) {
                    get_template_part('template-parts/content/content', 'parties');
                } elseif(is_page('media')) {
                    get_template_part('template-parts/content/content', 'media');
                } elseif(is_page('contact')) {
                    get_template_part('template-parts/content/content', 'contact');
                } elseif(is_page('jobs')) {
                    get_template_part('template-parts/content/content', 'jobs');
                } elseif(is_page('locations')) {
                    get_template_part('template-parts/content/content', 'locations');
                } elseif(is_page('dallas')) {
                    get_template_part('template-parts/content/content', 'dallas');
                } elseif(is_page('losangeles')) {
                    get_template_part('template-parts/content/content', 'losangeles');
                } elseif(is_page('latest-news')) {
                    get_template_part('template-parts/content/content', 'news');
                } elseif(is_page('our-manifesto')) {
                    get_template_part('template-parts/content/content', 'manifesto');
                } elseif(is_page('blog')) {
                    get_template_part('template-parts/content/content', 'blog');
                } elseif(is_page('faq')) {
                    get_template_part('template-parts/content/content', 'faqs');
                } else {
                    get_template_part('template-parts/content/content');
                }
                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number() ) {
                    comments_template();
                }

            endwhile; ?>

    </section><!-- #primary -->

<?php
get_footer();
