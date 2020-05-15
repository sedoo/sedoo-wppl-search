<?php
/**
 * Plugin Name: Sedoo - Search
 * Description: Change l'affichage des resultats de recherche et propose un filtre par cpt
 * Version: 0.0.2
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
  $array_id = $_POST['array_id'];
  $array_id = explode(',', $array_id);
 
  foreach($array_id as $id) {
    $post = get_post($id);
    global $post;
    include 'content.php';
  }


	wp_die();
}