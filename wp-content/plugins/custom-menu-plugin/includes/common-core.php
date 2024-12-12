<?php

// Custom Post Type
function wp_plugin_custom_post_type() {
    $post_type_params = array(
        'labels' => array(
            'name' => __('Projects', 'wp_plugin'),
            'singular_name' => __('Project', 'wp_plugin'),
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'project'), // my custom slug
    );
    register_post_type('project', apply_filters('wp_plugin_post_type_arguments', $post_type_params));
}
add_action('init', 'wp_plugin_custom_post_type');

// Custom Taxonomy
function wp_plugin_register_taxonomy_Project() {
    $labels = array(
        'name' => _x('Projects', 'taxonomy general name'),
        'singular_name' => _x('Project', 'taxonomy singular name'),
        'search_items' => __('Search Projects'),
        'all_items' => __('All Projects'),
        'parent_item' => __('Parent Project'),
        'parent_item_colon' => __('Parent Project:'),
        'edit_item' => __('Edit Project'),
        'update_item' => __('Update Project'),
        'add_new_item' => __('Add New Project'),
        'new_item_name' => __('New Project Name'),
        'menu_name' => __('Project'),
    );
    $args = array(
        'hierarchical' => true, // make it hierarchical (like categories)
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'Project'],
    );
    register_taxonomy('Project', ['post'], $args);
}
add_action('init', 'wp_plugin_register_taxonomy_Project');

// Modify Main Query
function wp_plugin_add_custom_post_types($query) {
    if (is_home() && $query->is_main_query()) {
        $query->set('post_type', array('post', 'page', 'project'));
    }
    return $query;
}
add_action('pre_get_posts', 'wp_plugin_add_custom_post_types');

// Custom Hook
function wp_plugin_add_content_using_custom_hook() {
    ?>
    <h2><?php echo esc_html_e('This context is displayed using custom hook');?></h2>
    <?php
}
add_action('wp_plugin_after_setting_page_html', 'wp_plugin_add_content_using_custom_hook');

// Meta Box
function wp_plugin_add_meta_box() {
    add_meta_box(
        'wp_plugin_box_id',                 // Unique ID
        'Project Post Metabox',      // Box title
        'wp_plugin_custom_box_html',  // Content callback, must be of type callable
        'project'                           // Post type
    );
}
add_action('add_meta_boxes', 'wp_plugin_add_meta_box');

function wp_plugin_custom_box_html($post) {
    $current_manager_name = get_post_meta($post->ID, '_wp_plugin_manager_name', true);
    $project_type = get_post_meta($post->ID, '_wp_plugin_project_type', true);
    $project_complete = get_post_meta($post->ID, '_wp_plugin_project_complete', true);
    ?>
    <label for="wp_plugin_manager_name">Project Manager Name</label>
    <input type="text" name="wp_plugin_manager_name" id="wp_plugin_manager_name" value="<?php echo esc_attr($current_manager_name); ?>">
    <br><br>
    <label for="wp_plugin_project_type">Type of Project</label>
    <select name="wp_plugin_project_type" id="wp_plugin_project_type">
        <option value="" <?php selected($project_type, ''); ?>>Select option...</option>
        <option value="website" <?php selected($project_type, 'website'); ?>>Website</option>
        <option value="app" <?php selected($project_type, 'app'); ?>>App</option>
        <option value="both" <?php selected($project_type, 'both'); ?>>Both</option>
    </select>
    <br><br>
    <label for="wp_plugin_project_complete">Project Completed
        <input type="checkbox" name="wp_plugin_project_complete" id="wp_plugin_project_complete" <?php checked($project_complete, 'on'); ?> />
    </label>
    <?php
}

function wp_plugin_save_postdata($post_id) {
    if (array_key_exists('wp_plugin_manager_name', $_POST)) {
		
        update_post_meta(
            $post_id,
            '_wp_plugin_manager_name',
            sanitize_text_field($_POST['wp_plugin_manager_name'])
        );
    }
    if (array_key_exists('wp_plugin_project_type', $_POST)) {
        update_post_meta(
            $post_id,
            '_wp_plugin_project_type',
            sanitize_text_field($_POST['wp_plugin_project_type'])
        );
    }
    if (array_key_exists('wp_plugin_project_complete', $_POST)) {
        update_post_meta(
            $post_id,
            '_wp_plugin_project_complete',
            sanitize_text_field($_POST['wp_plugin_project_complete'])
        );
    }
}
add_action('save_post', 'wp_plugin_save_postdata');

// Shortcode
add_shortcode('wp_plugin_shortcode', 'wp_plugin_custom_shortcode');
function wp_plugin_custom_shortcode($atts = [], $content = null) {
    $atts = array_change_key_case((array) $atts, CASE_LOWER);
    $wp_plugin_atts = shortcode_atts(
        array(
            'title' => 'My Plugin',
        ), $atts
    );
    $output = '<div class="my-shortcode-content">';
    $output .= '<h2>' . esc_html($wp_plugin_atts['title']) . '</h2>';
    if (!is_null($content)) {
        $output .= apply_filters('the_content', $content);
    }
    $output .= '</div>';
    return $output;
}
