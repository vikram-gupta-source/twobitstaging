<?php


add_action( 'wp_ajax_wpcf7_mce_loadlistas',  'wpcf7_mce_loadlistas' );
add_action( 'wp_ajax_no_priv_wpcf7_mce_loadlistas',  'wpcf7_mce_loadlistas' );

function wpcf7_mce_loadlistas() {
	global $wpdb;

	$cf7_mch_defaults = array();
	$mce_idformxx = 'cf7_mch_'. wp_unslash( $_POST['mce_idformxx'] );
	$mceapi = isset( $_POST['mceapi'] ) ? $_POST['mceapi'] : 0 ;

	$cf7_mch = get_option( $mce_idformxx, $cf7_mch_defaults );

	$tmppost = $cf7_mch ;

	$logfileEnabled = $cf7_mch['logfileEnabled'];
	$logfileEnabled = ( is_null( $logfileEnabled ) ) ? false : $logfileEnabled;

  unset( $tmppost['api'],$tmppost['api-validation'],$tmppost['lisdata'] );

	$tmp = wpcf7_mce_validate_api_key( $mceapi,$logfileEnabled,$mce_idformxx );
	$apivalid = $tmp['api-validation'];
 
	$tmppost = $tmppost + $tmp ;

	$tmp = wpcf7_mce_listasasociadas( $mceapi,$logfileEnabled,$mce_idformxx );
	$listdata = $tmp['lisdata'];
	$tmppost = $tmppost + $tmp ;

  $listatags = $cf7_mch['listatags'] ;

  $tmppost = $tmppost + array( 'api' => $mceapi );

	update_option( $mce_idformxx,$tmppost );

  mce_html_panel_listmail( $apivalid,$listdata,$cf7_mch );

	wp_die();
}



function mce_html_panel_listmail( $apivalid, $listdata, $cf7_mch ) {

  $vlist = ( isset( $cf7_mch['list'] )   ) ? $cf7_mch['list'] : ' ' ; 
  $i = 0 ;
  $count = count ( $listdata['lists'] ) ;

  ?>
    <small><input type="hidden" id="mce_txcomodin2" name="wpcf7-mailchimp[mce_txtcomodin2]" value="<?php echo( isset( $apivalid ) ) ? esc_textarea( $apivalid ) : ''; ?>" style="width:0%;" /></small>
  <?php

    if ( isset( $apivalid ) && '1' == $apivalid ) {
    ?>
      <label for="wpcf7-mailchimp-list"><?php echo esc_html( __( 'These are  ALL ' . $count .' your mailchimp.com lists: '  , 'wpcf7' ) ); ?></label><br />
      <select id="wpcf7-mailchimp-list" name="wpcf7-mailchimp[list]" style="width:45%;">
      <?php
      foreach ( $listdata['lists'] as $list ) {
        $i = $i + 1 ;
        ?>
        <option value="<?php echo $list['id'] ?>"
          <?php if ( $vlist == $list['id'] ) { echo 'selected="selected"'; } ?>>
          <?php echo $i .' - '.  $list['name'].' - Unique id: '.$list['id'].'' ?></option>
        <?php
      }
      ?>
      </select>
     <?php
  }
}

function mce_html_selected_tag ($nomfield,$listatags,$cf7_mch,$filtro) {

if ( $nomfield != 'email' )  {
    $r = array_filter( $listatags, function( $e ) use ($filtro) {
          return $e['basetype'] == $filtro or $e['basetype'] == 'textarea'  ;
        });
} else {
  $r = array_filter( $listatags, function( $e ) use ($filtro) {
          return $e['basetype'] == $filtro ;
        });
}

$listatags =   $r ;


  $ggCustomValue = ( isset( $cf7_mch[$nomfield] ) ) ? $cf7_mch[$nomfield] : ' ' ;
  
    
  $ggCustomValue = ( ( $nomfield =='email' && $ggCustomValue == ' ' )  ? '[your-email]':$ggCustomValue   );
 
     ?>
      <select class="chm-select" id="wpcf7-mailchimp-<?php echo $nomfield; ?>"
                name="wpcf7-mailchimp[<?php echo $nomfield; ?>]" style="width:95%">
                <?php if ( $nomfield != 'email'  ) { ?>
                    <option value=" "
                    <?php  if ( $ggCustomValue == ' ' ) { echo 'selected="selected"'; } ?>>
                    <?php echo (($nomfield=='email') ? 'Required by MailChimp': 'Choose.. ') ?></option>
         <?php
                   }
            foreach ( $listatags as $listdos ) {
              $vfield = '['. trim( $listdos['name'] ) . ']' ;
              if ( 'opt-in' != trim( $listdos['name'] )  && '' != trim( $listdos['name'] ) ) {
              ?>
                <option value="<?php echo $vfield ?>" <?php if (  trim( $ggCustomValue ) == $vfield ) { echo 'selected="selected"'; } ?>>
                  <?php echo '['.$listdos['name'].']' ?> <span class="mce-type"><?php echo ' - type :'.$listdos['basetype'] ; ?></span>
               </option>
                <?php
              }
           }
		    ?>
         </select>
        <?php
}

function wpcf7_mce_validate_api_key( $input, $logfileEnabled, $idform = '' ) {
	$sRpta = 0;

	try {

    if ( !isset( $input ) or trim ( $input ) =="" ) {
       $tmp = array( 'api-validation' => 0 );
       return $tmp ;
    }

    $api = ( isset( $input )  ) ? $input : "XXXX-XXXX" ;
    $dc    = explode("-",$api);
    $url   = "https://anystring:$dc[0]@$dc[1].api.mailchimp.com/3.0/ping";

    $vc_date = date( 'Md.H:i' );
    $vc_user_agent = '.' . SPARTAN_MCE_VERSION . '.' . strtolower( $vc_date );
    $vc_headers = array( "Content-Type" => "application/json" ) ;

    $opts = array(
                    'headers' => $vc_headers,
                    'user-agent' => 'mce-r' . $vc_user_agent
                  );

    $resp = wp_remote_get( $url, $opts );
    $mch_debug_logger = new mch_Debug_Logger() ;

    if ( is_wp_error ( $resp ) ) {

        $tmp = array( 'api-validation' => 0 );
        $mch_debug_logger->log_mch_debug( 'API Key Response - Result: - IdForm:'.$idform.' - Invalid Api Key ',4,$logfileEnabled );
        return $tmp;
    }

    $resultbody = wp_remote_retrieve_body( $resp );

    $validate_api_key_response = json_decode( $resultbody, True );

    $msgcad = ' Ok Valid Api Key ' ;

		$sRpta = 1;
		$tmp = array( 'api-validation' => 1 );
		$mch_debug_logger->log_mch_debug( 'API Key Response - Result: - IdForm:'.$idform.' - '.$msgcad,1,$logfileEnabled );

		return $tmp;

	} catch ( Exception $e ) {

		$tmp = array( 'api-validation' => 0 );

		$mch_debug_logger = new mch_Debug_Logger();
    $mch_debug_logger->log_mch_debug( 'API Key Response - Result: - IdForm:'.$idform.' - '.$e->getMessage(),4,$logfileEnabled );
		return $tmp;
	}

}

function wpcf7_mce_listasasociadas( $apikey, $logfileEnabled, $idform = '' ) {
	try {

   if ( !isset( $apikey ) or trim ( $apikey  ) ==""   ) {

      $list_data 	= array(
		    'id'  => 0,
				'name' => 'sin lista',
		    ) ;

       $tmp = array( 'lisdata' => $list_data );
       return $tmp ;
    }


    $api   = $apikey;
    $dc    = explode("-",$api);
    $url   = "https://anystring:$dc[0]@$dc[1].api.mailchimp.com/3.0/lists?count=9999";

    $vc_date = date( 'Md.H:i' );
    $vc_user_agent = '.' . SPARTAN_MCE_VERSION . '.' . strtolower( $vc_date );
    $vc_headers = array( "Content-Type" => "application/json" ) ;

    $opts = array(
                    'headers' => $vc_headers,
                    'user-agent' => 'mce-r' . $vc_user_agent
                  );

    $resp = wp_remote_get( $url, $opts );
    
    $resultbody = wp_remote_retrieve_body( $resp );    
   
    
    $list_datanew = json_decode( $resultbody, True );
      
 
    $tmp = array( 'lisdata' => $list_datanew );

	  $mch_debug_logger = new mch_Debug_Logger() ;
		$mch_debug_logger->log_mch_debug( 'List ID - Result: - IdForm:'.$idform.' - Complete Lists',1,$logfileEnabled );

		return $tmp;

	} catch (Exception $e) {
		$list_data 	= array(
		    'id'  => 0,
				'name' => 'sin lista',
		);
		$tmp = array( 'lisdata' => $list_data );

		$mch_debug_logger = new mch_Debug_Logger();
		$mch_debug_logger->log_mch_debug( 'List ID - Result: - IdForm:'.$idform.' - '.$e->getMessage(),4,$logfileEnabled );
		return $tmp;
	}
}


function wpcf7_mce_form_tags() {
	$manager = WPCF7_FormTagsManager::get_instance();
	$form_tags = $manager->get_scanned_tags();
	return $form_tags;
}
