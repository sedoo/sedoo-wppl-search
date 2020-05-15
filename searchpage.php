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
            while ( have_posts() ) :
                the_post();
                if(!array_key_exists(get_post_type(), $cpt_array)) {
                    $cpt_array[get_post_type()] = 1; 
                } else 
                {
                    $cpt_array[get_post_type()]++; 
                }
				include 'content.php';
			endwhile;
            echo '</section>';
            echo '<section class="sedoo_search_buttons">';
                foreach($cpt_array as $cpt_slug => $nbitem) {
                    echo '<div class="sedoo_search_button" id="sedoo_search_cpt_'.$cpt_slug.'">'.$cpt_slug.' ('.$nbitem.')</div>';
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
