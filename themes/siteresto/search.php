<?php get_header(); ?>

<div class="container">
    <div class="search-title">
        <h3>Resultat de recherche pour:
            <?= get_search_query(); ?>
        </h3>
    </div>
    <div class="page-content">
        <?php
        if (have_posts()):
            ?>
            <div class="row">
                <?php
                while (have_posts()):
                    the_post();
                    // Display search results here
                    ?>
                    <div class="col">
                        <div class="card mt-4" style="width: 30rem;">
                            <?php the_post_thumbnail('medium', ['class' => 'card-img-top', 'alt' => 'Card image cap', 'style' => 'height : auto;']) ?>
                            <div class="card-body">
                                <h3 class="card-title">
                                    <?php the_title(); ?>
                                </h3>
                                <p>
                                    <?php the_date(); ?>
                                </p>
                                <p class="card-text">
                                    <?php the_excerpt(); ?>
                                </p>
                                <a href="<?php the_permalink(); ?>" class="card-link">Afficher tous les details</a>
                            </div>
                        </div>
                    </div>
                    <?php
                endwhile;

                ?>
            </div>
            <?php
            // Pagination
            the_posts_pagination(
                array(
                    'prev_text' => __('« Previous'),
                    'next_text' => __('Next »'),
                )
            );
            ?>
            <?php
        else:
            echo '<p>' . esc_html__('No results found.', 'textdomain') . '</p>';
        endif;
        ?>
    </div>
</div>

<?php get_footer(); ?>