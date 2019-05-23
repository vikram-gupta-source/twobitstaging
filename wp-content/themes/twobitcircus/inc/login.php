<?php
/**
 * Login setup
 *
 * @package twobitcircus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function pm_custom_login_styling() {
  echo '<style type="text/css">
  *:focus { outline: 0 !important; box-shadow: none!important; }
  body.login { background: #c7c7c7 url(/wp-content/uploads/2019/05/login-bkg.jpg) repeat center / cover; }
  body.login h1 a {background-image: url(/wp-content/uploads/2019/03/logo.png) !important; }
  .login form { box-shadow: none; }
  body.login h1 { margin-top: 25%; }
  body.login #login { padding: 0; box-shadow: -1px 0 3px rgba(0,0,0,.13); float: right; height: 100vh; background-color: #fff; }
  #backtoblog { display: none !important; }
  </style>';
}
add_action( 'login_head', 'pm_custom_login_styling' );

function pm_custom_login_title() {
  return get_option( 'blogname' );
}
add_filter( 'login_headertitle', 'pm_custom_login_title' );

function pm_custom_loginlogo_url($url) {
    return home_url();
}
add_filter( 'login_headerurl', 'pm_custom_loginlogo_url' );
