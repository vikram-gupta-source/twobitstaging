<?php
/**
 * Login setup
 *
 * @package twobitcircus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function twobitcircus_custom_login_title() {
  return get_option( 'blogname' );
}
add_filter( 'login_headertext', 'twobitcircus_custom_login_title' );

function twobitcircus_custom_loginlogo_url($url) {
    return home_url();
}
add_filter( 'login_headerurl', 'twobitcircus_custom_loginlogo_url' );
