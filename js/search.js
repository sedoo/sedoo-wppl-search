jQuery(document).ready(function(){   
    jQuery('.sedoo_search_button').click(function() {
        jQuery('#sedoo_search_results_list_js').empty();
        jQuery('.sedoo_search_button.active').removeClass('active');
        jQuery(this).addClass('active');
        var array_id = jQuery(this).attr('array_id');   
        var trigger_name = jQuery(this).attr('id');  
        var infinite_load_ajout = 0; 
        var cpt = trigger_name.substr(17); 
            jQuery.ajax({
                url: ajaxurl,
                type: "POST",
                data: {
                  'action': 'search_load_post',
                  'array_id': array_id,
                  'page_no': 1,
                  'cpt': cpt,
                  'string_search' :search_string
                }
              }).done(function(response) {
                jQuery('#sedoo_search_results_list_js').append(response);
                jQuery('#sedoo_search_results_list_js').append('<div class="loader_button" id="sedoo_search_loader_button"> SHOW MORE </div>');
            
                var count = 2;
                var total = jQuery('#sedoo_Search_page_count').text();

                jQuery('#sedoo_search_loader_button').click(function(){
                    if (count > total){
                        return false;
                    } else {
                        loadArticle(count, cpt);
                    }
                    count++;
                });

                function loadArticle(pageNumber, cpt){
                    jQuery('#infiniteloader').show('fast');
                    jQuery.ajax({
                      url: ajaxurl,
                      type:'POST',
                      data: "action=search_load_post&cpt="+cpt+"&page_no="+ pageNumber + '&loop_file=loop',
                      success: function (html) {
                        jQuery('#sedoo_search_loader_button').remove();
                        jQuery("#sedoo_search_results_list_js").append(html);
                        jQuery('#sedoo_search_results_list_js').append('<div class="loader_button" id="sedoo_search_loader_button"> SHOW MORE </div>');
                        jQuery('#sedoo_search_loader_button').click(function(){
                            if (count > total){
                                return false;
                            } else {
                                loadArticle(count, cpt);
                            }
                            count++;
                        });
                      }
                    });
                return false;
                }
                
                jQuery('.sedoo_search_toggle_excerpt').click(function() {
                    var id = jQuery(this).attr('id');
                    jQuery(this).toggleClass('excerpt_displayed');
                    jQuery('#excerpt_'+id).toggleClass('visible');
                });
              });
    });
});