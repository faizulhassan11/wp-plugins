<?php

/**
 * plugin Name: ShortCode Plugin
 * Description: This is ShortCode Plugin 2.
 * Version: 1.0
 * Author: Faiz
 * Plugin URI:  https://example.com/plugins/the-basics/
 * Author URI: https://author.example.com/
 */


// ----------------shortcode plugin-----------------


// Basic ShortCode


function wp_show_static_message(){
    return "<h3>this is static shortcode message</h3>";        
}
add_shortcode("message","wp_show_static_message");


// parameterized shortcode

// [student name = "ali" email="ali@gmail.com"]


function wp_parameterize_shortcode($atts){
    $atts = shortcode_atts(    
		array(
			'name' => 'ali',
			'email' => 'ali@gmail.com',
		), $atts , 'student');

    return "<p style='color:blue;'>Student Name is {$atts['name']} and email is {$atts['email']} </p>";
}

add_shortcode('student','wp_parameterize_shortcode');

// shortcode with database

function wp_handle_list_posts(){
    global $wpdb;
    $table_prefix = $wpdb->prefix;  // wp_
    $table_name = $table_prefix."posts";

    // Get posts whose post_type = post and post_status = publish

    $posts = $wpdb->get_results("SELECT post_title FROM {$table_name} WHERE post_type = 'post' AND post_status = 'publish'");

    if(count($posts)>0){
        $markup = "<ul style='color:red;' >";
        foreach ($posts as $value) {
            $markup .= "<li>Post Title is " . htmlspecialchars($value->post_title) . "</li>";
        }
        $markup .= "</ul>";
        return $markup;
    }
    return "<p style='color:red;'> NO POST IS CREATED YET </p>";

   

    
}
add_shortcode('list-posts','wp_handle_list_posts');


// shortcode using wp query


function wp_list_posts_using_query($atts) {
    $atts = shortcode_atts(array(
        'number'=>5,
        'type'=>'post',
        'status'=>'public'

    ),$atts,'list-posts-using-query');

    $query = new WP_Query(array(
        'post_type' => $atts['type'],
        'posts_per_page' => $atts['number'],
        'post_status'=>$atts['status']
    ));

    $buffer = ''; // Initialize the buffer

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $buffer .= '<p>'.get_the_title() . '</p>';
        }
        wp_reset_postdata(); // Reset the post data
    } else {
        $buffer = 'No posts found';
    }

    return $buffer;
}

add_shortcode('list-posts-using-query', 'wp_list_posts_using_query');




