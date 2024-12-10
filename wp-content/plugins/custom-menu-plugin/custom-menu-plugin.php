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

if(!defined('plugin_dir_path')){
    define('plugin_dir_path',plugin_dir_path(__FILE__));
}

if(!defined('plugin_dir_url')){
    define('plugin_dir_url',plugin_dir_url(__FILE__));
}

if(!defined('plugin_url')){
    define('plugin_url',plugins_url('',__FILE__));
}


if(is_admin()){
    $file_path = plugin_dir_path."admin/admin-core.php";   // use contant variable that define for the path value
    if (file_exists($file_path)) {
        include $file_path;
    } else {
        echo 'File not found: ' . $file_path;

    }

}

$file_path = plugin_dir_path."includes/common-core.php";   // use contant variable that define for the path value

// echo $file_path;
    if (file_exists($file_path)) {
        include $file_path;
    } else {
        echo 'File not found: ' . $file_path;

    }


