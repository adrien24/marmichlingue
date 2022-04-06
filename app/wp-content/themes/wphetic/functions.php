<?php
add_filter('use_block_editor_for_post_type', 'prefix_disable_gutenberg', 10, 2);

function prefix_disable_gutenberg($current_status, $post_type)
{
}

function add_styles_and_scripts() {
    wp_enqueue_style( 'main', get_template_directory_uri() .'/src/style/main.css' );
    wp_enqueue_style( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css' );
    wp_enqueue_style( 'bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js' );
}

add_action( 'wp_enqueue_scripts', 'add_styles_and_scripts' );

function add_cpt_recipe() {

    // On rentre les différentes dénominations de notre custom post type qui seront affichées dans l'administration
    $labels = array(
        // Le nom au pluriel
        'name' => _x('Recette', 'Post Type General Name'),
        // Le nom au singulier
        'singular_name' => _x('Recette', 'Post Type Singular Name'),
        // Le libellé affiché dans le menu
        'menu_name' => __('Recettes'),
        // Les différents libellés de l'administration
        'all_items' => __('Toutes les recettes'),
        'view_item' => __('Voir les recettes'),
        'add_new_item' => __('Ajouter une nouvelle recette'),
        'add_new' => __('Ajouter'),
        'edit_item' => __('Editer la recette'),
        'update_item' => __('Modifier la recette'),
        'search_items' => __('Rechercher une recette'),
        'not_found' => __('Non trouvée'),
        'not_found_in_trash' => __('Non trouvée dans la corbeille'),
    );

    // On peut définir ici d'autres options pour notre custom post type
    $args = array(
        'label' => __('Recette'),
        'description' => __('Tous sur Recette'),
        'labels' => $labels,
        // On définit les options disponibles dans l'éditeur de notre custom post type ( un titre, un auteur...)
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'author',
            'thumbnail',
            'comments',
            'revisions',
            'custom-fields',
        ),
        /*
        * Différentes options supplémentaires
        */
        'show_in_rest' => true,
        'hierarchical' => false,
        'public' => true,
        'has_archive' => true,
        "show_in_menu" => true,
        'publicly_queryable' => true,
        'rewrite' => array('slug' => 'recette'),
        'taxonomies' => ['style'],
        'capabilities' => [
            'edit_post' => "edit_recipe",
            'edit_posts' => "edit_recipe",
            'read_post' => "edit_recipe",
            "delete_post" => "edit_recipe",
            "publish_posts" => "manage_recipe",
            "read_private_posts" => "manage_recipe",
        ]

    );

    // On enregistre notre custom post type qu'on nomme ici "serietv" et ses arguments
    register_post_type('recipe', $args);

}

add_action('init', 'add_cpt_recipe', 0);


$custom_post_type = [
    'capabilities' => array(
        'edit_posts' => "edit_recipe",
        'read_post' => "edit_recipe",
        "delete_post" => "edit_recipe",
        "publish_posts" => "manage_recipe",
        "read_private_posts" => "manage_recipe",
    )
];

register_post_type('posts', $custom_post_type);

/**
 * Modifier les rôles de l'admin
 * Création d'un rôle utilisateur
 * quand on active le thème
 */

add_action('after_switch_theme', function () {
    $admin = get_role('administrator');
    $admin->add_cap('manage_recipe');
    $admin->add_cap('edit_recipe');
});

/**
 * Ajout d'un rôle recipe_edit
 * Quand on active le thème
 */

add_action('after_switch_theme', function () {
    add_role('recipe_edit', 'Edit Recipe', [
        'read' => true,
        'edit_recipe' => true,
        'manage_recipe' => false
    ]);

    add_role('moderator', 'moderator', [
        'read' => true,
        'edit_recipe' => true,
        'manage_recipe' => true
    ]);
});

add_action('switch_theme', function () {
    $admin = get_role('administrator');
    $admin->remove_cap('manage_recipe');
    remove_role('edit_recipe');
});

/**
 * formulaire d'upload d'image
 */

add_action('admin_post_upload_demo', function () {

    $recipe = wp_insert_post([
        "post_content" => $_POST["recipe_content"],
        "post_title" => $_POST["recipe_title"],
        "post_type" => "recipe",
        "post_status" => "pending",
        "post_author" => get_current_user_id()
    ]);


    if (wp_verify_nonce($_POST['my_image_upload_nonce'], 'my_image_upload')) {

        $attachment_id = media_handle_upload('my_image_upload', 0);

        if (is_wp_error($attachment_id)) {
            wp_redirect($_POST['_wp_http_referer'] . '?status=error');
        } else {
            set_post_thumbnail($attachment_id, $recipe);
            wp_redirect($_POST['_wp_http_referer'] . '?status=no_nonce');
        }
    } else {
        wp_redirect($_POST['_wp_http_referer'] . '?status=error');
    }
});

function wphetic_add_metabox()
{
    add_meta_box(
        'price',
        'Prix de votre recette',
        'wphetic_metabox_render',
        'recipe',
        'side'
    );
}

add_action('add_meta_boxes', 'wphetic_add_metabox');

function wphetic_metabox_render()
{

    $checked = get_post_meta($_GET['post'], 'wphetic_price', true);
    ?>
    <label for="price">Entrer le prix de votre recette</label>
    <input type="number" value="<?= $checked; ?>" name="price" id="price">

    <?php
}

function wphetic_save_metabox($post_id)
{
    if (isset($_POST['price']) && !empty($_POST['price'])) {
        update_post_meta($post_id, 'wphetic_price', $_POST['price']);
    }
}

add_action('save_post', 'wphetic_save_metabox');


