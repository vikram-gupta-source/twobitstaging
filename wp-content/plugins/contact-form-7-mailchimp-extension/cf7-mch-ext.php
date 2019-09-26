<?php
/*
Plugin Name: Contact Form 7 Extension For MailChimp
Plugin URI: http://renzojohnson.com/contributions/contact-form-7-mailchimp-extension
Description: Integrate Contact Form 7 with MailChimp. Automatically add form submissions to predetermined lists in MailChimp, using its latest API.
Author: Renzo Johnson
Author URI: http://renzojohnson.com
Text Domain: contact-form-7
Domain Path: /languages/
Version: 0.4.61
*/

/*  Copyright 2013-2019 Renzo Johnson (email: renzojohnson at gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

define( 'SPARTAN_MCE_VERSION', '0.4.61' );
define( 'SPARTAN_MCE_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'SPARTAN_MCE_PLUGIN_NAME', trim( dirname( SPARTAN_MCE_PLUGIN_BASENAME ), '/' ) );
define( 'SPARTAN_MCE_PLUGIN_DIR', untrailingslashit( dirname( __FILE__ ) ) );
define( 'SPARTAN_MCE_PLUGIN_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );


require_once( SPARTAN_MCE_PLUGIN_DIR . '/lib/mailchimp.php' );


function mc_meta_links( $links, $file ) {
    if ( $file === 'contact-form-7-mailchimp-extension/cf7-mch-ext.php' ) {
        $links[] = '<a href="'.MCE_URL.'" target="_blank" title="Documentation">Documentation</a>';
        $links[] = '<a href="'.MCE_URL.'" target="_blank" title="Starter Guide">Starter Guide</a>';
        $links[] = '<a href="//www.paypal.me/renzojohnson" target="_blank" title="Donate"><strong>Donate</strong></a>';
    }
    return $links;
}
add_filter( 'plugin_row_meta', 'mc_meta_links', 10, 2 );


function mc_settings_link( $links ) {
    $url = get_admin_url() . 'admin.php?page=wpcf7&post='.mc_get_latest_item().'&active-tab=4' ;
    $settings_link = '<a href="' . $url . '">' . __('Settings', 'textdomain') . '</a>';
    array_unshift( $links, $settings_link );
    return $links;
}


function mc_after_setup_theme() {
     add_filter('plugin_action_links_' . SPARTAN_MCE_PLUGIN_BASENAME, 'mc_settings_link');
}
add_action ('after_setup_theme', 'mc_after_setup_theme');

register_activation_hook(__FILE__,'mce_help');


add_filter( 'cron_schedules', 'mce_cron_schedules');
function mce_cron_schedules( $schedules ) {

     $schedules['weekly'] = array(
        'interval' => 604800, // segundos en una semana
        'display' => __( 'Weekly', 'mce-textdomain' ) //nombre del intervalo
     );

     $schedules['monthly'] = array(
        'interval' => 2592000, // segundos en 30 dias
        'display' => __( 'Monthly', 'mce-textdomain' ) // nombre del intervalo
     );

    $schedules['12hours'] = array(
        'interval' => 43200, // segundos en 12 horas
        'display' => __( '12hours', 'mce-textdomain' ) // nombre del intervalo
     );

     $schedules['5min'] = array(
        'interval' => 300, // segundos en 5 minutos
        'display' => __( '5min', 'mce-textdomain' ) // nombre del intervalo
     );

     return $schedules;
}

register_activation_hook( __FILE__, 'mce_plugin_scrool' );

function mce_plugin_scrool() {

    /*if( ! wp_next_scheduled( 'mce_5min_cron_job' ) ) {
        wp_schedule_event( current_time( 'timestamp' ), '5min', 'mce_5min_cron_job' );
    }*/

    if( ! wp_next_scheduled( 'mce_12hours_cron_job' ) ) {
        wp_schedule_event( current_time( 'timestamp' ), '12hours', 'mce_12hours_cron_job' );
    }
}
add_action( 'mce_12hours_cron_job', 'mce_do_this_job_12hours' );

function mce_do_this_job_12hours() {
	  if ( get_site_option('mce_show_update_news') == NULL  )
        add_site_option( 'mce_show_update_news', 1 ) ;
    else  {
       $check = 0 ;
       $tittle = '' ;
       $message = mce_get_postnotice ($check,$tittle) ;
       if ( $check == 1 )  update_site_option('mce_show_update_news', 1);
       //var_dump (' $check ' . $check ) ;
    }
}

register_deactivation_hook( __FILE__, 'mce_plugin_deactivation' );
function mce_plugin_deactivation() {
     wp_clear_scheduled_hook( 'mce_12hours_cron_job' );
    // wp_clear_scheduled_hook( 'cyb_monthly_cron_job' );
}
