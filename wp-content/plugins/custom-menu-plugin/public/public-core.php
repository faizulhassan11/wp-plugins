<?php
/**
 * The code for the public side of the plugin
 */

function wp_plugin_append_edit_button($content) {
    if (!current_user_can('edit_posts')) {
        return $content;
    }

    $post_id = get_the_ID();
    $edit_screen_url = admin_url('post.php?post=' . $post_id . '&action=edit');
    $content .= '<a href="' . esc_url($edit_screen_url) . '">' . esc_html__('Edit', 'wp_plugin') . '</a>';

    return $content;
}

add_filter('the_content', 'wp_plugin_append_edit_button');


// enqueuing public js file

function wp_plugin_script_public_files() {
    // Enqueue public-specific JavaScript file
    wp_enqueue_script('public-script',plugin_dir_url.'/public/js/public.js',array('jquery'),'1.0.0',true);
    
}
add_action('wp_enqueue_scripts','wp_plugin_script_public_files');