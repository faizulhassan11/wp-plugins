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
        'rewrite' => array('slug' => 'project'), // Custom slug
    );
    register_post_type('project', apply_filters('wp_plugin_post_type_arguments', $post_type_params));
}
add_action('init', 'wp_plugin_custom_post_type');

// Custom Taxonomy
function wp_plugin_register_taxonomy_Project() {
    $labels = array(
        'name' => _x('Projects', 'taxonomy general name'),
        'singular_name' => _x('Project', 'taxonomy singular name'),
        'search_items' => __('Search Projects', 'wp_plugin'),
        'all_items' => __('All Projects', 'wp_plugin'),
        'parent_item' => __('Parent Project', 'wp_plugin'),
        'parent_item_colon' => __('Parent Project:', 'wp_plugin'),
        'edit_item' => __('Edit Project', 'wp_plugin'),
        'update_item' => __('Update Project', 'wp_plugin'),
        'add_new_item' => __('Add New Project', 'wp_plugin'),
        'new_item_name' => __('New Project Name', 'wp_plugin'),
        'menu_name' => __('Project', 'wp_plugin'),
    );
    $args = array(
        'hierarchical' => true, // Make it hierarchical (like categories)
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
    <h2><?php echo esc_html__('This content is displayed using a custom hook', 'wp_plugin'); ?></h2>
    <?php
}
add_action('wp_plugin_after_setting_page_html', 'wp_plugin_add_content_using_custom_hook');

// Meta Box
function wp_plugin_add_meta_box() {
    add_meta_box(
        'wp_plugin_box_id',                 // Unique ID
        __('Project Post Metabox', 'wp_plugin'),      // Box title
        'wp_plugin_custom_box_html',  // Content callback, must be of type callable
        'project'                           // Post type
    );
}
add_action('add_meta_boxes', 'wp_plugin_add_meta_box');

function wp_plugin_custom_box_html($post) {
    $current_manager_name = get_post_meta($post->ID, '_wp_plugin_manager_name', true);
    $project_type = get_post_meta($post->ID, '_wp_plugin_project_type', true);
    $project_complete = get_post_meta($post->ID, '_wp_plugin_project_complete', true);

    $metabox_nonce = wp_create_nonce('wp_plugin_project_metabox');
    ?>
    <label for="wp_plugin_manager_name"><?php esc_html_e('Project Manager Name', 'wp_plugin'); ?></label>
    <input type="text" name="wp_plugin_manager_name" id="wp_plugin_manager_name" value="<?php echo esc_attr($current_manager_name); ?>">
    <br><br>
    <label for="wp_plugin_project_type"><?php esc_html_e('Type of Project', 'wp_plugin'); ?></label>
    <select name="wp_plugin_project_type" id="wp_plugin_project_type">
        <option value="" <?php selected($project_type, ''); ?>><?php esc_html_e('Select option...', 'wp_plugin'); ?></option>
        <option value="website" <?php selected($project_type, 'website'); ?>><?php esc_html_e('Website', 'wp_plugin'); ?></option>
        <option value="app" <?php selected($project_type, 'app'); ?>><?php esc_html_e('App', 'wp_plugin'); ?></option>
        <option value="both" <?php selected($project_type, 'both'); ?>><?php esc_html_e('Both', 'wp_plugin'); ?></option>
    </select>
    <br><br>
    <label for="wp_plugin_project_complete"><?php esc_html_e('Project Completed', 'wp_plugin'); ?>
        <input type="checkbox" name="wp_plugin_project_complete" id="wp_plugin_project_complete" <?php checked($project_complete, 'on'); ?> />
    </label>
    <input type="hidden" name="wp_plugin_project_metabox" value="<?php echo esc_attr($metabox_nonce); ?>">
    <?php
}

function wp_plugin_save_postdata($post_id) {
    if (!array_key_exists('wp_plugin_project_metabox', $_POST) || !wp_verify_nonce($_POST['wp_plugin_project_metabox'], 'wp_plugin_project_metabox')) {
        return;
    }
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
            'title' => __('My Plugin', 'wp_plugin'),
        ), $atts
    );
    $output = '<div class="my-shortcode-content">';
    $output .= '<h2>' . esc_html($wp_plugin_atts['title']) . '</h2>';
    if (!is_null($content)) {
        $output .= apply_filters('the_content', $content);
    }
    $output .= '<br><button id="get_total_projects">Get Total Projects</button> <p id="project_response"></p> <br> <p>The following Projects count will be automatically updated</p> <h2 id="auto-projects-count"></h2>';
    $output .= '</div>';
    return $output;
}


// demo ajax action callback function

add_action( 'wp_ajax_wp_plugin_ajax_example', 'wp_plugin_ajax_handler' );  // action hook for logged in users
add_action( 'wp_ajax_nopriv_wp_plugin_ajax_example', 'wp_plugin_ajax_handler' ); // action hook for non-logged in users

/**
 * Handles my AJAX request.
 */
function wp_plugin_ajax_handler() {
	// Handle the ajax request here

    check_ajax_referer('wp_plugin_ajax_example');

    // Task: Send the total number of books available in our custom post type

    $args = array(
        'post_type'=>'project',
        'posts_per_page' => -1
    );
    $the_query = new WP_Query($args);

    $total_books = $the_query->post_count;

    wp_send_json(esc_html__($total_books));

	wp_die(); // All ajax handlers die when finished
}





function wp_plugin_create_user($username, $email) {
    // Check if the username or email already exists
    $user_id = username_exists($username);
    $user_email = email_exists($email);

    if ($user_id) {
        return array('message' => 'The username already exists', 'result' => false);
    }

    if ($user_email) {
        return array('message' => 'The email already exists', 'result' => false);
    }

    // Generate a random password
    $random_password = wp_generate_password(12, false);

    // Create the user
    $new_user_id = wp_create_user($username, $random_password, $email);

    if (is_wp_error($new_user_id)) {
        return array('message' => 'Error creating user: ' . $new_user_id->get_error_message(), 'result' => false);
    }

    return array('message' => 'The user has been successfully created', 'result' => true);
}

// Hook to 'init' to ensure WordPress is fully loaded
add_action('init', function() {
    $response = wp_plugin_create_user('newuser', 'newuser@gmail.com');
    if ($response['result']) {
        echo $response['message'];
    } else {
        echo $response['message'];
    }
});
