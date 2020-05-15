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

		<?php if ( have_posts() ) : ?>

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
            while ( have_posts() ) :
                the_post();
                if(!array_key_exists(get_post_type(), $cpt_array)) {
                    $cpt_array[get_post_type()] = 1; 
                } else 
                {
                    $cpt_array[get_post_type()]++; 
                }
                if( isset($cpt_id[get_post_type()]) ) {
                    $cpt_id[get_post_type()] .= ','.get_the_ID();
                }
                else {
                    $cpt_id[get_post_type()] = ','.get_the_ID();
                }
            endwhile;
            echo '<div id="sedoo_search_results_list_js"></div>';
            echo '</section>';
            echo '<section class="sedoo_search_buttons">';
                foreach($cpt_array as $cpt_slug => $nbitem) {
                    if($nbitem >1) {
                        $texte = ucfirst($cpt_slug).'s';
                    } else {
                        $texte = ucfirst($cpt_slug);
                    }
                    echo '<div class="sedoo_search_button" array_id='.substr($cpt_id[$cpt_slug],1).' id="sedoo_search_cpt_'.$cpt_slug.'">'.$texte.' ('.$nbitem.')</div>';
                }
            echo '</section>';

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
            </section>
		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
