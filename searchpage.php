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
        $args = array('s' => $s, 'posts_per_page' => -1);
        $search_query = new WP_Query( $args );
        ?>
		<?php if ( $search_query->have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Search Results for: %s', 'labs-by-sedoo' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
			</header><!-- .page-header -->
            <section class="search_result sedoo_search_results_container">
			<?php
            echo '<section class="sedoo_search_results">';
			/* Start the Loop */
            $cpt_array = array();
            $cpt_id = array();
            $cpt_slug_to_name = array();
            while ( $search_query->have_posts() ) :
                $search_query->the_post();
                $post_type = get_post_type_object(get_post_type()); 
                $post_type_name = esc_html($post_type->labels->singular_name);
                $cpt_slug_to_name[$post_type_name] = get_post_type();
                if(!array_key_exists($post_type_name, $cpt_array)) {
                    $cpt_array[$post_type_name] = 1; 
                } else 
                {
                    $cpt_array[$post_type_name]++; 
                }
                if( isset($cpt_id[$post_type_name]) ) {
                    $cpt_id[$post_type_name] .= ','.get_the_ID();
                }
                else {
                    $cpt_id[$post_type_name] = ','.get_the_ID();
                }
            endwhile;
            echo '<div id="sedoo_search_results_list_js"></div>';
            echo '</section>';

            // afficher les boutons

            echo '<section class="sedoo_search_buttons">';
                foreach($cpt_array as $cpt_slug => $nbitem) {
                    echo '<div class="sedoo_search_button" array_id='.substr($cpt_id[$cpt_slug],1).' id="sedoo_search_cpt_'.$cpt_slug_to_name[$cpt_slug].'">'.ucfirst($cpt_slug).' ('.$nbitem.')</div>';
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
