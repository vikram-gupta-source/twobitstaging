<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package twobitcircus
 */

get_header();
?>

	<section id="error-template" class="container">
    <article <?php post_class('my-4'); ?>>
			<div class="error-404 not-found">
			     <h1 class="headline inview animated"><?php _e( 'Oops! That page can&rsquo;t be found.', 'twobitcircus' ); ?></h1>

				<div class="page-content inview animated delay-2">
					<p><?php _e( 'It looks like nothing was found at this location.', 'twobitcircus' ); ?></p>
          <br/>
          <a class="btn btn-slide" href="/">
            <span><?php echo __( 'Go Back to Homepage', 'twobitcircus' ) ?></span>
          </a>
				</div><!-- .page-content -->
			</div><!-- .error-404 -->
    </article>
	</section>

<?php
get_footer();
