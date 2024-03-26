<?php get_header(); ?>

<div class="container mt-5">
        <?php
        // Requête pour obtenir les articles
        $query = new WP_Query(
            array(
                'post_type' => 'post',
                'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
                'orderby' => 'date', // Order by date
                'order' => 'DESC',  // Order in descending order (newest first)
            )
        );

        // Initialize a counter variable
        $post_counter = 0;
        // Variable to track if "Best Dishes" title has been displayed
        $best_dishes_displayed = false;
        // Boucle sur les articles
        ?>
        <?php
        if ($query->have_posts()): ?>
            <?php while ($query->have_posts()):
                $query->the_post();

                // Increment the counter
                $post_counter++;

                // Check if it's the first or second post
                $is_first_or_second = ($post_counter > 2);

                // Check if "Best Dishes" title has not been displayed
                if (!$best_dishes_displayed && $is_first_or_second) {
                    echo '<div class="col-md-12 text-center"><p>Best Dishes</p></div>';
                    $best_dishes_displayed = true;
                }
                ?>
                <?php if ($is_first_or_second): ?>
                    <div class="tag-contents mt-4">
                        <div class="tag-thumbnail-container">
                            <?php the_post_thumbnail('medium', ['class' => 'card-img-top', 'alt' => 'Card image cap', 'style' => 'height: 350px; width: 100%, object-fit: cover;']) ?>
                        </div>

                        <div class="tag-title-except-container">
                            <h3>
                                <?php the_title(); ?>
                            </h3>
                            <?php the_excerpt(); ?>
                            <a href="<?php the_permalink(); ?>" class="card-link">Lire la suite</a>
                            <div class="lire-plus-underline"></div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="tag-contents mt-4">
                        <div class="tag-thumbnail-container">
                            <?php the_post_thumbnail('medium', ['class' => 'card-img-top', 'alt' => 'Card image cap', 'style' => 'height: 350px; width: 100%, object-fit: cover;']) ?>
                        </div>

                        <div class="tag-title-except-container">
                            <h3>
                                <?php the_title(); ?>
                            </h3>
                            <?php the_excerpt(); ?>
                            <a href="<?php the_permalink(); ?>" class="card-link">Lire la suite</a>
                            <div class="lire-plus-underline"></div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endwhile; ?>
            <?php
            echo paginate_links(
                array(
                    'prev_text' => __('« Previous'),
                    'next_text' => __('Next »'),
                )
            );
            ?>

            <?php    // Réinitialisation de la requête
                wp_reset_postdata();
        else:
            // Affichage d'un message si aucun article n'est trouvé
            echo '<p>Aucun article trouvé</p>';
        endif;
        ?>

    <div class="d-flex justify-content-center mt-4">
        <div class="see-more-btn text-center">
            <a href="" style="color:white">voir plus de recettes</a>
        </div>
    </div>
</div>

<?php get_footer(); ?>