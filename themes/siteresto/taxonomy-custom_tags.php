<?php
/**
 * Template Name: Tag Archive
 *
 * This template is used to display a list of pages with the same tag.
 */

get_header();

// Get the current tag
$current_tag = single_tag_title('', false);

// Query to get pages with the current tag
$args = array(
    'post_type' => 'custom_content', // custom post
    'tax_query' => array(
        array(
            'taxonomy' => 'custom_tags', // custom taxonomy
            'field'    => 'slug',
            'terms'    => $current_tag,
        ),
    ),
);

$query = new WP_Query($args);

// Display the page titles
if ($query->have_posts()) {
    echo '<h1>Pages with the tag: ' . $current_tag . '</h1>';
    echo '<ul>';
    while ($query->have_posts()) {
        $query->the_post();
        echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
        echo '<a href="' . get_permalink() . '">' . get_the_post_thumbnail() . '</a>';
    }
    echo '</ul>';
} else {
    echo '<p>No pages found with the tag: ' . $current_tag . '</p>';
}

// Restore original post data
wp_reset_postdata();

get_footer();


