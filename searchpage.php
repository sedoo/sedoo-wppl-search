<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package labs_by_Sedoo
 */

get_header();
?>
<script>
    var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    var search_string = "<?php echo $s; ?>";
</script>
	<section id="primary" class="content-area wrapper">
		<main id="main" class="site-main">


        <?php
        $args = array('s' => $s, 'posts_per_page' => -1, 'post_status' => 'publish');
        $search_query = new WP_Query( $args );
        ?>
        <header class="page-header sedoo_search_header">
            <h1 class="page-title">
                <?php
                /* translators: %s: search query. */
                echo __('Search Results for :', 'sedoo-wpth-labs'). "<span>" . get_search_query() . "</span>";
                // printf( esc_html__( 'Search Results for: %s', 'labs-by-sedoo' ), '<span>' . get_search_query() . '</span>' );
                
                ?>
            </h1>
            <form class="sedoo_search_form" action="<?php site_url();?>" method="get">
            <label for="GET-name"><?php echo __('Search keyword :', 'sedoo-wpth-labs');?></label>
            <input class="input" id="s" placeholder="<?php echo $_GET['s']; ?>" type="text" name="s">
            <button type="submit" class="submit"><?php echo __('Submit', 'sedoo-wpth-labs');?></button>
            </form>
        </header><!-- .page-header -->

		<?php if ( $search_query->have_posts() ) : ?>
			
            <section class="search_result sedoo_search_results_container">
            <?php
            echo '<section class="sedoo_search_results">';

                $cpt_array = array();
                $cpt_slug_to_name = array();
                $cpt_slug_to_international_name =  array(); // due to polylang
                while ( $search_query->have_posts() ) :
                    $search_query->the_post();
                    $post_type = get_post_type_object(get_post_type()); 
                    $post_type_name = esc_html($post_type->labels->singular_name);
                    $cpt_slug_to_international_name[$post_type->name][] = $post_type_name;
                    $cpt_slug_to_name[$post_type_name] = get_post_type();
                    if(!array_key_exists($post_type_name, $cpt_array)) {
                        $cpt_array[$post_type_name] = 1; 
                    } else 
                    {
                        $cpt_array[$post_type_name]++; 
                    }
                endwhile;

                echo '<div id="sedoo_search_results_list_js"></div>';
            echo '</section>';

            // afficher les boutons

            echo '<section class="sedoo_search_buttons">';
                foreach($cpt_array as $cpt_slug => $nbitem) {
                    $nom_affiche = $cpt_slug;

                    // je dois determiner si le truc est internationalement un post
                    if(in_array($cpt_slug, $cpt_slug_to_international_name['post']) && get_field('sedoo_search_lib_articles', 'option') != '' && null !== get_field('sedoo_search_lib_articles', 'option')) {
                        $nom_affiche = get_field('sedoo_search_lib_articles', 'option');
                    }

                    // idem pour les page, peu importe le blaze que me renvoie polylang
                    if(in_array($cpt_slug, $cpt_slug_to_international_name['page']) && get_field('sedoo_search_lib_pages', 'option') != '' && null !== get_field('sedoo_search_lib_pages', 'option')) {
                        $nom_affiche = get_field('sedoo_search_lib_pages', 'option');
                    }
                    $ordre = sedoo_search_get_ordre(strtolower($cpt_slug_to_name[$cpt_slug]));
                    echo '<div class="sedoo_search_button flex-'.$ordre.'" id="sedoo_search_cpt_'.$cpt_slug_to_name[$cpt_slug].'">'.ucfirst($nom_affiche).' ('.$nbitem.')</div>';
                    
                }
            echo '</section>';
            
		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
            </section>
		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
