<?php
/**
 * Template Name: Custom Content Single
 */

get_header(); ?>

<div id="primary" class="content-area container mt-5">
    <main id="main" class="site-main">

        <?php
        // Get the current post ID
        $current_post_id = get_queried_object_id();

        // Query your custom content for the current post only
        $args = array(
            'post_type' => 'custom_content',
            'p' => $current_post_id,
        );

        $query = new WP_Query($args);

        if ($query->have_posts()):
            $query->the_post();

            // Get custom fields
            $auteur = get_post_meta(get_the_ID(), 'auteur', true);
            $auteur_comment = get_post_meta(get_the_ID(), 'auteur_comment', true);
            $autoriser_commentaires = get_post_meta(get_the_ID(), 'autoriser_commentaires', true);
            $bloquer_commentaires = get_post_meta(get_the_ID(), 'bloquer_commentaires', true);
            $published_date = get_post_meta(get_the_ID(), 'published_date', true);

            // Format the published date
            $formatted_published_date = $published_date ? date('j F, Y', strtotime($published_date)) : '';
            ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <header class="entry-header">
                    <h2 class="entry-title">
                        <?php the_title(); ?>
                    </h2>
                </header>
                <div class="text-center">
                    <p>Image de couverture</p>
                </div>

                <div class="mt-4 mb-4 container d-flex justify-content-center">
                    <div class="image-mise-en-avant-container">
                        <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>"
                            style="width:100%; height:auto">
                    </div>
                </div>



                <div class="entry-content">
                    <p><strong>Auteur:</strong>
                        <?php echo esc_html($auteur); ?>
                    </p>
                    <p><strong>Date de publication:</strong>
                        <?php echo esc_html($formatted_published_date); ?>
                    </p>
                    <p><strong>Commentaires:</strong>
                        <?php echo ($autoriser_commentaires === 'on' ? 'Autoriser' : ($bloquer_commentaires === 'on' ? 'Bloquer' : 'Non spécifié')); ?>
                    </p>
                    <p><strong>Commentaire de l'auteur:</strong>
                        <?php echo esc_html($auteur_comment); ?>
                    </p>

                    <?php the_content(); ?>
                </div>

                <div>
                    <?php comments_template(); // Display comments if you want      ?>
                </div>

            </article>

            <?php
            // Restore original post data
            wp_reset_postdata();

        else:
            echo 'No custom content found.';
        endif;
        ?>

        <?php
        // Get the post tags
        $tags = get_the_terms(get_the_ID(), 'custom_tags');

        // Check if there are tags
        if ($tags && !is_wp_error($tags)) {
            echo '<div class="custom-tags">';
            echo '<span class="tags-label">' . esc_html__('Tags: ', 'textdomain') . '</span>';

            foreach ($tags as $tag) {
                $tag_link = get_term_link($tag);
                echo '<a href="' . esc_url($tag_link) . '" rel="tag">' . esc_html($tag->name) . '</a>';
            }

            echo '</div>';
        }
        ?>


    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>