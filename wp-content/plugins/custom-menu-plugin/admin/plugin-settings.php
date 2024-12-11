<?php



echo plugins_url();  //  http://localhost/wp-plugins/wp-content/plugins
echo "<br>";
echo plugins_url('script.js', __FILE__);  //  http://localhost/wp-plugins/wp-content/plugins/custom-menu-plugin/admin/script.js
echo "<br>";
echo plugins_url('', __FILE__);   //  http://localhost/wp-plugins/wp-content/plugins/custom-menu-plugin/admin/
echo "<br>";
echo plugin_dir_url(__FILE__);  // it add slash in last  http://localhost/wp-plugins/wp-content/plugins/custom-menu-plugin/admin
echo "<br>";
echo plugin_dir_path(__DIR__);  // C:\xampp\htdocs\wp-plugins\wp-content\plugins\custom-menu-plugin/
echo "<br>";
echo plugin_dir_path(__FILE__);  // //  http://localhost/wp-plugins/wp-content/plugins/custom-menu-plugin/admin/
echo "<br>";


echo plugin_dir_path;  // C:\xampp\htdocs\wp-plugins\wp-content\plugins\custom-menu-plugin/
echo "<br>";
echo plugin_dir_path . 'uninstall.php'; // C:\xampp\htdocs\wp-plugins\wp-content\plugins\custom-menu-plugin/uninstall.php
echo "<br>";
echo plugin_url;  //  http://localhost/wp-plugins/wp-content/plugins/custom-menu-plugin


echo "<br>";
echo plugin_dir_url;  // http://localhost/wp-plugins/wp-content/plugins/custom-menu-plugin/


do_action('wp_plugin_after_setting_page_html');  // custom hook

// add post meta

$meta_response = add_post_meta(30, 'my-custom-key', 'any custom value', true); // it will return meta id

// $update_meta_response = update_post_meta(30, 'my-custom-key', 'any custom value'); // if the update value is same then it will return false

// $update_meta_response = update_post_meta(30, 'my-custom-key', 'new custom value'); // if it is change it will return 1 (true)

// $update_meta_response = update_post_meta(30, 'my-custom-key', 'new custom value', true); // dont pass true for update_post_meta it will return false if key exists

$update_meta_response = update_post_meta(20, 'my-custom-key-post-20', '20 post custom value');   // if the key is not exist i will createnew meta for post

// delete post meta

$delete_meta_response = delete_post_meta(30, 'my-custom-key');  // here value parameter is optional

var_dump($meta_response);
var_dump($update_meta_response);
var_dump($delete_meta_response);
?>

<div class="wrap">
    <h1>My Plugin Settings</h1>
    <p>This is the settings page for My Plugin.</p>
   
</div>