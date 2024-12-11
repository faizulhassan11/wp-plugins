<?php

// these functionalities are not admin or public spacific

// ----------filter-----------

// function wp_plugin_filter_title( $title ) {
// 	return 'The ' . $title . ' was filtered';
// }
// add_filter( 'the_title', 'wp_plugin_filter_title' );

function wp_plugin_custom_post_type()
{
	$post_type_params = array(
		'labels' => array(
			'name' => __('Projects', 'wp_plugin'),
			'singular_name' => __('Project', 'wp_plugin'),
		),
		'public' => true,
		'has_archive' => true,
		'rewrite' => array('slug' => 'project'), // my custom slug
	);
	// register_post_type('project',apply_filters( 'wporg_post_type_params', $post_type_params ));  

	register_post_type('project', apply_filters('wp_plugin_post_type_arguments', $post_type_params));  // apply custom filter hook

}
add_action('init', 'wp_plugin_custom_post_type');


// changing custom post argements using a custom filter hook
function wp_plugin_change_post_type_params($post_type_params)
{
	// $post_type_params['hierarchical'] = true;
	// $post_type_params['labels']['name']="projs";
	// $post_type_params['labels']['singular_name']="proj";

	$post_type_params['labels'] = array(
		'name' => __('Projs', 'wp_plugin'),
		'singular_name' => __('Proj', 'wp_plugin'),
	);

	return $post_type_params;
}
// add_filter( 'wp_plugin_post_type_arguments', 'wp_plugin_change_post_type_params' );

/*
* Plugin Name: Project Taxonomy
* Description: A short example showing how to add a taxonomy called Project.
* Version: 1.0
* Author: developer.wordpress.org
* Author URI: https://codex.wordpress.org/User:Aternus
*/

function wp_plugin_register_taxonomy_Project() {
	$labels = array(
		'name'              => _x( 'Projects', 'taxonomy general name' ),
		'singular_name'     => _x( 'Project', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Projects' ),
		'all_items'         => __( 'All Projects' ),
		'parent_item'       => __( 'Parent Project' ),
		'parent_item_colon' => __( 'Parent Project:' ),
		'edit_item'         => __( 'Edit Project' ),
		'update_item'       => __( 'Update Project' ),
		'add_new_item'      => __( 'Add New Project' ),
		'new_item_name'     => __( 'New Project Name' ),
		'menu_name'         => __( 'Project' ),
	);
	$args   = array(
		'hierarchical'      => true, // make it hierarchical (like categories)
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => [ 'slug' => 'Project' ],
	);
	register_taxonomy( 'Project', [ 'post' ], $args );
}
add_action( 'init', 'wp_plugin_register_taxonomy_Project' );



//   changing the main query to display custom post types as well
function wp_plugin_add_custom_post_types($query)
{
	if (is_home() && $query->is_main_query()) {
		$query->set('post_type', array('post', 'page', 'project'));
	}
	return $query;
}
add_action('pre_get_posts', 'wp_plugin_add_custom_post_types');

// ------------------custom hook-------------
function wp_plugin_add_content_using_custom_hook()
{
	?>
	<h2>This context is displayed using custom hook</h2>
	<?php
}

add_action('wp_plugin_after_setting_page_html', 'wp_plugin_add_content_using_custom_hook');


// ------------add meta box----------------

function wp_plugin_add_meta_box()
{
	add_meta_box(
		'wp_plugin_box_id',                 // Unique ID
		'project post metabox',      // Box title
		'wp_plugin_custom_box_html',  // Content callback, must be of type callable
		'project'                           // Post type
	);
}

function wp_plugin_custom_box_html($post)
{   // post object which we use to save and access post relavent in information

	$current_manager_name = get_post_meta($post->ID, '_wp_plugin_manager_name', true);
	$project_type = get_post_meta($post->ID, '_wp_plugin_project_type', true);
	$project_complete = get_post_meta($post->ID, '_wp_plugin_project_type', true);


	// var_dump($current_manager_name);
	?>
	<label for="wp_plugin_manager_name">Project Manager Name</label>
	<input type="text" name="wp_plugin_manager_name" id="wp_plugin_manager_name"
		value="<?php echo $current_manager_name; ?>">
	<br><br>
	<label for="wp_plugin_project_type">Type of Project</label>
	<select name="wp_plugin_project_type" id="wp_plugin_project_type" value="<?php echo $project_type; ?>">
		<option value="<?php selected($project_type, '') ?>">Select option...</option>
		<option value="website" <?php selected($project_type, 'website') ?>>Website</option>
		<option value="app" <?php selected($project_type, 'app') ?>>App</option>
		<option value="both" <?php selected($project_type, 'both') ?>>Both</option>
	</select>
	<br><br>
	<label for="wp_plugin_project_complete">Project Completed
		<input type="checkbox" name="wp_plugin_project_complete" id="wp_plugin_project_complete" <?php echo !empty($project_complete) ? 'checked' : ''; ?> />
	</label>

	<?php
}

add_action('add_meta_boxes', 'wp_plugin_add_meta_box');


function wp_plugin_save_postdata($post_id)
{
	if (array_key_exists('wp_plugin_manager_name', $_POST)) {
		update_post_meta(
			$post_id,
			'_wp_plugin_manager_name',
			$_POST['wp_plugin_manager_name']
		);
	}
	if (array_key_exists('wp_plugin_project_type', $_POST)) {
		update_post_meta(
			$post_id,
			'_wp_plugin_project_type',
			$_POST['wp_plugin_project_type']
		);
	}
	if (array_key_exists('wp_plugin_project_complete', $_POST)) {
		update_post_meta(
			$post_id,
			'_wp_plugin_project_complete',
			$_POST['wp_plugin_project_complete']
		);
	}
}
add_action('save_post', 'wp_plugin_save_postdata');