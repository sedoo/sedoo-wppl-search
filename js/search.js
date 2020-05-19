jQuery(document).ready(function(){   


    jQuery('.sedoo_search_button').click(function() {
        jQuery('#sedoo_search_results_list_js').empty();
        jQuery('.sedoo_search_button.active').removeClass('active');
        jQuery(this).addClass('active');
        var array_id = jQuery(this).attr('array_id');   
        var trigger_name = jQuery(this).attr('id');  
        var infinite_load_ajout = 0; 
        var previous_state;
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
                jQuery('#sedoo_search_results_list_js').append('<div class="sedoo_infiniteloader" id="infiniteloader"> LOADING </div>');

                jQuery('#infiniteloader').hide();
                var count = 2;
                var total = jQuery('#sedoo_Search_page_count').text();
                jQuery(window).scroll(function(){
                    console.log(jQuery('#sedoo_search_results_list_js').offset().top + jQuery('#sedoo_search_results_list_js').outerHeight() - window.innerHeight);
                    if(  (jQuery('#sedoo_search_results_list_js').offset().top + jQuery('#sedoo_search_results_list_js').outerHeight() - window.innerHeight)-20 < jQuery(window).scrollTop() &&  (jQuery('#sedoo_search_results_list_js').offset().top + jQuery('#sedoo_search_results_list_js').outerHeight() - window.innerHeight)+20 > jQuery(window).scrollTop() ) {
                        if (count > total){
                            return false;
                        } else {
                            if(infinite_load_ajout == 0) {
                                loadArticle(count, cpt);
                            }
                        }
                        count++;
                    }
                });

                function isOnScreen(elem) {
                    // if the element doesn't exist, abort
                    if( elem.length == 0 ) {
                        return;
                    }
                    var $window = jQuery(window)
                    var viewport_top = $window.scrollTop()
                    var viewport_height = $window.height()
                    var viewport_bottom = viewport_top + viewport_height
                    var $elem = jQuery(elem)
                    var top = $elem.offset().top
                    var height = $elem.height()
                    var bottom = top + height
                
                    return (top >= viewport_top && top < viewport_bottom) 
                }

                function loadArticle(pageNumber, cpt){
                    jQuery('#infiniteloader').show('fast');
                    jQuery.ajax({
                      url: ajaxurl,
                      type:'POST',
                      data: "action=search_load_post&cpt="+cpt+"&page_no="+ pageNumber,
                      success: function (html) {
                        infinite_load_ajout=1;
                        jQuery('#infiniteloader').hide();
                        jQuery('#infiniteloader').remove();
                        jQuery("#sedoo_search_results_list_js").append(html);
                        infinite_load_ajout=0;
                        jQuery('#sedoo_search_results_list_js').append('<div class="sedoo_infiniteloader" id="infiniteloader"> LOADING </div>'); 
                        jQuery('#infiniteloader').hide();
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