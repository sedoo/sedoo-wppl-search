<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */

$postType=get_post_type();
?>


<article id="post-<?php the_ID(); ?>" class="sch-<?php echo $postType; ?>">
    <header class="entry-header">
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    </header><!-- .entry-header -->
    <div class="group-content"> 
        <div class="entry-content"> <?php the_excerpt(); ?>
        </div> 
        <footer class="entry-footer"><?php
            if ( 'post' === get_post_type() ) :
                ?>
                <p><?php the_date('d.m.Y') ?></p>
            <?php endif; ?>
            <a href="<?php the_permalink(); ?>"><?php echo __('Lire la suite', 'sedoo-wpth-labs'); ?> →</a>
        </footer>
    </div>
</article><!-- #post-->