<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
 global $location;
 $isOpen = openClosed($location['days'])
?>
<!-- ******************* Navbar ******************* -->
<header id="main-nav" class="fixed-top" itemscope itemtype="http://schema.org/WebSite">
  <a class="skip-link sr-only sr-only-focusable" href="#content"><?php _e( 'Skip to content', 'twobitcircus' ); ?></a>
  <?php if(!empty(get_field('notification', 'options'))) :?>
  <div id="notification-bar">
    <div class="container text-center">
      <?php echo get_field('notification', 'options');?>
    </div>
  </div>
  <?php endif ?>
  <nav class="navbar">
    <div class="container">
      <?php the_custom_logo(); ?>

      <!-- The WordPress Menu goes here -->
      <?php wp_nav_menu( array(
          'theme_location'  => 'header',
          'container'         => 'div',
          'container_class'   => 'collapse show d-none d-lg-block',
          'container_id'      => 'navigation',
          'depth'	          => 1, // 1 = no dropdowns, 2 = with dropdowns.
          'menu_class'      => 'menu-table d-flex flex-column flex-md-row justify-content-between',
          'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
          'walker'          => new WP_Bootstrap_Navwalker(),
          'directions'       => '<span class="direction">'. $location['city'] . ' <span class="state '.$isOpen.'">('.ucwords($isOpen).')</span><br/>Directions</span>'
        ) );
      ?>

      <button class="navbar-toggler collapsed d-lg-none"" type="button" data-toggle="collapse" data-target="#expanded-menu" aria-controls="expanded-menu" aria-expanded="false" aria-label="<?php _e( 'Toggle navigation', 'twobitcircus' ); ?>">
        <div class="hamburger-wrapper">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </button>
    </div>
  </nav>
</header>
