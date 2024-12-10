<?php 

// these functionalities are not admin or public spacific

// ----------filter-----------

// function wp_plugin_filter_title( $title ) {
// 	return 'The ' . $title . ' was filtered';
// }
// add_filter( 'the_title', 'wp_plugin_filter_title' );

function wp_plugin_custom_post_type() {
	register_post_type('project',
		array(
			'labels'      => array(
				'name'          => __( 'Projects', 'wp_plugin' ),
				'singular_name' => __( 'Project', 'wp_plugin' ),
			),
			'public'      => true,
			'has_archive' => true,
			'rewrite'     => array( 'slug' => 'project' ), // my custom slug
		)
	);
}
add_action('init', 'wp_plugin_custom_post_type');


//   changing the main query to display custom post types as well
function wp_plugin_add_custom_post_types($query) {
	if ( is_home() && $query->is_main_query() ) {
		$query->set( 'post_type', array( 'post', 'page', 'project' ) );
	}
	return $query;
}
add_action('pre_get_posts', 'wp_plugin_add_custom_post_types');