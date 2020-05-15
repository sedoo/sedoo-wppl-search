<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */

$postType=get_post_type($id);
$post_type = get_post_type( $id );
// go to taxonomies array
$post_type_taxonomies = get_object_taxonomies( $post_type );
?>


<article id="post-<?php echo $id; ?>" class="sch-<?php echo $postType; ?>">
    <header class="entry-header">
        <h2><a href="<?php the_permalink(); ?>"><?php echo get_the_title($id); ?></a></h2>
        <?php
            if ( 'post' === get_post_type() ) :
            ?>
                <p><span class="dashicons dashicons-calendar-alt"></span><?php echo get_the_time('d.m.Y', $id) ?></p>
            <?php endif; ?>

        <?php 
        // if we have any taxonomy
        if ( ! empty( $post_type_taxonomies ) ) {

            echo '<ul class="sedoo_search_taxo">';

            // loop through each of them
            foreach ( $post_type_taxonomies as $taxonomy ) {
                // get terms list for each taxonomy
                $terms = get_the_term_list( $id, $taxonomy, '', '</li><li>', ''  );

                // show only those terms that are assigned to post 
                if ( $terms ) {
                    echo '<li>' . $terms . '</li>';
                }
            }

            echo '</ul>';
        }
        ?>


    </header><!-- .entry-header -->
    <div class="group-content"> 
        <div class="entry-content"> 
            <div id="<?php echo $id; ?>" class="sedoo_search_toggle_excerpt">
                Afficher l'extrait <span class="dashicons dashicons-arrow-down-alt2"></span>
            </div>
            <div class="hidded excerpt_search_displayed" id="excerpt_<?php echo $id; ?>">
                <?php echo get_the_excerpt($id); ?>
            </div>
        </div> 
    </div>
</article><!-- #post-->