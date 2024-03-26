<?php

function my_theme_register_styles() {
    // Register preconnect stylesheet for Google Fonts
    wp_register_style('google-fonts-preconnect', 'https://fonts.googleapis.com', array(), null);
    wp_enqueue_style('google-fonts-preconnect');

    // Register preconnect stylesheet for Google Fonts (crossorigin)
    wp_register_style('google-fonts-preconnect-crossorigin', 'https://fonts.gstatic.com', array(), null);
    wp_enqueue_style('google-fonts-preconnect-crossorigin');

    // Register main Google Fonts stylesheet
    wp_register_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Roboto+Serif:ital,opsz,wght@0,8..144,100..900;1,8..144,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Zilla+Slab:ital,wght@0,400;0,700;1,400;1,500;1,700&display=swap', array(), null);
    wp_enqueue_style('google-fonts');

    // Register bootsrap css
    wp_register_style('bootstrap-css', "https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css");
    wp_enqueue_style('bootstrap-css');

    // Register main stylesheet
    wp_register_style('stylesheet', get_stylesheet_uri());
    wp_enqueue_style('stylesheet');
}
add_action('wp_enqueue_scripts', 'my_theme_register_styles');


function my_theme_register_scripts()
{
    wp_register_script('main-js', get_template_directory_uri() . '/javascript/main.js', array(), false, true);
    // Custom content ingredients js
    wp_register_script('bootstrap-jquery', "https://code.jquery.com/jquery-3.6.0.min.js", [], false, true);
    wp_register_script('popper', "https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js", [], false, true);
    wp_register_script('bootstrap-js', "https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js", ['bootstrap-jquery', 'popper'], false, true);
    wp_enqueue_script('bootstrap-js');
    wp_enqueue_script('main-js');
}
function my_added_theme_supports()
{
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
    register_nav_menus(
        array(
            'top-menu' => 'Top Menu',
            'header-menu' => 'Header Menu',
            'footer-menu' => 'Footer Menu',
        )
    );
    add_theme_support('post-thumbnails');
}

function my_added_styles()
{
    wp_enqueue_style('stylesheet', get_stylesheet_uri());
}


add_action('wp_enqueue_scripts', 'my_theme_register_scripts');
add_action('wp_enqueue_scripts', 'my_added_styles');
add_action('after_setup_theme', 'my_added_theme_supports');


// Handle form submission

function handle_form_submission()
{
    if (isset($_POST['action']) && $_POST['action'] === 'my_form_action') {
        $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
        $text_area = isset($_POST['text_area']) ? sanitize_textarea_field($_POST['text_area']) : '';

        // Display the values
        echo '<div class="container mt-4">';
        echo '<h3>Submitted Values:</h3>';
        echo '<p>Email: ' . esc_html($email) . '</p>';
        echo '<p>Text Area: ' . esc_html($text_area) . '</p>';
        echo '</div>';


        // Send email with attachment
        $to = $email;
        $subject = 'Form Submission with Attachment';
        $message = "Email: $email\nText Area: $text_area";
        $headers = 'Content-Type: text/plain; charset=utf-8';

        wp_mail($to, $subject, $message, $headers);
    }
}

add_action('admin_post_my_form_action', 'handle_form_submission');
add_action('admin_post_nopriv_my_form_action', 'handle_form_submission');

// Modify search to be applicable to only blog posts 

function modify_search_query($query)
{
    if ($query->is_search && !is_admin()) {
        $query->set('post_type', array('post', 'ingredients'));
    }
}
add_action('pre_get_posts', 'modify_search_query');

if (!function_exists('write_log')) {
    function write_log($log) {
            if (WP_DEBUG === TRUE) {
                    if (is_array($log) || is_object($log)) {
                            error_log(print_r($log, true));
                    } else {
                            error_log($log);
                    }
            }
    }
}