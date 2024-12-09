<?php
/*
 * Plugin Name:       Custom Menu Option
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Hello plugins 1.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Faiz
 * Author URI:        https://author.example.com/
 */

//  ----------


function my_plugin_content()
{
    $file_path = plugin_dir_path(__FILE__).'admin/plugin-settings.php';
    if (file_exists($file_path)) {
        include $file_path;
    } else {
        echo 'File not found: ' . $file_path;

    }
   
}

add_action('admin_menu', 'wp_menu_button');
function wp_menu_button()
{
    add_menu_page(
        'My Plugin Title',
        'My Plugin',
        'manage_options',
        'my_plugin',
        'my_plugin_content',
        'dashicons-admin-generic',
        20
    );
}


