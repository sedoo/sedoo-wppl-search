<?php 
function sedoo_search_get_ordre($slug_cpt) {
	$ordre = 1;
	$cptordre=0;
	$acf_repeater_field = get_field('sedoo_search_repeat', 'option');
	if( !empty($acf_repeater_field)):
		// loop through the rows of data
	   while ( have_rows('sedoo_search_repeat', 'option') ) : the_row();
		   // display a sub field value
		   $cpt = get_sub_field('sedoo_search_post_type', 'option');
		   if($cpt == $slug_cpt) {
			   $cptordre = $ordre;
		   }
		   $ordre++;
		endwhile;
		return $cptordre;
	else :
		return $cptordre;
	   // no rows found
   endif;
}