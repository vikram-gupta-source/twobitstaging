

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


      beforeSend: function() {

        jQuery(".mce-custom-fields .spinner").css('visibility', 'visible');
        // alert('before');

      },


      success: function(response){ // response //data, textStatus, jqXHR

        jQuery(".mce-custom-fields .spinner").css('visibility', 'hidden');
        jQuery('#mce_panel_listamail').html( response );

        var valor = jQuery("#mce_txcomodin2").attr("value");
        // var chm_valid ='';
        var attrclass ='';

        if (valor === '1') {

          attrclass = 'spt-response-out spt-valid';
          jQuery("#mce_apivalid .chmm").removeClass("invalid").addClass("valid");
          jQuery("#mce_apivalid .dashicons").removeClass("dashicons-no").addClass( "dashicons-yes" );

        } else {

          attrclass = 'spt-response-out';
          jQuery("#mce_apivalid .chmm").removeClass("valid").addClass("invalid");
          jQuery("#mce_apivalid .dashicons").removeClass("dashicons-yes").addClass( "dashicons-no" );


        }

        jQuery('#mce_panel_listamail').attr("class",attrclass);
        // jQuery('#mce_apivalid').html( chm_valid );

      },

      error: function(data, textStatus, jqXHR){

          jQuery(".mce-custom-fields .spinner").css('visibility', 'hidden');
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


jQuery(".cme-trigger-sys").click(function() {

  jQuery( "#toggle-sys" ).slideToggle(250);

});

function toggleDiv() {

  setTimeout(function () {
      jQuery(".mce-cta").slideToggle(450);
  }, 9000);

}
toggleDiv();

jQuery(".mce-move").insertBefore("#informationdiv");


});



