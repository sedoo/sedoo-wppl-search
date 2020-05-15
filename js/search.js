jQuery(document).ready(function(){   
    jQuery('.sedoo_search_button').click(function() {
        var trigger_name = jQuery(this).attr('id');
        var cpt = trigger_name.substr(17);
        jQuery('.search_result article').hide();
        jQuery('.search_result article.sch-'+cpt).show();
        jQuery('.sedoo_search_button.active').removeClass('active');
        jQuery(this).addClass('active');
    });
});