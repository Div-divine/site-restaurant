<?php get_header(); ?>

<div class="big-carousel-container">
    <div id="postCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php
            $query = new WP_Query(array('post_type' => 'post'));

            while ($query->have_posts()):
                $query->the_post();
                ?>
                <div class="carousel-item <?php echo $query->current_post === 0 ? 'active' : ''; ?>">
                    <div class="d-flex justify-content-center">
                        <?php the_post_thumbnail('large', ['class' => 'second-imgs', 'alt' => get_the_title(), 'style' => 'height: 550px; width: 100%; object-fit: cover; overflow:hidden']); ?>
                    </div>

                    <div class="image-overlay" style="width:100%">
                        <img class="second-imgs">
                        <h2 class="title-overlay">
                            <?php the_title(); ?>
                        </h2>
                    </div>
                </div>

                <?php
            endwhile;
            wp_reset_postdata();
            ?>
            <a class="carousel-control-prev" href="#postCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#postCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>

<div class="container">
    <div class="text-center mt-5 mb-5">
        <h1>Découvrez les recettes de cuisines du Pays Basque</h1>
    </div>
    <div class="page-content">
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
        if ($query->have_posts()): ?>
            <div class="mb-2 text-center">
                <p>Dernières recettes</p>
            </div>
            <div class="posts-container" style="margin-left:auto; margin-right:auto;">
                <div class="row">
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
                        <div class="col-md-6">
                            <?php if ($is_first_or_second): ?>
                                <div class="">
                                    <?php the_post_thumbnail('medium', ['class' => 'card-img-top', 'alt' => 'Card image cap', 'style' => 'height: 350px; width: 100%, object-fit: cover;']) ?>
                                    <img class="card-img-top">
                                </div>
                                <div class="">
                                    <h3>
                                        <?php the_title(); ?>
                                    </h3>
                                    <p class="">
                                        <?php the_excerpt(); ?>
                                    </p>
                                    <a href="<?php the_permalink(); ?>" class="card-link">Lire la suite</a>
                                    <div class="lire-plus-underline"></div>
                                </div>
                            <?php else: ?>
                                <div class="latest-posts-container mb-4">
                                    <a href="<?php the_permalink(); ?>?category_name=<?php echo esc_attr(get_the_category()[0]->slug); ?>" class="thumbnail-link" data-post-id="<?php echo get_the_ID(); ?>" data-category-name="<?php echo get_the_category()[0]->slug; ?>" class="permalink-only">
                                        <?php the_post_thumbnail('large', ['class' => 'first-imgs-top', 'alt' => 'Image for ' . get_the_title(), 'style' => 'width: 500px; height: 250px; object-fit: cover;']) ?>
                                        <div class="image-overlay">
                                            <img class="first-imgs-top">
                                            <h3 class="title-overlay">
                                                <?php the_title(); ?>
                                            </h3>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
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
    </div>
    <div class="d-flex justify-content-center mt-4">
        <div class="see-more-btn text-center">
            <a href="" style="color:white">voir plus de recettes</a>
        </div>
    </div>
</div>

<?php get_footer(); ?>