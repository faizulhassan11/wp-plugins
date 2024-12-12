<?php
/**
 * The code for public side of the plugin
 */

function wp_plugin_append_edit_button($content) {
    if (!current_user_can('edit_posts')) {
        return $content;
    }

    $post_id = get_the_ID();
    $edit_screen_url = admin_url('post.php?post=' . $post_id . '&action=edit');
    $content .= '<a href="' . esc_url($edit_screen_url) . '">Edit</a>';

    return $content;
}

add_filter('the_content', 'wp_plugin_append_edit_button');
