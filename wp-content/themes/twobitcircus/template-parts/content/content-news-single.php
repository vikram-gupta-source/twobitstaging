<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
remove_filter('the_content', 'wpautop');
?>
<article id="news-detail" <?php post_class();?>>

    <div class="main-headline header-bkg-right container-fluid" style="background-image: url('/wp-content/uploads/2019/09/CLUB01-HIGHLIGHTS-FINAL-2.jpg');background-position: 0 60%;">
        <div class="row h-100">
            <div class="d-md-none"><img class="img-fluid" src="/wp-content/uploads/2019/09/CLUB01-HIGHLIGHTS-FINAL-2.jpg" alt="Latest News"></div>
            <div class="header-bkg-left py-5 my-auto">
                <h2 class="headline inview animated text-center fadeInDown" data-ease="fadeInDown">Latest News</h2>
                <div class="text-center content mx-auto inview animated fadeInUp">
                    <p>Read on to learn more about what’s happening at the circus.</p>
                </div>
            </div>
        </div>
    </div>

    <section id="news-content" class="entry-wrapper-padding inview animated delay-1">
        <div class="container white">
            <div class="row">
                <?php $_video  = get_field('video_embed', $post->ID);?>
                <?php $gallery = get_field('gallery');?>
                <div class="col-md-6 mb-3">
                    <?php if (!empty($gallery) || (!empty($_video))): ?>
                    <div class="show-asset-wrapper">
                        <div class="slick-media">
                            <?php if (!empty($_video)): ?>
                            <div class="item d-block">
                                <div class="embed-responsive embed-responsive-16by9"><iframe src="<?php echo $_video; ?>" width="640" height="360" frameborder="0" allow="autoplay; fullscreen" allowfullscreen="" data-ready="true"></iframe>
                                </div>
                            </div>
                            <?php endif?>
                            <?php if (!empty($gallery)): ?>
                            <?php foreach ($gallery as $gal): ?>
                            <div class="item d-block">
                                <div class="img d-block"><img class="img-fluid w-100" src="<?php echo $gal['url']; ?>" alt="<?php echo $gal['title']; ?>" /></div>
                            </div>
                            <?php endforeach?>
                            <?php endif?>
                        </div>
                    </div>
                    <?php endif?>
                    <div class="d-none d-md-block">
                        <?php echo do_shortcode('[button class="go-back" parent="mt-3"]GO BACK[/button]'); ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <h1 class="text-uppercase lubalinB inview animated"><?php the_title();?></h1>
                    <div class="news-description inview animated delay-2">
                        <i class="mb-3"><small><?php the_time(get_option('date_format'));?></small></i>
                        <hr class="mt-1 mb-3">
                        <?php the_content();?>
                    </div>
                </div>
            </div>
            <div class="d-md-none">
                <?php echo do_shortcode('[button class="go-back" parent="mt-5 mt-md-0"]GO BACK[/button]'); ?>
            </div>
    </section>

</article>