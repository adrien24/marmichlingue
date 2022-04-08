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
            <div class="cards">
                <div class="cards-buttons">
                    <button type="button" class="footer__btn"><a href="<?php 'http://'. $_SERVER['SERVER_NAME'] .'/recettes' ?>">Voir toutes les recettes</a></button>
                    <button type="button" class="footer__btn"><a href="<?php 'http://'. $_SERVER['SERVER_NAME'] .'/create-recipe' ?>">Ajouter une recette</a></button>
                </div>
                <div class="cards-gallery">
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <div class="card">
                            <img class="post_img" src="<?php the_post_thumbnail_url()?>" alt="">
                            <div class="card-body">
                                <p class="card-title"><?php the_title(); ?></p>
                                <div class="card-content">
                                    <a href="<?php the_permalink(); ?>">Voir plus</a>
                                    <p>Posté le <?php the_time('F jS, Y') ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; else : ?>
                        <p><?php _e('Désolé, aucun article ne correspond à vos critères.'); ?></p>
                    <?php endif; ?>
                </div>

            </div>
        </div>
        <?php get_sidebar(); ?>
    </main>
</div>
<?php get_footer(); ?>

