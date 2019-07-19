<?php
/**
 * The template for displaying the footer
 *
 * @package twobitcircus
 */

?>
  </main>
  <footer>
  	<div class="wrapper container pt-4">
      <div class="footer-logo d-md-none">
        <a href="/" class="navbar-brand"><img data-src="<?php echo get_option('theme_mods_twobitcircus')['footer_logo'];?>" class="img-fluid" /></a>
      </div>
      <div class="row">
        <div class="col-md-3 d-none d-md-block">
          <a href="/" class="navbar-brand"><img data-src="<?php echo get_option('theme_mods_twobitcircus')['footer_logo'];?>" class="img-fluid" /></a>
        </div>
        <div class="col-md-2">
           <?php dynamic_sidebar( 'Footer Column 1' ); ?>
        </div>
        <div class="col-md-2">
           <?php dynamic_sidebar( 'Footer Column 2' ); ?>
        </div>
        <div class="col-md-4 offset-md-0 offset-lg-1">
           <?php dynamic_sidebar( 'Footer Column 3' ); ?>
        </div>

      </div>
  	</div>
    <div class="legal text-center mt-4 pt-2 pb-2">&copy; <?php echo date('Y');?> <?php echo get_option('theme_mods_twobitcircus')['footer_copyright'];?></div>
  </footer>
  <a href="#" id="return-to-top"><i class="fa fa-chevron-up" aria-hidden="true"></i></a>
  <?php wp_footer(); ?>
</body>
</html>
