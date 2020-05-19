<?php
/**
 * Plugin Name: Sedoo - Search
 * Description: Change l'affichage des resultats de recherche et propose un filtre par cpt
 * Version: 0.0.7
 * Author: Nicolas Gruwe & Pierre Vert - SEDOO DATA CENTER
 * Author URI:      https://www.sedoo.fr 
 * GitHub Plugin URI: sedoo/sedoo-wppl-search
 * GitHub Branch:     master
 */

function enqueue_search_script() {
  // le fichier js qui contient les fonctions tirgger au change des select
  $scrpt_search = plugins_url().'/sedoo-wppl-search/js/search.js';
  wp_enqueue_script('sedoo_search', $scrpt_search,  array ( 'jquery' ));                    
}
add_action( 'wp_head', 'enqueue_search_script' );


function enqueue_search_style() {
  wp_register_style( 'sedoo_search_css', plugins_url('css/search.css', __FILE__) );
  wp_enqueue_style( 'sedoo_search_css' );
}
add_action( 'wp_head', 'enqueue_search_style' );

add_filter( 'template_include', 'sedoo_page_template');
function sedoo_page_template( $template ) {
    if(stripos(wp_unslash( $_SERVER['REQUEST_URI']) , '?s=' ) !== false) {
      $new_template = plugin_dir_path( __FILE__ ).'searchpage.php';
      return $new_template;
    }
    else {
      return $template;
    }
}

add_action( 'wp_ajax_search_load_post', 'sedoo_search_ajax' );
add_action( 'wp_ajax_nopriv_search_load_post', 'sedoo_search_ajax' );

function sedoo_search_ajax() {

  $search_string = $_POST['string_search'];
  $cpt = $_POST['cpt'];
  $page = $_POST['page_no'];

  $args = array(
    'post_type' => $cpt,
    's' => $search_string,
    "posts_per_page" => 20,
    'paged' => $page,
    'post_status' => 'publish'
  );
  $searching_post_query = new WP_Query($args);

  if ( $searching_post_query->have_posts() ) {
    echo '<div id="sedoo_Search_page_count" class="hide">'.$searching_post_query->max_num_pages.'</div>';
    while ( $searching_post_query->have_posts() ) {
        $searching_post_query->the_post();
        include 'content.php';
    } // end while		 
    wp_reset_postdata();
  } // endif
  
  
	wp_die();
}