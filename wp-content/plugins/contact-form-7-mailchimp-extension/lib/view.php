<?php
/*  Copyright 2013-2017 Renzo Johnson (email: renzojohnson at gmail.com)

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

function vc_utm() {

  global $wpdb;

  $utms  = '?utm_source=MailChimp';
  $utms .= '&utm_campaign=w' . get_bloginfo( 'version' ) . '-' . mce_difer_dateact_date() . 'c' . WPCF7_VERSION . ( defined( 'WPLANG' ) && WPLANG ? WPLANG : 'en_US' ) . '';
  $utms .= '&utm_medium=cme-' . SPARTAN_MCE_VERSION . '';
  $utms .= '&utm_term=F' . ini_get( 'allow_url_fopen' ) . 'C' . ( function_exists( 'curl_init' ) ? '1' : '0' ) . 'P' . PHP_VERSION . 'S' . $wpdb->db_version() . '';
  // $utms .= '&utm_content=';
  return $utms;
}

function mce_panel_gen ($apivalid,$listdata,$cf7_mch,$listatags,$mce_txcomodin) {
  ?>
   <div >
      <small><input type="hidden" id="mce_txtcomodin" name="wpcf7-mailchimp[mce_txtcomodin]" value="<?php echo( isset( $mce_txcomodin ) ) ? esc_textarea( $mce_txcomodin ) : ''; ?>" style="width:0%;" /></small>
    <div class="mce-custom-fields">
      <div class="mail-field">
        <div id="mce_panel_listamail" >

            <?php mce_html_panel_listmail( $apivalid, $listdata, $cf7_mch); // Get listas ?>

        </div>
        <small class="description">If you dont see all your lists, hit the Connect button again <a href="<?php echo MCE_URL ?>/mailchimp-list-id<?php echo vc_utm() ?>MC-list-id" class="helping-field" target="_blank" title="get help with MailChimp List ID:"> Get more help <span class="red-icon dashicons dashicons-admin-links"></span></a></small>
      </div>
    </div>

    <div class="mce-custom-fields">
      <div class="mail-field md-half">
        <label for="wpcf7-mailchimp-email"><?php echo esc_html( __( 'Subscriber Email: *|EMAIL|* ', 'wpcf7' ) ); ?></label><br />
         <?php mce_html_selected_tag ('email',$listatags,$cf7_mch,'email') ;  ?>
        <small class="description">This field MUST be an email tags <a href="<?php echo MCE_URL ?>/mailchimp-contact-form<?php echo vc_utm() ?>MC-email" class="helping-field" target="_blank" title="get help with Subscriber Email:"> Get more help <span class="red-icon dashicons dashicons-admin-links"></span></a></small>
      </div>

      <div class="mail-field md-half">
        <label for="wpcf7-mailchimp-name"><?php echo esc_html( __( 'Subscriber Name - *|FNAME|* ', 'wpcf7' ) ); ?></label><br />
         <?php mce_html_selected_tag ('name',$listatags,$cf7_mch,'text') ; ?>
        <small class="description"> Choose the field that will be mapped to as Name <a href="<?php echo MCE_URL ?>/mailchimp-contact-form<?php echo vc_utm() ?>MC-name" class="helping-field" target="_blank" title="get help with Subscriber name:"> Get more help <span class="red-icon dashicons dashicons-admin-links"></span></a></small>
      </div>
    </div>

  </div>


<?php
}

?>


<div class="mce-main-fields">



   <p class="mail-field">
      <div id="mce_apivalid"><h2>MailChimp Extension  <span><?php echo isset( $apivalid ) && '1' == $apivalid ? $chm_valid : $chm_invalid ; ?></span><span class="mc-code"><?php global $wpdb; $mce_sents = get_option( 'mce_sent'); echo SPARTAN_MCE_VERSION . ':' . ini_get( 'allow_url_fopen' ) . ':' . ( function_exists( 'curl_init' ) ? '1' : '0' ) . ':' . WPCF7_VERSION . ':' . get_bloginfo( 'version' ) . ':' . PHP_VERSION . ':' . $wpdb->db_version() .' = ' . $mce_sents .  ' saved in ' .  mce_difer_dateact_date(); ?></span></h3></div>
    </p>
  <div class="mce-custom-fields">

      <label for="wpcf7-mailchimp-api"><?php echo esc_html( __( 'MailChimp API Key:', 'wpcf7' ) ); ?> </label><br />
      <input type="text" id="wpcf7-mailchimp-api" name="wpcf7-mailchimp[api]" class="wide" size="50" placeholder=" " value="<?php echo (isset($cf7_mch['api']) ) ? esc_attr( $cf7_mch['api'] ) : ''; ?>" />
      <span><input id="mce_activalist" type="button" value="Connect and fetch your mailing lists" class="button button-primary" style="width:35%;" /><span class="spinner"></span></span>
      <small class="description">6283ef9bdef6755f8fe686ce53bdf75a-us9 <-- A number like this <a href="<?php echo MCE_URL ?>/mailchimp-api-key<?php echo vc_utm() ?>MC-api" class="helping-field" target="_blank" title="get help with MailChimp API Key:"> Get more help <span class="red-icon dashicons dashicons-admin-links"></span></a></small>



  </div>

    <div id="mce_panel_ajagen">
        <?php  mce_panel_gen ($apivalid,$listdata,$cf7_mch,$listatags,$mce_txcomodin) ;    ?>
    </div>

    <div class="cme-container mce-support" style="display:none">

        <p class="mail-field mt0">
          <label for="wpcf7-mailchimp-accept"><?php echo esc_html( __( 'Required Acceptance Field:', 'wpcf7' ) ); ?> </label><br />
          <input type="text" id="wpcf7-mailchimp-accept" name="wpcf7-mailchimp[accept]" class="wide" size="70" placeholder="[opt-in] <= Leave Empty if you are NOT using the checkbox or read the link above" value="<?php echo (isset($cf7_mch['accept'])) ? $cf7_mch['accept'] : '';?>" />
          <small class="description"><?php echo mce_mail_tags(); ?>  <-- you can use these mail-tags <a href="<?php echo MCE_URL ?>/mailchimp-opt-in-checkbox<?php echo vc_utm() ?>MC-opt-in-checkbox" class="helping-field" target="_blank" title="get help with Subscriber name:"> Get more help <span class="red-icon dashicons dashicons-admin-links"></span></a></small>
        </p>

        <p class="mail-field">
          <input type="checkbox" id="wpcf7-mailchimp-conf-subs" name="wpcf7-mailchimp[confsubs]" value="1"<?php echo ( isset($cf7_mch['confsubs']) ) ? ' checked="checked"' : ''; ?> />
          <label for="wpcf7-mailchimp-double-opt-in"><?php echo esc_html( __( 'Enable Double Opt-in (checked = true)', 'wpcf7' ) ); ?>  <a href="<?php echo MCE_URL ?><?php echo vc_utm() ?>MC-double-opt-in" class="helping-field" target="_blank" title="get help with Custom Fields"> Help <span class="red-icon dashicons dashicons-sos"></span></a></label>
        </p>


        <p class="mail-field">
          <input type="checkbox" id="wpcf7-mailchimp-cf-active" name="wpcf7-mailchimp[cfactive]" value="1"<?php echo ( isset($cf7_mch['cfactive']) ) ? ' checked="checked"' : ''; ?> />
          <label for="wpcf7-mailchimp-cfactive"><?php echo esc_html( __( 'Use Custom Fields', 'wpcf7' ) ); ?>  <a href="<?php echo MCE_URL ?>/mailchimp-custom-fields<?php echo vc_utm() ?>MC-custom-fields" class="helping-field" target="_blank" title="get help with Custom Fields"> Help <span class="red-icon dashicons dashicons-sos"></span></a></label>
        </p>


        <div class="mailchimp-custom-fields">
          <p>In the following fields, you can use these mail-tags: <?php echo mce_mail_tags(); ?>.</p>

          <?php for($i=1;$i<=10;$i++){ ?>
          <div>

            <div class="col-6">
              <label for="wpcf7-mailchimp-CustomValue<?php echo $i; ?>"><?php echo esc_html( __( 'Contact Form [mail-tag] '.$i.':', 'wpcf7' ) ); ?></label><br />
              <input type="text" id="wpcf7-mailchimp-CustomValue<?php echo $i; ?>" name="wpcf7-mailchimp[CustomValue<?php echo $i; ?>]" class="wide" size="70" placeholder="[your-mail-tag]" value="<?php echo (isset( $cf7_mch['CustomValue'.$i]) ) ?  esc_attr( $cf7_mch['CustomValue'.$i] ) : '' ;  ?>" />
            </div>


            <div class="col-6">
              <label for="wpcf7-mailchimp-CustomKey<?php echo $i; ?>"><?php echo esc_html( __( 'MailChimp field name or *|MERGE|* tag '.$i.':', 'wpcf7' ) ); ?> <a href="<?php echo MCE_URL ?>/mailchimp/mailchimp-list-fields-and-merge-tags<?php echo vc_utm() ?>MC-custom-fields" class="helping-field" target="_blank" title="get help with Custom Fields"> Help <span class="red-icon dashicons dashicons-sos"></span></a></label><br />
              <input type="text" id="wpcf7-mailchimp-CustomKey<?php echo $i; ?>" name="wpcf7-mailchimp[CustomKey<?php echo $i; ?>]" class="wide" size="70" placeholder="MERGE<?php echo $i+2;?>" value="<?php echo (isset( $cf7_mch['CustomKey'.$i]) ) ?  esc_attr( $cf7_mch['CustomKey'.$i] ) : '' ;  ?>" />
            </div>

          </div>
          <?php } ?>
        </div><!-- /.mailchimp-custom-field -->
    </div>

     <p class="p-author"><a type="button" aria-expanded="false" class="mce-trigger a-support ">Show advanced settings</a> &nbsp; <a class="cme-trigger-sys a-support ">Get System Information</a></p>

    <script>
      jQuery(".cme-trigger-sys").click(function() {
        jQuery( "#toggle-sys" ).slideToggle(250);

      });

      function toggleDiv() {

        setTimeout(function () {
            jQuery(".mce-cta").slideToggle(450);
        }, 9000);

      }
      toggleDiv();
    </script>

    <?php include SPARTAN_MCE_PLUGIN_DIR . '/lib/system.php'; ?>
      <!-- <hr class="p-hr"> -->



  <div class="dev-cta mce-cta welcome-panel" style="display: none;">

    <div class="welcome-panel-content">

      <p class="about-description">Hello. My name is Renzo, I <span alt="f487" class="dashicons dashicons-heart red-icon"> </span> WordPress and I develop this tiny FREE plugin to help users like you. I drink copious amounts of coffee to keep me running longer <span alt="f487" class="dashicons dashicons-smiley red-icon"> </span>. If you've found this plugin useful, please consider making a donation.</p><br>
      <p class="about-description">Would you like to <a class="button-primary" href="http://bit.ly/2HdTzmO" target="_blank">buy me a coffee?</a> or <a class="button-primary" href="http://bit.ly/2I7iZUA" target="_blank">Donate with Paypal</a></p>

    </div>

  </div>


  <table class="form-table mt0 description">
    <tbody>
      <tr>
        <th scope="row">Debug Logger</th>
        <td>
          <fieldset><legend class="screen-reader-text"><span>Debug Logger</span></legend><label for="wpcf7-mailchimp-cfactive">
          <input type="checkbox"
                 id="wpcf7-mailchimp-logfileEnabled"
                 name="wpcf7-mailchimp[logfileEnabled]"
                 value="1" <?php echo ( isset( $cf7_mch['logfileEnabled'] ) ) ? ' checked="checked"' : ''; ?>
          />
          Enable to troubleshoot issues with the extension.</label>
          </fieldset>
          <p>- View debug log file by clicking <a href="<?php echo esc_textarea( SPARTAN_MCE_PLUGIN_URL ). '/logs/log.txt'; ?>" target="_blank">here</a>. <br />
             - Reset debug log file by clicking <a href="<?php echo esc_textarea( $urlactual ). '&mce_reset_log=1'; ?>">here</a>.</p>

        </td>
      </tr>
    </tbody>
  </table>

  <p class="mail-field">
    <input type="checkbox" id="wpcf7-mailchimp-cf-support" name="wpcf7-mailchimp[cf-supp]" value="1"<?php echo ( isset($cf7_mch['cf-supp']) ) ? ' checked="checked"' : ''; ?> />
    <label for="wpcf7-mailchimp-cfactive"><?php echo esc_html( __( 'Developer Backlink', 'wpcf7' ) ); ?> <small><i>( If checked, a backlink to our site will be shown in the footer. This is not compulsory, but always appreciated <span class="spartan-blue smiles">:)</span> )</i></small></label>
  </p>

</div>





