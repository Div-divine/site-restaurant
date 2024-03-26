<?php
/*
Plugin Name: Instructions
Description: This is my instructions plugin.
Version: 1.0
Author: Divine Osuu
*/
?>

<?php
function my_custom_instructions_plugin()
{
    $labels = array(
        'name' => _x('Instructions', 'Nom général du type de publication', 'resto_plugin'),
        'singular_name' => _x('Instruction', 'Nom singulier du type de publication', 'resto_plugin'),
        'menu_name' => _x('Instructions', 'Nom du menu du type de publication', 'resto_plugin'),
        'all_items' => __('Tous les Instructions', 'resto_plugin'),
        'add_new_item' => __('Ajouter un nouveau instruction', 'resto_plugin'),
        'add_new' => __('Ajouter Nouveau', 'resto_plugin'),
        'new_item' => __('Nouveau Instruction', 'resto_plugin'),
        'edit_item' => __('Modifier l\'Instruction', 'resto_plugin'),
        'update_item' => __('Mettre à jour l\'Instruction', 'resto_plugin'),
        'view_item' => __('Voir l\'Instruction', 'resto_plugin'),
        'search_items' => __('Rechercher l\'Instruction', 'resto_plugin'),
    );

    $args = array(
        'label' => __('Instruction', 'resto_plugin'),
        'description' => __('Type de contenu personnalisé pour une instruction.', 'resto_plugin'),
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

    register_post_type('instructions', $args);

    // Add meta box for related post title
    add_action('add_meta_boxes', 'add_instructions_meta_box');
}
function my_custom_taxonomy_create_categories_instructions()
{
    $labels = array(
        'name' => _x('Catégories', 'taxonomy general name', 'textdomain'),
        'singular_name' => _x('Catégorie', 'taxonomy singular name', 'textdomain'),
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
    );

    register_taxonomy('custom_categories_instructions', 'instructions', $args);
}
add_action('init', 'my_custom_taxonomy_create_categories_instructions', 0);

function add_instructions_meta_box()
{
    add_meta_box(
        'related_post_title',
        __('Related Post Title', 'resto_plugin'),
        'related_post_title_meta_box_callback',
        'instructions',
        'normal',
        'default'
    );
}

function related_post_title_meta_box_callback($post)
{
    // Add nonce for security
    wp_nonce_field('related_post_title_meta_box', 'related_post_title_nonce');

    // Retrieve the current value of the related post title field
    $related_post_title = get_post_meta($post->ID, 'related_post_title', true);

    // Output the field
    echo '<label for="related_post_title">' . __('Related Post Title:', 'resto_plugin') . '</label>';
    echo '<input type="text" id="related_post_title" name="related_post_title" value="' . esc_attr($related_post_title) . '" size="25" />';
}

// Save meta box data
function save_related_post_title_meta_box_data($post_id)
{
    // Check if nonce is set
    if (!isset($_POST['related_post_title_nonce'])) {
        return;
    }

    // Verify nonce
    if (!wp_verify_nonce($_POST['related_post_title_nonce'], 'related_post_title_meta_box')) {
        return;
    }

    // Check if this is an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Sanitize input and save the meta box field value
    if (isset($_POST['related_post_title'])) {
        update_post_meta($post_id, 'related_post_title', sanitize_text_field($_POST['related_post_title']));
    }
}

add_action('save_post', 'save_related_post_title_meta_box_data');
// Hook into the 'init' action
add_action('init', 'my_custom_instructions_plugin', 0);
