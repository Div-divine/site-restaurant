<?php get_header(); ?>
<?php
/*
Template Name: Combined Content Page
*/
?>

<article id="post-<?php the_ID(); ?>">
    <div class="upper-dishes-container mt-5">
        <div class="image-content-flexbox">
            <div class="upper-image-container">
                <?php the_post_thumbnail('large', ['class' => 'second-imgs', 'alt' => get_the_title(), 'style' => 'max-height: 400px; width: 100%; object-fit: cover; overflow:hidden; border-radius: 16px']); ?>
            </div>
            <div class="upper-contents-container">
                <div class="acceuil-blog-title-container">
                    <p class="acceuil-blog-title-container">Acceuil/Blog/
                        <?php the_title(); ?>
                    </p>
                </div>
                <div class="post-date-container" style="width: 100%">
                    <p>
                        <?= get_the_date(); ?> //
                    </p>
                </div>
                <div class="tags-container" style="width: 100%">
                    <?php
                    // Get tags for the current post
                    $post_tags = wp_get_post_tags(get_the_ID());
                    if ($post_tags) {
                        foreach ($post_tags as $tag) {
                            echo '<a href="' . get_tag_link($tag->term_id) . '" class="tag-links">';
                            echo esc_html($tag->name) . '/ ';
                            echo '</a>';
                        }
                    }
                    ?>
                </div>
                <div class="upper-title-conatiner mt-3" style="width: 100%">
                    <p class="upper-title">
                        <?php the_title(); ?>
                    </p>
                </div>
                <div class="upper-icons-container">
                    <div>
                        <svg id="views-number" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="16px"
                            height="16px">
                            <path
                                d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                        </svg>
                    </div>
                    <div>
                        <svg id="likes-number" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16px"
                            height="16px">
                            <path
                                d="M47.6 300.4L228.3 469.1c7.5 7 17.4 10.9 27.7 10.9s20.2-3.9 27.7-10.9L464.4 300.4c30.4-28.3 47.6-68 47.6-109.5v-5.8c0-69.9-50.5-129.5-119.4-141C347 36.5 300.6 51.4 268 84L256 96 244 84c-32.6-32.6-79-47.5-124.6-39.9C50.5 55.6 0 115.2 0 185.1v5.8c0 41.5 17.2 81.2 47.6 109.5z" />
                        </svg>
                        <span id="click-count">0</span>
                    </div>
                    <div>
                        <svg id="comments-number" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="16px"
                            height="16px">
                            <path
                                d="M208 352c114.9 0 208-78.8 208-176S322.9 0 208 0S0 78.8 0 176c0 38.6 14.7 74.3 39.6 103.4c-3.5 9.4-8.7 17.7-14.2 24.7c-4.8 6.2-9.7 11-13.3 14.3c-1.8 1.6-3.3 2.9-4.3 3.7c-.5 .4-.9 .7-1.1 .8l-.2 .2 0 0 0 0C1 327.2-1.4 334.4 .8 340.9S9.1 352 16 352c21.8 0 43.8-5.6 62.1-12.5c9.2-3.5 17.8-7.4 25.3-11.4C134.1 343.3 169.8 352 208 352zM448 176c0 112.3-99.1 196.9-216.5 207C255.8 457.4 336.4 512 432 512c38.2 0 73.9-8.7 104.7-23.9c7.5 4 16 7.9 25.2 11.4c18.3 6.9 40.3 12.5 62.1 12.5c6.9 0 13.1-4.5 15.2-11.1c2.1-6.6-.2-13.8-5.8-17.9l0 0 0 0-.2-.2c-.2-.2-.6-.4-1.1-.8c-1-.8-2.5-2-4.3-3.7c-3.6-3.3-8.5-8.1-13.3-14.3c-5.5-7-10.7-15.4-14.2-24.7c24.9-29 39.6-64.7 39.6-103.4c0-92.8-84.9-168.9-192.6-175.5c.4 5.1 .6 10.3 .6 15.5z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="description-container">
            <p>
                <?php the_excerpt(); ?>
            </p>
        </div>
    </div>
    <div class="line-between-first"></div>
    <div class="lower-contents-container">
        <div class="lower-img-title">
            <?php the_post_thumbnail('large', ['class' => 'lower-img', 'alt' => get_the_title(), 'style' => 'height:300px; width: 600px; object-fit: cover; overflow:hidden;']); ?>
            <p class="text-center">
                <?php the_title(); ?>
            </p>
        </div>
        <div class="line-between"></div>
        <?php
        $titleEplode = explode(',', get_the_title());
        $firstPart = trim($titleEplode[0]);
        $desiredTitle = $firstPart;
        ?>
        <?php
        // Retrieve blog posts
        $blog_posts = new WP_Query(
            array(
                'post_type' => 'post', // Fetch standard blog posts
                'posts_per_page' => -1, // Retrieve all posts
                'category_name' => get_the_title(),
            )
        );

        // Display Ingredients
        $ingredients_posts = new WP_Query(
            array(
                'post_type' => 'ingredients',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'custom_categories_ingredients', // Change to your custom taxonomy
                        'field' => 'name',
                        'terms' => $desiredTitle,
                    ),
                ),
            )
        );

        if ($ingredients_posts->have_posts()):
            ?>
            <div class="ingredients-container">
                <p class="lower-title">Ingredients</p>
                <?php while ($ingredients_posts->have_posts()):
                    $ingredients_posts->the_post(); ?>
                    <div class="ingredient-item">
                        <?php the_content(); ?>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="line-between"></div>
        <?php endif;
        wp_reset_postdata();
        // Display Instructions
        $instructions_posts = new WP_Query(
            array(
                'post_type' => 'instructions',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'custom_categories_instructions', // Change to your custom taxonomy
                        'field' => 'name',
                        'terms' => $desiredTitle,
                    ),
                ),
            )
        );

        if ($instructions_posts->have_posts()):
            ?>
            <div class="instructions-container">
                <p class="lower-title">Instructions</p>
                <?php while ($instructions_posts->have_posts()):
                    $instructions_posts->the_post(); ?>
                    <div class="instruction-item">
                        <?php the_content(); ?>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif;
        wp_reset_postdata();

        // Display blog posts
        if ($blog_posts->have_posts()):
            ?>
            <div class="blog-posts-container">
                <?php while ($blog_posts->have_posts()):
                    $blog_posts->the_post(); ?>
                    <div class="blog-post-item">
                        <?php the_content(); ?>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif;
        wp_reset_postdata();
        ?>
    </div>
</article>
<div>
    <div class="lower-icons">
        <div class="heart-icon-in-circle">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="12px" height="12px">
                <path fill="white"
                    d="M47.6 300.4L228.3 469.1c7.5 7 17.4 10.9 27.7 10.9s20.2-3.9 27.7-10.9L464.4 300.4c30.4-28.3 47.6-68 47.6-109.5v-5.8c0-69.9-50.5-129.5-119.4-141C347 36.5 300.6 51.4 268 84L256 96 244 84c-32.6-32.6-79-47.5-124.6-39.9C50.5 55.6 0 115.2 0 185.1v5.8c0 41.5 17.2 81.2 47.6 109.5z" />
            </svg>
        </div>
        <div class="facebook-icon-in-circle">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="12px" height="12px">
            <path fill="white"
            d="M512 256C512 114.6 397.4 0 256 0S0 114.6 0 256C0 376 82.7 476.8 194.2 504.5V334.2H141.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H287V510.1C413.8 494.8 512 386.9 512 256h0z"/></svg>
        </div>
        <div class="twitter-icon-in-circle">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="12px" height="12px">
            <path fill="white"
            d="M459.4 151.7c.3 4.5 .3 9.1 .3 13.6 0 138.7-105.6 298.6-298.6 298.6-59.5 0-114.7-17.2-161.1-47.1 8.4 1 16.6 1.3 25.3 1.3 49.1 0 94.2-16.6 130.3-44.8-46.1-1-84.8-31.2-98.1-72.8 6.5 1 13 1.6 19.8 1.6 9.4 0 18.8-1.3 27.6-3.6-48.1-9.7-84.1-52-84.1-103v-1.3c14 7.8 30.2 12.7 47.4 13.3-28.3-18.8-46.8-51-46.8-87.4 0-19.5 5.2-37.4 14.3-53 51.7 63.7 129.3 105.3 216.4 109.8-1.6-7.8-2.6-15.9-2.6-24 0-57.8 46.8-104.9 104.9-104.9 30.2 0 57.5 12.7 76.7 33.1 23.7-4.5 46.5-13.3 66.6-25.3-7.8 24.4-24.4 44.8-46.1 57.8 21.1-2.3 41.6-8.1 60.4-16.2-14.3 20.8-32.2 39.3-52.6 54.3z"/></svg>
        </div>
        <div class="pinterest-icon-in-circle">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512" width="12px" height="12px">
            <path fill="white"
            d="M496 256c0 137-111 248-248 248-25.6 0-50.2-3.9-73.4-11.1 10.1-16.5 25.2-43.5 30.8-65 3-11.6 15.4-59 15.4-59 8.1 15.4 31.7 28.5 56.8 28.5 74.8 0 128.7-68.8 128.7-154.3 0-81.9-66.9-143.2-152.9-143.2-107 0-163.9 71.8-163.9 150.1 0 36.4 19.4 81.7 50.3 96.1 4.7 2.2 7.2 1.2 8.3-3.3 .8-3.4 5-20.3 6.9-28.1 .6-2.5 .3-4.7-1.7-7.1-10.1-12.5-18.3-35.3-18.3-56.6 0-54.7 41.4-107.6 112-107.6 60.9 0 103.6 41.5 103.6 100.9 0 67.1-33.9 113.6-78 113.6-24.3 0-42.6-20.1-36.7-44.8 7-29.5 20.5-61.3 20.5-82.6 0-19-10.2-34.9-31.4-34.9-24.9 0-44.9 25.7-44.9 60.2 0 22 7.4 36.8 7.4 36.8s-24.5 103.8-29 123.2c-5 21.4-3 51.6-.9 71.2C65.4 450.9 0 361.1 0 256 0 119 111 8 248 8s248 111 248 248z"/></svg>
        </div>
    </div>
</div>
<div class="line-between"></div>


<?php get_footer(); ?>