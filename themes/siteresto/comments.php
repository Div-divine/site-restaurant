<?php
// comments.php

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            $comment_count = get_comments_number();
            if ($comment_count === 1) {
                echo 'One Comment';
            } else {
                echo $comment_count . ' Comments';
            }
            ?>
        </h2>

        <ol class="comment-list">
            <?php wp_list_comments(array('style' => 'ol', 'short_ping' => true)); ?>
        </ol>

    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="no-comments"><?php esc_html_e('Comments are closed.', 'textdomain'); ?></p>
    <?php endif; ?>

    <?php comment_form(); ?>

</div><!-- #comments -->
