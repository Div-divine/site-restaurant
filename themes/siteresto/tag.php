<?php get_header(); ?>
<?php
// Get the current tag object
$current_tag = get_queried_object();

// Check if the tag name contains a slash
if (strpos($current_tag->name, '/') !== false) {
    // If it contains a slash, get the part after the slash
    $current_tag_name = explode('/', $current_tag->name)[1];
} else {
    // If it doesn't contain a slash, use the original tag name
    $current_tag_name = $current_tag->name;
}
// Display the tag name
echo '<p class="text-center mt-5 mb-5 tag-title">Plat(s) de type : ' . $current_tag_name . '</p>';

// Fetch posts associated with the current tag
$tag_posts = new WP_Query(
    array(
        'tag_id' => $current_tag->term_id,
        'post_type' => 'post', // Adjust post type as needed
        'posts_per_page' => -1, // Number of posts to display
    )
);

?>
<div class="tags-content-container">
    <?php
    if ($tag_posts->have_posts()) {
        while ($tag_posts->have_posts()) {
            $tag_posts->the_post();
            ?>
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
            <?php
        }
        wp_reset_postdata();
    } else {
        echo 'No posts found.';
    }

    ?>
</div>

<?php get_footer(); ?>