<?php
/**
 * The header for our theme
 *
 * @package twobitcircus
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

  <!-- ******************* Navbar ******************* -->
	<header id="main-nav" class="fixed-top" itemscope itemtype="http://schema.org/WebSite">
		<a class="skip-link sr-only sr-only-focusable" href="#content"><?php _e( 'Skip to content', 'twobitcircus' ); ?></a>
		<nav class="navbar">
			<div class="container">
        <?php do_shortcode('[geot country="US"] USA only content [/geot]'); ?>

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
  <main role="main">
