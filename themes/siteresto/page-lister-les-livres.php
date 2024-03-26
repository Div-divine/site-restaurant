<?php
/*
Template Name: Custom Content Page
*/
?>

<?php get_header(); ?>

<div id="primary" class="content-area container mt-5">
    <h2>Liste des livres</h2>
    <main id="main" class="site-main">

        <?php
        // Query your custom content
        $args = array(
            'post_type' => 'custom_content', // Adjust the post type if needed
            'posts_per_page' => -1, // Retrieve all posts
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
                // Display content with link to the post
                echo '<a href="' . esc_url(get_permalink()) . '"><ul>';
                echo '<li class="entry-title">' . get_the_title() . '</li>';
                echo '</ul></a>';

            endwhile;

            // Restore original post data
            wp_reset_postdata();

        else :
            echo 'No custom content found.';
        endif;
        ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
