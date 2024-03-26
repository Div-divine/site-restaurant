<?php
/*
Plugin Name: My Custom Plugin
Description: This is a custom plugin for WordPress.
Version: 1.0
Author: Divine Osuu
*/
?>

<?php



// Register Custom Post Type
function my_custom_plugin()
{
    $labels = array(
        'name' => _x('Contenu Personnalisé', 'Nom général du type de publication', 'resto_plugin'),
        'singular_name' => _x('Contenu Personnalisé', 'Nom singulier du type de publication', 'resto_plugin'),
        'menu_name' => _x('Contenu Personnalisé', 'Nom du menu du type de publication', 'resto_plugin'),
        'all_items' => __('Tout le Contenu Personnalisé', 'resto_plugin'),
        'add_new_item' => __('Ajouter un nouveau Contenu Personnalisé', 'resto_plugin'),
        'add_new' => __('Ajouter Nouveau', 'resto_plugin'),
        'new_item' => __('Nouveau Contenu Personnalisé', 'resto_plugin'),
        'edit_item' => __('Modifier le Contenu Personnalisé', 'resto_plugin'),
        'update_item' => __('Mettre à jour le Contenu Personnalisé', 'resto_plugin'),
        'view_item' => __('Voir le Contenu Personnalisé', 'resto_plugin'),
        'search_items' => __('Rechercher le Contenu Personnalisé', 'resto_plugin'),
    );

    $args = array(
        'label' => __('Contenu Personnalisé', 'resto_plugin'),
        'description' => __('Type de contenu personnalisé pour un contenu personnalisé.', 'resto_plugin'),
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

    register_post_type('custom_content', $args);
}

// Hook into the 'init' action
add_action('init', 'my_custom_plugin', 0);

// Add custom fields to the post editor
function my_custom_plugin_custom_fields()
{
    add_meta_box('post_image', 'Post Image', 'my_custom_plugin_image_field', 'custom_content', 'normal', 'default');
}

// Display custom image field in the post editor
function my_custom_plugin_image_field($post)
{
    $post_image = get_post_meta($post->ID, 'post_image', true);
    ?>
    <label for="post_image">Post Image:</label>
    <input type="button" value="Upload Image" id="upload_post_image_button" />
    <input type="hidden" id="post_image" name="post_image" value="<?php echo esc_attr($post_image); ?>" />
    <div id="preview_post_image">
        <?php if ($post_image): ?>
            <img src="<?php echo esc_url(wp_get_attachment_url($post_image)); ?>" alt="Uploaded Image"
                style="max-width: 100%;" />
        <?php endif; ?>
    </div>
    <?php
}

// Save custom image field value
function my_custom_plugin_save_image_field($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if (!current_user_can('edit_post', $post_id))
        return;
    if (isset($_POST['post_image'])) {
        update_post_meta($post_id, 'post_image', sanitize_text_field($_POST['post_image']));
    }
}

// Hook into the 'add_meta_boxes' action to add custom fields
add_action('add_meta_boxes', 'my_custom_plugin_custom_fields');

// Hook into the 'save_post' action to save custom field value
add_action('save_post', 'my_custom_plugin_save_image_field');

// Enqueue media uploader scripts
function my_custom_plugin_enqueue_scripts()
{
    if (get_current_screen()->id == 'custom_content') {
        wp_enqueue_media();
    }
}

add_action('admin_enqueue_scripts', 'my_custom_plugin_enqueue_scripts');


function my_custom_plugin_author_field($post)
{
    // Retrieve the current value of the author field if it exists
    $auteur = get_post_meta($post->ID, 'auteur', true);

    // Display the text field for the author
    echo '<label for="auteur">Auteur :</label>';
    echo '<input type="text" id="auteur" name="auteur" value="' . esc_attr($auteur) . '" size="25" />';

}

function my_custom_plugin_comment_field($post)
{
    // Retrieve the current value of the comment field if it exists
    $auteur_comment = get_post_meta($post->ID, 'auteur_comment', true);

    // Display the textarea for the author's comment
    echo '<label for="auteur_comment">Commentaire de l\'auteur :</label>';
    echo '<textarea id="auteur_comment" name="auteur_comment" rows="4" cols="50">' . esc_textarea($auteur_comment) . '</textarea>';
}

function my_custom_plugin_manage_comments_field($post)
{
    // Retrieve the current values of the manage comments checkboxes
    $autoriser_commentaires = get_post_meta($post->ID, 'autoriser_commentaires', true);
    $bloquer_commentaires = get_post_meta($post->ID, 'bloquer_commentaires', true);

    // Display the checkboxes for managing comments
    echo '<label>Gérer les commentaires :</label>';
    echo '<br /><label for="autoriser_commentaires">Autoriser les commentaires :</label>';
    echo '<input type="checkbox" id="autoriser_commentaires" name="autoriser_commentaires" ' . checked($autoriser_commentaires, 'on', false) . ' />';

    echo '<br /><label for="bloquer_commentaires">Bloquer les commentaires :</label>';
    echo '<input type="checkbox" id="bloquer_commentaires" name="bloquer_commentaires" ' . checked($bloquer_commentaires, 'on', false) . ' />';

    // JavaScript logic to ensure only one checkbox is checked
    echo '<script>
            document.getElementById("autoriser_commentaires").addEventListener("change", function() {
                if (this.checked) {
                    document.getElementById("bloquer_commentaires").checked = false;
                }
            });

            document.getElementById("bloquer_commentaires").addEventListener("change", function() {
                if (this.checked) {
                    document.getElementById("autoriser_commentaires").checked = false;
                }
            });
          </script>';
}


function my_custom_plugin_published_date_field($post)
{
    // Retrieve the current value of the published date field if it exists
    $published_date = get_post_meta($post->ID, 'published_date', true);

    // Display the input field for the published date
    echo '<label for="published_date">Date de publication :</label>';
    echo '<input type="date" id="published_date" name="published_date" value="' . esc_attr($published_date) . '" />';
}

function save_author_field($post_id)
{
    // Check user permissions
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if (!current_user_can('edit_post', $post_id))
        return;

    // Save the value of the author field
    if (isset($_POST['auteur'])) {
        update_post_meta($post_id, 'auteur', sanitize_text_field($_POST['auteur']));
    }

    // Save the value of the author's comment
    if (isset($_POST['auteur_comment'])) {
        update_post_meta($post_id, 'auteur_comment', sanitize_text_field($_POST['auteur_comment']));
    }

    // Manage comments checkboxes logic
    $autoriser_commentaires = isset($_POST['autoriser_commentaires']) ? 'on' : 'off';
    $bloquer_commentaires = isset($_POST['bloquer_commentaires']) ? 'on' : 'off';

    // If one checkbox is checked, uncheck the other
    if ($autoriser_commentaires === 'on') {
        update_post_meta($post_id, 'bloquer_commentaires', 'off');
    } elseif ($bloquer_commentaires === 'on') {
        update_post_meta($post_id, 'autoriser_commentaires', 'off');
    }

    // Save the values of the manage comments checkboxes
    update_post_meta($post_id, 'autoriser_commentaires', $autoriser_commentaires);
    update_post_meta($post_id, 'bloquer_commentaires', $bloquer_commentaires);

    // Save the value of the published date field
    if (isset($_POST['published_date'])) {
        update_post_meta($post_id, 'published_date', sanitize_text_field($_POST['published_date']));
    }
}

add_action('save_post', 'save_author_field');

// Hook into the 'add_meta_boxes' action to add custom fields
add_action('add_meta_boxes', 'my_custom_plugin_add_custom_fields');

function my_custom_plugin_add_custom_fields()
{
    // Add meta boxes for custom fields
    add_meta_box('livres_auteur', 'Auteur', 'my_custom_plugin_author_field', 'custom_content', 'normal', 'default');
    add_meta_box('livres_commentaire', 'Commentaire', 'my_custom_plugin_comment_field', 'custom_content', 'normal', 'default');
    add_meta_box('livres_manage_comments', 'Gérer les commentaires', 'my_custom_plugin_manage_comments_field', 'custom_content', 'normal', 'default');
    add_meta_box('livres_published_date', 'Date de publication', 'my_custom_plugin_published_date_field', 'custom_content', 'normal', 'default');
}


// Add taxonomies

// Add custom taxonomy categories
function my_custom_taxonomy_create_categories()
{
    $labels = array(
        'name' => _x('Catégories', 'taxonomy general name', 'textdomain'),
        'singular_name' => _x('Catégorie', 'taxonomy singular name', 'textdomain'),
        'search_items' => __('Rechercher des termes personnalisés', 'textdomain'),
        'popular_items' => __('Les plus utilisées', 'textdomain'),
        'all_items' => __('Therme personnalisés', 'textdomain'),
        'edit_item' => __('Modifier le terme personnalisé', 'textdomain'),
        'update_item' => __('Mettre à jour le terme personnalisé', 'textdomain'),
        'add_new_item' => __('Ajouter un nouveau terme personnalisé', 'textdomain'),
        'new_item_name' => __('Nom du nouveau terme personnalisé', 'textdomain'),
        'separate_items_with_commas' => __('Séparer les termes personnalisés avec des virgules', 'textdomain'),
        'add_or_remove_items' => __('Ajouter ou supprimer des termes personnalisés', 'textdomain'),
        'choose_from_most_used' => __('Choisir parmi les termes personnalisés les plus utilisés', 'textdomain'),
        'not_found' => __('Aucun terme personnalisé trouvé', 'textdomain'),
        'menu_name' => __('Taxonomie personnalisée', 'textdomain'),

    );

    $args = array(
        'hierarchical' => true, // Set to true if you want a hierarchical taxonomy like categories, false for a flat taxonomy like tags
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'custom_taxonomy'), // Customize the slug
    );

    register_taxonomy('custom_taxonomy', array('custom_content'), $args);
}
add_action('init', 'my_custom_taxonomy_create_categories', 0);

// Add custom taxonomy for tags
function my_custom_taxonomy_create_tags()
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
        'hierarchical' => false, // Tags are non-hierarchical
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'custom_tags'), // Customize the slug
    );

    register_taxonomy('custom_tags', 'custom_content', $args);
}
add_action('init', 'my_custom_taxonomy_create_tags', 0);

