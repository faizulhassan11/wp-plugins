<?php
/*
 * Plugin Name:       WP HELLO PLUGIN
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Hello plugins 1.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Faiz
 * Author URI:        https://author.example.com/
 */

//  ---------------admin notices---------------

 add_action('admin_notices','wp_hello_method');

 function wp_hello_method(){
    echo "<div class='notice notice-success is-dismissible'><p>THIS IS HELLO PLUGIN</p></div>";
 }

// ----------------admin custom widget------------

 add_action('wp_dashboard_setup','wp_hello_dashboard_widget');

 
 function wp_hello_dashboard_widget(){
    // wp_add_dashboard_widget('wp_hello_world_widget','WP - Hello World Widget', 'wp_custom_admin_widget');
    echo "This is custom admin widget";

}

function wp_custom_admin_widget(){
    // echo "This is custom admin widget";
}


