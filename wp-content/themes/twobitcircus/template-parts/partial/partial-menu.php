<?php
/**
 * Template part for displaying posts
 *
 * @package twobitcircus
 */
 global $location;
?>
<!-- ******************* Mobile ******************* -->
<div id="expanded-menu">
  <div class="menu-block">
    <div class="expanded-logo">
      <a href="/"><img src="/wp-content/uploads/2019/09/2BC_White_Logo.png" class="img-fluid" /></a>
    </div>
    <!-- The WordPress Menu goes here -->
    <?php wp_nav_menu( array(
        'theme_location'  => 'header',
        'container'         => 'div',
        'container_class'   => 'collapse show',
        'container_id'      => 'navigation-expand',
        'depth'	          => 1, // 1 = no dropdowns, 2 = with dropdowns.
        'menu_id'         => 'main-expanded-menu',
        'menu_class'      => 'menu-table',
        'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
        'walker'          => new WP_Bootstrap_Navwalker(),
      ) );
    ?>
  </div>
  <div id="close-btn">
    <span></span>
    <span></span>
  </div>
</div>
<!-- ******************* Navbar ******************* -->
<header id="main-nav" class="fixed-top" itemscope itemtype="http://schema.org/WebSite">
  <a class="skip-link sr-only sr-only-focusable" href="#main"><?php _e( 'Skip to content', 'twobitcircus' ); ?></a>
  <?php if(!empty(get_field('notification', 'options'))) :?>
  <div id="notification-bar">
    <div class="container text-center">
      <?php echo get_field('notification', 'options');?>
    </div>
  </div>
  <?php endif ?>
  <nav class="navbar">
    <div class="container position-relative pr-0">
      <?php the_custom_logo(); ?>
      <?php if(!empty($location['city'])):?>
      <a title="Directions" href="#map-modal" class="nav-link-direction text-center">
        <span class="direction text-uppercase d-none"><?php echo $location['city'] ?><br/><span class="state"></span></span>
      </a>
      <?php endif ?>

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
        ) );
      ?>

      <button class="navbar-toggler collapsed d-lg-none mt-1 mr-2" type="button" data-toggle="collapse" data-target="#expanded-menu" aria-controls="expanded-menu" aria-expanded="false" aria-label="<?php _e( 'Toggle navigation', 'twobitcircus' ); ?>">
        <div class="hamburger-wrapper">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </button>
    </div>
  </nav>
</header>
