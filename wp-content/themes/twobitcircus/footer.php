<?php
/**
 * The template for displaying the footer
 *
 * @package twobitcircus
 */

?>
  </main>
  <footer> 
  	<div class="container">
      <?php the_custom_logo(); ?>
  		<?php if ( has_nav_menu( 'footer' ) ) : ?>
  			<nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer Menu', 'twobitcircus' ); ?>">
  			<?php
  				wp_nav_menu(
  					array(
  						'theme_location' => 'footer',
  						'menu_class'     => 'footer-menu list-unstyled',
  						'depth'          => 1,
  					)
  				);
  			?>
  			</nav>
  		<?php endif; ?>
      <div class="legal text-center">&copy; <?php echo date('Y');?> <?php echo get_bloginfo(); ?>. All rights reserved.</div>
  	</div>
  </footer>
  <a href="#" id="return-to-top"><i class="fa fa-chevron-up" aria-hidden="true"></i></a>
  <?php wp_footer(); ?>
</body>
</html>
