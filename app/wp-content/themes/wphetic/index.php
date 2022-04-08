<?php

$args      = array('post_type' => 'recipe', 'posts_per_page' => 3);
$the_query = new WP_Query($args);
?>
<?php get_header(); ?>
<div id="wp_container">
    <main id="wp_main" class="row">
        <div id="wp_content">
            <div class="cards">
                <p class="cards-title">Les 3 dernières recettes</p>
                <div class="cards-buttons">
                    <button type="button" class="footer__btn"><a href="<?php 'http://'. $_SERVER['SERVER_NAME'] .'/recettes' ?>">Voir toutes les recettes</a></button>
                    <button type="button" class="footer__btn"><a href="<?php 'http://'. $_SERVER['SERVER_NAME'] .'/create-recipe' ?>">Ajouter une recette</a></button>
                </div>
                <div class="cards-gallery">
                    <?php if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post(); ?>
                    <div class="card">
                        <?php the_post_thumbnail(); ?>
                        <div class="card-body">
                            <p class="card-title"><?php the_title(); ?></p>
                            <div class="card-content">
                                <a href="<?php the_permalink(); ?>">Voir plus</a>
                                <p>Posté le <?php wphetic_date_french('l d F Y', get_post_time('U', true), 1) ?> </p>
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
