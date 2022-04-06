<?php
/*
Template Name: Search Page
*/

global $wp_query;
$wp_query->set('post_type', 'recipe');

?>
<?php get_header(); ?>
<div id="wp_container">
    <main id="wp_main" class="row">
        <div id="wp_content">
            <div class="row">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <div>
                        <a href="<?php the_permalink(); ?>">Voir plus</a>
                        <h1><?php the_title(); ?></h1>
                        <h4>Posté sur <?php the_time('F jS, Y') ?></h4>
                        <p><?php the_content(__('(more...)')); ?></p>
                    </div>
                <?php endwhile; else : ?>
                    <p><?php _e('Désolé, aucun article ne correspond à vos critères.'); ?></p>
                <?php endif; ?>
            </div>
        </div>
        <?php get_sidebar(); ?>
    </main>
</div>
<?php get_footer(); ?>