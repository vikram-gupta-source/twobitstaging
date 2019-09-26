

jQuery(document).on('click', '#mce_activalist', function(event){ // use jQuery no conflict methods replace $ with "jQuery"
      event.preventDefault(); // stop post action
      jQuery.ajax({
          type: "POST",
          url: ajaxurl, // or '<?php echo admin_url('admin-ajax.php'); ?>'
          data: {
              action : 'wpcf7_mce_loadlistas',              
              mce_idformxx : jQuery("#mce_txtcomodin").attr("value"),
              mceapi: jQuery("#wpcf7-mailchimp-api").attr("value"),
                },
          success: function(response){ // response //data, textStatus, jqXHR

            jQuery('#mce_panel_listamail').html( response );

            var valor = jQuery("#mce_txcomodin2").attr("value");
            var chm_valid ='';
            var attrclass ='';

            if (valor === '1') {
              attrclass = 'spt-response-out spt-valid';
              chm_valid = '<h3 class="title">MailChimp API Key <span><span class="chmm valid"><span class="dashicons dashicons-yes"></span>API Key</span></span></h3>';
            } else {
              attrclass = 'spt-response-out';
              chm_valid = '<h3 class="title">MailChimp API Key <span><span class="chmm invalid"><span class="dashicons dashicons-no"></span>Error: API Key</span></span></h3>';            
            }
            jQuery('#mce_panel_listamail').attr("class",attrclass);

            jQuery('#mce_apivalid').html( chm_valid );

          },
          error: function(data, textStatus, jqXHR){
              alert(textStatus);
          },
      });
  });

jQuery(document).ready(function() {

	try {

		if (! jQuery('#wpcf7-mailchimp-cf-active').is(':checked'))

			jQuery('.mailchimp-custom-fields').hide();

		jQuery('#wpcf7-mailchimp-cf-active').click(function() {

			if (jQuery('.mailchimp-custom-fields').is(':hidden')
			&& jQuery('#wpcf7-mailchimp-cf-active').is(':checked')) {

				jQuery('.mailchimp-custom-fields').slideDown('fast');
			}

			else if (jQuery('.mailchimp-custom-fields').is(':visible')
			&& jQuery('#wpcf7-mailchimp-cf-active').not(':checked')) {

				jQuery('.mailchimp-custom-fields').slideUp('fast');
        jQuery(this).closest('form').find(".mailchimp-custom-fields input[type=text]").val("");

			}

		});



		jQuery(".mce-trigger").click(function() {

			jQuery(".mce-support").slideToggle("fast");

      jQuery(this).text(function(i, text){
          return text === "Show advanced settings" ? "Hide advanced settings" : "Show advanced settings";
      })

			return false; //Prevent the browser jump to the link anchor

		});


    jQuery(".mce-trigger2").click(function() {
      jQuery(".mce-support2").slideToggle("fast");
      return false; //Prevent the browser jump to the link anchor
    });


    jQuery(".mce-trigger3").click(function() {
      jQuery(".mce-support3").slideToggle("fast");
      return false; //Prevent the browser jump to the link anchor
    });


	}

	catch (e) {

	}

});