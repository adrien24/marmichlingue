<?php
/*
* Template Name: Login
* Template Post Type : page
*/
?>
<?php get_header(); ?>

<?php if(have_posts());
 while (have_posts()): the_post();
?>

<div class="post_container">
    <div class="post_info">
        <span class="post_date"><?php the_time('F jS, Y') ?></span>
        <span class="post_price_category"><?php the_category() ?></span>
    </div>
    <h2 class="post_title"><?= the_title() ?></h2>
    <img class="post_img" src="<?php the_post_thumbnail_url()?>" alt="">
    <div class="post_content">
        <h2 class="post_headline">Préparation</h2>
        <p class="post_description"><?php the_content(__('(more...)')); ?></p>
        <div class="post_comments">
            <?php comments_template(); ?>
        </div>
    </div>
</div>
<?php endwhile; ?>

<?php get_footer(); ?>