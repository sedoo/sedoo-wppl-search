<?php
/**
 * Plugin Name: Sedoo - Search
 * Description: Change l'affichage des resultats de recherche et propose un filtre par cpt
 * Version: 0.0.12
 * Author: Nicolas Gruwe & Pierre Vert - SEDOO DATA CENTER
 * Author URI:      https://www.sedoo.fr 
 * GitHub Plugin URI: sedoo/sedoo-wppl-search
 * GitHub Branch:     master
 */

if ( ! function_exists('get_field') ) {
        
	add_action( 'admin_init', 'sb_plugin_sedoo_search_deactivate');
	add_action( 'admin_notices', 'sb_plugin_sedoo_search_admin_notice');

	//Désactiver le plugin
	function sb_plugin_sedoo_search_deactivate () {
		deactivate_plugins( plugin_basename( __FILE__ ) );
	}
	
	// Alerter pour expliquer pourquoi il ne s'est pas activé
	function sb_plugin_sedoo_search_admin_notice () {
		
		echo '<div class="error">Le plugin requiert ACF Pro pour fonctionner <br><strong>Activez ACF Pro ci-dessous</strong> ou <a href=https://wordpress.org/plugins/advanced-custom-fields/> Téléchargez ACF Pro &raquo;</a><br></div>';

		if ( isset( $_GET['activate'] ) ) 
			unset( $_GET['activate'] );	
	}
} else {
  include 'inc/sedoo-wppl-search-acf-fields.php';
  include 'sedoo-wppl-search-functions.php';
    function sedoo_labtools_acf_populate_post_type_search($field) {
        
        $content_type_list = [];

        $args = array(
            // 'name' => array('sedoo-platform', 'sedoo-research-team'),
            // 'labels' => array('Research team', 'Platform'),
            'public'   => true,
            '_builtin' => true
        );
        $output = 'object'; // names or objects, note names is the default
        $operator = 'or'; // 'and' or 'or'
        
        $post_types = get_post_types( $args, $output, $operator );    
        foreach ( $post_types as $post_type ) {        
            // array_push($content_type_list, $post_type->label);
            $content_type_list[$post_type->name] = $post_type->labels->singular_name;
        }    
        
        $field['choices'] = $content_type_list;
        return $field;
    }
    add_filter('acf/load_field/name=sedoo_search_post_type', 'sedoo_labtools_acf_populate_post_type_search');
  
  if( function_exists('acf_add_options_page') ) {
	
		acf_add_options_page(array(
			'page_title' 	=> 'Gestion de la recherche',
			'menu_title'	=> 'Gestion de la recherche',
			'menu_slug' 	=> 'sedoo-search-settings',
			'redirect'		=> true
		));
		
		acf_add_options_sub_page(array(
			'page_title' 	=> 'Paramètres',
			'menu_title'	=> 'Paramètres',
			'parent_slug'	=> 'sedoo-search-settings',
		));
	}

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
}