jQuery(document).ready(function(){   
    jQuery('.sedoo_search_button').click(function() {
        var array_id = jQuery(this).attr('array_id');    
            jQuery.ajax({
                url: ajaxurl,
                type: "POST",
                data: {
                  'action': 'search_load_post',
                  'array_id': array_id
                }
              }).done(function(response) {
                  jQuery('#sedoo_search_results_list_js').empty();
                  jQuery('#sedoo_search_results_list_js').append(response);

                    jQuery('.sedoo_search_toggle_excerpt').click(function() {
                        var id = jQuery(this).attr('id');
                        jQuery(this).toggleClass('excerpt_displayed');
                        jQuery('#excerpt_'+id).toggleClass('visible');
                    });
              });

        jQuery('.sedoo_search_button.active').removeClass('active');
        jQuery(this).addClass('active');
    });

});