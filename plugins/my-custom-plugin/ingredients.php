<?php
/*
Plugin Name: Ingredients
Description: This is my ingredients plugin.
Version: 1.0
Author: Divine Osuu
*/
?>

<?php

// Register Custom Post Type
function my_custom_ingredients_plugin()
{
    $labels = array(
        'name' => _x('Ingrédients', 'Nom général du type de publication', 'resto_plugin'),
        'singular_name' => _x('Ingrédient', 'Nom singulier du type de publication', 'resto_plugin'),
        'menu_name' => _x('Ingrédients', 'Nom du menu du type de publication', 'resto_plugin'),
        'all_items' => __('Tous les Ingrédients', 'resto_plugin'),
        'add_new_item' => __('Ajouter un nouveau ingrédient', 'resto_plugin'),
        'add_new' => __('Ajouter Nouveau', 'resto_plugin'),
        'new_item' => __('Nouveau Ingrédient', 'resto_plugin'),
        'edit_item' => __('Modifier l\'Ingrédient', 'resto_plugin'),
        'update_item' => __('Mettre à jour l\'Ingrédient', 'resto_plugin'),
        'view_item' => __('Voir l\'Ingrédient', 'resto_plugin'),
        'search_items' => __('Rechercher l\'Ingrédient', 'resto_plugin'),
    );

    $args = array(
        'label' => __('Ingrédient', 'resto_plugin'),
        'description' => __('Type de contenu personnalisé pour un ingrédient.', 'resto_plugin'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
    );

    register_post_type('ingredients', $args);
}

// Hook into the 'init' action
add_action('init', 'my_custom_ingredients_plugin', 0);

// Add custom taxonomy categories
function my_custom_taxonomy_create_categories_ingredients()
{
    $labels = array(
        'name' => _x('Catégories', 'taxonomy general name', 'textdomain'),
        'singular_name' => _x('Catégorie', 'taxonomy singular name', 'textdomain'),
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
    );

    register_taxonomy('custom_categories_ingredients', 'ingredients', $args);
}
add_action('init', 'my_custom_taxonomy_create_categories_ingredients', 0);

// Add custom taxonomy for tags
function my_custom_taxonomy_create_tags_ingredients()
{
    $labels = array(
        'name' => _x('Étiquettes personnalisées', 'taxonomy general name', 'textdomain'),
        'singular_name' => _x('Étiquette personnalisée', 'taxonomy singular name', 'textdomain'),
        'search_items' => __('Rechercher des étiquettes personnalisées', 'textdomain'),
        'popular_items' => __('Les plus utilisées', 'textdomain'),
        'all_items' => __('Liste des étiquettes', 'textdomain'),
        'edit_item' => __('Modifier l\'étiquette personnalisée', 'textdomain'),
        'update_item' => __('Mettre à jour l\'étiquette personnalisée', 'textdomain'),
        'add_new_item' => __('Ajouter une nouvelle étiquette personnalisée', 'textdomain'),
        'new_item_name' => __('Nom de la nouvelle étiquette personnalisée', 'textdomain'),
        'separate_items_with_commas' => __('Séparer les étiquettes personnalisées avec des virgules', 'textdomain'),
        'add_or_remove_items' => __('Ajouter ou supprimer des étiquettes personnalisées', 'textdomain'),
        'choose_from_most_used' => __('Choisir parmi les étiquettes personnalisées les plus utilisées', 'textdomain'),
        'not_found' => __('Aucune étiquette personnalisée trouvée', 'textdomain'),
        'menu_name' => __('Étiquettes personnalisées', 'textdomain'),
    );

    $args = array(
        'hierarchical' => false,
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'custom_tags_ingredients'),
    );

    register_taxonomy('custom_tags_ingredients', 'ingredients', $args);
}
add_action('init', 'my_custom_taxonomy_create_tags_ingredients', 0);


// Render custom meta box for adding ingredients
function render_custom_ingredients_meta_box($post)
{
    // Retrieve existing values for fields
    $quantite = get_post_meta($post->ID, 'quantite', true);
    $unite = get_post_meta($post->ID, 'unite', true);
    $selected_tags = get_post_meta($post->ID, 'selected_tags', true);
    $all_tags = get_terms(
        array(
            'taxonomy' => 'custom_tags_ingredients', // Change to your custom taxonomy
            'hide_empty' => true,
        )
    );
    ?>
    <div style="margin-bottom: 10px">
        <label for="quantite">Quantité:</label>
        <input type="number" id="quantite" name="quantite">
    </div>
    <div style="margin-bottom: 10px">
        <label for="unite">Unités:</label>
        <select id="unite" name="unite">
            <option selected id="option-unite">Selectionner l'un des options</option>
            <option value="kg">Kilogramme</option>
            <option value="g">Gramme</option>
            <option value="l">Litre</option>
            <option value="cl">Centilitre</option>
            <option value="ml">Millilitre</option>
            <option value="c à">Cuillère</option>
            <option value="pincéée">Pincée</option>
            <option value="pot">Pot</option>
            <option value="boîte">Boîte</option>
        </select>
    </div>
    <div style="margin-bottom: 10px">
        <div style="margin-bottom: 10px">
            <label for="form-select">Choisissez Vos ingredients</label>
            <select class="form-select" aria-label="Default select example" id="form-select">
                <?php
                // Get all terms (tags) from the custom taxonomy 'custom_tags_ingredients'
                $all_tags = get_terms(
                    array(
                        'taxonomy' => 'custom_tags_ingredients',
                        'hide_empty' => true,
                    )
                );
                // Check if terms were retrieved successfully
                if (!empty($all_tags) && !is_wp_error($all_tags)) {
                    echo '<option selected id="option-ingedients">Selectionner vos ingredients</option>';
                    // Loop through each term
                    foreach ($all_tags as $tag) {
                        // Output or process each tag as needed
                        echo '<option value="' . esc_attr($tag->name) . '">' . esc_html($tag->name) . '</option>';
                    }
                } else {
                    echo 'No tags found.';
                }
                ?>

            </select>
            <div id="error-msg-ingredient" style="display:none"><p style="color:red">Choisissez un ingrédient</p></div>
        </div>
        <div>
            <button id="save-button">Sauvegarder</button>
        </div>
    </div><br>
    <div id="saved-content"></div>
    <?php
}

// Add custom meta box
function add_custom_meta_box()
{
    add_meta_box(
        'ingredients_meta_box', // Meta box ID
        'Ajouter vos ingrédients', // Title
        'render_custom_ingredients_meta_box', // Callback function
        'ingredients', // Post type
        'normal', // Context
        'high' // Priority
    );
}
add_action('add_meta_boxes', 'add_custom_meta_box');

// add ingredients-script.js

function add_ingredients_script()
{
    wp_register_script('ingredients-script', get_template_directory_uri() . '/javascript/ingredients-script.js', [], false, true);
    wp_enqueue_script('ingredients-script');
}
add_action('admin_enqueue_scripts', 'add_ingredients_script');



